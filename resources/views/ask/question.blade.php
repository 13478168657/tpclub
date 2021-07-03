@extends('layouts.header')
@section('title')

<title>问答专场-待导师回答</title>
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

	<!--===========================================================================================-->
	<div class="qa_field_content">
		
		<!--banner start-->
		<div class="banner_fie relative">
			<img src="/images/ask/fie_banner.png" alt="">
			<div class="color_fff field_txt fz plr36 mt32">
				<span class="f24 border-radius50">你问我答</span>
				<p class="text_center f36 bold pt40">{{$special->title}}</p>
			</div>
		</div>
		<!--banner end-->

		<!--下拉 start-->
		@if($special->is_open==0)
		<div class="choice_content fz f28 color_gray666 plr36 field_choice">
		   <div class="choice_content_box">
		      <p class="flip ptb20 relative">查看该专区关联的组合课程<img src="/images/xiala_s.png" class="flip-arrow" alt=""/></p >
		      <div class="panel plr36">
		         <!--多选-->
		         <div class="checkboxWrap pb40">
		         	@foreach($group_class as $group)
		            <a href="/train/study.html"><label class="mt20">{{$group->title}}</label></a>
		            @endforeach
		         </div>
		      </div>
		   </div>
		   @if($course_class)
		   <div class="choice_content_box">
		      <p class="flip ptb20 relative">查看该专区关联的单一课程<img src="/images/xiala_s.png" class="flip-arrow" alt=""/></p >
		      <div class="panel plr36">
		         <!--多选-->
		         <div class="checkboxWrap pb40">
		            @foreach($course_class as $k=>$course)
		           <label class="mt20">{{$course->title}}</label>
		            @endforeach
		         </div>
		      </div>
		   </div>
		   @endif
		</div>
		@endif
		<!--下拉 end-->

		<!--关注 start-->
		<div class="plr30 gaunzhu_fiele ptb30">
			<div class="weui-cells  noafter nobefore padding0 mt0">
				<div class="weui-cell noafter nobefore padding0 ">
					<div class="weui-cell__hd">
						@if((strpos($teacher->avatar,'http') !== false))
							<img src="{{$teacher->avatar}}" class="border-radius50">
						@else
							<img src="{{env('IMG_URL')}}{{$teacher->avatar}}" class="border-radius50">

						@endif

					</div>
					<div class="weui-cell__bd fz">
						<p class="bold f32">{{$teacher->nickname?$teacher->nickname:''}}</p>
						<p class="f26">{{$teacher->introduction?$teacher->introduction:'暂无介绍'}}</p>
					</div>
					<?php
						$follow = DB::table("follow")->where("user_id",$teacher->id)->where("fans_id",$user_id)->count();
					?>
					@if($follow > 0)
						<div class="weui-cell__ft"><a href="javascript:void (0)" class="f28 fz border-radius-img bgcolor_orange" data-user_id="{{$teacher->id}}" data-fans_id='{{$user_id}}' onclick="article_follow(this)" data-is_follow='1' id="teacher{{$teacher->id}}">已关注</a></div>
					@else
						<div class="weui-cell__ft"><a href="javascript:void (0)" class="f28 fz border-radius-img bgcolor_orange" data-user_id="{{$teacher->id}}" data-fans_id='{{$user_id}}' onclick="article_follow(this)" data-is_follow='0' id="teacher{{$teacher->id}}">关注</a></div>
					@endif
				</div>
			</div>
		</div>
		<!--关注 end-->

		<!--导航 start-->
		<div class="field_nav text_center fz f28 bgcolor_f9f9f9">
			<ul class="clearfix">
				<li><a href="/ask/answer/{{$special->id}}.html">已回答</a></li>
				<li><a href="javascript:void (0)" class="cur">待导师回答</a></li>
				<li><a href="/ask/field/{{$special->id}}.html">导师作业</a></li>
			</ul>
		</div>
		<!--导航 end-->

		<!--列表 start-->
		<div class="fiele_list_tea fiele_list_tea2 plr30 HuidaImgMax">
			<ul class="append_more">

				@if(count($question)>0)
					@foreach($question as $v)
					<li>
						<a href="javascript:void (0)" class="fz ptb30">
							<h3 class="f32 color_333 bold text-jus">{{$v->title}}</h3>
							<p class="f28 color_gray666 text-jus mt10">{{$v->description}}</p>
							<div class="imgs hide ImgMax mt30">
								<?php
								$imgList = $v->imgurl_list;
								$imgArr = explode(",",$imgList);
								array_pop($imgArr);

								?>
								<ul class="clearfix post">
									@if(!is_null($imgList) && $imgList !== '')
										@foreach($imgArr as $a)
											<li><img src="{{env('IMG_URL')}}{{$a}}" class="img100" onclick="slidePhoto(this);" /></li>
										@endforeach
									@endif
								</ul>
							</div>
							<div class="weui-cell noafter nobefore padding0 f26 color_gray9b mt26">
								<div class="weui-cell__bd">
									<p>{{$v->view}}阅读· {{date("Y.m.d",strtotime($v->created_at))}}</p>
								</div>
								@if(!is_null($imgList) && $imgList !== '')
									<div class="weui-cell__ft " onclick="btn_open(this);">展开</div>
								@endif
							</div>

						</a>
					</li>
					@endforeach
					<a href="javascript:void (0)" class="Load fz text_center pt40 mt20 color_gray666 f24 loadmore" data-is_ture="0">加载更多</a>

				@else
					<a href="javascript:void (0)" class="Load fz text_center pt40 mt20 color_gray666 f24">暂时没有问题哦</a>

				@endif

				<br/>
			</ul>

		</div>
		<!--列表 end-->



		<!--底部悬浮【新建一个专题】按钮 start-->
		<div class="fixed_bar_bottom">
			<div class="btn_wrap bgcolor_fff">
				@if($user_id == 0)
					<a href="javascript:void(0)" class="f28 fz text_center bgcolor_gray open-popup color_333" onclick="userlogin();">向导师提问，等待专家的针对性回答</a>
				@elseif($can == 0)
					<a href="javascript:void(0)" class="f28 fz text_center bgcolor_gray color_333" onclick="layer.msg('购买该导师课程后才可以提问哦~');">向导师提问，等待专家的针对性回答</a>
				@else
					<a href="javascript:void(0)" class="f28 fz text_center bgcolor_gray open-popup color_333" data-target="#full">向导师提问，等待专家的针对性回答</a>
				@endif
			</div>
		</div>
		<!--底部悬浮【新建一个专题】按钮 end-->
		
	</div>
	<!--===========================================================================================-->







	<div id="full" class='weui-popup__container bgcolor_fff ask_popup'>
		<div class="weui-popup__overlay"></div>
		<div class="weui-popup__modal bgcolor_fff">
			<!-- 头部条 start -->
			<header class="header_bar max750 relative">
				<a href="javascript:void(0)" class="btn_cancel color_gray999 f24">取消</a>
				<a href="javascript:void(0)" class="btn_link btn_submit color_gray999 f24">提交</a>
			</header>
			<!-- 头部条 end -->
			<!-- 表单区 start -->
			<div class="ask_con">
				<div class="iptBox">
					<input type="text" id="tit" placeholder="请用一句话描述问题并以问号结尾（最多50字）" maxlength="50" />
				</div>
				<!--<div class="textareaBox">
					<textarea placeholder="请您添加问题描述" id="content"></textarea>
				</div>-->
				<div class="">
					<textarea name=""  class="text-adaption fz f28" placeholder="请您添加问题描述" rows="3" id="content"></textarea>
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
									{{--<div class="weui-uploader__input-box">--}}
										{{--<input id="uploaderInput" class="weui-uploader__input" type="file" accept="image/*" multiple="">--}}
									{{--</div>--}}
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

</div>
<!--导航大盒子id=page 结束-->
<!--放大-->
<div class="big_img">
	<div class="swiper-container2">
		<div class="swiper-wrapper"></div>
	</div>
	<div class="swiper-pagination"></div>
</div>


<br><br><br>

<script src="/js/ask.js"></script>
<script src="/lib/layer/layer.js"></script>


<script type="text/javascript">
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

	/*--------------------------------------*/
	var imgurl_list = "";
	var imgUrl      = "{{env('IMG_URL')}}";
	var img_number  = 0;
	var _token   = '{{csrf_token()}}';
	var c_length    = 0;
	//给body加一个类（为了弹窗有个父类）
	$('body').addClass('page_dialog_wrap');


	//展开
//	$('.btn_open').click(function (){
//		$(this).hide();
//		$(this).parents('.fiele_list_tea ul li').find('.imgs').show();
//	})
	function btn_open(obj){
		$(obj).hide();
		$(obj).parents('.fiele_list_tea ul li').find('.imgs').show();
	}
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
						console.log(data);
						if(img_number>=2){
							$("#upload_button").hide();
						}else{
							img_number++;
						}h
					}
				}
			});
		}
	});
	//提交
	$('.btn_submit').click(function (){
		imgurl_list = "";
		$(".img_url_list").each(function(){
			var cur = $(this).attr("data-url");
			imgurl_list+=cur+",";
		});
		var tit=$('#tit').val();
		var con=$('#content').val();
		var token   = '{{csrf_token()}}';
		var sid = "{{$special->id}}";
		console.log(imgurl_list);
		if(!tit){
			layer.msg('标题不能为空');
		}else if(!con){
			layer.msg('内容不能为空');
		}else{
			$.ajax({
				url : '/ask/qadd',
				type : 'post',
				dataType : 'json',
				data : {title:tit,desription:con,imgurl_list:imgurl_list,sid:sid,_token:token},
				success : function (data) {

					if(data.code == 1){
						var arr = imgurl_list.split(",");
						arr.splice(arr.length-1,1);
						//console.log(arr);
						var str = '<li><a href="javascript:void (0)" class="fz ptb30">';
						str += '<h3 class="f32 color_333 bold text-jus">'+tit+'</h3>';
						str +='<p class="f28 color_gray666 text-jus mt10">'+con+'</p>';
						str += '<div class="imgs hide">';
						for(var i= 0;i < arr.length;i++){
							str += '<img src="'+imgUrl+arr[i]+'" class="img100" />';
							console.log(str);
						}
						str += '</div>';
						str += 	'<div class="weui-cell noafter nobefore padding0 f26 color_gray9b mt26"><div class="weui-cell__bd">';
						str += 	'<p>360阅读· '+mydate+'</p></div><div class="weui-cell__ft" onclick="btn_open(this);">展开</div></div></a></li>';
						$(".append_more").prepend(str);
						$('.btn_open').click(function (){
							$(this).hide();
							$(this).parents('.fiele_list_tea ul li').find('.imgs').show();
						})

					}
					$('#tit').val('');
					$('#content').val('');
				}
			});
			$.closePopup();//关闭弹出框
		}

	})


	//取消
	$('.btn_cancel').click(function (){
		layer.open({
			title: '',
			content: '是否放弃提问',
			id: 'mylayer',
			closeBtn: 0, //不显示关闭按钮
			btn: ['放弃', '继续提问'],
			yes: function(index, layero) {
				//【放弃按钮】的回调
				layer.closeAll();
				$.closePopup();//关闭弹出框


			},
			btn2: function(index, layero) {
				//【继续回答】的回调

			}
		});
	})
	//关注取消关注
	function article_follow(e){
		var fans_id = e.getAttribute("data-fans_id");
		var user_id = e.getAttribute("data-user_id");
		var articleid  = e.getAttribute("id");
		var is_follow = e.getAttribute("data-is_follow");
		var token   = '{{csrf_token()}}';
		var mobile = "{{$user_id}}";
		if(mobile = 0){
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

	//跳转登陆函数
	var userlogin = function(){
		var url = "/ask/question/{{$teacher->id}}.html";
		layer.msg('请先注册');
		localStorage.setItem("redirect", url);
		setTimeout(function(){
			window.location.href = "/register";
		}, 500)
	}


</script>
<script type="text/javascript">
	var i = 2;
	$(".loadmore").click(function(){
		var token = "{{csrf_token()}}";
		var sid = "{{$special->id}}";
		var data_is_true = $(".loadmore").attr("data-is_ture");
		console.log(data_is_true);
		if(data_is_true == 0) {

			$.ajax({
				type: "POST",
				url: "/ask/loadmore",
				data: {sid: sid, page: i, is_question:1,_token: token},
				dataType: "json",
				success: function (result) {
					if(result.body !== '') {
						console.log(result);
						$(".loadmore").before(result.body);
						$('.btn_open').click(function (){
							$(this).hide();
							$(this).parents('.fiele_list_tea ul li').find('.imgs').show();
						})


						i++;
					}else{
						layer.msg("没有更多问题了！");
						$(".loadmore").attr("data-is_ture",1);
						$(".loadmore").text("已显示全部问题");
					}
				}
			});
		}else{
			layer.msg("没有更多作业了！");
		}

	})



</script>
<script>
	//删除图片
	var btn_delimg = function(e){
		var imgurl = e.getAttribute("data-url");
		var li     = e.parentNode.parentNode;
		var parent = li.parentNode;
		$.ajax({
			url: "/ask/deleteimg",
			type: "POST",
			data:  {imgurl:imgurl, _token:token},
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

	$(function(){
	   $('.flip').on('click',function(){
	      $(this).next().slideToggle(500);
	   });

	   //下拉箭头样式
	   var usercenter = {
	      init:function(){
	         this.modal();
	      },
	      modal: function() {
	         $(".flip").click(function(){
	            var arrow=$(this).children('.flip-arrow');
	            if(arrow.hasClass("rotate")){ //点击箭头旋转180度
	               arrow.removeClass("rotate");
	               arrow.addClass("rotate1");
	            }else{
	               arrow.removeClass("rotate1"); //再次点击箭头回来
	               arrow.addClass("rotate");
	            }
	         })
	      }
	   };
	   usercenter.init();
	})


	$(function(){
		$('.flip').on('click',function(){
			$(this).next().slideToggle(500);
		});

		//下拉箭头样式
		var usercenter = {
			init:function(){
				this.modal();
			},
			modal: function() {
				$(".flip").click(function(){
					var arrow=$(this).children('.flip-arrow');
					if(arrow.hasClass("rotate")){ //点击箭头旋转180度
						arrow.removeClass("rotate");
						arrow.addClass("rotate1");
					}else{
						arrow.removeClass("rotate1"); //再次点击箭头回来
						arrow.addClass("rotate");
					}
				})
			}
		};
		usercenter.init();
	})

	/*swiper弹出大图并轮播 start*/
	$(document).ready(function () {
		/*调起大图 S*/
		var mySwiper = new Swiper('.swiper-container2', {
			loop: false,
			pagination: '.swiper-pagination',
			paginationType: 'fraction'
		})
		$(".ImgMax").on("click", ".post img",
				function () {
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

		$(".big_img").on("click",
				function () {
					$(this).css({
						"z-index": "-1",
						"opacity": "0"
					});
				});
	});
	/*调起大图 E*/
</script>

@endsection
