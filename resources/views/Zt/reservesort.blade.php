@extends('layouts.header')
@section('title')
	<title>预定邀请排行{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
	<link href="/css/my.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="/css/zt/zt_xianshifuli.css">
	<style>
		.htmlWhite{background: none!important}
		#page {padding-bottom:3rem;}
		body{background: url('../images/zt/xianshifuli/sortbg.jpg')repeat-y !important;background-size: 100% auto;}
	</style>
	
	@endsection
	@section('content')
			<!-- 头部 -->
	<div class="yq_user pt40 mt20">
		<a href="javascript:;">

			@if($user)
				@if(strpos($user->avatar,'http') !== false)
					<img class="border-radius50" src="{{$user->avatar}}">
				@else
					<img class="border-radius50" src="{{env('IMG_URL')}}{{$user->avatar}}">
				@endif
			@else
				<img class="border-radius50" src=""/>
			@endif
		</a>
		<p class="lt color_fff f32 text_center ptb40">我当前内排名第{{$total+1}}名、已邀请{{$selfNum?$selfNum->reserve_num:"0"}}人</p>
	</div>

	<!-- 排行榜 start-->
	<ul class="bgcolor_fff border-radius-img mlr30 plr20 yq_phb">
		@foreach($userSorts as $sort)
			<li class="clearfix pt20 pb20">
				<div class="yq_phb_user fl lt f28 color_333">
					@if($sort->user)
						@if(strpos($sort->user->avatar,'http') !== false)
							<img src="{{$sort->user->avatar}}" class="border-radius50" />
						@else
							<img src="{{env('IMG_URL')}}{{$sort->user->avatar}}" class="border-radius50" />
						@endif
					@else
						<img src="/images/my/nophoto.jpg" class="border-radius50" />
					@endif
					{{$sort->user?$sort->user->nickname:'暂无昵称'}}
				</div>
				<p class="fr fz color_gray666 f26">已邀请{{$sort->reserve_num}}人</p>
			</li>
		@endforeach
		@if($count>=8)
		<a href="javascript:;" onclick="loadMore();" class="load_more color_gray666 f26 text_center ptb40 mt20 mb40">查看更多邀请明细</a>
		@endif
	</ul>

	<!-- 右侧悬浮 start -->
	<div class="right_wrap" style="top: 90%;">
		@if($mobile==0)
		<a class="bgcolor_orange f32 color_000 border-radius-img reserve" href="javascript:void (0)" onclick="userlogin()">
			马上<br>邀请
		</a>
		@else
		<a class="bgcolor_orange f32 color_000 border-radius-img reserve" href="/wechat/share/37.html">
			马上<br>邀请
		</a>
		@endif
	</div>
	<!-- 右侧悬浮 end-->

	<!-- 排行榜 end-->
<script>
	var page = 2;
	function loadMore(){
		var data = {page:page};
		$.ajax({
			url:'/zt/addMore',
			data:data,
			type:'GET',
			dataType:'json',
			success:function(res){
				if(res.code == 0){
					page = page+1;
					$('.yq_phb .load_more').before(res.body);
				}else{
					$('.yq_phb .load_more').text(res.body);
				}
			}
		});
	}

	//跳转登陆函数
	var userlogin = function(){
		var url = "/zt/yearinfo.html";
		localStorage.setItem("redirect", url);

		layer.msg('请先注册');
		setTimeout(function(){
			window.location.href = "/register";
		}, 500)
	}
</script>
@endsection