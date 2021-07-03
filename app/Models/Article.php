<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    //
    //use SoftDeletes;
    protected $table = "article";

    public function author(){
		return $this->belongsTo('App\Models\Users','user_id','id');
	}
}
