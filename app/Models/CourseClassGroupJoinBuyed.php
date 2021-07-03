<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class CourseClassGroupJoinBuyed extends Model
{
    use SoftDeletes;

    protected $table = 'course_class_group_join_buyed';


    public function user(){

        return $this->belongsTo('App\User','user_id');
    }
}
