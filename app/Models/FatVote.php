<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
class FatVote extends Model
{
    use SoftDeletes;

    protected $table = 'fat_votes';

}
