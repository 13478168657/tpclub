@extends('layouts.header')
@section('title')
<title></title>
<meta name="author" content="啾啾" />
<meta name="keywords" content="" />
<meta name="description" content="" />
@endsection

@section('cssjs')

<link href="../css/reset.css" rel="stylesheet" type="text/css" />
<link href="../css/font-num40.css" rel="stylesheet" >

	<!--本css-->
	<link rel="stylesheet" href="../css/zt/zt_qianxuesen.css">

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
<iframe name="teamPost" style="display:none;"></iframe>
<form method="post" action="/zt/store" id="formData"  target="teamPost">
	{{csrf_field()}}
<div class="plr68 pt40">
	<img src="../images/zt/qianxuesen/ban.jpg" alt="">

	<!--报名通道 start-->
	<div class="B-content text_center fz color_fff">
		<div class="form fz f24 clearfix mb30 ptb45">
			<div class="input">
				<input type="text" id="tel" name="name" placeholder="请输入微信号" class="name_attr input border-radius50 f34 text_center fz border1pxfff">
				<input type="hidden" name="url" value=""/>
				<!--<p class="text_left tip">错了, 诶嘿嘿！！</p>-->
			</div>
			<a href="javascript:void (0)" class="border-radius50 btn bgcolor_orange f34 fz color_000 border1pxorange mt30 btn-submit">免费报名</a>

			<p class="fz f28">注：请留下您的微信号，管理员将拉</p>
			<p class="fz f28 pb30 mb40">您进入森哥线上训练营社群</p>
		</div>

	</div>
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
