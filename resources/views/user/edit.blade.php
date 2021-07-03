@extends('layouts.header')
@section('title')
    <title>编辑个人资料{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link href="/css/my.css?t=1.1" rel="stylesheet" type="text/css" />
    <style>
        .aa .weui-flex__item:nth-child(2){margin:0;}
    	.aa .weui-flex__item{width: 46%;float: left;padding-bottom: .75rem;}
    	.aa .weui-flex__item:nth-child(2n){float: right;}
    	.aa .weui-flex__item input{padding-left: .375rem;padding-right: .375rem;}
    </style>
@endsection
@section('content')
<!-- 头部条 start -->
<!-- <div class="fixed_bar_top">
	<header class="header_bar bgc_grey relative">
		<a href="javascript:history.go(-1);" class="btn_back"><i></i></a>
		<h1 class="cat">编辑个人资料</h1>
	</header>
</div> -->
<!-- 头部条 end -->

<div class="weui-cells baseinfo noafter">
	<form id="uploadForm" action="{{url('user/fileupload')}}" method="post" enctype="multipart/form-data">
	<a href="javascript:void(0)" class="weui-cell upload_avatar" id="userPhoto-">
		<div class="weui-cell__bd">
			<div class="tit">头像</div>
		</div>
		
			<div class="weui-cell__ft">
				点击更换
				<div class="user_photo">
					@if($user->avatar)
						@if(strpos($user->avatar,'http') !== false)
							<img src="{{$user->avatar}}" alt="" id="avatar_url" />
						@else
							<img src="{{env('IMG_URL')}}{{$user->avatar}}" id="avatar_url" alt="" />
						@endif
					@else
					<img src="/images/my/nophoto.jpg" id="avatar_url" />
					@endif
				</div>
			</div>
	</a>
	<input style="display: none;" name="image" type="file" class="inputFile" />
	{{csrf_field()}}
	</form> 
	<form id="userinfo" action="{{url('user/updateinfo')}}" method="post">
	<a href="javascript:void(0)" class="weui-cell">
		<div class="weui-cell__bd">
			<div class="tit">昵称 </div>
		</div>
		<div class="weui-cell__ft">
			<span class="fs14"><input type="text" id="nickname" name="name" value="{{$user->nickname}}" style="border:none;text-align: right;color:#999" placeholder="请输入您的昵称最长12个字"></span>
		</div>
		<div class="weui-textarea-counter">&nbsp;&nbsp;<span id="nickname_words">0</span>/12</div>
	</a>
	<a href="javascript:void(0)" class="weui-cell sex">
		<div class="weui-cell__bd">
			<div class="tit fl">性别</div>

		</div>
		<div  class="weui-cell__ft">
			@if($user->sex=='unknow')
			<label class="radio_wrap">
				<input type="radio" name="sex" class="radio" value="male">男
			</label>
			<label class="">
				<input type="radio"  name="sex" class="radio" value="female">女
			</label>
			@elseif($user->sex=='male')
			<label class="radio_wrap">
				<input type="radio" name="sex" class="radio"  checked value="male">男
			</label>
			<label class="">
				<input type="radio"  name="sex" class="radio" value="female">女
			</label>
			@else
			<label class="radio_wrap">
				<input type="radio" name="sex" class="radio" value="male">男
			</label>
			<label class="">
				<input type="radio"  name="sex" class="radio" checked value="female">女
			</label>
			@endif
		</div>
	</a>
	<a href="javascript:void(0)" class="weui-cell">
		<div class="weui-cell__bd">
			<div class="tit">个人简介</div>
		</div>
	</a>
	<div class="weui-cell jianjie nobefore">
		<div class="weui-cell__bd">
			<textarea class="weui-textarea" placeholder="用一段话介绍一下自己吧（建议40字以内）" rows="3" id="jianjie" name="introduction">{{$user->introduction}}</textarea>
			<div class="weui-textarea-counter"><span id="jianjie_words">0</span>/40</div>
		</div>
	</div>
</div>
	@if(count($orders) || count($groupOrders))
	<!--我是灰色-->
	<p class="pt10 bgcolor_gray"></p >

	<!--学籍信息 start-->
	<div class="plr30 pt40 pb30">
		<h3 class="f32 color_333 bold fz pb30 text-jus">学籍信息-参加的认证（赛普健身教练培训基地）</h3>
		<div class="f28 fz color_gray999">
			@foreach($orders as $order)
				<?php
					if(!$order->getone){
						continue;
					}
				?>
			<p class="pb10">{{$order->getone->title}}</p>
			@endforeach
			@foreach($groupOrders as $gorder)
				<?php
					if(!$gorder->getone){
						continue;
					}
				?>
			<p class="pb10">{{$gorder->getone->title}}</p>
			@endforeach
		</div>
	</div>
	@endif
	<!--学籍信息 end-->

	<!--我是灰色-->
	<p class="pt10 bgcolor_gray"></p>
	<!--登陆账号 start-->
	<div class="plr30 pt40">
		<h3 class=" f32 color_333 bold fz">登陆账号</h3>
		<div class="MyBang pt30">
			<dl class="clearfix f26 fz pb30">
				<dt class="color_gray999">我的手机号</dt>
				<dd>{{$user->mobile}}</dd>

				@if(empty($user->mobile))
					<dd><a href="/bind/mobile" class="color_orange">绑定手机号</a></dd>
				@else
					<dd><a href="/bind/mobile" class="color_orange">重新绑定手机号</a></dd>
				@endif
			</dl>
			{{--<dl class="clearfix f26 fz pb30">--}}
				{{--<dt class="color_gray999">我的手机号</dt>--}}
				{{--<dd>{{$user->mobile}}</dd>--}}
				{{--<dd><a href="javascript:void (0)" class="color_orange">绑定微信账号</a></dd>--}}
			{{--</dl>--}}
		</div>
	</div>
	<!--登陆账号 end-->

	<!--我是灰色-->
	<p class="pt10 bgcolor_gray"></p>
	<!--教练资格证认证 start-->
	<div class="plr30 pt40">
		<h3 class="f32 color_333 bold fz pb30">教练资格证认证</h3>
		<a href="/apply/coach/verify" class="color_orange f26 fz">申请资格证认证</a>
	</div>
	<!--教练资格证认证 end-->


	<div class="Baocun plr30 bgcolor_fff">
		<input type="hidden" value="{{$user->avatar}}" name="avatar" id="input_avatar_url" />
		<input type="hidden" value="{{$user->id}}" name="id" />
		<input type="hidden" value="{{$worktag}}" name="worktag" />
		{{csrf_field()}}
		<input type="button" id="submit_form" value="保存" class="bgcolor_orange border-radius-img f34 color_333" />
	</div>
{{--<div class="padding15">--}}
	{{--<input type="button" class="weui-btn bgc_yellow grey" id="submit_form" value="保存" />--}}
{{--</div>--}}
</form>

<br><br><br><br><br>
<!-- 功能列表 end -->
<!-- 底部固定导航条 start -->
<!-- <div class="fixed_bar_bottom">
   <div class="weui-tabbar nav-tabbar">
      <a href="/" class="weui-tabbar__item"><span class="ico_home"></span></a>
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
<script src="/lib/icheck/js/icheck.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/js/js.js"></script>
<script>
	var imgUrl ="{{env('IMG_URL')}}";

	$(function (){
		
		var jianjie  = $("#jianjie");
		var nickname = $("#nickname");
		wordLimit1(jianjie,$("#jianjie_words"),40);
		wordLimit1(nickname, $("#nickname_words"), 12);
	})

$(function (e) {
 	 $("#uploadForm").on('submit', function(e){
      e.preventDefault();
      $.ajax({
          url: "{{url('user/fileupload')}}",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          dataType:'json',
          // 显示加载图片
          beforeSend: function () {
              $('.loading-shadow').addClass('active');
          },
          success: function (data) {
              if(data.code==1){
              	   // 移除loading加载图片
                  // $('.loading-shadow').removeClass('active');
                  // 看我接下来的解释
                  //console.log(imgUrl+ data.path);
                  $('#avatar_url').attr('src', imgUrl+ data.path);
                  $('#input_avatar_url').val(data.path);
              }else{
              	   layer.msg(data.msg);
              }
          },
          error: function(){}             
     	 });
  	});
       
  	// 选择完要上传的文件后, 直接触发表单提交
  	$('input[name=image]').on('change', function () {
      	// 如果确认已经选择了一张图片, 则进行上传操作
      	if ($.trim($(this).val())) {
          	$("#uploadForm").trigger('submit');
      	}
  	});

  	// 触发文件选择窗口
  	$('.upload_avatar').on('click', function () {
      	$('input[name=image]').trigger('click');
 	});

 	$("#submit_form").click(function(){
 		
		var data = $("#userinfo").serialize();
		data = decodeURIComponent(data,true);
		$.ajax({
			type:"POST",
			url:"/user/updateinfo",
			data:data,
			dataType:'json',
			success:function(result){
				if(result.code==1){
					layer.msg(result.msg);
					setTimeout(function(){
						window.location.href="/user/index";
					},2000); 
				}else{
					layer.msg(result.msg);
				}
			}
		});
	});

	/*tab选中状态*/
	$('.tag_zhi .in').click(function(){
		$(this).addClass('on').parent().siblings().children().removeClass('on');
		$("input[name='worktag']").val($(this).val());
	})
});
</script>
@endsection