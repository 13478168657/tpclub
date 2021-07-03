<?php

namespace App\Http\Controllers\Distribution;

use App\Models\TeamCourseBuyed;
use App\Models\TeamCourseStatistics;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Courseclass;
use App\Models\CourseClassGroup;
use App\Models\OrderCourseGroup;
use App\Models\Period;
use App\User;
use App\Models\DisForm;
use App\Models\DisCourse;
use App\Models\DisCourseClass;
use App\Models\DisCoursePlayRecord;
use App\Models\WechatActivityHand;
use App\Models\DisOrder;
use App\Models\DisStudying;
use App\Models\Paylog;
use App\Models\Order;
use App\Models\CourseOrder;
use App\Models\IntroActiveUser;
use App\Models\UsersAttribute;
use App\Models\FinanceAccount;
use Illuminate\Support\Facades\DB;
use App\Constant\WxMessageType;
use App\Utils\WxMessagePush;
use App\Events\WxCustomerMessagePush;

require app_path().'/Library/Wechat/WxPay.JsApiPay.php';

class TeamDistActiveController extends Controller
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

        $cid   = $request->input("class_id");// 课程id
        $dis_id = $request->input('dis_id','');//分享人id
        $sponsor_id = $request->input('sponsor_id','');
        $user_id = $request->user()->id;

        $team_course_buyed = TeamCourseBuyed::where('user_id',$dis_id)->where('cid',$cid)->where('type','train')->first();

        if(!$team_course_buyed){
            return ['code'=>1,'message'=>'发起人未购买'];
        }
        $disOrderGroup = DisOrder::where('user_id',$dis_id)->where('dis_course_class_id',$cid)->where('stage',$team_course_buyed->stage)->where('buy_way','TEAM')->where('state',1)->first();

        $effect_time = $disOrderGroup->uneffect_time;
        if(strtotime($effect_time) <= time()){
            return ['code'=>1,'message'=>'该团购活动失效'];
        }
        $course_total_buyed = TeamCourseBuyed::where('sponsor_id',$disOrderGroup->user_id)->where('cid',$cid)->where('type','train')->where('stage',$team_course_buyed->stage)->select('id','user_id')->get();

        $disClass = DisCourseClass::where("id",$cid)->select("id","title","price","team_price","team_people","people_set")->first();

        if(count($course_total_buyed) >= $disClass->team_people){
            return ['code'=>1,'message'=>'团购已满'];
        }
        $stage = $team_course_buyed->stage;
        $price = $disClass->team_price;


        $periodInfo = $this->judgePeriods(['stage'=>$team_course_buyed->stage,'c_id'=>$cid,'user_id'=>$user_id,'price'=>$price,'is_weixin'=>1]);

        if($periodInfo['code']){
            return $periodInfo;
        }

        $old_order = DisOrder::where("user_id",$user_id)->where("dis_course_class_id",$cid)->where('buy_way',"TEAM")->where('refund_id',0)->first();
        $buy_way = 'TEAM';
        if($old_order){
            if($old_order->state == 0){
                $oNumber = $old_order->number;
                $old_order->stage = $stage;
//                $old_order->dis_id = ;
                $old_order->price = $price;
                $old_order->sponsor_id = $sponsor_id;
                $old_order->save(); //更新期数
            }else{
                return ['code'=>1,'message'=>'您已购买请联系客服'];
            }
        }else{
            $disOrder = new DisOrder();
            $oNumber = date("YmdHis").rand(1000,9999);
            $disOrder->number  = $oNumber;
            $disOrder->user_id = $user_id;
            $disOrder->price   = $price;
            $disOrder->stage   = $stage;
            $disOrder->buy_way   = $buy_way;
            $disOrder->dis_course_class_id    = $cid;
            $disOrder->dis_course_class_title = $disClass->title;
//            $disOrder->dis_id = $dis_id;
            $disOrder->sponsor_id = $sponsor_id;
            $disOrder->save();
        }
        //②、统一下单
        $tools = new \JsApiPay();
        $openId = $request->user()->openid;
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($disClass->title);             //课程标题
        $input->SetAttach($oNumber);                          //订单号
        $input->SetOut_trade_no("sdkphp".date("YmdHis"));
        $input->SetTotal_fee($price*100);    //订单金额

        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://m.saipubbs.com/dist/team/notify");


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
        $pay_log->info   = $json_d;
        $pay_log->c_time = $time;
        $payfrom = "WXPAY";
        if($result['return_code']=='SUCCESS'){
            $pay_log->state = 1;

            $pay_log->save();     //记录正常支付日志
        }
        //开启事务
        DB::beginTransaction();
        try{
            if($result['return_code']=='SUCCESS'){
                $out_trade_no = $result['out_trade_no'];
                $number  = $result['attach'];
                $item    = DisOrder::where("number",$number)->where("state", 0)->first();
                if($item){
                    $groupStatic = TeamCourseStatistics::where('cid',$item->dis_course_class_id)->where('stage',$item->stage)->where('type','train')->first();
                    $dis_order_group = DisOrder::where('user_id',$item->sponsor_id)->where('dis_course_class_id',$item->dis_course_class_id)->where('stage',$item->stage)->where('state',1)->first();
                    $class_group_join_buyed = TeamCourseBuyed::where('user_id',$item->sponsor_id)->where('cid',$item->dis_course_class_id)->where('stage',$item->stage)->where('type','train')->first();
                    $class_group_total_buyed = TeamCourseBuyed::where('sponsor_id',$class_group_join_buyed->sponsor_id)->where('cid',$item->dis_course_class_id)->where('stage',$item->stage)->where('type','train')->get();

                    if($groupStatic){
                        $groupStatic->num += 1;
                        $groupStatic->save();
                    }else{
                        $groupStatic = new TeamCourseStatistics();
                        $groupStatic->cid = $item->dis_course_class_id;
                        $groupStatic->stage = $item->stage;
                        $groupStatic->num = 1;
                        $groupStatic->type = 'train';
                        $groupStatic->save();
                    }

                    //整套课程信息
                    $disClass = DisCourseClass::where("id", $item->dis_course_class_id)
                        ->first();

                    $item->state = 1;
                    $item->payfrom = $payfrom;
                    $item->price   = $result['total_fee']/100;
                    $item->uneffect_time = $dis_order_group->uneffect_time;
                    $item->transaction_id = $result['transaction_id'];//订单流水号
                    $item->save();        //将订单状态改为1  支付成功

//                    $price = $item->price;  //最终支付价格
//                    $finance_a = new FinanceAccount();
//                    $studying  = new Studying();

                    $course_join_buyed = TeamCourseBuyed::where('cid',$disClass->id)->where('stage',$item->stage)->where('type','train')->where('user_id',$item->user_id)->first();
                    $pintanFlag = 0;

                    if(count($class_group_total_buyed) == $disClass->team_people-1){

                        foreach($class_group_total_buyed as $joinUser){

                            $this->insertTrainInfo($joinUser);
                        }

                        //支付成功后将记录插入正在学习表
                        $user = DB::table("users")->where("id",$item->user_id)->select("name","avatar","openid","nickname")->first();
                        $pintanFlag = 1;
                    }
                    if(!$pintanFlag) {
                        $user = DB::table("users")->where("id", $item->user_id)->select("name", "avatar", "openid", "nickname")->first();
                    }

                    if(!$course_join_buyed){
                        $course_join_buyed = new TeamCourseBuyed();
                        $course_join_buyed->cid = $disClass->id;
                        $course_join_buyed->user_id = $item->user_id;
                        $course_join_buyed->sponsor_id = $class_group_join_buyed->sponsor_id;
                        $course_join_buyed->stage = $item->stage;
                        $course_join_buyed->price = $item->price;
                        $course_join_buyed->type = 'train';
                        $course_join_buyed->save();
                    }

                    $this->insertTrainInfo($course_join_buyed);
                    //操作客户账户资金信息
//                    $finance_a->addOne($item->user_id);
                    //推送消息
                    if(!$pintanFlag){
                        $sponsorUser = User::where('id',$class_group_join_buyed->sponsor_id)->first();
                        $data['openid'] = $user->openid;
                        $data['type'] = 'TEXT';
                        $name = $sponsorUser->name?$sponsorUser->name:$sponsorUser->nickname;
                        $restNum = $disClass->team_people - count($class_group_total_buyed)-1;
                        $data['text'] = "恭喜您，成功参加好友@".$name."的[".$disClass->title."第".$item->stage."期]拼团，距离拼团成功还剩".$restNum."人~\n您可以选择帮<a href='http://m.saipubbs.com/train/success/t".$disClass->id.".html'>好友邀请</a>，也可以<a href='m.saipubbs.com'>逛一逛社区的其他内容吧~~</a>";
                        event(new WxCustomerMessagePush($data));
                        $data['openid'] = $sponsorUser->openid;
                        $data['type'] = 'TEXT';
                        $friendName = $user->name?$user->name:$user->nickname;
                        $data['text'] = "好友@".$friendName."参加了你的[".$disClass->title."第".$item->stage."期]拼团，距离拼团成功还剩".$restNum."人~拼团有效期只有24小时，快点<a href='http://m.saipubbs.com/train/success/t".$disClass->id.".html'>邀请好友吧~~</a>";

                        event(new WxCustomerMessagePush($data));

                    }else{
                        foreach($class_group_total_buyed as $joinUser){
                            $sponsorUser = User::where('id',$joinUser->user_id)->first();
                            $data['openid'] = $sponsorUser->openid;
                            $data['type'] = 'TEXT';
                            $data['text'] = "报名成功，恭喜您获得[健身教练训练营|跑姿评估与纠正第1期]~\n扫描下方二维码，加入班级群吧~";
                            event(new WxCustomerMessagePush($data));
                            $data['openid'] = $sponsorUser->openid;
                            $data['type'] = 'IMAGES';
                            $data['media_id'] = "gvmlIDSH-W_k9qgA1XHKmcI8sgcr6PVi0Dnk2YMU8kmv6-OQlL3wli0lVUgY-SfF";
                            event(new WxCustomerMessagePush($data));
                        }
                        $sponsorUser = User::where('id',$item->user_id)->first();
                        $data['openid'] = $sponsorUser->openid;
                        $data['type'] = 'TEXT';
//                        $name = $sponsorUser->name?$sponsorUser->name:$sponsorUser->nickname;
                        $data['text'] = "报名成功，恭喜您获得[健身教练训练营|跑姿评估与纠正第1期]~\n扫描下方二维码，加入班级群吧~";
                        event(new WxCustomerMessagePush($data));
                        $data['openid'] = $sponsorUser->openid;
                        $data['type'] = 'IMAGES';
                        $data['media_id'] = "gvmlIDSH-W_k9qgA1XHKmcI8sgcr6PVi0Dnk2YMU8kmv6-OQlL3wli0lVUgY-SfF";
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

    //微信H5支付页面
    public function payH(Request $request){
        $cid   = $request->input("c_id");  // 课程id
        $dis_id = $request->input('dis_id');//分享人id
        $sponsor_id = $request->input('sponsor_id','');
        $user_id = $request->user()->id;

        $team_course_buyed = TeamCourseBuyed::where('user_id',$dis_id)->where('cid',$cid)->where('type','train')->first();
        if(!$team_course_buyed){
            return ['code'=>1,'message'=>'发起人未购买'];
        }
        $disOrder = DisOrder::where('user_id',$dis_id)->where('dis_course_class_id',$cid)->where('stage',$team_course_buyed->stage)->where('buy_way','TEAM')->where('state',1)->first();

        $effect_time = $disOrder->uneffect_time;

        if(strtotime($effect_time) >= time()){
            return ['code'=>1,'message'=>'该团购活动失效'];
        }

        $course_total_buyed = TeamCourseBuyed::where('sponsor_id',$disOrder->user_id)->where('cid',$cid)->where('type','train')->where('stage',$team_course_buyed->stage)->select('id','user_id')->get();

        $disClass = DisCourseClass::where("id",$cid)->select("id","title","price","team_price","team_people","people_set")->first();

        if(count($course_total_buyed) >= $disClass->team_people){
            return ['code'=>1,'message'=>'团购已满'];
        }
        $stage = $team_course_buyed->stage;
        $price = $disClass->team_price;

        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }

        $periodInfo = $this->judgePeriods(['stage'=>$team_course_buyed->stage,'c_id'=>$cid,'user_id'=>$user_id,'price'=>$price,'is_weixin'=>1]);

        if($periodInfo['code']){

            return $periodInfo;
        }

        if($user_id && $cid){


            $old_order = DisOrder::where("user_id",$user_id)->where("dis_course_class_id",$cid)->where('buy_way',"TEAM")->where('refund_id',0)->first();
            $buy_way = 'TEAM';
            if($old_order){
                if($old_order->state == 0){
                    $oNumber = $old_order->number;
                    $old_order->stage = $stage;
                    $old_order->dis_id = $dis_id;
                    $old_order->price = $price;
                    $old_order->sponsor_id = $sponsor_id;
                    $old_order->save(); //更新期数
                }else{
                    return ['code'=>1,'message'=>'您已购买请联系客服'];
                }
            }else{
                $disOrder = new DisOrder();
                $oNumber = date("YmdHis").rand(1000,9999);
                $disOrder->number  = $oNumber;
                $disOrder->user_id = $user_id;
                $disOrder->price   = $price;
                $disOrder->stage   = $stage;
                $disOrder->buy_way   = $buy_way;
                $disOrder->dis_course_class_id    = $cid;
                $disOrder->dis_course_class_title = $disClass->title;
                $disOrder->dis_id = $dis_id;
                $disOrder->sponsor_id = $sponsor_id;
                $disOrder->save();
            }

            $wxConfig = new \WxPayConfig();
            $userip = get_ip();                          //获得用户设备IP 自己网上百度去
            $appid  = $wxConfig->GetAppId();             //微信给的
            $mch_id = $wxConfig->GetMerchantId();        //微信官方的x
            $key    = $wxConfig->GetKey();               //自己设置的微信商家key
            $out_trade_no = $oNumber;                    //平台内部订单号
            $nonce_str    = MD5($out_trade_no);          //随机字符串
            $body         = $disClass->title;     //内容
            $total_fee    = $price*100; //金额
            $spbill_create_ip = $userip;                 //IP
            $notify_url   = "http://m.saipubbs.com/dist/team/notifyh"; //回调地址
            //$redirect_url = urlencode("http://m.saipubbs.com/course/middle/{$c_id}/{$video_id->id}");     //支付成功后跳转页面
            $redirect_url = urlencode("http://m.saipubbs.com/train/success/t".$disClass->id.".html");     //支付成功后跳转页面
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
                    $groupStatic = TeamCourseStatistics::where('cid',$item->dis_course_class_id)->where('stage',$item->stage)->where('type','train')->first();
                    $dis_order_group = DisOrder::where('user_id',$item->sponsor_id)->where('dis_course_class_id',$item->dis_course_class_id)->where('stage',$item->stage)->where('state',1)->first();
                    $class_group_join_buyed = TeamCourseBuyed::where('user_id',$item->sponsor_id)->where('cid',$item->dis_course_class_id)->where('stage',$item->stage)->where('type','train')->first();
                    $class_group_total_buyed = TeamCourseBuyed::where('sponsor_id',$class_group_join_buyed->sponsor_id)->where('cid',$item->dis_course_class_id)->where('stage',$item->stage)->where('type','train')->select('id','user_id')->get();
                    if($groupStatic){
                        $groupStatic->num += 1;
                        $groupStatic->save();
                    }else{
                        $groupStatic = new TeamCourseStatistics();
                        $groupStatic->cid = $item->dis_course_class_id;
                        $groupStatic->stage = $item->stage;
                        $groupStatic->type = 'train';
                        $groupStatic->num = 1;
                        $groupStatic->save();
                    }
                    //整套课程信息
                    $disClass = DisCourseClass::where("id", $item->dis_course_class_id)
                        ->first();

                    $item->state = 1;
                    $item->payfrom = $payfrom;
                    $item->price   = $result['total_fee']/100;
                    $item->uneffect_time = $dis_order_group->uneffect_time;
                    $item->transaction_id = $result['transaction_id'];//订单流水号
                    $item->save();        //将订单状态改为1  支付成功

//                    $price = $item->price;  //最终支付价格
//                    $finance_a = new FinanceAccount();
//                    $studying  = new Studying();

                    $course_class_ids   = explode(',', $disClass->course_ids);  //课程id
                    //导师id
                    $author_id   = $disClass->user_id;

                    $course_join_buyed = TeamCourseBuyed::where('cid',$disClass->id)->where('stage',$item->stage)->where('type','train')->where('user_id',$item->user_id)->first();
                    $pintanFlag = 0;

                    if(count($class_group_total_buyed) == $disClass->team_people-1){
                        foreach($class_group_total_buyed as $joinUser){

                            $this->insertTrainInfo($joinUser);
                        }
                        //支付成功后将记录插入正在学习表
                        $user = DB::table("users")->where("id",$item->user_id)->select("name","avatar","openid","nickname")->first();
                        $pintanFlag = 1;
                    }
                    if(!$pintanFlag) {
                        $user = DB::table("users")->where("id", $item->user_id)->select("name", "avatar", "openid", "nickname")->first();
                    }
                    if(!$course_join_buyed){
                        $teamCouserBuyed = new TeamCourseBuyed();
                        $teamCouserBuyed->cid = $disClass->id;
                        $teamCouserBuyed->user_id = $item->user_id;
                        $teamCouserBuyed->sponsor_id = $class_group_join_buyed->sponsor_id;
                        $teamCouserBuyed->stage = $item->stage;
                        $teamCouserBuyed->price = $item->price;
                        $teamCouserBuyed->save();
                    }
                    $this->insertTrainInfo($course_join_buyed);
                    //操作客户账户资金信息
//                    $finance_a->addOne($item->user_id);
                    //推送消息
                    if(!$pintanFlag){
                        $sponsorUser = User::where('id',$class_group_join_buyed->sponsor_id)->first();
                        $data['openid'] = $user->openid;
                        $data['type'] = 'TEXT';
                        $name = $sponsorUser->name?$sponsorUser->name:$sponsorUser->nickname;
                        $restNum = $disClass->team_people - count($class_group_total_buyed)-1;
                        $data['text'] = "恭喜您，成功参加好友@".$name."的[".$disClass->title."第".$item->stage."期]拼团，距离拼团成功还剩".$restNum."人~\n您可以选择帮<a href='http://m.saipubbs.com/train/success/t".$disClass->id.".html'>好友邀请</a>，也可以<a href='m.saipubbs.com'>逛一逛社区的其他内容吧~~</a>";
                        event(new WxCustomerMessagePush($data));
                        $data['openid'] = $sponsorUser->openid;
                        $data['type'] = 'TEXT';
                        $friendName = $user->name?$user->name:$user->nickname;
                        $data['text'] = "好友@".$friendName."参加了你的[".$disClass->title."第".$item->stage."期]拼团，距离拼团成功还剩".$restNum."人~拼团有效期只有24小时，快点<a href='http://m.saipubbs.com/train/success/t".$disClass->id.".html'>邀请好友吧~~</a>";

                        event(new WxCustomerMessagePush($data));

                    }else{
                        foreach($class_group_total_buyed as $joinUser){
                            $sponsorUser = User::where('id',$joinUser->user_id)->first();
                            $data['openid'] = $sponsorUser->openid;
                            $data['type'] = 'TEXT';
                            $data['text'] = "拼团成功，恭喜您获得[".$disClass->title."第".$item->stage."期]~\n快来"."<a href='http://m.saipubbs.com/train/success'>完善报名信息</a>,加入班级群吧~";
                            event(new WxCustomerMessagePush($data));
                        }
                        $sponsorUser = User::where('id',$item->user_id)->first();
                        $data['openid'] = $sponsorUser->openid;
                        $data['type'] = 'TEXT';
//                        $name = $sponsorUser->name?$sponsorUser->name:$sponsorUser->nickname;
                        $data['text'] = "拼团成功，恭喜您获得[".$disClass->title."第".$item->stage."期]~\n快来"."<a href='http://m.saipubbs.com/train/success'>完善报名信息</a>,加入班级群吧~";
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
        $cid = $data['c_id'];
        $user_id = $data['user_id'];
        $price = $data['price'];

        $teamStatic = TeamCourseStatistics::where('cid',$cid)->where('stage',$stage)->where('type','train')->select('num')->first();
        $disClass = DisCourseClass::where('id',$cid)->select('course_ids','people_set','team_price')->first();
        $order   = new Order();     //订单模型
        if(!$teamStatic){
            $teamStatic = new TeamCourseStatistics();
            $teamStatic->cid = $cid;
            $teamStatic->stage = $stage;
            $teamStatic->num = 0;
            $teamStatic->type = 'train';
            $teamStatic->save();
        }
        if($teamStatic->num >= $disClass->people_set){

                return ['code'=>0];
        }else{
            return ['code'=>0];
        }
    }

    /*
     * 处理订单
     */
    public function insertTrainInfo($item){
//操作客户账户资金信息
        $finance_a = new FinanceAccount();
        $finance_a->addOne($item->user_id); //查看用户资金账户，如果没有创建一条


        $disStudy = new DisStudying();
        //整套课程信息

        $disCourseClass = DisCourseClass::where("id", $item->cid)->first();
        $disStudy->user_id = $item->user_id;
        $disStudy->dis_course_class_id = $item->cid;
        $disStudy->dis_id = $item->sponsor_id;//分销员id
        $disStudy->save();

        $course_ids = explode(',', $disCourseClass->course_ids);
        $playRecords = [];
        $period = $this->getPeriods($item->cid);
        if ($period) {
            $periodTime = $period->begin_time;
        }

        $studyTime = strtotime($periodTime);
        foreach ($course_ids as $k => $ids) {

            $course = DisCourse::where('id', $ids)->select('delay')->first();
            $time = $studyTime + $course->delay * 86400;
            $day = date('Y-m-d', $time);
            $delayTime = strtotime($day);
            $playRecords[$k]['user_id'] = $item->user_id;
            $playRecords[$k]['dis_course_id'] = $ids;
            $playRecords[$k]['datetime'] = $delayTime;
            $playRecords[$k]['day'] = $day;
            $playRecords[$k]['dis_course_class_id'] = $disCourseClass->id;
            $playRecords[$k]['created_at'] = date('Y-m-d H:i:s');
            $playRecords[$k]['updated_at'] = date('Y-m-d H:i:s');
        }
        DB::table('dis_course_play_record')->insert($playRecords);
//        //推送消息
//        $user = DB::table("users")->where("id", $item->user_id)->select("openid")->first();
//        if ($user && $user->openid) {
//            $data['type'] = WxMessageType::DISCOURSE;
//            $data['url'] = env('APP_URL') . "/dist/study/{$item->dis_course_class_id}.html";
//            $data['notice'] = "您好，您已成功报名以下课程";
//            $data['message']['key1'] = $item->dis_course_class_title;
//            $data['message']['key2'] = "报名成功后永久开放";
//            $data['message']["remark"] = "记得每天学习打卡哦~";
//            $data['openid'] = $user->openid;
//            $wxpush = new WxMessagePush();
//            $wxpush->sendMessage($data);
//        }
    }

    /*
     * 获取购课期数
     */
    public function getPeriods($cid){

        $nowDay = date('Y-m-d');
        $period = Period::where('cid',$cid)->where('begin_time','>',$nowDay)->first();
        return $period;
    }
}
