<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityUserStatistics extends Model
{

    protected $table = 'activity_user_statistics';


    public function user(){

        return $this->belongsTo('App\User','user_id');
    }

    public function getActiveInfo($user_id,$type,$stage = 1){

        $result = IntroActiveUser::where('user_id',$user_id)->where('type',$type)->where('stage',$stage)->select('user_info')->first();

        return $result;
    }

}
