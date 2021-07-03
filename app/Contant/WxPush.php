<?php
namespace App\Contant;

class WxPush {
    //获得全局access_token
    public function get_token(){
        $appid = 'wx4001963936e98f4f';   //appid
        $appsecret = '6cd114f956d35b5af8655c889c0d8303';
        if(isset($_COOKIE['access_token'])){
            $access_token2 = $_COOKIE['access_token'];
        }else{
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
            $ch = curl_init();//初始化curl
            curl_setopt($ch, CURLOPT_URL,$url); //要访问的地址 
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//跳过证书验证
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
            $data = curl_exec($ch);
            if(curl_errno($ch)){
              var_dump(curl_error($ch)); //若错误打印错误信息 
            }
            //var_dump($data); //打印信息
            curl_close($ch);//关闭curl
            $access_token1 = json_decode($data,true);
            $access_token2 = $access_token1['access_token'];
            setcookie('access_token',$access_token2,7200);
        }
        return $access_token2;
        
    }
     
    //推送模板信息参数：发送给谁的openid,客户姓名，客户电话，推荐楼盘（参数自定）
    public function sendMessage() {
        $openid= "ogGtrv6Es5WiaRYadLeKAJPf5sng";
        //获取全局token
        $token = $this->get_token();
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;//模板信息请求地址
        //发送的模板信息(微信要求json格式，这里为数组（方便添加变量）格式，然后转为json)
        $post_data = array(
                "touser"=>$openid,//推送给谁,openid
                "template_id"=>"PM38bkgPJSwG_8RrC4aJUn4FZT4RU3JtrXOHnJDxn9g",//微信后台的模板信息id
                "url"=>"http://www.baidu.com",//下面为预约看房模板示例
                "data"=>array(
                    "first" => array(
                            "value"=>"您有新客户，请及时查看！",
                            "color"=>"#173177"
                        ),
                        "keyword1"=>array(
                                "value"=>'课程名称',//传的变量
                                "color"=>"#173177"
                        ),
                        "keyword2"=>array(
                                "value"=>'地点',
                                "color"=>"#173177"
                        ),
                        "keyword3"=> array(
                                "value"=>'讲师名字',
                                "color"=>"#173177"
                        ),
                        "keyword4"=> array(
                                "value"=>date('Y-m-d H:i:s'),
                                "color"=>"#173177"
                        ),
                        "remark"=> array(
                                "value"=>"请及时联系客户哦！",
                                "color"=>"#173177"
                        ),
                )
        );
        //将上面的数组数据转为json格式
        $post_data = json_encode($post_data);
        //发送数据，post方式<br>//配置curl请求
        $ch = curl_init();//创建curl请求
        curl_setopt($ch, CURLOPT_URL,$url);//设置发送数据的网址
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //设置有返回值，0，直接显示
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0); //禁用证书验证
        curl_setopt($ch, CURLOPT_POST, 1);//post方法请求
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);//post请求发送的数据包
        //接收执行返回的数据
        $data = curl_exec($ch);
        //关闭句柄
        curl_close($ch);
        $data = json_decode($data,true);//将json数据转成数组
        return $data;
    }
    //获取模板信息-行业信息（参考，示例未使用）
    public function getHangye(){
        //用户同意授权后，会传过来一个code
        $token = $this->get_token();
        $url = "https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token=".$token;
        //请求token，get方式
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        $data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($data,true);//将json数据转成数组
        //return $data["access_token"];
        return $data;
    }
}