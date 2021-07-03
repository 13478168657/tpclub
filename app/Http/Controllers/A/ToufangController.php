<?php

namespace App\Http\Controllers\A;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TfOrder;
use App\Models\TfCourseClass;
use App\Models\TfCount;
use App\Models\TfCountRecord;
use App\Models\IntroActiveUser;
use App\Models\FinanceAccount;
use App\Models\Paylog;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Utils\CurlUtil;
use App\Utils\MakeThumbPic;

use App\Utils\Alidayu;
use Illuminate\Support\Facades\Auth;
require app_path().'/Library/Wechat/WxPay.JsApiPay.php';
class ToufangController extends Controller
{
    //微信jsapi支付接口
    public function pay(Request $request){

        $user = $request->user();
        if($user){
            $user_id = $user->id;
        }else{

            return ["code"=>3,"message"=>'用户未登录'];
        }
        $username = $request->input('username','');
        $phone    = $request->input('phone','');
        $code     = $request->input('code','');
        $tf_class_id = $request->input('tf_class_id','');
        $idcard  = $request->input('idcard','');
        $is_give = $request->input('is_give',0);
//        $mobile_code = Redis::get('code_'.trim($phone));
//        if($code!='656565'){
//            if(empty($code)){
//                return $this->getMessage(1,'请输入有效的验证码');
//            }
//            if($mobile_code != $code){
//                return ["code"=>1,"message"=>'验证码有误或已过期'];
//            }
//        }
        $tfClass = TfCourseClass::where('id',$tf_class_id)->where('state',1)->first();
        $price = $tfClass->team_price;

        $user_id = $request->user()->id;
        $old_order = TfOrder::where('user_id',$user_id)->where('tf_course_class_id',$tfClass->id)->first();

        if($old_order){
            if($old_order->state == 0){
                $oNumber = $old_order->number;
                $old_order->price = $price;
                $old_order->username = $username;
                $old_order->phone    = $phone;
                $old_order->idcard   = $idcard;
                $old_order->is_give  = $is_give;
                $old_order->save(); //更新期数
            }else{
                return ["code"=>1,"message"=>'您已购买请联系客服'];
            }
        }else{
            $order = new TfOrder();
            $oNumber = date("YmdHis").rand(1000,9999);
            $order->number  = $oNumber;
            $order->user_id = $user_id;
            $order->price   = $price;
            $order->username = $username;
            $order->phone    = $phone;
            $order->idcard   = $idcard;
            $order->is_give  = $is_give;
            $order->tf_title = $tfClass->title;
            $order->tf_course_class_id = $tfClass->id;
            $order->save();
        }

        //②、统一下单
        $tools = new \JsApiPay();
        $openId = $request->user()->openid;
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($tfClass->title);             //课程标题
        $input->SetAttach($oNumber);                          //订单号
        $input->SetOut_trade_no("sdkphp".date("YmdHis"));
        $input->SetTotal_fee($price*100);    //订单金额

        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://m.saipubbs.com/tf/notify");

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
        $order = new TfOrder();     //订单模型
        $pay_log->info   = $json_d;
        $pay_log->c_time = $time;
        $pay_log->state = 1;
        $pay_log->save();     //记录正常支付日志

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
                    $item->payfrom =  $payfrom;
                    $item->price   = $result['total_fee']/100;
                    $item->date   = date('Y-m-d');
                    $item->transaction_id = $result['transaction_id'];//订单流水号
                    $item->save();        //将订单状态改为1  支付成功

//                    $sendUser = User::where('id',$item->user_id)->select('openid')->first();
//                    //推送消息
//                    $data['openid'] = $sendUser->openid;
//                    $data['type'] = 'TEXT';
//                    $stageInfo = [4=>'11月14日',5=>'11月14日'];
//
//                    $content = "恭喜您，报名成功！\n\n[1]减脂教练核心能力养成营\n报名期数：第".$item->jz_stage."期\n开班日期：".$stageInfo[$item->jz_stage]."\n[2]产后实战精英私教训练营\n报名期数：第12期\n开班日期：11月21日\n\n————————\n开班前，您可以<a href='http://m.saipubbs.com/user/studying'>进入我的课表</a>，预习视频课程~\n开班后，班主任将组建微信班级群，导师全程提供群内教学服务~\n\n扫描二维码，添加班主任微信↓↓↓";
//                    $data['text'] = $content;
//                    event(new WxCustomerMessagePush($data));
                }
            }else{
                $pay_log->state = 0;
                $pay_log->save();         //记录有问题支付日志
            }
            DB::commit();
        }catch(\Exception $e){
            logger()->info($e->getMessage().'---所在行---'.$e->getLine());
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
        
        $username = $request->input('username','');
        $phone = $request->input('phone','');
        $code = $request->input('code','');
        $tf_class_id = $request->input('tf_class_id','');
        $idcard  = $request->input('idcard','');
        $is_give = $request->input('is_give',0);
        $remark  = $request->input('remark',0);
        $page_url  = $request->input('page_url','');
        $mobile_code = Redis::get('code_'.trim($phone));
        if($code!='656565'){
           if(empty($code)){
               return $this->getMessage(1,'请输入有效的验证码');
           }
           if($mobile_code != $code){
               return $this->getMessage(1,'验证码有误或已过期');
           }
        }
        $user = User::where('mobile',$phone)->first();
        if(!$user){
            $user = new User();
            $user->mobile = $phone;
            $user->save();
        }
        Auth::loginUsingId($user->id);
        $user_id  = $user->id; 
        $tfClass = TfCourseClass::where('id',$tf_class_id)->where('state',1)->first();
        $price = $tfClass->team_price;
        $old_order = TfOrder::where('user_id',$user_id)->where('tf_course_class_id',$tfClass->id)->first();
        //return json_encode(['code'=>1,'message'=>'您已购买请联系客服'.$user_id]);
        if($user_id){
            if($old_order){
                if($old_order->state == 0){
                    $oNumber = $old_order->number;
                    $old_order->price = $price;
                    $old_order->username = $username;
                    $old_order->phone = $phone;
                    $old_order->idcard   = $idcard;
                    $old_order->is_give  = $is_give;
                    $old_order->save(); //更新期数
                }else{
                    return json_encode(['code'=>2,'message'=>'您已购买请联系客服'.$user->id]);
                }
            }else{
                $order = new TfOrder();
                $oNumber = date("YmdHis").rand(1000,9999);
                $order->number  = $oNumber;
                $order->user_id = $user_id;
                $order->price   = $price;
                $order->username = $username;
                $order->phone    = $phone;
                $order->idcard   = $idcard;
                $order->is_give  = $is_give;
                $order->tf_title = $tfClass->title;
                $order->tf_course_class_id = $tfClass->id;
                $order->remark = $remark;
                $order->page_url = $page_url;
                $order->save();
            }

            $wxConfig = new \WxPayConfig();
            $userip = get_ip();                          //获得用户设备IP 自己网上百度去
            $appid  = $wxConfig->GetAppId();             //微信给的
            $mch_id = $wxConfig->GetMerchantId();        //微信官方的x
            $key    = $wxConfig->GetKey();               //自己设置的微信商家key
            $out_trade_no = $oNumber;                    //平台内部订单号
            $nonce_str    = MD5($out_trade_no);          //随机字符串
            $body         = $tfClass->title;     //内容
            $total_fee    = $price*100; //金额
            $spbill_create_ip = $userip;                 //IP

            $notify_url   = "http://m.saipubbs.com/tf/notifyh"; //回调地址
            $redirect_url = urlencode("http://m.saipubbs.com/line/vote.html?id=".$tfClass->id."&is_pay=1&mobile=".$phone);     //支付成功后跳转页面
            logger()->info($redirect_url);
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
        $order  = new TfOrder();     //订单模型
        $pay_log->info   = $json_d;
        $pay_log->c_time = $time;
        $pay_log->state = 2;
        $pay_log->save();     //记录正常支付日志
        //开启事务
        DB::beginTransaction();
        try{
            if($result['return_code']=='SUCCESS'){
                $number = $result['out_trade_no'];
                $item    = $order->where("number",$number)->where("state", 0)->first();
                logger()->info("支付成功");
                if($item){

                    $item->state = 1;
                    $item->payfrom =  $payfrom;
                    $item->price   = $result['total_fee']/100;
                    $item->date   = date('Y-m-d');
                    $item->transaction_id = $result['transaction_id'];//订单流水号
                    logger()->info($item->phone);
                    $this->sendData($item->phone);
                    $info['name']        = $item->username;
                    $info['mobile1']     = $item->phone;
                    $info['inputTime']   = date("Y-m-d H:i:s");
                    $info['sex']         = "01";
                    $info['sourceType']  = 1;   //1： 表单       2： 赛普健身社区
                    $info['fromUrl']     = "http://m.saipubbs.com/line/vote.html?id=7&utm_source=xmt&utm_medium=douyinpay"; //渠道信息
                    $info['comment']     = $item->remark=='学习健身知识自己练身材,' ? '投放抖音上的大v  大v在视频中引导用户 在评论区 1元 领取《健身教练体验课，七大肌肉群训练教学》，用户应该已经领取过课程了，领取时用户选择了 想学习健身知识 自己练身材 的标签' : '投放抖音上的大v  大v在视频中引导用户 在评论区 1元 领取《健身教练体验课，七大肌肉群训练教学》，用户应该已经领取过课程了，领取时用户选择了将来想学习健身教练，想了解一下的标签'; //渠道信息
                    $r = request_post($info);   //执行发送数据
                    logger()->info($r);
                    if(isset($r)){
                        $item->api_code = isset($r['code'])?$r['code']:'';
                        $item->api_msg = isset($r['msg'])?$r['msg']:'';
                    }else{
                        $item->api_code = '';
                        $item->api_msg = '';
                    }
                    $item->save();//将订单状态改为1 支付成功
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


    public function sendData($mobile){
        //购课通知短信
        $params = [];
        $params["PhoneNumbers"] = $mobile;
        $params["TemplateCode"] = 'SMS_200694204';
        $params['TemplateParam'] = [
            "course" => '健身教练学前体验课，七大肌肉群训练教程'
        ];

        $this->sendCode($params);
    }

    public function sendCode($data){
        $params = array ();
        $accessKeyId = config('alidayu.access_key_id');
        $accessKeySecret = config('alidayu.access_key_secret');
        $params["PhoneNumbers"] = $data['PhoneNumbers'];
        $params["SignName"] = '赛普健身';
        $params["TemplateCode"] = $data['TemplateCode'];
        $params['TemplateParam'] = $data['TemplateParam'];

        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }
        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new Alidayu();
        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        );
    }

    public function judgeCourseBuy($userInfo){
        $user_id = $userInfo['user_id'];
        $ycOrder = OrderCourseGroup::where('user_id',$user_id)->where('course_class_group_id',1)->where('state',1)->select('id')->first();
        $jzOrder = OrderCourseGroup::where('user_id',$user_id)->where('course_class_group_id',4)->where('state',1)->select('id')->first();
        if($ycOrder && !$jzOrder){

            return ['code'=>2,'message'=>'已报名','data'=>['buyed'=>'《产后实战精英私教训练营》','noBuy'=>'《减脂教练核心能力养成营》','link'=>'/train/study.html?id=4']];
        }
        if($jzOrder && !$ycOrder){

            return ['code'=>3,'message'=>'已报名','data'=>['noBuy'=>'《产后实战精英私教训练营》','buyed'=>'《减脂教练核心能力养成营》','link'=>'/train/study.html']];
        }

        if($jzOrder && $ycOrder){

            return ['code'=>4,'message'=>''];
        }

        return ['code'=>0,'message'=>''];
    }

    public function success(Request $request,$id){
        $user = $request->user();
        if(!$user){
            return redirect('/register?redirect=/tf/success/'.$id.'.html');
        }else{
            $user_id = $user->id;
        }
//        $tf_course_class_id = $request->input("tf_course_class_id", 1);
        $tfCourseClass = TfCourseClass::where('state',1)->where("id", $id)->first();
        $buyNum = TfOrder::where('state',1)->where('tf_course_class_id',$id)->count();
        $tfOrders = TfOrder::where('state',1)->where('tf_course_class_id',$id)->orderBy('id','desc')->take(10)->get();
        $data['buyNum'] = $buyNum;
        $data['limitNum'] = 400;
        $data['tfOrders'] = $tfOrders;
        $data['tfCourseClass'] = $tfCourseClass;
        $data['user_id']  = $user_id;
        return view('a.vote.success',$data);
    }

    public function successYd(Request $request,$id){
        $user = $request->user();
        if(!$user){
            return redirect('/register?redirect=/tf/successyd/'.$id.'.html');
        }else{
            $user_id = $user->id;
        }
//        $tf_course_class_id = $request->input("tf_course_class_id", 1);
        $tfCourseClass = TfCourseClass::where('state',1)->where("id", $id)->first();
        $tfOrder  = TfOrder::where('tf_course_class_id',$id)->where("user_id", $user_id)->first();
        //dd($user_id);
        $data['tfOrder']  = $tfOrder;
        $data['tfCourseClass'] = $tfCourseClass;
        $data['user_id']  = $user_id;
        return view('a.vote.successyd',$data);
    }

    /*
     * 预定成功校区信息完善
     */
    public function infoAddSchool(Request $request){
        $user = $request->user();
        if($user){
            $user_id = $user->id;
        }else{
            return $this->getMessage(3,'用户未登录');
        }
        $year = $request->input('year','');
        $school = $request->input('school','');
        $course = $request->input('course','');
        
        $tf_class_id = $request->input('tf_class_id','');
        $tfOrder = TfOrder::where('user_id',$user_id)->where('tf_course_class_id',$tf_class_id)->where('state',1)->first();
        if($tfOrder){
            $tfOrder->year   = $year;
            $tfOrder->school = $school;
            $tfOrder->course = $course;
            $tfOrder->save();
            return $this->getMessage(0,'保存成功');
        }

        return $this->getMessage(1,'未购买');
    }

    /**
     * /
     * @param  Request $request [description]
     * @param  [type]  $id      [投放课程id]
     * @author lu
     * @time 20200321
     */
    public function result(Request $request,$id){
        $user = $request->user();
        if(!$user){
            return redirect('/register?redirect=/tf/success/'.$id.'.html');
        }else{
            $user_id = $user->id;
        }
//        $tf_course_class_id = $request->input("tf_course_class_id", 1);
        $tfCourseClass = TfCourseClass::where('state',1)->where("id", $id)->first();
        // $buyNum = TfOrder::where('state',1)->where('tf_course_class_id',$id)->count();
        // $tfOrders = TfOrder::where('state',1)->where('tf_course_class_id',$id)->orderBy('id','desc')->take(10)->get();
        // $data['buyNum'] = $buyNum;
        // $data['limitNum'] = 400;
        // $data['tfOrders'] = $tfOrders;
        $data['tfCourseClass'] = $tfCourseClass;
        $data['user_id']  = $user_id;
        return view('a.vote.result',$data);
    }

    /*
    *统计投放页 按钮点击次数
    *20200209
    */
    public function clickNum(Request $request){
        $tf_course_class_id = $request->input("tf_course_class_id", 1);
        $type    = $request->input("type", 'pay_click_num');
        $user_id = $request->input("user_id", 4531);
        $date = date("Y-m-d");
        $data = array();
        $data['tf_course_class_id'] = $tf_course_class_id;
        $data['type'] = $type;
        $data['date'] = $date;
        $data['user_id']    = $user_id;
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['updated_at'] = date("Y-m-d H:i:s");
        //新增记录
        $r = DB::table("tf_count_record")->insert($data);
        $count_pv = TfCount::where("date", $date)->where("tf_course_class_id", $tf_course_class_id)->first();
        if($count_pv){
            $count_pv->$type = $count_pv->$type+1;
        }else{
            $count_pv     = new TfCount();
            $count_pv->pv = 1;
            $count_pv->uv = 1;
            $count_pv->date  = $date;
            $count_pv->$type = $count_pv->$type+1;
            $count_pv->tf_course_class_id = $tf_course_class_id;
        }
        $count_pv->save();
    }

    /*
     * 信息更改
     */
    public function infoAdd(Request $request){

        $user = $request->user();
        if($user){
            $user_id = $user->id;
        }else{
            return $this->getMessage(3,'用户未登录');
        }
        $username = $request->input('username','');
        $phone = $request->input('phone','');
        $code  = $request->input('code','');
        $tf_class_id = $request->input('tf_class_id','');
        $mobile_code = Redis::get('code_'.trim($phone));
        if($code!='656565'){
            if(empty($code)){
                return $this->getMessage(1,'请输入有效的验证码');
            }
            if($mobile_code != $code){
                return $this->getMessage(1,'验证码有误或已过期');
            }
        }
        //查询手机号状态
        $url = 'http://101.201.81.14:9315/saipu-app-ins/api/trainee_info_status?mobile='.$phone;
        $result = CurlUtil::appCurl($url, [], 'GET');
        $resInfo= json_decode($result, true);
        $days   = 0;
        if (isset($resInfo['code']) && $resInfo['code'] == 0) {
            $traineeStatus     = $resInfo['result']['traineeStatus'];
            $traineeStatusName = $resInfo['result']['traineeStatusName'];
            $registerDate      = $resInfo['result']['registerDate'];
            $days = (time() - strtotime($registerDate))/86400;  //预定时间截止到今天的天数
        }else{
            $traineeStatus     = 1;
            $traineeStatusName = "没有该学员";
            $registerDate      = 0;
        }

        $tfOrder = TfOrder::where('user_id',$user_id)->where('tf_course_class_id',$tf_class_id)->where('state',1)->first();
        if($tfOrder){
            $tfOrder->username = $username;
            $tfOrder->phone = $phone;
            $tfOrder->traineeStatus = $traineeStatus;
            $tfOrder->traineeStatusName = $traineeStatusName;
            $tfOrder->registerDate  = $registerDate;
            $tfOrder->save();
            
            if($traineeStatus==1){
                return $this->getMessage(0,'保存成功');
            }elseif($traineeStatus=='01' && $days>60){
                return $this->getMessage(0,'保存成功');
            }elseif($traineeStatus=='02' || $traineeStatus=='03' || $traineeStatus=='04' || $traineeStatus=='05'){
                return $this->getMessage(2,'已预定');
            }elseif($traineeStatus=='01' && $days<60){
                 return $this->getMessage(2,'已预定');
            }else{
                return $this->getMessage(3,'不符合');
            }
            
        }

        return $this->getMessage(1,'未购买');
    }



    /*
    * 我的证书
    * 20200314
     */
    public function cert(Request $request){
        $user = $request->user();
        if($user){
            //$name     =  '暂无';
            $order    = TfOrder::where("user_id", $user->id)->first();
            $name     = $order ? $order->username : '暂无';
            $makePic  = new MakeThumbPic();
            $picInfo  = $makePic->makeCert("/images/vote/cert.jpg",'','','upload/share/', $name);
            $data['img_src'] = $picInfo[1];
        }else{
            $data['img_src'] = 0;
        }
        return view('a.vote.cert', $data);
    }
}
