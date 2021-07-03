<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CourseClassGroupOrderStatistics extends Model
{
    use SoftDeletes;

    protected $table = 'course_class_group_order_statistics';

    public function getOrderNumber($group_id,$stage){

        return $this->where('course_class_group_id',$group_id)->where('stage',$stage)->select('num')->first();
    }
}
