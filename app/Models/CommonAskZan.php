<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CommonAskZan extends Model
{
    use SoftDeletes;

    protected $table = 'common_ask_zan';
}
