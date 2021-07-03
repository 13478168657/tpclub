<?php

namespace App\Http\Controllers\A;

use App\Models\Courseclass;
use App\Models\CourseClassGroup;
use App\Models\IntroActiveUser;
use App\Models\TfOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utils\ImageThumb;
use App\Models\Studying;
use App\Models\Questionnaire;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\TfCourseClass;
use App\Models\TfCount;
use App\Models\TfCountRecord;
use App\Models\UserCoupon;
use App\Models\UserCourseFeedback;
use App\Models\OrderCourseGroup;
use Illuminate\Support\Facades\DB;
use App\Utils\CurlUtil;
use App\Utils\MakeThumbPic;
use App\Constant\CustomerPushType;
use App\Events\WxCustomerMessagePush;
use App\Http\Controllers\Wechat\WechatController;
use Illuminate\Support\Facades\Redis;
use App\Utils\Alidayu;
use App\User;
//require app_path().'/Library/Wechat/WxPay.JsApiPay.php';
class ActivityController extends Controller
{

    public function index(Request $request){


        return view('a.index');
    }


    public function scoreInfo(Request $request){
        $score = $request->input('score');
        $type = $request->input('type');
//        $name = $request->input('name');
        $user = $request->user();
        if($user){
            $flag = $request->user()->mobile?1:0;
            $name = $user->nickname;
        }else{
            $flag = 0;
            $name = '';
        }
        return view('a.scoreInfo',['score'=>$score,'type'=>$type,'name'=>$name,'flag'=>$flag]);
    }

    public function inviteUser(Request $request){
        $score = $request->input('score');
        $type = $request->input('type');
        $user = $request->user();

        if($user){
            $name = $user->nickname;
//            $name = 'ce';
//            $length = strlen($name);
//            if($length == 3){
//                $scoreArr = [330,290,200];
//            }elseif($length < 3){
//                $scoreArr = [330-15*(3-$length),290,200-15*(3-$length)];
//                $scoreArr = [330-15*(3-$length),290,200-15*(3-$length)];
//            }else{
//                $scoreArr = [330+22*($length-3),290,200+22*($length-3)];
//            }
            $scoreArr = [210,300,80,300];
        }else{
            $name = '';
            $scoreArr = [210,290,80,290];
        }
        $nameArr = [80,230];
        $sizeArr = [];
        if($score >85){
            $pic =  public_path()."/activity/images/score100.jpg";
            $codePic = public_path()."/activity/images/img5.png";
            $sizeArr = ['code'=>[380,1060],'name'=>$nameArr,'score'=>$scoreArr];
        }elseif($score >= 50 && $score <= 85){
            $pic =  public_path()."/activity/images/score68.jpg";
            if($score == 50){
                $codePic = public_path()."/activity/images/img4.png";
            }elseif($score == 55 || $score == 60 || $score == 65 || $score == 70 || $score == 80){
                $codePic = public_path()."/activity/images/img2.png";
            }else{
                $codePic = public_path()."/activity/images/img5.png";
            }
            $sizeArr = ['code'=>[380,1060],'name'=>$nameArr,'score'=>$scoreArr];
        }elseif($score >= 15 && $score <= 45){
            $pic =  public_path()."/activity/images/score24.jpg";
            if($score == 15){
                $codePic = public_path()."/activity/images/img6.png";
            }elseif($score == 20 || $score == 30 || $score == 35){
                $codePic = public_path()."/activity/images/img1.png";
            }elseif($score == 40 || $score ==  45){
                $codePic = public_path()."/activity/images/img4.png";
            }
            $sizeArr = ['code'=>[380,1010],'name'=>$nameArr,'score'=>$scoreArr];
        }elseif($score == 0){
            $pic =   public_path()."/activity/images/score0.jpg";
            $codePic = public_path()."/activity/images/img7.png";
            $sizeArr = ['code'=>[380,1010],'name'=>$nameArr,'score'=>$scoreArr];
        }

        $imageThumb = new ImageThumb();

        $res = $imageThumb->makeActivityPic($pic,$codePic,$name,$score,$sizeArr);
        $picContent = $this->getPic($res);
        return ['code'=>0,'body'=>$picContent];
    }

    public function getPic($res){
        $content =
        '<div class="bm_success_layer text_center tan-font"><img src="'.$res[1].'" class="bm_success" />';
        return $content;
    }

    public function getCourse(Request $request){
        $user = $request->user();
        if($user && $user->mobile){
            $study = new Studying();
            $study->addOne($user->id,6);
            return $this->getMessage(0,'获取成功');
        }else{
            return $this->getMessage(1,'用户未注册');
        }
    }

    /*
     * 反馈列表
     */
    public function userFeedBack(Request $request){

        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        return view('a.feedback',$this->ret);
    }

    /*
     * 提交就业反馈
     */
    public function postFeedBack(Request $request){
//        dd($request->all());
        $work_status = $request->input('status');
        $work_unit = $request->input('unit');
        $entry_time = $request->input('time');
        $wages = $request->input('salary');
        $questions = $request->input('question');
        $name = $request->input('name');
        $mobile = $request->input('mobile');
        $semester = $request->input('number');
        $city = $request->input('city');
        $user_id = $request->user()?$request->user()->id:0;
        if(!$user_id){
            return $this->getMessage(2,'用户未登陆');
        }
        $answer = config('distAnswer.feedback');
        $coupon = Coupon::where('state',1)->first();

        if(!$coupon){
            return $this->getMessage(1,'无优惠券');
        }
        $userCoupon = UserCoupon::where('user_id',$user_id)->where('coupon_id',$coupon->id)->select('id')->first();
        if($userCoupon){
            return $this->getMessage(1,'已提交就业反馈');
        }
        $giveCourse = [];
        if(!empty($coupon->course_class_id)){
            $giveCourse = Courseclass::where('id',$coupon->course_class_id)->first();
            $url = '/course/detail/'.$coupon->course_class_id.'.html';
        }
        if(!empty($coupon->course_class_group_id)){
            $giveCourse = CourseClassGroup::where('id',$coupon->course_class_group_id)->first();
            $url = '/train/study.html?id='.$coupon->course_class_group_id;
        }
        $content = $this->getCardInfo($giveCourse,$coupon);
        DB::beginTransaction();

        try{
            $question = Questionnaire::where('user_id',$user_id)->first();
            if(!$question){
                $question = new Questionnaire();
            }
            $question->work_status = isset($answer['status'][$work_status])?$answer['status'][$work_status]:'';
            $question->work_unit = $work_unit;
            $question->entry_time = $entry_time;
            $question->wages = $wages;
            $question->questions = $questions;
            $question->name = $name;
            $question->mobile = $mobile;
            $question->semester = isset($answer['number'][$semester])?$answer['number'][$semester]:'';
            $question->city = $city;
            $question->save();
            $userCoupon = new UserCoupon();
            $userCoupon->user_id = $user_id;
            $userCoupon->days = $coupon->days;
            $userCoupon->start_time = date('Y-m-d');
            $userCoupon->end_time = date('Y-m-d',time()+$coupon->days*86400);
            $userCoupon->is_use = 0;
            $userCoupon->coupon_id = $coupon->id;
            $userCoupon->save();
            DB::commit();
            return $this->getMessage(0,'保存成功',['content'=>$content,'url'=>$url]);
        }catch(\Exception $e){
            DB::rollback();
            return $this->getMessage(1,$e->getMessage());
        }
    }

    private function getCardInfo($giveInfo,$coupon){
        $info = '<div class="fz f28 pt40"><p class="pb20 bold color_333">恭喜你获得<span class="color_ff7e00">￥'.$coupon->price.'元</span></p><p class="color_ff7e00 bold">【'.$giveInfo->title.'】抵用券</p><p class="f24 pt40">仅限有效期内使用</p></div>';
        return $info;
    }

    public function travelManage(Request $request){

        $id = $request->input('fission_id');
        $data['fission_id'] = $id;
        return view('a.travel',$data);
    }

    public function checkout(Request $request,$type){

        $data['type'] = $type;

        if($type == 1){

            return view('a.check1');
        }elseif($type == 2){

            return view('a.check2');
        }else{

            return view('a.check3');
        }
    }

    public function feedBack(Request $request,$type){

        $user = $request->user();
        $flag = 0;
        if($user){
            if($user->mobile){
                $flag = 1;
            }
        }
        $data['flag'] = $flag;

        if($type == 1){

            return view('a.feedback.feedback1',$data);
        }elseif($type == 2){

            return view('a.feedback.feedback2',$data);
        }else{

            return view('a.feedback.feedback3',$data);
        }
    }

    /*
     *保存职业规划反馈表
     */
    public function postUserFeedback(Request $request){

        $type = $request->input('type',1);
        $user_id = $request->user()?$request->user()->id:0;
        $data = $request->all();
        unset($data['_token']);
        unset($data['_url']);
        unset($data['type']);
        $content = json_encode($data);
        if($type == 1){
            $img_url = explode(',',$data['imgurl_list']);
            $dataArr = [];
            if(!empty($img_url)){
                foreach($img_url as $url){
                    if(!empty($url)){
                        $dataArr[] = env('IMG_URL').$url;
                    }
                }
                $img_url = implode(',',$dataArr);
            }else{
                $img_url = '';
            }
            $data['imgurl_list'] = $img_url;
        }
        $userFeedback = UserCourseFeedback::where('user_id',$user_id)->where('type',$type)->first();
        if($userFeedback){
            return $this->getMessage('1','已提交，不可重复提交');
        }
        $userFeedback = new UserCourseFeedback();
        $userFeedback->type = 1;
        $userFeedback->content = $content;
        $userFeedback->user_id = $user_id;

        if($userFeedback->save()){
            return $this->getMessage(0,'提交成功');
        }else{
            return $this->getMessage(1,'保存失败');
        }
    }

    public function feedRedirect(Request $request){

        $user = $request->user();
        if($user){

        }

        return view('a.feedback.redirect');
    }

    public function scollInfo(Request $request){

        return view('a.xuanchuan');
    }

    //nasm反馈表
    public function nasmActive(Request $request){

        $courseClass = Courseclass::where('id',58)->first();
        $is_local = env("IS_LOCAL");
        $fission_id = $request->input('fid',0);
        $user = $request->user();
        if($user){
            $user_id = $user->id;
        }else{
            $user_id = 0;
        }
        $stageArr = [1=>30,2=>160,3=>165];
        $firstNum = $stageArr[1] - Order::where('course_class_id',58)->where('state',1)->where('stage',1)->select('id')->count();
        $secondNum = $stageArr[2] - Order::where('course_class_id',58)->where('state',1)->where('stage',2)->select('id')->count();
        $thirdNum = $stageArr[3] - Order::where('course_class_id',58)->where('state',1)->where('stage',3)->select('id')->count();
        $restNum = $firstNum + $secondNum + $thirdNum;
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
            $data['shareUrl'] = '';
        }else{
            $data['WechatShare'] = getSignPackage();
            $weChat    = new WechatController();

            $codeUrl = $weChat->getQRcodeUrl("nasm_active",'/upload/share/');

            $imageThumb  = new MakeThumbPic();

            $activity = 9;
            $bodyPic = '/images/zt/nasmcpt/subscribe.jpg';
            $img = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$codeUrl;

            $img_url = $imageThumb->makePic($bodyPic, '', $img,'upload/share/','',$activity);

            $data['shareUrl'] = 'http://m.saipubbs.com/'.$img_url[1];
        }

        $data['courseClass'] = $courseClass;
        $data['user_id'] = $user_id;
        $data['restNum'] = $restNum;
        $data['fission_id'] = $fission_id;
        return view('a.nasm.active',$data);
    }

    public function nasmApply(Request $request){
        $questionArr = [];
        $answerArr = [];

        $user = $request->user();
//        if($user){
//            $name = $user->name?$user->name:$user->nickname;
//        }else{
//            $name = '';
//        }

        $weChat    = new WechatController();

        $codeUrl = $weChat->getQRcodeUrl("nasm_active",'/upload/share/');

        $imageThumb  = new MakeThumbPic();

        $activity = 9;
        $bodyPic = '/images/zt/nasmcpt/subscribe.jpg';
        $img = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$codeUrl;

        $img_url = $imageThumb->makePic($bodyPic, '', $img,'upload/share/','',$activity);

        $shareUrl = 'http://m.saipubbs.com/'.$img_url[1];
        return ['code'=>0,'body'=>['shareUrl'=>$shareUrl]];
    }

    public function nasmForm(Request $request){

        $user = $request->user();
        $mobile = '';
        if($user){
            if($user->mobile){
                $mobile = $user->mobile;
            }
        }
        $stageArr = [1=>30,2=>160,3=>165];
        $firstNum = $stageArr[1] - Order::where('course_class_id',58)->where('state',1)->where('stage',1)->select('id')->count();
        $secondNum = $stageArr[2] - Order::where('course_class_id',58)->where('state',1)->where('stage',2)->select('id')->count(); 
        $thirdNum = $stageArr[3] - Order::where('course_class_id',58)->where('state',1)->where('stage',3)->select('id')->count();
        $restNum = $firstNum + $secondNum + $thirdNum;
        $data['mobile'] = $mobile;
        $data['restNum'] = $restNum;
        return view('a.nasm.form',$data);
    }

    public function infoVerify(Request $request){

        $user = $request->user();

        if($user){
            if(!$user->mobile){

            }
            $user_id = $user->id;
        }else{
//            return
            $user_id = 0;
        }
        $idCard = $request->input('card');

        $satisfy = 0;
        $url = 'http://101.201.81.14:9315/saipu-app-ins/api/trainee_info_status?idNumber='.$idCard;
        $result = CurlUtil::appCurl($url, [], 'GET');
        $resInfo = json_decode($result, true);
        if (isset($resInfo['code']) && $resInfo['code'] == 0) {
            if (isset($resInfo['result']['studentStatus']) && $resInfo['result']['studentStatus'] == '01') {
                $satisfy = 1;
            }
            if (isset($resInfo['result']['studentStatus']) && $resInfo['result']['studentStatus'] == '03') {
                $satisfy = 1;
            }
        }
        if(!$satisfy){
            $isBuy = $this->isBuyedCourse($user_id);
            if($isBuy){
                $satisfy = 1;
            }
        }
        $data['satisfy'] = $satisfy;
        if($user){
            $send['openid'] = $user->openid;
        }else{
            $send['openid'] = '';
        }
        $send['type'] = 'TEXT';
        if($satisfy){
            $send['text'] = "恭喜您，获得4700元学习NASM资格！→"."<a href='http://m.saipubbs.com/course/detail/58.html'>立即报名</a>";
        }else{
            $send['text'] = "十分抱歉，您不符合4700元学习NASM资格，可能您不是赛普在校生，您可以选择申请赛普学籍~
→"."<a href='http://m.saipubbs.com/nasm/apply.html'>申请赛普学籍</a>，4700元学NASM→";
        }
        if(env('IS_LOCAL')== false){
            event(new WxCustomerMessagePush($send));
        }

        return $this->getMessage(0,'验证成功',$data);
    }

    public function nasmInfo(Request $request,$type){

//        $satisfy = $request->input('type',0);
        $data['satisfy'] = $type;
//        dd($satisfy);
        return view('a.nasm.result',$data);
    }

    public function nasmAccess(Request $request){

        $stageArr = [1=>30,2=>160,3=>165];
        $firstNum = $stageArr[1] - Order::where('course_class_id',58)->where('state',1)->where('stage',1)->select('id')->count();
        $secondNum = $stageArr[2] - Order::where('course_class_id',58)->where('state',1)->where('stage',2)->select('id')->count();
        $thirdNum = $stageArr[3] - Order::where('course_class_id',58)->where('state',1)->where('stage',3)->select('id')->count();
        $restNum = $firstNum + $secondNum + $thirdNum;

        $data['restNum'] = $restNum;
        return view('a.nasm.recommand',$data);
    }


    /*
     * 判断是否购买组合课程
     */
    private function isBuyedCourse($userid){
        $groupOrder = OrderCourseGroup::where('user_id',$userid)->whereIn('course_class_group_id',[1,4])->where('state',1)->select('id')->first();
        $buyGroup = 0;
        if($groupOrder){
            $buyGroup = 1;
        }
        return $buyGroup;
    }

    public function jtCourse(Request $request){

        return view('a.junti.course');
    }

    public function jtJunren(Request $request){

        return view('a.junti.junren');
    }

    public function jtVerify(Request $request){

        return view('a.junti.verify');
    }

    public function jtConsult(Request $request){

        $user = $request->user();
        if($user){
            $mobile = $user->mobile;
        }else{
            $mobile = '';
        }
        return view('a.junti.consult',['mobile'=>$mobile]);
    }

    /*
     * 同步数据
     */

    public function jtSync(Request $request){

        $share_id = 0;
        $user = $request->user();
        $channel = 0;
        $from = '';
        users_growing($share_id,$user->id,$channel,$from,1);
        return $this->getMessage('0','通过成功');
    }

    /*
     * 学员就业需求搜集
     */
    public function stuCollect(Request $request){

        $user = $request->user();
        if(!$user) {

            return redirect('/register?redirect=/stu/info/collect');
        }
        $introUser = IntroActiveUser::where('user_id',$user->id)->where('type','JIUYEINFO')->first();
        if($introUser) {
            $userInfo = json_decode($introUser->user_info);
        }else{
            $userInfo = '';
        }
        return view('a.feedback.userInfo',['userInfo'=>$userInfo]);
    }

    public function infoCreate(Request $request){

        $user = $request->user();

        $introUser = IntroActiveUser::where('user_id',$user->id)->where('type','JIUYEINFO')->first();
        $userInfo = $request->all();
        unset($userInfo['_url']);
        unset($userInfo['_token']);
        $url = 'http://101.201.81.14:9315/saipu-app-ins/api/intro/student_info?stuIdNo='.$userInfo['idcard'];
        $result = CurlUtil::appCurl($url, [], 'GET');
        $resInfo = json_decode($result, true);
        logger()->info($resInfo);
        if($resInfo['code'] == 0){
            $resultInfo = $resInfo['result'];
            $userInfo['userName'] = $resultInfo['studentName'];
            $userInfo['studentId'] = $resultInfo['studentId'];
            $userInfo['courseSet'] = $resultInfo['courseSet'];
            $userInfo['campusName'] = $resultInfo['campusName'];
            $userInfo['campus'] = $resultInfo['campus'];
            $userInfo['className'] = $resultInfo['className'];
            $userInfo['termName'] = $resultInfo['termName'];
            $userInfo['termNo'] = $resultInfo['termNo'];
            $userInfo['classTeacherName'] = $resultInfo['classTeacherName'];
            $userInfo['native'] = $resultInfo['nativeArea1Name'].$resultInfo['nativeArea2Name'];
        }else{
            $userInfo['userName'] = '';
            $userInfo['studentId'] = '';
            $userInfo['courseSet'] = '';
            $userInfo['campusName'] = '';
            $userInfo['campus'] = '';
            $userInfo['className'] = '';
            $userInfo['termName'] = '';
            $userInfo['termNo'] = '';
            $userInfo['classTeacherName'] = '';
            $userInfo['native'] = '';
        }

        if(!$introUser) {

            $introUser = new IntroActiveUser();
            $introUser->type = 'JIUYEINFO';
            $introUser->user_id = $user->id;
        }
        $introUser->user_info = json_encode($userInfo);
        $introUser->save();
        return $this->getMessage(0,'提交成功');
    }

    public function formCourse(Request $request,$id){
        $user = $request->user();
        if($user){
            $userid = $user->id;
        }else{
            $userid = 0;
        }
        $introUser = IntroActiveUser::where('user_id',$userid)->where('type','DOITFEEDBACK')->first();
        $flag = 0;
        if($introUser){
            $userInfo = json_decode($introUser->user_info);
            $data['identify'] = $userInfo->identify;
            $data['is_know'] = $userInfo->is_know;
            $data['know_way'] = $userInfo->know_way;
            $data['other_way'] = isset($userInfo->other_way)?$userInfo->other_way:'';
            $data['join_way'] = $userInfo->join_way;
            $data['destination'] = $userInfo->destination;
            $data['other_dest'] = $userInfo->other_dest;
            $data['other_profit'] = $userInfo->other_profit;
            $flag = 1;
        }else{
            $data['identify'] = '';
            $data['is_know'] = '';
            $data['know_way'] = '';
            $data['other_way'] = '';
            $data['join_way'] = '';
            $data['destination'] = '';
            $data['other_dest'] = '';
            $data['other_profit'] = '';
        }
        $data['flag'] = $flag;
        $data['cid'] = $id;
        return view('a.formCourse',$data);
    }

    /*
     * 活动问卷反馈
     */
    public function postDoItFeedback(Request $request){
        $user = $request->user();

        if(!$user){
            return $this->getMessage(2,'未登录');
        }
        $userInfo = $request->all();

        unset($userInfo['_url']);
        unset($userInfo['_token']);
        $cid = $userInfo['cid'];
        $introUser = IntroActiveUser::where('user_id',$user->id)->where('type','DOITFEEDBACK')->first();

        if(!$introUser) {

            $introUser = new IntroActiveUser();
            $introUser->type = 'DOITFEEDBACK';
            $introUser->user_id = $user->id;
            // dd(json_encode($userInfo));
            $introUser->user_info = json_encode($userInfo);
            $res = $introUser->save();
            if($res){
                $studying = Studying::where('course_class_id',$cid)->where('user_id',$user->id)->select('id')->first();
                if(!$studying){
                    $studying = new Studying();
                    $studying->user_id = $user->id;
                    $studying->course_class_id = $cid;
                    $studying->save();
                }
                return $this->getMessage(0,'已提交');
            }else{
                return $this->getMessage(1,'提交失败');
            }

        }else{
//            $introUser->type = 'DOITFEEDBACK';
//            $introUser->user_id = $user->id;
//            $introUser->user_info = json_encode($userInfo);
//            $res = $introUser->save();
            return $this->getMessage(1,'课程已经领取 请在赛普健身社区【我的课表】中查看');
//            return $this->getMessage(1,'已参与问卷调查,请在【我的课程】中查看详情');
        }

    }

    /*
     * 活动课设置
     */
    public function lineliveCourse(Request $request){
        $user = $request->user();
        if(!$user){
            $user_id = 0;
        }else{
            $user_id = $user->id;
            //echo $user_id;
        }
        $is_pay = $request->input("is_pay", 0);
        $phone  = $request->input("mobile",0);
        $tf_course_class_id = $request->input("id", 1);
        if($user_id){
            $order  = TfOrder::where("user_id", $user_id)->where("tf_course_class_id", $tf_course_class_id)->where("state",1)->first();
            if($order){
                $is_pay = 1;
            }
        }
        if($phone){
            $order  = TfOrder::where("phone", $phone)->where("tf_course_class_id", $tf_course_class_id)->where("state",1)->first();
            if($order){
                $phone = 1;
            }
            //echo $phone;
        }
        $tfCourseClass = TfCourseClass::where('state',1)->where("id", $tf_course_class_id)->first();
        $buyNum = TfOrder::where('state',1)->where('tf_course_class_id',$tf_course_class_id)->count();
        $tfOrders = TfOrder::where('state',1)->where('tf_course_class_id',$tf_course_class_id)->orderBy('id','desc')->take(10)->get();
        $data['buyNum'] = $buyNum;
        $data['limitNum'] = 1000;
        $data['tfOrders'] = $tfOrders;
        $data['is_pay']   = $is_pay;
        $data['phone']    = $phone;
        $data['tfCourseClass'] = $tfCourseClass;

        $this->count_pv_uv($tf_course_class_id, $user_id);
        return view('a.vote.douyin',$data);
    }
    /**
     * [sendInfoStop description]
     * @param  Request $request [description]
     * @return [type]           [description]
     * luyahe
     * 20200902
     */
    public function sendInfoStop(Request $request){
        $orders = TfOrder::where("tf_course_class_id", 7)->where("state", 1)->where("send_info", 0)->offset(0)->limit(20)->get();
        foreach($orders as $order){
            $this->sendData($order);
        }
    }

    public function sendData($order){
        //购课通知短信
        $params = [];
        $params["PhoneNumbers"] = $order->phone;
        $params["TemplateCode"] = 'SMS_200694204';
        $params['TemplateParam'] = [
            "course" => '健身教练学前体验课，七大肌肉群训练教程'
        ];
        $this->sendCode($params, $order);
    }

    public function sendCode($data,$order){
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
        if($content->Code=='OK'){
            logger()->info('success');
            $order->send_info =1;
        }else{
            logger()->info('error');
            logger()->info($content->Code);
            $order->send_info =0;
            //logger()->info($content);
        };
        $order->save();
    }

    public function getVerifyCode(Request $request){
        $code = $request->input('code','') ? $request->input('code') : mt_rand(100000,999999);
        $params = array ();
        $time = date('Ymd');
        $accessKeyId = config('alidayu.access_key_id');
        $accessKeySecret = config('alidayu.access_key_secret');
        $params["PhoneNumbers"] = trim($request->input('mobile'));
        $params["SignName"] = config('alidayu.sign_name');
        $params["TemplateCode"] = config('alidayu.template_code');
        $params['TemplateParam'] = [
            "code" => $code,
        ];
        
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
        if($content->Code=='OK'){
            Redis::setex('code_'.$params["PhoneNumbers"],5*60,$code);
            Redis::incr('code_'.$time.'_'.$params["PhoneNumbers"]);
            Redis::expire('code_'.$params["PhoneNumbers"],86400);

            echo json_encode(array("code"=>1,"message"=>"发送成功"));
        }else{
            echo json_encode(array("code"=>0,"message"=>"发送失败"));
        };
    }

    /*
    *统计投放页pv/uv
    *20200209
    */
    public function count_pv_uv($tf_course_class_id, $user_id){
        $date = date("Y-m-d");
        $data = array();
        $data['tf_course_class_id'] = $tf_course_class_id;
        $data['type'] = 'pv';
        $data['date'] = $date;
        $data['user_id'] = $user_id;
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['updated_at'] = date("Y-m-d H:i:s");
        //新增记录
        $r = DB::table("tf_count_record")->insert($data);
        
        $record_uv = TfCountRecord::where("date", $date)->where("user_id",$user_id)->where("type", "uv")->first();
        if($record_uv){
            $uv = 0;
        }else{
            $uv = 1;
        }
        $data['type'] = 'uv';
        $r1 = DB::table("tf_count_record")->insert($data);
        $count_pv = TfCount::where("date", $date)->where("tf_course_class_id", $tf_course_class_id)->first();
        if($count_pv){
            $count_pv->pv = $count_pv->pv+1;
            $count_pv->uv = $count_pv->uv+$uv;
        }else{
            $count_pv     = new TfCount();
            $count_pv->pv = 1;
            $count_pv->uv = 1;
            $count_pv->date = $date;
            $count_pv->tf_course_class_id = $tf_course_class_id;
        }
        $count_pv->save();
    }
}



