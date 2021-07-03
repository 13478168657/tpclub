@extends('layouts.header')
@section('title')
    <title>{{$k}}-搜索结果{{env('WEB_TITLE')}}</title>
    <meta name="description" content="" />
    <title>{{$k}}-搜索结果-专业的健身行业资讯垂直搜索{{env('WEB_TITLE')}}</title>
    <meta name="description" content="普搜索致力于为健身教练提供健身图文、健身问答以及专业课程等信息，帮助健身教练更好解决工作、训练中遇到的问题。内容包括问答、视频、文章、训练动作等，涉及增肌、减脂、普拉提、孕产、康复等多个方向" />
    <meta name="keywords" content="健身,健身教练,康复,增肌,减脂" />
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/article.css?t=1">
    <style>
    	#page {padding-bottom:3rem;}
    	.hide{display: none;}
    </style>
@endsection
@section('content')	
<div id="page">
	<!--导航大盒子id=page 开始  【结束在最底部】-->
	<!--隐藏导航内容-->
	<nav id="menu"></nav>
	<!--头部导航 end-->


	<div class="page_search_result fz">
		<div class="plr30">
			<div class="searchWrap">
				<input type="text" class="input" placeholder="搜索问答、课程、文章" value="{{$k}}" />
				<span class="btn_ss"></span>
			</div>
			<ul class="clearfix searchConditions">
				<li class="on"><a href="javascript:void(0)">回答</a></li>
				<li><a href="javascript:void(0)">课程</a></li>
				<li><a href="javascript:void(0)">文章</a></li>
				<!-- <li><a href="javascript:void(0)">作者</a></li> -->
			</ul>
			<div class="searchResult">
				<div class="list_wenda">
                    @if($questionList->count())
					<ul>
                        @foreach($questionList as $question)
						<li>
							<div class="weui-cell padding0 qaImg fz">
								<div class="weui-cell__hd">
                                    <?php
                                    $user = $question->user;
                                    ?>
                                    @if($user)
                                        @if((strpos($user->avatar,'http') !== false))
                                            <img src="{{$user->avatar}}" alt="" class="img100 border-radius50">
                                        @else
                                            @if(!empty($user->avatar))
                                                <img src="{{env('IMG_URL')}}{{$user->avatar}}" alt="" class="img100 border-radius50">
                                            @else
                                                <img src="/images/my/nophoto.jpg" alt="" class="img100 border-radius50">
                                            @endif
                                        @endif
                                    @else
                                        <img src="/images/my/nophoto.jpg" alt="" class="img100 border-radius50">
                                    @endif
                                </div>
								<div class="weui-cell__bd">
                                    <?php
                                        $length = strlen($question->title);
                                        if($length >= 10){
                                            $title = mb_substr($question->title,0,10).'...';
                                        }else{
                                            $title = $question->title;
                                        }
                                    ?>
									<p class="d-in-black bold color_gray666 f26">
                                        <a href="/cak/answer/{{$question->id}}/1.html">
                                            @if($user)
                                                @if($user->name)
                                                    {{$user->name}}
                                                @elseif($user->nickname)
                                                    {{$user->nickname}}
                                                @else
                                                    {{'暂无昵称'}}
                                                @endif
                                            @else
                                                {{'暂无姓名'}}
                                            @endif
                                        </a>
                                    </p>
									@if($user && $user->userAttr)
										@if($user->userAttr->is_verify==1)
											<p class="d-in-black ren"><img src="/images/ren.jpg" alt=""></p>
										@endif
									@endif
									<p class="d-in-black color_gray666">提问</p>
								</div>

								<!--<div class="weui-cell__ft">5小时前</div>-->
							</div>
							<p class="qaText f28 fz color_333 mt20 text-jus"><a href="/cak/answer/{{$question->id}}/1.html"><?php echo $question->title;?></a></p>
						</li>
                        @endforeach
					</ul>
                    @else
                        <div class="weui-loadmore more text_center fz ptb30">
                            <span class="weui-loadmore__tips">抱歉~暂无问答</span>
                        </div>
                    @endif
				</div>
				<div  class="hide">
					@if($courses->count())
					<ul class="list_kecheng">
						@foreach ($courses as $course)
						<li>
							<a href="/course/detail/{{$course->id}}.html" class="thumb">
								<img src="{{env('IMG_URL')}}{{$course->cover_url}}" alt="">
							</a>
							<div class="con">
								<h3 class="title text-overflow"><a href="/course/detail/{{$course->id}}.html">{{$course->title}}</a></h3>
								<h4 class="classes fs12">{{$course->sum_course}} 节课·{{$course->sum_study}} 人正在提高中</h4>
								<div class="clearfix wrap">
									<span class="daoshi fl">{{$course->author ? $course->author->name : '--'}} 导师</span>
									@if($course->is_free)
                                   	<span class="price fr f28 red">￥{{$course->price}}</span>
                                    @else
                                    <span class="price fr f28 yellow">免费</span>
                                    @endif
								</div>
								<div class="swiper-container tags">
									<div class="swiper-wrapper">
										<?php
                                          echo  htmlspecialchars_decode($course->tags)
                                        ?>
									</div>
								</div>
							</div>
						</li>
						@endforeach
					</ul>
					@else
						<div class="weui-loadmore more text_center fz ptb30">
					        <span class="weui-loadmore__tips">抱歉~暂无课程</span>
					    </div>
					@endif

				</div>
				<div class="hide">
					@if($articlelist->count())
					<ul class="list_wenzhang">
						@foreach ($articlelist as $article)
						<li>
							<a href="/article/detail/{{$article->id}}.html" class="thumb">
								<img class="border-radius-img" src="{{env('IMG_URL')}}{{$article->cover_url}}" alt="">
							</a>
							<div class="con">
								<h3 class="title text-overflow2"><a href="/article/detail/{{$article->id}}.html">{{$article->title}}</a></h3>
								<div class="clearfix userInfo">
									<a href="javascript:;">
										<!-- <img src="/images/xy.png" alt="" /> -->
										@if($article->author)
											@if(strpos($article->author->avatar,'http') !== false)
												<img src="{{$article->author->avatar}}" class="border-radius50" />
											@else
												<img src="{{env('IMG_URL')}}{{$article->author->avatar}}" alt="头像" class="border-radius50" />
											@endif
										@else
										<img class="border-radius50" src="/images/my/nophoto.jpg" alt="头像" />
										@endif
									</a>
									<span>{{$article->author ? $article->author->name : '社区'}}</span>
								</div>
								<div class="clearfix wrap">
									<span class="date">{{substr($article->created_at,0, 10)}}</span>
									<span class="love">{{$article->likes}}</span>
									<span class="times">{{$article->views}}</span>
								</div>
							</div>
						</li>
						@endforeach
					</ul>
					@else
					    <div class="weui-loadmore more text_center fz ptb30">
					        <span class="weui-loadmore__tips">抱歉~暂无文章</span>
					    </div>
					@endif
				</div>
				<div class="hide">
					<ul class="list_zuozhe">
						<li>
							<dl>
								<dt>
									<a href="#" class="userInfo">
										<img src="/images/xy.png" alt="">
									</a>
								</dt>
								<dd>
									<span class="name">Jane King </span>
									<span class="intro">科学有效的跑步方案</span>
								</dd>
							</dl>
							<a href="#" class="btn_guanzhu btn1">关注</a>
						</li>
						<li>
							<dl>
								<dt>
									<a href="#" class="userInfo">
										<img src="/images/xy.png" alt="">
									</a>
								</dt>
								<dd>
									<span class="name">Jane King </span>
									<span class="intro">科学有效的跑步方案</span>
								</dd>
							</dl>
							<a href="#" class="btn_guanzhu btn1">关注</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!--边距30 end-->

</div>
<!--导航大盒子id=page 结束-->

<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jquery-ui/jquery-ui.js" type="text/javascript"></script>
<link href="/lib/jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css" />
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
  $(function() {
    FastClick.attach(document.body);
  });
</script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/swiper/swiper.min.js"></script>
<script>
	function getCookie(name) 
	{ 
	    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	 
	    if(arr=document.cookie.match(reg))
	 
	        return unescape(arr[2]); 
	    else 
	        return null; 
	} 
	var cookie = {
		set: function(name, value) {
			var Days = 30;
			var exp = new Date();
			exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
			document.cookie = name + '=' + escape(value) + ';expires=' + exp.toGMTString();
		},
		get: function(name) {
			var arr, reg = new RegExp('(^| )' + name + '=([^;]*)(;|$)');
			if(arr = document.cookie.match(reg)) {
				return unescape(arr[2]);
			} else {
				return null;
			}
		},
		del: function(name) {
			var exp = new Date();
			exp.setTime(exp.getTime() - 1);
			var cval = getCookie(name);
			if(cval != null) {
				document.cookie = name + '=' + cval + ';expires=' + exp.toGMTString();
			}
		}
	};
	
	var k  = cookie.get("k");
	console.log(k);
	if(k){
		var newk = JSON.parse(k);
		for(var i in newk){
			$("#old_keyword").append('<a href="/searchr.html?k='+newk[i]+'">'+newk[i]+'</a>');
		}
	}
</script>
<script type="text/javascript">
	//搜索
	$('.btn_ss').click(function (){
		var val=$(this).prev().val();
		var karr = new Array();
		if(val==''){
			layer.msg("请输入关键字");
			return;
		}else{
			var oldk = cookie.get("k");
			if(oldk){
				oldk = JSON.parse(oldk);
				//筛选是否有重复值
				var is_insert = 1;
				for(var o in oldk){
					if(val == oldk[o]){
						is_insert = 0;
					}
				}
				console.log(val);
				if(is_insert==1){
					oldk.unshift(val);
					cookie.set('k', JSON.stringify(oldk));
				}
			}else{
				karr.unshift(val);
				cookie.set('k', JSON.stringify(karr));
			}
			window.location.href = "/searchr.html?k="+val;
		}
		
	})

	//筛选
	$('.searchConditions li').click(function (){
		var index=$(this).index();
		$(this).addClass('on').siblings().removeClass('on');
		$('.searchResult>div').eq(index).show().siblings().hide();

		var swiper = new Swiper('.swiper-container', {
			slidesPerView: 'auto',
			leftedSlides: true,
			spaceBetween: 10,
			grabCursor: true
			// freeMode: true
		});
	})


	//自动完成数据
	$(".searchWrap .input").autocomplete({
	    source: [ 
	        "增肌增肌增肌",
	        "ChineseChinese",
	        "English",
	        "Spanish",
	        "Russian",
	        "French",
	        "Japanese",
	        "Korean",
	        "German"
	    ]
	})
	/*window.onload = function(){
		menuFixed('nav_keleyi_com');
	}*/
</script>
@endsection