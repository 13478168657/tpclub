<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class IntroActiveWin extends Model
{
    use SoftDeletes;
    protected $table = 'intro_winning';


    public function user(){

        return $this->belongsTo('App\User','user_id');
    }


    public function getSponosrNum($user_id,$type){

//        $day = date('Ymd');
        $result = ActivityUserStatistics::where('user_id',$user_id)->where('type',$type)->select('invite_num')->first();

        if($result){
            $num = $result->invite_num;
        }else{
            $num = 0;
        }
        return $num;
    }
}
