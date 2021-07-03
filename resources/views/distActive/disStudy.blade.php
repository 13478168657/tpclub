<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-正在学习</title>
    <meta name="author" content="啾啾" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <!--mmenu.css start-->
    <link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
    <link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
    <link href="/css/nav-mmenu-public.css" rel="stylesheet" />
    <!--end-->
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" />
    <script src="/js/jquery-1.11.2.min.js"></script>
    <script src="/js/jquery.SuperSlide.2.1.1.js" type="text/javascript"></script>
    <!--本css-->
    <link rel="stylesheet" href="/css/fenxiaoliucheng.css?t=1.2" >


    <style>
        .Img{width: 56%;display: block;margin: 0 auto;}
        .plr98{padding-left: 2.45rem;padding-right: 2.45rem;}
        .ptb50{padding-top: 1.25rem;padding-bottom: 1.25rem;}
        .fL{border: 1px solid rgba(250,108,17,0.40);}
        .fL h3{background: rgba(250,108,17,0.10);color: #FA6C11;height: 2.5rem;line-height: 2.5rem;}

    </style>
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

<!---导航右侧带导航弹出---->

<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->

    <!--头部导航 start-->
    <div class="mh-head Sticky">

        <div class=" menu-bg-logo">
			<span class="mh-btns-left">
				<a class="icon-menu icon-sousuo" href="javascript:;"></a>
			</span>
			<span class="mh-btns-right">
				<a class="icon-menu" href="#menu"></a>
				<a class="icon-menu" href="#page"></a>
			</span>
        </div>
    </div>

    <!--隐藏导航内容-->
    <nav id="menu">
        <div class="text_center  fz">
            <ul>
                <li><a href="/">首页</a></li>
                <li><a href="/user/studying">正在学习</a></li>
                <li><a href="/user/index">我的</a></li>
                <li><a href="javascript:history.go(-1);">返回</a></li>
            </ul>
        </div>
    </nav>
    <!--头部导航 end-->

    <!--====================================本喵是分割线  喵喵~========================================================-->

    <!--脖子 start-->
    <div class="plr30 bbtom20">
        <div class="pt70 fz study_head">
            <h3 class="f36 color_333 bold">{{$disCourseClass->title}}</h3>
            <p class="f26 mt30	mb30"><a href="javascript:void (0)" class="color_orange open-popup" data-target="#full">加入线上交流群<img src="/images/fenxiaoliucheng/ico_right.png" alt="" class="ico_right_stu"></a></p>
            {{--<p class="f26 color_gray999 mb40">2019.03.13-2019.03.23</p>--}}
                    <!-- <p class="f26 color_gray666 mb40">共{{$disCourseClass->course_num}}课 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;已打卡完成{{$cardTotal?$cardTotal:0}}课</p> -->
        </div>
    </div>
    <!--脖子 end-->
    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--列表 start-->
    <div class="study plr30">
        <div>
            <ul>
                @foreach($disCoursePlayRecords as $playRecord)

                    <?php
                        $is_jiesuo = 0;
                        if($playRecord->datetime <= $nowTime){
                            logger()->info(333);
                            $is_jiesuo = 1;
                        }
                    ?>
                    <li class="ptb30">
                        @if($is_jiesuo == 1)
                            <a href="/dist/finish/{{$playRecord->dis_course_class_id}}/{{$playRecord->dis_course_id}}.html">
                        @else
                            <a onclick="javascript:void(0);">
                        @endif
                            <dl class="clearfix">
                                <dt class="fl relative border-radius-img">
                                    <img src="{{env('IMG_URL')}}/{{$playRecord->disCourse?$playRecord->disCourse->cover_url:""}}" alt="" class="border-radius-img">
                                @if($is_jiesuo == 0)
                                <p>
                                    <span class="position_jiesuo_mask"></span>
       <span class="position_jiesuo text_center color_fff ">
          未解锁<img src="/images/icon_shipin.png" alt="" class="d-in-black">
       </span>
                                </p>
                                @endif
                                </dt>
                                <dd class="fl relative fz">
                                    <h3 class="text-overflow2 f30 color_333">{{$playRecord->disCourse?$playRecord->disCourse->title:''}}</h3>
                                    <!-- <p class="f26 color_gray999">{{date('Y.m.d',$playRecord->datetime)}}<span class="fr f26 color_333">{{$playRecord->is_play?'已打卡':'未打卡'}}</span></p> -->
                                </dd>
                            </dl>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <!--列表 end-->
    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--====================================本喵是分割线  喵喵~========================================================-->
</div><!--导航大盒子id=page 结束-->
<!-- popup -->
<div id="full" class='weui-popup__container bgcolor_fff ask_popup' style="z-index: 9999!important;">
    {{--@if($disCourseClass->id <=14)--}}
        {{--<div class="weui-popup__overlay"></div>--}}
        {{--<div class="weui-popup__modal bgcolor_fff" >--}}
            {{--<!-- 头部条 start -->--}}
            {{--<header class="header_bar2 max750 relative plr30 pt40">--}}
                {{--<a href="javascript:;" class="btn_cancel color_gray999 f28 fz">关闭</a >--}}
            {{--</header>--}}
            {{--<!-- 头部条 end -->--}}
            {{--<!-- 表单区 start -->--}}
            {{--<div>--}}
                {{--<img src="/images/zt/asszhuli/zhuli4.png" alt="">--}}
            {{--</div>--}}

            {{--<!-- 表单区 end -->--}}
        {{--</div>--}}
    {{--@elseif($disCourseClass->id == 15)--}}
        <div class="weui-popup__overlay"></div>
        <div class="weui-popup__modal bgcolor_fff" >
            <!-- 头部条 start -->
            <header class="header_bar2 max750 relative plr30 pt40">
                <a href="javascript:;" class="btn_cancel color_gray999 f28 fz">关闭</a >
            </header>
            <!-- 头部条 end -->
            <!-- 表单区 start -->
            <div class="plr98 text_center mt30 pt30">

                <img class="Img" src="{{env('IMG_URL')}}{{$disCourseClass->wx_group_url}}" alt="">
                <div class="ptb30 fz f30 color_333 bold">
                    <p>识别二维码添加管理员</p>
                    <p>管理员拉您进专属班级群</p>
                    <p class="bgcolor_orange d-in-black plr30 pt10 pb10 border-radius50 mt30">回复：{{$disCourseClass->teacher_remark}}</p>
                </div>

                <div class="fL fz">
                    <h3 class="f30 fz bold"> • 进群福利 • </h3>
                    <div class="ptb50 fz f30 color_333 bold">
                        <p class="pb20">专业老师在线答疑</p>
                        <p class="pb20">每日健身知识分享</p>
                    </div>
                </div>
            </div>
        </div>
    {{--@elseif($disCourseClass->id== 16)--}}
        {{--<div class="weui-popup__overlay"></div>--}}
        {{--<div class="weui-popup__modal bgcolor_fff" >--}}
            {{--<!-- 头部条 start -->--}}
            {{--<header class="header_bar2 max750 relative plr30 pt40">--}}
                {{--<a href="javascript:;" class="btn_cancel color_gray999 f28 fz">关闭</a >--}}
            {{--</header>--}}
            {{--<!-- 头部条 end -->--}}
            {{--<!-- 表单区 start -->--}}
            {{--<div class="plr98 text_center mt30 pt30">--}}

                {{--<img class="Img" src="{{env('IMG_URL')}}{{$disCourseClass->wx_group_url}}" alt="">--}}
                {{--<div class="ptb30 fz f30 color_333 bold">--}}
                    {{--<p>识别二维码</p>--}}
                    {{--<p>进入您的专属班级群</p>--}}
                    {{--<p class="bgcolor_orange d-in-black plr30 pt10 pb10 border-radius50 mt30">回复：体能</p>--}}
                {{--</div>--}}

                {{--<div class="fL fz">--}}
                    {{--<h3 class="f30 fz bold"> • 进群福利 • </h3>--}}
                    {{--<div class="ptb50 fz f30 color_333 bold">--}}
                        {{--<p class="pb20">专业老师在线答疑</p>--}}
                        {{--<p class="pb20">每日健身知识分享</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--@endif--}}
</div>

<br><br>
<script src="/js/jquery-1.11.2.min.js"></script>
{{--<script src="/lib/jqweui/js/fastclick.js"></script>--}}
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    var title = '';
    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: "{{$WechatShare['appId']}}", // 必填，公众号的唯一标识
        timestamp: "{{$WechatShare['timestamp']}}", // 必填，生成签名的时间戳
        nonceStr: "{{$WechatShare['noncestr']}}", // 必填，生成签名的随机串
        signature: "{{$WechatShare['signature']}}",// 必填，签名
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
        ] // 必填，需要使用的JS接口列表
    });
    var desc    = '{{$disCourseClass->seo_desc}}';
    var title   = '{{$disCourseClass->title}}';
    var user_id = '{{$user_id}}';
    var dis_id = '{{$dis_id}}';
    // var link = 'http://m.saipubbs.com/dist/buy/{{$disCourseClass->id}}.html?dis='+dis_id;   助理活动临时替换
    var link = 'http://m.saipubbs.com/dist/study/{{$disCourseClass->id}}.html';
    var imgUrl = '{{env('IMG_URL')}}/{{$disCourseClass->cover_url}}';
    var content = '';
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: imgUrl, // 分享图标
            success: function(){
                /*----分享获得赛普币end----*/
            },
            cancel:function(){

            }
        }, function(res) {
            //这里是回调函数

        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: title, // 分享标题
            link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: imgUrl, // 分享图标
            success: function(){


            },
            cancel:function(){

            }
        }, function(res) {
            //这里是回调函数

        });
    });
    $('.btn_cancel').click(function (){
        $.closePopup();//关闭弹出框
    })
</script>
</body>
</html>
