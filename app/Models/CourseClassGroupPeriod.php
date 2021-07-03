<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CourseClassGroupPeriod extends Model
{
    use SoftDeletes;
    protected $table = 'course_class_group_periods';

    public function getOrderNumber($group_id,$stage){

    }
}
