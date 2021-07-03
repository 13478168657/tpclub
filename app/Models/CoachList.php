<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class CoachList extends Model
{
    use SoftDeletes;

    protected $table = 'coach_lists';


    public function user(){

        return $this->belongsTo('App\User','author_id');
    }
}
