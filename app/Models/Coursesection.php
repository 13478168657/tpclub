<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coursesection extends Model
{
    //
    protected $table = "course_section";
    public function getcount($id){
    	return $count = $this->where("id",$id)->count();
    }
}
