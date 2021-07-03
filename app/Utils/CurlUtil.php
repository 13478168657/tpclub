<?php
namespace App\Utils;

class CurlUtil{

    public function __construct()
    {

    }

    public static function curl($url ,$postData = [],$type = 'POST',$charset='',$timeout = 60,$headers=''){

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url); //要访问的地址
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT,$timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//跳过证书验证
        if($charset== ''){
            curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:application/json;charset=utf-8']);
        }else{
            curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:application/json;charset='.$charset]);
        }
        if($headers){
            curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
        }
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

    public static function appCurl($url ,$postData = [],$type = 'POST',$timeout = 60){

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url); //要访问的地址
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_TIMEOUT,$timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//跳过证书验证

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