<?php

namespace App\Http\Controllers\Api;

use App\Models\UsersGrowing;
use App\Models\Order;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\Studying;
use App\Models\UsersGrowingSort;
use App\Models\Follow;
use App\Models\Comment;
use App\Constant\CommentDate;
use App\Models\Consultation;
use App\Models\DisCoursePlay;
use App\Models\ArticleRecommend;
use App\Utils\WxMessagePush;
use App\Constant\WxMessageType;
use App\Models\CourseClassPush;
use App\Utils\ImageThumb;
use App\Utils\SensitiveWord;
use App\Utils\CurlUtil;
use App\Events\WxCustomerMessagePush;
use App\Constant\CustomerPushType;
use App\Models\IntroductionStaff;
use App\Models\IntroductionPerson;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

require app_path().'/Library/Wechat/WxPay.JsApiPay.php';
class ApiController extends Controller
{
    //对外接口控制器
    protected $ret;

    public function __construct()
    {
        $this->ret = [];
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

    /**
     * .修改学员预定状态
     *  20181205
     */
    public function updateReserve(Request $request){

        $mobile = $request->input('mobile');
        $password = $request->input('password');
        if(empty($mobile)){
            return $this->getMessage(1,'手机号不能为空');
        }
        if(empty($password)){
            return $this->getMessage(2,'密码不能为空');
        }

        if (Auth::attempt(['mobile' => $mobile,'is_admin'=>0, 'password' => md5($password)],true)) {
            return $this->getMessage(0,'登录成功');
        }
        return $this->getMessage(3,'手机号或密码错误');
        return;


        echo users_growing(0,64);

        return;
        $img = "http://qr.topscan.com/api.php?text=m.saipubbs.com";

        $destDirectory = "/upload/wxqrcode/";

        if (!file_exists(public_path().'/'.$destDirectory)) {
            $fileDir = mkdir(public_path().'/'.$destDirectory,0777,true);
        }else{
            $fileDir = public_path().'/'.$destDirectory;
        }
        $file = time().rand(1000,9999).".png";
        $r = $this->getImage($img,$fileDir, $file);
        print_r($r);
        return;
        file_put_contents($fileDir.$file,$img);
        return $destDirectory.$file;
        return;


    	$mobile = $request->input("phone", "");
    	if($mobile){
    		$usergrow = UsersGrowing::where("mobile", $mobile)->first();
    		if($usergrow){
               $usergrow->is_reserve = 1;
               $usergrow->reserve_at = date("Y-m-d H:i:s");
               $r = $usergrow->save();
               if($r){
                    $code = 1;
                    $msg  = "预定信息修改成功";
               }else{
                    $code = 0;
                    $msg  = "未知错误";
               }
            }else{
                $code = 0;
                $msg  = "手机号不存在";
            }
    	}else{
            $code = 0;
            $msg  = "手机号不能为空";
    	}
        $data = array();
        $data['mobile'] = $mobile;
        $data['code']   = $code;
        $data['msg']    = $msg;
        $data['ip']     = get_ip();
        $data['created_at'] = date("Y-m-d H:i:s");
        DB::table("users_growing_records")->insert($data);       //记录信息 
        return json_encode(array("code"=>$code, "msg"=>$msg));   //返回信息
    }


    /**
     * .修改学员预定状态
     *  20181206
     */
    public function getUpdateReserve(Request $request){
        
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        $mobile = $request->input("phone");
        $course_class_id = 37;    //暂定课程id
        $url    = "isaipu.net/api/market/searchHandinState?traineeMobile=".$mobile;
        //$url    = "http://61.50.111.11:9050/api/market/searchHandinState?traineeMobile=".$mobile;   //临时测试接口
        $result = httpGet($url);
        $arr    = json_decode($result,true);
        //开启事务
        DB::beginTransaction();
        try{
            if($arr['code']==1){
                //修改预定状态
                $reverse = DB::table('users_growing')
                    ->where("mobile", $mobile)
                    ->where('is_reserve', 1)
                    ->first();
                if($reverse){
                    $result = array("code"=>1, "msg"=>"成功");
                    DB::commit();
                    //记录日志
                    $data = array();
                    $data['mobile'] = $mobile;
                    $data['code']   = $arr['code'];
                    $data['msg']    = $arr['msg'];
                    $data['created_at'] = date("Y-m-d H:i:s");
                    DB::table("users_growing_records")->insert($data);
                   
                    return json_encode($result);
                }
                DB::table('users_growing')
                ->where("mobile", $mobile)
                ->update(['is_reserve' => 1, "reserve_at"=>date("Y-m-d H:i:s")]);

                //将课程添加到学习列表
                $studying = new Studying();
                $studying->addOne($userid, $course_class_id);   //加入正在学习
                
                //记录用户邀请预定数量
                $usergrow = UsersGrowing::where("mobile", $mobile)->first();
                if($usergrow && $usergrow->fission_id){
                    $attribute = DB::table("users_attribute")->where("user_id", $usergrow->fission_id)->select("is_fission")->first();
                    if($attribute && $attribute->is_fission==0){
                        $sort = UsersGrowingSort::where("user_id", $usergrow->fission_id)->first();
                        if($sort){
                            DB::table("users_grow_sort")->where("user_id", $usergrow->fission_id)->increment("reserve_num", 1);
                        }else{
                            $newSort = new UsersGrowingSort();
                            $newSort->user_id     = $usergrow->fission_id;
                            $newSort->reserve_num = 1;
                            $newSort->created_at  = date("Y-m-d H:i:s");
                            $newSort->save();
                        }
                    }
                }
                $result = array("code"=>1, "msg"=>"成功");
                DB::commit();
            }else{
                $result = array("code"=>0, "msg"=>"失败");
                DB::rollback();
            }
        }catch(\Exception $e){
            $result = array("code"=>0, "msg"=>"失败");
            logger()->info($e->getMessage());
            DB::rollback();
        }    

        //记录日志
        $data = array();
        $data['mobile'] = $mobile;
        $data['code']   = $arr['code'];
        $data['msg']    = $arr['msg'];
        $data['created_at'] = date("Y-m-d H:i:s");
        DB::table("users_growing_records")->insert($data);
       
        return json_encode($result);
        
    }

    /*
    * 20190613
    * 接受老师资源
     */
    public function receiveData(Request $request){

        $data = array();
        $data['datetime'] = time();
        $data['ip']       = $_SERVER['REMOTE_ADDR'];;
        $data['uname']    = $request->input("xingming");
        $data['mobile']   = $request->input("shouji");
        $data['oldurl']   = $request->input("url");
        $data['yname']    = $request->input("title");
        $data['teacher_info'] = $request->input("teacher");
        $data['created_at']    = date("Y-m-d H:i:s");
        $result = DB::table('saipu_form_teacher')->where('mobile',$data['mobile'])->select('dataid')->first();
        if($result){
            echo json_encode(array("code"=>2));
            return;
        }
        $r = DB::table("saipu_form_teacher")->insert($data);
        if($r){
            echo json_encode(array("code"=>1));
        }else{
            echo json_encode(array("code"=>0));
        }
        return;
    }


    /**
     * .查看学员是否入学
     *  20190511
     */
    public function studentIsJoin(Request $request){
        
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        $mobile = $request->input("mobile", 13269280535);
        //临时地址
        $url    = "http://101.201.81.14:9315/saipu-app-ins"."/api/trainee_info_status?mobile=".$mobile;
        $result = httpGet($url);
        $arr    = json_decode($result,true);
        echo "<pre>";
        print_r($arr);
        
    }

    /**
     * .测试代理资源录入
     *  20190512
     */
    public function employeeResource(Request $request){
        $item2['employeeNo']   = "5388";         //录入人ID
        $item2['mobile']       = "18556568560";  //学员手机号
        $item2['traineeName']  = "张三";         //学员手机号
        //$item2['fromUrl']      = "http://m.saipubbs.com/?utm_source=111&utm_medium=22";
                       
        $r = request_post_crm($item2);
        echo "<pre>";
        print_r($r);
        
    }

    /**
     * .查看资源信息
     *  20190517
     */
    public function studentInfo(Request $request){
        
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        $mobile = $request->input("mobile", 18371507459);
        $url    = "http://101.201.81.14:9315/saipu-app-ins"."/api/trainee_info?mobile=".$mobile;
        $result = httpGet($url);
        $arr    = json_decode($result,true);
        echo "<pre>";
        print_r($arr);
        
    }

    /**
     * .查看资源状态 代理/转介绍人/学员
     *  20190517
     */
    public function studentStatus(Request $request){
        
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        $mobile = $request->input("mobile", 18371507459);
        $url    = "http://101.201.81.14:9315/saipu-app-ins"."/api/people_info?mobile=".$mobile;
        $result = httpGet($url);
        $arr    = json_decode($result,true);
        echo "<pre>";
        print_r($arr);
        
    }

    public function dake(){
        $user_id = DB::table("order_course_class_group")->where("state",1)->select("user_id")->get();
        //dd($user_id);
        $studying = new Studying();
        foreach($user_id as $id){
            $studying->addOne($id->user_id, 55);   //加入正在学习
        }
        
       
    }

    public function wxinfo(Request $request){
        $url    = "https://api.weixin.qq.com/sns/jscode2session?appid=APPID&secret=SECRET&js_code=JSCODE&grant_type=authorization_code";
        $result = httpGet($url);
        $arr    = json_encode($result,true);
        return $arr;
    }


    /**
     * .查看资源状态 代理/转介绍人/学员
     *  20190517
     */
    public function regWxShare(Request $request){
        
        if($request->input("url")){
            $url = $request->input("url");
        }else{
            $url = "http:m.saipubbs.com?n=11";
        }
        //echo $url;
        $share_info = getSignPackageTwo($url);
        echo json_encode($share_info);
        
    }

    /**
     * .批量将转介绍人与员工关系发送到系统
     *  20190911
     */
    public function staffPerson(Request $request){
        $person = IntroductionPerson::where('post_code',0)->limit(100)->select("id", "name", "mobile", "int_staff_id","bank_sex", "bank_card_number", "bank_info", "id_card")->get()->toArray();
        foreach($person as $item){
            $mobile = IntroductionStaff::where("user_id", $item['int_staff_id'])->first();
            $one    = IntroductionPerson::where("id", $item['id'])->first();
            //dd($one);
            if($item['bank_sex']=="male"){
                $item['bank_sex'] = "01";
            }elseif($item['bank_sex']=="female"){
                $item['bank_sex']=="02";
            }else{
                $item['bank_sex']=="";
            }
            if($mobile && $mobile->mobile){
                $data = array();
                $data['empMobile']         = $mobile->mobile;
                $data['introUserName']     = $item['name'];
                $data['introUserSexual']   = $item['bank_sex'];
                $data['introUserMobile']   = $item['mobile'];
                $data['introUserIdno']     = $item['id_card'];
                $data['introUserBankName'] = $item['bank_info'];
                $data['introUserBankNo']   = $item['bank_card_number'];

                $result = wx_http_post("http://101.201.81.14:9315/saipu-app-ins/api/intro/bind_intro", $data);
                $r = json_decode($result, true);
                //print_r($r);
                
                $one->post_code = 1;
                $one->post_info = $result;
            }else{
                $one->post_code = 2;
                $one->post_info = '发送失败';
            }
            
            $one->save();
            //return  333;
        }
        echo 222;
        
    }


    public function wxopenid(Request $request){
        $tools = new \JsApiPay();
        $openId = $tools->GetOpenid();
        echo $openId;
        echo 1111;
        dd();
    }
}
