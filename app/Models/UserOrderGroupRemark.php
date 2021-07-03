<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class UserOrderGroupRemark extends Model
{
    use SoftDeletes;

    protected $table = 'user_order_group_remarks';

}
