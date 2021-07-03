<?php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>{{$data->seo_title}}{{env('WEB_TITLE_COURSE')}}</title>
    <meta name="author" content="赛普课堂" />
    <meta name="description" content="{{$data->seo_description}}" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/xueyuan-detail2.css" rel="stylesheet" type="text/css" />
    <!--mmenu.css start-->
    <link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
    <link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
    <link href="/css/nav-mmenu-public.css" rel="stylesheet" />
    <!--end-->
    <script src="/js/TouchSlide.1.1.js"></script>
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
    @include('layouts.baidutongji')
</head>
<body ontouchstart>

<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->
    <!--头部导航 start-->
    <div class="mh-head Sticky">
        <div class=" menu-bg-logo">
                <span class="mh-btns-left">
                    <a class="icon-menu icon-sousuo" href="/search"></a>
                </span>
                <span class="mh-btns-right">
                    <a class="icon-menu" href="#menu"></a>
                    <a class="icon-menu" href="#page"></a>
                </span>
        </div>
    </div>

    <!--隐藏导航内容-->
    <nav id="menu">
        <div class="text_center nav-a">
            <ul>
                <li><a href="/">首页</a></li>
                <li><a href="/user/studying">正在学习</a></li>
                <li><a href="/user/index">我的</a></li>
                <li><a href="javascript:history.go(-1);">返回</a></li>
                @if(!is_weixin())
                    @if($user)
                        <li><a href="/logout">退出</a></li>
                    @else
                        <li><a href="/login">登录</a></li>
                    @endif
                @endif
            </ul>
        </div>
    </nav>
    <!--头部导航 end-->
    <?php
    $flag = 0;
    if($liveCourse && time() >= strtotime($liveCourse->live_start_time) && time() <= strtotime($liveCourse->live_end_time)){
        $flag = 1;
    }
    ?>
    <div class="bgc_white pb100 mb40">
        <!-- banner start -->
        <div class="banner max-img border-radius-img relative">
            @if($flag)
            <a href="{{env('POLY_LIVE_URL')}}{{$liveCourse->live_number}}"><img src="{{env('IMG_URL')}}{{$data->explain_url}}" class="img100" alt="{{$data->title}}" />
            <img class="icon-bofang" src="/images/now-zhibo.gif" alt=""></a>
            @else
                <img src="{{env('IMG_URL')}}{{$data->explain_url}}" class="img100" alt="{{$data->title}}" />
            @endif
        </div>
        <!-- banner end -->

        <!--本篇标题 start-->
        <div class="weui-cells xy-kecheng-tit mt0 noafter nobefore ">
            <div class="weui-cell">
                <div class="weui-cell__bd text-overflow ">
                    <h2 class="lt text-overflow">{{$data->title}}</h2>
                    <p class="color_gray666 fz">{{$data->sum_video}} 节课·{{$data->sum_people}} 人正在提高中</p>
                </div>
                @if(is_collect($data->id,$user_id) == 1)
                    <div class="weui-cell__ft text_center">
                        <div id="button_shoucang">
                            <img  id="wei_shoucang" data-collect="1" src="/images/yishoucang.png" alt="已收藏课程" data-attr="{{$data->id}}" />
                        </div>
                    </div>
                @else
                    <div class="weui-cell__ft text_center">
                        <div id="button_shoucang">
                            <img  id="wei_shoucang" data-collect="0" src="/images/shoucang.png" alt="未收藏课程" data-attr="{{$data->id}}" />
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!--本篇标题 end-->
        <!-- <span class="baomingBtn" onclick="follow_us()">报名成功</span> -->
        <!-- 选项卡 start ================================ -->
        <div id="leftTabBox" class="tabBox">
            <div class="hd" id="nav_keleyi_com">
                <ul>
                    <li><a href="javascript:void(0)" ><span>课程简介</span></a></li>
                    <li><a href="javascript:void(0)"><span>课程目录</span></a></li>

                </ul>
            </div>
            <div class="bd" id="tabBox1-bd">
                <div class="con">
                    <div>
                        <!--简介 start-->
                        <article class="weui-article color_gray666 xy-kecheng-wen text-jus bottomheightgrey">
                            <section>
                                <!--<h2 class="lt grey">简介</h2>-->
                                <section class="fz">
                                    <?php
                                    echo $data->introduction;
                                    ?>
                                </section>
                            </section>
                        </article>
                        <!--简介 end-->
                    </div>
                </div>
                <div class="con">
                    <!--课程目录 start-->
                    <div class="plr30">

                        <!--课程目录 start-->
                        <!-- Contenedor -->
                        <ul id="accordion" class="accordion">
                            @foreach($array as $k=>$v)

                            @if($flag && $liveCourse->course_class_section_id == $v->id)
                                <li  class="f28 fz open">
                            @elseif(!$flag)
                                <li  class="f28 {{$k==0?" open":"fz"}}">
                            @else
                                <li class="f28 fz">
                            @endif
                                <div class="link bold "><span class="pr20 color_gray666">{{($k+1)<10?'0'.($k+1):$k+1}}</span>{{$v->title}}<i class="fa-chevron-down"></i></div>
                                @if($data->is_free==0 || is_baoming($data->id,$user_id) == 1 || expericence_card_isture($data->course_type_id,$user_id) == 1)
                                    @if($k == 0)
                                        <ul class="submenu">
                                    @else
                                        <ul class="submenu">
                                    @endif
                                        @foreach($v->course as $a)
                                            <?php
                                                $colorFlag = 0;
                                                if(time() > strtotime($a->live_end_time)){
                                                    $colorFlag = 1;
                                                }
                                            ?>
                                            <li class="pt20">
                                                @if($a->is_live && time() <= strtotime($a->live_end_time))
                                                    <a href="{{env('POLY_LIVE_URL')}}{{$a->live_number}}">
                                                @elseif($a->is_live && time() > strtotime($a->live_end_time))
                                                    @if(strpos($a->video_url,'video.saipubbs.com') === false)
                                                        <a href="{{env('POLY_LIVE_URL')}}{{$a->live_number}}">
                                                    @else
                                                        <a  onclick="go_video('{{$data->id}}','{{$a->id}}');" id="player_{{$a->id}}">
                                                    @endif
                                                @else
                                                    <a  onclick="javascript:void(0);">
                                                @endif
                                                    <div class="weui-cells nobefore noborder noafter padding0 mt0">
                                                        <div class="weui-cell nobefore noborder noafter padding0 mt0">
                                                            <div class="weui-cell__hd"><img src="/images/ico_video.png"></div>
                                                            <div class="weui-cell__bd f28 {{$colorFlag?'color_c9c7c7':'color_333'}} fz">
                                                                <p class="text-overflow">{{$a->title}}</p>
                                                                <p class="fz color_gray9b f22">{{date('Y/m/d H:i',strtotime($a->live_start_time))}}~{{date('H:i',strtotime($a->live_end_time))}}<span class="pl20 ml20"></span></p>
                                                            </div>
                                                            @if($a->is_live && time() < strtotime($a->live_start_time))
                                                                 <div class="weui-cell__ft mr20 pt10 pb10 fz color_333 f20 text_center border-radius-img v-shiting">待直播</div>
                                                            @elseif($a->is_live && time() >= strtotime($a->live_start_time) && time() <= strtotime($a->live_end_time))
                                                                <div class="weui-cell__ft mr20 pt10 pb10 fz color_333 f20 text_center border-radius-img v-zhibozhong"><img src="/images/zhibozhong.gif" alt="">直播中</div>
                                                            @elseif($a->is_live && time() > strtotime($a->live_end_time))
                                                                @if(strpos($a->video_url,'video.saipubbs.com') === false)
                                                                <div class="weui-cell__ft mr20 pt10 pb10 fz {{$colorFlag?'color_c9c7c7':'color_333'}} f20 text_center border-radius-img v-shiting">已结束</div>
                                                                @endif
                                                            @else
                                                                @if($a->preview)
                                                                    <div class="weui-cell__ft mr20 pt10 pb10 fz color_333 f20 text_center border-radius-img v-shiting">试听</div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else

                                       <ul class="submenu">
                                       @foreach($v->course as $a)
                                            <?php
                                               $colorFlag = 0;
                                               if(time() > strtotime($a->live_end_time)){
                                                   $colorFlag = 1;
                                               }
                                            ?>
                                            <li class="pt20">
                                                @if($a->is_live && time() <= strtotime($a->live_end_time))
                                                <a href="{{env('POLY_LIVE_URL')}}{{$a->live_number}}">
                                                @elseif($a->is_live && time() > strtotime($a->live_end_time))
                                                    @if(strpos($a->video_url,'video.saipubbs.com') === false)
                                                        <a href="{{env('POLY_LIVE_URL')}}{{$a->live_number}}">
                                                    @else
                                                        <a onclick="go_video('{{$data->id}}','{{$a->id}}');" id="player_{{$a->id}}">
                                                    @endif
                                                @else
                                                    <a onclick="javascript:void(0);">
                                                @endif
                                                <div class="weui-cells nobefore noborder noafter padding0 mt0">
                                                     <div class="weui-cell nobefore noborder noafter padding0 mt0">
                                                     <div class="weui-cell__hd"><img src="/images/ico_video.png"></div>
                                                     <div class="weui-cell__bd f28 {{$colorFlag?'color_c9c7c7':'color_333'}} fz">
                                                     <p class="text-overflow">{{$a->title}}</p>
                                                     <p class="fz color_gray9b f22">{{date('Y/m/d',strtotime($a->live_start_time))}}<span class="pl20 ml20">{{$a->live_long_time}}min</span></p>
                                                </div>
                                                                                                                                           @if($a->is_live && time() < strtotime($a->live_start_time))
                                                                                                                                           <div class="weui-cell__ft mr20 pt10 pb10 fz color_333 f20 text_center border-radius-img v-shiting">待直播</div>
                                    @elseif($a->is_live && time() >= strtotime($a->live_start_time) && time() <= strtotime($a->live_end_time))
                                                                                                                                                <div class="weui-cell__ft mr20 pt10 pb10 fz color_333 f20 text_center border-radius-img v-zhibozhong"><img src="/images/zhibozhong.gif" alt="">直播中</div>
                                                                                                                                            @elseif($a->is_live && time() > strtotime($a->live_end_time))
                                                 <div class="weui-cell__ft mr20 pt10 pb10 fz {{$colorFlag?'color_c9c7c7':'color_333'}} f20 text_center border-radius-img v-shiting">已结束</div>
                                                                                                                                            @else
                                                                                                                                                @if($a->preview)
                                                                                                                                                    <div class="weui-cell__ft mr20 pt10 pb10 fz color_333 f20 text_center border-radius-img v-shiting">试听</div>
                                                                                                                                                @endif
                                                                                                                                            @endif
                                                                                                                                        </div>
                                                                                                                                    </div>
                                       </a>
                                      </li>
                                     @endforeach
                                   </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>

                        <!--课程目录 end-->
                    </div>
                    <!--课程目录 end-->
                </div>

            </div>
        </div>
        <!-- 选项卡 end ================================ -->


        <!--作者名片 start-->
        <div class="afterleftright075">
            <div class="weui-cells mt0 daoshi-tit nobefore">
                <a class="weui-cell weui-cell_access " href="/user/teacher/{{$data->user_id}}.html">
                    <div class="weui-cell__hd">
                        @if($data->avatar)
                            @if(strpos($data->avatar,'http') !== false)
                                <img class="border-radius50" src="{{$data->avatar}}">
                            @else
                                <img class="border-radius50" src="{{env('IMG_URL')}}{{$data->avatar}}">
                            @endif
                        @else
                            <img class="border-radius50" src="/images/my/nophoto.jpg" alt="" />
                        @endif
                    </div>
                    <div class="weui-cell__bd text-overflow">
                        <h2 class="lt">{{$data->teacher_name}} 导师</h2>
                        <p class="fz text-overflow color_gray666">{{$data->teacher_inc}}</p>
                    </div>
                    <div class="weui-cell__ft fz">个人主页</div>
                </a>
            </div>
        </div>
        <!--作者名片 end-->

        @if(avg_comments($data->id))
                <!-- 课程评价 start -->
        <div class="weui-cell nobefore mt10">
            <div class="weui-cell__bd">
                <h2 class="fs15 bold">课程评价<span class="ml10">{{avg_comments($data->id)}}分</span></h2>
            </div>
            <div class="weui-cell__ft">
                <a href="/course/comments/{{$data->id}}.html" class="fs12 grey1">查看全部评价&nbsp;&nbsp;{{sum_comments($data->id)}}&nbsp;<img src="/images/ico_arrow_db.png" class="ico_arrow_db ml5" /></a>
            </div>
        </div>
        <div class="weui-cell evaluate nobefore">
            <div class="weui-cell__bd">
                <a href="javascript:;" class="user_photo">
                    @if($comment_one && ($comment_one->users) && (strpos($comment_one->users->avatar,'http') !== false))
                        <img src="{{$comment_one->users->avatar}}" class="img100" />
                    @elseif($comment_one && $comment_one->users)
                        <img src="{{env('IMG_URL')}}{{$comment_one->users? $comment_one->users->avatar: ''}}" class="img100" />
                    @endif
                </a>
                <dl>
                    @if($comment_one && $comment_one->users)
                        <dt>{{$comment_one->users->name}}</dt>
                    @else
                        <dt></dt>
                    @endif
                    <dd>
                        <ul class="stars">
                            <?php
                            echo  htmlspecialchars_decode($comment_one->stars)
                            ?>
                        </ul>
                        <span class="score">{{$comment_one->score}}.0&nbsp;分</span>
                    </dd>
                </dl>
                <p>{{$comment_one->content}}</p>
            </div>
        </div>
        <!-- 课程评价 end -->
        @else
                <!--课程未评价 start-->
        <div class="mt10 ke_weipingjia text_center">
            <div class="color_gray666 mb40">
                <p class="mb40 pt40">还没有人评价，赶快来评价吧！</p>
                @if(is_baoming($data->id,$user_id) == 1 || expericence_card_isture($data->course_type_id,$user_id))
                    <a class="border-radius-img" href="/course/commentadd/{{$data->id}}">我要评价 <img src="/images/icon_ping.png" alt=""></a>
                @else
                    <a class="border-radius-img" href="javascript:;" onclick="layer.msg('报名后才能评价')">我要评价 <img src="/images/icon_ping.png" alt=""></a>
                @endif
            </div>
        </div>
        <!--课程未评价 end-->
        @endif
    </div>
</div>
<!-- 底部固定条 start -->
<div class="fixed_bar_bottom">
    <ul class="clearfix btnsWrap">
        @if(expericence_card_isture($data->course_type_id,$user_id))
            <li class="studyBtn">
                <a href="/course/video/{{$data->id}}/{{$array[0]->course[0]->id}}.html">进入直播间</a>
            </li>
        @else
            @if($mobile == 0 && is_baoming($data->id,$user_id)==0)
                @if($data->is_free==0)
                    <li class="studyBtn" onclick="userlogin()">
                        <a href="javascript:;">免费报名</a>
                    </li>
                @else
                    <li class="studyBtn open-popup" onclick="userlogin()">
                        <a href="javascript:;" id="studyBtn" onclick="userlogin()">立即学习¥{{$data->price}}</a>
                    </li>
                @endif
            @else
                @if(is_baoming($data->id,$user_id) == 1)
                    @if($mobile==0)
                        <li class="studyBtn">
                            <a href="javascript:;" onclick="userlogin()">进入直播间</a>
                        </li>
                    @else
                        <li class="studyBtn">
                            <a href="/course/video/{{$data->id}}/{{$array[0]->course[0]->id}}.html">进入直播间</a>
                        </li>
                    @endif
                @else
                    @if($data->is_free==0)
                        <li class="studyBtn">
                            <a href="javascript:;" id="enroll">免费报名</a>
                        </li>
                    @else
                        <li class="studyBtn open-popup" data-target="#half" id="studyBtn">
                            <a>立即学习¥{{$data->price}}</a>
                        </li>
                    @endif
                @endif
            @endif
        @endif
        <li class="consultBtn" onclick="window.location.href='/course/consultation/{{$data->id}}.html'">
            <a href="javascript:;"></a>
        </li>
    </ul>
</div>
<!-- 底部固定条 end -->

<!-- 底部弹出popup start -->
<div id="half" class='weui-popup__container popup-bottom payType_popup'>
    <div class="weui-popup__overlay"></div>
    <div class="weui-popup__modal">
        <div class="toolbar">
            <div class="toolbar-inner">
                <a href="javascript:;" class="picker-button close-popup">关闭</a>
                <h1 class="title">确认付款</h1>
            </div>
        </div>
        <div class="modal-content bgc_white">
            <div class="weui-cell  weui-cell">
                <div class="weui-cell__bd">
                    <h2 class="fs14">课程费用</h2>
                </div>
                <div class="weui-cell__ft">
                    <span class="price">{{$data->price}}元</span>
                </div>
            </div>
            <div class="weui-cells weui-cells_radio noafter">
                <label class="weui-cell weui-check__label" for="x11">
                    <div class="weui-cell__bd">
                        <p><i class="ico_wx"></i>微信支付</p>
                    </div>
                    <div class="weui-cell__ft">
                        <input type="radio" class="weui-check" name="radio1" id="x11" value="WXPAY" checked />
                        <span class="weui-icon-checked"></span>
                    </div>
                </label>
                @if($balance)
                    <label class="weui-cell weui-check__label" for="x12">
                        @else
                            <label class="weui-cell weui-check__label disabled_xueyuan" for="x12">
                                @endif
                                <div class="weui-cell__bd">
                                    <p><i class="ico_balance"></i>余额支付</p>
                                </div>
                                <div class="weui-cell__ft">
                                    <input type="radio" name="radio1" class="weui-check" id="x12" value="BANLANCE">
                                    <span class="weui-icon-checked"></span>
                                </div>
                            </label>
                            @if($spb/100 > $data->price)
                                <label class="weui-cell weui-check__label" for="x13">
                                    @else
                                        <label class="weui-cell weui-check__label disabled_xueyuan" for="x13">
                                            @endif
                                            <div class="weui-cell__bd">
                                                <p><i class="ico_spb"></i>{{$data->price * 100}}赛普币(已有{{$spb}}赛普币)</p>
                                            </div>
                                            <div class="weui-cell__ft">
                                                <input type="radio" name="radio1" class="weui-check" id="x13" value="SPB">
                                                <span class="weui-icon-checked"></span>
                                            </div>
                                        </label>
            </div>
            <div class="container pt15 pb15">
                <a href="javascript:void(0);" class="roy_btn bgc_yellow payBtn" data-is_weixin="{{$is_weixin}}">立即付款</a>
            </div>
        </div>
    </div>
</div>
<!-- 底部弹出popup end -->

<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
    $(function() {
        FastClick.attach(document.body);
    });
</script>
<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<!--<script src="/js/jweixin-1.4.0.js"></script>-->

<script src="http://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
<script type="text/javascript">
    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: "{{$WechatShare['appId']}}", // 必填，公众号的唯一标识
        timestamp: "{{$WechatShare['timestamp']}}", // 必填，生成签名的时间戳
        nonceStr: "{{$WechatShare['noncestr']}}", // 必填，生成签名的随机串
        signature: "{{$WechatShare['signature']}}",// 必填，签名
        jsApiList: [
            'updateAppMessageShareData',
            'updateTimelineShareData'
        ] // 必填，需要使用的JS接口列表
    });
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.updateAppMessageShareData({
            title: '{{$data->title}}', // 分享标题
            desc: '{{$data->seo_description}}', // 分享描述
            link: "{{$WechatShare['url']}}&fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "{{env('IMG_URL')}}{{$data->cover_url}}", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用

        wx.updateTimelineShareData({
            title: '{{$data->title}}', // 分享标题
            link: "{{$WechatShare['url']}}&fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "{{env('IMG_URL')}}{{$data->cover_url}}", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });

</script>
<script>
    var user_id   = "{{$user_id}}";      //用户id
    var c_c_id    = "{{$data->id}}";     //课程id
    var is_weixin = "{{$is_weixin}}";  //是否为微信浏览器
    var token     = '{{csrf_token()}}';
    var video_id  = "{{$array[0]->course[0]->id}}";
    var mobile    = "{{$mobile}}";
    var subscribe = "{{$subscribe}}";

    //免费报名成功或者购买成功后跳转
    function href_go(){
        //判断是否关注公众号如果未关注跳转引导页
        if(subscribe){
            location.href="/course/video/"+c_c_id+"/"+video_id+".html";
        }else{
            location.href="/course/middle/"+c_c_id+"/"+video_id;
        }

    }

    //跳转登陆函数
    var userlogin = function(){
        var url = "/course/detail/"+c_c_id+".html";
        localStorage.setItem("redirect", url);

        layer.msg('请先注册');
        setTimeout(function(){
            window.location.href = "/register";
        }, 500)
    }



    //调用微信JS api 支付
    function jsApiCall()
    {
        var _token = '{{csrf_token()}}';
        var data = {class_id:c_c_id,_token:_token};
        $.ajax({
            url:'/course/buy',
            data:data,
            type:'POST',
            dateType:'json',
            success:function(res){

                if(res.code != 0){
                    layer.msg(res.message);
                    return false;
                }else{
                    var data = res.data;
                }
                WeixinJSBridge.invoke(
                        'getBrandWCPayRequest',
                        data,
                        function(res){
                            WeixinJSBridge.log(res.err_msg);
                            if(res.err_msg=='get_brand_wcpay_request:ok'){
                                layer.msg('支付成功');
                                href_go();     //支付成功跳转
                            }else{
                                layer.msg('取消支付');
                            }
                        }
                );
            }
        })

    }
    //关注公众号函数
    var follow_us = function(){
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'bm_success_layer_wrap', //样式类名
            id: 'bm_success_layer', //设定一个id，防止重复弹出
            closeBtn: 0, //不显示关闭按钮
            anim: 2,
            shadeClose: true, //开启遮罩关闭
            area: ['80%', '70%'],
            content:'<div class="bm_success_layer"><img src="/images/bm_success.png" class="bm_success" alt="" /><dl><dt><img src="/images/qr.png" alt="" /></dt><dd>扫描二维码获得课程提醒</dd></dl><a href="/course/video/'+c_c_id+'/'+video_id+'.html">关闭</a></div>',
            btn:false
        });
    }
    $(function (){
        //折叠面板
//        $('.toggleBox .item h3').click(function (){
//            if($(this).next().hasClass('block')){
//                return false;
//            }else{
//                $(this).next().addClass('block').parents('.item').siblings().find('ul').removeClass('block');
//                $(this).find('i').addClass('up').parents('.item').siblings().find('i').removeClass('up');
//            }
//        })
        $('#accordion .link').click(function (){
            if($(this).parents('li').hasClass('open')){
                $('#accordion >li').removeClass('open')
                /*return false;*/
            }else{
                $(this).parents('li').addClass('open').siblings().removeClass('open');
                $(this).find('i').addClass('up').parents('.item').siblings().find('i').removeClass('up');
            }
            var h=$('#accordion').height()
            console.log($('.open .submenu').height())
            $('.tempWrap').height(h)
        })
        //不支持试看视频
        $(".no_preview").click(function(){
            $.closePopup()
            $.confirm({
                title: '提示',
                text: '立即购买学习该课程，确认购买吗？',
                onOK: function () {

                    $('#studyBtn').trigger('click');
                },
                onCancel: function (){

                }
            });

        });

        //立即付款弹出框
        $('.payBtn').click(function (){
            var payfrom = $("input[name='radio1']:checked").val();
            if(payfrom=='BANLANCE'){
                $.closePopup()
                $.confirm({
                    title: '提示',
                    text: '立即购买学习该课程，确认购买吗？',
                    onOK: function () {
                        //点击确认
                        $.ajax({
                            type:"GET",
                            url:"/course/paybalance",
                            data:{c_c_id:c_c_id, user_id:user_id},
                            dataType:"json",
                            success:function(result){
                                if(result.code==1){
                                    layer.msg(result.msg);
                                    setTimeout(function(){
                                        href_go();     //支付成功跳转
                                    },1500)  //延迟1.5秒刷新页面
                                }else{
                                    layer.msg(result.msg);
                                }
                            }
                        });
                    },
                    onCancel: function (){
                    }
                });
            }else if(payfrom=="WXPAY"){
                //alert(is_weixin);
                if(is_weixin==1){
                    jsApiCall();
//				layer.msg('微信浏览器');
                }else{
                    $.ajax({
                        type:"POST",
                        url:"/course/payh",
                        data:{course_class_id:c_c_id,_token:token},
                        dataType:"json",
                        success:function(result){
                            if(result.code==1){
                                console.log(result.objectxml.mweb_url);
                                //follow_us();
                                window.location.href=result.objectxml.mweb_url;   //h5呼叫微信支付
                            }else{
                                layer.msg(result.msg);
                            }
                        }
                    });
                }
            }else if(payfrom == "SPB"){
                $.closePopup()
                $.confirm({
                    title: '提示',
                    text: '立即购买学习该课程，确认购买吗？',
                    onOK: function () {
                        $.ajax({
                            type:"get",
                            url:"/course/paySpb",
                            data:{c_c_id:c_c_id,user_id:user_id},
                            dataType:"json",
                            success:function(data){
                                console.log(data);
                                if(data.code == 1){
                                    layer.msg(data.msg);
                                    setTimeout(function(){
                                        href_go();     //支付成功跳转
                                    },1500)  //延迟1.5秒刷新页面
                                }else{
                                    layer.msg(data.msg);
                                }
                            }


                        })
                    },
                    onCancel: function (){
                    }
                });
            }

        })

        //收藏课程或取消收藏  20180827
        $("#wei_shoucang").click(function(){
            var id = $("#wei_shoucang").attr("data-attr");
            //var user_id = '{{$user_id}}';
            if(mobile<1){
                userlogin();  //跳转登陆
                return;
            }
            var is_collect = $("#wei_shoucang").attr("data-collect");
            if(id){
                if(is_collect==1){
                    $.get("/course/nocollect",{course_class_id:id,user_id:user_id},function(result){
                        if(result){
                            //$("#wei_shoucang").removeAttr("data-attr");
                            $("#wei_shoucang").attr("src", "/images/shoucang.png");
                            $("#wei_shoucang").attr("data-collect", "0");
                            layer.msg('已取消');
                        }
                    })
                }else{
                    $.get("/course/collect",{course_class_id:id,user_id:user_id},function(result){
                        if(result){
                            //$("#wei_shoucang").removeAttr("data-attr");
                            $("#wei_shoucang").attr("src", "/images/yishoucang.png");
                            $("#wei_shoucang").attr("data-collect", "1");
                            layer.msg('已收藏');
                        }
                    })
                }
            }
        });

        //免费报名课程
        $("#enroll").click(function(){
            var id = '{{$data->id}}';
            var user_id = '{{$user_id}}';
            $.get("/course/enroll",{course_class_id:id,user_id:user_id},function(result){
                if(result == 0){
                    layer.msg('报名成功');

                    setTimeout(function(){
                        href_go();     //支付成功跳转
                    },1500)  //延迟1.5秒
                }else{
                    layer.msg('网络错误，稍后请重试');
                }
            })
        })
    })
</script>

<script>
    //跳转到课程播放页面
    var go_video  = function (c_c_id, video_id){
        window.location.href="/course/video/"+c_c_id+"/"+video_id+".html";
    }
</script>
<script type="text/javascript" >
    function menuFixed(id){
        var obj = document.getElementById(id);
        var _getHeight = obj.offsetTop;

        window.onscroll = function(){
            changePos(id,_getHeight);
        }
    }
    function changePos(id,height){
        var obj = document.getElementById(id);
        var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        if(scrollTop < height){
            obj.style.position = 'relative';
        }else{
            obj.style.position = 'fixed';
        }
    }
</script>
<script type="text/javascript">
    window.onload = function(){
        menuFixed('nav_keleyi_com');
    }
</script>

<script type="text/javascript">
    TouchSlide({ slideCell:"#leftTabBox",
        endFun:function(i){ //高度自适应
            var bd = document.getElementById("tabBox1-bd");
            bd.parentNode.style.height = bd.children[i].children[0].offsetHeight+"px";
            if(i>0)bd.parentNode.style.transition="200ms";//添加动画效果

        }
    });
</script>
</body>
</html>
