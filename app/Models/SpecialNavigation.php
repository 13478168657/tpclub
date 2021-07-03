<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class SpecialNavigation extends Model
{
    use SoftDeletes;

    protected $table = 'special_navigations';
}
