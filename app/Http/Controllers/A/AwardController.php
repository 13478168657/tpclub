<?php

namespace App\Http\Controllers\A;

use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Utils\MakeThumbPic;
use App\Models\ActivityShareRecords;
use App\Models\ActivityUserStatistics as ActiveUser;
use Illuminate\Support\Facades\DB;
use App\Models\Studying;
class AwardController extends Controller
{


    public function index(Request $request){
        $user = $request->user();
        if($user && $user->mobile){
            $flag = 1;
            $data['fission_id'] = $user->id;
            $user_id = $user->id;
            $data['name'] = $user->nickname ? $user->nickname : "好友";
        }else{
            $flag = 0;
            $data['fission_id'] = 0;
            $user_id = 0;
            $data['name'] = "好友";
        }

        if(env('IS_LOCAL')==false){
            $data['WechatShare'] = getSignPackage();
        }else{
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }

        $total = ActiveUser::where('user_id',$user_id)->select("invite_num")->first();
        $data['flag']  = $flag;
        $data['total'] = $total ? $total->invite_num : 0;
        return view('award.index',$data);
    }

    public function receive(Request $request){
        $user = $request->user();
        $fission_id = $request->input('fission_id','');
        if($user && $user->mobile){
            $flag = 1;
            $user_id = $user->id;

        }else{
            $flag = 0;
            $user_id = 0;
        }
        if($user_id==$fission_id){
            return redirect('/share/award');
        }
        if($fission_id){
            $fission_user = User::where('id',$fission_id)->select('name','nickname')->first();
            if($fission_user){
                $data['name'] = $fission_user->name?$fission_user->name:$fission_user->nickname;
                if(!$data['name']){
                    $data['name'] = "小伙伴儿";
                }
            }else{
                $data['name'] = "小伙伴儿";
            }
        }else{
            $data['name'] = "小伙伴儿";
        }
        $activeRecord = ActivityShareRecords::where('user_id',$user_id)->first();
        if($activeRecord){
            $data['isAward'] = 1;
        }else{
            $data['isAward'] = 0;
        }
        if(env('IS_LOCAL')==false){
            $data['WechatShare'] = getSignPackage();
        }else{
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }
        $data['fission_id'] = $fission_id;
        $data['flag'] = $flag;
        return view('award.receive',$data);
    }

    public function friend(Request $request){
        $user = $request->user();
        $page = $request->input('page',1);
        $friends = ActivityShareRecords::where('fission_id',$user->id)->select('id','user_id','created_at')->orderBy('created_at','desc')->paginate(10);
//        dd($friends);
        $data['friends'] = $friends;
        if($page >= 2){
            return json_encode(['code'=>0,'body'=>view('award.body.moreFriend',$data)->render()]);
        }else{
            return view("award.friend",$data);
        }
    }

    public function rank(Request $request){
        $user = $request->user();
        if(!$user){
            return redirect('/login');
        }
        $page = $request->input('page',1);
        $inviteUser = ActiveUser::where('user_id',$user->id)->where("state",1)->first();
        if(!$inviteUser){
            $total = 0;
        }else{
            //$total = ActiveUser::where('user_id','!=',$user->id)->where('invite_num','>=',$inviteUser->invite_num)->where('updated_at','<',$inviteUser->updated_at)->count();
            $cur_array = ActiveUser::where("state",1)->orderBy('invite_num','desc')->orderBy('updated_at','asc')->select("user_id")->get();
            foreach($cur_array as $k=>$v){
                if($v->user_id==$user->id){
                    $total = $k;
                    break;
                }
            }
        }

        $activeUsers = ActiveUser::where("state",1)->orderBy('invite_num','desc')->orderBy('updated_at','asc')->paginate(10);
        $data['inviteUser'] = $inviteUser;
        $data['activeUsers'] = $activeUsers;
        $data['total'] = $total;
        if($page >= 2){
            $rank = 10*($page-1);
            $data['rank'] = $rank;
            return json_encode(['code'=>0,'body'=>view('award.body.moreRank',$data)->render()]);
        }else{
            return view('award.rank',$data);
        }

    }

    public function gift(Request $request){
        $user = $request->user();

        if(!$user){
            return redirect('/login');
        }
//        dd($user);
        $inviteUser = ActiveUser::where('user_id',$user->id)->first();
        if(!$inviteUser){
            $total = 1000;
        }else{
//            $total = ActiveUser::where('user_id','!=',$user->id)->where('invite_num','>=',$inviteUser->invite_num)->where('updated_at','<',$inviteUser->updated_at)->count();
            $cur_array = ActiveUser::where("state",1)->orderBy('invite_num','desc')->orderBy('updated_at','asc')->select("user_id")->get();
            foreach($cur_array as $k=>$v){
                if($v->user_id==$user->id){
                    $total = $k;
                    break;
                }
            }
        }
        $awardTime = strtotime('2019-01-22 16:00');
        $data['inviteUser'] = $inviteUser;
        $data['total'] = $total;
        $data['awardTime'] = $awardTime;
        return view('award.gift',$data);
    }

    /*
     * 领取奖励
     */
    public function getAward(Request $request){
        $fission_id = $request->input('fission_id');
//        return $this->getMessage(0,'领取成功');
        $user = $request->user();
        $endTime = strtotime('2019-01-22 16:00');
        if(time()>$endTime){
            return $this->getMessage(4,'活动已结束');
        }
        if(!$user || $user->mobile == ''){
            return $this->getMessage(1,'用户未登录');
        }
        if(!$fission_id){
            return $this->getMessage(3,'未找到邀请者');
        }
        DB::beginTransaction();
        try{

            $activeRecord = ActivityShareRecords::where('user_id',$user->id)->first();
            $count        = ActivityShareRecords::where('fission_id', $fission_id)->count();
            if($count>3){
                //满3个人赠送课程
                $studying = new Studying();
                $course_class_ids = array(8,9,31);
                foreach($course_class_ids as $course_class_id){
                    $studying->addOne($fission_id, $course_class_id);
                }
            }
            if($activeRecord){
                DB::commit();
                return $this->getMessage(2,'已领取'.$count);
            }

            $activeRecord = new ActivityShareRecords();
            $activeRecord->fission_id = $fission_id;
            $activeRecord->user_id = $user->id;
            $activeRecord->save();

            $user = User::where('id',$user->id)->first();
            $user->spb += 10000;
            $user->save();
            $activeUser = ActiveUser::where('user_id',$fission_id)->first();

            if($activeUser){
                $activeUser->invite_num += 1;
                $activeUser->save();
            }else{
                $activeUser = new ActiveUser();
                $activeUser->user_id = $fission_id;
                $activeUser->invite_num = 1;
                $activeUser->save();
//                dd(3);
            }

            DB::commit();

            return $this->getMessage(0,'领取成功');
        }catch(\Exception $e){
            DB::rollback();
            logger()->info($e->getMessage());
            return $this->getMessage(2,'领取失败');
        }


    }

    public function shareCard(Request $request){
        $user = $request->user();
        if(!$user){
            return $this->getMessage(1,'用户未登录');
        }

        $name  = $user->name ? $user->name : $user->nickname;
        if($name==""){
            $name = "小伙伴儿";
        }
        $name = subtext($name,6);
        $img = "http://qr.topscan.com/api.php?text=http://m.saipubbs.com/share/receive?fission_id=".$user->id;

        $destDirectory = "/upload/wxqrcode/";
        if (!file_exists(public_path().'/'.$destDirectory)) {
            $fileDir = mkdir(public_path().'/'.$destDirectory,0777,true);
        }else{
            $fileDir = public_path().'/'.$destDirectory;
        }
        $file = time().rand(1000,9999).".png";
        $r = $this->getImage($img,$fileDir, $file);
        $wechatCode =  $destDirectory.$r['file_name'];

        $imageThumb  = new MakeThumbPic();
//        dd($wechatCode);
        $img_url = $imageThumb->makePic('/activity/award/images/zt/giftgive/shequhaibao.jpg','' ,$wechatCode,'upload/share/', $name,4);

        //return "<img src='".env('APP_URL')."/".$img_url[1]."' />";
//        $src  = env('APP_URL')."/".$img_url[1];
        $src  = "/".$img_url[1];

//        if($is_local){
//            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
//        }else{
//            $data['WechatShare'] = getSignPackage();
//        }
        $content = $this->getContent($src);
        return json_encode(['code'=>0,'data'=>$content]);
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

    private function getContent($image){

        return '<div class="bm_success_layer text_center tan-font color_fff fz f22"><img src="'.$image.'" class="bm_success" alt="" />─ 长按保存图片发送给好友 ─</div>';
    }
}
