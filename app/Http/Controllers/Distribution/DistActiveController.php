<?php

namespace App\Http\Controllers\Distribution;

use App\Models\Courseclass;
use App\Models\CourseClassGroup;
use App\Models\OrderCourseGroup;
use App\Models\Period;
use App\Models\TeamCourseBuyed;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use App\Http\Controllers\A\AcsmController;
use App\Models\DisForm;
use App\Models\DisCourse;
use App\Models\DisCourseClass;
use App\Models\DisCoursePlayRecord;
use App\Models\WechatActivityHand;
use App\Models\DisOrder;
use App\Models\DisStudying;
use App\Models\Paylog;
use App\Models\TfCourseClass;
use App\Models\TfOrder;
use App\Models\TfCountRecord;
use App\Models\TfCount;
use App\Models\Order;
use App\Models\CourseOrder;
use App\Models\IntroActiveUser;
use App\Models\UsersAttribute;
use App\Models\FinanceAccount;
use App\Models\GroupCourseActivityOrder;
use Illuminate\Support\Facades\DB;
use App\Constant\WxMessageType;
use App\Utils\WxMessagePush;
use App\Events\WxCustomerMessagePush;

require app_path().'/Library/Wechat/WxPay.JsApiPay.php';
class DistActiveController extends Controller
{


    public function index(Request $request,$dis,$cid){

        $disForm = DisForm::where('user_id',$dis)->first();
        $data['distClass'] = DisCourseClass::where('id',$cid)->first();
        $data['disForm'] = $disForm;
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();  //微信分享
        }
        return view('distActive.index',$data);
    }

    public function buy(Request $request,$id){
        if(is_weixin()){
            $is_weixin = 1;
        }else{
            $is_weixin = 0;
        }

        if(strpos($id,'a') !== false){
            $id = trim($id,'a');
            $user = $request->user();
            if($user){
                $user_id = $user->id;
                $mobile = $user->mobile;
            }else{
                $user_id = 0;
                $mobile = '';
            }
            $acsmInfo = $this->getAcsmPrice($id,$request->user());
            $price = $acsmInfo[0];
            $data['invite'] = $acsmInfo[1];
            $data['grade'] = $acsmInfo[2];
            $data['currentGrade'] = $acsmInfo[3];
            $order = Order::where('user_id',$user_id)->where('course_class_id',$id)->where('state',1)->select('id')->first();
            $buyed = 0;
            if($order){
                $buyed = 1;
            }
            $introActUser = IntroActiveUser::where('user_id',$user_id)->where("course_class_id", $id)->first();
            $buyed = 0;
            if($order){
                $buyed = 1;
            }
            $add_info = 0;
            if($introActUser){
                $add_info = 1;
            }
            $courseClass = Courseclass::where('id',$id)->first();
            $user_id = $request->user()?$request->user()->id:0;
            $assignHands = WechatActivityHand::where('user_id',$user_id)->get();
            $data['assignHands'] = $assignHands;
            $data['courseClass'] = $courseClass;
            $data['price'] = $price;
            $data['add_info'] = $add_info;
            $data['is_weixin'] = $is_weixin;
            $data['fission_id'] = $request->input('fission_id',0);
            $data['user_id'] = $user_id;
            $data['mobile'] = $mobile;
            $data['course_buyed'] = $buyed;
            $is_local = env("IS_LOCAL");
            if($is_local){
                $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
            }else{
                $data['WechatShare'] = getSignPackage();  //微信分享
            }
            return view('a.acsm.assign',$data);
        }elseif(strpos($id,'sy') !== false){
            $user = $request->user();
            if($user){
                $user_id = $user->id;
                $mobile = $user->mobile;
            }else{
                $user_id = 0;
                $mobile = '';
            }
            $data['userid'] = $user_id;
            $result = $this->getUnlineCourseInfo($data);
            $result['fission_id'] = $request->input('fission_id',0);
            $result['user_id'] = $user_id;
            $result['is_weixin'] = $is_weixin;
            $result['mobile'] = $mobile;
            $is_local = env("IS_LOCAL");
            if($is_local){
                $result['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
            }else{
                $result['WechatShare'] = getSignPackage();  //微信分享
            }
            return view('a.shiyi.index',$result);
        }elseif(strpos($id,'bm') !== false){
            $id = trim($id,'bm');
            $user = $request->user();
            if($user){
                $user_id = $user->id;
                $mobile = $user->mobile;
            }else{
                $user_id = 0;
                $mobile = '';
            }
            $courseOrder = CourseOrder::where('user_id',$user_id)->where('state',1)->select('id')->first();
            $courseClass = Courseclass::where('id',$id)->first();
            $data['userid'] = $user_id;
            $result['fission_id'] = $request->input('fission_id',0);
            $result['courseClass'] = $courseClass;
            $result['user_id'] = $user_id;
            $result['is_weixin'] = $is_weixin;
            $result['mobile'] = $mobile;
            $result['courseOrder'] = $courseOrder;
            $is_local = env("IS_LOCAL");
            if($is_local){
                $result['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
            }else{
                $result['WechatShare'] = getSignPackage();  //微信分享
            }
            return view('a.acsm.baoming',$result);
        }elseif(strpos($id,'pt') !== false){
            $user = $request->user();
            $id = trim($id,'pt');
            if($user){
                $user_id = $user->id;
            }else{
                $user_id = 0;
            }
            $tfCourseClass = TfCourseClass::where('state',1)->where('id',$id)->first();

            $data['tfCourseClass'] = $tfCourseClass;
            $is_local = env("IS_LOCAL");
            if($is_local){
                $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
            }else{
                $data['WechatShare'] = getSignPackage();  //微信分享
            }
            $old_order = TfOrder::where('user_id',$user_id)->where('tf_course_class_id',$id)->first();
            if($old_order){
                if($old_order->state==1){
                    $is_buy = 1;
                }else{
                    $is_buy = 0;
                }
            }else{
                $is_buy = 0;
            }
            $data['is_buy']    = $is_buy;
            $data['user_id']   = $user_id;
            $data['is_weixin'] = $is_weixin;
            return view('a.vote.pintuan',$data);
        }elseif(strpos($id,'yd') !== false){
            $user = $request->user();
            $id = trim($id,'yd');
            if($user){
                $user_id = $user->id;
            }else{
                $user_id = 0;
            }
            $tfCourseClass = TfCourseClass::where('state',1)->where('id',$id)->first();

            $data['tfCourseClass'] = $tfCourseClass;
            $is_local = env("IS_LOCAL");
            if($is_local){
                $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
            }else{
                $data['WechatShare'] = getSignPackage();  //微信分享
            }
            $old_order = TfOrder::where('user_id',$user_id)->where('tf_course_class_id',$id)->first();
            if($old_order){
                if($old_order->state==1){
                    $is_buy = 1;
                }else{
                    $is_buy = 0;
                }
            }else{
                $is_buy = 0;
            }
            $data['is_buy']    = $is_buy;
            $data['user_id']   = $user_id;
            $data['is_weixin'] = $is_weixin;
            return view('a.vote.yuding',$data);
        }
        $dis = $request->input('dis',0);
        $data['is_weixin'] = $is_weixin;
        $data['dist_id'] = $dis;
        $data['dis_course_id'] = $id;
//        dd(strtotime(date('Y-m-d')));
        $distClass = DisCourseClass::where('id',$id)->first();
        $data['distClass'] = $distClass;
        if($distClass){
            $data['distClass'] = $distClass;
        }else{
//            return redirect('/');
        }
        $data['is_buy'] = 0;
        $data['is_dis'] = 0;//是否为分销员
        $period  =  $this->getPeriods($id);
        $data['period'] = $period;
        if($request->user()){
            $user_id = $request->user()->id;
            $disStudy = DisStudying::where('user_id',$user_id)->where('dis_course_class_id',$id)->select('id')->first();
            if($disStudy){
//                return redirect("/dist/study/{$id}.html");
            }
//            dd($user_id);
            $mobile  = $request->user()->mobile ? $request->user()->mobile : 0;  //用户手机号
            $disOrder = DisOrder::where('user_id',$request->user()->id)->where('dis_course_class_id',$id)->where('state',1)->first();
            if($disOrder){
                $data['is_buy'] = 1;
            }
            $data['disOrder'] = $disOrder;
            $disForm = DisForm::where('user_id',$user_id)->where('code',1)->select('id')->first();
            if($disForm){
                $data['is_dis'] = 1;
            }
        }else{
            $user_id = 0;
            $mobile  = 0;  //用户手机号
        }

        if($user_id == 0){
            $data['spb'] = 0;
        }else{
            $data['spb'] = $request->user()->spb;
        }
        $data['mobile'] = $mobile;
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();  //微信分享
        }
//        dd($data);
        return view('distActive.buy',$data);
    }

    /*
     * 活动信息
     */
    public function getUnlineCourseInfo($data){

        $order = OrderCourseGroup::where('user_id',$data['userid'])->whereIn('course_class_group_id',[1,4])->where('state',1)->select('id')->first();
        $buyed = 0;
        if($order){
            $buyed = 1;
        }

        $groupOrder = GroupCourseActivityOrder::where('user_id',$data['userid'])->where('state',1)->first();
        $is_buy = 0;
        if($groupOrder){
            $is_buy = 1;
        }
        $data['is_buy'] = $is_buy;
        $jianzhiCourse = CourseClassGroup::where('id',4)->first();
        $yunchanCourse = CourseClassGroup::where('id',1)->first();

        $data['jianzhiCourse'] = $jianzhiCourse;
        $data['yunchanCourse'] = $yunchanCourse;

        $isStaff = 0;
        $staffReg = UsersAttribute::where('user_id',$data['userid'])->where('can_dist',1)->select('id')->first();
        if($staffReg){
            $isStaff = 1;
        }
//        if(env('IS_LOCAL') == false){
//            $wechat = new WechatController();
//            $code_img = $wechat->getQRcode('shiyi');   //下载带客户信息的二维码
//        }else{
//            $code_img = '';
//        }

        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();
        }

        $data['is_staff'] = $isStaff;
//        $data['code'] = $code_img;
        $data['course_buyed'] = $buyed;
        return $data;
    }


    /*
     * 获取课程价格
     */

    public function getAcsmPrice($cid,$user){
        if($user){
            $user_id = $user->id;
        }else{
            $user_id = 0;
        }
        $total = WechatActivityHand::where('user_id',$user_id)->where('type','ACSM')->select('id')->count();
        if($total<5){
            $price = 5800;
            $invite = 5 - $total;
            $grade = 4800;
            $currentGrage = 1;
        }elseif($total >= 5 && $total < 10){
            $price = 4800;
            $invite = 10 - $total;
            $grade = 3800;
            $currentGrage = 2;
        }elseif($total >= 10 && $total < 15){
            $price = 3800;
            $invite = 15 - $total;
            $grade = 3300;
            $currentGrage = 3;
        }elseif($total >= 15 && $total < 20){
            $price = 3300;
            $invite = 20 - $total;
            $grade = 2800;
            $currentGrage = 4;
        }else{
            $price = 2800;
            $invite = 0;
            $grade = 5;
            $currentGrage = 5;
        }
        return [$price,$invite,$grade,$currentGrage];
    }

    public function answer(Request $request,$id){

        $data['dis_course_id'] = $id;
        return view('distActive.answer',$data);
    }

    public function finish(Request $request,$cid,$id){

        if(!$request->user()){
            return redirect('/login');
        }
        $user_id = $request->user()->id;
        $share_id = $request->input('id',0);
        $userDisStudy = DisStudying::where('user_id',$user_id)->where('dis_course_class_id',$cid)->select('id','dis_id')->first();
        if(!$userDisStudy){
            $disStudy = DisStudying::where('user_id',$share_id)->where('dis_course_class_id',$cid)->first();
            if($disStudy){
                return redirect('/dist/active/'.$disStudy->dis_id.'/'.$cid.'.html');
            }else{
                return redirect('/');
            }
        }
        $disCourse = DisCourse::where('id',$id)->first();
        $data['disCourse'] = $disCourse;
        $data['cid'] = $cid;
        $data['user_id'] = $user_id;
        $playRecord = DisCoursePlayRecord::where('dis_course_id',$id)->where('dis_course_class_id',$cid)->where('user_id',$user_id)->select('is_play','datetime')->first();

        if($playRecord->datetime > time()){

            return redirect('/dist/study/'.$cid.'.html');
        }
        $data['dis_id'] = $userDisStudy->dis_id;

        if($playRecord->is_play){
            $data['flag'] = 1;
        }else{
            $data['flag'] = 0;
            $currentTime = strtotime(date('Y-m-d'));
            if($currentTime > $playRecord->datetime){
                $data['flag'] = 2;
            }
        }
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();  //微信分享
        }
        return view('distActive.finish',$data);
    }

    public function postFinish(Request $request){
        $course_id = $request->input('course_id');
        $c_id = $request->input('c_id');
        $user = $request->user();
        if($user){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }
        $playRecord = DisCoursePlayRecord::where('dis_course_id',$course_id)->where('user_id',$user_id)->where('dis_course_class_id',$c_id)->first();
        if(!$playRecord){
            $playRecord = new DisCoursePlayRecord();
            $playRecord->dis_course_id = $course_id;
            $playRecord->user_id = $user_id;
        }else{
            if($playRecord->is_play==0){
                $currentTime = strtotime(date('Y-m-d'));
                if($currentTime > $playRecord->datetime){
                    return $this->getMessage(1,'打卡已过期');
                }
            }
        }
        $playRecord->is_play = 1;
        $playRecord->save();
        return $this->getMessage(0,'打卡成功');
    }
    public function share(Request $request,$cid,$id){
        $disClass = DisCourseClass::where('id',$cid)->first();
        if(!$request->user()){
            return redirect('/');
        }
        $user_id = $request->user()?$request->user()->id:0;
        $total = DisCoursePlayRecord::where('dis_course_class_id',$cid)->where('user_id',$user_id)->where('is_play',1)->count();
        $data['disCourse'] = DisCourse::where('id',$id)->first();
        $data['disClass'] = $disClass;
        $data['total'] = $total;
        $disStudying = DisStudying::where('dis_course_class_id',$cid)->where('user_id',$user_id)->select('dis_id')->first();
        $data['dis_id'] = $disStudying->dis_id;
        $data['class_id'] = $cid;
        $data['course_id'] = $id;
        $data['user_id'] = $user_id;
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();  //微信分享
        }
        return view('distActive.share',$data);
    }
    public function disCourse(Request $request){
        $user_id = $request->user()->id;
        if(!$user_id){
            return redirect('/login');
        }
        $disStudy = DisStudying::where('user_id',$user_id)->paginate(10);

        return view('distActive.disCourse',['disStudy'=>$disStudy]);
    }

    public function cardPoster(Request $request,$userId,$cid,$id){
        $user = $request->user();
        $avatar = '';
        if($user){
            $name = $user->name;
        }else{
            $name = '';
        }
        if(!$request->user()){
            return redirect('/login');
        }
        $shareUser = User::where('id',$userId)->select('avatar',"nickname")->first();
        $nickName = '小伙伴儿';
        if($shareUser){
            if(strpos($shareUser->avatar,'http') !== false){
                $avatar = $shareUser->avatar;
            }else{
                if($avatar != ''){
                    $avatar = env('IMG_URL').$shareUser->avatar;
                }else{
                    $avatar = '/images/my/nophoto.jpg';
                }
            }
            $nickName = $shareUser->nickname ? $shareUser->nickname : "小伙伴儿";
        }else{
            $avatar = '/images/my/nophoto.jpg';
        }
        $disClass = DisCourseClass::where('id',$cid)->first();
        $disCourse = DisCourse::where('id',$id)->first();
        $user_id = $request->user()?$request->user()->id:0;
        $total = DisCoursePlayRecord::where('dis_course_class_id',$cid)->where('user_id',$userId)->where('is_play',1)->count();
        $distStudy  = DisStudying::where('dis_course_class_id',$cid)->where('user_id',$userId)->select('dis_id')->first();
        $data['disClass'] = $disClass;
        $data['total'] = $total;
        $data['name'] = $nickName;
        $data['avatar'] = $avatar;
        $data['dist_id'] = $distStudy->dis_id;
        $data['description'] = $this->getDesc($disCourse->study_content);
        return view('distActive.card',$data);
    }

    /*
     * 获取描述
     */
    public function getDesc($desc){
        $result = explode("\n",$desc);
        $str = [];
        foreach($result as $v){
            $str[] = trim($v);
        }
        return $str;
    }
    public function disStudy(Request $request,$id){

        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }
//        dd(strtotime(date('Y-m-d')));
        $share_id = $request->input('id',0);

//        $total = DisCourseClass::where('id',$id)->count();
        $disCourseClass = DisCourseClass::where('id',$id)->first();
//        $ids = explode(',',$disCourseClass->course_ids);
        $total = count(explode(',',$disCourseClass->course_ids));
        $currentTime = time();
        $data['disCoursePlayRecords'] = DisCoursePlayRecord::where('dis_course_class_id',$id)->where('user_id',$user_id)->orderBy('datetime','asc')->get();

        $userDisStudy = DisStudying::where('user_id',$user_id)->where('dis_course_class_id',$id)->select('id','dis_id')->first();
        if(!$userDisStudy){
            return redirect('/dist/buy/'.$id.'.html');
//            return redirect('/coach/'.$id.'.html');
        }
        $data['nowTime'] = strtotime(date('Y-m-d'));
        logger()->info([$data['nowTime'],date('Y-m-d')]);
        $data['cardTotal'] = DisCoursePlayRecord::where('dis_course_class_id',$id)->where('is_play',1)->where('user_id',$user_id)->count();
        $data['disCourseClass'] = $disCourseClass;
        $data['total'] = $total;
        $data['user_id'] = $user_id;
        $data['dis_id'] = $userDisStudy->dis_id;
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();  //微信分享
        }
        return view('distActive.disStudy',$data);
    }

    //微信jsapi支付接口
    public function pay(Request $request){

        $cid   = $request->input("class_id");           // 课程id
        $dist_id = $request->input('dist_id',0);           //分销员id
        $buy_type = $request->input('type','');//购买方式团购，直接购买
        if($request->user() && $request->user()->mobile != ''){
            $user_id = $request->user()->id;
        }else{
            return ['code'=>2,'message'=>'未登录'];
        }
        $disCourseClass = DisCourseClass::where("id",$cid)->select("id","title","price","o_price","team_price","team_people",'people_set')->first();
        if($disCourseClass){
            $disForm = DisForm::where('user_id',$user_id)->where('code',1)->select('id')->first();
            if($disForm){
                $price  = 0;
            }else{
                $price  = $disCourseClass->price;    // 最终价格
            }
        }else{
            return ['code'=>1,'message'=>'数据错误'];
        }
        //$price  = 0.01;        // 最终价格
        if($price == 0){
            $result = $this->disPay($cid,$dist_id,$user_id);

            if($result[0] == 0){

                return ['code'=>0,'message'=>'购买成功'];
            }else{
                return ['code'=>1,'message'=>'购买失败'];
            }
        }
        $order   = new DisOrder();     //订单模型
//        $old_order = $order->where("user_id",$user_id)->where("dis_course_class_id",$c_id)->first();
        if($buy_type == 'PT'){
            $old_order = $order->where("user_id",$user_id)->where("dis_course_class_id",$cid)->where('buy_way',"TEAM")->where('refund_id',0)->first();
            $buy_way = 'TEAM';
            $price = $disCourseClass->team_price;
        }else{
            $old_order = $order->where("user_id",$user_id)->where("dis_course_class_id",$cid)->where('buy_way',"SINGLE")->first();
            $buy_way = 'SINGLE';
            $price =  $disCourseClass->price;
        }
        $period  =  $this->getPeriods($cid);
        if($period){
            $stage = $period->stage;
        }else{
            $stage = 0;
            return ['code'=>1,'message'=>'报名已满'];
        }
        $totalCount = DisOrder::where("dis_course_class_id",$cid)->where('stage',$stage)->where('state',1)->count();
        if($totalCount >= $disCourseClass->people_set){

            return ['code'=>1,'message'=>'报名已满'];
        }
        if($old_order){
            if($old_order->state == 0){
                $oNumber = $old_order->number;
                $old_order->stage = $stage;
                $old_order->price = $price;
                $old_order->dis_id = $dist_id;
                $old_order->sponsor_id = $user_id;
                $old_order->save(); //更新期数
            }else{
                return ['code'=>1,'message'=>'您已购买请联系客服'];
            }
        }else{

            $oNumber = date("YmdHis").rand(1000,9999);
            $order->number  = $oNumber;
            $order->user_id = $user_id;
            $order->price   = $price;
            $order->buy_way   = $buy_way;
            $order->stage   =  $stage;
            $order->dis_id = $dist_id;
            $order->sponsor_id = $user_id;
            $order->dis_course_class_id    = $cid;
            $order->dis_course_class_title = $disCourseClass->title;
            $order->save();
        }
        //②、统一下单
        $tools = new \JsApiPay();
        $openId = $request->user()->openid;
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($disCourseClass->title);             //课程标题
        $input->SetAttach($oNumber."_".$dist_id);            //订单号
        $input->SetOut_trade_no("sdkphp".date("YmdHis"));
        $input->SetTotal_fee($price*100);    //订单金额

        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://m.saipubbs.com/dist/payW/notify");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);

        $config = new \WxPayConfig();
        $order = \WxPayApi::unifiedOrder($config, $input);
        logger()->info($order);
        $jsApiParameters = $tools->GetJsApiParameters($order);
        $info =  json_decode($jsApiParameters,true);
        return ['code'=>0,'data'=>$info];
    }
    /*
     * 分销员调用接口
     */
    public function disPay($c_id,$dist_id,$user_id){

        $disStudy = DisStudying::where('user_id',$user_id)->where('dis_course_class_id',$c_id)->where('dis_id',$dist_id)->first();
        if($disStudy){
            return [1,'已购买'];
        }else{
            $disStudy  = new DisStudying();
        }
        DB::beginTransaction();
        try{
            //整套课程信息
            $disCourseClass = DisCourseClass::where("id",$c_id)->first();
//                    $course_class_ids   = explode(',', $disCourseClass->course_ids);  //课程id
            //导师id
//                    $author_id   = $disCourseClass->user_id;
            $disStudy->user_id = $user_id;
            $disStudy->dis_course_class_id = $c_id;
            $disStudy->dis_id = $dist_id;//分销员id
            $disStudy->save();
            //操作客户账户资金信息
            $finance_a = new FinanceAccount();
            $finance_a->addOne($user_id);  //查看用户资金账户，如果没有创建一条
            $course_ids = explode(',',$disCourseClass->course_ids);
            $playRecords = [];
            $period = $this->getPeriods($c_id);
            if($period){
                $periodTime = $period->begin_time;
            }
            $studyTime = strtotime($periodTime);
            foreach($course_ids as $k => $ids){
                $course = DisCourse::where('id',$ids)->select('delay')->select('id','delay')->first();
                $time = $studyTime + $course->delay*86400;
                $day = date('Y-m-d',$time);
                $delayTime = strtotime($day);
                $playRecords[$k]['user_id'] = $user_id;
                $playRecords[$k]['dis_course_id'] = $ids;
                $playRecords[$k]['datetime'] = $delayTime;
                $playRecords[$k]['day'] = $day;
                $playRecords[$k]['dis_course_class_id'] = $disCourseClass->id;
                $playRecords[$k]['created_at'] = date('Y-m-d H:i:s');
                $playRecords[$k]['updated_at'] = date('Y-m-d H:i:s');
            }

            $res = DB::table('dis_course_play_record')->insert($playRecords);
            DB::commit();
            return [0,'购买成功'];
        }catch(\Exception $e){
            DB::rollback();
            return [1,'购买失败'];
        }
    }
    //微信jsapi支付成功后回调接口
    public function notify(Request $request){

        $xml = file_get_contents('php://input');
        $result = xmlToArray($xml);
        $json_d = json_encode($result);
        $time   = time();
        $pay_log= new Paylog();    //支付日志
        $order  = new DisOrder();     //订单模型
        $pay_log->info   = $json_d;
        $pay_log->c_time = $time;
        $transaction_id = json_decode($json_d)->transaction_id;
        $payfrom = "WXPAY";
        $pay_log->state = 1;
        $pay_log->save();     //记录正常支付日志
        //开启事务
        DB::beginTransaction();
        try{
            if($result['return_code']=='SUCCESS'){
                $out_trade_no = $result['out_trade_no'];
                $number  = explode('_',$result['attach']);
                $item    = $order->where("number",$number[0])->where("state", 0)->first();
                if($item){

                    $itemInfo['number'] = $number;
                    $itemInfo['item'] = $item;
                    $itemInfo['transaction_id'] = $transaction_id;
                    $itemInfo['payfrom'] = $payfrom;
                    $this->insertTrainInfo($itemInfo);
                }
            }else{
                $pay_log->state = 0;
                $pay_log->save();         //记录有问题支付日志
            }
            DB::commit();
        }catch(\Exception $e){
            $pay_log->state = 0;




            $pay_log->save();         //记录有问题支付日志
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
        $cid   = $request->input("class_id");           // 课程id
        $dist_id = $request->input('dist_id',0);           //分销员id
        $buy_type = $request->input('type','');//购买方式团购，直接购买
        if($request->user() && $request->user()->mobile != ''){
            $user_id = $request->user()->id;
        }else{
            return ['code'=>2,'message'=>'未登录'];
        }
        $disCourseClass = DisCourseClass::where("id",$cid)->select("id","title","price","o_price","team_price","team_people","people_set")->first();
        if($disCourseClass){
            $disForm = DisForm::where('user_id',$user_id)->where('code',1)->select('id')->first();
            if($disForm){
                $price  = 0;
            }else{
                $price  = $disCourseClass->price;    // 最终价格
            }
        }else{
            return ['code'=>1,'message'=>'数据异常'];
        }
        if($price == 0){
            $result = $this->disPay($cid,$dist_id,$user_id);
            if($result[0] == 0){
                return ['code'=>1,'message'=>'购买成功'];
            }else{
                return ['code'=>0,'message'=>'购买失败'];
            }
        }

        if($user_id && $cid){
            $order   = new DisOrder();         //订单模型
//            $disCourseClass = DisCourseClass::where("id",$cid)->select("id","title","price","o_price")->first();
//            $old_order = $order->where("user_id",$user_id)->where("dis_course_class_id",$c_id)->first();
            if($buy_type == 'PT'){
                $old_order = $order->where("user_id",$user_id)->where("dis_course_class_id",$cid)->where('buy_way',"TEAM")->where('refund_id',0)->first();
                $buy_way = 'TEAM';
                $price = $disCourseClass->team_price;
            }else{
                $old_order = $order->where("user_id",$user_id)->where("dis_course_class_id",$cid)->where('buy_way',"SINGLE")->first();
                $buy_way = 'SINGLE';
                $price = $disCourseClass->team_price;
            }
            $period  =  $this->getPeriods($cid);
            if($period){
                $stage = $period->stage;
            }else{
                $stage = 0;
                return ['code'=>1,'message'=>'报名已满'];
            }
            $totalCount = DisOrder::where("dis_course_class_id",$cid)->where('stage',$stage)->where('state',1)->count();
            if($totalCount >= $disCourseClass->people_set){

                return ['code'=>1,'message'=>'报名已满'];
            }
            if($old_order){
                if($old_order->state==0){
                    $oNumber = $old_order->number;
                    $old_order->stage = $stage;
                    $old_order->dis_id = $dist_id;
                    $old_order->sponsor_id = $user_id;
                    $old_order->save();
                }else{
                    echo json_encode(['code'=>0, 'msg'=>'您已购买请联系客服']);
                    return;
                }
            }else{
                $oNumber = date("YmdHis").rand(1000,9999);
                $order->number  = $oNumber;
                $order->user_id = $user_id;
                $order->price   = $price;
                $order->buy_way   = $buy_way;
                $order->stage   = $stage;
                $order->dis_id = $dist_id;
                $order->sponsor_id = $user_id;
                $order->dis_course_class_id    = $cid;
                $order->dis_course_class_title = $disCourseClass->title;
                $order->save();
            }
            //$video_id = DB::table("course")->where("course_class_id", $c_id)->select("id")->first();
            $wxConfig = new \WxPayConfig();
            $userip = get_ip();                          //获得用户设备IP 自己网上百度去
            $appid  = $wxConfig->GetAppId();             //微信给的
            $mch_id = $wxConfig->GetMerchantId();        //微信官方的x
            $key    = $wxConfig->GetKey();               //自己设置的微信商家key
            $out_trade_no = $oNumber.'_'.$dist_id;                    //平台内部订单号
            $nonce_str    = MD5($out_trade_no);          //随机字符串
            $body         = $disCourseClass->title;     //内容
            $total_fee    = $price*100; //金额
            $spbill_create_ip = $userip;                 //IP
            $notify_url   = "http://m.saipubbs.com/dist/payH/notify"; //回调地址
            //$redirect_url = urlencode("http://m.saipubbs.com/course/middle/{$c_id}/{$video_id->id}");     //支付成功后跳转页面
            $redirect_url = urlencode("http://m.saipubbs.com/dist/answer/".$cid.".html");     //支付成功后跳转页面
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

        $c_id   = $request->input("class_id");           // 课程id
        $price  = $request->input("final_price",99);    // 最终价格
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }
        //开启事务
        DB::beginTransaction();
        try{
            if($user_id && $c_id){
                $order   = new DisOrdeer();     //订单模型
                $disCourseClass  = DisCourseClass::where("id",$c_id)
                    ->select("id","title","price","o_price")->first();
                $old_order     = $order
                    ->where("user_id",$user_id)
                    ->where("dis_course_class_id",$c_id)
                    ->first();
                if($old_order){
                    if($old_order->state == 1){
                        echo json_encode(['code'=>0, 'msg'=>"您已购买请联系客服"]);
                        return;
                    }else{
                        $old_order->state = 1;
                        $old_order->payfrom = "SPB";
                        $re =  $old_order->save();
                    }
                }else{
                    $oNumber = date("YmdHis").rand(1000,9999);
                    $order->number  = $oNumber;
                    $order->user_id = $user_id;
                    $order->price   = $price;
                    $order->state   = 1;
                    $order->payfrom = "SPB";
                    $order->dis_course_class_id    = $c_id;
                    $order->dis_course_class_title = $disCourseClass->title;
                    $order->save();
                }

                $newPrice = $price * 100;
                DB::table("users")->where("id", '=', $user_id)->decrement("spb", $newPrice);
//                courseSpb($user_id, 25, $class_group_id."_group", $price);   //记录赛普币
//                $a['user_id']     = $user_id;
//                $a['spb_rule_id'] = 12;
//                $a['courseid']    = $class_group_id."_group";
//                $a['value']       = -$price * 100;
//                $a['created_at']  = date("Y-m-d H:i:s");
//                DB::table("spb_records")->insert($a);
                DB::commit();
                echo json_encode(['code'=>1, 'msg'=>"购买成功"]);
                return;
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
        $transaction_id = json_decode($json_d)->transaction_id;
        $payfrom= "WXPAYH";
        $pay_log= new Paylog();    //支付日志
        $order  = new DisOrder();     //订单模型
        $pay_log->info   = $json_d;
        $pay_log->c_time = $time;
        $pay_log->state = 2;
        $pay_log->save();     //记录正常支付日志
        //开启事务
        DB::beginTransaction();
        try{
            if($result['return_code']=='SUCCESS'){
                $number = explode('_',$result['out_trade_no']);
                $item    = $order->where("number",$number[0])->where("state", 0)->first();
                if($item){

                    $itemInfo['number'] = $number;
                    $itemInfo['item'] = $item;
                    $itemInfo['transaction_id'] = $transaction_id;
                    $itemInfo['payfrom'] = $payfrom;
                    $this->insertTrainInfo($itemInfo);
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
     * 获取购课期数
     */
    public function getPeriods($cid){

        $nowDay = date('Y-m-d');
        $period = Period::where('cid',$cid)->where('type','train')->where('begin_time','>',$nowDay)->first();
        return $period;
    }
    public function addCard(Request $request){
        $id = $request->input('id');
        $user_id = $request->user()->id;
        $record = DisCoursePlayRecord::where('user_id',$user_id)->where('dis_course_id',$id)->first();
        if(!$record){
            $record = new DisCoursePlayRecord();
            $record->user_id = $user_id;
            $record->dis_course_id = $id;
            $record->user_id = $user_id;
            $result = $record->save();
            if(!$result){
                return redirect('/');
            }else{
                return view('distActive.cardSuccess');
            }
        }
        return view('distActive.cardSuccess');
    }

    public function postAnswer(Request $request){
        $answerInfo = config('distAnswer.dist');
//        dd($answerInfo);
        $time = $answerInfo['time'][intval($request->input('time'))];
        $age = $answerInfo['age'][intval($request->input('age'))];
        $know = $answerInfo['know'][intval($request->input('know'))];
        $about = $answerInfo['about'][intval($request->input('about'))];
        $user = $request->user();
        if(!$user){
            return $this->getMessage(1,'未登录社区');
        }

        $userAttr = UsersAttribute::where('user_id',$user->id)->first();
        $data['about'] = $about;
        $data['time'] = $time;
        $data['age'] = $age;
        $data['know'] = $know;
        $userAttr->dis_tag = json_encode($data);
        $userAttr->save();
        return $this->getMessage(0,'添加成功',['subscribe'=>$user->subscribe]);
    }

    public function disCode(Request $request){

        return view('distActive.code');
    }

    /*
     * 处理购买信息
     */
    public function insertTrainInfo($itemInfo){
//操作客户账户资金信息
        $item = $itemInfo['item'];
        $number = $itemInfo['number'];
        $transaction_id = $itemInfo['transaction_id'];
        $payfrom = $itemInfo['payfrom'];
        $disCourseClass = DisCourseClass::where("id", $item->dis_course_class_id)->first();

        $item->state = 1;
        $item->transaction_id = $transaction_id;//支付订单号
        $item->uneffect_time = date('Y-m-d H:i:s',time()+$disCourseClass->team_time*86400);
        $item->payfrom = $payfrom;
        $item->save();        //将订单状态改为1  支付成功

        $finance_a = new FinanceAccount();
        $finance_a->addOne($item->user_id); //查看用户资金账户，如果没有创建一条
        if($item->buy_way != 'TEAM') {
            $disStudy = new DisStudying();
            //整套课程信息

            $disStudy->user_id = $item->user_id;
            $disStudy->dis_course_class_id = $item->dis_course_class_id;
            $disStudy->dis_id = $number[1];//分销员id
            $disStudy->save();

            $course_ids = explode(',', $disCourseClass->course_ids);
            $playRecords = [];
            $period = $this->getPeriods($item->dis_course_class_id);
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

            //推送消息
            $user = DB::table("users")->where("id", $item->user_id)->select("openid")->first();
            if ($user && $user->openid) {
//                $data['type'] = WxMessageType::DISCOURSE;
//                $data['url'] = env('APP_URL') . "/dist/study/{$item->dis_course_class_id}.html";
//                $data['notice'] = "您好，您已成功报名以下课程";
//                $data['message']['key1'] = $item->dis_course_class_title;
//                $data['message']['key2'] = "报名成功后永久开放";
//                $data['message']["remark"] = "记得每天学习打卡哦~";
//                $data['openid'] = $user->openid;
//                $wxpush = new WxMessagePush();
//                $wxpush->sendMessage($data);
//                $sponsorUser = User::where('id',$item->user_id)->first();
                $data['openid'] = $user->openid;
                $data['type'] = 'TEXT';
//                        $name = $sponsorUser->name?$sponsorUser->name:$sponsorUser->nickname;
                $data['text'] = "购买成功，恭喜您获得[{$disCourseClass->title}第1期]~\n扫描下方二维码，加入班级群吧~";
                event(new WxCustomerMessagePush($data));
                $data['openid'] = $user->openid;
                $data['type'] = 'IMAGES';
                $data['media_id'] = "gvmlIDSH-W_k9qgA1XHKmcI8sgcr6PVi0Dnk2YMU8kmv6-OQlL3wli0lVUgY-SfF";
                event(new WxCustomerMessagePush($data));
            }
        }else{
            $team_course_buyed = TeamCourseBuyed::where('cid',$item->dis_course_class_id)->where('user_id',$item->user_id)->first();
            if(!$team_course_buyed){
                $team_course_buyed = new TeamCourseBuyed();
                $team_course_buyed->cid = $item->dis_course_class_id;
                $team_course_buyed->user_id = $item->user_id;
                $team_course_buyed->type = 'train';
                $team_course_buyed->sponsor_id = $item->user_id;
                $team_course_buyed->stage = $item->stage;
                $team_course_buyed->price = $item->price;
                $team_course_buyed->save();
            }
        }
    }
}
