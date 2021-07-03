@extends('layouts.header')
@section('title')
	<title>帮我助力获得孕产教练必备课程</title>
	<meta name="author" content="啾啾" />
	<meta name="keywords" content="" />
	<meta name="description" content="孕产教练必备课程理论片解决了越来越多妈妈的孕前、孕后身体状态的问题，已经是每一个教练必备的技能" />
@endsection

@section('cssjs')
	<script src="/js/jquery-1.11.2.min.js"></script>
	<script src="/js/jquery.SuperSlide.2.1.1.js" type="text/javascript"></script>

<script>
	var ua = navigator.userAgent.toLowerCase();
//	var isWeixin = ua.indexOf('micromessenger') != -1;
//	if (!isWeixin) {
//		window.location.href = "http://m.saipubbs.com/assistance/erweima.html"
//	}
</script>

<!--本css-->
<link rel="stylesheet" href="/css/zt/zt_assistance.css" >


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

<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->



	<!--====================================本喵是分割线  喵喵~========================================================-->

	<!--banner start-->
	<div class=" text_center">
		{{--<p class="f64 lt color_fff">邀请好友助力</p>--}}
		{{--<p class="f40 fz color_orange mt20"><i></i>免费领取课程<i></i></p>--}}
		<img src="/images/zt/assistance/huodong2-banner.png" alt="邀请好友助力"/>
	</div>
	<!--banner end-->

	<!--====================================本喵是分割线  喵喵~========================================================-->

	<!--第一期 视频 start-->
	<div class="bgcolor_gray plr20 ptb20">
		<div class="Modular-one bgcolor_fff pt70 border-radius-img">
			<p class="text_center one-qi border-radius50 f34 ptb13 bgcolor_orange mb50"><i>◆</i>第2期<i>◆</i></p>

			<!--sp start-->
			<div class="plr30 mb50">
				<div class="video border-radius-img">
					<div class="box2 ">
						<img src="/images/zt/assistance/huodong2-cover.png" alt="" class="thumb"/>
						<div class="mask"></div>
						<span class="btn_play"></span>
						<span class="look text_center fz f22">立即试听</span>
					</div>
					<video id="video" src="http://v.saipubbs.com/da413882171de530e3a5770d33237009.mp4" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto" ></video>
				</div>


				<h3 class="lt f32 color_333 mt32 mb22">孕产教练实践|腹直肌分离评估技巧及改善思路</h3>
				<div class="sub-font clearfix">
					<p class="fl f26 color_gray666 fz">共5节&nbsp;&nbsp;4128人已经参加</p>
					<span class="fr f34 color_red- lt d-in-black">￥89</span>
				</div>
			</div>
			<!--sp end-->

			<div class="bgcolor_f9f9f9 plr56 ptb65 list">

				<div class="bd">
					<ul class="f26 fz color_gray999">
						<li class="clearfix">
							<p class="fl text-overflow">ID 威尔士资深教练WINDAY... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID 健身爱好者葱葱921... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID ENERGY健身工作室创始人... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID 我要瘦下来61... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID 我要当健美冠军李然... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>

						<li class="clearfix">
							<p class="fl text-overflow">ID 星冠国际健身会所总经理... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID 我要完美腹肌dy... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID POWER 大型健身房教研总监... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID 一个抑郁的产后妈妈... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID 卡澜普拉提会馆创始人... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID被孩他爸嫌弃的胖女神... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID 蓝速尔大型瑜伽会馆创始人 ... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID 我要翘臀我要翘腿... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID 健身牛的不行私教教练... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID 看我超大的二头肌峰 ... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID 爱健身爱赛普RUBBY... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID 567资深健身总监... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID 10年健身的健身达人... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID 胸肌持续练习第三天... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID 爱健身会馆教练... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID 我也想开健身房99 ... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID 20年健身经验刘斌老师... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID 下界健美冠军是我王晓... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID 赛普健身高级健身教练... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
						<li class="clearfix">
							<p class="fl text-overflow">ID 即可运动高级健身教练... </p>
							<span class="fr text_right">成功领取课程</span>
						</li>
					</ul>
				</div>
			</div>
			<script type="text/javascript">
				jQuery(".list").slide({mainCell:".bd ul",autoPage:true,effect:"topLoop",autoPlay:true,vis:4,mouseOverStop:false});
			</script>

		</div>
	</div>
	<!--第一期 视频 end-->


	<!--====================================本喵是分割线  喵喵~========================================================-->

	<!--距离活动结束还有 start-->
	<div class="daojishi bg262626 color_fff">

		<h3 class="f44 lt text_center pt105 mb50">距离活动结束还有</h3>

		<div class="plr44">
			<!--倒计时 start-->
			<div class="mlr50 fff-opt border-radius50 ptb20 text_center conton">
				<p class="f26 fz"><span class="f40 lt color_orange" id="_d" >05</span>天</p>
				<p class="f26 fz"><span class="f40 lt color_orange" id="_h" >05</span>小时</p>
				<p class="f26 fz"><span class="f40 lt color_orange" id="_m" >05</span>分钟</p>
				<p class="f26 fz"><span class="f40 lt color_orange" id="_s" >05</span>秒</p>
			</div>
			<!--倒计时 end-->
			<!--助力 start-->
			<div class="bgcolor_fff border-radius-img text_center mt32">
				<?php
					$num = count($data);
					$studying = DB::table("studying")->where("user_id",$userid)->where("course_class_id",$class_id)->count();

				?>
				@if($num >3)
					<p class="fz f28 color_gray666 pt40 mt10 mb40">该团人数已齐</p>
				@else
					<p class="fz f28 color_gray666 pt40 mt10 mb40">还差{{4-$num}}人助力、即可免费领取课程</p>
				@endif


				<div class="plr56 portrait mb26 pb10">
					<ul class="clearfix">
						@if(isset($data[0]))
							@foreach($data as $v)
								<?php
								$avatar = DB::table("users")->where("id",$v->friend)->select("avatar")->first();
								$moren = "/images/zt/assistance/hui.png";

								?>
								<li class="fl"><img class="border-radius50" src="{{$avatar?$avatar->avatar:$moren}}" alt=""></li>
							@endforeach
							@for ($i = 0; $i < 4-$num; $i++)
								<li class="fl"></li>
							@endfor
						@endif

						{{--<li class="fl"><img class="border-radius50" src="/images/zt/assistance/hui.png" alt=""></li>--}}
						{{--<li class="fl"><img class="border-radius50" src="/images/zt/assistance/hui.png" alt=""></li>--}}
						{{--<li class="fr"><img class="border-radius50" src="/images/zt/assistance/hui.png" alt=""></li>--}}
					</ul>
				</div>
			</div>
			<!--助力 end-->
			<!--活动步骤 start-->
			<div class="fff-opt1 plr44 mt32 border-radius-img pb30">
				<p class="lt f30 pt30 mb26 ">活动步骤</p>
				<span class="d-in-black fz f26 text-jus mb50">01、点击页面底部【邀请好友助力】分享到朋友圈或者微信好友寻求好友助力。</span>
				<span class="d-in-black fz f26 text-jus">02、当助力完成后进入【赛普健身社区】公众号-菜单栏【进入社区】-【我的课表】即可免费收看课程</span>
			</div>
			<!--活动步骤 end-->

			<!--btn start-->
			<div class="btn f32 bold fz text_center color_333 mt70 pb136">

				@if($num<4)<!--助力人数是否够---->

					<a class="bgcolor_orange border-radius-img " id="share_count" data-attr = "{{$num}}" href="javascript:void (0)">免费认领
							<img class="in-black" src="/images/zt/assistance/click.png" alt="">
					</a>
				@else
					<?php
						//$is_guanzhu = DB::table("users")->where("id",$userid)->select("subscribe")->first();

					?>
					@if($subscribe == 1)	<!--是否关注公众号--->
						@if($studying == 1)			<!--是否领到课程---->
							<a class="bgcolor_orange border-radius-img is_get" data-attr = "1" href="javascript:void (0)">免费认领
								<img class="in-black" src="/images/zt/assistance/click.png" alt="">
							</a>
						@else
							<a class="bgcolor_orange border-radius-img is_get" data-attr = "0" href="javascript:void (0)">免费认领
								<img class="in-black" src="/images/zt/assistance/click.png" alt="">
							</a>
						@endif
					@else
							<a class="bgcolor_orange border-radius-img kwg" href="javascript:void (0)">免费认领
								<img class="in-black " src="/images/zt/assistance/click.png" alt="">
							</a>

					@endif
				@endif
			</div>
			<!--btn end-->
		</div>

	</div>
	<!--距离活动结束还有 end-->

	<!--====================================本喵是分割线  喵喵~========================================================-->


	<!--选项卡 start-->
	<div>

		<!-- 本例主要代码 Start ================================ -->
		<div id="leftTabBox" class="tabBox">
			<div class="hd fz mb30">
				<ul>
					<li><a href="javascript:void 0;">课程简介</a></li>
					<li><a href="javascript:void 0;">课程目录</a></li>
				</ul>
			</div>
			<div class="bd" id="tabBox1-bd">
				<div class="con">
					<div class="plr30 mb40 jianjie">
						{{--<h2 class="lt f40 color_333">健身私教基础知识入门</h2>--}}
						{{--<p class="fz f22 color_gray9b mt10">300人加入学习</p>--}}
						{{--<p class="fz f30 color_gray666 text-jus text-intent3 mt32">--}}
							{{--孕产教练必备的线上课程！如何帮助产后妈妈抓住恢复期，快速瘦下来？产后恢复的黄金恢复期是什么？顺产、剖腹产如何饮食和训练？在这里，你将得到市场上最全的孕产教练攻略，赶快加入吧~</p>--}}
						{{--<br>--}}
						<img src="/images/zt/assistance/huodong2-course.png"/>
					</div>

				</div>
				<div class="con">
					<ul class="ul1 plr30 fz f28 mt20">
						<li class="mb26 ml20"><a href="javascript:void 0;"  class="color_orange"><span class="pr20">01</span>腹直肌分离评估技巧</a></li>
						<li class="mb26 ml20"><a href="javascript:void 0;"><span class="pr20">02</span>腹直肌分离改善思路</a></li>
						<li class="mb26 ml20"><a href="javascript:void 0;"><span class="pr20">03</span>腹直肌分离改善——呼吸</a></li>
						<li class="mb26 ml20"><a href="javascript:void 0;"><span class="pr20">04</span>腹直肌分离改善——躯干稳定四肢灵活类</a></li>
						<li class="mb26 ml20"><a href="javascript:void 0;"><span class="pr20">05</span>腹直肌分离改善——脊柱屈曲类</a></li>
						<br>
					</ul>

				</div>
			</div>
		</div>

		<script src="/js/TouchSlide.1.1.js"></script>
		<script type="text/javascript">TouchSlide({ slideCell:"#leftTabBox",

			endFun:function(i){ //高度自适应
				var bd = document.getElementById("tabBox1-bd");
				bd.parentNode.style.height = bd.children[i].children[0].offsetHeight+"px";
				if(i>0)bd.parentNode.style.transition="200ms";//添加动画效果
			}
		});
			var html = document.documentElement;
				var hWidth = html.getBoundingClientRect().width;
				var img_url = $('.jianjie img').attr('src')+'?'+Date.parse(new Date());
				console.log(img_url)
				// 创建对象
				var img = new Image();
				// 改变图片的src
				img.src = img_url;
				// 加载完成执行
				img.onload = function(){
					var h1=Math.ceil(hWidth/(img.width/img.height));
					$('.tabBox .tempWrap').height(h1)
				}
		</script>
		<!-- 本例主要代码 End ================================ -->

	</div>
	<!--选项卡 end-->
	<!--====================================本喵是分割线  喵喵~========================================================-->

	<!--我是灰色的线-->
	<div class="solidtop20"></div>


	<!--====================================本喵是分割线  喵喵~========================================================-->

@if($userid !== 0)
		<?php
			$mobile = DB::table("users")->where("id",$userid)->select("mobile")->first();

		?>
@if(empty($mobile->mobile))
	<!--表单 start-->
<form method = "post" action="/user/register" id="regForm">
	<div class="bgcolor_f9f9f9 mt30 border-radius-img mlr30 mb40">

		<div class="pt60 plr45 pb136">
			<h2 class="lt f52 color_333 text_center pt105 mt32">注册赛普健身社区</h2>
			<p class="fz f36 color_333 mt16 text_center">参加该活动</p>

			<div class="form fz f24 clearfix mb30  pt105">
				<ul>
					<li>
						<div class="input">
							<input type="text" id="tel" placeholder="请输入您的手机号码" class="input border-radius-img f30  fz bgcolor_fff mb30">
							<div class="tip mobile_error"></div>
						</div>
					</li>
					<li>
						<div class="input clearfix">
							<input type="text" id="code" placeholder="请输入您的验证码" class="input border-radius-img f30  fz bgcolor_fff mb30 yzm fl">
							<span class="vcodeBtn yzm-huoqu fr bgcolor_orange border-radius-img text_center f28 color_333">获取验证码</span>
						</div>
						<div class="tip code_error"></div>
					</li>

					<li>
						<div class="input">
							<input type="text" id="password" placeholder="请输入6-12位密码" class="input border-radius-img f30  fz bgcolor_fff mb30">
							<div class="tip passwd_error"></div>
						</div>
					</li>
				</ul>

				<!--按钮-->
				<button onclick="userRegister();" type="button" class="border-radius-img btn  color_333 f34 fz bgcolor_orange text_center  mt30">确认
				</button>
			</div>

		</div>

		<img src="/images/share/img-b.png" alt="">
	</div>
</form>
	@endif
@endif
		<br/><br/><br/><br/>
	<!--表单 end-->

	<!--====================================本喵是分割线  喵喵~========================================================-->
@if(empty($mobile->mobile))

	<div class="footer-x footer-x2 fz bold f32 color_333 text_center bgcolor_orange ">
		<ul class="clearfix">
				<li class="nav"><a class="d-in-black" href="javascript:void (0)">邀请好友助力（生成邀请海报）</a></li>
		</ul>
	</div>
<script>
	$('.nav').on('click',function(e){

		$('html,body').animate({scrollTop:$('#'+'regForm').offset().top}, 500);
	});

</script>


@else
		<!--悬浮按钮 start-->
	<div class="footer-x footer-x2 fz bold f32 color_333 text_center bgcolor_orange ">
		<ul class="clearfix">

			@if($userid == 0)
				<li class=""  onclick="userlogin()"><a class="d-in-black" href="javascript:void (0)">邀请好友助力（生成邀请海报）</a></li>
			@else
				<li class=""><a class="d-in-black" href="/wechat/shareArticle/39?aid=3&&userid={{$userid}}">邀请好友助力（生成邀请海报）</a></li>
			@endif
		</ul>
	</div>
	<!--悬浮按钮 end-->
@endif



</div><!--导航大盒子id=page 结束-->



<br><br>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
	//播放视频
	$(function (){
		//播放视频
		$('.video .box2').click(function(){
			$(this).hide();
			$(this).next().trigger('play');

		})
	})

</script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->

<script type="text/javascript">


	$("#share_count").click(function(){
		var count = $(this).attr("data-attr");
		var left = 4 - count;
		layer.msg("亲，还差"+left+"人助力，快去邀请好友吧");
	})
	$(".is_get").click(function() {
		var status = $(this).attr("data-attr");
		if (status == 0){
			var token = '{{csrf_token()}}';
			var userid = '{{$userid}}';
			var data = {userid: userid, _token: token};
			$.ajax({
				url: '/assistance/is_zutuan',
				type: 'POST',
				data: data,
				dataType: 'json',
				success: function (data) {
					$(".is_get").attr("data-attr",1);
					layer.msg("恭喜您已领到课程。");
					window.location.href = "/course/detail/39.html";

				}
			});
		}else{
			//layer.msg("您已领到课程，请在正在学习栏查看。");
			window.location.href = "/course/detail/39.html";
		}
	})



	function countTime() {
		//获取当前时间
		var date = new Date();
		var now = date.getTime();
		//设置截止时间
		var endDate = new Date("2019/1/7");
		var end = endDate.getTime();
		//时间差
		var leftTime = end-now;
		//定义变量 d,h,m,s保存倒计时的时间
		var d,h,m,s;
		if (leftTime>=0) {
			d = Math.floor(leftTime/1000/60/60/24);
			h = Math.floor(leftTime/1000/60/60%24);
			m = Math.floor(leftTime/1000/60%60);
			s = Math.floor(leftTime/1000%60);
		}
		//将倒计时赋值到div中
		document.getElementById("_d").innerHTML = d;/*+"天"*/
		document.getElementById("_h").innerHTML = h;/*+"时"*/
		document.getElementById("_m").innerHTML = m;/*+"分"*/
		document.getElementById("_s").innerHTML = s;/*+"秒"*/
		//递归每秒调用countTime方法，显示动态时间效果
		setTimeout(countTime,1000);

	}
	countTime();

</script>
<script>

	//跳转登陆函数
	var userlogin = function(){
		var userid = "{{$userid}}";
		var url = "/assistance/friend.html";
		localStorage.setItem("redirect", url);

		layer.msg('请先注册');
		setTimeout(function(){
			window.location.href = "/register";
		}, 500)
	}

	function userRegister(){

		var mobile = $("#tel").val();
		var token = '{{csrf_token()}}';
		var code = $('#code').val();
		var password = $('#password').val();

		if(!mobile || !/13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|16[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}$/.test(mobile)){
			$(".mobile_error").text('请输入有效的手机号码');
			return false;
		}else{
			$(".mobile_error").text('');
		}
		if(!code){
			$(".code_error").text('请输入正确的验证码');
			return;
		}else{
			$(".code_error").text('');
		}
		if(password.length < 6 || password.length > 20){
			$(".passwd_error").text('密码必须在6-20位字符之间');
			return;
		}else{
			$(".passwd_error").text('');
		}
		var fission_id = localStorage.getItem('fission_id');
		var share_id = '';
		if(fission_id != '' || fission_id != null){
			var share_id = fission_id;
		}
		var channel = localStorage.getItem('channel');
		if(channel == '' || channel == null){
			var channel = '';
		}

		var op = $("input[name='openid']").val();
		var data = {mobile:mobile,verifyCode:code,password:password,_token:token,op:op,share_id:share_id,channel:channel};
		$.ajax({
			url:'/user/register',
			type:'POST',
			data:data,
			dataType:'json',
			success:function(data){

				if(data.code == 0){
					layer.msg("注册成功");
					gio('track', 'register');   //growing  统计代码注册数加1
					window.location.reload();
				}else if(data.code == 1){
					$(".code_error").text(data.message);
				}else if(data.code == 2){
					$(".mobile_error").text(data.message);
				}else if(data.code == 3){
					$(".passwd_error").text(data.message);
				}else if(data.code == 4){
					$(".mobile_error").text(data.message);
				}else if(data.code == 5){
					$(".mobile_error").text(data.message);
				}

			}
		});
	}

	$(function(){
		//发送验证码
		$('.vcodeBtn').click(function (){
			var tel = $('#tel').val();
			if(!tel || !/13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}|16[0-9]{9}$/.test(tel)){
				layer.msg('请输入有效的手机号码');
			}else{
				var token = '{{csrf_token()}}';
				var mobile = $("#tel").val();
				var data = {mobile:mobile,_token:token};
				$.ajax({
					url:'/send/code',
					type:'POST',
					data:data,
					dataType:'json',
					success:function(res){
						if(res.code == 1){
							settime($('.vcodeBtn'),60);
							layer.msg(res.message);
						}else{
							layer.msg(res.message);
						}

					}
				});
			}
		})

		//单选按钮
		$('.radio').iCheck({
			//checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio',
			increaseArea: '20%'
		});

	})
</script>


<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>

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
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
				wx.onMenuShareAppMessage({
					title: '帮我助力获得孕产教练必备课程', // 分享标题
					desc: '孕产教练必备课程理论片解决了越来越多妈妈的孕前、孕后身体状态的问题，已经是每一个教练必备的技能', // 分享描述
					link: "http://m.saipubbs.com/assistance/index/{{$userid}}.html?fission_id={{$userid}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
					imgUrl: "http://m.saipubbs.com/images/zt/assistance/huodong2-banner.png", // 分享图标
				}, function(res) {
					//这里是回调函数
				});
			});
	wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
		wx.onMenuShareTimeline({
			title: '帮我助力获得孕产教练必备课程', // 分享标题
			link: "http://m.saipubbs.com/assistance/index/{{$userid}}.html?fission_id={{$userid}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
			imgUrl: "http://m.saipubbs.com/images/zt/assistance/huodong2-banner.png", // 分享图标
		}, function(res) {
			//这里是回调函数
		});
	});

		//弹窗
		$('.kwg').click(function(){
			layer.open({
				type: 1,
				title: false, //不显示标题栏
				skin: 'bm_success_layer_wrap2', //样式类名
				id: 'bm_success_layer2', //设定一个id，防止重复弹出
				closeBtn: 1, //不显示关闭按钮
				anim: 2,
				shadeClose: true, //开启遮罩关闭
				area: ['80%', '90%'],
				content:'<div class="bm_success_layer text_center tan-font"><img src="/images/zt/assistance.jpg" class="bm_success" alt="" /></div>',
				btn:false
			});
		})

</script>
@endsection
