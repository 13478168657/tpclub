<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderCourseGroup extends Model
{
	protected $table = "order_course_class_group";
    //
    public function getone(){
    	return $this->hasOne('App\Models\CourseClassGroup','id','course_class_group_id');
    }
    
}
