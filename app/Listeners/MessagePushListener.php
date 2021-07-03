<?php

namespace App\Listeners;

use App\Events\WxMessagePush;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Utils\WxMessagePush as messagePush;
class MessagePushListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  name  $event
     * @return void
     */
    public function handle(WxMessagePush $event)
    {
        $data = $event->data;
        $openid = $data['openid'];
        if(!$openid){
            return false;
        }
        
        $wxPush = new messagePush();
        $res = $wxPush->sendMessage($data);
    }
}
