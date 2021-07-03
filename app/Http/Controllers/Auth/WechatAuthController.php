<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Models\WechatAuthorization;
use App\Models\WechatUser;
use App\Models\UsersGrowing;
use App\Constant\UserGender;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use App\Events\WxCustomerMessagePush;
class WechatAuthController extends Controller
{
    public function __construct(){

    }

    public function authLogin(Request $request){
        $path = $request->input('redirect');
        $appid = config('wechat.oauth.appid');
        $url = config('wechat.oauth.wechat_auth_url');
        $callback_url = urlencode(config('wechat.oauth.callback_url').'?redirect='.$path);
        $state = $this->getState();
        $timestamp = time();
        $open_url = "$url?timestamp=".$timestamp."&appid=$appid&redirect_uri=$callback_url&response_type=code&scope=snsapi_userinfo&state=$state&connect_redirect=1#wechat_redirect";

        echo "<script>window.location.href='".$open_url."'</script>";
    }

    public function wechatCallback(Request $request){
        $redirect = $request->input('redirect');
        $code = $request->input('code');
        $appid = config('wechat.oauth.appid');
        $appSecret = config('wechat.oauth.app_secret');
        $url = config('wechat.oauth.wechat_access_token_url');
        $access_user_url = config('wechat.oauth.wechat_access_user_url');
        $token_url = "$url?appid=".$appid.'&secret='.$appSecret.'&code='.$code.'&grant_type=authorization_code';
        $token = json_decode(file_get_contents($token_url));
//        logger()->info(json_decode(json_encode($token),true));
        if (isset($token->errcode)) {
            logger()->info($token->errcode.':'.$token->errmsg);
            return $this->getMessage($token->errcode,$token->errmsg);
        }

        $user_info_url = "$access_user_url?access_token=".$token->access_token.'&openid='.$token->openid.'&lang=zh_CN';
        $user_info = json_decode(file_get_contents($user_info_url));

//        logger()->info(json_decode(json_encode($user_info),true));
        if (isset($user_info->errcode)) {
            logger()->info($user_info->errcode.':'.$user_info->errmsg);
            return $this->getMessage($user_info->errcode,$user_info->errmsg);
        }
        $fission_id = 0;
        $mobile = '';
        if(!$redirect){
            $redirect = '/';
        }else{
            $urlInfo = explode('?',$redirect);
            if(isset($urlInfo[1])){
                $urlInfoArr = explode('&',$urlInfo[1]);
                foreach($urlInfoArr as $info){
                    if(strpos($info,'fission_id') !== false){
                        $fission_id = substr($info,11);
                    }
                    if(strpos($info,'mobile') !== false){
                        $mobile = substr($info,7);
                    }
                }
            }
        }

        $this->userAuthorized($token,$user_info,$fission_id,$mobile);
        return redirect($redirect);
    }


    /*
     * 处理用户授权信息
     */
    public function userAuthorized($token,$user_info,$fission_id = 0,$mobile=''){
        $authorize = WechatAuthorization::where('openid',$token->openid)->first();

        DB::beginTransaction();
        try{
            if(!$authorize){
                $authorize = new WechatAuthorization();
            }
            $authorize->access_token = $token->access_token;
            $authorize->expires_in = $token->expires_in;
            $authorize->refresh_token = $token->refresh_token;
            $authorize->openid = $token->openid;
            $authorize->save();

            $wechatUser = WechatUser::where('openid',$user_info->openid)->first();
            $nickname = $this->filterSpecialChar($user_info->nickname);
            if(!$wechatUser){
                $wechatUser = new WechatUser();
                $wechatUser->openid =  $user_info->openid;
                $wechatUser->nickname = $nickname;
                $wechatUser->sex = $user_info->sex;
                $wechatUser->province = $this->filterSpecialChar($user_info->province);
                $wechatUser->city = $this->filterSpecialChar($user_info->city);
                $wechatUser->country = $this->filterSpecialChar($user_info->country);
                $wechatUser->headimgurl = $user_info->headimgurl;
                $wechatUser->privilege = json_encode($user_info->privilege);
                $wechatUser->save();
            }
            $flag = 0;
            $user = User::where('unionid',$user_info->unionid)->first();
            if($user){
                $flag = 1;
            }else{
                $user = User::where('openid',$user_info->openid)->first();
                if($user){
                    $flag = 1;
                }
            }

            if(!$flag){
                $user = new User();
                $user->nickname = $nickname;
                $user->sex = UserGender::trans($user_info->sex);
                $user->avatar = $user_info->headimgurl;
                $user->openid = $user_info->openid;
                //$user->mobile = $mobile;
                if(isset($user_info->unionid)){
                    $user->unionid = $user_info->unionid;
                }
                $user->save();
            }else{
                $user->openid = $user_info->openid;
                if(isset($user_info->unionid)){
                    if(strlen($user->unionid)<10){
                        $user->unionid = $user_info->unionid;
                    }
                }
                $user->save();
            }
            if(!empty($mobile)){
                users_growing_introduction($fission_id,$user->id,"","",1);
            }

            DB::commit();

            Auth::loginUsingId($user->id, true);
            $userGrow = UsersGrowing::where('user_id',$user->id)->select('id')->first();
            if(!$userGrow){
                //转介绍录入资源跳转授权如果手机号存在，不执行。
                if(empty($mobile)){
                    users_growing($fission_id,$user->id);
                }
               
            }
            return true;
        }catch(\Exception $e){
            logger()->error("用户授权失败:".$e->getMessage());
            DB::rollback();
            return false;
        }
    }
    /*
     * 获取state随机数
     */
    private function getState(){
        $chars = ['a','b','c','d','e','f','g
        ','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
        $num = mt_rand(10000,99999);

        return $chars[mt_rand(0,25)].$chars[mt_rand(0,25)].$chars[mt_rand(0,25)].$chars[mt_rand(0,25)].$chars[mt_rand(0,25)].$num;
    }

    /*
     * 昵称特殊字符过滤
     */
    public function filterSpecialChar($word){
        if($word){
            $name = $word;
            $name = preg_replace('/\xEE[\x80-\xBF][\x80-\xBF]|\xEF[\x81-\x83][\x80-\xBF]/', '', $name);
            $name = preg_replace('/xE0[x80-x9F][x80-xBF]'.'|xED[xA0-xBF][x80-xBF]/S','?', $name);
            $result = json_decode(preg_replace("#(\\\ud[0-9a-f]{3})#i","",json_encode($name)));

        }else{
            $result = '';
        }
        return $result;
    }
}
