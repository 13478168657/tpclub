<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assistance extends Model
{
    protected $table = 'activity_team';

    public function user(){

        return $this->belongsTo('App\User','friend');
    }
}
