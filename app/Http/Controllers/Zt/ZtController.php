<?php

namespace App\Http\Controllers\Zt;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Wechat_name;
use App\Models\UserGrowSort;
use App\Models\ExperienceQuestion;
use App\Models\SaipuFormTeacher;
use Illuminate\Support\Facades\Redis;
use App\User;
use App\Utils\Alidayu;
use Mail;
use App\Models\Users;
use App\Models\Studying;
use App\Models\Coupon;
use App\Models\UserCoupon;

class ZtController extends Controller
{
    protected $ret;

    public function __construct()
    {
        $this->ret = [];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tuibian()
    {
        
		return view("Zt.tuibian");
    }

    /**/
    public function store(Request $request)
    {
		
        $wechat = new Wechat_name();
        $name = $request->input("name");
        $data = $wechat->where("name",$name)->count();
        
        if($data < 1){
    		$wechat->name =  $name;
            $wechat->url = $request->input("url");
    		$re = $wechat->save();
    		if($re){
    			return "1";
    		}else{
    			return "0";
    		}
        }else{
            return "1";
        }
    }
    //减脂
    public function jianzhi(){

        return view("Zt.jianzhi");
    }
    //坤坤
    public function kunkun(){
        
        return view("Zt.kunkun");
    }
    //钱学森
    public function qianxuesen(){
        return view("Zt.qianxuesen");
    }
    //钱学森的二维码
    public function qianxuesen_href(){
        return view("Zt.qianxuesen-href");
    }


    //活动页面20181207
    public function yearinfo(Request $request){
        $fission_id = $request->input('fission_id',0);
        if($request->user()){
            $userid = $request->user()->id;
            $mobile = $request->user()->mobile ? $request->user()->mobile : 0;  //用户手机号
        }else{
            $userid = 0;
            $mobile = 0;
        }
        $data = array();
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();
        }
        //$data['time']   = time();
        $data['endtime']= strtotime("2018-12-31 24:00:00") - time();
        $data['mobile'] = $mobile;
        $data['user_id']= $userid;
        $data['fission_id'] = $fission_id;
        return view("Zt.yearinfo", $data);
    }

    //预定排行20181207
    public function reserveSort(Request $request){
        $user   = $request->user()?$request->user():0;

        $mobile = $request->user() ? $request->user()->mobile : 0;  //用户手机号
        $userId = 0;
        if($user){
            $userId = $user->id;
        }
        $userSorts = UserGrowSort::orderBy('reserve_num','desc')->paginate(8);
        $selfNum = UserGrowSort::where('user_id',$userId)->select('reserve_num')->first();
        if($selfNum){
            $total = UserGrowSort::where('reserve_num','>',$selfNum->reserve_num)->count();
        }else{
            $total = UserGrowSort::where('reserve_num','>',0)->count();
        }

        return view("Zt.reservesort",['userSorts'=>$userSorts,'count'=>$userSorts->count(),'user'=>$user,'total'=>$total,'selfNum'=>$selfNum, "mobile"=>$mobile]);
    }

    /*
     * 更多排名
     */
    public function getMoreRank(Request $request){
        $userSorts = UserGrowSort::orderBy('reserve_num','desc')->paginate(8);
        if($userSorts->count()){
            return json_encode(['code'=>0,'body'=>view('Zt.body.moreRankBody',['userSorts'=>$userSorts])->render()]);
        }else{
            return json_encode(['code'=>1,'body'=>'无更多排名']);
        }
    }

    //品牌词

    public function pinpaici(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        $this->ret['userid'] = $userid;
        return view("pinpaici.index",$this->ret);
    }
    public function z_card(){
        return view("pinpaici.z_card");
    }
    public function z_class(){
        return view("pinpaici.z_class");
    }
    public function z_envior(){
        return view("pinpaici.z_envior");
    }
    public function z_job(){
        return view("pinpaici.z_job");
    }
    public function z_prize(){
        return view("pinpaici.z_prize");
    }
    public function z_teacher(){
        return view("pinpaici.z_teacher");
    }


    //2019年课程9.0
    public function trainer(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
            $mobile  = $request->user()->mobile ? $request->user()->mobile : 0;  //用户手机号
        }else{
            $userid = 0;
            $mobile = 0;
        }
        $openId = '';
        $fission_id = $request->input('fission_id',0);
        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        $this->ret['openid']  = $openId;
        $this->ret['fission_id'] = $fission_id;
        $this->ret['userid'] = $userid;
        $this->ret['mobile'] = $mobile;
        return view("trainer.index",$this->ret);
    }

    //产品体验官首页
    public function exper(Request $request){
        if($request->user()){
            $user_id = $request->user()->id;
            $mobile  = $request->user()->mobile ? $request->user()->mobile : 0;  //用户手机号
        }else{
            $user_id = 0;
            $mobile  = 0;
        }

        return view("Zt.exper", array("mobile"=>$mobile));
    }

    //产品体验官第二页
    public function experinfo(Request $request){
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }
        $data    = $request->input();
        if($data){
            if($data['info71']){
                $data['info7'] = $data['info7'].'-'.$data['info71'];
            }
            if($data['info111']){
                $data['info11'] = $data['info11'].'-'.$data['info111'];
            }
            $experience = new ExperienceQuestion();
            $experience->info1 = $data['info1'];
            $experience->info2 = $data['info2'];
            $experience->info3 = $data['info3'];
            $experience->info4 = $data['info4'];
            $experience->info5 = $data['info5'];
            $experience->info6 = $data['info6'];
            $experience->info7 = $data['info7'];
            $experience->info8 = $data['info8'];
            $experience->info9 = $data['info9'];
            $experience->info10 = $data['info10'];
            $experience->info11 = $data['info11'];
            $experience->experience1_1 = $data['experience1_1'];
            $experience->experience1_2 = $data['experience1_2'];
            $experience->experience1_3 = $data['experience1_3'];
            $experience->experience1_4 = $data['experience1_4'];
            $experience->experience2   = $data['experience2'];
            $experience->experience3   = $data['experience3'];
            $experience->experience4   = $data['experience4'];
            $experience->experience5   = $data['experience5'];
            $experience->experience6   = $data['experience6'];
            $experience->experience7   = $data['experience7'];
            $experience->product1   = $data['product1'];
            $experience->product2   = $data['product2'];
            $experience->product3   = $data['product3'];
            $experience->product4   = $data['product4'];
            $experience->user_id    = $user_id;
            $r = $experience->save();
            if($r){
                courseSpb($user_id, 24);
                echo json_encode(array("code"=>1, "msg"=>"提交成功"));
            }else{
                echo json_encode(array("code"=>0, "msg"=>"提交失败，请重新填写"));
            }
            return;
        }


        return view("Zt.experinfo");
    }
    /*
    * 新媒体部门咨询老师获取表单页面
    * 20190411
    */
    public function teacherFrom(Request $request){
        $is_local = env("IS_LOCAL");
        $teacher  = $request->input("info", "111");
        switch ($teacher) {
            case 't1':
                $js = 'daade9402481';
                break;
            case 't2':
                $js = '917df1c00ed0';
                break;
            case 't3':
                $js = '04fdf1e050d5';
                break;
            case 't4':
                $js = '990df200be34';
                break;
            case 't5':
                $js = '67cdf2208dca';
                break;
            case 't6':
                $js = '413df240ddf4';
                break;                        
            default:
                $js = '67cdf2208dcanonon';
                break;
        }
        

        $this->ret['js_string'] = $js;
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();  //微信分享
        }

        return view("Zt.teacherform", $this->ret);
    }
    public function junren(){

        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        return view("Zt.junren",$this->ret);
    }

    public function ztZhaoSheng(Request $request){
        $is_local = env("IS_LOCAL");
        $teacher  = $request->input("teacher", "111");
        $zq       = $request->input("zq");  //抓取代码
        switch ($teacher) {
            case 't1':
                $js = 'c89e4240ee2c';
                break;
            case 't2':
                $js = '31fe42c018e9';
                break;
            case 't3':
                $js = 'c99e4300fc43';
                break;
            case 't4':
                $js = '9e9e4320d846';
                break;
            case 't5':
                $js = '5d9e43408944';
                break;
            case 't6':
                $js = '6dfe4360ba8c';
                break;                        
            default:
                $js = '67cdf2208dcanonon';
                break;
        }
        

        $this->ret['js_string'] = $zq;
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        return view('Zt.zhaosheng',$this->ret);
    }
    public function junren_save(Request $request){
        $form   = new SaipuFormTeacher();
        $name   = $request->input("xingming");
        $mobile = $request->input("shouji");
        $url    = $request->input("url");
        $yname  = $request->input("yname");
        $teacher_info = $request->input("teacher");
        $data   = $form->where("mobile",$mobile)->count();
        if($data > 0 ){
            return '已存在表';
        }else{
            $form->uname  = $name;
            $form->mobile = $mobile;
            $form->oldurl = $url;
            $form->yname  = $yname;
            $form->teacher_info  = $teacher_info;
            $form->ip     = $_SERVER["REMOTE_ADDR"];
            $form->datetime = time();
            $form->save();
        }

    }
    /*
    * 赛普视频
    * 20190426
     */
    public function video(){
        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        return view("Zt.video",$this->ret);
    }


    /**
     * 测一测
     */
    public function ceyice(){
        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        return view("Zt.ceyice",$this->ret);
    }

    public function store_ceyice(Request $request){
        $code = $request->input('verifyCode');
        $mobile_code = Redis::get('code_ceyice_'.trim($request->input('shouji')));
        if($mobile_code != $code){
            echo $this->getMessage(1,'验证码有误或已过期');
            return;
        }
        $form = new SaipuFormTeacher();

        $mark = 0;
        if($request->input('r1') == 2){ $mark = $mark + 5; }
        if($request->input('r2') == 1){ $mark = $mark + 10; }
        if($request->input('r3') == 2){ $mark = $mark + 10; }
        if($request->input('r4') == 1){ $mark = $mark + 5; }
        if($request->input('r5') == 3){ $mark = $mark + 10; }
        if($request->input('r6') == 2){ $mark = $mark + 5; }
        if($request->input('r7') == 2){ $mark = $mark + 5; }
        if($request->input('r8') == 1){ $mark = $mark + 5; }
        if($request->input('r9') == 2){ $mark = $mark + 10; }
        if($request->input('r10') == 2){ $mark = $mark + 10; }
        if($request->input('r11') == 2){ $mark = $mark + 10; }
        if($request->input('r12') == 2){ $mark = $mark + 10; }
        $age = $request->input('r14');
        if($age == 1){
            $age = "18岁以下";
        }elseif($age == 2){
            $age = "18-24岁";
        }elseif($age == 3){
            $age = "24-35岁";
        }else{
            $age = "35岁以上";
        }
        $workstatus = $request->input('r15');
        if($workstatus == 1){
            $workstatus = "正在学习健身教练";
        }elseif($workstatus == 2){
            $workstatus = "想学习健身教练，正在考虑中";
        }elseif($workstatus == 3){
            $workstatus = "已经是健身教练";
        }else{
            $workstatus = "毫无兴趣";
        }


        //保存数据
        $form->uname = $request->input('xingming');
        $form->mobile = $request->input('shouji');
        $form->oldurl = $request->input('url');
        $form->yname = $request->input('yname');
        $form->teacher_info = $request->input("teacher");
        $form->age = $age;
        $form->workstatus = $workstatus;
        $form->ip = $_SERVER["REMOTE_ADDR"];
        $form->datetime = time();
        $re = $form->save();

        echo json_encode(array("mark"=>$mark));


    }

    public function getVerifyCode(Request $request){
        $code = $request->input('code','') ? $request->input('code') : mt_rand(100000,999999);

        $this->messageOverNotice();

        $params = array ();
        $time = date('Ymd');
        $sendNum = Redis::get('code_'.$time.'_send');

        $accessKeyId = config('alidayu.access_key_id');
        $accessKeySecret = config('alidayu.access_key_secret');
        $params["PhoneNumbers"] = trim($request->input('mobile'));
        $params["SignName"] = config('alidayu.sign_name');
        $params["TemplateCode"] = config('alidayu.template_code');
        $params['TemplateParam'] = [
            "code" => $code,
        ];
        $flag = $request->input('flag',0);
        $user = User::where('mobile',$params["PhoneNumbers"])->first();

        $mobile_register_num = Redis::get('code_'.$time.'_'.$params["PhoneNumbers"]);
        if($mobile_register_num > 6){
            return $this->getMessage(3,'获取验证码超过最大次数');
        }

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
            Redis::setex('code_ceyice_'.$params["PhoneNumbers"],5*60,$code);
            Redis::incr('code_ceyice_'.$time.'_'.$params["PhoneNumbers"]);
            Redis::expire('code_ceyice_'.$params["PhoneNumbers"],86400);
            $sendKey = 'code_'.$time.'_send';
            if(Redis::exists($sendKey)){
                Redis::incr('code_'.$time.'_send');
            }else{
                Redis::set('code_'.$time.'_send',1);
            }
            echo json_encode(array("code"=>1,"message"=>"发送成功"));
        }else{
            echo json_encode(array("code"=>0,"message"=>"发送失败"));
        };
    }
    /*
    * 短信超限提醒
    */
    private function messageOverNotice(){
        $time = date('Ymd');
        $sendNum = Redis::get('code_'.$time.'_send');
        if($sendNum >=1000){
            $name = '验证码发送超过1000';
            if(!env('IS_LOCAL')){
                $flag = Mail::send('emails.error',['name'=>$name],function($message){
                    $to = ['2465508405@qq.com','892336606@qq.com','1028242057@qq.com'];
                    $message ->to($to)->subject('社区网站bug提醒');
                });
            }
            logger()->info('短信超标提醒');
        }
    }

    /*
     * 领取课程
     * */
    public function get_class(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
            $mobile = $request->user()->mobile;
            $data = Users::where("id",$userid)->select("mobile")->first();


            if($data->mobile !== ''){
                $this->ret['status'] = 1;
            }else{
                $this->ret['status'] = 0;
            }
            $num = Studying::where("user_id",$userid)->where("course_class_id",56)->count();
        }else{
            $num = 0;
            $this->ret['status'] = 0;
            $mobile = "";
        }
        $this->ret['num'] = $num;
        $this->ret['mobile'] = $mobile;

        return view("Zt.get_class",$this->ret);
    }

    public function savedata(Request $request){
        $status = $request->input("status");
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            // return redirect("/login");
            echo $this->getMessage(3,'请在微信端打开此页面');
            return;
        }
        if($status == 0){
            $code = $request->input('verifyCode');
            $mobile_code = Redis::get('code_ceyice_'.trim($request->input('mobile')));
            if($mobile_code != $code){
                echo $this->getMessage(1,'验证码有误或已过期');
                return;
            }
            $users = new Users();
            $data = $users->where("id",$userid)->first();
            $data->mobile = $request->input('mobile');
            $re = $data->save();
            if($re){
                $studying = new Studying();
                $studying->user_id = $userid;
                $studying->course_class_id = 56;
                $studying->save();
                echo json_encode(array("code"=>2, "message"=>"提交成功"));
            }else{
                echo json_encode(array("code"=>0, "message"=>"提交失败"));
            }
        }else{
            $studying = new Studying();
            $num = $studying->where("user_id",$userid)->where("course_class_id",56)->count();
            if($num > 0){
                echo json_encode(array("code"=>2, "message"=>"领取成功"));
            }else{
                $studying->user_id = $userid;
                $studying->course_class_id = 56;
                $re = $studying->save();
                if($re){
                    echo json_encode(array("code"=>2, "message"=>"领取成功"));
                }else{
                    echo json_encode(array("code"=>0, "message"=>"提交失败"));
                }
            }
        }
    }
    /**
     * 领取优惠券
     */
    public function get_coupon(Request $request){
        if($request->user()) {
            $userid = $request->user()->id;

            $data = Coupon::first();

            $UserCoupon = new UserCoupon();
            $is_get = $UserCoupon->where("user_id", $userid)->where("coupon_id", $data->id)->count();
            $this->ret['course_class_group_id'] = $data->course_class_group_id;
        }else{
            $is_get = 0;
        }

        $this->ret['is_get'] = $is_get;
        return view("Zt.get_coupon",$this->ret);
    }
    /**
     * 获取优惠券
     */
    public function getcoupon(Request $request){


        if($request->user()){
            $userid = $request->user()->id;

            $data = Coupon::first();

            $UserCoupon = new UserCoupon();
            $is_get = $UserCoupon->where("user_id",$userid)->where("coupon_id",$data->id)->first();

            if($is_get){
                echo json_encode(array("code"=>0, "message"=>"您已领取过了哟~","course_class_group_id"=>$data->course_class_group_id));
            }else{
                $UserCoupon->user_id = $userid;
                $UserCoupon->coupon_id = $data->id;
                $UserCoupon->days = $data->days;
                $UserCoupon->start_time = date("Y-m-d",time());
                $UserCoupon->end_time = date("Y-m-d",time()+10*60*60*24);
                $re = $UserCoupon->save();
                echo json_encode(array("code"=>0, "message"=>"领取成功", "course_class_group_id"=>$data->course_class_group_id));
            }

        }else{
            echo json_encode(array("code"=>0, "message"=>"请先登录再领取哦"));
        }

    }
}
