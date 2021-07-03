<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-{{$distClass->title}}</title>
    <meta name="author" content="赛普健身社区" />
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
    <!--本css-->

    <link rel="stylesheet" href="/css/fenxiaoliucheng_clock.css" >


    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
</head>
<body ontouchstart>

<!---导航右侧带导航弹出---->
<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->

    <!--头部导航 start-->
    <!-- <div class="mh-head Sticky">

        <div class=" menu-bg-logo">
			<span class="mh-btns-left">
				<a class="icon-menu icon-sousuo" href="javascript:;"></a>
			</span>
			<span class="mh-btns-right">
				<a class="icon-menu" href="#menu"></a>
				<a class="icon-menu" href="#page"></a>
			</span>
        </div>
    </div> -->

    <!--隐藏导航内容-->
    <!-- <nav id="menu">
        <div class="text_center  fz">
            <ul>
                <li><a href="/">首页</a></li>
                <li><a href="/user/studying">正在学习</a></li>
                <li><a href="/user/index">我的</a></li>
                <li><a href="javascript:history.go(-1);">返回</a></li>
            </ul>
        </div>
    </nav> -->
    <!--头部导航 end-->

    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--banner start-->
    <div>
        <img src="{{env('IMG_URL')}}/{{$distClass->head_url}}" alt="">
    </div>
    <!--banner end-->

    <!--====================================本喵是分割线  喵喵~========================================================-->
    <div class="bgcolor_000 sp pb92 pt70">
        <p class="fz color_fff bold text_center f34 border-radius50">课程试看</p>
        <!--视频 start-->
        <div class="plr30 pt40">
            <div class="video">
                <div class="box2">
                    <img src="{{env('IMG_URL')}}/{{$distClass->cover_url}}" alt=""/>
                    <div class="mask"></div>
                    <span class="btn_play"></span>
                </div>
                <video id="video" src="{{$distClass->video_url}}"></video>
            </div>
        </div>
        <!--视频 end-->
        <span class="block fz f30 pt40 color_fff text_center">{{$distClass->video_title}}</span>
    </div>
    <div class="bgcolor_000">
        <p class="text_center color_orange f26 fz mlr30 zhan-lie ptb65 btn_open">点击查看全部课程内容 <img src="/images/clock/jiant.png" alt="" class="j-img"></p>
        <div class="imgs hide">
            <img src="{{env('IMG_URL')}}/{{$distClass->course_desc}}" class="img100" />
        </div>
    </div>
    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--微信二维码 start-->
    <div class="text_center wxin" id="j_weixin">
       <div class="bgw1">
          <p class="fz bold f40 color_000 pb60">添加老师微信</p >
          <p class="fz f26 color_fff">为您发送<span class="bold">《{{$distClass->title}}》</span></p >
       </div>
       <div class="bgw2 fz f22">
          <img src="{{env('IMG_URL')}}/{{$disForm->wx_img}}" alt="">
          <p class="bold f32 mt30">备注：{{$distClass->teacher_remark}}</p >
          <p class="pt10">长按二维码添加老师微信</p >
          <p>名额有限、30分钟内添加有效</p >
       </div>
       <img src="/images/clock/bg_wx3.jpg" alt="">
    </div>
    <div id="" class="">
        <img src="{{env('IMG_URL')}}/{{$distClass->inc_url}}" alt="">
        <!-- <div class="pos2img">
            <img src="{{env('IMG_URL')}}/{{$disForm->wx_img}}" alt="">
        </div> -->
    </div>
    <!--微信二维码 end-->
    <!--====================================本喵是分割线  喵喵~========================================================-->

    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--悬浮btn start-->
    <div class="relative top_weixin">
        <a href="javascript:void (0)" class="block fz bold f32 text_center color_fff">添加微信咨询</a>
    </div>
    <!--悬浮btn end-->
    <!--====================================本喵是分割线  喵喵~========================================================-->




    <br><br><br><br><br><br>

<script src="/lib/jqweui/js/fastclick.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->

<script>
    $('body').addClass('bgcolor_fff3bd');

    $(function() {

        //视频
        $('.video .box2').click(function(){
            $(this).hide();
            $(this).next().trigger('play');

        });

        //展开
        $('.btn_open').click(function (){
            $(this).hide();
            $(this).siblings().show();
        })


        //当点击悬浮按钮后，回到页面微信位置
        $(".top_weixin").click(function() {
            $('body,html').animate({
                        scrollTop: $("#j_weixin").offset().top
                    },
                    1000);
            return false;
        });
    })


</script>

    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript">
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
        var link = 'http://m.saipubbs.com/dist/active/{{$disForm->user_id}}/{{$distClass->id}}.html';
        var title = '{{$distClass->title}}';
        var desc = '{{$distClass->seo_desc}}';
        var img = '{{env('IMG_URL')}}/{{$distClass->cover_url}}';
        wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
            wx.onMenuShareAppMessage({
                title: title, // 分享标题
                desc: desc, // 分享描述
                link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: img, // 分享图标

            }, function(res) {
                //这里是回调函数

            });
        });
        wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
            wx.onMenuShareTimeline({
                title: title, // 分享标题
                link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: img, // 分享图标

            }, function(res) {
                //这里是回调函数

            });
        });
    </script>
</body>
</html>
