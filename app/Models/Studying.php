<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\CourseClassPush;
use Illuminate\Database\Eloquent\SoftDeletes;

class Studying extends Model
{
    use SoftDeletes;
    protected $table = "studying";
    //新增学习记录
    public function addOne($user_id, $course_class_id){
       
    	$item = $this->where("user_id", "=", $user_id)->where("course_class_id", "=", $course_class_id)->first();
        if(!$item){
    		$item = new self;
    		$item->user_id = $user_id;
			$item->course_class_id = $course_class_id;
            //logger()->info($item->save());
    		return $item->save();
    	}
        return $item;
    }
}
