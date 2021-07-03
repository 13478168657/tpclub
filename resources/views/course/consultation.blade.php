@extends('layouts.header')
@section('title')
    <title>在线咨询{{env('WEB_TITLE')}}</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
@endsection

@section('cssjs')
    <link href="/css/xueyuan-detail2.css" rel="stylesheet" type="text/css" />
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth/18.75 + "px";
        })()
    </script>
@endsection

@section('content')
<div class="bgc_white overflow">
	<!-- 对话框 start -->
	<div class="dialog_item container clearfix wow animated fadeIn"  data-wow-duration="1s" data-wow-delay="0s">
		<div class="user_photo"><img src="../images/xy.png" alt="" class="img100"></div>
		<div class="con">
			<p>同学你好</p>
		</div>
	</div>
	<div class="dialog_item container clearfix wow animated fadeIn"  data-wow-duration="1s" data-wow-delay="0.8s">
		<div class="user_photo"><img src="../images/xy.png" alt="" class="img100"></div>
		<div class="con">
			<p>如果您想了解课程内容，想知道课程是否适合自己，不想错过精品课程优惠信息，请留下您的微信号，我会为您答疑解惑，帮您省钱！</p>
		</div>
	</div>
	<!-- 对话框 end -->
</div>

<!-- 底部固定条 start -->
<div class="fixed_bar_bottom">
	<div class="container wxForm">
		<h3>选择你想要达成的目标</h3>
		<ul class="clearfix">
			<li><span>增肌</span></li>
			<li><span>减脂</span></li>
			<li><span>瘦腿</span></li>
			<li><span>翘臀</span></li>
			<li><span>塑形</span></li>
			<li><span>有氧</span></li>
			<li><span>健美比赛</span></li>
			<li><span>成为私教</span></li>
		</ul>
		<div class="iptWrap">
			<input class="weui-input" type="text" placeholder="输入微信号" id="wxnumber" />
		</div>
		<div class="pt15 pb15">
			<a href="javascript:void(0);" class="roy_btn bgc_yellow payBtn">提交</a>
		</div>
	</div>	  
</div>	  
<!-- 底部固定条 end -->
<link href="/lib/wow/animate.css" rel="stylesheet" type="text/css" />
<script src="/lib/wow/wow.js"></script>
<script>
  $(function() {
    FastClick.attach(document.body);
  });
</script>
<script type="text/javascript">
	new WOW().init();
	
	$(function (){
		//多选
		$('.wxForm li').click(function(){
			$(this).toggleClass('on');
		})
		//点击提交
		$('.payBtn').click(function(){
			var targets = "";
			var c_c_id  = "{{$c_c_id}}";
			var token   = '{{csrf_token()}}';
			$(".clearfix .on").each(function(){
				targets += $(this).children().eq(0).text()+",";
			});
			var wechat_number = $("#wxnumber").val();
			if(targets=="" || wechat_number.length<1){
				layer.msg("请选择目标或输入微信号");
				return;
			}
			
			$.ajax({
				type:"POST",
				url:"/course/consultation/"+c_c_id+'.html',
				data:{course_class_id:c_c_id, targets:targets, wechat_number:wechat_number,_token:token},
				dataType:"json",
				success:function(result){
					if(result.code==1){
						layer.msg(result.msg);
						setTimeout(function(){
							window.history.go(-1);
						},1500)  //延迟1.5秒刷新页面
					}else{
						layer.msg(result.msg);
					}
	            }
			});
		})
	})
</script>
@endsection