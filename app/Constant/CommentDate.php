<?php
namespace App\Constant;
class CommentDate{


    public static function getDate($time){
        $diffTime = time() - strtotime($time);
//        dd($diffTime);
        $day = floor($diffTime/86400);
        $hours = floor($diffTime/3600);
        $minutes = floor($diffTime/60);
        if($day > 365){
            return '1年前';
        }
//        dd($day,$hours,$minutes);
        if($day > 31){
            return '1个月前';
        }
        if($day >= 1){
            return $day.'天前';
        }
        if($hours >= 1){
            return $hours.'小时前';
        }
        if($minutes >= 1){
            return $minutes.'分钟前';
        }else{
            return '刚刚';
        }
    }
}