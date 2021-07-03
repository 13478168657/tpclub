<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DisForm extends Model
{
    use SoftDeletes;

    protected $table = 'dis_form';
}
