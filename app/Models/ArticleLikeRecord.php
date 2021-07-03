<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleLikeRecord extends Model
{
    //use SoftDeletes;
    protected $table = "article_like_records";

    public function author(){
		return $this->belongsTo('App\Models\Users','user_id','id');
	}
}
