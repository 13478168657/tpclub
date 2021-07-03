<?php

namespace App\Http\Controllers\Content;

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
use App\Events\WxMessagePush;
use App\Constant\WxMessageType;
use App\Models\CourseClassPush;
use App\Utils\CurlUtil;
use App\Utils\FileUploader;
use App\Events\WxCustomerMessagePush;
use App\Constant\CustomerPushType;
use Illuminate\Support\Facades\Redis;

class ContentController extends Controller
{
    //20191210  期刊控制器
    
    protected $ret;
    protected $page;

    public function __construct()
    {
        $this->ret = [];
        $this->page = 10;
    }

    /**
     * 赛普期刊
     * lu
     * 20191210
     */
    public function index(Request $request)
    {
        if($request->user()){
            $user_id = $request->user()->id;
            $user    = $request->user();
            if($user->avatar){
            	if(strpos($user->avatar,'http') !== false){
					$avatar = $user->avatar;
            	}else{
            		$avatar = env('IMG_URL').$user->avatar;
            	}	
            }else{
            	$avatar = "/images/userImg.png";
            }
            $name   = $user->nickname ? $user->nickname : '暂无昵称';
            $wx_code= $user->wx_code ? env('IMG_URL').$user->wx_code : env('IMG_URL')."self/qr.png";
        }else{
            $user_id = 0;
        }
        $day = date("Y-m-d");
        $article = new Article();
        $articlelist = $article::where("state",1)->where("today_selected", $day)
                                ->select("id", "title", "cover_url", "user_id", "likes", "views", "created_at", "is_video","is_selected")->orderBy("id","desc")->paginate(10);
        if(!$articlelist->count()){
        	$articlelist = $article::where("state",1)
                            ->select("id", "title", "cover_url", "user_id", "likes", "views", "created_at", "is_video","is_selected")->orderBy("today_selected","desc")->paginate(10);
        }

        $weekarray = array("日","一","二","三","四","五","六");

        $this->ret['week']    = $weekarray[date("w")];
        $this->ret['articlelist'] = $articlelist;
        $this->ret['avatar']  = $avatar;
        $this->ret['nickname']= $name;
        $this->ret['wx_code'] = $wx_code;
        $this->ret['user_id'] = $user_id;
        $this->ret['user']    = $request->user();
        return view("content.index",$this->ret);
    }

    public function codeUpload(Request $request){

        $file = new FileUploader($request);
        $fileInfo = $file->base64ImgUpload($request,'upload/avatar');
        return $fileInfo;
    }

    public function activeJournal(Request $request){

        $user = $request->user();
        $code_img = '';
        if($user){
            $code_img = $user->wx_code;
        }
        $data['code_img'] = $code_img;
        return view('content.journal',$data);
    }

    public function journalWxCode(Request $request){

        $user = $request->user();
        if(!$user){
            return $this->getMessage(4,'用户未登录');
        }
        $code = $request->input('code_img');

        $user->wx_code = $code;
        $user->save();

        return $this->getMessage(0,'上传成功');
    }

}
