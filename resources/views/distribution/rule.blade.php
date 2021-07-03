@extends('layouts.header')
@section('title')
<title>赛普社区-分销规则</title>
<meta name="author" content="啾啾" />
<meta name="keywords" content="" />
<meta name="description" content="" />
@endsection

@section('cssjs')
	<!--本css-->
	<link rel="stylesheet" href="/css/fenxiaoliucheng_clock.css" >

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

<div>
	<!--====================================本喵是分割线  喵喵~========================================================-->
	<div class="plr35 fz color_333">
		<h2 class="pt70 f40 bold">分销规则</h2>
		<h3 class="pt40 pb20 f30 bold">1.转介绍成功可以获得多少佣金？</h3>
		<div class="color_gray666 f24 pb30 text-jus">
			<p>成功转介绍赛普高级私教课程，可获得佣金1500元；</p>
			<p>成功转介绍赛普中级私教课程，可获得佣金1000元；</p>
			<p>成功转介绍赛普初级私教课程，可获得佣金600元。</p>
		</div>

		<h3 class="pt30 pb20 f30 bold">2.如何转介绍？</h3>
		<div class="color_gray666 f24 text-jus">
			<p class="bold f26">方法一：口口相传</p>
			<p>也是之前大部分做转介绍人员采取的方法，每天在朋友圈或者各种微信群发送课程广告，看到有意向或感兴趣的的人就发起攻势。但是纵然微信好友再多，也是有限的。</p>
			<p>要想稳定长久的获得佣金返现，除了要转化身边的人，身边人的身边人也是我们的目标。</p>

			<p class="bold f26 pt30">方法二：分发打卡课</p>
			<p>分发打卡课就是一种能把你身边人的身边人转化的方法。过去我们转介绍分发的都是广告，别人看到就烦，但是分发有内容的训练干货就不一样了，爱好健身的人都会点进来看看。</p>
			<p class="pt30">而我们设计的对赌打卡课程也不会让你白白分发，所有经过你分发而参加对赌打卡课程的用户会记录在你分销名单中。不仅如此，打卡课的关键还在于“打卡”，打卡对应的指令就是“分享”，也就是说经过你分发参加打卡课程的用户，在交付对赌金之后，必须要“分享”才会被视为打卡完成，打卡完成才能获得前期交付的对赌金。</p>
			<p>而通过打卡用户分享再次带来的新用户依然会记录在你的分销名单中。是不是比以前的笨办法能让你拉更多的人头，挣更多的佣金呢~</p>
		</div>

		<h3 class="pt40 pb20 f30 bold">3. 如何分发打卡课？</h3>
		<div class="color_gray666 f24 pb30 text-jus">
			<p><strong class="bold">第一步：</strong>在分销员中心找到你想分发的课程，分享打卡课程海报/链接到朋友圈/微信群或其他渠道。</p>
			<p><strong class="bold">第二步：</strong>将有报名参与打卡挑战的用户加为微信好友，并且拉入课程打卡群。</p>
			<p class="pt20">在打卡群中，你不用负责用户的维系，我们会有专业的运营人员义务辅助你运营好微信群，专业问题方面的解答也会有专业导师负责，让你的转化完成的省时又省力。</p>
		</div>

		<h3 class="pt40 pb20 f30 bold">4. 如何知道转介绍是否成功？</h3>
		<div class="color_gray666 f24 pb30 text-jus">
			<p>你可以在分销列表中查看用户未预定—预定状态，当用户到校后，会有招生老师会主动联系你，给你佣金返还。</p>
		</div>
	</div>
	<!--====================================本喵是分割线  喵喵~========================================================-->
	<!--====================================本喵是分割线  喵喵~========================================================-->
</div><!--导航大盒子id=page 结束-->



<br><br><br>
@endsection
