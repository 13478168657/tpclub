@extends('layouts.header')
@section('title')
<title>{{$title}}{{env('WEB_TITLE_COURSE')}}</title>
<meta name="author" content="啾啾" />
<meta name="keywords" content="" />
<meta name="description" content="" />
@endsection

@section('cssjs')

	<!--文章下css-->
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

<!---导航右侧带导航弹出---->

<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->


	<div class="">
		<div class="page_dailySelection">

			<!--文章导航 start-->
			<!--导航 start-->
			<div class="swiper-art-mar1 clearfix">
				<!-- Swiper -->
				<div class="swiper-container swiper-art-nav1 fz">
					<div class="swiper-wrapper f28 ">
						@foreach($tags as $k=>$v)
							<div class="swiper-slide index_{{$v->id}}" data-cid="{{$k}}"><a href="/course/courseAll/{{$v->id}}.html" >{{$v->title}}</a></div>
						@endforeach
						<!--<div class="swiper-slide index_2" data-cid="1"><a href="javascript:void (0)">减脂</a></div>
						<div class="swiper-slide index_3" data-cid="2"><a href="javascript:void (0)">塑性</a></div>
						<div class="swiper-slide index_4" data-cid="3"><a href="javascript:void (0)">增肌</a></div>
						<div class="swiper-slide index_5" data-cid="4"><a href="javascript:void (0)" class="font-active">营养恢复</a></div>
						<div class="swiper-slide index_6" data-cid="5"><a href="javascript:void (0)">健美竞技</a></div>
						<div class="swiper-slide index_7" data-cid="6"><a href="javascript:void (0)">体态康复</a></div>
						<div class="swiper-slide index_8" data-cid="7"><a href="javascript:void (0)">其他</a></div>-->
					</div>
				</div>
				<!--下箭头-->
				<div class="icon-xiala"></div>
			</div>

			<!-- 灰色的边框 start -->
		<!-- 	<div class="h20grey"></div> -->
			<!-- 灰色的边框 end -->

	@if(isset($new->level))
			<!--最近更新的课程 start-->
		<!-- 	<div class="sijiao_update plr30 mb30">
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
								@if(sum_course($new->id)->count == 1 || $new->preview == 0)
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
						<div class="swiper-container swiper-container-t tags fr f24 color_gray666">
							<div class="swiper-wrapper">
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
<div  id ="content_a">

@foreach($data as $v)


			<!-- 灰色的边框 start -->
			<div class="h20grey"></div>
			<!-- 灰色的边框 end -->

			<!--文章banner 标题内容-->
			<div class="art-list-content plr30 mt30 ">
				<div class="sijiao_update_list color_333">
					<a href="/course/detail/{{$v->id}}.html">
					<div class="sijiao_update_img  border-radius-img relative">
						<img src="{{env('IMG_URL')}}{{$v->explain_url}}" alt="" class="border-radius-img ">
						<p class="fz f22 bold bgcolor_orange">{{$v->level}}</p>
					</div>
					<h3 class="lt f30 mt20 mb10 letter04">{{$v->title}}</h3>
					<div class="weui-cells noafter nobefore mt0">
						<div class="weui-cell mt0  padding0 ">
							<div class="weui-cell__bd fz f24 color_gray666">
								<p>{{sum_course($v->id)->count}} 节课·{{sum_study($v->id)->count + $v->count}} 人正在提高中</p>
							</div>
							@if($v->is_free == 1)
								@if(sum_course($v->id)->count == 1 || $v->preview == 0)
                                    <div class="weui-cell__ft color_orange f28 color_red">¥{{$v->price}}</div>
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
						<span class="daoshi fl f22 color_4a"><span>{{get_teacher_name($v->user_id)->name}} 导师</span></span>
						<div class="swiper-container swiper-container-t tags fr f24 color_gray666">
							<div class="swiper-wrapper">
								@foreach($v->tagArr as $a)
									@if(isset($a))
										<div class="swiper-slide border-radius-img"><a href="/course/tagdetail/{{$a->id}}.html"><span>{{$a->title}}</span></a></div>
									@endif
								@endforeach
							</div>
						</div>
					</div>
				</div>
				<!--大图 end--><br/><br/>
				</div>
	


@endforeach
	</div>
			<br/><br/>
			<div class="text_center ptb40">
				<b  class="fz f26 color_gray9b d-in-black study_more" id ="add_more"  data-is_ture='1'>加载更多</b>
			</div>
		@else
		
		<br/><br/>
				<div class="weui-loadmore more text_center fz ptb45 remove_attr ">
					<span class="weui-loadmore__tips" >暂时没有课程哦</span>
				</div>
		@endif



			<!-- 半透明蒙版 start -->
			<div class="bg_mask">
				<div class=""></div>
				<ul class="nav-list1 f28 fz">
					@foreach($tags as $k=>$v)
						<li><a href="/course/courseAll/{{$v->id}}.html">{{$v->title}}</a></li>
					@endforeach
				</ul>
			</div>
			<!-- 半透明蒙版 end -->
		</div>
	</div><!--边距30 end-->


</div><!--导航大盒子id=page 结束-->


<!--推荐文章-->


<!--=======================================================================================-->
<!--=======================================================================================-->
<!--=======================================================================================-->

<div class="fixed_bar_bottom">
	<div class="weui-tabbar nav-tabbar">
		<a href="/" class="weui-tabbar__item"><span class="ico_home"></span></a>
		<a href="/article/0.html" class="weui-tabbar__item"><span class="ico_find"></span></a>
		<a href="/user/studying" class="weui-tabbar__item"><span class="ico_study"></span></a>
		<a href="/user/index" class="weui-tabbar__item"><span class="ico_my"></span></a>
	</div>
</div>
<br><br><br>
<br><br><br>
<br><br><br>
<!-- 报名成功弹窗 start -->
<!--<div class="bm_success_layer hide">-->
	<!--<img src="../images/bm_success.png" class="bm_success" alt="" />-->
	<!--<dl>-->
		<!--<dt><img src="../images/qr.png" alt="" /></dt>-->
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
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->

<!-- Swiper JS -->
<script src="/lib/swiper/swiper.min.js"></script>
<!-- Initialize Swiper -->
<script>
	var a = 2;

	$(".study_more").click(function(){
		var number = $("#add_more").attr("data-is_ture");
		
		if(number == 1) {
			$.ajax({
				type: "get",
				url: "/course/getCourseJson/{{$tagid}}/" + a,
				//data:{page:i},
				dataType: "json",
				success: function (data) {

					if (!jQuery.isEmptyObject(data)) {
						$.each(data, function (index, json) {
							var str = "";
							var str = str + '<div class="h20grey"></div><div class="art-list-content plr30 mt30"><div class="sijiao_update_list color_333">';
							var str = str + '<a href="/course/detail/' + json['id'] + '.html"><div class="sijiao_update_img  border-radius-img relative">';
							var str = str + '<img src="{{env('IMG_URL')}}' + json["explain_url"] + '" alt="" class="border-radius-img ">';
							if(json["level"] == null){
								var str = str + '<p class="fz f22 bold bgcolor_orange"></p> </div>';

							}else{
								var str = str + '<p class="fz f22 bold bgcolor_orange">' + json["level"] + '</p> </div>';
							}

							var str = str + '<h3 class="lt f30 mt20 mb10 letter04">' + json['title'] + '</h3><div class="weui-cells noafter nobefore mt0"> <div class="weui-cell mt0  padding0 "> <div class="weui-cell__bd fz f24 color_gray666">';
							var str = str + '<p>' + json['sum_course'] + ' 节课·' + json['sum_study'] + '人正在提高中</p> </div>';
							if (json['is_free'] == 1) {
								if(json['sum_course'] == 1 || json['preview'] == 0){
									var str = str + '<div class="weui-cell__ft color_orange f28 color_red">¥'+json['price']+'</div>';
								}else{
									var str = str + '<div class="weui-cell__ft color_orange f28 color_red">可试看</div>';
								}
							} else {
								var str = str + '<div class="weui-cell__ft color_orange bold f28">免费</div>';
							}
							var str = str + '</div></div></a><div class="wrap1 fz mt30"><span class="daoshi fl f22 color_4a"><span>' + json['teacher_name'] + ' 导师</span></span> <div class="swiper-container swiper-container-t tags fr f24 color_gray666"> <div class="swiper-wrapper">';
							for (var i = 0; i < json['tagArr'].length; i++) {
								if(!json['tagArr']){
									var str = str + '<div class="swiper-slide border-radius-img"><a href="/course/tagdetail/' + json['tagArr'][i]['id'] + '.html"><span>' + json['tagArr'][i]['title'] + '</span></a></div>';
								}
							}
							var str = str + '</div> </div> </div> </div> <br/><br/> </div>';
							$("#content_a").append(str);

						})

						a++;
						var swiper = new Swiper('.swiper-container', {
							slidesPerView: 'auto',
							leftedSlides: true,
							spaceBetween: 10,
							grabCursor: true
						});
					} else {
						$("#add_more").attr("data-is_ture", 0);
						$("#add_more").text("没有更多课程了");
						layer.msg('没有更多课程啦');
					}
				}

			});
		}else{
			layer.msg('没有更多课程啦');
		}


	})



</script>
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
		var cid='{{$tagid}}';
		var datacid=parseInt($('.index_'+cid).attr('data-cid'));
		var id = "{{$tagid}}";
		var length = $('.swiper-art-nav1 .swiper-slide').length;

		var indexId = $('.index_'+id).attr('data-cid');

		var flag = false;
		var tt = 3;
		if(length >=3 && (indexId >=1 && (indexId <=length-2))){
			flag = true;
		}
		var swiper = new Swiper('.swiper-art-nav1', {
			pagination: '.swiper-pagination',
			slidesPerView:4,////可见个数
			initialSlide :datacid,//默认第一个
			centeredSlides: flag,//居中
			paginationClickable: true,
			spaceBetween: 10,
			slidesOffsetAfter :10,
		});
		if(mobile == 'phone'){
			if(indexId <= 2){
				$('.swiper-art-nav1 .swiper-wrapper').css({'transform': 'translate3d(0px,0px,0px)'});
			}
			if(indexId ==3){
				$('.swiper-art-nav1 .swiper-wrapper').css({'transform': 'translate3d(-140px,0px,0px)'});
			}
			if(indexId >= 4 && (indexId >=length -4)){
				$('.swiper-art-nav1 .swiper-wrapper').css({'transform': 'translate3d(-140px,0px,0px)'});
			}
		}else{
			if(indexId < 2){
				$('.swiper-art-nav1 .swiper-wrapper').css({'transform': 'translate3d(0px,0px,0px)'});
			}
			if(indexId >= 4 && (indexId <=length -3)){
				$('.swiper-art-nav1 .swiper-wrapper').css({'transform': 'translate3d(0px,0px,0px)'});
			}
//			if(indexId == 5){
//				$('.swiper-art-nav1 .swiper-wrapper').css({'transform': 'translate3d(-200px,0px,0px)'});
//			}

		}

		$('.swiper-art-nav1 .swiper-slide a').removeClass('font-active');
		//$(".swiper-art-nav1 .swiper-slide").eq(datacid).find('a').addClass('font-active');
		$('.swiper-art-nav1 .swiper-slide').eq(datacid).find('a').addClass('font-active');
		//swiper.slideTo(cid, 1000, false);//切换到第一个slide，速度为1秒
		//


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



	//弹窗
	$('.erweima').click(function(){
		layer.open({
			type: 1,
			title: false, //不显示标题栏
			skin: 'bm_success_layer_wrap', //样式类名
			id: 'bm_success_layer', //设定一个id，防止重复弹出
			closeBtn: 0, //不显示关闭按钮
			anim: 2,
			shadeClose: true, //开启遮罩关闭
			area: ['80%', '70%'],
			content:'<div class="bm_success_layer text_center"><div class="mt30 pt30"><p class="lt bold color_333 f30">识别二维码</p><p class="fz color_gray666 f24 mt10">关注赛普健身社区公众号</p></div><img src="../images/qr.png" class="bm_success" alt="" /><div><p class="lt bold color_333 f30 mt10">更新实时提醒</p><p class="fz color_gray666 f24 mt20">不错过每一次的精彩</p></div></div>',
			btn:false
		});
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

	//底部导航默认选中样式
	var links=document.querySelectorAll(".nav-tabbar a")
	var currenturl = document.location.href;
	var last = 0;
	for (var i=0;i<links.length;i++)
	{
		var linkurl =  links[i].getAttribute("href");
		if(currenturl.indexOf(linkurl)!=-1)
		{
			last = i;
		}
	}
	links[last].classList.add("weui-bar__item--on");   //高亮代码样式



</script>


@endsection
