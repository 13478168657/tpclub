<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

class MoneyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            return redirect("/login");
        }
        $data = DB::table("finance_accounts")->where("user_id",$userid)->select("total")->get();
       // dd($data);

        return view("money.index",["spb"=>$data]);
    }

/**
 * 提现界面
 */

    public function tixian(Request $request){

        if($request->user()){
            $userid = $request->user()->id;
        }else{
            return redirect("/login");
        }

        $array = $request->input();
        $data = DB::table("finance_accounts")->where("user_id",$userid)->select("total")->get();
        if($array && isset($array['money'])){
             array_shift($array);
             unset($array['_token']);
             if($data[0]->total > $array['money']){
                 $array['finance'] = $data[0]->total - $array['money'];
                 $array['created_at'] = date("Y-m-d H:i:s");
                 $re = DB::table("applies")->insert($array);
                 if($re){
                    //----修改账户余额----
                    $ccc['total'] = $array['finance'];
                    $ccc['frozen_total'] = $array["money"];
                    $aaa = DB::table("finance_accounts")->where("user_id",$userid)->update($ccc);
                 }
                 return back()->with('tixian_success','提现请求已成功提交');
             }else{
                return back()->with('tixian_error','余额不足');
             }
        }
        return view("money.tixian",["spb"=>$data,"userid"=>$userid]);
    }

    /**
     * 查看帮助
     */
    public function help(){

        return view("money.help");
    }
    /**
     * 我的收入
     * @return [type] [description]
     */
    public function myincome(Request $request)
    {
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            return redirect("/login");
        }
        $page = 1;
        $num  = 1;
        $start = $num * ($page - 1);
        $con['type']    = "ADD";
        $con['user_id'] = $userid;
        
        $data = DB::table("finance_records")->where($con)->select("course_class_id")->skip($start)->take($num)->get()->toArray();
         //dd($data);
        if($data){                                    
            foreach($data as $k){
                $course_id = $k->course_class_id;
                $a['type'] = "BUY";
                $a['course_class_id'] = $course_id;
                $course = DB::table("finance_records")->where($a)->orderBy("id","desc")->get();
                $courseArr[] = $course;
            }
            foreach($courseArr as $v){  
                foreach($v as $s){
                    $s->user_name = get_teacher_name($s->user_id)->name;
                    $s->course_class_name = getCourseName($s->course_class_id);
                    $arr2[] = $s;
                }
            }
        }else{
            $arr2 = [];
        }
      
        return view("money.myincome",["list" => $arr2]);
    }
    public function myincomeJson(Request $request)
    {
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
        $num = 1;
        $start = $num * ($page - 1);
        $con['type'] = "ADD";
        $con['user_id'] = $userid;
        $data = DB::table("finance_records")->where($con)->select("course_class_id")->skip($start)
                                            ->take($num)->get()->toArray();
        // dd($data);                                   
        if($data){                                  
            foreach($data as $k){
                $course_id = $k->course_class_id;
                $a['type'] = "BUY";
                $a['course_class_id'] = $course_id;
                $course = DB::table("finance_records")->where($a)->orderBy("id","desc")->get();
                $courseArr[] = $course;
            }
            foreach($courseArr as $v){  
                foreach($v as $s){
                    $s->user_name = get_teacher_name($s->user_id)->name;
                    $s->course_class_name = getCourseName($s->course_class_id);
                    $arr2[] = $s;
                }
            }
        //dd($arr2);
        
            $all['code'] = 1;
            $all['data'] = $arr2; 
            return json_encode($all);
        }else{
            $c['code'] = 0;
            return json_encode($c);
        }
        
    }

    /**
     * 支付记录
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function myrecord(Request $request)
    {
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            return redirect("/login");
        }
        $con['user_id'] = $userid;
        
        $data = DB::table("finance_records")->where($con)->whereIn("type",["APPLY","BUY"])->orderBy("id","desc")->skip(0)->take(2)->get();
        //dd($data);
        return view("money.myrecord",['data'=>$data]);
    }
    public function getRecord(Request $request){
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
        $num = 2;
        $start = $num * ($page - 1);
        $data = DB::table("finance_records")->where("user_id",$userid)
                                            ->whereIn("type",["APPLY","BUY"])
                                            ->orderBy("id","desc")
                                            ->skip($start)
                                            ->take($num)
                                            ->get();
        return json_encode($data);                                 
    }

  
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         