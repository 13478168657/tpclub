@extends('layouts.header')
@section('title')
    <title>{{$article->title}}{{env('WEB_TITLE')}}</title>
    <meta name="description" content="{{$article->description}}" />
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/article.css?t=1.32">
    <link rel="stylesheet" type="text/css" href="/css/qikan.css">
	<link rel="stylesheet" type="text/css" href="/css/zt/zt_RightFloat.css">
    <style>
    	#page {padding-bottom:3rem;}
    	.art-detail-detail-cont a{color: blue;}
    </style>
    <!-- 熊掌号搜索结果出图20181114 海洋 -->
    <script type="application/ld+json">
        {
            "@context": "https://ziyuan.baidu.com/contexts/cambrian.jsonld",
            "@id": "http://m.saipubbs.com/article/detail/{{$article->id}}.html",
            "appid": "1551964634744717",
            "title": "{{$article->title}}",
            "images": [
                "{{env('IMG_URL')}}{{$article->cover_url}}"
            ], //请在此处添加希望在搜索结果中展示图片的url，可以添加1个或3个url
            "pubDate": "{{substr($article->created_at,0, 10)}}T{{substr($article->created_at,-8)}}" // 需按照yyyy-mm-ddThh:mm:ss格式编写时间，字母T不能省去
        }
    </script>
@endsection
@section('content')
	@if($content==1)
	<!--黄条 start -->
	<div class="color_orange_f5a623 h80 plr30">
		<div class="weui-cell padding0 mt0 noafter nobefore">
			<div class="weui-cell__bd">
				<p class="f32 fz bold">赛普期刊-赛普老师的创作期刊</p>
			</div>
		</div>
	</div>
	<!--黄条 end -->
	<!-- 老师 start -->
	<div class="mb10">
		<div class="weixinBox ptb35 fz bgcolor_fff">
			<div class="weui-cell padding0 mt0 noafter nobefore">
				<div class="weui-cell__hd">
					<img src="{{$f_avatar}}" class="border-radius50">
				</div>
				<div class="weui-cell__bd">
					<p class="f32 color_1515 bold ml10">{{$f_nickname}}</p>
					<p class="f26 color_gray666 ml10">赛普健身教练培训基地导师</p>
				</div>
				<div class="weui-cell__ft weixins bgcolor_gray codeWBtn">
					<img src="/images/weixin.png" alt="微信">
					<p class="f18">微信咨询</p>
				</div>
			</div>
		</div>
	</div>
	@endif
	<!-- 老师 end -->
<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->
	<!--头部导航 start-->
	<div class="plr30"><!--边距30 开始-->

		<div class="art-detail pt30">
			<!--头部文章标题-->
			<h1 class="f44 lt">{{$article->title}}</h1>
			<div class="weui-cells noafter nobefore mt0 art-list-title pb10">
				<div class="weui-cell padding0">
					<div class="weui-cell__bd fz f20 color_gray999 yudu-img">
						<time datetime="{{substr($article->created_at,0, 10)}}" pubdate="pubdate"></time>
						<span class="f24 d-in-black mr20">{{$article->created_at}}</span>
						<span class="d-in-black pl20 "><img src="/images/icon-xiao-xihuan.png" alt="">{{$article->likes}}</span>
						<span class="pl20"><img src="/images/icon-xiao-yuedu.png" alt="">{{$article->views}}</span>
					</div>
				</div>
			</div>

			<div class="weui-cells noafter nobefore mt0 art-det-con1">
				<a class="weui-cell weui-cell_access padding0 mtb15" href="javascript:;">
					<div class="weui-cell__hd border-radius50" onclick="window.location.href='/user/teacher/{{$article->author->id}}/1.html'">
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
					<div class="weui-cell__bd f32 color_000 lt">
						<p>{{$article->author->name?$article->author->name:$article->author->nickname}}</p>
					</div>
					@if($article->is_follow)
					<div class="art-det-but bgcolor_orange f28 color_333 border-radius-img" data-user_id="{{$article->user_id}}" data-fans_id='{{$user_id}}' onclick="article_follow(this)" data-is_follow='1' id="article{{$article->id}}" >已关注</div>
					@else
					<div class="art-det-but bgcolor_orange f28 color_333 border-radius-img" data-user_id="{{$article->user_id}}" data-fans_id='{{$user_id}}' onclick="article_follow(this)" data-is_follow='0' id="article{{$article->id}}" >关注</div>
					@endif
				</a>
			</div>
		</div>



		<!--文章本章没错了 start-->
		<!-- 视频 start -->
		@if($article->video_url)
		<div class="mb30">
			<div class="video_s mt20 border-radius-img">
				<div class="box2">
					<img src="{{env('IMG_URL')}}{{$article->video_img}}" alt=""/>
					<div class="mask"></div>
					<span class="btn_play"></span>
				</div>
				<video src="{{$article->video_url}}" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto" ></video>
			</div>
			<p class="fz f32 color_333 text_center mt10">{{$article->video_title}}</p>
		</div>
		@endif
		<!-- 视频 end -->
		<div class="art-detail-detail-wrap">

			<div class="art-detail-detail-cont text-jus f30 color_333 fz">
				<!-- <img src="{{env('IMG_URL')}}{{$article->cover_url}}" alt="{{$article->title}}" /> -->
				<?php
                  echo  htmlspecialchars_decode($article->content)
                ?>
			</div>
			@if($mobile==0)
			<!-- <div class="unfold-field">
				<div class="unflod-field_mask"></div>
				<div class="unfold-field_text bgcolor_fff text_center fz f28 bold" onclick="userlogin()"><span>展开全文</span></div>
			</div>  -->
			@endif
			<div class="zhuyi color_333 text-jus mt30">
				上述文章内容仅代表个人心得分享，不代表（赛普健身教练培训基地）官方意见。
			</div>
		</div>
		<!--文章本章没错了 end-->

		<!--文章下标签没错了 start-->
		<div class="art-detali-tag fz solidtop1px pt30 pb20 mt30">
			@foreach($tags as $tag)
				<?php
					$tgTitle = 	getTagTitle($tag);
					if(!$tgTitle){
						continue;
					}
				?>
			<a class="bgcolor_gray border-radius-img f24 color_gray666" href="/article/tag/{{$tag}}.html">{{getTagTitle($tag)}}</a>
			@endforeach
		</div>
		<!--文章下标签没错了 end-->

		<!-- 广告位 start -->
		@if($selectCourse)
			<a href="{{$linkUrl}}">
				<div class="pt10 pb30">
					<img src="{{env('IMG_URL')}}{{$selectCourse->cover_url}}" alt="" class="img100 border-radius-img">
					<p class="pt10 fz f30 bold">{{$selectCourse->sell_point}}</p >
				</div>
			</a>
		@endif
		<!-- 广告位 end -->

	</div><!--边距30 结束-->

	<!--我是灰色的线-->
	<div class="solidtop20"></div>

	<!--小图list-->
	<div class="plr30"><!--边距30开始-->

		<div class="weui-cells nobefore noafter">
			<div class="weui-cell left0 padding0">
				<div class="weui-cell__bd">
					<h2 class="f30 bold pb30">相关内容</h2>
				</div>
			</div>
		</div>

		<div class="list-art">
			<ul>
				@if($abouts->count())
				@foreach($abouts as $about)
				<li class="pt30 pb30">
					<a href="/article/detail/{{$about->id}}.html">
						<dl class="clearfix relative">
							<dt class="border-radius-img">
								<img src="{{env('IMG_URL')}}{{$about->cover_url}}" />
								@if($about->is_selected)
									<img class="icon-new-hot" src="/images/icon-hot.png" />
								@else
									@if(article_isnew($article->created_at))
										<img class="icon-new-hot" src="/images/icon-new.png" />
									@endif
								@endif
								@if($about->is_video)
									<img class="icon-bofang" src="/images/bofang.png" />
								@endif
							</dt>
							<dd>
								<h3 class="lt f30 color_333 text-overflow2">{{$about->title}}</h3>
								<div class="weui-cells nobefore noafter padding0 art-list-title mt0">
									<div class="weui-cell nobefore noafter padding0 mt20">
										<div class="weui-cell__hd border-radius50">
											@if($about->author)
												@if(strpos($about->author->avatar,'http') !== false)
													<img src="{{$about->author->avatar}}" class="border-radius50" />
												@else
													<img src="{{env('IMG_URL')}}{{$about->author->avatar}}" alt="头像" class="border-radius50" />
												@endif
											@else
											<img src="/images/my/nophoto.jpg" alt="头像" class="border-radius50" />
											@endif
										</div>
										<div class="weui-cell__bd f28 fz color_gray666 ">
											@if($about->author)
											<p>{{$about->author->name}}</p>
											@else
											<p>暂无</p>
											@endif
										</div>
									</div>

									<div class="weui-cell nobefore noafter padding0">
										<div class="weui-cell__bd mt10">
											<p class="color_gray9b f22 fz">{{substr($about->created_at,0, 10)}}</p>
										</div>
										<div class="weui-cell__ft fz f20 color_gray9b yudu-img">
											<span class=""><img src="/images/icon-xiao-xihuan.png">{{$about->likes}}</span>
											<span class="pl20"><img src="/images/icon-xiao-yuedu.png">{{$about->views}}</span>
										</div>
									</div>
								</div>
							</dd>
						</dl>
					</a>
				</li>
				@endforeach
				@endif
			</ul>
		</div>
	</div><!--边距30结束-->
	<!--小图 end-->

	<!--我是灰色的线-->
	<div class="solidtop20"></div>

	<div class="plr30"><!--边距30 开始-->


		<!-- 课程评价 start -->
		<!-- 文章评价列表 start -->
		<div class="page_evaluate bgc_white">
			<!-- 文章评价列表 start -->
			<div class="weui-cells nobefore  ">

				<div class="weui-cell left0 padding0 " id="head" >
					<div class="weui-cell__bd">
						<h2 class="f30 bold">评价</h2>
					</div>
				</div>
				@if($comments->count())
					@foreach($comments as $comment)
					<div class="weui-cells pt30 pb30">
						<div class="weui-cell evaluate padding0" data-id="1">
							<div class="weui-cell__bd">
								<a href="javascript:;" class="user_photo">
									<!-- <img src="/images/xy.png" alt="" class="img100"> -->
									@if($comment->author)
										@if(strpos($comment->author->avatar,'http') !== false)
										<img class="border-radius50" src="{{$comment->author->avatar}}">
										@else
										<img class="border-radius50" src="{{env('IMG_URL')}}{{$comment->author->avatar}}">
										@endif
									@else
										<img class="border-radius50" src="/images/my/nophoto.jpg"/>
									@endif
								</a>
								<dl>
									@if($comment->author)
									<dt>{{$comment->author->nickname ? $comment->author->nickname : '暂无昵称'}}</dt>
									@else
									<dt>暂无昵称</dt>
									@endif
									<dd class="fz">{{App\Constant\CommentDate::getDate($comment->created_at)}}</dd>
								</dl>
								<p class="fz text-jus">{{$comment->content}}</p>
							</div>
						</div>
					</div>
					@endforeach
				@endif
			</div>
			<!-- 文章评价列表 end -->
		</div>
		@if($comments->count())
		<div class="text_center art-quanbu fz f26 color_gray666 mt30"><a href="/article/comment/{{$article->id}}.html">查看全部评价</a></div>
		@endif
		<!--未评价=============================================================================-->
		<!--课程未评价 start-->
		@if(!$comments->count())
		<div class="start_weipingjia text_center">
			<div class="color_c9c7c7 fz f24 mt30 pt40">
				<img src="/images/shafa.png" alt="">
				<p class="mb40 pt10 pb30">沙发还没有人坐，请发言</p>
			</div>
		</div>
		@endif
		<!--课程未评价 end-->
	</div><!--边距30 结束-->

	<!--悬浮评价底部-->
	@if($article->state == 1)
	<div class="art-footer">
	   <ul class="clearfix text_center">
		   <li class="bgcolor_orange fz f34 color_333">
			   @if($mobile==0)
			   <a href="javascript:;" class="open-popup" onclick="userlogin()">谈谈你的看法</a>
			   @else
			   <a href="javascript:;" class="open-popup" data-target="#full">谈谈你的看法</a>
			   @endif
		   </li>

		   @if($mobile==0)
			   <li class="fz f20" onclick="userlogin()"></li>
			   <li class="fz f20" onclick="userlogin()"></li>
		   @else
			   @if(article_is_like($article->id, $user_id))
				   <li class="fz f20 check2" style="background:url(/images/art-like.png)no-repeat top center;background-size:50%;background-color:#f9f9f9" article_like="1"></li>
				   @else
				   <li class="fz f20 check2" article_like="0"></li>
				   @endif

			   @if(article_is_collect($article->id, $user_id))
				  <li class="fz f20 check" style="background:url(/images/art-sc.png)no-repeat top center;background-size:50%;background-color:#f9f9f9" article_collect="1"></li>
				   @else
				   <li class="fz f20 check" article_collect="0"></li>
			   @endif
		   @endif

	   </ul>
	</div>
	@endif

</div><!--导航大盒子id=page 结束-->


<div id="full" class='weui-popup__container bgc_white page_evaluate_form zindex6ge9'>
	<div class="weui-popup__overlay"></div>
	<div class="weui-popup__modal bgc_white">
		<!-- 头部条 start -->
		<header class="header_bar max640 bgc_white relative">
			<a href="javascript:;" class="btn_back close-popup fz bold">取消</a>
			<h2 class="cat1 lt">文章评论</h2>
			<a href="javascript:void(0)" class="btn_link btn_submit fz bold">提交</a>
		</header>
		<!-- 头部条 end -->
		<div class="textareaBox">
			<textarea class="fz text-jus" placeholder="请发表您的评论..." id="content"></textarea>
		</div>
	</div>
</div>

	<!--悬浮 btn1 start-->
	@if($userAttribute && $can_verify)
		@if($article->state == 2 || $article->state == 3)
			<div class="footer_f text_center fz f30">
				<ul>
					<li><a class="block" onclick="passArticle(this);" data-id="{{$article->id}}">通过审核</a></li>
				{{--@elseif($article->state == 1)--}}
					{{--<li><a class="block" href="javascript:void (0)">已经通过</a></li>--}}
				</ul>
			</div>
		@endif
	@endif
	@if($can_verify == 0 && ($article->state == 2 || $article->state == 2))
		<div class="footer_f text_center fz f30">
			<ul>
				<li><a class="block" onclick="javascript:void(0);" data-id="{{$article->id}}">该文章还没通过审核</a></li>
			</ul>
		</div>
	@endif
	<!--悬浮 btn1 end-->
<script src="/lib/jqweui/js/fastclick.js"></script>
<!-- <script src="http://res2.wx.qq.com/open/js/jweixin-1.4.0.js"></script> -->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
	var token1   = '{{csrf_token()}}';
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
	<?php
		$content = explode(PHP_EOL,$article->seo_description);
		$art = '';
		if($content == ''){
			foreach($content as $cont){
				$art .= trim($cont);
			}
		}else{
			$content = strip_tags($article->content);
			$art = mb_substr($content,0,60);
		}

	?>
	wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
		wx.onMenuShareAppMessage({
			title: '{{$article->title}}', // 分享标题
			desc: '{{$art}}', // 分享描述
			link: "http://m.saipubbs.com/article/detail/{{$article->id}}.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
			imgUrl: "{{env('IMG_URL')}}{{$article->cover_url}}", // 分享图标
			success: function(){
				/*----分享获得赛普币start----*/
				$.ajax({
					type:"POST",
					url:"/article/spbArticle",
					data:{userid:"{{$user_id}}",article_id:"{{$article->id}}", _token:token1},
					dataType:"json",
					success:function(result){
						//alert(result);
					}
				});
				/*----分享获得赛普币end----*/
			}
		}, function(res) {
		//这里是回调函数

		});
	});
	wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
		wx.onMenuShareTimeline({
			title: '{{$article->title}}', // 分享标题
			link: "http://m.saipubbs.com/article/detail/{{$article->id}}.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
			imgUrl: "{{env('IMG_URL')}}{{$article->cover_url}}", // 分享图标
			success: function(){
				/*----分享获得赛普币start----*/
				$.ajax({
					type:"POST",
					url:"/article/spbArticle",
					data:{userid:"{{$user_id}}",article_id:"{{$article->id}}", _token:token1},
					dataType:"json",
					success:function(result){
						//alert(result);
					}
				});
				/*----分享获得赛普币end----*/
			}
		}, function(res) {
		//这里是回调函数

		});
	});
</script>
<script type="text/javascript">
	//二维码弹窗
	$('.codeWBtn').click(function(){
		layer.open({
			type: 1,
			title: false, //不显示标题栏
			skin: 'codeW_layer_wrap codeW_layer_wrap_qikan', //样式类名
			id: 'codeW_layer', //设定一个id，防止重复弹出
			closeBtn: 0, //不/显示关闭按钮
			anim: 2,
			shadeClose: 1, //开启/关闭遮罩
			shade: [0.7, '#000'],
			area: ['30%', '60%'],
			content:'<div class="hideWImg hideWImgPublic text_center mt32">' +
			'<p class="fz f32 color_333 mb20 bold relative"><img src="{{$f_avatar}}" alt="" class="user"></p>' +
			'<p class="fz f32 color_333 mb20 bold pt20">{{$f_nickname}}</p>' +
			'<p class="plr30 fz f30 color_333 mt20">' +
			'<span class="block bold">立即长按识别下方二维码</span>' +
			'<span class="block bold">添加我微信领取健身资料包</span>' +
			'</p>' +
			'<img src="{{env('IMG_URL')}}{{$f_wx_code}}" alt="赛普健身社区{{$f_wx_code}}">' +
			'</div>',
			btn:false
		});
	});
</script>
<script>
	//将裂变者id写入本地  用于存储上下级关系
	var fission_id = "{{$fission_id}}";
    if(fission_id>0){
        localStorage.setItem("fission_id", fission_id);
    }

	//将注册来源页面写入存储
    localStorage.setItem("channel", "article{{$article->id}}");
	var utm_source = "{{$utm_source}}";
	var utm_medium = "{{$utm_medium}}";
	if(utm_source != ''){
		localStorage.setItem("utm_source","{{$utm_source}}");
	}
	if(utm_medium != ''){
		localStorage.setItem("utm_medium","{{$utm_medium}}");
	}

	//关注取消关注
	function article_follow(e){
		var fans_id = e.getAttribute("data-fans_id");
		var user_id = e.getAttribute("data-user_id");
		var articleid  = e.getAttribute("id");
		var is_follow = e.getAttribute("data-is_follow");
		var token   = '{{csrf_token()}}';
		var mobile = "{{$mobile}}";
		if(mobile<1){
			userlogin();  //跳转登陆
			return;
		}
		if(is_follow==0){
			$.ajax({
				type:"POST",
				url:"/user/followadd",
				data:{fans_id:fans_id, user_id:user_id, _token:token},
				dataType:"json",
				success:function(result){
					if(result.code==1){
						layer.msg('关注成功');
						document.getElementById(articleid).setAttribute('data-is_follow', 1);
						document.getElementById(articleid).innerHTML='已关注';
					}else{
						layer.msg(result.msg);
					}
	            }
			});
		}else{
			$.ajax({
				type:"POST",
				url:"/user/followcancel",
				data:{fans_id:fans_id, user_id:user_id, _token:token},
				dataType:"json",
				success:function(result){
					if(result.code==1){
						layer.msg('取消关注');
						document.getElementById(articleid).setAttribute('data-is_follow', 0);
						document.getElementById(articleid).innerHTML='关注';
					}else{
						layer.msg(result.msg);
					}
	            }
			});
		}
	}
	//给body加一个类
	$('body').addClass('page_evaluate_wrap');
	var user_id = "{{$user_id}}";
	var article_id = "{{$article_id}}";
	//console.log(article_id);
	//跳转登陆函数
	var userlogin = function(){
		var url = "/article/detail/"+article_id+".html";
		layer.msg('请先注册');
		localStorage.setItem("redirect", url);
		setTimeout(function(){
			window.location.href = "/register";
		}, 500)
	}

	//提交评论内容
	$('.btn_submit').click(function (){
		var con        =$('#content').val();
		var token      = '{{csrf_token()}}';
		var article_id = "{{$article->id}}";
		var user_id    = "{{$user_id}}";
		var avatar     = "{{$avatar}}";
		var user_name  = "{{$user_name}}";
		if(con.length==""){
			layer.msg('评论不能为空~');
			return;
		}

		var html='<div class="weui-cells pt30  noafter " data-id="1">' +
				'<div class="weui-cell evaluate padding0">'+
				'<div class="weui-cell__bd">'+
				'	<a href="#" class="user_photo"><img src="'+avatar+'" alt="" class="img100"></a>'+
				'	<dl>'+
				'		<dt>'+user_name+'</dt>'+
				'		<dd class="fz">刚刚</dd>'+
				'	</dl>'+
				'	<p  class="fz text-jus">'+con+'</p>'+
				'</div>'+
				'</div>'+
				'</div>	';
		$('#head').after(html);
		$(".start_weipingjia").hide();

		var data = {user_id:user_id, _token:token, article_id:article_id, content:con};
        $.ajax({
            url:'/article/commentinsert',
            type:'POST',
            data:data,
            dataType:'json',
            success:function(res){
                if(res.code){
                	layer.msg(res.msg);
                	$('#content').val("");
                	$.closePopup();

                }else{
                	layer.msg(res.msg);
                }
            }
        });
        return;
		//$.closePopup();//关闭弹出框
		//location.reload()

	})

	$(document).ready(function(){
		//收藏/取消收藏文章
		$(".check").click(function(){
			var article_collect = $(this).attr("article_collect");
			var token   = '{{csrf_token()}}';
			var article_id = "{{$article->id}}";
			var user_id    = "{{$user_id}}";
			//alert(article_collect);
			$.ajax({
				type:"POST",
				url:"/article/collect",
				data:{article_id:article_id, user_id:user_id, article_collect:article_collect, _token:token},
				dataType:"json",
				success:function(result){
					if(result.code==1){
						layer.msg(result.msg);
						if(article_collect == 0){
							$(".check").css({"background":"url(/images/art-sc.png)no-repeat top center","background-size":"50%","background-color":"#f9f9f9"});
							$(".check").attr("article_collect", 1);
						}else{
							$(".check").css({"background":"url(/images/art-no-sc.png)no-repeat top center","background-size":"50%","background-color":"#f9f9f9"});
							$(".check").attr("article_collect", 0);
						}
					}else{
						layer.msg(result.msg);
					}
	            }
			});
		})

		//喜欢/不喜欢课程
		$(".check2").click(function(){
			var article_like = $(this).attr("article_like");
			var token   = '{{csrf_token()}}';
			var article_id = "{{$article->id}}";
			var user_id    = "{{$user_id}}";
			$.ajax({
				type:"POST",
				url:"/article/like",
				data:{article_id:article_id, user_id:user_id, article_like:article_like, _token:token},
				dataType:"json",
				success:function(result){
					if(result.code==1){
						layer.msg(result.msg);
						if(article_like == 0){
							$(".check2").css({"background":"url(/images/art-like.png)no-repeat top center","background-size":"50%","background-color":"#f9f9f9"});
							$(".check2").attr("article_like",1);
						}else{
							$(".check2").css({"background":"url(/images/art-no-like.png)no-repeat top center","background-size":"50%","background-color":"#f9f9f9"});
							$(".check2").attr("article_like", 0);
						}
					}else{
						layer.msg(result.msg);
					}
	            }
			});
		});

		//播放视频
		$('.video_s .box2').click(function(){
			$('.video_s .box2').show();
			$(this).hide();
			$(this).next().trigger('play');
		})

	});

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

<script type="text/javascript">
	function unfold(){
		var doc =  document;
		var wrap=doc.querySelector(".art-detail-detail-wrap");
		var unfoldField=doc.querySelector(".unfold-field-");
		unfoldField.onclick=function(){
			this.parentNode.removeChild(this);
			wrap.style.maxHeight="12000px";
		}
		document.onreadystatechange = function () { //当内容中有图片时，立即获取无法获取到实际高度，需要用 onreadystatechange
			if (document.readyState === "complete") {
				var wrapH=doc.querySelector(".art-detail-detail-wrap").offsetHeight;
				var contentH=doc.querySelector(".art-detail-detail-cont").offsetHeight;
				if(contentH <= wrapH){  // 如果实际高度大于我们设置的默认高度就把超出的部分隐藏。
					unfoldField.style.display="none";
				}
			}
		}
	}
	unfold();

	function passArticle(obj){
		var id = $(obj).attr('data-id');
		var data = {id:id,_token:'{{csrf_token()}}'};
		$.ajax({
			url:'/article/verify',
			data:data,
			type:"POST",
			dataType:'json',
			success:function(res){
				if(res.code == 0){
					$(obj).text(res.message);
				}else{
					layer.msg(res.message);
				}
			}
		});
	}
</script>
<script type="text/javascript">
	window.onload = function(){
		menuFixed('nav_keleyi_com');
	}
</script>
@endsection