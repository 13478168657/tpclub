<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Constant\WxMessageType;
use App\User;
use App\Models\Studying;
use App\Events\WxMessagePush;
class PushCourseMessageToUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:course_msg_to_user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '消息推送';

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
        $dataInfo['type'] = WxMessageType::NOTICE;
        $dataInfo['url'] = 'http://m.saipubbs.com/assistance/friend/0.html/?utm_source=mubanxiaoxi';
        logger()->info('推送脚本');
//        $total = Studying::where('course_class_id',15)->select('user_id')->distinct('user_id')->count();
        $studyInfo = Studying::where('course_class_id',15)->where('id','>',35885)->select('id','user_id')->distinct('user_id')->limit(10000)->get();
        $study = Studying::where('course_class_id',15)->select('id','user_id')->distinct('user_id')->orderBy('id','desc')->limit(5000)->get();
        foreach($studyInfo as $k => $stu){
            $user = User::where('id',$stu->user_id)->select('openid','name')->first();

            if(!$user || ($user && !$user->openid)){
                continue;
            }

            $dataInfo['notice'] = '年前最后一波福利来袭，免费领价值69元的【孕产教练必备课程】，活动仅剩3天~';
            $dataInfo['message']['key1'] = '孕产教练必备课程';
            $dataInfo['message']['key2'] = '课程活动仅剩3天';
            $dataInfo['message']['key3'] = '等您领取';
            $dataInfo['message']['remark'] = "点击下方【详情】，马上领取↓↓↓";
            $dataInfo['openid'] = $user->openid;
            if(env('IS_LOCAL') == false){
                event(new WxMessagePush($dataInfo));
            }

            if($k % 5000 ==0){
                sleep(10);
            }
        }

        foreach($study as $k => $stu){
            $user = User::where('id',$stu->user_id)->select('openid','name')->first();

            if(!$user || ($user && !$user->openid)){
                continue;
            }

            $dataInfo['notice'] = '年前最后一波福利来袭，免费领价值69元的【孕产教练必备课程】，活动仅剩3天~';
            $dataInfo['message']['key1'] = '孕产教练必备课程';
            $dataInfo['message']['key2'] = '课程活动仅剩3天';
            $dataInfo['message']['key3'] = '等您领取';
            $dataInfo['message']['remark'] = "点击下方【详情】，马上领取↓↓↓";
            $dataInfo['openid'] = $user->openid;
            if(env('IS_LOCAL') == false){
                event(new WxMessagePush($dataInfo));
            }
        }
        $this->info('推送成功,推送结束');
    }
}
