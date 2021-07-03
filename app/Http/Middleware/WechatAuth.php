<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\WechatAuthController;
use App\Models\Users;
use Illuminate\Support\Facades\Cookie;
class WechatAuth
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
        if(is_weixin()){
            if(Auth::user()){
//                logger()->info(333);
                $user = Auth::user();
                if(!$user->openid){
                    return redirect('/wechat/auth?redirect='.$path);
                }
            }else{
//                logger()->info(444);
                return redirect('/wechat/auth?redirect='.$path);
            }
        }
        return $next($request);
    }
}
