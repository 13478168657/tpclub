<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AskAnswer extends Model
{
    protected $table = "ask_answer";

    public function users(){
    	return $this->belongsTo("App\User", "user_id", "id");	
    }
}
