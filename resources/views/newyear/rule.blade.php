@extends('layouts.header_no_menu')
@section('title')
<title>活动规则</title>

@endsection
@section('cssjs')

	<link rel="stylesheet" href="/css/newyear_reset.css">
	<link rel="stylesheet" href="/css/newyear_index.css">
<script>
(function(){
	var html = document.documentElement;
	var hWidth = html.getBoundingClientRect().width;
	html.style.fontSize=hWidth/18.75+'px';
})()
</script>
@endsection

@section('content')
<div class="register_top mb80">
	<a href="javascript:;" class="display"><img src="images/logo.png" alt=""></a>
</div>

<h2 class="sy_b f44 color_333 text_center rule_yao">邀请好友助力<br>赢现金红包和奖品福利</h2>

<div class="bg_f8f8f8 mt70 border-radius-img mlr30 mb40">
	<div class="plr45 pb136 color_333">
		<p class="mt100 sy_b f32">活动时间</p>
		<p class="sy_n f28 color_1515 mb40">活动时间为2019年1月23日-2019年2月19日</p>
		<p>注明：【每个福利仅限前500名用户领取，如奖品提前领完，活动将会提前结束哦~】</p>

		<p class="sy_b f32">如何参与活动</p>

		<p class="sy_n f28 color_1515 mb40">每个福利用户均需邀请相对应数量的好友，即可获得福利。</p>
		<p class="sy_n f28 color_1515 mb40">发起人和助力人限定：福利1新老用户都可参与且仅有1次领取和助力机会，福利2至福利5，老用户有参与活动资格，但不能为好友助力。<span class="f24 color_c93126">领取实物福利须知：福利3和福利4均为实物奖品，年后（2月12日）3-5个工作日奖品会陆续寄出。</span>
		</p>
		<p class="sy_b f32">注意事项</p>
		<p class="sy_n f28 color_1515">1.填写信息请务必准确，否则将无法收到福利哦~</p>
		<p class="sy_n f28 color_1515">2. 大家注意微信公号推出的消息，查看奖品领取进度。</p>
		<p class="sy_n f28 color_1515">3. 如果有任何问题欢迎添加微信：18611262363</p>
		<p class="sy_n f28 color_1515">4.本活动的最终解释权归【赛普健身社区】所有</p>
	</div> 		
</div>

<br><br>

@endsection
