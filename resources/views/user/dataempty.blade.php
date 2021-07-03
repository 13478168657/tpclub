<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
		<title>赛普社区-各种头部样式</title>
		<meta name="author" content="啾啾" />
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
		<link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
		<!--mmenu.css start-->
		<link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
		<link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
		<link href="/css/nav-mmenu-public.css" rel="stylesheet" />
		<!--end-->
		<link href="/css/reset.css" rel="stylesheet" type="text/css" />
		<link href="/css/font-num40.css" rel="stylesheet" >

		<link rel="stylesheet" href="/css/xueyuan.css">
		<script>
		(function(){
			var html = document.documentElement;
			var hWidth = html.getBoundingClientRect().width;
			html.style.fontSize=hWidth/18.75+'px';
		})()
		</script>
	</head>
<body ontouchstart>
<!---导航右侧带二维码弹出---->
<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->

    <!-------------------------------------------本喵是模块分割线-------------------------------------------------------->

	<!--中标题-->
	<div class="mt20">
		<div class="weui-cells nobefore noafter mt0 fz bold xuyuan-title">
			<div class="weui-cell">
				<div class="weui-cell__bd text_center">
					<p>最热课程</p>
				</div>
			</div>
			<hr class="mlr20">
		</div>
	</div>

	<!--列表1 start-->
	<div class="list bgcolor_fff plr30">
		<ul>
			<a href="/course/detail/{{$hot->id}}.html">
			<li class="ptb40">
				<dl class="clearfix">
					<dt class="border-radius-img"><img src="{{env('IMG_URL')}}{{$hot->cover_url}}" alt="" /><span class="bgcolor_orange text_center fz color_333">{{$hot->cytitle}}</span></dt>
					<dd>
						<h3 class="fz bold text-overflow">{{$hot->title}}</h3>
						<p class="fz color_gray666">{{$hot->sum_course}}节课·{{$hot->sum_study}} 人正在提高中</p>
						<div class="weui-cells fz color_gray666 noafter nobefore mt0 ">
							<div class="weui-cell">
								<div class="weui-cell__bd">
									<p>{{$hot->name}}</p>
								</div>
								@if($hot->is_free)
                                <div class="weui-cell__ft color_orange f28 color_red">可试看</div>
                                @else
                                <div class="weui-cell__ft color_orange bold f28">免费</div>
                                @endif
							</div>
						</div>
						<!--<p class="fz color_gray999">Jane King 导师</p>-->
						<div class="text_center fz">
							<!-- Swiper -->
							<div class="swiper-container">
								<div class="swiper-wrapper">
									<?php
                                      echo  htmlspecialchars_decode($hot->tags)
                                    ?>
								</div>
							</div>
						</div>

					</dd>
				</dl>
			</li>
			</a>
		</ul>
	</div>
	<!--列表1 end-->

    <!-------------------------------------------本喵是模块分割线-------------------------------------------------------->

	<!--中标题-->
	<div class="mt20">
		<div class="weui-cells nobefore noafter mt0 fz bold xuyuan-title">
			<div class="weui-cell">
				<div class="weui-cell__bd text_center">
					<p>免费课程</p>
				</div>
			</div>
			<hr class="mlr20">
		</div>
	</div>

	<div class="bgcolor_fff plr30">

		<!--列表2 start-->
		<div class="list">
			<ul>
				@foreach ($free as $v)
                <a href="/course/detail/{{$v->id}}.html">
                    <li class="ptb30">
                    <dl class="clearfix">
                        <dt class="border-radius-img"><img src="{{env('IMG_URL')}}{{$v->cover_url}}" alt="" /><span class="bgcolor_orange text_center fz color_333">{{$v->cytitle}}</span></dt>
                        <dd>
                            <h3 class="lt text-overflow">{{$v->title}}</h3>
                            <p class="fz color_gray666">{{$v->sum_course}} 节课·{{$v->sum_study}} 人正在提高中</p>
                            <!-- <p class="fz color_gray999">{{$v->name}}老师</p> -->
                            <div class="weui-cells fz color_gray666 noafter nobefore mt0 ">
                                <div class="weui-cell">
                                    <div class="weui-cell__bd f22">
                                        <p>{{$v->name}} 导师</p>
                                    </div>
                                    @if($v->is_free)
                                    <div class="weui-cell__ft color_orange f28 color_red">可试看</div>
                                    @else
                                    <div class="weui-cell__ft color_orange bold f28">免费</div>
                                    @endif
                                </div>
                            </div>
                            <div class="text_center fz">
                                <!-- Swiper -->
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <?php
                                          echo  htmlspecialchars_decode($v->tags)
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </dd>
                    </dl>
                </li>
                </a>
                @endforeach
			</ul>
		</div>
		<!--列表2 end-->
</div><!--导航大盒子id=page 结束-->
<script src="/js/swiper.min.js"></script>
<script type="text/javascript">
	var swiper = new Swiper('.swiper-container', {
		slidesPerView: 'auto',
		leftedSlides: true,
		spaceBetween: 10,
		grabCursor: true
	});
</script>
<!-- 底部固定导航条 end -->
</body>
</html>
