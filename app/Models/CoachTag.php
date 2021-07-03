<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class CoachTag extends Model
{
    use SoftDeletes;

    protected $table = 'coach_tags';
}
