<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityShareRecords extends Model
{

    protected $table = 'activity_share_records';

    public function user(){

        return $this->belongsTo('App\User','user_id');
    }
}
