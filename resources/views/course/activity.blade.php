<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
		<title>{{$data->title}}{{env('WEB_TITLE')}}</title>
		<meta name="author" content="络绎" />
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
		<link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
		<link href="/css/reset.css" rel="stylesheet" type="text/css" />
		<link href="/css/xueyuan-detail2.css" rel="stylesheet" type="text/css" />
		<!--mmenu.css start-->
		<link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
		<link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
		<link href="/css/nav-mmenu-public.css" rel="stylesheet" />
		<!--end-->
		<script src="/js/TouchSlide.1.1.js"></script>
		<script>
			(function(){
				var html = document.documentElement;
				var hWidth = html.getBoundingClientRect().width;
				html.style.fontSize=hWidth/18.75+'px';
			})()
		</script>
		<style>
			.bm_success_layer_wrap {
			  width: 13.75rem !important;
			  height: 18.15rem !important;
			  border-radius: 0.25rem !important;
			}
			.bm_success_layer_wrap .bm_success {
			  display: block;
			  width: 9rem;
			  height: auto;
			  margin: .9rem auto 0rem;
			}
			.bm_success_layer p{font-size: .7rem;line-height: 1rem;}
			.bm_success_layer p:last-child{font-size: .8rem;}
		</style>
	</head>
<body ontouchstart>

<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->
<!--头部导航 start-->
        <div class="mh-head Sticky">
            <div class=" menu-bg-logo">
                <span class="mh-btns-right">
                    <a class="icon-menu" href="#menu"></a>
                    <a class="icon-menu" href="#page"></a>
                </span>
            </div>
        </div>

        <!--隐藏导航内容-->
        <nav id="menu">
            <div class="text_center nav-a">
                <ul>
                    <li><a href="/">首页</a></li>
                    <li><a href="/user/studying">正在学习</a></li>
                    <li><a href="/user/index">我的</a></li>
                    <li><a href="javascript:history.go(-1);">返回</a></li>
                </ul>
            </div>
        </nav>
        <!--头部导航 end-->

<div class="bgc_white pb100 mb40">
	<!-- banner start -->
	<div class="banner">
		<img src="{{env('IMG_URL')}}{{$data->explain_url}}" class="img100" alt="{{$data->title}}" />
	</div>
	<!-- banner end -->

	<!--本篇标题 start-->
	<div class="weui-cells xy-kecheng-tit mt0 noafter nobefore ">
		<div class="weui-cell">
			<div class="weui-cell__bd text-overflow ">
				<h2 class="lt text-overflow">{{$data->title}}</h2>
				<p class="color_gray666 fz">{{$data->sum_video}} 节课·{{$data->sum_people}} 人正在提高中</p>
			</div>
			@if(is_collect($data->id,$user_id) == 1)
			<div class="weui-cell__ft text_center ">
				<div id="button_shoucang">
					<img  id="wei_shoucang" data-collect="1" src="/images/yishoucang.png" alt="已收藏课程" data-attr="{{$data->id}}" />
				</div>
			</div>
			@else
			<div class="weui-cell__ft text_center ">
				<div id="button_shoucang">
					<img  id="wei_shoucang" data-collect="0" src="/images/shoucang.png" alt="未收藏课程" data-attr="{{$data->id}}" />
				</div>
			</div>
			@endif
		</div>
	</div>
	<!--本篇标题 end-->
<!-- <span class="baomingBtn" onclick="follow_us()">报名成功</span> -->
	<!-- 选项卡 start ================================ -->
	<div id="leftTabBox" class="tabBox">
		<div class="hd" id="nav_keleyi_com">
			<ul>
				<li><a href="javascript:void(0)" ><span>课程简介</span></a></li>
				<li><a href="javascript:void(0)"><span>课程目录</span></a></li>
				
			</ul>
		</div>
		<div class="bd" id="tabBox1-bd">
			<div class="con">
				<div>
					<!--简介 start-->
					<article class="weui-article color_gray666 xy-kecheng-wen text-jus bottomheightgrey">
						<section>
							<!--<h2 class="lt grey">简介</h2>-->
							<section class="fz">
								<?php
				                    echo $data->introduction;
								?>
							</section>
						</section>
					</article>
					<!--简介 end-->
				</div>
			</div>
			<div class="con">
				<!--课程目录 start-->
				<div class="afterleftright075 bottomheightgrey"><!--afterleftright075/代表线的父级-->
					<div class="weui-cells noafter nobefore mt0 xy-kecheng-liebiao pb10">
						<div class=""><!--weui-cell-->
							<div class="weui-cell__bd fz">
								<div class="container">
									<div class="toggleBox">
										@foreach($array as $k=>$v)
											<div class="item">
											<h3>
												<strong class="fl"><span class="num">{{$k+1}}</span>{{$v->title}}</strong>
												@if($k == 0) 
												<i class="arrowBtn fr up"></i> 
												@else 
												<i class="arrowBtn fr"></i> 
												@endif
											</h3>
				<!--如果免费或者已购买或已加入学习-->
				@if($data->is_free==0 || is_baoming($data->id,$user_id) == 1)
					@if($k == 0) 
					<ul class="block">
					@else
					<ul>  
					@endif
						@foreach($v->course as $a)
						<li onclick="go_video('{{$data->id}}','{{$a->id}}');">
							<h4 class="fl onerow">
							<img src="/images/ico_video.png" class="ico_video" />{{$a->title}}
							</h4>
						</li>
						@endforeach
					</ul>
				@else
					@if($k == 0) 
					<ul class="block">
					@else
					<ul>  
					@endif
						@foreach($v->course as $a)
						@if($a->preview)
						<li onclick="go_video('{{$data->id}}','{{$a->id}}');">
						@else	
						<li onclick="follow_us()">
						@endif	
							<h4 class="fl onerow">
							<img src="../images/ico_video.png" class="ico_video" />{{$a->title}}
							</h4>
							@if($a->preview)
							<span class="shiting fr">试听</span>
							@endif
						</li>
						@endforeach
					</ul>
				@endif							
											
										</div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--课程目录 end-->
			</div>
			
		</div>
	</div>
	<!-- 选项卡 end ================================ -->


	<!--作者名片 start-->
	<div class="afterleftright075">
		<div class="weui-cells mt0 daoshi-tit nobefore">
			<a class="weui-cell weui-cell_access " href="/user/teacher/{{$data->user_id}}">
				<div class="weui-cell__hd">
					@if($data->avatar)
					<img class="border-radius50" src="{{env('IMG_URL')}}{{$data->avatar}}">
					@else
					<img class="border-radius50" src="/images/my/nophoto.jpg" alt="" />
					@endif
				</div>
				<div class="weui-cell__bd text-overflow">
					<h2 class="lt">{{$data->teacher_name}} 导师</h2>
					<p class="fz text-overflow color_gray666">{{$data->teacher_inc}}</p>
				</div>
				<div class="weui-cell__ft fz">个人主页</div>
			</a>
		</div>
	</div>
	<!--作者名片 end-->
	
	@if(avg_comments($data->id))
	<!-- 课程评价 start -->
	<div class="weui-cell nobefore mt10">
		<div class="weui-cell__bd">
			<h2 class="fs15 bold">课程评价<span class="ml10">{{avg_comments($data->id)}}分</span></h2>
		</div>
		<div class="weui-cell__ft">
			<a href="/course/comments/{{$data->id}}" class="fs12 grey1">查看全部评价&nbsp;&nbsp;{{sum_comments($data->id)}}&nbsp;<img src="/images/ico_arrow_db.png" class="ico_arrow_db ml5" /></a>
		</div>
	</div>
	<div class="weui-cell evaluate nobefore">
		<div class="weui-cell__bd">
			<a href="javascript:;" class="user_photo"><img src="{{env('IMG_URL')}}{{$comment_one->users? $comment_one->users->avatar: ''}}" alt="" class="img100" /></a>
			<dl>
				<dt>{{$comment_one->users?$comment_one->users->name:''}} </dt>
				<dd>
					<ul class="stars">
						<?php
                          echo  htmlspecialchars_decode($comment_one->stars)
                        ?>
					</ul>
					<span class="score">{{$comment_one->score}}.0&nbsp;分</span>
				</dd>
			</dl>
			<p>{{$comment_one->content}}</p>
		</div>
	</div>
	<!-- 课程评价 end -->
	@else
	<!--课程未评价 start-->
	<div class="mt10 ke_weipingjia text_center">
		<div class="color_gray666 mb40">
			<p class="mb40 pt40">还没有人评价，赶快来评价吧！</p>
			@if(is_baoming($data->id,$user_id) == 1)
			<a class="border-radius-img" href="/course/commentadd/{{$data->id}}">我要评价 <img src="/images/icon_ping.png" alt=""></a>
			@else
			<a class="border-radius-img" href="javascript:;" onclick="layer.msg('报名后才能评价')">我要评价 <img src="/images/icon_ping.png" alt=""></a>
			@endif
		</div>
	</div>
	<!--课程未评价 end-->
	@endif
</div>
</div>
<!-- 底部固定条 start -->
<div class="fixed_bar_bottom">
	<ul class="clearfix btnsWrap">
		<li class="studyBtn" style="width:100%;" onclick="follow_us()"><a href="javascript:;">免费报名</a></li>
	</ul>
</div>
<!-- 底部固定条 end -->

<!-- 底部弹出popup start -->
<div id="half" class='weui-popup__container popup-bottom payType_popup'>
    <div class="weui-popup__overlay"></div>
    <div class="weui-popup__modal">
        <div class="toolbar">
            <div class="toolbar-inner">
                <a href="javascript:;" class="picker-button close-popup">关闭</a>
                <h1 class="title">确认付款</h1>
            </div>
        </div>
        <div class="modal-content bgc_white">
			<div class="weui-cell  weui-cell">
				<div class="weui-cell__bd">
					<h2 class="fs14">课程费用</h2>
				</div>
				<div class="weui-cell__ft">
					<span class="price">{{$data->price}}元</span>
				</div>
			</div>
			<div class="weui-cells weui-cells_radio noafter">
				<label class="weui-cell weui-check__label" for="x11">
					<div class="weui-cell__bd">
						<p><i class="ico_wx"></i>微信支付</p>
					</div>
					<div class="weui-cell__ft">
						<input type="radio" class="weui-check" name="radio1" id="x11" value="WXPAY" checked />
						<span class="weui-icon-checked"></span>
					</div>
				</label>
				@if($balance)
				<label class="weui-cell weui-check__label" for="x12">
				@else
				<label class="weui-cell weui-check__label disabled" for="x12">
				@endif	
					<div class="weui-cell__bd">
						<p><i class="ico_balance"></i>余额支付</p>
					</div>
					<div class="weui-cell__ft">
						<input type="radio" name="radio1" class="weui-check" id="x12" value="BANLANCE">
						<span class="weui-icon-checked"></span>
					</div>
				</label>
			</div>
			<div class="container pt15 pb15">
				<a href="javascript:void(0);" class="roy_btn bgc_yellow payBtn" data-is_weixin="{{$is_weixin}}">立即付款</a>
			</div>
        </div>
    </div>
</div>
<!-- 底部弹出popup end -->

<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
  $(function() {
    FastClick.attach(document.body);
  });
</script>
<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>

<script>
	var user_id = "{{$user_id}}";      //用户id
	var c_c_id  = "{{$data->id}}";     //课程id
	var is_weixin = "{{$is_weixin}}";  //是否为微信浏览器
	var token   = '{{csrf_token()}}';
	var video_id = "{{$array[0]->course[0]->id}}";
	var mobile   = "{{$mobile}}";
	var keyword  = "{{$keyword}}";

	//微信jsapi支付成功后跳转地址
	function blacktle2() {
		location.href="/course/video/"+c_c_id+"/"+video_id+".html";
	}
	
	//跳转登陆函数
	var userlogin = function(){
		var url = "/course/detail/"+c_c_id+".html";
		layer.msg('请先登录');
		localStorage.setItem("redirect", url);
		setTimeout(function(){
			window.location.href = "/login";
		}, 500)
	}


	
	//调用微信JS api 支付
	function jsApiCall()
	{
		var _token = '{{csrf_token()}}';
		var data = {class_id:c_c_id,_token:_token};
		$.ajax({
			url:'/course/buy',
			data:data,
			type:'POST',
			dateType:'json',
			success:function(res){

				if(res.code != 0){
					swal(res.message);
					return false;
				}else{
					var data = res.data;
				}
				WeixinJSBridge.invoke(
						'getBrandWCPayRequest',
						data,
						function(res){
							WeixinJSBridge.log(res.err_msg);

							if(res.err_msg=='get_brand_wcpay_request:ok'){
								layer.msg('支付成功');
								//follow_us();
								blacktle2();
							}else{
								alert(res.err_msg);	
							}
						}
				);
			}
		})

	}
	//关注公众号函数
	var follow_us = function(){
		layer.open({
			type: 1,
			title: false, //不显示标题栏
			skin: 'bm_success_layer_wrap', //样式类名
			id: 'bm_success_layer', //设定一个id，防止重复弹出
			closeBtn: 0, //不显示关闭按钮
			anim: 2,
			shadeClose: true, //开启遮罩关闭
			area: ['80%', '70%'],
			content:'<div class="bm_success_layer"><img src="/images/qr.png" class="bm_success" alt="" /><div class="text_center"><p>想要免费学习课程的小伙伴</p ><p>可以扫描下方的二维码</p ><p>进入微信公众号“赛普健身社区”</p ><p>后台回复：'+keyword+'</p ><p>获取免费听课资格</p ><p class="mt20">课程可以终身免费学习哦～</p ></div></div>',
			btn:false
		});
	}
$(function (){
	//折叠面板
	$('.toggleBox .item h3').click(function (){
		if($(this).next().hasClass('block')){
			return false;
		}else{
			$(this).next().addClass('block').parents('.item').siblings().find('ul').removeClass('block');
			$(this).find('i').addClass('up').parents('.item').siblings().find('i').removeClass('up');
		}
	})
	//不支持试看视频
	$(".no_preview").click(function(){
		$.closePopup()
			$.confirm({
				title: '提示',
				text: '立即购买学习该课程，确认购买吗？',
				onOK: function () {

					$('#studyBtn').trigger('click');
				},
				onCancel: function (){

				}
			});

	});
	//报名成功二维码弹出框
	$('.baomingBtn-').click(function(){
		layer.open({
			type: 1,
			title: false, //不显示标题栏
			skin: 'bm_success_layer_wrap', //样式类名
			id: 'bm_success_layer', //设定一个id，防止重复弹出
			closeBtn: 0, //不显示关闭按钮
			anim: 2,
			shadeClose: true, //开启遮罩关闭
			area: ['80%', '70%'],
			content:'<div class="bm_success_layer"><img src="/images/bm_success.png" class="bm_success" alt="" /><dl><dt><img src="/images/qr.png" alt="" /></dt><dd>扫描二维码获得课程提醒</dd></dl><a href="/course/video/'+c_c_id+'/'+video_id+'.html">关闭</a></div>',
			btn:false
		});
	})

	//立即付款弹出框
	$('.payBtn').click(function (){
		var payfrom = $("input[name='radio1']:checked").val();
		if(payfrom=='BANLANCE'){
			$.closePopup()
			$.confirm({
				title: '提示',
				text: '立即购买学习该课程，确认购买吗？',
				onOK: function () {
					//点击确认
					$.ajax({
						type:"GET",
						url:"/course/paybalance",
						data:{c_c_id:c_c_id, user_id:user_id},
						dataType:"json",
						success:function(result){
							if(result.code==1){
								layer.msg(result.msg);
								setTimeout(function(){
									window.location.href = "/course/video/"+c_c_id+"/"+video_id+".html";
									//follow_us();
								},1500)  //延迟1.5秒刷新页面
							}else{
								layer.msg(result.msg);
							}
			            }
					});
				},
				onCancel: function (){
				}
			});
		}else if(payfrom=="WXPAY"){
			if(is_weixin==1){
				jsApiCall();
//				layer.msg('微信浏览器');
			}else{
				$.ajax({
					type:"POST",
					url:"/course/payh",
					data:{course_class_id:c_c_id,_token:token},
					dataType:"json",
					success:function(result){
						if(result.code==1){
							console.log(result.objectxml.mweb_url);
							//follow_us();
							window.location.href=result.objectxml.mweb_url;   //h5呼叫微信支付
						}else{
							layer.msg(result.msg);
						}
		            }
				});
			}
		}
		
	})

	//收藏课程或取消收藏  20180827
	$("#wei_shoucang").click(function(){
		var id = $("#wei_shoucang").attr("data-attr");
		//var user_id = '{{$user_id}}';
		if(mobile<1){
			userlogin();  //跳转登陆
			return;
		}
		var is_collect = $("#wei_shoucang").attr("data-collect");
		if(id){
			if(is_collect==1){
				$.get("/course/nocollect",{course_class_id:id,user_id:user_id},function(result){
					if(result){
						//$("#wei_shoucang").removeAttr("data-attr");
						$("#wei_shoucang").attr("src", "/images/shoucang.png");
						$("#wei_shoucang").attr("data-collect", "0");
						layer.msg('已取消');
					}
				})
			}else{
				$.get("/course/collect",{course_class_id:id,user_id:user_id},function(result){
					if(result){
						//$("#wei_shoucang").removeAttr("data-attr");
						$("#wei_shoucang").attr("src", "/images/yishoucang.png");
						$("#wei_shoucang").attr("data-collect", "1");
						layer.msg('已收藏');
					}
				})
			}
		}
	});

	//免费报名课程
	$("#enroll").click(function(){
		var id = '{{$data->id}}';
		var user_id = '{{$user_id}}';
		$.get("/course/enroll",{course_class_id:id,user_id:user_id},function(result){
			if(result == 0){
				layer.msg('报名成功');

				setTimeout(function(){
					//$(".enroll_bb").text("进入课程");
					window.location.href = "/course/video/"+id+"/"+video_id+".html";
				},1500)  //延迟1.5秒
			}else{
				layer.msg('网络错误，稍后请重试');
			}
		})
	})
})
</script>

<script>
	//跳转到课程播放页面
	var go_video  = function (c_c_id, video_id){
		window.location.href="/course/video/"+c_c_id+"/"+video_id+".html";
	}
</script>
<script type="text/javascript" >
	function menuFixed(id){
		var obj = document.getElementById(id);
		var _getHeight = obj.offsetTop;

		window.onscroll = function(){
			changePos(id,_getHeight);
		}
	}
	function changePos(id,height){
		var obj = document.getElementById(id);
		var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
		if(scrollTop < height){
			obj.style.position = 'relative';
		}else{
			obj.style.position = 'fixed';
		}
	}
</script>
<script type="text/javascript">
	window.onload = function(){
		menuFixed('nav_keleyi_com');
	}
</script>

<script type="text/javascript">
	TouchSlide({ slideCell:"#leftTabBox",
		endFun:function(i){ //高度自适应
			var bd = document.getElementById("tabBox1-bd");
			bd.parentNode.style.height = bd.children[i].children[0].offsetHeight+"px";
			if(i>0)bd.parentNode.style.transition="200ms";//添加动画效果
		
		}
	});
</script>
</body>
</html>
