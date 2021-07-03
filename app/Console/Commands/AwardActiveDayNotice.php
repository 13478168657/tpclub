<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Constant\WxMessageType;
use App\Models\ActivityShareRecords;
use App\Models\ActivityUserStatistics;
use App\Models\Courseclass;
use App\User;
use App\Events\WxMessagePush;
class AwardActiveDayNotice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'award:active_day_notice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '奖励活动报名结束日期';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $dataInfo['type'] = WxMessageType::ACTIVERANK;
//        $dataInfo['url'] = 'http://m.saipubbs.com/share/award';
//        logger()->info('推送脚本');
//        $activeUsers = ActivityUserStatistics::where('state',1)->orderBy('invite_num','desc')->orderBy('updated_at','asc')->select('user_id','invite_num')->get();
//        foreach($activeUsers as $k => $active){
////            echo $k.'==='.$active->user_id.'--'.$active->invite_num."\n";
//            $user = User::where('id',$active->user_id)->select('openid','name')->first();
//            if(!$user || ($user && !$user->openid)){
//                continue;
//            }
////            dd($k+1);
//            $dataInfo['notice'] = '感谢您参与“分享好友赢大礼”活动~';
//            $dataInfo['message']['key1'] = $k+1;
//            $dataInfo['message']['key2'] = '2019年1月22日';
//            $dataInfo['message']['remark'] = "活动还有10分钟就结束了，赶紧来刷新自己的名次吧~";
//            $dataInfo['openid'] = $user->openid;
//            if(env('IS_LOCAL') == false){
//                event(new WxMessagePush($dataInfo));
//            }
//        }
//        $dataInfo['type'] = WxMessageType::ACCESSPRAISE;
//        $dataInfo['url'] = 'http://m.saipubbs.com/share/my/gift';
////        logger()->info('推送脚本');
//        $activeUsers = ActivityUserStatistics::where('state',1)->orderBy('invite_num','desc')->orderBy('updated_at','asc')->select('user_id','invite_num')->take(100)->get();
////        dd($activeUsers);
//        foreach($activeUsers as $k => $active){
////            echo $k.'==='.$active->user_id.'--'.$active->invite_num."\n";
//            $user = User::where('id',$active->user_id)->select('openid','name')->first();
//            if(!$user || ($user && !$user->openid)){
//                continue;
//            }
////            dd($k+1);
//            $rank = $k+1;
//
//            $dataInfo['notice'] = '恭喜你中奖了';
//            $dataInfo['message']['key1'] = '分享好友赢大礼';
//            if($rank == 1){
//                $dataInfo['message']['key2'] = '筋膜枪';
//            }elseif($rank >= 2 && $rank <= 6){
//                $dataInfo['message']['key2'] = '蛋白粉';
//            }elseif($rank >= 7 && $rank <= 16){
//                $dataInfo['message']['key2'] = '左旋肉碱';
//            }elseif($rank >= 17 && $rank <= 36){
//                $dataInfo['message']['key2'] = '支链氨基酸肽';
//            }elseif($rank >= 37 && $rank <= 100){
//                $dataInfo['message']['key2'] = '双肩背包';
//            }else{
//                break;
//            }
////            print_r($rank.'---'.$active->invite_num."\n");
//            $dataInfo['message']['key3'] = '2019年1月22日';
//            $dataInfo['message']['remark'] = "奖品领取7日内有效，请尽快点击【详情】进入领奖流程";
//            $dataInfo['openid'] = $user->openid;
//            if(env('IS_LOCAL') == false){
//                event(new WxMessagePush($dataInfo));
//            }
//        }
        $dataInfo['type'] = WxMessageType::COURSENOTICE;
        $dataInfo['url'] = 'http://m.saipubbs.com/course/detail/42.html';
        logger()->info('推送脚本');
        $course = Courseclass::where('id',42)->first();
        $users = User::where('openid','!=','')->where('spb','>=',8000)->select('id','openid')->get();
//        dd($users);
        foreach($users as $k => $user){
//            echo $k.'==='.$active->user_id.'--'.$active->invite_num."\n";
//            dd($k+1);
            if($k%500){
                sleep(5);
            }
            $dataInfo['notice'] = '您好，您可以免费兑换新课程了！';
            $dataInfo['message']['key1'] = $course->title;
            $dataInfo['message']['key2'] = '赛普健身社区';
            $dataInfo['message']['key3'] = '田坤';
            $dataInfo['message']['key4'] = '2019年1月23日';
            $dataInfo['message']['remark'] = "点击详情用赛普币免费兑换课程~";
            $dataInfo['openid'] = $user->openid;
//            dd($dataInfo);
            if(env('IS_LOCAL') == false){
                event(new WxMessagePush($dataInfo));
            }
        }
        $this->info('推送成功,推送结束');
    }
}
