<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
class DisCourse extends Model
{
    use SoftDeletes;

    protected $table = 'dis_course';

    public function getPlayRecord($user_id,$courseId){

        $result = DB::table('dis_course_play_record')->where('user_id',$user_id)->where('dis_course_id',$courseId)->first();
        return $result;
    }
}
