<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class UsersAttribute extends Model
{
    //use SoftDeletes;
    protected $table = 'users_attribute';
    

}
