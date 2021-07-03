<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

class SpbController extends Controller
{
    /**
     *
     * 赛普币首页
     */
    public function index(Request $request)
    {
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            return redirect("/login");
        }
        $page = 1;
        $num = 5;
        $start = $num * ($page - 1);
        $data = DB::table("users")->where("id",$userid)->select("spb")->get();
        $spb = DB::table("spb_records")
                    ->leftJoin("spb_rules","spb_records.spb_rule_id","=","spb_rules.id")
                    ->where("user_id",$userid)
                    ->orderBy("spb_records.id", "desc")
                    ->skip($start)
                    ->take($num)
                    ->select("spb_records.*","spb_rules.title")
                    ->get();
       
        return view("spb.index",['spb'=>$data,'list'=>$spb]);
    }

    /**
     *赛普币json
     */
    public function spbJson(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            return redirect("/login");
        }
        if($request->input("page")){
            $page = $request->input("page");
        }else{
            $page = 2;
        }
        $num = 5;
        $start = $num * ($page - 1);
        $spb = DB::table("spb_records")
                    ->leftJoin("spb_rules","spb_records.spb_rule_id","=","spb_rules.id")
                    ->where("user_id",$userid)
                    ->orderBy("spb_records.id", "desc")
                    ->skip($start)
                    ->take($num)
                    ->select("spb_records.*","spb_rules.title")
                    ->get();
        return json_encode($spb);

    }

    /**
     *赛普币规则
     */
    public function spbRules(Request $request){


        return view("spb.rules");
    }

}
