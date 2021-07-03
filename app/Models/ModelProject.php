<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\CourseClassGroup;
use App\Models\CourseClass;
use App\Models\DisCourseClass;
class ModelProject extends Model
{
    use SoftDeletes;

    protected $table = 'model_projects';

    public function getCourse($type,$type_id){

        if($type == 'DIS'){

            $result = DisCourseClass::where('id',$type_id)->where('state',1)->first();
        }elseif($type == 'COURSE'){
            $result = CourseClass::where('id',$type_id)->where('state',1)->first();
        }elseif($type == 'GROUP'){
            $result = CourseClassGroup::where('id',$type_id)->first();
        }

        return $result;
    }
}
