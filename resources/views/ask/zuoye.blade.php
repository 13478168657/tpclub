@extends('layouts.header')
@section('title')
<title>导师作业详情页</title>
<meta name="author" content="啾啾" />
<meta name="keywords" content="" />
<meta name="description" content="" />
@endsection

@section('cssjs')
	<!--问答下css-->
<link rel="stylesheet" href="/css/ask.css">
<link rel="stylesheet" href="/css/ask_popup.css">
<link rel="stylesheet" href="/css/swiper.min.css">
<script src="/js/swiper.min.js"></script>
<script type="text/javascript" src="/js/base64/localResizeIMG.js"></script>
<script type="text/javascript" src="/js/base64/mobileBUGFix.mini.js"></script>
<style>
	.img_list li{background-size: cover;
		background-position: center center;
		background-repeat: no-repeat;}
</style>

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

<div id="page">
	<!--导航大盒子id=page 开始  【结束在最底部】-->


	<div class="page_ask bgcolor_gray">
		<!-- 文章评价列表 start -->
		<div class="daoshizuoye_box bgcolor_fff HuidaImgMax">
			<h2 class="tit f32 bold">{{$detail->title}}</h2>
			<p class="desc f28 color_gray666">{{$detail->description}}</p>
			<div class="imgs hide ImgMax mt30">
				<?php
					$imgList_ans = $detail->imgurl_list;
					$imgArr_ans = explode(",",$imgList_ans);
					array_pop($imgArr_ans);
				?>
				@if($imgList_ans !== '' && is_null($imgList_ans))
					@foreach($imgArr_ans as $a)
						<img src="{{env('IMG_URL')}}{{$a}}" class="img100" />
					@endforeach

				@endif

			</div>
			<div class="weui-cell nobefore foot f24">
				<div class="weui-cell__bd color_gray9b">
					<span>{{$detail->view}}阅读&nbsp;&nbsp;·&nbsp;&nbsp;{{q_answer_count($detail->id)}}回答</span>
					<span>{{q_answer_count($detail->id,1)}}回答被导师认可</span>
				</div>
				<!-- <div class="weui-cell__ft"> -->
					<!-- @if($imgList_ans !== '')
						<a href="javascript:;" class="f24 btn_open open-popup">展开</a>
					@endif -->

				<!-- </div> -->
				<!-- <div class="weui-cell nobefore foot f24">
				   	<div class="weui-cell__bd color_gray9b rev_del fz color_333">
				      <span><img src="/images/ico_rev.png" alt="">修改</span>
				      <span><img src="/images/ico_del.png" alt="">删除</span>
				   	</div>
				   	<div class="weui-cell__ft">
				      <a href="javascript:;" class="f24 btn_open open-popup">展开</ a>
				   </div>
				</div> -->
			</div>
			<div class="weui-cell nobefore foot f24">
				@if($user_id == $detail->user_id)
				   	<div class="weui-cell__bd color_gray9b rev_del fz color_333">
				      <span class="open-popup" data-target="#full1"><img src="/images/ico_rev.png">修改</span>
						@if(count($answer)>0)
							<span class="btn_del btn_del_question" data-attr = 1><img src="/images/ico_del.png">删除</span>
						@else
							<span class="btn_del btn_del_question" data-attr = 0><img src="/images/ico_del.png">删除</span>
						@endif

				   	</div>
				@endif
				   	@if($imgList_ans !== '' && is_null($imgList_ans))
				   	<div class="">
				      	<a href="javascript:;" class="f24 btn_open open-popup">展开</a>
				   	</div>
				   @endif
				</div>
		</div>

		<!-- 排序 start -->
		<div class="weui-flex sort f28 text_center mt20">
			<div class="weui-flex__item"><a href="/ask/zuoye/{{$detail->id}}/1/{{$can}}.html" @if($order == 0) class="color_gray666" @endif>按时间排序</a></div>
			<div class="weui-flex__item"><a href="/ask/zuoye/{{$detail->id}}/0/{{$can}}.html" @if($order == 1) class="color_gray666" @endif>按认可数排序</a></div>
		</div>
		<!--没有内容 start-->
		@if(count($answer) < 1)
		<div class="no_paixu bgcolor_fff text_center">
		   <img src="/images/no-paixu.png" alt="">
		   <p class="fz f28 color_gray666 text_center pt40">请先添加回答，查看所有答案</p >
		</div>
		@endif
		<!--没有内容 end-->
			<ul class="list_daoshizuoye append_more">
				@if($count>0 || $detail->user_id==$user_id)
					@if(count($answer) > 0)
						@foreach($answer as $v)
							<li>
								<?php
								$user = DB::table("users")->where("id",$v->user_id)->select("name","nickname","avatar","introduction")->first();

								?>
								<div class="weui-cell head noafter nobefore padding0 mt0 no_b_border">
									<div class="weui-cell__hd">
										@if(count($user) > 0)
											@if((strpos($user->avatar,'http') !== false))
												<img src="{{$user->avatar}}" class="border-radius50" style="width:2rem;margin-right:.5rem;">
											@else
												<img src="{{env('IMG_URL')}}{{$user->avatar}}" class="border-radius50" style="width:2rem;margin-right:.5rem;">
											@endif
										@endif
									</div>
									<div class="weui-cell__bd">
										<p class="fz f28 bold color_333 mt0 text-overflow" >{{$user?$user->nickname:''}}</p>
										<p class="fz f26 mt0">{{$user?$user->introduction:''}}</p>
									</div>
									<div class="weui-cell__ft color_gray9b">{{date("Y.m.d",strtotime($v->created_at))}}</div>
								</div>

									<div class="ConHref mt20">
										<h3 class="HrefWrap f28 text-jus fz line16" data-id="{{$v->qid}}_{{$v->id}}_{{$can}}">{{$v->content}}</h3>
										<div class="read-more"></div>
									</div>
								<div class="weui-flex pices mt30" >
									<?php
									$imgList = $v->imgurl_list;
									$imgArr = explode(",",$imgList);
									array_pop($imgArr);
									$comment_num = DB::table("ask_comment")->where("aid",$v->id)->count();
									?>
									@if($imgList !== '')
										@foreach($imgArr as $a)

											<div class="weui-flex__item"><img src="{{env('IMG_URL')}}{{$a}}" alt="" class="img100"></div>
										@endforeach
									@endif

								</div>
								<div class="weui-cell foot" onclick="window.location.href='/ask/zuoyedetail/{{$v->qid}}/{{$v->id}}/{{$can}}.html';">
									<div class="weui-cell__bd">
										<a href="javascript:;" class="color_gray666 f26">查看详情</a>
										@if($v->is_approve > 0) <img src="/images/tea_rk.png" class="biaoqian" alt=""> @endif
									</div>
									<div class="weui-cell__ft color_gray9b f24">
										<div class="pl">评论{{$comment_num}}</div>
										<div class="zt">赞同{{$v->zan}}</div>
									</div>
								</div>
							</li>
						@endforeach
						<div class="nomore f24 color_gray666 text_center ptb50 bgcolor_fff loadmore" onclick="loadmore(this);" data-load = 0>加载更多</div>

					@else

					@endif

				@else
					<div class="no_paixu bgcolor_fff text_center">
						<img src="/images/no-paixu.png" alt="">
						<p class="fz f28 color_gray666 text_center pt40">请先添加回答，查看所有答案</p >
					</div>
				@endif
			</ul>




	</div>
	<!--边距30 end-->
</div>
<!--导航大盒子id=page 结束-->
	<br/><br/><br/><br/>
<!-- 底部固定按钮 start -->
<div class="fixed_bar_bottom">
	<div class="btn_wrap bgcolor_fff">
		@if($user_id == 0)
			<a href="javascript:void(0)" class="f28 text_center bgcolor_gray" onclick="userlogin();">添加回答-完成作业</a>
		@elseif($can == 0)
			<!-- <a href="javascript:void(0)" class="f28 fz text_center bgcolor_gray color_333" onclick="layer.msg('请将关联的课程添加到我的课表');">添加回答-完成作业</a> -->
			<a href="javascript:void(0)" class="f28 text_center bgcolor_gray open-popup" data-target="#full">添加回答-完成作业</a>
		@else
			<a href="javascript:void(0)" class="f28 text_center bgcolor_gray open-popup" data-target="#full">添加回答-完成作业</a>
		@endif

	</div>
</div>
<!-- 底部固定按钮 end -->

<div id="full" class='weui-popup__container bgcolor_fff ask_popup'>
    <div class="weui-popup__overlay"></div>
    <div class="weui-popup__modal bgcolor_fff">
        <!-- 头部条 start -->
			<header class="header_bar max750 relative">
				<a href="javascript:void(0)" class="btn_cancel btn_cancel0 color_gray999 f24">取消</a>
				<a href="javascript:void(0)" class="btn_link btn_submit color_gray999 f24">提交</a>
			</header>
		<!-- 头部条 end -->
		<!-- 表单区 start -->
		<div class="ask_con">
			<div class="iptBox">
				<input type="text" id="tit" maxlength="50" onfocus="this.blur();" value="{{$detail->title}}" />
			</div>
			<!--<div class="textareaBox">
				<textarea placeholder="请您添加问题描述" id="content"></textarea>
			</div>-->
			<div class="">
				<textarea name=""  class="text-adaption fz f28" placeholder="请您填写答案"  id="content" rows="3"></textarea>
			</div>
			<div class="weui-cells weui-cells_form">
				<div class="weui-cell">
					<div class="weui-cell__bd">
						<div class="weui-uploader">
							<div class="weui-uploader__bd">
								<ul class="weui-uploader__files img_list" id="uploaderFiles">
									{{--<li>--}}
										{{--<img src="/images/ask/test/img.jpg" alt="" class="img100" />--}}
										{{--<div class="operation">--}}
											{{--<span class="btn_del"></span>--}}
										{{--</div>--}}
									{{--</li>--}}
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



<!--///////////////////////////修改//////////////////////////////////////////////////////-->
<div id="full1" class='weui-popup__container bgcolor_fff ask_popup'>
	<div class="weui-popup__overlay"></div>
	<div class="weui-popup__modal bgcolor_fff">
		<!-- 头部条 start -->
		<header class="header_bar max750 relative">
			<a href="javascript:void(0)" class="btn_cancel btn_cancel1 color_gray999 f24">取消</a>
			<a href="javascript:void(0)" class="btn_link btn_submit1 color_gray999 f24">提交</a>
		</header>
		<!-- 头部条 end -->
		<!-- 表单区 start -->
		<div class="ask_con">
			<div class="iptBox">
				<input type="text" id="tit1" maxlength="50" value="{{$detail->title}}" />
			</div>
			<div class="">
				<textarea name=""  class="text-adaption fz f28" placeholder="请您填写答案"  id="content_ans" rows="3"></textarea>
			</div>
			<div class="weui-cells weui-cells_form">
				<div class="weui-cell">
					<div class="weui-cell__bd">
						<div class="weui-uploader">
							<div class="weui-uploader__bd">
								<ul class="weui-uploader__files img_list" id="uploaderFiles">
									@if($imgList_ans !== '')
										@foreach($imgArr_ans as $a)
											<li>
												<img src="{{env('IMG_URL')}}{{$a}}" alt="" class="img100" />
												<div class="operation">
													<span class="btn_del img_url_list" onclick="btn_delimg(this)" data-url="{{$a}}"></span>
												</div>
											</li>
										@endforeach
									@endif

								</ul>
								<form id="uploadForm" action="{{url('user/fileupload')}}" method="post" enctype="multipart/form-data">
									<div class="weui-uploader__input-box" id="upload_button">
										<input id="uploaderInput1" class="weui-uploader__input" name="image" type="file" accept="image/*" multiple="">
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
<!--放大-->
<div class="big_img">
	<div class="swiper-container2">
		<div class="swiper-wrapper"></div>
	</div>
	<div class="swiper-pagination"></div>
</div>
<!--////////////////////////////////////////////////////////////////////////////---->
<script src="/js/ask.js"></script>

<script type="text/javascript">
	/*---获取当前时间---------------------------*/
	Date.prototype.Format = function (fmt) { //author: meizz
		var o = {
			"M+": this.getMonth() + 1, //月份
			"d+": this.getDate(), //日
			"H+": this.getHours(), //小时
			"m+": this.getMinutes(), //分
			"s+": this.getSeconds(), //秒
			"q+": Math.floor((this.getMonth() + 3) / 3), //季度
			"S": this.getMilliseconds() //毫秒
		};
		if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
		for (var k in o)
			if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
		return fmt;
	}

	var mydate = new Date().Format("yyyy.MM.dd");

	/*--------------------------------------------------*/
	var imgurl_list = "";
	var imgUrl      = "{{env('IMG_URL')}}";
	var img_number  = 0;
	var _token   = '{{csrf_token()}}';
	var c_length    = 0;
	//给body加一个类（为了弹窗有个父类）
	$('body').addClass('page_dialog_wrap');

	//展开
	$('.btn_open').click(function (){
		$(this).hide();
		$(this).parents('.daoshizuoye_box').find('.imgs').show();

	})
	$('#uploaderInput').localResizeIMG({
		width:800,// 宽度
		quality: 0.8, // 压缩参数 1 不压缩 越小清晰度越低
		success: function (result) {
			var img = new Image();
			img.src = result.base64;
			c_length = $("#full .img_url_list").length;
			c_length++;

			$("#full .img_list").append('<li style="background-image: url('+img.src+')"><div class="operation"><span class="btn_del img_url_list" onclick="btn_delimg(this)" id="cur_span'+c_length+'" data-url=""></span></div></li>');
			$.ajax({
				url: "{{url('ask/fileuploadbase')}}",
				type: "POST",
				data:  {file:img.src, _token:_token},
				dataType:'json',
				success: function (data) {
					if(data.code==0){
						console.log(data);
						if(img_number>=2){
							$("#full #upload_button").hide();
						}else{
							img_number++;
						}
						$("#full #cur_span"+c_length).attr("data-url", data.url);
					}
				}
			});
		}
	});
	//提交
	$('.btn_submit').click(function (){
		imgurl_list = "";
		$("#full .img_url_list").each(function(){
			var cur = $(this).attr("data-url");
			imgurl_list+=cur+",";
		});
		var tit=$('#full #tit').val();
		var con=$('#full #content').val();
		var qid = "{{$detail->id}}";
		var author = "{{$detail->user_id}}";
		var token   = '{{csrf_token()}}';
		console.log(imgurl_list);
		if(!tit){
			layer.msg('标题不能为空');
		}else if(!con){
			layer.msg('内容不能为空');
		}else{
			$.ajax({
				url : '/ask/addanswer',
				type : 'post',
				dataType : 'json',
				data : {
					title	: tit,
					content : con,
					qid : qid,
					author:author,
					_token:token,
					imgurl_list:imgurl_list,
				},
				success : function (data) {
					if(data.code == 1){
						$(".no_paixu").addClass("hide");
						var arr = imgurl_list.split(",");
						arr.splice(arr.length-1,1);
						var str = '<li><div class="weui-cell head"><div class="weui-cell__bd"><a href="#" class="user_photo">' ;
						str +='<img src="'+data.avatar+'" alt="" class="img100" /></a><dl><dt>{{$users?$users->nickname:""}}</dt><dd>{{$users?$users->introduction:""}}</dd></dl>';
						str +='<p>'+con+'</p><span class="date color_gray9b">'+mydate+'</span></div></div><div class="weui-flex pices">';
						for(var i= 0;i < arr.length;i++){
							str +='<div class="weui-flex__item"><img src="'+imgUrl+arr[i]+'" alt="" class="img100" /></div>';
							console.log(str);
						}
						str +='</div><div class="weui-cell foot"><div class="weui-cell__bd">';
						str +='<a href="/ask/zuoyedetail/'+qid+'/'+data.id+'/{{$can}}.html" class="color_gray666 f26" target="_blank">查看详情</a>';
						str +='</div><div class="weui-cell__ft color_gray9b f24"><div class="pl">评论0</div><div class="zt">赞同0</div>';
						str +='</div></div></li>';

						$(".append_more").prepend(str);
					}
				}
			});
			$.closePopup();//关闭弹出框
		}

	})


	//取消
	$('.btn_cancel0').click(function (){
		layer.open({
			title: '',
			content: '是否放弃回答',
			id: 'mylayer',
			closeBtn: 0, //不显示关闭按钮
			btn: ['放弃', '继续回答'],
			yes: function(index, layero) {
				//【放弃按钮】的回调
				layer.closeAll();
				$.closePopup();//关闭弹出框
				//$('#tit').val('');
				$('#content').val('');

			},
			btn2: function(index, layero) {
				//【继续回答】的回调

			}
		});
	})

	//取消
	$('.btn_cancel1').click(function (){
		layer.open({
			title: '',
			content: '是否放弃修改',
			id: 'mylayer',
			closeBtn: 0, //不显示关闭按钮
			btn: ['放弃', '继续修改'],
			yes: function(index, layero) {
				//【放弃按钮】的回调
				layer.closeAll();
				$.closePopup();//关闭弹出框
				//$('#tit').val('');
				$('#content').val('');

			},
			btn2: function(index, layero) {
				//【继续回答】的回调

			}
		});
	})


</script>

<script>

	//修改作业
	$('#content_ans').val("{{$detail->description}}");

	$('.btn_submit1').click(function (){
		imgurl_list1 = "";
		$(".img_url_list").each(function(){
			var cur = $(this).attr("data-url");
			imgurl_list1+=cur+",";
		});
		var tit=$('#tit1').val();
		var con=$('#content_ans').val();
		var qid = "{{$detail->id}}";
		var sid = "{{$detail->special_id}}";
		var token   = '{{csrf_token()}}';
		if(!tit){
			layer.msg('标题不能为空');
		}else if(!con){
			layer.msg('内容不能为空');
		}else{
			$.ajax({
				url : '/ask/qadd',
				type : 'post',
				dataType : 'json',
				data : {
					title	: tit,
					desription : con,
					qid : qid,
					_token:token,
					imgurl_list:imgurl_list1,
					update:1,
					sid:sid,
				},
				success : function (data) {
					if(data.code == 1){
						layer.msg("修改成功");
						window.location.reload();
					}
				}
			});
			$.closePopup();//关闭弹出框
		}

	})
	/*--------------------------------------*/
	var t_length    = 0;
	$('#uploaderInput1').localResizeIMG({
		width:800,// 宽度
		quality: 0.8, // 压缩参数 1 不压缩 越小清晰度越低
		success: function (result) {
			var img = new Image();
			img.src = result.base64;
			t_length = $("#full1 .img_url_list").length;
			t_length++;

			$("#full1 .img_list").append('<li style="background-image: url('+img.src+')"><div class="operation"><span class="btn_del img_url_list" onclick="btn_delimg(this)" id="cur_span'+t_length+'" data-url=""></span></div></li>');
			$.ajax({
				url: "{{url('ask/fileuploadbase')}}",
				type: "POST",
				data:  {file:img.src, _token:_token},
				dataType:'json',
				success: function (data) {
					if(data.code==0){
						var length = $("#full1 .img_list li").length;
						if(length>=3){
							$("#full1 #upload_button").hide();
						}
						$("#full1 #cur_span"+t_length).attr("data-url", data.url);
					}
				}
			});
		}
	});

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
					$("#full1 .img_url_list").each(function(){
						var cur = $(this).attr("data-url");
						imgurl_list+=cur+",";
					});
					var length = $("#full1 .img_list li").length;
					//判断上传按钮是否显示
					if(length<3){
						$("#full1 #upload_button").show();
					}
				}
			}
		});
	}





	//跳转登陆函数
	var userlogin = function(){
		var url = "/ask/zuoye/{{$detail->id}}}/1.html";
		layer.msg('请先注册');
		localStorage.setItem("redirect", url);
		setTimeout(function(){
			window.location.href = "/register";
		}, 500)
	}
</script>
	<script>
		//删除作业
		$('.btn_del_question').click(function (){
			var status = $(this).attr("data-attr");
			var qid = "{{$detail->id}}";
			if(status == 1){
				layer.msg("已有回复不能删除哦~");
			}else{
				layer.open({
					title: '',
					content: '确定要删除么',
					id: 'mylayer',
					closeBtn: 0, //不显示关闭按钮
					btn: ['取消', '确定'],
					yes: function(index, layero) {
						layer.closeAll();
						$.closePopup();//关闭弹出框

					},
					btn2: function(index, layero) {
						console.log(111);
						$.ajax({
							url : '/ask/delanswer',
							type : 'post',
							dataType : 'json',
							data : {qid : qid,_token:_token},
							success : function (data) {
								console.log(data);
								if(data.code == 1){
									layer.msg("删除成功");
									window.location.href = "/ask/field/{{$detail->special_id}}.html";
								}
							}
						});

					}
				});
			}

		})

	</script>
<script>
	var i = 2;
	var loadmore = function(e){
		var loaddata = e.getAttribute("data-load");
		console.log(loaddata);
		if(loaddata == 0){
			var qid = "{{$detail->id}}";
			var order = "{{$order}}";
			var can = "{{$can}}";
			$.ajax({
				url : '/ask/moreanswer',
				type : 'post',
				dataType : 'json',
				data : {qid : qid,order:order,can:can,page:i,_token:_token},
				success : function (data) {
					if(data.body == ''){
						layer.msg("加载完成哦~");
						$(".loadmore").text("加载完成");
						$(".loadmore").attr("data-load",1);
					}else{
						$(".loadmore").before(data.body);
					}


					i++;
				}
			});
		}else{
			layer.msg("加载已完成哦~");
		}

	}


	/*超出出现【全文】*/
	$(function(){

		var slideHeight = 68; // px
		var defHeight = $('.HrefWrap').height();

		$('.HrefWrap').each(function(i){
			var defHeight = $(this).height();
//alert(defHeight);
			if(defHeight >= slideHeight){
				$('.ConHref').bind('click',function(){
//					window.location.href="http://www.baidu.com"
				});
				var askInfo = $('.HrefWrap').eq(i).attr('data-id');
				var askArr = askInfo.split('_');
				var url = '/ask/zuoyedetail/'+askArr[0]+'/'+askArr[1]+'/'+askArr[2]+'.html';
				$('.HrefWrap').eq(i).css('height' , slideHeight + 'px');
				$('.HrefWrap').eq(i).next('.read-more').html('<a href="'+url+'">...全文</a>');
				$('.HrefWrap').eq(i).next('.read-more a').click(function(){
					var curHeight = $('.HrefWrap').height();
					//console.log(333)
					if(curHeight == slideHeight){
						//					window.location.href="http://www.baidu.com"
					}else{

					}
					return false;
				});
			}else{

			}
		})

	});

	/*swiper弹出大图并轮播 start*/
	$(document).ready(function () {
		/*调起大图 S*/
		var mySwiper = new Swiper('.swiper-container2', {
			loop: false,
			pagination: '.swiper-pagination',
			paginationType: 'fraction'
		})
		$(".ImgMax").on("click", ".post img", function () {
			var imgBox = $(this).parents(".post").find("img");
			var i = $(imgBox).index(this);
			$(".big_img .swiper-wrapper").html("");

			for (var j = 0, c = imgBox.length; j < c; j++) {
				$(".big_img .swiper-wrapper").append('<div class="swiper-slide"><div class="cell"><img src="' + imgBox.eq(j).attr("src") + '" / ></div></div>');
			}
			mySwiper.updateSlidesSize();
			mySwiper.updatePagination();
			$(".big_img").css({
				"z-index": 1001,
				"opacity": "1"
			});
			mySwiper.slideTo(i, 0, false);
			return false;
		});

		$(".big_img").on("click",function () {
			$(this).css({
				"z-index": "-1",
				"opacity": "0"
			});
		});
	});
	/*调起大图 E*/
	/*swiper弹出大图并轮播 end*/
</script>
@endsection
