

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
	@yield('title')
	<meta name="author" content="赛普课堂" />

	<meta name="author" content="赛普课堂" />
	<link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
	<link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
	<link href="/css/reset.css?t=1.21" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="/css/font-num40.css">

	<!--mmenu.css start-->
	<script src="/lib/jqweui/js/jquery-2.1.4.js"></script>
	<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
	<script src="/lib/layer/layer.js"></script>
	<script src="/js/fonts.js?t={{time()}}"></script>


	<!--end-->

	<style>
		.head-tit3{height: 2.6rem;line-height: 2.6rem;background: url("../../../images/logo.png")no-repeat center center;background-size: 35% auto;text-indent:-9999px;box-shadow: 0px 1px 3px rgba(236,236,236,.5);padding:.6rem 0;}
	</style>
	@include('layouts.baidutongji')
	@yield('cssjs')
</head>
<body>
<h2 class="head-tit3">赛普健身社区</h2>

<!-- 头部条 start -->
@yield('top')
		<!-- 头部条 end -->


<!-- 主体内容 start -->
@yield('content')
		<!-- 主体内容 end -->
</body>
</html>