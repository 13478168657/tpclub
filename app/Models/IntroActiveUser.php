<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class IntroActiveUser extends Model
{
    use SoftDeletes;
    protected $table = 'intro_active_users';


    public function user(){

        return $this->belongsTo('App\User','user_id');
    }


    public function getSponosrNum($user_id,$type,$stage = 1){

//        $day = date('Ymd');
        $result = ActivityUserStatistics::where('user_id',$user_id)->where('type',$type)->where('stage',$stage)->select('invite_num')->first();

        if($result){
            $num = $result->invite_num;
        }else{
            $num = 0;
        }
        return $num;
    }
}
