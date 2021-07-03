<?php

namespace App\Http\Controllers\A;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Assistance;
use App\Models\ActivityUserStatistics;
use App\Models\DisCourseClass;
use App\Models\DisCourse;
use App\Models\DisStudying;
use DB;
use App\Utils\MakeThumbPic;
class HandController extends Controller
{
    public function __construct(){

        $this->startTime = '2019-06-13';
        $this->delayTime = 3;
    }

    public function index(Request $request){
        $user = $request->user();

        $has_mobile = 0;
        $hasStudy = 0;
        if($user){
            $user_id = $user->id;
            $has_mobile = $user->mobile?1:0;
        }else{
            $user_id = 0;
        }
        $disClass = DisCourseClass::where('id',13)->first();
        $dis_course_id = 13;
        $disStudying = DisStudying::where('user_id',$user_id)->where('dis_course_class_id',$dis_course_id)->select('id')->first();
        if($disStudying){
            $hasStudy = $dis_course_id;
            return redirect("/dist/study/{$dis_course_id}.html");
        }else{
            $hasStudy = 0;
        }
        $dateInfo = $this->getTime();
        $data['beginTime'] = $dateInfo['beginTime'];
        $data['num'] = $dateInfo['num'];
        $data['hasMobile'] = $has_mobile;
        $data['hasStudy'] = $hasStudy;
        $assignFriends = Assistance::where('userid',$user_id)->where('dis_course_id',$dis_course_id)->take(4)->get();
//        dd($assignFriends);
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();
        }
        $static = ActivityUserStatistics::where('user_id',$user_id)->where('type',1)->first();
        if($static){
            $data['invite_num'] = $static->invite_num;
        }else{
            $data['invite_num'] = 0;
        }
        $data['assignFriends'] = $assignFriends;
        $data['user_id'] = $user_id;
        $data['disClass'] = $disClass;
//        dd($data);
        return view('a.hand.center',$data);
    }
    public function friend(Request $request,$id){

        $user = $request->user();
        $has_mobile = 0;
        if($user){
            $user_id = $user->id;
            $has_mobile = $user->mobile?1:0;
        }else{
            $user_id = 0;
        }
        if($user_id == $id){
            return redirect('/hand/index.html');
        }
        $disClass = DisCourseClass::where('id',13)->first();
        $dis_course_id = 13;
        $dateInfo = $this->getTime();
        $data['beginTime'] = $dateInfo['beginTime'];
        $data['num'] = $dateInfo['num'];
        $data['hasMobile'] = $has_mobile;
        $data['assign_id'] = $id;
        $assignFriends = Assistance::where('userid',$id)->where('dis_course_id',$dis_course_id)->take(4)->get();
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();
        }
        $static = ActivityUserStatistics::where('user_id',$id)->where('type',1)->first();
        if($static){
            $data['invite_num'] = $static->invite_num;
        }else{
            $data['invite_num'] = 0;
        }
        $data['assignFriends'] = $assignFriends;
        $data['user_id'] = $user_id;
        $data['disClass'] = $disClass;
        return view('a.hand.index',$data);
    }

    public function help(Request $request){
        $user = $request->user();
        $assign_id = $request->input('a_id');
        if(!$user){
            $this->getMessage(2,'用户未登陆');
        }
        $user_id = $user->id;
        $disClass = DisCourseClass::where('id',13)->first();
        $dis_course_id = 13;
        $assistance = Assistance::where('friend',$user_id)->where('dis_course_id',$dis_course_id)->first();
        if($assistance){
            return $this->getMessage(1,'只能助力一次');
        }


        $assistance = new Assistance();
        $assistance->userid = $assign_id;
        $assistance->friend = $user_id;
        $assistance->dis_course_id = $dis_course_id;
        $assistance->save();
        $static = ActivityUserStatistics::where('user_id',$assign_id)->where('type',1)->first();
        $flag = 0;
        $dateInfo = $this->getTime();
        $beginTime = strtotime($dateInfo['beginTime']);
        DB::beginTransaction();
        try{
            if($static){
                if($static->invite_num == 3){
                    $flag = 1;
                }
                $static->invite_num += 1;
            }else{
                $static = new ActivityUserStatistics();
                $static->invite_num = 1;
            }
            $static->user_id = $assign_id;
            $static->type = 1;
            $static->save();
            if($flag){
                $disCourseClass = DisCourseClass::where("id",$dis_course_id)->first();
                $disStudy = DisStudying::where('user_id',$assign_id)->where('dis_course_class_id',$dis_course_id)->first();
                if($disStudy){
                    DB::commit();
                    return $this->getMessage(0,'助力成功');
                }else{
                    $disStudy  = new DisStudying();
                }
                $disStudy->user_id = $assign_id;
                $disStudy->dis_course_class_id = $dis_course_id;
                $disStudy->save();
                $course_ids = explode(',',$disCourseClass->course_ids);
                $playRecords = [];
                foreach($course_ids as $k => $ids){
                    $course = DisCourse::where('id',$ids)->select('delay')->first();
                    $day = date('Y-m-d',$beginTime+$course->delay*86400);
                    $delayTime = strtotime($day);
                    $playRecords[$k]['user_id'] = $assign_id;
                    $playRecords[$k]['dis_course_id'] = $ids;
                    $playRecords[$k]['datetime'] = $delayTime;
                    $playRecords[$k]['day'] = $day;
                    $playRecords[$k]['dis_course_class_id'] = $disCourseClass->id;
                    $playRecords[$k]['created_at'] = date('Y-m-d H:i:s');
                    $playRecords[$k]['updated_at'] = date('Y-m-d H:i:s');
                }
                $res = DB::table('dis_course_play_record')->insert($playRecords);
            }
            DB::commit();
            return $this->getMessage(0,'助力成功');
        }catch(\Exception $e){
            DB::rollback();
            logger()->info($e->getMessage());
            return $this->getMessage(1,'助力失败');
        }

    }

    /*
     * 获取时间
     */
    public function getTime(){
        $currentTime = time();
        $startTime = $this->startTime;
        $delayDays = $this->delayTime;
        $num = floor(($currentTime - strtotime($startTime))/(86400*$delayDays));
//        dd($currentTime - strtotime($startTime),$num);
        if($num < 0){
            $num = 0;
            $beginTime = date('Y-m-d',(strtotime($startTime)+86400*$num*$this->delayTime));
        }else{

            $beginTime = date('Y-m-d',(strtotime($startTime)+86400*($num+1)*$this->delayTime));
            $num += 1;
        }

        return ['beginTime'=>$beginTime,'num'=>$num+1];
    }
    /*
     * 生成邀请海报
     */
    public function getPoster(Request $request){
        $user = $request->user();
        $flag = $request->input('flag',0);
        $imageThumb  = new MakeThumbPic();
        $bodyPic = "/images/zt/jieshao.png";
        $user_id = $request->user()->id;

        $shareCodeArr[] = "http://qr.topscan.com/api.php?text=http://m.saipubbs.com/hand/friend/".$user_id.'.html';
        $imgArr = ["/images/zt/asszhuli/hb.jpg"];
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
        $activity = 6;
        foreach($imgArr as $k => $bodyPic){
            $img_url[] = $imageThumb->makePic($bodyPic, '', $wechatCodeArr[$k],'upload/share/', $name,$activity);
        }
        $picContent = $this->getPic($img_url, $flag);
        return ['code'=>0,'body'=>$picContent];
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

    public function getPic($res ,$flag){
        $content = '<div class="hb_success_layer text_center tan-font"><img src="/'.$res[0][1].'" class="bm_success" alt="" /></div>';
        return $content;
    }

    //update_data
    public function user_play_record(){
        $users = DisStudying::where("dis_id", 0)->select("user_id")->get();
        $dateInfo = $this->getTime();
        $beginTime = strtotime($dateInfo['beginTime']);
        foreach($users as $user){
            $disCourseClass = DisCourseClass::where("id",13)->first();
            // $disStudy = DisStudying::where('user_id',$assign_id)->where('dis_course_class_id',$dis_course_id)->first();
            // if($disStudy){
            //     DB::commit();
            //     return $this->getMessage(0,'助力成功');
            // }else{
                // $disStudy  = new DisStudying();
            // }
            // $disStudy->user_id = $user->user_id;
            // $disStudy->dis_course_class_id = $dis_course_id;
            // $disStudy->save();
            $course_ids = explode(',',$disCourseClass->course_ids);
            $playRecords = [];
            foreach($course_ids as $k => $ids){
                $course = DisCourse::where('id',$ids)->select('delay')->first();
                $day = date('Y-m-d',$beginTime+$course->delay*86400);
                $delayTime = strtotime($day);
                $playRecords[$k]['user_id'] = $user->user_id;
                $playRecords[$k]['dis_course_id'] = $ids;
                $playRecords[$k]['datetime'] = $delayTime;
                $playRecords[$k]['day'] = $day;
                $playRecords[$k]['dis_course_class_id'] = $disCourseClass->id;
                $playRecords[$k]['created_at'] = date('Y-m-d H:i:s');
                $playRecords[$k]['updated_at'] = date('Y-m-d H:i:s');
            }
            $res = DB::table('dis_course_play_record')->insert($playRecords);
        }
    }
}
