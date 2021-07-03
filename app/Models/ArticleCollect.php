<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCollect extends Model
{
    //
    //use SoftDeletes;
    protected $table = "article_collect";

    public function author(){
		return $this->belongsTo('App\Models\Users','user_id','id');
	}

    public function article(){
        return $this->belongsTo('App\Models\Article','article_id');
    }
}
