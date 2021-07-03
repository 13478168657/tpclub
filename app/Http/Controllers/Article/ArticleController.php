<?php

namespace App\Http\Controllers\Article;

use App\Models\Article;
use App\Models\Courseclass;
use App\Models\Type;
use App\Models\Tags;
use App\Models\ArticleCollect;
use App\Models\ArticleComment;
use App\Models\ArticleLikeRecord;
use App\Models\CommonAskQuestion;
use App\Models\Users;
use App\Models\UsersAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\Studying;
use App\Models\SearchKeyword;
use App\Models\Follow;
use App\Models\Comment;
use App\Constant\CommentDate;
use App\Models\Consultation;
use App\Models\ArticleRecommend;
use App\Models\CourseClassGroup;
use App\Models\DisCourseClass;
use App\Events\WxMessagePush;
use App\Constant\WxMessageType;
use App\Models\CourseClassPush;
use App\Models\AdCourseSet;
use App\Utils\CurlUtil;
use App\Events\WxCustomerMessagePush;
use App\Constant\CustomerPushType;
use Illuminate\Support\Facades\Redis;

class ArticleController extends Controller
{
    protected $ret;
    protected $page;

    public function __construct()
    {
        $this->ret = [];
        $this->page = 10;
    }

    /**
     * .文章首页
     * 20181012
     * 20181201 旧版文章发现页
     */
    public function indexold(Request $request, $type_id)
    {
        if(Redis::exists("cache_article_type_".$type_id) && Redis::get("cache_article_type_".$type_id) != ''){
            $article_type_id = Redis::get("cache_article_type_".$type_id);
        }else{
            $article_type_id = 2;
        }
        if($article_type_id==1 || $article_type_id==2){
            
            if($request->user()){
                $userid = $request->user()->id;
            }else{
                $userid = 0;
            }
            $type_id = $type_id ? $type_id : 0;   
            $type    = new Type();
            $typelist= $type->getList("ARTICLE");   //首页显示的类别
            if($type_id==0){
                $cid = 0;
            }else{
                foreach($typelist as $k=>$v){
                    if($v->id==$type_id){
                        $cid = $k+1;
                    }
                }
            }

            $article = new Article();
            if($type_id==0){
                //精选文章
                $articlelist = $article::where("state",1)->where("is_selected", 1)
                                ->select("id", "title", "cover_url", "user_id", "likes", "views", "created_at", "is_video","is_selected")
                                ->orderBy("id","desc")
                                ->paginate(10);
                $title = "精选文章";
                $description = "赛普健身社区是赛普健身旗下针对于健身行业量身打造的一款私教健身资讯平台，帮助私人健身教练提高健身水平，让更多健身人事学习更多健身知识。";                  
            }else{
                //类别文章
                $articlelist = $article::where("state",1)->where("type_ids", "like", '%'.$type_id.'%')
                                ->select("id", "title", "cover_url", "user_id", "likes", "views", "created_at", "is_video","is_selected")
                                ->orderBy("id","desc")
                                ->paginate(10);
                $seoinfo = $type->where("id", $type_id)->select("seo_title", "seo_description")->first();  
                $title   = $seoinfo->seo_title ? $seoinfo->seo_title : "精选文章";
                $description = $seoinfo->seo_description ? $seoinfo->seo_description : "赛普健身社区是赛普健身旗下针对于健身行业量身打造的一款私教健身资讯平台，帮助私人健身教练提高健身水平，让更多健身人事学习更多健身知识。";             
            }
            $is_local = env("IS_LOCAL");
            if($is_local){
                $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
            }else{
                $this->ret['WechatShare'] = getSignPackage();
            }
            $fission_id = $request->input("fission_id", 0);   //裂变者id
            $this->ret['fission_id'] = $fission_id;//裂变者id
            $this->ret['typelist'] = $typelist;
            $this->ret['type_id']  = $type_id;
            $this->ret['cid']      = $type_id;
            $this->ret['title']    = $title;
            $this->ret['description'] = $description;
            $this->ret['articlelist'] = $articlelist;
            $this->ret['user_id'] = $userid;
            if($article_type_id==2){
                //读取数据库
                return view("article.index", $this->ret);
            }else{
                //读取数据库并生成缓存文件
                Redis::set("cache_article_type_".$type_id, 0);
                file_put_contents(resource_path().'/views/cache/index'.$type_id.'.blade.php',view("article.index",$this->ret)->__toString());
                return view("cache.index".$type_id,$this->ret);
            }
        }else{
            //读取缓存文件
            return view("cache.index".$type_id,$this->ret);
        }
        
    }
    /**
     * 新版文章首页
     *
     * 20181201 
     */
    public function index(Request $request, $type_id)
    {
        
        if(Redis::exists("cache_article_type_".$type_id) && Redis::get("cache_article_type_".$type_id) != ''){

            $article_type_id = Redis::get("cache_article_type_".$type_id);
        }else{
            $article_type_id = 2;
        }

        if($article_type_id==1 || $article_type_id==2){

            if($request->user()){
                $userid = $request->user()->id;
            }else{
                $userid = 0;
            }
            $type_id = $type_id ? $type_id : 0;   
            $type    = new Type();
            $typelist= $type->getList("ARTICLE");   //首页显示的类别
            if($type_id==0){
                $cid = 0;
            }else{
                foreach($typelist as $k=>$v){
                    if($v->id==$type_id){
                        $cid = $k+1;
                    }
                }
            }

            $article = new Article();
            if($type_id==0){
                $selected = DB::table("article_selected")
                            ->where("today", "<=", date("Y-m-d"))
                            ->orderBy("today_timestamp", "desc")
                            ->select("article_ids","today")->skip(0)->take(5)->get();
                //精选文章
                $title = "精选";
                $description = "赛普健身社区是赛普健身旗下针对于健身行业量身打造的一款私教健身资讯平台，帮助私人健身教练提高健身水平，让更多健身人事学习更多健身知识。";  
                $this->ret['selected'] = $selected;                
            }else{
                //类别文章
                $articlelist = $article::where("state",1)->where("type_ids", "like", '%'.$type_id.'%')
                                ->select("id", "title", "cover_url", "user_id", "likes", "views", "created_at", "is_video","is_selected")
                                ->orderBy("updated_at","desc")
                                ->paginate(10);
                $seoinfo = $type->where("id", $type_id)->select("seo_title", "seo_description")->first();  
                $title   = $seoinfo->seo_title ? $seoinfo->seo_title : "精选文章";
                $description = $seoinfo->seo_description ? $seoinfo->seo_description : "赛普健身社区是赛普健身旗下针对于健身行业量身打造的一款私教健身资讯平台，帮助私人健身教练提高健身水平，让更多健身人事学习更多健身知识。";
                 $this->ret['articlelist'] = $articlelist;
            }
            $is_local = env("IS_LOCAL");
            if($is_local){
                $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
            }else{
                $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
                //$this->ret['WechatShare'] = getSignPackage();
            }
            $fission_id = $request->input("fission_id", 0);   //裂变者id
            $this->ret['fission_id'] = $fission_id;//裂变者id
            $this->ret['typelist'] = $typelist;
            $this->ret['type_id']  = $type_id;
            $this->ret['cid']      = $type_id;
            $this->ret['title']    = $title;
            $this->ret['description'] = $description;
           
            $this->ret['user_id'] = $userid;

            if($article_type_id==2){
                //读取数据库
                if($type_id==0){
                    return view("article.indextest0",$this->ret);
                }else{
                    return view("article.indextest",$this->ret);
                }
            }else{
                //读取数据库并生成缓存文件
                Redis::set("cache_article_type_".$type_id, 0);
                if($type_id==0){

                    file_put_contents(resource_path().'/views/cache/index'.$type_id.'.blade.php',view("article.indextest0",$this->ret)->__toString());
                    return view("cache.index".$type_id,$this->ret);
                }else{
                    file_put_contents(resource_path().'/views/cache/index'.$type_id.'.blade.php',view("article.indextest",$this->ret)->__toString());
                    return view("cache.index".$type_id,$this->ret);
                }
            }
        }else{
            //读取缓存文件
            return view("cache.index".$type_id,$this->ret);
        }
    }

    public function question(Request $request, $type_id)
    {
        
        if(Redis::exists("cache_article_type_".$type_id) && Redis::get("cache_article_type_".$type_id) != ''){
            $article_type_id = Redis::get("cache_article_type_".$type_id);
        }else{
            $article_type_id = 2;
        }
        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();  //微信分享
        }
       
        $article_type_id = 2;
        if($article_type_id==1 || $article_type_id==2){
            if($request->user()){
                $userid = $request->user()->id;
            }else{
                $userid = 0;
            }
            if(Redis::exists("index_q_type") && Redis::get("index_q_type") !=""){
                $index_q_type_json = Redis::get("index_q_type");
                $q_type = json_decode($index_q_type_json);
            }else{
                $q_type = DB::table("type")->where("model","ARTICLE")->where("is_index",0)->where("state",1)->get();
                $index_q_type_json = json_encode($q_type);
                Redis::setex("index_q_type", 7200, $index_q_type_json);
            }

            $article = new Article();
            //类别文章
            $articlelist = $article::where("state",1)->where("type_ids", "like", '%'.$type_id.'%')
                            ->select("id", "title", "cover_url", "user_id", "likes", "views", "created_at", "is_video","is_selected")
                            ->orderBy("id","desc")
                            ->paginate(10);
            $seoinfo = DB::table("type")->where("id", $type_id)->select("seo_title", "seo_description")->first();  
            $title   = $seoinfo->seo_title ? $seoinfo->seo_title : "精选文章";
            $description = $seoinfo->seo_description ? $seoinfo->seo_description : "赛普健身社区是赛普健身旗下针对于健身行业量身打造的一款私教健身资讯平台，帮助私人健身教练提高健身水平，让更多健身人事学习更多健身知识。"; 
             $this->ret['articlelist'] = $articlelist;
            
            $is_local = env("IS_LOCAL");
            if($is_local){
                $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
            }else{
                $this->ret['WechatShare'] = getSignPackage();
            }
            $fission_id = $request->input("fission_id", 0);   //裂变者id
            $this->ret['fission_id'] = $fission_id;//裂变者id
            $this->ret['typelist'] = $q_type;
            $this->ret['type_id']  = $type_id;
            $this->ret['cid']      = $type_id;
            $this->ret['title']    = $title;
            $this->ret['description'] = $description;
            $this->ret['user_id'] = $userid;
            //echo $article_type_id;
            if($article_type_id==2){
                //读取数据库
                return view("article.indexquestion",$this->ret);
            }else{
               
                //读取数据库并生成缓存文件
                Redis::set("cache_article_type_".$type_id, 0);
                file_put_contents(resource_path().'/views/cache/indexquestion'.$type_id.'.blade.php',view("article.indexquestion",$this->ret)->__toString());
                return view("cache.indexquestion".$type_id,$this->ret);
            }
        }else{
            //读取缓存文件
            return view("cache.indexquestion".$type_id,$this->ret);
        }
    }

    /**
     * 文章标签页面
     * 20181130
     */
    public function articleSelectedMore(Request $request){
        $page    = $request->input("page") ?  $request->input("page") : 1;
        $offset  = 5*($page-1);
       
        $selected = DB::table("article_selected")
                        ->orderBy("today_timestamp", "desc")
                        ->select("article_ids","today")->skip($offset)->take(5)->get();
        if($selected){
            return json_encode(array("code"=>1, "list"=>view('article.body.aritcleBody',['selected'=>$selected])->render(),"msg"=>"抱歉没有更多的数据了"));
        }else{
            return json_encode(array("code"=>0, "msg"=>"抱歉没有更多的数据了"));
        }                
                        
    }

    /**
     * .文章标签页面
     * 20181015
     */
    public function articleTag(Request $request, $tag_id)
    {
       
        $tag     = Tags::where("id", $tag_id)->first();
        $article = new Article();
        //标签文章
        $articlelist = $article::where("state",1)->where("tag_ids", "like", '%'.$tag_id.'%')
                            ->select("id", "title", "cover_url", "user_id", "likes", "views", "created_at", "is_video","is_selected")
                            ->orderBy("id","desc")
                            ->paginate(10);
        
        $this->ret['tag_id']  = $tag_id;
        $this->ret['tag']     = $tag;
        $this->ret['articlelist'] = $articlelist;
        return view("article.tag", $this->ret);
    }

    /**
     * .文章标签页面
     * 20181015
     */
    public function articleMore(Request $request)
    {
        
        $type    = $request->input("type");
        $page    = $request->input("page") ?  $request->input("page") : 1;
        $offset  = $this->page*($page-1);
        if($type=='tag'){
            $tag_id = $request->input("tag_id");
        }else{
            $type_id= $request->input("type_id");
        }
        $article = new Article();
        //标签文章
        if($tag_id){
            $articlelist = $article::where("state",1)->where("tag_ids", "like", '%'.$tag_id.'%')
                            ->select("id", "title", "cover_url", "user_id", "likes", "views", "created_at", "is_video","is_selected")
                            ->orderBy("id","desc")
                            ->offset($offset)->limit($this->page)->get();
        }else{
            if($type_id==0){
                $articlelist = $article::where("state",1)->where("is_selected", 1)
                            ->select("id", "title", "cover_url", "user_id", "likes", "views", "created_at", "is_video","is_selected")
                            ->orderBy("id","desc")
                             ->offset($offset)->limit($this->page)->get();
            }else{
                $articlelist = $article::where("state",1)->where("type_ids", "like", '%'.$type_id.'%')
                            ->select("id", "title", "cover_url", "user_id", "likes", "views", "created_at", "is_video","is_selected")
                            ->orderBy("id","desc")
                            ->offset($offset)->limit($this->page)->get();
            }
            
        }
        
        if($articlelist->count()){
            foreach($articlelist as &$article){
                $article->user_name = $article->author->name;
                $article->avatar    = $article->author->avatar;
                $article->created   = substr($article->created_at,0,10);
            }
            echo json_encode(['code'=>1, 'list'=>$articlelist]);
            return;
        }else{
            echo json_encode(['code'=>0, 'msg'=>'没有更多的文章了']);
            return;
        }
    }

    /**
     * .文章标签页面
     * 20181015
     */
    public function articleMoreIndex(Request $request)
    {
        
        $type    = $request->input("type");
        $page    = $request->input("page") ?  $request->input("page") : 1;
        $offset  = $this->page*($page-1);
        
        $type_id= $request->input("type_id") ? $request->input("type_id") : 0;
        
        $article = new Article();
        //标签文章
        logger()->info(111);
        if($type_id==0){
            logger()->info(222);
            $articlelist = $article::where("state",1)->where("is_selected", 1)
                        ->select("id", "title", "cover_url", "user_id", "likes", "views", "created_at", "is_video","is_selected")
                        ->orderBy("id","desc")
                         ->offset($offset)->limit($this->page)->get();
        }else{
            logger()->info(333);
            $articlelist = $article::where("state",1)->where("type_ids", "like", '%'.$type_id.'%')
                        ->select("id", "title", "cover_url", "user_id", "likes", "views", "created_at", "is_video","is_selected")
                        ->orderBy("id","desc")
                        ->offset($offset)->limit($this->page)->get();
        }
        if($articlelist->count()){
            foreach($articlelist as &$article){
                $article->user_name = $article->author->name;
                $article->avatar    = $article->author->avatar;
                $article->created   = substr($article->created_at,0,10);
            }
            logger()->info(444);
            echo json_encode(['code'=>1, 'list'=>$articlelist]);
            return;
        }else{
            echo json_encode(['code'=>0, 'msg'=>'没有更多的文章了']);
            return;
        }
    }

    /**
     * .文章详情页
     * 20181012
     */
    public function detail(Request $request, $id)
    {
        if($request->user()){
            $user_id = $request->user()->id;
            $mobile  = $request->user()->mobile ? $request->user()->mobile : 0;  //用户手机号
            if(strpos($request->user()->avatar,'http')){
                $avatar = env('IMG_URL').$request->user()->avatar;
            }else{
                $avatar = $request->user()->avatar;
            }
            $user_name = $request->user()->nickname ? $request->user()->nickname : "ID:".$user_id;
        }else{
            $user_id = 0;
            $mobile  = 0;
            $avatar  = "";
            $user_name = "--";
        }

        if($user_id != 0){
            Redis::incr('article_visit_'.date('Ymd').'_'.$user_id);
        }

        $fission_id = $request->input("fission_id", 0); 
        $content   = 0; //默认咨询或就业老师
        $f_avatar  = "/images/userImg.png";
        $f_name    = "暂无昵称";
        $f_wx_code = "self/qr.png";
        if($fission_id){
            //通过属性信息确认是否显示咨询老师或者就业老师信息
            
            $attribute = UsersAttribute::where('user_id',$fission_id)->first();
            if(isset($attribute) && ($attribute->is_fission==1 || $attribute->can_dist==1)){
                $fission = Users::where("id", $fission_id)->first();
                if($fission->avatar){
                    if(strpos($fission->avatar,'http') !== false){
                        $f_avatar = $fission->avatar;
                    }else{
                        $f_avatar = env('IMG_URL').$fission->avatar;
                    }   
                }
                $f_name   = $fission->nickname ? $fission->nickname : '暂无昵称';
                $content  = 1;
                $f_wx_code= $fission->wx_code ? $fission->wx_code : "self/qr.png";
            }
        }
        $article = Article::where("id", $id)->first();
        $userAttribute = UsersAttribute::where('user_id',$user_id)->where('article_verify',1)->first();
        if($article->user_id != $user_id && !$userAttribute){
            $article = Article::where("id", $id)->where('state',1)->first();
        }
        $can_verify = 1;
        if(!$article){
            return redirect('/');
        }
        if($article->user_id == $user_id){
            $can_verify = 0;
        }

        $comments= ArticleComment::where("article_id", $id)->orderBy("id", "desc")->offset(0)->limit(2)->get();
        $follow = new Follow();
        if(!$article){
            logger()->info('文章id__'.$id);
        }
        $item = $follow->where(['user_id'=>$article->user_id, 'fans_id'=>$user_id])->first();
        if($item){
            $article->is_follow = 1;  //已关注
        }else{
            $article->is_follow = 0;  //未关注
        }
        $selectCourse = '';
        $linkUrl = '';
        $flag = 0;
        if($article->union_type == 'UNLINE' || $article->union_type == 'COURSE'){
            $selectCourse = Courseclass::where('id',$article->union_course_id)->first();
            $selectCourse->cover_url = $selectCourse->explain_url;
            $linkUrl = '/course/detail/'.$selectCourse->id.'.html';
            $flag = 1;
        }elseif($article->union_type == 'GROUP'){
            $selectCourse = CourseclassGroup::where('id',$article->union_course_id)->first();
            $linkUrl = '/train/study.html?id='.$article->union_course_id;
            $selectCourse->cover_url = $selectCourse->list_url;
            $flag = 1;
        }elseif($article->union_type == 'TRAIN'){
            $selectCourse = DisCourseClass::where('id',$article->union_course_id)->first();
            $linkUrl = '/coach/'.$article->union_course_id.'.html';
            $flag = 1;
        }
        if($flag == 0){
            $adCourse = AdCourseSet::first();
            if($adCourse){
                if($adCourse->union_type == 'COURSE'){
                    $selectCourse = Courseclass::where('id',$adCourse->union_id)->first();
                    $linkUrl = '/course/detail/'.$adCourse->union_id.'.html';
                }elseif($article->union_type == 'GROUP'){
                    $selectCourse = CourseclassGroup::where('id',$adCourse->union_id)->first();
                    $linkUrl = '/train/study.html?id='.$adCourse->union_id;
                }elseif($article->union_type == 'TRAIN'){
                    $selectCourse = DisCourseClass::where('id',$adCourse->union_id)->first();
                    $linkUrl = '/coach/'.$adCourse->union_id.'.html';
                }
            }
        }
        //文章浏览数加1
        DB::table("article")->where("id",$id)->increment("views",1);

        $tags    = explode(",", $article->tag_ids);
//        dd($selectCourse);
        $this->ret['selectCourse'] = $selectCourse;
        $this->ret['userAttribute'] = $userAttribute;
        $this->ret['linkUrl'] = $linkUrl;
        $this->ret['can_verify'] = $can_verify;
        $this->ret['article'] = $article;      //文章详情
        $this->ret['tags']    = $tags;         //标签数组
        $this->ret['comments']= $comments;     //最新评论
        $this->ret['user_id'] = $user_id;      //用户id
        $this->ret['user_name'] = $user_name;    //用户姓名
        $this->ret['avatar']  = $avatar;       //用户头像
        $this->ret['mobile']  = $mobile;       //用户手机号
        $this->ret['article_id'] = $id;        //文章id
        $this->ret['fission_id'] = $fission_id;//裂变者id
        $this->ret['content']    = $content;   //是否显示期刊导师信息
        $this->ret['f_avatar']   = $f_avatar;  //是否显示期刊导师信息
        $this->ret['f_nickname'] = $f_name;    //是否显示期刊导师信息
        $this->ret['f_wx_code']  = $f_wx_code; //是否显示期刊导师信息
        $this->ret['utm_source'] = $request->input('utm_source','');
        $this->ret['utm_medium'] = $request->input('utm_medium','');
        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        if($article->is_video){
            $tag_id_array = explode(',', $article->tag_ids);
            foreach($tag_id_array as $k=>$tag_id){

                if($k==0){
                    $abouts = Article::where("tag_ids",  "like", '%'.$tag_id);
                }else{
                    $abouts = Article::orWhere("tag_ids",  "like", '%'.$tag_id);
                }
                
            }
            $abouts = $abouts->where("id", "!=", $id)->orderBy("id", "desc")->limit(3)->get();
            $this->ret['abouts'] = $abouts;        //相关文章
            return view("article.detailvideo", $this->ret);
        }else{
            $tag_id_array = explode(',', $article->tag_ids);

            foreach($tag_id_array as $k=>$tag_id){
                if($k==0){
                    $abouts = Article::where("tag_ids",  "like", '%'.$tag_id);
                }else{
                    $abouts = Article::orWhere("tag_ids",  "like", '%'.$tag_id);
                }
                
            }
            $r = is_question($article->type_ids);
            if($r==1){
                $abouts = $abouts->where("id", "!=", $id)->where("is_video",1)->orderBy("id", "desc")->limit(3)->get();
                $this->ret['abouts'] = $abouts;        //相关文章
                return view("article.detail_question", $this->ret);
            }else{
                $abouts = $abouts->where("id", "!=", $id)->orderBy("id", "desc")->limit(3)->get();
                $this->ret['abouts'] = $abouts;        //相关文章
                return view("article.detail", $this->ret);
            }
            
        }
        
    }

    /**
     * 文章收藏/取消收藏
     * 20181015
     */
    public function collect(Request $request){
        $user_id = $request->input("user_id");
        $article_id = $request->input("article_id");
        $article_collect = $request->input("article_collect");
        if($user_id && $article_id){
            if($article_collect){
                $r = DB::table('article_collect')->where([['user_id',"=",$user_id],["article_id","=",$article_id]])->delete();
                if($r){
                echo json_encode(['code'=>1, 'msg'=>'取消收藏']);
                return;
            }
            }else{
                $article = new ArticleCollect();
                $article->user_id = $user_id;
                $article->article_id = $article_id;
                $r = $article->save();
                if($r){
                    $spburl = $request->input("spburl")?$request->input("spburl"):"18";
                    courseSpb($user_id,$spburl,$article_id);
                    echo json_encode(['code'=>1, 'msg'=>'收藏成功']);
                    return;
                }
            }
            echo json_encode(['code'=>0, 'msg'=>'参数错误']);
            return;
        }else{
            echo json_encode(['code'=>0, 'msg'=>'参数错误']);
            return;
        }
    }

    /**
     * 文章喜欢/取消喜欢
     * 20181015
     */
    public function like(Request $request){
        $user_id = $request->input("user_id");
        $article_id = $request->input("article_id");
        $article_like = $request->input("article_like");
        if($user_id && $article_id){
            if($article_like){
                $r = DB::table('article_like_records')->where([['user_id',"=",$user_id],["article_id","=",$article_id]])->delete();
                if($r){
                    //文章喜欢数减1
                    DB::table("article")->where("id",$article_id)->decrement("likes",1);
                    echo json_encode(['code'=>1, 'msg'=>'取消喜欢']);
                    return;
                }
            }else{
                $articleLike = new ArticleLikeRecord();
                $articleLike->user_id = $user_id;
                $articleLike->article_id = $article_id;
                $r = $articleLike->save();
                if($r){
                    //文章喜欢数加1
                    DB::table("article")->where("id",$article_id)->increment("likes",1);
                    $spburl = $request->input("spburl")?$request->input("spburl"):"17";
                    courseSpb($user_id,$spburl,$article_id);
                    echo json_encode(['code'=>1, 'msg'=>'喜欢成功']);
                    return;
                }
            }
            echo json_encode(['code'=>0, 'msg'=>'参数错误']);
            return;
        }else{
            echo json_encode(['code'=>0, 'msg'=>'参数错误']);
            return;
        }
    }

    /**
     * 文章评论列表
     * 20181015
     */
    public function ArticleComments(Request $request, $article_id)
    {
        if($request->user()){
            $user_id = $request->user()->id;
            $mobile  = $request->user()->mobile ? $request->user()->mobile : 0;  //用户手机号
            if(strpos($request->user()->avatar,'http')){
                $avatar = env('IMG_URL').$request->user()->avatar;
            }else{
                $avatar = $request->user()->avatar;
            }
            $user_name  = $request->user()->nickname ? $request->user()->nickname : "ID:".$user_id;    //用户姓名
        }else{
            $user_id = 0;
            $mobile  = 0;  //用户手机号
            $user_name = "暂无";
            $avatar    = "/images/my/nophoto.jpg";
        }
        $comment  = new ArticleComment();
        $comments = $comment->getList($article_id);  //最新评论
        $is_true  = DB::table("comments")->where(['article_id'=>$article_id, "user_id"=>$user_id])->select("id")->first();   //查看客户是否评论该课程
        
        //dd($comments);
        $this->ret['comments']   = $comments;
        $this->ret['article_id'] = $article_id;
        $this->ret['is_true']    = $is_true ? 1 : 0;
        $this->ret['user_id']    = $user_id;    //用户id
        $this->ret['user_name']  = $user_name;  //用户姓名
        $this->ret['avatar']  = $avatar;        //用户头像
        $this->ret['mobile']  = $mobile;        //用户手机号
        return view("article.comments", $this->ret);
    }


    //20181015 ajax添加评论
    public function commentInsert(Request $request){
        $user_id     = $request->input('user_id');
        $article_id  = $request->input('article_id');
        $content     = $request->input('content');
       // $item    = DB::table("course_class")->where("id", $c_c_id)->select("user_id","title")->first();
        if($user_id && $article_id && $content){
            $user = DB::table("users")->where("id",$user_id)->select("name","avatar",'openid')->get();
            $data = array();
            $data['user_id']    = $user_id;
            $data['article_id'] = $article_id;
            $data['content']    = $this->filterSpecialChar($content);
            $data['created_at']   = date("Y-m-d H:i:s");
            $data['user_name']    = $user[0]->name;
            $result = DB::table("article_comments")->insert($data);
            if($result){
                //评论成功写入消息通知
                // add_message($item->user_id,$user_id, $user[0]->name, $user[0]->avatar,$item->title, "COMMENT", $text);
                // courseSpb($user_id,7,$c_c_id);

                // $dataInfo['type'] = WxMessageType::COMMENT;
                // $dataInfo['url'] = env('APP_URL').'/course/detail?id='.$c_c_id;
                // $author = Users::where('id',$item->user_id)->select('name')->first();
                // $dataInfo['notice'] = '感谢你的评论！';
                // $dataInfo['message']['course'] = $item;
                // $dataInfo['message']['author'] = $author;
                // $dataInfo['openid'] = $user[0]->openid;
                // event(new WxMessagePush($dataInfo));
                courseSpb($user_id,16,$article_id);
                echo json_encode(['code'=>1, 'msg'=>"评价成功！"]);
                return;
            }
        }
        echo json_encode(['code'=>0, 'msg'=>'添加失败，稍后请重试']);
    }

    //20181015 评论加载更多
    public function commentMore(Request $request){
        $page   = $request->input('page');
        $offset = 10*($page-1);
        $article_id = $request->input('article_id');
        
        if($page && $article_id){
            $comment  = new ArticleComment();
            $comments = $comment->getList($article_id, $offset);  //评论列表
            if($comments->count()){
                foreach($comments as &$item){
                    if($item->author){
                        $item->user_name   = $item->author->name;
                        $item->user_avatar = $item->author->avatar;
                        $item->stars       = stars($item->score, "comments");
                        $item->created_a   = CommentDate::getDate($item->created_at);
                    }
                }
                echo json_encode(['code'=>1, 'list'=>$comments]);
                return;
            }
        }
        echo json_encode(['code'=>0, 'msg'=>'抱歉没有数据了']);
    }

    //20181015 ajax删除评论
    public function commentDel(Request $request){
        $comment_id = $request->input('article_id');
        if($comment_id){
            $comment  = new ArticleComment();
            $r = $comment->where("id", $comment_id)->delete();
            if($r){
                echo json_encode(['code'=>1, 'msg'=>'删除成功']);
                return;
            }
        }
        echo json_encode(['code'=>0, 'msg'=>'网络错误~失败啦']);
    }

    /**
     * 检索页面
     * 20181017
     */
    public function search(Request $request){
        $keywords = SearchKeyword::where("state", 1)->orderBy("orderby", "desc")->select("keyword")->get();
        $this->ret['keywords'] = $keywords;
        return view("article.search", $this->ret);
    }

    /**
     * 检索页面
     * 20181017
     */
    public function searchResult(Request $request){
        $k = $request->input("k");

        $courseclass = Courseclass::where("state",1)->where("title", "like", '%'.$k.'%')
                        ->whereNull("deleted_at")
                        ->where("is_hide",0)
                        ->orderBy("id","desc")
                        ->offset(0)->limit(20)->get();

        foreach($courseclass as &$item){
            $item->sum_course = sum_course($item->id)->count;
            $item->sum_study  = sum_study($item->id)->count+$item->studying_num;
            $item->tags       = get_course_class_tag($item->id);
        }
        
        $articlelist = Article::where("state",1)->where("title", "like", '%'.$k.'%')
                            ->select("id", "title", "cover_url", "user_id", "likes", "views", "created_at", "is_video","is_selected")
                            ->whereNull("deleted_at")
                            ->orderBy("id","desc")
                            ->offset(0)->limit(20)->get();
        $commonQuestionList = CommonAskQuestion::where('is_ans',1)
            ->where('title','like','%'.$k.'%')
            ->orderBy('id','desc')
            ->offset(0)
            ->limit(20)
            ->get();;
        $this->ret['k']       = $k;
        $this->ret['courses'] = $courseclass; 
        $this->ret['articlelist'] = $articlelist;    
        $this->ret['questionList'] = $commonQuestionList;
        return view("article.searchr", $this->ret);
    }


    /**
     * 文章推荐页面
     * 20181023
     */
    public function recommend(Request $request){
       
        return view("article.recommend");
    }

    /**
     * 文章推荐解析成功页面
     * 20181023
     */
    public function recommendSuccess(Request $request,$id){
        $user_id = $request->user()->id;
        $recommend = ArticleRecommend::where("id", $id)->select("id","title", "url")->first();
        

        $this->ret['recommend'] = $recommend;
        return view("article.recommendsuccess", $this->ret);
    }

    /**
     * 文章推荐发布页面
     * 20181023
     */
    public function release(Request $request,$id){
        $user_id = $request->user()->id;
        courseSpb($user_id,13);
        
        return view("article.release");
    }


    /**
     * 查看所有文章链接  临时接口
     * 20181113
     */
    public function allLink(){
        $articlelist = Article::where("state", 1)->get();
        foreach($articlelist as $article){
            echo "http://m.saipubbs.com/article/detail/".$article->id.".html"."<br/>";
        }
    }

    /**
     * 导用户数据  临时接口
     * 20181113
     */
    public function userData(){
        $growing = DB::table("users_growing")->where("mobile", ">", 1)->where("code", 20)->
                    select("id","name", "mobile","code","created_at")->first();
        if($growing){
            $item['name']        = $growing->name;
            $item['mobile1']     = $growing->mobile;
            $item['inputTime']   = $growing->created_at;
            $item['sourceType']  = 2;   //1： 表单       2： 赛普健身社区            
            $r = $this->request_post($item);
            DB::table("users_growing")->where("id", $growing->id)->update(array("code"=>$r['code'], "msg"=>$r['msg']));
            dd($r);
        }
    }
    /**
     * 导用户数据到信息运营中心  临时接口
     * 20181113
     */
    protected function request_post($info=''){
        if (empty($info)) {
            return array("code"=>'200', "msg"=>"参数有误");
        }
        $postUrl = "isaipu.net/market/QuasiTraineeInfo/officialapi";
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $info);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        return json_decode($data,true);
    }




    /**
     * .专题文章详情页
     * 
     */
    public function special(Request $request, $id,$sid)
    {

        if($request->user()){
            $user_id = $request->user()->id;
            $mobile  = $request->user()->mobile ? $request->user()->mobile : 0;  //用户手机号
            if(strpos($request->user()->avatar,'http')){
                $avatar = env('IMG_URL').$request->user()->avatar;
            }else{
                $avatar = $request->user()->avatar;
            }
            $user_name = $request->user()->name ? $request->user()->name : "ID:".$user_id;
        }else{
            $user_id = 0;
            $mobile  = 0;
            $avatar  = "";
            $user_name = "--";
        }
        $fission_id = $request->input("fission_id", 0); 
        $article = Article::where("id", $id)->first();
        $follow = new Follow();
        $item = $follow->where(['user_id'=>$article->user_id, 'fans_id'=>$user_id])->first();
        if($item){
            $article->is_follow = 1;  //已关注
        }else{
            $article->is_follow = 0;  //未关注
        }
        
        //文章浏览数加1
        DB::table("article")->where("id",$id)->increment("views",1);
        //
        $tags    = explode(",", $article->tag_ids);
        $this->ret['article'] = $article;      //文章详情
        $this->ret['tags']    = $tags;         //标签数组
        $this->ret['user_id'] = $user_id;      //用户id
        $this->ret['user_name'] = $user_name;    //用户姓名
        $this->ret['avatar']  = $avatar;       //用户头像
        $this->ret['mobile']  = $mobile;       //用户手机号
        $this->ret['article_id'] = $id;        //文章id
        $this->ret['fission_id'] = $fission_id;//裂变者id
        $this->ret['sid'] = $sid;
        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();  //微信分享
        }
        $abouts = $article->where("special_id","like","%".$sid."%")->where("id", "!=", $id)->orderBy("id", "desc")->limit(3)->get();
        //dd($abouts);
        //
        $next_article = Article::where("special_id","like","%".$sid."%")->where('id','>',$id)->orderBy('id','asc')->select("id","title")->first();
        //dd($next_article);
        $this->ret['next_article'] =  $next_article; //下一篇文章
        $this->ret['abouts'] = $abouts;        //相关文章
        if($article->is_video){
            return view("article.specialvideo", $this->ret);
        }else{
            return view("article.special", $this->ret);
        }
        
    }
    public function spbArticle(Request $request){
        $userid = $request->input("userid");
        $article_id = $request->input("article_id");
        $spburl = $request->input("spburl")?$request->input("spburl"):"19";
        $re = courseSpb($userid,$spburl,$article_id);
        if($re){
            return json_encode(['code'=>1,'result'=>'分享成功']);
        }else{
            return json_encode(['code'=>0,'result'=>'分享失败']);
        }
    }

    /*
     * 文章审核
     */
    public function articleVerify(Request $request){

        $id = $request->input('id');
        $user = $request->user();
        $userAttr = UsersAttribute::where('user_id',$user->id)->first();
        $article = Article::where('id',$id)->first();
        if(!$article){
            return $this->getMessage(1,'文章不存在');
        }

        if($article->state == 1){

            return $this->getMessage(0,'已经通过');
        }
        $article->state = 1;
        $article->save();

        return $this->getMessage(0,'已经通过');
    }

    /*
     * 特殊字符过滤
     */
    public function filterSpecialChar($word){
        if($word){
            $name = $word;
            $name = preg_replace('/\xEE[\x80-\xBF][\x80-\xBF]|\xEF[\x81-\x83][\x80-\xBF]/', '', $name);
            $name = preg_replace('/xE0[x80-x9F][x80-xBF]'.'|xED[xA0-xBF][x80-xBF]/S','?', $name);
            $result = json_decode(preg_replace("#(\\\ud[0-9a-f]{3})#i","",json_encode($name)));

        }else{
            $result = '';
        }
        return $result;
    }

}
