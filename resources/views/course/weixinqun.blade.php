@extends('layouts.header')
@section('title')
    <title>微信群{{env('WEB_TITLE')}}</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
@endsection

@section('cssjs')
	<style>
		.swiper-container {width: 100%;height: 100%;}
		.swiper-slide {
			/* Center slide text vertically */
			display: -webkit-box;
			display: -ms-flexbox;
			display: -webkit-flex;
			display: flex;
			-webkit-box-pack: center;
			-ms-flex-pack: center;
			-webkit-justify-content: center;
			justify-content: center;
			-webkit-box-align: center;
			-ms-flex-align: center;
			-webkit-align-items: center;
			align-items: center;
		}
		.swiper-pagination-bullet-active{background:rgba(0,0,0,.7);}

		.plr98{padding-left:2.45rem;padding-right: 2.45rem;}
		.bgPink{background: rgba(250,108,17,0.10);}
		.borderPink{border: 1px solid rgba(250,108,17,0.40);}
		.pt85{padding-top: 2.125rem;}
		.pb90{padding-bottom: 2.25rem;}

		.conPink{margin: 0 auto;}
		.conPink img{width: 60%;}
		.disn{display: inline-block;padding-left: .75rem;padding-right: .75rem;height: 1.55rem;line-height: 1.55rem;}
		.listPink h4{height: 2.525rem;line-height: 2.525rem;color: #FA6C11;}
	</style>
	<script>
		(function(){
			var html = document.documentElement;
			var hWidth = html.getBoundingClientRect().width;
			html.style.fontSize=hWidth/18.75+'px';
		})()
	</script>
@endsection

@section('content')
	<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->

		<!--头部导航 start-->
		{{--<div class="mh-head Sticky">--}}

			{{--<div class=" menu-bg-logo">--}}
			{{--<span class="mh-btns-left">--}}
				{{--<a class="icon-menu icon-sousuo" href="javascript:;"></a>--}}
			{{--</span>--}}
			{{--<span class="mh-btns-right">--}}
				{{--<a class="icon-menu" href="#menu"></a>--}}
				{{--<a class="icon-menu" href="#page"></a>--}}
			{{--</span>--}}
			{{--</div>--}}
		{{--</div>--}}


		<!-- start-->
		<div>
			<!-- Swiper -->
			<div class="swiper-container">
				<div class="swiper-wrapper">
					<div class="swiper-slide">

						<!--1 start-->
						<div class="color_333 plr98 conPink text_center pt85 pb90">
							<img src="/images/zt/wxG.png" alt="">
							<p class=" f30 bold pb10">长按识别添加管理员微信</p>
							<p class=" f30 bold">加入【冠军训练营】线上社群</p>
							<p class="bgcolor_orange disn f30 border-radius50 mt30 mb20">备注：增肌</p>

							<div class="fz f30 bold listPink mt30 borderPink">
								<h4 class="bgPink bold">• 进群福利 •</h4>
								<ul class="color_333  pt40 mt10 mb40 ">
									<li class="pb30">专业老师在线答疑</li>
									<li class="pb30">每日健身知识分享</li>
									<li class="pb30">不定期健身技巧直播</li>
								</ul>
							</div>
						</div>
						<!--1 end-->

					</div>
					<div class="swiper-slide">

						<!--2 start-->
						<div class="color_333 plr98 conPink text_center pt85 pb90">
							<img src="/images/zt/wxG.png" alt="">
							<p class=" f30 bold pb10">长按识别添加管理员微信</p>
							<p class=" f30 bold">加入【孕产教练养成营】线上社群</p>
							<p class="bgcolor_orange disn f30 border-radius50 mt30 mb20">备注：孕产</p>

							<div class="fz f30 bold listPink mt30 borderPink">
								<h4 class="bgPink bold">• 进群福利 •</h4>
								<ul class="color_333  pt40 mt10 mb40 ">
									<li class="pb30">专业老师在线答疑</li>
									<li class="pb30">每日健身知识分享</li>
									<li class="pb30">定期产后恢复直播</li>
								</ul>
							</div>
						</div>
						<!--2 end-->

					</div>
					<div class="swiper-slide">

						<!--3 start-->
						<div class="color_333 plr98 conPink text_center pt85 pb90">
							<img src="/images/zt/wxG.png" alt="">
							<p class=" f30 bold pb10">长按识别添加管理员微信</p>
							<p class=" f30 bold">加入【康复教练养成营】线上社群</p>
							<p class="bgcolor_orange disn f30 border-radius50 mt30 mb20">备注：康复</p>

							<div class="fz f30 bold listPink mt30 borderPink">
								<h4 class="bgPink bold">• 进群福利 •</h4>
								<ul class="color_333  pt40 mt10 mb40 ">
									<li class="pb30">专业老师在线答疑</li>
									<li class="pb30">每日健身知识分享</li>
									<li class="pb30">定期运动康复直播</li>
								</ul>
							</div>
						</div>
						<!--3 end-->

					</div>
				</div>
				<!-- Add Pagination -->
				<div class="swiper-pagination"></div>
			</div>

		</div>
		<!-- end-->



	</div><!--导航大盒子id=page 结束-->


	<script src="/js/jquery-1.11.2.min.js"></script>
	<!-- Swiper JS -->
	<script src="/lib/swiper/swiper.min.js"></script>
	<!-- Initialize Swiper -->
	<script>
		var swiper = new Swiper('.swiper-container', {
			pagination: '.swiper-pagination',
			paginationClickable: true
		});
	</script>
	<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
	<script src="/lib/layer/layer.js"></script>

	<!--nav logo menu 导航条-->
	<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
	<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
	<script src="/lib/mmenu/js/jquery.mhead.js"></script>
	<!--end-->
@endsection