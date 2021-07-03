@extends('layouts.headercode')
@section('title')
    <title>赛普热文-{{$title}}-优质健身知识聚集地{{env('WEB_TITLE')}}</title>
    <meta name="description" content="{{$description}}" />
    <meta name="keywords" content="增肌,减脂,塑形,训练技术,运动营养,健美竞技,体态康复" />
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/article.css">
    <style>
    	#page {padding-bottom:3rem;}
    </style>
@endsection
@section('content')
<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->

	<!--隐藏导航内容-->
	<!-- <nav id="menu"></nav> -->
	<!--头部导航 end-->


	<div class="">
		<div class="page_dailySelection">
			<!--文章导航 start-->
			<!--导航 start-->
			<div class="swiper-art-mar1 clearfix">
				<!-- Swiper -->
				<div class="swiper-container swiper-art-nav1 fz">
					<div class="swiper-wrapper f28">
						<div class="swiper-slide index_0" data-cid="0">
							<a href="/article/0.html">精选</a>
						</div>
						@if($typelist->count())
							@foreach($typelist as $k=>$item)
								<div class="swiper-slide index_{{$item->id}}" data-cid="{{$k+1}}">
									<a href="/article/{{$item->id}}.html">{{$item->title}}</a>
								</div>
							@endforeach
						@endif
					</div>
				</div>
				<!--下箭头-->
				<div class="icon-xiala"></div>
			</div>

			<!-- 头 start -->
			@if($selected->count())
			@foreach($selected as $item)
			<div class="head-art clearfix fz">
				<dl class="fl">
					<dt class="f32 mb20 bold">每日精选</dt>
					<dd class="f20 color_gray666">每天早上10:00，与您分享</dd>
				</dl>
				<p class="fr bold"><b class="f36 mr5 font-Oswald-Medium">{{str_replace('-', '.',$item->today)}}</b><span>期</span></p>
			</div>
				
				<div class="art-list-content plr30 mt30" id="">
					<!--大图list-->
					<div>
						<div class="list-art">
							<ul>
								@foreach(get_articla_selected($item->article_ids) as $article)
								<li class="li-top-noborder">
									<a href="/article/detail/{{$article->id}}.html">
									<!--大图 start-->
									<div class="max-img border-radius-img mb20 relative height9">
										@if($article->is_video)
										<div class="new_mask"></div>
										@endif
										<img class="max-img-banner" src="{{env('IMG_URL')}}{{$article->cover_url}}" alt="{{$article->title}}" />
										@if($article->is_selected)
										<img class="icon-new-hot" src="/images/icon-hot.png" />
										@else
											@if(article_isnew($article->created_at))
											<img class="icon-new-hot" src="/images/icon-new.png" />
											@endif
										@endif
										@if($article->is_video)
										<img class="icon-bofang" src="/images/bofang.png" />
										@endif
									</div>
									<h3 class="f30 color_333 lt">{{$article->title}}</h3>
									<div class="weui-cells noafter nobefore mt0 art-list-title pb10">
										<a href="">
											<div class="weui-cell padding0">
												<div class="weui-cell__hd border-radius50">
													<?php
														$getUser = getUsers($article->user_id);
													?>
													@if($getUser)
														@if(strpos($getUser->avatar,'http') !== false)
															<img src="{{getUsers($article->user_id)->avatar}}" class="border-radius50" />
														@elseif($getUser->avatar)
															<img src="{{env('IMG_URL')}}{{getUsers($article->user_id)->avatar}}" alt="头像" class="border-radius50" />
														@else
															<img src="/images/my/nophoto.jpg"/>
														@endif
													@else
														<img src="/images/my/nophoto.jpg" alt="头像" class="border-radius50" />
													@endif
												</div>
												<div class="weui-cell__bd fz f28 color_gray666 mtb20">
													<p>{{$getUser->name}}
														<span class="color_gray9b f22 pl20">{{substr($article->created_at,0, 10)}}</span>
													</p>
												</div>
												<div class="weui-cell__ft fz f20 color_gray9b yudu-img">
													<span class="">
														<img src="/images/icon-xiao-xihuan.png" alt="">
														{{$article->likes}}
													</span>
													<span class="pl20">
														<img src="/images/icon-xiao-yuedu.png" alt="">
														{{$article->views}}
													</span>
												</div>
											</div>
										</a>
									</div>
									</a>
								</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
				
			@endforeach
			@endif
			<!--文章banner 标题内容-->
	

	@if($selected->count())
    	<div class="weui-loadmore more text_center fz ptb30" id="selected_list">
	        <!-- <i class="weui-loading"></i> -->
	        <span class="weui-loadmore__tips" id="article_more" data-is_ture='1'>加载更多</span>
	    </div>
    @else
	    <div class="weui-loadmore more text_center fz ptb30">
	        <span class="weui-loadmore__tips">暂无文章</span>
	    </div>
    @endif

			<!--推荐文章-->
			<div class="relative">
				<div id="hiddle-button"
					 class="hiddle-button f28 fz pb22 pt26 text_center border-radius-img bgcolor_orange">
					<a href="/article/recommend"><img src="/images/icon-tuijian.png" alt="">推荐文章</a>
				</div>
			</div>


			<!-- 半透明蒙版 start -->
			<div class="bg_mask">
				<div class=""></div>
				<ul class="nav-list1 f28 fz">
					<li><a href="/article/0.html">精选</a></li>
					@foreach($typelist as $k=>$item)
						<li><a href="/article/{{$item->id}}.html">{{$item->title}}</a></li>
					@endforeach
				</ul>
			</div>
			<!-- 半透明蒙版 end -->
		</div>
	</div><!--边距30 end-->


</div><!--导航大盒子id=page 结束-->
<!--=======================================================================================-->

<div class="relative">
    <div class="fixed_bottom_4 clearfix">
        <a href="/"><span class="icon-home"></span></a>
        <a href="/article/0.html" class="on"><span class="icon-find"></span></a>
        <a href="/cak/1.html"><span class="icon-ask"></span></a>
        <a href="/user/studying"><span class="icon-study"></span></a>
        <a href="/user/index"><span class="icon-my"></span></a>
    </div>
</div>
<br><br><br>

<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>

<!-- Swiper JS -->
<script src="/lib/swiper/swiper.min.js"></script>
<!-- Initialize Swiper -->

<script>
$(function (){
	$(function (){
		var events = navigator.userAgent;
		var mobile = 'phone';
		if(events.indexOf('Android')>-1 || events.indexOf('Linux')>-1 || events.indexOf('Adr')>-1){
			mobile = '';
		}else if(events.indexOf('iPhone')>-1){
			//根据尺寸进行判断 苹果的型号
			if(screen.height == 812 && screen.width == 375){// 进行操作，改变样式
				//console.log("苹果X");
			}else if(screen.height == 736 && screen.width == 414){
				mobile = 'phonePlus';
			}else if(screen.height == 667 && screen.width == 375){
				//console.log("iPhone7 - iPhone8 - iPhone6");
			}else if(screen.height == 568 && screen.width == 320){
				//console.log("iPhone5");
			}else if(events.indexOf('Windows Phone')>-1){
				//console.log("诺基亚手机");
			}else{
				//console.log("iPhone4");
			}

		}else if(events.indexOf("iPad")>-1){

		}
		//导航
		var cid="{{$cid}}";
		var datacid=parseInt($('.index_'+cid).attr('data-cid'));
		var id = "{{$cid}}";
		var length = $('.swiper-art-nav1 .swiper-slide').length;

		var indexId = $('.index_'+id).attr('data-cid');

		var flag = false;

		if(length >=4 && (indexId >=1 && (indexId <=length-2))){
			flag = true;
		}
		var cid = indexId;
		var swiper = new Swiper('.swiper-art-nav1', {
			pagination: '.swiper-pagination',
			slidesPerView:4,////可见个数
			initialSlide :datacid,//默认第一个
			centeredSlides: flag,//居中
			paginationClickable: true,
			spaceBetween: 0,
			slidesOffsetAfter : 10,
		});
		$('.swiper-art-nav1 .swiper-slide a').removeClass('font-active');
		$('.swiper-art-nav1 .swiper-slide').eq(datacid).find('a').addClass('font-active');
		//swiper.slideTo(cid, 1000, false);//切换到第一个slide，速度为1秒
		// if(mobile == 'phone'){
		// 	if(indexId <= 4){
		// 		$('.swiper-wrapper').css({'transform': 'translate3d(-160px,0px,0px)'});
		// 	}
		// 	if(indexId >= 6 && (indexId >=length -2)){
		// 		$('.swiper-wrapper').css({'transform': 'translate3d(-400px,0px,0px)'});
		// 	}
		// }else{
		// 	if(indexId <= 4){
		// 		$('.swiper-wrapper').css({'transform': 'translate3d(-160px,0px,0px)'});
		// 	}
		// 	if(indexId >= 6 && (indexId >=length -2)){
		// 		$('.swiper-wrapper').css({'transform': 'translate3d(-400px,0px,0px)'});
		// 	}
		// }

		var flag1=false;
		$('.icon-xiala').click(function (){
			if(!flag1){
				$(this).addClass('up');
				$('body').addClass('fixed100');//解决移动端滚动穿透
				$('.bg_mask').fadeIn(400).show();
				$('.nav-list1').slideDown(400);

			}else{
				$(this).removeClass('up');
				$('body').removeClass('fixed100');
				$('.bg_mask').hide();
				$('.nav-list1').slideUp();
			}
			flag1=!flag1;
		});
	});

})
</script>

<script>
	/*滑动*/
	var swiper = new Swiper('.swiper-container-t', {
		slidesPerView: 'auto',
		spaceBetween: 10
	});

	//推荐文章
	$(document).ready(function() {
		//首先将#hiddle-button隐藏
		$("#hiddle-button").hide();
		//当滚动条的位置处于距顶部100像素以下时，跳转链接出现，否则消失
		$(function() {
			$(window).scroll(function() {
				if ($(window).scrollTop() > 200) {
					$("#hiddle-button").fadeIn(1000);
				}
				else {
					$("#hiddle-button").fadeOut(1000);
				}
			});
		});
	});
</script>
<script>
	$(document).ready(function() {
		//加载更多
	    var page = 1;
	    var imgUrl = "{{env('IMG_URL')}}";  //图片公共地址
	    $("#article_more").click(function(){
	        page++;
	        //如果没有数据就不再请求数据库了
	        var is_ture= $(this).attr('data-is_ture');
	        if(is_ture<1){
	            layer.msg('抱歉没有更多的数据了');
	            return;
	        }
	        $.ajax({
	            type:"get",
	            url:"/article/selectedmore",
	            data:{page:page},
	            dataType:"json",
	            success:function(result){
	                console.log(result);
	                if(result.code==1 && result.list!=""){
	                     $("#selected_list").before(result.list); 
	                }else{
	                    $("#article_more").attr('data-is_ture', 0);
	                    $("#article_more").text('抱歉没有更多的数据了');
	                    layer.msg(result.msg);
	                }
	            }
	        });
	    });
	});
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
	wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
		wx.onMenuShareAppMessage({
			title: '{{$title}}{{env('WEB_TITLE')}}', // 分享标题
			desc: '{{$description}}', // 分享描述
			link: "http://m.saipubbs.com/article/{{$type_id}}.html", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
			imgUrl: "http://m.saipubbs.com/images/tubiao/1.png", // 分享图标
		}, function(res) {
			//这里是回调函数
		});
	});
	wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
		wx.onMenuShareTimeline({
			title: '{{$title}}{{env('WEB_TITLE')}}', // 分享标题
			link: "http://m.saipubbs.com/article/{{$type_id}}.html", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
			imgUrl: "http://m.saipubbs.com/images/tubiao/1.png", // 分享图标
		}, function(res) {
			//这里是回调函数
		});
	});
	//将裂变者id写入本地  用于存储上下级关系
	localStorage.setItem("fission_id", "{{$fission_id}}");
</script>
@endsection