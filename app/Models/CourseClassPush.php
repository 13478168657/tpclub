<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CourseClassPush extends Model
{
    
    protected $table = "course_class_push";

    //新增消息提醒记录20180831
    public function addOne($user_id, $course_class_id){
    	$item = $this->where("user_id", "=", $user_id)->where("course_class_id", "=", $course_class_id)->first();
    	if(!$item){
			$user = DB::table("users")->where("id",$user_id)->select("openid")->first();
    		$item = new self;
    		$item->user_id = $user_id;
			$item->course_class_id = $course_class_id;
			$item->user_openid = $user->openid;
    		return $item->save() ? $item : "";
    	}
		return $item;
    }
	
	//客户取消消息提醒20180831
	public function updateState($user_id, $course_class_id, $state){
		if($user_id && $course_class_id && $state){
			$item = $this->where("user_id", $user_id)->where("course_class_id", $course_class_id)->first();
			if($item){
				$item->state = $state;
				$r = $item->save();
				return $r;
			}
		}
		return false;
	}

    
}
