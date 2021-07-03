<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    use SoftDeletes;
    protected $table = 'users';

    public function getOne($userid){
    	return $this->where("id", $userid)->get()->toArray();
    }
    public function getMessage($userid){
    	$data = DB::table("messages")->where("author_id",$userid)->orderBy("id","desc")->get();
    	foreach($data as $v){
    		$id = $v->user_id;
    		$object = getUsers($id);
    		$v->usersName = $object->name;
    		$v->userAvatar = $object->avatar;
    	}
        //dd($data);
    	return $data;
    }

}
