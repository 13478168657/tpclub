<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AskQuestion extends Model
{
    protected $table = "ask_question";

    public function users(){
    	return $this->belongsTo("App\User", "user_id", "id");	
    }
}
