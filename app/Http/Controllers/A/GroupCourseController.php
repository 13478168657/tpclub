<?php

namespace App\Http\Controllers\A;

use App\Models\GroupCourseActivityOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WechatActivityHand;
use App\Models\Order;
use App\Models\Course;
use App\Models\Article;
use App\Models\Courseclass;
use App\Models\CourseType;
use App\Models\CourseContent;
use App\Models\Coursesection;
use App\Models\CourseClassGroup;
use App\Models\OrderCourseGroup;
use App\Models\IntroActiveUser;
use App\Models\FinanceAccount;
use App\Models\Paylog;
use App\Models\Tags;
use App\Models\UserCoupon;
use App\Models\Users;
use App\User;
use App\Models\Studying;
use App\Models\CourseClassGroupOrderStatistics as GroupOrderStatistics;
use App\Utils\MakeThumbPic;
use App\Events\WxCustomerMessagePush;
use App\Constant\CustomerPushType;
use App\Constant\WxMessageType;
use App\Events\WxMessagePush;
use Illuminate\Support\Facades\DB;
require app_path().'/Library/Wechat/WxPay.JsApiPay.php';
class GroupCourseController extends  Controller
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

        $price  = 499;
//        $price  = 0.0;
        $stage = $request->input('stage','');//购买期数
        $dis_id = $request->input('dis_id','');//分享人id
        $stagey = $request->input('stagey');
        $stagej = $request->input('stagej');
        //$price  = 0.01;        // 最终价格
        $user_id = $request->user()->id;
        $old_order = GroupCourseActivityOrder::where('user_id',$user_id)->first();

        $userInfo['user_id'] = $user_id;
        $judgeInfo = $this->judgeCourseBuy($userInfo);

        if($judgeInfo['code'] != 0){

            return json_encode($judgeInfo);
        }

        if($old_order){
            if($old_order->state == 0){
                $oNumber = $old_order->number;
                $old_order->dis_id = $dis_id;
                $old_order->price = $price;
                $old_order->jz_stage = $stagej;
                $old_order->yc_stage = $stagey;
                $old_order->save(); //更新期数
            }else{

                return json_encode(['code'=>1,'message'=>'您已购买请联系客服']);
            }
        }else{
            $order_group = new GroupCourseActivityOrder();
            $oNumber = date("YmdHis").rand(1000,9999);
            $order_group->number  = $oNumber;
            $order_group->user_id = $user_id;
            $order_group->price   = $price;
            $order_group->dis_id = $dis_id;
            $order_group->jz_stage = $stagej;
            $order_group->yc_stage = $stagey;
            $order_group->save();
        }

//        logger()->info('支付用户id:'.$request->user()->id.'--openid--'.$request->user()->openid);
        //②、统一下单
        $tools = new \JsApiPay();
        $openId = $request->user()->openid;
        $input = new \WxPayUnifiedOrder();
        $input->SetBody('健身教练进阶计划-女会员业绩提升班');             //课程标题
        $input->SetAttach($oNumber);                          //订单号
        $input->SetOut_trade_no("sdkphp".date("YmdHis"));
        $input->SetTotal_fee($price*100);    //订单金额

        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://m.saipubbs.com/sy/active/notify");

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
        $order_group  = new GroupCourseActivityOrder();     //订单模型
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
                    $groupStaticY = GroupOrderStatistics::where('course_class_group_id',1)->where('stage',$item->yc_stage)->first();
                    $groupStaticJ = GroupOrderStatistics::where('course_class_group_id',4)->where('stage',$item->jz_stage)->first();
                    if($groupStaticY){
                        $groupStaticY->num += 1;
                        $groupStaticY->save();
                    }else{
                        $groupStaticY = new GroupOrderStatistics();
                        $groupStaticY->course_class_group_id = 1;
                        $groupStaticY->stage = $item->yc_stage;
                        $groupStaticY->num = 1;
                        $groupStaticY->save();
                    }
                    if($groupStaticJ){
                        $groupStaticJ->num += 1;
                        $groupStaticJ->save();
                    }else{
                        $groupStaticJ = new GroupOrderStatistics();
                        $groupStaticJ->course_class_group_id = 4;
                        $groupStaticJ->stage = $item->jz_stage;
                        $groupStaticJ->num = 1;
                        $groupStaticJ->save();
                    }

                    $info['groupOrder'] = $item;
                    $info['payfrom'] = $payfrom;
                    $this->dealGroupCourseOrder($info);
                    $item->state = 1;
//                    $item->payfrom =  $payfrom;
                    $item->price   = $result['total_fee']/100;
                    $item->transaction_id = $result['transaction_id'];//订单流水号
                    $item->save();        //将订单状态改为1  支付成功
                    $pay_log->state = 1;
                    $pay_log->save();     //记录正常支付日志

                    //记录赛普币
//                    courseSpb($item->user_id, 25, $item->course_class_group_id."_group", $price);
                    $sendUser = User::where('id',$item->user_id)->select('openid')->first();
                    //推送消息
                    $data['openid'] = $sendUser->openid;
                    $data['type'] = 'TEXT';
                    $stageInfo = [4=>'11月14日',5=>'11月14日'];

                    $content = "恭喜您，报名成功！\n\n[1]减脂教练核心能力养成营\n报名期数：第".$item->jz_stage."期\n开班日期：".$stageInfo[$item->jz_stage]."\n[2]产后实战精英私教训练营\n报名期数：第12期\n开班日期：11月21日\n\n————————\n开班前，您可以<a href='http://m.saipubbs.com/user/studying'>进入我的课表</a>，预习视频课程~\n开班后，班主任将组建微信班级群，导师全程提供群内教学服务~\n\n扫描二维码，添加班主任微信↓↓↓";
                    $data['text'] = $content;
                    event(new WxCustomerMessagePush($data));
                    $data['openid'] = $sendUser->openid;
                    $data['type'] = 'IMAGES';
                    $data['media_id'] = '_BhBQ8TyjNCKGiFEinDE7YaZZWlo5iex8bX06xfaC3buHxKGUcgRih6w67oErM8n';
                    event(new WxCustomerMessagePush($data));
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

        $price  = 499; // 最终价格
        $stagey = $request->input('stagey','');//期数
        $stagej = $request->input('stagej','');//期数
        $dis_id = $request->input('dis_id');//分享人id
        //$price  = 0.01;        // 最终价格

        $buy_type = $request->input('type','');//购买方式团购，直接购买
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }
        $userInfo['user_id'] = $user_id;
        $judgeInfo = $this->judgeCourseBuy($userInfo);
        if($judgeInfo['code'] != 0){

            return json_encode($judgeInfo);
        }

        $old_order = GroupCourseActivityOrder::where('user_id',$user_id)->first();
        if($user_id){

            if($old_order){
                if($old_order->state==0){
                    $oNumber = $old_order->number;
                    $old_order->dis_id = $dis_id;
                    $old_order->price = $price;
                    $old_order->jz_stage = $stagej;
                    $old_order->yc_stage = $stagey;
                    $old_order->save(); //更新期数
                }else{
                    echo json_encode(['code'=>0, 'msg'=>'您已购买请联系客服']);
                    return;
                }
            }else{
                $order_group = new GroupCourseActivityOrder();
                $oNumber = date("YmdHis").rand(1000,9999);
                $order_group->number  = $oNumber;
                $order_group->user_id = $user_id;
                $order_group->price   = $price;
                $order_group->dis_id = $dis_id;
                $order_group->jz_stage = $stagej;
                $order_group->yc_stage = $stagey;
                $order_group->save();
            }

            $wxConfig = new \WxPayConfig();
            $userip = get_ip();                          //获得用户设备IP 自己网上百度去
            $appid  = $wxConfig->GetAppId();             //微信给的
            $mch_id = $wxConfig->GetMerchantId();        //微信官方的x
            $key    = $wxConfig->GetKey();               //自己设置的微信商家key
            $out_trade_no = $oNumber;                    //平台内部订单号
            $nonce_str    = MD5($out_trade_no);          //随机字符串
            $body         = '健身教练进阶计划-女会员业绩提升班';     //内容
            $total_fee    = $price*100; //金额
            $spbill_create_ip = $userip;                 //IP

            $notify_url   = "http://m.saipubbs.com/sy/active/notifyh"; //回调地址
            $redirect_url = urlencode("http://m.saipubbs.com/train/success");     //支付成功后跳转页面

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
        $order_group  = new GroupCourseActivityOrder();     //订单模型
        $pay_log->info   = $json_d;
        $pay_log->c_time = $time;
        //开启事务
        DB::beginTransaction();
        try{
            if($result['return_code']=='SUCCESS'){
                $number = $result['out_trade_no'];
                $item    = $order_group->where("number",$number)->where("state", 0)->first();
                if($item){

                    $groupStaticY = GroupOrderStatistics::where('course_class_group_id',1)->where('stage',$item->yc_stage)->first();
                    $groupStaticJ = GroupOrderStatistics::where('course_class_group_id',4)->where('stage',$item->jz_stage)->first();
                    if($groupStaticY){
                        $groupStaticY->num += 1;
                        $groupStaticY->save();
                    }else{
                        $groupStaticY = new GroupOrderStatistics();
                        $groupStaticY->course_class_group_id = 1;
                        $groupStaticY->stage = $item->yc_stage;
                        $groupStaticY->num = 1;
                        $groupStaticY->save();
                    }
                    if($groupStaticJ){
                        $groupStaticJ->num += 1;
                        $groupStaticJ->save();
                    }else{
                        $groupStaticJ = new GroupOrderStatistics();
                        $groupStaticJ->course_class_group_id = 4;
                        $groupStaticJ->stage = $item->jz_stage;
                        $groupStaticJ->num = 1;
                        $groupStaticJ->save();
                    }
                    //整套课程信息
                    $course_class_group = DB::table("course_class_group")
                        ->where("id", $item->course_class_group_id)
                        ->first();

                    $info['groupOrder'] = $item;
                    $info['payfrom'] = $payfrom;
                    $this->dealGroupCourseOrder($info);
                    $item->state = 1;
//                    $item->payfrom =  $payfrom;
                    $item->price   = $result['total_fee']/100;
                    $item->transaction_id = $result['transaction_id'];//订单流水号
                    $item->save();        //将订单状态改为1  支付成功
                    $pay_log->state = 2;
                    $pay_log->save();     //记录正常支付日志

                    $sendUser = User::where('id',$item->user_id)->select('openid')->first();
                    //推送消息
                    $data['openid'] = $sendUser->openid;
                    $data['type'] = 'TEXT';
                    $stageInfo = [4=>'11月14日',5=>'11月14日'];
                    $content = "恭喜您，报名成功！\n\n[1]减脂教练核心能力养成营\n报名期数：第".$item->jz_stage."期\n开班日期：".$stageInfo[$item->jz_stage]."\n[2]产后实战精英私教训练营\n报名期数：第12期\n开班日期：11月21日\n\n————————\n开班前，您可以<a href='http://m.saipubbs.com/user/studying'>进入我的课表</a>，预习视频课程~\n开班后，班主任将组建微信班级群，导师全程提供群内教学服务~\n\n扫描二维码，添加班主任微信↓↓↓";
                    $data['text'] = $content;
                    event(new WxCustomerMessagePush($data));
                    $data['openid'] = $sendUser->openid;
                    $data['type'] = 'IMAGES';
                    $data['media_id'] = '_BhBQ8TyjNCKGiFEinDE7YaZZWlo5iex8bX06xfaC3buHxKGUcgRih6w67oErM8n';
                    event(new WxCustomerMessagePush($data));

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

    public function dealGroupCourseOrder($buyInfo){
        $course_ids = [1,4];
        $course_prices = [1=>409,4=>90];
        $course_titles = [1=>'产后实战精英私教训练营',4=>'减脂教练核心能力养成营'];
        $payfrom = $buyInfo['payfrom'];
        $groupOrder = $buyInfo['groupOrder'];
        foreach($course_ids as $group_id){
            $course_class_group = CourseClassGroup::where('id',$group_id)->select('id','user_id','course_class_ids','title')->first();
            $price = $course_prices[$group_id];

            $order =  OrderCourseGroup::where('user_id',$groupOrder->user_id)->where('state',0)->first();
            if(!$order){
                $order = new OrderCourseGroup();
            }
            $order->state = 1;
            $order->number = $groupOrder->number;
            $order->payfrom = $payfrom;
            $order->price   = $price;
            $order->buy_way = 'SINGLE';
            $order->dis_id   = $groupOrder->dis_id;
            if($group_id == 1){
                $order->stage   = 12;
            }else{
                $order->stage = $groupOrder->jz_stage;
            }
            $order->course_class_group_id   = $group_id;
            $order->course_class_group_title   = $course_titles[$group_id];
            $order->user_id = $groupOrder->user_id;
            $order->transaction_id = $groupOrder->transaction_id;//订单流水号
            $order->save();        //将订单状态改为1 支付成功
            $finance_a = new FinanceAccount();
            $studying  = new Studying();

            $course_class_ids   = explode(',', $course_class_group->course_class_ids);  //课程id
            //导师id
            $author_id   = $course_class_group->user_id;

            //支付成功后将记录插入正在学习表
            $user = DB::table("users")->where("id",$groupOrder->user_id)->select("name","avatar","openid")->get();

            foreach($course_class_ids as $id){
                $course_class = DB::table("course_class")
                    ->where("id",$id)
                    ->select("user_id",'explain_url','push_message',"title","id","price", "state")
                    ->get();
                $studying->addOne($groupOrder->user_id, $id);
                //购买成功写入消息通知
                add_message($author_id,$groupOrder->user_id, $user[0]->name, $user[0]->avatar,$course_class[0]->title, "BUY");
            }

            //操作客户账户资金信息
            $finance_a->addOne($groupOrder->user_id);                               //查看用户资金账户，如果没有创建一条
            //支付成功后记录流水记录
            add_finance_record($price,"BUY", $groupOrder->user_id, $payfrom, 0,$group_id);

            //记录导师账户资金信息
            $author_id   = $course_class_group->user_id;
            $finance_a->addOne($author_id);
            //支付成功后记录流水记录
            add_finance_record($price,"ADD", $author_id, $payfrom, 0,$group_id);
            DB::table("finance_accounts")->where("user_id", '=', $author_id)->increment("total", $price);

        }
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

}