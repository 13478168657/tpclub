@extends('layouts.header')
@section('title')
    <title>消息{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/xueyuan.css">
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth/18.75 + "px";
        })()
    </script>
@endsection
@section('content')
<!-- 新手指南 start -->
<div class="kcml_wrap xszn">
	<h2 class="bgcolor_fff lt color_333">常见问题</h2>
	<!--下拉 start-->
	<div class="xiangqing_xiala cjwt_xiala">
		<aside class="sidebar mb40">
			<nav class="sidebar-nav">
				<ul id="xiangqing_menu">
				<!-- 11111111111111111111111111111111 -->
				@foreach($data as $k=>$v)
					<li @if($k == 0) class="active" @endif>
						<a href="javascript:;" class="fz color_333 clearfix kc_title mlr20">{{$v->name}}<span class="fa arrow"></span></a>
						<ul class=" bgcolor_gray ask_ul">
						<?php echo $v->content; ?>
						</ul>
					</li>
				@endforeach
					
				</ul>
			</nav>
		</aside>
		<!-- 取消报名 -->
		<!--大按钮-->
		<div class="mlr25 Btn pb30 nobefore noafter big_Btn1">
			<a href="/feedback" class="weui-btn nobefore noafter bgcolor_orange color_333">意见反馈</a>
		</div>
		<br/>
		<br/>
		<br/>
	</div>
	<!--下拉 end-->

	<!--下拉展开 start-->
	<script src="../js/xiala_metismenu.js"></script>
		<script>
			$(function () {
				$('#xiangqing_menu').metisMenu({
					doubleTapToGo: true,
					toggle: false
				});
			});
	</script>
	<!--下拉展开 end-->
</div>
<!-- 新手指南 end -->
@endsection