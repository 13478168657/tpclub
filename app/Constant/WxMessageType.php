<?php
namespace App\Constant;


class WxMessageType{
    const COMMENT = 'COMMENT';//评论
    const ADD	  = 'ADD'; //购买
    const FOLLOW  = 'FOLLOW';//关注
    const ENROLL  = 'ENROLL';//报名
    const STUDY   = 'STUDY';//学习
    const COST    = 'COST';//消费提醒
    const NOTICE    = 'NOTICE';//消费提醒
    const ACTIVERANK    = 'ACTIVERANK';//活动排名
    const NEWYEAR = 'NEWYEAR';  //新年助力好礼活动
    const ACCESSPRAISE = 'ACCESSPRAISE'; //领取奖励
    const COURSENOTICE = 'COURSENOTICE'; //领取奖励
    const ASKFEEDBACK = 'ASKFEEDBACK'; //提问反馈
    const ASKCOMMENT = 'ASKCOMMENT'; //点评完成提醒
    const DISTRIBUTION = 'DISTRIBUTION'; // 申请分销员通知
    const DISCOURSE    = 'DISCOURSE';    // 打卡课程报名通知
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
            case self::NOTICE:
                return '课程提醒';
            case self::ACTIVERANK:
                return '活动排名';
            case self::ACCESSPRAISE:
                return '领取奖励';
            case self::NEWYEAR:
                return '新年助力好礼活动';
            case self::COURSENOTICE:
                return '课程通知';
            case self::ASKFEEDBACK:
                return '问答提醒';
            case self::ASKCOMMENT:
                return '问答提醒';
            case self::DISTRIBUTION:
                return '分销';
            case self::DISCOURSE:
                return '分销课程报名通知';    
        }
    }
}