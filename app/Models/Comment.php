<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    //use SoftDeletes;
    protected $table = 'comments';

    //评论总数
    public function commentCount($course_class_id){
    	return $this->where("course_class_id", $course_class_id)->count();
    }

    //评论信息
    public function getOne($course_class_id,$num = 1){
        if($num == 1){
            return $this->where("course_class_id", $course_class_id)->select("id","user_id","content","score")->orderBy("id", "desc")->first();
        }else{
            return $this->where("course_class_id", $course_class_id)->select("id","user_id","content","score",'created_at')->orderBy("id", "desc")->take(2)->get();
        }

    }
    //评论列表
    public function getList($course_class_id, $offset=0, $pagesize=10){
        return $this->where("course_class_id", $course_class_id)->select("id","user_id","content","score","created_at","user_id")->orderBy("id", "desc")->offset($offset)->limit($pagesize)->get();
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
