<?php

namespace App\Http\Controllers\Distribution;

use App\Http\Controllers\Wechat\WechatShareController;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DisCourse;
use App\Models\DisCourseClass;
use App\Models\DisCoursePlayRecord;
use App\Models\DisOrder;
use App\Models\DisStudying;
use App\Models\ActivityUserStatistics;
use App\Models\CoachList;
use App\Models\CoachListStep;
use App\Models\CoachTag;
use App\Models\CoachClassify;
use App\Models\CoachListComment;
use App\Models\CoachListZan;
use App\Models\Follow;
use App\Models\Period;
use Illuminate\Support\Facades\DB;
use App\Constant\WxMessageType;
use App\Utils\WxMessagePush;
use App\Utils\MakeThumbPic;
use App\Http\Controllers\Wechat\WechatController;
require app_path().'/Library/Wechat/WxPay.JsApiPay.php';
class CoachTrainController extends Controller
{


    public function index(Request $request,$id){
        $fission_id = $request->input('fid',0);
        $data = [];
//        $disForm = DisForm::where('user_id',$dis)->first();
//        $data['distClass'] = DisCourseClass::where('id',$cid)->first();
//        $data['disForm'] = $disForm;
        if($id == 15){
            $range = 10;
            $startTime = '2019-08-05';
        }else{
            $range = 7;
            $startTime = '2019-08-18';
        }

        $stageArr = $this->judgeStage($startTime,$range);
        $nowTime = date('Y-m-d');
        $period = Period::where('begin_time',">",$nowTime)->where('cid',$id)->first();
        $data['period'] = $period;
        $user = $request->user();
        $flag = 0;
        if($user){
            if($user->mobile){
                $flag = 1;
            }

            $data['fid'] = $user->id;
        }else{
            $data['fid'] = 0;
        }
        $data['fission_id'] = $fission_id;
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();  //微信分享
        }
        $data['flag'] = $flag;
        $disCourseClass = DisCourseClass::where('id',$id)->first();
        $disStudy = DisStudying::where('user_id',$data['fid'])->where('dis_course_class_id',$id)->select('id')->first();
        if($disStudy){
            $data ['is_have'] = 1;  //是否拥有此课程
        }else{
            $data ['is_have'] = 0;  //是否拥有此课程
        }
        $img = '';
        if(env('IS_LOCAL') == false){
            $weChat    = new WechatController();
            $QRcodeUrl = $weChat->getQRcodeUrl("coach_".$id,'/upload/share/');
            $img = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$QRcodeUrl;
        }
        //echo $QRcodeUrl;

        if($disCourseClass->is_external==1){
            $img = env("IMG_URL").$disCourseClass->qrcode_url;
        }

        $data['QRcodeUrl'] = $img;
        $data['id']        = $id;
        $data['disCourse'] = $disCourseClass;
        $data['stageArr']  = $stageArr;
        return view('distActive.train',$data);
    }

    /*
     * 分享二维码
     */
    public function generateShareCode(Request $request){

        $user = $request->user();
        $id = $request->input('id','');
        if($user){
            $user_id = $user->id;
        }else{
            $user_id = 0;
        }
        $shareCode = "http://qr.topscan.com/api.php?text=http://m.saipubbs.com/coach/".$id.'.html?fid='.$user_id;
        $destDirectory = "/upload/wxqrcode/";
        if (!file_exists(public_path().'/'.$destDirectory)) {
            $fileDir = mkdir(public_path().'/'.$destDirectory,0777,true);
        }else{
            $fileDir = public_path().'/'.$destDirectory;
        }

        $imageThumb  = new MakeThumbPic();
        $bodyPic = "/images/activity/train.jpg";
        $file = time().rand(1000,9999).".png";
        $r = $imageThumb->getImage($shareCode,$fileDir, $file);
        $wechatCodeArr = $destDirectory.$r['file_name'];

        $activity = 12;
        $img_url = $imageThumb->makePic($bodyPic, '', $wechatCodeArr,'upload/share/','',$activity,'');
        $shareUrl = env('APP_URL').'/'.$img_url[1];
//        echo "<img src='http://m.saipubbs.com/".$img_url[1]."'/>";

        return $this->getMessage(0,'成功',['shareCode'=>$shareUrl]);
    }
    /*
     * 生成二维码
     */
    public function generateCode(Request $request,$id){

        $user = $request->user();
        if(!$user){
            return redirect('/login?redirect=/coach/code/'.$id.'.html');
        }
        $shareName = $user->name?$user->name:$user->nickname;

        $weChat = new WechatController();
        $shareDir = $weChat->getQRcode("coach_".$id."_".$user->id,'/upload/share/');
        $disCourseClass = DisCourseClass::where('id',$id)->first();
        $bodyPic = env('IMG_PATH').$disCourseClass->poster_url;

        $thumbPic = new MakeThumbPic();
        $imgPic = $thumbPic->makePic($bodyPic,'',$shareDir,'upload/wxqrcode/',$shareName,7);
        $data = [];
        $data['shareCode'] = env('APP_URL').'/'.$imgPic[1];
        $data['title'] = $disCourseClass->title;
        return view('distActive.trainCode',$data);
    }
    public function totalSubscribeUser($dis_id, $user_id){
        
        $disCourseClass = DisCourseClass::where('id',$dis_id)->first();

        if(!$disCourseClass) {
            return false;
        }
        $user = User::where('id',$user_id)->first();

        if(!$user){
            return false;
        }
        if($dis_id == 15){
            $type =2;
            $activeStatic = ActivityUserStatistics::where('user_id',$user_id)->where('type',$type)->first();//type:2;军人训练营
        }else{
            $type = 3;
            $activeStatic = ActivityUserStatistics::where('user_id',$user_id)->where('type',$type)->first();//type:2;军人训练营
        }

        if(!$activeStatic){
            $activeStatic = new ActivityUserStatistics();
            $activeStatic->user_id = $user_id;
            $activeStatic->invite_num += 1;
            $activeStatic->type = $type;//用户活动类型：
        }else{
            $activeStatic->invite_num += 1;
        }
        $activeStatic->save();
        if($activeStatic->invite_num != 3){
            return false;
        }
        $disStudy = DisStudying::where('user_id',$user_id)->where('dis_course_class_id',$dis_id)->select('id')->first();

        if($disStudy){
            return [1,'已购买'];
        }else{
            $disStudy  = new DisStudying();
        }

        if($dis_id == 15){
            $range = 10;
            $startTime = '2019-08-05';
        }else{
            $range = 7;
            $startTime = '2019-08-18';
        }
        $stageArr = $this->judgeStage($startTime,$range);
        DB::beginTransaction();
        try{
            $disStudy->user_id = $user_id;
            $disStudy->dis_course_class_id = $dis_id;
            $disStudy->stage = $stageArr['stage'];
//            $disStudy->dis_id = $dist_id;//分销员id
            $disStudy->save();
            //操作客户账户资金信息
            $course_ids = explode(',',$disCourseClass->course_ids);
            $playRecords = [];
            foreach($course_ids as $k => $ids){
                $course = DisCourse::where('id',$ids)->select('delay')->first();
                $day = date('Y-m-d',time()+$course->delay*86400);
                $delayTime = strtotime($day);
                $playRecords[$k]['user_id'] = $user_id;
                $playRecords[$k]['dis_course_id'] = $ids;
                $playRecords[$k]['datetime'] = $delayTime;
                $playRecords[$k]['day'] = $day;
                $playRecords[$k]['dis_course_class_id'] = $disCourseClass->id;
                $playRecords[$k]['created_at'] = date('Y-m-d H:i:s');
                $playRecords[$k]['updated_at'] = date('Y-m-d H:i:s');
            }

            $res = DB::table('dis_course_play_record')->insert($playRecords);
            DB::commit();
            // if($user && $user->openid){
            //     //logger()->info($user->nickname);
            //     $data['type'] = WxMessageType::DISCOURSE;
            //     $userName = $user->name?$user->name:$user->nickname;
            //     $data['url'] = env('APP_URL')."/dist/study/{$disCourseClass->id}.html";
            //     $data['notice'] = "Hi~".$userName."，已经有三位小伙伴帮你成功领取课程。";
            //     $data['message']['key1']  = $disCourseClass->title;
            //     $data['message']['key2']  = "永久";
            //     $data['message']["remark"]  = "点击详情即可查看";
            //     $data['openid'] = $user->openid;
            //     $wxpush = new WxMessagePush();
            //     $wxpush->sendMessage($data);
            // }
            return [0,'获取成功'];
        }catch(\Exception $e){
            DB::rollback();
            logger()->info('获取军民训练课程失败');
            return [1,'购买失败'];
        }
    }

    private function judgeStage($startTime,$range = 10){

        $start = strtotime($startTime);
        $now = strtotime(date('Y-m-d'));
        $stage = intval(ceil((abs($now-$start)/86400)/$range));
        $end = date('m月d日',($start + 86400*$range*$stage));
        $nextTime = date('m月d日',($start + 86400*$range*$stage+86400));
        return ['end'=>$end,'stage'=>$stage,'nextTime'=>$nextTime];
    }

    public function wxShareSuccess(Request $request){
        $dis_id  = $request->input("dis_id");
        $user_id = $request->input("user_id");
        $disCourseClass = DisCourseClass::where('id',$dis_id)->first();
        if(!$disCourseClass) {
            return false;
        }
        $user = User::where('id',$user_id)->first();

        if(!$user){
            return false;
        }
        $disStudy = DisStudying::where('user_id',$user_id)->where('dis_course_class_id',$dis_id)->select('id')->first();
        if($disStudy){
            return json_encode(array("code"=>1, "msg"=>"获取成功"));
        }else{
            $disStudy  = new DisStudying();
        }

        if($dis_id == 15){
            $range = 10;
            $startTime = '2019-08-05';
        }else{
            $range = 7;
            $startTime = '2019-08-18';
        }
        $stageArr = $this->judgeStage($startTime,$range);
        $nowTime = date('Y-m-d');
        $period = Period::where('begin_time','>=',$nowTime)->first();
        $beginTime = strtotime($period->begin_time)-86400;
        DB::beginTransaction();
        try{
            $disStudy->user_id = $user_id;
            $disStudy->dis_course_class_id = $dis_id;
            $disStudy->stage = $stageArr['stage'];
//            $disStudy->dis_id = $dist_id;//分销员id
            $disStudy->save();
            //操作客户账户资金信息
            $course_ids = explode(',',$disCourseClass->course_ids);
            $playRecords = [];
            foreach($course_ids as $k => $ids){
                $course = DisCourse::where('id',$ids)->select('delay')->first();
                $day = date('Y-m-d',$beginTime+$course->delay*86400);
                $delayTime = strtotime($day);
                $playRecords[$k]['user_id'] = $user_id;
                $playRecords[$k]['dis_course_id'] = $ids;
                $playRecords[$k]['datetime'] = $delayTime;
                $playRecords[$k]['day'] = $day;
                $playRecords[$k]['dis_course_class_id'] = $disCourseClass->id;
                $playRecords[$k]['created_at'] = date('Y-m-d H:i:s');
                $playRecords[$k]['updated_at'] = date('Y-m-d H:i:s');
            }

            $res = DB::table('dis_course_play_record')->insert($playRecords);
            DB::commit();
            
            return json_encode(array("code"=>1, "msg"=>"获取成功"));
        }catch(\Exception $e){
            DB::rollback();
            logger()->info('获取军民训练课程失败');
            return json_encode(array("code"=>0, "msg"=>"购买失败"));
        }
    }

    public function coachList(Request $request){
        $style = $request->input('id','');
        $type = $request->input('type','');
        $coachTags = CoachTag::where('status',1)->get();
        $coachClassify = CoachClassify::where('status',1)->get();

        if($type == 'pos'){

            $coachList = Coachlist::where('status',1)->where(function($query) use ($style) {
                $query->where('list_classify','like','%'.$style.',%')
                    ->orWhere('list_classify','like',$style.',%')
                    ->orWhere('list_classify','like','%'.','.$style);
            })->paginate(10);
            return $this->getMessage(0,'获取成功',['body'=>view('coach.body.coachMore',['coachList'=>$coachList,'coachTags'=>$coachTags,'coachClassify'=>$coachClassify])->render()]);
        }elseif($type == 'tag'){
            $coachList = Coachlist::where('status',1)->where(function($query) use ($style) {
                $query->where('list_tags','like','%'.$style.',%')
                    ->orWhere('list_tags','like',$style.',%')
                    ->orWhere('list_tags','like','%'.','.$style);
            })->paginate(10);
            return $this->getMessage(0,'获取成功',['body'=>view('coach.body.coachMore',['coachList'=>$coachList,'coachTags'=>$coachTags,'coachClassify'=>$coachClassify])->render()]);

        }elseif($type == 'zan'){
            $coachList = Coachlist::where('status',1)->orderBy('zans','desc')->paginate(10);
            return $this->getMessage(0,'获取成功',['body'=>view('coach.body.coachMore',['coachList'=>$coachList,'coachTags'=>$coachTags,'coachClassify'=>$coachClassify])->render()]);
        }
        $coachList = CoachList::where('status',1)->paginate(10);

        return view('coach.coachList',['coachList'=>$coachList,'coachTags'=>$coachTags,'coachClassify'=>$coachClassify]);
    }

    public function coachDetail(Request $request,$id){

        $coachList = CoachList::where('id',$id)->where('status',1)->first();
        $coachList->views +=1;
        $coachList->save();
        $coachSteps = CoachListStep::where('coach_list_id',$id)->get();
        $author = $coachList->user;
        $user = $request->user();
        if($user){
            $user_id = $user->id;
            $mobile = $user->mobile;
        }else{
            $user_id = 0;
            $mobile = '';
        }
        $follow = new Follow();
        $item = $follow->where(['user_id'=>$author->id, 'fans_id'=>$user_id])->first();
        if($item){
            $is_follow = 1;  //已关注
        }else{
            $is_follow = 0;  //未关注
        }
        $moreCoachList = CoachList::where('status',1)->where('id','!=',$id)->take(10)->get();

        $user_id = $request->user()?$request->user()->id:'';
        $mobile = $request->user()?$request->user()->mobile:'';
        $comments = CoachListComment::where('coach_list_id',$id)->where('level',1)->orderBy("created_at","desc")->paginate(3);
        $zan = CoachListZan::where('user_id',$user_id)->where('coach_list_id',$id)->where('type',0)->select('id')->first();
        $help = CoachListZan::where('user_id',$user_id)->where('coach_list_id',$id)->where('type',1)->select('help')->first();
        if($help){
            if($help->help == 0){
                $isHelp = 0;
            }else{
                $isHelp = 1;
            }
        }else{
            $isHelp = 1;
        }
        $collect = CoachListZan::where('user_id',$user_id)->where('coach_list_id',$id)->where('type',2)->select('id','collect')->first();
        if($collect){
            if($collect->collect == 0){
                $isCollect = 0;
            }else{
                $isCollect = 1;
            }
        }else{
            $isCollect = 0;
        }

        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();

        }

        $sumZan = CoachListZan::where('coach_list_id',$id)->select('id')->count();
        $data['comments'] = $comments;
        $data['user_id'] = $user_id;
        $data['mobile'] = $mobile;
        $data['user'] = $request->user()?$request->user():'';
        $data['zan'] = $zan;
        $data['sumZan'] = $sumZan;
        $data['isHelp'] = $isHelp;
        $data['isCollect'] = $isCollect;
        $data['coachList'] = $coachList;
        $data['coachSteps'] = $coachSteps;
        $data['author'] = $author;
        $data['is_follow'] = $is_follow;
        $data['mobile'] = $mobile;
        $data['moreCoachList'] = $moreCoachList;
        return view('coach.coachDetail',$data);
    }

    public function coachSearch(Request $request){

    }

    public function addComment(Request $request){
        $con = filterSpecialChar($request->input('con',''));
        $coach_list_id = $request->input('coachid');
        $com_id = $request->input('comid');
        $author_id = $request->input('cid');
        $answer = CoachList::where('id',$coach_list_id)->first();
//        $push_user = $request->input('push_user',0);
        if(!$answer){
            return $this->getMessage(1,'答案不存在');
        }
        $user_id = $request->user()?$request->user()->id:'';
        $comment = new CoachListComment();
        $comment->coach_list_id = $coach_list_id;
        $comment->content = $con;
        $comment->user_id = $user_id;
        $comment->replyed_id = $com_id;
        $content_arr = explode(" ",$con);
        if(isset($content_arr[2])){
            $allName = trim($content_arr[0].$content_arr[1],'@');
        }else{
            $allName = trim($content_arr[0],'@');
        }
        $reply_cont = str_replace("@".$allName.' ',"",$con);
        $comment->reply_content = $reply_cont;
        if($author_id > 0){
            $comment->level = 2;
        }
        $comment->cid = $author_id;
        $data['user'] = $request->user();
        if($comment->save()){

            return $this->getMessage(0,'评论成功',['body'=>view('coach.body.comment',['cid'=>$author_id,'comment'=>$comment,'user_id'=>$user_id])->render()]);

        }else{
            return $this->getMessage(1,'评论失败');
        }
    }

    public function delComment(Request $request){
        $cid = $request->input('cid','');
        $user = $request->user();
        if(!$user){
            return $this->getMessage(1,'用户未登录');
        }
        $comment = CoachListComment::where('id',$cid)->where('user_id',$user->id)->first();
        if(!$comment){
            return $this->getMessage(1,'无此评论');
        }
        $replyComment = CoachListComment::where('replyed_id',$cid)->select('id')->first();
        if($replyComment){
            return $this->getMessage(1,'被评论，不能删除');
        }

        if($comment->delete()){
            return $this->getMessage(0,'删除成功');
        }else{
            return $this->getMessage(1,'删除失败');
        }
    }
    public function moreComment(Request $request){
        $user_id = $request->user()?$request->user():'';
        $num = 3;
        $cid = $request->input("cid");
        $page = $request->input("page");
        $can  = $request->input("can",1);
        $offset = $num *($page - 1);
        $comment = CoachListComment::where("coach_list_id",$cid)->where('level',1)->orderBy("created_at","desc")->paginate(3);
        $hasMore = 0;
        if($comment->hasMorePages()){
            $hasMore = 1;
        }

        return json_encode(['code'=>0,'body'=>view('coach.body.loadComment',['comment'=>$comment, "can"=>$can,'user_id'=>$user_id])->render(),'hasMore'=>$hasMore]);
    }

    public function coachAgree(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }

        $cid = $request->input("cid");
        $type = $request->input('type',0);
        if($type==0){
            $zan  = CoachListZan::where('user_id',$userid)->where('type',0)->where('coach_list_id',$cid)->first();
            if($zan){
                return $this->getMessage(1,'已赞');
            }
            $zan = new CoachListZan();
            $zan->user_id = $userid;
            $zan->coach_list_id = $cid;
            $re = $zan->save();
            if($re){
                CoachList::where("id",$cid)->increment('zans');
                return $this->getMessage(0,'成功');
            }else{
                return $this->getMessage(1,'失败');
            }
        }elseif($type == 1){
            $zan  = CoachListZan::where('user_id',$userid)->where('type',1)->where('coach_list_id',$cid)->first();
            if($zan){
                if($zan->help == 0){
                    $help = 1;
                }else{
                    $help = 0;
                }
            }else{
                $help = 0;
                $zan = new CoachListZan();
            }

            $zan->user_id = $userid;
            $zan->coach_list_id = $cid;
            $zan->type = $type;
            $zan->help = $help;
            $re = $zan->save();
            if($re){
                return $this->getMessage(0,'成功');
            }else{
                return $this->getMessage(1,'失败');
            }
        }elseif($type == 2){
            $zan  = CoachListZan::where('user_id',$userid)->where('type',$type)->where('coach_list_id',$cid)->first();
            if($zan){
                if($zan->collect == 0){
                    $collect = 1;
                }else{
                    $collect = 0;
                }
            }else{
                $collect = 1;
                $zan = new CoachListZan();
            }

            $zan->user_id = $userid;
            $zan->coach_list_id = $cid;
            $zan->type = $type;
            $zan->collect = $collect;
            $re = $zan->save();
            if($re){
                return $this->getMessage(0,'成功');
            }else{
                return $this->getMessage(1,'失败');
            }
        }
    }
}
