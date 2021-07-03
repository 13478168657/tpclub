@extends('layouts.header')
@section('title')

<title>问答专场-赛普知道-健身教练专业问答平台</title>
<meta name="author" content="啾啾" />
<meta name="keywords" content="" />
<meta name="description" content="" />
@endsection

@section('cssjs')
	<!--问答下css-->
<link rel="stylesheet" href="/css/ask.css">



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

<div id="page">
	<!--导航大盒子id=page 开始  【结束在最底部】-->



	<!--===========================================================================================-->
	<!--导航 start-->
	<div class="nav_bar_zt text_center">
		<ul class="clearfix fz f28 color_gray666">
			<li><a href="/cak/1.html">最热</a></li>
			<li><a href="/cak/2.html">待你来答({{sum_common_ask_questions(0)}})</a></li>
			<li><a href="javascript:void(0)" class="cur">问答专场</a></li>
		</ul>
	</div>
	<!--导航 end-->
	<!--===========================================================================================-->
	<div class="bor10"></div>
    <!--创建问答专区 start-->
	<div class="chuangjian plr30">
		<div class="list_chuangjian">
			<ul>
				@if(count($special)>0)
				@foreach($special as $k=>$v)
					<?php
						$remainder = ($k+1)%6;
						$author_users = get_teacher_name($v->user_id);
						$time = time();
						$start_time = $v->start_time;
						$end_time = $v->end_time;
						if($start_time && $end_time){

							$stTime = strtotime($start_time);
							$endTime = strtotime($end_time);

							if($stTime <= $time && $time <= $endTime){
								$courseStage = '问答进行中';
								$flag = 1;
							}elseif($time < $stTime){
								$courseStage = '问答进行中';
								$flag = 1;
							}elseif($time > $endTime){
								$courseStage = '问答已结束';
								$flag = 0;
							}
						}else{
							$courseStage = '问答进行中';
							$flag = 1;
						}
//						dd($start_time,$end_time);
					?>
				<li class="pt30">
					<a href="/ask/answer/{{$v->id}}.html">
						<div class="bg bg_color_{{$remainder}} border-radius-img color_fff relative">
							<dl class="clearfix">
								<dt class="fl">
									@if($author_users)
										@if((strpos($author_users->avatar,'http') !== false))
											<img src="{{$author_users->avatar}}"  class="border-radius50"/>
										@else
											@if($author_users->avatar)
											<img src="{{env('IMG_URL')}}{{$author_users->avatar}}"  class="border-radius50"/>
											@else
											<img class="border-radius50" src="/images/my/nophoto.jpg"/>
											@endif
										@endif
										@else
										<img src="../images/ask/Group.png" alt="" class="border-radius50">
									@endif

								</dt>
								<dd class="fl fz pt14">
									<h3 class="f28 bold">{{$v->title?$v->title:''}}</h3>
									<p class="f26">{{$v->author?$v->author:''}}</p>
									<span class="f20">{{$v->description?$v->description:'暂无简介'}}</span>
								</dd>
							</dl>
							@if($v->is_open)
							<strong class="open_open border-radius50 text_center f14">公开</strong>
							@endif
						</div>
						<div class="zhuanqu_tit pb30 pt20">
							{{--<h3 class="fz bold text-overflow2 f30 color_333 text-jus">{{$v->description}}</h3>--}}
							<div class="zhuanqu_hot clearfix fz f24 color_gray9b pt14">
								<p class="fl">提问{{all_answer_num($v->id,1)}}&nbsp;&nbsp;•&nbsp;&nbsp;回答{{all_answer_num($v->id,2)}}</p>
								{{--<p class="fr">获得认可{{all_answer_num($v->id,3)}}</p>--}}						@if($flag == 1)
									<p class="fr color_orange">问答进行中</p>
								@else
									<p class="fr color_cecece">问答已结束</p>
								@endif
							</div>
						</div>
					</a>
				</li>
				<div class="bor20 mlrfu-30"></div>
				@endforeach
			@endif


			</ul>
		</div>
	</div>
	<!--创建问答专区 end-->
	<!--===========================================================================================-->









</div>
<!--导航大盒子id=page 结束-->


<br><br><br>
<div class="relative">
    <div class="fixed_bottom_4 clearfix">
        <a href="/"><span class="icon-home"></span></a>
        <a href="/article/0.html"><span class="icon-find"></span></a>
        <a href="/cak/1.html" class="on"><span class="icon-ask"></span></a>
        <a href="/user/studying"><span class="icon-study"></span></a>
        <a href="/user/index"><span class="icon-my"></span></a>
    </div>
</div>

<!--end-->

<script type="text/javascript">

</script>
@endsection
