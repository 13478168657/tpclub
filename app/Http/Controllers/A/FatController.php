<?php

namespace App\Http\Controllers\A;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Utils\ImageThumb;
use App\Utils\ImageCompress;
use App\Utils\CurlUtil;
use App\Utils\MakeThumbPic;
use App\User;
use App\Models\FatActivityMember;
use App\Models\FatBodyData;
use App\Models\FatVote;
use App\Models\FatMobile;
use App\Utils\FileUploader;
class FatController extends Controller
{

    /**
     * [index description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function index(Request $request){

        $rankLists = FatActivityMember::orderByRaw("RAND()")->paginate(20);
        $hasPage = $rankLists->hasMorePages();
        $joinTotal = FatActivityMember::select('id')->count();
        $data['voteUsers'] = FatVote::distinct('fid')->count('fid');
//        $data['voteNums'] = FatVote::select('id')->count();
        $data['joinTotal'] = $joinTotal;
        $data['rankLists'] = $rankLists;
        $data['name'] = '';
        $data['voteNums'] = Redis::get('fat_vote_sum');
        $data['hasPage'] = $hasPage;
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();
        }
        $data['redisData'] = $this->redisData();
        return view('a.fat.index',$data);
    }

    public function fatLoadMore(Request $request){
        $page = $request->input('page',2);
        $rankLists = FatActivityMember::orderByRaw("RAND()")->paginate(20);
        $hasPage = $rankLists->hasMorePages();
        return $this->getMessage(0,'获取成功',['body'=>view('a.fat.body.loadMore',['rankLists'=>$rankLists, 'page'=>$page])->render(),'hasPage'=>$hasPage]);
    }

    public function userVote(Request $request){

        $user = $request->user();
        if(!$user){

            return $this->getMessage(1,'请登录');
        }
        $endTime = strtotime('2020-12-27 18:00');
        $startTime = strtotime('2020-12-05 24:00');
        $now = time();
        if($now >= $endTime){
            
            return $this->getMessage(2,'亲~投票已结束');
        }
        if($now<=$startTime){
            
            return $this->getMessage(2,'亲~投票还未开始');
        }
        $mid = $request->input('mid');
        $fid = $user->id;
        $day = date('Y-m-d');
        $voteKey = 'vote_'.date('Ymd').'_'.$user->id;
        $fatMemberKey = 'fatMember_'.date('Ymd').'_'.$mid;
        $voteKeyExist = Redis::exists($voteKey);
        $voteTotalNumKey = 'fat_vote_sum';
        $fatMemberKeyExist = Redis::exists($fatMemberKey);
        $voteTotalNumKeyExist =  Redis::exists($fatMemberKey);
        $voteNum = Redis::get($voteKey);
        $fatMemberNum = Redis::get($fatMemberKey);
        $fatMember = FatActivityMember::where('id',$mid)->first();
        if($fid == $fatMember->user_id){

            return $this->getMessage(2,'本人不可投自己');
        }
        if($voteKeyExist && $voteNum >=5){
            return $this->getMessage(2,'当日投票次数已用完');
        }
        $beginTime = strtotime('2020-12-27');
        if($now <= $beginTime){
            if($fatMemberKeyExist && $fatMemberNum >= 1000){
                
                return $this->getMessage(2,'最多一千票');
            }
        }

        if($voteTotalNumKeyExist){
            Redis::incr($voteTotalNumKey);
        }else{
            Redis::incr($voteTotalNumKey);
        }
        if($fatMemberKeyExist){
            Redis::incr($fatMemberKey);
        }else{
            Redis::set($fatMemberKey,1);
        }
        if($voteKeyExist){
            Redis::incr($voteKey);
        }else{
            Redis::set($voteKey,1);
        }
        $fatVote = new FatVote();
        $fatVote->mid = $mid;
        $fatVote->fid = $fid;
        $fatVote->day = $day;
        $fatVote->save();
        DB::beginTransaction();
        try{
            $fatMember->votes = $fatMember->votes + 1;
            $fatMember->save();
            DB::commit();
            return $this->getMessage(0,'第'.($voteNum+1).'次投票成功');
        }catch(\Exception $e){
            DB::rollback();
            return $this->getMessage(2,'投票失败');
        }
    }

    public function hcdel(Request $request){
        $voteKey = 'vote_'.date('Ymd');
        $votepreKey = 'vote_'.date('Ymd',time()-86400);
        $fatMemberKey = 'fatMember_'.date('Ymd');
        $voteTotalNumKey = 'fat_vote_sum';
        $voteKeys = Redis::keys($voteKey);
        $votepreKeys = Redis::keys($votepreKey);

        foreach($voteKeys as $key){
            Redis::del($key);
        }
        foreach($votepreKeys as $preKey){
            Redis::del($preKey);
        }

        Redis::del($voteTotalNumKey);
    }
    public function userSearch(Request $request){

        $name = $request->input('name','');
        if($name){
            $rankLists = FatActivityMember::where('name','like','%'.$name.'%')->orWhere('id',$name)->orderBy('votes','desc')->get();
        }else{
            $rankLists = FatActivityMember::orderBy('votes','desc')->get();
        }

        $data['rankLists'] = $rankLists;
        return $this->getMessage(0,'查询成功',['body'=>view('a.fat.body.searchInfo',$data)->render()]);
    }
    /**
     * [info description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
	public function info(Request $request){

        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();
        }

        $dir    = env('IMG_PATH').'/upload/fat/';
        $newDir = env('IMG_PATH').'/upload/newfat/';

        //PHP遍历文件夹下所有文件
        // $files=opendir($dir.".");
        // while (false !== ($file = readdir($files)))
        // { 
        //     if ($file != "." && $file != ".." && is_file($dir.$file)) {
        //       $source =  $dir.$file;
        //       $dst_img = $newDir.$file;
        //       $percent = 1;  #原图压缩，不缩放，但体积大大降低 
        //       $image = (new ImageCompress($source,$percent))->compressImg($dst_img);
         
        //     }
         
        // }
        // closedir($files);
        // $source =  $dir.'1606785341.5804593923.jpeg';
        // $dst_img = $newDir.'1606785341.5804593923.jpeg';
        // $percent = 1;  #原图压缩，不缩放，但体积大大降低 
        // $image = (new ImageCompress($source,$percent))->compressImg($dst_img);

        return view('a.fat.info',$data);
    }
	
    /**
     * [signUp description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
	public function signUp(Request $request){
        $user = $request->user();
        $data['redisData'] = $this->redisData();
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();
        }
        if(!$user){
            return redirect("/login?redirect=/fat/signup");
        }else{
            $member = FatActivityMember::where("user_id", $user->id)->first();

            if($member){
                $count  = FatBodyData::where("mid", $member->id)->count();
                $data['member'] = $member;
                $data['count']  = $count;
                return view('a.fat.signinfo', $data);
            }else{
                return view('a.fat.sign', $data);
            }
        }
    }
	
    /**
     * [ranking description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
	public function ranking(Request $request){

        $rankLists = FatActivityMember::orderBy('votes','desc')->orderBy("updated_at","asc")->offset(0)->limit(50)->get();

        //$joinTotal = FatActivityMember::select('id')->count();
        //$data['voteUsers'] = FatVote::distinct('fid')->count('fid');
        //$data['voteNums'] = FatVote::select('id')->count();
        $data['voteNums'] = Redis::get('fat_vote_sum');
        //$data['joinTotal'] = $joinTotal;
        $data['rankLists'] = $rankLists;
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();
        }
        $data['redisData'] = $this->redisData();
        return view('a.fat.rank',$data);
    }

    public function groupRank(Request $request){

        $group = $request->input('group');
        $groupArr =explode('_',$group);
        $gp = '';
        if($groupArr[0] == 'm'){
            $sex = 'male';
            $gp = strtoupper($groupArr[1]);
        }elseif($groupArr[0] == 'f'){
            $sex = 'female';
            $gp = strtoupper($groupArr[1]);
        }elseif($groupArr[0] =='p'){
            $gp = strtoupper($groupArr[1]);
        }

        if(isset($sex)){

            $rankLists = FatActivityMember::where('group',$gp)->where('sex',$sex)->orderBy('fat_diff_value','desc')->get();
        }elseif($gp == 'D'){
            $rankLists = FatActivityMember::where('object','teacher')->orderBy('fat_diff_value','desc')->get();
        }else{
            $rankLists = FatActivityMember::orderBy('votes','desc')->orderBy('updated_at','asc')->get();
        }

        $data['rankLists'] = $rankLists; //20201202排行暂时隐藏
        //$data['rankLists'] = [];
        return $this->getMessage(0,'查询成功',['body'=>view('a.fat.body.rankInfo',$data)->render()]);
    }
	/**
     * [member description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
	public function member(Request $request,$id){

        $userMember = FatActivityMember::where('id',$id)->first();
        if(!$userMember){

            return redirect('/fat/index');
        }
        $user     = $request->user();
        $rankData = FatActivityMember::orderBy('votes','>=',$userMember->votes)->orderBy('updated_at','asc')->select('id','votes')->get();
        $rank = 1;
        foreach($rankData as $k => $rd){
            if($rd->id == $userMember->id){
                $rank = $k+1;
                break;
            }
            $rank = $k+1;
        }

        if(isset($rankData[$rank-2])){
            $preUser = $rankData[$rank-2];
        }else{
            $preUser = '';
        }

        $fatBodyData = FatBodyData::where('mid',$id)->orderBy('created_at','asc')->get();

        $data['userMember'] = $userMember;
        $data['rank'] = $rank;
        $data['preUser'] = $preUser;
        $data['fatBodyData'] = $fatBodyData;
        $data['user'] = $user;
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();
        }
        $data['redisData'] = $this->redisData();
        return view('a.fat.member',$data);
    }

    /**
     * [bodyData description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function bodyData(Request $request){
        $user = $request->user();
        $data['redisData'] = $this->redisData();
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();
        }
        if(!$user){
            return back();
        }else{
            $member = FatActivityMember::where("user_id", $user->id)->first();
            $count  = FatBodyData::where("mid", $member->id)->count();
            $data['member'] = $member;
            $data['count']  = $count;
            return view('a.fat.body', $data);
        }
    }

    /**
     *20201124
     *销售上传证件图片
    */
    public function CoverUpload(Request $request){
        $file = new FileUploader($request);
        $fileInfo = $file->base64ImgUpload($request,'upload/fat');
        return $fileInfo;
        
    }

    /**
     * [signUp 提交报名信息]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function signUpInfo(Request $request){
        $name = $request->input("name");
        $mobile = $request->input("mobile");
        $sex = $request->input("sex");
        $stage = $request->input("stage");
        $class = $request->input("classNumber");
        $cover_img = $request->input("cover_img");
        $object = $request->input("object");
        $user   = $request->user();
        if(!$user || !$user->id){
            return $this->getMessage('1', '您还未登录无法报名');
        }
        $regMobile = FatMobile::where("mobile", $mobile)->first();
        if(!$regMobile){
            return $this->getMessage('1', '抱歉您的身份无法参加此次活动');
        }
        $member = FatActivityMember::where("mobile", $mobile)->first();
        if($member){
            return $this->getMessage('1', '您已报名无需重复提交');
        }else{
            $member = new FatActivityMember();
            $member->name = $name;
            $member->mobile = $mobile;
            $member->sex = $sex;
            $member->stage = $stage;
            $member->class = $class;
            $member->cover_img = $cover_img;
            $member->object = $object;
            $member->user_id = $user->id;
            $r = $member->save();
            if($r){
                return $this->getMessage('0', '恭喜你报名成功！赶快为自己拉票吧！');
            }else{
                return $this->getMessage('1', '报名失败联系工作人员');
            }
        }
    }

    /**
     * [signUp 提交报名信息]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function postBodyData(Request $request){
        $mid  = $request->input("mid");
        $age  = $request->input("age");
        $weight = $request->input("weight");
        $height = $request->input("height");
        $group  = $request->input("group");
        $fat_rate = $request->input("fat_rate");
        $fat_img  = $request->input("fat_img");
        $positive_img = $request->input("positive_img");
        $side_img = $request->input("side_img");
        $fre      = $request->input("fre", 0); //新增体测数据0：首次；1，2，3，4对用后面几次
        $user     = $request->user();
        if(!$user || !$user->id){
            return $this->getMessage('1', '您还未登录无法报名');
        }
        if(is_float($fat_rate) || is_numeric($fat_rate)){
            
        }else{
            return $this->getMessage('1', '请填写正确的体脂率'.$fat_rate);
        }
        if(is_float($weight) || is_numeric($weight)){
           
        }else{
             return $this->getMessage('1', '请填写正确的体重'.$weight);
        }
        $member = FatActivityMember::where("id", $mid)->first();
        if(!$member){
            return $this->getMessage('1', '未找到您的报名信息');
        }else{
            if($member->fat_rate==0){
                $member->age = $age;
                $member->weight = $weight;
                $member->height = $height;
                $member->group  = $group;
                $member->fat_rate = $fat_rate;
                $member->fat_img  = $fat_img;
                $member->positive_img = $positive_img;
                $member->side_img = $side_img;
                $member->fat_diff_value = 0;
                $r = $member->save();
            }else{
                $member->fat_diff_value = $member->fat_rate-$fat_rate;
                $r = $member->save();
                if(!$r){
                    return $this->getMessage('1', '完善体测信息失败联系工作人员');
                }
                $body = new FatBodyData();
                $body->mid = $mid;
                $body->height = $height;
                $body->weight = $weight;
                $body->fat_rate = $fat_rate;
                $body->fat_img  = $fat_img;
                $body->positive_img  = $positive_img;
                $body->side_img  = $side_img;
                $r = $body->save();
            }
            if($r){
                return $this->getMessage('0', '完善信息成功');
            }else{
                return $this->getMessage('1', '完善体测信息失败联系工作人员');
            }
        }
    }

    /**
     * [redisData 缓存数据]
     * @return [type] [description]
     */
    protected function redisData(){
        // $members = FatActivityMember::orderBy("id", "desc")->first();    //报名总人数
        $members = 836;    //报名总人数
        //redis::del("fat_activity_votes");
        if(Redis::exists("fat_activity_views") && Redis::get("fat_activity_views") != ''){
            $fat_activity_views    = Redis::get("fat_activity_views");   //页面浏览总数 
            Redis::setex("fat_activity_views", 3600*24, $fat_activity_views+1);//页面浏览总数 
        }else{
            $fat_activity_views    = 1000;
            Redis::setex("fat_activity_views", 3600*24, $fat_activity_views);//页面浏览总数 
        }
        if(Redis::exists("fat_activity_votes") && Redis::get("fat_activity_votes") != ''){
            $fat_activity_votes    = Redis::get("fat_activity_votes");       //投票总人数
        }else{
            $fat_activity_votes   = FatVote::orderBy("id", "desc")->first(); //投票总人数
            $fat_activity_votes   = $fat_activity_votes ?  $fat_activity_votes->id : 0;
            Redis::setex("fat_activity_votes", 3600*4, $fat_activity_votes); //投票总人数
        }
        return['members'=>$members, 'fat_activity_votes'=>$fat_activity_votes, 'fat_activity_views'=>$fat_activity_views];
    }


    public function yasuo(){
        //return;
        $dir    = env('IMG_PATH').'/upload/fat/img20210424/';
        $newDir = env('IMG_PATH').'/upload/fat/newimg20210424/';
        // $source =  $dir.'1606788447.6929635289.jpeg';
        // $dst_img = $newDir.'1606788447.6929635289.jpeg';
        // $percent = 1;  #原图压缩，不缩放，但体积大大降低 
        // $image = (new ImageCompress($source,$percent))->compressImg($dst_img);
        // echo 111;


        //PHP遍历文件夹下所有文件
        $files=opendir($dir.".");
        while (false !== ($file = readdir($files)))
        { 
            if ($file != "." && $file != ".." && is_file($dir.$file)) {
              $source =  $dir.$file;
              $dst_img = $newDir.$file;
              $percent = 0.8;  #原图压缩，不缩放，但体积大大降低 
              $image = (new ImageCompress($source,$percent))->compressImg($dst_img);
         
            }
         
        }
        closedir($files);
    }
}