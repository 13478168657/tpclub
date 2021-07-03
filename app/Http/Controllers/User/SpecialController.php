<?php

namespace App\Http\Controllers\User;

use App\Models\Special;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\Users;
use App\Models\UsersAttribute;
use App\Models\Follow;
use App\Models\Mycoupon;
use App\Models\ArticleCollect;
use App\Models\Article;
use App\Models\Collect;
use Illuminate\Support\Facades\DB;
use App\Utils\FileUploader;
use App\Events\WxCustomerMessagePush;
use App\Constant\CustomerPushType;
use App\Utils\WxMessagePush as WxPush;
use App\Models\AskSpecial;
use App\Models\AskQuestion;
use App\Models\AskAnswer;
use App\Models\Courseclass;
use App\Models\CourseClassGroup;
use App\Constant\WxMessageType;
use App\Events\WxMessagePush;
use Illuminate\Support\Facades\Redis;

class SpecialController extends Controller
{
    protected $ret;
    public function __construct()
    {
        $this->ret = [];
    }

    protected function decodeUnicode($str) 
    {
    //    $str = str_replace("null",'""',$str);
        $str = str_replace("font-size",'font_size',$str);
        $str = str_replace("font-color",'font_color',$str);
        return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', create_function('$matches', 'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'), $str);
    }

    //问答专区列表
    //20190320
    public function askSpecials(Request $request){

        $array = [
            [   "view"=>3600,
                "ititle"=>"问题问题问题问题",
                "iid"=>"1580",
                "ct_a"=>"360", 
                "iuser"=>[ 
                        array("uid"=>508,"uheadImg"=>"用户头像", "uname"=>"小张"), 
                        array("uid"=>508,"uheadImg"=>"用户头像", "uname"=>"小张")], 
                "itime"=>"2019-04-05 12:25:25"
            ],
            [   "view"=>3600,
                "ititle"=>"问题问题问题问题",
                "iid"=>"1580",
               "ct_a"=>"360", 
                "iuser"=>[ 
                        array("uid"=>508,"uheadImg"=>"用户头像", "uname"=>"小张"), 
                       array("uid"=>508,"uheadImg"=>"用户头像", "uname"=>"小张")], 
                "itime"=>"2019-04-05 12:25:25"
            ],
           
        ];
        //echo "<pre>";
        // echo $this->decodeUnicode(json_encode(array("code"=>1,"list"=>$array)));
        // return;
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }
        //echo $user_id;
        $model  = new AskSpecial();
        $list   = $model->where("user_id",$user_id)->select("id", "title", "author", "description", "user_id","is_open")->orderBy("id", "desc")->take(20)->get()->toArray();

         //所有单一课程
        if(Redis::exists("all_course_class") && Redis::get("all_course_class") != ""){
            $courseClass_json = Redis::get("all_course_class");
            $courseClass      = json_decode($courseClass_json);
        }else{
            $courseClass = DB::table("course_class")->whereNull("deleted_at")
                           ->where("is_hide", 0)->where("state", 1)->select("id", "title")->get();
            $courseClass_json = json_encode($courseClass);
            Redis::setex("all_course_class", 7200, $courseClass_json);
        }
        
        //所有组合课程
        if(Redis::exists("all_course_class_group") && Redis::get("all_course_class_group") != ""){
            $CourseClassGroup_json = Redis::get("all_course_class_group");
            $CourseClassGroup      = json_decode($CourseClassGroup_json);
        }else{
            $CourseClassGroup = DB::table("course_class_group")->whereNull("deleted_at")->select("id", "title")->get();
            $CourseClassGroup_json = json_encode($CourseClassGroup);
            Redis::setex("all_course_class_group", 7200, $CourseClassGroup_json); 
        }
        

        $this->ret['courseclass'] = $courseClass;
        $this->ret['courseclassgroup'] = $CourseClassGroup;
    	$this->ret['list'] = $list;
        $this->ret['user'] = $request->user();
    	return view("user.ask.specials", $this->ret);
    }

    //问答专区创建新专题
    //20190321
    public function askSpecialAdd(Request $request){
        $id = $request->input("id")?$request->input("id"):0;
        $model     = new AskSpecial();
        if($id !== 0){
            $model = $model->where("id",$id)->first();
        }
    	if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }
    	
    	$author    = $request->input("author");
    	$title     = $request->input("title");
    	$des       = $request->input("des");
        $start_time = $request->input('start');
        $end_time = $request->input('end');
        $is_open   = $request->input("is_open");  //是否公开
        $course    = $request->input("course") ? trim($request->input("course"), ',') : "";
        $group     = $request->input("group")  ? trim($request->input("group"), ',') : "";


    	$model->title  = $title;
    	$model->author = $author;
    	$model->description = $des;
    	$model->user_id     = $user_id;
        $model->is_open     = $is_open;
        $model->course_class_ids = $course;
        $model->course_class_group_ids = $group;
        $model->start_time = $start_time;
        $model->end_time = $end_time;
    	$r = $model->save();
    	if($r){
    	 	echo json_encode(['code'=>1, 'msg'=>'创建成功', "id"=>$model->id]);
        }else{
            echo json_encode(['code'=>0, 'msg'=>'创建失败请稍后重试']);
        }
        return;
    }

    //问答专区导师详情待回答问题
    //20190321
    public function specailask(Request $request, $id){
        $AskQuestion = new AskQuestion();
        $list  = $AskQuestion
                 ->where("special_id", $id)
                 ->where("is_ans",0)
                 ->where("is_question", 1)
                 ->select("id", "title", "description","user_id","created_at")
                 ->orderBy("id", "desc")
                 ->take(300)->get();
        
        //dd($list);
        $this->ret['id']   = $id;     //专区id
        $this->ret['list'] = $list;   //待回答列表
        return view("user.ask.noanswer", $this->ret);
    }

    //问答专区导师详情待作业
    //20190321
    public function specailtask(Request $request, $id){
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }
        $AskQuestion = new AskQuestion();
        $list  = $AskQuestion
                 ->where("special_id", $id)
                 ->where("user_id",$user_id)
                 ->where("is_question", 0)    //参数为0，表示为作业
                 ->select("id", "title", "view","user_id","created_at")
                 ->orderBy("id", "desc")
                 ->take(20)->get();
        //print_r($list);
        $this->ret['list'] = $list;  //作业列表
        $this->ret['id']   = $id;    //专区id
        return view("user.ask.task", $this->ret);
    }

    //问答专区导师创建作业
    //20190321
    public function taskCreate(Request $request){
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }
        
        $title = $request->input("title");
        $des   = $request->input("description");
        //$user_id     = $request->input("user_id");
        $imgurl_list = $request->input("imgurl_list");
        $special_id  = $request->input("special_id");

        $AskQuestion = new AskQuestion();
        $AskQuestion->title       = $title;
        $AskQuestion->description = $des;
        $AskQuestion->imgurl_list = $imgurl_list;
        $AskQuestion->special_id  = $special_id;
        $AskQuestion->user_id     = $user_id;
        $AskQuestion->is_question = 0;//老师布置作业
        if($AskQuestion->save()){
            echo json_encode(array("code"=>1, "data"=>$title, "d"=>$des, "c"=>$imgurl_list));
        }else{
            echo json_encode(array("code"=>0, "msg"=>"创建失败"));
        }

        return;
    }

    //问答专区导师回答问题
    //20190321
    public function answerQuestion(Request $request){
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }
        
        $answer = $request->input("answer");
        $qid    = $request->input("qid");
        $q_user_id   = $request->input("q_user_id");
       
        $AskAnswer = new AskAnswer();
        $AskAnswer->content     = $answer;
        $AskAnswer->qid         = $qid;
        $AskAnswer->user_id     = $q_user_id;
        $AskAnswer->author_id   = $user_id;
        if($AskAnswer->save()){
            //修改问题状态为已回答
            $AskQuestion = new AskQuestion();
            $AskQuestion = $AskQuestion->where("id", $qid)->first();
            if($AskQuestion){
                $AskQuestion->is_ans = 1;
                $AskQuestion->save();
            }

            
            $cur_user = DB::table("users")->where("id", $AskQuestion->user_id)->first();
            //推送消息
            if($cur_user->openid){
                $dataInfo['type'] = WxMessageType::ASKFEEDBACK;//
                $dataInfo['url'] = 'http://m.saipubbs.com/ask/answer/'.$AskQuestion->special_id.'.html';//问答地址
                $dataInfo['notice'] = $request->user()->nickname.'导师解答了你的提问~';
                $dataInfo['message']['key1'] = $AskQuestion->title;
                $dataInfo['message']['key2'] = $AskQuestion->description;
                $dataInfo['message']['remark'] = "点击赶快查阅吧~";
                $dataInfo['openid'] = $cur_user->openid;
                if(env('IS_LOCAL') == false){
                   event(new WxMessagePush($dataInfo));
                }
            }
            echo json_encode(array("code"=>1, "msg"=>"回答成功"));
        }else{
            echo json_encode(array("code"=>0, "msg"=>"回答失败，稍后重试"));
        }

        return;
    }

    /*
     * 图片问答专区图片
     * 20190322
     */
    public function postUpload(Request $request){
        $upload  = new FileUploader();
        $img     = $_FILES["image"];
        $result  = $upload->formUpload($img, 'upload/askspecial');
        return $result;
    }

    /*
     * 图片上传
     * 20190327
     */
    public function postUploadBase(Request $request){
        $file = new FileUploader($request);
        $fileInfo = $file->base64ImgUpload($request,'upload/askspecial');
        return $fileInfo;
    }

    /*
     * 删除图片
     * 20190322
     */
    public function deleteImg(Request $request){
        $url     = $request->input("imgurl");
        $result  = unlink(env('IMG_PATH').$url);
        if($result){
            echo json_encode(array("code"=>1));
        }else{
            echo json_encode(array("code"=>0));
        }
        return; 
       
    }

    /**
     * 问答专区删除专题
     */
    public function delSpecial(Request $request){

        $id = $request->input("sid");
        $re = AskSpecial::where("id",$id)->delete();
        if($re){
            return json_encode(array("code"=>1));
        }else{
            return json_encode(array("code"=>0));
        }

    }
    /**
     * 问答专区获取专题详情
     */
    public function getDetail(Request $request){
        $id = $request->input("sid");
        $data = AskSpecial::where("id",$id)->first()->ToArray();
        return json_encode($data);
    }

}
