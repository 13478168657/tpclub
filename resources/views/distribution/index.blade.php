@extends('layouts.header')
@section('title')

<title>赛普社区-分销员中心</title>
<meta name="author" content="啾啾" />
<meta name="keywords" content="" />
<meta name="description" content="" />
@endsection

@section('cssjs')
	<!--本css-->
	<link rel="stylesheet" href="/css/fenxiaoliucheng.css" >

<script>
(function(){
	var html = document.documentElement;
	var hWidth = html.getBoundingClientRect().width;
	html.style.fontSize=hWidth/18.75+'px';
})()
</script>
@endsection

@section('content')

<!---导航右侧带导航弹出---->

<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->

	

	<!--====================================本喵是分割线  喵喵~========================================================-->
	<div class="mlr30">

		<p class="box1 text_center fz f42 bold color_F59023 bor-rad100 mtb45">成为课程顾问 &nbsp;&nbsp;一键分享赚佣金</p>


		<div class="fz color_333 mt70 mb30">
			<p class="f32 mb20 bold">什么是课程顾问？</p>
			<span class="f26 text-jus">课程顾问是赛普课程的推广大使，所有的课程顾问都有一个共同的使命：将赛普课程推广给所有需要它的人。</span>

			<p class="f32 bold mb30 mt70">课程顾问的“钱”途</p>
			<img src="/images/fenxiaoliucheng/img1.png" alt="">

			<p class="f26 text-jus color_333 pt20 mb30">课程顾问通过分享分销中心的课程海报或链接带来新用户形成注册都会被记录在邀请列表中，用户成功入校，课程顾问就能获得600-1500元的佣金返现。  </p>
			<div class="txt-s fz f28 color_333 bold pl20 ptb40 mb40">
				<p>初级私教课程：介绍学员成功入校返现600元</p>
				<p>中级私教课程：介绍学员成功入校返现1000元</p>
				<p>高级私教课程：介绍学员成功入校返现1500元</p>
			</div>
		</div>

		<!--招生老师助你征服朋友圈 start-->
		<div class="pb92">
			<p class="fz f32 color_333 bold">招生老师助你征服朋友圈</p>
			<img src="/images/fenxiaoliucheng/zhuanzhang.png" alt="">

			<p class="fz f26 color_333">你只需要分享分销中心的课程，跟单全部由招生老师替你完成，你带来的学员成功入校，招生老师将直接为你返现。</p>
		</div>
		<!--招生老师助你征服朋友圈 end-->
	</div>

	<!--====================================本喵是分割线  喵喵~========================================================-->
	<!--如何成为课程顾问 start-->
	<div class="guwen_he fz text_center color_333 bold f32 color_F59023">如何成为课程顾问</div>

	<div class="">
		<!--====================================本喵是分割线  喵喵~========================================================-->
		<div class="plr30">
			<!--01 关注赛普健身社区公众号 start-->
			<div class="mt70">
				<p class="fz f32 color_333 pb30 bold">01 关注赛普健身社区公众号</p>

				<div id="j_weixin" class="text_center erwema pt70 pb70 bgcolor_orange">
					<img src="/images/share/share-er-1.png" alt="">
					<p class="fz f26 color_333">扫描二维码<br>关注赛普健身社区公众号</p>
				</div>
			</div>
			<!--01 关注赛普健身社区公众号 end-->
		</div>
		<!--====================================本喵是分割线  喵喵~========================================================-->
		<div>
			<!--02 点击菜单栏【分销员中心】 start-->
			<div class="mt70">
				<p class="fz f32 color_333 pb30 bold plr30">02 点击菜单栏【分销员中心】</p>
				<img src="/images/fenxiaoliucheng/category.png" alt="">
			</div>
			<!--02 点击菜单栏【分销员中心】 end-->
		</div>
		<!--====================================本喵是分割线  喵喵~========================================================-->
		<div>
			<!--03 填写申请信息 start-->
			<div class="mt70">
				<p class="fz f32 color_333 pb30 bold plr30">03 填写申请信息</p>
				<img src="/images/fenxiaoliucheng/img4.png" alt="" class="plr-30">
			</div>
			<!--03 填写申请信息 end-->
		</div>
		<!--====================================本喵是分割线  喵喵~========================================================-->
		<div>
			<!--04 收到确认消息，成为课程顾问 start-->
			<div class="mt70">
				<p class="fz f32 color_333 pb30 bold plr30">04 收到确认消息，成为课程顾问</p>
				<img src="/images/fenxiaoliucheng/recieve.png" alt="">
			</div>
			<!--04 收到确认消息，成为课程顾问 end-->
		</div>
	</div>
	<!--如何成为课程顾问 end-->
	
	<!--====================================本喵是分割线  喵喵~========================================================-->
	<!--====================================本喵是分割线  喵喵~========================================================-->
	<!--====================================本喵是分割线  喵喵~========================================================-->
	<!--====================================本喵是分割线  喵喵~========================================================-->
	<div class="relative">
		<a href="javascript:;" class="btn-f text_center bgcolor_orange fz f34 color_333 top_weixin">关注公众号申请课程顾问</a>
	</div>
	<!--====================================本喵是分割线  喵喵~========================================================-->
</div><!--导航大盒子id=page 结束-->



<br><br><br><br>


<script>
	$(function() {
		//当点击悬浮按钮后，回到页面微信位置
		$(".top_weixin").click(function() {
			$('body,html').animate({
						scrollTop: $("#j_weixin").offset().top-250
					},
					500);
			return false;
		});
	});
</script>
@endsection
