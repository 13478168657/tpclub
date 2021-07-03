<!DOCTYPE html>
<html lang="zh-CN">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
	<title>您已预定</title>
	<meta name="author" content="" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<script src="/js/rem.js" type="text/javascript"></script>
	<link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
	<link href="/lib/jqweui/css/jquery-weui.css" rel="stylesheet" type="text/css" />
	<link href="/css/reset_phone.css" rel="stylesheet" type="text/css" />
	<link href="/css/font-num40.css" rel="stylesheet" type="text/css" />
	<link href="/css/toufang.css" rel="stylesheet">
	<script type="text/javascript">
		var showModel = function(){
	    	layer.open({
				type: 1,
				title: false, //不显示标题栏
				skin: 'tiyan_layer_wrap', //样式类名
				id: 'tiyan_layer', //设定一个id，防止重复弹出
				closeBtn: 1, //不显示关闭按钮
				anim: 2,
				shadeClose: false, //开启遮罩关闭
				area: ['80%', '60%'],
				content:$('.tiyan_layer'),
				btn:false
			});
	    }
	</script>
</head>

<body ontouchstart class="bg_343434">
	<!-- 手机号已预订页面 start -->
	<div class="page_toufang_result w750">
		<h3 class="f48 lh66 text_center">
			非常抱歉<br>
			《赛普实训体验营》<br>
			本期报名名额已满
		</h3>
		<div class="page_toufang_tiyan mlr40 plr10">
			<img src="/images/vote/tiyan.png" alt="" class="img100">
		</div>
		<p class="mt50 mb50 lh66 text_center f48 ltc color_fff text_reg">
			请联系咨询老师<br>
			—— 获取其他课程 ——
		</p>
		<div class="tiyan_btn pt30">
			<a href="javascript:void(0)" class="f48 ltc text_center tui_btn" onclick="showModel()">退还报名费</a>
		</div>
	</div>
	<!-- 手机号已预订页面 end -->


	<!-- 二维码弹窗 start -->
	<div class="tiyan_layer hide">
		<div class="container pt50 text_center">
			<p class="color_000 f35 text_center mb40 mt20">添加客服<br>为您退还体验营报名费</p>
			<img src="/images/vote/code_result.png" alt="二维码" />
		</div>
	</div>
	<!-- 二维码弹窗 end -->
	<br><br><br /><br />

	<script src="/js/jquery-1.11.2.min.js"></script>
	<script src="/lib/layer/layer.js"></script>
	<!-- <script src="/lib/jqweui/js/jquery-weui.min.js"></script> -->
	<!-- <script src="/js/js.js"></script> -->
</body>
<script type="text/javascript">
	$(document).ready(function(){
		var user_id   = "{{$user_id}}";      //用户id
	    var tf_course_class_id = "{{$tfCourseClass->id}}";  //购买投放课程id
	    //20200210 记录记录微信页面点击册数
	    var data = {type:"yuding_num",user_id:user_id, tf_course_class_id:tf_course_class_id};
	    $.ajax({
	        url:'/tf/click',
	        data:data,
	        type:'GET',
	        dataType:'json',
	        success:function(res){
	        	console.log(111111);
	        }
	    });
	});
	
</script>
</html>