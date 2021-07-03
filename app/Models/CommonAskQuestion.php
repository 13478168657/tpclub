<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CommonAskAnswer;
class CommonAskQuestion extends Model
{
    use SoftDeletes;
    protected  $table = 'common_ask_questions';

    public function user(){

        return $this->belongsTo('App\User','user_id');
    }


    public function getAnswerTotal(){

        return CommonAskAnswer::where('qid',$this->id)->select('id')->count();
    }
}