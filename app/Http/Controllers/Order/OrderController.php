<?php

namespace App\Http\Controllers\Order;

use App\Models\Courseclass;
use App\Models\ArticleCollect;
use App\Models\ArticleComment;
use App\Models\Order;
use App\Models\DisOrder;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\Studying;
use App\Models\SearchKeyword;
use App\Models\Follow;
use App\Models\Comment;
use App\Constant\CommentDate;
use App\Models\Consultation;
use App\Models\OrderCourseGroup;
use App\Events\WxMessagePush;
use App\Constant\WxMessageType;
use App\Models\CourseClassPush;
use App\Utils\CurlUtil;
use App\Events\WxCustomerMessagePush;
use App\Constant\CustomerPushType;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    //前台订单控制器  组合大课/精品单课/打卡课程
    protected $ret;
    protected $page;

    public function __construct()
    {
        $this->ret = [];
        $this->page = 10;
    }

    /**
     * .组合课程订单列表
     * 20190507
     */
    public function GroupCourseOrder(Request $request)
    {
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }

       	$list = OrderCourseGroup::where("user_id", $user_id)->orderBy("id", "desc")->offset(0)->limit(10)->get();
       	//echo $user_id;
       	//dd($list);
       	$this->ret['list']    = $list;
        $this->ret['user_id'] = $user_id;
        return view("order.groupcourseorder",$this->ret);
        
    }

    /**
     * .打卡课程订单列表
     * 20190507
     */
    public function ClockOrder(Request $request)
    {
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }

       	$list = DisOrder::where("user_id", $user_id)->orderBy("id", "desc")->offset(0)->limit(10)->get();
       	//echo $user_id;
       	//dd($list);
       	$this->ret['list']    = $list;
        $this->ret['user_id'] = $user_id;
        return view("order.clockorder",$this->ret);
    }

    /**
     * .精品课程订单列表
     * 20190507
     */
    public function CourseOrder(Request $request)
    {
        if($request->user()){
            $user_id = $request->user()->id;
        }else{
            $user_id = 0;
        }

       	$list = Order::where("user_id", $user_id)->orderBy("id", "desc")->offset(0)->limit(10)->get();
       	//echo $user_id;
       	//dd($list);
       	$this->ret['list']    = $list;
        $this->ret['user_id'] = $user_id;
        return view("order.courseorder",$this->ret);
    }
}
