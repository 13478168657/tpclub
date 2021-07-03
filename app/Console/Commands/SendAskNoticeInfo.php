<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Constant\WxMessageType;
use App\User;
use App\Models\Studying;
use App\Events\WxMessagePush;
class SendAskNoticeInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:ask_notice_info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '问答板块消息提醒';

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
        /*
         * 提问反馈结果通知
         */
//        $dataInfo['type'] = WxMessageType::ASKFEEDBACK;//
//        $dataInfo['url'] = 'http://m.saipubbs.com/assistance/friend/0.html/?utm_source=mubanxiaoxi';//问答地址
//        $dataInfo['notice'] = '田坤导师解答了你的提问~';
//        $dataInfo['message']['key1'] = '问题标题';
//        $dataInfo['message']['key2'] = '问题描述';
//        $dataInfo['message']['remark'] = "点击赶快查阅吧~";
//        $dataInfo['openid'] = 'ogGtrv2zRkqvjKu2xbsnOZYRau4I';
//        if(env('IS_LOCAL') == false){
//            event(new WxMessagePush($dataInfo));
//        }

        /*
         * 提问反馈结果通知
         */
        $dataInfo['type'] = WxMessageType::ASKCOMMENT;//
        $dataInfo['url'] = 'http://m.saipubbs.com/assistance/friend/0.html/?utm_source=mubanxiaoxi';//问答地址
        $dataInfo['notice'] = '你提交的作业得到老师的点评了~';
        $dataInfo['message']['key1'] = '田坤';
        $dataInfo['message']['key2'] = '作业标题';
        $dataInfo['message']['key3'] = '巴拉巴拉……';
        $dataInfo['message']['remark'] = "点击赶快查阅吧~";
        $dataInfo['openid'] = 'ogGtrv2zRkqvjKu2xbsnOZYRau4I';
        if(env('IS_LOCAL') == false){
            event(new WxMessagePush($dataInfo));
        }

        $this->info('推送成功,推送结束');
    }
}
