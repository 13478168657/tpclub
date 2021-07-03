@extends('layouts.header')
@section('title')
    <title>专场问答-待回答{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
   	<link rel="stylesheet" href="/css/ask.css">
	<link rel="stylesheet" href="/css/ask_popup.css">
	<script type="text/javascript" src="/js/base64/localResizeIMG.js"></script>
	<script type="text/javascript" src="/js/base64/mobileBUGFix.mini.js"></script>
	<style>
		.img_list li{background-size: cover;
   	 	background-position: center center;
    	background-repeat: no-repeat;}
	</style>
    
@endsection
@section('content')	
<div class="zc_await">
	<div class="zc_await_title clearfix bgcolor_fff">
		<a href="javascript:;" class="f28 fz bold color_333 text_center block fl">待回答</a>
		<a href="/ask/specialtask/{{$id}}.html" class="f28 fz color_gray666 text_center block fl">创建作业</a>
	</div>
	@if($list->count())
	<ul class="zc_await_ask">
		@foreach($list as $k=>$item)
		<li class="pb30 pt30 mb20 bgcolor_fff plr30">
			<p class="f32 color_333 mb20 fz bold">{{$item->title}}</p>
			<p class="f28 color_gray666 fz pb20 text-jus">{{$item->description}}</p>
			<div class="weui-cell nobefore noafter padding0">
				<div class="weui-cell__bd">
					<span class="color_gray9b f24 fz">{{$item->users->nickname ? $item->users->nickname : '小伙伴'}} ·</span>
					<span class="color_gray9b f24 fz">{{str_replace('-', '.',substr($item->created_at,0, 10))}}</span>
				</div>
				<div class="weui-cell__ft fz btn_answer">
					<a href="javascript:;" data-id="{{$item->id}}" data-user_id="{{$item->user_id}}" class="f24 color_333 border-radius-img open-popup call_answer" id="question{{$item->id}}" data-target="#answer">回答</a>
				</div>
			</div>
		</li>
		@endforeach
	</ul>
	@else
		<a href="javascript:void (0)" class="Load fz text_center pt40 mt20 color_gray666 f24">暂无数据</a>
	@endif
	<!-- <a href="javascript:void (0)" class="Load fz text_center pt40 mt20 color_gray666 f24">加载更多</a> -->
	<br/>
	<br/>
	<br/>
	<!--底部悬浮【新建一个练习题】按钮 start-->
	<div class="relative">
		<div class="fixed_zt_bottom text_center bgcolor_orange">
			<a href="javascript:void (0)" class="color_333 fz f34 open-popup" data-target="#full">新建一个练习题</a>
		</div>
	</div>
	<!--底部悬浮【新建一个练习题】按钮 end-->
</div>
<!-- 导师创建作业 -->
<div id="full" class='weui-popup__container bgcolor_fff ask_popup'>
	<div class="weui-popup__overlay"></div>
	<div class="weui-popup__modal bgcolor_fff">
		<!-- 头部条 start -->
		<header class="header_bar max750 relative">
			<a href="javascript:void(0);" class="btn_cancel btn_cancel_task color_gray999 f24">取消</a>
			<a href="javascript:void(0)" class="btn_link btn_submit btn_submit_task color_gray999 f24">提交</a>
		</header>
		<!-- 头部条 end -->
		<!-- 表单区 start -->
		<div class="ask_con">
			<div class="iptBox">
				<input type="text" id="tit" placeholder="请用一句话描述问题并以问号结尾（最多500字）" maxlength="500" />
			</div>
			<!--<div class="textareaBox">
				<textarea placeholder="请您添加问题描述" id="content"></textarea>
			</div>-->
			<div class="">
				<textarea  class="text-adaption fz f28" placeholder="请您添加问题描述" rows="3" id="content"></textarea>
			</div>
			<div class="weui-cells weui-cells_form">
				<div class="weui-cell">
					<div class="weui-cell__bd">
						<div class="weui-uploader">
							<div class="weui-uploader__bd">
								<ul class="weui-uploader__files img_list" id="uploaderFiles">
									
								</ul>

	<form id="uploadForm" action="{{url('user/fileupload')}}" method="post" enctype="multipart/form-data">
		<div class="weui-uploader__input-box" id="upload_button">
			<input id="uploaderInput" class="weui-uploader__input" name="image" type="file" accept="image/*" multiple="">
		</div>
		{{csrf_field()}}
	</form> 



							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- 表单区 end -->
	</div>
</div>


<!-- 导师回答问题 -->
<div id="answer" class='weui-popup__container bgcolor_fff ask_popup'>
    <div class="weui-popup__overlay"></div>
    <div class="weui-popup__modal bgcolor_fff">
        <!-- 头部条 start -->
			<header class="header_bar max750 relative">
				<a href="javascript:;" class="btn_cancel btn_cancel_answer color_gray999 f24">取消</a>
				<div class="cat1 f28">回答</div>
				<a href="javascript:void(0)" class="btn_link btn_submit btn_submit_answer color_gray999 f24">提交</a>
			</header>
		<!-- 头部条 end -->
		<!-- 表单区 start -->
		<div class="ask_con">
			<div class="textareaBox mt20 mb20 pb20 pt20 plr20" id="question_title" style="border:1px solid rgba(204,204,204,.4);">
				
			</div>
			<div>
				<textarea  class="text-adaption fz f28" placeholder="请填写内容"  id="content_answer" rows="10"></textarea>
			</div>
		</div>
		<!-- 表单区 end -->
    </div>
</div>

<script>
	//给body加一个类
	//给body加一个类（为了弹窗有个父类）
	$('body').addClass('page_dialog_wrap');

	var imgurl_list = "";
	var _token      = '{{csrf_token()}}';
	var imgUrl      = "{{env('IMG_URL')}}";
	var special_id  = "{{$id}}";
	var img_number  = 0;
	var c_length    = 0;

	$('input:file').localResizeIMG({
		width:800,// 宽度
		quality: 0.8, // 压缩参数 1 不压缩 越小清晰度越低
		success: function (result) {
			var img = new Image();
			img.src = result.base64;
			c_length = $(".img_url_list").length;
			c_length++;

			$(".img_list").append('<li style="background-image: url('+img.src+')"><div class="operation"><span class="btn_del img_url_list" onclick="btn_delimg(this)" id="cur_span'+c_length+'" data-url=""></span></div></li>');
			$.ajax({
	         	url: "{{url('ask/fileuploadbase')}}",
	          	type: "POST",
	          	data:  {file:img.src, _token:_token},
	         	dataType:'json',
	          	success: function (data) {
	              	if(data.code==0){
	              		if(img_number>=2){
							$("#upload_button").hide();
						}else{
							img_number++;
						}
	              		$("#cur_span"+c_length).attr("data-url", data.url);
	              	}
	         	}     
	     	});
		}
	});

	//创建作业提交按钮
	$('.btn_submit_task').click(function (){
		imgurl_list = "";
		$(".img_url_list").each(function(){
			var cur = $(this).attr("data-url");
			imgurl_list+=cur+",";
		});

		var tit = $('#tit').val();
		var con = $('#content').val();
		console.log(con);
		if(!tit){
			layer.msg('标题不能为空');
		}else if(!con){
			layer.msg('内容不能为空');
		}else{
			$.ajax({
				url : '/ask/taskcreate',
				type : 'post',
				dataType : 'json',
				data : {title:tit, description:con, imgurl_list:imgurl_list, _token:_token, special_id:special_id},
				success : function (data) {
					if(data.code==1){
						window.location.href='/ask/specialtask/{{$id}}.html';
					}else{
						layer.msg(data.msg);
						$.closePopup();//关闭弹出框
					}
				}
			});
			$.closePopup();//关闭弹出框
		}

	})


	//创建作业取消按钮
	$('.btn_cancel_task').click(function (){
		layer.open({
			title: '',
			content: '是否放弃创建',
			id: 'mylayer',
			closeBtn: 0, //不显示关闭按钮
			btn: ['放弃', '继续'],
			yes: function(index, layero) {
				//【放弃按钮】的回调
				layer.closeAll();
				$.closePopup();//关闭弹出框
				$('#tit').val('');
				$('#content').val('');

			},
			btn2: function(index, layero) {
				//【继续回答】的回调

			}
		});
	})

	//回答问题取消按钮
	$('.btn_cancel_answer').click(function (){
		layer.open({
			title: '',
			content: '是否放弃回答',
			id: 'mylayer',
			closeBtn: 0, //不显示关闭按钮
			btn: ['放弃', '继续'],
			yes: function(index, layero) {
				//【放弃按钮】的回调
				layer.closeAll();
				$.closePopup();//关闭弹出框
				// $('#tit').val('');
				// $('#content').val('');

			},
			btn2: function(index, layero) {
				//【继续回答】的回调

			}
		});
	})

	//点击回答确认问题id
	var qid = "";
	var q_user_id   = "";
	var attr_id     = "";
	var q_description = "";
	$(".call_answer").click(function(){
		qid = $(this).attr("data-id");                //问题id
		q_user_id   = $(this).attr("data-user_id");   //提问者id
		attr_id     = "question"+qid;
		q_description = $(this).parent().parent().prev().text();
		$("#question_title").text(q_description);
	});

	//回答问题提交按钮
	$('.btn_submit_answer').click(function (){
		var answer = $('#content_answer').val();
		if(!answer){
			layer.msg('答案不能为空');
		}else{
			$.ajax({
				url : '/ask/answer',
				type : 'post',
				dataType : 'json',
				data : {answer:answer, qid:qid, q_user_id:q_user_id, _token:_token},
				success : function (data) {
					if(data.code==1){
						layer.msg(data.msg);
						$('#content_answer').val("");
						$("#"+attr_id).parent().parent().parent().remove();   //删除已回复问题
					}else{
						layer.msg(data.msg);
					}
					$.closePopup();//关闭弹出框
				}
			});
			//$.closePopup();//关闭弹出框
		}
	})

	//删除图片
	var btn_delimg = function(e){
		var imgurl = e.getAttribute("data-url");
		var li     = e.parentNode.parentNode;
		var parent = li.parentNode;
		$.ajax({
          	url: "/ask/deleteimg",
          	type: "POST",
          	data:  {imgurl:imgurl, _token:_token},
          	dataType:'json',
          	success: function (data) {
              	if(data.code==1){
              		parent.removeChild(li);    //删除图片元素
              		imgurl_list = "";
              		//删除图片重新计算图片地址
              		$(".img_url_list").each(function(){
						var cur = $(this).attr("data-url");
						imgurl_list+=cur+",";
					});

					//判断上传按钮是否显示
					if(img_number<3){
						$("#upload_button").show();
					}else{
						img_number--;
					}
              	}
          	}
	    });
	}
	
	//上传图片
	$(function (e) {
	 	 $("#uploadForm----").on('submit', function(e){
	      e.preventDefault();
	      $.ajax({
	          url: "{{url('ask/fileupload')}}",
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
	              		//隐藏上传图片按钮
	                  	if(img_number>=2){
							$("#upload_button").hide();
						}else{
							img_number++;
						}
						//插入图片
	                  	$(".img_list").append('<li><img src="'+imgUrl+ data.path+'"  class="img100" /><div class="operation"><span class="btn_del img_url_list" onclick="btn_delimg(this)" data-url="'+data.path+'"></span></div></li>');
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
	  	
	});
</script>



@endsection