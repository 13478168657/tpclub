@extends('layouts.header')
@section('title')
	<title>导师作业详情页-评论回复</title>
	<meta name="author" content="啾啾" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	@endsection

	@section('cssjs')
			<!--文章下css-->
	<link rel="stylesheet" href="/css/ask.css">
	<link rel="stylesheet" href="/css/ask_popup.css">

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
			<div class="daoshizuoye_box bgcolor_fff">
				<h2 class="tit f32 bold">{{$question->title}}</h2>
				<div class="weui-cell nobefore foot f24 pt0">
					<div class="weui-cell__bd color_gray9b">{{date("Y.m.d",strtotime($question->created_at))}}</div>
					<div class="weui-cell__ft">
						<a href="/ask/zuoye/{{$question->id}}/1/{{$can}}.html" class="f24">查看全部回答</a>
					</div>
				</div>
				<div class="imgs pb20 hide">
					<img src="/images/ask/test/banner1.jpg" class="img100 mb20" />
					<img src="/images/ask/test/banner1.jpg" class="img100 mb20" />
				</div>
			</div>
			<ul class="list_daoshizuoye mt20">
				@if($answer)
				<li>
					<?php
					$user = DB::table("users")->where("id",$answer->user_id)->select("name","nickname","avatar","introduction")->first();

					?>
					<div class="weui-cell head">
						<div class="weui-cell__bd">

							<a href="#" class="user_photo">
								@if($user)
									@if((strpos($user->avatar,'http') !== false))
										<img src="{{$user->avatar}}" alt="" class="img100">
									@else
										<img src="{{env('IMG_URL')}}{{$user->avatar}}" alt="" class="img100">
									@endif
								@else
									<img src="/images/my/nophoto.jpg" alt="" class="img100">
								@endif
							</a>
							<dl>
								@if($user)
									<dt>{{$user->name?$user->name:$user->nickname}}</dt>
									<dd>{{$user->introduction}}</dd>
								@else
									<dt></dt>
									<dd></dd>
								@endif
							</dl>

							<p>{{$answer->content}}</p>
							<span class="date color_gray9b">{{date("Y.m.d",strtotime($answer->created_at))}}</span>
						</div>
					</div>
					<div class="imgs pb20">
						<?php
						$imgList = $answer->imgurl_list;
						$imgArr = explode(",",$imgList);
						array_pop($imgArr);


						?>
						@if($imgList !== '')
							@foreach($imgArr as $a)
								<img src="{{env('IMG_URL')}}{{$a}}" class="img100 mb20" />
							@endforeach
						@endif

					</div>
					<div class="weui-cell nobefore foot">
					   <div class="weui-cell__bd fz f26 color_gray9b">
					      阅读量{{$answer->view}}
					   </div>
						@if($user_id == $answer->user_id)
						   <div class="weui-cell__ft">
							  <a href="javascript:;" class="f24 color_gray9b rev_del fz color_333">
								 <span  class="open-popup" data-target="#full1" ><img src="/images/ico_rev.png"alt="">修改</span>
								  @if(count($comment)>0)
								 		<span class="btn_del btn_del_comment" data-attr = 1><img src="/images/ico_del.png" alt="">删除</span>
									  @else
									  	<span class="btn_del btn_del_comment" data-attr = 0><img src="/images/ico_del.png" alt="">删除</span>
									@endif
							  </a>
						   </div>
						@endif
					</div>
				</li>
					@else
					<li>答案已删除~</li>
				@endif
			</ul>
			<!-- 全部评论 start -->
			<h2 class="color_gray666 f30 text_center ptb40 bgcolor_fff cat_pl">全部评论</h2>

			<ul class="list_comment">
				@if(count($comment) > 0)
					@foreach($comment as $k=>$v)
						<li>
							<div class="pl_item noafter first_data{{$v->id}}">
								<div class="clearfix">
									<?php
									$all = get_teacher_name($v->user_id);
									?>
									<a href="#" class="user_photo">
										@if((strpos($all->avatar,'http') !== false))
											<img src="{{$all->avatar}}" alt="" class="img100">
										@else
											<img src="{{env('IMG_URL')}}{{$all->avatar}}" alt="" class="img100">
										@endif

									</a>
									<div class="info fl">

										<span class="f32 bold name">{{$all->name?$all->name:$all->nickname}}</span>
										<span class="f24 color_gray9b date">{{date("Y.m.d",strtotime($v->created_at))}}</span>
									</div>
									{{--data-target="#full1"--}}
									@if($can==0)
									<div class="btn_reply fr" onclick="layer.msg('请将关联的课程添加到我的课表');"><span>回复</span>
									</div>
									@else
									<div class="btn_reply fr open-popup" onclick="two_open(this);" first_key="{{$v->id}}" author_name = "{{$all->name?$all->name:$all->nickname}}" author_id = "{{$v->id}}" data-level="2"><span>回复</span>
									</div>
									@endif
								</div>
								<p class="cont">{{$v->content}}</p>
							</div>

							<!--二级回复-->
							<?php
							$two = DB::table("ask_comment")->where("aid",$answer->id)->where("level",2)->orderBy("created_at","desc")->where("cid",$v->id)->limit(3)->get();


							?>
							@if(count($two) > 0)
								@foreach($two as $k => $a)
									<?php
									$all2 = get_teacher_name($a->user_id);
									?>
									<div class="hf_item bgcolor_f9f9f9">
										<div class="clearfix">
											<a href="#" class="user_photo">
												@if((strpos($all->avatar,'http') !== false))
													<img src="{{$all2->avatar}}" alt="" class="img100">
												@else
													<img src="{{env('IMG_URL')}}{{$all2->avatar}}" alt="" class="img100">
												@endif

											</a>
											<div class="info fl">
												<span class="f32 bold name">{{$all2->name?$all2->name:$all2->nickname}}</span>
												<em class="f24 color_gray9b date">回复</em>
												<span class="f32 bold name ml20">{{$all->name?$all->name:$all->nickname}}</span>
											</div>
										</div>
										<p class="cont">
											<?php
												$content_arr = explode(" ",$a->content);
												$cont = '';
												if(isset($content_arr[1])){
													$cont = $content_arr[1];
												}
											?>
											{{$cont}}</p>
										<div class="ptb30 clearfix">
											<span class="date_hf f24 color_gray9b fl">{{date("Y.m.d",strtotime($a->created_at))}}</span>
											{{--<span class="btn_reply2 fl open-popup" data-target="#full">回复</span>--}}
										</div>

									</div>
									@endforeach
									@endif
											<!---end-->

						</li>
					@endforeach
				@endif

			</ul>
			@if(count($comment) > 0)
			<!-- 全部评论 end -->
				<div class="nomore f24 color_gray666 text_center ptb50 bgcolor_fff loadmore" onclick="loadmore(this);" data-load = 0>加载更多</div>
			@else
				<div class="start_weipingjia text_center">
					<div class="color_c9c7c7 fz f24 mt30 pt40">
						<img src="/images/shafa.png" alt="">
						<p class="mb40 pt10 pb30">沙发还没有人坐，请发言</p><br/><br/><br/><br/><br/>
					</div>
				</div>
			@endif

		</div>
		<!--边距30 end-->
	</div>
	<!--导航大盒子id=page 结束-->

	<!-- 底部固定按钮 start -->
	<div class="fixed_bar_bottom">
		<div class="btn_double_wrap clearfix max750">
			<div class="weui-flex">
				<div class="weui-flex__item text_center ">
					@if($user_id == 0)
						<a href="javascript:void(0)" class="f30 btn_add_comments open-popup" onclick="userlogin();">添加评论</a>
					@elseif($can == 0)
						<a href="javascript:void(0)" class="f30 btn_add_comments " onclick="layer.msg('购买该导师课程后才可以提问哦~');">添加评论</a>
					@else
						<a href="javascript:void(0)" class="f30 btn_add_comments open-popup one_open" data-level="2">添加评论</a>
					@endif
				</div>
				<div class="weui-flex__item text_center ">
					<?php
						$is_zan = DB::table("ask_zan")->where("user_id",$user_id)->where("aid",$answer->id)->count();

					?>
					@if($user_id == 0)
						<a href="javascript:void(0)" class="f30" onclick="userlogin();">赞同</a>
					@elseif($can == 0)
						<a href="javascript:void(0)" class="f30 btn_agree" onclick="layer.msg('购买该导师课程后才可以提问哦~');">赞同</a>
					@else
						@if($is_zan == 0)
							<a href="javascript:void(0)" class="f30 btn_agree" data-agree = "0">赞同</a>
						@else
							<a href="javascript:void(0)" class="f30 btn_agree" data-agree = "1">已赞</a>
						@endif
					@endif

				</div>
			</div>
		</div>
	</div>
	<!-- 底部固定按钮 end -->

	<!-- popup -->
	<div id="full" class='weui-popup__container bgcolor_fff ask_popup'>
		<div class="weui-popup__overlay"></div>
		<div class="weui-popup__modal bgcolor_fff">
			<!-- 头部条 start -->
			<header class="header_bar max750 relative">
				<a href="javascript:void(0)" class="btn_cancel btn_cancel_comment color_gray999 f24">取消</a>
				<div class="cat1 f28">回答评论</div>
				<a href="javascript:void(0)" class="btn_link btn_submit color_gray999 f24">提交</a>
			</header>
			<!-- 头部条 end -->
			<!-- 表单区 start -->
			<div class="ask_con">
				<div class="textareaBox mt20 mb20 pb20 pt20 plr20" style="border:1px solid rgba(204,204,204,.4);">
				{{$answer->content}}
				</div>
				<div class="">
					<textarea name=""  class="text-adaption fz f28" placeholder="请发表您的评论…"  id="content" rows="10"></textarea>
				</div>
			</div>
			<!-- 表单区 end -->
		</div>
	</div>




	<!-- 底部固定按钮 end -->

<!--/////////////////////////////////////////////////////////////////////////////////-->
	<div id="full1" class='weui-popup__container bgcolor_fff ask_popup'>
		<div class="weui-popup__overlay"></div>
		<div class="weui-popup__modal bgcolor_fff">
			<!-- 头部条 start -->
			<header class="header_bar max750 relative">
				<a href="javascript:void(0)" class="btn_cancel btn_cancel_update color_gray999 f24">取消</a>
				<a href="javascript:void(0)" class="btn_link btn_submit1 color_gray999 f24">提交</a>
			</header>
			<!-- 头部条 end -->
			<!-- 表单区 start -->
			<div class="ask_con">
				<div class="iptBox">
					<input type="text" id="tit" maxlength="50" onfocus="this.blur();" value="{{$question->title}}" />
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
										@if($imgList !== '')
											@foreach($imgArr as $a)
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

	<!--////////////////////////////////////////////////////////////////////////////---->


<script src="/js/ask.js"></script>

<script type="text/javascript">
var token   = '{{csrf_token()}}';
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
		var imgUrl      = "{{env('IMG_URL')}}";
		//给body加一个类
		$('body').addClass('page_dialog_wrap');

		$('.btn_agree').click(function (){
			var aid = "{{$answer->id}}";
			var agree = $(this).attr("data-agree");
			if(agree == 0){
				$.ajax({
					url : '/ask/zan',
					type : 'post',
					dataType : 'json',
					data : {aid : aid,_token:token},
					success : function (data) {

						if(data.code == 1){
							$(".btn_agree").text('已赞');
							$(".btn_agree").attr("data-agree",1);
						}

					}
				});
			}
		})
var author_id = 0;

var user_avatar = '{{$users?$users->avatar:""}}';
var user_name = '{{$users?$users->nickname:""}}';
var author_name = '';
var key = '';

function two_open(e){
	var author_id_two = e.getAttribute("author_id");//评论id
	author_name = e.getAttribute("author_name");
	author_id = author_id_two;
	key = e.getAttribute("first_key");

	$("#content").val("@"+author_name+" ");
	$("#full").popup();
}



$(".one_open").click(function(){
	author_id = 0;
	$("#full").popup();
})

		//提交
		$('.btn_submit').click(function (){
			console.log(author_id);

			var con = $('#content').val();
			var aid = "{{$answer->id}}";

			if(!con){
				layer.msg('内容不能为空');
			}else{
				$.ajax({
					url : '/ask/comment',
					type : 'post',
					dataType : 'json',
					data : {con : con,aid:aid,cid:author_id,_token:token},
					success : function (data) {
						if(data.code == 1){
							console.log(key);
							layer.msg("评论成功");
							$(".start_weipingjia").addClass("hide");
							if(author_id == 0){
								var str = '';
								str = '<li class="first_data'+data.id+'"><div class="pl_item "><div class="clearfix"><a href="#" class="user_photo">';
								str +=	'<img src="'+user_avatar+'" alt="" class="img100"></a><div class="info fl">';
								str +=	'<span class="f32 bold name">'+user_name+'</span><span class="f24 color_gray9b date">'+mydate+'</span></div>';
								str +='<div class="btn_reply fr open-popup" onclick="two_open(this);" first_key="'+data.id+'" author_name = "'+user_name+'" author_id = "'+data.id+'" data-level="2"><span>回复</span></div>';
								str +='</div><p class="cont">'+con+'</p></div></li>';
								$(".list_comment").append(str);
							}else{

								/**---<span class="btn_reply2 fl open-popup" data-target="#full">回复</span>-----**/
								var str = '';
								str += '<div class="hf_item bgcolor_f9f9f9"><div class="clearfix">';
								str += '<a href="#" class="user_photo"><img src="'+user_avatar+'" alt="" class="img100"></a>';
								str += '<div class="info fl"><span class="f32 bold name">'+user_name+'</span><em class="f24 color_gray9b date">回复</em>';
								str += '<span class="f32 bold name ml20">'+author_name+'</span></div></div><p class="cont">'+con.split(' ')[1]+'</p>';
								str += '<div class="ptb30 clearfix"><span class="date_hf f24 color_gray9b fl">'+mydate+'</span>';
								str += '</div></div>';
								/**--------**/
								$(".first_data"+key).append(str);
							}

							$("#content").val("");
						}
					}
				});
				$.closePopup();//关闭弹出框
			}

		})


		//取消
		$('.btn_cancel_comment').click(function (){
			layer.open({
				title: '',
				content: '是否放弃评论',
				id: 'mylayer',
				closeBtn: 0, //不显示关闭按钮
				btn: ['放弃', '继续评论'],
				yes: function(index, layero) {
					//【放弃按钮】的回调
					layer.closeAll();
					$.closePopup();//关闭弹出框
					$('#content').val('');

				},
				btn2: function(index, layero) {
					//【继续回答】的回调

				}
			});
		})

		//取消
		$('.btn_cancel_update').click(function (){
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
					$('#content').val('');

				},
				btn2: function(index, layero) {
					//【继续回答】的回调

				}
			});
		})

		//删除作业
		$('.btn_del_comment').click(function (){
			var status = $(this).attr("data-attr");
			var answer_id = "{{$answer->id}}";
			if(status == 1){
				layer.msg("已有评论不能删除哦~");
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
							data : {answer_id : answer_id,_token:token},
							success : function (data) {
								console.log(answer_id);
								if(data.code == 1){
									layer.msg("删除成功");
									window.location.href = "/ask/zuoye/{{$question->id}}/1/{{$can}}.html";
								}
							}
						});

					}
				});
			}

		})



		//跳转登陆函数
		var userlogin = function(){
			var url = "/ask/zuoyedetail/{{$question->id}}/{{$answer->id}}.html";
			layer.msg('请先注册');
			localStorage.setItem("redirect", url);
			setTimeout(function(){
				window.location.href = "/register";
			}, 500)
		}

	</script>

	<script>
	var i = 2;
	var can = "{{$can}}";
	var loadmore = function(e){
		var loaddata = e.getAttribute("data-load");
		console.log(loaddata);
		if(loaddata == 0){
			var answer_id = "{{$answer->id}}";
			$.ajax({
				url : '/ask/morecomment',
				type : 'post',
				dataType : 'json',
				data : {answer_id : answer_id,page:i,_token:token, can:can},
				success : function (data) {
					if(data.body == ''){
						layer.msg("加载完成哦~");
						$(".loadmore").text("加载完成");
						$(".loadmore").attr("data-load",1);
					}else{
						$(".list_comment").append(data.body);
					}


					i++;
				}
			});
		}else{
			layer.msg("加载已完成哦~");
		}

	}


	</script>
	<script>
		//修改作业
		$('#content_ans').val("{{$answer->content}}");

		$('.btn_submit1').click(function (){
			console.log('yaya');
			imgurl_list = "";
			$(".img_url_list").each(function(){
				var cur = $(this).attr("data-url");
				imgurl_list+=cur+",";
			});
			var tit=$('#tit').val();
			var con=$('#content_ans').val();
			var qid = "{{$question->id}}";
			var author = "{{$question->user_id}}";
			var aid = "{{$answer->id}}";
			var token   = '{{csrf_token()}}';
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
						update:1,
						aid:aid,
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
		var imgUrl      = "{{env('IMG_URL')}}";
		var _token   = '{{csrf_token()}}';
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
							var length = $(".img_list li").length;
							console.log(length);
							console.log(data);
							if(length>=3){
								$("#upload_button").hide();
							}
							$("#cur_span"+c_length).attr("data-url", data.url);
							console.log("图片地址是"+data.url);
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
						var length = $(".img_list li").length;
						//判断上传按钮是否显示
						if(length<3){
							$("#upload_button").show();
						}
					}
				}
			});
		}





	</script>
@endsection