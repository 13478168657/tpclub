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
	<title>赛普社区-产后实践-报名成功</title>
	<meta name="author" content="啾啾" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<!--mmenu.css start-->
	<link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
	<link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
	<link href="/css/nav-mmenu-public.css" rel="stylesheet" />
	<!--end-->
	<link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" >

	<!--本css-->
	<link rel="stylesheet" href="/css/zt/zt_chanhoushijian.css">

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
				<li><a href="/article/0.html">文章</a></li>
				<li><a href="/cak/1.html">问答</a></li>
				<li><a href="/user/studying">我的课程</a></li>
				<li><a href="/user/index">我的</a></li>
                <li><a href="javascript:history.go(-1);">返回</a></li>
                @if(!is_weixin())
                    @if($user)
                        <li><a href="/logout">退出</a></li>
                    @else
                        <li><a href="/register">注册/登录</a></li>
                    @endif
                @endif
                </ul>
			</ul>
		</div>
	</nav>
	<!--头部导航 end-->


	<!--报名成功 start-->
	<div class="bg_fdf3cc ptblr44">
		<div class="bgcolor_fff border-radius-img text_center bsplr">
			<p class="f54 color_be3f00 pb15">恭喜您</p>
			<p class="f54 color_be3f00 mb80">报名成功</rb></p>
			<img src="/images/zt/group-er1.png" alt="">
			<p class="f26 fz mt32">长按识别添加班主任微信</p>
			<p class="f26 fz">班主任将拉您加入<span class="color_be3f00">线上班级群</span></p>
			<p class="f30 fz pt140">添加好友备注报名<span class="color_be3f00">课程及期数</span></p>
			<p class="f30 fz">例如：产后实战第1期</p>
		</div>
	</div>
	<!--报名成功 end-->

</div><!--导航大盒子id=page 结束-->



<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>

<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->



</body>
</html>
