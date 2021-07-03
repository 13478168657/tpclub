<?php

namespace App\Http\Controllers\Special;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Special;
use App\Models\Article;
use App\Models\Special_follow;
use App\User;


class SpecialController extends Controller
{
    /**
     * 专题列表页
     */
    public function dataList(){
        $data = Special::whereNull("deleted_at")->where("state",1)->orderby("id","desc")->get();
        //dd($data);
        $this->ret['data'] = $data;
        return view("special.list",$this->ret);
    }
    /**
     * 首页
     */
    public function index(Request $request,$id)
    {   
        if($request->user()){
                $userid = $request->user()->id;
            }else{
                $userid = 0;
            }
        
        $data = Special::where("id",$id)->first();
        $article = Article::where("special_id","like","%".$id."%")->orderby("orderby", "asc")->get();

        $fission_id = $request->input("fission_id", 0);   //裂变者id
        $this->ret['fission_id'] = $fission_id;//裂变者id

        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();  //微信分享
        }
        $this->ret['data'] = $data;
        $this->ret['article'] = $article;
        $this->ret['userid'] = $userid;
        return view("special.index",$this->ret);
    }
    /**
     * 
     * 关注专题
     */
    public function interest(Request $request){
        if($request->user()){
                $userid = $request->user()->id;
        }else{
                $userid = 0;
        }
        $special_id = $request->input("id");
        $a = new Special_follow();
        $a->special_id = $special_id;
        $a->fans_id = $userid;
        $result = $a->save(); 
        if($result){
            courseSpb($userid,15,$special_id);
            return json_encode(['code'=>1]);
        }else{
            return json_encode(['code'=>0]);
        }
       // dd($request->input());
    }
    
    //分享课程页
    public function shareArticle(Request $request,$id,$sid){
        if($request->user()){
                $userid = $request->user()->id;
        }else{
                $userid = 0;
        }

        $mobile = User::where("id",$userid)->select("mobile")->first();
        $data = Article::where("id",$id)->first();

        $fission_id = $request->input("fission_id", 0);   //裂变者id

        $this->ret['fission_id'] = $fission_id;//裂变者id

        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();  //微信分享
        }
        //dd($data);
        $this->ret['data'] = $data;
        $this->ret['redirect'] = "/special/indexRegister/".$id."/".$sid.".html#form";
        $this->ret['mobile'] = $mobile?$mobile:'';
        $this->ret['sid'] = $sid;
        $this->ret['userid'] = $userid;
        return view("special.indexLand",$this->ret);
    }

    public function register(Request $request,$id,$sid){
        if($request->user()){
                $userid = $request->user()->id;
        }else{
                $userid = 0;
        }

        $mobile = User::where("id",$userid)->select("mobile")->first();
        $openId = '';
        $data = Article::where("id",$id)->first();
        if(!$data){
            logger()->info('文章id--'.$id);
            logger()->info('文章specialid--'.$sid);
        }
        $fission_id = $request->input("fission_id", 0);   //裂变者id
        $this->ret['fission_id'] = $fission_id;//裂变者id

        $is_local = env("IS_LOCAL");
        if($is_local){
            $this->ret['WechatShare'] = ['appId'=>1, "timestamp"=>2, "noncestr"=>3, "signature"=>4, "url"=>5];
        }else{
            $this->ret['WechatShare'] = getSignPackage();  //微信分享
        }

        $this->ret['data'] = $data;

        $this->ret['openid']  = $openId;
        $this->ret['redirect'] = "/special/indexLand/".$id."/".$sid.".html#form";
        $this->ret['mobile'] = $mobile?$mobile:'';
        $this->ret['sid']    = $sid;
        $this->ret['href']   = "/article/special/".$id."/".$sid.".html";
        $this->ret['userid'] = $userid;
        return view("special.indexRegister",$this->ret);
    }

 

 

}
