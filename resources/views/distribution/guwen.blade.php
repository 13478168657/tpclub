@extends('layouts.header')
@section('title')
<title>赛普社区-我的课程顾问</title>
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
		<div class="list_guwen">
			<ul>
				@foreach($guwen as $v)
					<?php
					$user = getUsers($v['user_id']);
					?>
				<li class="ptb30">
					<div class="weui-cell noafter nobefore padding0">
						<div class="weui-cell__hd">
							@if(count($user)>0)
								@if(strpos($user->avatar,'http') !== false)
									<img src="{{$user->avatar}}" class="border-radius50">
								@else
									<img src="{{env('IMG_URL')}}{{$user->avatar}}" class="border-radius50">
								@endif
							@else
								<img src="/images/daoshi-t-img.jpg" class="border-radius50">
							@endif

						</div>
						<div class="weui-cell__bd fz f32 color_333 bold">
							<p>{{$v['name']}}</p>
						</div>
						<div class="weui-cell__ft fz f26 color_333">已邀请{{$v['num']}}人</div>
					</div>
				</li>
				@endforeach

			</ul>

		</div>


	</div>

	<!--====================================本喵是分割线  喵喵~========================================================-->


	<!--====================================本喵是分割线  喵喵~========================================================-->


	<!--====================================本喵是分割线  喵喵~========================================================-->

	<!--====================================本喵是分割线  喵喵~========================================================-->

	<!--====================================本喵是分割线  喵喵~========================================================-->
</div><!--导航大盒子id=page 结束-->



<br><br><br><br>


<script>

</script>
@endsection
