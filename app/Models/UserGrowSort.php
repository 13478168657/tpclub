<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class UserGrowSort extends Model
{
    use SoftDeletes;

    protected $table = 'users_grow_sort';

    public function user(){
        return $this->belongsTo('App\Models\Users','user_id');
    }
}
