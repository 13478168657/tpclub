<?php

namespace App\Http\Controllers\A;

use App\Models\ActivityUserStatistics;
use App\Models\IntroActiveWin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\IntroActiveUser;
use App\Models\WechatActivityHand;
use App\Models\Period;
use App\Utils\FileUploader;
use App\Utils\MakeThumbPic;
use App\Events\WxCustomerMessagePush;
//导入七牛相关类
use Qiniu\Auth;
use Qiniu\Config;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
use App\Http\Controllers\Wechat\WechatController;
class JustDoController extends Controller
{

    public function __construct(){
        $this->voteNum = 3;
        $this->stage = $this->getPeriod();
    }

    public function index(Request $request){

        $user = $request->user();
        if(!$user){
            $user_id = 0;
        }else{
            $user_id = $user->id;
        }
        $restNum = $this->getVoteNum($user_id);
        $data['restNum'] = $restNum;
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();  //微信分享
        }
        $f_channel  = $request->input('f_channel', 'default');
        $data['f_channel']   = $f_channel;     //来源渠道
        $data['subscribe']   =  isset($user->subscribe) ? $user->subscribe : 0;
        return view('a.justdo.index',$data);
    }


    public function getVoteNum($user_id){
        $day = date('Ymd');
        $num = WechatActivityHand::where('sponsor_id',$user_id)->where('type','DOIT')->where('day',$day)->where('stage',$this->stage)->select('id')->count();

        return ($this->voteNum - $num)>0?$this->voteNum - $num:0;
    }
    public function baoming(Request $request){

        $user = $request->user();
        if(!$user){
            return redirect('/register?redirect=/jdt/active/baoming');
        }
        $introUser = IntroActiveUser::where('type','DOIT')->where('user_id',$user->id)->where('stage',$this->stage)->select('user_info')->first();

        $flag = 0;
        if($introUser){
            $userInfo = json_decode($introUser->user_info);
            $flag = 1;
            logger()->info([$flag,$user->id]);
        }else{
            $userInfo = '';
        }

        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();  //微信分享
        }
        $data['user'] = $user;
        $data['name'] =  $userInfo?$userInfo->name:'';
        $data['avatar'] =  $user->avatar;
        $data['mobile'] =  $userInfo?$userInfo->mobile:'';
        $data['wechat'] =  $userInfo?$userInfo->wechat:'';
        $data['sex'] =  $userInfo?$userInfo->sex:'';
        $data['age'] =  $userInfo?$userInfo->age:'';
        $data['semester'] =  $userInfo?$userInfo->semester:'';
        $data['city'] =  $userInfo?$userInfo->city:'';
        $data['company'] =  $userInfo?$userInfo->company:'';
        $data['positon'] =  $userInfo?$userInfo->positon:'';
        $data['working_life'] =  $userInfo?$userInfo->working_life:'';
        $data['self_media'] =  $userInfo?$userInfo->self_media:'';
        $data['upload_video'] =  $userInfo?$userInfo->upload_video:'';
        $data['cover_img'] =  $userInfo?$userInfo->cover_img:'';
        $data['cover_img2'] =  isset($userInfo->cover_img2) ? $userInfo->cover_img2 :'';
        $data['cover_img3'] =  isset($userInfo->cover_img3) ? $userInfo->cover_img3 :'';
        //echo $userInfo->cover_img;
        $data['subscribe'] =  isset($user->subscribe) ? $user->subscribe : 0;
        if(isset($userInfo->identity)){
            $data['identity'] =  $userInfo->identity;
        }else{
            $data['identity'] =  '';
        }
        $data['user_id'] = $user->id;
        $data['userInfo'] = $userInfo;
        $data['userFlag'] = $flag;
        return view('a.justdo.baoming',$data);
    }

    public function rank(Request $request){
        $ranks = ActivityUserStatistics::where('type',5)->where('stage',$this->stage)->orderBy('invite_num','desc')->orderBy('updated_at','asc')->take(3)->get();
        $idsArr = [];
        $num = 0;
        if(isset($ranks[0])){
            $firstRank = $ranks[0];
            $idsArr[] = $firstRank->user_id;
            $num++;
        }else{
            $firstRank = '';
        }
        if(isset($ranks[1])){
            $secondRank = $ranks[1];
            $idsArr[] = $secondRank->user_id;
            $num++;
        }else{
            $secondRank = '';
        }
        if(isset($ranks[2])){
            $thirdRank = $ranks[2];
            $idsArr[] = $thirdRank->user_id;
            $num++;
        }else{
            $thirdRank = '';
        }
        $rankInfo = ActivityUserStatistics::whereNotIn('user_id',$idsArr)->where('type',5)->where('stage',$this->stage)->orderBy('invite_num','desc')->orderBy('updated_at','asc')->get();
        $data['firstRank'] = $firstRank;
        $data['secondRank'] = $secondRank;
        $data['thirdRank'] = $thirdRank;
        $data['num'] = $num;
        $data['rankInfo'] = $rankInfo;
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();  //微信分享
        }
        return view('a.justdo.rank',$data);
    }

    public function center(Request $request,$id){

        $cur_user = $request->user();
        if($cur_user){
            $user_id = $cur_user->id;
        }else{
            $user_id = 0;
        }
        $day = date('Ymd');
        $activeHand = WechatActivityHand::where('user_id',$id)->where('sponsor_id',$user_id)->where('type','DOIT')->where('day',$day)->where('stage',$this->stage)->first();
        $isVote = 0;
        if($activeHand){
            $isVote = 1;
        }
        $data['isVote'] = $isVote;
        $activeUser = IntroActiveUser::where('user_id',$id)->where('type','DOIT')->where('stage',$this->stage)->first();
        if(!$activeUser){
           return redirect('/jdt/active/vote');
        }
        $data['userInfo'] = json_decode($activeUser->user_info);
        $user = User::where('id',$id)->first();
        $data['user'] = $user;
        $data['activeUser'] = $activeUser;
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();  //微信分享
        }
        $userStatistics = ActivityUserStatistics::where('user_id',$id)->where('type',5)->where('stage',$this->stage)->first();
        $total = 0;
        if($userStatistics){
            $total = $userStatistics->invite_num;
        }
        $data['user_id'] = $user_id;
        $data['total'] = $total;
        return view('a.justdo.center',$data);
    }

    public function userVote(Request $request){

        $user = $request->user();
        if($user){
            $user_id = $user->id;
        }else{
            $user_id = 0;
        }
        $type = $request->input('type',0);
        $key  = $request->input('key',"");
        
        $restNum = $this->getVoteNum($user_id);
        if($type){
            if($key){
                $activeUsers = ActivityUserStatistics::where('type',5)->where('name','like','%'.$key.'%')->where('stage',$this->stage)->orderBy('invite_num','desc')->orderBy('updated_at','asc')->paginate(10);
            }else{
                $activeUsers = ActivityUserStatistics::where('type',5)->where('stage',$this->stage)->orderBy('invite_num','desc')->orderBy('updated_at','asc')->paginate(10);
            }
            
//            $dataInfo = [];
//            foreach($activeUsers as $activeUser){
//                $dataInfo[] = view('a.justdo.body.list',['activeUser'=>$activeUser,'user_id'=>$user_id])->render();
//            }
//            $activeUsers = IntroActiveUser::where('type','DOIT')->select('user_id','user_info')->paginate(10);
            $data['activeUsers'] = $activeUsers;
            $data['user_id'] = $user_id;
//            return $this->getMessage(0,'获取成功',['activeInfo'=>$dataInfo,]);
            return $this->getMessage(0,'获取成功',['body'=>view('a.justdo.body.list',['activeUsers'=>$activeUsers,'user_id'=>$user_id])->render()]);
        }

        $selfActive = ActivityUserStatistics::where('user_id',$user_id)->where('type',5)->where('stage',$this->stage)->first();
        if($selfActive){
            $selfRank = ActivityUserStatistics::where('invite_num','>=',$selfActive->invite_num)->where('type',5)->where('stage',$this->stage)->where('user_id','!=',$user_id)->orderBy('updated_at','asc')->select('id')->get();

            $data['selfActive'] = $selfActive;
            $data['selfRank'] = count($selfRank);
        }else{
            $data['selfActive'] = '';
            $data['selfRank'] = '';
        }

        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();  //微信分享
        }
        if($key){
            $activeUsers = ActivityUserStatistics::where('type',5)->where('name','like','%'.$key.'%')->where('stage',$this->stage)->orderBy('invite_num','desc')->orderBy('updated_at','asc')->paginate(10);
            $data['key'] = $key;
        }else{
            $activeUsers = ActivityUserStatistics::where('type',5)->orderBy('invite_num','desc')->where('stage',$this->stage)->orderBy('updated_at','asc')->paginate(10);
            $data['key'] = "";
        }
        
        $data['bmTotal'] = IntroActiveUser::where('type','DOIT')->where('stage',$this->stage)->select('id')->count();
        $data['totalVote'] = WechatActivityHand::where('type','DOIT')->where('stage',$this->stage)->select('id')->count();
        $data['activeUsers'] = $activeUsers;
        $data['user_id'] = $user_id;
        $data['restNum'] = $restNum;
        $data['subscribe'] =  isset($user->subscribe) ? $user->subscribe : 0;

        return view('a.justdo.vote1',$data);
    }
    public function postVote(Request $request){

        $user_id = $request->input('id');
        $user = $request->user();
        $currDate = time();
        if($currDate >= strtotime('2020-01-04')){
            return $this->getMessage(2,'投票已结束');
        }

        if(!$user){
            return $this->getMessage(4,'用户未登录');
        }

        if($user_id == $user->id){

            return $this->getMessage(1,'不可投自己哟～');
        }
        if($user->subscribe==0){
            return $this->getMessage(5,'未关注公众号，引导关注');
        }
        $day = date('Ymd');
        $total = WechatActivityHand::where('sponsor_id',$user->id)->where('day',$day)->where('stage',$this->stage)->where('type','DOIT')->count();
        if($total >= $this->voteNum){

            return $this->getMessage(2,'每天最多可投三人');
        }
        $activeHand = WechatActivityHand::where('user_id',$user_id)->where('sponsor_id',$user->id)->where('day',$day)->where('stage',$this->stage)->where('type','DOIT')->first();
        if($activeHand){

            return $this->getMessage(2,'已投');
        }
        $dayVote = WechatActivityHand::where('user_id',$user_id)->where('day',$day)->where('type','DOIT')->where('stage',$this->stage)->select('id')->count();
        if($dayVote > 500){
            return $this->getMessage(3,'已超单日投票数');
        }
        try{
            $activeHand = new WechatActivityHand();
            $activeHand->user_id = $user_id;
            $activeHand->sponsor_id = $user->id;
            $activeHand->type = 'DOIT';
            $activeHand->day = $day;
            $activeHand->stage = $this->stage;
            $activeHand->save();
            $userStatistics = ActivityUserStatistics::where('user_id',$user_id)->where('type',5)->where('stage',$this->stage)->first();
            if(!$userStatistics){
                $userStatistics = new ActivityUserStatistics();
                $userStatistics->type = 5;
                $userStatistics->stage = $this->stage;
                $userStatistics->user_id = $user_id;
                $userStatistics->invite_num = 1;
            }else{
                $userStatistics->invite_num += 1;
            }
            $userStatistics->save();

            if($userStatistics->invite_num % 5 == 0){
                logger()->info('票数:'.$userStatistics->invite_num.'---user_id:'.$user_id);
                $push_user = User::where('id',$user_id)->select('openid')->first();
                $content = "恭喜您获得5位好友的投票\n您目前的总票数是".$userStatistics->invite_num."\n再进一步，您将获得更多机会！\n<a href='http://m.saipubbs.com/jdt/active/vote"."'>点击查看目前排名</a>";
                $data['openid'] = $push_user->openid;
                $data['type']   = 'TEXT';
                $data['text'] = $content;
                if(env('IS_LOCAL') == false){

                    event(new WxCustomerMessagePush($data));
                }
            }
            return $this->getMessage(0,'投票成功');
        }catch(\Exception $e){

            return $this->getMessage(3,'投票失败');
        }

    }

    public function generatePoster(Request $request){
        $user = $request->user();
        $user_id = $user->id;

        $wechat = new WechatController();
        $img_url = $wechat->getQRcode("jdtUser_".$user_id);
        return $this->getMessage(0,'成功',['img'=>'http://m.saipubbs.com/'.$img_url]);
    }

    public function pullTicket(Request $request){

        $user_id = $request->input('id');
        $shareCode = "http://qr.topscan.com/api.php?text=http://m.saipubbs.com/jdt/active/center/".$user_id.'.html';
        $destDirectory = "/upload/wxqrcode/";
        if (!file_exists(public_path().'/'.$destDirectory)) {
            $fileDir = mkdir(public_path().'/'.$destDirectory,0777,true);
        }else{
            $fileDir = public_path().'/'.$destDirectory;
        }
//        $user = User::where('id',$user_id)->first();
        $introUser = IntroActiveUser::where('type','DOIT')->where('user_id',$user_id)->select('user_info')->first();
        $userInfo = json_decode($introUser->user_info);
        $name = $userInfo->name;
        $imageThumb  = new MakeThumbPic();
        $bodyPic = "/images/zt/just_do_it/lapiao_img.jpg";
        $file = time().rand(1000,9999).".png";
        $r = $imageThumb->getImage($shareCode,$fileDir, $file);
        $wechatCodeArr = $destDirectory.$r['file_name'];

        $activity = 15;
        logger()->info($activity);
        $img_url = $imageThumb->makePic($bodyPic, '', $wechatCodeArr,'upload/share/',$name,$activity,'');
        $shareUrl = env('APP_URL').'/'.$img_url[1];
        return $this->getMessage(0,'成功',['shareCode'=>$shareUrl]);
    }

    public function createVoteCode(Request $request){
        
        $user_id = $request->input('id',"4531");
        $wechat = new WechatController();
        $img_url = $wechat->getQRcode("vote".$user_id);
        return json_encode(array("code"=>1, "url"=>$img_url));
    }

    public function successPage(Request $request){

        return view('a.justdo.success');
    }

    /*
     * 报名
     */
    public function postJoin(Request $request){

        $user = $request->user();
        $currDate = date('Y-m-d');

        if($currDate == '2020-01-04'){
            return $this->getMessage(2,'报名已结束');
        }
        if(!$user){
            return $this->getMessage(4,'用户未登录');
        }
        $user->avatar = $request->input('avatar','');
        $user->save();
        $userInfo = $request->all();
        unset($userInfo['_url']);
        unset($userInfo['_token']);

        if($userInfo['cover_img']){
            if(file_exists(env('IMG_PATH').$userInfo['cover_img'])){
                $imgInfo = getimagesize(env('IMG_URL').$userInfo['cover_img']);
                list($width, $height) = $imgInfo;
                $userInfo['img_width'] = $width;
                $userInfo['img_height'] = $height;
            }else{

                $userInfo['img_width'] = 150;
                $userInfo['img_height'] = 150;
            }
        }
        $data = $request->all();
        $activeUser = IntroActiveUser::where('user_id',$user->id)->where('type','DOIT')->where('stage',$this->stage)->first();
        $flag = 0;
        if(!$activeUser){
            $activeUser = new IntroActiveUser();
            $activeUser->user_id = $user->id;
            $activeUser->type = 'DOIT';
            $activeUser->stage = $this->stage;
            $flag = 1;
            $activeUser->f_channel = $userInfo['f_channel'];
        }
        $activeUser->user_info = json_encode($userInfo);
        if($activeUser->save()){
            $userStatistics = ActivityUserStatistics::where('user_id',$user->id)->where('type',5)->where('stage',$this->stage)->first();
            if(!$userStatistics){
                $userStatistics = new ActivityUserStatistics();
                $userStatistics->type = 5;
                $userStatistics->user_id = $user->id;
                $userStatistics->name = $userInfo['name'];
                $userStatistics->stage = $this->stage;
                $userStatistics->save();
            }else{
                $userStatistics->name = $userInfo['name'];
                $userStatistics->save();
            }
            if($flag){
                $content = "恭喜您，报名报名成功！\n您现在已经进入线上海选环节，线上投票获得票数最多的前50名可直接进入面试环节，\n赶快邀请好友为你投票吧！<a href='http://m.saipubbs.com/jdt/active/center/".$user->id.".html'>邀请好友投票</a>";
                $data['openid'] = $user->openid;
                $data['type']   = 'TEXT';
                $data['text'] = $content;
                if(env('IS_LOCAL') == false){

                    event(new WxCustomerMessagePush($data));
                }
            }
            return $this->getMessage(0,'添加成功');
        }
        return $this->getMessage(2,'添加失败');
    }

    /*
     * 封面上传
     */
    public function coverUpload(Request $request){

        $file = new FileUploader($request);
        $fileInfo = $file->base64ImgUpload($request,'upload/justdoit');
        return $fileInfo;
    }

    /*
     * 删除封面
     */
    public function deleteImg(Request $request){
        $url     = $request->input("imgurl");

        $user = $request->user();
        if(!$user){
            return $this->getMessage(4,'用户未登录');
        }

//        $introUser = IntroActiveUser::where('user_id',$user->id)->where('type','DOIT')->first();
//        if($introUser){
//            $userInfo = json_decode($introUser->user_info);
//            $userInfo->cover_img = '';
//            $userInfo = json_encode($userInfo);
//            $introUser->user_info = $userInfo;
//            $introUser->save();
//        }
//        $result  = @unlink(env('IMG_PATH').$url);
        return $this->getMessage(0,'删除成功');
    }
    /*
     * 视频上传
     */
    public function videoUpload(Request $request){
        set_time_limit(0);
        $token=$this->getToken();
        $uploadManager=new UploadManager();
        $user = $request->user();
        if($user){
            $user_id = $user->id;
        }else{
            $user_id = 0;
        }
        logger()->info(3333);
        $name='justdoit/'.date('Ymd').'/'.$user_id.'/'.$_FILES['uploadfile']['name'];
//        logger()->info($name);
        $filePath= $_FILES['uploadfile']['tmp_name'];
//        logger()->info($filePath);
        $type=$_FILES['uploadfile']['type'];
        $size = $_FILES['uploadfile']['size'];
        if($size > 250000000){
            return json_encode(['code'=>0,'content'=>'视频尺寸过大']);
        }
        list($ret,$err)=$uploadManager->putFile($token,$name,$filePath,null,$type,false);
        if($err){//上传失败

            logger()->info($err);
            return json_encode(['code'=>0,'content'=>$err]);//返回错误信息到上传页面
        }else{//成功
            //添加信息到数据库
//            logger()->info($ret);
            $url = config('qiniu.domain').$ret['key'];
            return json_encode(['code'=>1,'content'=>'上传成功','url'=>$url]);//返回结果到上传页面
        }
    }

    /*
     * 删除视频
     */
    public function delVideo(Request $request){

        $user = $request->user();
        if(!$user){
            return $this->getMessage(1,'无此视频');
        }

//        $introUser = IntroActiveUser::where('user_id',$user->id)->where('type','DOIT')->first();
//        if($introUser){
//            $userInfo = json_decode($introUser->user_info);
//            $userInfo->upload_video = '';
//            $userInfo = json_encode($userInfo);
//            $introUser->user_info = $userInfo;
//            $introUser->save();
//        }

        return $this->getMessage(0,'删除成功');

    }

    /*
     * 获取七牛配置信息
     */
    private function getToken(){
        $accessKey=config('qiniu.accessKey');
        $secretKey=config('qiniu.secretKey');
        $auth=new Auth($accessKey, $secretKey);
        $bucket=config('qiniu.bucket');//上传空间名称
        //设置put policy的其他参数
        return $auth->uploadToken($bucket);//生成token
    }

    

    /**
     * 获取微信图片
     * 20200101
     * @return [type] [description]
     */
    public function getListPic(){
        $activeUsers = ActivityUserStatistics::where('type',5)->where('stage',$this->stage)->orderBy('invite_num','desc')->orderBy('updated_at','asc')->paginate(20);
        $img_arr = array();
        $dir     = iconv("UTF-8", "GBK", "saishi/111");
        foreach($activeUsers as &$u){
            $introActive = $u->getActiveInfo($u->user_id,'DOIT',$this->stage);
            $img_arr[]   = json_decode($introActive->user_info,true)['cover_img'];
        }
       
        if(!file_exists($dir)){
            mkdir ($dir,0777,true);
            //echo '创建文件夹bookcover成功';
        } 
        $zip    = new \ZipArchive();
        $zipname= "saishi/saishi-".date('YmdHis',time()).".zip";
        $res    =  $zip->open($zipname, \ZipArchive::CREATE);
        $myfile = fopen("saishi/name.txt", "w");

        foreach($img_arr as $k=>$v){
            //创建txt名录表
            //$name_str = $k.'=>'.$v['name']."\r\n";
            //fwrite($myfile, $name_str);
            $return_content = $this->http_get_data(env('IMG_URL').$v);  
            $filename =  $dir.'/'.iconv('utf-8','gb2312',$k.'.jpg');
            $fp= @fopen($filename,"a"); //将文件绑定到流
            fwrite($fp,$return_content); //写入文件  
            if($res == true){
                $zip->addFile(iconv('utf-8','gb2312',$filename));
            }
        }
        
        fclose($myfile);
        $zip->addFile("saishi/name.txt");
        $zip->close();

        //下载压缩包
        header("Cache-Control: public"); 
        header("Content-Description: File Transfer"); 
        header('Content-disposition: attachment; filename='.basename($zipname)); //文件名  
        header("Content-Type: application/zip"); //zip格式的  
        header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件  
        header('Content-Length: '. filesize($zipname)); //告诉浏览器，文件大小  
        ob_clean();  
        flush();     
        @readfile($zipname);
        unlink($zipname);
        unlink("saishi/name.txt");
        $this->deldir($dir);
    }
    
        
    
    //爬取图片
    public function http_get_data($url) {  
        $ch = curl_init ();  
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );  
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );  
        curl_setopt ( $ch, CURLOPT_URL, $url );  
        ob_start ();  
        $fileContent = curl_exec ( $ch );  
        $return_content = ob_get_contents();  
        ob_end_clean ();  

        $return_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );  
        return $return_content;  
    }  

    //删除文件夹
    public function deldir($dir) {
       //先删除目录下的文件：
       $dh=opendir($dir);
       while ($file=readdir($dh)) {
          if($file!="." && $file!="..") {
             $fullpath=$dir."/".$file;
             if(!is_dir($fullpath)) {
                unlink($fullpath);
             } else {
                deldir($fullpath);
             }
          }
       }
       closedir($dh);
       //删除当前文件夹：
       if(rmdir($dir)) {
          return true;
       } else {
          return false;
       }
    }

    public function notice(Request $request){

        $user = $request->user();
        if(!$user){
            $user_id  = 0;
            $name     =  '暂无姓名';
            $identity =  '暂无信息';
            $is_have  = 0;
        }else{
            $user_id = $user->id;
            $is_have = IntroActiveWin::where("user_id", $user_id)->first();
            if($is_have){
                $is_have = 1;
            }else{
                $is_have = 0;
            }
            $activeUser = IntroActiveUser::where("user_id", $user_id)->where("type", "DOIT")->first();
            if($activeUser){
                $activeUser = json_decode($activeUser->user_info, true);
                $name = $activeUser['name'] ? $activeUser['name'] : '暂无姓名';
                $identity = $activeUser['identity'] ? $activeUser['identity'] : '暂无信息';
                if($identity=='管理方向'){
                    $identity='管理精英奖';
                }elseif($identity=='已创业' || $identity=='准备创业'){
                    $identity='创业精英奖';
                }else{
                    $identity='明星教练奖';
                }
            }else{
                $name     =  '暂无姓名';
                $identity =  '暂无信息';
            }
        }
        //echo $is_have;
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();  //微信分享
        }
        $data['is_have']  = $is_have;
        $data['name']     = $name;     //来源渠道
        $data['identity'] =  $identity;
        return view('a.justdo.notice',$data);
    }
    /**
     * **20200310
     * 视频达人通知证书
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function noticeVideo(Request $request){

        $user = $request->user();
        if(!$user){
            $user_id  = 0;
            $name     =  '暂无姓名';
            $is_have  = 0;
        }else{
            $user_id = $user->id;
            $ids     = [175223, 42425, 226253, 145749, 187673, 153063, 259052, 7540, 105579, 24048, 131613, 101018, 142029, 43197, 196205, 217955, 39626, 128705, 202082, 201987, 145463, 102212, 156689, 40095, 28759, 66647, 5319, 19248, 19175, 119948, 289371, 140732, 297328, 50559, 53253, 230766, 187380, 134636, 203929, 71233, 117656, 194249,4531,202274,186118, 102519, 129689, 7515, 90197, 18055, 47989, 136439, 26364, 19049, 117833  , 160837, 149128 ,17110, 54780, 105616, 131846, 62340, 251397, 7796, 3135, 135350, 22399, 170957, 48052, 196819, 7365, 231395, 9881, 39251, 227846, 136463, 135330, 130640];
            $is_have = IntroActiveWin::where("user_id", $user_id)->first();
            if(in_array($user_id, $ids)){
                $is_have = 1;
            }else{
                return;
            }
            $activeUser = IntroActiveUser::where("user_id", $user_id)->where("type", "DOIT")->first();
            if($activeUser){
                $activeUser = json_decode($activeUser->user_info, true);
                $name = $activeUser['name'] ? $activeUser['name'] : '暂无姓名';
            }else{
                $name     =  '暂无姓名';
            }
        }
        //echo $is_have;
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();  //微信分享
        }
        $name = $user ? $user->nickname : "--";
        $data['is_have']  = $is_have;
        $data['name']     = $name;     //来源渠道
        return view('a.justdo.video',$data);
    }


    /**
     * **20200228 
     * youku 直播报名
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function youkuBaoming(Request $request){

        $user = $request->user();
        if(!$user){
            return redirect('/register?redirect=/jdt/active/baoming');
        }
        $introUser = IntroActiveUser::where('type','YOUKU')->where('user_id',$user->id)->select('user_info')->first();

        $flag = 0;
        if($introUser){
            $userInfo = json_decode($introUser->user_info);
            $flag = 1;
            logger()->info([$flag,$user->id]);
            //dd($introUser->id);
        }else{
            $userInfo = '';
        }
        
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();  //微信分享
        }
        $data['user']    = $user;
        $data['name']    =  $userInfo?$userInfo->name:'';
        $data['avatar']  =  $user->avatar;
        $data['sex']     =  $userInfo?$userInfo->sex:'';
        $data['number']  =  $userInfo?$userInfo->number:'';
        $data['content'] =  $userInfo?$userInfo->content:'';
        $data['date']    =  $userInfo?$userInfo->date:'';
        $data['hours']   =  $userInfo?$userInfo->hours:'';
        $data['cover_img']   =  isset($userInfo->cover_img) ? $userInfo->cover_img:'';

        $data['subscribe'] =  isset($user->subscribe) ? $user->subscribe : 0;
        if(isset($userInfo->identity)){
            $data['identity'] =  $userInfo->identity;
        }else{
            $data['identity'] =  '';
        }
        $data['user_id']  = $user->id;
        $data['userInfo'] = $userInfo;
        $data['userFlag'] = $flag;
        return view('a.justdo.youku',$data);
    }

    /*
     *
     * 20200228
     * youku 直播报名
     */
    public function postJoinYk(Request $request){
        $user = $request->user();
        if(!$user){
            return $this->getMessage(4,'用户未登录');
        }
        $user->avatar = $request->input('avatar','');
        $user->save();
        $userInfo = $request->all();
        unset($userInfo['_url']);
        unset($userInfo['_token']);
        $list  = IntroActiveUser::where('type','YOUKU')->get();
        $dates = 0;
        $hours = 0;
        

        foreach($list as $i){
            $info = json_decode($i->user_info,true);
            if($info['date']==$userInfo['date']){
                $dates+=1;
                if($info['hours']==$userInfo['hours']){
                    $hours+=1;
                }
            }

            
        } 
        // if($dates>=5){
        //     return $this->getMessage(2,'请更换日期，该日期人数已报满');
        // }
        if($hours>=5){
            return $this->getMessage(2,'请更换时间段，该时间段人数已报满');
        }

        $data = $request->all();
        $activeUser = IntroActiveUser::where('user_id',$user->id)->where('type','YOUKU')->first();
        $flag = 0;
        if(!$activeUser){
            $activeUser = new IntroActiveUser();
            $activeUser->user_id = $user->id;
            $activeUser->type = 'YOUKU';
            $flag = 1;
        }
        $activeUser->user_info = json_encode($userInfo);
        if($activeUser->save()){
            
            return $this->getMessage(0,'添加成功');
        }
        return $this->getMessage(2,'添加失败');
    }

    private function getPeriod(){
        $period = Period::where('type','doit')->where('state',1)->select('stage')->first();
        $stage = 1;
        if($period){
            $stage = $period->stage;
        }
        return $stage;
    }
}
