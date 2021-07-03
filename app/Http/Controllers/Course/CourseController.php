<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Wechat\WechatController;
use App\Models\Course;
use App\Models\Article;
use App\Models\CourseActivityUser;
use App\Models\Courseclass;
use App\Models\CourseClassGroupJoinBuyed;
use App\Models\CourseType;
use App\Models\CourseContent;
use App\Models\Coursesection;
use App\Models\DisCoursePlayRecord;
use App\Models\Order;
use App\Models\Paylog;
use App\Models\Tags;
use App\Models\UserCoupon;
use App\Models\Users;
use App\Models\UsersAttribute;
use App\Models\WechatActivityHand;
use App\Models\CourseActivityView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\FinanceAccount;
use App\Models\FinanceRecord;
use App\Models\Studying;
use App\Utils\WxMessagePush as WxPush;
use App\Models\Follow;
use App\Models\Comment;
use App\Constant\CommentDate;
use App\Models\Consultation;
use App\Models\ArticleRecommend;
use App\Events\WxMessagePush;
use App\Constant\WxMessageType;
use App\Models\CourseClassPush;
use App\Models\CourseClassGroup;
use App\Models\OrderCourseGroup;
use App\Models\IntroductionStaffReg;
use App\Models\IntroActiveUser;
use App\Models\Coupon;
use App\Models\DisCourseClass;
use App\Models\DisStudying;
use App\Models\ModelProject;
use App\Models\ModelSetting;
use App\Models\SpecialNavigation;
use App\Utils\ImageThumb;
use App\Utils\SensitiveWord;
use App\Utils\CurlUtil;
use App\Events\WxCustomerMessagePush;
use App\Constant\CustomerPushType;
use Illuminate\Support\Facades\Redis;

require app_path().'/Library/Wechat/WxPay.JsApiPay.php';
class CourseController extends Controller
{
    protected $ret;
    protected $page;

    public function __construct()
    {
        $this->ret = [];
        $this->page = 2;
    }

    /**
     * .课程首页
     *  20181201 旧版网站首页
     *
     */
    public function indexold(Request $request)
    {
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        $course = new Courseclass();
       //redis::del("select_course_class");
        if(Redis::exists("index_banner") && Redis::get("index_banner") != ''){
            $banner_json    = Redis::get("index_banner");
            $banner = json_decode($banner_json);
        }else{
            $banner = $course->getBanner()->toArray();
            $json   = json_encode($banner);
            Redis::setex("index_banner", 7200, $json);
        }
        //判断是否有数据
        if(!count($banner)){
           $banner[0] = false;
        }

        $one = $course->getone();
        //判断是否有数据
        if(!$one->count()){
           $one[0] = false;
        }
        $website = DB::table("sp_website")->where("id",1)->select("title", "keywords", "description")->first();
        //精选课程
        $data = array();
        if(Redis::exists("select_course_class") && Redis::get("select_course_class") != ''){
            $course_class_json = Redis::get("select_course_class");
            $list      = json_decode($course_class_json);
        }else{
            $list      = $course->getMany($data);
            $list_json   = json_encode($list);
            Redis::setex("select_course_class", 7200, $list_json);
        }

        //最新文章
        if(Redis::exists("index_article") && Redis::get("index_article") != ''){
            $index_article_json = Redis::get("index_article");
            $newarticle         = json_decode($index_article_json,true);
        }else{
            $newarticle = Article::where("state",1)->orderBy("id", "desc")->offset(0)->limit(4)->get()->toArray();   
            $article_json   = json_encode($newarticle);
            Redis::setex("index_article", 7200, $article_json);
        }
        
        $liveCourses = Courseclass::where('is_live',1)->where('state',1)->whereNull('deleted_at')->get();
        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        $fission_id = $request->input("fission_id", 0);   //裂变者id
        $this->ret['fission_id'] = $fission_id;           //裂变者id
        $this->ret['list'] = $list;                       //精选课程

        $this->ret['one']  = $one[0];                     //新课速递
        $this->ret['banner'] = $banner;                   //banner数据
        $this->ret['website']= $website;                  //网站设置数据
        $this->ret['newarticle']  = $newarticle;          //最新文章
        $this->ret['liveCourses'] = $liveCourses;         //直播课程
        $this->ret['user_id'] = $userid;                  //用户id


        return view("course.index",$this->ret);
    }
    //20181128 新首页
    public function index(Request $request)
    {
//        $query_str = $_SERVER['QUERY_STRING'];
        return view('course.blacklist');
        $urlParams = parse_url($_SERVER['REQUEST_URI'],PHP_URL_QUERY);
        parse_str($urlParams,$urlArr);
        $fission_id = isset($urlArr['fission_id'])?$urlArr['fission_id']:'';

        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        
        $course = new Courseclass();
        redis::del("index_q_type");
        if(Redis::exists("index_banner") && Redis::get("index_banner") != ''){
            $banner_json    = Redis::get("index_banner");
            $banner = json_decode($banner_json);
        }else{
            $banner = $course->getBanner()->toArray();
            $json   = json_encode($banner);
            Redis::setex("index_banner", 7200, $json);
        }

        //判断是否有数据
        if(!count($banner)){
           $banner[0] = false;
        }

//        $one = $course->getone();
//        //判断是否有数据
//        if(!$one->count()){
//           $one[0] = false;
//        }
        $one = CourseClassGroup::where("id","4")->limit(1)->get();
        //dd($one);
        //入门
        $initCourses = CourseClass::where('stage',1)->orderBy('orderby','desc')->get();
        //进阶
        $stageCourses = CourseClass::where('stage',2)->orderBy('orderby','desc')->get();
        //分销打卡
        $disCourse = DisCourseClass::first();
        //正在学习
        $disNum = DisStudying::where('dis_course_class_id',$disCourse->id)->select('id')->count();
        $disStudy = DisStudying::where("user_id",$userid)->orderBy('created_at','desc')->select("dis_course_class_id")->first();

        $nowDay = date('Y-m-d');
        $disPlayRecord = DisCoursePlayRecord::where('user_id',$userid)->where('day',$nowDay)->first();
//        dd($disPlayRecord);
        if($disPlayRecord){
            $preDay = date('Y-m-d',time()-86400);
            $nextDay = date('Y-m-d',time()+86400);
            $prePlayRecord = DisCoursePlayRecord::where('user_id',$userid)->where('day',$preDay)->where('dis_course_class_id',$disPlayRecord->dis_course_class_id)->first();

            $nowTask = DisCoursePlayRecord::where('user_id',$userid)->where('dis_course_class_id',$disPlayRecord->dis_course_class_id)->where('datetime','<=',strtotime($nowDay))->count();
            $nextPlayRecord = DisCoursePlayRecord::where('user_id',$userid)->where('day',$nextDay)->where('dis_course_class_id',$disPlayRecord->dis_course_class_id)->first();
            $disCourseClass = DisCourseClass::where('id',$disPlayRecord->dis_course_class_id)->first();
        }else{
            $prePlayRecord = '';
            $disCourseClass = '';
            $nextPlayRecord = '';
            $nowTask = 0;
        }
        $this->ret['nowTask'] = $nowTask;
        $this->ret['prePlayRecord'] = $prePlayRecord;
        $this->ret['disPlayRecord'] = $disPlayRecord;
        $this->ret['nextPlayRecord'] = $nextPlayRecord;
        $this->ret['disCourseClass'] = $disCourseClass;
        //导航模块
        $navigations = SpecialNavigation::where('state',1)->orderBy('orderby','desc')->get();
        //模块设置
        $modelSettings = ModelSetting::where('state',1)->orderBy('sort','desc')->get();

        $this->ret['navigations'] = $navigations;
        $this->ret['modelSettings'] = $modelSettings;
        //网站设置
        if(Redis::exists("website") && Redis::get("website") != ""){
            $website_json = Redis::get("website");
            $website      = json_decode($website_json);
        }else{
            $website = DB::table("sp_website")->where("id",1)->select("title", "keywords", "description")->first();
            $websete_json = json_encode($website);
            Redis::setex("website", 7200, $websete_json);
        }
        Redis::del('index_selected');
        //每日精选文章                  
        if(Redis::exists("index_selected") && Redis::get("index_selected") != ''){
            $index_selected_json = Redis::get("index_selected");
            $selected            = json_decode($index_selected_json,true);
//            dd($selected);
        }else{
            $selected = DB::table("article_selected")
                    ->where("today", date("Y-m-d"))
                    ->orderBy("today_timestamp", "desc")
                    ->select("article_ids","today")->limit(1)->get()->toArray();
            $selected_json   = json_encode($selected);
            $selected        = json_decode($selected_json,true);
            Redis::setex("index_selected", 7200, $selected_json);
//            dd(4);
//            dd($selected);
        }

        // 免费课程
        if(Redis::exists("index_free") && Redis::get("index_free") !=""){
            $index_free_json = Redis::get("index_free");
            $free = json_decode($index_free_json);
        }else{
            $free = $course->getFree();
            $index_free_json = json_encode($free);
            Redis::setex("index_free", 7200, $index_free_json);
        }
        //推荐课程
        if(Redis::exists("index_hot") && Redis::get("index_hot") !=""){
            $index_hot_json = Redis::get("index_hot");
            $hot = json_decode($index_hot_json);
        }else{
            $hot = $course->getHot();
            $index_hot_json = json_encode($hot);
            Redis::setex("index_hot", 7200, $index_hot_json);
        }
        //每日问答
        if(Redis::exists("index_q_type") && Redis::get("index_q_type") !=""){
            $index_q_type_json = Redis::get("index_q_type");
            $q_type = json_decode($index_q_type_json);
            //echo 111;
        }else{
            $q_type = DB::table("type")->where("model","ARTICLE")->where("is_index",0)->where("state",1)->get();
            $index_q_type_json = json_encode($q_type);
            Redis::setex("index_q_type", 7200, $index_q_type_json);
            //echo 222;
        }

        //最新活动
        $activity = DB::table("activity")->where("state",1)->orderBy("orderby", "desc")->limit(1)->get();
        //专题页
        $special = DB::table("special")->where("state",1)->orderBy("orderby", "desc")->orderBy("id","desc")->get();

        //dd($special);
        $courseType = CourseType::where("state",1)->where("pid",0)
                    ->orderBy("orderby", "desc")
                    ->select("id", "title", "cover_url")->get();
        $liveCourses = Courseclass::where('is_live',1)->where('state',1)->whereNull('deleted_at')->get();
        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
           // $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }
        //echo "欢迎来的赛普社区le2";
       // return;
//        $fission_id = $request->input("fission_id", 0);   //裂变者id
        $this->ret['fission_id'] = $fission_id;           //裂变者id
        $this->ret['one']  = $one;                     //新课速递
        $this->ret['banner'] = $banner;                   //banner数据
        $this->ret['website']= $website;                  //网站设置数据
        $this->ret['liveCourses'] = $liveCourses;         //直播课程
        $this->ret['user_id']     = $userid;              //用户id
        $this->ret['frees']       = $free;                //免费课程
        $this->ret['hots']        = $hot;                 //推荐课程
        $this->ret['coursetypes'] = $courseType;          //课程类别列表
        $this->ret['q_type']      = $q_type;              //问答类别
        $this->ret['selected']    = isset($selected[0])?$selected[0]:'';         //每日精选文章
        $this->ret['activity']    = $activity;
        $this->ret['special']    = $special;
        $this->ret['initCourses']    = $initCourses;
        $this->ret['stageCourses']    = $stageCourses;
        $this->ret['disCourse']    = '';
//        $this->ret['disCourse']    = $disCourse;
//        $this->ret['disNum']    = $disNum;
        $this->ret['disNum']    = '';

        return view("course.indexnew",$this->ret);
//        return view("course.indextwo",$this->ret);
    }
    //20181128  免费课程列表
    public function free(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        $course     = new Courseclass();
        $page       = $request->input("page", 0);
        if($page){
            $courselist = $course->getFreeAll($page);
            return json_encode($courselist);
        }
        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        $fission_id = $request->input("fission_id", 0);   //裂变者id
      
        $courselist = $course->getFreeAll();
        $this->ret['courselist'] = $courselist;
        $this->ret['fission_id'] = $fission_id;           //裂变者id
        $this->ret['user_id']     = $userid;              //用户id

        return view("course.free", $this->ret);
    }

    public function getJson(Request $request){
            $gets = $request->input();
            $page['page'] = $gets["page"];
            if(isset($gets["typeId"])){
                $page["course_type_id"] = $gets["typeId"];
            }
            $course = new Courseclass();
            $posts = $course->pageJson($page);
            //dd($posts);
            return json_encode($posts);
    }
    /**
     * tag标签页
     *
     * 
     */
    public function tag(Request $request)
    {
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        $data = DB::table("tags")->where("state",1)->where("type", "COURSE")->whereNull("deleted_at")->select("id","title","cover_url")->get();
        //dd($data);
        $arr = $this->sortTag($data);

        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        $fission_id = $request->input("fission_id", 0);   //裂变者id
        $this->ret['fission_id'] = $fission_id;//裂变者id
        $this->ret['data'] = $arr;
        $this->ret['user_id'] = $userid;
        return view("course.tag",$this->ret);
    }
    public function sortTag($arr){
        $count = count($arr);
        if($count <= 0) return false;
            for($i=0; $i < $count; $i++) {
                for($j=$count-1; $j>$i; $j--) {
                   // dd($arr[$j]->title);
                    if(strlen($arr[$j]->title) < strlen($arr[$j-1]->title)) {
                        $tmp = $arr[$j];
                        $arr[$j] = $arr[$j-1];
                        $arr[$j-1] = $tmp;
                    }
                }
            }
            return $arr;
    }
    public function tagDetail(Request $request, $id){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        //$id = $request->input("id");
        $course = new Courseclass();
        $data = DB::table("course_tag")->where("tag_id",$id)->whereNull("deleted_at")->select("course_class_id")->get()->toArray();
        $name = DB::table("tags")->where("id",$id)->whereNull("deleted_at")->select("id","title","seo_title","seo_description")->first();
        $arr = [];
        foreach($data as $k=>$v){
            $arr[$k] = $v->course_class_id;
        }
       
            $page = 1;
        $list = $course->getTagDetail($arr,$page);
        //dd($list);

        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        $fission_id = $request->input("fission_id", 0);   //裂变者id
        $this->ret['fission_id'] = $fission_id;//裂变者id
        $this->ret['list'] = $list;
        $this->ret['name'] = $name;
        $this->ret['tagId'] = $id;
        $this->ret['user_id'] = $userid;
        return view("course.tagDetail",$this->ret);
    }
    public function TagGetJson(Request $request){
            $gets = $request->input();
            $page = isset($gets["page"])?$gets["page"] : '';
            $tagId = $gets["tagId"];

            $data = DB::table("course_tag")->where("tag_id",$tagId)->whereNull("deleted_at")->select("course_class_id")->get()->toArray();
            $arr = [];
            foreach($data as $k=>$v){
                $arr[$k] = $v->course_class_id;
             }
             //dd($arr);
            $course = new Courseclass();
            $posts = $course->getTagDetail($arr,$page);
            //dd($posts);
            return json_encode($posts);
    }
    function arr_foreach($array,$return=[]){
        array_walk_recursive($array,function($value)use(&$return){$return[]=$value;});
        return $return;
    }
    public function type(Request $request, $id){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        //$id = $request->input("id");
        $course = new Courseclass();
        $data['course_type_id'] = $id;
        $arr = $course->getMany($data);
        $type = DB::table("course_type")->where("id",$id)->select("id","seo_title","seo_description")->first();
        if(!$arr->count()){
            $arr[0] = false;
            $typeName = '暂无类别';
        }else{
            $typeName = $arr[0]['typeName'];
        }
        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        $fission_id = $request->input("fission_id", 0);   //裂变者id
        $this->ret['fission_id'] = $fission_id;//裂变者id
        $this->ret['data'] = $arr;
        $this->ret['typeId'] = $id;
        $this->ret['name'] = $typeName;
        $this->ret['type'] = $type;
        $this->ret['user_id'] = $userid;
        return view("course.type",$this->ret);
    }

    /**
     * 课程详细页
     */
    public function detail(Request $request,$id="")
    {

        if(is_weixin()){
            $is_weixin = 1;
            //$subscribe = $this->getOpenid(); //是否关注
            $subscribe = $request->user()?$request->user()->subscribe:''; //是否关注
        }else{
            $is_weixin = 0;
            $subscribe = $request->user()?$request->user()->subscribe:'';
        }

        if($id == 60){
            return redirect('/');
        }

//        if($id == 58){
//
//            return redirect('/');
//        }
        if($request->user()){
            $userid = $request->user()->id;
            $mobile = $request->user()->mobile ? $request->user()->mobile : 0;  //用户手机号
            if($is_weixin){
                $user = $request->user();
                if($user->openid ==''){
                    $user = Users::where('id',$user->id)->first();
                    $tools = new \JsApiPay();
                    $openId = $tools->GetOpenid();
                    $user->openid = $openId;
                    if(!$user->save()){
                        logger()->info('用户id:'.$user->id.'用户名：'.$user->name);
                    }
                }
            }
        }else{
            $userid = 0;
            $mobile = 0;
        }

        if(!$id){
            $id = $request->input('id');    //课程id
            if(!is_numeric($id)){
                $cur_arr = explode("=", $id);
                $id = $cur_arr[1];
            }
        }else{
            $id_arr = explode(".", $id);
            $id     = $id_arr[0];
        }
        $fission_id = $request->input("fission_id", 0);   //裂变者id

        if($id == 60){

            $acsmInfo = $this->getUnlineCourseInfo(['id'=>$id,'userid'=>$userid,'mobile'=>$mobile]);

            $acsmInfo['user_id'] = $userid;        //用户id
            $acsmInfo['mobile']  = $mobile;        //用户手机号
            $acsmInfo['is_weixin'] = $is_weixin;
            $acsmInfo['fission_id'] = $fission_id;
            $acsm = $this->getAcsmPrice($id,$request->user());
            $acsmInfo['price'] = $acsm[0];
            return view('a.acsm.index',$acsmInfo);
        }
        $course = new Courseclass();
        $data  = $course->detail($id);  //课程目录
        $array = $course->video($id); 
        $courseClass  = DB::table("course_section")->where("course_class_id",$id)->whereNull("deleted_at")->get();
//        logger()->info("用户课程id::_".$id);
        /*
         * 优惠券
         */
        $couponInfo = $this->couponCard($userid,$id);

        $sum_video    = sum_course($id);
        $sum_people   = sum_study($id);
       // dd($data);
        $teacher_name = get_teacher_name($data[0]->user_id);
        $data[0]['sum_people']   = $sum_people->count + $data[0]->studying_num;
        $data[0]['sum_video']    = $sum_video->count;
        $data[0]['teacher_name'] = $teacher_name->name;
        $data[0]['teacher_inc']  = $teacher_name->introduction;

        $comment = new Comment();
        $comment_one = $comment->getOne($id);  //最新评论
        if($comment_one){
            $comment_one->stars = stars($comment_one->score, "video");
        }
        $follow = new Follow();
        $item = $follow->where(['user_id'=>$data[0]->user_id, 'fans_id'=>$userid])->first();
        if($item){
            $is_follow = 1;  //已关注
        }else{
            $is_follow = 0;  //未关注
        }
       // dd($item);
        // $WechatData = getSignPackage();     //微信分享
        //dd($WechatData);
        $this->ret['data']    = $data[0];       //课程信息
        $this->ret['class']   = $courseClass;   //章节信息
        $this->ret['array']   = $array;         //视频列表
        $this->ret['user_id'] = $userid;        //用户id
        $this->ret['mobile']  = $mobile;        //用户手机号 
        $this->ret['comment_one'] = $comment_one;   //第一条评论
        $this->ret['is_weixin']= $is_weixin;        //是否是微信浏览器
        $this->ret['subscribe']= $subscribe;        //是否关注微信公众号
        $this->ret['fission_id'] = $fission_id;//裂变者id
        $this->ret['balance'] = user_balance($userid, $data[0]->price);  //用户余额
        $this->ret['is_follow']   = $is_follow;//是否关注老师
        $this->ret['hasCoupon'] = $couponInfo['hasCoupon'];//是否有优惠券
        $this->ret['couponPrice'] = $couponInfo['couponPrice'];
        if($userid == 0){
            $this->ret['spb'] = 0;
        }else{
            $this->ret['spb'] = getSpb($userid);
        }
        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        if($data[0]->is_live==1){
            $liveCourse = Course::where('course_class_id',$data[0]->id)->where('is_live',1)->first();
            $this->ret['liveCourse'] = $liveCourse;
            return view('course.liveDetail',$this->ret);
        }
        $isStaff = 0;
        $price = $data[0]->price;
        if($data[0]->course_type == 1){

            $add_info = 0;
            if($mobile){
                $introActiveUser = IntroActiveUser::where('user_id',$userid)->first();
                if($introActiveUser){
                    $idNumber = json_decode($introActiveUser->user_info)->card;
                }else{
                    $idNumber = '';
                }
                if($data[0]->id == 58) {
                    $url = 'http://101.201.81.14:9315/saipu-app-ins/api/trainee_info_status?idNumber=' . $idNumber;
                    $result = CurlUtil::appCurl($url, [], 'GET');
                    $resInfo = json_decode($result, true);
                    //                dd($resInfo);
                    if (isset($resInfo['code']) && $resInfo['code'] == 0) {
                        if (isset($resInfo['result']['studentStatus']) && $resInfo['result']['studentStatus'] == '01') {
                            $price = 4700;
                        }
                        if (isset($resInfo['result']['studentStatus']) && $resInfo['result']['studentStatus'] == '03') {
                            $price = 4700;
                        }
                    } else {
                        $price = 7040;
                    }
                    $isBuy = $this->isBuyedCourse($userid);
                    if($isBuy){
                        $price = 4700;
                    }
                }else{
                    $price = $data[0]->price;
                }
//                $staffReg = IntroductionStaffReg::where('staff_mobile',$mobile)->select('id')->first();
                $staffReg = UsersAttribute::where('user_id',$userid)->where('can_dist',1)->select('id')->first();
                if($staffReg){
                    $isStaff = 1;
                }
            }
            $introActUser = IntroActiveUser::where('user_id',$userid)->where("course_class_id", $id)->first();
            if($introActUser){
                $add_info = 1;
            }
            $order = Order::where('user_id',$userid)->where('course_class_id',$id)->where('state',1)->select('id')->first();
            if($order){
                $is_buy = 1;
            }else{
                $is_buy = 0;
            }
            if($fission_id == $userid){
                $this->ret['fission_id'] =  0;
            }
            $this->ret['is_buy'] = $is_buy;
            $this->ret['price'] = $price;
            $this->ret['actualPrice'] = $data[0]->price;
            $this->ret['is_staff'] = $isStaff;
            $this->ret['add_info'] = $add_info;

            if($id == 58){
                $stageArr = [1=>30,2=>160,3=>165];
                $firstNum = $stageArr[1] - Order::where('course_class_id',58)->where('state',1)->where('stage',1)->select('id')->count();
                $secondNum = $stageArr[2] - Order::where('course_class_id',58)->where('state',1)->where('stage',2)->select('id')->count();
                $thirdNum = $stageArr[3] - Order::where('course_class_id',58)->where('state',1)->where('stage',3)->select('id')->count();
                $stageNumArr = [1=>$firstNum,2=>$secondNum,3=>$thirdNum];
                $this->ret['stageNumArr'] = $stageNumArr;
                return view('course.activeDetail',$this->ret);
            }elseif($id == 70) {
                $stageArr = [1=>36,2=>36];
                $firstNum = $stageArr[1] - Order::where('course_class_id',70)->where('state',1)->where('stage',1)->select('id')->count();
                $secondNum = $stageArr[2] - Order::where('course_class_id',70)->where('state',1)->where('stage',2)->select('id')->count();
                $stageNumArr = [1=>$firstNum,2=>$secondNum];
                $this->ret['stageNumArr'] = $stageNumArr;
                $this->ret['price'] = 4800;
                return view('course.trainDetail',$this->ret);
            }elseif($id == 71){
                $stageArr = [1=>25,2=>50];
                $firstNum = $stageArr[1] - Order::where('course_class_id',71)->where('state',1)->where('stage',1)->select('id')->count();
                $secondNum = $stageArr[2] - Order::where('course_class_id',71)->where('state',1)->where('stage',2)->select('id')->count();
                $stageNumArr = [1=>$firstNum,2=>$secondNum];
                $this->ret['stageNumArr'] = $stageNumArr;
                $this->ret['price'] = 4800;
                return view('a.tishineng.index',$this->ret);
            }else{
                return view('course.activeDetailo',$this->ret);
            }

        }
        //dd($this->ret);
        return view("course.detail", $this->ret);
    }

    /*
     * 获课信息
     */
    public function getUnlineCourseInfo($data){

        $introActUser = IntroActiveUser::where('user_id',$data['userid'])->where("course_class_id", $data['id'])->first();
        $order = Order::where('user_id',$data['userid'])->where('course_class_id',$data['id'])->where('state',1)->select('id')->first();
        $buyed = 0;
        if($order){
            $buyed = 1;
        }
        $add_info = 0;
        if($introActUser){
            $add_info = 1;
        }
        $courseClass = CourseClass::where('id',$data['id'])->first();
        $data['courseClass'] = $courseClass;

        $isStaff = 0;
//        $staffReg = IntroductionStaffReg::where('staff_mobile',$data['mobile'])->select('id')->first();
        $staffReg = UsersAttribute::where('user_id',$data['userid'])->where('can_dist',1)->select('id')->first();
        if($staffReg){
            $isStaff = 1;
        }
        if(env('IS_LOCAL') == false){
            $wechat = new WechatController();
            $code_img = $wechat->getQRcode('acsm-'.$data['userid']);   //下载带客户信息的二维码
        }else{
            $code_img = '';
        }

        $is_local = env("IS_LOCAL");
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();
        }

        $data['add_info'] = $add_info;
        $data['is_staff'] = $isStaff;
        $data['code'] = $code_img;
        $data['course_buyed'] = $buyed;
        return $data;
    }

    /*
     * 获取课程价格
     */

    public function getAcsmPrice($cid,$user){
        if($user){
            $user_id = $user->id;
        }else{
            $user_id = 0;
        }
        $total = WechatActivityHand::where('user_id',$user_id)->where('type','ACSM')->select('id')->count();
        if($total<5){
            $price = 5800;
            $invite = 5 - $total;
            $grade = 1;
        }elseif($total >= 5 && $total < 10){
            $price = 4800;
            $invite = 10 - $total;
            $grade = 2;
        }elseif($total >= 10 && $total < 15){
            $price = 3800;
            $invite = 15 - $total;
            $grade = 3;
        }elseif($total >= 15 && $total < 20){
            $price = 3300;
            $invite = 20 - $total;
            $grade = 4;
        }else{
            $price = 2800;
            $invite = 0;
            $grade = 5;

        }
        return [$price,$invite,$grade];
    }

    /*
     * 判断是否购买组合课程
     */
    private function isBuyedCourse($userid){
        $groupOrder = OrderCourseGroup::where('user_id',$userid)->whereIn('course_class_group_id',[1,4])->where('state',1)->select('id','course_class_group_id')->get();
        $buyGroup = 0;
        foreach($groupOrder as $order){
            if($order->buy_way == 'TEAM'){
                $joinBuyed = CourseClassGroupJoinBuyed::where('course_class_group_id',$order->course_class_group_id)->where('user_id',$userid)->select('sponsor_id')->first();
                if($order->course_class_group_id == 1){
                    $total = CourseClassGroupJoinBuyed::where('sponsor_id',$joinBuyed->sponsor_id)->select('id')->count();
                    if($total >= 2){
                        $buyGroup = 1;
                        break;
                    }
                }else{
                    $total = CourseClassGroupJoinBuyed::where('sponsor_id',$joinBuyed->sponsor_id)->select('id')->count();
                    if($total >= 3){
                        $buyGroup = 1;
                        break;
                    }
                }
            }else{
                $buyGroup = 1;
                break;
            }
        }
        return $buyGroup;
    }

    public function activityindex(){
       
        return view("course.aindex");
    }

    public function activitym(){
       
        return view("course.mindex");
    }

    /**
     * 课程活动页
     */
    public function activity(Request $request)
    {
        if(is_weixin()){
            $is_weixin = 1;
        }else{
            $is_weixin = 0;
        }
       
        if($request->user()){
            $userid = $request->user()->id;
            $mobile = $request->user()->mobile;  //用户手机号
            if($is_weixin){
                $user = $request->user();
                if($user->openid ==''){
                    $user = Users::where('id',$user->id)->first();
                    $tools = new \JsApiPay();
                    $openId = $tools->GetOpenid();
                    $user->openid = $openId;
                    if(!$user->save()){
                        logger()->info('用户id:'.$user->id.'用户名：'.$user->name);
                    }
                }
            }
        }else{
            $userid = 0;
            $mobile = 0;
        }
        $id = $request->input('id');    //课程id
        if(!is_numeric($id)){
            $cur_arr = explode("=", $id);
            $id = $cur_arr[1];
        }
        $course = new Courseclass();
        $data  = $course->detail($id);  //课程目录
        $array = $course->video($id); 
        $courseClass  = DB::table("course_section")->where("course_class_id",$id)->whereNull("deleted_at")->get();
        $sum_video    = sum_course($id);
        $sum_people   = sum_study($id);
       // dd($data);
        $teacher_name = get_teacher_name($data[0]->user_id);
        $data[0]['sum_people']   = $sum_people->count + $data[0]->studying_num;
        $data[0]['sum_video']    = $sum_video->count;
        $data[0]['teacher_name'] = $teacher_name->name;
        $data[0]['teacher_inc']  = $teacher_name->introduction;

        $comment = new Comment();
        if($data[0]->is_live){
            $comment_one = $comment->getOne($id,2);  //最新评论
        }else{
            $comment_one = $comment->getOne($id);  //最新评论
            if($comment_one){
                $comment_one->stars = stars($comment_one->score, "video");
            }
        }

        $keyword = DB::table("course_class_about")->where("course_class_id", $id)->select("wx_keyword")->first();


        $this->ret['data']    = $data[0];      //课程信息
        $this->ret['class']   = $courseClass;  //章节信息
        $this->ret['array']   = $array;        //视频章节列表
        $this->ret['user_id'] = $userid;       //用id
        $this->ret['mobile']  = $mobile;       //用户手机号
        $this->ret['keyword'] = $keyword->wx_keyword ? $keyword->wx_keyword : "暂无";
        $this->ret['comment_one'] = $comment_one;  // 第一条评论
        $this->ret['is_weixin']= $is_weixin;       // 是否是微信浏览器
        $this->ret['balance'] = user_balance($userid, $data[0]->price);  //用户余额
        return view("course.activity", $this->ret);
    }

    public function video(Request $request, $id, $vid)
    {

        if(is_weixin()){
            $is_weixin = 1;
            $subscribe = 0; //是否关注
        }else{
            $is_weixin = 0;
            $subscribe = 0;
        }

        if($request->user()){
            $userid = $request->user()->id;
            $mobile = $request->user()->mobile ? $request->user()->mobile : 0;  //用户手机号
            if(strpos($request->user()->avatar,'http')){
                $avatar = env('IMG_URL').$request->user()->avatar;
            }else{
                $avatar = $request->user()->avatar;
            }
            $user_name = $request->user()->name ? $request->user()->name : "ID:".$userid;
            courseSpb($userid,10,$id);
        }else{
            $userid = 0;
            $mobile = 0;  //用户手机号
            $user_name = "暂无";
            $avatar    = "/images/my/nophoto.jpg";
        }

        if($userid != 0){
            Redis::incr('course_visit_'.date("Ymd").'_'.$userid);
        }
        $course = new Courseclass();
        $data = $course->detail($id);
        
        if($vid){
            //获取视频
            $videoOne = $course->videoDetail($vid);
        }else{
            $videoOne = [];
            $vid = 0;
        }
        //获取课程目录
        $array = $course->video($id);
        $name = get_course_name($id);

        $courseClass = DB::table("course_section")->where("course_class_id",$id)->whereNull("deleted_at")->get();
        $sumTotal = Course::where('course_class_id',$id)->select('id')->count();
        $viewTotal = CourseActivityView::where('course_class_id',$id)->where('user_id',$userid)->where('finished',1)->select('id')->count();

        $sum_video    = sum_course($id);
        $sum_people   = sum_study($id);
        $teacher_name = get_teacher_name($data[0]->user_id);

        $data[0]['sum_people'] = $sum_people->count;
        $data[0]['sum_video']  = $sum_video->count;
        $this->ret['viewTotal']  = $viewTotal;
        $this->ret['sumTotal']  = $sumTotal;
        $data[0]['teacher_name'] = $teacher_name->name;

        $follow = new Follow();
        $item = $follow->where(['user_id'=>$teacher_name->id, 'fans_id'=>$userid])->first();
        if($item){
            $is_follow = 1;  //已关注
        }else{
            $is_follow = 0;  //未关注
        }
        $comment = new Comment();
        if(!$data[0]->is_live){
            $comment_one = $comment->getOne($id);  //最新评论
            if($comment_one){
                $comment_one->stars = stars($comment_one->score, "video");
            }
        }else{

            $comment_one = $comment->getOne($id,2);  //最新评论
        }

        //$WechatData = getSignPackage();     //微信分享
        $this->ret['data']   = $data[0];       //课程信息
        $this->ret['class']  = $courseClass;   //章节信息
        $this->ret['userid'] = $userid;        //用户id
        $this->ret['mobile'] = $mobile;        //用户手机号
        $this->ret['vid']    = $vid;           //第一条视频id
        $this->ret['videoOne'] = $videoOne;    //第一条视频信息
        $this->ret['array']    = $array;       //视频列表
        $this->ret['teacher']  = $teacher_name;//讲师姓名
        $this->ret['is_follow']   = $is_follow;//是否关注老师
        $this->ret['comment_one'] = $comment_one;   //第一条评论
        $this->ret['is_weixin']   = $is_weixin;     // 是否是微信浏览器
        $this->ret['subscribe']   = $subscribe;     // 是否关注公众号
        $this->ret['balance']     = user_balance($userid, $data[0]->price);   //客户余额
        $this->ret['user_name'] = $user_name;    //用户姓名
        $this->ret['avatar']  = $avatar;       //用户头像
        if($userid == 0){
            $this->ret['spb'] = 0;
        }else{
            $this->ret['spb'] = getSpb($userid);
         }

        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        if($data[0]->is_live){
            return view('course.liveVideo',$this->ret);
        }

        return view("course.video1", $this->ret);
    }

    public function groupVideo(Request $request,$gid,$id){

        if(is_weixin()){
            $is_weixin = 1;
            $subscribe = 0; //是否关注
        }else{
            $is_weixin = 0;
            $subscribe = 0;
        }

        if($request->user()){
            $userid = $request->user()->id;
            $mobile = $request->user()->mobile ? $request->user()->mobile : 0;  //用户手机号
            if(strpos($request->user()->avatar,'http')){
                $avatar = env('IMG_URL').$request->user()->avatar;
            }else{
                $avatar = $request->user()->avatar;
            }
            $user_name = $request->user()->name ? $request->user()->name : "ID:".$userid;
            courseSpb($userid,10,$id);
        }else{
            $userid = 0;
            $mobile = 0;  //用户手机号
            $user_name = "暂无";
            $avatar    = "/images/my/nophoto.jpg";
        }
        $groupOrder = OrderCourseGroup::where('user_id',$userid)->where('course_class_group_id',$gid)->where('state',1)->first();
        if(!$groupOrder){
            return redirect('/user/studying');
        }

        $groupClass = CourseClassGroup::where('id',$gid)->first();
        $videoOne = Course::where('course_class_id',$id)->first();
        $class_ids = explode(',',$groupClass->course_class_ids);
        $courses = Course::whereIn('course_class_id',$class_ids)->select('id')->get();
        $courseClass = Courseclass::where('id',$id)->first();
        $totalCourse = count($courses);
        $courseArr = [];
        foreach($courses as $course){
            $courseArr[] = $course->id;
        }

        $viewTotal = CourseActivityView::whereIn('course_id',$courseArr)->where('user_id',$userid)->where('finished',1)->select('id')->count();
        $this->ret['totalCourse'] = $totalCourse;
        $this->ret['viewTotal'] = $viewTotal;
        $this->ret['videoOne'] = $videoOne;
        $this->ret['courseClass'] = $courseClass;
        if($userid != 0){
            Redis::incr('course_visit_'.date("Ymd").'_'.$userid);
        }
        $this->ret['groupClass'] = $groupClass;

        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        $this->ret['vid'] = $videoOne->id;
        $this->ret['video_id'] = $videoOne->id;
        $this->ret['is_weixin'] = $is_weixin;
        $this->ret['subscribe'] = $subscribe;
        $this->ret['userid'] = $userid;
        return view("course.video2", $this->ret);
    }
    /*
    *20190617 
    *课程图文内容页
    *lu
    */
    public function content(Request $request, $id, $content_id)
    {
       
        if(is_weixin()){
            $is_weixin = 1;
        }else{
            $is_weixin = 0;
        }
        
        if($request->user()){
            $userid = $request->user()->id;
            $mobile = $request->user()->mobile ? $request->user()->mobile : 0;  //用户手机号
            if(strpos($request->user()->avatar,'http')){
                $avatar = env('IMG_URL').$request->user()->avatar;
            }else{
                $avatar = $request->user()->avatar;
            }
            $user_name = $request->user()->name ? $request->user()->name : "ID:".$userid;
        }else{
            $userid = 0;
            $mobile = 0;  //用户手机号
            $user_name = "暂无";
            $avatar    = "/images/my/nophoto.jpg";
        }

        $content = CourseContent::where("id", $content_id)->first();
        $content->views = $content->views+1;
        $content->save();
        $course  = new Courseclass();
        $data    = $course->detail($id);
        //获取课程目录
        $name  = get_course_name($id);
        $sum_video    = sum_course($id);
        $sum_people   = sum_study($id);
        $teacher_name = get_teacher_name($data[0]->user_id);

        $data[0]['sum_people'] = $sum_people->count;
        $data[0]['sum_video']  = $sum_video->count;
        $data[0]['teacher_name'] = $teacher_name->name;

        $follow = new Follow();
        $item = $follow->where(['user_id'=>$teacher_name->id, 'fans_id'=>$userid])->first();
        if($item){
            $is_follow = 1;  //已关注
        }else{
            $is_follow = 0;  //未关注
        }
        
        $this->ret['data']   = $data[0];       //课程信息
        $this->ret['user_id'] = $userid;        //用户id
        $this->ret['teacher']= $teacher_name;  //讲师姓名
        $this->ret['is_follow']   = $is_follow;//是否关注老师
        $this->ret['is_weixin']   = $is_weixin;    //是否是微信浏览器
        $this->ret['user_name']   = $user_name;    //用户姓名
        $this->ret['avatar']      = $avatar;       //用户头像
        $this->ret['content']     = $content;      //课程图文内容
         $this->ret['mobile'] = $mobile;        //用户手机号
        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        
        return view("course.content", $this->ret);
    }

    //课程报名成功后引导关注公众号
    public function middle($c_c_id, $video_id){

        $data['c_c_id']    = $c_c_id;
        $data['video_id'] = $video_id;
        return view("course.middle", $data);
    }

    //20180820 课程评论列表
    public function comments(Request $request, $course_class_id)
    {
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        $comment  = new Comment();
        $comments = $comment->getList($course_class_id);  //最新评论
        $is_true  = DB::table("comments")->where(['course_class_id'=>$course_class_id, "user_id"=>$userid])->select("id")->first();   //查看客户是否评论该课程
        
        //dd($comments);
        $course_type_id = Courseclass::where("id", $course_class_id)->select("course_type_id")->first();
        $this->ret['comments'] = $comments;
        $this->ret['course_class_id'] = $course_class_id;
        $this->ret['course_type_id']  = $course_type_id->course_type_id;
        $this->ret['is_true']  = $is_true ? 1 : 0;
        $this->ret['userid']   = $userid;
        return view("course.comments", $this->ret);
    }

    //20180820 添加评论
    public function commentAdd(Request $request, $course_class_id){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }

        $this->ret['user_id'] = $userid;
        $this->ret['c_c_id']  = $course_class_id;
        return view("course.addcomment", $this->ret);
    }

    //20180820 ajax添加评论
    public function commentInsert(Request $request){
        $user_id = $request->input('user_id');
        $c_c_id  = $request->input('c_c_id');
        $text    = $request->input('text');
        $SensitiveWord = new SensitiveWord();
        $flag    = $SensitiveWord->filterWord($text);
        if($flag==1){
            echo json_encode(['code'=>0, 'msg'=>'包含敏感词,请重新编辑']);
            return;
        }
        $final_score= $request->input('final_score');
        $item    = DB::table("course_class")->where("id", $c_c_id)->select("user_id","title")->first();
        if($user_id && $c_c_id && $text && $final_score){
            $user = DB::table("users")->where("id",$user_id)->select("name","avatar",'openid')->get();
            $data = array();
            $data['user_id'] = $user_id;
            $data['course_class_id'] = $c_c_id;
            $data['content'] = filterSpecialChar($text);
            $data['score']   = $final_score;
            $data['created_at']   = date("Y-m-d H:i:s");
            $data['user_name']    = $user[0]->name;
            $result = DB::table("comments")->insert($data);
            if($result){
                //评论成功写入消息通知
                add_message($item->user_id,$user_id, $user[0]->name, $user[0]->avatar,$item->title, "COMMENT", $text);
                courseSpb($user_id,7,$c_c_id);

                $dataInfo['type'] = WxMessageType::COMMENT;
                $dataInfo['url'] = env('APP_URL').'/course/detail/'.$c_c_id.".html";
                $author = Users::where('id',$item->user_id)->select('name')->first();
                $dataInfo['notice'] = '感谢你的评论！';
                $dataInfo['message']['course'] = $item;
                $dataInfo['message']['author'] = $author;
                $dataInfo['openid'] = $user[0]->openid;
                if(env('IS_LOCAL') == false){
                    event(new WxMessagePush($dataInfo));
                }
                echo json_encode(['code'=>1, 'msg'=>"评价成功！"]);
                return;
            }
        }
        echo json_encode(['code'=>0, 'msg'=>'添加失败，稍后请重试']);
    }

    //20180820 评论加载更多
    public function commentMore(Request $request){
        $page   = $request->input('page');
        $offset = 10*($page-1);
        $c_c_id = $request->input('course_class_id');
        
        if($page && $c_c_id){
            $comment  = new Comment();
            $comments = $comment->getList($c_c_id, $offset);  //评论列表
            if($comments->count()){
                foreach($comments as &$item){
                    $item->user_name   = $item->users ? $item->users->name : '暂无昵称';
                    $item->user_avatar = $item->users ? $item->users->avatar : 'http://m.saipubbs.com/images/my/nophoto.jpg';
                    $item->stars       = stars($item->score, "comments");
                    $item->created_a   = CommentDate::getDate($item->created_at);
                }
                echo json_encode(['code'=>1, 'list'=>$comments]);
                return;
            }
        }
        echo json_encode(['code'=>0, 'msg'=>'抱歉没有数据了']);
    }

    //20180912 ajax删除评论
    public function commentDel(Request $request){
        $comment_id = $request->input('comment_id');
        if($comment_id){
            $comment  = new Comment();
            $r = $comment->where("id", $comment_id)->delete();
            if($r){
                echo json_encode(['code'=>1, 'msg'=>'删除成功']);
                return;
            }
        }
        echo json_encode(['code'=>0, 'msg'=>'网络错误~失败啦']);
    }
    
    /*
    *   课程报名
    */
    public function enroll(Request $request){
        $data = $request->input();
        //开启事务
        DB::beginTransaction();
        try{
            if(isset($data['course_class_id']) && isset($data["user_id"])){
                $studying = new Studying();
                $collect  = $studying->addOne($data["user_id"], $data['course_class_id']);   //加入正在学习
                
                $CourseClassPush = new CourseClassPush();
                $result   = $CourseClassPush->addOne($data["user_id"], $data['course_class_id']);            //默认接收课程提醒
                if($collect && $result){
                    courseSpb($data["user_id"],9,$data['course_class_id']);
                    DB::commit();
                    $str= 0;
//                    $data['openid'] = $request->user()->openid;
//                    $data['type'] = WxMessageType::ENROLL;
//                    $courseClass = Courseclass::where('id',$data['course_class_id'])->select('title','user_id')->first();
//                    $author = $courseClass->author;
//                    $data['url'] = env('APP_URL').'/course/detail?id='.$data['course_class_id'];
//                    $data['message']['course'] = $courseClass;
//                    $data['message']['author'] = $author;
                    $data['openid'] = $request->user()->openid;
                    $data['type'] = CustomerPushType::IMAGE;
                    $courseClass = Courseclass::where('id',$data['course_class_id'])->select('id','title','user_id','explain_url','push_message')->first();
                    $author = $courseClass->author;

                    $title = "【报名成功】".$courseClass->title;
                    $desc = $author->name."[导师系列课]：\n".$courseClass->push_message."\n点击进入即可查看系列课内容\n回复[TD]".$courseClass->id."不再接收该导师系列课推送";
                    $data['list'] = [[
                        "title"=>$title,
                        "description"=>$desc,
                        "url"=>env('APP_URL').'/course/detail/'.$data['course_class_id'].".html",
                        "picurl"=>'http://image.saipubbs.com/'.$courseClass->explain_url]];
                    if($courseClass->push_message){
                        event(new WxCustomerMessagePush($data));
                    }
                }else{
                    $str = 1;
                }
            }else{
                $str = 1;
            }
        }catch(\Exception $e){
            logger()->info($e->getMessage().'/'.$e->getLine());
            DB::rollback();
        }
        return $str;
    }
    public function collect(Request $request){
        $data = $request->input();
        unset($data['_url']);
        $data['created_at'] = date("Y-m-d H:i:s");
        if(isset($data['course_class_id']) && isset($data["user_id"])){
            $user = DB::table("collect")->where($data)->get();
            
            if(empty($user[0])){
                $collect = DB::table("collect")->insert($data);
                courseSpb($data['user_id'],9,$data['course_class_id']);
                if($collect){
                    $str= 0;
                    $data['type'] = CustomerPushType::IMAGE;
                    $data['openid'] = $request->user()->openid;
                    $courseClass = Courseclass::where('id',$data['course_class_id'])->select('id','user_id','title','explain_url','push_message')->first();
                    $author = Users::where('id',$courseClass->user_id)->select('id','name')->first();
                    $title = "【收藏成功】".$courseClass->title;
                    $data['list'] = [[
                        "title"=>$title,
                        "description"=>"[".$author->name."导师系列课]：
\n".$courseClass->push_message."\n回复[TD".$data['course_class_id']."]不再接收该导师系列课推送",
                        "url"=>env('APP_URL').'/course/detail/'.$courseClass->id.".html",
                        "picurl"=>'http://image.saipubbs.com/'.$courseClass->explain_url]];
                    if($courseClass->push_message){
                        event(new WxCustomerMessagePush($data));
                    }
                }else{
                    $str = 1;
                }
            }else{
                $str = 1;
            }   
        }else{
            $str = 1;
        }
        return $data;
    }
    //ajax  客户取消收藏
    public function noCollect(Request $request){
        $data   = $request->input();
        $id     = $data['course_class_id'];
        $user_id = $data['user_id'];
        if($id && $user_id){
            $arr = DB::table('collect')->where([['user_id',"=",$user_id],["course_class_id","=",$id]])->delete();
            if($arr){
                return $arr;
            }
        }
        return false;
    }

    //ajax  客户取消报名正在学习
    public function no_entroll(Request $request){
        $data    = $request->input();
        $id      = $data['course_class_id'];
        $user_id = $data['user_id'];
        $arr     = DB::table('studying')->where([['user_id',"=",$user_id],["course_class_id","=",$id]])->delete();
        if($arr){
            echo json_encode(['code'=>1, 'msg'=>'取消报名成功']);
            return;
        }else{
            echo json_encode(['code'=>0, 'msg'=>'取消报名失败']);
            return;
        }
    }

    //微信jsapi支付接口
    public function pay(Request $request){
        //$user_id= $request->input("user_id");          //用户id
        $c_id   = $request->input("class_id");  // 课程id
        $user_id = $request->user()->id;
        $order   = new Order();     //订单模型
        $course_class = DB::table("course_class")->where("id",$c_id)->select("id","title","price")->get();
        $old_order = $order->where("user_id",$user_id)->where("course_class_id",$c_id)->first();
        $couponInfo = $this->couponCard($user_id,$c_id);
        $hasCoupon = $couponInfo['hasCoupon'];
        $payPrice = $course_class[0]->price - $couponInfo['couponPrice'];
        $coupon_id = $couponInfo['coupon_id'];
        if($old_order){
            if($old_order->state == 0){
                $oNumber = $old_order->number;
                if($hasCoupon){
                    $old_order->price = $payPrice;
                    $old_order->coupon_id = $coupon_id;
                    $old_order->save();
                }
            }else{
                return ['code'=>1,'message'=>'您已购买请联系客服'];
            }
        }else{
            $oNumber = date("YmdHis").rand(1000,9999);
            $order->number  = $oNumber;
            $order->user_id = $user_id;
            $order->price   = $payPrice;
            if($hasCoupon){
                $order->coupon_id = $coupon_id;
            }
            $order->course_class_id = $c_id;
            $order->course_class_title = $course_class[0]->title;
            $order->save();
        }
        //②、统一下单
        $tools = new \JsApiPay();
        $openId = $request->user()->openid;
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($course_class[0]->title);             //课程标题
        $input->SetAttach($oNumber);                          //订单号
        $input->SetOut_trade_no("sdkphp".date("YmdHis"));
        $input->SetTotal_fee($payPrice*100);    //订单金额
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://m.saipubbs.com/course/notify");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);

        $config = new \WxPayConfig();
        $order = \WxPayApi::unifiedOrder($config, $input);

        $jsApiParameters = $tools->GetJsApiParameters($order);
        $info =  json_decode($jsApiParameters,true);
        return ['code'=>0,'data'=>$info];
    }
    //微信jsapi支付成功后回调接口
    public function notify(Request $request){

        $xml = file_get_contents('php://input');
        $result = xmlToArray($xml);
        $json_d = json_encode($result);
        $time   = time();
        $pay_log= new Paylog();    //支付日志
        $order  = new Order();     //订单模型
        $pay_log->info   = $json_d;
        $pay_log->c_time = $time;
        $payfrom = "WXPAY";
        //开启事务
        DB::beginTransaction();
        try{
            if($result['return_code']=='SUCCESS'){
                $out_trade_no = $result['out_trade_no'];
                $number  = $result['attach'];
                $item    = $order->where("number",$number)->where("state", 0)->first();
                if($item){
                    $item->state = 1;
                    $item->payfrom = $payfrom;
                    $item->save();        //将订单状态改为1  支付成功
                    $pay_log->state = 1;
                    $pay_log->save();     //记录正常支付日志
                    /*
                     * 优惠券使用
                     */
                    $userCoupon = UserCoupon::where('user_id',$item->user_id)->where('coupon_id',$item->coupon_id)->where('is_use',0)->first();
                    if($userCoupon){
                        $userCoupon->is_use = 1;
                        $userCoupon->save();
                    }
                    //操作客户账户资金信息
                    $finance_a = new FinanceAccount();
                    $finance_a->addOne($item->user_id);                           //查看用户资金账户，如果没有创建一条
                    $studying  = new Studying();
                    $studying->addOne($item->user_id, $item->course_class_id);    //支付成功后将记录插入正在学习表
                    $CourseClassPush = new CourseClassPush();
                    $CourseClassPush->addOne($item->user_id, $item->course_class_id);            //默认接收课程提醒
                    add_finance_record($item->price,"BUY", $item->user_id, $payfrom, $item->course_class_id);   //支付成功后记录流水记录
                       
                    //记录导师账户资金信息
                    $course_class = DB::table("course_class")
                                    ->where("id",$item->course_class_id)
                                    ->select("user_id",'explain_url','push_message',"title","id")
                                    ->get();
                    $author_id   = $course_class[0]->user_id;  
                    $finance_a->addOne($author_id);              
                    add_finance_record($item->price,"ADD", $author_id, $payfrom, $item->course_class_id);   //支付成功后记录流水记录
                    DB::table("finance_accounts")->where("user_id", '=', $author_id)->increment("total", $item->price);
                    //购买成功写入消息通知
                    $user = DB::table("users")->where("id",$item->user_id)->select("name","avatar","openid")->get();
                    add_message($author_id,$item->user_id, $user[0]->name, $user[0]->avatar,$item->course_class_title, "BUY");

                    courseSpb($item->user_id,6,$item->course_class_id,$item->price);   //记录赛普币

                    $data['openid'] = $user[0]->openid;
                    $data['type'] = CustomerPushType::IMAGE;

                    $author = Users::where('id',$author_id)->select('name')->first();

                    $title = "【购买成功】".$course_class[0]->title;
                    $desc = $author->name."[导师系列课]：\n".$course_class[0]->push_message."\n点击进入即可查看系列课内容\回复[TD".$course_class[0]->id."]不再接收该导师系列课推送";
                    $data['list'] = [[
                        "title"=>$title,
                        "description"=>$desc,
                        "url"=>env('APP_URL').'/course/detail/'.$item->course_class_id.".html",
                        "picurl"=>'http://image.saipubbs.com/'.$course_class[0]->explain_url]];
                    if($course_class[0]->push_message) {
                        event(new WxCustomerMessagePush($data));
                    }
                }
            }else{
                $pay_log->state = 0;
                $pay_log->save();         //记录有问题支付日志
            }
            DB::commit();
//            $data['openid'] = $user[0]->openid;
//            $data['type']   = WxMessageType::ENROLL;
//            $courseClass    = Courseclass::where('id',$item->course_class_id)->select('title','user_id')->first();
//            $author         = $courseClass->author;
//            $data['notice'] = "支付成功！";
//            $data['url']    = env('APP_URL').'/course/detail?id='.$item->course_class_id;
//            $data['message']['course'] = $courseClass;
//            $data['message']['author'] = $author;
//            event(new WxMessagePush($data));

        }catch(\Exception $e){
            logger()->info($e->getMessage());
            DB::rollback();
        }

        $xml ='<xml>
          <return_code><![CDATA[SUCCESS]]></return_code>
          <return_msg><![CDATA[OK]]></return_msg>
        </xml>';
        echo $xml;  
        return $xml;
    }

    //微信H5支付页面
    public function payH(Request $request){
        $c_id   = $request->input("course_class_id");  // 课程id
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }
        if($user_id && $c_id){
            $order   = new Order();     //订单模型
            $course_class = DB::table("course_class")->where("id",$c_id)->select("id","title","price","course_type")->get();
            $old_order = $order->where("user_id",$user_id)->where("course_class_id",$c_id)->first();
            $couponInfo = $this->couponCard($user_id,$c_id);
            $hasCoupon = $couponInfo['hasCoupon'];
            $payPrice = $course_class[0]->price - $couponInfo['couponPrice'];
            $coupon_id = $couponInfo['coupon_id'];
            if($old_order){
                if($old_order->state==0){
                    $oNumber = $old_order->number;
                    if($hasCoupon){
                        $old_order->price = $payPrice;
                        $old_order->coupon_id = $coupon_id;
                        $old_order->save();
                    }
                }else{

                    echo json_encode(['code'=>0, 'msg'=>'您已购买请联系客服']);
                    return;
                }
            }else{
                $oNumber = date("YmdHis").rand(1000,9999);
                $order->number  = $oNumber;
                $order->user_id = $user_id;
                $order->price   = $payPrice;
                $order->course_class_id = $c_id;
                if($hasCoupon){
                    $order->coupon_id = $coupon_id;
                }
                $order->course_class_title = $course_class[0]->title;
                $order->save();
            }
            if($course_class[0]->course_type == 0){
                $video_id = DB::table("course")->where("course_class_id", $c_id)->select("id")->first();
            }

            logger()->info('video_id_'.$c_id);
            $wxConfig = new \WxPayConfig(); 
            $userip = get_ip();                          //获得用户设备IP 自己网上百度去
            $appid  = $wxConfig->GetAppId();             //微信给的
            $mch_id = $wxConfig->GetMerchantId();        //微信官方的x
            $key    = $wxConfig->GetKey();               //自己设置的微信商家key
            $out_trade_no = $oNumber;                    //平台内部订单号
            $nonce_str    = MD5($out_trade_no);          //随机字符串
            $body         = $course_class[0]->title;     //内容
            $total_fee    = $course_class[0]->price*100; //金额
            $spbill_create_ip = $userip;                 //IP
            $notify_url   = "http://m.saipubbs.com/course/notifyh"; //回调地址
            if($course_class[0]->course_type == 0){
                $redirect_url = urlencode("http://m.saipubbs.com/course/middle/{$c_id}/{$video_id->id}");     //支付成功后跳转页面
            }else{
                $redirect_url = urlencode("http://m.saipubbs.com/activeCourse/addUserInfo/{$c_id}.html");     //支付成功后跳转页面
            }

            $trade_type   = 'MWEB';//交易类型 具体看API 里面有详细介绍
            $scene_info   = '{"h5_info":{"type":"Wap","wap_url":"http://m.saipubbs.com","wap_name":"微信H5支付"}}';//场景信息 必要参数

            $signA ="appid=$appid&body=$body&mch_id=$mch_id&nonce_str=$nonce_str&notify_url=$notify_url&out_trade_no=$out_trade_no&scene_info=$scene_info&spbill_create_ip=$spbill_create_ip&total_fee=$total_fee&trade_type=$trade_type";
            $strSignTmp = $signA."&key=$key"; //拼接字符串  注意顺序微信有个测试网址 顺序按照他的来 直接点下面的校正测试 包括下面XML  是否正确
            $sign = strtoupper(MD5($strSignTmp)); // MD5 后转换成大写
            $post_data = "<xml>
                             <appid>$appid</appid>
                             <body>$body</body>
                             <mch_id>$mch_id</mch_id>
                             <nonce_str>$nonce_str</nonce_str>
                             <notify_url>$notify_url</notify_url>
                             <out_trade_no>$out_trade_no</out_trade_no>
                             <scene_info>$scene_info</scene_info>
                             <spbill_create_ip>$spbill_create_ip</spbill_create_ip>
                             <total_fee>$total_fee</total_fee>
                             <trade_type>$trade_type</trade_type>
                             <sign>$sign</sign>
                         </xml>";//拼接成XML 格式
            $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";//微信传参地址
            $dataxml = wx_http_post($url,$post_data); //后台POST微信传参地址  同时取得微信返回的参数    POST 方法我写下面了
            $objectxml = (array)simplexml_load_string($dataxml, 'SimpleXMLElement', LIBXML_NOCDATA); //将微信返回的XML 转换成数组
            $objectxml['mweb_url'] = $objectxml['mweb_url']."&redirect_url=".$redirect_url;
            //return view('course.payh', ['objectxml'=>$objectxml, "is_buy"=>0]);
            echo json_encode(['code'=>1, 'objectxml'=>$objectxml]);
            return;
        }else{
            echo json_encode(['code'=>0, 'msg'=>'抱歉没有数据了']);
            return;
        }
        
    }
    //赛普币支付
    public function paySpb(Request $request){

        $c_id   = $request->input("c_c_id");  // 课程id
       if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }
        $payfrom = "SPB";
        //开启事务
        DB::beginTransaction();
        try{
            if($user_id && $c_id){
                $order   = new Order();     //订单模型
                $course_class = DB::table("course_class")->where("id",$c_id)->select("id","title","price","user_id")->first();
                $price = $course_class->price; //课程价格
                $old_order = $order->where("user_id",$user_id)->where("course_class_id",$c_id)->first();
                if($old_order){
                    if($old_order->state == 1){
                        echo json_encode(['code'=>0, 'msg'=>"您已购买请联系客服"]);
                        return;
                    }else{
                        $old_order->state = 1;
                        $re =  $old_order->save();
                    }
                }else{
                    $oNumber = date("YmdHis").rand(1000,9999);
                    $order->number  = $oNumber;
                    $order->user_id = $user_id;
                    $order->price   = $price;
                    $order->course_class_id = $c_id;
                    $order->payfrom = $payfrom;
                    $order->state = 1;
                    $order->course_class_title = $course_class->title;
                    $re =  $order->save();
                }
                if($re){
                    $studying  = new Studying();
                    $studying->addOne($user_id, $c_id);    //支付成功后将记录插入正在学习表
                    $CourseClassPush = new CourseClassPush();
                    $CourseClassPush->addOne($user_id, $c_id);            //默认接收课程提醒
                    
                    //购买成功写入消息通知
                    $user = DB::table("users")->where("id",$user_id)->select("name","avatar", "openid")->first();
                    $author_id = $course_class ->user_id;
                    add_message($author_id,$user_id, $user->name, $user->avatar,$course_class->title, "BUY");
                    //记录赛普币
                   // $addSpb = $price * 10;
                    $newPrice =$price * 100;
                    DB::table("users")->where("id", '=', $user_id)->decrement("spb", $newPrice);
                    courseSpb($user_id,6,$c_id,$price);   //记录赛普币
                    $a['user_id'] = $user_id;
                    $a['spb_rule_id'] = 12;
                    $a['courseid'] = $c_id;
                    $a['value'] = -$price * 100;
                    $a['created_at'] = date("Y-m-d H:i:s");
                    DB::table("spb_records")->insert($a);
                    DB::commit();
                    echo json_encode(['code'=>1, 'msg'=>"购买成功"]);
                    return;
                }
            }else{
                echo json_encode(['code'=>0, 'msg'=>"余额不足或购买失败"]);
            }   
        }catch(\Exception $e){
            DB::rollback();
            echo json_encode(['code'=>0, 'msg'=>"余额不足或购买失败1"]);
        }

    }
    //微信H5支付成功回调接口
    public function notifyH(){

        $xml = file_get_contents('php://input');
        $result = xmlToArray($xml);
        $json_d = json_encode($result);
        $time   = time();
        $payfrom= "WXPAYH";
        $pay_log= new Paylog();    //支付日志
        $order  = new Order();     //订单模型
        $pay_log->info   = $json_d;
        $pay_log->c_time = $time;
        //开启事务
        DB::beginTransaction();
        try{
            if($result['return_code']=='SUCCESS'){
                $number = $result['out_trade_no'];
                $item    = $order->where("number",$number)->where("state", 0)->first();
                if($item){
                    $item->state = 1;
                    $item->payfrom = $payfrom;
                    $item->save();        //将订单状态改为1  支付成功
                    $pay_log->state = 2;
                    $pay_log->save();     //记录正常支付日志
                    /*
                     * 优惠券使用
                     */
                    $userCoupon = UserCoupon::where('user_id',$item->user_id)->where('coupon_id',$item->coupon_id)->where('is_use',0)->first();
                    if($userCoupon){
                        $userCoupon->is_use = 1;
                        $userCoupon->save();
                    }
                    //操作客户账户资金信息
                    $finance_a = new FinanceAccount();
                    $finance_a->addOne($item->user_id);                           //查看用户资金账户，如果没有创建一条
                    $studying  = new Studying();
                    $studying->addOne($item->user_id, $item->course_class_id);    //支付成功后将记录插入正在学习表
                    $CourseClassPush = new CourseClassPush();
                    $CourseClassPush->addOne($item->user_id, $item->course_class_id);            //默认接收课程提醒
                    add_finance_record($item->price,"BUY", $item->user_id, $payfrom, $item->course_class_id);   //支付成功后记录流水记录

                    //记录导师账户资金信息
                    $course_class = DB::table("course_class")
                                    ->where("id",$item->course_class_id)
                                    ->select("user_id",'title','push_message','id','explain_url')
                                    ->get();
                    $author_id   = $course_class[0]->user_id;  
                    $finance_a->addOne($author_id);              
                    add_finance_record($item->price,"ADD", $author_id, $payfrom, $item->course_class_id);   //支付成功后记录流水记录
                    DB::table("finance_accounts")->where("user_id", '=', $author_id)->increment("total", $item->price);
                    //购买成功写入消息通知
                    $user = DB::table("users")->where("id",$item->user_id)->select("name","avatar", "openid")->get();
                    add_message($author_id,$item->user_id, $user[0]->name, $user[0]->avatar,$item->course_class_title, "BUY");


                    courseSpb($item->user_id,6,$item->course_class_id,$item->price);   //记录赛普币
                    $data['openid'] = $user[0]->openid;
                    $data['type'] = CustomerPushType::IMAGE;

                    $author = Users::where('id',$author_id)->select('name')->first();

                    $title = "【购买成功】".$course_class[0]->title;
                    $desc = $author->name."[导师系列课]：\n".$course_class[0]->push_message."\n点击进入即可查看系列课内容\n回复[TD".$course_class[0]->id."]不再接收该导师系列课推送";
                    $data['list'] = [[
                        "title"=>$title,
                        "description"=>$desc,
                        "url"=>env('APP_URL').'/course/detail/'.$item->course_class_id.".html",
                        "picurl"=>'http://image.saipubbs.com/'.$course_class[0]->explain_url]];
                    if($course_class[0]->push_message) {
                        event(new WxCustomerMessagePush($data));
                    }
                }
            }else{
                $pay_log->state = 0;
                $pay_log->save();         //记录有问题支付日志
            }
            DB::commit();

        }catch(\Exception $e){
            logger()->info($e->getMessage());
            DB::rollback();
        }

        $xml ='<xml>
          <return_code><![CDATA[SUCCESS]]></return_code>
          <return_msg><![CDATA[OK]]></return_msg>
        </xml>';
        echo $xml;  
        return $xml;
    }

    //客户余额支付购买课程20180821
    public function payBalance(Request $request){
        $user_id = $request->input("user_id");     //用户id
        if(!$user_id){
            if($request->user()){
                $userid = $request->user()->id;
            }else{
                $userid = 0;
            }
        }
        $c_c_id  = $request->input("c_c_id");      //课程id
        $payfrom = "BALANCE";
        
        //开启事务
        DB::beginTransaction();
        try{
            if($user_id && $c_c_id){
                $course_class = DB::table("course_class")
                                    ->where("id",$c_c_id)
                                    ->select("user_id", "price", "title",'id','push_message','explain_url')
                                    ->get();
                $order = Order::where("user_id",$user_id)->where("course_class_id", $c_c_id)->first();
                
                if($order){
                    $order->state   = 1;
                    echo json_encode(['code'=>0, 'msg'=>"您已购买请联系客服"]);
                    return;
                }else{
                    $order   = new Order();     //订单模型
                    $oNumber = date("YmdHis").rand(1000,9999);
                    $order->number  = $oNumber;
                    $order->user_id = $user_id;
                    $order->price   = $course_class[0]->price;
                    $order->course_class_id = $c_c_id;
                    $order->course_class_title = $course_class[0]->title;
                    $order->payfrom = $payfrom;
                    $order->state   = 1;
                    $order->created_at= date("Y-m-d H:i:s");
                } 
                $r = $order->save();
                if($r){
                    //操作客户账户资金信息
                    $finance_a = new FinanceAccount();
                    $finance_a->addOne($user_id);            //查看用户资金账户，如果没有创建一条
                    $studying  = new Studying();
                    $studying->addOne($user_id, $c_c_id);    //支付成功后将记录插入正在学习表
                    $CourseClassPush = new CourseClassPush();
                    $CourseClassPush->addOne($user_id, $c_c_id);            //默认接收课程提醒
                    add_finance_record($course_class[0]->price,"BUY", $user_id, $payfrom, $c_c_id);   //支付成功后记录流水记录
                    DB::table("finance_accounts")->where("user_id", '=', $user_id)->decrement("total", $course_class[0]->price);
                    //记录导师账户资金信息
                    $author_id   = $course_class[0]->user_id;  
                    $finance_a->addOne($author_id);              
                    add_finance_record($course_class[0]->price,"ADD", $author_id, $payfrom, $c_c_id);   //支付成功后记录流水记录
                    DB::table("finance_accounts")->where("user_id", '=', $author_id)->increment("total", $course_class[0]->price);
                    //购买成功写入消息通知
                    $user = DB::table("users")->where("id",$user_id)->select("name","avatar")->get();
                    add_message($author_id,$user_id, $user[0]->name, $user[0]->avatar,$course_class[0]->title, "BUY");

                    courseSpb($user_id,6,$c_c_id,$course_class[0]->price);
                    DB::commit();
                    $data['openid'] = $request->user()->openid;
                    $data['type'] = CustomerPushType::IMAGE;

                    $author = Users::where('id',$author_id)->select('name')->first();

                    $title = "【购买成功】".$course_class[0]->title;
                    $desc = $author->name."[导师系列课]：\n".$course_class[0]->push_message."\n点击进入即可查看系列课内容\n回复[TD".$course_class[0]->id."]不再接收该导师系列课推送";
                    $data['list'] = [[
                        "title"=>$title,
                        "description"=>$desc,
                        "url"=>env('APP_URL').'/course/detail/'.$c_c_id.".html",
                        "picurl"=>'http://image.saipubbs.com/'.$course_class[0]->explain_url]];
                    if($course_class[0]->push_message) {
                        event(new WxCustomerMessagePush($data));
                    }
                    echo json_encode(['code'=>1, 'msg'=>"支付成功"]);
                    return;
                }
            }else{
                echo json_encode(['code'=>0, 'msg'=>"余额不足或购买失败"]);
            }
            
        }catch(\Exception $e){
            logger()->info($e->getMessage());
            logger()->info($e->getLine());
            DB::rollback();

            echo json_encode(['code'=>0, 'msg'=>"余额不足或购买失败1"]);
        }
        
    }

    //测试获取openid
    public function getOpenid(){
        $tools  = new \JsApiPay();
        $openId = $tools->GetOpenid();
        $wxPush = new WxPush();
        $token  = $wxPush->getToken();
        $str1   = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=$token&openid=$openId&lang=zh_CN");
        $wx_user= json_decode($str1, true);
        logger()->info($wx_user);
        return $wx_user['subscribe'];
    }

    //测试微信推送消息
    public function wxPush(){
        
        $result = $this->getOpenid();
        print_r($result);
    }

    //课程详情页面在线咨询20180821
    public function consultation(Request $request,$c_c_id){
        //$c_c_id = $request->input("course_class_id");
        $wechat_number = "";
        $targets       = "";
        if($request->input("wechat_number")){
            $wechat_number = $request->input("wechat_number");   //微信号
        }
        if($request->input("targets")){
            $targets = $request->input("targets");               //学习目标
        }

        if($wechat_number && $targets && $c_c_id){
            $consultation = new Consultation();
            $consultation->course_class_id  = $c_c_id;
            $consultation->targets          = trim($targets, ",");
            $consultation->wechat_number    = $wechat_number;
            $r = $consultation->save();
            if($r){
                echo json_encode(['code'=>1, 'msg'=>"添加成功，稍后老师会和您联系"]);
            }else{
                echo json_encode(['code'=>0, 'msg'=>"添加成功，稍后老师会和您联系"]);
            }
        }else{
            $this->ret['c_c_id'] = $c_c_id;
            return view("course.weixinqun", $this->ret);
            //return view("course.consultation", $this->ret);
        }
        
    }

    //课程邀请卡
    public function detailCard(Request $request,$id){
        
        return view("course.detailcard");
    }

    public function doImage(){
        $ImageThumb  = new ImageThumb();
        $img_url     = $ImageThumb->makePic("/base20180911.jpg", "qr.jpg");
        echo "<img src='/".$img_url[1]."' />";
    }

    public function captureArticle(Request $request){
        $user = $request->user();
        $url = $request->input('url','');
        $tags = $request->input('tags','');
        $tags = trim($tags, ",");
       
        $pattern = '/<title>(.*?)<\/title>/';
        $articlePattern = '/<h1.*?>([\s\S]*?)<([\s\S]*?)\/h1>/';
        $encodePattern = '/charset=(.*?)[\/]*>/';
        $curl = new CurlUtil();
        $result = $curl->curl($url,'','GET');
        preg_match($encodePattern,$result,$char);
        if(!empty($char) && $char[1] != '' && strpos($char[1],'gb') !== false){
            return ['code'=>1,'msg'=>'获取资源失败'];
//            $result = $curl->curl('https://www.sohu.com/a/126857149_500718','','GET','gbk');
        }

        preg_match($pattern,$result,$title);
        preg_match($articlePattern,$result,$artitcleTitle);

        if(empty($title)){
            return ['code'=>1,'msg'=>'获取标题失败'];
        }
        if(!empty($artitcleTitle)){
            $artTitle = $artitcleTitle[1];
        }else{
            $artTitle = '';
        }
        if(!empty($artTitle)){
            if(strpos($title[1],$artTitle) !== false){
                $newTitle = $artTitle;
            }else{
                $newTitle = explode('_',$title[1])[0];
                if($newTitle == $title[1]){
                    $newTitle = explode('|',$title[1])[0];
                }
            }
        }else{
            $newTitle = explode('_',$title[1])[0];
            if($newTitle == $title[1]){
                $newTitle = explode('|',$title[1])[0];
            }
        }

        $recommend = new ArticleRecommend();
        $recommend->user_id = $user->id;
        $recommend->title = $newTitle;
        $recommend->url = $url;
        $recommend->user_id = $user->id;
        $recommend->tag_ids = $tags;
        if($recommend->save()){
            return ['code'=>0,'msg'=>'推荐成功',"id"=>$recommend->id];
        }else{
            return ['code'=>1,'msg'=>'推荐失败'];
        }
    }

    //20181105
    public function coursePlay(Request $request){
        
        $c_c_id   = $request->input("c_c_id");
        $video_id = $request->input("video_id");
       
        if(Redis::exists("course_".$c_c_id."_".$video_id) && Redis::get("course_".$c_c_id."_".$video_id) != ''){
            $json    = Redis::incr("course_".$c_c_id."_".$video_id);
        }else{
            Redis::setex("course_".$c_c_id."_".$video_id, 60*60*24, 1);
        }
        
    }

    //20181105  定时处理redis存储课程及视频播放次数
    public function coursePlayEmpty(){
        $date = date("Ymd");
        if(Redis::keys("course_*") && Redis::keys("course_*") != ''){
            $json    = Redis::keys("course_*");
            foreach($json as $v){
                echo $v."=>".Redis::get($v)."<br/>";
                // $arr = explode("_", $v);
                // $data = array();
                // $data['course_id'] = $arr[2];         //单独视频id
                // $data['course_class_id'] = $arr[1];   //课程id
                // $data['date'] = $date;
                // $data['number'] = Redis::get($v);
                // $data['created_at'] = date("Y-m-d H:i:s");
                // DB::table("course_play_number")->insert($data);
                // empty($arr);
                // empty($data);
                // Redis::del($v);
            }
        }
    }

    /*
     *
     * 注册弹框课程设置
     */
    public function sendCourse(Request $request){

        $courseClass = Courseclass::where('register_free_watch',1)->whereNull('deleted_at')->take(3)->get();
//        dd($courseClass);
        $res = $this->getCourseList($courseClass);
        return $this->getMessage(0,'获取成功',['freeCourse'=>$res]);
    }

    public function getCourseList($courseClass){
        $str = '<div class="zhucelingqu_layer fz"><div class="plr30"><img src="/images/tanchu/liwuhe.png"class="liwuhe"/><dl><dt class="f36 bold">Hi~</dt>
<dd class="f26 bold">欢迎来到赛普健身社区，赛普君送你好课3套~</dd></dl><ul class="list_kecheng">';
        foreach($courseClass as $class) {
//            dd($class);
            if($class->is_free == 0){
                $priceSet = '免费';
            }else{
                $priceSet = $class->price.'元';
            }
            $pic = env('IMG_URL').$class->cover_url;
            $str .= '<li><a href="#" class="thumb"><img src="'.$pic.'" alt="">
            <span>'.($class->courseType->title).'</span></a><div class="con"><h3 class="title text-overflow f26 mb20 bold"><a href="#">'.$class->title.'</a></h3><div class="clearfix wrap"><h4 class="classes fl color_gray666">'.(sum_course($class->id)->count).'节课-'.(sum_study($class->id)->count).'人正在提高中</h4><span class="price fr color_red bold f26">'.$priceSet.'</span></div><div class="clearfix wrap1"><div class="swiper-container tags fl"><div class="swiper-wrapper">';

            $courseTags = $class->courseTag;

            foreach($courseTags as $tags){
                $tag = Tags::where('id',$tags->tag_id)->select('title')->first();
                $str .= '<div class="swiper-slide"><a href="#"><span>'.($tag->title).'</span></a></div>';
            }
            $str .= '</div></div><span class="daoshi fr"><span>'.($class->author->name).'导师</span></span></div></div></li>';
        }

        $str .= '</ul>
        <div class="btns clearfix bold"><a href="javascript:void(0)"class="btn2 fl btn_fangqi">狠心放弃</a><a href="/register"class="btn1 fr">注册领取</a></div></div></div>';

        return $str;

    }

    //修改之后全部课程分类详情页
    public function ctypeDetail($id= 0,$cid= 0){

        if(Redis::exists("cache_course_type_".$cid) && Redis::get("cache_course_type_".$cid) != ''){
            $course_type_id = Redis::get("cache_course_type_".$cid);
        }else{
            $course_type_id = 2;
        }
        //dd($course_type_id );
        //$course_type_id = 1;
        if($course_type_id == 1 || $course_type_id ==2){
            $course = new Courseclass();
            $data = $course->getTypeData($id,$cid);
            $typeName = CourseType::where("id",$id)->select("title","description")->first();

            $this->ret['type'] = $data['type'];
            $this->ret['new'] =$course->getTwoRecommend($id,$cid); //end($data['newData']);
            $this->ret['data'] = $data['data'];
            $this->ret['cid'] = $data['cid'];
            $this->ret['id'] = $id;
            $this->ret['img'] = $data['img'];
            //dd($data);
            $this->ret['title'] = $typeName->title;
            $this->ret['description'] = $typeName->description;
            //dd($course_type_id);
            if($course_type_id == 2){
                return view("course_new.index",$this->ret);
            }else{
                Redis::set("cache_course_type_".$cid, 0);
                file_put_contents(resource_path().'/views/cache/course_index'.$id.'_'.$cid.'.blade.php',view("course_new.index",$this->ret)->__toString());
                return view("cache.course_index".$id.'_'.$cid,$this->ret);
            }
        }else{
            return view("cache.course_index".$id.'_'.$cid,$this->ret);
        }
        

        
    }

    public function courseAll($tagid=0,Request $request){
        if(Redis::exists("cache_course_type_".$tagid) && Redis::get("cache_course_type_".$tagid) != ''){
            $course_type_id = Redis::get("cache_course_type_".$tagid);
        }else{
            $course_type_id = 2;
        }
        if($course_type_id == 1 || $course_type_id ==2){
            $page   = $request->input('page');
            if(empty($page)){
                $page = 1;
            }

            $offset = 5*($page-1);
            $tags = CourseType::where("pid",0)->select("id","title","cover_url")->whereNull("deleted_at")->where("state",1)->get();
            if($tagid == 0){
                $tagid = $tags[0]->id;
            }
            $typeName = CourseType::where("id",$tagid)->select("title")->first();
            $course = new Courseclass();
            $data = $course->getTagData1($tagid,$offset);
            $recommend =$course->getRecommend($tagid);
           // dd($data);
            $this->ret['tags'] = $tags;
            $this->ret['tagid'] = $tagid;
            $this->ret['data'] = $data;
            $this->ret['new'] = $recommend;
            $this->ret['title'] = $typeName->title;
            
            if($course_type_id == 2){
                return view("course_new.courseAll",$this->ret);
            }else{
                Redis::set("cache_course_type_".$tagid, 0);
                file_put_contents(resource_path().'/views/cache/course_all'.$tagid.'.blade.php',view("course_new.courseAll",$this->ret)->__toString());
                return view("cache.course_all".$tagid,$this->ret);
            }

        }else{
            return view("cache.course_all".$tagid,$this->ret);
        }
    }
    public function getCourseJson($tagid,$page){

        $offset = 5*($page-1);
        $course = new Courseclass();
        $data = $course->getTagData1($tagid,$offset);
        foreach($data as $v){
            $v->sum_course = sum_course($v->id)->count;
            $v->sum_study = sum_study($v->id)->count + $v->count;
            $v->teacher_name = get_teacher_name($v->user_id)->name;
        }
        return json_encode($data);

    }

    //20190116 全部活动页
    public function activityAll(){

        //最新活动
        $activity = DB::table("activity")->orderBy("state", "desc")->orderBy("orderby", "desc")->limit(10)->get();
        $this->ret['activity'] = $activity;
        return view("course.allactivity", $this->ret);
    }

    public function courseTab(Request $request){

        $courseTypes = CourseType::where("state",1)->where("pid",0)
            ->orderBy("orderby", "desc")
            ->select("id", "title", "cover_url")->get();
        $data['courseTypes'] = $courseTypes;
        return view('course.tab',$data);
    }
    /*
     * 是否存在优惠券
     */
    private function couponCard($user_id,$course_id=0 ,$group_id=0){
        $coupon = Coupon::where('course_class_id',$course_id)->first();//优惠券
        $couponPrice = 0;
        $hasCoupon = 0;
        $coupon_id = 0;
        if($coupon){
            if($user_id){
                $userCoupon = UserCoupon::where('user_id',$user_id)->where('coupon_id',$coupon->id)->where('is_use',0)->first();
                if($userCoupon){
                    $hasCoupon = 1;
                    $couponPrice = $coupon->price;
                    $coupon_id = $coupon->id;
                }
            }
        }
        return ['hasCoupon'=>$hasCoupon,'couponPrice'=>$couponPrice,'coupon_id'=>$coupon_id];
    }

}





