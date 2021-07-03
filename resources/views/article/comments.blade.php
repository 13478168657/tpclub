@extends('layouts.headercode')
@section('title')
    <title>赛普社区-评价列表{{env('WEB_TITLE')}}</title>
    <meta name="description" content="" />
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/article.css">
@endsection
@section('content')	
<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->
	<!--隐藏导航内容-->
	<nav id="menu"></nav>
	<!--头部导航 end-->


	<div class="plr30">
		<div class="page_evaluate bgc_white">
			<!-- 文章评价列表 start -->
			<div class="weui-cells nobefore" id="article_comments">

				<div class="weui-cell left0 padding0 " id="head" >
					<div class="weui-cell__bd">
						<h2 class="f30 bold">全部评价</h2>
					</div>
					<div class="weui-cell__ft">
						@if($mobile)
							<a href="javascript:;" class="f24 fz bold color_gray666 open-popup" data-target="#full">我也要评价<img src="/images/icon_ping.png" class="ico_evaluate" /></a>
						@else
							<a href="javascript:;" class="f24 fz bold color_gray666 open-popup" onclick="userlogin()">我也要评价<img src="/images/icon_ping.png" class="ico_evaluate" /></a>
						@endif
					</div>
				</div>
				@if($comments->count())
					@foreach($comments as $comment)
						<div class="weui-cells pt30 pb30 noafter" id="article_item_{{$comment->id}}">
							<div class="weui-cell evaluate padding0">
								<div class="weui-cell__bd">
									<a href="javascript:;" class="user_photo">
			                            @if($comment->author && $comment->author->avatar)
											@if(strpos($comment->author->avatar,'http') !== false)
												<img class="border-radius50" src="{{$comment->author->avatar}}" alt=""/>
											@else
												<img class="border-radius50" src="{{env('IMG_URL')}}{{$comment->author->avatar}}" alt="头像" />
											@endif
										@else
										<img src="/images/my/nophoto.jpg" alt="头像" />
										@endif
									</a>
									<dl>
										<dt>{{$comment->author ? subtext($comment->author->nickname,15) : '暂无昵称'}}</dt>
										<dd class="fz">{{App\Constant\CommentDate::getDate($comment->created_at)}}</dd>
									</dl>
									<p class="fz text-jus">{{$comment->content}}</p>
									@if($comment->user_id==$user_id)
									<span class="btn_del" data-id="{{$comment->id}}"></span>
									@endif
								</div>
							</div>
						</div>
					@endforeach
				@endif
			</div>
			<!-- 文章评价列表 end -->

			@if($comments->count())
			    <div class="weui-loadmore more text_center fz ptb30">
			        <!-- <i class="weui-loading"></i> -->
			        <span class="weui-loadmore__tips" id="comment_more" data-is_ture='1'>加载更多</span>
			    </div>
		    @else
			    <div class="weui-loadmore more text_center fz ptb30">
			        <span class="weui-loadmore__tips">暂无评论</span>
			    </div>
		    @endif
		</div>
	</div><!--边距30 end-->


</div><!--导航大盒子id=page 结束-->

<!--评论弹出-->
<div id="full" class='weui-popup__container bgc_white page_evaluate_form'>
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


<div class="relative">
    <div class="fixed_bottom_4 clearfix">
        <a href="/"><span class="icon-home"></span></a>
        <a href="/article/0.html"><span class="icon-find"></span></a>
        <a href="/ask/specialdetail.html"><span class="icon-ask"></span></a>
        <a href="/user/studying"><span class="icon-study"></span></a>
        <a href="/user/index"><span class="icon-my"></span></a>
    </div>
</div>
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

	//跳转登陆函数
	var userlogin = function(){
		var url = "/article/comment/{{$article_id}}.html";
		localStorage.setItem("redirect", url);

		layer.msg('请先登录');
		setTimeout(function(){
			window.location.href = "/login";
		}, 500)
	}

	//提交评论内容
	$('.btn_submit').click(function (){
		//layer.msg('1111~');
		//return;
		var con        =$('#content').val();
		var token      = '{{csrf_token()}}';
		var article_id = "{{$article_id}}";
		var user_id    = "{{$user_id}}";
		var avatar     = "{{$avatar}}";
		var user_name  = "{{$user_name}}";
		if(con.length==""){
			layer.msg('评论不能为空~');
			// layer.msg('墨绿风格')
			return;
		}

		var html='<div class="weui-cells pt30  noafter " data-id="1">' +
				'<div class="weui-cell evaluate padding0">'+
				'<div class="weui-cell__bd">'+
				'	<a href="#" class="user_photo"><img src="'+avatar+'" alt="" class="img100"></a>'+
				'	<dl>'+
				'		<dt>'+user_name+'</dt>'+
				'		<dd class="fz">1分钟前</dd>'+
				'	</dl>'+
				'	<p  class="fz text-jus">'+con+'</p>'+
				'</div>'+
				'</div>'+
				'</div>	';
		$('#head').after(html);

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
	})

	//删除
	$('.btn_del').click(function (){
		var article_id = $(this).attr("data-id");
        var article_item_id = "article_item_"+article_id;
        var token      = '{{csrf_token()}}';
		layer.open({
			title: '',
			content: '是否确认删除？',
			id: 'mylayer',
			closeBtn: 0, //不显示关闭按钮
			btn: ['取消', '确定'],
			yes: function(index, layero) {
				//【取消按钮】的回调
				layer.closeAll();
				
			},
			btn2: function(index, layero) {
				//【确定按钮】的回调
				$.ajax({
                    type:"POST",
                    url:"/article/commentdel",
                    data:{article_id:article_id, _token:token},
                    dataType:"json",
                    success:function(result){
                        if(result.code==1){
                            $("#"+article_item_id).remove();
                            layer.msg(result.msg);
                        }else{
                            layer.msg(result.msg);
                        }
                    }
                });
			}
		});
	})


	//加载更多
    var page = 1;
    var imgUrl  = "{{env('IMG_URL')}}";  //图片公共地址
    $("#comment_more").click(function(){
        page++;
        var article_id = {{$article_id}};
        //如果没有数据就不再请求数据库了
        var is_ture= $(this).attr('data-is_ture');
        if(is_ture<1){
            layer.msg('抱歉没有更多的数据了');
            return;
        }
        $.ajax({
            type:"GET",
            url:"/article/commentmore",
            data:{article_id:article_id, page:page},
            dataType:"json",
            success:function(result){
                //console.log(result);
                if(result.code==1){
                    for (var item in result.list) {
                        if((result.list[item].user_avatar).indexOf("http") > -1){
                            var img = result.list[item].user_avatar;
                        }else{
                            var img = imgUrl+result.list[item].user_avatar;
                        }
                        if(result.list[item].user_name){
                            var name = result.list[item].user_name;
                        }else{
                            var name = "--";
                        }
                        $("#article_comments").append('<div class="weui-cells pt30  noafter " data-id="1">' +
														'<div class="weui-cell evaluate padding0">'+
														'<div class="weui-cell__bd">'+
														'	<a href="#" class="user_photo"><img src="'+img+'" alt="" class="img100"></a>'+
														'	<dl>'+
														'		<dt>'+name+'</dt>'+
														'		<dd class="fz">'+result.list[item].created_a+'</dd>'+
														'	</dl>'+
														'	<p  class="fz text-jus">'+result.list[item].content+'</p>'+
														'</div>'+
														'</div>'+
														'</div>	');
                    }
                }else{
                    $("#comment_more").attr('data-is_ture', 0);
                    $("#comment_more").text('抱歉没有更多的数据了');
                    layer.msg(result.msg);
                }
            }
        });
    });




	/*window.onload = function(){
	 menuFixed('nav_keleyi_com');
	 }*/
</script>
<script>
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
</script>
@endsection