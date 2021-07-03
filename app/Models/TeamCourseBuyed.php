<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamCourseBuyed extends Model
{

    protected $table = 'team_course_buyed';


    public function user(){

        return $this->belongsTo('App\User','user_id');
    }
}
