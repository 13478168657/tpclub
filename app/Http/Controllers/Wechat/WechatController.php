<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WeChatLog;
use App\Utils\WxMessagePush as WxPush;
use App\Utils\WxQRcode;
use App\Utils\ImageThumb;
use App\Utils\MakeThumbPic;
use App\Models\Courseclass;
use App\Models\Users;
use App\Models\WechatNews;
use App\Models\WechatReply;
use App\Models\CourseClassAbout;
use App\Models\WechatInvitation;     //邀请用户
use App\Models\Studying;
use App\Models\ActivityShareRecords;
use App\Constant\WxMessageType;
use App\Models\CourseClassPush;
use App\Models\WechatSubscribeWay;
use App\Models\WechatActivityHand;
use App\Http\Controllers\Wechat\WeChatMessageController;
use App\Http\Controllers\Distribution\CoachTrainController;
use App\Events\WxMessagePush;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Events\WxCustomerMessagePush; 
use App\Models\DisCourseClass;
use App\Models\Sijiaojingli;



class WechatController extends Controller
{
    public function index(){
    	//$wechat_log = new WeChatLog();    //支付日志
    	//$wechat_log->info  = json_encode($_GET); //记录正常支付日志
    	//$wechat_log->save();    
        //logger()->info("成功接收微信信息");
		if (!isset($_GET['echostr'])) {
			$this->responseMsg();
		}else{
		    $this->valid();
		}
    }

    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = "saipubbsmm";
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if($tmpStr == $signature){
            return true;
        }else{
            return false;
        }
    }

    //判断用户消息类型
    public function responseMsg()
    {
        $postStr = file_get_contents('php://input');
        if (!empty($postStr)){
            $this->logger("R ".$postStr);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            $json = xmlToArray($postStr);
            $wechat_log = new WeChatLog();    //支付日志
            $wechat_log->info  = json_encode($json); //记录正常支付日志
            $wechat_log->save(); 

            switch ($RX_TYPE)
            {
                case "event":
                    $result = $this->receiveEvent($postObj);
                    break;
                case "text":
                    $result = $this->receiveText($postObj);
                    break;
            }
//            $this->logger("T ".$result);
            echo $result;
        }else {
            logger()->info(222);
            echo "";
            exit;
        }
    }
    //用户触发事件  关注/取关/点击事件
    private function receiveEvent($object)
    {
        $content = "";
        $new     = false;
        $data    = array();
        switch ($object->Event)
        {
            case "subscribe":
                //自动回复客服消息
                $this->subscribe_service($this->wx_user($object->FromUserName));
                $replyData = WechatReply::where("event",1)->first();
                if($replyData){
                    $content = $replyData->content;
                }else{
                    $content = "赛普健身社区——健身教练的终身学习平台";
                }
                $key     = $object->EventKey;
                //创建关注公众号的新用户
                $cur_user = Users::where("openid", $object->FromUserName)->first();
                if(strpos($key,'acsm-') !== false){
                    $share_id = explode('-',$key)[1];
//                    logger()->info('分享id::--'.$share_id);
                    if($cur_user && $cur_user->mobile != ''){
                        $cur_user->subscribe = 1;
                    }elseif($cur_user && $cur_user->mobile == ''){
                        if($cur_user->id != $share_id){
                            $cur_user->delete();
                            $cur_user =  Users::where("id", $share_id)->first();
                            $cur_user->openid = $object->FromUserName;
                            $cur_user->subscribe = 1;
                        }
                    }else{
                        $cur_user =  Users::where("id", $share_id)->first();
                        $cur_user->openid = $object->FromUserName;
                        $cur_user->subscribe = 1;
                    }
                }else{
                    if($cur_user){
                        $cur_user->subscribe = 1;
                    }else{
                        $cur_user = new Users();
                        $cur_user->openid = $object->FromUserName;
                        $cur_user->subscribe = 1;
                    }
                }


                $cur_user->save();

                if(strpos($key,'live_video') !== false){
                    $wechatWay = WechatSubscribeWay::where('user_id',$cur_user->id)->where('subscribe_way','live_video')->first();
                    if(!$wechatWay){
                        $wechatWay = new WechatSubscribeWay();
                        $wechatWay->user_id = $cur_user->id;
                        $wechatWay->subscribe_way = 'live_video';
                        $wechatWay->save();
                    }
                }
//                logger()->info('关注:'.$key);
                //logger()->info($cur_user);
                if(in_array($key,['qrscene_video_sp','qrscene_poster_1','qrscene_poster_2','qrscene_poster_3','qrscene_ppt_ppt'])){
                    if($key=='qrscene_video_sp'){
                        $href = "<a href='http://m.saipubbs.com/cak/1.html?sp'>点我，进入赛普知道</a>";
                    }elseif($key == 'qrscene_poster_1'){
                        $href = "<a href='http://m.saipubbs.com/cak/1.html?haibao_1'>点我，进入赛普知道</a>";
                    }elseif($key == 'qrscene_poster_2'){
                        $href = "<a href='http://m.saipubbs.com/cak/1.html?haibao_2'>点我，进入赛普知道</a>";
                    }elseif($key == 'qrscene_poster_3'){
                        $href = "<a href='http://m.saipubbs.com/cak/1.html?haibao_3'>点我，进入赛普知道</a>";
                    }elseif($key == 'qrscene_ppt_ppt'){
                        $href = "<a href='http://m.saipubbs.com/cak/1.html?ppt'>点我，进入赛普知道</a>";
                    }
                    $content = "Hi~欢迎关注赛普健身社区。\n\n自己有问题，带会员有问题，就来赛普知道，百位赛普专业老师坐镇，只有你问不出的，没有导师答不了的；\n\n没有问题，也要来赛普知道围观问题，增肌、减脂、康复等技能一键get！\n\n".$href."，向导师提问吧。\n\n赛普知道——健身教练的问答平台，有问题，就上赛普健身社区！";

                }else{
                    if(strpos($key,'coach') !== false){
                        $coachArr = explode('_',$key);
                        $DisCourseClass = new DisCourseClass;
                        $item = DisCourseClass::where("id", $coachArr[2])->first();
                        if($item){
                        $content = "您好，您已成功报名以下课程：\n\n"."<a href='http://m.saipubbs.com/dist/study/".$coachArr[2].".html'>《".$item->title."》</a>";
                        }

                    }elseif(strpos($key,'qixi') !== false){
                        $content = "【七夕一问】有一个爱健身的另一半是一种什么体验？\n不管那个人是前任，现任，相信一定有让你之后无数次想起的深深体验，\n<a href='http://m.saipubbs.com/cak/answer/4027/1.html"."'>点我，一起讨论</a>";
                    }elseif(strpos($key,'weekAsk')!== false){
                        if(strpos($key,'weekAsk1') !== false){
                            $content = "【每周一问】健身俱乐部or工作室，你是如何选择的？\n相信大家都经历过去俱乐部还是工作室的灵魂质问吧～所以你是如何选择，又是为什么这样选择呢？\n<a href='http://m.saipubbs.com/cak/answer/4136/1.html"."'>点我：一起来讨论</a>\n点赞数排名前三的答主，可获价值99元课程～";
                        }else{
                            $content = "【每周一问】还记得你第一次带会员时的经历吗？\n作为教练，第一次带会员时的经历无论美好不美好，相信你都记忆犹新吧~\n<a href='http://m.saipubbs.com/cak/answer/4097/1.html"."'>点我：一起讨论</a>\n点赞数排名前三的答主可获得价值199元课程~";
                        }

                    }elseif(strpos($key,'fenghui') !== false){
                        $content = "2019IDEA峰会正在进行时\n<a href='https://www.runff.com/html/live/s2429.html?from=groupmessage&isappinstalled=0"."'>点我</a>,观看图片直播";
                    }elseif(strpos($key,'career_plan') !== false){

                        if(strpos($key,'career_plan_a') !== false){

                            $content = "您好，恭喜您完成了职业规划第1次课程，感谢您全程参与到我们的课程当中。\n\n为了不断提升课程授课效果，我们需要您的宝贵建议:\n\n"."<a href='http://m.saipubbs.com/user/feedback/1.html'>点击这里</a>写下您的课程感受吧~";
                        }elseif(strpos($key,'career_plan_b') !== false){
                            $content = "您好，恭喜您完成了职业规划第2次课程，感谢您全程参与到我们的课程当中。\n\n为了不断提升课程授课效果，我们需要您的宝贵建议:\n\n"."<a href='http://m.saipubbs.com/user/feedback/2.html'>点击这里</a>写下您的课程感受吧~";
                        }else{
                            $content = "您好，恭喜您完成了职业规划第3次课程，感谢您全程参与到我们的课程当中。\n\n为了不断提升课程授课效果，我们需要您的宝贵建议:\n\n"."<a href='http://m.saipubbs.com/user/feedback/3.html'>点击这里</a>写下您的课程感受吧~";
                        }
                    }elseif(strpos($key,'nasm_active') !== false){
                        $content = "4700元学NASM报名通道只针对赛普在校生开放，为避免产生不必要的麻烦，请先查询是否符合申请资格再进行报名→"."<a href='http://m.saipubbs.com/nasm/form.html'>查询通道</a>\n非赛普在校生可先→<a href='http://m.saipubbs.com/nasm/access.html'>申请在校学员身份</a>，获取赛普在校生学籍后再申请4700元学NASM\n确信自己是赛普在校学员的，也可→<a href='http://m.saipubbs.com/course/detail/58.html'>直接报名</a>";
                    }elseif(strpos($key,'live_video') !== false){
                        $userObj = json_decode(json_encode($object));
                        $this->pushLiveVideo($userObj->FromUserName);
                    }elseif(strpos($key,'saishi') !== false) {
                        $content = "今年北京最后一场健身赛事！！！12月1日，肌肉战士、运动天使、时尚先生、健身男模、运动宝贝、才艺之星将齐聚赛普健身全明星赛北京站舞台，闪耀健身荣耀时刻，老铁们赶快点此链接完成报名吧！http://m.saipujiaoyu.com/Saishi?tid=20";
                    }elseif(strpos($key,'bjfreecourse') !== false) {
                        $content = "【免费】10月24日18:00-21:00JOINFIT公开课北京站#小工具的康复训练、用对了是康复，用错了叫自虐。三小时教你最底层的康复逻辑，戳此链接完成报名https://saipujianshenxueyuan.mikecrm.com/3QbaJV1";
                    }elseif(strpos($key,'sijiaojingli_mianfei') !== false){//新关注--私教经理免费体验
                        $new = 'img';
                        $content = $this->sijiaojingli($key,$cur_user);
                    }elseif(strpos($key,'sijiaojingli_xinhuodong') !== false){
                        $new = 'img';
                        $content = $this->sijiaojingli_xinhuodong($cur_user);

                    }elseif(strpos($key,'sijiaojingli_mf_zhuli') !== false){//新关注--私教经理扫码助力--sijiaojingli_mianfei_zhuli
                        $content = $this->sijiaojingli_zhuli($key,$cur_user);
                        if(preg_match('/[\x{4e00}-\x{9fa5}]/u', $content) == 0){
                            $new = 'img';
                        }
                    }elseif(strpos($key,'activity_shequ') !== false){//activity_qingshaoer 
                        $content  = $this->activity_qingshaoer($cur_user);

                    }elseif(strpos($key,'shequ_zhibo_1') !== false){//社区直播1
                        $content  = $this->shequ_zhibo_1($cur_user);
                    }elseif(strpos($key,'acsm_zhibohuodong') !== false){//活动ACSM直播海报
                        $new = 'img';
                        $content = $this->acsm_zhibohuodong($cur_user);

                    }elseif(strpos($key,'saipuoldstudent') !== false){ //saipuoldstudent 赛普老学员分享直播
                        $content = "您已成功预约赛普老学员分享
                                    \n直播时间：11月1日16：00
                                    \n直播地址：
                                    \n https://vzan.com/live/tvchat-1173803874?v=637081461265186942#/";

                    }elseif(strpos($key,'acsm') !== false){

                        $content = $this->unlineCoursePush($key,$cur_user);
                    }elseif(strpos($key,'asm_course_assign') !== false){
                        $content = $this->assignAcsmPush($key,$cur_user);

                    }elseif(strpos($key,'xiaocutui') !== false){
                        $data['type'] = 'xiaocutui';
                        $data['key'] = $key;
                        $data['user'] = $cur_user;
                        $new = 'img';
                        $content = $this->commonMessagePush($data);

                    }elseif(strpos($key,'songke') !== false){
                        $data['type'] = 'songke';
                        $data['key'] = $key;
                        $data['user'] = $cur_user;
                        $new = '';
                        $content = $this->commonMessagePush($data);

                    }elseif(strpos($key,'justdoit') !== false){
                        $data['type'] = 'justdoit';
                        $data['key'] = $key;
                        $data['user'] = $cur_user;
                        $new = '';
                        $content = $this->commonMessagePush($data);

                    }elseif(strpos($key,'vote') !== false){
                        //just do it 活动20191222  投票专属二维码
                        $data['user_id'] = trim($key ,"qrscene_vote");
                        $data['type'] = 'vote';
                        $data['key']  = $key;
                        $data['user'] = $cur_user;
                        $match        = DB::table("intro_active_users")->where("user_id",$data['user_id'])->where('type','DOIT')->first();
                        if($match){
                            $data['m_name'] = json_decode($match->user_info, true)['name'];
                        }else{
                            $data['m_name'] = "你的好友";
                        }
                        $content = $this->commonMessagePush($data);
                    }elseif(strpos($key,'jdtUser') !== false){
                            //just do it 活动20191222  投票专属二维码
                        $data['type'] = 'jdtUser';
                        $data['key']  = $key;
                        $data['user'] = $cur_user;
                        $new = '';
                        logger()->info('当前用户.'.$cur_user->id);
                        $match = DB::table("intro_active_users")->where("user_id",$cur_user->id)->where('type','DOIT')->first();
                        if($match){
                            $data['name'] = json_decode($match->user_info, true)['name'];
                        }else{
                            $data['name'] = "你的好友".$data['user_id'];
                        }
                        $content = $this->commonMessagePush($data);
                    }elseif(strpos($key,'jobCollect') !== false){
                        $new = '';
                        $content = "紧张的学习生活匆匆而过，转眼即将面临就业选择，在接下来的一段时间班主任将开始为各位学员进行工作推荐和匹配~\n——————\n赶快<a href='http://m.saipubbs.com/stu/info/collect.html"."'>填写你的就业需求</a>吧~";
                    }else{
                        //扫码新关注的小伙伴
                        if (strlen($key) > 5) {
                            if (count(explode('_', $key)) == 2) {
                                $keyArr = explode('_', $key);
                                users_growing(0, $cur_user->id, "", $keyArr[1]);
                                //扫码分销二维码关注的小伙伴
                                if ($keyArr[1] == 'distribution') {
                                    $content = "您好，现在点击右下角菜单栏了解赛普>>分销员中心 就可以进入赛普健身社区课程顾问申请流程，申请成功即可享看课特权~";
                                } elseif ($keyArr[1] == 'distribution_course') {
                                    //购买分销打卡课程成功后
                                    $content = "您已成功报名打卡课程，查看每日课程内容请点击菜单栏 进入社区 > 我的课表 > 参加的打卡课程";
                                } elseif ($keyArr[1] == 'askspecial') {
                                    //20190618  添加
                                    $content = "欢迎来到赛普健身社区「健身行业大盘问」 林怀慎院长专场。\n说出你最想问的\n林院长亲自作答，给出走心实用的答案！\n点击下方链接↓ ↓↓ 向林院长发问\nhttp://m.saipubbs.com/ask/answer/14.html\n你也可以从底部菜单【进入社区-问答专场】进入查看更多专场问答";
                                } elseif ($keyArr[1] == 'getclass') {
                                    $content = "Hi，同学你好，课程已经加到你的课表中，点击下方就可以去听课啦~<a href='http://m.saipubbs.com/course/detail/56.html'>点击去上课</a>";
                                }
                            } else {
                                $keyArr = explode('_', $key);
                                $user = DB::table("users")->where("id", $keyArr[2])->select("id", "openid", 'name')->first();
                                //分享人如果不存在创建用户
                                if (!$user) {
                                    $user = new Users();
                                    $user->subscribe = 1;
                                    $user->save();
                                }

                                DB::beginTransaction();
                                try {
                                    $class = DB::table("course_class")->where("id", $keyArr[1])->select("explain_url", "id", 'title')->first();

                                    $data['type'] = "IMAGE";
                                    $data['openid'] = $cur_user->openid;
                                    $title = '【' . $class->title . '】';
                                    $data['list'] = [[
                                        "title" => $title,
                                        "description" => "你已成功接受" . ($user->name ? $user->name . '的' : '') . "邀请，关注了该系列课。\n点击进入查看课程详情报名",
                                        "url" => env('APP_URL') . '//course/detail/' . $class->id . ".html",
                                        "picurl" => env('IMG_URL') . $class->explain_url]];
                                    event(new WxCustomerMessagePush($data));
                                    if (isset($keyArr[3])) {
                                        users_growing($user->id, $cur_user->id, 'course' . $class->id, $keyArr[3]);
                                    } else {
                                        users_growing($user->id, $cur_user->id, 'course' . $class->id, "saoma");
                                    }

                                    DB::commit();
                                    // }
                                } catch (\Exception $e) {
                                    logger()->info('ceshi:' . $e->getMessage());
                                    DB::rollback();
                                }
                            }
                        }
                    }
                }

                break;
            case "unsubscribe":
                $content = "取消关注";
                //将用户信息设置为取消关注
                $user = Users::where("openid", $object->FromUserName)->first();
                if($user){
                    $user->subscribe = 0;
                    $user->save();
                }
                break;
            case "CLICK":
                $key = $object->EventKey;
               /* if($key=="follow"){
                    $content = "为了感谢你的关注，我们现为你送出多套<a href='http://m.saipubbs.com'>精选课程</a>，好课持续上新中~";
                }*/
                 $replyData = WechatReply::where("event",4)->get();
                    foreach($replyData as $v){
                        if($key == $v->keyword){
                            $content = $v->content;
                        }
                        if(!empty($v->keyword)){
                            $content = $v->content;
                        }
                    }
                break;
            case "SCAN":
                $wechatInfo = json_decode(json_encode($object),true);
//                logger()->info($wechatInfo);
                //已关注扫码来的小伙伴
                //$replyData = WechatReply::where("event",3)->get();
                //$content = $replyData[0]->content;
                $key = $wechatInfo['EventKey'];
//                logger()->info($key);

                $cur_user = Users::where("openid", $object->FromUserName)->first();
//创建关注公众号的新用户
                if(strpos($key,'acsm-') !== false){
                    $share_id = explode('-',$key)[1];
//                    logger()->info('分享id::--'.$share_id);
                    if($cur_user && $cur_user->mobile != ''){
                        $cur_user->subscribe = 1;
                    }elseif($cur_user && $cur_user->mobile == ''){
                        if($cur_user->id != $share_id){
                            $cur_user->delete();
                            $cur_user =  Users::where("id", $share_id)->first();
                            $cur_user->openid = $object->FromUserName;
                            $cur_user->subscribe = 1;
                        }
                    }else{
                        $cur_user =  Users::where("id", $share_id)->first();
                        $cur_user->openid = $object->FromUserName;
                        $cur_user->subscribe = 1;
                    }
                    $cur_user->save();
                }
                $cur_user->subscribe = 1;
                $cur_user->save();
                if(strpos($key,'live_video') !== false && $cur_user){
                    $wechatWay = WechatSubscribeWay::where('user_id',$cur_user->id)->where('subscribe_way','live_video')->first();
                    if(!$wechatWay){
                        $wechatWay = new WechatSubscribeWay();
                        $wechatWay->user_id = $cur_user->id;
                        $wechatWay->subscribe_way = 'live_video';
                        $wechatWay->save();
                    }
                }
                if($key=='score'){
                    $openid = $wechatInfo['FromUserName'];
                    $userInfo = $this->wx_user($openid);
                    $dataInfo['type']   = "SCORE";
                    $dataInfo['url'] = env('APP_URL').'/answer';
                    $dataInfo['notice'] = 'HELLO，欢迎你参与隐藏的性格测试，揭开你内心最真实的一面';
                    $dataInfo['message']['key1'] = $userInfo['nickname'];
                    $dataInfo['message']['key2'] = '自恋资本摸底考试';
                    $dataInfo['message']['key3'] = '2019年1月10日';
                    $dataInfo['message']['key4'] = '2019年2月28日';
                    $dataInfo['message']['key5'] = '老铁，都这么熟拉，当然免费~';
                    $dataInfo['message']['remark'] = "点击下方【详情】立即参与测试↓↓↓";
                    $dataInfo['openid'] = $openid;
                    if(env('IS_LOCAL') == false){
                        event(new WxMessagePush($dataInfo));
                    }
                    return ;
                }elseif($key == 'sijiaojingli_mianfei'){//已关注 --- 私教经理免费体验
                    $new = 'img';
                    $content = $this->sijiaojingli($key,$cur_user);
                }elseif(strpos($key,'sijiaojingli_mf_zhuli') !== false){//已关注 --- 私教经理扫码助力--
                    $content = $this->sijiaojingli_zhuli($key,$cur_user);
                    if(preg_match('/[\x{4e00}-\x{9fa5}]/u', $content) == 0){
                        $new = 'img';
                    }
                }elseif(strpos($key,'saipuoldstudent') !== false){ //赛普老学员分享直播
                    $content = "您已成功预约赛普老学员分享
                                    \n直播时间：11月1日16：00
                                    \n直播地址：
                                    \n https://vzan.com/live/tvchat-1173803874?v=637081461265186942#/";

                }elseif(strpos($key,'acsm_zhibohuodong') !== false){//活动ACSM直播海报
                    $new = 'img';
                    $content = $this->acsm_zhibohuodong($cur_user);

                }elseif(strpos($key,'sijiaojingli_xinhuodong') !== false){
                    $new = 'img';
                    $content = $this->sijiaojingli_xinhuodong($cur_user);

                }elseif($key=='year'){
                    $openid = $wechatInfo['FromUserName'];
                    $userInfo = $this->wx_user($openid);
                    $dataInfo['type']   = "SCORE";
                    $dataInfo['url'] = env('APP_URL').'/newyear/index.html';
                    $dataInfo['notice'] = 'HELLO，新年最大福利免费领，错过这次就要等2020年啦~';
                    $dataInfo['message']['key1'] = $userInfo['nickname'];
                    $dataInfo['message']['key2'] = '新学期充电福利 为你的2019加油大气';
                    $dataInfo['message']['key3'] = '2019年1月23日';
                    $dataInfo['message']['key4'] = '2019年2月19日';
                    $dataInfo['message']['key5'] = '老铁，全都免费，不领白领啦~~';
                    $dataInfo['message']['remark'] = "健身课程，100元京东卡，20元红包现金，家用收腹机等好礼，全都免费领~
点击下方【详情】立即领取↓↓↓";
                    $dataInfo['openid'] = $openid;
                    if(env('IS_LOCAL') == false){
                        event(new WxMessagePush($dataInfo));
                    }
                    return ;
                }elseif($key=='distribution'){
                    $content = "您好，现在点击右下角菜单栏了解赛普>>分销员中心 就可以进入赛普健身社区课程顾问申请流程，申请成功即可享看课特权~";

                }elseif($key=='askspecial'){
                    //20190618  添加
                    $content = "欢迎来到赛普健身社区「健身行业大盘问」 林怀慎院长专场。\n说出你最想问的\n林院长亲自作答，给出走心实用的答案！\n点击下方链接↓ ↓↓ 向林院长发问\nhttp://m.saipubbs.com/ask/answer/14.html\n你也可以从底部菜单【进入社区-问答专场】进入查看更多专场问答";
                }elseif($key == 'getclass'){
                    $content = "Hi，同学你好，课程已经加到你的课表中，点击下方就可以去听课啦~<a href='http://m.saipubbs.com/course/detail/56.html'>点击去上课</a>";
                }elseif($key == 'sijiaokaidan') {
                    $content = "欢迎来到赛普健身社区「私教开单基本法」专场问答
\n我们经常听到，作为一名私教最烦恼的是：开单、开单还是开单！\n私教开单专场问答来啦~
\n点击下方链接↓ ↓↓ \nhttp://m.saipubbs.com/ask/answer/18.html\n你也可以从底部菜单【进入社区-问答专场】进入查看更多专场问答";
                }elseif($key == 'disclass'){
                    $info     = array();
                    $info['openid'] = $wechatInfo['FromUserName'];
                    $info['type']   = 'TEXT';
                    $info['text']   = "您可以点击下方链接进入我的课表查看已领取的价值600元的线上课程。\n也可以通过底部菜单栏【进入社区】-【我的课表页】查看。";
                    event(new WxCustomerMessagePush($info));

                    $new = true;
                    $data = array();
                    $data[0]['Title'] = '赛普健身社区-我的课表';
                    $data[0]['Description'] = "点击此链接即可进入您的课表，查看课程。";
                    $data[0]['PicUrl'] = 'http://image.saipubbs.com/upload/image/20181211/1544496889.5281120769.jpeg';
                    $data[0]['Url']  = 'http://m.saipubbs.com/user/studying';

                }elseif(in_array($key,['video_sp','poster_1','poster_2','poster_3','ppt_ppt'])){
                    if($key=='video_sp'){
                        $href = "<a href='http://m.saipubbs.com/cak/1.html?sp'>点我，进入赛普知道</a>";
                    }elseif($key == 'poster_1'){
                        $href = "<a href='http://m.saipubbs.com/cak/1.html?haibao_1'>点我，进入赛普知道</a>";
                    }elseif($key == 'poster_2'){
                        $href = "<a href='http://m.saipubbs.com/cak/1.html?haibao_2'>点我，进入赛普知道</a>";
                    }elseif($key == 'poster_3'){
                        $href = "<a href='http://m.saipubbs.com/cak/1.html?haibao_3'>点我，进入赛普知道</a>";
                    }elseif($key == 'ppt_ppt'){
                        $href = "<a href='http://m.saipubbs.com/cak/1.html?ppt'>点我，进入赛普知道</a>";
                    }
                    $content = "Hi~欢迎关注赛普健身社区。\n\n自己有问题，带会员有问题，就来赛普知道，百位赛普专业老师坐镇，只有你问不出的，没有导师答不了的；\n\n没有问题，也要来赛普知道围观问题，增肌、减脂、康复等技能一键get！\n\n".$href."，向导师提问吧。\n\n赛普知道——健身教练的问答平台，有问题，就上赛普健身社区！";
                }elseif(strpos($key,'coach') !== false){
                    logger()->info($key);
                    $coachArr = explode('_',$key);
                    $DisCourseClass = new DisCourseClass;
                    $item     = DisCourseClass::where("id", $coachArr[1])->first();
                    if($item){
                        $content = "您好，您已成功报名以下课程：\n\n"."<a href='http://m.saipubbs.com/dist/study/".$coachArr[1].".html'>《".$item->title."》</a>";
                    }else{
                        $content = "您已关注赛普健身社区，本次助力无效~";
                    }
                    
                }elseif(strpos($key,'weekAsk')!== false){
                    if(strpos($key,'weekAsk1') !== false){
                        $content = "【每周一问】健身俱乐部or工作室，你是如何选择的？\n相信大家都经历过去俱乐部还是工作室的灵魂质问吧～所以你是如何选择，又是为什么这样选择呢？\n<a href='http://m.saipubbs.com/cak/answer/4136/1.html"."'>点我：一起来讨论</a>\n点赞数排名前三的答主，可获价值99元课程～";
                    }else{
                        $content = "【每周一问】还记得你第一次带会员时的经历吗？\n作为教练，第一次带会员时的经历无论美好不美好，相信你都记忆犹新吧~\n<a href='http://m.saipubbs.com/cak/answer/4097/1.html"."'>点我：一起讨论</a>\n点赞数排名前三的答主可获得价值199元课程~";
                    }
                }elseif(strpos($key,'activity_shequ') !== false){//activity_qingshaoer 
                        $content  = $this->activity_qingshaoer($cur_user);

                }elseif(strpos($key,'shequ_zhibo_1') !== false){//社区直播1
                        $content  = $this->shequ_zhibo_1($cur_user);
                }elseif(strpos($key,'fenghui') !== false){
                    $content = "2019IDEA峰会正在进行时\n<a href='https://www.runff.com/html/live/s2429.html?from=groupmessage&isappinstalled=0"."'>点我</a>,观看图片直播";
                }elseif($key == "qixi"){
                    $content = "【七夕一问】有一个爱健身的另一半是一种什么体验？\n不管那个人是前任，现任，相信一定有让你之后无数次想起的深深体验，\n<a href='http://m.saipubbs.com/cak/answer/4097/1.html"."'>点我，一起讨论</a>";
                }elseif(strpos($key,'career_plan') !== false){
                    if($key == 'career_plan_a'){
                        $content = "您好，恭喜您完成了职业规划第1次课程，感谢您全程参与到我们的课程当中。\n\n为了不断提升课程授课效果，我们需要您的宝贵建议:\n\n<a href='http://m.saipubbs.com/user/feedback/1.html"."'>点击这里</a>写下您的课程感受吧~";
                    }elseif($key == 'career_plan_b'){
                        $content = "您好，恭喜您完成了职业规划第2次课程，感谢您全程参与到我们的课程当中。\n\n为了不断提升课程授课效果，我们需要您的宝贵建议:\n\n<a href='http://m.saipubbs.com/user/feedback/2.html"."'>点击这里</a>写下您的课程感受吧~";
                    }else{
                        $content = "您好，恭喜您完成了职业规划第3次课程，感谢您全程参与到我们的课程当中。\n\n为了不断提升课程授课效果，我们需要您的宝贵建议:\n\n<a href='http://m.saipubbs.com/user/feedback/3.html"."'>点击这里</a>写下您的课程感受吧~";
                    }
                }elseif(strpos($key,'nasm_active') !== false){
                    $content = "4700元学NASM报名通道只针对赛普在校生开放，为避免产生不必要的麻烦，请先查询是否符合申请资格再进行报名→"."<a href='http://m.saipubbs.com/nasm/form.html'>查询通道</a>\n非赛普在校生可先→<a href='http://m.saipubbs.com/nasm/access.html'>申请在校学员身份</a>，获取赛普在校生学籍后再申请4700元学NASM\n确信自己是赛普在校学员的，也可→<a href='http://m.saipubbs.com/course/detail/58.html'>直接报名</a>";
                }elseif(strpos($key,'live_video') !== false){
                    $content = "开启直播提醒成功！直播会在开始前15分钟通过公众号提醒您\n"."<a href='https://vzan.com/live/tvchat-442538259?v=637064836485232887#/'>点击进入直播间</a>";
//                    $userObj = json_decode(json_encode($object));
//                    $this->pushLiveVideo($userObj->FromUserName);


                }elseif(strpos($key,'saishi') !== false) {
                    $content = "今年北京最后一场健身赛事！！！12月1日，肌肉战士、运动天使、时尚先生、健身男模、运动宝贝、才艺之星将齐聚赛普健身全明星赛北京站舞台，闪耀健身荣耀时刻，老铁们赶快点此链接完成报名吧！http://m.saipujiaoyu.com/Saishi?tid=20";
                }elseif(strpos($key,'bjfreecourse') !== false) {
                    $content = "【免费】10月24日18:00-21:00JOINFIT公开课北京站#小工具的康复训练、
用对了是康复，用错了叫自虐。三小时教你最底层的康复逻辑，戳此链接完成报名https://saipujianshenxueyuan.mikecrm.com/3QbaJV1";
                }elseif(strpos($key,'acsm') !== false){

                    $content = $this->unlineCoursePush($key,$cur_user);
                }elseif(strpos($key,'asm_course_assign') !== false){

                    $content = $this->assignAcsmPush($key,$cur_user);
                }elseif(strpos($key,'xiaocutui') !== false){
                    $data['type'] = 'xiaocutui';
                    $data['key'] = $key;
                    $data['user'] = $cur_user;
                    $new = 'img';
                    $content = $this->commonMessagePush($data);

                }elseif(strpos($key,'songke') !== false){
                    $data['type'] = 'songke';
                    $data['key'] = $key;
                    $data['user'] = $cur_user;
                    $new = '';
                    $content = $this->commonMessagePush($data);
                }elseif(strpos($key,'justdoit') !== false){
                    $data['type'] = 'justdoit';
                    $data['key'] = $key;
                    $data['user'] = $cur_user;
                    $new = '';
                    $content = $this->commonMessagePush($data);
                }elseif(strpos($key,'vote') !== false){
                    //just do it 活动20191222  投票专属二维码
                    $data['user_id'] = trim($key ,"vote");
                    $data['type'] = 'vote';
                    $data['key']  = $key;
                    $data['user'] = $cur_user;
                    $new = '';
                    $match        = DB::table("intro_active_users")->where("user_id",$data['user_id'])->where('type','DOIT')->first();
                    if($match){
                        $data['m_name'] = json_decode($match->user_info, true)['name'];
                    }else{
                        $data['m_name'] = "你的好友".$data['user_id'];
                    }
                    $content = $this->commonMessagePush($data);
                }elseif(strpos($key,'jdtUser') !== false){
                    //just do it 活动20191222  投票专属二维码
                    $data['type'] = 'jdtUser';
                    $data['key']  = $key;
                    $data['user'] = $cur_user;
                    $new = '';
                    $match = DB::table("intro_active_users")->where("user_id",$cur_user->id)->where('type','DOIT')->first();
                    logger()->info('当前用户.'.$cur_user->id);
                    if($match){
                        $data['name'] = json_decode($match->user_info, true)['name'];
                    }else{
                        $data['name'] = "你的好友".$data['user_id'];
                    }
                    logger()->info('当前用户.'.$data['name']);
                    $content = $this->commonMessagePush($data);
                }elseif(strpos($key,'jobCollect') !== false){
                    $new = '';
                    $content = "紧张的学习生活匆匆而过，转眼即将面临就业选择，在接下来的一段时间班主任将开始为各位学员进行工作推荐和匹配~\n——————\n赶快<a href='http://m.saipubbs.com/stu/info/collect.html"."'>填写你的就业需求</a>吧~";
                }
        }
        if($new){
            if(strpos($new,'img') !== false){

                $result =  $this->transmitImg($object, $content);
            }else{
                //回复图文消息
                $result =  $this->transmitNews($object, $data);
            }

        }else{
            $result = $this->transmitText($object, $content);
        }

        return $result;
    }
    
    //接收文本消息
    private function receiveText($object)
    {
        $keyword = trim($object->Content);
        $content = date("Y-m-d H:i:s",time())."\n嗨！等你好久了！".$keyword;
        $two_text= substr($keyword,0,2);

        // $wechatInfo = json_decode(json_encode($object),true);
        // $data     = array();
        // $data['openid'] = $wechatInfo['FromUserName'];
        // $data['type']   = 'TEXT';
        // $data['text']   = "很抱歉，给您的生活带来了不便。\n由于红包太火爆，已经被一抢而光啦~凡邀请5名好友助力成功，未成功领取红包的用户\n请添加个人微信号：lihan7475234凭如下截图领取红包：您将享受VIP用户待遇，客服小姐姐将为您手动发放红包。";

        //event(new WxCustomerMessagePush($data));

        // $result  = $this->transmitImg($object, "Wqji42ykCKd6xLWVzXxyG5S-L6TOpAbpZQ13AGsNqrWo85E8MBJd5Zd5EtNq67eI");
        // return $result;
        
        if(is_array($content)){
            if (isset($content[0]['PicUrl'])){
                $result = $this->transmitNews($object, $content);
            }else if (isset($content['MusicUrl'])){
                $result = $this->transmitMusic($object, $content);
            }
        }else{
            if($two_text=="TD"){
                $c_c_id = substr($keyword,2);
                $openid = $object->FromUserName;
                if($c_c_id && $openid){
                    $r  = CourseClassPush::where("user_openid", $openid)->where("course_class_id", $c_c_id)->delete();
                    //logger()->info($r);
                }
                $content = "成功取消该系列课程推送信息";
                $result  = $this->transmitText($object, $content);
            }else{
                $result  = DB::table("wechat_keyword_set")->whereNull("deleted_at")->where("keyword", 'like', "%".$keyword."%")->where("state",1)->select("reply_content")->first();
                if($result){
                    if($keyword == '666'){
                        $media = $this->uplodeTmp("/ziliaobaoCode.jpeg");
                        $media_id = $media['media_id'];
                        // $userChatInfo = json_decode(json_encode($object),true);
                        // $data['type']   = "IMAGES";
                        // $data['openid'] = $userChatInfo['FromUserName'];
                        // $data['media_id'] = $media_id;
                        // event(new WxCustomerMessagePush($data));

                        $result = $this->transmitImg($object, $media_id);
                    }else{
                        $result = $this->transmitText($object, $result->reply_content);
                    }

                }else{
                    //根据关键字查询相关信息
                    $about = CourseClassAbout::where("wx_keyword", $keyword)->select("activity_url","course_class_id")->first();
                    if($about && $about->activity_url){
                        $wx_user = $this->wx_user($object->FromUserName);
                        $this->service_push_text($wx_user, $about->course_class_id);  //客服推送课程消息
                       
                        $destDirectory = "/upload/wxqrcode/";
                        $head_img = $destDirectory.rand(10000,99999).".jpg";
                        $code_img = $this->getQRcode($about->course_class_id.'-'.$wx_user['openid']);   //下载带客户信息的二维码
                        $ImageThumb  = new ImageThumb();
                        $img_url     = $ImageThumb->makePic("/".$about->activity_url, $head_img, $code_img);
                        $media_id = $this->uplodeTmp("/".$img_url[1]);

                        $result   = $this->transmitImg($object, $media_id['media_id']);
                    }else{
                        $result = $this->transmitText($object, "");
                    }
                }
            }
        }
        return $result;
    }

    //回复图片消息
    private function transmitImg($object, $media_id)
    {
        $imgTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[image]]></MsgType>
                    <Image><MediaId><![CDATA[%s]]></MediaId></Image>
                    </xml>";

        $result  = sprintf($imgTpl, $object->FromUserName, $object->ToUserName, time(), $media_id);
        return $result;
    }

    //回复文本消息
    private function transmitText($object, $content)
    {
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>";
        
        //$wx_user = $this->wx_user($object->FromUserName);   //微信用户信息
        if(!$content){
            $content = "赛普健身社区——健身教练的终身学习平台";
        }
        $result  = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }


    //回复图文列表
    private function transmitNews($object, $arr_item)
    {
        if(!is_array($arr_item))
            return;

        $itemTpl = "<item>
                        <Title><![CDATA[%s]]></Title>
                        <Description><![CDATA[%s]]></Description>
                        <PicUrl><![CDATA[%s]]></PicUrl>
                        <Url><![CDATA[%s]]></Url>
                    </item>";
        $item_str = "";
        foreach ($arr_item as $item)
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);

            $newsTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[news]]></MsgType>
                    <Content><![CDATA[]]></Content>
                    <ArticleCount>%s</ArticleCount>
                    <Articles>
                    $item_str</Articles>
                    </xml>";

        $result = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item));
        return $result;
    }
    //返回音乐
    private function transmitMusic($object, $musicArray)
    {
        $itemTpl = "<Music>
                        <Title><![CDATA[%s]]></Title>
                        <Description><![CDATA[%s]]></Description>
                        <MusicUrl><![CDATA[%s]]></MusicUrl>
                        <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
                    </Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[music]]></MsgType>
                    $item_str
                    </xml>";

        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }
    
    private function logger($log_content)
    {
        if(isset($_SERVER['HTTP_APPNAME'])){   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);
        }else if($_SERVER['REMOTE_ADDR'] != "127.0.0.1"){ //LOCAL
            $max_size = 10000;
            $log_filename = "log.xml";
            if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
            file_put_contents($log_filename, date('H:i:s')." ".$log_content."\r\n", FILE_APPEND);
        }
    }

    //20180906 测试上传微信图片
    public function uplodeTmp($img_url){
        $file_info= array(
            'filename'=>$img_url,  //国片相对于网站根目录的路径
            'content-type'=>'image/jpg',  //文件类型
            'filelength'=>'72'         //图文大小
        );
        $token = $this->getToken();
        $type = "image";  //声明上传的素材类型，这里为image
        //$url  = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=".$token."&type=".$type;//永久
        $url  = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$token."&type=".$type;//临时
        $real_path= new \curlFile($_SERVER['DOCUMENT_ROOT'].$file_info['filename']);
        $data= array("media"=>$real_path, 'form-data'=>$file_info);

        $ch1 = curl_init();
        $timeout =60;
        curl_setopt ( $ch1, CURLOPT_URL, $url );
        curl_setopt ( $ch1, CURLOPT_POST, 1 );
        curl_setopt ( $ch1, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch1, CURLOPT_CONNECTTIMEOUT, $timeout );
        curl_setopt ( $ch1, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch1, CURLOPT_SAFE_UPLOAD, true);
        curl_setopt ( $ch1, CURLOPT_SSL_VERIFYHOST, false );
        @curl_setopt ( $ch1, CURLOPT_POSTFIELDS, $data );
        $result = curl_exec ($ch1);

        curl_close ($ch1);
        return json_decode($result,true);
    }

    //20180906获取access_token
    private function getToken(){
        $wxPush  = new WxPush();
        $token   = $wxPush->getToken();
        return $token;
    }

    //20180906获取access_token
    private function wx_user($openId){
        $token   = $this->getToken();
        //获取用户信息
        $str1    = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=$token&openid=$openId&lang=zh_CN");

        return json_decode($str1, true);
    }

    //20180906 生成带参数的二维码  客户id/课程id
    public function getQRcode($scene_id,$dir = '/upload/wxqrcode/'){
        $wechat = new WxQRcode($this->getToken());
        //$wechat = new WxQRcode($this->getToken11());
        return $wechat -> _getQRCode(2592000,"temp", $scene_id,$dir);
    }

    //20180914 以客服消息形式给用户推送课程信息
    public function push_course($user,$course){
        $openid   = $user['openid'];
        $data   = array();
        $articles = array();
        $article = array(
            "title"      =>$course->title,
            "description"=>"",
            "url"        =>env('APP_URL')."/course/detail/".$course->id.".html",
            "picurl"     =>env('IMG_URL').$course->explain_url
        );
        $articles[]  = $article;

        $data['openid'] = "$openid";
        $data['type']   = 'IMAGE';
        $data['list']   = $articles;

        event(new WxCustomerMessagePush($data));
        return;
    }



    //20180912 新用户关注客服回复消息
    public function subscribe_service($user){
        $openid   = $user['openid'];
        $nickname = $user['nickname'];
        
        $data   = array();
        // if(Redis::exists("wx_".$openid) && Redis::get("wx_".$openid) != ''){
        //     $json    = Redis::get("wx_".$openid);
        // }else{
            $new    = new WechatNews();
            $list   = $new->orderBy("orderby","desc")->get();
            $articles = array();
            foreach($list as $item){
                $article = array(
                    "title"      =>"【新人礼包】".$nickname.','.$list[0]->title,
                    "description"=>$list[0]->description,
                    "url"        =>$list[0]->url,
                    "picurl"     =>env('IMG_URL').$list[0]->picurl
                );
                $articles[]  = $article;
                unset($article);
            }
            // $json = json_encode($articles);
            // Redis::setex("wx_".$openid, 1800, $json);
        // }

        $data['openid'] = $openid;
        $data['type']   = 'IMAGE';
        //$data['list']   = json_decode($json, true);
        $data['list']   = $articles;

        event(new WxCustomerMessagePush($data));
        return;
    }

    //20180917 客服回复文字消息
    public function service_push_text($user, $course_class_id){
        $openid   = $user['openid'];
        $title    = DB::table("course_class")->where("id", $course_class_id)->select("title","id")->first();
        $data     = array();
        $data['openid'] = $openid;
        $data['type']   = 'TEXT';
        $data['text']   = "很抱歉，给您的生活带来了不便。\n由于红包太火爆，已经被一抢而光啦~\n凡邀请5名好友助力成功，未成功领取红包的用户\n请添加个人微信号：lihan7475234\n您将享受VIP用户通道，当前排队人数较多，请您耐心等候";

        event(new WxCustomerMessagePush($data));
        return;
    }

    public function pushLiveVideo($openid){

        $data['openid'] = $openid;
        $data['type']   = 'TEXT';
        $data['text']   = "开启直播提醒成功！直播会在开始前15分钟通过公众号提醒您\n"."<a href='https://vzan.com/live/tvchat-442538259?v=637064836485232887#/'>点击进入直播间</a>";
        //                    logger()->info('live提醒');
        event(new WxCustomerMessagePush($data));
        return ;
    }

    public function getImage($url,$save_dir='',$filename='',$type=0){ 
        if(trim($url)==''){ 
            return array('file_name'=>'','save_path'=>'','error'=>1); 
        } 
        if(trim($save_dir)==''){ 
            $save_dir='./'; 
        } 
        if(trim($filename)==''){//保存文件名 
            $ext=strrchr($url,'.'); 
            if($ext!='.gif'&&$ext!='.jpg'){ 
                return array('file_name'=>'','save_path'=>'','error'=>3); 
            }
            $filename=time().$ext;
        } 
        if(0!==strrpos($save_dir,'/')){ 
            $save_dir.='/'; 
        } 
        //创建保存目录 
        if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){ 
            return array('file_name'=>'','save_path'=>'','error'=>5); 
        } 
        //获取远程文件所采用的方法  
        if($type){ 
            $ch=curl_init(); 
            $timeout=5; 
            curl_setopt($ch,CURLOPT_URL,$url); 
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout); 
            $img=curl_exec($ch); 
            curl_close($ch); 
        }else{ 
            ob_start();  
            readfile($url); 
            $img=ob_get_contents();  
            ob_end_clean();  
        } 
        //$size=strlen($img); 
        //文件大小  
        $fp2=@fopen($save_dir.$filename,'a'); 
        fwrite($fp2,$img); 
        fclose($fp2); 
        unset($img,$url); 
        return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'error'=>0); 
    } 

    /*
     * 微信分享页生成
     */
    public function wechatShare(Request $request,$id){
        $user_id = $request->user()?$request->user()->id:0;
        $fission_id = $request->input('fission_id',0);
        $class_id = $id;
        $course   = DB::table("course_class")->where("id", $id)->first();

        $activity = $id==37 ? 1 : 0;
        $name    = $request->user()->nickname ? $request->user()->nickname : $request->user()->name;
        if($name==""){
            $name = "小伙伴儿";
        }
        $name = subtext($name,6);
        $classAbout = CourseClassAbout::where('course_class_id',$class_id)->select('activity_url','course_class_id')->first();
        // $wechatCode = $this->getQRcode($classAbout->course_class_id.'_'.$user_id.'_TOUTIAO','/upload/share/');
        if($class_id==37){
            $img = "http://qr.topscan.com/api.php?text=http://m.saipubbs.com/zt/yearinfo.html?fission_id=".$user_id;
        }else{
            $img = "http://qr.topscan.com/api.php?text=http://m.saipubbs.com/course/detail/".$class_id.".html?fission_id=".$user_id;
        }    
        $destDirectory = "/upload/wxqrcode/";
        if (!file_exists(public_path().'/'.$destDirectory)) {
            $fileDir = mkdir(public_path().'/'.$destDirectory,0777,true);
        }else{
            $fileDir = public_path().'/'.$destDirectory;
        }
        $file = time().rand(1000,9999).".png";
        $r = $this->getImage($img,$fileDir, $file);
        $wechatCode =  $destDirectory.$r['file_name'];
        // }else{
        //     $wechatCode = $this->getQRcode($classAbout->course_class_id.'_'.$user_id,'/upload/share/');
        // }
        
        $imageThumb  = new ImageThumb();
        $img_url = $imageThumb->makePic('/'.$classAbout->activity_url, '', $wechatCode,'upload/share/', $name,$activity);

        //return "<img src='".env('APP_URL')."/".$img_url[1]."' />";
        $src  = env('APP_URL')."/".$img_url[1];
        $is_local = env("IS_LOCAL");
        $data = array();
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();
        }
        $data['course']  = $course;
        $data['src']     = $src;
        $data['user_id'] = $user_id;
        $data['fission_id'] = $fission_id;
        return view("course.detailcard", $data);
    }
    /*
     * 微信文章页
     */
    
    
    public function wechatShareArticle(Request $request,$id){

        $user_id = $request->user()?$request->user()->id:0;
        $fission_id = $request->input('fission_id',0);
        $special_id = $id; 
        $activity   = 3;                             //专题id
        if($id==39){
            $activity = 1;
        }

        $aid = $request->aid?$request->aid:0;

        if($aid == 0){
            $special   = DB::table("special")->where("id", $id)->first();
            $url = env('APP_URL')."/special/index/".$id.".html?fission_id=".$user_id;
            $special->cover_url = $special->img_url;

        }elseif($aid == 3){ //微信好友助力邀请
            $activity_userid = $request->input("userid");
            $special = DB::table("course_class")->where("id", $id)->first();
            $img_url   = DB::table("course_class_about")->where("course_class_id", $id)->first();

            $url = env('APP_URL')."/assistance/index/".$activity_userid.".html?fission_id=".$activity_userid;
            $special->bill_url = $img_url->activity_two_url;
        }else{
            $special   = DB::table("article")->where("id", $aid)->first();
            $url = env('APP_URL')."/article/special/".$aid."/".$id.".html?fission_id=".$user_id;
            $special->bill_url = $special->bill_img;

        }
        $name  = $request->user()->name ? $request->user()->name : $request->user()->nickname;
        if($name==""){
            $name = "小伙伴儿";
        }
        
        $name = subtext($name,6);

        $img = "http://qr.topscan.com/api.php?text=".$url;
        $destDirectory = "/upload/wxqrcode/";
        if (!file_exists(public_path().'/'.$destDirectory)) {
            $fileDir = mkdir(public_path().'/'.$destDirectory,0777,true);
        }else{
            $fileDir = public_path().'/'.$destDirectory;
        }
        $file = time().rand(1000,9999).".png";
        $r = $this->getImage($img,$fileDir, $file);
        $wechatCode =  $destDirectory.$r['file_name'];

        $imageThumb  = new ImageThumb();
        if($aid == 3){
            logger()->info($special->bill_url);
            //dd($special->bill_url);
            $img_url = $imageThumb->makePic('/'.$special->bill_url, '', $wechatCode,'upload/share/', $name,$activity);
        }else{
            $img_url = $imageThumb->makePic(env("IMG_URL").$special->bill_url, '', $wechatCode,'upload/share/', $name,$activity);
        }
        
        $src  = "/".$img_url[1];//env('APP_URL')."/".
        $is_local = env("IS_LOCAL");
        $data = array();
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();
        }

        $data['course']  = $special;
        $data['src']     = $src;
        $data['user_id'] = $user_id;
        $data['fission_id'] = $fission_id;
        $data['redirect_url'] = $url;

        return view("course.sharecard", $data);
    }

    public function wechatShareZt(Request $request){

        $user_id = $request->user()?$request->user()->id:0;
        $fission_id = $request->input('fission_id',0);

        $aid = $request->aid?$request->aid:0;
        $url = env('APP_URL').'/trainer/index.html?fission_id = '.$user_id;

        $name  = $request->user()->name ? $request->user()->name : $request->user()->nickname;
        if($name==""){
            $name = "小伙伴儿";
        }

        $name = subtext($name,6);

        $img = "http://qr.topscan.com/api.php?text=".$url;
        $destDirectory = "/upload/wxqrcode/";
        if (!file_exists(public_path().'/'.$destDirectory)) {
            $fileDir = mkdir(public_path().'/'.$destDirectory,0777,true);
        }else{
            $fileDir = public_path().'/'.$destDirectory;
        }
        $file = time().rand(1000,9999).".png";
        $r = $this->getImage($img,$fileDir, $file);
        $wechatCode =  $destDirectory.$r['file_name'];

        $imageThumb  = new MakeThumbPic();
        $img_url = $imageThumb->makePic(env('APP_URL').'/images/zt/class.jpg', '', $wechatCode,'upload/share/', $name,2);


        $src  = "/".$img_url[1];//env('APP_URL')."/".
        $is_local = env("IS_LOCAL");
        $data = array();
        if($is_local){
            $data['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $data['WechatShare'] = getSignPackage();
        }


        $data['src']     = $src;
        $data['user_id'] = $user_id;
        $data['fission_id'] = $fission_id;
        $data['redirect_url'] = $url;

        return view("course.shareZt", $data);
    }
      //获得全局access_token
    public function getToken11(){
        $appId = "wx550f84c4ffa15d13";   //appid
        $appSecret = "d4624c36b6795d1d99dcf0547af5443d";
        // if(Redis::exists('access_token') && Redis::get('access_token') != ''){
        //     $access_token = Redis::get('access_token');
        // }else{
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appId."&secret=".$appSecret;
            $data = $this->curl($url);
            $tokenInfo = json_decode($data,true);
            $access_token = $tokenInfo['access_token'];
        //     Redis::setex('access_token',7200,$access_token);
        // }
        return $access_token;
    }
    public function curl($url,$postData = '',$type = ''){
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url); //要访问的地址
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//跳过证书验证

        if($postData){
            curl_setopt($ch, CURLOPT_POST, 1);//post方法请求
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);//post请求发送的数据包
        }else{
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        }

        $data = curl_exec($ch);
        if(curl_errno($ch)){
            logger()->info(curl_error($ch));
        }
        curl_close($ch);
        return $data;
    }

    /*
    *2019-01-09
    *获取token
    */
    public function cur_token(){
        $cur_token = $this->getToken();
        echo $cur_token;

        $wechatCode = $this->getQRcode("fenghui",'/upload/share/');
        dd($wechatCode);
    }

    /*
    *2019-08-27
    *生成带参数的二维码图片地址
    */
    public function getQRcodeUrl($scene_id,$dir = '/upload/wxqrcode/'){
        $wechat = new WxQRcode($this->getToken());
        //$wechat = new WxQRcode($this->getToken11());
        return $wechat -> _getQRCodeUrl(2592000,"temp", $scene_id,$dir);
    }


    /*
     * 私教经理免费活动 -- sijiaojingli_mianfei
     * */
    public function sijiaojingli($key,$user){
        logger()->info("私教经理免费活动----".$user->nickname);
        $sijiaojingli = new Sijiaojingli();

        //参加活动
        $num = $sijiaojingli::where("user_id",$user->id)->count();
        if($num == 0){
            $sijiaojingli->user_id = $user->id;
            $sijiaojingli->is_first = 1;
            $sijiaojingli->friend_id = 0;
            $re = $sijiaojingli->save();
        }
        if($num < 4){
            $data['openid'] = $user->openid;
            $data['type']   = 'TEXT';
            $data['text']   = "0元学习活动规则：
                   \n①邀请3位好友扫码助力，即可观看《私教经理管理体验营》全部4次课程\n更有机会与大咖导师交流。
                    \n有疑问请添加赛普小助手微信：18944605582
                    \n将下方海报转发到朋友圈或者微信群
                    \n↓邀请好友为您助力吧↓";
            event(new WxCustomerMessagePush($data));

            $codeUrl = $this->getQRcodeUrl("sijiaojingli_mf_zhuli-".$user->id,'/upload/share/');
            $imageThumb  = new MakeThumbPic();

            $activity = 10;
            $bodyPic = '/images/zt/wechat_sijiaojingli/sijiaojingli.jpg';
            $img = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$codeUrl;
            $img_url = $imageThumb->makePic($bodyPic, '', $img,'upload/share/','',$activity);
            $media_id = $this->uplodeTmp('/'.$img_url[1]);

            return $media_id['media_id'];
        }else{
            $data['openid'] = $user->openid;
            $data['type']   = 'TEXT';
            $data['text']   = "您已经成功邀请够3位好友了哦！
                               \n0元获得《私教经理管理体验营》全部4堂系列课程
                               \n体验营的课程将于28日正式开始，所有内容将通过社群推送，识别下方二维码马上加入体验营的社群吧！";


            event(new WxCustomerMessagePush($data));
            return 'RVLNP8jy_WSxLHgzucSYJMIvrLHAxdHsN2hVQcAtbNWVMVvAoW3xP1Fyo3OrGq5p';
        }
    }
    /**
     * 私教经理培训免费---助力款
     */
    public function sijiaojingli_zhuli($key,$user){
        logger()->info("私教经理培训免费---助力款----".$user->nickname);
        $sijiaojingli = new Sijiaojingli();
        if(strpos($key,'sijiaojingli_mf_zhuli') !== false){    //3个助力人群
            $arr = explode("-",$key);
            $last_uid = (int)$arr[1];
            $userinfo = Users::where("id", $last_uid)->first();
            $gebie_num = $sijiaojingli::where("user_id",$last_uid)->where("friend_id", $user->id)->count();
            logger()->info("私教经理培训免费---助力款----".$gebie_num);
            $all_num = $sijiaojingli::where("user_id",$last_uid)->where("is_first", 0)->count();

            if($gebie_num == 0 && $last_uid !== $user->id){

                $sijiaojingli->user_id = $last_uid;
                $sijiaojingli->is_first = 0;
                $sijiaojingli->friend_id = $user->id;
                $re = $sijiaojingli->save();
                if($re){
                    $all_num = $all_num+1;
                }
            }
            //助力好友推送消息
            $leave = 3-$all_num > 0?3-$all_num:0;
            if($last_uid !== $user->id){
                if($gebie_num > 0){
                    $data['openid'] = $user->openid;
                    $data['type']   = 'TEXT';
                    $data['text'] = "您已经助力过了哦~~";
                    event(new WxCustomerMessagePush($data));
                }else{
                    $data['openid'] = $user->openid;
                    $data['type']   = 'TEXT';
                    $data['text'] = "欢迎关注赛普健身社区！
                                   \n 恭喜您成功助力
                                   \n ————
                                   \n 您的好友@" . $userinfo->nickname . "正在参与《私教经理管理体验营》
                                   \n 从服务技巧、营销方法等5大方向打造成功私教管理人！
                                   \n 我也要参与↓↓";
                    event(new WxCustomerMessagePush($data));
                }

                //发起人推送消息

                $data['openid'] = $userinfo->openid;
                $data['type']   = 'TEXT';
                if($leave>0){
                    if($gebie_num == 0) {
                        $data['text'] = "好友加入提醒
                                            \n太棒了，您获得一位好友的助力啦！
                                            \n好友@" . $user->nickname . "为您成功助力
                                            \n再邀请" . $leave . "位好友就可以免费获得《私教经理管理体验营》体验营全部学习内容。";
                        event(new WxCustomerMessagePush($data));
                    }
                    $data['text']   = "恭喜您成功邀请".$all_num."位好友！
                                               \n0元获得《私教经理管理体验营》全部4堂系列课程
                                               \n体验营的课程将于28日正式开始，所有内容将通过社群推送，识别下方二维码马上加入体验营的社群吧！";
                    event(new WxCustomerMessagePush($data));
                    $data     = array();
                    $data['openid'] = $userinfo->openid;
                    $data['type']   = 'IMAGES';
                    $data['media_id'] = "RVLNP8jy_WSxLHgzucSYJMIvrLHAxdHsN2hVQcAtbNWVMVvAoW3xP1Fyo3OrGq5p";
                    event(new WxCustomerMessagePush($data));
                }
            }

            return $this->sijiaojingli($key,$user);
        }
    }

    /*
     * acsm消息推送
     */

    public function unlineCoursePush($key ,$user){
        $data['openid'] = $user->openid;
        $data['type']   = 'TEXT';
        $userName = $user->name?$user->name:$user->nickname;
        $data['text'] = "hello，{$userName}~\n恭喜您成功抢占活动名额~\n
《ACSM中文CPT认证课程》在赛普健身社区报名，享全国最低学费。平均优惠价5800元，本活动最低仅需2800元。\n【活动参与形式】\n1、将生成的带有自己专属昵称的海报分享给好友、群或朋友圈，邀请好友助力\n2、好友成功为您助力后，您将获得优惠价报名资格\n<a href='http://m.saipubbs.com/dist/buy/a60.html'".">→查看助力情况</a>
\n<a href='http://m.saipubbs.com/course/detail/60.html'>→查看课程详情</a>";

        event(new WxCustomerMessagePush($data));

        $codeUrl = $this->getQRcodeUrl("asm_course_assign-".$user->id,'/upload/share/');
        $imageThumb  = new MakeThumbPic();

        $activity = 11;
        $bodyPic = '/images/zt/acsm/acsm_poster.jpg';
        $img = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$codeUrl;
        $img_url = $imageThumb->makePic($bodyPic, '', $img,'upload/share/',$userName,$activity);
        $mediaInfo = $this->uplodeTmp('/'.$img_url[1]);
        $data['type'] = 'IMAGES';
        $data['media_id'] = $mediaInfo['media_id'];
        event(new WxCustomerMessagePush($data));
        return '快点分享海报给好友，邀请好友为您助力吧~~~';
    }

    /*
     * just do it生成海报
     */
    public function justDoitPush($data){
        $user = $data['user'];
        $data['openid'] = $user->openid;
        $data['type']   = 'TEXT';
        $name = $data['name'];
//        $userName = $user->name?$user->name:$user->nickname;
        $data['text'] = "【海报】\n快点把海报分享出去，让好友帮你投票吧~进入选手页，查看票数";

//        event(new WxCustomerMessagePush($data));

        $img = "http://qr.topscan.com/api.php?text=http://m.saipubbs.com/jdt/active/center/".$user->id.".html";
        $destDirectory = "/upload/wxqrcode/";
        if (!file_exists(public_path().'/'.$destDirectory)) {
            $fileDir = mkdir(public_path().'/'.$destDirectory,0777,true);
        }else{
            $fileDir = public_path().'/'.$destDirectory;
        }
        $file = time().rand(1000,9999).".png";
        $r = $this->getImage($img,$fileDir, $file);
        $wechatCode =  $destDirectory.$r['file_name'];
        // }else{
        //     $wechatCode = $this->getQRcode($classAbout->course_class_id.'_'.$user_id,'/upload/share/');
        // }

        $imageThumb  = new MakeThumbPic();
        $bodyPic = '/images/zt/just_do_it/lapiao_img.jpg';
        $img_url = $imageThumb->makePic($bodyPic, '', $wechatCode,'upload/share/', $name,15,'');

//        $codeUrl = $this->getQRcodeUrl("asm_course_assign-".$user->id,'/upload/share/');
//        $imageThumb  = new MakeThumbPic();
//
//        $activity = 11;
//        $bodyPic = '/images/zt/acsm/acsm_poster.jpg';
//        $img = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$codeUrl;
//        $img_url = $imageThumb->makePic($bodyPic, '', $img,'upload/share/',$userName,$activity);
        $mediaInfo = $this->uplodeTmp('/'.$img_url[1]);
        $data['type'] = 'IMAGES';
        $data['media_id'] = $mediaInfo['media_id'];
        event(new WxCustomerMessagePush($data));
        return "【海报】\n快点把海报分享出去，让好友帮你投票吧~进入选手页，查看票数";
    }

    /*
     *  ACSM活动
     */
    public function assignAcsmPush($key,$user){

        $user_id = explode('-',$key)[1];
        $assignedUser = User::where('id',$user_id)->first();
        logger()->info('user_id'.$user_id);
        $userName = $user->name?$user->name:$user->nickname;
        $assignedUserName = $assignedUser->name?$assignedUser->name:$assignedUser->nickname;

        if($user->openid !=  $assignedUser->openid){
            $wechatHand = WechatActivityHand::where('user_id',$assignedUser->id)->where('sponsor_id',$user->id)->where('type','ACSM')->first();
            if(!$wechatHand){
                $wechatHand = new WechatActivityHand();
            }else{

                $content = "你已经为@{$assignedUserName}助力过，每人只能为好友助力一次哦~";
                return $content;
            }
            $wechatHand->user_id = $assignedUser->id;
            $wechatHand->sponsor_id = $user->id;
            $wechatHand->type = "ACSM";
            $wechatHand->save();
        }else{
            return '本人不可以参与助力哦~，请邀请好友助力！';
        }
        $wechatCount = WechatActivityHand::where('user_id',$assignedUser->id)->where('type','ACSM')->select('id')->count();
        $data['openid'] = $assignedUser->openid;
        $data['type']   = 'TEXT';
        $data['text'] = "恭喜您，好友@{$userName}为您成功助力
\n<a href='http://m.saipubbs.com/dist/buy/a60.html"."'>→查看我的助力情况</a>";

        event(new WxCustomerMessagePush($data));

        if($wechatCount >= 20){
            $data['openid'] = $assignedUser->openid;
            $data['type'] = 'TEXT';
            $data['text'] = "恭喜您，30个好友为您成功助力~~\n您已获得2800元报名ACSM资格，快点报名吧~\n<a href='http://m.saipubbs.com/course/detail/60.html"."'>→立即报名</a>";
            event(new WxCustomerMessagePush($data));
        }

        $content = "hello，{$userName}~\n恭喜您助力成功~~\n
好友@{$assignedUserName}为你推荐《ACSM中文CPT认证课程》~\n在赛普健身社区报名，享全国最低学费。平均优惠价5800元，本活动最低仅需2800\n<a href='http://m.saipubbs.com/course/detail/60.html"."'>→查看活动详情</a>";

        return $content;
    }
    /*私教经理新活动*/
    public function sijiaojingli_xinhuodong($user){
        $data['openid'] = $user->openid;
        $data['type']   = 'TEXT';
        $data['text'] = "您已成功预约10.28日 15:00的直播《全明星私教打造的秘诀》
                        \n带你学习如何进行自我及团队营销矩阵搭建！！
                        \n直播地址：https://vzan.com/live/tvchat-192831914?v=637076122426577666#/";

        event(new WxCustomerMessagePush($data));
        $data['openid'] = $user->openid;
        $data['type']   = 'TEXT';
        $data['text'] = "《全明星私教打造的秘诀》是”私教经理管理体验营“的第1堂课，10.29——10.31日体验营陆续推出《从服务技巧、营销方法等5大方向打造私教团队》、《俱乐部营销关键动作讲解》等干货。
                    \n扫描下方二维码免费加入体验营↓↓";

        event(new WxCustomerMessagePush($data));
        return "CognksiLKbUQOQ_lWYtOyhTXDxE1SlwTnRXC4SB-4JT19QavZQ7hIMmLfJ4ks8VO";

    }

    //活动ACSM直播海报
    public function acsm_zhibohuodong($user){
        $data['openid'] = $user->openid;
        $data['type']   = 'TEXT';
        $data['text'] = "恭喜您成功预约ACSM直播公开课
                        \n直播主题：
                        \n《如何制定和调整运动处方，让训练效果更有效》
                        \n直播时间：10月30日 18：00
                        \n——————
                        \n扫描下方二维码进入直播群↓↓";

        event(new WxCustomerMessagePush($data));
        return "BQFTCQPzWesLzDN3LEgIvS6hGocnVc9vHPhYKSzfqFhrTdKIZxK7vLsnCh9huIss";
    }

    //活动青少年体能市场
    public function activity_qingshaoer($user){
      
        $content = "欢迎各位小伙伴加入赛普直播间~
                    \n——————
                    \n【直播预告】
                    \n《如何抓住青少年市场，提升业绩》
                    \n直播时间：今晚 17:30
                    \n直播导师：SP+体能学院院长 杨文忠
                    \n——————
                    \n点击下方链接免费报名直播↓↓↓↓↓
                    \nhttps://vzan.com/live/tvchat-1208453592?v=637088235493964891#/";
        $data['type'] = "activity_shequ";
        $data['user'] = $user;
        $this->subscribeWay($data);
        
        return  $content;
    }

    public function shequ_zhibo_1($user){
      
        $content = "11月22日 17：30赛普老学员分享
                    \n↓↓↓
                    \n15天15万业绩，每月业绩5万以上
                    \n赛普小师兄告诉你，如何找对目标和方向
                    \n马上预约直播
                    \nhttps://vzan.com/live/tvchat-2133469470?v=637097830782276631#/";
        $data['type'] = "shequ_zhibo_1";
        $data['user'] = $user;
        $this->subscribeWay($data);
        
        return  $content;
    }

    /*
     * 通用消息模版
     */
    public function commonMessagePush($data){
        $type = $data['type'];
        $user = $data['user'];
        switch($type){
            case 'xiaocutui':
                $content = "恭喜您成功预约赛普直播~\n\n直播主题：《5分钟改善小粗腿》\n直播期数：第17期\n直播时间：11月6日 13:30\n\n在直播前，您可以先<a href='http://m.saipubbs.com/cak/answer/4489/1.html'>进入讨论专场</a>留下自己的问题或见解\n\n——————\n扫描二维码进入直播群获取直播地址↓↓↓";
                $data['openid'] = $user->openid;
                $data['type']   = 'TEXT';
                $data['text'] = $content;

                event(new WxCustomerMessagePush($data));

                $content = 'VKJpRCsjh5-8WNC5sh6tnvOmtDtlLo2qN4_S0TLyWH9gcFFNYWxAhax-JHb5YC0R';
                break;
            case "songke":
                $name = $user->name?$user->name:$user->nickname;
                $content = "hello，".$name."~\n欢迎参加“好课送不停”活动~\n免费领课流程：\n1、进入活动专区\n2、点击免费领取\n3、添加特定标签提问\n4、获得课程\n"."<a href='http://m.saipubbs.com/course/access.html'>点击进入</a>活动专区，<a href='http://m.saipubbs.com/course/access.html'>免费领取</a>教练必修课~";
                $this->subscribeWay($data);
                break;
            case 'justdoit':
                $content = "拒绝平庸 我要我行！\n赛普携手耐克超级健身盛典，打造“ TRAIN TO WIN”大奖，\n有机会获得赛普在管理、创业和明星教练方面的深度赋能，并有机会成为耐克盛典签约教练。\n2020年招募开启，<a href='http://m.saipubbs.com/jdt/active/index'".">马上报名</a>";
                break;
            case 'vote':
                $content = $data['m_name']."急需你的投票才能晋级~进入<a href='http://m.saipubbs.com/jdt/active/center/".$data['user_id'].".html'>TA的投票主页</a>，帮TA投票吧~";
                break;
            case 'jdtUser':
                $content = $this->justDoitPush($data);
                break;
            default:
                $content = '欢迎来到赛普健身社区';
        }
        return $content ;
    }

    private function subscribeWay($data){
        $type = $data['type'];
        $user = $data['user'];
        $subWay = WechatSubscribeWay::where('user_id',$user->id)->where('type',$type)->first();

        if(!$subWay){
            $subWay = new WechatSubscribeWay();
            $subWay->user_id = $user->id;
            $subWay->openid = $user->openid;
            $subWay->type = $type;
            $subWay->save();
        }
    }

}
