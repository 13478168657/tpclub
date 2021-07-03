<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
<title>产品体验官招募</title>
<meta name="author" content="涵涵" />
<meta name="keywords" content="" />
<meta name="description" content="" />
	<link href="/css/reset.css" rel="stylesheet" type="text/css" />
	<link href="/css/font-num40.css" rel="stylesheet" >
	<!--本css-->
	<link rel="stylesheet" href="/css/zt/zt_recruit.css">


<script>
(function(){
	var html = document.documentElement;
	var hWidth = html.getBoundingClientRect().width;
	html.style.fontSize=hWidth/18.75+'px';
})()
</script>
</head>
<body>
	<div>

		<div>
			<img src="/images/zt/recruit/topimg.jpg" alt="">
			<!--=============================本喵是分割线 喵喵~===============================================-->
			<div class="text_center">
				<h1 class="fz f25 mb30">赛普健身社区 你的社区你做主</h1>
				<h2 class="f87 fw box-show30 color_000 font-str">产品体验官招募</h2>
			</div>
			<div class="fw font-str1-2 f28 left50 pt40 mb50">
				<p>招募人数：30-50人</p>
				<p>任期：2019年第一季度</p>
			</div>
			<!--=============================本喵是分割线 喵喵~===============================================-->
			<div class="plr35">
				<div class="bgkimg bgkimg1 text_center mb40">
					<h3 class="fz f34 bold mb30"><i></i>产品体验官的权利（任期内）<i></i></h3>
					<p class="fz f24">免费学习平台上所有课程</p>
					<p class="fz f24">加入VIP用户群，大咖导师一对一指导</p>
					<p class="fz f24">免费参与平台线下训练营</p>
					<p class="fz f24">平台周边实物礼品回馈</p>
				</div>

				<div class="bgkimg text_center">
					<h3 class="fz f34 bold mb30"><i></i>产品体验官的责任（任期内）<i></i></h3>
					<p class="fz f24 plr111 text-jus">积极使用赛普健身社区产品，反馈发现的问题，提出优化建议，若有完整的解决思路或者方案最佳，每月最少四条，乐于分享，愿意把赛普健身社区产品分享给身边的小伙伴</p>
				</div>

				<div class="btn text_center  mt70 mb20">
					@if($mobile==0)
					<a href="javascript:;" class="text_center f30 fz bold d-in-black" onclick="userlogin()">参与竞选</a>
					@else
					<a href="/zt/experinfo.html" class="text_center f30 fz bold d-in-black">参与竞选</a>
					@endif
				</div>
			</div>
			<!--=============================本喵是分割线 喵喵~===============================================-->
			<div class="bot-bg text_center">
				<p class="fz bold f24">所有参与竞选的小伙伴均可获得2000赛普币</p>
			</div>
			<!--=============================本喵是分割线 喵喵~===============================================-->
			
			
		</div>
	</div>
</body>
<script src="../../lib/jquery-2.1.4.js" type="text/javascript"></script>
<script src="../../lib/layer/layer.js"></script>
<script type="text/javascript">
	var userlogin = function(){
		var url = "/zt/experinfo.html";
		localStorage.setItem("redirect", url);

		layer.msg('请先注册');
		setTimeout(function(){
			window.location.href = "/register";
		}, 500)
	}
</script>

</html>
