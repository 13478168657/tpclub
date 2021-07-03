<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FinanceAccount extends Model
{
    //
    protected $table = "finance_accounts";

    //新增资金总账户
    public function addOne($user_id,$userName = ''){
    	$item = $this->where("user_id", "=", $user_id)->first();
    	if(!$item){
    		$item = new self;
    		$item->user_id = $user_id;
			$item->finance_name = $userName;
    		$item->save();
    	}
    }


    
}
