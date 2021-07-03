<?php

namespace App\Http\Controllers\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utils\CurlUtil;
class LiveController extends Controller
{


    public function createLive(Request $request){
        $userId = "83d3607097";
        $autoPlay = 1;
        $name = "开发测试";
        $playerColor = "#00ffff";
        $channelPasswd = "123456";
        $courseId = "123456";
        $scene = "alone";
        $appId = 'f5rf94sa7w';
        $timestamp = time();
        $params = array(
            'appId'=>$appId,
            'autoPlay'=>$autoPlay,
            'name'=>$name,
            'courseId'=>$courseId,
            'playerColor'=>$playerColor,
            'userId'=>$userId,
            'channelPasswd'=>$channelPasswd,
            'scene'=>$scene,
            'timestamp'=>$timestamp
        );

//生成sign
        $sign = getSign($params); //详细查看config.php文件的getSign方法


        $data = array(
            'appId' => $appId,
            'autoPlay'=>$autoPlay,
            'name'=>$name,
            'courseId'=>$courseId,
            'playerColor'=>$playerColor,
            'timestamp'=>$timestamp,
            'userId'=>$userId,
            'channelPasswd'=>$channelPasswd,
            'scene'=>$scene,
            'sign'=>$sign
        );

        $url = "http://api.polyv.net/live/v2/channels";
        $ch = curl_init() or die ( curl_error() );
        curl_setopt( $ch, CURLOPT_URL, $url);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 360);
        $response = curl_exec ( $ch );
        curl_close ( $ch );

        echo $response;
    }

    public function touTiao(){
          $host = "https://crm.bytedance.com";
          $api  = "/crm/v2/openapi/pull-clues";
          
          // $payload = {};
          $payload = [];
          $payload["start_time"] = '2017-11-10';
          $payload["end_time"] = '2018-11-12';
          $payload["page"] = 1;
          $payload["page_size"] = 10;
          $now = time();
          $url = $host.$api;
          $start_ts = $now-24*60*60;
          $end_ts   = $now;
          $start_date = "2017-01-01";
          $end_date   = "2018-11-12";
        
          
          $source_data = $api."?start_time=".$start_date."&end_time".$end_date." ".$now;
          $key = "RUc3UVEzSkxTSEVW";
          $token = "5ea791d295f544256d206d3106037f05b2fd55ab";
          $data = base64_encode(hash_hmac("sha256",$source_data, $key));
          $headers[] = 'Signature:'.$data;
          $headers[] = 'Timestamp:'.$now;
          $headers[] = 'Access-Token:'.$token;
          $headers[] = 'Content-Type:application/json';
          // dd($url);
          $result = CurlUtil::curl($url,$payload,'GET','',200,$headers);
          dd($result);
          $curl = curl_init();
          $query_url = ($api."?start_time=".$start_date."&end_time=".$end_date."&page=1&page_size=1");
          
          curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
          curl_setopt($curl,CURLINFO_HEADER_OUT, true);
          curl_setopt($curl,CURLOPT_URL, $query_url);
          curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
          
          $res = curl_exec($curl);
          curl_close($curl);
          
          dd($res);

    }
}
