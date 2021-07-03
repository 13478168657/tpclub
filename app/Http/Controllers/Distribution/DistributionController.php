<?php

namespace App\Http\Controllers\Distribution;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Distribution;
use App\Utils\FileUploader;
use App\Models\Users;
use App\Models\UsersGrowing;
use App\Models\DisCourseClass;
use App\Utils\ImageThumb;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use App\Constant\WxMessageType;
use App\Events\WxMessagePush;

class DistributionController extends Controller
{

    /**
     * 分销主页
     */

    public function home()
    {

        return view("distribution.home");
    }

    /**
     * 分销申请流程-分销员中心
     */
    public function index()
    {

        return view("distribution.index");
    }

    /**
     * 分销申请流程-分销员中心
     */
    public function apply(Request $request)
    {
        if ($request->user()) {
            $userid = $request->user()->id;
            $mobile = $request->user()->mobile ? $request->user()->mobile : 0;  //用户手机号
        } else {
            $userid = 0;
            $mobile = 0;
        }
        $this->ret['mobile'] = $mobile;
        // $subscribe = Users::where("id", $userid)->first();
        // if(count($subscribe) > 0 ){
            // if ($subscribe->subscribe == 1) {
                $data = Distribution::where("user_id", $userid)->first();

                if (count($data) > 0) {
                    if ($data->code == 1) {
                        $user = Users::where("id", $userid)->first();
                        $all_num = UsersGrowing::where("fission_id", $userid)->where("code","00")->count();

                        $all_share_class = DisCourseClass::whereNull("deleted_at")->where("state",1)->orderBy('id', "desc")->take(5)->get();    //获取所有分享课程
                        $fission_id = UsersGrowing::where("user_id",$userid)->select("fission_id")->first();
                        $this->ret['class'] = $all_share_class;
                        $this->ret['all_num'] = $all_num;
                        $this->ret['user'] = $user;
                        $this->ret['userid'] = $userid;
                        $this->ret['fission_id'] = $fission_id;
                        return view("distribution.home", $this->ret);
                    }
                }
                $this->ret['data'] = $data;
               // dd($data);
                return view("distribution.apply", $this->ret);
            // } else {
            //     return view("distribution.index");
            // }
        // }else{
        //     return view("distribution.index");
        // }
    }
    /**
     * 分销申请流程-分销员说明中心
     */
    public function disExplain(Request $request)
    {
        if ($request->user()) {
            $userid = $request->user()->id;
        } else {
            $userid = 0;
        }
        
        return view("distribution.index");
    }

    /**
     * 邀请的人-全部
     */
    public function invite(Request $request, $status)
    {
        if ($request->user()) {
            $userid = $request->user()->id;
        } else {
            $userid = 0;
        }
        $growing = new UsersGrowing();
        $time = Distribution::where("user_id", $userid)->select("created_at")->first();
        $all_data = $growing->where("fission_id", $userid)->where("code","00")->where("created_at",">=",$time->created_at)->orderBy("id","desc")->take(10)->get();
        //是否预定
        $num = 0;
        foreach($all_data as $v){
            if($v->is_reserve == 1){
                $num = $num + 1;

            }else{
                if($v->mobile !== ''){
                    $url    = "isaipu.net/api/market/searchHandinState?traineeMobile=".$v->mobile;
                    $result = httpGet($url);
                    $arr    = json_decode($result,true);
                    if($arr['code'] == 1){
                        $num = $num + 1;
                        if($v->is_reserve !== 1) {
                            DB::table('users_growing')
                                ->where("mobile", $v->mobile)
                                ->update(['is_reserve' => 1, "reserve_at" => date("Y-m-d H:i:s")]);
                        }
                    }
                }
            }

        }
        //是否已入学
        $entrance_num = 0 ;
        foreach($all_data as $v){
            if($v->is_entrance == 1){
                $entrance_num = $entrance_num + 1;
            }else{
                if($v->mobile !== ''){
                    $url    = "/api/student/join?mobile=".$v->mobile;
                    $result = httpGet($url);
                    $arr    = json_decode($result,true);
                    if($arr['code'] == 0){
                        $entrance_num = $entrance_num + 1;
                        if($v->is_entrance !== 1) {
                            DB::table('users_growing')
                                ->where("mobile", $v->mobile)
                                ->update(['is_entrance' => 1]);
                        }
                    }
                }
            }
        }
        if ($status == 0) {
            $growing = $growing;
        }elseif($status == 2){
            $growing = $growing->where("is_entrance", 1);
        } else {
            $growing = $growing->where("is_reserve", 1);
        }
        $data = $growing->where("fission_id", $userid)->where("code","00")->where("created_at",">=",$time->created_at)->orderBy("id","desc")->take(10)->get();

        $all_num = UsersGrowing::where("fission_id", $userid)->where("created_at",">=",$time->created_at)->where("code","00")->count();

        $this->ret['all_num'] = $all_num;           //所有人数
        $this->ret['num'] = $num;                   //是否预定
        $this->ret['entrance_num'] = $entrance_num; //已入学人数
        $this->ret['data'] = $data;
        $this->ret['status'] = $status;
        return view("distribution.invite", $this->ret);
    }
    public function loadmoreinvite(Request $request){
        if ($request->user()) {
            $userid = $request->user()->id;
        } else {
            $userid = 0;
        }
        $time = Distribution::where("user_id", $userid)->select("created_at")->first();
        $status = $request->input("status");
        $growing = new UsersGrowing();
        if ($status == 0) {
            $growing = $growing;
        }elseif($status == 2){
            $growing = $growing->where("is_entrance", 1);
        } else {
            $growing = $growing->where("is_reserve", 1);
        }
        $num = 10;
        $page = $request->input("page");
        $offset = $num *($page - 1);
        $data = $growing->where("fission_id", $userid)->whereNull("deleted_at")->where("created_at",">=",$time->created_at)->where("code","00")->orderBy("created_at","desc")->skip($offset)->take($num)->get();

        return json_encode(['code'=>0,'body'=>view('distribution.body.loadmoreinvite',['data'=>$data,"userid"=>$userid])->render()]);
    }
    /**
     * 我的课程顾问
     */
    public function guwen(Request $request)
    {
        if ($request->user()) {
            $userid = $request->user()->id;
        } else {
            $userid = 0;
        }
        $guwen = Distribution::whereNull("deleted_at")->where("code", 1)->get();
        $score = [];
        foreach ($guwen as $k => $v) {
            $count = UsersGrowing::where("fission_id", $v->user_id)->count();
            $score[$k] = $count;
            $v->num = $count;
        }
        $json = json_encode($guwen);
        $guwen = json_decode($json, true);
        array_multisort($score, SORT_DESC, $guwen);
        //dd($guwen);
        $this->ret['guwen'] = $guwen;
        return view("distribution.guwen", $this->ret);
    }

    /**
     * 申请信息
     */
    public function form_data(Request $request)
    {
        if ($request->user()) {
            $userid = $request->user()->id;
            $openid = $request->user()->openid;
        } else {
            $userid = 0;
            $openid = "";
        }
        $form_id = $request->input("form_id")?$request->input("form_id"):0;
        $distribution = new Distribution();
        if($form_id !== 0){
            $distribution = $distribution->where("id",$form_id)->first();
            $distribution->code = 0;
        }
        //上传图片
        //$file = new FileUploader($request);
        //$fileInfo = $file->base64ImgUpload($request, 'upload/askspecial');
        //logger()->info($fileInfo);


        $distribution->name = filterSpecialChar($request->input("name"));
        $distribution->mobile = filterSpecialChar($request->input("tel"));
        $distribution->wx_code = filterSpecialChar($request->input("wechat"));
        $distribution->id_card = filterSpecialChar($request->input("idcard"));
        $distribution->teacher_mobile = filterSpecialChar($request->input("teacher_tel"));
        $distribution->user_id = $userid;
        $distribution->wx_img = $request->input("img_data");
        $re = $distribution->save();
        if ($re) {
            //΢微信推送模板消息
            $dataInfo['type'] = WxMessageType::DISTRIBUTION;
            $dataInfo['url'] = env('APP_URL')."/distribution/apply.html";
            $dataInfo['notice'] = "您申请的课程顾问已经提交成功了 ";
            $dataInfo['message']['key1'] ="课程顾问申请";
            $dataInfo['message']['key2'] = date("Y-m-d H:i:s",time());
            $dataInfo['message']['remark'] = "请等待1-3天左右的审核期，审核结果将会在本公众号内通知您";
            $dataInfo['openid'] = $openid;
            logger()->info($dataInfo);
            logger()->info("申请分销成功推送");
            if(env('IS_LOCAL') == false){
                event(new WxMessagePush($dataInfo));
            }
            echo json_encode(array("code" => 1));
        } else {
            echo json_encode(array("code" => 0));
        }


    }

    /**
     * 加载更多
     */
    public function loadmore(Request $request)
    {
        if ($request->user()) {
            $userid = $request->user()->id;
        } else {
            $userid = 0;
        }
        $num = 10;
        $page = $request->input("page");

        $offset = $num *($page - 1);
        $data = DisCourseClass::whereNull("deleted_at")->where("state",1)->orderBy("created_at","desc")->skip($offset)->take($num)->get();

        return json_encode(['code'=>0,'body'=>view('distribution.body.loadmore',['data'=>$data,"userid"=>$userid])->render()]);
    }

    /**
     * 生成邀请卡片
     */

    public function shareCard(Request $request){
        $id = $request->input("id");
        $cid = $request->input("cid");

        if(Redis::exists("cache_fenxiao_img_".$id."_".$cid) && Redis::get("cache_fenxiao_img_".$id."_".$cid) != ''){
            $src = Redis::get("cache_fenxiao_img_".$id."_".$cid);
        }else{
            $img = Distribution::where("user_id",$id)->select("wx_img")->first();
            $poster_card = DisCourseClass::where("id",$cid)->select("poster_url")->first();
            // dd($img);
            //$share_img = '/images/fenxiaoliucheng/moban.png';
            $share_img = $poster_card->poster_url;

            $wechatCode = $img->wx_img;
            //$wechatCode = 'http://image.saipubbs.com/upload/askspecial/20190412/1555047488.5933513027.jpeg';
            $name='';
            $imageThumb  = new ImageThumb();
            $img_url = $imageThumb->makePic($share_img,'' ,$wechatCode,'/upload/share/', $name,4);
            $src  = $img_url[1];
            Redis::set("cache_fenxiao_img_".$id."_".$cid, $src);
        }

        return json_encode(array("img" => $src));
        //return view("distribution.sharecard",$this->ret);
    }

    /**
     * 分销规则
     * 20190508
     */
    public function rule(Request $request)
    {
        return view("distribution.rule");
    }


}
