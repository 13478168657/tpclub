<?php
namespace App\Utils;
class WxQRcode {
    private $_token;
    public function __construct($token){
        $this->_token = $token;
    }
    private function _request($curl, $https=true, $method='get', $data=null){
		$ch = curl_init();//初始化
		curl_setopt($ch, CURLOPT_URL, $curl);//设置访问的URL
		curl_setopt($ch, CURLOPT_HEADER, false);//设置不需要头信息
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//只获取页面内容，但不输出
		if($https){
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//不做服务器认证
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//不做客户端认证
		}
		if($method == 'post'){
			curl_setopt($ch, CURLOPT_POST, true);//设置请求是POST方式
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//设置POST请求的数据
		}
		$str = curl_exec($ch);//执行访问，返回结果
		curl_close($ch);//关闭curl，释放资源
		return $str;
     }
    /** 
    *_getTicket():获取ticket，用于以后换取二维码
	*@expires_secords：二维码有效期（秒）
	*@type ：二维码类型（临时或永久）
	*@scene：场景编号
	**/
    public function _getTicket($expires_secords = 604800, $type = "temp", $scene = 1){ 
        if($type == "temp"){//临时二维码的处理
            $info  = array("scene_str"=>$scene);
            $array = array("expire_seconds"=>$expires_secords, "action_name"=>"QR_STR_SCENE",
                     "action_info"=>array("scene"=>$info)
            );
            //$data = '{"expire_seconds":'.$expires_secords.', "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": ".$scene."}}}';//临时二维码生成所需提交数据
            $data = json_encode($array);
            //logger()->info($data.'二维码参数');
            return $this->_request("https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$this->_token,true, "post", $data);//发出请求并获得ticket
        } else { //永久二维码的处理
            $data = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$scene.'}}}';//永久二维码生成所需提交数据
            return $this->_request("https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$this->_token,true, "post", $data);//发出请求并获得ticket
        }
     }
 
     /**
	 *_getQRCode():获取二维码
     *@expires_secords：二维码有效期（秒）
     *@type：二维码类型
     *@scene：场景编号
     **/
    public function _getQRCode($expires_secords,$type,$scene,$dir = '/upload/wxqrcode/'){
        $content = json_decode($this->_getTicket($expires_secords,$type,$scene));
        $ticket = $content->ticket;
        $img = $this ->_request('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($ticket));

        //将生成的二维码保存到本地
        $destDirectory = $dir;
//        dd(public_path());
         if (!file_exists(public_path().'/'.$destDirectory)) {
             $fileDir = mkdir(public_path().'/'.$destDirectory,0777,true);
         }else{
             $fileDir = public_path().'/'.$destDirectory;
         }
        $file = time().rand(1000,9999).".jpg";
//        dd($fileDir.$file);
        file_put_contents($fileDir.$file,$img);
        return $dir.$file;
        
    }

    /**
     *_getQRCode():获取二维码
     *@expires_secords：二维码有效期（秒）
     *@type：二维码类型
     *@scene：场景编号
     *@date:20190827
     *@auther:lu
     **/
    public function _getQRCodeUrl($expires_secords,$type,$scene,$dir = '/upload/wxqrcode/'){
        $content = json_decode($this->_getTicket($expires_secords,$type,$scene));
        $ticket = $content->ticket;
        $img = $this ->_request('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($ticket));
        return $ticket;
    }
}