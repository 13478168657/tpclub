<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TfOrder extends Model
{
    use SoftDeletes;

    protected $table = 'tf_order';
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
