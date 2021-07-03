@extends('layouts.headercode')
@section('title')
    <title>赛普期刊{{env('WEB_TITLE')}}</title>
   
@endsection

@section('cssjs')
    <link rel="stylesheet" type="text/css" href="/css/qikan.css">
	<link rel="stylesheet" type="text/css" href="/css/zt/zt_RightFloat.css">
@endsection
@section('content')
<!---导航右侧带导航弹出---->

<div id="page">
	<!--导航大盒子id=page 开始  【结束在最底部】-->

	<!--头部导航 start-->
	<!-- <div class="mh-head Sticky">
		<div class=" menu-bg-logo">
			<span class="mh-btns-left">
				<a class="icon-menu icon-sousuo" href="javascript:;"></a>
			</span>
			<span class="mh-btns-right">
				<a class="icon-menu erweima icon-erweima" href="javascript:;"></a>
			</span>
		</div>
	</div> -->
	<!--隐藏导航内容-->
	<!-- <nav id="menu"></nav> -->
	<!--头部导航 end-->

	<!--===================================================================================-->

	<!--黄条 start -->
	<div class="color_orange_f5a623 h80 plr30">
		<div class="weui-cell padding0 mt0 noafter nobefore">
			<div class="weui-cell__bd">
				<p class="f32 fz bold">赛普期刊-赛普老师的创作期刊</p>
			</div>
		</div>
	</div>
	<!--黄条 end -->
	<!-- 老师 start -->
	<div class="mb10">
		<div class="weixinBox ptb35 fz bgcolor_fff">
			<div class="weui-cell padding0 mt0 noafter nobefore">
				<div class="weui-cell__hd">
					
					<img src="{{$avatar}}" class="border-radius50">
				</div>
				<div class="weui-cell__bd">
					<p class="f32 color_1515 bold ml10">{{$nickname}}</p>
					<p class="f26 color_gray666 ml10">赛普健身教练培训基地导师</p>
				</div>
				<div class="weui-cell__ft weixins bgcolor_gray codeWBtn">
					<img src="/images/weixin.png" alt="微信">
					<p class="f18">微信咨询</p>
				</div>
			</div>
		</div>
	</div>
	<!-- 老师 end -->

	<!-- 日期、星期 start-->
	<div class="week plr30 bgcolor_f9f9f9 ptb26">
		<p class="font-Oswald-Medium f36 color_333 ml30">{{date("Y")}}.{{date("m")}}.{{date("d")}}<span class="f22 mr30">&nbsp;期</span><span class="d-in-black f32 fz bold">星期{{$week}}</span></p>
		<p class="f24 fontopt"><span class="color_orange mr10">●</span>已为您准备好今日发朋友圈文章↓↓↓请查看</p>
	</div>
	<!-- 日期、星期 end-->

	<!--黄条 文章 start -->
	<div class="color_orange_f5a623 h80 plr30">
		<div class="weui-cell padding0 mt0 noafter nobefore">
			<div class="weui-cell__bd">
				<p class="f32 fz bold">赛普期刊-文章</p>
			</div>
			<div class="weui-cell_ft fz">
				<a href="/article/0.html" class="color_orange f26">更多</a>
			</div>
		</div>
	</div>
	<!--黄条 文章 end -->

	<!-- 文章内容 start -->
	<div class="qikan_list plr30 mt30">
		<ul>
			@foreach($articlelist as $k=>$article)
			<li>
				<a href="/article/detail/{{$article->id}}.html?fission_id={{$user_id}}" class="block">
					<img src="{{env('IMG_URL')}}{{$article->cover_url}}" alt="{{$article->title}}" class="border-radius-img">
				<h3 class="fz bold f34 mt30 text-jus">{{$article->title}}</h3>
				</a>
			</li>
			@endforeach
		</ul>
	</div>
	<!-- 文章内容 end -->

</div>
<!--导航大盒子id=page 结束-->


<br><br><br>
<!-- <script type="text/javascript" src="../lib/jqweui/js/jquery-2.1.4.js"></script>
<script type="text/javascript" src="../lib/jqweui/js/jquery-weui.min.js"></script>
<script type="text/javascript" src="../lib/layer/layer.js"></script> -->
<!--nav logo menu 导航条-->
<!-- <script type="text/javascript" src="../lib/mmenu/js/nav-mmenu-public.js"></script>
<script type="text/javascript" src="../lib/mmenu/js/jquery.mmenu.all.js"></script>
<script type="text/javascript" src="../lib/mmenu/js/jquery.mhead.js"></script> -->
<!--end-->
<script type="text/javascript">
	//二维码弹窗
	$('.codeWBtn').click(function(){
		layer.open({
			type: 1,
			title: false, //不显示标题栏
			skin: 'codeW_layer_wrap codeW_layer_wrap_qikan', //样式类名
			id: 'codeW_layer', //设定一个id，防止重复弹出
			closeBtn: 0, //不/显示关闭按钮
			anim: 2,
			shadeClose: 1, //开启/关闭遮罩
			shade: [0.7, '#000'],
			area: ['30%', '60%'],
			content:'<div class="hideWImg hideWImgPublic text_center mt32">' +
			'<p class="fz f32 color_333 mb20 bold relative"><img src="{{$avatar}}" alt="" class="user"></p>' +
			'<p class="fz f32 color_333 mb20 bold pt20">{{$nickname}}</p>' +
			'<p class="plr30 fz f30 color_333 mt20">' +
			'<span class="block bold">立即长按识别下方二维码</span>' +
			'<span class="block bold">添加我微信领取健身资料包</span>' +
			'</p>' +
			'<img src="{{$wx_code}}" alt="赛普健身社区">' +
			'</div>',
			btn:false
		});
	});
</script>
@endsection