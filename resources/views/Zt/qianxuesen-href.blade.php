@extends('layouts.header')
@section('title')
<title>功能性训练营-赛普健身社区</title>
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

<!---导航右侧带导航弹出---->

<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->



	<div class="plr68 pt40 mt10 color_fff text_center ">

		<div class="bgcolor-262626 pb103 bor-left-bot">
			<div class="bg-ban">
				<p class="lt f36 mb40">扫码加训练顾问微信</p>
			</div>
			<img class="qimg" src="/images/zt/qr-yanjun.png" alt="">

			<p class="lt f34 pt40">回复入群密令：减脂</p>
			<p class="lt f34 mt30">训练顾问邀请您入群</p>
		</div>
	</div>





</div><!--导航大盒子id=page 结束-->



<br><br><br>



<script src="../lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="../lib/jqweui/js/fastclick.js"></script>
<script>


	/**/
  $(function() {
    FastClick.attach(document.body);
  });
</script>
<script src="../lib/jqweui/js/jquery-weui.min.js"></script>
<script src="../lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="../lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="../lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="../lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->
@endsection
