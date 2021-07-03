@extends('layouts.header')
@section('title')
<title>问答专场-导师作业</title>
<meta name="author" content="啾啾" />
<meta name="keywords" content="" />
<meta name="description" content="" />
@endsection

@section('cssjs')
<!--问答下css-->
<link rel="stylesheet" href="/css/ask.css">

<script>
(function(){
	var html = document.documentElement;
	var hWidth = html.getBoundingClientRect().width;
	html.style.fontSize=hWidth/18.75+'px';
})()
</script>
@endsection

@section('content')

<!---导航右侧带导航弹出---->
<div id="page">
	<!--导航大盒子id=page 开始  【结束在最底部】-->




	<!--===========================================================================================-->
	<div class="qa_field_content">
		
		<!--banner start-->
		<div class="banner_fie relative">
			<img src="/images/ask/fie_banner.png" alt="">
			<div class="color_fff field_txt fz plr36 mt32">
				<span class="f24 border-radius50">你问我答</span>
				<p class="text_center f36 bold pt40">{{$special->title}}</p>
			</div>
		</div>
		<!--banner end-->

		<!--下拉 start-->
		@if($special->is_open==0)
		<div class="choice_content fz f28 color_gray666 plr36 field_choice">
		   <div class="choice_content_box">
		      <p class="flip ptb20 relative">查看该专区关联的组合课程<img src="/images/xiala_s.png" class="flip-arrow" alt=""/></p >
		      <div class="panel plr36">
		         <!--多选-->
		         <div class="checkboxWrap pb40">
		         	@foreach($group_class as $group)
		         	<a href="/train/study.html"><label class="mt20">{{$group->title}}</label></a>
		            @endforeach
		         </div>
		      </div>
		   </div>
		   @if($course_class)
		   <div class="choice_content_box">
		      <p class="flip ptb20 relative">查看该专区关联的单一课程<img src="/images/xiala_s.png" class="flip-arrow" alt=""/></p >
		      <div class="panel plr36">
		         <!--多选-->
		         <div class="checkboxWrap pb40">
		            @foreach($course_class as $k=>$course)
		            <label class="mt20">{{$course->title}}</label>
		            @endforeach
		         </div>
		      </div>
		   </div>
		   @endif
		</div>
		@endif
		<!--下拉 end-->

		<!--关注 start-->
		<div class="plr30 gaunzhu_fiele ptb30">
			<div class="weui-cells  noafter nobefore padding0 mt0">
				<div class="weui-cell noafter nobefore padding0 ">
					<div class="weui-cell__hd">
						@if(count($teacher)>0)
							@if((strpos($teacher->avatar,'http') !== false))
								<img src="{{$teacher->avatar}}" class="border-radius50">
							@else
								<img src="{{env('IMG_URL')}}{{$teacher->avatar}}" class="border-radius50">

							@endif
						@endif
					</div>
					<div class="weui-cell__bd fz">
						<p class="bold f32">{{$teacher?$teacher->nickname:''}}</p>
						<p class="f26">{{$teacher?$teacher->introduction:'暂无介绍'}}</p>
					</div>
					@if(count($teacher) > 0)
						<?php
							$follow = DB::table("follow")->where("user_id",$teacher->id)->where("fans_id",$user_id)->count();
						?>
						@if($follow > 0)
							<div class="weui-cell__ft"><a href="javascript:void (0)" class="f28 fz border-radius-img bgcolor_orange" data-user_id="{{$teacher->id}}" data-fans_id='{{$user_id}}' onclick="article_follow(this)" data-is_follow='1' id="teacher{{$teacher->id}}">已关注</a></div>
						@else
							<div class="weui-cell__ft"><a href="javascript:void (0)" class="f28 fz border-radius-img bgcolor_orange" data-user_id="{{$teacher->id}}" data-fans_id='{{$user_id}}' onclick="article_follow(this)" data-is_follow='0' id="teacher{{$teacher->id}}">关注</a></div>
						@endif
					@endif
				</div>
			</div>
		</div>
		<!--关注 end-->

		<!--导航 start-->
		<div class="field_nav text_center fz f28 bgcolor_f9f9f9">
			<ul class="clearfix">
				<li><a href="/ask/answer/{{$special->id}}.html">已回答</a></li>
				<li><a href="/ask/question/{{$special->id}}.html">待导师回答</a></li>
				<li><a href="javascript:void (0)" class="cur">导师作业</a></li>
			</ul>
		</div>
		<!--导航 end-->

		<!--列表 start-->
		<div class="fiele_list_tea plr30">
			<ul class="append_ask">
				@foreach($question as $v)
					<?php
						$ans_num = DB::table("ask_answer")->where("qid",$v->id)->count();	//回答数量
						$approve_num = DB::table("ask_answer")->where("qid",$v->id)->where("is_approve",1)->count();	//认可数量
					?>
				<li>
					<a href="/ask/zuoye/{{$v->id}}/1/{{$can}}.html" class="fz ptb30">
						<h3 class="f32 color_333 bold text-jus">{{$v->title}}</h3>
						<p class="f24 color_gray9b">{{$v->view}} 阅读· {{$ans_num}}回答 &nbsp;&nbsp;{{$approve_num}}回答被导师认可<span class="text_right fr">{{date("Y.m.d",strtotime($v->created_at))}}</span></p>
					</a>
				</li>
				@endforeach

				<a href="javascript:void (0)" class="Load fz text_center pt40 mt20 color_gray666 f24 loadmore" data-is_ture="0">加载更多练习题…</a>
			</ul>
		</div>
		<!--列表 end-->
		
	</div>
	<!--===========================================================================================-->









</div>
<!--导航大盒子id=page 结束-->
<br><br><br>

<script src="/lib/layer/layer.js"></script>
<script type="text/javascript">
	var i = 2;
	var can = "{{$can}}";
	$(".loadmore").click(function(){
		var token = "{{csrf_token()}}";
		var sid = "{{$special->id}}";
		var data_is_true = $(".loadmore").attr("data-is_ture");
		console.log(data_is_true);
		if(data_is_true == 0) {

			$.ajax({
				type: "POST",
				url: "/ask/loadmore",
				data: {sid: sid, page: i, is_question:0,_token: token, can:can},
				dataType: "json",
				success: function (result) {
					if(result.body !== '') {
						console.log(result);
						$(".loadmore").before(result.body);
						i++;
					}else{
						layer.msg("没有更多作业了！");
						$(".loadmore").attr("data-is_ture",1);
						$(".loadmore").text("已显示全部作业");
					}
				}
			});
		}else{
			layer.msg("没有更多作业了！");
		}

	})

	$(function(){
	   $('.flip').on('click',function(){
	      $(this).next().slideToggle(500);
	   });

	   //下拉箭头样式
	   var usercenter = {
	      init:function(){
	         this.modal();
	      },
	      modal: function() {
	         $(".flip").click(function(){
	            var arrow=$(this).children('.flip-arrow');
	            if(arrow.hasClass("rotate")){ //点击箭头旋转180度
	               arrow.removeClass("rotate");
	               arrow.addClass("rotate1");
	            }else{
	               arrow.removeClass("rotate1"); //再次点击箭头回来
	               arrow.addClass("rotate");
	            }
	         })
	      }
	   };
	   usercenter.init();
	})



</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
	wx.config({
		debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
		appId: "{{$WechatShare['appId']}}", // 必填，公众号的唯一标识
		timestamp: "{{$WechatShare['timestamp']}}", // 必填，生成签名的时间戳
		nonceStr: "{{$WechatShare['noncestr']}}", // 必填，生成签名的随机串
		signature: "{{$WechatShare['signature']}}",// 必填，签名
		jsApiList: [
			'checkJsApi',
			'onMenuShareTimeline',
			'onMenuShareAppMessage',
		] // 必填，需要使用的JS接口列表
	});

	var link = 'http://m.saipubbs.com/ask/field/{{$special->id}}.html';
	var title = '导师问答专区';
	var desc = '疑难问题全知道~';
	var img = 'http://m.saipubbs.com/images/ask/ask_share.png';
	wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
		wx.onMenuShareAppMessage({
			title: title, // 分享标题
			desc: desc, // 分享描述
			link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
			imgUrl: img, // 分享图标

		}, function(res) {
			//这里是回调函数

		});
	});
	wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
		wx.onMenuShareTimeline({
			title: title, // 分享标题
			link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
			imgUrl: img, // 分享图标

		}, function(res) {
			//这里是回调函数

		});
	});
</script>
@endsection
