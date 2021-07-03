<?php

namespace App\Http\Controllers\Assistance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\Assistance;
use App\Models\Studying;
use App\Utils\WxMessagePush as WxPush;



class AssistanceController extends Controller
{
    /**
     * �������� �γ�ID Ϊ39
     */
    public function index(Request $request,$id)
    {
        $courseid = 39;
        if($request->user()){
            $userid = $request->user()->id;
            $mobile  = $request->user()->mobile ? $request->user()->mobile : 0;  //�û��ֻ���
        }else{
            $mobile  = 0;  //�û��ֻ���
            $userid = 0;
        }
        if($userid !== 0){
            $subscribe = $request->user()?$request->user()->subscribe:''; //�Ƿ��ע
            if($subscribe == 0){
                $openid = $request->user()?$request->user()->openid:''; //�Ƿ��ע
                $sub_state = $this->is_sub($openid);
                $subscribe = $sub_state;
                if($userid !== 0){
                    Users::where("id",$userid)->update(['subscribe'=>$subscribe]);
                }
            }
        }else{
            $subscribe = 0;
        }

        //dd($userid);
        $assistance = new Assistance();
        $data = $assistance->where("userid",$id)->where("course_id",$courseid)->limit(4)->get();

        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        $fission_id = $request->input("fission_id", 0);   //�ѱ���id
        $this->ret['fission_id'] = $fission_id;           //�ѱ���id
        $this->ret['data'] = $data;
        $this->ret['userid'] = $userid;
        $this->ret['id'] = $id;
        $this->ret['class_id'] = $courseid;//�γ�id
        $this->ret['mobile'] = (int)$mobile;
        $this->ret['subscribe'] = $subscribe;              //�Ƿ��ע

        return view('assistance.index',$this->ret);
    }

    /**
     * ��ҳ--��������
     *
     */
    public function friend(Request $request,$id)
    {
        $courseid = 39;
        if($request->user()){
            $userid = $request->user()->id;
            $mobile  = $request->user()->mobile ? $request->user()->mobile : 0;  //�û��ֻ���
        }else{
            $mobile  = 0;  //�û��ֻ���
            $userid = 0;
        }
        if($userid !== 0) {
            $subscribe = $request->user() ? $request->user()->subscribe : ''; //�Ƿ��ע
            if ($subscribe == 0) {
                $openid = $request->user() ? $request->user()->openid : ''; //�Ƿ��ע
                $sub_state = $this->is_sub($openid);                    //��ȡ״ֵ̬
                $subscribe = $sub_state;
                if ($userid !== 0) {
                    Users::where("id", $userid)->update(['subscribe' => $subscribe]);
                }

            }
        }else{
            $subscribe = 0;
        }


        $assistance = new Assistance();
        if($id !== "0") {

            $re = $assistance->where("userid", $userid)->where("friend",$userid)->where("course_id",$courseid)->count();
            if ($re == 0) {
                $assistance->userid = $userid;
                $assistance->friend = $userid;
                $assistance->course_id = $courseid;
                $assistance->is_sponsor = 1;
                $all = $assistance->save();
            }
        }
        $data = $assistance->where("userid",$userid)->where("course_id",$courseid)->limit(4)->orderBy("is_sponsor","desc")->get();
        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();
        }
        //$data = Users::where("id",$userid)->first();
        $this->ret['data'] = $data;
        $this->ret['userid'] = $userid;
        $this->ret['class_id'] = $courseid;                      //�γ�id
        $this->ret['mobile'] = (int)$mobile;
        $this->ret['subscribe'] = $subscribe;            //�Ƿ��ע

        return view("assistance.index_form",$this->ret);
    }

    /*
     * ������������
     * */
    public function store_data(Request $request)
    {
        $courseid = 39;
        $userid = $request->input("userid");
        $id = $request->input("friend");
        $assistance = new Assistance();
        $data  = $assistance->where("userid",$id)->where("friend",$userid)->where("course_id",$courseid)->count();
        $data2 = $assistance->where("friend",$userid)->where("course_id",$courseid)->count();

        if (empty($data)) {
            if($data2 < 2) {
                $assistance->userid = $id;
                $assistance->friend = $userid;
                $assistance->course_id = $courseid;
                $re = $assistance->save();
                if ($re) {
                    $result = 1;
                    $json = ['code' => 1, "result" => $result];//�����ɹ�
                }
            }else{
                $result = 3;
                $json = ['code' => 3, "result" => $result];     //�������������2��
            }
        } else {
            $result = 0;
            $json = ['code' => 0, "result" => $result];     //�Ѿ�����
        }

        return json_encode($json);
    }

    public function is_zutuan(Request $request)
    {
        $courseid = 39;
        $userid = $request->input("userid");
        $assistance = new Assistance();

        $data = Assistance::where("userid",$userid)->where("course_id",$courseid)->count();   //��������
        if($data > 3){
            $studying = new Studying();
            $re = $studying->addOne($userid, 39);       //���γ̸����û�
            $assistance->where('userid',$userid)->where("friend",$userid)->where("course_id",$courseid)->update(['is_get'=>1]);   //�޸�״̬

            if($re){
                return json_encode(['code'=>1,'count'=>1]);
            }
        }else{
            return json_encode(['code'=>0,'count'=>$data]);
        }


    }
    public function erweima(){

        return view("assistance.redirect");
    }

    //�ж��Ƿ��ע
    public function is_sub($openid){
        $wxPush  = new WxPush();
        $token   = $wxPush->getToken();//��ȡaccessToken
        $subscribe_msg = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$token."&openid=".$openid;
        $subscribe = json_decode(file_get_contents($subscribe_msg));
        $is_sub = $subscribe? $subscribe->subscribe : 0;
        return $is_sub;

    }



}
