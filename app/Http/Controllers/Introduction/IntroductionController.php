<?php

namespace App\Http\Controllers\Introduction;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\IntroductionStaff;
use App\Models\IntroductionResource;
use App\Models\IntroductionStaffReg;
use App\Models\IntroductionPerson;
use App\Models\Studying;

use App\Http\Controllers\Controller;
use App\Utils\WxMessagePush as WxPush;
use App\Models\ArticleRecommend;
use App\Constant\WxMessageType;
use App\Utils\MakeThumbPic;
use App\Utils\SensitiveWord;
use App\Utils\Alidayu;
use App\Utils\CurlUtil;
use Illuminate\Support\Facades\Redis;
use Mail;
class IntroductionController extends Controller
{
	protected $apiUrl;

	public function __construct()
    {
        $this->apiUrl = "http://101.201.81.14:9315/saipu-app-ins";
    }
    /*
    * 员工中心
    * 20190516
    */
   	public function staff(Request $request){
   		return "请使用赛普家转介绍小程序";
   		if($request->user()){
            $user_id = $request->user()->id;
        }else{
			$url = urlencode('/intro/staff');
            return redirect('/login?redirect='.$url);
        }
        //判断是否为员工，如果是直接进入员工中心
        $item = IntroductionStaff::where("user_id", $user_id)->first();
        if($item){
        	return redirect('/intro/staffList');
        }

        return view('introduction.staff');
  	}

	public function staffJoin(Request $request){
		$mobile = $request->input('mobile');
		$user = $request->user();
		if(!$user){
			return $this->getMessage(1,'用户未登陆');
		}
		if(empty($mobile)){
			return $this->getMessage(1,'手机号为空');
		}
		$result = $this->regStaffMobile($mobile);
		if(!$result){
			return $this->getMessage(1,'该员工不存在');
		}
		$introStaff = IntroductionStaff::where('mobile',$mobile)->select('id')->first();
		if($introStaff){
			return $this->getMessage(1,'该手机号已申请');
		}
		$introStaff = new IntroductionStaff();
		$introStaff->user_id = $user->id;
		$introStaff->openid = $user->openid;
		$introStaff->mobile = $mobile;
		$introStaff->idcard = '';
		if($introStaff->save()){
			return $this->getMessage(0,'申请成功');
		}else{
			return $this->getMessage(1,'申请失败');
		}
	}
	public function staffInfo(Request $request){
		return "请使用赛普家转介绍小程序";
		$user = $request->user();
		if(!$user){
			$url = urlencode('/intro/staffList');
			return redirect('/login?redirect='.$url);
		}
//		dd($user->name);
		$introStaff = IntroductionStaff::where('user_id',$user->id)->select('id')->first();
		if(!$introStaff){
			return redirect('/intro/staff');
		}

		$reserveInfo = $this->resourceState($user->id,'staff');
		$data = $reserveInfo;

		$partnerNum = IntroductionPerson::where('int_staff_id',$user->id)->count();
		$stuNum = IntroductionResource::where('int_staff_id',$user->id)->count();
		$data['partnerNum'] = $partnerNum;
		$data['stuNum'] = $stuNum;
		$data['staff_id'] = $user->id;
		$introResource = IntroductionResource::where('int_staff_id',$user->id)->get();
		$data['introResource'] = $introResource;
		$is_local = env("IS_LOCAL");
		if($is_local){
			$data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
		}else{
			$data['WechatShare'] = getSignPackage();  //微信分享
		}
		return view('introduction.staffInfo',$data);
	}

	public function partner(Request $request,$id){
		return "请使用赛普家转介绍小程序";
		if($request->user()){
            $user_id = $request->user()->id;
        }else{
			$user_id = 0;
        }
		$is_staff = 0;
//		if($id == $user_id){
//			$is_staff = 1;
//		}
		//页面浏览数加1
        DB::table("introduction_staff")->where("user_id",$id)->increment("views",1);
        //判断是否为转介绍人，如果是直接进入转介绍人中心
        $partner = IntroductionPerson::where("user_id", $user_id)->first();
        if($partner){
        	return redirect('/intro/partnerList');
        }
		$is_local = env("IS_LOCAL");
		if($is_local){
			$data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
		}else{
			$data['WechatShare'] = getSignPackage();  //微信分享
		}

		$data['staff_id'] = $id;
		$data['is_staff'] = $is_staff;
		$data['user_id']  = $id; //员工user_id
		return view('introduction.partner',$data);
	}

	public function partnerJoin(Request $request){
		$staff_id = $request->input('s_id');
		$mobile = $request->input('mobile');
//		$idcard = $request->input('idcard');
		$code = $request->input('code');
		$name = $request->input('name');
		$originMobile = $request->input('originMobile','');
		$user = $request->user();
		if(!$user){
			return $this->getMessage(2,'用户未登陆');
		}
		$mobile_code = Redis::get('code_'.trim($mobile));

		if($mobile_code != $code){
			return $this->getMessage(1,'验证码有误或已过期');
		}
		$introStaff = IntroductionStaff::where('user_id',$staff_id)->select('mobile')->first();
		if(!$introStaff){
			return $this->getMessage(1,'员工不存在');
		}
		$introPerson = IntroductionPerson::where('mobile',$mobile)->select('id')->first();
		if($introPerson){
			return $this->getMessage(1,'已申请加入');
		}
		if(!empty($originMobile)){
			$resultInfo = $this->oldPartnerJoin($name,$staff_id,$originMobile,$mobile,$user);
			return $resultInfo;
		}
		$url    = "http://101.201.81.14:9315/saipu-app-ins/api/people_info?mobile=".$mobile;
		$result = httpGet($url);
		$info = json_decode($result);
		if($info->code == 1){
			return $this->getMessage(1,'没有该学员');
		}
		$type = $info->result->type;

		if($type == 'agent'){
			return $this->getMessage(1,'你已成为代理，无法参与此次活动');
		}elseif($type=="introducer"){
			//通过
		}elseif($type=="trainee" && $info->result->traineeStatus != '05'){
			return $this->getMessage(1,'非赛普学员，无法申请');
		}elseif($type=="unknown"){
			return $this->getMessage(1,'没有该学员');
		}


		$introPerson = new IntroductionPerson();
		$introPerson->user_id = $user->id;
		$introPerson->mobile = $mobile;
		$introPerson->name = $name;
		$introPerson->int_staff_id = $staff_id;
		return $this->getMessage(1,'加入申请失败,请使用微信小程序');
		if($introPerson->save()){
			return $this->getMessage(0,'加入申请成功');
		}else{
			return $this->getMessage(1,'加入申请失败');
		}
	}
	public function oldPartnerJoin($name,$staff_id,$originMobile,$mobile,$user){
		$url    = "http://101.201.81.14:9315/saipu-app-ins/api/people_info?mobile=".$originMobile;
		$result = httpGet($url);
		$info = json_decode($result);
		if($info->code == 1){
			return $this->getMessage(1,'手机号有误，请联系您的咨询老师');
		}
		$type = $info->result->type;
		// if($type == 'trainee' && $info->result->traineeStatus != '05'){
		// 	return $this->getMessage(1,'非赛普学员，无法申请');
		// }
		// if($type == 'agent'){
		// 	return $this->getMessage(1,'你已成为代理，无法参与此次活动');
		// }
		// if($type != 'introducer'){
		// 	return $this->getMessage(1,'没有该学员'.$type.$info->result->traineeStatus);
		// }

		if($type == 'agent'){
			return $this->getMessage(1,'你已成为代理，无法参与此次活动');
		}elseif($type=="introducer"){
			//通过
		}elseif($type=="trainee" && $info->result->traineeStatus != '05'){
			return $this->getMessage(1,'手机号有误，请联系您的咨询老师');
		}elseif($type=="unknown"){
			return $this->getMessage(1,'手机号有误，请联系您的咨询老师');
		}


		$introPerson = new IntroductionPerson();
		$introPerson->user_id = $user->id;
		$introPerson->mobile = $mobile;
		$introPerson->old_mobile = $originMobile;
		$introPerson->name = $name;
		$introPerson->int_staff_id = $staff_id;
		return $this->getMessage(1,'加入申请失败');
		if($introPerson->save()){
			return $this->getMessage(0,'加入申请成功');
		}else{
			return $this->getMessage(1,'加入申请失败');
		}
	}
	public function tiaoLi(Request $request){
		return view('introduction.tiaoli');
	}
	public function partnerJudge(Request $request){
		$mobile = $request->input('mobile');
		$url    = "http://101.201.81.14:9315/saipu-app-ins/api/people_info?mobile=".$mobile;
		$result = httpGet($url);
		$info = json_decode($result);
		if($info->code == 1){
			return $this->getMessage(1,'手机号有误，请联系您的咨询老师');
		}
		$type = $info->result->type;
		if($type == 'agent'){
			return $this->getMessage(1,'你已成为代理，无法参与此次活动');
		}elseif($type=="introducer"){
			//通过
		}elseif($type=="trainee" && $info->result->traineeStatus != '05'){
			return $this->getMessage(1,'手机号有误，请联系您的咨询老师');
		}elseif($type=="unknown"){
			return $this->getMessage(1,'手机号有误，请联系您的咨询老师');
		}
		return $this->getMessage(0,'验证通过');
	}

	public function partnerInfo(Request $request){
		$user = $request->user();
		if(!$user){
			$url = urlencode('/intro/staffList');
			return redirect('/login?redirect='.$url);
		}
		$introPerson = IntroductionPerson::where('user_id',$user->id)->select('id','name',"bank_username", "bank_card_number", "bank_info")->first();
//		dd($introPerson);
		if(!$introPerson){
			return redirect('/intro/partner/'.$user->id.'.html');
		}
		$reserveInfo = $this->resourceState($user->id);
		$data = $reserveInfo;
		$stuNum = IntroductionResource::where('int_person_id',$user->id)->count();
		$data['stuNum'] = $stuNum;
		//$introResource = IntroductionResource::where('int_person_id',$user->id)->select("mobile")->get();
		$data['partnerName'] = $introPerson->name;
		$data['introPerson'] = $introPerson;
		$data['partner_id'] = $user->id;
		$is_local = env("IS_LOCAL");
		if($is_local){
			$data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
		}else{
			$data['WechatShare'] = getSignPackage();  //微信分享
		}
//		dd($data);
		return view('introduction.partnerInfo',$data);
	}
	/*
	 * 合伙人补充信息
	 */
	public function cardBank(Request $request){
		$user = $request->user();
		if(!$user) {
			return json_encode(['code'=>2,'message'=>'用户未登录']);
		}
		$introPartner = IntroductionPerson::where('user_id',$user->id)->first();
		$cardName = $request->input('cardName');
		$card = $request->input('card');
		$cardBank = $request->input('cardBank');
		$introPartner->bank_username = $cardName;
		$introPartner->bank_card_number = $card;
		$introPartner->bank_info = $cardBank;
		if($introPartner->save()){
			return $this->getMessage(0,'添加成功');
		}else{
			return $this->getMessage(0,'添加失败');
		}
	}

	public function reserve(Request $request,$id){
		return "请使用赛普家转介绍小程序";
		if($request->user()){
            $user_id = $request->user()->id;
        }else{
			$user_id = 0;
        }
        $data['user_id']  = $user_id;
        if($user_id==$id){
        	$data['is_partner'] = 1;
        }else{
        	$data['is_partner'] = 0;
        }
		$data['partner_id'] = $id;
		$introPerson = IntroductionPerson::where('user_id',$id)->first();
		if(!$introPerson){
			return '';
		}else{
			$introPerson->views += 1;
			$introPerson->save();
		}
		$style = $request->input('style',0);
		$is_local = env("IS_LOCAL");
		if($is_local){
			$data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
		}else{
			$data['WechatShare'] = getSignPackage();  //微信分享
		}
		$data['style'] = $style;
//		dd($style);
		return view('introduction.reserve',$data);
	}

	public function getPoster(Request $request){
		$user = $request->user();
		$flag = $request->input('flag',0);
		$imageThumb  = new MakeThumbPic();
		$bodyPic = "/images/zt/jieshao.png";
		$user_id = $request->user()->id;
		if($flag==1){
			$shareCodeArr[]  = "http://qr.topscan.com/api.php?text=http://m.saipubbs.com/intro/reserve/".$user_id.".html";
			$shareCodeArr[]  = "http://qr.topscan.com/api.php?text=http://m.saipubbs.com/intro/reserve/".$user_id.".html?style=1";
			$shareCodeArr[]  = "http://qr.topscan.com/api.php?text=http://m.saipubbs.com/intro/reserve/".$user_id.".html";
			$imgArr = ["/images/zt/resource.png","/images/zt/resource1.png","/images/zt/resource.png"];
		}else{
			$shareCodeArr[] = "http://qr.topscan.com/api.php?text=http://m.saipubbs.com/intro/partner/".$user->id.'.html';
			// $shareCodeArr[] = "http://qr.topscan.com/api.php?text=http://m.saipubbs.com/intro/partner/".$user->id.'.html';
			$imgArr = ["/images/zt/jieshao.png"];
			// $imgArr = ["/images/zt/jieshao.png","/images/zt/jieshao1.png"];
		}
		$destDirectory = "/upload/wxqrcode/";
		if (!file_exists(public_path().'/'.$destDirectory)) {
			$fileDir = mkdir(public_path().'/'.$destDirectory,0777,true);
		}else{
			$fileDir = public_path().'/'.$destDirectory;
		}

		foreach($shareCodeArr as $shareCode){
			$file = time().rand(1000,9999).".png";
			$r = $this->getImage($shareCode,$fileDir, $file);
			$wechatCodeArr[] = $destDirectory.$r['file_name'];
		}
		$name = '';
//		dd($name);
		$activity = 5;
		foreach($imgArr as $k => $bodyPic){
			$img_url[] = $imageThumb->makePic($bodyPic, '', $wechatCodeArr[$k],'upload/share/', $name,$activity);
		}
		$picContent = $this->getPic($img_url, $flag);
		return ['code'=>0,'body'=>$picContent];
	}

	public function getPic($res ,$flag){
		if($flag==1){
			$content = '<div class="pop-img-height-auto"><div class="bm_success_layer text_center tan-font fz"><div class="swiper-container swiper_con"><div class="swiper-wrapper"><div class="swiper-slide"><img src="/'.$res[0][1].'" class="" alt="" /><span onclick="sucai(1);" class="block fz f26 ptb20 jiugongge">查看素材包  &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp; 上图可长按保存</span></div><div class="swiper-slide"><img src="/'.$res[1][1].'" class="" alt="" /><span onclick="sucai(2);" class="block fz f26 ptb20 jiugongge2">查看素材包  &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp; 上图可长按保存</span></div><div class="swiper-slide"><img src="/'.$res[2][1].'" class="" alt="" /><span onclick="sucai(3);" class="block fz f26 ptb20 jiugongge">查看素材包  &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp; 上图可长按保存</span></div></div>
<div class="swiper-button-prev"></div><div class="swiper-button-next"></div></div></div></div>';
		}else{
			$content = '<div class="pop-img-height-auto">
	<div class="bm_success_layer text_center tan-font fz">
		<div class="swiper-container swiper_con">
			<div class="swiper-wrapper">
				<div class="swiper-slide">
					<img src="/'.$res[0][1].'" class="" alt="" />
					<span onclick="sucai(1);" class="block fz f26 ptb20 jiugongge">查看素材包  &nbsp;&nbsp;&nbsp;/&nbsp;&nbsp; 上图可长按保存</span>
				</div>
			</div>
		</div>
	</div>
</div>';
		}
		
		return $content;
	}

	public function clickSet(Request $request){
		$partner_id = $request->input('p_id');
		$introPerson = IntroductionPerson::where('user_id',$partner_id)->first();
//		dd($introPerson);
		if($introPerson){
			$introPerson->clicks += 1;
			$introPerson->save();
		}
		return $this->getMessage(0,'用户报名统计');
	}

	public function postReserve(Request $request){
		$partner_id = $request->input('p_id');
		$mobile = $request->input('mobile');
		$name = $request->input('name');
		$path = $request->input('path');
		$code = $request->input('code');
		$mobile_code = Redis::get('code_'.trim($mobile));

		// if($mobile_code != $code){
		// 	return $this->getMessage(1,'验证码有误或已过期');
		// }
		$introPerson = IntroductionPerson::where('user_id',$partner_id)->first();

		if(empty($mobile)){
			return $this->getMessage(1,'未填写手机号');
		}
		if(!$introPerson){
			return $this->getMessage(1,'不存在该合伙人');
		}else{
			$introPerson->clicks += 1;
			$introPerson->save();
		}
		$introResource = IntroductionResource::where('mobile',$mobile)->first();
		if($introResource){
			return $this->getMessage(1,'您已报名，请勿重复填写');
		}
		$url    = "http://101.201.81.14:9315/saipu-app-ins/api/trainee_info?mobile=".$mobile;
		$result = httpGet($url);
		$info = json_decode($result);

		try{
			$introResource = new IntroductionResource();
			$introResource->int_person_id = $partner_id;
			$introResource->int_staff_id = $introPerson->int_staff_id;
			$introResource->name = $name;
			$introResource->mobile = $mobile;
			$introResource->code = $info->code;
			$introResource->msg = $info->msg;
			$introResource->url = $path;
			$introResource->result = $result;

			if($info->code == 1){

				$infoArr = [];
				$infoArr['name']        = $name;
				$infoArr['mobile1']     = $mobile;
				$infoArr['inputTime']   = date("Y-m-d H:i:s");
				$infoArr['sex']         = "02";
				$infoArr['sourceType']  = 2;   //1： 表单
				$infoArr['fromUrl']     = "http://m.saipubbs.com/?utm_source=saipubbs&utm_medium=shequ"; //渠道信息
				$introStaff = IntroductionStaff::where('user_id',$introPerson->int_staff_id)->select('mobile')->first();
				if($introStaff){
					$staffMobile = $introStaff->mobile;
				}else{
					$staffMobile = '';
				}
				$introReg = IntroductionStaffReg::where('staff_mobile',$staffMobile)->first();
				if($introReg && $introReg->state == 1){
					$is_send = 0;
					//给新手机号发送短信
					if($introReg->staff_mobile1){
						$staffMobile = $introReg->staff_mobile1;
					}
				}else{
					$is_send = 1;
				}
				if($is_send){
					logger()->info("d");
					$result = request_post($infoArr);
					$introResource->post_resource_code    = $result['code'];
					$introResource->post_resource_msg = $result['msg'];
				}else{
					logger()->info("d1");
					$dataInfo['name'] = $name;
					$introResource->has_teacher = 1;
					$dataInfo['partnerMobile'] = $introPerson->mobile;
					$this->sendCodeToStaff($staffMobile,$mobile,0,$dataInfo);
				}

				if($introResource->save()){
					return $this->getMessage(0,'加入成功');
				}else{
					return $this->getMessage(1,'加入申请失败');
				}
			}
			$serviceMobile = $info->result->serviceEmployeeInfoMobile;
			if(!empty($info->result->introducerMobile)){

				if($introPerson->mobile == $info->result->introducerMobile){
					$introResource->system_introducer_mobile = $introPerson->mobile;
					$introResource->system_exist = 1;
					$introResource->service_employeeInfo_mobile = $serviceMobile;
					if($introResource->save()){
						return $this->getMessage(0,'加入成功');
					}else{
						return $this->getMessage(1,'加入申请失败');
					}
				}else{
//					dd(3);
					$introResource->system_exist = 1;
					$introResource->flag = 0;
					$introResource->system_introducer_mobile = $info->result->introducerMobile;
					$introResource->service_employeeInfo_mobile = $serviceMobile;
					if($introResource->save()){
						if(!empty($serviceMobile)){
							$this->sendCodeToStaff($serviceMobile,$mobile,1);
						}
						return $this->getMessage(1,'您已获得其他人的邀请，请勿重复填写。');
					}else{
						return $this->getMessage(1,'加入申请失败');
					}
				}
			}else{
				$introResource->system_exist = 1;
				$introResource->flag = 0;
				$introResource->service_employeeInfo_mobile = $serviceMobile;
//				dd($introResource);
				$introResource->save();
//				dd($introResource);
				if(!empty($serviceMobile)){

					$this->sendCodeToStaff($serviceMobile,$mobile);
				}
				return json_encode(array("code"=>1, "message"=>"您已加入，稍后会有赛普老师与您联系。"));
			}

		}catch(\Exception $e){
			logger()->info($e->getMessage().'----'.$e->getLine());
			return $this->getMessage(1,'加入失败');
		}

	}
	public function sendCode(Request $request){
		$code = $request->input('code','') ? $request->input('code') : mt_rand(100000,999999);
		$time = date('Ymd');
		$this->messageOverNotice();
		$params = array();
		$accessKeyId = config('alidayu.access_key_id');
		$accessKeySecret = config('alidayu.access_key_secret');
		$params["PhoneNumbers"] = trim($request->input('mobile'));
		$params["SignName"] = config('alidayu.sign_name');
		$params["TemplateCode"] = config('alidayu.template_code');
		$params['TemplateParam'] = [
			"code" => $code,
		];
		$flag = $request->input('flag',0);
		if($flag){
			$introResource = IntroductionResource::where('mobile',$request->input('mobile'))->select('id')->first();
			if($introResource){
				return $this->getMessage(1,'已报名');
			}
		}else{
			$introPerson = IntroductionPerson::where('mobile',$params["PhoneNumbers"])->first();
			if($introPerson){
				return $this->getMessage(1,'已申请加入');
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
			$sendKey = 'code_'.$time.'_send';
			if(Redis::exists($sendKey)){
				Redis::incr($sendKey);
			}else{
				Redis::set($sendKey,1);
			}
			echo json_encode(array("code"=>1,"message"=>"发送成功"));
		}else{
			echo json_encode(array("code"=>0,"message"=>"发送失败"));
		};
	}

	/*
	 * 给员工发送短信
	 */
	public function sendCodeToStaff($serviceMobile,$mobile,$flag = 1,$userInfo = []){
//		$serviceMobile = '13301372956';
//		$mobile = '13301372956';
		$params = array();
		$accessKeyId = config('alidayu.access_key_id');
		$accessKeySecret = config('alidayu.access_key_secret');
		$params["PhoneNumbers"] = $serviceMobile;
		if($flag == 1){
			$params["SignName"] = config('alidayu.sign_intro_name');
			$params["TemplateCode"] = config('alidayu.template_intro_code');
			$params['TemplateParam'] = [
				"vacode" => $mobile
			];
		}else{
			$params["SignName"] = config('alidayu.sign_intro_name');
			$params["TemplateCode"] = config('alidayu.template_resource_code');
			$params['TemplateParam'] = [
				"uname" => $userInfo['name'],
				"umobile" => $mobile,
				'imobile' => $userInfo['partnerMobile']
			];
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

		}else{

		}
	}
  	/*
    * 验证是否为员工
    * 20190516
    */
  	protected function regStaffMobile($mobile){
  		$staff =  IntroductionStaffReg::where("staff_mobile", $mobile)->first();
  		if($staff){
  			return 1;
  		}else{
  			return 0;
  		}
  	}

	public function getImage($url,$save_dir='',$filename='',$type=0){
		if(trim($url)==''){
			return array('file_name'=>'','save_path'=>'','error'=>1);
		}
		if(trim($save_dir)==''){
			$save_dir='./';
		}
		if(trim($filename)==''){//保存文件名
			$ext=strrchr($url,'.');
			if($ext!='.gif'&&$ext!='.jpg'){
				return array('file_name'=>'','save_path'=>'','error'=>3);
			}
			$filename=time().$ext;
		}
		if(0!==strrpos($save_dir,'/')){
			$save_dir.='/';
		}
		//创建保存目录
		if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){
			return array('file_name'=>'','save_path'=>'','error'=>5);
		}
		//获取远程文件所采用的方法
		if($type){
			$ch=curl_init();
			$timeout=5;
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
			$img=curl_exec($ch);
			curl_close($ch);
		}else{
			ob_start();
			readfile($url);
			$img=ob_get_contents();
			ob_end_clean();
		}
		//$size=strlen($img);
		//文件大小
		$fp2=@fopen($save_dir.$filename,'a');
		fwrite($fp2,$img);
		fclose($fp2);
		unset($img,$url);
		return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'error'=>0);
	}
	public function sharePage(Request $request){
		$course_class_ids = DB::table("course_class")->where(["register_free_watch"=>1, "state"=>1])->select("id")->get();
		$user = $request->user();
		if($user){
			$user_id = $user->id;
		}else{
			$user_id = 0;
		}
		//处理赠送课程
		if($user_id){
			if($course_class_ids){
				$studying = new Studying();
				foreach($course_class_ids as $course_class_id){
					$studying->addOne($user_id, $course_class_id->id);
				}
			}
		}

		return view('introduction.sharePage');
	}
	/*
    * 员工招募转介绍人页面按钮点击次数
    * 20190521
    */
  	public function staffClicks(Request $request){
  		$user_id = $request->input("user_id");
  		if($user_id){
  			//页面浏览数加1
       		DB::table("introduction_staff")->where("user_id",$user_id)->increment("clicks",1);
  		}
  	}

	/*
    * 转介绍人中心页查看跟单、预定、入学数量
    * 20190529
    */
   protected function resourceState($int_person_id,$type="person"){
   		if($type=="staff"){
   			$introResource = IntroductionResource::where('int_staff_id',$int_person_id)->where('system_exist',0)->select("mobile","system_exist","name",'created_at', "int_person_id")->take(30)->orderBy('created_at','desc')->get();
//			dd(3);
   		}else{
   			$introResource = IntroductionResource::where('int_person_id',$int_person_id)->where('system_exist',0)->select("mobile","system_exist","name",'created_at',"int_person_id")->take(40)->orderBy('created_at','desc')->get();
   		}
		
		$gendan = 0;
		$yuding = 0;
		$ruxue  = 0;
		$sourceArr = [];
	    $sourceArr['newSource'] = [];
	    $sourceArr['sysSource'] = [];
//		$i = 0;
//		$j = 0;
//		foreach($introResource as $k => $source){
//			$url    = $this->apiUrl."/api/trainee_info_status?mobile=".$source->mobile;
//			$result = json_decode(httpGet($url),true);
//			if($source->system_exist == 0){
//				$sourceArr['newSource'][$i]['name']   = $source->name;
//				$sourceArr['newSource'][$i]['mobile'] = $source->mobile;
//				$sourceArr['newSource'][$i]['status'] = $result['result']['traineeStatusName'];
//				$sourceArr['newSource'][$i]['time']   = date('Y.m.d',strtotime($source->created_at));
//				$sourceArr['newSource'][$i]['person'] = $source->int_person_id;
//				$i++;
//			}else{
//				$sourceArr['sysSource'][$j]['name']   = $source->name;
//				$sourceArr['sysSource'][$j]['mobile'] = $source->mobile;
//				$sourceArr['sysSource'][$j]['status'] = $result['result']['traineeStatusName'];
//				$sourceArr['sysSource'][$j]['time']   = date('Y.m.d',strtotime($source->created_at));
//				$sourceArr['sysSource'][$j]['person'] = $source->int_person_id;
//				$j++;
//			}
//			if($result['result']['traineeStatus']=='01'){
//				$gendan++;
//			}elseif($result['result']['traineeStatus']=='02'){
//				$yuding++;
//			}elseif($result['result']['traineeStatus']=='05'){
//				$ruxue++;
//			}
//		}
	    $sourceArr['gendan'] = 0;
	    $sourceArr['yuding'] = 0;
	    $sourceArr['ruxue'] = 0;
		return $sourceArr;
   }

    /*
     * 短信超限提醒
     */
	private function messageOverNotice(){
		$time = date('Ymd');
		$sendNum = Redis::get('code_'.$time.'_send');
		if($sendNum >=1000){
			$name = '验证码发送超过1000';
			if(!env('IS_LOCAL')){
				$flag = Mail::send('emails.error',['name'=>$name],function($message){
					$to = ['2465508405@qq.com','892336606@qq.com','1028242057@qq.com'];
					$message ->to($to)->subject('社区网站bug提醒');
				});
			}
			logger()->info('短信超标提醒');
		}
	}

	/*
	 * 招录转介绍人页面
	 */
	public function joinPartnerPage(Request $request){

		
		return view('introduction.joinPartner');
	}
}
