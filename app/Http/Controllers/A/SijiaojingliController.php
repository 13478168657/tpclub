<?php

namespace App\Http\Controllers\A;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sijiaojingli;


class SijiaojingliController extends Controller
{
    /**
     * ������
     */
    public function mianfei(Request $request)
    {
        //��ȡ��ǰ�û�id
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
     * ������ʼ
     */
    public function zhuli(Request $request)
    {
        //��ȡ��ǰ�û�id
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
