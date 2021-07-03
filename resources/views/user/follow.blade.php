
@extends('layouts.header')
@section('title')
    <title>我的关注列表{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/xueyuan.css">
@endsection
@section('content')
<!-- 头部条 start -->
<!-- <div class="fixed_bar_top">
    <header class="header_bar bgc_grey relative">
        <a href="javascript:history.go(-1);" class="btn_back"><i></i></a>
        <h1 class="cat">关注列表</h1>
    </header>
</div> -->
<!-- 头部条 end -->
<!-- 粉丝 start -->
<div class="bgcolor_fff">
	<!--关注列表 start-->
	@if($list)
	<div class="weui-cells nobefore noafter mt0 fensi-tit pt10 pb10" id="list">
	  	@foreach ($list as $v)
	    	<div class="weui-cell mtb15 right15" id="follow{{$v->users->id}}">
				<div class="weui-cell__hd pt10">
					<a href="/user/teacher/{{$v->users->id}}/1.html">
						@if(strpos($v->users->avatar,'http') !== false)
						<img  class="border-radius50" src="{{$v->users->avatar}}">
						@else
						<img  class="border-radius50" src="{{env('IMG_URL')}}{{$v->users->avatar}}" />
						@endif
					</a>
				</div>
				<div class="weui-cell__bd color_333 text-overflow">
					<a href="">
						<h2 class="lt">{{$v->users->name}}</h2>
						@if($v->users->introduction)
							<p class="fz text-overflow">{{$v->users->introduction}}</p>
						@else
							<p class="fz text-overflow">暂无</p>
						@endif
					</a>
				</div>
				<div class="weui-cell__ft">
					<a href="javascript:;" class="yihuguan border-radius" data-user_id="{{$v->users->id}}" data-follow_id="{{$v->id}}" onclick="click_cancel(this)">取关</a>
					<!-- <a href="javascript:;" class="yihuguan border-radius click_cancel" data-user_id="{{$v->users->id}}" data-follow_id="{{$v->id}}" onclick="click_cancel(this)">取关</a> -->
				</div>
			</div>
		@endforeach
	</div>
	<!--关注列表 end-->
	<!--加载更多-->
	<div class="weui-loadmore more text_center fz ptb30">
		<!-- <i class="weui-loading"></i> -->
		<span class="weui-loadmore__tips" id="follow_more" data-is_ture='1'>加载更多</span>
	</div>
	@else
	<div class="weui-loadmore more text_center fz ptb30">
		<!-- <i class="weui-loading"></i> -->
		<span class="weui-loadmore__tips">暂无关注信息</span>
	</div>
	@endif
</div>
<!-- 功能列表 end -->

<!-- 粉丝 end -->
<script src="/lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
	$(function() {
		FastClick.attach(document.body);
	});
</script>

<script src="/lib/jqweui/js/jquery-weui.js"></script>
<script>
	var imgUrl = "{{env('IMG_URL')}}";
	//取消关注
	function click_cancel(e){
		var user_id   = e.getAttribute("data-user_id");
		var follow_id = e.getAttribute("data-follow_id");  //执行删除的记录id
		var parent_id = "follow"+user_id;
		var token     = '{{csrf_token()}}';
		$.ajax({
			type:"POST",
			url:"/user/followcancel",
			data:{follow_id:follow_id, _token:token},
			dataType:"json",
			success:function(result){
				if(result.code==1){
					layer.msg('操作成功');
					$("#"+parent_id).remove();
				}else{
					layer.msg('网络错误,等一会儿');
				}
            }
		});
	}
	$(document).ready(function() {
		//加载更多
		var page = 1;
		var www  = "/";
		$("#follow_more").click(function(){
			page++;
			var type   = 'follow';
			var user_id= {{$userid}};
			//如果没有数据就不再请求数据库了
			var is_ture= $(this).attr('data-is_ture');
			if(is_ture<1){
				layer.msg('抱歉没有更多的数据了');
				return;
			}
			$.ajax({
				type:"GET",
				url:"/user/addmore",
				data:{type:type, user_id:user_id, page:page},
				dataType:"json",
				success:function(result){
					console.log(result.list);
					if(result.code==1){
						for (var item in result.list) {
							if((result.list[item].avatar).indexOf("http") > -1){
                                var img = result.list[item].avatar;
                            }else{
                                var img = imgUrl+result.list[item].avatar;
                            }
                            if(result.list[item].name){
                                var name = result.list[item].name;
                            }else{
                                var name = "--";
                            }
							$("#list").append("" +
					"<div class='weui-cell mtb15 right15' id='follow"+result.list[item].user_id+"'>" +
					"<div class='weui-cell__hd pt10'>" +
					"<a href=''><img  class='border-radius50' src='"+img+"'></a>" +
					"</div>" +
					"<div class='weui-cell__bd color_333 text-overflow'>" +
					"<a href=''><h2 class='lt'>"+name+"</h2><p class='fz text-overflow'>"+result.list[item].introduction+"</p></a>" +
					"</div>" +
					"<div class='weui-cell__ft'><a class='yihuguan border-radius' data-user_id='"+result.list[item].user_id+"' data-follow_id='"+result.list[item].id+"' onclick='click_cancel(this)'>取关</a></div>" +
					"</div>");
						}
					}else{
						$("#follow_more").attr('data-is_ture', 0);
						$("#follow_more").text('抱歉没有更多的数据了');
						layer.msg(result.msg);
					}
                }
			});
		});
	});
</script>
<script>
	var loading = false;
	$(document.body).infinite().on("infinite", function() {
		if(loading) return;
		loading = true;
		setTimeout(function() {
			$("#list").append("" +
					"<div class='weui-cell mtb15 right15'>" +
					"<div class='weui-cell__hd pt10'>" +
					"<a href=''><img  class='border-radius50' src='/images/daoshi-t-img.jpg'></a>" +
					"</div>" +
					"<div class='weui-cell__bd color_333 text-overflow'>" +
					"<a href=''><h2 class='lt'>何翔宇</h2><p class='fz text-overflow'>导师简介导师简介导师简介</p></a>" +
					"</div>" +
					"<div class='weui-cell__ft'><a href='' class='yihuguan border-radius'>互相关注</a></div>" +
					"</div>");



			loading = false;
		}, 2000);
	});
</script>
@endsection
