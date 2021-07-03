@extends('layouts.header')
@section('title')
	<title>{{$title}}{{env('WEB_TITLE_COURSE')}}</title>
	<meta name="author" content="啾啾" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />

@endsection

@section('cssjs')

	<link rel="stylesheet" href="/css/article.css">
	<script>
		(function(){
			var html = document.documentElement;
			var hWidth = html.getBoundingClientRect().width;
			html.style.fontSize=hWidth/18.75+'px';
		})()
	</script>

	@endsection
	@section('content')
</head>
<body ontouchstart>
<!---导航右侧带二维码弹出---->
<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->

	<!--基础私教学院 背景 start-->
	<div class="sijiao text_center color_fff relative">
		<h1 class="lt f48 pt40">{{$title}}</h1>
		<p class="fz f28 pb30 mt16">{{$description}}</p>
		<a href="/course/courseAll/{{$id}}.html" class="f20 color_fff fz text_center">全部</a>
	</div>
	<!--基础私教学院 背景 end-->



	<div>
		<!--标签 start-->
		<div class="plr20 mtb15">
			<ul class="gallery fz f27">
				@foreach($type as $k=>$v)
					<li class="border-radius-img @if($cid == $v->id) active @endif"><a href="/course/ctypeDetail/{{$id}}/{{$v->id}}.html">{{$v->title}}</a></li>
				@endforeach

			</ul>
		</div>
		<!--标签 end-->
@if(isset($new->id))

		<!-- 灰色的边框 start -->
		<div class="h20grey" style="display: none;"></div>
		<!-- 灰色的边框 end -->

		<!--最近更新的课程 start-->

		<!-- <div class="sijiao_update plr30 mb30" style="display: none;">

			<h2 class="lt f32 color_333 text_center mt30 pb15 mb10">最近更新的课程</h2>

			<div class="sijiao_update_list color_333">
				<a href="/course/detail/{{$new->id}}.html">
					<div class="sijiao_update_img  border-radius-img relative">
						<img src="{{env('IMG_URL')}}{{$new->explain_url}}" alt="" class="border-radius-img ">
						<p class="fz f22 bold bgcolor_orange">{{$new->level}}</p>
					</div>
					<h3 class="lt f30 mt20 mb10 letter04">{{$new->title}}</h3>
					<div class="weui-cells noafter nobefore mt0">
						<div class="weui-cell mt0  padding0 ">
							<div class="weui-cell__bd fz f24 color_gray666">
								<p>{{sum_course($new->id)->count}} 节课·{{sum_study($new->id)->count + $new->count}} 人正在提高中</p>
							</div>
							@if($new->is_free == 1)
								@if(sum_course($new->id)->count == 1)
                                    <div class="weui-cell__ft color_orange f28 color_red">¥{{$new->price}}</div>
                                @else
                                    <div class="weui-cell__ft color_orange f28 color_red">可试看</div>
                                @endif
							@else
								<div class="weui-cell__ft color_orange bold f28">免费</div>
							@endif
						</div>
					</div>
				</a>
				<div class="wrap1 fz mt30">
					<span class="daoshi fl f22 color_4a"><span>{{get_teacher_name($new->user_id)->name}} 导师</span></span>
					<div class="swiper-container tags fr f24 color_gray666">
						<div class="swiper-wrapper  ">
							@foreach($new->tagArr as $a)
								@if(isset($a))
								<div class="swiper-slide border-radius-img"><a href="/course/tagdetail/{{$a->id}}.html"><span>{{$a->title}}</span></a></div>
								@endif
							@endforeach
						</div>
					</div>
				</div>
			</div>

		</div> -->
		<!--最近更新的课程 end-->
@endif
<?php $count =  count($data);?>
@if($count > 0)
@foreach($data as $a=>$c)

@foreach($c as $b=>$k)

		<!-- 灰色的边框 start -->
		<div class="h20grey"></div>
		<!-- 灰色的边框 end -->

		<!--Part1-运动术语 start-->

		<div class="sijiao_update plr30 mb30">
			

			@if($b == 0)<h2 class="lt f32 color_333 text_center mt30 pb15 mb10">{{$k->typeName}}</h2>@endif
			
				<div class="sijiao_update_list color_333">
					<a href="/course/detail/{{$k->id}}.html">
					<div class="sijiao_update_img  border-radius-img relative">
						<img src="{{env('IMG_URL')}}{{$k->explain_url}}" alt="" class="border-radius-img">
						<p class="fz f22 bold bgcolor_orange">{{$k->level}}</p>
					</div>
					<h3 class="lt f30 mt20 mb10 letter04">{{$k->title}}</h3>
					<div class="weui-cells noafter nobefore mt0">
						<div class="weui-cell mt0  padding0 ">
							<div class="weui-cell__bd fz f24 color_gray666">
								<p> {{sum_course($k->id)->count}} 节课·{{sum_study($k->id)->count + $k->count}} 人正在提高中</p>
							</div>
							@if($k->is_free == 1)
								<!-- <div class="weui-cell__ft fz f28 color_orange bold mr30">可试看</div> -->
								@if(sum_course($k->id)->count == 1 || $k->preview == 0)
                                    <div class="weui-cell__ft color_orange f28 color_red">¥{{$k->price}}</div>
                                @else
                                    <div class="weui-cell__ft color_orange f28 color_red">可试看</div>
                                @endif
							@else
								<div class="weui-cell__ft color_orange bold f28">免费</div>
							@endif
						</div>
					</div>
				    </a>
					<div class="wrap1 fz mt30">
						<span class="daoshi fl f22 color_4a"><span>{{get_teacher_name($k->user_id)->name}}导师</span></span>
						<div class="swiper-container tags fr f24 color_gray666">
							<div class="swiper-wrapper  ">
							@if(isset($k['tagArr']))
								@foreach($k['tagArr'] as $a)
 									@if(isset($a))
										<div class="swiper-slide border-radius-img"><a href="/course/tagdetail/{{$a->id}}.html"><span>{{$a->title}}</span></a></div>
									@endif
								@endforeach
							@endif
							</div>
						</div>
					</div>
				</div>
			
		</div>

		<!--Part1-运动术语 end-->
	@endforeach	
@endforeach


@else
			<div class="weui-loadmore more text_center fz ptb45 remove_attr " id="study_more">
				<span class="weui-loadmore__tips" >暂时没有课程哦</span>
			</div>
@endif


		

@if(isset($img->cover_url))
<!-- 灰色的边框 start -->
		<div class="h20grey"></div>
		<!-- 灰色的边框 end -->
		<!--完成Part1的学习 start-->
		<div class="bg-jiangpai text_center fz color_fff">
			<img src="{{env('IMG_URL')}}{{$img->cover_url}}" alt="" class="">
			<!--<p class="f30 mt10 bold">完成Part1的学习</p>
			<p class="f20 pb30">你可以获得以下能力</p>-->
		</div>
@endif
		<!--<div class="plr30 mlr30 jiangpai-list mt30 mb40 pb30">
			<ul class="clearfix fz f24 color_4a">
				<li>定制合理的营养餐</li>
				<li>定制合理的营养餐</li>
				<li>定制合理的营养餐</li>
				<li>定制合理的营养餐</li>
			</ul>
		</div>-->
		<!--完成Part1的学习 end-->


		<!-- 灰色的边框 start -->
		<div class="h20grey"></div>
		<!-- 灰色的边框 end -->

	</div>




</div><!--导航大盒子id=page 结束-->

<br><br><br>
<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
	$(function() {
		FastClick.attach(document.body);
	});
</script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->
<!-- swiper -->
<script src="/lib/swiper/swiper.min.js"></script>
<script>
	$(function (){
		//弹窗
		$('.baomingBtn').click(function(){
			layer.open({
				type: 1,
				title: false, //不显示标题栏
				skin: 'bm_success_layer_wrap', //样式类名
				id: 'bm_success_layer', //设定一个id，防止重复弹出
				closeBtn: 0, //不显示关闭按钮
				anim: 2,
				shadeClose: true, //开启遮罩关闭
				area: ['80%', '70%'],
				content:'<div class="bm_success_layer text_center"><div class="mt30 pt30"><p class="lt bold color_333 f30">识别二维码</p><p class="fz color_gray666 f24 mt10">关注赛普健身社区公众号</p></div><img src="/images/qr.png" class="bm_success" alt="" /><div><p class="lt bold color_333 f30 mt10">更新实时提醒</p><p class="fz color_gray666 f24 mt20">不错过每一次的精彩</p></div></div>',
				btn:false
			});
		})

		/*滑动*/
		var swiper = new Swiper('.swiper-container', {
			slidesPerView: 'auto',
			spaceBetween: 10
		});
	})
</script>
@endsection
