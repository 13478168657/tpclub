<?php
namespace App\Constant;


class CustomerPushType{
    const IMAGE = 'IMAGE';//评论
    public static function trans($type){
        switch ($type) {
            case self::COMMENT:
                return '评论';
            case self::ADD:
                return '购买';
            case self::FOLLOW:
                return '关注';
            case self::ENROLL:
                return '报名';
            case self::STUDY:
                return '学习提醒';
            case self::COST:
                return '消费提醒';
        }
    }
}