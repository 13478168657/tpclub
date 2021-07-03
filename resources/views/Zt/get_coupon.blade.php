<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
<title>赛普社区-领取优惠劵</title>
<meta name="author" content="涵涵" />
<meta name="keywords" content="" />
<meta name="description" content="" />
	<!-- Link Swiper's CSS -->
	<link rel="stylesheet" href="../css/swiper.min.css">
	<!--mmenu.css start-->
<link href="../lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
<link href="../lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
<link href="../css/nav-mmenu-public.css" rel="stylesheet" />
	<!--end-->

	<!--jqweui css-->
	<link href="../lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
	<link href="../lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
	<!--end -->

<link href="../css/reset.css" rel="stylesheet" type="text/css" />
<link href="../css/font-num40.css" rel="stylesheet" >

	<!--本css-->
	<style>
		/*领取优惠劵*/
		.cFA6C11{color: #FA6C11;}
		.bgCg{background: url("../images/zt/Group4.png")no-repeat top center;background-size: 100% 100%;height: 5.025rem;}
		.Cg ul li{height: 5.025rem;}
		.Cg ul li:first-child{width: 68%}
		.Cg ul li:last-child{width: 32%;line-height: 5.025rem;}
		.Cg ul li:first-child p:first-child{padding-top: 1.3rem;}
		.btnBs{display: block;height:2.175rem;line-height: 2.175rem;width: 80%;border: none;margin: 1.5rem auto 0;}
	</style>


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
				<li><a href="/user/studying">正在学习</a></li>
				<li><a href="/user/index">我的</a></li>
			</ul>
		</div>
	</nav>
	<!--头部导航 end-->

	<!--====================================本喵是分割线  喵喵~========================================================-->
	<div class="bgCg Cg mlr30 mt30">
		<ul class="clearfix text_center">
			<li class="fl fz">
				<p class="f34 cFA6C11 bold">优惠劵</p>
				<p class="f26 color_4a">产后实战精英私教训练营</p>
			</li>
			<li class="fr f54 cFA6C11 ">50元</li>
		</ul>
	</div>
	<!--按钮-->
	@if($is_get == 0)
		<button  class="btnBs border-radius-img color_333 f34 fz bgcolor_orange text_center mt60 btn_submit">立即领取</button>
		@else
		<button  class="btnBs border-radius-img color_333 f34 fz bgcolor_orange text_center mt60" onclick="window.location.href='/train/study.html?id={{$course_class_group_id}}'">立即领取</button>
	@endif
	<p class="fz f26 color_gray999 text_center mt10">优惠券领取后有效期为10天，请及时领取</p>
	<!--====================================本喵是分割线  喵喵~========================================================-->

</div><!--导航大盒子id=page 结束-->

<br><br>
<script src="../js/jquery-1.11.2.min.js"></script>
<script src="../lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="../lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="../lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="../lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->
<script>
	var token = '{{csrf_token()}}';
	$('body').addClass('bgcolor_gray');

	$(function(){
		//提示层
		//layer.msg('领取成功');
	})
	var data = {_token:token};
	$(".btn_submit").click(function(){
		$.ajax({
			url:'/zt/getcoupona',
			type:'POST',
			data:data,
			dataType:'json',
			success:function(res){
				console.log(res);
				layer.msg(res.message);
				window.location.href="/train/study.html?id="+res.course_class_group_id;

			}
		});
	})
</script>
</body>
</html>
