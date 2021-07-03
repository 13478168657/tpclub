<?php
namespace App\Constant;

class UserGender{
    const FEMALE  = 'female';
    const MALE = 'male';
    const UNKNOWN  = 'unknow';

    public static function trans($type){
        switch($type){
            case 1:
                return self::MALE;
            case 2:
                return self::FEMALE;
            case 0:
                return self::UNKNOWN;
            default:
                return self::MALE;
        }
    }
}