<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\FinanceAccount;
use App\Models\Studying;
use App\Models\Courseclass;
use App\Utils\Alidayu;
use App\Utils\CurlUtil;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use App\Events\WxCustomerMessagePush;
use App\Constant\CustomerPushType;
use App\Models\UsersAttribute;
use Mail;
use Validator;
require app_path().'/Library/Wechat/WxPay.JsApiPay.php';
class LoginController extends Controller
{

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function login(Request $request){

        return view('login.login');
    }

    /*
     * 用户注册
     */
    public function register(Request $request){
        $openId = '';
//        if(is_weixin()){
//            $tools = new \JsApiPay();
//            $openId = $tools->GetOpenid();
//        }
        return view('login.register' ,['openid'=>$openId]);
    }
    /*
     *用户登录操作
     */
    public function postLogin(Request $request){
        $mobile = $request->input('mobile');
        $password = $request->input('password');
        if(empty($mobile)){
            return $this->getMessage(1,'手机号不能为空');
        }
        if(empty($password)){
            return $this->getMessage(2,'密码不能为空');
        }

        if (Auth::attempt(['mobile' => $mobile, 'password' => md5($password)],true)) {
            return $this->getMessage(0,'登录成功');
        }
        return $this->getMessage(3,'手机号或密码错误');
    }

    /*
     *用户登录操作2018-12-21 临时测试
     */
    public function postLogins(Request $request){
        echo 33333;
        return;

        $mobile = $request->input('mobile');
        $password = $request->input('password');
        if(empty($mobile)){
            return $this->getMessage(1,'手机号不能为空');
        }
        if(empty($password)){
            return $this->getMessage(2,'密码不能为空');
        }

        if (Auth::attempt(['mobile' => $mobile,'is_admin'=>0, 'password' => md5($password)],true)) {
            return $this->getMessage(0,'登录成功');
        }
        return $this->getMessage(3,'手机号或密码错误');
    }
    /*
     * 密码找回
     */
    public function passwordBack(Request $request){
        $code = $request->input('code');
        $mobile = trim($request->input('mobile'));
        $password = $request->input('password');
        $rePassword = $request->input('repassword');
        $mobile_code = Redis::get('code_'.trim($mobile));
        $time = date('Ymd');
        $user = User::where('mobile',$mobile)->first();
        if(!$user){
            return $this->getMessage(1,'该手机号未注册');
        }
        $reg_mobile  = '/^1[3|4|5|6|7|8|9]{1}\d{9}$/';
        if(!preg_match($reg_mobile,$mobile)){
            return $this->getMessage(2,'手机号格式错误');
        }
        if($mobile_code != $code){
            return $this->getMessage(3,'验证码有误或已过期');
        }

        if($password != $rePassword){
            return $this->getMessage(4,'两次密码不一致');
        }
        $user = User::where('mobile',$mobile)->first();
        $user->mobile = $mobile;
        $user->password = bcrypt(md5($password));
        if($user->save()){
            Auth::loginUsingId($user->id);
            return $this->getMessage(0,'密码找回成功');
        }else{
            return $this->getMessage(5,'密码找回失败');
        }
    }

    public function getVerifyCode(Request $request){

        $code = $request->input('code','') ? $request->input('code') : mt_rand(100000,999999);

        $params = array ();
        $time = date('Ymd');
//        $sendNum = Redis::get('code_'.$time.'_send');

        $accessKeyId = config('alidayu.access_key_id');
        $accessKeySecret = config('alidayu.access_key_secret');
        $params["PhoneNumbers"] = trim($request->input('mobile'));
        $params["SignName"] = config('alidayu.sign_name');
        $params["TemplateCode"] = config('alidayu.template_code');
        $params['TemplateParam'] = [
            "code" => $code,
        ];
        $verify = $request->input('verify','');
        if(!$verify) {
            $flag = $request->input('flag',0);
            $user = User::where('mobile',$params["PhoneNumbers"])->first();

            if ($flag == 3) {
                $curUser = $request->user();
                if ($curUser) {
                    //                return $this->getMessage(1,'用户未登录');
                    if ($user) {
                        if ($user->id == $curUser->id) {
                            return $this->getMessage(1, '手机号与用户当前手机号一致，无需绑定');
                        }
                    }
                }
            } else {
                if (!is_weixin() && $user && $flag == 0) {
                    //                return $this->getMessage(4,'手机号已注册');
                }
                if (is_weixin()) {
                    $weixinUser = $request->user();
                    if ($weixinUser && $weixinUser->mobile == $params["PhoneNumbers"] && $flag == 0) {
                        //                    return $this->getMessage(4,'手机号已注册');
                    }
                }
            }
        }

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
            Redis::setex('code_'.$params["PhoneNumbers"],5*60,$code);
            Redis::incr('code_'.$time.'_'.$params["PhoneNumbers"]);
            Redis::expire('code_'.$params["PhoneNumbers"],86400);
//            $sendKey = 'code_'.$time.'_send';
//            if(Redis::exists($sendKey)){
//                Redis::incr('code_'.$time.'_send');
//            }else{
//                Redis::set('code_'.$time.'_send',1);
//            }
            echo json_encode(array("code"=>1,"message"=>"发送成功"));
        }else{
            echo json_encode(array("code"=>0,"message"=>"发送失败"));
        };
    }

    /*
     * 用户绑定手机号
     */
    public function postRegister(Request $request){
        $code = $request->input('verifyCode');
        $mobile = $request->input('mobile');
//        $password = $request->input('password');
        $share_id = $request->input('share_id',0);
        $mobile_code = Redis::get('code_'.trim($mobile));
        $channel = $request->input('channel');
        $from = $request->input('from','');
        $job = $request->input('job','');
//        $utm_source = $request->input('utm_source','');
//        $utm_medium = $request->input('utm_medium','');
//        $openid = $request->input('op');
//        $time = date('Ymd');
//       
        if($code!='656565'){
            if($mobile_code != $code){
                return $this->getMessage(1,'验证码有误或已过期');
            }
        }
        
        $reg_mobile  = '/^1[3|4|5|6|7|8|9]{1}\d{9}$/';

        if(!preg_match($reg_mobile,$mobile)){
            return $this->getMessage(2,'手机号格式错误');
        }
//        if(strlen($password)<6 || strlen($password)>20){
//            return $this->getMessage(3,'密码长度有误');
//        }
        $user    = User::where('mobile',$mobile)->first();//第一次注册用户
        $oldUser = $request->user();   //微信授权用户
        $flag    = 1;
        if(!is_weixin()){  //外部浏览器
            if($user){
                Auth::loginUsingId($user->id);
                return $this->getMessage(0,'登录成功');
            }else{
                $user = new User();
            }
        }else{  //微信浏览器浏览器
            if($oldUser->mobile == $mobile){
                return $this->getMessage(0,'登录成功');
            }else{
                if($user){
                    //合并用户，将老用户合并到新用户
                    $user->nickname = $oldUser->nickname;
                    if(empty($user->avatar)){
                        $user->avatar = $oldUser->headimgurl;
                    }
                    if($user->unionid){
                        return $this->getMessage(5,'手机号已注册');
                    }
                    $user->openid  = $oldUser->openid;
                    $user->unionid = $oldUser->unionid;
                    //删除老用户
                    User::where('id',$oldUser->id)->delete();
                    $flag = 0;
                }else{
                    $user = User::where('id',$oldUser->id)->first();
                }
            }
        }
        $user->mobile = $mobile;
        DB::beginTransaction();
        try{
            if($user->save()){
                $attribute = UsersAttribute::where("user_id", $user->id)->first();
                if(!$attribute){
                    $attribute = new UsersAttribute();
                    $attribute->user_id = $user->id;
                    $attribute->job = $job;
                    $attribute->save();
                }else{
                    $attribute->job = $job;
                    $attribute->save();
                }

                $this->syncUserInfoToApp($user);
                if(!is_weixin()){
                    Auth::loginUsingId($user->id);
                }else{
                    Auth::logout();
                    Auth::loginUsingId($user->id);
                }
                if(!$flag){
                    $studying = Studying::where('user_id',$oldUser->id)
                        ->update(['user_id'=>$user->id]);
                }
                $finance = new FinanceAccount();
                //201905024 继续赠送赛普币
//                if($flag){
//                    courseSpb($user->id,2);
//                    $data['type'] = CustomerPushType::IMAGE;
//                    $data['openid'] = $user->openid;
//                    $title = "【新人礼包】恭喜您获得3000赛普币";
//                    $data['list'] = [[
//                        "title"=>$title,
//                        "description"=>"
//想免费听课就来做任务挣赛普币吧~\n点击进入即可查看赛普币玩法攻略",
//                        "url"=>env('APP_URL').'/spb/rules',
//                        "picurl"=>'http://www.saipubbs.com/images/saipubi.jpg']];
//                    event(new WxCustomerMessagePush($data));
//                }

                $finance->addOne($user->id,$user->name);
                if($job == '想了解健身教练'){
                    users_growing($share_id,$user->id,$channel,$from,1);
                }
                DB::commit();

                return $this->getMessage(0,'登录成功');
            }else{
                DB::rollback();
                return $this->getMessage(5,'登录失败');
            }
        }catch(\Exception $e){

            DB::rollback();
            return $this->getMessage(5,'登录失败'.$e->getMessage());
        }

    }
    /*
         * 用户注册
         */
    public function postRegisterBak(Request $request){
        $code = $request->input('verifyCode');
        $mobile = $request->input('mobile');
        $password = $request->input('password');
        $share_id = $request->input('share_id',0);
        $mobile_code = Redis::get('code_'.trim($mobile));
        $channel = $request->input('channel');
        $from = $request->input('from','');
        $workstatus = $request->input("workstatus");
//        $utm_source = $request->input('utm_source','');
//        $utm_medium = $request->input('utm_medium','');
//        $openid = $request->input('op');
//        $time = date('Ymd');
//
        if($code!='656565'){
            if($mobile_code != $code){
                return $this->getMessage(1,'验证码有误或已过期');
            }
        }

        $reg_mobile  = '/^1[3|4|5|6|7|8|9]{1}\d{9}$/';

        if(!preg_match($reg_mobile,$mobile)){
            return $this->getMessage(2,'手机号格式错误');
        }
        if(strlen($password)<6 || strlen($password)>20){
            return $this->getMessage(3,'密码长度有误');
        }
        $user = User::where('mobile',$mobile)->first();//第一次注册用户
        if(!is_weixin() && $user){
            return $this->getMessage(4,'手机号已注册');
        }
        $oldUser = $request->user();//微信授权用户
        if($oldUser && $oldUser->mobile == $mobile){
            return $this->getMessage(4,'手机号已注册');
        }
        $flag = 1;
        if(is_weixin() && $user){
            if($oldUser){
                $user->nickname = $oldUser->nickname;
                if(empty($user->avatar)){
                    $user->avatar = $oldUser->headimgurl;
                }
                $user->openid = $oldUser->openid;
                $user->unionid = $oldUser->unionid;

                User::where('id',$oldUser->id)->delete();

//                Auth::logout();
                $flag = 0;
            }else{
                return $this->getMessage(5,'用户注册失败');
            }
        }elseif(is_weixin() && !$user){
            if($oldUser){
                $user = User::where('id',$oldUser->id)->first();
            }else{
                return $this->getMessage(5,'用户注册失败');
            }
        }else{
            $user = new User();
        }

        $user->mobile = $mobile;
        $user->password = bcrypt(md5($password));
        //$user->workstatus = $workstatus;
//        if(is_weixin()){
//            if($user->openid == null){
//                $user->openid = $openid;
//            }
//        }
        DB::beginTransaction();
        try{
            if($user->save()){
                $attribute = UsersAttribute::where("user_id", $user->id)->first();
                if(!$attribute){
                    $attribute = new UsersAttribute();
                    $attribute->user_id = $user->id;
                    $attribute->worktag = $workstatus;
                    $attribute->save();
                }else{
                    $attribute->worktag = $workstatus;
                    $attribute->save();
                }

                $this->syncUserInfoToApp($user);
                if(!is_weixin()){
                    Auth::loginUsingId($user->id);
                }else{
                    Auth::logout();
                    Auth::loginUsingId($user->id);
                }
                if(!$flag){
                    $studying = Studying::where('user_id',$oldUser->id)
                        ->update(['user_id'=>$user->id]);
                }
                $finance = new FinanceAccount();
                //201905024 继续赠送赛普币
                if($flag){
                    courseSpb($user->id,2);
                    $data['type'] = CustomerPushType::IMAGE;
                    $data['openid'] = $user->openid;
                    $title = "【新人礼包】恭喜您获得3000赛普币";
                    $data['list'] = [[
                        "title"=>$title,
                        "description"=>"
想免费听课就来做任务挣赛普币吧~\n点击进入即可查看赛普币玩法攻略",
                        "url"=>env('APP_URL').'/spb/rules',
                        "picurl"=>'http://www.saipubbs.com/images/saipubi.jpg']];
                    event(new WxCustomerMessagePush($data));
                }

                $finance->addOne($user->id,$user->name);
                users_growing($share_id,$user->id,$channel,$from,1);
                DB::commit();

                return $this->getMessage(0,'用户注册成功');
            }else{
                DB::rollback();
                return $this->getMessage(5,'用户注册失败');
            }
        }catch(\Exception $e){

            DB::rollback();
            return $this->getMessage(5,'用户注册失败'.$e->getMessage());
        }


    }
    /*
     * 退出登录
     */
    public function logout(Request $request){
        Auth::logout();
        return redirect('/');
    }
    /*
     * 用户信息验证
     */
    private function validateUserName($name){
        $type = '';
        $reg_mobile  = '/^1[3|4|5|6|7|8|9]{1}\d{9}$/';
        $reg_email  = '/^(\w|\d)+([-+.](\w|\d)+)*@(\w|\d)+([-.](\w|\d)+)*\.\w+([-.]\w+)*/';
        if(preg_match($reg_email,$name)){
            $type = 'email';
        }elseif(preg_match($reg_mobile,$name)){
            $type = 'mobile';
        }else{
            $type = 'name';
        }
        if(empty($type)){
            return false;
        }
        return $type;
    }

    /*
     *
     */
    public function registerAccess(Request $request){
        $courseClass = Courseclass::where('register_free_watch',1)->whereNull('deleted_at')->take(3)->get();

        return view('login.aregister',['courses'=>$courseClass]);
    }

    /*
     * 获取用户数据到app，保存app_user_id,
     */
    public function syncUserInfoToApp($user){
        $address = env('APP_INTERFACE_URL').'api/communityUser/userSynchronization';
        $data['mobile'] = $user->mobile;
        $data['nickname'] = mb_substr($user->nickname,0,20,'UTF-8');
        if(strpos($user->avatar,'http') !== false){
            $data['avatar'] = $user->avatar;
        }else{
            if($user->avatar == ''){
                $data['avatar'] = '';
            }else{
                $data['avatar'] = env('IMG_URL').$user->avatar;
            }
        }
        $data['sex'] = $user->sex;
        $data['unionid'] = $user->unionid;
        $data['registerTime'] = date('Y-m-d H:i:s',strtotime($user->created_at));

        if (empty($data)) {
            return array("code"=>'200', "msg"=>"参数有误");
        }

        $result = CurlUtil::appCurl($address,$data);
        $appInfo = [];
        if($result){
            logger()->info($result);
            $appInfo = json_decode($result,true);
        }
        if(isset($appInfo['app_user_id'])) {
            $app_user_id = $appInfo['app_user_id'] ? $appInfo['app_user_id'] : 0;
        }else{
            $app_user_id = 0;
        }
        $user->app_user_id = $app_user_id;
        $user->save();
    }

    public function captcha(){
        $captcha['url'] = captcha_src();
        return ['code'=>0,'img'=>'<img src="'.captcha_src().'"/>'];
    }

}