<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatNews extends Model
{
    protected $table = 'wechat_news';

     public function users(){
    	return $this->belongsTo("App\User", "opertion_user_id", "id");	
    }
}
