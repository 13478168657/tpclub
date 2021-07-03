@extends('layouts.header')
@section('title')
<title>赛普健身教学总监教你做自己的减脂教练</title>
<meta name="author" content="啾啾" />
<meta name="keywords" content="" />
<meta name="description" content="" />
@endsection

@section('cssjs')
	<!--本css-->
<link rel="stylesheet" href="/css/zt/zt_jianzhi.css">

<script>
(function(){
	var html = document.documentElement;
	var hWidth = html.getBoundingClientRect().width;
	html.style.fontSize=hWidth/18.75+'px';
})()
</script>
@endsection

@section('content')
</head>
<body ontouchstart>

<img src="/images/zt/jianzhi/banner1.jpg" alt="">
<img src="/images/zt/jianzhi/banner2.jpg" alt="">

<!--报名通道 start-->
<div class="B-content text_center fz">
	<p class="lt f44 bold icon-B">报名通道</p>
	<iframe name="teamPost" style="display:none;"></iframe>
	<form method="post" action="/zt/store" id="formData"  target="teamPost">
		{{csrf_field()}}
		<div class="form fz f24 clearfix mb30 mtb45">
			<div class="input">
				<input type="text" id="tel" name="name" placeholder="请输入微信号" class="input border-radius50 f34 text_center fz border1px000 name_attr">
				<input type="hidden" name="url" value=""/>
				<!--<p class="text_left tip">错了, 诶嘿嘿！！</p>-->
			</div>
			<a href="javascript:void (0)" class="border-radius50 btn bgcolor_000 f34 fz color_fff border1px000 mt30 btn-self btn-submit">提交</a>
		</div>
	</form>
	<p class="fz f28">注：请填入微信号，由管理员拉</p>
	<p class="fz f28">您进入线上训练营群。</p>
</div>

<br><br><br>

</body>
</html>

<script src="../lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script type="text/javascript">

var strUrl = window.location.href;
$('input[name="url"]').attr('value',strUrl);


	window.onload = function(){
		menuFixed('nav_keleyi_com');
	}
	$(".btn-submit").click(function(){
		var name = $(".name_attr").val();
		if(name == ""){
		 	layer.msg("请输入您的微信号");
		}else{
			$("#formData").submit();
			layer.msg("申请已提交");
			$('#formData')[0].reset();

			
		}
	

	})
		
</script>
@endsection
