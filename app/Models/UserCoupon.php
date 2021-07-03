<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class UserCoupon extends Model
{
    use SoftDeletes;
    protected $table = 'users_coupon';
}
