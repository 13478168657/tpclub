<?php

namespace App\Http\Controllers\A;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sijiaojingli;


class SijiaojingliController extends Controller
{
    /**
     * 开团起
     */
    public function mianfei(Request $request)
    {
        //获取当前用户id
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }

        echo $userid;
        $sijiaojingli = new Sijiaojingli();
        if($userid > 0){
            $sijiaojingli = new Sijiaojingli();
            $sijiaojingli->user_id = $userid;
            $sijiaojingli->is_first = 1;
            $sijiaojingli->friend_id = 0;
            $re = $sijiaojingli->save();
        }
    }
    /**
     * 助力开始
     */
    public function zhuli(Request $request)
    {
        //获取当前用户id
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }

        echo $userid;
        $sijiaojingli = new Sijiaojingli();
        if($userid > 0){

        }
    }







}
