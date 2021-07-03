<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class WechatActivityHand extends Model
{
    use SoftDeletes;
    protected $table = 'wechat_activtity_hands';

    public function user(){

        return $this->belongsTo('App\User','sponsor_id');
    }
}