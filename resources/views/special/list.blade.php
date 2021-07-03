@extends('layouts.header')
@section('title')
	<title>赛普社区-专题首页</title>
	<meta name="author" content="啾啾" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
@endsection

@section('cssjs')
	<!--分享下css-->
	<link rel="stylesheet" href="/css/share.css">

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


	<!--============================本喵是分割线===================================-->



	<!--============================本喵是分割线===================================-->
	<div class="plr30"><!--边距30开始-->

		<div class="list-art list-art-list">
			<ul>
			@if(count($data) !== 0)


			@foreach($data as $k=>$v)
				<li class="pt30 pb30">
					<a href="/special/index/{{$v->id}}.html">
						<dl class="clearfix relative">
							<dt class="border-radius-img"><img src="{{env('IMG_URL')}}{{$v->img_url}}" alt="" /></dt>
							<dd>
								<h3 class="lt f30 color_333 text-overflow">{{$v->title}}</h3>

								<div class="weui-cells nobefore noafter padding0 share-title mt0">
									<div class="weui-cell nobefore noafter padding0 mt10">
										<div class="weui-cell__bd f28 fz color_gray666 miaoshu text-overflow2">
											<p>{{$v->jianshu}}</p>
										</div>
									</div>

									<div class="weui-cell nobefore noafter padding0 mt10">
										<div class="weui-cell__bd mt10">
											<?php
												//$article = DB::table('article')->where("special_id","like",'%'.$v->id."%")->count();
												$people = DB::table('special_follow')->where("special_id","like",'%'.$v->id."%")->count();
											?>
											{{--<p class="color_gray9b f22 fz">共{{$article}}篇文章</p>--}}
											<p class="color_gray9b f22 fz">{{$v->count_special}}</p>
										</div>
										<div class="weui-cell__ft fz f22 color_gray9b mt10">
											<span>{{$people+$v->likes}}人已经关注</span>
										</div>
									</div>
								</div>
							</dd>
						</dl>
					</a>
				</li>
			@endforeach
				@else
					<div class="weui-loadmore more text_center fz ptb30 remove_attr " id="study_more">
						<span class="weui-loadmore__tips" >暂无相关专题哦</span>
					</div>
@endif
			</ul>
		</div>
	</div><!--边距30结束-->


	<!--============================本喵是分割线===================================-->





</div><!--导航大盒子id=page 结束-->



<br><br><br>
<!--end-->

@endsection
