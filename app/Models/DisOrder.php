<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DisOrder extends Model
{
    use SoftDeletes;
    protected $table = 'dis_order';
}