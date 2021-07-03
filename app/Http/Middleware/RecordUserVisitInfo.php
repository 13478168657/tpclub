<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Users;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class RecordUserVisitInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $path = $_SERVER['REQUEST_URI'];
        $filter = $this->ignoreMethod($path);
        if($filter){
//            logger()->info(3);
            return $next($request);
        }
        $arr  = explode("?", $path);
        if(Auth::user()){
        $userid =Auth::user()->id;
        }else{
            $userid = 0;
        }
        $data = array();
        $data['year']   = date("Y");
        $data['month']  = date("Y-m");
        $data['day']    = date("Y-m-d");
        $data['month']  = date("m");
        $data['user_id']= $userid;
        $data['method'] = $arr[0];
        if(isset($arr[1])){
            $data['from']   = $arr[1];
        }
        
        $data['created_at'] = date("Y-m-d H:i:s");
        DB::table("visit_record")->insert($data);
//        dd($path);
        return $next($request);
    }

    private function ignoreMethod($url){
        $code = 0;
        if(strpos($url,'jdt') !== false){
            $code = 1;
        }
        return $code;
    }
}
