<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class CoachListStep extends Model
{
    use SoftDeletes;

    protected $table = 'coach_list_steps';
}
