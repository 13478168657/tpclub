<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CourseTag extends Model
{
    use SoftDeletes;

    protected $table = 'course_tag';

    public function tag(){
        return $this->hasOne('App\Models\Tags','id','tag_id');
    }
}
