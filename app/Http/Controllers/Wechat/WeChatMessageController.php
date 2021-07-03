<?php

namespace App\Http\Controllers\Wechat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Models\WechatAuthorization;
use App\Models\WechatUser;
use App\Models\WechatNews;
use App\Constant\UserGender;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use App\Events\WxCustomerMessagePush;
class WeChatMessageController extends Controller
{
    public function __construct(){

    }

    public function index(Request $request){
        $data['openid'] = 'sdsf';
        $data['type'] = 'IMAGE';

        event(new WxCustomerMessagePush($data));
    }
    //20180912 新用户关注客服回复消息
    public function subscribe($user){
        $openid   = $user['openid'];
        $nickname = $user['nickname'];

        $data   = array();
        $new    = new WechatNews();
        $list   = $new->orderBy("orderby","desc")->get();
        foreach($list as $item){
            $article = array(
                "title"      =>"Hi~".$nickname.$list[0]->title,
                "description"=>$list[0]->description,
                "url"        =>$list[0]->url,
                "picurl"     =>env('IMG_URL').$list[0]->picurl
            );
            $data['list'][]  = $article;
            unset($article);
        }

        $data['openid'] = $user['openid'];
        $data['type']   = 'IMAGE';

        event(new WxCustomerMessagePush($data));
        return;

        $result = $this->curl($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        logger()->info($result);
    }

    //获得全局access_token
    public function getToken(){
        $appId = env('APP_ID');   //appid
        $appSecret = env('APP_SECRET');
        if(Redis::exists('access_token') && Redis::get('access_token') != ''){
            $access_token = Redis::get('access_token');
        }else{
            $url = env('WX_TOKEN_URL')."?grant_type=client_credential&appid=".$appId."&secret=".$appSecret;
            $data = $this->curl($url);
            $tokenInfo = json_decode($data,true);
            $access_token = $tokenInfo['access_token'];
            Redis::setex('access_token',7200,$access_token);
        }
        return $access_token;

    }

    public function curl($url,$postData = '',$type = 'POST'){
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url); //要访问的地址
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//跳过证书验证
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:application/json;charset=utf-8']);
//        if($postData){
//            curl_setopt($ch, CURLOPT_POST, 1);//post方法请求
//            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);//post请求发送的数据包
//        }else{
//            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
//        }
        switch($type){
            case "POST":
                curl_setopt($ch,CURLOPT_POST,true);
                break;
            case "GET":
                curl_setopt($ch,CURLOPT_HTTPGET,true);
                break;
            case "DELETE":
                curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"DELETE");
                break;
            case "PUT":
                curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'PUT');
                break;
        }
        if(!empty($postData)){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }
        $data = curl_exec($ch);
        if(curl_errno($ch)){
            logger()->info(curl_error($ch));
        }
        curl_close($ch);
        return $data;
    }
}
