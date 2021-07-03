<?php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();
$flag = 0;
if($user && $user->mobile !=''){
    $flag = 1;
}
?>

<!doctype html>
<html lang="en" class="htmlWhite">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    @yield('title')
    <meta name="author" content="赛普课堂" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/reset.css?t=1.21" rel="stylesheet" type="text/css" />
    <link href="/css/head.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/css/font-num40.css">
    <link href="/css/footer.css" rel="stylesheet" type="text/css" />
    <!--mmenu.css start-->
    <link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
    <link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
    {{--<link rel="stylesheet" href="/lib/swiper/swiper.min.css">--}}
    <link href="/css/nav-mmenu-public.css?t=2" rel="stylesheet" />
    <!--end-->
    <script src="/lib/jqweui/js/jquery-2.1.4.js"></script>

    <script src="/js/fonts.js?t={{time()}}"></script>
    @include('layouts.baidutongji')
    @yield('cssjs')
</head>
<body ontouchstart style="background: #fff">
@if(!$flag)
    {{--<div class="relative">--}}
        {{--<div class="right-suspension">--}}
            {{--<a href="/register/access.html"><img src="/images/gift.png" alt=""></a>--}}
        {{--</div>--}}
    {{--</div>--}}
@endif
<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->
    <!--头部导航 start-->
    <div class="mh-head Sticky">
        <div class=" menu-bg-logo">
            <span class="mh-btns-left">
                <a class="icon-menu icon-sousuo" href="/search"></a>
            </span>
            <span class="mh-text menu-list-a text_center bgcolor_fff fz f28 color_gray666">
				<a href="/cak/1.html" class="{{$type == 1?"cur":''}}">最热</a>
                <a href="/cak/2.html" class="{{$type == 2?"cur":''}}">待你来答</a>
                <a href="/ask/specialdetail.html">回答专场</a>
			</span>
            <span class="mh-btns-right">
                    <a class="icon-menu erweima icon-erweima" href="javascript:;"></a>
            </span>
        </div>
    </div>

    <!--隐藏导航内容-->
    <nav id="menu">
        <div class="text_center nav-a">
            <ul>
                <li><a href="/">首页</a></li>
                <li><a href="/article/0.html">文章</a></li>
                <li><a href="/cak/1.html">问答</a></li>
                <li><a href="/user/studying">我的课程</a></li>
                <li><a href="/user/index">我的</a></li>
                <li><a href="javascript:history.go(-1);">返回</a></li>
                @if(!is_weixin())
                    @if($user)
                        <li><a href="/logout">退出</a></li>
                    @else
                        <li><a href="/login">登录</a></li>
                    @endif
                    <li><a href="/register">注册</a></li>
                @endif

            </ul>
        </div>
    </nav>
    <!--头部导航 end-->
    <!-- 头部条 start -->
    @yield('top')
            <!-- 头部条 end -->


    <!-- 主体内容 start -->
    @yield('content')
            <!-- 主体内容 end -->
</div>
</body>

<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
    var date = new Date();
    Y = date.getFullYear();

    M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1);
    D = date.getDate() < 10? '0'+(date.getDate()): date.getDate();
    var dateTime = Y+''+M+''+D;
    var isDiscard = 'isDiscard_'+dateTime;
    var isShow = localStorage.getItem('isDiscard_'+dateTime);

    $(function() {
        FastClick.attach(document.body);
    });

    $(function (){
        //弹窗
        $('.erweima').click(function(){
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'bm_success_layer_wrap', //样式类名
                id: 'bm_success_layer', //设定一个id，防止重复弹出
                closeBtn: 0, //不显示关闭按钮
                anim: 2,
                shadeClose: true, //开启遮罩关闭
                area: ['80%', '70%'],
                content:'<div class="bm_success_layer text_center"><div class="mt30 pt30"><p class="lt bold color_333 f30">识别二维码</p><p class="fz color_gray666 f24 mt10">关注赛普健身社区公众号</p></div><img src="/images/qr.png" class="bm_success" alt="" /><div><p class="lt bold color_333 f30 mt10">更新实时提醒</p><p class="fz color_gray666 f24 mt20">不错过每一次的精彩</p></div></div>',
                btn:false
            });
        });
    })
    $(function (){

        //弹窗
        $('.baomingBtn').click(function(){
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'bm_success_layer_wrap', //样式类名
                id: 'bm_success_layer', //设定一个id，防止重复弹出
                closeBtn: 0, //不显示关闭按钮
                anim: 2,
                shadeClose: true, //开启遮罩关闭
                area: ['80%', '70%'],
                content:'<div class="bm_success_layer text_center"><div class="mt30 pt30"><p class="lt bold color_333 f30">识别二维码</p><p class="fz color_gray666 f24 mt10">关注赛普健身社区公众号</p></div><img src="../images/qr.png" class="bm_success" alt="" /><div><p class="lt bold color_333 f30 mt10">更新实时提醒</p><p class="fz color_gray666 f24 mt20">不错过每一次的精彩</p></div></div>',
                btn:false
            });
        })
    });
</script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<script src="/lib/swiper/swiper.min.js"></script>
