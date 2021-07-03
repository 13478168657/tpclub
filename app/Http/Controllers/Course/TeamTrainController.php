<?php

namespace App\Http\Controllers\Course;

use App\Models\CourseClassGroupJoinBuyed;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

use App\Models\Paylog;
use App\Models\Order;
use App\Models\OrderCourseGroup;   //课程组订单表
use App\Models\FinanceAccount;
use App\Models\FinanceRecord;
use App\Models\Studying;
use App\Models\Coupon;
use App\Models\UserCoupon;
use App\Models\CourseClassPush;
use App\Models\CourseClassGroup;
use App\Models\UserOrderGroupRemark;
use App\Models\CourseClassGroupPeriod;
use App\Models\CourseClassGroupOrderStatistics as GroupOrderStatistics;
use App\Models\DisCourseUser;
use App\Constant\CustomerPushType;
use App\Events\WxCustomerMessagePush;
use Illuminate\Support\Facades\DB;
use App\Models\Users;

require app_path().'/Library/Wechat/WxPay.JsApiPay.php';
class TeamTrainController extends Controller
{
    protected $ret;


    public function __construct()
    {
        $this->ret = [];
    }

    public function getDate($group_id){

        $courseDate = date('Y-m-d H',time()+7200);
        $periods = CourseClassGroupPeriod::where('course_class_group_id',$group_id)->where('is_show',1)->get();
        if(count($periods)){
            $flag = 1;
        }else{
            $periods = CourseClassGroupPeriod::where('course_class_group_id',$group_id)->where('begin_time','>',$courseDate)->take(2)->get();
            $flag = 0;
        }
//        dd($periods);
        return ['flag'=>$flag,'periods'=>$periods];
    }

    //微信jsapi支付接口
    public function pay(Request $request){
        //$user_id= $request->input("user_id");          //用户id
        $c_id   = $request->input("class_id");           // 课程id
        $price  = round($request->input("final_price",499),2);        // 最终价格
        $stage = $request->input('stage','');//购买期数
        $dis_id = $request->input('dis_id','');//分享人id
//        $dis_id = 0;//分享人id
        //$price  = 0.01;        // 最终价格
        $sponsor_id = $request->input('sponsor_id');
        $user_id = $request->user()->id;
        $class_group_join_buyed = CourseClassGroupJoinBuyed::where('user_id',$dis_id)->where('course_class_group_id',$c_id)->where('stage',$stage)->first();
        $disOrderGroup = OrderCourseGroup::where('user_id',$dis_id)->where('course_class_group_id',$c_id)->where('stage',$stage)->where('state',1)->first();
//        logger()->info($dis_id);
        if(!$disOrderGroup){
            return ['code'=>1,'message'=>'发起人未购买'];
        }
        $effect_time = $disOrderGroup->uneffect_time;

        if(strtotime($effect_time) <= time()){
            return ['code'=>1,'message'=>'该团购活动失效'];
        }
        $class_group_total_buyed = CourseClassGroupJoinBuyed::where('sponsor_id',$class_group_join_buyed->sponsor_id)->where('course_class_group_id',$c_id)->where('stage',$stage)->select('id','user_id')->get();
//        if(count($class_group_total_buyed) == 3){
//            return ['code'=>1,'message'=>'团购已满'];
//        }

        $order_group   = new OrderCourseGroup(); //订单模型
        $course_class = DB::table("course_class_group")->where("id",$c_id)->select("id","title","price","team_price","team_people","people_set")->first();

        if(count($class_group_total_buyed) >= $course_class->team_people){
            return ['code'=>1,'message'=>'团购已满'];
        }
        $old_order = $order_group->where("user_id",$user_id)->where("course_class_group_id",$c_id)->where('buy_way',"TEAM")->where('refund_id',0)->first();
        $buy_way = 'TEAM';

        $periodInfo = $this->judgePeriods(['stage'=>$stage,'c_id'=>$c_id,'user_id'=>$user_id,'price'=>$price,'is_weixin'=>1]);

        if($periodInfo['code']){
//            $periodInfo['code'] = 1;
//            logger()->info($periodInfo);
            return $periodInfo;
        }
        $couponInfo = $this->couponCard($user_id,0,$c_id);
        $hasCoupon = $couponInfo['hasCoupon'];
        $payPrice = $price;
        $coupon_id = $couponInfo['coupon_id'];
//        $dis_id = 0;//分享人id
        if($old_order){
            if($old_order->state == 0){
                $oNumber = $old_order->number;
                $old_order->stage = $stage;
                $old_order->dis_id = $dis_id;
                $old_order->price = $payPrice;
                if($hasCoupon){
                    if(!$old_order->coupon_id){

                        $old_order->coupon_id = $coupon_id;
                    }
                }
                $old_order->save(); //更新期数
            }else{
                return ['code'=>1,'message'=>'您已购买请联系客服'];
            }
        }else{
            $oNumber = date("YmdHis").rand(1000,9999);
            $order_group->number  = $oNumber;
            $order_group->user_id = $user_id;
            $order_group->price   = $price;
            $order_group->stage   = $stage;
            $order_group->buy_way   = $buy_way;
            $order_group->course_class_group_id    = $c_id;
            $order_group->course_class_group_title = $course_class->title;
            $order_group->dis_id = $dis_id;
            if($hasCoupon){
                $order_group->coupon_id = $coupon_id;
            }
            $order_group->save();
        }
        //②、统一下单
        $tools = new \JsApiPay();
        $openId = $request->user()->openid;
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($course_class->title);             //课程标题
        $input->SetAttach($oNumber);                          //订单号
        $input->SetOut_trade_no("sdkphp".date("YmdHis"));
        $input->SetTotal_fee($price*100);    //订单金额

        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://m.saipubbs.com/team/train/notify");


        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);

        $config = new \WxPayConfig();
        $order = \WxPayApi::unifiedOrder($config, $input);

        $jsApiParameters = $tools->GetJsApiParameters($order);
        $info =  json_decode($jsApiParameters,true);
        return ['code'=>0,'data'=>$info];
    }

    //微信jsapi支付成功后回调接口
    public function notify(Request $request){

        $xml = file_get_contents('php://input');
        $result = xmlToArray($xml);
        $json_d = json_encode($result);
        $time   = time();
        $pay_log= new Paylog();    //支付日志
        //$order  = new Order();     //订单模型
        $order_group  = new OrderCourseGroup();     //订单模型
        $pay_log->info   = $json_d;
        $pay_log->c_time = $time;
        $payfrom = "WXPAY";
        if($result['return_code']=='SUCCESS'){
            $pay_log->state = 1;

            $pay_log->save();     //记录正常支付日志
        }
//        logger()->info('用户id:');
        //开启事务
        DB::beginTransaction();
        try{
//            logger()->info('用户id111:');
            if($result['return_code']=='SUCCESS'){
                $out_trade_no = $result['out_trade_no'];
                $number  = $result['attach'];
                $item    = $order_group->where("number",$number)->where("state", 0)->first();
                if($item){
                    $groupStatic = GroupOrderStatistics::where('course_class_group_id',$item->course_class_group_id)->where('stage',$item->stage)->first();
                    $dis_order_group = OrderCourseGroup::where('user_id',$item->dis_id)->where('course_class_group_id',$item->course_class_group_id)->where('stage',$item->stage)->where('state',1)->first();
                    $class_group_join_buyed = CourseClassGroupJoinBuyed::where('user_id',$item->dis_id)->where('course_class_group_id',$item->course_class_group_id)->where('stage',$item->stage)->first();
                    $class_group_total_buyed = CourseClassGroupJoinBuyed::where('sponsor_id',$class_group_join_buyed->sponsor_id)->where('course_class_group_id',$item->course_class_group_id)->where('stage',$item->stage)->select('id','user_id')->get();
                    if($groupStatic){
                        $groupStatic->num += 1;
                        $groupStatic->save();
                    }else{
                        $groupStatic = new GroupOrderStatistics();
                        $groupStatic->course_class_group_id = $item->course_class_group_id;
                        $groupStatic->stage = $item->stage;
                        $groupStatic->num = 1;
                        $groupStatic->save();
                    }
                    //整套课程信息
                    $course_class_group = DB::table("course_class_group")
                        ->where("id", $item->course_class_group_id)
                        ->first();

                    $item->state = 1;
                    $item->payfrom = $payfrom;
                    $item->price   = $result['total_fee']/100;
                    $item->uneffect_time = $dis_order_group->uneffect_time;
                    $item->transaction_id = $result['transaction_id'];//订单流水号
                    $item->save();        //将订单状态改为1  支付成功

                    $price = $item->price;  //最终支付价格
                    /*
                     * 优惠券使用
                     */
                    $userCoupon = UserCoupon::where('user_id',$item->user_id)->where('coupon_id',$item->coupon_id)->where('is_use',0)->first();
                    if($userCoupon){
                        $userCoupon->is_use = 1;
                        $userCoupon->save();
                    }
                    $finance_a = new FinanceAccount();
                    $studying  = new Studying();

                    $course_class_ids   = explode(',', $course_class_group->course_class_ids);  //课程id
                    //导师id
                    $author_id   = $course_class_group->user_id;

                    $course_join_buyed = CourseClassGroupJoinBuyed::where('course_class_group_id',$course_class_group->id)->where('stage',$item->stage)->where('user_id',$item->user_id)->first();
                    $pintanFlag = 0;

                    if(count($class_group_total_buyed) == $course_class_group->team_people-1){
                        foreach($class_group_total_buyed as $joinUser){
                            foreach($course_class_ids as $id){
                                $course_class = DB::table("course_class")
                                    ->where("id",$id)
                                    ->select("user_id",'explain_url','push_message',"title","id","price", "state")
                                    ->first();
                                $studying->addOne($joinUser->user_id, $id);
                                //购买成功写入消息通知
                                $user = DB::table("users")->where("id",$joinUser->user_id)->select("name","avatar","openid")->first();
                                add_message($author_id,$joinUser->user_id, $user->name, $user->avatar,$course_class->title, "BUY");
                            }
                        }
                        //支付成功后将记录插入正在学习表
                        $user = DB::table("users")->where("id",$item->user_id)->select("name","avatar","openid","nickname")->first();
                        foreach($course_class_ids as $id){
                            $course_class = DB::table("course_class")
                                ->where("id",$id)
                                ->select("user_id",'explain_url','push_message',"title","id","price", "state")
                                ->first();
                            $studying->addOne($item->user_id, $id);
                            //购买成功写入消息通知
                            add_message($author_id,$item->user_id, $user->name, $user->avatar,$course_class->title, "BUY");
                        }
                        $pintanFlag = 1;
                    }
                    if(!$pintanFlag) {
                        $user = DB::table("users")->where("id", $item->user_id)->select("name", "avatar", "openid", "nickname")->first();
                    }
                    if(!$course_join_buyed){
                        $courseJoinBuyed = new CourseClassGroupJoinBuyed();
                        $courseJoinBuyed->course_class_group_id = $course_class_group->id;
                        $courseJoinBuyed->user_id = $item->user_id;
                        $courseJoinBuyed->sponsor_id = $class_group_join_buyed->sponsor_id;
                        $courseJoinBuyed->stage = $item->stage;
                        $courseJoinBuyed->price = $item->price;
                        $courseJoinBuyed->save();
                    }

                    //操作客户账户资金信息
                    $finance_a->addOne($item->user_id);                               //查看用户资金账户，如果没有创建一条
                    //支付成功后记录流水记录
                    add_finance_record($price,"BUY", $item->user_id, $payfrom, 0,$item->course_class_group_id);

                    //记录导师账户资金信息
                    $author_id   = $course_class_group->user_id;
                    $finance_a->addOne($author_id);
                    //支付成功后记录流水记录
                    add_finance_record($price,"ADD", $author_id, $payfrom, 0,$item->course_class_group_id);
                    DB::table("finance_accounts")->where("user_id", '=', $author_id)->increment("total", $price);
                    //记录赛普币
                    courseSpb($item->user_id, 25, $item->course_class_group_id."_group", $price);

                    //推送消息
                    if(!$pintanFlag){
                        $sponsorUser = User::where('id',$class_group_join_buyed->sponsor_id)->first();
                        $data['openid'] = $user->openid;
                        $data['type'] = 'TEXT';
                        $name = $sponsorUser->name?$sponsorUser->name:$sponsorUser->nickname;
                        $restNum = $course_class_group->team_people - count($class_group_total_buyed)-1;
                        $data['text'] = "恭喜您，成功参加好友@".$name."的[".$course_class_group->title."第".$item->stage."期]拼团，距离拼团成功还剩".$restNum."人~\n您可以选择帮<a href='http://m.saipubbs.com/train/success/".$course_class_group->id.".html'>好友邀请</a>，也可以<a href='m.saipubbs.com'>逛一逛社区的其他内容吧~~</a>";
                        event(new WxCustomerMessagePush($data));
                        logger()->info($data['text']);
                        $data['openid'] = $sponsorUser->openid;
                        $data['type'] = 'TEXT';
                        $friendName = $user->name?$user->name:$user->nickname;
                        $data['text'] = "好友@".$friendName."参加了你的[".$course_class_group->title."第".$item->stage."期]拼团，距离拼团成功还剩".$restNum."人~拼团有效期只有24小时，快点<a href='http://m.saipubbs.com/train/success/".$course_class_group->id.".html'>邀请好友吧~~</a>";
                        logger()->info($data['text']);
                        event(new WxCustomerMessagePush($data));

                    }else{
                        foreach($class_group_total_buyed as $joinUser){
                            $sponsorUser = User::where('id',$joinUser->user_id)->first();
                            $data['openid'] = $sponsorUser->openid;
                            $data['type'] = 'TEXT';
                            if($item->course_class_group_id != 5){
                                $data['text'] = "拼团成功，恭喜您获得[".$course_class_group->title."第".$item->stage."期]~\n快来"."<a href='http://m.saipubbs.com/train/success'>完善报名信息</a>,加入班级群吧~";
                                event(new WxCustomerMessagePush($data));
                            }else{
                                $data['text'] = "恭喜，第".$item->stage."期<a href='http://m.saipubbs.com/user/train.html'>【".$course_class_group->title."】</a>报名成功~扫描下方二维码，加入班级群把~";
                                event(new WxCustomerMessagePush($data));
                                $data['openid'] = $sponsorUser->openid;
                                $data['type'] = 'IMAGES';
                                $data['media_id'] = "OiHeUrHDVYV8JmyX4e8tsOffY17xy9RIxIwFmpMv5VzfmZIIFiZRvZP2lmwoAGw1";
                                event(new WxCustomerMessagePush($data));
                            }

                        }
                        $sponsorUser = User::where('id',$item->user_id)->first();
                        $data['openid'] = $sponsorUser->openid;
                        $data['type'] = 'TEXT';
//                        $name = $sponsorUser->name?$sponsorUser->name:$sponsorUser->nickname;
                        if($item->course_class_group_id != 5) {
                            $data['text'] = "拼团成功，恭喜您获得[" . $course_class_group->title . "第" . $item->stage . "期]~\n快来" . "<a href='http://m.saipubbs.com/train/success'>完善报名信息</a>,加入班级群吧~";
                            event(new WxCustomerMessagePush($data));
                        }else{
                            $data['text'] = "恭喜，第".$item->stage."期"."<a href='http://m.saipubbs.com/user/train.html'>【".$course_class_group->title."】</a>报名成功~扫描下方二维码，加入班级群把~";
                            event(new WxCustomerMessagePush($data));
                            $data['type'] = 'IMAGES';
                            $data['media_id'] = "OiHeUrHDVYV8JmyX4e8tsOffY17xy9RIxIwFmpMv5VzfmZIIFiZRvZP2lmwoAGw1";
                            event(new WxCustomerMessagePush($data));
                        }
                    }
                }
            }else{
                $pay_log->state = 0;
                $pay_log->save();         //记录有问题支付日志
            }
            DB::commit();
        }catch(\Exception $e){
            logger()->info($e->getMessage());
            DB::rollback();
        }

        $xml ='<xml>
          <return_code><![CDATA[SUCCESS]]></return_code>
          <return_msg><![CDATA[OK]]></return_msg>
        </xml>';
        echo $xml;
        return $xml;
    }

    //微信H5支付页面
    public function payH(Request $request){
        $c_id   = $request->input("class_group_id");  // 课程id
        $price  = round($request->input("final_price",499),2);        // 最终价格
        $stage = $request->input('stage','');//期数
        $dis_id = $request->input('dis_id');//分享人id

        //$price  = 0.01;        // 最终价格

        $sponsor_id = $request->input('sponsor_id','');

        $class_group_join_buyed = CourseClassGroupJoinBuyed::where('user_id',$dis_id)->where('course_class_group_id',$c_id)->where('stage',$stage)->first();
        $disOrderGroup = OrderCourseGroup::where('user_id',$dis_id)->where('course_class_group_id',$c_id)->where('stage',$stage)->where('state',1)->first();
        $effect_time = $disOrderGroup->uneffect_time;

        if(strtotime($effect_time) >= time()){
            return ['code'=>1,'message'=>'该团购活动失效'];
        }

        $class_group_total_buyed = CourseClassGroupJoinBuyed::where('sponsor_id',$class_group_join_buyed->sponsor_id)->where('course_class_group_id',$c_id)->where('stage',$stage)->select('id','user_id')->get();
        if(count($class_group_total_buyed) == 3){
            return ['code'=>1,'message'=>'团购已满'];
        }
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }

        $periodInfo = $this->judgePeriods(['stage'=>$stage,'c_id'=>$c_id,'user_id'=>$user_id,'price'=>$price,'is_weixin'=>0]);
        if($periodInfo['code']){
            $periodInfo['code'] = 0;
            return $periodInfo;
        }

        if($user_id && $c_id){
            //$order        = new Order();     //订单模型
            $order_group  = new OrderCourseGroup();     //订单模型
            $course_class = DB::table("course_class_group")->where("id",$c_id)->select("id","title","price")->get();
            $old_order = $order_group->where("user_id",$user_id)->where("course_class_group_id",$c_id)->where('buy_way',"TEAM")->where('refund_id',0)->first();

            $couponInfo = $this->couponCard($user_id,0,$c_id);
            $hasCoupon = $couponInfo['hasCoupon'];
            $payPrice = $price;
            $coupon_id = $couponInfo['coupon_id'];
//            $dis_id = 0;//分享人id
            if($old_order){
                if($old_order->state==0){
                    $oNumber = $old_order->number;
                    $old_order->stage = $stage;
                    $old_order->dis_id = $dis_id;
                    $old_order->price = $payPrice;
                    if($hasCoupon){
                        if(!$old_order->coupon_id){
                            $old_order->coupon_id = $coupon_id;
                        }
                    }
                    $old_order->save(); //更新期数
                }else{
                    echo json_encode(['code'=>0, 'msg'=>'您已购买请联系客服']);
                    return;
                }
            }else{
                $oNumber = date("YmdHis").rand(1000,9999);
                $order_group->number  = $oNumber;
                $order_group->user_id = $user_id;
                $order_group->price   = $price;
                $order_group->stage   = $stage;
                $order_group->course_class_group_id    = $c_id;
                $order_group->course_class_group_title = $course_class[0]->title;
                $order_group->dis_id = $dis_id;
                $order_group->buy_way   = "TEAM";
                if($hasCoupon){
                    $order_group->coupon_id = $coupon_id;
                }
                $order_group->save();
            }
            //$video_id = DB::table("course")->where("course_class_id", $c_id)->select("id")->first();
            $wxConfig = new \WxPayConfig();
            $userip = get_ip();                          //获得用户设备IP 自己网上百度去
            $appid  = $wxConfig->GetAppId();             //微信给的
            $mch_id = $wxConfig->GetMerchantId();        //微信官方的x
            $key    = $wxConfig->GetKey();               //自己设置的微信商家key
            $out_trade_no = $oNumber;                    //平台内部订单号
            $nonce_str    = MD5($out_trade_no);          //随机字符串
            $body         = $course_class[0]->title;     //内容
            $total_fee    = $price*100; //金额
            $spbill_create_ip = $userip;                 //IP
            $notify_url   = "http://m.saipubbs.com/team/train/notifyh"; //回调地址
            //$redirect_url = urlencode("http://m.saipubbs.com/course/middle/{$c_id}/{$video_id->id}");     //支付成功后跳转页面
            $redirect_url = urlencode("http://m.saipubbs.com/train/success/".$course_class[0]->id.".html");     //支付成功后跳转页面
            $trade_type   = 'MWEB';//交易类型 具体看API 里面有详细介绍
            $scene_info   = '{"h5_info":{"type":"Wap","wap_url":"http://m.saipubbs.com","wap_name":"微信H5支付"}}';//场景信息 必要参数

            $signA ="appid=$appid&body=$body&mch_id=$mch_id&nonce_str=$nonce_str&notify_url=$notify_url&out_trade_no=$out_trade_no&scene_info=$scene_info&spbill_create_ip=$spbill_create_ip&total_fee=$total_fee&trade_type=$trade_type";
            $strSignTmp = $signA."&key=$key"; //拼接字符串  注意顺序微信有个测试网址 顺序按照他的来 直接点下面的校正测试 包括下面XML  是否正确
            $sign = strtoupper(MD5($strSignTmp)); // MD5 后转换成大写
            $post_data = "<xml>
                             <appid>$appid</appid>
                             <body>$body</body>
                             <mch_id>$mch_id</mch_id>
                             <nonce_str>$nonce_str</nonce_str>
                             <notify_url>$notify_url</notify_url>
                             <out_trade_no>$out_trade_no</out_trade_no>
                             <scene_info>$scene_info</scene_info>
                             <spbill_create_ip>$spbill_create_ip</spbill_create_ip>
                             <total_fee>$total_fee</total_fee>
                             <trade_type>$trade_type</trade_type>
                             <sign>$sign</sign>
                         </xml>";//拼接成XML 格式
            $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";//微信传参地址
            $dataxml = wx_http_post($url,$post_data); //后台POST微信传参地址  同时取得微信返回的参数    POST 方法我写下面了
            $objectxml = (array)simplexml_load_string($dataxml, 'SimpleXMLElement', LIBXML_NOCDATA); //将微信返回的XML 转换成数组
            $objectxml['mweb_url'] = $objectxml['mweb_url']."&redirect_url=".$redirect_url;
            //return view('course.payh', ['objectxml'=>$objectxml, "is_buy"=>0]);
            echo json_encode(['code'=>1, 'objectxml'=>$objectxml]);
            return;
        }else{
            echo json_encode(['code'=>0, 'msg'=>'抱歉没有数据了']);
            return;
        }

    }

    //微信H5支付成功回调接口
    public function notifyH(){

        $xml = file_get_contents('php://input');
        $result = xmlToArray($xml);
        $json_d = json_encode($result);
        $time   = time();
        $payfrom= "WXPAYH";
        $pay_log= new Paylog();    //支付日志
        $order_group  = new OrderCourseGroup();     //订单模型
        $pay_log->info   = $json_d;
        $pay_log->c_time = $time;
        if($result['return_code']=='SUCCESS'){
            $pay_log->state = 2;

            $pay_log->save();     //记录正常支付日志
        }
        //开启事务
        DB::beginTransaction();
        try{
            if($result['return_code']=='SUCCESS'){
                $number = $result['out_trade_no'];
                $item    = $order_group->where("number",$number)->where("state", 0)->first();
                if($item){
                    $groupStatic = GroupOrderStatistics::where('course_class_group_id',$item->course_class_group_id)->where('stage',$item->stage)->first();

                    $dis_order_group = OrderCourseGroup::where('user_id',$item->dis_id)->where('course_class_group_id',$item->course_class_group_id)->where('stage',$item->stage)->where('state',1)->first();
                    $class_group_join_buyed = CourseClassGroupJoinBuyed::where('user_id',$item->dis_id)->where('course_class_group_id',$item->course_class_group_id)->where('stage',$item->stage)->first();
                    $class_group_total_buyed = CourseClassGroupJoinBuyed::where('sponsor_id',$class_group_join_buyed->sponsor_id)->where('course_class_group_id',$item->course_class_group_id)->where('stage',$item->stage)->select('id','user_id')->get();
                    if($groupStatic){
                        $groupStatic->num += 1;
                        $groupStatic->save();
                    }else{
                        $groupStatic = new GroupOrderStatistics();
                        $groupStatic->course_class_group_id = $item->course_class_group_id;
                        $groupStatic->stage = $item->stage;
                        $groupStatic->num = 1;
                        $groupStatic->save();
                    }
                    $item->state = 1;
                    $item->payfrom = $payfrom;
                    $item->price  = $result['total_fee']/100;
                    $item->uneffect_time = $dis_order_group->uneffect_time;
                    $item->transaction_id = $result['transaction_id'];//订单流水号
                    $item->save();        //将订单状态改为1  支付成功

                    $price = $item->price;  //最终支付价格
                    /*
                     * 优惠券使用
                     */
                    $userCoupon = UserCoupon::where('user_id',$item->user_id)->where('coupon_id',$item->coupon_id)->where('is_use',0)->first();
                    if($userCoupon){
                        $userCoupon->is_use = 1;
                        $userCoupon->save();
                    }
                    $finance_a = new FinanceAccount();
                    $studying  = new Studying();
                    //整套课程信息
                    $course_class_group = DB::table("course_class_group")
                        ->where("id", $item->course_class_group_id)
                        ->first();

                    $course_class_ids   = explode(',', $course_class_group->course_class_ids);  //课程id
                    //导师id
                    $author_id   = $course_class_group->user_id;

                    $course_join_buyed = CourseClassGroupJoinBuyed::where('course_class_group_id',$course_class_group->id)->where('stage',$item->stage)->where('user_id',$item->user_id)->first();
                    $pintanFlag = 0;

                    if(count($class_group_total_buyed) == $course_class_group->team_people-1){
                        foreach($class_group_total_buyed as $joinUser){
                            foreach($course_class_ids as $id){
                                $course_class = DB::table("course_class")
                                    ->where("id",$id)
                                    ->select("user_id",'explain_url','push_message',"title","id","price", "state")
                                    ->first();
                                $studying->addOne($joinUser->user_id, $id);
                                //购买成功写入消息通知
                                $user = DB::table("users")->where("id",$joinUser->user_id)->select("name","avatar","openid")->first();
                                add_message($author_id,$joinUser->user_id, $user->name, $user->avatar,$course_class->title, "BUY");
                            }
                        }
                        //支付成功后将记录插入正在学习表
                        $user = DB::table("users")->where("id",$item->user_id)->select("name","avatar","openid","nickname")->first();
                        foreach($course_class_ids as $id){
                            $course_class = DB::table("course_class")
                                ->where("id",$id)
                                ->select("user_id",'explain_url','push_message',"title","id","price", "state")
                                ->first();
                            $studying->addOne($item->user_id, $id);
                            //购买成功写入消息通知
                            add_message($author_id,$item->user_id, $user->name, $user->avatar,$course_class->title, "BUY");
                        }
                        $pintanFlag = 1;
                    }
                    if(!$pintanFlag) {
                        $user = DB::table("users")->where("id", $item->user_id)->select("name", "avatar", "openid", "nickname")->first();
                    }
                    if(!$course_join_buyed){
                        $courseJoinBuyed = new CourseClassGroupJoinBuyed();
                        $courseJoinBuyed->course_class_group_id = $course_class_group->id;
                        $courseJoinBuyed->user_id = $item->user_id;
                        $courseJoinBuyed->sponsor_id = $class_group_join_buyed->sponsor_id;
                        $courseJoinBuyed->stage = $item->stage;
                        $courseJoinBuyed->price = $item->price;
                        $courseJoinBuyed->save();
                    }

                    //操作客户账户资金信息
                    $finance_a->addOne($item->user_id);                               //查看用户资金账户，如果没有创建一条
                    //支付成功后记录流水记录
                    add_finance_record($price,"BUY", $item->user_id, $payfrom, 0,$item->course_class_group_id);

                    //记录导师账户资金信息
                    $author_id   = $course_class_group->user_id;
                    $finance_a->addOne($author_id);
                    //支付成功后记录流水记录
                    add_finance_record($price,"ADD", $author_id, $payfrom, 0,$item->course_class_group_id);
                    DB::table("finance_accounts")->where("user_id", '=', $author_id)->increment("total", $price);
                    //记录赛普币
                    courseSpb($item->user_id, 25, $item->course_class_group_id."_group", $price);

                    //推送消息
                    if(!$pintanFlag){
                        $sponsorUser = User::where('id',$class_group_join_buyed->sponsor_id)->first();
                        $data['openid'] = $user->openid;
                        $data['type'] = 'TEXT';
                        $name = $sponsorUser->name?$sponsorUser->name:$sponsorUser->nickname;
                        $restNum = $course_class_group->team_people - count($class_group_total_buyed)-1;
                        $data['text'] = "恭喜您，成功参加好友@".$name."的[".$course_class_group->title."第".$item->stage."期]拼团，距离拼团成功还剩".$restNum."人~\n您可以选择帮<a href='http://m.saipubbs.com/train/success/".$course_class_group->id.".html'>好友邀请</a>，也可以<a href='m.saipubbs.com'>逛一逛社区的其他内容吧~~</a>";
                        event(new WxCustomerMessagePush($data));
                        $data['openid'] = $sponsorUser->openid;
                        $data['type'] = 'TEXT';
                        $friendName = $user->name?$user->name:$user->nickname;
                        $data['text'] = "好友@".$friendName."参加了你的[".$course_class_group->title."第".$item->stage."期]拼团，距离拼团成功还剩".$restNum."人~拼团有效期只有24小时，快点<a href='http://m.saipubbs.com/train/success/".$course_class_group->id.".html'>邀请好友吧~~</a>";
                        event(new WxCustomerMessagePush($data));

                    }else{
                        foreach($class_group_total_buyed as $joinUser){
                            $sponsorUser = User::where('id',$joinUser->user_id)->first();
                            $data['openid'] = $sponsorUser->openid;
                            $data['type'] = 'TEXT';
                            if($item->course_class_group_id != 5){
                                $data['text'] = "拼团成功，恭喜您获得[".$course_class_group->title."第".$item->stage."期]~\n快来"."<a href='http://m.saipubbs.com/train/success'>完善报名信息</a>,加入班级群吧~";
                                event(new WxCustomerMessagePush($data));
                            }else {
                                $data['text'] = "恭喜，第" . $item->stage . "期<a href='http://m.saipubbs.com/user/train.html'>【" . $course_class_group->title . "】</a>报名成功~扫描下方二维码，加入班级群把~";
                                event(new WxCustomerMessagePush($data));
                                $data['openid'] = $sponsorUser->openid;
                                $data['type'] = 'IMAGES';
                                $data['media_id'] = "OiHeUrHDVYV8JmyX4e8tsOffY17xy9RIxIwFmpMv5VzfmZIIFiZRvZP2lmwoAGw1";
                                event(new WxCustomerMessagePush($data));
                            }
                        }
                        $sponsorUser = User::where('id',$item->user_id)->first();
                        $data['openid'] = $sponsorUser->openid;
                        $data['type'] = 'TEXT';

                        if($item->course_class_group_id != 5){
                            $data['text'] = "拼团成功，恭喜您获得[".$course_class_group->title."第".$item->stage."期]~\n快来"."<a href='http://m.saipubbs.com/train/success'>完善报名信息</a>,加入班级群吧~";
                            event(new WxCustomerMessagePush($data));
                        }else {
                            $data['text'] = "恭喜，第" . $item->stage . "期<a href='http://m.saipubbs.com/user/train.html'>【" . $course_class_group->title . "】</a>报名成功~扫描下方二维码，加入班级群把~";
                            event(new WxCustomerMessagePush($data));
                            $data['openid'] = $sponsorUser->openid;
                            $data['type'] = 'IMAGES';
                            $data['media_id'] = "OiHeUrHDVYV8JmyX4e8tsOffY17xy9RIxIwFmpMv5VzfmZIIFiZRvZP2lmwoAGw1";
                            event(new WxCustomerMessagePush($data));
                        }
                        event(new WxCustomerMessagePush($data));
                    }
                }
            }else{
                $pay_log->state = 0;
                $pay_log->save();         //记录有问题支付日志
            }
            DB::commit();

        }catch(\Exception $e){
            logger()->info($e->getMessage());
            DB::rollback();
        }

        $xml ='<xml>
          <return_code><![CDATA[SUCCESS]]></return_code>
          <return_msg><![CDATA[OK]]></return_msg>
        </xml>';
        echo $xml;
        return $xml;
    }


    /*
  -     * 测试微信支付退款功能
  -     * 20190410
  -     */
    public function wxRefund(){

        $config = new \WxPayConfig();
        //查询订单,根据订单里边的数据进行退款
        //$order = M('order')->where(array('id'=>$order_id,'is_refund'=>2,'orde                                  r_status'=>1))->find();
        $order = array();
        // 这句file_put_contents是用来查看服务器返回的退款结果 测试完可以删除了
        //file_put_contents(APP_ROOT.'/Api/wxpay/logs/log3.txt',arrayToXml($res                                  :
        $order['transaction_id'] = "4200000280201904105314087858";
        $order['total_price'] = 1;
        $merchid = $config->GetMerchantId();

        if(!$order) return false;

        $input = new \WxPayRefund();
        //$input->SetOut_trade_no($order['order_sn']);             //自己的订单号
        $input->SetTransaction_id($order['transaction_id']);     //微信官方生成的订单流水号，在支付成功中有返回
        $input->SetOut_refund_no(order_number());                //退款单号
        $input->SetTotal_fee($order['total_price']);             //订单标价金额，单位为分
        $input->SetRefund_fee($order['total_price']);            //退款总金额，订单总金额，单位为分，只能为整数
        $input->SetOp_user_id($merchid);

        $result = \WxPayApi::refund($config, $input); //退款操作

        // 这句file_put_contents是用来查看服务器返回的退款结果 测试完可以删除了
        //file_put_contents(APP_ROOT.'/Api/wxpay/logs/log3.txt',arrayToXml($result),FILE_APPEND);
        print_r($result);
    }

    /*
     * 测试微信支付退款功能查询结果
     * 20190410
     */
    public function wxRefundResult(Request $request){

        $config = new \WxPayConfig();
        //查询订单,根据订单里边的数据进行退款
        $id = $request->input("id");
        $order = DB::table("order")->where("id", $id)->first();
        $order->transaction_id = "4200000280201904105314087858";
        $merchid = $config->GetMerchantId();
        if(!$order) return false;

        $input = new \WxPayRefund();
        $input->SetTransaction_id($order->transaction_id);     //微信官方生成的订单流水号，在支付成功中有返回
        $result = \WxPayApi::refundQuery($config, $input);       //查询退款操作结果
        echo "<pre/>";
        print_r($result);
        return;
        //如果退款成功修改订单已回款状态
        if($result['return_code']=="SUCCESS" && $result['result_code']=='SUCCESS'){
            echo "退款成功修改订单已回款状态";
        }
    }
    //20190314 购买成功
    public function success(Request $request){
        $user = $request->user();
        if($user){
            return view('train.success');
        }else{
            return redirect('/login');
        }
    }

    /*
     * 判断名额是否已满
     */
    public function judgePeriods($data){
        $stage = $data['stage'];
        $c_id = $data['c_id'];
        $user_id = $data['user_id'];
        $price = $data['price'];

        $groupStatic = GroupOrderStatistics::where('course_class_group_id',$c_id)->where('stage',$stage)->select('num')->first();
        $coursePeriod = CourseClassGroupPeriod::where('course_class_group_id',$c_id)->where('stage',$stage)->select('originPrice','birdPrice')->first();
        $courseClassGroup = CourseClassGroup::where('id',$c_id)->select('course_class_ids','people_set','team_price')->first();
        $order   = new Order();     //订单模型
        $youhui  = 0;
        $courseIdArr = explode(',',$courseClassGroup->course_class_ids);
        foreach($courseIdArr as $arr){
            $old_order = $order->where("user_id",$user_id)->where("course_class_id",$arr)->where("state",1)->select("price")->first();

            if($old_order){
                $youhui+=$old_order->price;
            }
        }

        if(!$groupStatic){
            $groupStatic = new GroupOrderStatistics();
            $groupStatic->course_class_group_id = $c_id;
            $groupStatic->stage = $stage;
            $groupStatic->num = 0;
            $groupStatic->save();
        }
        if($groupStatic->num >= $courseClassGroup->people_set){

            if(($coursePeriod->birdPrice - $youhui) > $price){
                return ['code'=>0];
//                return ['code'=>1,'msg'=>'支付失败，优惠名额已满'];
            }
        }else{
            return ['code'=>0];
        }
    }

    /*
     * 是否存在优惠券
     */
    private function couponCard($user_id,$course_id=0 ,$group_id=0){
        $coupon = Coupon::where('course_class_group_id',$group_id)->first();//优惠券
        $couponPrice = 0;
        $hasCoupon = 0;
        $coupon_id = 0;
        if($coupon){
            if($user_id){
                $userCoupon = UserCoupon::where('user_id',$user_id)->where('coupon_id',$coupon->id)->where('is_use',0)->first();
                if($userCoupon){
                    $hasCoupon = 1;
                    $couponPrice = $coupon->price;
                    $coupon_id = $coupon->id;
                }
            }
        }
        return ['hasCoupon'=>$hasCoupon,'couponPrice'=>$couponPrice,'coupon_id'=>$coupon_id];
    }

    /*
     * 参团页面
     */
    public function sponsorBuy(Request $request, $qid){

        $user = $request->user();
        if(!$user){
            return redirect('/');
        }else{

            $user_id = $user->id;
        }

        $groupCourse = CourseClassGroup::where('id',$qid)->first();
        $orderCourse = OrderCourseGroup::where('course_class_group_id',$qid)->where('buy_way','TEAM')->first();
        $classJoinBuyed = CourseClassGroupJoinBuyed::where('user_id',$user_id)->first();
        if(!$classJoinBuyed){
            return redirect('/train/study.html');
        }
        $classJoins = CourseClassGroupJoinBuyed::where('sponsor_id',$classJoinBuyed->sponsor_id)->get();
        $fission_id = $classJoinBuyed->sponsor_id;
        $this->ret['fission_id'] = $fission_id;
        $this->ret['courseClassGroup'] = $groupCourse;
        $this->ret['orderCourse'] = $orderCourse;
        $this->ret['classJoins'] = $classJoins;
        $is_local = env("IS_LOCAL");
        $this->ret['user_id'] = $user_id;
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();  //微信分享
        }

        return view('train.sponsor',$this->ret);
    }

    /*
     *
     */
    public function joinBuy(Request $request ,$uid,$gid){

        $courseGroup = CourseClassGroup::where('id',$gid)->first();

        $sponsorUser = User::where('id',$uid)->select('id')->first();

        $joinBuyed = CourseClassGroupJoinBuyed::where('course_class_group_id',$gid)->where('user_id',$uid)->first();
        if(!$joinBuyed){
            return redirect('/train/study.html');
        }
        $orderCourse = OrderCourseGroup::where('course_class_group_id',$gid)->where('buy_way','TEAM')->first();
        if(!$joinBuyed){
            return redirect('/train/study.html');
        }
        $sponsorOrders = CourseClassGroupJoinBuyed::where('sponsor_id',$uid)->get();
        $data['courseClassGroup'] = $courseGroup;
        $data['sponsorUser'] = $sponsorUser;
        $data['sponsorOrders'] = $sponsorOrders;
        $data['orderCourse'] = $orderCourse;
        /*
         * 是否是微信
         */
        if(is_weixin()){
            $is_weixin = 1;
        }else{
            $is_weixin = 0;
        }

        if($request->user()){
            $user_id = $request->user()->id;
            if($gid == 5){
                $mobile  = $request->user()->mobile ? $request->user()->mobile : '111';  //用户手机号
            }else{
                $mobile  = $request->user()->mobile ? $request->user()->mobile : 0;  //用户手机号
            }

        }else{
            $user_id = 0;
            $mobile  = 0;  //用户手机号
        }
        $fission_id = $request->input("fission_id", 0);    //裂变者id

        $courseClassGroup = CourseClassGroup::where('id',$gid)->first();
        $order   = new Order();     //订单模型
        $youhui  = 0;
        $courseIdArr = explode(',',$courseClassGroup->course_class_ids);
        foreach($courseIdArr as $arr){
            $old_order = $order->where("user_id",$user_id)->where("course_class_id",$arr)->where("state",1)->select("price")->first();

            if($old_order){
                $youhui+=$old_order->price;
            }
        }
        $title = $courseClassGroup->title;
//        $description = $this->getDsec($courseClassGroup->description);
        $teamDesc = $this->getDsec($courseClassGroup->team_course_desc);
        //echo $youhui.'--';
//        $courseDate = ['一', '二', '三', '四', '五', '六', '七', '八', '九', '十', '十一', '十二'];
//        $courseData = json_decode($this->getDate($courseArr,$starTime,$courseDate),true);
//        $courseData = $this->getDate($gid);
        $nowTime = strtotime(date('Y-m-d'));
        if($youhui>0){
            $youhuitext = "(减免已购课程费用)";
        }else{
            $youhuitext = "";
        }
        /*
         * 优惠券
         */
        $couponInfo = $this->couponCard($user_id,0,$gid);

        $is_buy = DB::table("order_course_class_group")->where("user_id",$user_id)
            ->where("course_class_group_id", $gid)
            ->where("state",1)
            ->select("id")->first();
        if(!$is_buy){
            if($user_id){
                $disCourseUser = DisCourseUser::where('user_id',$user_id)->select('id')->first();
                if($disCourseUser){
                    $is_buy = 1;
                }else{
                    $is_buy = 0;
                }
            }else{
                $is_buy = 0;
            }
        }else{
            $is_buy = 1;
        }

        $data['courseClassGroup'] = $courseClassGroup;
        $data['is_buy']     = $is_buy;
        $data['youhuitext'] = $youhuitext;
        $data['youhui']     = $youhui;
        $data['user_id']    = $user_id;        //用户id
        $data['mobile']     = $mobile;         //用户手机号
        $data['is_weixin']  = $is_weixin;      // 是否是微信浏览器
        $data['sponsor_id'] = $joinBuyed->sponsor_id;//发起人
//        $data['courseData'] = $courseData;
        $data['nowTime']    = $nowTime;
        $data['fission_id'] = $fission_id;     //裂变者id
        $data['groupTitle'] = $title;     //组合课程标题
//        $data['groupDesc'] = $description;     //组合课程描述
        $data['teamDesc'] = $teamDesc;     //组合课程拼团描述
        $data['discount_num'] = 30;     //优惠名额
        $data['hasCoupon'] = $couponInfo['hasCoupon'];
        $data['couponPrice'] = $couponInfo['couponPrice'];
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();  //微信分享
        }
        if($user_id == 0){
            $data['spb'] = 0;
        }else{
            $data['spb'] = getSpb($user_id);
        }
        return view('train.joinBuy',$data);
    }
}
