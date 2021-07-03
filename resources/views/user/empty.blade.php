<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="han"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no"/>
	<title>{{$title}}的课程—空{{env('WEB_TITLE')}}</title>
	<meta name="keywords" content=""/>
	<meta name="description" content=""/>
	<link rel="stylesheet" href="/css/reset.css">
	<link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="/css/xueyuan.css">
	<link rel="stylesheet" href="/css/my.css">
    <link rel="stylesheet" href="/css/footer.css">
	<!--mmenu.css start-->
	<link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
	<link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
	<link href="/css/nav-mmenu-public.css" rel="stylesheet" />
	<!--end-->
	<script src="/js/TouchSlide.1.1.js"></script>	
	<!-- jqweui -->
	<script>
		(function(){
			var html = document.documentElement;
			var hWidth = html.getBoundingClientRect().width;
			html.style.fontSize=hWidth/18.75+'px';
		})()
	</script>
     @include('layouts.baidutongji')
<head>
<body style="background-color: #fff;">
<div class="" id="page">
	<!-- <div class="fixed_bar_top">
        <header class="header_bar bgc_grey relative">
            <a href="javascript:history.go(-1);" class="btn_back"><i></i></a>
            <h1 class="cat">{{$title}}课程列表</h1>
        </header>
    </div> -->
    <!--头部导航 start-->
        <div class="mh-head Sticky">
            <div class=" menu-bg-logo">
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
                </ul>
            </div>
        </nav>
        <!--头部导航 end-->
	<div class="con">
		<div class="empty"><img src="/images/empty.png" alt=""></div>
		<h2 class="fz color_gray666  text_center mt30 pt20">没有找到课程,快去学院看看吧!</h2>
	</div>
</div>
<!-- 底部固定导航条 start -->
<div class="relative">
    <div class="fixed_bottom_4 clearfix">
        <a href="/"><span class="icon-home"></span></a>
        <a href="/article/0.html"><span class="icon-find"></span></a>
        <a href="/user/studying"><span class="icon-study"></span></a>
        <a href="/user/index"><span class="icon-my"></span></a>
    </div>
</div>
<!-- 底部固定导航条 end -->

</body>
<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->
</html>


