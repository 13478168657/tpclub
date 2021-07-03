<?php

namespace App\Http\Controllers\A;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\CourseOrder;
use App\Models\FinanceAccount;
use App\Models\Paylog;
use App\Models\Users;
use App\Events\WxCustomerMessagePush;
use App\Constant\CustomerPushType;
use App\Constant\WxMessageType;
use App\Events\WxMessagePush;
use Illuminate\Support\Facades\DB;
require app_path().'/Library/Wechat/WxPay.JsApiPay.php';
class BaomingController extends  Controller
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
        $c_id   = $request->input("class_id",60);  // 课程id
        $fission_id = $request->input('fission_id','0');//分享人用户id
        $user_id = $request->user()->id;
        $mobile = $request->user()->mobile;
        $time = $request->input('time',1);
        $city = $request->input('city',1);
        $stage = $time.$city;
        $price = 2800;
        $order   = Order::where('user_id',$user_id)->where('state',1)->where('course_class_id',$c_id)->first();

        if(!$order){

            return ['code'=>1,'message'=>'未报名ACSM课程'];
        }

        $course_class = DB::table("course_class")->where("id",$c_id)->select("id","title","price")->first();

        $courseOrder = CourseOrder::where("user_id",$user_id)->where("course_class_id",$c_id)->first();

//        $price = 0.01;

        $payPrice = $price;
        if($courseOrder){
            if($courseOrder->state == 0){
                $oNumber = $courseOrder->number;
                $courseOrder->price = $payPrice;
//                $courseOrder->dis_id = $fission_id;
                $courseOrder->save();
            }else{
                return ['code'=>1,'message'=>'您已交报名费'];
            }
        }else{
            $courseOrder = new CourseOrder();
            $oNumber = date("YmdHis").rand(1000,9999);
            $courseOrder->number  = $oNumber;
            $courseOrder->user_id = $user_id;
            $courseOrder->price   = $payPrice;
            $courseOrder->order_id   = $order->id;
//            $order->dis_id = $fission_id;
//            $order->stage = $stage;
//            $order->type = 1;
            $courseOrder->course_class_id = $c_id;
//            $order->course_class_title = $course_class->title;
            $courseOrder->save();
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
        $input->SetNotify_url("http://m.saipubbs.com/unline/exam/notify");
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
        $order  = new CourseOrder();     //订单模型
        $pay_log->info   = $json_d;
        $pay_log->c_time = $time;
        $payfrom = "WXPAY";
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
                    $pay_log->state = 1;
                    $pay_log->save();     //记录正常支付日志

                    //操作客户账户资金信息
                    $finance_a = new FinanceAccount();
                    $finance_a->addOne($item->user_id);                           //查看用户资金账户，如果没有创建一条

                    add_finance_record($item->price,"BUY", $item->user_id, $payfrom, $item->course_class_id);   //支付成功后记录流水记录

                    //记录导师账户资金信息
                    $course_class = DB::table("course_class")
                        ->where("id",$item->course_class_id)
                        ->select("user_id",'explain_url','push_message',"title","id")
                        ->first();
                    $author_id   = $course_class->user_id;
                    $finance_a->addOne($author_id);
//                    add_finance_record($item->price,"ADD", $author_id, $payfrom, $item->course_class_id);   //支付成功后记录流水记录
//                    DB::table("finance_accounts")->where("user_id", '=', $author_id)->increment("total", $item->price);
                    //购买成功写入消息通知
                    $user = DB::table("users")->where("id",$item->user_id)->select("name","avatar","openid")->first();
                    add_message($author_id,$item->user_id, $user->name, $user->avatar,$item->course_class_title, "BUY");

//                    courseSpb($item->user_id,6,$item->course_class_id,$item->price);   //记录赛普币


//                    $data['type'] = CustomerPushType::IMAGE;

//                    $author = Users::where('id',$author_id)->select('name')->first();
                    $data['openid'] = $user->openid;
                    $data['type'] = 'TEXT';
//                    $stageInfo = $this->getStagePeriod($item->stage);
                    $data['text'] = "恭喜您，报名成功！\n课程名称：《ACSM中文CPT认证课程》\n课程班期：所在校区：开班前3天，会有班主任联系您处理开班事宜，请耐心等待~";
//                    event(new WxCustomerMessagePush($data));

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
        $c_id   = $request->input("course_class_id",60);  // 课程id
        $fission_id = $request->input('fission_id','0');//分销员id

        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }

        $order   = Order::where('user_id',$user_id)->where('state',1)->where('course_class_id',$c_id)->first();

        if(!$order){

            return ['code'=>1,'message'=>'未报名ACSM课程'];
        }

        if($user_id && $c_id){

            $course_class = DB::table("course_class")->where("id",$c_id)->select("id","title","price",'course_type')->first();
            $courseOrder = CourseOrder::where("user_id",$user_id)->where("course_class_id",$c_id)->first();
            $mobile = $request->user()->mobile;

//            $price = $this->getAcsmPrice($c_id,$request->user());
            $price = 2800;
//            $price = 0.01;
            $payPrice = $price;
//            $stageArr = [1=>30,2=>160,3=>165];
//            if($c_id == 58){
//                $buyNum = $stageArr[$stage] - Order::where('course_class_id',58)->where('state',1)->where('stage',$stage)->select('id')->count();
//                if($buyNum <= 0){
//                    return $this->getMessage(1,'该期课程报名已满');
//                }
//            }
            if($courseOrder){
                if($courseOrder->state==0){
                    $oNumber = $courseOrder->number;
                    $courseOrder->price = $payPrice;
//                    $courseOrder->dis_id = $fission_id;
//                    $old_order->type  = 1;
//                    $old_order->stage  = $stage;
                    $courseOrder->save();
                }else{
                    echo json_encode(['code'=>1, 'msg'=>'您已购买请联系客服']);
                    return;
                }
            }else{
                $courseOrder   = new CourseOrder();     //订单模型
                $oNumber = date("YmdHis").rand(1000,9999);
                $courseOrder->number  = $oNumber;
                $courseOrder->user_id = $user_id;
                $courseOrder->price   = $payPrice;
                $courseOrder->order_id   = $order->id;
//                $courseOrder->dis_id = $fission_id;
//                $courseOrder->type  = 1;
//                $courseOrder->stage  = $stage;
                $courseOrder->course_class_id = $c_id;
//                $courseOrder->course_class_title = $course_class[0]->title;
                $courseOrder->save();
            }
//            $video_id = DB::table("course")->where("course_class_id", $c_id)->select("id")->first();
            $wxConfig = new \WxPayConfig();
            $userip = get_ip();                          //获得用户设备IP 自己网上百度去
            $appid  = $wxConfig->GetAppId();             //微信给的
            $mch_id = $wxConfig->GetMerchantId();        //微信官方的x
            $key    = $wxConfig->GetKey();               //自己设置的微信商家key
            $out_trade_no = $oNumber;                    //平台内部订单号
            $nonce_str    = MD5($out_trade_no);          //随机字符串
            $body         = $course_class->title;     //内容
            $total_fee    = $course_class->price*100; //金额
            $spbill_create_ip = $userip;                 //IP
            $notify_url   = "http://m.saipubbs.com/unline/exam/notifyh"; //回调地址
//            if($course_class[0]->course_type == 0){
            $redirect_url = urlencode("http://m.saipubbs.com/dist/buy/bm{$c_id}.html");     //支付成功后跳转页面
//            }else{
//                $redirect_url = urlencode("http://m.saipubbs.com/activeCourse/addUserInfo/{$c_id}.html");     //支付成功后跳转页面
//            }
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
            echo json_encode(['code'=>0, 'objectxml'=>$objectxml]);
            return;
        }else{
            echo json_encode(['code'=>1, 'msg'=>'抱歉没有数据了']);
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
        $courseOrder  = new CourseOrder();     //订单模型
        $pay_log->info   = $json_d;
        $pay_log->c_time = $time;
        //开启事务
        DB::beginTransaction();
        try{
            if($result['return_code']=='SUCCESS'){
                $number = $result['out_trade_no'];
                $item    = $courseOrder->where("number",$number)->where("state", 0)->first();
                if($item){
                    $item->state = 1;
                    $item->payfrom = $payfrom;
                    $item->save();        //将订单状态改为1  支付成功
                    $pay_log->state = 2;
                    $pay_log->save();     //记录正常支付日志

                    //操作客户账户资金信息
                    $finance_a = new FinanceAccount();
                    $finance_a->addOne($item->user_id);                           //查看用户资金账户，如果没有创建一条

//                    $CourseClassPush = new CourseClassPush();
//                    $CourseClassPush->addOne($item->user_id, $item->course_class_id);            //默认接收课程提醒
                    add_finance_record($item->price,"BUY", $item->user_id, $payfrom, $item->course_class_id);   //支付成功后记录流水记录

                    //记录导师账户资金信息
                    $course_class = DB::table("course_class")
                        ->where("id",$item->course_class_id)
                        ->select("user_id",'title','push_message','id','explain_url')
                        ->first();
                    $author_id   = $course_class->user_id;
                    $finance_a->addOne($author_id);
//                    add_finance_record($item->price,"BAOMING", $author_id, $payfrom, $item->course_class_id);   //支付成功后记录流水记录
//                    DB::table("finance_accounts")->where("user_id", '=', $author_id)->increment("total", $item->price);
                    //购买成功写入消息通知
                    $user = DB::table("users")->where("id",$item->user_id)->select("name","avatar", "openid")->first();
                    add_message($author_id,$item->user_id, $user->name, $user->avatar,$item->course_class_title, "BUY");

//                    $data['openid'] = $user[0]->openid;
//                    $data['type'] = CustomerPushType::IMAGE;

//                    $author = Users::where('id',$author_id)->select('name')->first();
                    $data['openid'] = $user->openid;
                    $data['type'] = 'TEXT';
                    $data['text'] = "恭喜您，报名成功！\n课程名称：《ACSM中文CPT认证课程》\n课程班期：开班前3天，会有班主任联系您处理开班事宜，请耐心等待~";
//                    event(new WxCustomerMessagePush($data));

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


}
