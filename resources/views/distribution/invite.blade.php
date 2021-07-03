@extends('layouts.header')
@section('title')
<title>赛普社区-邀请的人</title>
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
	<div class="nav_list text_center">
		<ul class="clearfix fz f28">
			<li><a href="/distribution/invite/0.html" class="color_gray666 @if($status == 0) on @endif">全部({{$all_num}})</a></li>
			<li><a href="/distribution/invite/1.html" class="color_gray666 @if($status == 1) on @endif">已预定({{$num}})</a></li>
			<li><a href="/distribution/invite/2.html" class="color_gray666 @if($status == 2) on @endif">已入校({{$entrance_num}})</a></li>
		</ul>
	</div>
	<div class="mlr30">
		<div class="list_guwen">
			<ul class="data_list">
				@if(count($data)>0)
				@foreach($data as $v)
					<li class="ptb30">
						<div class="weui-cell noafter nobefore padding0">
							<div class="weui-cell__hd">
								<?php
									$user = getUsers($v->user_id);
								?>
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
								{{--<p>{{$v->name?$v->name:'匿名'}}</p>--}}
								<p>
									@if(count($user))
										@if($user->nickname == '')
											{{$user->name}}
										@else
											{{$user->nickname}}
										@endif
									@endif
								</p>
							</div>
							<div class="weui-cell__ft fz f26 color_333 time">{{$v->is_reserve == 0?'未预定':'已预定'}}<span class="color_gray9b f20">{{date("Y/m/d",strtotime($v->created_at))}}</span></div>
						</div>
					</li>
				@endforeach
			@endif

			</ul>

		</div>


	</div>
	<br/>
	<div class="nomore f24 color_gray666 text_center ptb50 bgcolor_fff loadmore" onclick="loadmore(this);" data-load = 0>加载更多</div>

	<!--====================================本喵是分割线  喵喵~========================================================-->


	<!--====================================本喵是分割线  喵喵~========================================================-->


	<!--====================================本喵是分割线  喵喵~========================================================-->

	<!--====================================本喵是分割线  喵喵~========================================================-->

	<!--====================================本喵是分割线  喵喵~========================================================-->
</div><!--导航大盒子id=page 结束-->



<br><br><br><br>


<script>
 var i = 2;
 var _token   = '{{csrf_token()}}';
 var status = "{{$status}}";
 function loadmore(obj){
	 var loaddata = obj.getAttribute("data-load");
	 if(loaddata == 0){
		 $.ajax({
			 url : '/distribution/loadmoreinvite',
			 type : 'post',
			 dataType : 'json',
			 data : {page:i,status:status,_token:_token},
			 success : function (data) {
				 console.log(data);
				 if(data.body == ''){
					 layer.msg("加载完成哦~");
					 $(".loadmore").text("加载完成");
					 $(".loadmore").attr("data-load",1);
				 }else{
					 $(".data_list").append(data.body);
					 $('.tempWrap').css('height','auto');

				 }
				 i++;
			 }
		 });
	 }else{
		 layer.msg("加载已完成哦~");
	 }
 }
</script>
@endsection
