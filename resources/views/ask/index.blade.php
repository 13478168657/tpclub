@extends('layouts.header')
@section('title')


<title>问答专场-已回答</title>
<meta name="author" content="啾啾" />
<meta name="keywords" content="" />
<meta name="description" content="" />
	@endsection

	@section('cssjs')
	<!--问答下css-->
	<link rel="stylesheet" href="/css/ask.css?t=1.1">
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
				{{--<span class="f24 border-radius50">你问我答</span>--}}
				<p class="text_center f36 bold pt40">{{$special->title}}</p>
                <?php
                    $start_time = $special->start_time;
                    $end_time = $special->end_time;
					$time = time();
                    if($start_time && $end_time){

                        $stTime = strtotime($start_time);
                        $endTime = strtotime($end_time);

                        if($stTime <= $time && $time <= $endTime){
                            $courseStage = '问答进行中';
                            $flag = 1;
                        }elseif($time < $stTime){
                            $courseStage = '问答进行中';
                            $flag = 1;
                        }elseif($time > $endTime){
                            $courseStage = '问答已结束';
                            $flag = 0;
                        }
                    }else{
                        $courseStage = '问答进行中';
                        $flag = 1;
                    }
                ?>
				<p class="Pswitch text_center"><span class="border-radius50 color_orange border1Orange f24 fz">{{$courseStage}}</span></p>
				<!--<p class="Pswitch text_center"><span class="border-radius50 color_fff  border1White f24 fz">问答已结束</span></p>-->

				{{--<p class="text_center color_fff fz f24 pt26">-2019.07.06</p>--}}
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
							<img src="{{$teacher?$teacher->avatar:''}}" class="border-radius50">
						@else
							<img src="{{env('IMG_URL')}}{{$teacher?$teacher->avatar:''}}" class="border-radius50">
						@endif

					</div>
					<div class="weui-cell__bd fz">
						<p class="bold f32">{{$teacher?$teacher->nickname:''}}</p>
						<p class="f26">{{$teacher?$teacher->introduction:'暂无介绍'}}</p>
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
				<li><a href="javascript:void (0)" class="cur">已回答</a></li>
				<li><a href="/ask/question/{{$special->id}}.html">待导师回答</a></li>
				<li><a href="/ask/field/{{$special->id}}.html">导师作业</a></li>
			</ul>
		</div>
		<!--导航 end-->

		<!--列表 start-->
		<div class="fiele_list_tea HuidaImgMax fiele_list_tea3  plr30">
			<ul class="append_more">
				@if(count($question)>0)
					@foreach($question as $v)
				<li>
					<!--提问-->
					<a href="javascript:void (0)" class="fz ptb30">
						<h3 class="f32 color_gray666 bold text-jus"><img src="/images/ask/wen.png" alt="">{{$v->title}}</h3>
						<p class="f28 color_gray999 text-jus mt10">{{$v->description}}</p>
						<div class="imgs hide ImgMax">

							<?php
								$imgList = $v->imgurl_list;
								$imgArr = explode(",",$imgList);
								array_pop($imgArr);
								$askUser = App\User::where('id',$v->user_id)->first();
								if($askUser){
									$askName = $askUser->name?$askUser->nickname:'';
								}else{
									$askName = '';
								}
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
                                @if($askName)
								    <p>{{$askName}}&nbsp;&nbsp;{{date("Y.m.d",strtotime($v->created_at))}}</p>
                                @else
                                    <p>{{date("Y.m.d",strtotime($v->created_at))}}</p>
                                @endif
							</div>
							@if($imgList !== '' && !is_null($imgList))
								<div class="weui-cell__ft btn_open">展开</div>
							@endif
						</div>
					</a>
					<?php
							$answer = DB::table("ask_answer")->where("qid",$v->id)->first();	//答案
							if(count($answer)>0){
								$users = DB::table("users")->where("id",$answer->author_id)->select("name","introduction","avatar","nickname")->first();
							}

					?>
					@if(count($answer) > 0 )
					<!--回答-->
					<div class="fiele_list_tea_da pt40">
						<a class="weui-cells  noafter nobefore padding0 mt0 no_b_border">
							<div class="weui-cell noafter nobefore padding0 ">
								<div class="weui-cell__hd">

									@if(count($users)>0)
										@if(strpos($users->avatar,'http') !== false)
											<img src="{{$users->avatar}}" class="border-radius50">
										@else
											<img src="{{env('IMG_URL')}}{{$users->avatar}}" class="border-radius50">

										@endif
										@else
										<img src="/images/ask/Group.png" class="border-radius50">
									@endif

								</div>
								<div class="weui-cell__bd fz">
									<p class="bold f28 color_333">@if(count($users)>0) {{$users->name == ''?$users->nickname:$users->name}} @endif<span class="f16 color_orange border-radius-img">导师</span></p>
									<p class="f26">{{$users?$users->introduction:''}}</p>
								</div>
							</div>
						</a>
						<div class="fz ptb30">
							<h3 class="f32 color_333 text-jus ConHref">
								<p class="HrefWrap" data-id="{{$v->id}}_{{$answer->id}}_1">
									<img src="/images/ask/da.png" alt="">{{$answer->content}}
								</p>
								<div class="read-more"></div>
							</h3>
							<p class="f24 color_gray9b mt26">{{date("Y.m.d",strtotime($answer->created_at))}}<span class="f24 color_gray9b fr"><!-- <img src="/images/ask/zan_h.png" alt="" class="fie_zan">赞同{{$answer->zan}}</span> --></p>
						</div>
					</div>
					@endif
				</li>
				<div class="bor20 mlrfu-30"></div>
					@endforeach
				@endif


			</ul>
			@if(count($question) > 4)
				<a href="javascript:void (0)" class="Load fz text_center pt40 mt20 color_gray666 f24 loadmore" data-is_ture="0">加载更多</a><br/><br/><br/>
			@endif
		</div>
		<!--列表 end-->



		<!--底部悬浮【新建一个专题】按钮 start-->
		<div class="fixed_bar_bottom">
			<div class="btn_wrap bgcolor_fff">
				@if($user_id == 0)
					<a href="javascript:void(0)" class="f28 fz text_center bgcolor_gray open-popup color_333" onclick="userlogin();">向导师提问，等待专家的针对性回答</a>
				@elseif($can == 0)
					<a href="javascript:void(0)" class="f28 fz text_center bgcolor_gray color_333" onclick="layer.msg('购买该导师课程后才可以提问哦~');window.location.href='/train/study.html?id={{$special->course_class_group_ids}}';">向导师提问，等待专家的针对性回答</a>
				@else
					<a href="javascript:void(0)" class="f28 fz text_center bgcolor_gray open-popup color_333" data-target="#full">向导师提问，等待专家的针对性回答</a>
					<!--<a href="javascript:void(0)" class="f28 fz text_center bgcolor_gray color_gray999" >专场已经结束，看看专家解答吧</a>-->
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
				<a href="javascript:void(0)" class="btn_link btn_submit color_gray999 f24 ">提交</a>
			</header>
			<!-- 头部条 end -->
			<!-- 表单区 start -->


			<div class="ask_con">
				<div class="iptBox">
					<input type="text" id="tit" name="title" placeholder="请用一句话描述问题并以问号结尾（最多50字）" maxlength="50" />
				</div>

				<div class="">
					<textarea name="description"  class="text-adaption fz f28" placeholder="请您添加问题描述" rows="3" id="content" ></textarea>
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
	var imgurl_list = "";
	var imgUrl      = "{{env('IMG_URL')}}";
	var img_number  = 0;
	var c_length    = 0;
	var _token      = '{{csrf_token()}}';

	//给body加一个类（为了弹窗有个父类）
	$('body').addClass('page_dialog_wrap');

	//展开
	$('.btn_open').click(function (){
		$(this).hide();
		$(this).parents('.fiele_list_tea ul li').find('.imgs').show();
	})

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
						}
						$("#cur_span"+c_length).attr("data-url", data.url);
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
		if(!tit){
			layer.msg('标题不能为空');
		}else if(!con){
			layer.msg('内容不能为空');
		}else{
			console.log(tit);
			console.log(imgurl_list);
			$.ajax({
				url : '/ask/qadd',
				type : 'post',
				dataType : 'json',
				data : {title:tit,desription:con,imgurl_list:imgurl_list,sid:sid,_token:token},
				success : function (data) {
					console.log(data);
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
				//$('#tit').val('');
				//$('#content').val('');

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

<script>

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
</script>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
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

	var link = 'http://m.saipubbs.com/ask/answer/{{$special->id}}.html';
	var title = '导师问答专区';
	var desc = '疑难问题全知道~';
	var img = 'http://m.saipubbs.com/images/ask/ask_share.png';
	wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
		wx.onMenuShareAppMessage({
			title: title, // 分享标题
			desc: desc, // 分享描述
			link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
			imgUrl: img, // 分享图标

		}, function(res) {
			//这里是回调函数

		});
	});
	wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
		wx.onMenuShareTimeline({
			title: title, // 分享标题
			link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
			imgUrl: img, // 分享图标

		}, function(res) {
			//这里是回调函数

		});
	});
</script>


<script type="text/javascript">
	var i = 2;
	$(".loadmore").click(function(){
		var token = "{{csrf_token()}}";
		var sid = "{{$special->id}}";
		var data_is_true = $(".loadmore").attr("data-is_ture");
		if(data_is_true == 0) {
			$.ajax({
				type: "POST",
				url: "/ask/loadmorequestion",
				data: {sid: sid, page: i, _token: token},
				dataType: "json",
				success: function (result) {

					if(result.body !== '') {
						$(".append_more").append(result.body);
						$('.btn_open').click(function (){
							$(this).hide();
							$(this).parents('.fiele_list_tea ul li').find('.imgs').show();
						})
						i++;
					}else{
						layer.msg("已经显示全部了哦");
						$(".loadmore").attr("data-is_ture",1);
						$(".loadmore").text("已经显示全部了哦");
					}
				}
			});
		}else{
			layer.msg("已经显示全部了哦！");
		}

	})

	/*swiper弹出大图并轮播 start*/
	$(document).ready(function () {
		/*调起大图 S*/

		$(".big_img").on("click",function () {
			$(this).css({
				"z-index": "-1",
				"opacity": "0"
			});
		});
	});
	function slidePhoto(obj){
		var mySwiper = new Swiper('.swiper-container2', {
			loop: false,
			pagination: '.swiper-pagination',
			paginationType: 'fraction'
		})
		var imgBox = $(obj).parents(".post").find("img");
		var i = $(imgBox).index(obj);
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
	}

	/*调起大图 E*/
	/*swiper弹出大图并轮播 end*/



	/*超出出现【全文】*/
	$(function(){

		var slideHeight = 68; // px
		var defHeight = $('.HrefWrap').height();

		$('.HrefWrap').each(function(i){
			var defHeight = $(this).height();
//alert(defHeight);
			if(defHeight >= slideHeight){
				var askInfo = $('.HrefWrap').eq(i).attr('data-id');
                var askArr = askInfo.split('_');

				var url = '/ask/zyxiangqing/'+askArr[0]+'/'+askArr[1]+'/1.html';
				$('.ConHref').eq(i).bind('click',function(){
					window.location.href = url;
				});
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

</script>
@endsection
