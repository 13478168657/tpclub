<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class CoachListComment extends Model
{
    use SoftDeletes;
    protected $table = 'coach_list_comments';

    public function user(){

        return $this->belongsTo('App\User','user_id');
    }
}
