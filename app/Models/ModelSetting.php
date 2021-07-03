<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\ModelProject;
class ModelSetting extends Model
{
    use SoftDeletes;

    protected $table = 'model_settings';

    public function projects($id){

        return ModelProject::where('model_id',$id)->where('state',1)->orderBy('sort','desc')->get();
    }
}