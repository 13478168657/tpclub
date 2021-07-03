<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class CourseOrder extends Model
{
    use SoftDeletes;

    protected $table = 'course_orders';
}
