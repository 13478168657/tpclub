<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CourseClassGroup extends Model
{
    use SoftDeletes;

    protected $table = 'course_class_group';

}
