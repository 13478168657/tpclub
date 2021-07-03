@extends('layouts.headercode')
@section('title')
    <title>{{$tag->seo_title}}{{env('WEB_TITLE')}}</title>
    <meta name="description" content="{{$tag->seo_description}}" />
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/article.css">
@endsection
@section('content')	
<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->
	<nav id="menu"></nav>
	<!--头部导航 end-->


	<div class="plr30">
		<!--小图list-->
		<div>

			<div class="weui-cells nobefore noafter">
				<div class="weui-cell left0 padding0" id="head" >
					<div class="weui-cell__bd">
						<h2 class="f30 bold">“{{$tag->title}}”相关内容</h2>
					</div>
				</div>
			</div>

			<div class="list-art">
				<ul id="article_list">
		@if($articlelist->count())
			@foreach($articlelist as $k=>$article)
					<li class="pt30 pb30 noborder">
						<a href="/article/detail/{{$article->id}}.html">
							<dl class="clearfix relative">
								<dt class="border-radius-img">
									<img src="{{env('IMG_URL')}}{{$article->cover_url}}" alt="" />
									@if($article->is_selected)
									<img class="icon-new-hot" src="/images/icon-hot.png" />
									@else
									<img class="icon-new-hot" src="/images/icon-new.png" />
									@endif
									@if($article->is_video)
									<img class="icon-bofang" src="/images/bofang.png" alt="">
									@endif
								</dt>
								<dd>
									<h3 class="lt f30 color_333 text-overflow2">{{$article->title}}</h3>
									<div class="weui-cells nobefore noafter padding0 art-list-title mt0">
										<div class="weui-cell nobefore noafter padding0 mt20">
											<div class="weui-cell__hd border-radius50">
												@if($article->author)
													@if(strpos($article->author->avatar,'http') !== false)
														<img src="{{$article->author->avatar}}" class="border-radius50" />
													@else
														@if(empty($article->author->avatar))
														<img src="{{env('IMG_URL')}}{{$article->author->avatar}}" alt="头像" class="border-radius50" />
														@else
															<img class="border-radius50" src="/images/my/nophoto.jpg" alt="头像" class="border-radius50" />
														@endif
													@endif
												@else
												<img class="border-radius50" src="/images/my/nophoto.jpg" alt="头像" class="border-radius50" />
												@endif
											</div>
											<div class="weui-cell__bd f28 fz color_gray666 ">
												<p>{{$article->author?$article->author->name:''}}</p>
											</div>
										</div>

										<div class="weui-cell nobefore noafter padding0">
											<div class="weui-cell__bd mt10">
												<p class="color_gray9b f22 fz">{{substr($article->created_at,0, 10)}}</p>
											</div>
											<div class="weui-cell__ft fz f20 color_gray9b yudu-img">
												<span class="">
													<img src="/images/icon-xiao-xihuan.png" alt="">{{$article->likes}}
												</span>
												<span class="pl20">
													<img src="/images/icon-xiao-yuedu.png" alt="">{{$article->views}}
												</span>
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
				@if($articlelist->count())
			    <div class="weui-loadmore more text_center fz ptb30">
				        <!-- <i class="weui-loading"></i> -->
				        <span class="weui-loadmore__tips" id="article_more" data-is_ture='1'>加载更多</span>
				    </div>
			    @else
				    <div class="weui-loadmore more text_center fz ptb30">
				        <span class="weui-loadmore__tips">暂无评论</span>
				    </div>
			    @endif
			</div>
		</div>
		<!--小图 end-->

	</div><!--边距30 end-->

</div><!--导航大盒子id=page 结束-->


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

<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
  $(function() {
    FastClick.attach(document.body);
  });
</script>


<script type="text/javascript">
	//给body加一个类
	$('body').addClass('page_evaluate_wrap');
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
	//links[last].classList.add("weui-bar__item--on");   //高亮代码样式
</script>
<script type="text/javascript">
	window.onload = function(){
		menuFixed('nav_keleyi_com');
	}


	$(document).ready(function(){
		//加载更多
	    var page = 1;
	    var tag_id = "{{$tag_id}}";
	    var type   = "tag";
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
	            type:"post",
	            url:"/article/addmore",
	            data:{tag_id:tag_id, page:page, type:type, _token:token},
	            dataType:"json",
	            success:function(result){
	                console.log(result);
	                if(result.code==1){
	                    for (var item in result.list) {
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
	                        	var tuiguang = "/images/icon-hot.png";
	                        }else{
	                        	var tuiguang = "/images/icon-new.png";
	                        }
	                        if(result.list[item].is_video){
	                        	var video  = '<img class="icon-bofang" src="/images/bofang.png" alt="">';
	                        }else{
	                        	var video  = "";
	                        }
	                        var url = "/article/detail/"+ result.list[item].id+".html";
	                        $("#article_list").append('<li class="pt30 pb30"><a href="'+url+'">' +
								'<dl class="clearfix relative">' +
								'<dt class="border-radius-img">' +
								'<img src="'+imgUrl+result.list[item].cover_url+'" alt="" />' +
								'<img class="icon-new-hot" src="'+tuiguang+'" alt="">' +video+
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
								'<p class="color_gray9b f22 fz">'+result.list[item].created+'</p>' +
								'</div>' +
								'<div class="weui-cell__ft fz f20 color_gray9b yudu-img">' +
								'<span class=""><img src="/images/icon-xiao-xihuan.png" alt="">'+result.list[item].likes+'</span>' +
								'<span class="pl20"><img src="/images/icon-xiao-yuedu.png" alt="">'+result.list[item].views+'</span>' +
								'</div>' +
								'</div>' +
								'</div>' +
								'</dd></dl></a></li>');
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
@endsection