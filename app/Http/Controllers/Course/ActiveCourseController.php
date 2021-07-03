<?php

namespace App\Http\Controllers\Course;

use App\Models\Course;
use App\Models\Article;
use App\Models\Courseclass;
use App\Models\CourseType;
use App\Models\CourseContent;
use App\Models\Coursesection;
use App\Models\IntroActiveUser;
use App\Models\Order;
use App\Models\Paylog;
use App\Models\Tags;
use App\Models\UserCoupon;
use App\Models\Users;
use App\Models\CourseActivityUser;
use App\Models\CourseActivityView;
use App\Models\CourseActivitySpbRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\FinanceAccount;
use App\Models\FinanceRecord;
use App\Models\Studying;
use App\Utils\WxMessagePush as WxPush;
use App\Models\Follow;
use App\Models\Comment;
use App\Constant\CommentDate;
use App\Models\Consultation;
use App\Models\ArticleRecommend;
use App\Events\WxMessagePush;
use App\Constant\WxMessageType;
use App\Models\CourseClassPush;
use App\Models\Coupon;
use App\Models\DisCourseClass;
use App\Models\DisStudying;
use App\Models\OrderCourseGroup;
use App\Utils\ImageThumb;
use App\Utils\SensitiveWord;
use App\Utils\CurlUtil;
use App\Events\WxCustomerMessagePush;
use App\Constant\CustomerPushType;
use Illuminate\Support\Facades\Redis;
use App\Models\CourseClassGroup;

require app_path().'/Library/Wechat/WxPay.JsApiPay.php';
class ActiveCourseController extends Controller
{
    protected $ret;
    protected $page;

    public function __construct()
    {
        $this->ret = [];
        $this->page = 2;
    }

    //微信jsapi支付接口
    public function pay(Request $request){
        //$user_id= $request->input("user_id");    //用户id
        $c_id   = $request->input("class_id","");  // 课程id
        $fission_id = $request->input('fission_id','0');//分享人用户id
        $user_id = $request->user()->id;
        $mobile = $request->user()->mobile;
        $stage = $request->input('stage',0);
        $order   = new Order();     //订单模型
        $course_class = DB::table("course_class")->where("id",$c_id)->select("id","title","price")->first();

        //判断用户角色，确定支付价格
        $descPrice = 0;

        if($c_id == 58){
            $stageArr = [1=>30,2=>160,3=>165];
            $buyNum = $stageArr[$stage] - Order::where('course_class_id',58)->where('state',1)->where('stage',$stage)->select('id')->count();
            if($buyNum <= 0){
                return $this->getMessage(1,'该期课程报名已满');
            }
        }elseif($c_id == 70){
            $stageArr = [1=>36,2=>36];
            $buyNum = $stageArr[$stage] - Order::where('course_class_id',$c_id)->where('state',1)->where('stage',$stage)->select('id')->count();
            if($buyNum <= 0){
                return $this->getMessage(1,'该期课程报名已满');
            }
        }elseif($c_id = 71){
            $stageArr = [1=>25,2=>50];
            $buyNum = $stageArr[$stage] - Order::where('course_class_id',$c_id)->where('state',1)->where('stage',$stage)->select('id')->count();
            if($buyNum <= 0){
                return $this->getMessage(1,'该期课程报名已满');
            }
        }

        $old_order = $order->where("user_id",$user_id)->where("course_class_id",$c_id)->first();
        $price = 7040;
        if($mobile){
            $introActiveUser = IntroActiveUser::where('user_id',$user_id)->first();
            if($introActiveUser){
                $idNumber = json_decode($introActiveUser->user_info)->card;
            }else{
                $idNumber = '';
            }
            if($course_class->id== 58) {
                $url = 'http://101.201.81.14:9315/saipu-app-ins/api/trainee_info_status?idNumber=' . $idNumber;
                $result = CurlUtil::appCurl($url, [], 'GET');
                $resInfo = json_decode($result, true);
                //                dd($resInfo);
                if (isset($resInfo['code']) && $resInfo['code'] == 0) {
                    if (isset($resInfo['result']['studentStatus']) && $resInfo['result']['studentStatus'] == '01') {
                        $price = 4700;
                    }
                    if (isset($resInfo['result']['studentStatus']) && $resInfo['result']['studentStatus'] == '03') {
                        $price = 4700;
                    }
                } else {
                    $price = 7040;
                }
                $isBuy = $this->isBuyedCourse($user_id);
                if($isBuy){
                    $price = 4700;
                }
            }elseif($course_class->id == 70){
                $priceArr = [1=>4800,2=>5600];
                $price = $priceArr[$stage];
            }elseif($course_class->id == 71){
//                $price = 0.01;
                $price = $course_class->price;
            }else{
                $price = $course_class->price;
            }
        }

        $payPrice = $price;
        if($old_order){
            if($old_order->state == 0){
                $oNumber = $old_order->number;
                $old_order->price = $payPrice;
                $old_order->dis_id = $fission_id;
                $old_order->type  = 1;
                $old_order->stage = $stage;
                $old_order->save();
            }else{
                return ['code'=>1,'message'=>'您已购买请联系客服'];
            }
        }else{
            $oNumber = date("YmdHis").rand(1000,9999);
            $order->number  = $oNumber;
            $order->user_id = $user_id;
            $order->price   = $payPrice;
            $order->dis_id = $fission_id;
            $order->stage = $stage;
            $order->type = 1;
            $order->course_class_id = $c_id;
            $order->course_class_title = $course_class->title;
            $order->save();
        }
//        logger()->info([$order->number,$user_id,$payPrice,$fission_id,$c_id,$course_class->title, $request->user()->openid]);
        //②、统一下单
        $tools = new \JsApiPay();
        $openId = $request->user()->openid;
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($course_class->title);             //课程标题
        $input->SetAttach($oNumber);                          //订单号
        $input->SetOut_trade_no("sdkphp".date("YmdHis"));
        $input->SetTotal_fee($payPrice*100);    //订单金额
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://m.saipubbs.com/activeCourse/notify");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);

        $config = new \WxPayConfig();
        $order = \WxPayApi::unifiedOrder($config, $input);

        $jsApiParameters = $tools->GetJsApiParameters($order);
        $info =  json_decode($jsApiParameters,true);
        return ['code'=>0,'data'=>$info];
    }

    /*
     * 判断是否购买组合课程
     */
    private function isBuyedCourse($userid){
//        $groupOrder = OrderCourseGroup::where('user_id',$userid)->whereIn('course_class_group_id',[1,4])->where('state',1)->select('id')->first();
//        $buyGroup = 0;
//        if($groupOrder){
//            $buyGroup = 1;
//        }
        $groupOrder = OrderCourseGroup::where('user_id',$userid)->whereIn('course_class_group_id',[1,4])->where('state',1)->select('id','course_class_group_id')->get();
        $buyGroup = 0;
        foreach($groupOrder as $order){
            if($order->buy_way == 'TEAM'){
                $joinBuyed = CourseClassGroupJoinBuyed::where('course_class_group_id',$order->course_class_group_id)->where('user_id',$userid)->select('sponsor_id')->first();
                if($order->course_class_group_id == 1){
                    $total = CourseClassGroupJoinBuyed::where('sponsor_id',$joinBuyed->sponsor_id)->select('id')->count();
                    if($total >= 2){
                        $buyGroup = 1;
                        break;
                    }
                }else{
                    $total = CourseClassGroupJoinBuyed::where('sponsor_id',$joinBuyed->sponsor_id)->select('id')->count();
                    if($total >= 3){
                        $buyGroup = 1;
                        break;
                    }
                }
            }else{
                $buyGroup = 1;
                break;
            }
        }
        return $buyGroup;
    }

    //微信jsapi支付成功后回调接口
    public function notify(Request $request){

        $xml = file_get_contents('php://input');
        $result = xmlToArray($xml);
        $json_d = json_encode($result);
        $time   = time();
        $pay_log= new Paylog();    //支付日志
        $order  = new Order();     //订单模型
        $pay_log->info   = $json_d;
        $pay_log->c_time = $time;
        $payfrom = "WXPAY";
        if($result['return_code']=='SUCCESS') {
            $pay_log->state = 1;
            $pay_log->save();     //记录正常支付日志
        }
        //开启事务
        DB::beginTransaction();
        try{
            if($result['return_code']=='SUCCESS'){
                $out_trade_no = $result['out_trade_no'];
                $number  = $result['attach'];
                $item    = $order->where("number",$number)->where("state", 0)->first();
                if($item){
                    $item->state = 1;
                    $item->payfrom = $payfrom;
                    $item->save();        //将订单状态改为1  支付成功
                    //操作客户账户资金信息
                    $finance_a = new FinanceAccount();
                    $finance_a->addOne($item->user_id);                           //查看用户资金账户，如果没有创建一条
//                    $studying  = new Studying();
//                    $studying->addOne($item->user_id, $item->course_class_id);    //支付成功后将记录插入正在学习表
//                    $CourseClassPush = new CourseClassPush();
//                    $CourseClassPush->addOne($item->user_id, $item->course_class_id);            //默认接收课程提醒
                    add_finance_record($item->price,"BUY", $item->user_id, $payfrom, $item->course_class_id);   //支付成功后记录流水记录

                    //记录导师账户资金信息
                    $course_class = DB::table("course_class")
                        ->where("id",$item->course_class_id)
                        ->select("user_id",'explain_url','push_message',"title","id")
                        ->get();
                    $author_id   = $course_class[0]->user_id;
                    $finance_a->addOne($author_id);
                    add_finance_record($item->price,"ADD", $author_id, $payfrom, $item->course_class_id);   //支付成功后记录流水记录
                    DB::table("finance_accounts")->where("user_id", '=', $author_id)->increment("total", $item->price);
                    //购买成功写入消息通知
                    $user = DB::table("users")->where("id",$item->user_id)->select("name","avatar","openid")->get();
                    add_message($author_id,$item->user_id, $user[0]->name, $user[0]->avatar,$item->course_class_title, "BUY");

//                    courseSpb($item->user_id,6,$item->course_class_id,$item->price);   //记录赛普币

                    $data['openid'] = $user[0]->openid;
                    $data['type'] = CustomerPushType::IMAGE;

                    $author = Users::where('id',$author_id)->select('name')->first();

                    $title = "【购买成功】".$course_class[0]->title;
                    $desc = $author->name."[导师系列课]：\n".$course_class[0]->push_message."\n点击进入即可查看系列课内容\回复[TD".$course_class[0]->id."]不再接收该导师系列课推送";
                    $data['list'] = [[
                        "title"=>$title,
                        "description"=>$desc,
                        "url"=>env('APP_URL').'/course/detail/'.$item->course_class_id.".html",
                        "picurl"=>'http://image.saipubbs.com/'.$course_class[0]->explain_url]];
                    if($course_class[0]->push_message) {
                        event(new WxCustomerMessagePush($data));
                    }
                }
            }else{
                $pay_log->state = 0;
                $pay_log->save();         //记录有问题支付日志
            }
            DB::commit();
//            $data['openid'] = $user[0]->openid;
//            $data['type']   = WxMessageType::ENROLL;
//            $courseClass    = Courseclass::where('id',$item->course_class_id)->select('title','user_id')->first();
//            $author         = $courseClass->author;
//            $data['notice'] = "支付成功！";
//            $data['url']    = env('APP_URL').'/course/detail?id='.$item->course_class_id;
//            $data['message']['course'] = $courseClass;
//            $data['message']['author'] = $author;
//            event(new WxMessagePush($data));

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
        $c_id   = $request->input("course_class_id");  // 课程id
        $fission_id = $request->input('fission_id','0');//分销员id
        $stage = $request->input('stage','0');//所购课程阶段
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }
        if($user_id && $c_id){
            $order   = new Order();     //订单模型
            $course_class = DB::table("course_class")->where("id",$c_id)->select("id","title","price",'course_type')->get();
            $old_order = $order->where("user_id",$user_id)->where("course_class_id",$c_id)->first();
            $mobile = $request->user()->mobile;
            if($mobile){
                $introActiveUser = IntroActiveUser::where('user_id',$user_id)->first();
                if($introActiveUser){
                    $idNumber = json_decode($introActiveUser->user_info)->card;
                }else{
                    $idNumber = '';
                }
                $url = 'http://101.201.81.14:9315/saipu-app-ins/api/trainee_info_status?idNumber='.$idNumber;
                $result = CurlUtil::appCurl($url,[],'GET');
                $resInfo = json_decode($result,true);
//                dd($resInfo);
                if(isset($resInfo['code']) && $resInfo['code'] == 0){
                    if(isset($resInfo['result']['studentStatus']) && $resInfo['result']['studentStatus'] == '01'){
                        $price = 4700;
                    }
                    if (isset($resInfo['result']['studentStatus']) && $resInfo['result']['studentStatus'] == '03') {
                        $price = 4700;
                    }
                }else{
                    $price = 7040;
                }
                $isBuy = $this->isBuyedCourse($user_id);
                if($isBuy){
                    $price = 4700;
                }
            }else{
                $price = 7040;
            }
//            $price = 0.01;

            if($c_id == 58){
                $stageArr = [1=>30,2=>160,3=>165];
                $buyNum = $stageArr[$stage] - Order::where('course_class_id',58)->where('state',1)->where('stage',$stage)->select('id')->count();
                if($buyNum <= 0){
                    return $this->getMessage(1,'该期课程报名已满');
                }
            }elseif($c_id == 70){
                $stageArr = [1=>36,2=>36];
                $priceArr = [1=>4800,2=>5600];
                $buyNum = $stageArr[$stage] - Order::where('course_class_id',$c_id)->where('state',1)->where('stage',$stage)->select('id')->count();
                if($buyNum <= 0){
                    return $this->getMessage(1,'该期课程报名已满');
                }
                $price = $priceArr[$stage];
            }elseif($c_id = 71){
                $stageArr = [1=>25,2=>50];
                $buyNum = $stageArr[$stage] - Order::where('course_class_id',$c_id)->where('state',1)->where('stage',$stage)->select('id')->count();
                if($buyNum <= 0){
                    return $this->getMessage(1,'该期课程报名已满');
                }
            }
            $payPrice = $price;
            if($old_order){
                if($old_order->state==0){
                    $oNumber = $old_order->number;
                    $old_order->price = $payPrice;
                    $old_order->dis_id = $fission_id;
                    $old_order->type  = 1;
                    $old_order->stage  = $stage;

                    $old_order->save();
                }else{
                    echo json_encode(['code'=>0, 'msg'=>'您已购买请联系客服']);
                    return;
                }
            }else{
                $oNumber = date("YmdHis").rand(1000,9999);
                $order->number  = $oNumber;
                $order->user_id = $user_id;
                $order->price   = $payPrice;
                $order->dis_id = $fission_id;
                $order->type  = 1;
                $order->stage  = $stage;
                $order->course_class_id = $c_id;
                $order->course_class_title = $course_class[0]->title;
                $order->save();
            }
            $video_id = DB::table("course")->where("course_class_id", $c_id)->select("id")->first();
            $wxConfig = new \WxPayConfig();
            $userip = get_ip();                          //获得用户设备IP 自己网上百度去
            $appid  = $wxConfig->GetAppId();             //微信给的
            $mch_id = $wxConfig->GetMerchantId();        //微信官方的x
            $key    = $wxConfig->GetKey();               //自己设置的微信商家key
            $out_trade_no = $oNumber;                    //平台内部订单号
            $nonce_str    = MD5($out_trade_no);          //随机字符串
            $body         = $course_class[0]->title;     //内容
            $total_fee    = $course_class[0]->price*100; //金额
            $spbill_create_ip = $userip;                 //IP
            $notify_url   = "http://m.saipubbs.com/activeCourse/notifyh"; //回调地址
            if($course_class[0]->course_type == 0){
                $redirect_url = urlencode("http://m.saipubbs.com/course/middle/{$c_id}/{$video_id->id}");     //支付成功后跳转页面
            }else{
                $redirect_url = urlencode("http://m.saipubbs.com/activeCourse/addUserInfo/{$c_id}.html");     //支付成功后跳转页面
            }
//            $redirect_url = urlencode("http://m.saipubbs.com/course/middle/{$c_id}/{$video_id->id}");     //支付成功后跳转页面
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
        $order  = new Order();     //订单模型
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
                $item    = $order->where("number",$number)->where("state", 0)->first();
                if($item){
                    $item->state = 1;
                    $item->payfrom = $payfrom;
                    $item->save();        //将订单状态改为1  支付成功


                    //操作客户账户资金信息
                    $finance_a = new FinanceAccount();
                    $finance_a->addOne($item->user_id);                           //查看用户资金账户，如果没有创建一条

                    $CourseClassPush = new CourseClassPush();
                    $CourseClassPush->addOne($item->user_id, $item->course_class_id);            //默认接收课程提醒
                    add_finance_record($item->price,"BUY", $item->user_id, $payfrom, $item->course_class_id);   //支付成功后记录流水记录

                    //记录导师账户资金信息
                    $course_class = DB::table("course_class")
                        ->where("id",$item->course_class_id)
                        ->select("user_id",'title','push_message','id','explain_url')
                        ->get();
                    $author_id   = $course_class[0]->user_id;
                    $finance_a->addOne($author_id);
                    add_finance_record($item->price,"ADD", $author_id, $payfrom, $item->course_class_id);   //支付成功后记录流水记录
                    DB::table("finance_accounts")->where("user_id", '=', $author_id)->increment("total", $item->price);
                    //购买成功写入消息通知
                    $user = DB::table("users")->where("id",$item->user_id)->select("name","avatar", "openid")->get();
                    add_message($author_id,$item->user_id, $user[0]->name, $user[0]->avatar,$item->course_class_title, "BUY");

                    $data['openid'] = $user[0]->openid;
                    $data['type'] = CustomerPushType::IMAGE;

                    $author = Users::where('id',$author_id)->select('name')->first();

                    $title = "【购买成功】".$course_class[0]->title;
                    $desc = $author->name."[导师系列课]：\n".$course_class[0]->push_message."\n点击进入即可查看系列课内容\n回复[TD".$course_class[0]->id."]不再接收该导师系列课推送";
                    $data['list'] = [[
                        "title"=>$title,
                        "description"=>$desc,
                        "url"=>env('APP_URL').'/course/detail/'.$item->course_class_id.".html",
                        "picurl"=>'http://image.saipubbs.com/'.$course_class[0]->explain_url]];
                    if($course_class[0]->push_message) {
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

    //测试获取openid
    public function getOpenid(){
        $tools  = new \JsApiPay();
        $openId = $tools->GetOpenid();
        $wxPush = new WxPush();
        $token  = $wxPush->getToken();
        $str1   = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=$token&openid=$openId&lang=zh_CN");
        $wx_user= json_decode($str1, true);
        return $wx_user['subscribe'];
    }

    //测试微信推送消息
    public function wxPush(){

        $result = $this->getOpenid();
        print_r($result);
    }

    //课程详情页面在线咨询20180821
    public function consultation(Request $request,$c_c_id){
        //$c_c_id = $request->input("course_class_id");
        $wechat_number = "";
        $targets       = "";
        if($request->input("wechat_number")){
            $wechat_number = $request->input("wechat_number");   //微信号
        }
        if($request->input("targets")){
            $targets = $request->input("targets");               //学习目标
        }

        if($wechat_number && $targets && $c_c_id){
            $consultation = new Consultation();
            $consultation->course_class_id  = $c_c_id;
            $consultation->targets          = trim($targets, ",");
            $consultation->wechat_number    = $wechat_number;
            $r = $consultation->save();
            if($r){
                echo json_encode(['code'=>1, 'msg'=>"添加成功，稍后老师会和您联系"]);
            }else{
                echo json_encode(['code'=>0, 'msg'=>"添加成功，稍后老师会和您联系"]);
            }
        }else{
            $this->ret['c_c_id'] = $c_c_id;
            return view("course.weixinqun", $this->ret);
            //return view("course.consultation", $this->ret);
        }

    }

    //课程邀请卡
    public function detailCard(Request $request,$id){

        return view("course.detailcard");
    }

    public function doImage(){
        $ImageThumb  = new ImageThumb();
        $img_url     = $ImageThumb->makePic("/base20180911.jpg", "qr.jpg");
        echo "<img src='/".$img_url[1]."' />";
    }

    public function captureArticle(Request $request){
        $user = $request->user();
        $url = $request->input('url','');
        $tags = $request->input('tags','');
        $tags = trim($tags, ",");

        $pattern = '/<title>(.*?)<\/title>/';
        $articlePattern = '/<h1.*?>([\s\S]*?)<([\s\S]*?)\/h1>/';
        $encodePattern = '/charset=(.*?)[\/]*>/';
        $curl = new CurlUtil();
        $result = $curl->curl($url,'','GET');
        preg_match($encodePattern,$result,$char);
        if(!empty($char) && $char[1] != '' && strpos($char[1],'gb') !== false){
            return ['code'=>1,'msg'=>'获取资源失败'];
//            $result = $curl->curl('https://www.sohu.com/a/126857149_500718','','GET','gbk');
        }

        preg_match($pattern,$result,$title);
        preg_match($articlePattern,$result,$artitcleTitle);

        if(empty($title)){
            return ['code'=>1,'msg'=>'获取标题失败'];
        }
        if(!empty($artitcleTitle)){
            $artTitle = $artitcleTitle[1];
        }else{
            $artTitle = '';
        }
        if(!empty($artTitle)){
            if(strpos($title[1],$artTitle) !== false){
                $newTitle = $artTitle;
            }else{
                $newTitle = explode('_',$title[1])[0];
                if($newTitle == $title[1]){
                    $newTitle = explode('|',$title[1])[0];
                }
            }
        }else{
            $newTitle = explode('_',$title[1])[0];
            if($newTitle == $title[1]){
                $newTitle = explode('|',$title[1])[0];
            }
        }

        $recommend = new ArticleRecommend();
        $recommend->user_id = $user->id;
        $recommend->title = $newTitle;
        $recommend->url = $url;
        $recommend->user_id = $user->id;
        $recommend->tag_ids = $tags;
        if($recommend->save()){
            return ['code'=>0,'msg'=>'推荐成功',"id"=>$recommend->id];
        }else{
            return ['code'=>1,'msg'=>'推荐失败'];
        }
    }

    //20181105
    public function coursePlay(Request $request){

        $c_c_id   = $request->input("c_c_id");
        $video_id = $request->input("video_id");

        if(Redis::exists("course_".$c_c_id."_".$video_id) && Redis::get("course_".$c_c_id."_".$video_id) != ''){
            $json    = Redis::incr("course_".$c_c_id."_".$video_id);
        }else{
            Redis::setex("course_".$c_c_id."_".$video_id, 60*60*24, 1);
        }

    }

    //20181105  定时处理redis存储课程及视频播放次数
    public function coursePlayEmpty(){
        $date = date("Ymd");
        if(Redis::keys("course_*") && Redis::keys("course_*") != ''){
            $json    = Redis::keys("course_*");
            foreach($json as $v){
                echo $v."=>".Redis::get($v)."<br/>";
                // $arr = explode("_", $v);
                // $data = array();
                // $data['course_id'] = $arr[2];         //单独视频id
                // $data['course_class_id'] = $arr[1];   //课程id
                // $data['date'] = $date;
                // $data['number'] = Redis::get($v);
                // $data['created_at'] = date("Y-m-d H:i:s");
                // DB::table("course_play_number")->insert($data);
                // empty($arr);
                // empty($data);
                // Redis::del($v);
            }
        }
    }

    /*
     *
     * 注册弹框课程设置
     */
    public function sendCourse(Request $request){

        $courseClass = Courseclass::where('register_free_watch',1)->whereNull('deleted_at')->take(3)->get();
//        dd($courseClass);
        $res = $this->getCourseList($courseClass);
        return $this->getMessage(0,'获取成功',['freeCourse'=>$res]);
    }

    public function getCourseList($courseClass){
        $str = '<div class="zhucelingqu_layer fz"><div class="plr30"><img src="/images/tanchu/liwuhe.png"class="liwuhe"/><dl><dt class="f36 bold">Hi~</dt>
<dd class="f26 bold">欢迎来到赛普健身社区，赛普君送你好课3套~</dd></dl><ul class="list_kecheng">';
        foreach($courseClass as $class) {
//            dd($class);
            if($class->is_free == 0){
                $priceSet = '免费';
            }else{
                $priceSet = $class->price.'元';
            }
            $pic = env('IMG_URL').$class->cover_url;
            $str .= '<li><a href="#" class="thumb"><img src="'.$pic.'" alt="">
            <span>'.($class->courseType->title).'</span></a><div class="con"><h3 class="title text-overflow f26 mb20 bold"><a href="#">'.$class->title.'</a></h3><div class="clearfix wrap"><h4 class="classes fl color_gray666">'.(sum_course($class->id)->count).'节课-'.(sum_study($class->id)->count).'人正在提高中</h4><span class="price fr color_red bold f26">'.$priceSet.'</span></div><div class="clearfix wrap1"><div class="swiper-container tags fl"><div class="swiper-wrapper">';

            $courseTags = $class->courseTag;

            foreach($courseTags as $tags){
                $tag = Tags::where('id',$tags->tag_id)->select('title')->first();
                $str .= '<div class="swiper-slide"><a href="#"><span>'.($tag->title).'</span></a></div>';
            }
            $str .= '</div></div><span class="daoshi fr"><span>'.($class->author->name).'导师</span></span></div></div></li>';
        }

        $str .= '</ul>
        <div class="btns clearfix bold"><a href="javascript:void(0)"class="btn2 fl btn_fangqi">狠心放弃</a><a href="/register"class="btn1 fr">注册领取</a></div></div></div>';

        return $str;

    }

    //修改之后全部课程分类详情页
    public function ctypeDetail($id= 0,$cid= 0){

        if(Redis::exists("cache_course_type_".$cid) && Redis::get("cache_course_type_".$cid) != ''){
            $course_type_id = Redis::get("cache_course_type_".$cid);
        }else{
            $course_type_id = 2;
        }
        //dd($course_type_id );
        //$course_type_id = 1;
        if($course_type_id == 1 || $course_type_id ==2){
            $course = new Courseclass();
            $data = $course->getTypeData($id,$cid);
            $typeName = CourseType::where("id",$id)->select("title","description")->first();

            $this->ret['type'] = $data['type'];
            $this->ret['new'] =$course->getTwoRecommend($id,$cid); //end($data['newData']);
            $this->ret['data'] = $data['data'];
            $this->ret['cid'] = $data['cid'];
            $this->ret['id'] = $id;
            $this->ret['img'] = $data['img'];
            //dd($data);
            $this->ret['title'] = $typeName->title;
            $this->ret['description'] = $typeName->description;
            //dd($course_type_id);
            if($course_type_id == 2){
                return view("course_new.index",$this->ret);
            }else{
                Redis::set("cache_course_type_".$cid, 0);
                file_put_contents(resource_path().'/views/cache/course_index'.$id.'_'.$cid.'.blade.php',view("course_new.index",$this->ret)->__toString());
                return view("cache.course_index".$id.'_'.$cid,$this->ret);
            }
        }else{
            return view("cache.course_index".$id.'_'.$cid,$this->ret);
        }



    }

    public function courseAll($tagid=0,Request $request){
        if(Redis::exists("cache_course_type_".$tagid) && Redis::get("cache_course_type_".$tagid) != ''){
            $course_type_id = Redis::get("cache_course_type_".$tagid);
        }else{
            $course_type_id = 2;
        }
        if($course_type_id == 1 || $course_type_id ==2){
            $page   = $request->input('page');
            if(empty($page)){
                $page = 1;
            }

            $offset = 5*($page-1);
            $tags = CourseType::where("pid",0)->select("id","title","cover_url")->whereNull("deleted_at")->where("state",1)->get();
            if($tagid == 0){
                $tagid = $tags[0]->id;
            }
            $typeName = CourseType::where("id",$tagid)->select("title")->first();
            $course = new Courseclass();
            $data = $course->getTagData1($tagid,$offset);
            $recommend =$course->getRecommend($tagid);
            // dd($data);
            $this->ret['tags'] = $tags;
            $this->ret['tagid'] = $tagid;
            $this->ret['data'] = $data;
            $this->ret['new'] = $recommend;
            $this->ret['title'] = $typeName->title;

            if($course_type_id == 2){
                return view("course_new.courseAll",$this->ret);
            }else{
                Redis::set("cache_course_type_".$tagid, 0);
                file_put_contents(resource_path().'/views/cache/course_all'.$tagid.'.blade.php',view("course_new.courseAll",$this->ret)->__toString());
                return view("cache.course_all".$tagid,$this->ret);
            }

        }else{
            return view("cache.course_all".$tagid,$this->ret);
        }
    }
    public function getCourseJson($tagid,$page){

        $offset = 5*($page-1);
        $course = new Courseclass();
        $data = $course->getTagData1($tagid,$offset);
        foreach($data as $v){
            $v->sum_course = sum_course($v->id)->count;
            $v->sum_study = sum_study($v->id)->count + $v->count;
            $v->teacher_name = get_teacher_name($v->user_id)->name;
        }
        return json_encode($data);

    }

    //20190116 全部活动页
    public function activityAll(){

        //最新活动
        $activity = DB::table("activity")->orderBy("state", "desc")->orderBy("orderby", "desc")->limit(10)->get();
        $this->ret['activity'] = $activity;
        return view("course.allactivity", $this->ret);
    }

    /*
     * 是否存在优惠券
     */
    private function couponCard($user_id,$course_id=0 ,$group_id=0){
        $coupon = Coupon::where('course_class_id',$course_id)->first();//优惠券
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

    public function addUserInfo(Request $request,$id){
        $user = $request->user();
        $fid = $request->input('fid','0');
        $introUserInfo = '';
        if($user){
            $introUserInfo = IntroActiveUser::where('course_class_id',$id)->where('user_id',$user->id)->first();
        }
        if($introUserInfo){
            $userInfo  = json_decode($introUserInfo->user_info);
        }else{
            $userInfo = '';
        }
        return view('course.activeUserInfo',['id'=>$id,'fid'=>$fid,'userInfo'=>$userInfo]);
    }

    public function createUserInfo(Request $request){
        $dataInfo = $request->all();
        unset($dataInfo['_token']);
        unset($dataInfo['_url']);

        $user = $request->user();
        if(!$user){
            return $this->getMessage(1,'用户未登陆');
        }
        $introUser = IntroActiveUser::where('user_id',$user->id)->where("course_class_id", $request->input("course_class_id"))->first();
        if(!$introUser){
            $introUser = new IntroActiveUser();
        }
        $introUser->user_id = $user->id;
        $introUser->user_info = json_encode($dataInfo);
        $introUser->course_class_id = $request->input("course_class_id");
        if($introUser->save()){
            return $this->getMessage(0,'提交成功');
        }else{
            return $this->getMessage(1,'提交失败');
        }
    }

    /*
     * 获课活动列表
     */
    public function freeCourse(Request $request){

        $user = $request->user();
        $user_id = 0;
        if($user){
            $user_id = $user->id;
        }
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();
        }
        $data['user_id'] = $user_id;
        return view('a.freeCourse',$data);
    }
    /*
     * doit调查送课
     */
    public function freeDoCourse(Request $request){
        $user = $request->user();
        $user_id = 0;
        if($user){
            $user_id = $user->id;
        }
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();
        }
        $user = $request->user();
        $introUser = IntroActiveUser::where('user_id',$user_id)->where('type','DOITFEEDBACK')->select('id')->first();
        $is_send = 0;
        if($introUser){
            $is_send = 1;
        }
        $data['user_id'] = $user_id;
        $data['is_send'] = $is_send;
        return view('a.freeDoCourse',$data);
    }

    /*
     * 判断用户获课信息
     */
    public function getFreeCourse(Request $request){
        $id = $request->input('id');
        $user = $request->user();
        if(!$user){
            return $this->getMessage(5,'用户未登录');
        }

//        $studying = Studying::where('course_class_id',$id)->where('user_id',$user->id)->first();
//
//        if($studying){
//
//            $courseAcitveSpb = CourseActivitySpbRecord::where('user_id',$user->id)->where('course_class_id',$id)->first();
//            if(!$courseAcitveSpb){
//
//                $data['code'] = 1;
//                $data['cid']  = $id;
//                $content = $this->getContent($data);
//                $info['openid'] = $user->openid;
//                $info['type']   = 'TEXT';
//                $info['text']   = "您已经拥有该课程，无法重复领取，特补贴1000赛普币，<a href='http://m.saipubbs.com/course/access.html"."'>点击领取</a>吧～";
//                if(env("IS_LOCAL") == false){
//                    event(new WxCustomerMessagePush($info));
//                }
//                return $this->getMessage(1,'已有该课程',['content'=>$content]);
//            }else{
//                $data['code'] = 2;
//                $content = $this->getContent($data);
//                return $this->getMessage(2,'已赠赛普币',['content'=>$content]);
//            }
//        }
//
//        $courseUser = CourseActivityUser::where('course_class_id',$id)->where('user_id',$user->id)->first();
//
//        if($courseUser){
//            $data['code'] = 3;
//            $content = $this->getMessage($data);
//            return $this->getMessage(3,'课程已领取',['content'=>$content]);
//        }
//
//        $courseActiveUser = CourseActivityUser::where('user_id',$user->id)->where('finished',0)->select('course_class_id')->first();
//
//        if($courseActiveUser){
//            $courseClass = CourseClass::where('id',$courseActiveUser->course_class_id)->select('id','title')->first();
//            $video = Course::where('course_class_id',$courseClass->id)->where('state',1)->first();
//            $data['vid'] = $video->id;
//            $data['title'] = $courseClass->title;
//            $data['id'] = $courseClass->id;
//            $data['code'] = 4;
//            $content = $this->getContent($data);
//            return $this->getMessage(4,'上个领取课程未完成',['content'=>$content]);
//        }
//
        return $this->getMessage(0,'请求成功');
    }

    public function videoFinish(Request $request){

        $c_id   = $request->input("c_c_id");
        $video_id = $request->input("video_id");
        $user = $request->user();

        if($user){
            $courseUser = CourseActivityUser::where('user_id',$user->id)->where('course_class_id',$c_id)->first();
//            if($courseUser){
//                return $this->getMessage(0,'结束观看');
//            }
            $courseView = CourseActivityView::where('course_class_id',$c_id)->where('course_id',$video_id)->where('user_id',$user->id)->where('finished',0)->first();
            if($courseView){
                $courseView->finished = 1;
                $courseView->save();

                $courseView = CourseActivityView::where('course_class_id',$c_id)->where('user_id',$user->id)->where('finished',0)->select('id')->first();
                if(!$courseView){
                    if($courseUser){
                        $courseUser->finished = 1;
                        $courseUser->save();

                        $courseClass = CourseClass::where('id',$c_id)->select('title')->first();
                        $courseCount = CourseActivityUser::where('user_id',$user->id)->select('id')->count();
                        $rest = 6 - $courseCount;
                        $data['openid'] = $user->openid;
                        $data['type'] = 'TEXT';
                        $data['content'] = '恭喜您！《'.$courseClass->title.'》课程学习已完成！
您已成功领取'.$courseCount.'个课程，还有'.$rest."个课程待领取~\n<a href='http://m.saipubbs.com/course/vid.html'>继续领取</a>";
                        event(new WxCustomerMessagePush($data));
                    }
                }
            }else {
                $courseView = CourseActivityView::where('course_class_id',$c_id)->where('course_id',$video_id)->where('user_id',$user->id)->where('finished',1)->first();
                if(!$courseView){
                    $courseView = new CourseActivityView();
                    $courseView->course_class_id = $c_id;
                    $courseView->course_id = $video_id;
                    $courseView->finished = 1;
                    $courseView->user_id = $user->id;
                    $courseView->save();
                }
            }
        }
        return $this->getMessage(0,'观看完成');
    }

    public function sendSpb(Request $request){
        $user = $request->user();
        $cid = $request->input('cid');
        $courseSpbRecord = CourseActivitySpbRecord::where('user_id',$user->id)->where('course_class_id',$cid)->first();

        if(!$courseSpbRecord){
            $user->spb += 1000;
            $user->save();
            $courseAcitveSpb = new CourseActivitySpbRecord();
            $courseAcitveSpb->user_id = $user->id;
            $courseAcitveSpb->course_class_id = $cid;
            $courseAcitveSpb->spb = 1000;
            $courseAcitveSpb->save();
            $info['openid'] = $user->openid;
            $info['type']   = 'TEXT';
//            $courseClass = CourseClass::where('id',$cid)->select('title')->first();

            $info['text']   = "1000赛普币已到账，快点<a href='http://m.saipubbs.com/course/access.html"."'>领取其他课程</a>吧~";
            if(env("IS_LOCAL") == false){
                event(new WxCustomerMessagePush($info));
            }
        }

        return $this->getMessage(0,'赠送成功');
    }

    public function getContent($data){
        if($data['code'] == 1){
            $content = '<div class="jump jump3"><div class="text_center pt115"><p class="fz f28 color_gray666 mb30">您已经拥有该课程</p><p class="f40 color_333 lt pb70">奉上1000赛普币<br>请您笑纳</p><button class="bgcolor_orange fz f28 color_000 border-radius-img" onclick="getSpbCoin(this);" data-id="'.$data['cid'].'">领取赛普币</button><p class="fz f20 color_gray999 plr65 pt40 text_left line1">提示：您可以继续领取其他课程</p></div></div>';

        }elseif($data['code'] == 2){
            $content = '<div class="jump jump3"><div class="text_center pt115"><p class="fz f28 color_gray666 mb30">您已经拥有该课程</p><p class="f40 color_333 lt pb70">已赠送1000赛普币</p></div>';
        }elseif($data['code'] == 3){

            $content = '<div class="jump jump3"><div class="text_center pt115"><p class="fz f28 color_gray666 mb30">您已领取该课程</p><p class="fz f20 color_gray999 plr65 pt40 text_left line1">提示：您可以继续领取其他课程</p></div></div>';
        }elseif($data['code'] == 4){
            $content = '<div class="jump jump4"><div class="text_center pt115"><p class="f40 color_333 lt mb30">不要贪心哟</p><p class="fz f28 color_gray666 pb70 plr30 line1 text_left">《'.$data['title'].'》学习 没有完成不能领取下一个课程</p><button data-id="'.$data['id'].'" data-vid="'.$data['vid'].'" onclick="courseStudy(this);" class="bgcolor_orange fz f28 color_000 border-radius-img">前往学习</button><p class="fz f20 color_gray999 plr65 pt40 text_left line1">提示：该课程学习进度为100%时，方可 领取下一个课程</p></div></div>';
        }

        return $content;
    }
}