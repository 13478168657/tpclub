<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paylog extends Model
{
	protected $table = "pay_log";
    //
    public function getone(){
    	return $this->hasOne('App\Models\CourseClass','course_class_id','id');
    }
    
}
