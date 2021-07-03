<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class UserCourseFeedback extends Model
{
    use SoftDeletes;
    protected $table = 'user_course_feedback';
}
