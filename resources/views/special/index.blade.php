@extends('layouts.header')
@section('title')
<title>{{$data->title}}{{env('WEB_TITLE')}}</title>
<meta name="author" content="啾啾" />
<meta name="keywords" content="{{$data->seo_title}}" />
<meta name="description" content="{{$data->seo_description}}" />
@endsection

@section('cssjs')
<!--分享下css-->
<link rel="stylesheet" href="/css/share.css">

<script>
(function(){
	var html = document.documentElement;
	var hWidth = html.getBoundingClientRect().width;
	html.style.fontSize=hWidth/18.75+'px';
})()
</script>
</head>
@endsection
@section('content')
<body ontouchstart>

<!---导航右侧带导航弹出---->

<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->



	<!--============================本喵是分割线===================================-->

	<!--banner start-->
	<div class="banner relative">
		<img class="pos-img-img" src="{{env('IMG_URL')}}{{$data->img_url}}" alt="">
		<div class="bg-000">
			<div class="text_center pos-img color_fff">
				<p class="f34 pb13"><i class="color_orange">#</i>{{$data->title}}<i class="color_orange">#</i></p>
				<?php
					$people = DB::table('special_follow')->where("special_id", $data->id)->count();
				?>
				<p class="f26 fz "><span>{{$data->count_special}}</span><span>{{$people + $data->likes}}人已关注</span></p>
				{{--共{{count($article)}}篇文章--}}
				@if($userid == 0)
					<a class="f28 bold mt30 bgcolor_orange border-radius-img " href="javascript:void (0)" onclick="userlogin()">关注</a>
				@else
				<?php
						$interest = DB::table("special_follow")->where("special_id",$data->id)->where("fans_id",$userid)->count();
				?>
					@if($interest >0)
						<a class="f28 bold mt30 bgcolor_orange border-radius-img" href="javascript:void (0)">已关注</a>
					@else
						<a class="f28 bold mt30 bgcolor_orange border-radius-img  interest" data-attr = "{{$data->id}}" href="javascript:void (0)">关注</a><!--SuccessBtn 二维码弹出-->
					@endif
				@endif
			</div>
		</div>
		<div class="bor-radius-top hei-bottom bgcolor_fff"></div>
	</div>
	<!--banner end-->


	<!--============================本喵是分割线===================================-->
	<div class="plr30"><!--边距30开始-->

		<!--文章本章没错了 start-->
		<div class="share-detail pt20 pb20">
			<div class="text-jus  color_333  f26">
				<p>{{$data->description}}</p>
			</div>
		</div>
		<!--文章本章没错了 end-->


		<div class="list-art">
			<ul>
			@foreach($article as $v)
				<li class="pt30 pb30">
					<a href="/article/special/{{$v->id}}/{{$data->id}}.html">
						<dl class="clearfix relative">
							<dt class="border-radius-img"><img src="{{env('IMG_URL')}}{{$v->cover_url}}" alt="" /></dt>
							<dd>
								<h3 class="lt f30 color_333 text-overflow2">{{$v->title}}</h3>

								<div class="weui-cells nobefore noafter padding0 share-title mt0">
									<div class="weui-cell nobefore noafter padding0 mt20">
										<div class="weui-cell__hd border-radius50 line-h6">
										@if($v->author)
												@if($v->author->avatar)
													@if(strpos($v->author->avatar,'http') !== false)
														<img src="{{$v->author->avatar?$v->author->avatar:''}}" class="border-radius50" />
													@else
														<img src="{{env('IMG_URL')}}{{$v->author->avatar?$v->author->avatar:''}}" alt="头像" class="border-radius50" />
													@endif
												@else
														<img src="/images/my/nophoto.jpg" alt="头像" class="border-radius50" />
												@endif
										</div>
										<div class="weui-cell__bd f28 fz color_gray666">
											<p>{{$v->author->name?$v->author->name:''}}</p>
										</div>
										@endif
									</div>

									<div class="weui-cell nobefore noafter padding0">
										<div class="weui-cell__bd mt10">
											<p class="color_gray9b f22 fz">{{substr($v->created_at,0, 10)}}</p>
										</div>
										<div class="weui-cell__ft fz f20 color_gray9b watch-img">
											<span class=""><img src="/images/icon-xiao-xihuan.png" alt="">{{$v->likes}}</span>
											<span class="pl20"><img src="/images/icon-xiao-yuedu.png" alt="">{{$v->views}}</span>
										</div>
									</div>
								</div>
							</dd>
						</dl>
					</a>
				</li>
				@endforeach

			</ul>
		</div>
	</div><!--边距30结束-->


	<!--============================本喵是分割线===================================-->



	<!--底部 start-->
	<div class="art-footer art-footer-d">
		<ul class="clearfix text_center">
			<li class="bgcolor_orange fz f34 color_333"><a href="/wechat/shareArticle/{{$data->id}}" class="">邀请朋友观看</a></li>
		</ul>
	</div>
	<!--底部 end-->



</div><!--导航大盒子id=page 结束-->



<br><br><br>





<!--end-->
<script>
	$(document).ready(function(){
		var flag = 1;
		$(".check").click(function(){
			if(flag == 1){
				$(".check").css({"background":"url(/images/art-sc.png)no-repeat top center","background-size":"50%","background-color":"#f9f9f9"});
				flag = 0;
			} else{
				$(".check").css({"background":"url(/images/art-no-sc.png)no-repeat top center","background-size":"50%","background-color":"#f9f9f9"});
				flag = 1;
			}
		})
	});

	$(document).ready(function(){
		var flag = 1;
		$(".check2").click(function(){
			if(flag == 1){
				$(".check2").css({"background":"url(/images/art-like.png)no-repeat top center","background-size":"50%","background-color":"#f9f9f9"});
				flag = 0;
			} else{
				$(".check2").css({"background":"url(/images/art-no-like.png)no-repeat top center","background-size":"50%","background-color":"#f9f9f9"});
				flag = 1;
			}
		})
	});

	//弹窗
	//$('.SuccessBtn').click(function(){
	function a(){
		layer.open({
			type: 1,
			title: false, //不显示标题栏
			skin: 'bm_success_layer_wrap_tiao', //样式类名
			id: 'bm_success_layer', //设定一个id，防止重复弹出
			closeBtn: 1, //不显示关闭按钮
			anim: 2,
			shadeClose: true, //开启遮罩关闭
			area: ['73%', '62%'],
			content:'' +
			'<div class="bm_success_layer text_center">' +
			'<div class="mt30 pt30">' +
			'<p class="lt bold color_333 f34 text_center pt80"><img src="/images/dui.png" alt="" class="dui">关注成功!</p>' +
			'</div>' +
			'<img src="/images/qr.png" class="bm_success pt40" alt="" />' +
			'<div>' +
			'<p class="fz color_333 f26 lin9 pt40">扫描二维码获得专题更新提醒</p>' +
			'</div>' +
			'</div>',
			btn:false
		});
	}
		
	//})
	
	var _token = '{{csrf_token()}}';
	$(".interest").click(function(){
		var id = $(this).attr("data-attr");
		console.log(id);
		if(id){
			$.ajax({
              url:'/special/interest',
              data:{id:id,_token:_token},
              type:'POST',
              dataType: 'json',
              success:function(res){
				  console.log(res);
				if(res.code == 1){
					$(".interest").text("已关注");
					$(".interest").removeAttr("data-attr");
					a();
				}
              }
          });

		}
		

	})

	//跳转登陆函数
	var userlogin = function(){
		var userid = "{{$data->id}}";
		var url = "/special/index/"+userid+".html";
		localStorage.setItem("redirect", url);

		layer.msg('请先注册');
		setTimeout(function(){
			window.location.href = "/register";
		}, 500)
	}
	//将裂变者id写入本地  用于存储上下级关系
	var fission_id = "{{$fission_id}}";
	if(fission_id>0){
		localStorage.setItem("fission_id", fission_id);
	}
</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
	var token1   = '{{csrf_token()}}';
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

	wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
				wx.onMenuShareAppMessage({
					title: '{{$data->title}}', // 分享标题
					desc: '{{$data->seo_description}}', // 分享描述
					link: "http://m.saipubbs.com/special/index/{{$data->id}}.html?fission_id={{$userid}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
					imgUrl: "{{env('IMG_URL')}}{{$data->img_url}}", // 分享图标
					success: function(){
						/*----分享获得赛普币start----*/
						$.ajax({
							type:"POST",
							url:"/article/spbArticle",
							data:{userid:"{{$userid}}",article_id:"{{$data->id}}",spburl:"21", _token:token1},
							dataType:"json",
							success:function(result){
								//alert(result);
							}
						});
						/*----分享获得赛普币end----*/
					}
				}, function(res) {
					//这里是回调函数
					alert("分享好友成功");
				});
			});
	wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
		wx.onMenuShareTimeline({
			title: '{{$data->title}}', // 分享标题
			link: "http://m.saipubbs.com/special/index/{{$data->id}}.html?fission_id={{$userid}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
			imgUrl: "{{env('IMG_URL')}}{{$data->img_url}}", // 分享图标
			success: function(){
				/*----分享获得赛普币start----*/
				$.ajax({
					type:"POST",
					url:"/article/spbArticle",
					data:{userid:"{{$userid}}",article_id:"{{$data->id}}",spburl:"21", _token:token1},
					dataType:"json",
					success:function(result){
						//alert(result);
					}
				});
				/*----分享获得赛普币end----*/
			}
		}, function(res) {
			//这里是回调函数

		});
	});
</script>
@endsection
