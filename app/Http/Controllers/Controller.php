<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getMessage($code=0,$msg='',$data=[]){
        if($data){
            return json_encode(['code'=>$code,'message'=>$msg,'data'=>$data]);
        }else{
            return json_encode(['code'=>$code,'message'=>$msg]);
        }

    }
}
