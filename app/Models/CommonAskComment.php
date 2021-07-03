<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommonAskComment extends Model
{
    use SoftDeletes;
    protected $table = 'common_ask_comments';

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
