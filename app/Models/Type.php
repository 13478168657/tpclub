<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    //use SoftDeletes;
    protected $table = "type";

    public function getList($model){
    	return self::where("state",1)->where("is_index",1)->where("model", $model)->select("id","title")->get();
    }

    static public function getTitle($id){
    	return self::where("id", $id)->where("state", 1)->select("title")->first();
    }
}
