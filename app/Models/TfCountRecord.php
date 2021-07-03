<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TfCountRecord extends Model
{
    use SoftDeletes;

    protected $table = 'tf_count_record';
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
