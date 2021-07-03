<?php

namespace App\Http\Controllers\Course;

use App\Models\CourseClassGroupJoinBuyed;
use App\Models\DisOrder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Courseclass;
use App\Models\DisCourseClass;
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
use App\Models\TeamCourseBuyed;
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
class TrainController extends Controller
{
    protected $ret;


    public function __construct()
    {
        $this->ret = [];
    }

    public function index1(Request $request){
        $id = $request->input('id',1);
        if(is_null($id)){
            return;
        }
        if(is_weixin()){
            $is_weixin = 1;
        }else{
            $is_weixin = 0;
        }

//        if($id == 1){
//            return redirect('/');
//        }
        if($request->user()){
            $user_id = $request->user()->id;
            if($id == 5){
                $mobile  = $request->user()->mobile ? $request->user()->mobile : '111';  //用户手机号
            }else{
                $mobile  = $request->user()->mobile ? $request->user()->mobile : 0;  //用户手机号
            }
        }else{
            $user_id = 0;
            $mobile  = 0;  //用户手机号
        }
        $fission_id = $request->input("fission_id", 0);    //裂变者id

        $courseClassGroup = CourseClassGroup::where('id',$id)->first();
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
        $description = $this->getDsec($courseClassGroup->description);
        $teamDesc = $this->getDsec($courseClassGroup->team_course_desc);

        $courseData = $this->getDate($id);
        $nowTime = strtotime(date('Y-m-d'));
        if($youhui>0){
            $youhuitext = "(减免已购课程费用)";
        }else{
            $youhuitext = "";
        }
        /*
         * 优惠券
         */
        $couponInfo = $this->couponCard($user_id,0,$id);

        $buyGroup = DB::table("order_course_class_group")->where("user_id",$user_id)
            ->where("course_class_group_id", $id)
            ->where("state",1)
            ->select("id","stage","uneffect_time",'buy_way')->first();
        $buyStage = '';
        $isTeam = 0;
        $isTeamSuccess = 0;//是否拼团成功
        if(!$buyGroup){
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
            if($buyGroup->buy_way == 'TEAM'){

                $courseJoinBuyed = CourseClassGroupJoinBuyed::where('user_id',$user_id)->where('course_class_group_id',$id)->select('sponsor_id')->first();
                $teamCount = CourseClassGroupJoinBuyed::where('sponsor_id',$courseJoinBuyed->sponsor_id)->where('course_class_group_id',$id)->select('id')->count();
                logger()->info('总数：'.$teamCount."---sponsor_id".$courseJoinBuyed->sponsor_id);
                if($teamCount == 3){
                    $isTeamSuccess = 1;
                }
                $isTeam= 1;
            }
            $buyStage = $buyGroup->stage;
        }
//        dd($isTeam);
        $this->ret['courseClassGroup'] = $courseClassGroup;
        $this->ret['is_buy']     = $is_buy;
        $this->ret['isTeamSuccess'] = $isTeamSuccess;
        $this->ret['buyStage']   = $buyStage;
        $this->ret['isTeam']   = $isTeam;
        $this->ret['youhuitext'] = $youhuitext;
        $this->ret['youhui']     = $youhui;
        $this->ret['user_id']    = $user_id;        //用户id
        $this->ret['mobile']     = $mobile;         //用户手机号
        $this->ret['is_weixin']  = $is_weixin;      // 是否是微信浏览器
        $this->ret['courseData'] = $courseData;
        $this->ret['nowTime']    = $nowTime;
        $this->ret['fission_id'] = $fission_id;     //裂变者id
        $this->ret['groupTitle'] = $title;     //组合课程标题
        $this->ret['groupDesc'] = $description;     //组合课程描述
        $this->ret['teamDesc'] = $teamDesc;     //组合课程拼团描述
        $this->ret['discount_num'] = $courseClassGroup->people_set;     //优惠名额
        $this->ret['hasCoupon'] = $couponInfo['hasCoupon'];
        $this->ret['couponPrice'] = $couponInfo['couponPrice'];
        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();  //微信分享
        }
        if($user_id == 0){
            $this->ret['spb'] = 0;
        }else{
            $this->ret['spb'] = getSpb($user_id);
        }
        
        return view('train.index1', $this->ret);
    }

    public function getDate($group_id){

        $courseDate = date('Y-m-d H',time()+7200);
        $periods = CourseClassGroupPeriod::where('course_class_group_id',$group_id)->where('is_show',1)->get();
        if(count($periods)){
            $flag = 1;
        }else{
            $periods = CourseClassGroupPeriod::where('course_class_group_id',$group_id)->where('is_hide',0)->where('begin_time','>',$courseDate)->take(2)->get();
            $flag = 0;
        }
//        dd($periods);
        return ['flag'=>$flag,'periods'=>$periods];
    }

    /*
     * 获取描述
     */
    public function getDsec($desc){
        $result = explode("\n",$desc);
        $str = '';
        foreach($result as $v){
            $str .= '<li>'.trim($v).'</li>';
        }
        return $str;
    }
    //微信jsapi支付接口
    public function pay(Request $request){
        //$user_id= $request->input("user_id");          //用户id
        $c_id   = $request->input("class_id");           // 课程id
        $price  = round($request->input("final_price",499),2);        // 最终价格
        $stage = $request->input('stage','');//购买期数
        $dis_id = $request->input('dis_id','');//分享人id
        $buy_type = $request->input('type','');//购买方式团购，直接购买
        //$price  = 0.01;        // 最终价格
        $user_id = $request->user()->id;
        $order_group   = new OrderCourseGroup();     //订单模型
        $course_class = DB::table("course_class_group")->where("id",$c_id)->select("id","title","price")->get();

        if($buy_type == 'PT'){
            $old_order = $order_group->where("user_id",$user_id)->where("course_class_group_id",$c_id)->where('buy_way',"TEAM")->where('refund_id',0)->first();
            $buy_way = 'TEAM';
        }else{
            $old_order = $order_group->where("user_id",$user_id)->where("course_class_group_id",$c_id)->where('buy_way',"SINGLE")->first();
            $buy_way = 'SINGLE';
        }
        logger()->info("购买类型:_".$buy_type.'::stage_'.$stage);
        $periodInfo = $this->judgePeriods(['stage'=>$stage,'c_id'=>$c_id,'user_id'=>$user_id,'price'=>$price,'is_weixin'=>1,'buy_type'=>$buy_type]);
        if($periodInfo['code']){
//            $periodInfo['code'] = 1;
            logger()->info($periodInfo);
            return $periodInfo;
        }
        $couponInfo = $this->couponCard($user_id,0,$c_id);
        $hasCoupon = $couponInfo['hasCoupon'];
        $payPrice = $price;
        $coupon_id = $couponInfo['coupon_id'];
        if($old_order){
            logger()->info("goumai:_".$old_order->state);
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
            $order_group->course_class_group_title = $course_class[0]->title;
            $order_group->dis_id = $dis_id;
            if($hasCoupon){
                $order_group->coupon_id = $coupon_id;
            }
            $order_group->save();
        }
        logger()->info('支付用户id:'.$request->user()->id.'--openid--'.$request->user()->openid);
        //②、统一下单
        $tools = new \JsApiPay();
        $openId = $request->user()->openid;
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($course_class[0]->title);             //课程标题
        $input->SetAttach($oNumber);                          //订单号
        $input->SetOut_trade_no("sdkphp".date("YmdHis"));
        $input->SetTotal_fee($price*100);    //订单金额

        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        if($buy_type == 'PT'){
//            $input->SetNotify_url("http://m.saipubbs.com/train/success/".$c_id.".html");
            $input->SetNotify_url("http://m.saipubbs.com/train/notify");
        }else{
            $input->SetNotify_url("http://m.saipubbs.com/train/notify");
        }

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
        //$pay_log->save();     //记录正常支付日志
        $payfrom = "WXPAY";
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
                    $item->transaction_id = $result['transaction_id'];//订单流水号
                    $item->uneffect_time = date('Y-m-d H:i:s',time()+$course_class_group->team_time*86400);
                    $item->save();        //将订单状态改为1  支付成功
                    $pay_log->state = 1;

                    $pay_log->save();     //记录正常支付日志

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

                    //支付成功后将记录插入正在学习表
                    $user = DB::table("users")->where("id",$item->user_id)->select("name","avatar","openid")->get();
                    if($item->buy_way != 'TEAM'){

                        foreach($course_class_ids as $id){
                            $course_class = DB::table("course_class")
                                ->where("id",$id)
                                ->select("user_id",'explain_url','push_message',"title","id","price", "state")
                                ->get();
                            $studying->addOne($item->user_id, $id);
                            //购买成功写入消息通知
                            add_message($author_id,$item->user_id, $user[0]->name, $user[0]->avatar,$course_class[0]->title, "BUY");
                        }
                    }else{
                        $course_join_buyed = CourseClassGroupJoinBuyed::where('course_class_group_id',$course_class_group->id)->where('user_id',$item->user_id)->first();
                        if(!$course_join_buyed){
                            $courseJoinBuyed = new CourseClassGroupJoinBuyed();
                            $courseJoinBuyed->course_class_group_id = $course_class_group->id;
                            $courseJoinBuyed->user_id = $item->user_id;
                            $courseJoinBuyed->sponsor_id = $item->user_id;
                            $courseJoinBuyed->stage = $item->stage;
                            $courseJoinBuyed->price = $item->price;
                            $courseJoinBuyed->save();
                        }
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
                    $sendUser = User::where('id',$item->user_id)->first();
                    //推送消息
                    $data['openid'] = $user[0]->openid;

                    if($item->buy_way != 'TEAM') {
                        $data['type'] = CustomerPushType::IMAGE;
                        $author = Users::where('id',$author_id)->select('name')->first();
                        $title = "【购买成功】".$course_class_group->title;
//                        $desc = "点击进入，添加班主任微信，备注：产后实战";
                        if($course_class_group->id == 1){
                            $desc = "点击进入，添加班主任微信，备注：产后实战";
                            $picurl = 'http://m.saipubbs.com/images/zt/yunchan01.jpg';
                        }else{
                            $desc = "点击进入，添加班主任微信";
                            $picurl = 'http://m.saipubbs.com/images/zt/xunlianying.jpeg';
                        }
                        $data['list'] = [[
                            "title"=>$title,
                            "description"=>$desc,
                            "url"=>env('APP_URL').'/train/success?id='.$course_class_group->id,
                            "picurl"=>$picurl]];
                        if ($course_class[0]->push_message) {
                            event(new WxCustomerMessagePush($data));
                        }
                    }else{
                        $data['type'] = 'TEXT';
                        $ptnum = $course_class_group->team_people -1;
                        $data['text'] = "恭喜您，成功发起[".$course_class_group->title."第".$item->stage."期]拼团，距离拼团成功还剩".$ptnum."人~\n拼团有效期只有24小时，快点<a href='http://m.saipubbs.com/train/success/".$course_class_group->id.".html'>邀请好友</a>吧~~";
                        event(new WxCustomerMessagePush($data));
                    }
                    // $CourseClassPush = new CourseClassPush();
                    //$CourseClassPush->addOne($item->user_id, $item->course_class_id);            //默认接收课程提醒   
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

        $buy_type = $request->input('type','');//购买方式团购，直接购买
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
            if($buy_type == 'PT'){
                $old_order = $order_group->where("user_id",$user_id)->where("course_class_group_id",$c_id)->where('buy_way',"TEAM")->where('refund_id',0)->first();
                $buy_way = 'TEAM';
            }else{
                $old_order = $order_group->where("user_id",$user_id)->where("course_class_group_id",$c_id)->where('buy_way',"SINGLE")->first();
                $buy_way = 'SINGLE';
            }

            $couponInfo = $this->couponCard($user_id,0,$c_id);
            $hasCoupon = $couponInfo['hasCoupon'];
            $payPrice = $price;
            $coupon_id = $couponInfo['coupon_id'];
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
                $order_group->buy_way   = $buy_way;
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

            $notify_url   = "http://m.saipubbs.com/train/notifyh"; //回调地址
            //$redirect_url = urlencode("http://m.saipubbs.com/course/middle/{$c_id}/{$video_id->id}");     //支付成功后跳转页面
            if($buy_type == 'PT'){
                $redirect_url = urlencode("http://m.saipubbs.com/train/success/".$c_id.".html");
            }else{

                $redirect_url = urlencode("http://m.saipubbs.com/train/success?id=".$c_id);     //支付成功后跳转页面
            }

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
    //赛普币支付
    public function paySpb(Request $request){

        $class_group_id   = $request->input("class_group_id");  // 整套课程id
        $price            = $request->input("final_price",499);        // 最终价格
        $stage              = $request->input('stage','');//具体课程购买;
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }

        $periodInfo = $this->judgePeriods(['stage'=>$stage,'c_id'=>$class_group_id,'user_id'=>$user_id,'price'=>$price]);
        if($periodInfo['code']){
            $periodInfo['code'] = 0;
            return $periodInfo;
        }

        //开启事务
        DB::beginTransaction();
        try{
            if($user_id && $class_group_id){
                $order_group   = new OrderCourseGroup();     //订单模型
                $course_class  = DB::table("course_class_group")
                    ->where("id",$class_group_id)
                    ->select("id","title","price")
                    ->first();
                $old_order     = $order_group
                    ->where("user_id",$user_id)
                    ->where("course_class_group_id",$class_group_id)
                    ->first();
                if($old_order){
                    if($old_order->state == 1){
                        echo json_encode(['code'=>0, 'msg'=>"您已购买请联系客服"]);
                        return;
                    }else{
                        $old_order->state = 1;
                        $old_order->payfrom = "SPB";
                        $order_group->stage   = $stage;
                        $re =  $old_order->save();
                    }
                }else{
                    $oNumber = date("YmdHis").rand(1000,9999);
                    $order_group->number  = $oNumber;
                    $order_group->user_id = $user_id;
                    $order_group->price   = $price;
                    $order_group->stage   = $stage;
                    $order_group->state   = 1;
                    $order_group->payfrom = "SPB";
                    $order_group->course_class_group_id    = $class_group_id;
                    $order_group->course_class_group_title = $course_class->title;
                    $re =  $order_group->save();
                }

                $groupStatic = GroupOrderStatistics::where('course_class_group_id',$class_group_id)->where('stage',$stage)->first();
                if($groupStatic){
                    $groupStatic->num += 1;
                    $groupStatic->save();
                }else{
                    $groupStatic = new GroupOrderStatistics();
                    $groupStatic->course_class_group_id = $class_group_id;
                    $groupStatic->stage = $stage;
                    $groupStatic->num = 0;
                }
                if($re){
                    $studying  = new Studying();
                    $CourseClassPush = new CourseClassPush();
                    //整套课程信息
                    $course_class_group = DB::table("course_class_group")
                        ->where("id", $class_group_id)
                        ->first();
                    $course_class_ids   = explode(',', $course_class_group->course_class_ids);  //课程id
                    //导师id
                    $author_id   = $course_class_group->user_id;

                    //支付成功后将记录插入正在学习表
                    foreach($course_class_ids as $id){
                        $course_class = DB::table("course_class")
                            ->where("id",$id)
                            ->select("user_id",'explain_url','push_message',"title","id","price", "state")
                            ->first();

                        $studying->addOne($user_id, $id);
                        $CourseClassPush->addOne($user_id, $id);            //默认接收课程提醒
                        //购买成功写入消息通知
                        $user = DB::table("users")->where("id",$user_id)->select("name","avatar","openid")->first();
                        add_message($author_id, $user_id, $user->name, $user->avatar,$course_class->title, "BUY");
                    }

                    //记录赛普币
                    $newPrice = $price * 100;
                    DB::table("users")->where("id", '=', $user_id)->decrement("spb", $newPrice);
                    courseSpb($user_id, 25, $class_group_id."_group", $price);   //记录赛普币
                    $a['user_id']     = $user_id;
                    $a['spb_rule_id'] = 12;
                    $a['courseid']    = $class_group_id."_group";
                    $a['value']       = -$price * 100;
                    $a['created_at']  = date("Y-m-d H:i:s");
                    DB::table("spb_records")->insert($a);
                    DB::commit();
                    echo json_encode(['code'=>1, 'msg'=>"购买成功"]);
                    return;
                }
            }else{
                echo json_encode(['code'=>0, 'msg'=>"余额不足或购买失败"]);
            }
        }catch(\Exception $e){
            DB::rollback();
            echo json_encode(['code'=>0, 'msg'=>"余额不足或购买失败1"]);
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
        //开启事务
        DB::beginTransaction();
        try{
            if($result['return_code']=='SUCCESS'){
                $number = $result['out_trade_no'];
                $item    = $order_group->where("number",$number)->where("state", 0)->first();
                if($item){

                    $groupStatic = GroupOrderStatistics::where('course_class_group_id',$item->course_class_group_id)->where('stage',$item->stage)->first();
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
                    $item->price  = $result['total_fee']/100;
                    $item->transaction_id = $result['transaction_id'];//订单流水号
                    $item->uneffect_time = date('Y-m-d H:i:s',time()+$course_class_group->team_time*86400);
                    $item->save();        //将订单状态改为1  支付成功

                    $pay_log->state = 2;
                    $pay_log->save();     //记录正常支付日志

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

                    //支付成功后将记录插入正在学习表
                    $user = DB::table("users")->where("id",$item->user_id)->select("name","avatar","openid")->get();
                    if($item->buy_way != 'TEAM'){

                        foreach($course_class_ids as $id){
                            $course_class = DB::table("course_class")
                                ->where("id",$id)
                                ->select("user_id",'explain_url','push_message',"title","id","price", "state")
                                ->get();
                            $studying->addOne($item->user_id, $id);
                            //购买成功写入消息通知
                            add_message($author_id,$item->user_id, $user[0]->name, $user[0]->avatar,$course_class[0]->title, "BUY");
                        }
                    }else{
                        $course_join_buyed = CourseClassGroupJoinBuyed::where('course_class_group_id',$course_class_group->id)->where('user_id',$item->user_id)->first();
                        if(!$course_join_buyed){
                            $courseJoinBuyed = new CourseClassGroupJoinBuyed();
                            $courseJoinBuyed->course_class_group_id = $course_class_group->id;
                            $courseJoinBuyed->user_id = $item->user_id;
                            $courseJoinBuyed->sponsor_id = $item->user_id;
                            $courseJoinBuyed->stage = $item->stage;
                            $courseJoinBuyed->price = $item->price;
                            $courseJoinBuyed->save();
                        }
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
                    $sendUser = User::where('id',$item->user_id)->first();
                    //推送消息
                    $data['openid'] = $user[0]->openid;

                    if($item->buy_way != 'TEAM') {
                        $data['type'] = CustomerPushType::IMAGE;
                        $author = Users::where('id',$author_id)->select('name')->first();
                        $title = "【购买成功】".$course_class_group->title;
//                        $desc = "点击进入，添加班主任微信，备注：产后实战";
                        if($course_class_group->id == 1){
                            $desc = "点击进入，添加班主任微信，备注：产后实战";
                            $picurl = 'http://m.saipubbs.com/images/zt/yunchan01.jpg';
                        }else{
                            $desc = "点击进入，添加班主任微信";
                            $picurl = 'http://m.saipubbs.com/images/zt/xunlianying.jpeg';
                        }
                        $data['list'] = [[
                            "title"=>$title,
                            "description"=>$desc,
                            "url"=>env('APP_URL').'/train/success?id='.$course_class_group->id,
                            "picurl"=>$picurl]];
                        if ($course_class[0]->push_message) {
                            event(new WxCustomerMessagePush($data));
                        }
                    }else{
                        $data['type'] = 'TEXT';
                        $ptnum = $course_class_group->team_people -1;
                        $data['text'] = "恭喜您，成功发起[".$course_class_group->title."第".$item->stage."期]拼团，距离拼团成功还剩".$ptnum."人~\n拼团有效期只有24小时，快点<a href='http://m.saipubbs.com/train/success/".$course_class_group->id.".html'>邀请好友</a>吧~~";
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

    //客户余额支付购买课程20180821
    public function payBalance(Request $request){
        $user_id = $request->input("user_id");     //用户id
        if(!$user_id){
            if($request->user()){
                $userid = $request->user()->id;
            }else{
                $userid = 0;    
            }
        }
        $c_c_id  = $request->input("c_c_id");      //课程id
        $payfrom = "BALANCE";

        //开启事务
        DB::beginTransaction();
        try{
            if($user_id && $c_c_id){
                $course_class = DB::table("course_class")
                    ->where("id",$c_c_id)
                    ->select("user_id", "price", "title",'id','push_message','explain_url')
                    ->get();
                $order = Order::where("user_id",$user_id)->where("course_class_id", $c_c_id)->first();

                if($order){
                    $order->state   = 1;
                    echo json_encode(['code'=>0, 'msg'=>"您已购买请联系客服"]);
                    return;
                }else{
                    $order   = new Order();     //订单模型
                    $oNumber = date("YmdHis").rand(1000,9999);
                    $order->number  = $oNumber;
                    $order->user_id = $user_id;
                    $order->price   = $course_class[0]->price;
                    $order->course_class_id = $c_c_id;
                    $order->course_class_title = $course_class[0]->title;
                    $order->payfrom = $payfrom;
                    $order->state   = 1;
                    $order->created_at= date("Y-m-d H:i:s");
                }
                $r = $order->save();
                if($r){
                    //操作客户账户资金信息
                    $finance_a = new FinanceAccount();
                    $finance_a->addOne($user_id);            //查看用户资金账户，如果没有创建一条
                    $studying  = new Studying();
                    $studying->addOne($user_id, $c_c_id);    //支付成功后将记录插入正在学习表
                    $CourseClassPush = new CourseClassPush();
                    $CourseClassPush->addOne($user_id, $c_c_id);            //默认接收课程提醒
                    add_finance_record($course_class[0]->price,"BUY", $user_id, $payfrom, $c_c_id);   //支付成功后记录流水记录
                    DB::table("finance_accounts")->where("user_id", '=', $user_id)->decrement("total", $course_class[0]->price);
                    //记录导师账户资金信息
                    $author_id   = $course_class[0]->user_id;
                    $finance_a->addOne($author_id);
                    add_finance_record($course_class[0]->price,"ADD", $author_id, $payfrom, $c_c_id);   //支付成功后记录流水记录
                    DB::table("finance_accounts")->where("user_id", '=', $author_id)->increment("total", $course_class[0]->price);
                    //购买成功写入消息通知
                    $user = DB::table("users")->where("id",$user_id)->select("name","avatar")->get();
                    add_message($author_id,$user_id, $user[0]->name, $user[0]->avatar,$course_class[0]->title, "BUY");

                    courseSpb($user_id,6,$c_c_id,$course_class[0]->price);
                    DB::commit();
                    $data['openid'] = $request->user()->openid;
                    $data['type'] = CustomerPushType::IMAGE;

                    $author = Users::where('id',$author_id)->select('name')->first();

                    $title = "【购买成功】".$course_class[0]->title;
                    $desc = $author->name."[导师系列课]：\n".$course_class[0]->push_message."\n点击进入即可查看系列课内容\n回复[TD".$course_class[0]->id."]不再接收该导师系列课推送";
                    $data['list'] = [[
                        "title"=>$title,
                        "description"=>$desc,
                        "url"=>env('APP_URL').'/course/detail/'.$c_c_id.".html",
                        "picurl"=>'http://image.saipubbs.com/'.$course_class[0]->explain_url]];
                    if($course_class[0]->push_message) {
                        event(new WxCustomerMessagePush($data));
                    }
                    echo json_encode(['code'=>1, 'msg'=>"支付成功"]);
                    return;
                }
            }else{
                echo json_encode(['code'=>0, 'msg'=>"余额不足或购买失败"]);
            }

        }catch(\Exception $e){
            logger()->info($e->getMessage());
            logger()->info($e->getLine());
            DB::rollback();

            echo json_encode(['code'=>0, 'msg'=>"余额不足或购买失败1"]);
        }

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
        $id = $request->input('id','');
        $data['id'] = $id;
        if($user){
            return view('train.success',$data);
        }else{
            return redirect('/login');
        }
    }

    /*
     * 信息提交
     */
    public function remark(Request $request){
        $wx = $request->input('wx');
        $time = $request->input('time');
        $know = $request->input('know');
        $way = $request->input('way');
        $suggest = $request->input('suggest');
        $group_id = $request->input('id',1);
        if(empty($group_id)){
            $group_id = 1;
        }
        $user = $request->user();
        if($user){
            $userRemark = UserOrderGroupRemark::where('user_id',$user->id)->where('course_class_group_id',$group_id)->first();
            if(!$userRemark){
                $userRemark = new UserOrderGroupRemark();
            }
            $userRemark->user_id = $user->id;
            $userRemark->course_class_group_id = $group_id;
            $userRemark->mobile = $user->mobile;
            $userRemark->wechat = $wx;
            $userRemark->teach_years = $time;
            $userRemark->way = $know;
            $userRemark->other_way = $way;
            $userRemark->other_suggest = $suggest;
            if($userRemark->save()){
                $data['openid'] = $user->openid;
                $data['type'] = 'TEXT';
                $data['text'] = "已经收到您的报名信息，开课前一天班主任会建班级群，请耐心等待~想提前预习可进入<a href='"."http://m.saipubbs.com/user/studying'>我的课表</a>进行学习~";
                if(env('IS_LOCAL') == false){
//                    logger()->info($data);
                    event(new WxCustomerMessagePush($data));
                }

                return $this->getMessage(0,'提交成功');
            }else{
                return $this->getMessage(1,'提交失败');
            }
        }else{
            return $this->getMessage(2,'未正常提交');
        }

    }

    /*
     *
     */
    public function notice(Request $request){
        $id = $request->input('id','');
        $data['id'] = $id;
        if($request->user()){
            return view('train.begin',$data);
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
//        $buy_type = $data['buy_type'];
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
//        dd($user);
        if(!$user){
            return redirect('/register');
        }else{

            $user_id = $user->id;
        }

        if(strpos($qid,'t') !== false){
            $id =  trim($qid,'t');
            $disInfo['id'] = $id;
            $disInfo['user_id'] = $user_id;
            $info = $this->getTrainInfo($disInfo);

            return view('distActive.sponsor',$info);
        }
        $groupCourse = CourseClassGroup::where('id',$qid)->first();
        $orderCourse = OrderCourseGroup::where('course_class_group_id',$qid)->where('buy_way','TEAM')->where('user_id',$user_id)->where('refund_id',0)->first();

//        dd($orderCourse);
        $classJoinBuyed = CourseClassGroupJoinBuyed::where('user_id',$user_id)->where('course_class_group_id',$qid)->first();
        if(!$classJoinBuyed){
            return redirect('/train/study.html?id='.$qid);
        }
        $classJoins = CourseClassGroupJoinBuyed::where('sponsor_id',$classJoinBuyed->sponsor_id)->where('course_class_group_id',$qid)->orderBy('id','asc')->get();
//        dd($classJoins);
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
    public function joinBuy(Request $request ,$id){
        if(strpos($id,'s') !== false){
            $idArr = explode('s',$id);
            $uid = $idArr[0];
            $gid = $idArr[1];
        }elseif(strpos($id,'t') !== false){
            $idArr = explode('t',$id);
            $uid = $idArr[0];
            $cid = $idArr[1];
            $disInfo['cid'] = $cid;
            $disInfo['uid'] = $uid;
            $curUser = $request->user();
            $disInfo['curUser'] = $curUser;
            $info = $this->getJoinBuyInfo($disInfo);
//            logger()->info($info);
            return view('distActive.joinBuy',$info);
        }

        $courseGroup = CourseClassGroup::where('id',$gid)->first();

        $sponsorUser = User::where('id',$uid)->select('id')->first();

        $joinBuyed = CourseClassGroupJoinBuyed::where('course_class_group_id',$gid)->where('user_id',$uid)->first();
        if(!$joinBuyed){
            return redirect('/train/study.html?id='.$gid);
        }

        $classJoins = CourseClassGroupJoinBuyed::where('sponsor_id',$joinBuyed->sponsor_id)->where('course_class_group_id',$gid)->get();

        $orderCourse = OrderCourseGroup::where('course_class_group_id',$gid)->where('buy_way','TEAM')->where('user_id',$uid)->where('stage',$joinBuyed->stage)->where('refund_id',0)->first();
        if(!$orderCourse){
            return redirect('/train/study.html?id='.$gid);
        }

        $coursePeriod = CourseClassGroupPeriod::where('course_class_group_id',$gid)->where('stage',$orderCourse->stage)->first();

        $sponsorOrders = CourseClassGroupJoinBuyed::where('sponsor_id',$uid)->where('course_class_group_id',$gid)->first();
        $data['courseClassGroup'] = $courseGroup;
        $data['sponsorUser'] = $sponsorUser;
        $data['sponsorOrders'] = $sponsorOrders;
        $data['orderCourse'] = $orderCourse;
        $data['classJoins'] = $classJoins;
        $data['coursePeriod'] = $coursePeriod;
//        dd($orderCourse);
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
        $userJoinBuyed = CourseClassGroupJoinBuyed::where('course_class_group_id',$gid)->where('user_id',$user_id)->where('stage',$joinBuyed->stage)->where('sponsor_id',$joinBuyed->sponsor_id)->select('id')->first();
        if($userJoinBuyed){
            return redirect("/train/success/".$gid.".html");
        }
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

        $teamDesc = $this->getDsec($courseClassGroup->team_course_desc);

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

        $data['courseClassGroup'] = $courseClassGroup;
        $data['youhuitext'] = $youhuitext;
        $data['youhui']     = $youhui;
        $data['user_id']    = $user_id;        //用户id
        $data['mobile']     = $mobile;         //用户手机号
        $data['is_weixin']  = $is_weixin;      // 是否是微信浏览器
        $data['sponsor_id'] = $joinBuyed->sponsor_id;//发起人
//        $data['courseData'] = $courseData;
        $data['nowTime']    = $nowTime;
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

    /*
     * 训练营列表
     */
    public function trainList(Request $request){

        $disCourses = DisCourseClass::where('state',1)->where('is_external',0)->orderBy('orderby','desc')->get();
        $data['disCourses'] = $disCourses;
        return view('train.trainList',$data);
    }

    /*
     *训练营信息
     */
    public function getTrainInfo($disInfo){
        $id = trim($disInfo['id'],'t');
        $user_id = $disInfo['user_id'];
        $disCourse = DisCourseClass::where('id',$id)->first();
//        dd($disCourse);
        $orderCourse = DisOrder::where('dis_course_class_id',$id)->where('buy_way','TEAM')->where('user_id',$user_id)->where('refund_id',0)->first();

        $classJoinBuyed = TeamCourseBuyed::where('user_id',$user_id)->where('cid',$id)->where('type','train')->first();

        $classJoins = TeamCourseBuyed::where('sponsor_id',$classJoinBuyed->sponsor_id)->where('cid',$id)->where('type','train')->orderBy('id','asc')->get();

        $fission_id = $classJoinBuyed->sponsor_id;
        $this->ret['fission_id'] = $fission_id;
        $this->ret['disCourse'] = $disCourse;
        $this->ret['orderCourse'] = $orderCourse;
        $this->ret['classJoins'] = $classJoins;
        $is_local = env("IS_LOCAL");
        $this->ret['user_id'] = $user_id;
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();  //微信分享
        }

        return $this->ret;
    }

    public function getJoinBuyInfo($disInfo){

        $id = $disInfo['cid'];
        $user_id = $disInfo['uid'];
        $curUser = $disInfo['curUser'];
        $mobile = '';
        if($curUser){
            $mobile = $curUser->mobile;
            $cur_user_id = $curUser->id;
        }else{

            $cur_user_id = 0;
        }
        $this->ret['mobile'] = $mobile;
        $disCourse = DisCourseClass::where('id',$id)->first();

        $orderCourse = DisOrder::where('dis_course_class_id',$id)->where('buy_way','TEAM')->where('user_id',$user_id)->where('refund_id',0)->where('state',1)->first();
        $this->ret['trainTitle'] = $disCourse->title;
        $classJoinBuyed = TeamCourseBuyed::where('user_id',$user_id)->where('cid',$id)->where('type','train')->first();
        if(!$orderCourse){

            return ['code'=>400];
        }
        $is_buyed = DisOrder::where('dis_course_class_id',$id)->where('user_id',$cur_user_id)->where('refund_id',0)->where('state',1)->select('id')->first();
        if($is_buyed){
            $is_buyed = 1;
        }else{
            $is_buyed = 0;
        }
        $classJoins = TeamCourseBuyed::where('sponsor_id',$classJoinBuyed->sponsor_id)->where('cid',$id)->where('type','train')->orderBy('id','asc')->get();

        $fission_id = $classJoinBuyed->sponsor_id;
        $this->ret['fission_id'] = $fission_id;
        $this->ret['disCourse'] = $disCourse;
        $this->ret['is_buyed'] = $is_buyed;
        $this->ret['orderCourse'] = $orderCourse;
        $this->ret['classJoins'] = $classJoins;
        $is_local = env("IS_LOCAL");
        $this->ret['user_id'] = $user_id;
        $this->ret['teamDesc'] = '';
        $this->ret['youhui'] = '';
        $this->ret['hasCoupon'] = '';
        $this->ret['sponsor_id'] = '';
        $this->ret['mobile'] = $mobile;
        $this->ret['is_weixin'] = is_weixin()?1:0;
        $this->ret['couponPrice'] = '';
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();  //微信分享
        }

        return $this->ret;
    }
}
