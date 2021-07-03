<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class GroupCourseActivityOrder extends Model
{
    use SoftDeletes;

    protected $table = 'group_course_activity_orders';
}
