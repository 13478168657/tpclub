<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CourseClassGroupCommission extends Model
{
    use SoftDeletes;
	//分销课程申请佣金表
    protected $table = 'course_class_group_commission';

}
