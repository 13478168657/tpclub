@extends('layouts.header')
@section('title')
<title>{{$article->title}}{{env('WEB_TITLE')}}</title>
<meta name="description" content="{{$article->description}}" />
@endsection

@section('cssjs')

	<!--分享下css-->
	<link rel="stylesheet" href="/css/share.css">

<script>
(function(){
	var html = document.documentElement;
	var hWidth = html.getBoundingClientRect().width;
	html.style.fontSize=hWidth/18.75+'px';
})()
</script>

@endsection
@section('content')	

<!---导航右侧带导航弹出---->

<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->


	<div class="plr30"><!--边距30 开始-->

		<div class="video border-radius-img">
			<div class="box2 ">
				<img src="{{env('IMG_URL')}}{{$article->cover_url}}" alt=""/>
				<div class="mask"></div>
				<span class="btn_play"></span>
			</div>
			<video id="video" src="{{$article->video_url}}" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto" ></video>
		</div>


		<div class="pt40">
			<!--头部文章标题-->
			<h3 class="f36 lt mb20">{{$article->title}}</h3>
			<time datetime="{{$article->created_at}}" pubdate="pubdate"></time>
			<div class="weui-cells  nobefore mt0 share-title pb40">
				<div class="weui-cell padding0">
					<div class="weui-cell__bd fz f20 color_gray9b watch-img">
						<span class="f22 mr20">{{substr($article->created_at,0, 10)}}</span>
						<span class="pl20"><img src="/images/icon-xiao-xihuan.png" alt="">{{$article->likes}}</span>
						<span class="pl20"><img src="/images/icon-xiao-yuedu.png" alt="">{{$article->views}}</span>
					</div>
				</div>
			</div>
		</div>



		<!--文章本章没错了 start-->
		<div class="share-detail pt40">
			<div class="text-jus f30 color_333 fz">
				
					<?php
	                  echo  htmlspecialchars_decode($article->content)
	                ?>
                
			</div>
		</div>
		<!--文章本章没错了 end-->



		<!--文章下标签没错了 start-->
		<div class="share-detali-tag fz solidtop1px pt30 pb20 mt30">
			@if($mobile == 0)
				@foreach($tags as $tag)

					<a onclick="userlogin()" class="bgcolor_gray border-radius-img f24 color_gray666" href="javascript:;">{{getTagTitle($tag)}}</a>
				@endforeach
				@else
				@foreach($tags as $tag)
					<a class="bgcolor_gray border-radius-img f24 color_gray666" href="/article/tag/{{$tag}}.html">{{getTagTitle($tag)}}</a>
				@endforeach

			@endif

		</div>
		<!--文章下标签没错了 end-->

		<!--关注 start-->
		<div class="weui-cells noafter nobefore mt0 share-ter">
			<a class="weui-cell weui-cell_access padding0 mtb15" href="javascript:;">
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
				<div class="weui-cell__bd f26">
					<p>{{$article->author->name}}</p>
				</div>
				<!-- <div class="share-det-but bgcolor_orange f28 color_333 border-radius-img">关注</div> -->
				@if($article->is_follow)
					<div class="share-det-but bgcolor_orange f28 color_333 border-radius-img" data-user_id="{{$article->user_id}}" data-fans_id='{{$user_id}}' onclick="article_follow(this)" data-is_follow='1' id="article{{$article->id}}" >已关注</div>
				@else
					<div class="share-det-but bgcolor_orange f28 color_333 border-radius-img" data-user_id="{{$article->user_id}}" data-fans_id='{{$user_id}}' onclick="article_follow(this)" data-is_follow='0' id="article{{$article->id}}" >关注</div>
				@endif
			</a>
		</div>
		<!--关注  end-->

		
		<div class="bgcolor_f9f9f9 text_center border-radius-img mt32 mb40">
		@if(isset($next_article->title))
			<p class="f22 color_gray666 mb10 pt30">下一节</p>
				@if($mobile == 0)
					<a class="f28 color_333 bold pb30 d-in-black" href="javascript:;" onclick="userlogin()">{{$next_article->title}}</a>
				@else
					<a class="f28 color_333 bold pb30 d-in-black" href="/article/special/{{$next_article->id}}/{{$sid}}.html">{{$next_article->title}}</a>
				@endif

		@else
			<p class="f22 color_gray666 mb10 pt30">没有了</p>
			
		@endif
		</div>



	</div><!--边距30 结束-->

	<!--我是灰色的线-->
	<div class="solidtop20"></div>


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
			@foreach($abouts as $v)
				<li class="pt30 pb30">
					@if($mobile == 0)
						<a href="javascript:;" onclick="userlogin()">
					@else
						<a href="/article/special/{{$v->id}}/{{$sid}}.html">
					@endif

						<dl class="clearfix relative">
							<dt class="border-radius-img"><img src="{{env('IMG_URL')}}{{$v->cover_url}}" alt="" /></dt>
							<dd>
								<h3 class="lt f30 color_333 text-overflow2">{{$v->title}}</h3>

								<div class="weui-cells nobefore noafter padding0 share-title mt0">
									<div class="weui-cell nobefore noafter padding0 mt20">
										<div class="weui-cell__hd border-radius50 line-h6">
											@if($v->author)
												@if(strpos($v->author->avatar,'http') !== false)
													<img src="{{$v->author->avatar}}" class="border-radius50" />
												@else
													<img src="{{env('IMG_URL')}}{{$v->author->avatar}}" alt="头像" class="border-radius50" />
												@endif
											@else
											<img src="/images/my/nophoto.jpg" alt="头像" class="border-radius50" />
											@endif
										</div>
										<div class="weui-cell__bd f28 fz color_gray666">
											
											@if($v->author)
												<p>{{$v->author->name}}</p>
											@else
												<p>暂无</p>
											@endif
										</div>
									</div>

									<div class="weui-cell nobefore noafter padding0">
										<div class="weui-cell__bd mt10">
											<p class="color_gray9b f22 fz">{{substr($v->created_at,0, 10)}}</p>
										</div>
										<div class="weui-cell__ft fz f20 color_gray9b watch-img">
											<span class=""><img src="/images/icon-xiao-xihuan.png" alt="">{{$v->likes}}</span>
											<span class="pl20"><img src="/images/icon-xiao-yuedu.png" alt="">{{$v->views}}</span>
										</div>
									</div>
								</div>
							</dd>
						</dl>
					</a>
				</li>
			@endforeach

			</ul>
		</div>
	</div><!--边距30结束-->






	<!--底部 start-->
	<div class="art-footer">
		<ul class="clearfix text_center">
			<li class="bgcolor_orange fz f34 color_333" id ="share"><a href="/wechat/shareArticle/{{$sid}}?aid={{$article->id}}" class="">邀请朋友观看</a></li>
			<li onclick="window.location.href='/special/index/{{$sid}}.html'"></li>
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
	<!--底部 end-->



</div><!--导航大盒子id=page 结束-->



<br><br><br>





<!--end-->
<script>
	$(document).ready(function(){
		var flag = 1;
		$(".check").click(function(){
			if(flag == 1){
				$(".check").css({"background":"url(/images/art-sc.png)no-repeat top center","background-size":"50%","background-color":"#f9f9f9"});
				flag = 0;
			} else{
				$(".check").css({"background":"url(/images/art-no-sc.png)no-repeat top center","background-size":"50%","background-color":"#f9f9f9"});
				flag = 1;
			}
		})
	});

	$(document).ready(function(){
		var flag = 1;
		$(".check2").click(function(){
			if(flag == 1){
				$(".check2").css({"background":"url(/images/art-like.png)no-repeat top center","background-size":"50%","background-color":"#f9f9f9"});
				flag = 0;
			} else{
				$(".check2").css({"background":"url(/images/art-no-like.png)no-repeat top center","background-size":"50%","background-color":"#f9f9f9"});
				flag = 1;
			}
		})
	});
</script>

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
		foreach($content as $cont){
			$art .= trim($cont);
		}
	?>
	wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
		wx.onMenuShareAppMessage({ 
			title: '{{$article->title}}', // 分享标题
			desc: '{{$art}}', // 分享描述 
			link: "http://m.saipubbs.com/special/indexRegister/{{$article->id}}/{{$sid}}.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
			imgUrl: "{{env('IMG_URL')}}{{$article->cover_url}}", // 分享图标
			success: function(){
				/*----分享获得赛普币start----*/
				$.ajax({
					type:"POST",
					url:"/article/spbArticle",
					data:{userid:"{{$user_id}}",article_id:"{{$article->id}}",spburl:"20", _token:token1},//分享专题规则20
					dataType:"json",
					success:function(result){
						//alert(result);
					}
				});
				/*----分享获得赛普币end----*/
				layer.msg("分享成功");
			},
			cancel: function () {
				layer.msg("取消分享");
			}
		}, function(res) { 
		//这里是回调函数 
			alert("分享好友成功");
		}); 
	});
	wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
		wx.onMenuShareTimeline({ 
			title: '{{$article->title}}', // 分享标题
			link: "http://m.saipubbs.com/special/indexRegister/{{$article->id}}/{{$sid}}.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
			imgUrl: "{{env('IMG_URL')}}{{$article->cover_url}}", 	// 分享图标
			confirm: function(){
				/*----分享获得赛普币start----*/
				$.ajax({
					type:"POST",
					url:"/article/spbArticle",
					data:{userid:"{{$user_id}}",article_id:"{{$article->id}}",spburl:"20", _token:token1},//分享专题规则20
					dataType:"json",
					success:function(result){
						//alert(result);
					}
				});
				/*----分享获得赛普币end----*/
				layer.msg("分享成功");
			},
			cancel: function () {
				layer.msg("取消分享");
			}
		}, function(res) { 
		//这里是回调函数 
		}); 
	});
</script>
<script>
	//将裂变者id写入本地  用于存储上下级关系
	var fission_id = "{{$fission_id}}";
    if(fission_id>0){
        localStorage.setItem("fission_id", fission_id);
    }
	
	console.log(localStorage.getItem('fission_id')+"是否是裂变者");
	console.log("article{{$article->id}}"+"channel");
	//将注册来源页面写入存储
    localStorage.setItem("channel", "article{{$article->id}}");

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
	var sid = "{{$sid}}";
	//console.log(article_id);
	//跳转登陆函数
	var userlogin = function(){
		var url = "/article/special/"+article_id+"/"+sid+".html";
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
				data:{article_id:article_id, user_id:user_id, article_collect:article_collect,spburl:'22', _token:token},
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
				data:{article_id:article_id, user_id:user_id, article_like:article_like,spburl:'23', _token:token},
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

</script>
<script type="text/javascript">
	window.onload = function(){
		menuFixed('nav_keleyi_com');
	}
</script>
<script>
	//播放视频
	$(function (){
		//播放视频
		$('.video .box2').click(function(){
			$(this).hide();
			$(this).next().trigger('play');

		})
	})

</script>
@endsection
