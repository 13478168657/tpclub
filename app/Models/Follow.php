<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Follow extends Model
{
    //use SoftDeletes;
    protected $table = 'follow';

    //关注总数
    public function followCount($fans_id){
    	return $this->where("fans_id", $fans_id)->count();
    }

    //关注列表
    public function followList($fans_id,$offset=0){

    	return $this->where("fans_id", $fans_id)->offset($offset)->limit(5)->get();

    }
    
    //粉丝总数
    public function fansCount($user_id){
    	return $this->where("user_id", $user_id)->count();
    }

    //粉丝列表
    public function fansList($user_id,$offset=0){
    	return $this->where("user_id", $user_id)->offset($offset)->limit(5)->get();
    }

    //关联用户表
    public function users(){
    	return $this->hasOne("App\Models\Users", 'id', 'user_id');
    }

    //关联用户表
    public function users_fans(){
    	return $this->hasOne("App\Models\Users", 'id', 'fans_id');
    }
}
