<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CommonAskComment;
class CommonAskAnswer extends Model
{
    use SoftDeletes;
    protected $table = 'common_ask_answers';

    public function user(){

        return $this->belongsTo('App\User','user_id');
    }

    public function comment(){
        return $this->belongsTo('App\Models\CommonAskComment','');
    }

    public function getTotalComment(){

        return CommonAskComment::where('aid',$this->id)->select('id')->count();
    }

    public function getTotalZan(){
        return CommonAskZan::where('aid',$this->id)->select('id')->count();
    }

    public function getTotalZan1(){

    }

}
