@extends('layouts.header')
@section('title')
    <title>{{$title}}{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/xueyuan.css">
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth/18.75 + "px";
        })()
    </script>
@endsection
@section('content')
	<!--隐藏导航内容-->
	<nav id="menu"></nav>
	<!--头部导航 end-->

    <!-------------------------------------------本喵是模块分割线-------------------------------------------------------->

    <!--您的课表是空的 start-->
    <div class="ke-kong bgcolor_fff plr30 text_center">
        <div class="ptb45 color_gray666 fz f28">
            <img src="/images/ke-nono.png" alt="">您的{{$title}}是空的~
        </div>
        <div class="ke-kong-btn clearfix pb30 fz f34 color_333">
            <a class="fl bgcolor_orange border-radius-img ptb20" href="/">查看课程</a>
            <a class="fr bgcolor_orange border-radius-img ptb20" href="/article/0.html">读读文章</a>
        </div>
    </div>
    <!--您的课表是空的 end-->

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

        <!-------------------------------------------本喵是模块分割线---------------------------------------------------------->

</div><!--导航大盒子id=page 结束-->

<br><br><br><br><br>
<!-- 底部固定导航条 start -->
{{--<div class="fixed_bar_bottom">--}}
   {{--<div class="weui-tabbar nav-tabbar">--}}
      {{--<a href="/" class="weui-tabbar__item"><span class="ico_home"></span></a>--}}
      {{--<a href="/article/0.html" class="weui-tabbar__item"><span class="ico_find"></span></a>--}}
      {{--<a href="/user/studying" class="weui-tabbar__item"><span class="ico_study"></span></a>--}}
      {{--<a href="/user/index" class="weui-tabbar__item "><span class="ico_my"></span></a>--}}
   {{--</div>--}}
{{--</div>--}}
	<div class="relative">
		<div class="fixed_bottom_4 clearfix">
			<a href="/"><span class="icon-home"></span></a>
			<a href="/article/0.html"><span class="icon-find"></span></a>
			<a href="/cak/1.html"><span class="icon-ask"></span></a>
			<a href="/user/studying" class="on"><span class="icon-study"></span></a>
			<a href="/user/index"><span class="icon-my"></span></a>
		</div>
	</div>
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
@endsection