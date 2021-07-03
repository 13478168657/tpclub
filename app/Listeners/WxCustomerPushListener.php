<?php

namespace App\Listeners;

use App\Events\WxCustomerMessagePush;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Utils\CurlUtil;
use Illuminate\Support\Facades\Redis;
class WxCustomerPushListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  name  $event
     * @return void
     */
    public function handle(WxCustomerMessagePush $event)
    {
        $data = $event->data;
        $openid = $data['openid'];
//        dd(333);
        if(!$openid){
            return false;
        }
        $this->pushMessage($data);
    }

    public function pushMessage($dataInfo){
        $access_token = $this->getToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token;

        switch($dataInfo['type']){
            case 'IMAGE'://图文
                $data = [
                    "touser"=>$dataInfo['openid'],
                    "msgtype"=>"news",
                    "news"=>[
                        "articles"=> $dataInfo['list']
                    ]
                ];
                break;
            case "TEXT"://文字
                $data = [
                    "touser"=>$dataInfo['openid'],
                    "msgtype"=>"text",
                    "text"=>[
                        "content"=> $dataInfo['text']
                    ]
                ];
                break;
            case 'IMAGES':
                $data = [
                    "touser"=>$dataInfo['openid'],
                    "msgtype"=>"image",
                    "image"=>[
                        "media_id"=> $dataInfo['media_id']
                    ]
                ];
        }
//        logger()->info($data);
        $result = CurlUtil::curl($url,json_encode($data,JSON_UNESCAPED_UNICODE));
//        logger()->info($result);
    }


    //获得全局access_token
    public function getToken(){
        $appId = env('APP_ID');   //appid
        $appSecret = env('APP_SECRET');
        if(Redis::exists('access_token') && Redis::get('access_token') != ''){
            $access_token = Redis::get('access_token');
        }else{
            $url = env('WX_TOKEN_URL')."?grant_type=client_credential&appid=".$appId."&secret=".$appSecret;
            $data = CurlUtil::curl($url);
            $tokenInfo = json_decode($data,true);
            $access_token = $tokenInfo['access_token'];
            Redis::setex('access_token',7200,$access_token);
        }
        return $access_token;

    }
}
