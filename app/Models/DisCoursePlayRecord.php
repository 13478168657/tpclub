<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DisCoursePlayRecord extends Model
{
    use SoftDeletes;

    protected $table = 'dis_course_play_record';


    public function disCourse(){
        return $this->belongsTo('App\Models\DisCourse','dis_course_id');
    }
}
