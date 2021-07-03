@extends('layouts.header')
@section('title')
    <title>文章发布成功{{env('WEB_TITLE')}}</title>
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

	<div class="page_article_success">
		<div class="plr30 text_center fz">
			<dl>
				<dt><img src="/images/saipubi.png" alt="赛普币" /></dt>
				<dd>奖励赛普币+20(每日一次)</dd>
			</dl>
			<p class="p1">获得小编推荐会发布到首页</p>
			<p class="p2"><a href="#" class="viewRule">查看赛普币规则</a></p>
		</div>
		<!-- 底部按钮 -->
		<div class="fixed_bar_bottom">
			<div class="btnWrap bgcolor_fff ">
				<div class="weui-flex fz">
					<div class="weui-flex__item"><a class="btn1" href='/article/0.html'>返回文章首页</a></div>
					<div class="weui-flex__item"><a class="btn1" href='/article/recommend'>继续推荐</a></div>
				</div>
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
			$('.btn1').removeClass('disabled');
		}
	})

	
	//发布文章
	$('.btn1').click(function (){
		var art=$('.kc_input').val();
		var url=$('.url_input').val();
		//ajax
	})

	/*window.onload = function(){
		menuFixed('nav_keleyi_com');
	}*/
</script>
@endsection