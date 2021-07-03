@extends('layouts.header')
@section('title')
    <title>赛普社区-就业课程{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link href="/css/fenxiaoliucheng_clock.css" rel="stylesheet" type="text/css" />
    <link href="/css/fenxiaoliucheng.css" rel="stylesheet" type="text/css" />
    <style>
    	#page {padding-bottom:3rem;}
    </style>
@endsection
@section('content')
	<!--====================================本喵是分割线  喵喵~========================================================-->

	<!--小导航 start-->
	<div class="nav-dingdan text_center f28 fz">
		<ul class="clearfix">
			<li><a href="javascript:void (0)" class="on">就业课程</a></li>
			<li><a href="/order/course">精品单课</a></li>
			<li><a href="/order/clock">挑战打卡</a></li>
		</ul>
	</div>
	<!--小导航 end-->
	<!--====================================本喵是分割线  喵喵~========================================================-->
	<!--列表 start-->
	@if($list->count())
	<div class="dingdan-list">
		<ul>
			@foreach($list as $item)
			<li class="bgcolor_fff plr30 fz mb20 ptb30">
				<div class="weui-cell padding0 noafter nobefore">
					<div class="weui-cell__bd f24 color_gray9b"><p>订单编号：{{$item->number}}</p></div>
					@if($item->state==0)
					<div class="weui-cell__ft f24 color_F5A623">待付款</div>
					@else
					<div class="weui-cell__ft f24 color_F5A623">支付成功</div>
					@endif
				</div>
				<div class="weui-cell padding0 noafter nobefore mt30 mb30">
					<div class="weui-cell__bd f32 color_333 fz bold"><p>{{$item->course_class_group_title}}</p></div>
					<div class="weui-cell__ft f32 color_333 fz bold "><p class="d-in-black f24">￥</p>{{$item->price}}</div>
				</div>
				<div class="weui-cell padding0 noafter nobefore">
					<div class="weui-cell__bd f26 color_gray666"><p>订单时间：{{$item->created_at}}</p></div>
					<div class="weui-cell__ft f24 color_333">
						@if($item->state==0)
						<a href="/train/study.html" class="btn-dd plr30 border-radius-img bgcolor_orange">付款</a>
						@endif
					</div>
				</div>
			</li>
			@endforeach
		</ul>
	</div>
	@else
	<div class="relative">
		<div class="kong-lingqu f28 color_gray666 fz">
			<img src="/images/clock/fx-none.png" alt="" class="mb40">您还没有该课程订单
		</div>
	</div>
	@endif
	<!--列表 end-->
	<!--====================================本喵是分割线  喵喵~========================================================-->
	<!--====================================本喵是分割线  喵喵~========================================================-->
	<!--====================================本喵是分割线  喵喵~========================================================-->
</div><!--导航大盒子id=page 结束-->
<br><br>
<script>
$('body').addClass('bgcolor_gray');
</script>
@endsection