@extends('layouts.header')
@section('title')
    <title>发布文章{{env('WEB_TITLE')}}</title>
    <meta name="description" content="" />
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/article.css">
    <style>
    	#page {padding-bottom:3rem;}
    </style>
@endsection
@section('content')	
<div id="page">
	
	<!--隐藏导航内容-->
	<nav id="menu"></nav>
	<!--头部导航 end-->


	<div class="page_tags page_article bgcolor_fff">
		<div class="plr30 bgcolor_fff fz">
			<h3 class="clearfix">课程名称</h3>
			<div class="inputWrap">
				<input type="text" class="input kc_input" value="{{$recommend->title}}" placeholder="运动健康的必要前提" />
			</div>
			<h3 class="clearfix">URL</h3>
			<div class="inputWrap">
				<input type="text" class="input url_input" value="{{$recommend->url}}" placeholder="运动健康的必要前提" />
			</div>
			<div class="tips">解析成功</div>
		</div>
		<!-- 底部按钮 -->
		<div class="fixed_bar_bottom ptb20">
			<div class="plr30 bgcolor_fff">
				<a class="btn1 btn_addArt fz" href='/article/release/{{$recommend->id}}'>立即发布</a>
			</div>
		</div>
	</div>
	<!--边距30 end-->

</div>
<!--导航大盒子id=page 结束-->

<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
  $(function() {
    FastClick.attach(document.body);
  });
</script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->

<script type="text/javascript">
	$('html,body,#page').css('height','100%');

	//去除底部按钮不能点击样式
	$('.kc_input,.url_input').on("input propertychange", function() {
		if($('.kc_input').val().length>0 && $('.url_input').val().length>0){
			$('.btn_addArt').removeClass('disabled');
		}
	})

	
	//发布文章
	$('.btn_addArt').click(function (){
		var art=$('.kc_input').val();
		var url=$('.url_input').val();
		//ajax
		window.location="addarticle_success.html";
	})

	/*window.onload = function(){
		menuFixed('nav_keleyi_com');
	}*/
</script>
@endsection