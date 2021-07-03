<?php

namespace App\Http\Controllers\A;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Assistance;
use App\Models\Sponsor;
use App\Models\Users;
use App\Utils\ImageThumb;
use App\Models\Studying;
use App\Constant\WxMessageType;
use App\Events\WxMessagePush;
use App\Models\Jscard;
use Illuminate\Support\Facades\DB;

class NewyearController extends Controller
{
    /**
     * ���ҳ
     */
    public function index(Request $request)
    {
        if($request->user()){
            $userid = $request->user()->id;
            $mobile  = $request->user()->mobile ? $request->user()->mobile : 0;  //�û��ֻ���
        }else{
            $mobile  = 0;  //�û��ֻ���
            $userid = 0;
        }
        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        $act3 = $this->activity_all(3);         //活动3
        $act4 = $this->activity_all(4);         //活动3
        $this->ret['userid'] = $userid;
        $fission_id = $request->input("fission_id", 0);   //�ѱ���id
        $this->ret['fission_id'] = $fission_id;           //�ѱ���id
        $this->ret['act3'] = $act3['maxnum'];
        $this->ret['act4'] = $act4['maxnum'];
       return view("newyear.index",$this->ret);
    }

    /**
     * �����
     */
    public function rule()
    {

        return view("newyear.rule");
    }
    /*
     * 所有活动
     */
    public function activity_all($aid){
        if($aid == 1){
            $data['title'] = "新年充电活动福利1";
            $data['gift'] = "健身干货课程";
            $data['num'] = 3;
            $data['gifturl'] = "";              //礼品链接
            $data['maxnum'] = 0;

        }elseif($aid == 2){
            $data['title'] = "新年充电活动福利2";
            $data['gift'] = "20元现金红包";
            $data['num'] = 5;
            $data['gifturl'] = "https://hd.faisco.cn/7361402/3Eu0MW2IzVxVbg6Fi6e_Rg/load.html?style=66";
            $data['maxnum'] = 100;

        }elseif($aid == 3){
            $data['title'] = "新年充电活动福利3";
            $data['gift'] = "10MM瑜伽垫";
            $data['num'] = 5;
            $data['gifturl'] = "/newyear/addr/".$aid.".html";
            $data['maxnum'] = 30;

        }elseif($aid == 4){
            $data['title'] = "新年充电活动福利4";
            $data['gift'] = "家用多功能收腹机";
            $data['num'] = 15;
            $data['gifturl'] = "/newyear/addr/".$aid.".html";
            $data['maxnum'] = 40;
        }else{
            $data['title'] = "新年充电活动福利5";
            $data['gift'] = "价值100元京东卡";
            $data['num'] = 25;
            $data['gifturl'] = "/newyear/jdshare.html";
            $data['maxnum'] = 100;

        }
        return $data;
    }
    /**
     * 赠送好礼
     */
    public function kecheng(Request $request,$id,$aid)
    {

        if($request->user()){
            $userid = $request->user()->id;
            $mobile  = $request->user()->mobile ? $request->user()->mobile : 0;  //�û��ֻ���
        }else{
            $mobile  = 0;  //�û��ֻ���
            $userid = 0;
        }
        $redirect_url = "/newyear/class/".$id."/".$aid.".html";
        $sponsor = new Sponsor();
        if($userid !== 0) {
            $re = $sponsor->where("uid", $userid)->where("aid",$aid)->count();
            if ($re == 0) {
                $sponsor->uid = $userid;
                $sponsor->aid = $aid;
                $all = $sponsor->save();

            }
        }

        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        $sponsor_people = Sponsor::where("uid",$userid)->first();//������
        $data = Assistance::where("userid",$userid)->where("aid",$aid)->limit(3)->get();//��������

        $fission_id = $request->input("fission_id", 0);   //�ѱ���id
        $this->ret['fission_id'] = $fission_id;           //�ѱ���id

        $this->ret['sponsor'] = $sponsor_people;
        $this->ret['data'] = $data;
        $this->ret['userid'] = $userid;
        $this->ret['class_id'] = $id;                      //�γ�id
        $this->ret['aid'] = $aid;                           //�id
        $this->ret['mobile'] = (int)$mobile;
        $this->ret['url'] = $redirect_url;

        return view("newyear.kecheng",$this->ret);
    }
    /*
     * $uid ������ id
     * $id �γ�id
     * $aid �id
     *
     * �γ̻ -- ����ҳ
     */
    public function help(Request $request,$uid,$id,$aid){

        if($request->user()){
            $userid = $request->user()->id;
            $mobile  = $request->user()->mobile ? $request->user()->mobile : 0;  //�û��ֻ���
            //$avatar  = $request->user()->avatar ? $request->user()->avatar : "/images/new_year/head_img2.png";  //ͷ��
        }else{
            $mobile  = 0;  //�û��ֻ���
            $userid = 0;
            //$avatar = "/images/new_year/head_img2.png";
        }

        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }

        $sponsor_people = Sponsor::where("uid",$uid)->first();//������

        $data = Assistance::where("userid",$uid)->where("aid",$aid)->limit(3)->get();//��������

        $fission_id = $request->input("fission_id", 0);   //�ѱ���id
        $this->ret['fission_id'] = $fission_id;           //�ѱ���id

        $this->ret['sponsor'] = $sponsor_people;
        $this->ret['data'] = $data;
        $this->ret['userid'] = $userid;
        $this->ret['class_id'] = $id;                      //�γ�id
        $this->ret['mobile'] = (int)$mobile;
        $this->ret['aid'] = $aid;                           //�id
        $this->ret['uid'] = $uid;                           //������id
        //$this->ret['avatar'] = $avatar;                     //������ͷ��
        $this->ret['url'] = "/newyear/classhelp/".$uid."/".$id."/".$aid.".html";

        return view("newyear.kecheng_help",$this->ret);
    }
    /**
     * �������
     *
     * 2 20Ԫ�ֽ�         5��
     * 3 �٤��           5��
     * 4 �ո���    15��
     * 5 100Ԫ������      25��
     */
    public function gift(Request $request,$aid){

        $activity = $this->activity_all($aid);//获取礼品信息
        $anum = $activity['num'];
        $gifturl = $activity['gifturl'];
        $maxnum = $activity['maxnum'];      //礼品最大限额
        $sponsor_count = Sponsor::where("aid",$aid)->where("is_get",1)->count();    //当前活动完成人数

        if($request->user()){
            $userid = $request->user()->id;
            $mobile  = $request->user()->mobile ? $request->user()->mobile : 0;  //�û��ֻ���
        }else{
            $mobile  = 0;  //�û��ֻ���
            $userid = 0;
        }
        $sponsor = new Sponsor();
        if($userid !== 0) {
            $re = $sponsor->where("uid", $userid)->where("aid",$aid)->count();
            if ($re == 0) {
                $sponsor->uid = $userid;
                $sponsor->aid = $aid;
                $all = $sponsor->save();

            }
        }

        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        $sponsor_people = Sponsor::where("uid",$userid)->where("aid",$aid)->first();//������
        $data = Assistance::where("userid",$userid)->where("aid",$aid)->limit($anum)->get();//��������

        $fission_id = $request->input("fission_id", 0);   //�ѱ���id
        $this->ret['fission_id'] = $fission_id;           //�ѱ���id

        $this->ret['sponsor'] = $sponsor_people;
        $this->ret['data'] = $data;
        $this->ret['userid'] = $userid;
        $this->ret['aid'] = $aid;                           //�id
        $this->ret['mobile'] = (int)$mobile;
        $this->ret['url'] = "/newyear/gift/".$aid.".html";      //��ת����
        $this->ret['anum'] = $anum;                         //������������
        $this->ret['gifturl'] = $gifturl;                   //�������
        $this->ret['maxnum']  = $maxnum;                    //活动最大人数
        $this->ret['sponsor_count']  = $sponsor_count;      //活动人数总计
        return view("newyear.gift",$this->ret);
    }

    /**
     * �����������
     *
     * 2 20Ԫ�ֽ�         5��
     * 3 �٤��           5��
     * 4 �ո���Ԫ������    15��
     * 5 100Ԫ������      25��
     */
    public function gifthelp(Request $request,$uid,$aid){
        $activity = $this->activity_all($aid);//获取礼品信息
        $anum = $activity['num'];
        $gifturl = $activity['gifturl'];

        $maxnum = $activity['maxnum'];      //礼品最大限额
        $sponsor_count = Sponsor::where("aid",$aid)->where("is_get",1)->count();    //当前活动完成人数

        if($request->user()){
            $userid = $request->user()->id;
            $mobile  = $request->user()->mobile ? $request->user()->mobile : 0;  //�û��ֻ���
        }else{
            $mobile  = 0;  //�û��ֻ���
            $userid = 0;
        }

        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }

        $sponsor_people = Sponsor::where("uid",$uid)->where("aid",$aid)->first();//������

        $data = Assistance::where("userid",$uid)->where("aid",$aid)->limit($anum)->get();//��������

        $fission_id = $request->input("fission_id", 0);   //�ѱ���id
        $this->ret['fission_id'] = $fission_id;           //�ѱ���id

        $this->ret['sponsor'] = $sponsor_people;
        $this->ret['data'] = $data;
        $this->ret['userid'] = $userid;
        $this->ret['mobile'] = (int)$mobile;
        $this->ret['aid'] = $aid;                           //�id
        $this->ret['uid'] = $uid;                           //������id newyear/gifthelp/{uid}/{aid}
        $this->ret['url'] = "/newyear/gifthelp/".$uid."/".$aid.".html";
        $this->ret['anum'] = $anum;                         //������������
        $this->ret['gifturl'] = $gifturl;                   //�������
        $this->ret['maxnum']  = $maxnum;                    //活动最大人数
        $this->ret['sponsor_count']  = $sponsor_count;      //活动人数总计

        return view("newyear.gift_help",$this->ret);
    }

    /*
     * ���������
     *
     * */
    public function store_data(Request $request)
    {
        $userid = $request->input("userid");    //发起人id
        $id = $request->input("friend");           //�����û�id
        $aid = $request->input("aid");          //活动id
        if($aid == 1){
            $cid = $request->input("cid");          //课程id
            $redirect_url = "/newyear/class/".$cid."/".$aid.".html"; //课程跳转链接
        }else{
            $redirect_url =  "/newyear/gift/".$aid.".html";         //礼品跳转链接
        }

        $assistance = new Assistance();

//        $newuser = 1;
//        $data2 = $assistance->where("friend",$id)->where("aid",$aid)->count();

        if($aid == 1){
            $newuser = 1;
            $data2 = $assistance->where("friend",$id)->where("aid",$aid)->count();
        }else{
            $newuser = $this->is_new($id);
            $data2 = $assistance->where("friend",$id)->count();
        }
        $activity = $this->activity_all($aid);//获取礼品信息
        if($newuser == 1){
            if($userid !== $id) {
                if (empty($data2)) {
                    if ($data2 < 1) {
                        $assistance->userid = $userid;
                        $assistance->friend = $id;
                        if($aid == 1){
                            $assistance->course_id = $cid;
                        }
                        $assistance->aid = $aid;
                        $re = $assistance->save();
                        if ($re) {
                            $result = 1;
                            $json = ['code' => 1, "result" => $result];//助力成功
                            //人数已满操作推送消息
                            $data3 = $assistance->where("userid",$userid)->where("aid",$aid)->count();
                            $openid = Users::where("id",$userid)->select("openid")->first();
                            if($data3 >= $activity['num']){
                                //΢微信推送模板消息
                                $dataInfo['type'] = WxMessageType::NEWYEAR;
                               // $dataInfo['url'] = env('APP_URL').$activity['gifturl'];
                                $dataInfo['url'] = env('APP_URL').$redirect_url;
                                logger()->info($activity['num']);
                                logger()->info("微信分享推送");
                                $dataInfo['notice'] = "恭喜你~好友助力成功，即可免费领取福利 ";
                                $dataInfo['message']['key1'] = $activity['title'];
                                $dataInfo['message']['key2'] = $activity['gift'];
                                $dataInfo['message']['key3'] = "2019年1月23日-2019年2月19日";
                                $dataInfo['message']['remark'] = "点击下方【详情】邀好友助力，免费领更多福利↓↓↓";
                                $dataInfo['openid'] = $openid->openid;
                                logger()->info($dataInfo);
                                logger()->info("微信分享推送");
                                if(env('IS_LOCAL') == false){
                                    event(new WxMessagePush($dataInfo));
                                }
                                //΢end
                            }else{
                                //΢微信推送模板消息
                                $dataInfo['type'] = WxMessageType::NEWYEAR;
                                $dataInfo['url'] = env('APP_URL').$redirect_url;
                                $count = Assistance::where("userid",$userid)->where("aid",$aid)->limit($activity['num'])->count();
                                $differ = $activity['num'] - $count;
                                logger()->info($differ);
                                $dataInfo['notice'] = "恭喜你~已经有".$count."位好友为你助力，还差".$differ."位好友即可免费领取福利";
                                $dataInfo['message']['key1'] = $activity['title'];
                                $dataInfo['message']['key2'] = $activity['gift'];
                                $dataInfo['message']['key3'] = "2019年1月23日-2019年2月19日";
                                $dataInfo['message']['remark'] = "点击下方【详情】邀好友助力，免费领更多福利↓↓↓";
                                $dataInfo['openid'] = $openid->openid;
                                logger()->info($dataInfo);
                                if(env('IS_LOCAL') == false){
                                    event(new WxMessagePush($dataInfo));
                                }
                                //΢end
                            }
                            //end
                        }
                    } else {
                        $result = 3;
                        $json = ['code' => 3, "result" => $result];     //�������������2��
                    }
                } else {
                    $result = 0;
                    $json = ['code' => 0, "result" => $result];     //�Ѿ�����
                }
            }else{
                $result = 4;  //���ܸ��Լ�����Ŷ
                $json = ['code' => 4, "result" => $result];     //�Ѿ�����
            }

        }else{
            $result = 5;  //ֻ�����û���������Ŷ
            $json = ['code' => 5, "result" => $result];     //�Ѿ�����
        }
        return json_encode($json);
    }


    //领取福利
    public function is_zutuan(Request $request)
    {

        $userid = $request->input("userid");    //用户id
        $aid = $request->input("aid");          //活动id
        $activity = $this->activity_all($aid);//获取礼品信息
        if($aid == 1){
            $cid = $request->input("cid");          //课程id
        }
        $num = $activity['num'];
        $activity = $this->activity_all($aid);//获取礼品信息
        $assistance = new Assistance();
        $data = Assistance::where("userid",$userid)->where("aid",$aid)->count();   //��������
        if($data >= $num){
            if($aid == 1){
                $studying = new Studying();
                $studying->addOne($userid, $cid);       //将课程分配给用户
            }
            $re = Sponsor::where('uid',$userid)->where("aid",$aid)->update(['is_get'=>1]);   //�޸�״̬

            if($re){



                return json_encode(['code'=>1,'count'=>1]);

            }else{
                return json_encode(['code'=>0,'count'=>$data]);
            }
        }else{
            return json_encode(['code'=>0,'count'=>$data]);
        }


    }

    /**
     *
     * ��ȡ��Ʒ��д��ַ
     *
     */
    public function addr(Request $request,$aid){
        $activity = $this->activity_all($aid);//获取礼品信息
        $num = $activity['num'];

        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        $status = Sponsor::where("uid",$userid) ->where("aid",$aid) ->first();
        $this->ret['aid'] = $aid;
        $this->ret["num"] = $num;
        $this->ret['status'] = $status;
        $this->ret['userid'] = $userid;
        return view("newyear.addr",$this->ret);
    }

    public function addrsave(Request $request,$aid){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }

        $status = Sponsor::where("uid",$userid) ->where("aid",$aid) ->first();
        if($status->is_get == 1){
            if($status->tel == ''){
                $status->name = $request->input("name");
                $status->tel = $request->input("mobile");
                $status->wechat = $request->input("wechat");
                $status->addr = $request->input("addr");

                $re = $status->save();
                if($re){
                    return json_encode(['code'=>1,'count'=>1]);     //�ɹ��������ݿ�
                }
            }else{
                return json_encode(['code'=>2,'count'=>0]);     //��ַ�Ѿ���д
            }

        }else{
            return json_encode(['code'=>0,'count'=>0]);     //��ȥ������Ѱ�
        }
    }
    /**
     *
     * 判断是否为新用户
     */
    public function is_new($userid){
        $mobile = Users::where("id",$userid)->select("created_at")->first();
        $created_at = $mobile->created_at;
        $now = date("Y-m-d",time());
        if(strtotime($created_at) - strtotime($now) > 0){
            return '1';//新用户
        }else{
            return '0';//老用户
        }


    }

    //生成邀请卡片
    public function shareCard(Request $request,$aid){

        $user = $request->user();
        $name  = $user->name ? $user->name : $user->nickname;
        if($name==""){
            $name = "С����";
        }
        $name = subtext($name,6);
        if($aid == 1){
            $cid = $request->input("cid");
            $share_img = env("APP_URL")."/images/new_year/shareclass.png";
            $share_url = env('APP_URL')."/newyear/classhelp/".$user->id."/".$cid."/".$aid.".html?fission_id=".$user->id;
            $activity = 3;              //
        }else{
            $share_img = env("APP_URL")."/images/new_year/gift.png";
            $share_url = env('APP_URL')."/newyear/gifthelp/".$user->id."/".$aid.".html?fission_id=".$user->id;
            $activity = 10;             //其他四项活动赠礼
        }

        $img = "http://qr.topscan.com/api.php?text=".$share_url;

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

        $img_url = $imageThumb->makePic($share_img,'' ,$wechatCode,'upload/share/', $name,$activity);
        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        $src  = "/".$img_url[1];
        $this->ret['src'] = $src;
        $this->ret['title'] = "111";
        $this->ret['desc'] = "1111";
        $this->ret['redirect_url'] = $share_url;
        $this->ret['fission_id'] = "";
        return view("newyear.sharecard",$this->ret);
    }

    public function getImage($url,$save_dir='',$filename='',$type=0){
        if(trim($url)==''){
            return array('file_name'=>'','save_path'=>'','error'=>1);
        }
        if(trim($save_dir)==''){
            $save_dir='./';
        }
        if(trim($filename)==''){//�����ļ���
            $ext=strrchr($url,'.');
            if($ext!='.gif'&&$ext!='.jpg'){
                return array('file_name'=>'','save_path'=>'','error'=>3);
            }
            $filename=time().$ext;
        }
        if(0!==strrpos($save_dir,'/')){
            $save_dir.='/';
        }
        //��������Ŀ¼
        if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){
            return array('file_name'=>'','save_path'=>'','error'=>5);
        }
        //��ȡԶ���ļ������õķ���
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
        //�ļ���С
        $fp2=@fopen($save_dir.$filename,'a');
        fwrite($fp2,$img);
        fclose($fp2);
        unset($img,$url);
        return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'error'=>0);
    }

    /*
     * 京东卡分配
     */
    public function jdshare(Request $request){
        if($request->user()){
            $userid = $request->user()->id;
        }else{
            $userid = 0;
        }
        $status = Sponsor::where("uid",$userid) ->where("aid",5) ->first();

        if($status->is_get == 1){
            $is_get = Jscard::where("user_id",$userid)->count();
            if($is_get == 1){
                $data = Jscard::orderBy("id","desc")->where("user_id",$userid)->first();
            }else{
                $data = Jscard::orderBy("id","desc")->where("user_id",0)->first();
                if($data){
                    $data->user_id = $userid;
                    $re = $data->save();
                }
            }
            $this->ret['data'] = $data;
        }

        $this->ret['userid'] = $userid;
        $this->ret['status'] = $status;

        return view("newyear.jdshare",$this->ret);
    }
    public function erweima(){

        return view("newyear.erweima");
    }




}
