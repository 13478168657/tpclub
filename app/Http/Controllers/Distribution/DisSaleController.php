<?php

namespace App\Http\Controllers\Distribution;

use App\Models\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DisForm;
use App\Models\DisCourse;
use App\Models\DisCourseClass;
use App\Models\CourseClassGroupCommission;
use App\Models\OrderCourseGroup;
use App\Models\DisStudying;
use App\Models\CourseClassGroup;

use Illuminate\Support\Facades\DB;
use App\Constant\WxMessageType;
use App\Utils\WxMessagePush;
 /**
 * 咨询老师分销组合大课控制器
 * 20190508
 * luyahe
 */
class DisSaleController extends Controller
{
	protected $ret;

	public function __construct()
    {
        $this->ret = [];
    }

    /**
	 * 分销中心
	 * 20190508
	 * luyahe
	 */
    public function index(Request $request){
    	if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }

        //组合大课（就业大课，就业大课）
        $groupClass = CourseClassGroup::orderBy("id", "desc")->select("id", "cover_url", "title","course_class_ids")->offset(0)->limit(10)->get();
        if($groupClass){
        	foreach($groupClass as $class){
        		$class->courses = count(explode(",", $class->course_class_ids));
                $course_ids = trim($class->course_class_ids,",");
//                dd($course_ids);
        		$count = DB::select("select count(id) as count  from course where course_class_id in ({$course_ids})");
        		$class->videos = $count[0]->count;

        		$order = OrderCourseGroup::where("course_class_group_id", $class->id)->where("state",1)->where('refund_id',0)->count();
        		$class->order   = $order;
        	}
        }
        $formlist = CourseClassGroupCommission::offset(0)->limit(10)->select("user_name", "user_mobile", "is_receive","created_at")->get();
        $orders = OrderCourseGroup::where("dis_id", $user_id)->where("state",1)->where('refund_id',0)->select("user_id","course_class_group_title","id","is_commission")->get();

        //线下活动大课订单统计
        $courseOrders = Order::where('type',1)->where('state',1)
            ->where('dis_id',$user_id)->orderBy('id','desc')->get();
//        dd($courseOrders->count());
        //print_r($count[0]->count);
        //dd($groupClass);
        $this->ret['groupClass'] = $groupClass;
        $this->ret['formlist']   = $formlist;
        $this->ret['orders']     = $orders;
        $this->ret['courseOrders'] = $courseOrders;
        $this->ret['user'] = $request->user();
    	return view("distSale.index", $this->ret);
    }

    /**
	 * 分销中心老师提交数据
	 * 20190508
	 * luyahe
	 */
    public function formno(Request $request){
    	if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }
        //组合大课（就业大课，就业大课）
        $user_name   = $request->input("user_name");
        $user_mobile = $request->input("user_mobile");
        $title       = $request->input("title");
        $form        = new CourseClassGroupCommission();
        $form->user_name   = $user_name;
        $form->user_mobile = $user_mobile;
        $form->course_class_group_title = $title;
        $form->dis_id  = $user_id;
        $r = $form->save();        
        
        if($r){
        	return json_encode(array("code"=>1));
        }else{
        	return json_encode(array("code"=>0));
        }
    }

    /**
     * 分销中心老师发送提现申请
     * 20190528
     * luyahe
     */
    public function form(Request $request){
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }
        //组合大课（就业大课，就业大课）
        $group_id    = $request->input("group_id");
        $order       = OrderCourseGroup::where("id", $group_id)->first();
        $cur_user    = getUsers($order->user_id);
        $commission  = CourseClassGroupCommission::where("order_course_class_group_id", $order->id)->where("dis_id",$order->dis_id)->first();
        if($commission){
            return json_encode(array("code"=>0, "msg"=>"已提交申请"));
        }else{
            $form        = new CourseClassGroupCommission();
            $form->user_name   = $cur_user ? $cur_user->nickname : '暂无昵称';
            $form->user_mobile = $cur_user ? $cur_user->mobile : '0';
            $form->dis_id      = $order->dis_id;
            $form->order_course_class_group_id    = $order->id;
            $form->course_class_group_title = $order->course_class_group_title;
            $r = $form->save();        
                
            if($r){
                $order->is_commission=2;
                $order->save();
                return json_encode(array("code"=>1, "msg"=>"添加成功，请等候审核"));
            }else{
                return json_encode(array("code"=>0, "msg"=>"添加失败，请重试"));
            }
        }
        
    }

}
