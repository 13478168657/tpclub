<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TfCourseClass extends Model
{
    use SoftDeletes;

    protected $table = 'tf_course_class';
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
