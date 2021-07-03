@extends('layouts.headercode')
@section('title')
    <title>{{$title}}{{env('WEB_TITLE')}}</title>
    <meta name="description" content="{{$description}}" />
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/article.css">
    <style>
    	#page {padding-bottom:3rem;}
    </style>
    <!-- 熊掌号搜索出图20181114海洋 -->
    <script type="application/ld+json">
        {
            "@context": "https://ziyuan.baidu.com/contexts/cambrian.jsonld",
            "@id": "http://m.saipubbs.com//article/{{$type_id}}.html",
            "appid": "1615100668980398",
            "title": "{{$title}}",
            "images": [
                "{{env('IMG_URL')}}{{$articlelist[0]->cover_url}}"
            ], //请在此处添加希望在搜索结果中展示图片的url，可以添加1个或3个url
            "pubDate": "{{substr($articlelist[0]->created_at,0, 10)}}T{{substr($articlelist[0]->created_at,-8)}}" // 需按照yyyy-mm-ddThh:mm:ss格式编写时间，字母T不能省去
        }
    </script>
@endsection
@section('content')
<!---导航右侧带导航弹出---->

	<!--头部导航 start-->
	<!-- <div class="mh-head Sticky">
		<div class=" menu-bg-logo">
			<span class="mh-btns-left">
				<a class="icon-menu icon-sousuo" href="javascript:;"></a>
			</span>
			<span class="mh-btns-right">
				<a class="icon-menu erweima icon-erweima" href="javascript:;"></a>
			</span>
		</div>
	</div> -->
	<!--隐藏导航内容-->
	<nav id="menu"></nav>
	<!--头部导航 end-->
	<div class="plr30">
		<!--文章导航 start-->
		<div class="swiper-art-mar0 clearfix ptb20">
			<!-- Swiper -->
			<div class="swiper-container swiper-art-nav">
				<div class="swiper-wrapper f26 fz ">
					<div class="swiper-slide index_0 width-set" style="width:38px;" data-index="0"><a href="/article/0.html" class="color_4a ">精选</a></div>
					@if($typelist->count())
						@foreach($typelist as $k=>$item)
							<?php

//							dd(mb_strlen($item->title,'utf-8') == 2?'width-set':"");
							?>
						<div class="swiper-slide index_{{$item->id}} {{mb_strlen($item->title,'utf-8')==2?'width-set':''}} {{mb_strlen($item->title,'utf-8')==3?'width-setting':''}} {{mb_strlen($item->title,'utf-8')==4?'width-settings':''}}"  data-index="{{$k+1}}">
							<a href="/article/{{$item->id}}.html" class="color_4a">{{$item->title}}</a>
						</div>
						@endforeach
					@endif
				</div>
			</div>
			<!--下箭头-->
			<div class="icon-art-list text_right">
				<div class="text_right"><img src="/images/icon-xiala.png"></div>
			</div>
		</div>
		<!--文章导航 end-->


		<!--文章banner 标题内容-->
		<div class="art-list-content">

			<!--小图list-->
			<div>
				<div class="list-art">
					<ul id="index_article_list">
					@if($articlelist->count())
						@foreach($articlelist as $k=>$article)
							@if($article->is_video)
								<li @if($k==0) class="pt30  li-top-noborder" @else class="pt30" @endif>	
									<a href="/article/detail/{{$article->id}}.html">
									<!--大图 start-->
									<div class="max-img border-radius-img mb20 relative">
										<img class="max-img-banner" src="{{env('IMG_URL')}}{{$article->cover_url}}" />
										@if($article->is_selected)
										<img class="icon-new-hot" src="/images/icon-hot.png" />
										@else
											@if(article_isnew($article->created_at))
											<img class="icon-new-hot" src="/images/icon-new.png" />
											@endif
										@endif
										<img class="icon-bofang" src="/images/bofang.png" />
									</div>
									<h3 class="f30 color_333 lt">{{$article->title}}</h3>
									<div class="weui-cells noafter nobefore mt0 art-list-title pb10">
									<a href="javascript:;">

										<div class="weui-cell padding0" >
											<div class="weui-cell__hd border-radius50">
												@if($article->author->avatar)
													@if(strpos($article->author->avatar,'http') !== false)
														<img src="{{$article->author->avatar}}" class="border-radius50" />
													@else
														<img src="{{env('IMG_URL')}}{{$article->author->avatar}}" alt="头像" class="border-radius50" />
													@endif
												@else
												<img src="/images/my/nophoto.jpg" alt="头像" class="border-radius50" />
												@endif
											</div>
											<div class="weui-cell__bd fz f28 color_gray666 mtb20">
												<p>{{$article->author->name}}<span class="color_gray9b f22 pl20">{{substr($article->created_at,0, 10)}}</span></p>
											</div>
											<div class="weui-cell__ft fz f20 color_gray9b yudu-img">
												<span class=""><img src="/images/icon-xiao-xihuan.png" alt="">{{$article->likes}}</span>
												<span class="pl20"><img src="/images/icon-xiao-yuedu.png" alt="">{{$article->views}}</span>
											</div>
										</div>
										</a>
									</div>
									<!--大图 end-->
									</a>
								</li>
							@else
							<li @if($k==0) class="pt30 pb30 li-top-noborder" @else class="pt30 pb30" @endif>
								<a href="/article/detail/{{$article->id}}.html">
									<dl class="clearfix relative">
										<dt class="border-radius-img">
											<img src="{{env('IMG_URL')}}{{$article->cover_url}}" />
											@if($article->is_selected)
											<img class="icon-new-hot" src="/images/icon-hot.png" />
											@else
												@if(article_isnew($article->created_at))
												<img class="icon-new-hot" src="/images/icon-new.png" />
												@endif
											@endif
										</dt>
										<dd>
											<h3 class="lt f30 color_333 text-overflow2">{{$article->title}}</h3>
											<div class="weui-cells nobefore noafter padding0 art-list-title mt0">
												<div class="weui-cell nobefore noafter padding0 mt20">
													<div class="weui-cell__hd border-radius50">
														@if($article->author->avatar)
															@if(strpos($article->author->avatar,'http') !== false)
																<img src="{{$article->author->avatar}}" class="border-radius50" />
															@else
																<img src="{{env('IMG_URL')}}{{$article->author->avatar}}" alt="头像" class="border-radius50" />
															@endif
														@else
														<img class="border-radius50" src="/images/my/nophoto.jpg" alt="头像" class="border-radius50" />
														@endif
													</div>
													<div class="weui-cell__bd f28 fz color_gray666 ">
														<p>{{$article->author->name}}</p>
													</div>
												</div>

												<div class="weui-cell nobefore noafter padding0">
													<div class="weui-cell__bd mt10">
														<time datetime="{{substr($article->created_at,0, 10)}}" pubdate="pubdate"></time>
														<p class="color_gray9b f22 fz">{{substr($article->created_at,0, 10)}}</p>
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
											</div>
										</dd>
									</dl>
								</a>
							</li>
							@endif
						@endforeach
					@endif
					</ul>
				</div>
			</div>

			@if($articlelist->count())
		    <div class="weui-loadmore more text_center fz ptb30">
			        <!-- <i class="weui-loading"></i> -->
			        <span class="weui-loadmore__tips" id="article_more" data-is_ture='1'>加载更多</span>
			    </div>
		    @else
			    <div class="weui-loadmore more text_center fz ptb30">
			        <span class="weui-loadmore__tips">暂无文章</span>
			    </div>
		    @endif
			<!--小图 end-->
			<!--推荐文章-->
			<div class="relative" style="">
				<div id="hiddle-button" class="hiddle-button f34 fz pb22 pt26 text_center border-radius-img bgcolor_orange">
					<a href="/article/recommend"><img src="/images/icon-tuijian.png" alt="推荐文章">推荐文章</a>
				</div>
			</div>

		</div>

	</div><!--边距30 end-->

<!--=======================================================================================-->
<!--=======================================================================================-->
<!--=======================================================================================-->
<!-- <div class="fixed_bar_bottom">
	<div class="weui-tabbar nav-tabbar">
		<a href="/" class="weui-tabbar__item"><span class="ico_home"></span></a>
		<a href="javascript:;" class="weui-tabbar__item weui-bar__item--on"><span class="ico_find"></span></a>
		<a href="/user/studying" class="weui-tabbar__item"><span class="ico_study"></span></a>
		<a href="/user/index" class="weui-tabbar__item"><span class="ico_my"></span></a>
	</div>
</div> -->
<div class="relative">
    <div class="fixed_bottom_4 clearfix">
        <a href="/"><span class="icon-home"></span></a>
        <a href="/article/0.html" class="on"><span class="icon-find"></span></a>
        <a href="/user/studying"><span class="icon-study"></span></a>
        <a href="/user/index"><span class="icon-my"></span></a>
    </div>
</div>
	<div id="cur_html" style="display:none">
		<div class="top-art-list-hide">
			<ul class="clearfix plr30 text_center f24 fz ">
				<li><a href="/article/0.html">精选</a>
				@foreach($typelist as $item)
					<li><a href="/article/{{$item->id}}.html">{{$item->title}}</a>
				@endforeach
			</ul>
		</div>
	</div>
<br><br><br>
<!-- <br><br><br> -->
<!-- <br><br><br> -->
<!-- 报名成功弹窗 start -->
<!--<div class="bm_success_layer hide">-->
	<!--<img src="/images/bm_success.png" class="bm_success" alt="" />-->
	<!--<dl>-->
		<!--<dt><img src="/images/qr.png" alt="" /></dt>-->
		<!--<dd>扫描二维码获得课程提醒</dd>-->
	<!--</dl>-->
<!--</div>-->
<!-- 报名成功弹窗 end -->

<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
  $(function() {
    FastClick.attach(document.body);
  });
</script>
<!-- <script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>
 -->
<!--nav logo menu 导航条-->
<!-- <script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script> -->
<!--end-->

<!-- Swiper JS -->
<script src="/lib/swiper/swiper.min.js"></script>
<!-- Initialize Swiper -->
<script>
	var events = navigator.userAgent;
	var mobile = 'phone';
	if(events.indexOf('Android')>-1 || events.indexOf('Linux')>-1 || events.indexOf('Adr')>-1){
		console.log("安卓手机");
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

	var id = "{{$cid}}";
	var length = $('.swiper-art-nav .swiper-slide').length;

	var indexId = $('.index_'+id).attr('data-index');
	var flag = false;

	if(length >=6 && (indexId >=2 && (indexId <=length-4))){
		flag = true;
	}

	var cid = indexId;
	var swiper = new Swiper('.swiper-art-nav', {
		pagination: '.swiper-pagination',
		slidesPerView:6,////可见个数2
		initialSlide :cid,//默认第一个
		centeredSlides: flag,//居中
		paginationClickable: true,
		spaceBetween: 20,
		slidesOffsetAfter : 40,
	});
	if(mobile == 'phone'){
		if(indexId <= 3){
			$('.swiper-wrapper').css({'transform': 'translate3d(0px,0px,0px)'});
		}
		if(indexId >= 5 && (indexId >=length -4)){
			$('.swiper-wrapper').css({'transform': 'translate3d(-120px,0px,0px)'});
		}
		// $('.swiper-art-nav .width-set').css('width','35px');
		// $('.swiper-art-nav .width-setting').css('width','45px');
		// $('.swiper-art-nav .width-settings').css('width','68px');
	}else{
		if(indexId <= 3){
			$('.swiper-wrapper').css({'transform': 'translate3d(0px,0px,0px)'});
		}
		if(indexId >= 5 && (indexId >=length -4)){
			$('.swiper-wrapper').css({'transform': 'translate3d(-150px,0px,0px)'});
		}
		// $('.swiper-art-nav .width-set').css('width','45px');
		// $('.swiper-art-nav .width-setting').css('width','55px');
		// $('.swiper-art-nav .width-settings').css('width','77px');
	}


	$('.swiper-art-nav .swiper-slide').eq(cid).find('a').addClass('font-active').parent().siblings().find('a').removeClass('font-active');
	$('.swiper-art-nav .swiper-slide').each(function(){
	   var a_w=$(this).find('a').outerWidth();
	   console.log(a_w);
	   $(this).width(a_w)
	})

	$(function (){
		/*文章内导航list*/
		$(".icon-art-list").click(function(){
			var content = $("#cur_html").html();
			layer.open({
				type: 1,
				title: false,
				id: 'top-art-list-hide',
				skin: 'top-art-list-hide1', //样式类名
				closeBtn: 0,
				shadeClose: true,
				content:content
			});
			/**/
			/*$('.top-art-list-hide ul li').eq(cid).addClass('bold').siblings().removeClass('bold');*/
			/**/
		})
	})
</script>

<script>
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


		//加载更多
	    var page = 1;
	    var type_id = "{{$type_id}}";
	    var type   = "type";
	    var token  = '{{csrf_token()}}';
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
	            url:"/article/addmorei",
	            data:{type_id:type_id, page:page, type:type},
	            dataType:"json",
	            success:function(result){
	                console.log(result);
	                if(result.code==1){
	                    for (var item in result.list) {
	                    	var url = "/article/detail/"+ result.list[item].id+".html";
	                    	if((result.list[item].avatar).indexOf("http") > -1){
		                            var img = result.list[item].avatar;
	                        }else{
	                            var img = imgUrl+result.list[item].avatar;
	                        }
	                        if(result.list[item].user_name){
	                            var name = result.list[item].user_name;
	                        }else{
	                            var name = "--";
	                        }
	                        if(result.list[item].is_selected){
	                        	
	                        	var tuiguang = "<img class='icon-new-hot' src='/images/icon-hot.png' alt=''>";
	                        }else{
	                        	var tuiguang = "";
	                        }
	                        if(result.list[item].is_video){
	                        	var video  = '<img class="icon-bofang" src="/images/bofang.png" alt="">';
	                        	$("#index_article_list").append('<li class="li-top-noborder">'+
										'<a href="'+url+'">'+
										'<div class="max-img border-radius-img mb20 relative">'+
											'<img class="max-img-banner" src="'+imgUrl+result.list[item].cover_url+'" alt="">'+tuiguang+
											'<img class="icon-bofang" src="/images/bofang.png" alt="">'+
										'</div>'+
										'<h3 class="f30 color_333 lt">'+result.list[item].title+'</h3>'+
										'<div class="weui-cells noafter nobefore mt0 art-list-title pb10">'+
											'<a class="weui-cell padding0" href="javascript:;">'+
												'<div class="weui-cell__hd border-radius50"><img src="'+img+'" class="border-radius50"></div>'+
												'<div class="weui-cell__bd fz f28 color_gray666 mtb20">'+
													'<p>'+name+'<span class="color_gray9b f22 pl20">2018.09.25</span></p>'+
												'</div>'+
												'<div class="weui-cell__ft fz f20 color_gray9b yudu-img">'+
													'<span class=""><img src="../images/icon-xiao-xihuan.png" alt="">'+result.list[item].likes+'</span>'+
													'<span class="pl20"><img src="../images/icon-xiao-yuedu.png" alt="">'+result.list[item].views+'</span>'+
												'</div>'+
											'</a>'+
										'</div>'+
										'</a>'+
									'</li>');
	                        }else{
	                        	$("#index_article_list").append('<li class="pt30 pb30"><a href="'+url+'">' +
								'<dl class="clearfix relative">' +
								'<dt class="border-radius-img">' +
								'<img src="'+imgUrl+result.list[item].cover_url+'" alt="" />'+tuiguang+
								'</dt>' +
								'<dd>' +
								'<h3 class="lt f30 color_333 text-overflow2">'+result.list[item].title+'</h3>' +
								'<div class="weui-cells nobefore noafter padding0 art-list-title mt0"><div class="weui-cell nobefore noafter padding0 mt20">' +
								'<div class="weui-cell__hd border-radius50"><img src="'+img+'" class="border-radius50"></div><div class="weui-cell__bd f28 fz color_gray666 ">' +
								'<p>'+name+'</p>' +
								'</div>' +
								'</div>' +
								'' +
								'<div class="weui-cell nobefore noafter padding0"><div class="weui-cell__bd mt10">' +
								'<time datetime="'+result.list[item].created+'" pubdate="pubdate"></time><p class="color_gray9b f22 fz">'+result.list[item].created+'</p>' +
								'</div>' +
								'<div class="weui-cell__ft fz f20 color_gray9b yudu-img">' +
								'<span class=""><img src="/images/icon-xiao-xihuan.png" alt="">'+result.list[item].likes+'</span>' +
								'<span class="pl20"><img src="/images/icon-xiao-yuedu.png" alt="">'+result.list[item].views+'</span>' +
								'</div>' +
								'</div>' +
								'</div>' +
								'</dd></dl></a></li>');
	                        }
	                    }
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