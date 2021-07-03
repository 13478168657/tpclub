@extends('layouts.header')
@section('title')
    <title>个人主页{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link href="/css/my.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<!-- 头部条 start -->
<!-- <div class="fixed_bar_top">
	<header class="header_bar bgc_grey relative">
		<a href="javascript:history.go(-1);" class="btn_back"><i></i></a>
		<h1 class="cat">个人主页</h1>
	</header>
</div> -->
<!-- 头部条 end -->

<!-- 用户登录头像信息 start -->
<div class="weui-cells photo_info bgc_white logged">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<a href="/user/edit" class="user_photo">
				@if($user->avatar)
					@if(strpos($user->avatar,'http') !== false)
						<img src="{{$user->avatar}}" alt="" />
					@else
						<img src="{{env('IMG_URL')}}{{$user->avatar}}" alt="" />
					@endif
				@else
				<img src="/images/my/nophoto.jpg" alt="" />
				@endif
			</a>
			<ul class="info">
				<li>{{$user->name}} 
					@if($user->sex=='male')
					<img src="/images/my/ico_nan.png" alt="男" />
					@elseif($user->sex=='female')
					<img src="/images/my/ico_nv.png" alt="女" />
					@endif
				</li>
				<li class="fans">
					<span>{{$follows}}关注</span>
					<span>{{$fans}}粉丝</span>
					<span>{{$powders}}互粉</span>
				</li>
			</ul>
		</div>
		<div class="weui-cell__ft">
			<!-- <a href="" class="guanzhuBtn">关注</a> -->
		</div>
	</div>
</div>
<!-- 用户登录头像信息 end -->

<!-- 简介 start -->
<div class="bgc_white jianjieCon">
	<p class="h40">{{$user->introduction ? $user->introduction : '暂无简介'}}</p>
	<!-- 没有简介就隐藏按钮 -->
	@if(mb_strlen($user->introduction,'UTF8')>50)
	<i class="arrowBtn"></i>
	@endif
</div>
<!-- 简介 end -->

<!-- 编辑按钮 start -->
<div class="weui-cells bgc_white nobefore noafter">
	<div class="weui-cell">
		<a href="/user/edit" class="weui-btn bgc_yellow grey editBtn"><img src="/images/my/ico_bianji.png" />编辑个人资料</a>
	</div>
</div>
<!-- 编辑按钮 end -->

<!-- 讲师课程 start -->
<div class="weui-cells mt10">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<div class="fs16 bold">讲师课程</div>
		</div>
	</div>
</div>
<!-- 列表 -->
<div class="weui-panel weui-panel_access list_kecheng">
	@if($list)
	<div class="weui-panel__bd" id="list">
			@foreach ($list as $v)
				<div class="weui-media-box weui-media-box_appmsg">
					<div class="weui-media-box__hd">
						<a href="/course/detail/{{$v->id}}.html">
							<img class="weui-media-box__thumb" src="{{env('IMG_URL')}}{{$v->cover_url}}" alt="">
							<span class="">{{$v->cytitle}}</span>
						</a>
					</div>
					<div class="weui-media-box__bd">
						<h4 class="weui-media-box__title"><a href="/course/detail/{{$v->id}}.html">{{$v->title}}</a></h4>
						<h5 class="classes fs12">{{$v->sum_course}} 节课·{{$v->sum_study}} 人正在提高中</h5>
						<!-- <span class="daoshi">{{$v->name}}导师</span> -->
						<div class="weui-cells fz color_gray666 noafter nobefore mt0 ">
                            <div class="weui-cell">
                                <div class="weui-cell__bd f22">
                                    <p>{{$v->name}}</p>
                                </div>
                                @if($v->is_free)
                                <div class="weui-cell__ft color_orange bold f28 color_red">￥{{$v->price}}</div>
                                @else
                                <div class="weui-cell__ft color_orange bold f28">免费</div>
                                @endif
                            </div>
                        </div>
						<div class="swiper-container tags">
							<div class="swiper-wrapper">
								<?php
	                              echo  htmlspecialchars_decode($v->tags)
	                            ?>
							</div>
						</div>
					</div>
				</div>
			@endforeach
	</div>
	<!--加载更多-->
    <div class="weui-loadmore more text_center fz ptb30">
        <!-- <i class="weui-loading"></i> -->
        <span class="weui-loadmore__tips" id="courseclass_more" data-is_ture='1'>加载更多</span>
    </div>
    @else
	<div class="weui-loadmore more text_center fz ptb30">
		<!-- <i class="weui-loading"></i> -->
		<span class="weui-loadmore__tips">暂无课程信息</span>
	</div>
	@endif
</div>
<!-- 讲师课程 end -->
<!-- 功能列表 end -->
<!-- 底部固定导航条 start -->
<br/>
<br/>
<!-- <div class="fixed_bar_bottom">
   <div class="weui-tabbar nav-tabbar">
      <a href="/" class="weui-tabbar__item"><span class="ico_home"></span></a>
      <a href="/article/0.html" class="weui-tabbar__item"><span class="ico_find"></span></a>
      <a href="/user/studying" class="weui-tabbar__item"><span class="ico_study"></span></a>
      <a href="javascript:;" class="weui-tabbar__item weui-bar__item--on"><span class="ico_my"></span></a>
   </div>
</div> -->
<!-- 底部固定导航条 end -->

<script src="/lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
  $(function() {
    FastClick.attach(document.body);
  });
</script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/swiper/swiper.min.js"></script>
<script src="/js/js.js"></script>
<script>
$('.jianjieCon').click(function (){
	$(this).find('p').toggleClass("h40");
	$(this).find('.arrowBtn').toggleClass("up");
})
var swiper = new Swiper('.swiper-container', {
	slidesPerView: 'auto',
	leftedSlides: true,
	spaceBetween: 10,
	grabCursor: true
	// freeMode: true
});
</script>
<script>
    $(document).ready(function() {
        //加载更多
        var page = 1;
        var www  = "{{env('IMG_URL')}}";
        $("#courseclass_more").click(function(){
            page++;
            var type   = 'courseclass';
            var user_id= {{$userid}};
            //如果没有数据就不再请求数据库了
            var is_ture= $(this).attr('data-is_ture');
            if(is_ture<1){
                layer.msg('没有更多课程了');
                return;
            }
            $.ajax({
                type:"GET",
                url:"/user/addmorecourse",
                data:{type:type, user_id:user_id, page:page},
                dataType:"json",
                success:function(result){
                    console.log(result.list);
                    if(result.code==1){
                        for (var i in result.list) {
                        	if(result.list[i].is_free){
                                var text ='<div class="weui-cell__ft color_orange bold f28 color_red">￥'+result.list[i].price+'</div>';
                            }else{
                                var text ='<div class="weui-cell__ft color_orange bold f28">免费</div>';
                            }
                            $("#list").append('<div class="weui-media-box weui-media-box_appmsg">'+
							'<div class="weui-media-box__hd">'+
							'<a href="/course/detail/'+result.list[i].id+'.html">'+
							'<img class="weui-media-box__thumb" src="'+www+result.list[i].cover_url+'" alt="">'+
							'<span class="">'+result.list[i].cytitle+'</span>'+
							'</a>'+
							'</div>'+
							'<div class="weui-media-box__bd">'+
							'<h4 class="weui-media-box__title"><a href="/course/detail/'+result.list[i].id+'.html">'+result.list[i].title+'</a></h4>'+
							'<h5 class="classes fs12">'+result.list[i].sum_course+'节课·'+result.list[i].sum_study+' 人正在提高中</h5>'+
							'<div class="weui-cells fz color_gray666 noafter nobefore mt0 ">'+
                                '<div class="weui-cell">'+
                                    '<div class="weui-cell__bd f22">'+
                                        '<p>'+result.list[i].name+'</p>'+
                                    '</div>'+text+
                                '</div>'+
                            '</div>'+
							'<div class="swiper-container tags">'+
							'<div class="swiper-wrapper">'+result.list[i].tags+'</div>'+
							'</div>'+
							'</div>');
                            var swiper = new Swiper('.swiper-container', {
                                slidesPerView: 'auto',
                                leftedSlides: true,
                                spaceBetween: 10,
                                grabCursor: true
                            });
                        }    
                    }else{
                        $("#courseclass_more").attr('data-is_ture', 0);
                        $("#courseclass_more").text('没有更多课程了');
                        layer.msg(result.msg);
                    }
                }
            });
        });
    });
</script>
@endsection