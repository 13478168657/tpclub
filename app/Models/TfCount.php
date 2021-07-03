<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TfCount extends Model
{
    use SoftDeletes;

    protected $table = 'tf_count';
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
