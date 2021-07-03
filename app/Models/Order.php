<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $table = "order";
    //
    public function getone(){
    	return $this->hasOne('App\Models\Courseclass','id','course_class_id');
    }
    
}
