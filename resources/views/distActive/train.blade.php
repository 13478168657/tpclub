<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
<title>{{$disCourse->title}}</title>
<meta name="author" content="涵涵" />
<meta name="keywords" content="" />
<meta name="description" content="" />
	<link href="/css/reset.css?t=1.21" rel="stylesheet" type="text/css" />
	<link href="/css/font-num40.css" rel="stylesheet" >
	<link rel="stylesheet" href="/css/zt/zt_RightFloat.css">

	<style>
		.right-fixed{background: #ff7900;z-index:9999 !important;bottom:18%!important;}
		img{width: 100%;display: block;}
		.video {position: relative;width: 100%;height: 9.5rem;}
		.video .box2 {position: absolute;width: 100%;height: 100%;z-index: 100;}
		.video .box2 img {display: block;width: 100%;height: 100%;}
		.video .box2 .mask {position: absolute;left: 0;top: 0;width: 100%;height: 100%;background-color: #000;filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=50);opacity: .5;}
		.video .box2 .btn_play {position: absolute;left: 50%;top: 50%;transform: translate(-50%, -50%);width: 1.95rem;height: 1.95rem;background: url(/images/zt/play.png) 0 0 no-repeat;background-size: 1.95rem 1.95rem;}
		.video video {position: absolute;left: 0;top: 0;width: 100%;height: 9.5rem;}

		.time span{border-top: 1px solid #666;width: 50%;display: block;margin: 0 auto;}

		.shipin{padding:2.7rem 0 1rem;background-color: #000;}
		.shipin h3 i{border-top: 1px solid #fff;display: inline-block;width: 18%;vertical-align: middle;margin-right: .3rem;margin-left: .3rem;}

		.dumpClass{border-top: 1px solid #2c2c2c;}
		.dumpClass img{display: inline-block;vertical-align: middle;width: .65rem;margin-left: .3rem;}
		.dumpClass .dumpImg{width: 100%!important;margin:1rem auto;display: none;}

		.transition3s{
			-webkit-transition: all .3s ease-in-out;
			-moz-transition: all .3s ease-in-out;
			-ms-transition: all .3s ease-in-out;
			-o-transition: all .3s ease-in-out;
			transition: all .3s ease-in-out;}

		.fixed{position: fixed;bottom: 0;left: 0;width: 100%;z-index: 9999;}
		.fixed ul li:nth-child(1){background-color: #ff7900;height: 2.25rem;line-height: 2.25rem;}
		.fixed ul li:nth-child(2){height: 2.25rem;line-height: 2.25rem;background-color: #ff7900;}

		/*弹出分享提示样式*/
		.fxpyq_success_layer_wrap{height: auto!important;background: none!important;box-shadow: none!important;top: 1rem!important;}
		.fxpyq_success_layer_wrap .layui-layer-content img{height: 8.35rem!important;background: none!important;}
		/*弹出的img晃动样式*/
		.zhuan_left{transform: rotate(-.6deg);-webkit-transform: rotate(-.6deg);}
		.zhuan_right{-webkit-transform: rotate(.6deg);transform: rotate(.6deg);}

		img.down-arrow{
			transform-origin: 100% 100%;
			-webkit-transform-origin: 100% 100%;
			-webkit-transition: all 1s ease-in-out 0s;
			-o-transition: all 1s ease-in-out 0s;
			-moz-transition: all 1s ease-in-out 0s;
			transition: all 1s ease-in-out 0s;
		}
		#hand{
			-webkit-animation:swinging 2s ease-in-out 0s infinite;
			-moz-animation:swinging 2s ease-in-out 0s infinite;
			animation:swinging 2s ease-in-out 0s infinite;
			-webkit-transform-origin: 50% 100%;
			-moz-transform-origin: 50% 100%;
			transform-origin: 50% 100%;
		}

		@-webkit-keyframes swinging{
			0% { -webkit-transform: rotate(.6deg); }
			50% { -webkit-transform: rotate(-.6deg); }
			100% { -webkit-transform: rotate(.6deg); }
		}

		.fxpyq_success_layer_wrap .fx-img img{width: 2.5rem;height: 3.4rem!important;margin-right: 3.7rem;}
		.fxpyq_success_layer_wrap img.more-s{width: .875rem;height: .875rem!important;vertical-align: middle;margin-right: 0;}
		.fx-img .doimg{}
		.fx-img .doimg img{float: right;}
		.pl135{padding-left: 3.25rem!important;}
		.pt105{padding-top: 2.625rem;}
		.pt70{padding-top: 1.75rem !important;}
		.mlr40{margin-left: 1rem;margin-right: 1rem;}
		.borderRadius50{border-radius: 2rem;overflow: hidden;}

		/*二维码弹出*/

		.tan_layer_wrap{
			width: 15.75rem !important;
			height: 18.15rem !important;
			border-radius: 1rem !important;
			overflow: hidden;
			background-color: #ff7900!important;
		}
		.tan_layer_wrap img{width: 8rem!important;margin: 0 auto;}
		.tan_layer_wrap p{height: 2.8rem;line-height: 1rem;padding-top: .45rem;background-color: #F5BD7F;}
		.tan_layer_wrap .layui-layer-setwin .layui-layer-close2{
			right: 12rem;top: 0rem;width: 1.8rem;height: 1rem;/*background: url(../images/close.png) no-repeat center
		center;*/background-size: 1.3rem 1.3rem;z-index: 99999;}
		.tan_layer_wrap .layui-layer-setwin .layui-layer-close2:before{
			content: '关闭';
			font-size: .8rem;
			color: #333;
			font-family: "兰亭黑简"!important;
		}

		.train_layer_wrap {
			width: 15.75rem !important;
			height: 18.15rem !important;
			border-radius: 0.25rem !important;
		}
		.train_layer_wrap .layui-layer-setwin .layui-layer-close2
		{right: 0rem;top: 0rem;width: 1.1rem;height: 1.1rem;background: url(/images/close.png) no-repeat center center;background-size: 1.3rem 1.3rem;z-index: 99999; }
		.train_layer_wrap .bm_success {
			display: block;
		}
		.train_layer_wrap{height: auto!important;}
		.train_layer_wrap .layui-layer-content img{height: 25.55rem!important;}

	</style>
<script>
(function(){
	var html = document.documentElement;
	var hWidth = html.getBoundingClientRect().width;
	html.style.fontSize=hWidth/18.75+'px';
})()
</script>
</head>
<body >

<div>
	
	<!--banner start -->
	<img src="{{env('IMG_URL')}}{{$disCourse->head_url}}" alt="">
	<!--banner end -->


	<!-- 时间 start -->
	<div class="text_center color_gray666 fz f30 ptb30 time ">
		@if($period)
			<p>第{{$period->stage}}期&nbsp;&nbsp;{{date('Y-m-d',strtotime($period->begin_time))}}&nbsp;开营</p>
			<span class="mt10 pb10"></span>
			<p>报名截止：{{date('m-d',strtotime($period->begin_time)-86400)}}日24时</p>
		@endif
	</div>
	<!-- 时间 end -->

	<div class="plr30 text_center color_fff shipin">
		<h3 class="fz f36 pb30 mb20 bold"><i></i>课程试看<i></i></h3>

		<!-- 视频 start -->
		<div class="video">
			<div class="box2">
				<img src="{{env('IMG_URL')}}{{$disCourse->cover_url}}" alt=""/>
				<div class="mask"></div>
				<span class="btn_play"></span>
			</div>
			<video id="video" src="{{$disCourse->video_url}}" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto" ></video>
			{{--<video src="{{$disCourse->video_url}}" controls="controls" x5-playsinline="" playsinline="true" webkit-playsinline="true" x-webkit-airplay="true" x5-video-player-type="h5" x5-video-player-fullscreen="" x5-video-orientation="portraint"></video>--}}
		</div>
		<p class="fz f34 ptb30">{{$disCourse->video_title}}</p>
		<!-- 视频 end -->

		<!--下拉 start-->
		<div class="dumpClass color_orange fz f30 pt40">
			<p><span>点击查看全部课程内容</span><img class="transition3s" src="/images/clock/jiant.png" alt=""></p>

			<img src="{{env('IMG_URL')}}{{$disCourse->course_desc}}" alt="" class="dumpImg">
		</div>
		<!--下拉 end-->
	</div>

	<img src="{{env('IMG_URL')}}{{$disCourse->inc_url}}" alt="">
	@if($disCourse->id == 17)
		@if($flag)
		<div class="right-suspension_wx right-fixed  text_center open-popup" data-target="#Invitation">
			<a href="javascript:void(0)" class="shareRuleImg color_fff fz f26 bold plr30 ptb20">分享</a>
		</div>
		@else
			<div class="right-suspension_wx user_login right-fixed  text_center">
				<a onclick="userlogin();" class="color_fff fz f26 bold plr30 ptb20">分享</a>
			</div>
		@endif
	@endif
	<!-- 悬浮 start-->
	<div class="fixed fz color_fff">
		<ul>
			<!-- <li class="plr30 f28 pt20 pb20 text-jus">点击[ 免费获取课程 ]，将生成的个人海报分享至朋友圈，3位好友关注后即可获取。</li> -->
            @if($flag)
            	@if($is_have)
			    <li class="text_center f32 bold clickTan">报名成功 进入课程</li>
			    @else
				<li class="text_center f32 bold clickFen">免费获取课程</li>
			    @endif
            @else
                <li class="text_center f32 bold"><a href="/login?redirect=/coach/{{$id}}.html">免费获取课程</a></li>
            @endif
		</ul>
	</div>
	<!-- 悬浮 end-->


	<!--弹出分享 start-->
	<div class="bb hide">
		<div class="fxpyq_success_layer_wrap text_center tan-font color_fff f32 fz pt105 fx-img" >
			<p class="doimg clearfix">
				<img src="/images/fenxiang-j.png" class="down-arrow" id="dou" alt="" />
			</p>
			<p class="pt105 color_fff f36 fz bold ">分享一下，即可免费获取课程</p>
			<p class="text_left pl135 pt70 pb30">1、点击“<img src="/images/more.png" alt="" class="d-in-black more-s">”</p>
			<p class="text_left pl135">2、点击“<img src="/images/pyq.png" alt="" class="d-in-black more-s">”分享到朋友圈</p>
			<!-- <p class="pt70 mt16 f36 bold mb10" onclick="window.location.reload()">3、点击刷新</p> -->
		</div>
	</div>
	<!--弹出分享 end-->

	<!-- 弹出二维码 start-->
	<div class="cc hide">
		<div class="text_center fz">
			<h3 class="pt70 f38 color_fff mt30">恭喜您报名成功</h3>
			<p class="f30 mlr40 borderRadius50 mt20 mb40">扫描以下二维码关注公众号 <br>	即可进入课程学习</p>
			<img src="{{$QRcodeUrl}}" alt="">
			
		</div>
	</div>
	<!-- 弹出二维码 end-->

</div>
<br><br><br>
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script>
	var codeurl = "{{$QRcodeUrl}}";
	console.log(codeurl);
	//播放视频
	$(function (){
		$('.video .box2').click(function(){
			$(this).hide();
			$(this).next().trigger('play');
		})
	});



	 function userlogin(){

		var url = "/coach/{{$disCourse->id}}.html?fission_id={{$fission_id}}";
		localStorage.setItem("redirect", url);

		layer.msg('请先注册');
		setTimeout(function(){
			window.location.href = "/register";
		}, 500);
	}

	var block = 1;
	$(".dumpClass p").click(function(){
		$(this).next(".dumpImg").slideToggle("fast");

		if( block == 1 ){
			$(".dumpClass p span").text('点击收起全部课程内容');
			$(".dumpClass p img").css("transform","rotate(180deg)");
			block = 0;
		}else{
			$(".dumpClass p span").text("点击查看全部课程内容");
			$(".dumpClass p img").css("transform","rotate(0deg)");
			block = 1;
		}
	})

	//分享弹窗
	$('.clickFen').click(function(){
		pauseAll();
		layer.open({
			type: 1,
			title: false, //不显示标题栏
			skin: 'fxpyq_success_layer_wrap', //样式类名
			id: 'fxpyq_success_layer', //设定一个id，防止重复弹出
			closeBtn: 0, //不显示关闭按钮
			anim: 2,
			shade:[0.7, '#000'],
			shadeClose: true, //开启遮罩关闭
			area: ['90%', '80%'],
			content: $('.bb'),
			btn: false
		});
	});
	/*点击文字也可以全部关闭*/
	$('.fxpyq_success_layer_wrap').click(function(){
		parent.layer.closeAll()
	});

	// 暂停函数
	function pauseAll() {
		$('#video').remove();

		var video = '<video id="video" src="{{$disCourse->video_url}}" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto" ></video>';
		$('.box2').after(video);
	}

	//分享箭头样式
	var i=0;
	$(document).ready(function(){
		setInterval('gaibian()',1000);
	});
	function gaibian(){
		if(i==0){
			i=1;
			$("#dou").removeClass("zhuan_left");
			$("#dou").addClass("zhuan_right");
		}else{
			i=0;
			$("#dou").addClass("zhuan_left");
			$("#dou").removeClass("zhuan_right");
		}
	}


	$('.clickTan').click(function(){
		pauseAll();
		layer.open({
			type: 1,
			title: false, //不显示标题栏
			skin: 'tan_layer_wrap', //样式类名
			id: 'tan_layer', //设定一个id，防止重复弹出
			closeBtn: 1, //不显示关闭按钮
			anim: 2,
			shade:[0.7, '#000'],
			shadeClose: true, //开启遮罩关闭
			area: ['80%', '60%'],
			content: $('.cc'),
			btn: false
		});
	});
</script>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    var fission_id = "{{$fission_id}}";
    if(fission_id>0){
        localStorage.setItem("fission_id", fission_id);
        console.log(localStorage.getItem('fission_id')+"是否是裂变者");
    }else{
    	console.log("没有裂变者信息");
    }
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
    var fid   = '{{$fid}}';
	var id    = '{{$id}}';
    var link  = 'http://m.saipubbs.com/coach/'+id+'.html?fid='+fid;
    var title = '{{$disCourse->seo_title}}';
    var desc  = '{{$disCourse->seo_desc}}';
    var img   = '{{env('IMG_URL')}}/{{$disCourse->cover_url}}';
    var token1   = '{{csrf_token()}}';
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: img, // 分享图标
            success: function(){
				/*----分享成功赠送课程start----*/
				$.ajax({
					type:"POST",
					url:"/coach/wxshare",
					data:{user_id:fid,dis_id:id, _token:token1},
					dataType:"json",
					success:function(result){
						alert(result.msg);
						locationinfo();
					}
				});

				pauseAll();
				layer.open({
					type: 1,
					title: false, //不显示标题栏
					skin: 'tan_layer_wrap', //样式类名
					id: 'tan_layer', //设定一个id，防止重复弹出
					closeBtn: 1, //不显示关闭按钮
					anim: 2,
					shade:[0.7, '#000'],
					shadeClose: true, //开启遮罩关闭
					area: ['80%', '60%'],
					content: $('.cc'),
					btn: false
				});
				/*----分享成功赠送课程end----*/
			}

        }, function(res) {
            //这里是回调函数

        });
    });

    var locationinfo = function(){
    	//window.location.href = "http://m.saipubbs.com/coach/"+id+".html?"+Math.random();
    }
    var flag = 0;
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: title, // 分享标题
            link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: img, // 分享图标
            success: function(){
				/*----分享成功赠送课程start----*/
				$.ajax({
					type:"POST",
					url:"/coach/wxshare",
					data:{user_id:fid,dis_id:id, _token:token1},
					dataType:"json",
					success:function(result){
						alert(result.msg);
						locationinfo(id);
					}
				});

				pauseAll();
				layer.open({
					type: 1,
					title: false, //不显示标题栏
					skin: 'tan_layer_wrap', //样式类名
					id: 'tan_layer', //设定一个id，防止重复弹出
					closeBtn: 1, //不显示关闭按钮
					anim: 2,
					shade:[0.7, '#000'],
					shadeClose: true, //开启遮罩关闭
					area: ['80%', '60%'],
					content: $('.cc'),
					btn: false
				});
				/*----分享成功赠送课程end----*/
			}

        }, function(res) {
            //这里是回调函数

        });
    });

	$('.shareRuleImg').click(function () {
		$.closePopup();//关闭底部弹出【分销】

		var data = {id:'{{$id}}',_token:'{{csrf_token()}}'};
		$.ajax({
			url:'/coach/share/code.html',
			data:data,
			type:'POST',
			dataType:'json',
			success:function(res){

				if(res.code == 0){
					var content = '<div class="train_layer_wrap text_center tan-font"><img src="'+res.data.shareCode+'" class="bm_success" alt="" /></div>';
					layer.open({
						type: 1,
						title: false, //不显示标题栏
						skin: 'train_layer_wrap', //样式类名
						id: 'train_layer_wrap', //设定一个id，防止重复弹出
						closeBtn: 1, //不显示关闭按钮
						anim: 2,
						shadeClose: true, //开启遮罩关闭
						area: ['90%', '80%'],
						content: content,
						btn: false
					});
				}
			}
		});

	});
</script>
</body>
</html>
