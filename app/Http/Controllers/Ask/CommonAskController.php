<?php

namespace App\Http\Controllers\Ask;

use App\Models\Studying;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommonAskQuestion;
use App\Models\CommonAskAnswer;
use App\Models\CommonAskComment;
use App\Models\CommonAskZan;
use App\Models\CommonAskAnswerComplain;
use App\Models\CommonHotQuestion;
use App\Models\Tags;
use App\Models\Type;
use App\Models\Courseclass;
use App\Models\Course;
use App\Models\CourseActivitySpbRecord;
use App\Models\CourseActivityUser;
use App\Models\CourseActivityView;
use App\Models\CourseActivityAskRecord;
use App\Utils\MakeThumbPic;
use App\User;
use DB;
use App\Events\WxCustomerMessagePush;
use App\Constant\CustomerPushType;
use App\Constant\WxMessageType;
use App\Events\WxMessagePush;
class CommonAskController extends Controller
{
    public function __construct(){

    }

    public function index(Request $request,$type){


        $tagTypes = Type::orderBy('orderby','desc')->where('state',1)->where('is_view_ask',1)->get();
//        if($type == 1){
//            dd($type);
        if($type == 1){
            $is_ans = 1;
        }else{
            $is_ans = 0;
        }

        $hotQuestion = CommonAskQuestion::where('is_hot',1)->orderBy('hot_set_time')->limit(1)->first();

        $hot = CommonHotQuestion::orderBy('order_style','desc')->orderBy('id','desc')->select('qid')->first();
        $qidArr = [];
        if($hot){
            $htQuestion = CommonAskQuestion::where('id',$hot->qid)->first();
            $qidArr[] = $hot->qid;
        }else{
            $htQuestion = [];
        }
        if($hotQuestion){
            $qidArr[] = $hotQuestion->id;
            $commonQuestions = CommonAskQuestion::where('is_ans',$is_ans)->whereNotIn('id',$qidArr)->orderBy('updated_at','desc')->paginate(10);
        }else{
            $commonQuestions = CommonAskQuestion::where('is_ans',$is_ans)->whereNotIn('id',$qidArr)->orderBy('updated_at','desc')->paginate(10);
        }

        $data['commonQuestions'] = $commonQuestions;
        $data['hotQuestion'] = $hotQuestion;
        $data['htQuestion'] = $htQuestion;
//        dd($htQuestion);
        $data['type'] = $type;
        $data['hasMore'] = 0;
        $data['tagTypes'] = $tagTypes;
        if($commonQuestions->hasMorePages()){
            $data['hasMore'] = 1;
        }
        return view('commonAsk.index',$data);
    }

    public function cakLoadMore(Request $request){
        $type = $request->input('type');
        $tagId = $request->input('tagid','');

//        if($type == 1){
        if($type == 1){
            $is_ans = 1;
        }else{
            $is_ans = 0;
        }

        if($tagId){
            $commonQuestions = CommonAskQuestion::where('is_ans',$is_ans)->where(function($query) use ($tagId){
                $query->orWhere('type_ids','like',$tagId.',%');
                $query->orWhere('type_ids','like',','.$tagId);
                $query->orWhere('type_ids','like','%,'.$tagId.',%');
                $query->orWhere('type_ids',$tagId);
            })->paginate(10);
//            dd($commonQuestions);
        }else{
            $commonQuestions = CommonAskQuestion::where('is_ans',$is_ans)->orderBy('updated_at','desc')->paginate(10);
        }
//        dd($is_ans);

//        $commonQuestions = $commonQuestions->where('is_ans',$is_ans)->orderBy('updated_at','desc')->paginate(10);
//            dd($commonQuestions);
        $data['commonQuestions'] = $commonQuestions;
        $data['type'] = $type;
        $hasMore = 0;
        if($commonQuestions->hasMorePages()){
            $hasMore = 1;
        }
        return $this->getMessage(0,'获取成功',['body'=>view('commonAsk.body.ask',['commonQuestions'=>$commonQuestions,'type'=>$type])->render(),'hasMore'=>$hasMore]);
//        }else{
//            if($tagId){
//                $commonQuestions = CommonAskAnswer::where('type_ids','like',',%'.$tagId.',')->orWhere('type_ids','like',$tagId.',%')->orWhere('type_ids','like',',%'.$tagId);
//            }else{
//                $commonQuestions = new CommonAskQuestion();
//            }
//            $commonQuestions = $commonQuestions::where('is_ans',0)->orderBy('updated_at','desc')->paginate(10);
//            $data['commonQuestions'] = $commonQuestions;
//            $data['type'] = $type;
//            $hasMore = 0;
//            if($commonQuestions->hasMorePages()){
//                $hasMore = 1;
//            }

//            return $this->getMessage(0,'获取成功',['body'=>view('commonAsk.body.waitAsk',['commonQuestions'=>$commonQuestions,'type'=>$type])->render(),'hasMore'=>$hasMore]);
//        }
    }
    /*
     * 提问页
     */
    public function create(Request $request){
//        dd(3);
        $cid = $request->input('id',0);

        if($cid && in_array($cid,[8,4,24,12,39,68])){
            $user = $request->user();
            if($user){
                $askRecord = CourseActivityAskRecord::where('course_class_id',$cid)->where('user_id',$user->id)->first();
                if(!$askRecord){
                    $askRecord = new CourseActivityAskRecord();
                    $askRecord->course_class_id = $cid;
                    $askRecord->user_id = $user->id;
                    $askRecord->notice_time = time()+60*10;
                    $askRecord->save();
                }
            }
        }
        return view('commonAsk.create',['cid'=>$cid]);
    }

    /*
     *
     */
    public function edit(Request $request){

        return view('commonAsk.edit');
    }
    /*
     * 提交常规问答
     */
    public function createCommonQuestion(Request $request){
        $user = $request->user();
        if(!$user){
            return $this->getMessage(2,'用户未登录');
        }
        $title = $request->input('title');
        $desc = $request->input('desc');
        $user_id = $user->id;
        $img_url = $request->input('img_url');
        $qid = $request->input('qid','');
        $tags = $request->input('tag','');
        $cid = $request->input('cid',0);
        $has_tag = 0;
        if($qid){
            $comQuestion = CommonAskQuestion::where('id',$qid)->first();
        }else{
            $comQuestion = new CommonAskQuestion();
            $comQuestion->tags = $tags;
            $tagsArr = explode(',',$tags);
            $typeIdsArr = [];
            $tagsAddArr = [];
            if($cid){
                $courseTags = [8=>'减脂',4=>'增肌',24=>'肌肉解剖',12=>'普拉提',39=>'孕产',68=>'康复'];
                if(isset($courseTags[$cid]) && in_array($courseTags[$cid],$tagsArr)){
                    $has_tag = 1;
                }
            }
            foreach($tagsArr as $k => $tg){
                $tag = Tags::where('title',$tg)->where('state',1)->first();

                if($tag){
                    $tags = explode(',',$tag->type_ids);
                    array_push($typeIdsArr,$tags);

                }else{
                    $tag = new Tags();
                    $tag->title = $tg;
                    $tag->save();
                }
                $tagsAddArr[$k] = $tag->id;
            }
            $tagIds = implode(',',array_unique($tagsAddArr));
            $typeIds = implode(',',array_unique(array_reduce($typeIdsArr, 'array_merge', array())));
            $comQuestion->tag_ids = $tagIds;
            $comQuestion->type_ids = $typeIds;
        }

        $comQuestion->title = filterSpecialChar($title);
        $comQuestion->desc = filterSpecialChar($desc);
        $comQuestion->user_id = $user_id;
        $comQuestion->img_url = $img_url;

        if($comQuestion->save()){
            if($cid){

                $data['user_id'] = $user_id;
                $data['cid'] = $cid;
                $result = $this->judgeCourseBuy($data);
                if($result && $has_tag){
                    logger()->info($has_tag.'----'.$result);
                    $courseUser = CourseActivityUser::where('user_id',$user_id)->where('course_class_id',$cid)->first();
                    $courseClass = CourseClass::where('id',$cid)->where('state',1)->select('title')->first();

                    if(!$courseUser){
                        $courseUser = new CourseActivityUser();
                        $courseUser->user_id = $user_id;
                        $courseUser->course_class_id = $cid;
                        $courseUser->study_time = time()+86400*2;
                        $courseUser->three_time = time()+86400*3;
                        $courseUser->course_class_id = $cid;
                        $courseUser->save();
                        $courses = Course::where('course_class_id',$cid)->where('state',1)->get();
                        foreach($courses as $course){
                            $courseView = new CourseActivityView();
                            $courseView->user_id = $user_id;
                            $courseView->course_class_id  = $cid;
                            $courseView->course_id = $course->id;
                            $courseView->save();
                        }

                        $studying = new Studying();
                        $studying->user_id = $user_id;
                        $studying->course_class_id = $cid;
                        $studying->save();
                        $askRecord = CourseActivityAskRecord::where('course_class_id',$cid)->where('user_id',$user_id)->where('status',0)->first();
                        if($askRecord){
                            $askRecord->status = 1;
                            $askRecord->save();
                        }
                        $info['openid'] = $user->openid;
                        $info['type']   = 'TEXT';
                        $info['text']   = "恭喜您，成功领取《".$courseClass->title."》课程，点击<a href='http://m.saipubbs.com/user/studying'>我的教室</a>开始学习吧~\n注意：当学习进度为100%时才可以领取其他课程哦~";
                        if(env("IS_LOCAL") == false){
                            event(new WxCustomerMessagePush($info));
                        }

                        $content = '<div class="jump jump2"><div class="text_center pt115"><p class="fz f28 color_gray666 mb30">《'.$courseClass->title.'》</p><p class="f40 color_333 lt pb70">课程领取成功</p><button class="bgcolor_orange fz f28 color_000 border-radius-img" onclick="courseWatch(this)" data-id="'.$cid.'">前往看课</button><p class="fz f20 color_gray999 plr65 pt40 text_left line1">提示：该课程学习进度为100%时，方可领取下一个课程</p></div></div>';
                        return $this->getMessage(3,'课程领取成功',['content'=>$content]);
                    }
                }
            }
            return $this->getMessage(0,'提交成功');
        }else{
            return $this->getMessage(1,'提交失败');
        }
    }

    public function judgeCourseBuy($data){
        $studying = Studying::where('course_class_id',$data['cid'])->where('user_id',$data['user_id'])->select('id')->first();
        if($studying){
            return 0;
        }

        return 1;
    }
    /*
     *删除常规问答
     */
    public function delQuestion(Request $request){
        $qid = $request->input('qid');
        $question = CommonAskQuestion::where('id',$qid)->first();
        if(!$question){
            return $this->getMessage(1,'问题不存在');
        }else{
            $answer = CommonAskAnswer::where('qid',$qid)->select('id')->first();
            if($answer){
                return $this->getMessage(1,'存在答案,不能删除');
            }
            
        }
        $user = $request->user();
        if($user && $user->id == $question->user_id){
            $question->delete();
            return $this->getMessage(0,'删除成功');
        }else{
            return $this->getMessage(1,'非问答用户，无法删除');
        }
    }
    /*
     * 问题回答页面
     */
    public function answer(Request $request,$qid,$order){
        $question = CommonAskQuestion::where('id',$qid)->first();
//        dd($question);
        if(!$question){
            return redirect('/404.html');
        }
        $updated_at = $question->updated_at;
        $views = $question->view + 1;
//        dd($question);
        DB::table('common_ask_questions')->where('id',$qid)->update(['view'=>$views]);
        if($order == 1){
            $answers  = CommonAskAnswer::where('qid',$qid)->orderBy('updated_at','desc')->paginate(10);
        }else{
            $answers = CommonAskAnswer::where('qid',$qid)->orderBy('zan','desc')->paginate(10);
        }

        $hasMore = 0;
        if($answers->hasMorePages()){
            $hasMore = 1;
        }
        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();  //微信分享
//             $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }
        $userid = $request->user()?$request->user()->id:'';
        $data['userid'] = $userid;
        $data['question'] = $question;
        $data['answers'] = $answers;
        $data['order'] = $order;
        $data['hasMore'] = $hasMore;

        return view('commonAsk.answer',$data);
    }

    public function postAnswer(Request $request){
        $qid = $request->input('qid');
        $question = CommonAskQuestion::where('id',$qid)->first();
        if(!$question){
            return $this->getMessage(1,'无此问答');
        }
        $questionUser = User::where('id',$question->user_id)->select('openid')->first();
        $user = $request->user();
        if(!$user){
            return $this->getMessage(2,'请先登录');
        }
        $title = $request->input('title','');
        $content = $request->input('content');
        $imgurl_list = $request->input('img_url');
        $aid = $request->input('aid','');
        $answerName = $user->name?$user->name:$user->nickname;
        if($aid){
            $answer = CommonAskAnswer::where('id',$aid)->first();
        }else{
            $answer = new CommonAskAnswer();
        }
        $user_id = $user->id;
        $author_id = $question->user_id;
        $answer->title = $title;
        $answer->content = filterSpecialChar($content);
        $answer->imgurl_list = $imgurl_list;
        $answer->qid = $qid;
        $answer->user_id = $user_id;
        $answer->author_id = $author_id;
        $question->is_ans = 1;
        $question->save();
        if($answer->save()){

            $dataInfo['type'] = WxMessageType::ASKFEEDBACK;//问答提问通知
            $dataInfo['url'] = 'http://m.saipubbs.com/cak/answer/'.$qid."/1.html";//问答地址
            $dataInfo['notice'] = $answerName.'解答了你的提问~';
            $dataInfo['message']['key1'] = $question->title;
            $dataInfo['message']['key2'] = mb_strlen($question->desc) >20 ? mb_substr($question->desc, 0,20, "utf-8")."..." : $question->desc;
            $dataInfo['message']['remark'] = "点击赶快查阅吧~";
            $dataInfo['openid'] = $questionUser->openid;
            if(env('IS_LOCAL') == false){
                event(new WxMessagePush($dataInfo));
            }
            return $this->getMessage(0,'提交成功');
        }else{
            return $this->getMessage(1,'提交失败');
        }
    }
    /*
     * 加载更多答案
     */
    public function loadAnswer(Request $request){
        $qid = $request->input('qid','');
        $answers  = CommonAskAnswer::where('qid',$qid)->orderBy('updated_at','desc')->paginate(10);
        $hasMore = 0;
        if($answers->hasMorePages()){
            $hasMore = 1;
        }
        return $this->getMessage(0,'获取成功',['body'=>view('commonAsk.body.loadAnswer',['answers'=>$answers])->render(),'hasMore'=>$hasMore]);
    }

    /*
     * 常规问答
     */
    public function commComment(Request $request,$aid){
//        $aid = $request->input('aid');
        $answer = CommonAskAnswer::where('id',$aid)->first();
//        dd($answer);
        $answer->view += 1;
        $answer->save();
        $user_id = $request->user()?$request->user()->id:'';
        $mobile = $request->user()?$request->user()->mobile:'';
        $question = CommonAskQuestion::where('id',$answer->qid)->first();
        $comments = CommonAskComment::where('aid',$aid)->where('level',1)->orderBy("created_at","desc")->paginate(3);
        $zan = CommonAskZan::where('user_id',$user_id)->where('aid',$aid)->where('type',0)->select('id')->first();
        $help = CommonAskZan::where('user_id',$user_id)->where('aid',$aid)->where('type',1)->select('help')->first();
        if($help){
            if($help->help == 0){
                $isHelp = 0;
            }else{
                $isHelp = 1;
            }
        }else{
            $isHelp = 1;
        }
        $collect = CommonAskZan::where('user_id',$user_id)->where('aid',$aid)->where('type',2)->select('id','collect')->first();
        if($collect){
            if($collect->collect == 0){
                $isCollect = 0;
            }else{
                $isCollect = 1;
            }
        }else{
            $isCollect = 0;
        }
//        dd($user_id);
        $sumZan = CommonAskZan::where('aid',$aid)->select('id')->count();
        $data['answer'] = $answer;
        $data['comments'] = $comments;
        $data['question'] = $question;
        $data['user_id'] = $user_id;
        $data['mobile'] = $mobile;
        $data['user'] = $request->user()?$request->user():'';
        $data['zan'] = $zan;
        $data['sumZan'] = $sumZan;
        $data['isHelp'] = $isHelp;
        $data['isCollect'] = $isCollect;
        return view('commonAsk.comments',$data);
    }

    /*
     *
     */
    public function loadMoreComment(Request $request){
        $user_id = $request->user()?$request->user():'';
        $num = 3;
        $aid = $request->input("aid");
        $page = $request->input("page");
        $can  = $request->input("can",1);
        $offset = $num *($page - 1);
        $comment = CommonAskComment::where("aid",$aid)->where('level',1)->orderBy("created_at","desc")->paginate(3);
        $hasMore = 0;
        if($comment->hasMorePages()){
            $hasMore = 1;
        }
        return json_encode(['code'=>0,'body'=>view('commonAsk.body.loadComment',['comment'=>$comment, "can"=>$can,'user_id'=>$user_id])->render(),'hasMore'=>$hasMore]);
    }
    /*
     * 添加评论
     */
    public function addComment(Request $request){
        $con = filterSpecialChar($request->input('con',''));
        $aid = $request->input('aid');
        $cid = $request->input('cid','');
        $com_id = $request->input('comid','');
        $answer = CommonAskAnswer::where('id',$aid)->first();
        $push_user = $request->input('push_user',0);
        if(!$answer){
            return $this->getMessage(1,'答案不存在');
        }
        $question = CommonAskQuestion::where('id',$answer->qid)->first();
        $user_id = $request->user()?$request->user()->id:'';
        $comment = new CommonAskComment();
        $comment->aid = $aid;
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
        if($cid > 0){
            $comment->level = 2;
        }
        $comment->cid = $cid;
        $data['user'] = $request->user();
        if($comment->save()){

            $dataInfo['type'] = WxMessageType::ASKFEEDBACK;//问答提问通知
            $dataInfo['url'] = 'http://m.saipubbs.com/cak/comment/'.$aid.".html";//问答地址
            $comName = $request->user()->name?$request->user()->name:$request->user()->nickname;
            if($cid){
                $bComment = CommonAskComment::where('id',$cid)->first();
                $bUser = User::where('id',$push_user)->first();

                $dataInfo['notice'] = $comName.'回复了你~';
                $dataInfo['message']['key1'] = $question->title;
                $dataInfo['message']['key2'] = mb_strlen($bComment->content) >20 ? mb_substr($bComment->content, 0,20, "utf-8")."..." : $bComment->content;
                $dataInfo['message']['remark'] = "点击赶快查阅吧~";
                $dataInfo['openid'] = $bUser->openid;
            }else{
                $bUser = User::where('id',$answer->user_id)->first();
                $dataInfo['notice'] = $comName.'评论了你~';
                $dataInfo['message']['key1'] = $question->title;
                $dataInfo['message']['key2'] = mb_strlen($answer->content) >20 ? mb_substr($answer->content, 0,20, "utf-8")."..." : $answer->content;
                $dataInfo['message']['remark'] = "点击赶快查阅吧~";
                $dataInfo['openid'] = $bUser->openid;
            }

            if(env('IS_LOCAL') == false){
                event(new WxMessagePush($dataInfo));
            }
            return $this->getMessage(0,'评论成功',['body'=>view('commonAsk.body.commentReply',['cid'=>$cid,'comment'=>$comment,'user_id'=>$user_id])->render()]);

        }else{
            return $this->getMessage(1,'评论失败');
        }
    }

    /*
     * 删除回复
     */
    public function delCommentReply(Request $request){
        $cid = $request->input('cid','');
        $user = $request->user();
        if(!$user){
            return $this->getMessage(1,'用户未登录');
        }
        $comment = CommonAskComment::where('id',$cid)->where('user_id',$user->id)->first();
        if(!$comment){
            return $this->getMessage(1,'无此评论');
        }
        $replyComment = CommonAskComment::where('replyed_id',$cid)->select('id')->first();
        if($replyComment){
            return $this->getMessage(1,'被评论，不能删除');
        }

        if($comment->delete()){
            return $this->getMessage(0,'删除成功');
        }else{
            return $this->getMessage(1,'删除失败');
        }
    }

    public function modifyAnswer(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        $answer = new CommonAskAnswer();
        $update = $request->input("update")?$request->input("update"):0;
        if($update == 1){
            $aid = $request->input("aid");
            $answer = $answer->where("id",$aid)->first();
        }
        $qid = $request->input("qid");
        $title = $request->input("title");
        $content = $request->input("content");
        $author = $request->input("author");
        $imgurl_list = $request->input("imgurl_list");

        $content = filterSpecialChar($content); //过滤字符

        $answer->qid = $qid;
        $answer->title = $title;
        $answer->content = $content;
        $answer->user_id = $userid;
        //$answer->zan = rand(400,1000);
        $answer->author_id = $author;
        $answer->imgurl_list = $imgurl_list;

        $re = $answer->save();

        if($re){
            $user_avatar = get_teacher_name($userid)->avatar;
            if(strpos($user_avatar,'http') !== false){
                $user_avatar = $user_avatar;
            }else{
                $user_avatar = env('IMG_URL').$user_avatar;
            }
            $insert_id = $answer->id;
            return json_encode(['code'=>0,"id"=>$insert_id,"avatar" =>$user_avatar]);
        }else{
            return json_encode(["code"=>1]);
        }
    }

    public function delAnswer(Request $request){
        $answer_id =  $request->input("answer_id")?$request->input("answer_id"):0;
        if($answer_id == 0){
            $qid = $request->input("qid");
            $re = CommonAskQuestion::where("id",$qid)->delete();
        }else{
            $re = CommonAskAnswer::where("id",$answer_id)->delete();
        }

        if($re){
            return json_encode(['code'=>0]);
        }else{
            return json_encode(['code'=>1]);
        }
    }

    public function addAskAgree(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
            $teacher = 0;
        }

        $aid = $request->input("aid");
        $type = $request->input('type',0);
        if($type==0){
            $zan  = CommonAskZan::where('user_id',$userid)->where('type',0)->where('aid',$aid)->first();
            if($zan){
                return $this->getMessage(1,'已赞');
            }
            $zan = new CommonAskZan();
            $zan->user_id = $userid;
            $zan->aid = $aid;
            $re = $zan->save();
            if($re){
                CommonAskAnswer::where("id",$aid)->increment('zan');
                return $this->getMessage(0,'成功');
            }else{
                return $this->getMessage(1,'失败');
            }
        }elseif($type == 1){
            $zan  = CommonAskZan::where('user_id',$userid)->where('type',1)->where('aid',$aid)->first();
            if($zan){
                if($zan->help == 0){
                    $help = 1;
                }else{
                    $help = 0;
                }
            }else{
                $help = 0;
                $zan = new CommonAskZan();
            }

            $zan->user_id = $userid;
            $zan->aid = $aid;
            $zan->type = $type;
            $zan->help = $help;
            $re = $zan->save();
            if($re){
                return $this->getMessage(0,'成功');
            }else{
                return $this->getMessage(1,'失败');
            }
        }elseif($type == 2){
            $zan  = CommonAskZan::where('user_id',$userid)->where('type',$type)->where('aid',$aid)->first();
            if($zan){
                if($zan->collect == 0){
                    $collect = 1;
                }else{
                    $collect = 0;
                }
            }else{
                $collect = 1;
                $zan = new CommonAskZan();
            }

            $zan->user_id = $userid;
            $zan->aid = $aid;
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


    /*
     *
     */
    public function getTags(Request $request){
        $title = $request->input('keyword','');
        if(empty($title)){
            return ;
        }
        $tags = Tags::where('title','like','%'.$title.'%')->where('state',1)->get();
        $tagsArr = [];
        foreach($tags as $k => $tag){
            $tagsArr[$k]['name'] = $tag->title;
        }

        return $this->getMessage(0,'获取成功',['tags'=>$tagsArr]);
    }

    /*
     *常规问答举报
     */
    public function answerComplain(Request $request){
        $type = $request->input('type');
        $aid = $request->input('aid','');
        $user = $request->user();
        if(!$user){
            return $this->getMessage(1,'请先登录');
        }
        if(empty($aid)){
            return $this->getMessage(1,'举报失败');
        }
        $complain = CommonAskAnswerComplain::where('user_id',$user->id)->where('type',$type)->where('aid',$aid)->select('id')->first();
        if($complain){
            return $this->getMessage(1,'已举报');
        }
        $complain = new CommonAskAnswerComplain();
        $complain->user_id = $user->id;
        $complain->type = $type;
        $complain->aid = $aid;
        if($complain->save()){
            return $this->getMessage(0,'举报成功');
        }else{
            return $this->getMessage(1,'举报失败');
        }
    }

    public function searchAsk(Request $request,$tagId){
        $tag = Tags::where('id',$tagId)->select('title')->first();
        $questions = CommonAskQuestion::where(function($query) use ($tagId){
            $query->orWhere('tag_ids','like',$tagId.',%');
            $query->orWhere('tag_ids','like',','.$tagId);
            $query->orWhere('tag_ids','like','%,'.$tagId.',%');
            $query->orWhere('tag_ids',$tagId);
        })->orderBy('id','desc')->paginate(10);
        if($questions->hasMorePages()){
            $data['hasMore'] = 1;
        }else{
            $data['hasMore'] = 0;
        }
        $data['title'] = $tag->title;
        $data['questions'] = $questions;
        $data['tagId'] = $tagId;
        return view('commonAsk.search',$data);
    }

    public function searchAskByTag(Request $request){
        $tagId = $request->input('tagId');

        $tag = Tags::where('id',$tagId)->select('title')->first();
        $questions = CommonAskQuestion::where(function($query) use ($tagId){
            $query->orWhere('tag_ids','like',$tagId.',%');
            $query->orWhere('tag_ids','like',','.$tagId);
            $query->orWhere('tag_ids','like','%,'.$tagId.',%');
            $query->orWhere('tag_ids',$tagId);
        })->orderBy('id','desc')->paginate(10);
        $data['title'] = $tag->title;
        $data['questions'] = $questions;
        $data['tagId'] = $tagId;
        if($questions->hasMorePages()){
            $hasMore = 1;
        }else{
            $hasMore = 0;
        }
        return $this->getMessage(0,'获取成功',['body'=>view('commonAsk.body.search',$data)->render(),'hasMore'=>$hasMore]);
    }

    /*
     * 生成分享海报
     */
    public function shareComment(Request $request,$aid){
        $questionArr = [];
        $answerArr = [];
        $qrowStr = 18;
        $arowStr = 21;

        $answer = CommonAskAnswer::where('id',$aid)->first();

        $user = $request->user();
        if($user){
            $name = $user->name?$user->name:$user->nickname;
        }else{
            $name = '';
        }
        if(!$answer){
            return $this->getMessage(0,'问题不存在');
        }
        $question = CommonAskQuestion::where('id',$answer->qid)->first();
        $questionTitle = $question->title;
        $answerTitle = str_replace(PHP_EOL, '',strip_tags($answer->content));
        $qlength = mb_strlen($questionTitle);
        $alength = mb_strlen($answerTitle);
        if($qlength <= $qrowStr){
            $questionArr[] = $questionTitle;
        }else{

            $rowNum = ceil($qlength/$qrowStr);
            for($i = 0; $i < $rowNum;$i++){
                if($i > 1){
                    $questionArr[1] = mb_substr($questionArr[1],0,$qrowStr-1).'...';
                    break;
                }
                $questionArr[$i] = mb_substr($questionTitle,$i*$qrowStr,$qrowStr);
            }
        }
        if($alength <= $arowStr){
            if(empty($answerTitle)){
                $answerArr[] = '暂无回答';
            }else{
                $answerArr[] = $answerTitle;
            }
        }else{
            $rowNum = ceil($alength/$arowStr);
            for($i = 0; $i < $rowNum;$i++){
                if($i > 4){
                    $answerArr[4] = mb_substr($answerArr[4],0,$arowStr-1).'...';
                    break;
                }
                $answerArr[$i] = mb_substr($answerTitle,$i*$arowStr,$arowStr);
            }
        }
        $commInfo['questionArr'] = $questionArr;
        $commInfo['answerArr'] = $answerArr;
//        dd($commInfo);
        // $shareCode = "http://api.k780.com:88/?app=qr.get&data=http://m.saipubbs.com/cak/comment/".$answer->id.'.html';
        $shareCode = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=http://m.saipubbs.com/cak/comment/".$answer->id.'.html';
        $destDirectory = "/upload/wxqrcode/";
        if (!file_exists(public_path().'/'.$destDirectory)) {
            $fileDir = mkdir(public_path().'/'.$destDirectory,0777,true);
        }else{
            $fileDir = public_path().'/'.$destDirectory;
        }
        $bodyPic = "/images/ask/fenimg1.jpg";
        $file = time().rand(1000,9999).".png";
        $r = $this->getImage($shareCode,$fileDir, $file);
        $wechatCodeArr = $destDirectory.$r['file_name'];
        $imageThumb  = new MakeThumbPic();
//        dd($wechatCodeArr);
//        dd($name);
        $activity = 8;
        $img_url = $imageThumb->makePic($bodyPic, '', $wechatCodeArr,'upload/share/',$name,$activity,$commInfo);
        $shareUrl = 'http://m.saipubbs.com/'.$img_url[1];
//        echo "<img src='http://m.saipubbs.com/".$img_url[1]."'/>";
//        dd($img_url);
        return view('commonAsk.share',['shareCode'=>$shareUrl]);
    }

    /*
     * 生成图片
     */
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
}