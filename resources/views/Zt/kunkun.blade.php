@extends('layouts.header')
@section('title')
<title></title>
<meta name="author" content="啾啾" />
<meta name="keywords" content="" />
<meta name="description" content="" />
@endsection

@section('cssjs')

	<!--本css-->
	<link rel="stylesheet" href="../css/zt/zt_jianzhi.css">

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

<img src="../images/zt/kunkun/banner1.jpg" alt="">
<img src="../images/zt/kunkun/banner2.jpg" alt="">

<!--报名通道 start-->
<div class="B-content text_center fz">
<iframe name="teamPost" style="display:none;"></iframe>
<form method="post" action="/zt/store" id="formData"  target="teamPost">
		{{csrf_field()}}
	<div class="form fz f24 clearfix mb30 mtb45">
		<div class="input">
			<input type="text" id="tel" name="name" placeholder="请输入微信号" class="name_attr input border-radius50 f34 text_center fz border1px000">
			<input type="hidden" name="url" value=""/>
			<!--<p class="text_left tip">错了, 诶嘿嘿！！</p>-->
		</div>
		<a href="javascript:void (0)" class="border-radius50 btn bgcolor_000 f34 fz color_fff border1px000 mt30 btn-self btn-submit">免费报名</a>
	</div>

	<p class="fz f28">注：请留下您的微信号，管理员将拉您进入坤坤</p>
	<p class="fz f28">普拉提减脂塑形教练线上训练营社群。</p>
</div>
</form>
<br><br><br>
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
