<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
<title>赛普社区-领取课程</title>
<meta name="author" content="涵涵" />
<meta name="keywords" content="" />
<meta name="description" content="" />
	<!-- Link Swiper's CSS -->
	<link rel="stylesheet" href="../css/swiper.min.css">
	<!--mmenu.css start-->
<link href="../lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
<link href="../lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
<link href="../css/nav-mmenu-public.css" rel="stylesheet" />
	<!--end-->

	<!--jqweui css-->
	<link href="../lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
	<link href="../lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
	<!--end -->

<link href="../css/reset.css" rel="stylesheet" type="text/css" />
<link href="../css/font-num40.css" rel="stylesheet" >


	<!--本css-->
	<style>
		.f66{font-size: 1.65rem;}
		.mr10{margin-right: .25rem;}
		.mt60{margin-top: 1.5rem;}
		.mb90{margin-bottom: 2.25rem;}
		.headDit ul{margin-left: 1.3rem;}
		.headDit h3,.headDit ul li{color: #FA6C11;}
		.plr45{padding-left: 1.125rem;padding-right: 1.125rem;}
		.bggr{background: rgba(253,208,0,0.10);}

		/*表单*/
		.form{}
		.input{width: 100%;}
		.input input{width: 100%;height: 2.175rem;line-height: 2.175rem;padding-left: .8rem;padding-right: .8rem;border:none}
		input::-webkit-input-placeholder {/*Chrome/Opera/Safari*/color: #d5d5d6;}
		input:-ms-input-placeholder{/*IE*/color:#d5d5d6;}
		input::-moz-placeholder{/*Firfox*/color: #d5d5d6}
		.form .btn{display: block;height:2.175rem;line-height: 2.175rem;width: 100%;}
		.form .btn{border: none}


		/*注册页面下输入验证码*/
		.yzm{width: 64% !important}
		.yzm-huoqu{width: 33% !important;height: 2.175rem;line-height: 2.175rem;}


		/*弹出 start*/
		.lingQ_layer_wrap {
			width: 13.75rem !important;
			height: 18.15rem !important;
			border-radius: 0.25rem !important;
		}

		.lingQ_layer_wrap .bm_success {
			display: block;
			width: 9rem;
			height: auto;
			margin: .5rem auto 0rem;
		}

	</style>


<script>
(function(){
	var html = document.documentElement;
	var hWidth = html.getBoundingClientRect().width;
	html.style.fontSize=hWidth/18.75+'px';
})()
</script>
</head>
<body ontouchstart>

<!---导航右侧带导航弹出---->
<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->

	<!--头部导航 start-->
	<div class="mh-head Sticky">

		<div class=" menu-bg-logo">
			<span class="mh-btns-left">
				<a class="icon-menu icon-sousuo" href="javascript:;"></a>
			</span>
			<span class="mh-btns-right">
				<a class="icon-menu" href="#menu"></a>
				<a class="icon-menu" href="#page"></a>
			</span>
		</div>
	</div>

	<!--隐藏导航内容-->
	<nav id="menu">
		<div class="text_center  fz">
			<ul>
				<li><a href="/">首页</a></li>
				<li><a href="/user/studying">正在学习</a></li>
				<li><a href="/user/index">我的</a></li>
			</ul>
		</div>
	</nav>
	<!--头部导航 end-->

	<!--====================================本喵是分割线  喵喵~========================================================-->
	<!--标题 start-->
	<div class="text_center mt60 pt40 mb40">
		<h1 class="color_333 f66 fz bold mb30">赛普健身社区</h1>
		<p class="f44 color_gray666 fz">免费送你一门精品课</p>
	</div>
	<!--标题 end-->

	<!--表单 start-->
	<div class="bggr mt32 border-radius-img mlr30 mb40">
		<div class="plr45">
			<!------------------------------------------------------------------------------>

			<div class="form fz f24 clearfix mb30  pt40">
				<div class="headDit">
					<h3 class="f38 fz bold mb40 pb10 mt32 pt40 text_center">《产后实战精英私教—精品课》</h3>
					<ul class="f28 fz mb40">
						<li class="pb30"><span class='mr10'>•</span>教你1分钟掌握腹直肌分离的评估方法</li>
						<li class="pb30"><span class='mr10'>•</span>掌握9个动作高效改善腹直肌分离</li>
						<li class="pb30"><span class='mr10'>•</span>了解成为一个优秀孕产教练的秘诀</li>
					</ul>
				</div>
				@if($status == 0)
					{{--<ul>--}}
						{{--<li>--}}
							{{--<div class="input">--}}
								{{--<input type="text" id="tel" name="shouji" placeholder="请输入您的手机号码" class="input border-radius-img f30  fz bgcolor_fff mb30" maxlength="11">--}}
							{{--</div>--}}
						{{--</li>--}}
						{{--<li>--}}
							{{--<div class="input clearfix">--}}
								{{--<input name="verifyCode" type="text" id="verifyCode" placeholder="请输入您的验证码" class="input border-radius-img f30  fz bgcolor_fff mb30 yzm fl">--}}
								{{--<span class="vcodeBtn yzm-huoqu fr bgcolor_orange border-radius-img text_center f28 color_333">获取验证码</span>--}}
							{{--</div>--}}
						{{--</li>--}}
					{{--</ul>--}}
				@endif


				<!--按钮-->
				@if($mobile !== "")
					<button  class="border-radius-img btn  color_333 f34 fz bgcolor_orange text_center mt60 mb90 @if($num > 0) btn_get @else lingQ @endif ">免费领课</button>
				@else
					<button  class="border-radius-img btn  color_333 f34 fz bgcolor_orange text_center mt60 mb90" @if($mobile == 0) onclick="userlogin()" @endif>免费领课</button>
				@endif
			</div>

			<!------------------------------------------------------------------------------>
		</div>

	</div>
	<!--表单 end-->
	<!--====================================本喵是分割线  喵喵~========================================================-->

</div><!--导航大盒子id=page 结束-->

<br><br>
<script src="../js/jquery-1.11.2.min.js"></script>
<script src="../lib/layer/layer.js"></script>
<script src="../js/js.js"></script>
<!--nav logo menu 导航条-->
<script src="../lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="../lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="../lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->
<script>

	//跳转登陆函数
	var userlogin = function(){
		var url = "/zt/getclass.html";
		localStorage.setItem("redirect", url);

		layer.msg('请先注册');
		setTimeout(function(){
			window.location.href = "/register";
		}, 500)
	}

	var token = '{{csrf_token()}}';
	$(function(){
		//发送验证码
		$('.vcodeBtn').click(function (){
			var tel = $('#tel').val();
			if(!tel || !/13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}$/.test(tel)){
				layer.msg('请输入有效的手机号码');
			}else{

				var mobile = tel;
				var flag=1;
				var data = {mobile:mobile,_token:token,flag:flag};
				$.ajax({
					url:'/zt/getVerifyCode',
					type:'POST',
					data:data,
					dataType:'json',
					success:function(res){
						console.log(res);
						if(res.code == 1){
							settime($('.vcodeBtn'),60);
							verify = res.verify;
							//alert(res.message);
							layer.msg(res.message);
						}else{
							layer.msg(res.message);
						}

					}
				});
			}
		})

		$(".btn_submit").click(function(){
			var tel = $('#tel').val();
			var verifyCode = $("#verifyCode").val();
			if(!tel || !/13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}$/.test(tel)){
				layer.msg('请输入有效的手机号码');
				return;
			}
			if(!verifyCode){
				layer.msg('请输入验证码');
				return;
			}
			var data = {mobile:tel,_token:token,verifyCode:verifyCode,status:0};
			$.ajax({
				url:'/zt/savedata',
				type:'POST',
				data:data,
				dataType:'json',
				success:function(res){
					console.log(res);
					if(res.code == 2){
						layer.open({
							type: 1,
							title: false, //不显示标题栏
							skin: 'lingQ_layer_wrap', //样式类名
							id: 'lingQ_layer', //设定一个id，防止重复弹出
							closeBtn: 0, //不显示关闭按钮
							anim: 2,
							shadeClose: true, //开启遮罩关闭
							area: ['80%', '70%'],
							content:'<div class="text_center"><div class="mt60 pt40"><p class="lt bold color_333 f38">领取成功</p><p class="fz color_gray666 f30 mt10">长按获取上课地址</p></div><img src="../images/zt/get_class.png" class="bm_success" alt="" /></div>',
							btn:false
						});
					}
					layer.msg(res.message);

				}
			});


		})
		//弹窗
		$('.lingQ').click(function(){
			data = {_token:token,status:1};
			$.ajax({
				url:'/zt/savedata',
				type:'POST',
				data:data,
				dataType:'json',
				success:function(res){
					console.log(res);
					if(res.code == 2){
						layer.open({
							type: 1,
							title: false, //不显示标题栏
							skin: 'lingQ_layer_wrap', //样式类名
							id: 'lingQ_layer', //设定一个id，防止重复弹出
							closeBtn: 0, //不显示关闭按钮
							anim: 2,
							shadeClose: true, //开启遮罩关闭
							area: ['80%', '70%'],
							content:'<div class="text_center"><div class="mt60 pt40"><p class="lt bold color_333 f38">领取成功</p><p class="fz color_gray666 f30 mt10">长按获取上课地址</p></div><img src="../images/zt/get_class.png" class="bm_success" alt="" /></div>',
							btn:false
						});
					}
					layer.msg(res.message);

				}
			});

		})
		$(".btn_get").click(function(){
			layer.open({
				type: 1,
				title: false, //不显示标题栏
				skin: 'lingQ_layer_wrap', //样式类名
				id: 'lingQ_layer', //设定一个id，防止重复弹出
				closeBtn: 0, //不显示关闭按钮
				anim: 2,
				shadeClose: true, //开启遮罩关闭
				area: ['80%', '70%'],
				content:'<div class="text_center"><div class="mt60 pt40"><p class="lt bold color_333 f38">领取成功</p><p class="fz color_gray666 f30 mt10">长按获取上课地址</p></div><img src="../images/zt/get_class.png" class="bm_success" alt="" /></div>',
				btn:false
			});
		})

	})

</script>


</body>
</html>
