<!---导航右侧带导航弹出---->
@extends('layouts.header')
@section('title')
    <title>2018年终锦鲤免费预定注册私教{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link href="/css/my.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/css/zt/zt_xianshifuli.css">
    <style>
    	#page {padding-bottom:3rem;}
    </style>
@endsection
@section('content')	
<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->

	<!--头部导航 start-->

	<div class="mlr20 mt26"><!--边距30 开始-->


		<!--banner start-->
		<div>
			<img src="../images/zt/xianshifuli/ban1.jpg" alt="">
			<img src="../images/zt/xianshifuli/ban2.jpg" alt="">
			<img src="../images/zt/xianshifuli/ban3.jpg" alt="">
			<img src="../images/zt/xianshifuli/ban-xian.jpg" alt="">
		</div>
		<!--banner end-->



		<!--视频 1 start-->
		<div class="shipin-one text_center">
			<h2 class="color_orange f32 mb40">赛普健身教练培训基地能给你带来什么？</h2>

			<!--shipin start-->
			<div class="video-wrap">
				<div class="con">
					<div class="video">
						<div class="box2">
							<img src="../images/zt/xianshifuli/shipingimg1.jpg" alt="" />
							<!--<div class="mask"></div>-->
							<!--<span class="btn_play"></span>-->
						</div>
						<video src="http://v.saipubbs.com/guangwang/赛普健身宣传片1120.mp4" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto"></video>
					</div>

				</div>
			</div>
			<!--shipin end-->

		</div>
		<img src="../images/zt/xianshifuli/spxiang.jpg" alt="">
		<!--视频 2 start-->

		<!--=========================本喵是分割线===============================================================-->

		<!--倒计时 start-->
		<div>
			<img src="../images/zt/xianshifuli/time-title.jpg" alt="">

			<div class="daojishi_wrap">
				<div class="inner">
					<div class="con">
						<div class="wrap">
							<!--倒计时开始-->
							<div class="ft_counter cleafix">
							</div>
							<!-- 倒计时结束 -->
						</div>
						<div class="txt f26 bold">
							<p class="text-jus">12月30日前邀请好友预定-赛普私教培训课程，邀请人数最多的前10名、免学费上价值25000元高级私教课程（3个月）。</p>
							<div class="mb63">
								<a href="/zt/rsort.html" class="color_red">点击查看邀请排行榜</a>
							</div>
							<p class="text-jus">价值3000元的线上【私教课程】，现在预定即可免费获得。课程详情请看下文。</p>
							<div class="color_red">
								（活动后即刻恢复原价）
							</div>
							<img src="../images/zt/xianshifuli/djs_lian.png" class="lian lian1" alt="链" />
							<img src="../images/zt/xianshifuli/djs_lian.png" class="lian lian2" alt="链" />
						</div>
					</div>
				</div>

			</div>

			<img src="../images/zt/xianshifuli/timexian.jpg" alt="">
		</div>
		<!--倒计时 end-->

		<!--=========================本喵是分割线===============================================================-->


		<!--课程 start-->
		<div>
			<h2 class="color_orange f44 ke-tit text_center">2019年赛普重磅<br>推出线上【私教课堂】</h2>

			<div class="bg-ketit">
				<p class="f36 bgcolor_orange color_000">先试听一下课程<img src="../images/zt/xianshifuli/icon-houzi.jpg" alt=""></p>
			</div>

			<div class="bg-ter color_fff">
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-he.jpg" alt=""></dt>
					<dd class="fl pt10">
						<h3 class="f32">运动训练基础解剖</h3>
						<p class="f26">4节课&nbsp;&nbsp;&nbsp;课程导师：何翔宇</p>
					</dd>
				</dl>
			</div>


			<!--第一节-->
			<img src="../images/zt/xianshifuli/1jie-sp.jpg" alt="">
			<div class="color_fff text_center one-jie pb30">
				<p class="f32 mb40">第1节试听-学习解剖的意义</p>

				<!--shipin start-->
				<div class="video-wrap pb30">
					<div class="con">
						<div class="video">
							<div class="box2">
								<img src="../images/zt/xianshifuli/shipingimg2.jpg" alt="" />
								<!--<div class="mask"></div>-->
								<!--<span class="btn_play"></span>-->
							</div>
							<video src="http://v.saipubbs.com/%E4%BD%95%E7%BF%94%E5%AE%87/1-1-1%E5%9F%BA%E7%A1%80%E8%A7%A3%E5%89%96%E8%AF%AD%E8%A8%80%EF%BC%9A%E5%AD%A6%E4%B9%A0%E8%A7%A3%E5%89%96%E7%9A%84%E6%84%8F%E4%B9%89.mp4" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto"></video>
						</div>

					</div>
				</div>
				<!--shipin end-->

			</div>

			<!--第二节-->
			<img src="../images/zt/xianshifuli/2jie-sp.jpg" alt="">
			<div class="color_fff text_center two-jie pb30">
				<p class="f32 mb40">第2节试听-三个运动解剖平面</p>

				<!--shipin start-->
				<div class="video-wrap pb30 ">
					<div class="con">
						<div class="video">
							<div class="box2">
								<img src="../images/zt/xianshifuli/shipingimg3.jpg" alt="" />
								<!--<div class="mask"></div>-->
								<!--<span class="btn_play"></span>-->
							</div>
							<video src="http://v.saipubbs.com/%E4%BD%95%E7%BF%94%E5%AE%87/1-1-2%E5%9F%BA%E7%A1%80%E8%A7%A3%E5%89%96%E8%AF%AD%E8%A8%80%EF%BC%9A%E4%B8%89%E4%B8%AA%E8%BF%90%E5%8A%A8%E8%A7%A3%E5%89%96%E5%B9%B3%E9%9D%A2.mp4" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto"></video>
						</div>

					</div>
				</div>
				<!--shipin end-->

			</div>
			<img src="../images/zt/xianshifuli/ke-xian.jpg" alt="">

		</div>

		<!--课程 end-->


		<!--=========================本喵是分割线===============================================================-->

		<!--课表 start-->
		<div class="kebiao">
			<h4 class="f44 color_orange text_center">2019【私教课堂】完整课表</h4>

			<!--何翔宇-->
			<div class="bg-ter bg-list-ter color_fff relative">
				<span class="f24 color_000 bgcolor_orange">4节课</span>
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-he.jpg" alt=""></dt>
					<dd class="fl">
						<h3 class="f32">运动训练基础解剖</h3>
						<p class="f26">课程导师：何翔宇</p>
					</dd>
				</dl>
			</div>
			<img src="../images/zt/xianshifuli/bgtea-hexiangyu-b.jpg" alt="">

			<!--陶顺吉-->
			<div class="bg-ter bg-list-ter bg-list-ter-taoshunji color_fff relative">
				<span class="f24 color_000 bgcolor_orange">4节课</span>
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-taoshunji.jpg" alt=""></dt>
					<dd class="fl nobo">
						<h3 class="f32">健身教练必备基础<br>知识入门</h3>
						<p class="f26">课程导师：陶顺吉</p>
					</dd>
				</dl>
			</div>
			<img src="../images/zt/xianshifuli/bgtea-taoshunji-b.jpg" alt="">

			<!--徐乐-->
			<div class="bg-ter bg-list-ter bg-list-ter-xule color_fff relative">
				<span class="f24 color_000 bgcolor_orange">4节课</span>
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-xule.jpg" alt=""></dt>
					<dd class="fl nobo">
						<h3 class="f32">【运动解剖】看这一<br>套就够了</h3>
						<p class="f26">课程导师：徐乐</p>
					</dd>
				</dl>
			</div>
			<img src="../images/zt/xianshifuli/bgtea-xule-b.jpg" alt="">

			<!--解鹏-->
			<div class="bg-ter bg-list-ter bg-list-ter-xiepeng color_fff relative">
				<span class="f24 color_000 bgcolor_orange">4节课</span>
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-xiepeng.jpg" alt=""></dt>
					<dd class="fl nobo">
						<h3 class="f32">【运动营养】减脂的<br>你吃对了吗？</h3>
						<p class="f26">课程导师：解鹏</p>
					</dd>
				</dl>
			</div>
			<img src="../images/zt/xianshifuli/bgtea-xiepeng-b.jpg" alt="">

			<!--何翔宇-->
			<div class="bg-ter bg-list-ter bg-list-ter-he2 color_fff relative">
				<span class="f24 color_000 bgcolor_orange">4节课</span>
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-he.jpg" alt=""></dt>
					<dd class="fl nobo">
						<h3 class="f32">如何进行抗阻力训练<br>的动作设计</h3>
						<p class="f26">课程导师：何翔宇</p>
					</dd>
				</dl>
			</div>
			<img src="../images/zt/xianshifuli/bgtea-hexiangyu-b2.jpg" alt="">

			<!--何翔宇-->
			<div class="bg-ter bg-list-ter bg-list-ter-he3 color_fff relative">
				<span class="f24 color_000 bgcolor_orange">4节课</span>
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-he.jpg" alt=""></dt>
					<dd class="fl">
						<h3 class="f32">胸部解剖与训练技术</h3>
						<p class="f26">课程导师：何翔宇</p>
					</dd>
				</dl>
			</div>
			<img src="../images/zt/xianshifuli/bgtea-hexiangyu-b3.jpg" alt="">

			<!--何翔宇-->
			<div class="bg-ter bg-list-ter bg-list-ter-he4 color_fff relative">
				<span class="f24 color_000 bgcolor_orange">4节课</span>
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-he.jpg" alt=""></dt>
					<dd class="fl">
						<h3 class="f32">肩部解剖与训练技术</h3>
						<p class="f26">课程导师：何翔宇</p>
					</dd>
				</dl>
			</div>
			<img src="../images/zt/xianshifuli/bgtea-hexiangyu-b4.jpg" alt="">

			<!--何翔宇-->
			<div class="bg-ter bg-list-ter bg-list-ter-he5 color_fff relative">
				<span class="f24 color_000 bgcolor_orange">4节课</span>
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-he.jpg" alt=""></dt>
					<dd class="fl">
						<h3 class="f32">背部解剖与训练技术</h3>
						<p class="f26">课程导师：何翔宇</p>
					</dd>
				</dl>
			</div>
			<img src="../images/zt/xianshifuli/bgtea-hexiangyu-b5.jpg" alt="">

			<!--何翔宇-->
			<div class="bg-ter bg-list-ter bg-list-ter-he6 color_fff relative">
				<span class="f24 color_000 bgcolor_orange">4节课</span>
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-he.jpg" alt=""></dt>
					<dd class="fl">
						<h3 class="f32">腿部解剖与训练技术</h3>
						<p class="f26">课程导师：何翔宇</p>
					</dd>
				</dl>
			</div>
			<img src="../images/zt/xianshifuli/bgtea-hexiangyu-b6.jpg" alt="">

			<!--何翔宇-->
			<div class="bg-ter bg-list-ter bg-list-ter-he7 color_fff relative">
				<span class="f24 color_000 bgcolor_orange">4节课</span>
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-he.jpg" alt=""></dt>
					<dd class="fl">
						<h3 class="f32">腹部解剖与训练技术</h3>
						<p class="f26">课程导师：何翔宇</p>
					</dd>
				</dl>
			</div>
			<img src="../images/zt/xianshifuli/bgtea-hexiangyu-b7.jpg" alt="">

		</div>
		<!--课表 end-->

		<!--=========================本喵是分割线===============================================================-->

		<!--适合的人群 start-->
		<div class="bg-shihe">
			<h3 class="f40 color_orange text_center"><i></i>该活动适合人群<i></i></h3>

			<div class="plr30 mlr30">
				<h2 class="color_orange f30 mb26">01、0基础职业转行</h2>
				<p class="color_fff mb63 f30 text-jus">如果你想0基础转行做教练，如何快速学习必备技能，拿到证书，一步到位转行上岗。</p>

				<h2 class="color_orange f30 mb26">02、健身爱好者</h2>
				<p class="color_fff mb63 f30 text-jus">如果你热爱健身，渴望将爱好变成职业，如何从自己练转变成带人练。</p>

				<h2 class="color_orange f30 mb26">03、退伍军人</h2>
				<p class="color_fff mb63 f30 text-jus">如果你想退伍后免去求职烦恼，如何掌握技能，通过全国就业网络获取高薪工作。</p>

				<h2 class="color_orange f30 mb26">04、体校生、大学生</h2>
				<p class="color_fff mb63 f30 text-jus">如果你厌倦平庸，如何轻松打造时尚教练职业的成功捷径。</p>
			</div>
		</div>
		<img src="../images/zt/xianshifuli/shihe-xian.jpg" alt="">
		<!--适合的人群 end-->

		<!--=========================本喵是分割线===============================================================-->

		<!--购买需知 start-->
		<div class="bg-shihe bg-xuzhi">
			<h3 class="f40 color_orange text_center"><i></i>购买需知<i></i></h3>

			<div class="plr30 mlr30">
				<p class="color_fff mb63 f28 text-jus">为了用户资金安全，点击【500元立即预定】，弹出登录框、登录框密码为-注册社区手机号后6位，填写正确方可预定成功。</p>
				<p class="color_fff mb63 f28 text-jus">预定成功后会有你的专属咨询师与你取得联系、有任何预定问题都可以咨询你的专属咨询师。<br>	预定成功之后获得高级私教课程5000元学费优惠。</p>
				<p class="color_fff mb63 f28 text-jus">线上【私教课堂】为视频课程、供计9套课程，预定成功后，可以不限次数反复学习、永久有效。</p>
				<p class="color_fff mb63 f28 text-jus">本课程限时预定免费送、截止时间12月31日，之后恢复原价3000元。</p>
				<p class="color_fff mb63 f28 text-jus">该课程目前仅上线4套、我们会在2019年初陆续上线。</p>
				<p class="color_orange mb63 f28 text-jus">本活动所有解释权归赛普健身教练培训基地所有</p>
			</div>
		</div>
		<img src="../images/zt/xianshifuli/xuzhi-xian.jpg" alt="">
		<!--购买需知 end-->

		<!--=========================本喵是分割线===============================================================-->

		<!--如何学习 start-->
		<div class="bg-shihe bg-xuexi">
			<h3 class="f40 color_orange text_center"><i></i>如何学习<i></i></h3>

			<div class="plr30 mlr30">
				<p class="color_fff mb63 f28 text-jus">点击立即预定缴纳预定金、大概1个小时内系统审核通过、就可通过点击进入课堂查看课程。</p>
				<p class="color_fff mb63 f28 text-jus">后续反复学习可以通过（赛普健身社区-我的课表）目录下找到该课程进入学习。</p>
				<!--<p class="color_orange mb63 f28">有任何问题：添加客服老师微信saipujianshen,为您进行贴心解答。</p>-->
			</div>
		</div>
		<!--如何学习 end-->

		<!--=========================本喵是分割线===============================================================-->

		<!--btn start-->
		<div class="btn-bg text_center">
			@if($mobile==0)
				<a class="bgcolor_orange f32 color_000 border-radius-img" onclick="userlogin()" href="javascript:void (0)">我已预定成功</a>
			@else
				<a class="bgcolor_orange f32 color_000 border-radius-img reserve" href="javascript:void (0)">我已预定成功</a>
			@endif
			
			<a class="bgcolor_orange f32 color_000 border-radius-img mt32" href="/zt/rsort.html">查看预定邀请排行榜</a>
		</div>
		<!--btn end-->

	</div><!--边距30 结束-->
	
	<div class="footer_fuli text_center">
		<ul class="clearfix color_000 bgcolor_orange f32">
			<li class="fl">
				@if($mobile==0)
					<a href="javascript:void (0)" onclick="userlogin()">500元立即预定</a>
				@else
					<a href="http://jfpt.saipujiaoyu.com/MNetWorkUI/">500元立即预定</a>
				@endif
			</li>
			<li class="fl"><a href="/wechat/share/37.html">分享给好友</a></li>
			<li class="fr wzixun"><a href="javascript:void (0)">微信咨询</a></li>
		</ul>
	</div>

</div><!--导航大盒子id=page 结束-->
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
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: '2018年终锦鲤免费预定注册私教', // 分享标题
            desc: '2018年终锦鲤免费预定注册私教', // 分享描述
            link: "http://m.saipubbs.com/zt/yearinfo.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/tubiao/1.png", // 分享图标
        }, function(res) {
        //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '2018年终锦鲤免费预定注册私教', // 分享标题
            link: "http://m.saipubbs.com/zt/yearinfo.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/tubiao/1.png", // 分享图标
        }, function(res) {
        //这里是回调函数
        });
    });
</script>
{{--<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>--}}
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
	localStorage.setItem("fission_id", "{{$fission_id}}");
	//播放视频
	$(function (){
		//播放视频
		$('.con .video .box2').click(function(){
			$(this).hide();
			/*//首页下点击图片播放的id  //教师下点击图片播放的id
			 document.getElementById('video').play();*/
			$(this).next().trigger('play');
		})
	})

	//跳转登陆函数
	var userlogin = function(){
		var url = "/zt/yearinfo.html";
		localStorage.setItem("redirect", url);

		layer.msg('请先注册');
		setTimeout(function(){
			window.location.href = "/register";
		}, 500)
	}


	//点击其中一个播放时，其他的停止播放
	// 获取所有video
	var videoclose = document.getElementsByTagName("video");
	// 暂停函数
	function pauseAll() {
		var self = this;
		[].forEach.call(videoclose, function (i) {
			// 将video中其他的video全部暂停
			i !== self && i.pause();
		})
	}
	// 给play事件绑定暂停函数
	[].forEach.call(videoclose, function (i) {
		i.addEventListener("play", pauseAll.bind(i));
	})



	/**/
  $(function() {
    FastClick.attach(document.body);
  });
</script>

<script>
	$(function (){
		//微信咨询弹窗
		$('.wzixun').click(function(){
			layer.open({
				type: 1,
				title: false, //不显示标题栏
				skin: 'bm_success_layer_wrap', //样式类名
				id: 'bm_success_layer', //设定一个id，防止重复弹出
				closeBtn: 0, //不显示关闭按钮
				anim: 2,
				shadeClose: true, //开启遮罩关闭
				area: ['80%', '70%'],
				content:'<div class="bm_success_layer text_center "><div class="mt30 pt30"><p class="lt bold color_333 f30">识别二维码</p><p class="fz color_gray666 f24 mt10">关注赛普健身社区公众号</p></div><img src="../images/qr.png" class="bm_success" alt="" /><div><p class="lt bold color_333 f30 mt10">更新实时提醒</p><p class="fz color_gray666 f24 mt20">不错过每一次的精彩</p></div></div>',
				btn:false
			});
		})

		var mobile = "{{$mobile}}";
		var content = "";
		if(mobile==0){
			content = '<div class="mykebiao_layer text-jus"><div class="container"><h3 class="pt40 mb40 f36 text_center">提示</h3><p class="pt30 f32">很遗憾！您还没有预定赛普私教课程，快去预定吧</p><div class="btnWrap pt30 pb30"><a href="javascript:;" onclick="userlogin()" class="btn f34">马上预定</a></div></div></div>';
		}else{
			content = '<div class="mykebiao_layer text-jus"><div class="container"><h3 class="pt40 mb40 f36 text_center">提示</h3><p class="pt30 f32">很遗憾！您还没有预定赛普私教课程，快去预定吧</p><div class="btnWrap pt30 pb30"><a href="http://jfpt.saipujiaoyu.com/MNetWorkUI/"class="btn f34">马上预定</a></div></div></div>';
		}


		//未预定
		$('.no-reserve').click(function(){
			layer.open({
				type: 1,
				title: false, //不显示标题栏
				skin: 'mykebiao_layer_wrap', //样式类名
				id: 'mykebiao_layer', //设定一个id，防止重复弹出
				closeBtn: 0, //不显示关闭按钮
				anim: 2,
				shadeClose: true, //开启遮罩关闭
				area: ['80%', '60%'],
				content:content,
				btn:false
			});
		})

		//成功预定
		$('.reserve').click(function(){
			var phone = '{{$mobile}}';
			var data = {phone:phone};

			$.ajax({
				url:'/api/reservedetail',
				data:data,
				type:'GET',
				dataType:'json',
				success:function(res){
					if(res.code == 1){
						layer.open({
							type: 1,
							title: false, //不显示标题栏
							skin: 'mykebiao_layer_wrap', //样式类名
							id: 'mykebiao_layer', //设定一个id，防止重复弹出
							closeBtn: 0, //不显示关闭按钮
							anim: 2,
							shadeClose: true, //开启遮罩关闭
							area: ['80%', '60%'],
							content:'<div class="mykebiao_layer text-jus"><div class="container"><h3 class="pt40 mb40 f36 text_center">提示</h3><p class="pt30 f32">你已成功预定-私教培训课程-快去我的课程查看赠送的【赛普课堂】吧</p><div class="btnWrap pt30 pb30"><a href="/course/detail/37.html"class="btn f34">我的课表</a></div></div></div>',
							btn:false
						});
					}else{
						layer.open({
							type: 1,
							title: false, //不显示标题栏
							skin: 'mykebiao_layer_wrap', //样式类名
							id: 'mykebiao_layer', //设定一个id，防止重复弹出
							closeBtn: 0, //不显示关闭按钮
							anim: 2,
							shadeClose: true, //开启遮罩关闭
							area: ['80%', '60%'],
							content:content,
							btn:false
						});
					}
				}
			});

		})


	})
</script>
{{--<script src="/lib/jqweui/js/jquery-weui.min.js"></script>--}}
{{--<script src="/lib/layer/layer.js"></script>--}}

<!--倒计时 start-->
<script src="/lib/djs/jquery.easing.js"></script>
<script src="/lib/djs/fliptimer.js"></script>
<script type="text/javascript">
	$(".ft_counter").EightycloudsFliptimer({
		//enddate    : "18 March 2019 12:00:00 GMT",
		enddate    : "31 December 2018 24:00:00 GMT",
		callback   : function(){
			alert("本活动已结束!");
		}
	});
	$(function (){
		$(".ft_counter .EightycloudsFlipTimer .hours").after("<div class='clear'></div>");
		$('.ft_counter .EightycloudsFlipTimer .days .block_text').text('天');
		$('.ft_counter .EightycloudsFlipTimer .hours .block_text').text('小时');
		$('.ft_counter .EightycloudsFlipTimer .minutes .block_text').text('分钟');
		$('.ft_counter .EightycloudsFlipTimer .seconds .block_text').text('秒');
	})

</script>
<!--倒计时 end-->

<script type="text/javascript">
	window.onload = function(){
		menuFixed('nav_keleyi_com');
	}
</script>

@endsection