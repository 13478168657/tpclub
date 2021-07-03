<?php

namespace App\Http\Controllers\Ask;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\AskSpecial;
use App\Models\AskQuestion;
use App\Models\AskAnswer;
use App\Models\Ask_zan;
use App\Models\AskComment;
use App\Constant\WxMessageType;
use App\Events\WxMessagePush;

class AskController extends Controller
{

    public function special(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        $data = AskSpecial::whereNull("deleted_at")->get();

        $this->ret['user_id'] = $userid;
        $this->ret['special'] = $data;

        return view("ask.special",$this->ret);
    }
    /**
     * 已回答
     */
    public function index(Request $request,$sid)
    {
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }
        $special = AskSpecial::where("id",$sid)->first();
        $teacher = Users::where("id",$special->user_id)->select("id","nickname","avatar","name","introduction")->first();

        //已回答问题
        $question = AskQuestion::where("is_ans",1)->where("special_id",$sid)->where("is_question",1)->orderBy("created_at","desc")->limit(5)->get();
        $this->ret['user_id'] = $user_id;
        $this->ret['teacher'] = $teacher;
        $this->ret['special'] = $special;
        $this->ret['question'] = $question;
        $can = 0;
        $course_class = [];
        $group_class = [];
        if($special->is_open==0){
            if($special->course_class_ids){
                $course_class_id_arr = explode(',', $special->course_class_ids);
                //关联的单一课程
                $course_class = DB::select("select id,title  from course_class where id in ({$special->course_class_ids})");
                $order = DB::table("order")->where("user_id", $user_id)->where("state",1)->select("id", "user_id")->get();
                if($order){
                    foreach($order as $o){
                        if(in_array($o->id, $course_class_id_arr)){
                            $can =1;
                            break;
                        }
                    }
                }
            }
                
            if($can==0){
                
                if($special->course_class_group_ids){
                    
                    $course_group_id_arr =  explode(',', $special->course_class_group_ids);
                    //关联的组合课程
                    $group_class  = DB::select("select id,title  from course_class_group where id in ({$special->course_class_group_ids})");
                    
                    $gorder = DB::table("order_course_class_group")->where("user_id", $user_id)->where("state",1)
                              ->select("id", "course_class_group_id")->get();
                            
                    if($gorder){
                        foreach($gorder as $g){
                            if(in_array($g->course_class_group_id, $course_group_id_arr)){
                                $can =1;
                                break;
                            }
                        }
                    } 
                }
            }
        }else{
            $can = 1;
        }
        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();  //微信分享
        }
        $this->ret['course_class'] = $course_class;
        $this->ret['group_class']  = $group_class;   
        $this->ret['can'] = $can;
        return view("ask.index",$this->ret);
    }

    public function loadmorequestion(Request $request){
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }
        $sid = $request->input("sid");
        $page = $request->input("page");
        $num = 5;
        $offset = $num *($page - 1);
        $question = AskQuestion::where("is_ans",1)->where("special_id",$sid)->where("is_question",1)->orderBy("created_at","desc")->skip($offset)->take($num)->get();


        return json_encode(['code'=>0,'body'=>view('ask.body.answeredbody',['question'=>$question])->render()]);
    }

    /**
     * 学生提问题
     */
    public function question(Request $request,$sid)
    {
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }
        $special = AskSpecial::where("id",$sid)->first();
        $teacher = Users::where("id",$special->user_id)->select("id","nickname","avatar","name","introduction")->first();

        //待回答问题
        $question = AskQuestion::where("is_ans",0)->where("special_id",$sid)->where("is_question",1)->orderBy("created_at","desc")->limit(10)->get();
        $this->ret['user_id']  = $user_id;
        $this->ret['teacher']  = $teacher;
        $this->ret['special']  = $special;
        $this->ret['question'] = $question;
        $can = 0;
        $course_class = [];
        $group_class  = [];
        if($special->is_open==0){
            if($special->course_class_ids){
                $course_class_id_arr = explode(',', $special->course_class_ids);
                //关联的单一课程
                $course_class = DB::select("select id,title  from course_class where id in ({$special->course_class_ids})");
                $order = DB::table("order")->where("user_id", $user_id)->where("state",1)->select("id", "user_id")->get();
                if($order){
                    foreach($order as $o){
                        if(in_array($o->id, $course_class_id_arr)){
                            $can =1;
                            break;
                        }
                    }
                }
            }

            if($can==0){
                if($special->course_class_group_ids){
                    $course_group_id_arr =  explode(',', $special->course_class_group_ids);
                    //关联的组合课程
                    $group_class  = DB::select("select id,title  from course_class_group where id in ({$special->course_class_group_ids})");
                    
                    $gorder = DB::table("order_course_class_group")->where("user_id", $user_id)->where("state",1)
                              ->select("id", "course_class_group_id")->get();
                    if($gorder){
                        foreach($gorder as $g){
                            if(in_array($g->course_class_group_id, $course_group_id_arr)){
                                $can =1;
                                break;
                            }
                        }
                    } 
                }
            }
        }else{
            $can = 1;
        }
        $this->ret['course_class']  = $course_class;
        $this->ret['group_class']   = $group_class;   
        $this->ret['can'] = $can;
        return view("ask.question",$this->ret);
    }

    /**
     *
     */
    public function field(Request $request,$sid)
    {
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }
        $special = AskSpecial::where("id",$sid)->first();
        if(count($special) > 0){
            $teacher = Users::where("id",$special->user_id)->select("id","nickname","avatar","name","introduction")->first();
        }else{
            $teacher = [];
        }


        //作业
        $question = AskQuestion::where("is_question",0)->where("special_id",$sid)->orderBy("created_at","desc")->get();

        $can = 0;
        if($special->is_open==0){
            if($special->course_class_ids){
                $course_class_id_arr = explode(',', $special->course_class_ids);
                //关联的单一课程
                $course_class = DB::select("select id,title  from course_class where id in ({$special->course_class_ids})");
                $this->ret['course_class'] = $course_class;
                $order = DB::table("order")->where("user_id", $user_id)->where("state",1)->select("id", "user_id")->get();
                if($order){
                    foreach($order as $o){
                        if(in_array($o->id, $course_class_id_arr)){
                            $can =1;
                            break;
                        }
                    }
                }
            }else{
                $this->ret['course_class'] = [];
            }
            if($can==0){
                if($special->course_class_group_ids){
                    $course_group_id_arr =  explode(',', $special->course_class_group_ids);
                    //关联的组合课程
                    $group_class  = DB::select("select id,title  from course_class_group where id in ({$special->course_class_group_ids})");
                    $this->ret['group_class'] = $group_class;
                    $gorder = DB::table("order_course_class_group")->where("user_id", $user_id)->where("state",1)
                          ->select("id", "course_class_group_id")->get();
                    if($gorder){
                        foreach($gorder as $g){
                            if(in_array($g->course_class_group_id, $course_group_id_arr)){
                                $can =1;
                                break;
                            }
                        }
                    }
                }else{
                    $this->ret['group_class'] = [];
                }          
            }
        }else{
            $can = 1;
        }
        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();  //微信分享
        }
        $this->ret['can']     = $can;
        $this->ret['sid']     = $sid;
        $this->ret['user_id'] = $user_id;
        $this->ret['teacher'] = $teacher;
        $this->ret['special'] = $special;
        $this->ret['question'] = $question;

        return view("ask.field",$this->ret);
    }

    /**
     * 保存问题
     */
    public function creates(Request $request)
    {

        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        $question = new AskQuestion();
        $update = $request->input("update")?$request->input("update"):0;
        if($update == 1){
            $qid = $request->input("qid");
            $question = $question->where("id",$qid)->first();
        }
        $sid = $request->input("sid");
        $title = $request->input("title");
        $desc = $request->input("desription");
        $imgurl_list = $request->input("imgurl_list");

        $desc = filterSpecialChar($desc);   //过滤特殊字符

        $question->special_id = $sid;
        $question->user_id = $userid;
        $question->title = $title;
        $question->description = $desc;
        $question->view     = rand(100,800);
        $question->imgurl_list     = $imgurl_list;
        $re = $question->save();

        if($re){
            return json_encode(['code'=>1]);
        }else{
            return json_encode(["code"=>0]);
        }



    }


    /**
     * 加载更多作业
     */
    public function loadmore(Request $request)
    {
        $num = 10;
        $sid = $request->input("sid");
        $page = $request->input("page");
        $can  = $request->input("can", 0);
        $is_question = $request->input("is_question");
        $offset = $num *($page - 1);
        $quesstion = AskQuestion::where("is_question",$is_question)->where("special_id",$sid)->orderBy("created_at","desc")->skip($offset)->take($num)->get();

        if(count($quesstion) > 0){
           foreach ($quesstion as $v) {
               if($is_question == 0) {
                    $ans_num = DB::table("ask_answer")->where("qid", $v->id)->count();                                //回答数量
                    $approve_num = DB::table("ask_answer")->where("qid", $v->id)->where("is_approve", 1)->count();    //认可数量
                    $v->ans_num = $ans_num;
                    $v->approve_num = $approve_num;
               }
           }
        }

        return json_encode(['code'=>1,'body'=>view('ask.body.questionbody',['question'=>$quesstion,'is_question'=>$is_question, "can"=>$can])->render()]);
    }

    /**
     *作业详情页
     *$can 是否有权限回答
     *$zid 作业id
     *$order  排序方式
     */
    public function zuoye(Request $request,$zid,$order,$can=1)
    {
        if($request->user()){
            $user_id    = $request->user()->id;
        }else{
            $user_id = 0;
        }
        $this->ret['order'] = $order;
        if($order == 1){
            $order = "created_at";
        }else{
            $order = "zan";
        }
        $update  = AskQuestion::where("id", '=', $zid)->increment("view", 1);  //增加阅读量
        $detail  = AskQuestion::where("id",$zid)->first();
        $answer  = AskAnswer::where("qid",$zid)->orderBy($order,"desc")->whereNull("deleted_at")->take(10)->get();
        $count   = AskAnswer::where("qid",$zid)->where("user_id",$user_id)->whereNull("deleted_at")->count();
        $users   = Users::where("id",$user_id)->select("name","avatar","nickname","introduction")->first();
        
        $this->ret['can'] = $can;
        $this->ret['detail'] = $detail;
        $this->ret['answer'] = $answer;
        $this->ret['users'] = $users;
        $this->ret['user_id'] = $user_id;
        $this->ret['count'] = $count;
        return view("ask.zuoye",$this->ret);
    }

    public function answer(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        $answer = new AskAnswer();
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
            return json_encode(['code'=>1,"id"=>$insert_id,"avatar" =>$user_avatar]);
        }else{
            return json_encode(["code"=>0]);
        }

    }

    /**
     * 作业详情页
     */

    public function zuoyedetail(Request $request,$zid,$aid, $can=1){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        //dd($userid);
        $update = AskAnswer::where("id", '=', $aid)->increment("view", 1);  //增加阅读量
        $ask = AskQuestion::where("id",$zid)->first();
        $answer = AskAnswer::where("id",$aid)->first();
        $comment = AskComment::where("aid",$aid)->where("level","1")->orderBy("created_at","desc")->limit(3)->get();
        $users = Users::where("id",$userid)->select("name","avatar","nickname")->first();

        $this->ret['can']      = $can;
        $this->ret['question'] = $ask;
        $this->ret['answer']   = $answer;
        $this->ret['user_id']  = $userid;
        $this->ret['comment']  = $comment;
        $this->ret['users'] = $users;
        return view("ask.zuoyedetail",$this->ret);
    }

    /*
     * 作业问答详情
     */
    public function zuoyewendaDetail(Request $request,$zid ,$aid,$can=1){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        //dd($userid);
        $update = AskAnswer::where("id", '=', $aid)->increment("view", 1);  //增加阅读量
        $ask = AskQuestion::where("id",$zid)->first();
        $answer = AskAnswer::where("id",$aid)->first();
        $comment = AskComment::where("aid",$aid)->where("level","1")->orderBy("created_at","desc")->limit(3)->get();
        $users = Users::where("id",$userid)->select("name","avatar","nickname")->first();

        $this->ret['can']      = $can;
        $this->ret['question'] = $ask;
        $this->ret['answer']   = $answer;
        $this->ret['user_id']  = $userid;
        $this->ret['comment']  = $comment;
        $this->ret['users'] = $users;
        return view("ask.zuoyewendadetail",$this->ret);
    }

    /*
     * 点赞
     */
    public function zan(Request $request){

        if($request->user()){
            $userid = $request->user()->id;
            $teacher = $request->user()->is_author;
        }else{
            $userid = 0;
            $teacher = 0;
        }

        $aid = $request->input("aid");

        $zan = new Ask_zan();
        $zan->user_id = $userid;
        $zan->aid = $aid;
        $re = $zan->save();
        if($re){
            AskAnswer::where("id",$aid)->increment('zan');
            if($teacher > 0){
                AskAnswer::where("id",$aid)->update(['is_approve'=>1]);
            }
            return json_encode(['code'=>1]);
        }else{
            return json_encode(['code'=>0]);
        }



    }
    /**
     * 回复评论
     */
    public function comment(Request $request){

        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        $con = $request->input("con");
        $aid = $request->input("aid");
        $cid = $request->input("cid");
        $con = filterSpecialChar($con);   //过滤特殊字符串
        $comment = new AskComment();
        $comment->content = $con;
        $comment->aid = $aid;
        $comment->user_id = $userid;
        if($cid > 0){
            $comment->level = 2;
        }
        $comment->cid = $cid;
        $re = $comment->save();
        $insert_id = $comment->id;
        if($re){
            $answer  = DB::table("ask_answer")->where("id", $aid)->select("user_id","title","qid", "author_id")->first();
            $user    = DB::table("users")->where("id", $answer->user_id)->select("openid")->first();
            if($answer->author_id==$userid && $request->user() && $user->openid){
                $dataInfo['type'] = WxMessageType::ASKCOMMENT;//
                $dataInfo['url'] = 'http://m.saipubbs.com/ask/zuoyedetail/'.$answer->qid."/".$aid."/1.html";//问答地址
                $dataInfo['notice'] = '你提交的作业得到老师的点评了~';
                $dataInfo['message']['key1'] = $request->user()->nickname;
                $dataInfo['message']['key2'] = $answer->title;
                $dataInfo['message']['key3'] = mb_strlen($con) >20 ? mb_substr($con, 0,20, "utf-8")."..." : $con;
                $dataInfo['message']['remark'] = "点击赶快查阅吧~";
                $dataInfo['openid'] = $user->openid;
                if(env('IS_LOCAL') == false){
                    event(new WxMessagePush($dataInfo));
                }
            }
            
            return json_encode(['code'=>1,'id'=>$insert_id]);
        }else{
            return json_encode(['code'=>0]);
        }


    }
    /*
     * 加载更多评论
     */
    public function morecomment(Request $request)
    {
        $num = 3;
        $aid = $request->input("answer_id");
        $page = $request->input("page");
        $can  = $request->input("can");
        $offset = $num *($page - 1);
        $comment = AskComment::where("aid",$aid)->orderBy("created_at","desc")->skip($offset)->take($num)->get();

        return json_encode(['code'=>0,'body'=>view('ask.body.askbody',['comment'=>$comment, "can"=>$can])->render()]);
    }

    /**
     * 加载更多回答
     */
    public function moreanswer(Request $request)
    {
        $num = 10;
        $aid = $request->input("qid");
        $page = $request->input("page");
        $order = $request->input("order");
        $can = $request->input("can");
        if($order == 1){
            $order = "created_at";
        }else{
            $order = "zan";
        }
        $offset = $num *($page - 1);
        $answer = AskAnswer::where("qid",$aid)->orderBy($order,"desc")->skip($offset)->take($num)->get();

        return json_encode(['code'=>0,'body'=>view('ask.body.moreanswer',['answer'=>$answer,'can'=>$can])->render()]);
    }

    /**
     * 删除回答
     */
    public function delanswer(Request $request){
        $answer_id =  $request->input("answer_id")?$request->input("answer_id"):0;
        if($answer_id == 0){
            $qid = $request->input("qid");
            $re = AskQuestion::where("id",$qid)->delete();
        }else{
            $re = AskAnswer::where("id",$answer_id)->delete();
        }

        if($re){
            return json_encode(['code'=>1]);
        }else{
            return json_encode(['code'=>0]);
        }
    }

    /**
     * 更新导师认可
     */
    public function updatedata(){
        $users = Ask_zan::select("user_id","aid")->get();
        $arr = array();
        foreach($users as $v){
            $is_author = Users::where("id",$v->user_id)->select("is_author")->first();
            if($is_author->is_author > 0){
                $arr[] = $v->aid;
            }
        }
        $re = AskAnswer::whereIn("id",$arr)->update(['is_approve'=>1]);
        dd($re);

    }

    //搜索作业
    public function selectzuoye(Request $request){
        $mobile = $request->input("mobile","");
        if($mobile){
            $aid = Users::where("mobile",$mobile)->select("id")->first();
            if($aid){
                $answer = AskAnswer::where("user_id",$aid->id)->get();
                $this->ret['answer'] = $answer;
            }else{
                $this->ret['answer'] = '';
            }
        }else{
            $this->ret['answer'] = '';
        }

        $this->ret['mobile'] = $mobile;
        return view("ask.result.index",$this->ret);
    }


    public function zhuanlun(Request $request){


        return view('course.zhuanlun');
    }


}
