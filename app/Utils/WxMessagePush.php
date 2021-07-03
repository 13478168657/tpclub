<?php
namespace App\Utils;
use Illuminate\Support\Facades\Redis;
class WxMessagePush {

    //推送模板信息参数：发送给谁的openid
    public function sendMessage($data) {
//        $openid= "ogGtrv6Es5WiaRYadLeKAJPf5sng";
        $openId = $data['openid'];
        $type = $data['type'];
        $url = $data['url'];
        //获取全局token
        $token = $this->getToken();
        $postUrl = env('WX_MESSAGE_SEND_URL')."?access_token=".$token;//模板信息请求地址
        $postData = [];
        $postData['touser'] = $openId;
        $postData['template_id'] = env('WX_TEMPLATE_ID_'.$type);
        $postData['url'] = $url;
        $postData['data'] = $this->getData($data);

        $post_data = json_encode($postData);
        $info = $this->curl($postUrl,$post_data);
        $result = $info;//将json数据转成数组
        return $result;
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

    private function getData($data){
        $type = $data['type'];
        $message = [];
        if($type == 'COMMENT'){
            $course = $data['message']['course'];
            $author = $data['message']['author'];
            $notice = isset($data['notice']) ? $data['notice'] : "感谢你的评论！";
            $message = [];
            $message["first"] = ["value"=>$notice, "color"=>"#173177"];
            $message["keyword1"] = ["value"=>$course->title,"color"=>"#173177"];
            $message["keyword2"] = ["value"=>$author->name,"color"=>"#173177"];
            $message["remark"] = ["value"=>"我们收到了您的评价，有则改之无则加勉。
点击详情进入课程页面开始学习，祝训练愉快","color"=>"#173177"];
        }elseif($type == 'ADD'){

        }elseif($type == 'FOLLOW'){

        }elseif($type == 'ENROLL'){
            $course = $data['message']['course'];
            $author = $data['message']['author'];
            $notice = isset($data['notice']) ? $data['notice'] : "报名成功！";
            $message = [];
            $message["first"] = ["value"=>$notice, "color"=>"#173177"];
            $message["keyword1"] = ["value"=>$course->title,"color"=>"#173177"];
            $message["keyword2"] = ["value"=>"赛普健身社区","color"=>"#173177"];
            $message["keyword3"] = ["value"=>$author->name,"color"=>"#173177"];
            $message["keyword4"] = ["value"=>date('Y-m-d H:i:s'),"color"=>"#173177"];
            $message["remark"] = ["value"=>"如有问题，请及时联系我们哦！","color"=>"#173177"];
        }elseif($type == 'NOTICE'){
            $message = [];
            $message["first"] = ["value"=>$data['notice'], "color"=>"#ff0000"];
            $message["keyword1"] = ["value"=>$data['message']['key1'],"color"=>"#173177"];
            $message["keyword2"] = ["value"=>$data['message']['key2'],"color"=>"#173177"];
            $message["keyword3"] = ["value"=>$data['message']['key3'],"color"=>"#173177"];
            $message["remark"] = ["value"=>$data['message']['remark'],"color"=>"#ff0000"];
        }elseif($type == 'SCORE'){
            $message = [];
            $message["first"] = ["value"=>$data['notice'], "color"=>"#ff0000"];
            $message["keyword1"] = ["value"=>$data['message']['key1'],"color"=>"#173177"];
            $message["keyword2"] = ["value"=>$data['message']['key2'],"color"=>"#173177"];
            $message["keyword3"] = ["value"=>$data['message']['key3'],"color"=>"#173177"];
            $message["keyword4"] = ["value"=>$data['message']['key4'],"color"=>"#173177"];
            $message["keyword5"] = ["value"=>$data['message']['key5'],"color"=>"#173177"];
            $message["remark"] = ["value"=>$data['message']['remark'],"color"=>"#ff0000"];
        }elseif($type == 'ACTIVERANK'){
            $message = [];
            $message["first"] = ["value"=>$data['notice'], "color"=>"#173177"];
            $message["keyword1"] = ["value"=>$data['message']['key1'],"color"=>"#173177"];
            $message["keyword2"] = ["value"=>$data['message']['key2'],"color"=>"#173177"];
            $message["remark"] = ["value"=>$data['message']['remark'],"color"=>"#173177"];
        }elseif($type == "NEWYEAR"){
            $message = [];
            $message["first"] = ["value"=>$data['notice'], "color"=>"#173177"];
            $message["keyword1"] = ["value"=>$data['message']['key1'],"color"=>"#173177"];
            $message["keyword2"] = ["value"=>$data['message']['key2'],"color"=>"#173177"];
            $message["keyword3"] = ["value"=>$data['message']['key3'],"color"=>"#173177"];
            $message["remark"] = ["value"=>$data['message']['remark'],"color"=>"#173177"];
        }elseif($type == 'ACCESSPRAISE'){
            $message = [];
            $message["first"] = ["value"=>$data['notice'], "color"=>"#173177"];
            $message["keyword1"] = ["value"=>$data['message']['key1'],"color"=>"#173177"];
            $message["keyword2"] = ["value"=>$data['message']['key2'],"color"=>"#173177"];
            $message["keyword3"] = ["value"=>$data['message']['key3'],"color"=>"#173177"];
            $message["remark"] = ["value"=>$data['message']['remark'],"color"=>"#173177"];
        }elseif($type == 'COURSENOTICE'){
            $message["first"] = ["value"=>$data['notice'], "color"=>"#173177"];
            $message["keyword1"] = ["value"=>$data['message']['key1'],"color"=>"#173177"];
            $message["keyword2"] = ["value"=>$data['message']['key2'],"color"=>"#173177"];
            $message["keyword3"] = ["value"=>$data['message']['key3'],"color"=>"#173177"];
            $message["keyword4"] = ["value"=>$data['message']['key4'],"color"=>"#173177"];
            $message["remark"] = ["value"=>$data['message']['remark'],"color"=>"#173177"];
        }elseif($type == 'ASKFEEDBACK'){
            $message["first"] = ["value"=>$data['notice'], "color"=>"#173177"];
            $message["keyword1"] = ["value"=>$data['message']['key1'],"color"=>"#173177"];
            $message["keyword2"] = ["value"=>$data['message']['key2'],"color"=>"#173177"];
            $message["remark"] = ["value"=>$data['message']['remark'],"color"=>"#173177"];
        }elseif($type == 'ASKCOMMENT'){
            $message["first"] = ["value"=>$data['notice'], "color"=>"#173177"];
            $message["keyword1"] = ["value"=>$data['message']['key1'],"color"=>"#173177"];
            $message["keyword2"] = ["value"=>$data['message']['key2'],"color"=>"#173177"];
            $message["keyword3"] = ["value"=>$data['message']['key3'],"color"=>"#173177"];
            $message["remark"] = ["value"=>$data['message']['remark'],"color"=>"#173177"];
        }elseif($type == 'STUDY'){
            //分销打卡学习提醒
            $message["first"]    = ["value"=>$data['notice'], "color"=>"#173177"];
            $message["keyword1"] = ["value"=>$data['message']['key1'],"color"=>"#173177"];
            $message["keyword2"] = ["value"=>$data['message']['key2'],"color"=>"#173177"];
            $message["remark"]   = ["value"=>$data['message']['remark'],"color"=>"#173177"];
        }elseif($type == 'DISTRIBUTION'){
            $message["first"] = ["value"=>$data['notice'], "color"=>"#173177"];
            $message["keyword1"] = ["value"=> $data['message']['key1'],"color"=>"#173177"];
            $message["keyword2"] = ["value"=>$data['message']['key2'],"color"=>"#173177"];
            $message["remark"] = ["value"=>$data['message']['remark'],"color"=>"#173177"];
        }elseif($type == 'DISCOURSE'){
            $message["first"] = ["value"=>$data['notice'], "color"=>"#173177"];
            $message["keyword1"] = ["value"=> $data['message']['key1'],"color"=>"#173177"];
            $message["keyword2"] = ["value"=>$data['message']['key2'],"color"=>"#173177"];
            $message["remark"] = ["value"=>$data['message']['remark'],"color"=>"#173177"];
        }
        return $message;
    }
    public function curl($url,$postData = '',$type = ''){
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url); //要访问的地址
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//跳过证书验证

        if($postData){
            curl_setopt($ch, CURLOPT_POST, 1);//post方法请求
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);//post请求发送的数据包
        }else{
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        }

        $data = curl_exec($ch);
        if(curl_errno($ch)){
            logger()->info(curl_error($ch));
        }
        curl_close($ch);
        return $data;
    }
}