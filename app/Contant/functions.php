<?php

use App\Utils\WxMessagePush as WxPush;
use Illuminate\Support\Facades\Redis;
use App\Models\Studying;

/**
 * @Author: 公共函数库
 * @Author: saipu
 * @Date:   2018-07-26 10:21:26
 * @Last Modified by:   saipu
 * @Last Modified time: 2020-12-06 13:43:03
 */

/**
 *  获取课程收藏数量
 * @param $course_class_id  课程id
 * @param object $list 返回数据
 * @Author: luyahe
 */
function sum_collect($course_class_id){
	$list = DB::select("select count(id) as count  from collect where course_class_id={$course_class_id}");
	return $list[0];
}

/**
 *  获取视频总集数
 * @param $course_class_id  课程id
 * @param object $list 返回数据
 * @Author: luyahe
 */
function sum_course($course_class_id){
	$list = DB::select("select count(id) as count  from course where course_class_id={$course_class_id} and deleted_at is null");
	return $list[0];
}

/**
 *  获取用户输出总内容
 * @param $user_id  课程id
 * @param object $list 返回数据
 * @Author: luyahe
 */
function sum_content($user_id){
	//课程总数
	$list = DB::select("select count(id) as count  from course_class where user_id={$user_id}");

	//文章总数
	return $list[0]->count;
}

/**
 *  获取课程报名人数
 * @param $course_class_id  课程id
 * @param object $list 返回数据
 * @Author: luyahe
 */
function sum_study($course_class_id){
	$list = DB::select("select count(id) as count  from studying where course_class_id={$course_class_id}");
	return $list[0];
}

/**
 *  获取课程标签列表
 * @param $course_class_id  课程id
 * @param object $list 返回数据
 * @Author: luyahe
 */
function get_course_class_tag($course_class_id){
	$tag_id = DB::table("course_tag")->where("course_class_id", $course_class_id)->pluck('tag_id')->toArray();
	$tags   = DB::table("tags")->wherein("id", $tag_id)->select("tags.id", "tags.title")->get();
	$tag_str= "";
	if(!empty($tags)){
		foreach($tags as $tag){
			$tag_str.='<div class="swiper-slide" style="margin-right:10px;"><a class="color_gray666" href="/course/tagdetail/'.$tag->id.'.html">'.$tag->title.'</a></div>';
		}
	}
	return $tag_str;
}

/**
 *  获取课程标签列表  第二种样式
 * @param $course_class_id  课程id
 * @param object $list 返回数据
 * @Author: luyahe
 */
function get_course_class_tag_two($course_class_id){
	$tag_id = DB::table("course_tag")->where("course_class_id", $course_class_id)->pluck('tag_id')->toArray();
	$tags   = DB::table("tags")->wherein("id", $tag_id)->select("tags.id", "tags.title")->get();
	$tag_str= '';
	if(!empty($tags)){
		foreach($tags as $tag){
			$tag_str.='<div class="swiper-slide"><a class="color_gray666" href="/course/tagdetail/'.$tag->id.'.html">'.$tag->title.'</a></div>';
		}
	}
	return $tag_str;
}


/*
	获取课程老师名称
*/
function get_teacher_name($userId){
	$data = DB::table("users")->where("id",$userId)->select("name","id","avatar", "introduction","nickname")->first();
	return $data;
	
}
/*
	判断是否收藏
*/
function is_collect($course_id,$userid){
	$data = DB::table("collect")->where([["course_class_id","=",$course_id],["user_id","=",$userid]])->select("user_id")->get();
	if(isset($data[0])){
		return $str= 1;
	}else{
		return $str= 0;
	}
}
/*
	是否报名
*/
function is_baoming($course_id,$userid){
	$data = DB::table("studying")->where([["course_class_id","=",$course_id],["user_id","=",$userid]])->get();
	if(isset($data[0])){
		return $str = 1;
	}else{
		return $str = 0;
	}
}

/**
	课程名称
*/
function get_course_name($id){
	
	$data = DB::table("course_class")->where("id",$id)->select("title")->first();
	return $data;
}

/**
 *  图片格式
 * @param array $text_type 返回数据
 * @Author: luyahe
/**获取上传文件类型
 * 
 */
function return_type(){
	$text_type  = array('.gif', '.jpg', '.png','.jpeg');
	return $text_type;
}
/**
 *  xml格式转数组
 * @param $xml  xml数据
 * @param array $values 返回数据
 * @Author: luyahe
 */
function xmlToArray($xml)
{    
    //禁止引用外部xml实体
    libxml_disable_entity_loader(true);
    $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);        
    return $values;
}
/**
 *  微信h5支付发起请求
 * @param $$url  url地址
 * @param $data  数据
 * @Author: luyahe
 */
function wx_http_post($url, $data) {
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL,$url);
     curl_setopt($ch, CURLOPT_HEADER,0);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_POST, 1);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
     $res = curl_exec($ch);
     curl_close($ch);
     return $res;
 }

 function get_ip(){
    //判断服务器是否允许$_SERVER
    if(isset($_SERVER)){    
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }elseif(isset($_SERVER['HTTP_CLIENT_IP'])) {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }else{
            $realip = $_SERVER['REMOTE_ADDR'];
        }
    }else{
        //不允许就使用getenv获取  
        if(getenv("HTTP_X_FORWARDED_FOR")){
              $realip = getenv( "HTTP_X_FORWARDED_FOR");
        }elseif(getenv("HTTP_CLIENT_IP")) {
              $realip = getenv("HTTP_CLIENT_IP");
        }else{
              $realip = getenv("REMOTE_ADDR");
        }
    }

    return $realip;
}


/*
*
* 新增正在学习
*/
function add_baoming($course_id,$user_id){
	$data = DB::table("studying")->where([["course_class_id","=",$course_id],["user_id","=",$user_id]])->get();
	if(isset($data[0])){
		$study = [];
		$study['course_class_id'] = $course_id;
		$study['user_id'] = $user_id;
		DB::table("studying")->insert($study);
	}
}

/*
*
* 新增流水记录
*/
function add_finance_record($money,$type,$user_id, $payfrom,$course_class_id=0,$course_class_group_id=0){
	$data = array();
	$data['money'] = $money;
	$data['type']  = $type;
	$data['user_id'] = $user_id;
	$data['payfrom'] = $payfrom;
	$data['course_class_id'] = $course_class_id;
	$data['course_class_group_id'] = $course_class_group_id;
	$data['created_at'] = date("Y-m-d H:i:s");
	//dd($data);
	DB::table("finance_records")->insert($data);
}
/**
 * 签到赛普币
 * @param  [type] $userid   [description]
 * @param  [type] $rulesid  [description]
 * @param  string $courseid [description]
 * @return [type]           [description]
 */
function signIn($userid,$rulesid,$courseid="0"){
	
}

/**
 * 赛普币调用  注册 完善
 * $userid 用户id
 * $rulesid 规则id
 * 规则id
 * 1-->唯一一次（新手任务）
 * 2-->购买课程返币
 * 3-->评价课程返币
 * 4-->分享课程（一天三次)
 * 5-->每日首次收藏，报名，学习，关注返币
 * 6-->签到任务（每天一次）
 * 7-->活动奖励
 * 8-->其他赛普币规则次数设置

 * $userid -- 用户id
 * $rulesid -- 规则id
 * $money 	-- 购买课程付款钱数
 * $courseId -- 购买课程id
 *购买课程返赛普币
 */
function courseSpb($userid,$rulesid,$courseid="0",$money=""){
		$newMoney = getM($rulesid);
		$unique = $newMoney->is_unique;
		$type = $newMoney->type;
		if($unique == 2){
			if($money < 1){
				$money = 1;
			}
			$a1 = (float)$newMoney->value/100;
			$m1 = $a1 * $money *100;
			$m = (int)$m1;
			
		}else{
			$m = $newMoney->value;	
		}
		$condition['user_id'] = $userid;
		$condition['spb_rule_id'] = $rulesid;
		$condition['value'] = $m;

		if($type == "special"){						//专题系列spb
			$condition['special_id'] = $courseid;
			$count = course_over($userid,$rulesid,$unique,$courseid,"special_id");
		}elseif($type == 'teacher'){				//导师系列spb
			$condition['tid'] = $courseid;
			$count = course_over($userid,$rulesid,$unique,$courseid,"tid");
		}elseif($type == 'article'){				//文章系列spb
			$condition['article_id'] = $courseid;
			$count = course_over($userid,$rulesid,$unique,$courseid,"article_id");
		}else{										//课程系列以及其他spb

			$count = course_over($userid,$rulesid,$unique,$courseid,"courseid");
		}
		$condition['courseid'] = $courseid;
		$condition['created_at'] = date("Y-m-d H:i:s");
		
		if( $count == 0){//每日单次任务
			$data = DB::table("spb_records")->insert($condition);
			if($data){
				$update = DB::table("users")->where("id", '=', $userid)->increment("spb", $m);
			}
			return true;
		}elseif($count < 3 && $unique == 4){
			$data = DB::table("spb_records")->insert($condition);
			if($data){
				$update = DB::table("users")->where("id", '=', $userid)->increment("spb", $m);
			}
			return true;
		}elseif($count < 11 && $unique == 8 ){
			$data = DB::table("spb_records")->insert($condition);
			if($data){
				$update = DB::table("users")->where("id", '=', $userid)->increment("spb", $m);
			}
			return true;
		}else{
			return false;
		}
}

/**
 * 获取相应规则对应的钱币
 */

function getM($rulesId){
	$data = DB::table("spb_rules")->where("id",$rulesId)->select("value","is_unique","type")->first();
	return $data;
}

/**
 * 购买收藏课程
 */
 
function course_over($userid,$rulesid,$unique = "",$courseId="",$type="courseid"){
	$records = DB::table("spb_records")->where("$type",$courseId);
	if($unique == "5" || $unique == "4"){
		$data = DB::table("spb_records")->where("user_id",$userid)
										->where('spb_rule_id',$rulesid)
										->where("created_at","like",date('Y-m-d')."%")
										->select("count(*) as num")->count();
	}elseif($unique == "2" || $unique == "3"){
		$data = $records->where("user_id",$userid)
						->where('spb_rule_id',$rulesid)
						->select("count(*) as num")->count();
	}elseif($unique == "7"){
		$data = $records->where("user_id",$userid)
						->where('spb_rule_id',$rulesid)
						->select("count(*) as num")->count();
	}else{
		$data = DB::table("spb_records")->where("user_id",$userid)->where('spb_rule_id',$rulesid)->select("count(*) as num")->count();
	}

	return $data;
	
}



/*
*
* 新增购买课程通知消息
* @param $author_id     作者id
* @param $user_id       用户id
* @param $user_name     用户名
* @param $user_avatar   用户头像
* @param $title         课程标题
* @param $message_type  消息类型
*/
function add_message($author_id,$user_id,$user_name,$user_avatar,$title, $message_type, $comment=""){
	$data = array();
	$data['author_id']    = $author_id;
	$data['user_id']      = $user_id;
	$data['user_name']    = $user_name;
	$data['title']        = $title;
	$data['message_type'] = $message_type;
	$data['user_avatar']  = filterSpecialChar($user_avatar);
	$data['comment']      = filterSpecialChar($comment);
	$data['created_at']   = date("Y-m-d H:i:s");
	DB::table("messages")->insert($data);
}

/*
*
* php判断是否是微信内部浏览器
*/
function is_weixin(){
	if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
     	return true;
    }  
     	return false;
}



function getCourseName($courseId){
	$data = DB::table("course_class")->where("id",$courseId)->select("title")->first();
	return $data->title;
}

/**
 *  获取课程评论总条数
 * @param $course_class_id  课程id
 * @param object $list 返回数据
 * @Author: luyahe
 */
function sum_comments($course_class_id){
	//评论总数
	$list = DB::select("select count(id) as count  from comments where course_class_id={$course_class_id}");
	return $list[0]->count;
}

/**
 *  获取课程平均分数
 * @param $course_class_id  课程id
 * @param object $list 返回数据
 * @Author: luyahe
 */
function avg_comments($course_class_id){
	//评论总数
	$list = DB::select("select avg(score) as score  from comments where course_class_id={$course_class_id}");
	return round($list[0]->score,1);
}

/**
 *  根据课程评分返回星星点亮数量
 * @param $score  分数
 * @param object $list 返回数据
 * @Author: luyahe
 */
function stars($score,$type="video"){
	//评论总数
	$str = "";
	if($type=='video'){
		if($score==1){
			$str = '<li class="star-full"></li><li></li><li></li><li></li><li></li><li></li>';
		}elseif($score==2){
			$str = '<li class="star-full"></li><li class="star-full"></li><li></li><li></li><li></li>';
		}elseif($score==3){
			$str = '<li class="star-full"></li><li class="star-full"></li><li class="star-full"></li><li></li><li></li>';
		}elseif($score==4){
			$str = '<li class="star-full"></li><li class="star-full"></li><li class="star-full"></li><li class="star-full"></li><li></li>';
		}elseif($score==5){
			$str = '<li class="star-full"></li><li class="star-full"></li><li class="star-full"></li><li class="star-full"></li><li class="star-full"></li>';
		}
	}else{
		if($score==1){
			$str = '<span><img src="/images/start_bright.png" alt=""></span><span>&nbsp;<img src="/images/start_dark.png" alt=""></span>&nbsp;<span><img src="/images/start_dark.png" alt=""></span>&nbsp;<span><img src="/images/start_dark.png" alt=""></span>&nbsp;<span><img src="/images/start_dark.png" alt=""></span>&nbsp;';
		}elseif($score==2){
			$str = '<span><img src="/images/start_bright.png" alt=""></span>&nbsp;<span><img src="/images/start_bright.png" alt=""></span>&nbsp;<span><img src="/images/start_dark.png" alt=""></span>&nbsp;<span><img src="/images/start_dark.png" alt=""></span>&nbsp;<span><img src="/images/start_dark.png" alt=""></span>&nbsp;';
		}elseif($score==3){
			$str = '<span><img src="/images/start_bright.png" alt=""></span>&nbsp;<span><img src="/images/start_bright.png" alt=""></span>&nbsp;<span><img src="/images/start_bright.png" alt=""></span>&nbsp;<span><img src="/images/start_dark.png" alt=""></span>&nbsp;<span><img src="/images/start_dark.png" alt=""></span>&nbsp;';
		}elseif($score==4){
			$str = '<span><img src="/images/start_bright.png" alt=""></span>&nbsp;<span><img src="/images/start_bright.png" alt=""></span>&nbsp;<span><img src="/images/start_bright.png" alt=""></span>&nbsp;<span><img src="/images/start_bright.png" alt=""></span>&nbsp;<span><img src="/images/start_dark.png" alt=""></span>&nbsp;';
		}elseif($score==5){
			$str = '<span><img src="/images/start_bright.png" alt=""></span>&nbsp;<span><img src="/images/start_bright.png" alt=""></span>&nbsp;<span><img src="/images/start_bright.png" alt=""></span>&nbsp;<span><img src="/images/start_bright.png" alt=""></span>&nbsp;<span><img src="/images/start_bright.png" alt=""></span>&nbsp;';
		}
	}
	
	return $str;
}

/**
 * 查看客户余额是否购买某个课程
 * @param int $user_id  课程id
 * @param int $price 课程价格
 * 20180821
 * @Author: luyahe
 */
function user_balance($user_id, $price){
	if($user_id && $price){
		$list = DB::select("select total from finance_accounts where user_id={$user_id}");
		if($list){
			if($list[0]->total >$price){
				return 1; 
			}
		}
	}
	return 0;
}


function getSpb($userid){
	$data = DB::table("users")->where("id",$userid)->select("spb")->first();
	return $data->spb;
}


/**
 * 消息列表获取名字和图片
 */
function getUsers($userid){
	$data = DB::table("users")->where("id",$userid)->select("name","avatar","nickname","mobile", "nickname")->first();
	if($data){
		return $data;
	}else{
		return [];
	}
	return $data;
}



 
function getSignPackage() {
	//$appId = env('APP_ID'); //APP_ID=wx4001963936e98f4f	APP_SECRET=6cd114f956d35b5af8655c889c0d8303
	$appId = env('APP_ID');
    $jsapiTicket = getJsApiTicket();
 	
    // 注意 URL 一定要动态获取，不能 hardcode.
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
 
    $timestamp = time();
    $nonceStr = createNonceStr();
 
    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
 
    $signature = sha1($string);
 
    $signPackage = array(
      "appId"     => $appId,
      "noncestr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );
    return $signPackage; 
}

/*
*20190816
*根据参数获取微信分享信息
* 
 */
function getSignPackageTwo($url) {
	//$appId = env('APP_ID'); //APP_ID=wx4001963936e98f4f	APP_SECRET=6cd114f956d35b5af8655c889c0d8303
	$appId = env('APP_ID');
    $jsapiTicket = getJsApiTicket();
    // 注意 URL 一定要动态获取，不能 hardcode.
    //$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    //$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $timestamp = time();
    $nonceStr = createNonceStr();
    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
    $signature = sha1($string);
    $signPackage = array(
      "appId"     => $appId,
      "noncestr"  => $nonceStr,
      "timestamp" => $timestamp,
      "url"       => $url,
      "signature" => $signature,
      "rawString" => $string
    );
    return $signPackage; 
}

function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}

function getJsApiTicket() {

   	$wxPush  = new WxPush();
    $token   = $wxPush->getToken();
    $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$token";
	//logger()->info($token);
    $res = json_decode(httpGet($url),true);
  	//logger()->info($res);
  	if($res && $res['ticket']){
  		$ticket = $res['ticket'];
  	}else{
  		$ticket = "";
  	}
  return $ticket;
}
//APP_ID=wx4001963936e98f4f	APP_SECRET=6cd114f956d35b5af8655c889c0d8303
function getAccessToken(){
    if(Redis::exists('access_token') && Redis::get('access_token') != ''){
         $access_token = Redis::get('access_token');
    }else{
        $appId = env('APP_ID'); 
	    $appSecret = env('APP_SECRET');
	    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appId&secret=$appSecret";
	    $res = json_decode(httpGet($url));
	    $access_token = $res->access_token;
        Redis::setex('access_token',7200,$access_token);
    }
    return $access_token;
  }
 
function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
//    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);
// 	logger()->info($res);
    return $res;
  }

/**
 * 消息列表获取名字和图片
 */
function getTagTitle($tag_id){
	$data = DB::table("tags")->where("id",$tag_id)->where("state",1)->select("title")->first();
	if($data){
		return $data->title;
	}else{
		return "";
	}
}

/*
*判断文章是否收藏
*20181015
*/
function article_is_collect($article_id,$user_id){
	$data = DB::table("article_collect")->where([["article_id","=",$article_id],["user_id","=",$user_id]])->first();
	if($data){
		//已收藏
		return 1;
	}else{
		//未收藏
		return 0;
	}
}

/*
*判断文章是否被喜欢
*20181015
*/
function article_is_like($article_id,$user_id){
	$data = DB::table("article_like_records")->where([["article_id","=",$article_id],["user_id","=",$user_id]])->first();
	if($data){
		//已喜欢
		return 1;
	}else{
		//未喜欢
		return 0;
	}
}

/*
*判断用户是享用该类别课程并且判断是否到期
*20181022
*/
function expericence_card_isture($course_class_type_id,$user_id){
	$freeCard    = DB::table("expericence_card_records")->where([["type_id","=",0],["user_id","=",$user_id]])->select("start_time", "experience_time")->first();
	//现时免费
	if($freeCard){
		$end_time =  strtotime($freeCard->start_time)+$freeCard->experience_time*(24*60*60);
		if($end_time>time()){
			//没有到期
			return 1;
		}
	}else{
		$expericence = DB::table("expericence_card_records")->where([["type_id","=",$course_class_type_id],["user_id","=",$user_id]])->select("start_time", "experience_time")->first();
		if($expericence){
			$end_time =  strtotime($expericence->start_time)+$expericence->experience_time*(24*60*60);
			//return date("Y-m-d H:i:s", $end_time);
			if($end_time>time()){
				//没有到期
				return 1;
			}
		}
	}
	return 0;
}

/*
*存储用户上下级关系 /赠送免费课程
*$fission_id 分享人id
*$user_id    新用户id
*$channel    具体来源 课程或者文章
*$from       来源渠道
*$is_give    是否赠送课程默认0;
*20181022
*/
function users_growing($fission_id,$user_id,$channel="",$from="", $is_give=0){


	//20201206千人减脂活动开始这里暂时停用
	return;
	//logger()->info("function_users_growing开始".$user_id);
	if($fission_id==""){
		$fission_id = 0;
	}else{
		$fission_id = intval($fission_id);
	}
	if($is_give==1){
		$course_class_ids = DB::table("course_class")->where(["register_free_watch"=>1, "state"=>1])->select("id")->get();
	    //处理赠送课程
	    if($course_class_ids){
	    	$studying = new Studying();
	    	foreach($course_class_ids as $course_class_id){
	    		$studying->addOne($user_id, $course_class_id->id);
	    	}
	    }
	}
    //用户属性表
	$attribute = DB::table("users_attribute")->where("user_id", $user_id)->first();
	if(!$attribute){
		$data = array();
		$data['user_id']      = $user_id;
		$data['is_fission']   = 0;
		$data['created_at']   = date("Y-m-d H:i:s");
		DB::table("users_attribute")->insert($data);
		unset($data);
	}
	
	//用户上下级关系表
	$user    = DB::table("users")->where("id", $user_id)->select("name", "mobile","created_at", "sex", "nickname")->first();
	$growing = DB::table("users_growing")->where("user_id", $user_id)->first();

	if($fission_id==0 && $growing && $growing->fission_id){
		$fission_id = $growing->fission_id;
	}
	//默认渠道信息
	$utm_source = "saipubbs";
	$utm_medium = "shequ";
	if($fission_id > 0){
		$parentGrow = DB::table("users_growing")->where("user_id", $fission_id)->select('utm_source','utm_medium')->first();
		if($parentGrow->utm_source != ""){
			$utm_source = $parentGrow->utm_source;
			$utm_medium = $parentGrow->utm_medium;
		}
	}
    if($user->mobile){
    	$item['name']        = $user->name;
	    $item['mobile1']     = $user->mobile;
	    $item['inputTime']   = $user->created_at ? $user->created_at : date("Y-m-d H:i:s");
	    $item['sex']         = $user->sex=='male' ? "01" : "02";
	    $item['sourceType']  = 2;   //1： 表单       2： 赛普健身社区
	    $item['fromUrl']     = "http://m.saipubbs.com/?utm_source=".$utm_source."&utm_medium=".$utm_medium; //渠道信息
	    $data1 = array();
    	if($fission_id>0){
        	$parent = DB::table("users_attribute")->where("user_id", $fission_id)->first();   //查看上级是否是裂变者
	        if($parent && $parent->is_fission==1){
	        	//发送数据走第二个接口
	        	$utm_source = "saipubbs";
	        	$utm_medium = "reserve";
        		$mobile = DB::table("users")->where("id", $fission_id)->select("mobile")->first();
	        	$item2['employeeMobile'] = $mobile->mobile;    //员工手机号
	        	$item2['traineeMobile']  = $user->mobile;      //学员手机号
	        	$item2['fromUrl']        = "http://m.saipubbs.com/?utm_source=".$utm_source."&utm_medium=".$utm_medium;
	        	//$r1 = request_post_two($item2);
	        	//DB::table("users_growing_post_records")->insert(array("post_data"=>json_encode($item2), "result_data"=>json_encode($r1), "created_at"=>date("Y-m-d H:i:s")));   //记录发送日志
	        	//$data1['code']   = $r1['code'];
				$data1['msg']    = '20190905暂停发送';
				$data1['api_number'] = "api2";
	        }elseif($parent && $parent->is_fission==2){
	        	$data1['msg']    = "就业老师不发送";
	        	$data1['top_top_id']    = $parent->user_id;
	        }elseif($parent && $parent->is_fission==3){
	        	//表示该身份为课程顾问
	        	$teacher = DB::table("users_growing")->where("user_id", $fission_id)->first();//当前用户上级fission_id
	        	$mobile  = DB::table("users")->where("id", $teacher->fission_id)->select("mobile")->first();
	        	$item2['employeeNo']     = $teacher->employeeNo;    //课程顾问在管理系统的id号
	        	$item2['mobile']         = $user->mobile;           //学员手机号
	        	$item2['traineeName']    = $user->nickname ? $user->nickname : "暂无姓名";         //学员姓名
	        	
	        	//$r1 = request_post_crm($item2);   //课程顾问发送数据接口
	        	//DB::table("users_growing_post_records")->insert(array("post_data"=>json_encode($item2), "result_data"=>json_encode($r1), "created_at"=>date("Y-m-d H:i:s")));   //记录发送日志
	        	//$data1['code']   = $r1['code'];
				$data1['msg']    = '20190905暂停发送';
				$data1['api_number'] = "api3";
	        }else{
	        	$parent_grow = DB::table("users_growing")->where("user_id", $fission_id)->first();//当前用户上级fission_id
	        	if($parent_grow && $parent_grow->fission_id){

	        		$parent1 = DB::table("users_attribute")->where("user_id", $parent_grow->fission_id)->first();   //查看上级是否是裂变者
	        		if($parent1 && $parent1->is_fission==1){
	        			$utm_source = "saipubbs";
	        			$utm_medium = "reserve";
        				$mobile = DB::table("users")->where("id", $parent1->user_id)->select("mobile")->first();
			        	$item2['employeeMobile'] = $mobile->mobile;    //员工手机号
			        	$item2['traineeMobile']  = $user->mobile;      //学员手机号
			        	$item2['fromUrl']        = "http://m.saipubbs.com/?utm_source=".$utm_source."&utm_medium=".$utm_medium;
			        	//$r1 = request_post_two($item2);
			        	//DB::table("users_growing_post_records")->insert(array("post_data"=>json_encode($item2), "result_data"=>json_encode($r1), "created_at"=>date("Y-m-d H:i:s")));   //记录发送日志
			        	//$data1['code']   = $r1['code'];
						$data1['msg']    = '20190905暂停发送';
						$data1['api_number'] = "api2";
	        		}elseif($parent1 && $parent1->is_fission==2){
	        			$data1['msg']    = "就业老师不发送";
	        			$data1['top_top_id']    = $parent1->user_id;
	        		}elseif($parent1 && $parent1->is_fission==3){
	        			//表示该身份为课程顾问
	        			$teacher = DB::table("users_growing")->where("user_id", $parent1->user_id)->first();//当前用户上级fission_id
	        			$mobile  = DB::table("users")->where("id", $teacher->fission_id)->select("mobile")->first();
			        	$item2['employeeNo']   = $teacher->employeeNo;    //课程顾问在管理系统的id号
			        	$item2['mobile']       = $user->mobile;           //学员手机号
			        	$item2['traineeName']  = $user->nickname ? $user->nickname : "暂无姓名";;         //学员手机号
			        	
			        	//$r1 = request_post_crm($item2);  //课程顾问发送数据接口
			        	//DB::table("users_growing_post_records")->insert(array("post_data"=>json_encode($item2), "result_data"=>json_encode($r1), "created_at"=>date("Y-m-d H:i:s")));   //记录发送日志
			        	//$data1['code']   = $r1['code'];
						$data1['msg']    = '20190905暂停发送';
						$data1['api_number'] = "api3";
	        			$fission_id = $parent1->user_id;
	        		}else{
        				$r = request_post($item);   //执行发送数据
			        	$data1['code']   = $r['code'];
						$data1['msg']    = $r['msg'];
						// $data1['code']       = "20";  	   // 状态码
						// $data1['msg']        = "转介绍活动暂时不发送";   // 数据
						$data1['api_number'] = "api11";
	        		}
	        	}else{
    				$r = request_post($item);   //执行发送数据
		        	$data1['code']   = $r['code'];
					$data1['msg']    = $r['msg'];
					// $data1['code']       = "20";  	   // 状态码
					// $data1['msg']        = "转介绍活动暂时不发送";   // 数据
					$data1['api_number'] = "api12";
	        	}
	        }
        }else{
			$r = request_post($item);   //执行发送数据
        	$data1['code']   = $r['code'];
			$data1['msg']    = $r['msg'];
			// $data1['code']       = "20";  	   // 状态码
			// $data1['msg']        = "转介绍活动暂时不发送";   // 数据
			$data1['api_number'] = "api13";
        }
        //老用户已存在重新梳理上下级关系
		if($growing){
		    $data1['name']   = $user->name ? $user->name : "-";
		    $data1['mobile'] = $user->mobile;
		    if($fission_id>0){
		    	$data1['fission_id'] = $fission_id;
		    }
		    $data1['updated_at']  = date("Y-m-d H:i:s");
		    $data1['json_data']   = json_encode($data1);
		    $data1['utm_source']   = $utm_source;
		    $data1['utm_medium']   = $utm_medium;
			//完善信息
			DB::table('users_growing')
	            ->where("id", $growing->id)
	            ->update($data1);
		}else{
			//发送数据   绑定上下级关系
			$data1['fission_id'] = $fission_id ? $fission_id : 0;
			$data1['user_id']    = $user_id;
			$data1['name']       = $user->name;
			$data1['mobile']     = $user->mobile;
			$data1['created_at'] = date("Y-m-d H:i:s");
			$data1['from']       = $from;      // 来源
			$data1['channel']    = $channel;   // 具体来源信息  课程/文章
			$data1['json_data_insert']   = json_encode($data1);
			$data1['utm_source']   = $utm_source;
			$data1['utm_medium']   = $utm_medium;
			DB::table("users_growing")->insert($data1);
		}
    }else{
    	//绑定上下级关系
    	$data2 = array();
		$data2['fission_id'] = $fission_id ? $fission_id : 0;
		$data2['user_id']    = $user_id;
		$data2['name']       = $user->name ? $user->name : "--";
		$data2['mobile']     = $user->mobile ? $user->mobile : "";
		$data2['created_at'] = date("Y-m-d H:i:s");
		$data2['from']       = $from;      // 来源
		$data2['channel']    = $channel;   // 具体来源信息  课程/文章
		$data2['json_data_insert']   = json_encode($data2);
		$data2['utm_source']   = $utm_source;
		$data2['utm_medium']   = $utm_medium;
		DB::table("users_growing")->insert($data2);
    }
//	logger()->info("function_users_growing结束2");
}

/*
*转介绍活动存储用户上下级关系 /赠送免费课程
*$fission_id 分享人id
*$user_id    新用户id
*$channel    具体来源 课程或者文章
*$from       来源渠道
*$is_give    是否赠送课程默认0;
*20190522
*/
function users_growing_introduction($fission_id=0,$user_id,$channel="",$from="", $is_give=0){
	if($fission_id==""){
		$fission_id = 0;
	}else{
		$fission_id = intval($fission_id);
	}
	if($is_give==1){
		$course_class_ids = DB::table("course_class")->where(["register_free_watch"=>1, "state"=>1])->select("id")->get();
	    //处理赠送课程
	    if($course_class_ids){
	    	$studying = new Studying();
	    	foreach($course_class_ids as $course_class_id){
	    		$studying->addOne($user_id, $course_class_id->id);
	    	}
	    }
	}
	//默认渠道信息
	$utm_source = "saipubbs";
	$utm_medium = "shequ";
    //用户属性表
	$attribute = DB::table("users_attribute")->where("user_id", $user_id)->first();
	if(!$attribute){
		$data = array();
		$data['user_id']      = $user_id;
		$data['is_fission']   = 0;
		$data['created_at']   = date("Y-m-d H:i:s");
		DB::table("users_attribute")->insert($data);
		unset($data);
	}
	//用户上下级关系表
	$growing = DB::table("users_growing")->where("user_id", $user_id)->first();
	$user    = DB::table("users")->where("id", $user_id)->select("name", "mobile","created_at", "sex", "nickname")->first();
	if(!$growing){
		$data2 = array();
		$data2['fission_id'] = $fission_id ? $fission_id : 0;
		$data2['user_id']    = $user_id;
		$data2['name']       = $user->name ? $user->name : "--";
		$data2['mobile']     = $user->mobile ? $user->mobile : "";
		$data2['created_at'] = date("Y-m-d H:i:s");
		$data2['from']       = $from;      // 来源
		$data2['channel']    = $channel;   // 具体来源信息  课程/文章
		$data2['code']       = "20";  	   // 状态码
		$data2['msg']        = "转介绍活动暂时不发送";   // 数据
		$data2['utm_source']   = $utm_source;
		$data2['utm_medium']   = $utm_medium;
		DB::table("users_growing")->insert($data2);
	}	
}

 /**
 * 导用户数据到信息运营中心
 * 20181113
 */
function request_post($info=''){
    if (empty($info)) {
        return array("code"=>'200', "msg"=>"参数有误");
    }
    $postUrl = "isaipu.net/market/QuasiTraineeInfo/officialapi";
    $ch = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $info);
    $data = curl_exec($ch);//运行curl
    curl_close($ch);
    return json_decode($data,true);
}

 /**
 * 导用户数据到信息运营中心第二个接口
 * 20181206
 */
function request_post_two($info=''){
    if (empty($info)) {
        return array("code"=>'200', "msg"=>"参数有误");
    }
    $postUrl = "isaipu.net/api/market/channelFixation";   
    
    $ch = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $info);
    $data = curl_exec($ch);//运行curl
    curl_close($ch);
    return json_decode($data,true);
}

 /**
 * 录入代理资源到管理系统
 * 20190511
 */
function request_post_crm($info=''){
    if (empty($info)) {
        return array("code"=>'200', "msg"=>"参数有误");
    }
    //生产环境
    $postUrl = "http://101.201.81.14:9315/saipu-app-ins"."/api/add_stu";   
   
    $ch = curl_init();                     //初始化curl
    curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);   //设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);     //post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $info);
    $data = curl_exec($ch);                //运行curl
    curl_close($ch);
    return json_decode($data,true);
}

/*
*判断文章是否为新发布文章
*20181108
*/
function article_isnew($time){
	$time = strtotime($time)+60*60*24*3;
	$now  = time();
	if($time>$now){
		return 1;
	}else{
		return 0;
	}
}

/**
 * 裂变者
 */
function is_fission($userid){
	$data = DB::table("users_attribute")->where("user_id",$userid)->select("is_fission")->first();
	if($data){
		return $data->is_fission;
	}else{
		return 0;
	}
	
}


/*
*查看精选文章
*20181130
*/
function get_articla_selected($article_ids){
	$article_ids_arr = explode(",", $article_ids);
	$articles = DB::table("article")->where("state",1)
				->whereIn("id", $article_ids_arr)
				->select("id", "title", "cover_url", "user_id", "likes", "views", "created_at", "is_video","is_selected",'video_url')
                ->orderBy("orderby","desc")
                ->get();
    return $articles;
}

/*
*对象转数组方法
*20181205
*/
function object_to_array($obj) {
    $obj = (array)$obj;
    foreach ($obj as $k => $v) {
        if (gettype($v) == 'resource') {
            return;
        }
        if (gettype($v) == 'object' || gettype($v) == 'array') {
            $obj[$k] = (array)object_to_array($v);
        }
    }
    return $obj;
}


/*
*字符串截取超过长度变省略号
*20181211
*/
function subtext($text, $length)
{
    if(mb_strlen($text, 'utf8') > $length) {
        return mb_substr($text, 0, $length, 'utf8').'...';
    } else {
        return $text;
    }
 
}

/*
 * 昵称特殊字符过滤
 */
function filterSpecialChar($word){
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

/*
*判断文章是否是问答
*20190121
*/
function is_question($type_ids)
{
    $ids = explode(",", $type_ids);
    foreach($ids as $id){
    	$type = DB::table("type")->where("id", $id)->where("state",1)->where("is_index",0)->first();
    	if($type){
    		return 1;
    	}
    }
 	
 	return 0;
}

/*
*统计问答专区作业/问题回答总数
*20190327
*$qid    作业/问题id
*/
function q_answer_count($qid,$is_approve=0)
{
	if($is_approve){
		//回答被老师认可总数
		$count = DB::table("ask_answer")->where("qid", $qid)->where("is_approve", 1)->count();
	}else{
		//回答总数
		$count = DB::table("ask_answer")->where("qid", $qid)->count();
	}
    if($count){
    	return $count;
    }else{
    	return 0;
    }	
}

/**
 * 问答专区答案总数
 * 1为提问
 * 2为回答
 * 3为认可
 */

function all_answer_num($fid,$status){
	$qid = DB::table("ask_question")->where("special_id",$fid)->select("id")->get();
	if($status == 1){
		$count = count($qid);
	}elseif($status == 2){
		if(count($qid)>0){
			$arr = [];
			foreach($qid as $k=>$v){
				$arr[$k] = $v->id;
			}
			$count = DB::table("ask_answer")->whereIn("qid",$arr)->count();
		}else{
			$count = 0;
		}
	}else{//获得认可
		if(count($qid)>0){
			$arr = [];
			foreach($qid as $k=>$v){
				$arr[$k] = $v->id;
			}
			$count = DB::table("ask_answer")->whereIn("qid",$arr)->where("is_approve",">","0")->count();
		}else{
			$count = 0;
		}
	}

	return $count;

}

/*
*生成订单号
*20190410
*/
function order_number()
{
	return date("YmdHis").rand(1000,9999);
}

/*
*访问记录
*20190426
*/
function visit_record($info, $method)
{
	if($info->user()){
        $userid = $info->user()->id;
    }else{
        $userid = 0;
    }
    $data = array();
    $data['year']   = date("Y");
    $data['month']  = date("Y-m");
    $data['day']    = date("Y-m-d");
    $data['month']  = date("m");
    $data['user_id']= $userid;
    $data['method'] = $method;
    $data['created_at'] = date("Y-m-d H:i:s");
    DB::table("visit_record")->insert($data);
}


/*
*获取转介绍人信息
*20190410
*/
function introduction_person($user_id)
{
	$person = DB::table("introduction_person")->where("user_id", $user_id)->select("name")->first();
	if($person){
		return $person->name;
	}else{
		return '暂无';
	}
}

/*
*获取常规问答待回答总数
*20190805
*/
function sum_common_ask_questions($is_ans=0)
{
	$count  = DB::table("common_ask_questions")->where('is_ans', $is_ans)->count();
	if($count){
		return $count;
	}else{
		return 0;
	}
}



