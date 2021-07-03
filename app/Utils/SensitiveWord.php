<?php
namespace App\Utils;
use Illuminate\Support\Facades\Redis;
class SensitiveWord{

    public function __construct()
    {

    }

    public function filterWord($word){
        if(Redis::exists('sensitiveWords')){
            $sensitiveWords = Redis::lrange('sensitiveWords',0,-1);
        }else{
            $file = fopen(base_path('public/sensitive.txt'),'r');
            while(!feof($file)){
                $content = fgets($file);
                $content=str_replace(PHP_EOL,"",$content);
                Redis::rpush('sensitiveWords',$content);
            }
            fclose($file);
            $sensitiveWords = Redis::lrange('sensitiveWords',0,-1);
        }
        $flag = 0;
        foreach($sensitiveWords as $sensitive){
            if(preg_match("/$sensitive/ui",$word)){
                $flag = 1;
                break;
            }
        }
        return $flag;
    }

}