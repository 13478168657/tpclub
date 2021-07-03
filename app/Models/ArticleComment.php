<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleComment extends Model
{
    //use SoftDeletes;
    protected $table = "article_comments";

    //评论信息
    public function getTwo($article_id){
    	return $this->where("article_id", $article_id)->select("id","user_id","content","user_name")->orderBy("id", "desc")->first();
    }

    //评论列表
    public function getList($article_id, $offset=0){
        return $this->where("article_id", $article_id)->select("id","user_id","content","created_at","user_id")->orderBy("id", "desc")->offset($offset)->limit(10)->get();
    }

    public function author(){
		return $this->belongsTo('App\Models\Users','user_id','id');
	}
}
