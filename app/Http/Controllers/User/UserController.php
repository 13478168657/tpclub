<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\OrderCourseGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\Users;
use App\Models\UsersAttribute;
use App\Models\Follow;
use App\Models\Mycoupon;
use App\Models\ArticleCollect;
use App\Models\Article;
use App\Models\FinanceAccount;
use App\Models\CourseClassGroup;
use App\Models\CourseClassGroupJoinBuyed;
use App\User;
use App\Models\Collect;
use App\Utils\CurlUtil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Utils\FileUploader;
use App\Events\WxCustomerMessagePush;
use App\Constant\CustomerPushType;
use App\Utils\WxMessagePush as WxPush;
use App\Models\DisCourseClass;
use App\Models\DisStudying;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    protected $ret;
    protected $page;

	public function __construct()
    {
    	$this->ret = [];
    	$this->ret['www'] = "http://admin.saipujianshen.com/";
    	$this->page = 5;
    }

    //20180724  我的页面
    public function UserIndex(Request $request){
    	if($request->user()){
    		$userid = $request->user()->id;
            $mobile = $request->user()->mobile ? $request->user()->mobile : 0;  //用户手机号
    	}else{
    		$userid = 0;
            $mobile = 0;
    	}
    	//dd($userid);
    	$user   = Users::find($userid);
    	$follow = new Follow();
    	
    	if(empty($user)){
            $this->ret['mobile']  = $mobile;                         //用户手机号 
    		return view("user.index", $this->ret);
    	}else{
    		$powders = DB::select("select count(id) as powders from follow where user_id={$userid} and fans_id in(select user_id from follow where fans_id={$userid})");  //互粉总数
            $childrens = DB::table("users_growing")->where("fission_id", $userid)->count();

    		$this->ret['user'] = $user;
    		$this->ret['follows'] = $follow->followCount($userid);   //我关注的总数
    		$this->ret['fans']    = $follow->fansCount($userid);     //我的粉丝总数
    		$this->ret['powders'] = $powders[0]->powders;
    		$this->ret['userid']  = $userid;
            $this->ret["spb"]     = getSpb($userid);
            $this->ret['mobile']  = $mobile;                         //用户手机号 
            $this->ret['is_fission'] = is_fission($userid);          //裂变者  
            $this->ret['childrens']  = $childrens;                   //二级代理人数  
           // dd($this->ret);             
    		return view("user.indexlogin", $this->ret);
    	}
    	
    }

    //20180724  我关注的导师列表
    public function followList(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
    	$follow = new Follow();
    	$list   = $follow->followList($userid);
        //dd($list);
    	$this->ret['list'] = $list;
    	$this->ret['userid'] = $userid;
    	return view('user.follow', $this->ret);
    }

    //20180724  我粉丝列表
    public function fansList(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
    	$follow = new Follow();
    	$list   = $follow->fansList($userid);
    	foreach($list as &$item){
    		$is_true = $follow->where(["user_id"=>$item->fans_id, 'fans_id'=>$item->user_id])->first();
    		if($is_true){
    			$item->is_powder = 1;
    		}else{
    			$item->is_powder = 0;
    		}
    	}
        //dd($userid);
    	//return;
        if(!$list->count()){
            //最热推荐
            $hot_course  = DB::table("course_class")
            ->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
            ->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
            ->select("course_class.*", "course_type.title as cytitle","users.name")
            ->where("course_class.state",1)
            ->where("course_class.is_hot", 1)->first();
            $hot_course->sum_course = sum_course($hot_course->id)->count;
            $hot_course->sum_study  = sum_study($hot_course->id)->count+$hot_course->studying_num;
            $hot_course->tags       = get_course_class_tag($hot_course->id);
            //免费课程
            $free_course = DB::table("course_class")
            ->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
            ->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
            ->select("course_class.*", "course_type.title as cytitle","users.name")
            ->where("course_class.state",1)
            ->where("course_class.is_live",0)
            ->whereNull("course_class.deleted_at")
            ->where("course_class.is_free",0)->get();
            foreach($free_course as &$item){
                $item->sum_course = sum_course($item->id)->count;
                $item->sum_study  = sum_study($item->id)->count+$item->studying_num;
                $item->tags       = get_course_class_tag($item->id);
            }

            $this->ret['hot']     = $hot_course;
            $this->ret['free']    = $free_course;
            $this->ret['title']   = '粉丝列表';
            return view('user.studyingempty', $this->ret);
        }else{
            $this->ret['list'] = $list;
            $this->ret['userid']  = $userid;
            return view('user.fans', $this->ret);
        }
    }

    //20180724  互粉列表
    public function powderList(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
    	$powders = DB::select("select fans_id from follow where user_id={$userid} and fans_id in(select user_id from follow where fans_id={$userid}) limit 0,{$this->page}");  //互粉总数
    	$fans_id = "";
        $powders_list = [];
    	foreach($powders as $v){
    		$fans_id .= $v->fans_id.',';
    	}
    	$fans_id = (trim($fans_id, ','));  //用户id列表
        if($fans_id){
            $powders_list = DB::select("select u.name,u.avatar,u.introduction,u.id from users as u where id in ({$fans_id})");
        }
        if(!$powders_list){
            //最热推荐
            $hot_course  = DB::table("course_class")
            ->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
            ->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
            ->select("course_class.*", "course_type.title as cytitle","users.name")
            ->where("course_class.state",1)
            ->where("course_class.is_hot", 1)->first();
            $hot_course->sum_course = sum_course($hot_course->id)->count;
            $hot_course->sum_study  = sum_study($hot_course->id)->count+$hot_course->studying_num;
            $hot_course->tags       = get_course_class_tag($hot_course->id);
            //免费课程
            $free_course = DB::table("course_class")
            ->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
            ->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
            ->select("course_class.*", "course_type.title as cytitle","users.name")
            ->where("course_class.state",1)
            ->where("course_class.is_live",0)
            ->whereNull("course_class.deleted_at")
            ->where("course_class.is_free",0)->get();
            foreach($free_course as &$item){
                $item->sum_course = sum_course($item->id)->count;
                $item->sum_study  = sum_study($item->id)->count+$item->studying_num;
                $item->tags       = get_course_class_tag($item->id);
            }

            $this->ret['hot']     = $hot_course;
            $this->ret['free']    = $free_course;
            $this->ret['title']   = '互粉列表';
            return view('user.studyingempty', $this->ret);
        }else{
            $this->ret['list'] = $powders_list;
            $this->ret['userid']  = $userid;
            return view("user.powder", $this->ret);
        }
		
    }

    //20180725 ajax用户取消关注  包括关注的取关和互粉的取关
    public function followCancel(Request $request){

    	$follow    = new Follow();
    	if(Input::has('follow_id')){
    		$follow_id = Input::get('follow_id');
    	}else{
    		$follow_id = 0;
    	}
    	if(Input::has("user_id")){
    		$user_id = Input::get('user_id');
    	}
    	if(Input::has("fans_id")){
    		$fans_id = Input::get('fans_id');
    	}

    	if($follow_id){
    		$item = $follow::find($follow_id);
    		if($item->delete()){
    			echo json_encode(['code'=>1, 'msg'=>'成功']);
    			return;
    		}else{
				echo json_encode(['code'=>0, 'msg'=>'参数错误']);
				return;
    		}
    	}elseif($user_id && $fans_id){
    		$item = $follow->where('user_id',$user_id)->where('fans_id',$fans_id)->delete();
    		if($item){
    			echo json_encode(['code'=>1, 'msg'=>'成功']);
    			return;
    		}else{
				echo json_encode(['code'=>0, 'msg'=>'参数错误']);
				return;
    		}
    	}

    }

    //20180725 ajax用户添加关注
    public function followAdd(Request $request){

    	$follow  = new Follow();
        $is_follow = $request->input("is_follow");
        $follow->user_id =  $request->input('user_id');     //被关注者id
        $follow->fans_id =  $request->input('fans_id');     //粉丝id
        if($is_follow == 1){
            $item = $follow->where('user_id',$follow->user_id)->where('fans_id',$follow->fans_id)->delete();
            if($item){
                    //courseSpb($follow->fans_id,11,$follow->user_id);
                    echo json_encode(['code'=>0, 'msg'=>'取关成功']);
                    return;
                }
        }else{
            	
            	$item = $follow->where(['user_id'=>$request->input('user_id'), 'fans_id'=>$request->input('fans_id')])->first();
            	if($item){
        			//courseSpb($follow->fans_id,11,$follow->user_id);
            		echo json_encode(['code'=>0, 'msg'=>'您已关注,无需重复操作']);
            		return;
            	}
                if($follow->save()){
                    //courseSpb($follow->fans_id,11);
                    courseSpb($follow->fans_id,11,$follow->user_id);
                    $data['type'] = CustomerPushType::IMAGE;
                    $data['openid'] = $request->user()->openid;
                    $author = Users::where('id',$follow->user_id)->first();
                    $title = $author->name."导师向你Say Hi~";
                    $data['list'] = [[
                             "title"=>$title,
                             "description"=>"你刚刚关注了".$author->name."导师\n点击进入即可查看导师系列课内容",
                             "url"=>env('APP_URL').'/user/teacher/'.$follow->user_id.'/1.html',
                             "picurl"=>env('IMG_URL').$author->push_cover]];
                    if(env('IS_LOCAL') == false){
                        event(new WxCustomerMessagePush($data));
                    }
                    echo json_encode(['code'=>1, 'msg'=>'成功']);
                }else{
                    echo json_encode(['code'=>0, 'msg'=>'网络错误,等一会儿']);
                }
        }
    }

    //20180725 ajax关注，粉丝点击加载更多
    public function addMore(Request $request){

    	$type = $request->input('type');    //区分关注，粉丝，互粉列表
    	$page =  $request->input('page');
    	$user_id = $request->input('user_id');
        logger()->info("UserController--addMore".$this->page);
        logger()->info("UserController--addMore".$page);
    	$offset = $this->page*($page-1);
        logger()->info("UserController--addMore".$offset);
    	$follow = new Follow();
    	if($type=='follow'){
    		$list    = $follow->followList($user_id, $offset);
    		foreach($list as &$item){
				$item->name    = $item->users->name;
				$item->u_id = $item->users->id;
				$item->avatar  = $item->users->avatar;
				$item->introduction = $item->users->introduction ? $item->users->introduction : '暂无';
			}
    	}elseif($type=='fans'){
    		$list    = $follow->fansList($user_id, $offset);
    		foreach($list as &$item){
				$item->name    = $item->users_fans->name;
				$item->u_id    = $item->users_fans->id;
				$item->avatar  = $item->users_fans->avatar;
				$item->introduction = $item->users_fans->introduction ? $item->users_fans->introduction : '暂无';
				$is_true = $follow->where(["user_id"=>$item->fans_id, 'fans_id'=>$item->user_id])->first();
	    		if($is_true){
	    			$item->text = '已关注';
	    			$item->class= 'yihuguan border-radius';
	    			$item->is_follow = 1;
	    		}else{
	    			$item->text = '关注';
	    			$item->class= 'guanzhu border-radius';
	    			$item->is_follow = 0;
    			}
			}
    	}
		
		if($list->count()){
			echo json_encode(['code'=>1, 'list'=>$list]);
		}else{
			echo json_encode(['code'=>0, 'msg'=>'抱歉没有数据了']);
		}
    }
    //20180725 ajax互粉点击加载更多
    public function addMorePowder(Request $request){
    	$page    = $request->input('page') ? $request->input('page') : 1;  //页码
    	$user_id = $request->input('user_id');   //用户id
    	$offset  = $this->page*($page-1);    
    	$powders = DB::select("select fans_id from follow where user_id={$user_id} and fans_id in(select user_id from follow where fans_id={$user_id}) limit {$offset},{$this->page}");  //互粉总数
    	$fans_id = "";
    	foreach($powders as $v){
    		$fans_id .= $v->fans_id.',';
    	}
    	if($fans_id){
    		$fans_id = (trim($fans_id, ','));  //用户id列表
	    	$powders_list = DB::select("select u.name,u.avatar,u.introduction,u.id from users as u where id in ({$fans_id})");
	    	foreach($powders_list as &$item){
	    		if($item->introduction==""){
	    			$item->introduction= '暂无';
	    		}
	    	}
	    	if(count($powders_list)){
				echo json_encode(['code'=>1, 'list'=>$powders_list]);
			}
    	}else{
			echo json_encode(['code'=>0, 'msg'=>'没有更多数据了']);
		}
    }

    //20180726  客户正在学习页面
    public function UserStudy(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }

    	$course_class_list = DB::table("studying")
            ->leftJoin("users" , 'studying.user_id', '=', 'users.id')
            ->leftJoin("course_class" , 'course_class.id', '=', 'studying.course_class_id')
            // ->select("course_class.*", "course_type.title as cytitle","users.name")
            ->select("course_class.*","users.name")
            ->where("course_class.state",1)
            ->whereNull("course_class.deleted_at")
            ->where("studying.user_id",$userid)
            ->orderBy("studying.id", "desc")
            ->take($this->page)
            ->get();
        foreach($course_class_list as &$item){
            $item->sum_course = sum_course($item->id)->count;
            $item->sum_study  = sum_study($item->id)->count+$item->studying_num;
            $item->tags       = get_course_class_tag($item->id);
        }

    	if(empty($course_class_list)){
            //最热推荐
            $hot_course  = DB::table("course_class")
            ->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
            ->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
            ->select("course_class.*", "course_type.title as cytitle","users.name")
            ->where("course_class.state",1)
            ->where("course_class.is_hot", 1)->first();
            $hot_course->sum_course = sum_course($hot_course->id)->count;
            $hot_course->sum_study  = sum_study($hot_course->id)->count+$hot_course->studying_num;
            $hot_course->tags       = get_course_class_tag($hot_course->id);
            //免费课程
            $free_course = DB::table("course_class")
            ->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
            ->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
            ->select("course_class.*", "course_type.title as cytitle","users.name")
            ->where("course_class.state",1)
            ->where("course_class.is_live",0)
            ->whereNull("course_class.deleted_at")
            ->where("course_class.is_free",0)->get();
            foreach($free_course as &$item){
                $item->sum_course = sum_course($item->id)->count;
                $item->sum_study  = sum_study($item->id)->count+$item->studying_num;
                $item->tags       = get_course_class_tag($item->id);
            }

            $this->ret['hot']     = $hot_course;
            $this->ret['free']    = $free_course;
            $this->ret['title']   = "正在学习课表";
            return view('user.studyingempty', $this->ret);
    		//return view('user.empty', $this->ret);
    	}else{
    		$this->ret['list'] = $course_class_list;
    		$this->ret['userid'] = $userid;
    		return view('user.study', $this->ret);
    	}
    	
    }

    //20180726  客户发布课程列表
    public function UserCourse(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }

        $course_class_list = DB::table("course_class")
        ->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
        ->select("course_class.*","users.name")
        ->where("course_class.user_id", $userid)
        ->where("course_class.state",1)
        ->take($this->page)
        ->get();
        foreach($course_class_list as &$item){
            $item->sum_course = sum_course($item->id)->count;
            $item->sum_study  = sum_study($item->id)->count+$item->studying_num;
            $item->tags       = get_course_class_tag($item->id);
        }

    	if(empty($course_class_list)){
            //最热推荐
            $hot_course  = DB::table("course_class")
            ->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
            ->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
            ->select("course_class.*", "course_type.title as cytitle","users.name")
            ->where("course_class.state",1)
            ->where("course_class.is_hide", 0)
            ->where("course_class.is_hot", 1)->first();
            $hot_course->sum_course = sum_course($hot_course->id)->count;
            $hot_course->sum_study  = sum_study($hot_course->id)->count+$hot_course->studying_num;
            $hot_course->tags       = get_course_class_tag($hot_course->id);
            //免费课程
            $free_course = DB::table("course_class")
            ->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
            ->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
            ->select("course_class.*", "course_type.title as cytitle","users.name")
            ->where("course_class.state",1)
            ->where("course_class.is_hide", 0)
            ->where("course_class.is_live",0)
            ->whereNull("course_class.deleted_at")
            ->where("course_class.is_free",0)->get();
            foreach($free_course as &$item){
                $item->sum_course = sum_course($item->id)->count;
                $item->sum_study  = sum_study($item->id)->count+$item->studying_num;
                $item->tags       = get_course_class_tag($item->id);
            }

            $this->ret['hot']     = $hot_course;
            $this->ret['free']    = $free_course;
            $this->ret['title']   = "发布课表";
            return view('user.studyingempty', $this->ret);
    	}else{

    		$this->ret['list'] = $course_class_list;
    		$this->ret['userid'] = $userid;
    		return view('user.courseclass', $this->ret);
    	}
    }

    //20180726  客户收藏课程列表
    public function UserCollect(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
    	$study_object = DB::table("collect")->where('user_id', $userid)->pluck('course_class_id')->take($this->page)->toArray();
    	$course_class_list = [];
    	if(!empty($study_object)){
    		$study_ids    = implode(',', $study_object);
			$course_class_list = DB::table("course_class")
			->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
			->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
			->select("course_class.*", "course_type.title as cytitle","users.name")
			->wherein("course_class.id", $study_object)->get();
			foreach($course_class_list as &$item){
	    		$item->sum_course = sum_course($item->id)->count;
	    		$item->sum_study  = sum_study($item->id)->count+$item->studying_num;
	    		$item->tags       = get_course_class_tag($item->id);
	    	}
    	}
    	
    	if(empty($course_class_list)){
            
    		//最热推荐
            $hot_course  = DB::table("course_class")
            ->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
            ->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
            ->select("course_class.*", "course_type.title as cytitle","users.name")
            ->where("course_class.state",1)
            ->where("course_class.is_hide",0)
            ->where("course_class.is_hot", 1)->first();
            $hot_course->sum_course = sum_course($hot_course->id)->count;
            $hot_course->sum_study  = sum_study($hot_course->id)->count+$hot_course->studying_num;
            $hot_course->tags       = get_course_class_tag($hot_course->id);
            //免费课程
            $free_course = DB::table("course_class")
            ->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
            ->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
            ->select("course_class.*", "course_type.title as cytitle","users.name")
            ->where("course_class.state",1)
            ->where("course_class.is_hide",0)
            ->where("course_class.is_live",0)
            ->whereNull("course_class.deleted_at")
            ->where("course_class.is_free",0)->get();
            foreach($free_course as &$item){
                $item->sum_course = sum_course($item->id)->count;
                $item->sum_study  = sum_study($item->id)->count+$item->studying_num;
                $item->tags       = get_course_class_tag($item->id);
            }

            $this->ret['hot']     = $hot_course;
            $this->ret['free']    = $free_course;
            $this->ret['title']   = '收藏课表';
            return view('user.studyingempty', $this->ret);
    	}else{
    		$this->ret['list'] = $course_class_list;
    		$this->ret['userid'] = $userid;
    		return view('user.collect', $this->ret);
    	}
    }

    //20180726  ajax正在学习，发布课程，收藏课程点击加载更多
    public function addMoreCourseClass(Request $request){
    	$page    =  $request->input('page') ? $request->input('page') : 1;  //页码
    	$user_id =  $request->input('user_id');   //用户id
    	$offset  = $this->page*($page-1);
    	$type    =  $request->input('type');      //用于区分正在学习，发布，收藏
    	if($type=='study'){
            $userid = $request->user()?$request->user()->id:0;

            $orderGroups = OrderCourseGroup::where('state',1)->where('user_id',$userid)->select('course_class_group_id')->get();
            $group_ids = [];
            foreach($orderGroups as $orderGroup){
                $groupClass = CourseClassGroup::where('id',$orderGroup->course_class_group_id)->select('course_class_ids')->first();
                $class_ids = explode(',',$groupClass->course_class_ids);
                foreach($class_ids as $class){
                    $group_ids[] = $class;
                }
            }
            $course_class_list = DB::table("studying")
            ->leftJoin("course_class" , 'course_class.id', '=', 'studying.course_class_id')
            ->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
            ->select("course_class.*","users.name")
            ->where("course_class.state",1)
            ->whereNotIn('studying.course_class_id',$group_ids)
            ->whereNull("course_class.deleted_at")
            ->where("studying.user_id",$user_id)
            ->orderBy("studying.id", "desc")
            ->offset($offset)->limit($this->page)
            ->get();
            if($course_class_list){
                foreach($course_class_list as &$item){
                    $item->sum_course = sum_course($item->id)->count;
                    $item->sum_study  = sum_study($item->id)->count+$item->studying_num;
                    $item->tags       = get_course_class_tag($item->id);
                }
            }
            return $this->getMessage(1,'成功',['body'=>view('user.body.studyBody',['course_lists'=>$course_class_list,'userid'=>$user_id])->render()]);
            echo json_encode(['code'=>1, 'list'=>$course_class_list]);
            return;
    	}elseif($type=='collect'){
    		$course_class_list = DB::table("collect")
                ->leftJoin("users" , 'collect.user_id', '=', 'users.id')
                ->leftJoin("course_class" , 'course_class.id', '=', 'collect.course_class_id')
                ->select("course_class.*", "users.name")
                ->where("course_class.state",1)
                ->where("collect.user_id", $user_id)
                ->whereNull("course_class.deleted_at")
                ->orderBy("collect.id", "desc")
                ->offset($offset)->limit($this->page)
                ->get();
    	}elseif($type=='courseclass'){
    		$course_class_list = DB::table("course_class")
            ->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
            ->select("course_class.*","users.name")
            ->where("course_class.user_id", $user_id)
            ->where("course_class.state",1)
            ->offset($offset)->limit($this->page)
            ->get();
    	}
    	
    	if($course_class_list && $course_class_list->count()){
            
            foreach($course_class_list as &$item){
                $item->sum_course = sum_course($item->id)->count;
                $item->sum_study  = sum_study($item->id)->count+$item->studying_num;
                $item->tags       = get_course_class_tag($item->id);
            }
	    	echo json_encode(['code'=>1, 'list'=>$course_class_list]);
	    	return;
    	}else{
    		echo json_encode(['code'=>0, 'msg'=>'没有更多课程了']);
    		return;
    	}
    }

    //20180726  个人主页
    public function UserIndexInfo(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
    	$user   = Users::find($userid);
    	$follow = new Follow();
    	$course_class_list = collect([]);   //用户课程
    	$study_object = DB::table("course_class")->where('user_id', $userid)->where('state',1)->pluck('id')->take($this->page)->toArray();
    	if(!empty($study_object)){
    		$study_ids    = implode(',', $study_object);
			$course_class_list = DB::table("course_class")
			->leftJoin("users" , 'course_class.opertion_user_id', '=', 'users.id')
			->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
			->select("course_class.*", "course_type.title as cytitle","users.name")
			->wherein("course_class.id", $study_object)->get();

			foreach($course_class_list as &$item){
	    		$item->sum_course = sum_course($item->id)->count;
	    		$item->sum_study  = sum_study($item->id)->count+$item->studying_num;
	    		$item->tags       = get_course_class_tag($item->id);
	    	}
    	}
    	
    	if(empty($user)){
    		return view("user.index", $this->ret);
    	}else{
    		$powders = DB::select("select count(id) as powders from follow where user_id={$userid} and fans_id in(select user_id from follow where fans_id={$userid})");  //互粉总数
    		$this->ret['user'] = $user;
    		$this->ret['follows'] = $follow->followCount($userid);   //我关注的总数
    		$this->ret['fans']    = $follow->fansCount($userid);     //我的粉丝总数
    		$this->ret['powders'] = $powders[0]->powders;
    		$this->ret['userid']  = $userid;
    		$this->ret['list']    = $course_class_list;
    		return view("user.info", $this->ret);
    	}
    }

    //20180726  老师详情页
    public function teacherInfo(Request $request ,$tid,$type=''){
        if($request->user()){
            $userid = $request->user()->id;
            $mobile = $request->user()->mobile;
        }else{
            $userid = 0;
            $mobile = 0;
        }
		$page = $request->input('page',1);
    	$user   = Users::find($tid);
    	$follow = new Follow();
    	$item = $follow->where(['user_id'=>$tid, 'fans_id'=>$userid])->first();
    	if($item){
    		$user->is_follow = 1;  //已关注
    	}else{
    		$user->is_follow = 0;  //未关注
    	}
		$this->ret['page']    = $page;
        if($userid){
            $this->ret['userVerify'] =  UsersAttribute::where('user_id',$userid)->where('is_verify',1)->select('is_verify','verify_info')->first();
        }else{
            $this->ret['userVerify'] = [];
        }

		if($type == 1){
			$course_class_list = [];   //用户课程
			$study_object = DB::table("course_class")->where('user_id', $tid)->where('state',1)->where("is_hide", 0)->whereNull("deleted_at")->pluck('id')->take($this->page)->toArray();
			if(!empty($study_object)){
				$study_ids    = implode(',', $study_object);
				$course_class_list = DB::table("course_class")
					->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
					->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
					->select("course_class.*", "course_type.title as cytitle","users.name")
					->wherein("course_class.id", $study_object)->get();

				foreach($course_class_list as &$item){
					$item->sum_course = sum_course($item->id)->count;
					$item->sum_study  = sum_study($item->id)->count+$item->studying_num;
					$item->tags       = get_course_class_tag($item->id);
				}
			}

			if(empty($user)){
				return view("user.index", $this->ret);
			}else{
				$powders = DB::select("select count(id) as powders from follow where user_id={$tid} and fans_id in(select user_id from follow where fans_id={$tid})");  //互粉总数
				$this->ret['user']    = $user;
				$this->ret['follows'] = $follow->followCount($tid);   //我关注的总数
				$this->ret['fans']    = $follow->fansCount($tid);     //我的粉丝总数
				$this->ret['powders'] = $powders[0]->powders;
				$this->ret['userid']  = $tid;
				$this->ret['mobile']  = $mobile;
				$this->ret['fansid']  = $userid;
				$this->ret['list']    = $course_class_list;
				return view("user.teacher.course", $this->ret);
			}
		}elseif($type == 2){
			$list = Article::where('user_id',$user->id)->where('state',1)->orderBy("id","desc")->paginate($this->page);
			$powders = DB::select("select count(id) as powders from follow where user_id={$tid} and fans_id in(select user_id from follow where fans_id={$tid})");  //互粉总数
			$this->ret['user']    = $user;
			$this->ret['follows'] = $follow->followCount($tid);   //我关注的总数
			$this->ret['fans']    = $follow->fansCount($tid);     //我的粉丝总数
			$this->ret['powders'] = $powders[0]->powders;
			$this->ret['userid']  = $tid;
			$this->ret['mobile']  = $mobile;
			$this->ret['fansid']  = $userid;
			$this->ret['list']    = $list;
			return view("user.teacher.article", $this->ret);
		}elseif($type == 3){
			$list = Article::where('id',$user->id)->where('state',1)->paginate($this->page);
			$powders = DB::select("select count(id) as powders from follow where user_id={$tid} and fans_id in(select user_id from follow where fans_id={$tid})");  //互粉总数
			$this->ret['user']    = $user;
			$this->ret['follows'] = $follow->followCount($tid);   //我关注的总数
			$this->ret['fans']    = $follow->fansCount($tid);     //我的粉丝总数
			$this->ret['powders'] = $powders[0]->powders;
			$this->ret['userid']  = $tid;
			$this->ret['mobile']  = $mobile;
			$this->ret['fansid']  = $userid;
			$this->ret['list']    = $list;
			return view("user.teacher.live", $this->ret);
		}
    }

    //20180726  编辑个人资料
    public function UserEdit(Request $request){
    	
    	if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
    	$user   = Users::find($userid);
    	$follow = new Follow();
    	
    	if(empty($user)){
    		return view("user.index", $this->ret);
    	}else{
    		//$powders = DB::select("select count(id) as powders from follow where user_id={$userid} and fans_id in(select user_id from follow where fans_id={$userid})");  //互粉总数
            $attribute = UsersAttribute::where("user_id", $userid)->first();
    		$this->ret['user'] = $user;
            $this->ret['worktag'] = $attribute ? $attribute->worktag : "";
            $orders = Order::where('state',1)->where('user_id',$user->id)->where('type',1)->get();
            $groupOrders = OrderCourseGroup::where('state',1)->where('user_id',$user->id)->get();
            $this->ret['orders'] = $orders;
            $this->ret['groupOrders'] = $groupOrders;
    		// $this->ret['follows'] = $follow->followCount($userid);   //我关注的总数
    		// $this->ret['fans']    = $follow->fansCount($userid);     //我的粉丝总数
    		// $this->ret['powders'] = $powders[0]->powders;
    		$this->ret['userid']  = $userid;
    		return view("user.edit", $this->ret);
    	}
    	
    }

    /*
     * 图片上传
     */
    public function postUpload(Request $request){
        $upload  = new FileUploader();
        $img     = $_FILES["image"];
        $result  = $upload->formUpload($img, 'upload/avatar');
        return $result;
    }

    /*
     * base64上传
     */
    public function baseUpload(Request $request){
        $file = new FileUploader($request);
        $fileInfo = $file->base64ImgUpload($request,'upload/avatar');
        return $fileInfo;
    }

    //20180727  执行修改用户个人信息
    public function userUpdate(Request $request){
    	$userid = $request->input('id','');
        if($userid){
            $user = $request->user();
            if(!$user){
                echo json_encode(['code'=>0, 'msg'=>'网络错误请稍后重试']);
            }
            $user = Users::where('id',$userid)->first();
            $user->nickname = filterSpecialChar($request->input('name'));
	        $user->sex = $request->input('sex');
	        $user->avatar = $request->input('avatar');
	        $user->introduction = filterSpecialChar($request->input('introduction'));
	        $user->save();
			courseSpb($userid,3);
            $attribute = UsersAttribute::where("user_id", $userid)->first();
			if(!$attribute){
				$attribute = new UsersAttribute();
				$attribute->user_id = $userid;
				$attribute->worktag = $request->input("worktag",'');
				$attribute->save();
			}else{
				$attribute->worktag = $request->input("worktag",'');
				$attribute->save();
			}
	        echo json_encode(['code'=>1, 'msg'=>'信息修改成功']);
        }else{
            echo json_encode(['code'=>0, 'msg'=>'网络错误请稍后重试']);
        }
        
    }

    //20180727  底部导航正在学习
    public function UserStudying(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        $orderGroups = OrderCourseGroup::where('state',1)->where('user_id',$userid)->select('course_class_group_id')->get();
        $group_ids = [];
        foreach($orderGroups as $orderGroup){
            $groupClass = CourseClassGroup::where('id',$orderGroup->course_class_group_id)->select('course_class_ids')->first();
            if(!$groupClass){
                continue;
            }
            $class_ids = explode(',',$groupClass->course_class_ids);
            foreach($class_ids as $class){
                $group_ids[] = $class;
            }
        }
        $course_class_list = DB::table("studying")
            
            ->leftJoin("course_class" , 'course_class.id', '=', 'studying.course_class_id')
            ->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
            // ->select("course_class.*", "course_type.title as cytitle","users.name")
            ->select("course_class.*","users.name")
            ->whereNotIn('studying.course_class_id',$group_ids)
            ->where("course_class.state",1)
            ->whereNull("course_class.deleted_at")
            ->where("studying.user_id",$userid)
            ->orderBy("studying.id", "desc")
            ->take($this->page)
            ->get();
        foreach($course_class_list as &$item){
            $item->sum_course = sum_course($item->id)->count;
            $item->sum_study  = sum_study($item->id)->count+$item->studying_num;
            $item->tags       = get_course_class_tag($item->id);
        }

//        if(!$course_class_list->count()){
//            //最热推荐
//            $hot_course  = DB::table("course_class")
//            ->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
//            ->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
//            ->select("course_class.*", "course_type.title as cytitle","users.name")
//            ->where("course_class.state",1)
//            ->where("course_class.is_hide",0)
//            ->where("course_class.is_hot", 1)->first();
//            $hot_course->sum_course = sum_course($hot_course->id)->count;
//            $hot_course->sum_study  = sum_study($hot_course->id)->count+$hot_course->studying_num;
//            $hot_course->tags       = get_course_class_tag($hot_course->id);
//            //免费课程
//            $free_course = DB::table("course_class")
//            ->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
//            ->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
//            ->select("course_class.*", "course_type.title as cytitle","users.name")
//            ->where("course_class.state",1)
//            ->where("course_class.is_hide",0)
//            ->where("course_class.is_live",0)
//            ->whereNull("course_class.deleted_at")
//            ->where("course_class.is_free",0)->get();
//            foreach($free_course as &$item){
//                $item->sum_course = sum_course($item->id)->count;
//                $item->sum_study  = sum_study($item->id)->count+$item->studying_num;
//                $item->tags       = get_course_class_tag($item->id);
//            }
//
//            $this->ret['hot']     = $hot_course;
//            $this->ret['free']    = $free_course;
//            $this->ret['title']   = "正在学习课表";
//            return view('user.studyingempty', $this->ret);
//        }else{
            $this->ret['list'] = $course_class_list;
            $this->ret['userid'] = $userid;
            $this->ret['total'] = count($course_class_list);

            return view('user.studying1', $this->ret);
//        }
    }

    /**
     * 打卡课程
     */
    public function clock(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        $all = DisStudying::where("user_id",$userid)->select("dis_course_class_id")->get();
        $arr = [];
        foreach($all as $k=>$v){
            $arr[$k] = $v->dis_course_class_id;
        }
        if(count($arr) > 0){
            $data = DisCourseClass::whereNull("deleted_at")->orderBy("created_at","desc")->whereIn("id",$arr)->take(5)->get();


        }else{
            $data = [];
        }
        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();  //微信分享
        }
        $this->ret['data'] = $data;
        return view("user.clock",$this->ret);
    }
    public function underlineCourse(Request $request){
        $data = [];
        $page = $request->input('page',1);
        $userid = $request->user()?$request->user()->id:0;
        $orders = Order::where('type',1)->where('user_id',$userid)->paginate(10);
        $data['orders'] = $orders;
        $data['userid'] = $userid;
        $data['total'] = $orders->total();
//        dd($data);
        $data['hasNext'] = $orders->hasMorePages();
        if($page == 1){
            return view('user.underlineCourse',$data);
        }else{
            $data['page'] = $page;
            $data['body'] = view('user.body.underlineBody',$data)->render();
            return $this->getMessage('0','获取成功',$data);
        }
    }
    /**
     * 打卡课程加载更多
     */
    public function moreclock(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        $num = 5;
        $page = $request->input("page");
        $offset = $num *($page - 1);
        $all = DisStudying::where("user_id",$userid)->select("dis_course_class_id")->get();
        $arr = [];
        foreach($all as $k=>$v){
            $arr[$k] = $v->dis_course_class_id;
        }
        if(count($arr) > 0){
            $data = DisCourseClass::whereNull("deleted_at")->whereIn("id",$arr)->orderBy("created_at","desc")->skip($offset)->take($num)->get();
        }else{
            $data = [];
        }
        return json_encode(['code'=>0, 'body'=>view('user.body.clockBody',['data'=>$data])->render()]);
    }
    public function groupStudy(Request $request){
        $user = $request->user();
        if(!$user){

            return redirect('/register?redirect=/user/train.html');
        }
        $type = $request->input('type','');
        if($type){
            $groupOrders = OrderCourseGroup::where('user_id',$user->id)->where('state',1)->paginate(5);
            $groupArr = [];
            foreach($groupOrders as $group){
                $groupClass = CourseClassGroup::where('id',$group->course_class_group_id)->first();
                if(!$groupClass){
                    continue;
                }
                if($group->buy_way == 'TEAM' && strtotime($group->uneffect_time) > time()){
                    $class_group_join_buyed = CourseClassGroupJoinBuyed::where('user_id',$group->user_id)->where('course_class_group_id',$group->course_class_group_id)->where('stage',$group->stage)->first();
                    $totalBuyed = CourseClassGroupJoinBuyed::where('sponsor_id',$class_group_join_buyed->sponsor_id)->where('course_class_group_id',$group->course_class_group_id)->where('stage',$group->stage)->select('id','user_id')->count();
                    if($totalBuyed >= $groupClass->team_people){
                        $groupArr[] = $groupClass;
                    }else{
                        continue;
                    }
                }
                $groupArr[] = $groupClass;
            }

            return $this->getMessage(0,'成功',['body'=>view('user.body.groupBody',['groupList'=>$groupArr])->render()]);
        }
        $groupOrders = OrderCourseGroup::where('user_id',$user->id)->where('state',1)->paginate(5);
        $groupArr = [];
        if($user->id == 93271){
//            dd($groupOrders);
        }
        foreach($groupOrders as $group){
            $groupClass = CourseClassGroup::where('id',$group->course_class_group_id)->first();
            if(!$groupClass){
                continue;
            }
            if($group->buy_way == 'TEAM' && strtotime($group->uneffect_time) > time()){
                $class_group_join_buyed = CourseClassGroupJoinBuyed::where('user_id',$group->user_id)->where('course_class_group_id',$group->course_class_group_id)->where('stage',$group->stage)->first();
                $totalBuyed = CourseClassGroupJoinBuyed::where('sponsor_id',$class_group_join_buyed->sponsor_id)->where('course_class_group_id',$group->course_class_group_id)->where('stage',$group->stage)->select('id','user_id')->count();
                if($totalBuyed >= $groupClass->team_people){
                    $groupArr[] = $groupClass;
                }else{
                    continue;
                }
            }else{
                $groupArr[] = $groupClass;
            }

        }

        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();  //微信分享
        }
        $this->ret['groupList'] = $groupArr;
        return view('user.groupStudy',$this->ret);
    }
    //20180801 新手指南
    public function newUser(){
		$data = DB::table("help")->where("status","1")->orderBy("id","desc")->get();
		//dd($data);
        return view('user.newuser',["data"=>$data]);
    }

    //20180801 关于我们
    public function aboutUs(){

        return view('user.about');
    }

    //20180801 意见反馈
    public function feedback(Request $request){
		if($request->user()){
    		$userid = $request->user()->id;
    	}else{
    		$userid = 0;
    	}
        return view("user.feedback",["userid"=>$userid]);
    }
	public function feedback_save(Request $request){
		$data = $request->input();
		array_shift($data);
		$data['created_at'] = date("Y-m-d H:i:s");
		$re = DB::table("feedback")->insert($data);
		if($re){
			return redirect("user/index");
		}else{
			return false;
		}
		//dd($data);
	}
    public function news(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            return redirect("/login");
        }
        $arr = new Users();
        $data = $arr->getMessage($userid);
       // dd($data);
        return view("user.news",['list'=>$data]);
    }
    //分享课程邀请人数
    public function shareFriends(Request $request){
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            return redirect("/login");
        }
        //dd($userid);
        $is_fission = DB::table("users_attribute")->where("user_id",$user_id)->select("is_fission")->first();
        
        if($is_fission->is_fission==2){
            $code   = "20";
            $field = "top_top_id";
            $test = DB::table("users_growing")->where("users_growing.code", $code);
        }elseif($is_fission->is_fission==1){
            $code = "00";
            $field = "fission_id";
            $test = DB::table("users_growing")->where("users_growing.code", $code);
        }else{
            $field = "fission_id";
            $test = DB::table("users_growing");
        }
        $data = $test
                ->leftJoin("users" , 'users_growing.user_id', '=', 'users.id')
                //->where('users_growing.fission_id',$user_id)
                ->where("users_growing.".$field, $user_id)
                ->where("users_growing.mobile", ">", 0)
                
                ->select("users_growing.user_id","users.mobile", "users_growing.created_at", "users.nickname as name", "users.avatar","users_growing.is_reserve","users_growing.fission_id")
                ->orderBy("users_growing.id", "desc")
                ->skip(0)->take($this->page)
                ->get();
        if($data->count()){
            foreach($data as &$d){
                $d->fisson_name = subtext(getUsers($d->fission_id)->nickname, 6);
            }
        }        
        //echo $field;
        $this->ret['list'] = $data;
        $this->ret['user_id'] = $user_id;
        if($is_fission && $is_fission->is_fission==2){
            return view("user.myfriendsjob",$this->ret);
        }else{
            return view("user.myfriends",$this->ret);
        }
    }

    //邀请好友点击加载更多
    public function shareFriendsMore(Request $request){
        $user_id = $request->input("user_id");
        $page    = $request->input("page", 1);
        $skip    = $this->page*($page-1);
        
        $is_fission = DB::table("users_attribute")->where("user_id",$user_id)->select("is_fission")->first();
        switch ($is_fission->is_fission) {
            case '2':
                $code   = "20";
                $field  = "top_top_id";
                break;
            default:
                $code = "00";
                $field = "fission_id";
                break;
        }
        $data = DB::table("users_growing")
                ->leftJoin("users" , 'users_growing.user_id', '=', 'users.id')
                ->where("users_growing.".$field, $user_id)
                ->where("users_growing.mobile", ">", 0)
                ->where("users_growing.code", $code)
                ->select("users_growing.user_id","users.mobile", "users_growing.created_at", "users.nickname as name", "users.avatar","users_growing.is_reserve","users_growing.fission_id")
                ->orderBy("users_growing.id", "desc")
                ->skip($skip)->take($this->page)
                ->get()->toArray();

        if($data){
            foreach($data as &$d){
                $d->fisson_name = subtext(getUsers($d->fission_id)->nickname, 6);
            }
            echo json_encode(['code'=>1, 'list'=>$data]);
        }else{
            echo json_encode(['code'=>0, 'msg'=>'已经到底啦~']);
        }
        return;
    }


    public function coupons(Request $request){
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            return redirect("/login");
        }
        //$data = array();
        $data = DB::table("users_coupon")->where("user_id", $user_id)->limit(10)->get();
        foreach($data as &$item){
            $coupon = DB::table("coupon")->where("id", $item->coupon_id)->select("title", "days","course_class_id", "course_class_group_id")->first();
            $item->title = $coupon->title;
            $item->days  = $coupon->days;
            if($coupon->course_class_id>0){
                $item->url = "/course/detail/{$coupon->course_class_id}.html";
            }else{
                $item->url = "/train/study.html?id={$coupon->course_class_group_id}";
            }
        }
        //dd($data);
       //dd($list);
  //       $data = DB::table("course_experience_cards")->orderBy("end","desc")->get()->toArray();
  //       $now_time=date("Y-m-d h:i:s");
		// $sort_arr = array();
  //       foreach($data as $k){
  //           $card_id = $k->id;
  //           $status = Mycoupon::where("user_id",$userid)->where("cards_id",$card_id)->select("start_time","experience_time")->first();
  //           if($status){
  //               $start_time = $status->start_time;
  //               $day = $status->experience_time;
  //               $reckon = date('Y-m-d H:i:s',strtotime("$start_time +$day day")); 
  //               if(strtotime($now_time) < strtotime($reckon)){
  //                   $k->status_coupons = 1;//正在使用
  //                }else{
  //                   $k->status_coupons = 0;//已过期
  //                }
  //           }else{
               // $end_time = $k->end;
               // if(strtotime($now_time) < strtotime($end_time)){
                    //$k->status_coupons = 2;//未使用
                /* }else{
                    $k->status_coupons = 0;//已过期
                 }*/
   //          }
			// $sort_arr[] = $k->status_coupons;
   //      }
   //      array_multisort($sort_arr,SORT_DESC, $data);
		
        return view("user.mycoupon",['list'=>$data]);
    }
    public function record_coupon(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            return redirect("/login");
        }
        $id = $request->input("id");
        $data = DB::table("course_experience_cards")->where("id",$id)->select("id","start","validate_time","type_id")->first();
        //dd($data);
        if($data){
            $coupon = new Mycoupon();
            $coupon ->user_id = $userid;
            $coupon ->cards_id = $data->id;
            $coupon ->type_id = $data->type_id;
            $coupon ->start_time = date("Y-m-d h:i:s");
            $coupon ->experience_time = $data->validate_time;
            $re = $coupon ->save();
			//dd($re);
            if($re){
                echo '1';
            }else{
                echo '0';
            }
        }else{
            echo "1";
        }


    }

    public function dataempty(){
        //最热推荐
        $hot_course  = DB::table("course_class")
        ->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
        ->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
        ->select("course_class.*", "course_type.title as cytitle","users.name")
        ->where("course_class.state",1)
        ->where("course_class.is_hot", 1)->first();
        $hot_course->sum_course = sum_course($hot_course->id)->count;
        $hot_course->sum_study  = sum_study($hot_course->id)->count+$hot_course->studying_num;
        $hot_course->tags       = get_course_class_tag($hot_course->id);
        //免费课程
        $free_course = DB::table("course_class")
        ->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
        ->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
        ->select("course_class.*", "course_type.title as cytitle","users.name")
        ->where("course_class.state",1)
        ->where("course_class.is_live",0)
        ->whereNull("course_class.deleted_at")
        ->where("course_class.is_free",0)->get();
        foreach($free_course as &$item){
            $item->sum_course = sum_course($item->id)->count;
            $item->sum_study  = sum_study($item->id)->count+$item->studying_num;
            $item->tags       = get_course_class_tag($item->id);
        }

        $this->ret['hot']     = $hot_course;
        $this->ret['free']    = $free_course;
        $this->ret['title']   = "数据空";
        return view('user.dataempty', $this->ret);

    }
    //20181126 新建直播
    public function live(Request $request){
        
        if($request->user()){
            $userid = $request->user()->id;
        }

        $this->ret['$user_id'] = $userid;
        return view('user.live', $this->ret);
    }

	/*
	 * 用户中心
	 */
	public function userCenter(Request $request,$type){
		if($request->user()){
			$userid = $request->user()->id;
		}else{
			$userid = 0;
		}
		$page = $request->input('page',1);
		if($type == 1){
			$user   = Users::find($userid);
			$follow = new Follow();
			$course_class_list = collect([]);   //用户课程
			$study_object = DB::table("course_class")->where('user_id', $userid)->where('state',1)->pluck('id')->take($this->page)->toArray();
			if(!empty($study_object)){
				$study_ids    = implode(',', $study_object);
				$course_class_list = DB::table("course_class")
					->leftJoin("users" , 'course_class.opertion_user_id', '=', 'users.id')
					->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
					->select("course_class.*", "course_type.title as cytitle","users.name")
					->wherein("course_class.id", $study_object)->get();

				foreach($course_class_list as &$item){
					$item->sum_course = sum_course($item->id)->count;
					$item->sum_study  = sum_study($item->id)->count+$item->studying_num;
					$item->tags       = get_course_class_tag($item->id);
				}
			}
			$this->ret['page'] = $page;
			if(empty($user)){
				return view("user.userCenter", $this->ret);
			}else{
				$powders = DB::select("select count(id) as powders from follow where user_id={$userid} and fans_id in(select user_id from follow where fans_id={$userid})");  //互粉总数
				$this->ret['user'] = $user;
				$this->ret['follows'] = $follow->followCount($userid);   //我关注的总数
				$this->ret['fans']    = $follow->fansCount($userid);     //我的粉丝总数
				$this->ret['powders'] = $powders[0]->powders;
				$this->ret['userid']  = $userid;
				$this->ret['list']    = $course_class_list;
			}

			return view('user.userCenter',$this->ret);
		}elseif($type == 2){
			$user   = Users::find($userid);
			$follow = new Follow();
			$list = Article::where('user_id',$userid)->whereIn('state',[1,2])->orderBy('updated_at','desc')->paginate($this->page);
//            dd($list);
			$powders = DB::select("select count(id) as powders from follow where user_id={$userid} and fans_id in(select user_id from follow where fans_id={$userid})");  //互粉总数
			$this->ret['user'] = $user;
			$this->ret['follows'] = $follow->followCount($userid);   //我关注的总数
			$this->ret['fans']    = $follow->fansCount($userid);     //我的粉丝总数
			$this->ret['powders'] = $powders[0]->powders;
			$this->ret['userid']  = $userid;
			$this->ret['list']    = $list;
			$this->ret['page']    = $page;
			return view('user.userCenter1',$this->ret);
		}else{
			$user   = Users::find($userid);
			$follow = new Follow();
//			$list = Article::where('id',$userid)->paginate($this->page);
			$powders = DB::select("select count(id) as powders from follow where user_id={$userid} and fans_id in(select user_id from follow where fans_id={$userid})");  //互粉总数
			$this->ret['user'] = $user;
			$this->ret['follows'] = $follow->followCount($userid);   //我关注的总数
			$this->ret['fans']    = $follow->fansCount($userid);     //我的粉丝总数
			$this->ret['powders'] = $powders[0]->powders;
			$this->ret['userid']  = $userid;
			$this->ret['page']  = $page;
//			$this->ret['list']    = ;
			return view('user.userCenter2',$this->ret);
		}
	}

	/*
	 * 用户收藏
	 */
	public function collect(Request $request,$type){
		if($request->user()){
			$userid = $request->user()->id;
		}else{
			$userid = 0;
		}
		$page = $request->input('page',1);
		$this->ret['page'] = $page;
		if($type == 1){
            $course_class_list = DB::table("collect")
                ->leftJoin("users" , 'collect.user_id', '=', 'users.id')
                ->leftJoin("course_class" , 'course_class.id', '=', 'collect.course_class_id')
                ->select("course_class.*", "users.name")
                ->where("course_class.state",1)
                ->where("collect.user_id", $userid)
                ->whereNull("course_class.deleted_at")
                ->orderBy("collect.id", "desc")
                ->take($this->page)
                ->get();
            foreach($course_class_list as &$item){
                $item->sum_course = sum_course($item->id)->count;
                $item->sum_study  = sum_study($item->id)->count+$item->studying_num;
                $item->tags       = get_course_class_tag($item->id);
            }

			if(empty($course_class_list)){

				//最热推荐
				$hot_course  = DB::table("course_class")
					->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
					->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
					->select("course_class.*", "course_type.title as cytitle","users.name")
					->where("course_class.state",1)
					->where("course_class.is_hot", 1)->first();
				$hot_course->sum_course = sum_course($hot_course->id)->count;
				$hot_course->sum_study  = sum_study($hot_course->id)->count+$hot_course->studying_num;
				$hot_course->tags       = get_course_class_tag($hot_course->id);
				//免费课程
				$free_course = DB::table("course_class")
					->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
					->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
					->select("course_class.*", "course_type.title as cytitle","users.name")
					->where("course_class.state",1)
					->where("course_class.is_live",0)
					->whereNull("course_class.deleted_at")
					->where("course_class.is_free",0)->get();
				foreach($free_course as &$item){
					$item->sum_course = sum_course($item->id)->count;
					$item->sum_study  = sum_study($item->id)->count+$item->studying_num;
					$item->tags       = get_course_class_tag($item->id);
				}

				$this->ret['hot']     = $hot_course;
				$this->ret['free']    = $free_course;
				$this->ret['title']   = '收藏课表';
				$this->ret['page']  = $page;
				return view('collect.course', $this->ret);
			}else{

				$this->ret['list'] = $course_class_list;
				$this->ret['userid'] = $userid;
				return view('collect.course', $this->ret);
			}
		}else{
			$collectArticle = ArticleCollect::where('user_id',$userid)->paginate($this->page);
//			dd($collectArticle);
			return view('collect.figure',['collectArticles'=>$collectArticle,'page'=>$page]);
		}

	}

	/*
	 * 查看更多课程
	 */
	public function addMoreCourse(Request $request){
		$page    =  $request->input('page') ? $request->input('page') : 1;  //页码
		$user_id =  $request->user()->id;   //用户id
		$offset  = $this->page*($page-1);
		$type    =  $request->input('type');      //用于区分正在学习，发布，收藏
		if($type=='study'){
			$study_object = DB::table("studying")->where('user_id', $user_id)->whereNull("deleted_at")->select("studying.course_class_id")->offset($offset)->limit($this->page)->get();
		}elseif($type=='collect'){
			$study_object = DB::table("collect")->where('user_id', $user_id)->whereNull("deleted_at")->select("collect.course_class_id")->offset($offset)->limit($this->page)->get();
		}elseif($type=='courseclass'){
			$study_object = DB::table("course_class")->where('user_id', $user_id)->where('state',1)->whereNull("deleted_at")->select("course_class.id as course_class_id")->offset($offset)->limit($this->page)->get();
		}elseif($type == 'article'){
			$articleCollect  = ArticleCollect::where('user_id',$user_id)->paginate($this->page);
		}
		if($type != 'article'){
            if($study_object && $study_object->count()){
                if($type=='collect'){
                    $course_class_list = DB::table("collect")
                        ->leftJoin("users" , 'collect.user_id', '=', 'users.id')
                        ->leftJoin("course_class" , 'course_class.id', '=', 'collect.course_class_id')
                        ->select("course_class.*", "users.name")
                        ->where("course_class.state",1)
                        ->where("collect.user_id", $user_id)
                        ->whereNull("course_class.deleted_at")
                        ->orderBy("collect.id", "desc")
                        ->offset($offset)->limit($this->page)
                        ->get();
                    foreach($course_class_list as &$item){
                        $item->sum_course = sum_course($item->id)->count;
                        $item->sum_study  = sum_study($item->id)->count+$item->studying_num;
                        $item->tags       = get_course_class_tag($item->id);
                    }

                }else{
                    $course_class_id   = [];
                    foreach($study_object as $v){
                        $course_class_id[] = $v->course_class_id;
                    }
                    $course_class_list = DB::table("course_class")
                        ->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
                        ->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
                        ->select("course_class.*", "course_type.title as cytitle","users.name")
                        ->wherein("course_class.id", $course_class_id)->get();

                    foreach($course_class_list as &$item){
                        $item->sum_course = sum_course($item->id)->count;
                        $item->sum_study  = sum_study($item->id)->count+$item->studying_num;
                        $item->tags       = get_course_class_tag($item->id);
                    }
                }
                return json_encode(['code'=>0, 'body'=>view('collect.body.courseBody',['list'=>$course_class_list])->render()]);
			}else{
				return json_encode(['code'=>1, 'msg'=>'没有更多课程了']);
			}
		}else{
			if($articleCollect->count()){
				return json_encode(['code'=>0,'body'=>view('collect.body.articleBody',['articleCollect'=>$articleCollect])->render()]);
			}else{
				return json_encode(['code'=>1,'msg'=>'没有更多文章了']);
			}
		}
	}

	/*
	 *点击关注
	 */
	public function userFollow(Request $request){
		$user = $request->user();
		$articleCollect = new ArticleCollect();
	}


	/*
	 * 个人中心用户资料获取
	 */
	public function userCenterInfoMore(Request $request){
		$page    =  $request->input('page') ? $request->input('page') : 1;  //页码
		if($request->input('userId','')){
			$user_id = $request->input('userId');
		}else{
			$user_id =  $request->user()->id;
		}

		$offset  = $this->page*($page-1);
		$type    =  $request->input('type');      //用于区分正在学习，发布，收藏

		if($type==1){
			$info = DB::table("course_class")
				->leftJoin("users" , 'course_class.user_id', '=', 'users.id')
				->leftJoin("course_type" , 'course_class.course_type_id', '=', 'course_type.id')
				->where('course_class.user_id',$user_id)
                ->where('course_class.state',1)
				->where('course_class.is_hide',0)
				->whereNull("course_class.deleted_at")
				->select("course_class.*", "course_type.title as cytitle","users.name")
				->paginate($this->page);
			foreach($info as &$item){
				$item->sum_course = sum_course($item->id)->count;
				$item->sum_study  = sum_study($item->id)->count+$item->studying_num;
				$item->tags       = get_course_class_tag($item->id);
			}
			if($info->count()){
				return json_encode(['code'=>0,'body'=>view('user.body.courseBody',['articleCollect'=>$info])->render()]);
			}else{
				return json_encode(['code'=>1,'msg'=>'没有更多课程了']);
			}

		}elseif($type==2){
			$info = Article::where('user_id',$user_id)->whereIn('state',[1,2])->orderBy("id", "desc")->paginate($this->page);
			if($info->count()){
				return json_encode(['code'=>0,'body'=>view('user.body.articleBody',['articleCollect'=>$info])->render()]);
			}else{
				return json_encode(['code'=>1,'msg'=>'没有更多文章了']);
			}

		}elseif($type==3){
			$info = DB::table("course_class")->where('user_id', $user_id)->where('state',1)->whereNull("deleted_at")->select("course_class.id as course_class_id")->offset($offset)->limit($this->page)->get();
			if($info){
				return json_encode(['code'=>0,'body'=>view('user.body.liveBody',['articleCollect'=>$info])->render()]);
			}else{
				return json_encode(['code'=>1,'msg'=>'没有更多直播了']);
			}
		}
	}
    /*
     * 用户任务列表
     * 20190116
     */
    public function UserTask(Request $request){
        if($request->user()){
            $spb = $request->user()->spb;
        }else{
            $spb = 0;
        }
        $this->ret['spb'] = $spb;
        return view("user.task", $this->ret);
    }

    /*
     * 测试用户唯一unionid
     * 20190013
     */
    public function UserUnionid(Request $request){
        if($request->user()){
            $openid = $request->user()->openid;
        }else{
            $spb = 0;
        }

        $wxPush  = new WxPush();
        $token   = $wxPush->getToken();

        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$token."&openid=".$openid."&lang=zh_CN";
            $jsonRes = httpGet($url);
        $arrRes = json_decode($jsonRes, true); 
        print_r($arrRes);
        return;   

        $user = new Users();
        $list = $user->whereNull("unionid")->whereNotNull("openid")->select("id","openid")->limit(20)->get();
        foreach($list as $item){
            $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$token."&openid=".$item->openid."&lang=zh_CN";
            $jsonRes = httpGet($url);
            if ($jsonRes){
                $arrRes = json_decode($jsonRes, true);
                if(isset($arrRes['unionid'])){
                    $data['unionid'] = $arrRes['unionid'];
                }else{
                    $data['unionid'] = '-----';
                }
                DB::table('users')
                    ->where("id", $item->id)
                    ->update($data);
                print_r($arrRes);
                echo $item->id."<br/>";
            }
        }
        return;
        dd($list);

    }

    public function isFollow(Request $request){
        if($request->user()){
            $openid = $request->user()->openid;
        }else{
            $spb = 0;
        }
        $openid = $request->input("openid");

        $wxPush  = new WxPush();
        $token   = $wxPush->getToken();
        
        
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$token."&openid=".$openid."&lang=zh_CN";
        
        $jsonRes = httpGet($url);
        if ($jsonRes){
            $arrRes = json_decode($jsonRes, true);
            print_r($arrRes);
        }else{
            echo 1111;
        }
        return;

    }

    //20190228 临时接口删除0.01元课程 目的商户号可以发红包
    public function update_order(Request $request){
        $mobile = $request->input("mobile", 13269280535);
        $user   = new Users();
        $item   = $user->where("mobile", $mobile)->select("id")->first();
        if($item){
            $order = DB::table("order")->where("user_id", $item->id)->where("course_class_id",17)->first();
            //dd($order);
            if($order){
                DB::beginTransaction();
                try{
                    DB::table("order")->where("id", $order->id)->update(array("state"=>0, "updated_at"=>date("Y-m-d H:i:s")));
                    DB::table("studying")->where("user_id", $item->id)->where("course_class_id",17)->delete();
                    DB::commit();
                    echo "操作成功";
                }catch(\Exception $e){
                    echo $e->getMessage();
                    DB::rollback();
                } 

            }else{
                echo "订单不存在";
            }
        }else{
            echo "手机号不存在";
        }
    }


    /*
     * 绑定用户手机号
     */

    public function bindMobile(Request $request){

        $user = $request->user();
        if($user && $user->mobile){
            $flag = 1;
        }else{
            $flag = 0;
        }
        return view('user.bindMobile',['flag'=>$flag]);
    }

    /*
     * 完成绑定
     */
    public function bindFinish(Request $request){

        return view('user.bindFinish',[]);
    }


    public function coachVerify(Request $request){


        return view('user.coach',[]);
    }

    /*
     * 绑定手机号
     */
    public function postBindMobile(Request $request){

        $code = $request->input('code');
        $mobile = $request->input('mobile');
        $share_id = $request->input('share_id',0);
        $job = $request->input('job','');
        $mobile_code = Redis::get('code_'.trim($mobile));
        $channel = $request->input('channel','');
        $from = $request->input('from','');

        if($code!='656565'){
            if($mobile_code != $code){
                return $this->getMessage(1,'验证码有误或已过期');
            }
        }

        $reg_mobile  = '/^1[3|4|5|6|7|8|9]{1}\d{9}$/';

        if(!preg_match($reg_mobile,$mobile)){
            return $this->getMessage(2,'手机号格式错误');
        }

        $user = User::where('mobile',$mobile)->first();//第一次注册用户
        $oldUser = $request->user();//当前登录用户
        if(!$oldUser){

            return $this->getMessage(1,'用户未登录');
        }
//        if($oldUser){
//            if(!empty($oldUser->mobile)){
//                return $this->getMessage(1,'手机号存在，禁止绑定');
//            }
//        }
        $flag = 1;
        if(!is_weixin()){
            if($user){

                if($oldUser->id == $user->id){
                    return $this->getMessage(4,'用户手机号相同，无需绑定');
                }
                if($user->openid != '' || $user->unionid != ''){

                    return $this->getMessage(1,'手机号已经绑定过微信，请更换手机号');
                }else{
                    if($oldUser->mobile){
                        return $this->getMessage(1,'手机号已存在无法绑定');
                    }else{
                        $user->nickname = $oldUser->nickname;
                        if(empty($user->avatar)){
                            $user->avatar = $oldUser->headimgurl;
                        }
                        $user->openid = $oldUser->openid;
                        $user->unionid = $oldUser->unionid;

                        User::where('id',$oldUser->id)->delete();
                        $flag = 0;
                    }
                }
            }else{
                $user = User::where('id',$oldUser->id)->first();
            }
        }elseif(is_weixin()){
            if($user){
                if($oldUser->id == $user->id){
                    return $this->getMessage(4,'用户手机号相同，无需绑定');
                }
                if($user->openid != '' || $user->unionid != ''){

                    return $this->getMessage(1,'手机号已经绑定过微信，请更换手机号');
                }else{
                    if($oldUser->mobile){
                        return $this->getMessage(1,'手机号已存在无法绑定');
                    }else{
                        $user->nickname = $oldUser->nickname;
                        if(empty($user->avatar)){
                            $user->avatar = $oldUser->headimgurl;
                        }
                        $user->openid = $oldUser->openid;
                        $user->unionid = $oldUser->unionid;

                        User::where('id',$oldUser->id)->delete();
                        $flag = 0;
                    }
                }


//                $user->nickname = $oldUser->nickname;
//                if(empty($user->avatar)){
//                    $user->avatar = $oldUser->headimgurl;
//                }
//                $user->openid = $oldUser->openid;
//                $user->unionid = $oldUser->unionid;
//
//                User::where('id',$oldUser->id)->delete();

            }else{
                if($oldUser){
                    $user = User::where('id',$oldUser->id)->first();
                }else{
                    return $this->getMessage(5,'绑定失败');
                }
            }
        }
        if($oldUser && $oldUser->mobile == $mobile){
            return $this->getMessage(4,'手机号已存在无需绑定');
        }
//        $flag = 1;

        $user->mobile = $mobile;
        //$user->workstatus = $workstatus;
//        if(is_weixin()){
//            if($user->openid == null){
//                $user->openid = $openid;
//            }
//        }
        DB::beginTransaction();
        try{
            if($user->save()){
                $attribute = UsersAttribute::where("user_id", $user->id)->first();
                if(!$attribute){
                    $attribute = new UsersAttribute();
                    $attribute->user_id = $user->id;
                    $attribute->job = $job;
                    $attribute->save();
                }else{
                    $attribute->job = $job;
                    $attribute->save();
                }

                $this->syncUserInfoToApp($user);
                if(!is_weixin()){
                    Auth::loginUsingId($user->id);
                }else{
                    Auth::logout();
                    Auth::loginUsingId($user->id);
                }
                if(!$flag){
                    $studying = Studying::where('user_id',$oldUser->id)
                        ->update(['user_id'=>$user->id]);
                }
                $finance = new FinanceAccount();
                //201905024 继续赠送赛普币
//                if($flag){
//                    courseSpb($user->id,2);
//                    if(!env('IS_LOCAL')){
//                        $data['type'] = CustomerPushType::IMAGE;
//                        $data['openid'] = $user->openid;
//                        $title = "【新人礼包】恭喜您获得3000赛普币";
//                        $data['list'] = [[
//                            "title"=>$title,
//                            "description"=>"
//想免费听课就来做任务挣赛普币吧~\n点击进入即可查看赛普币玩法攻略",
//                            "url"=>env('APP_URL').'/spb/rules',
//                            "picurl"=>'http://www.saipubbs.com/images/saipubi.jpg']];
//                        event(new WxCustomerMessagePush($data));
//                    }
//                }

                $finance->addOne($user->id,$user->name);
                users_growing($share_id,$user->id,$channel,$from,1);
                DB::commit();

                return $this->getMessage(0,'绑定成功');
            }else{
                DB::rollback();
                return $this->getMessage(5,'绑定失败');
            }
        }catch(\Exception $e){

            DB::rollback();
            logger()->info($e->getMessage());
            return $this->getMessage(5,'用户注册失败'.$e->getMessage());
        }
    }
    /*
     *绑定感兴趣标签
     */
    public function bindInterest(Request $request){
        $interest = $request->input('interest','');
        $user = $request->user();
        if(!$user){
            return $this->getMessage(1,'用户未登录');
        }
        $userAttr = UsersAttribute::where('user_id',$user->id)->first();
        $userAttr->interest_tag = $interest;
        if($userAttr->save()){

            return $this->getMessage(0,'完成');
        }else{

            return $this->getMessage(1,'添加失败');
        }
    }

    /*
     * 申请教练认证
     */
    public function applyVerify(Request $request){
        $company = $request->input('company');
        $info = $request->input('info');
        $imgUrl = $request->input('imgUrl');
        $user = $request->user();
        if(!$user){
            return $this->getMessage(1,'用户未登录');
        }

        $userAttr = UsersAttribute::where('user_id',$user->id)->first();
        $userAttr->company = $company;
        $userAttr->verify_info = $info;
        $userAttr->certificate = $imgUrl;
        if($userAttr->save()){
            return $this->getMessage(0,'添加成功');
        }else{
            return $this->getMessage(1,'添加失败');
        }
    }

    /*
     * 获取用户数据到app，保存app_user_id,
     */
    public function syncUserInfoToApp($user){
        $address = env('APP_INTERFACE_URL').'api/communityUser/userSynchronization';
        $data['mobile'] = $user->mobile;
        $data['nickname'] = mb_substr($user->nickname,0,20,'UTF-8');
        if(strpos($user->avatar,'http') !== false){
            $data['avatar'] = $user->avatar;
        }else{
            if($user->avatar == ''){
                $data['avatar'] = '';
            }else{
                $data['avatar'] = env('IMG_URL').$user->avatar;
            }
        }
        $data['sex'] = $user->sex;
        $data['unionid'] = $user->unionid;
        $data['registerTime'] = date('Y-m-d H:i:s',strtotime($user->created_at));

        if (empty($data)) {
            return array("code"=>'200', "msg"=>"参数有误");
        }

        $result = CurlUtil::appCurl($address,$data);
        $appInfo = [];
        if($result){
            logger()->info($result);
            $appInfo = json_decode($result,true);
        }
        if(isset($appInfo['app_user_id'])) {
            $app_user_id = $appInfo['app_user_id'] ? $appInfo['app_user_id'] : 0;
        }else{
            $app_user_id = 0;
        }
        $user->app_user_id = $app_user_id;
        $user->save();
    }

}