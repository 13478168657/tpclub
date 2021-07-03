<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
class IntroductionResource extends Model
{
	//转介绍人所带来得资源表
	protected $table = "introduction_resource";

	public function getIntroPerson(){

		return User::where('id',$this->int_person_id)->select('name')->first();
	}
}