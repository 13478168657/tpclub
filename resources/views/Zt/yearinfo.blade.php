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
	<!--banner start-->
	<div>
		<img src="/images/zt/xianshifuli/ban1.jpg" alt="">
		<img src="/images/zt/xianshifuli/ban2.jpg" alt="">
		<img src="/images/zt/xianshifuli/ban3.jpg" alt="">
		<img src="/images/zt/xianshifuli/ban4.jpg" alt="">
	</div>
	<!--banner end-->

	<div class="mlr20"><!--边距30 开始-->
		<!--倒计时 start-->
		<div>
			<img src="../images/zt/xianshifuli/time-title.jpg" alt="">

			<div class="daojishi_wrap">
				<div class="inner">
					<div class="con">
						<div class="wrap">
							<!--倒计时开始-->
							<!--<div class="ft_counter cleafix">
							</div>-->

							<div class="djs-list mb30 pt10">
								<p class="f36">
									<span class="e bold text_center f46 border-radius-img bgcolor_fff" id="_d">00</span>天
									<span class="e bold text_center f46 border-radius-img bgcolor_fff ml20" id="_h">00</span>小时
								</p>

							</div>
							<div class="djs-list2 pb10">
								<p class="f36">
									<span class="e bold text_center f97 border-radius-img bgcolor_fff" id="_m">00</span>分钟
									<span class="e bold text_center f97 border-radius-img bgcolor_fff ml20" id="_s">00</span>秒
								</p>

							</div>

							<!-- 倒计时结束 -->
						</div>
						<div class="txt f26 bold">
							<p class="text-jus">活动结束前邀请好友预定-【赛普高级私教】，邀请人数最多的排名前十，可免费上价值<span class="color_red">25000</span>元的高级私教课程。<br><span class="color_red">（预定金随时可退）</span></p>

							<p class="text-jus mt20">不仅如此活动结束前——所有预定【赛普高级私教】课程的小伙伴都可以获得价值<span class="color_red">3000</span>元线上视频课程<br><span class="color_red">（活动后恢复原价）</span></p>

							<p class="text-jus color_red mt20">此活动可与赛普其他活动同时参与（不影响学费减免）</p>
							<!--<div class="mb63">
								<a href="#" class="color_red">点击查看邀请排行榜</a>
							</div>
							<p class="text-jus">价值3000元的线上【私教课程】，现在预定即可免费获得。课程详情请看下文。</p>
							<div class="color_red">
								（活动后即刻恢复原价）
							</div>
							<img src="../images/zt/xianshifuli/djs_lian.png" class="lian lian1" alt="链" />
							<img src="../images/zt/xianshifuli/djs_lian.png" class="lian lian2" alt="链" />-->
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



		<!--视频 1 start-->
		<div class="shipin-one text_center">
			<h2 class="color_orange f32 mb40">年终锦鲤活动说明</h2>

			<!--shipin start-->
			<div class="video-wrap">
				<div class="con">
					<div class="video">
						<div class="box2">
							<img src="../images/zt/xianshifuli/shipingimg1.jpg" alt="" />
							<!--<div class="mask"></div>-->
							<!--<span class="btn_play"></span>-->
						</div>
						<video src="http://v.saipubbs.com//zt/%E5%B9%B4%E7%BB%88%E8%B5%9B%E6%99%AE%E9%94%A6%E9%B2%A4%E5%B0%8F.mp4" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto"></video>
					</div>

				</div>
			</div>
			<!--shipin end-->

		</div>
		<div class="bg-btn clearfix text_center ">
			@if($mobile==0)
				<a href="javascript:void (0)" onclick="userlogin()" class="fl bgcolor_orange f32 border-radius-img">我要预定</a>
				<a href="javascript:void (0)" onclick="userlogin()" class="fr bgcolor_orange f32 border-radius-img">马上邀请</a>	
			@else
				<a href="http://jfpt.saipujiaoyu.com/MNetWorkUI/" class="fl bgcolor_orange f32 border-radius-img">我要预定</a>
				<a href="/wechat/share/37.html" class="fr bgcolor_orange f32 border-radius-img">马上邀请</a>
			@endif
			
		</div>
		<!--视频 2 start-->

		<!--=========================本喵是分割线===============================================================-->
		<!--活动规则 start-->
		<!-- <div class=" bg-hongdong">
			<h3 class="f40 color_orange text_center"><i></i>活动规则<i></i></h3>

			<div class="plr30 mlr30 pt40 mt30">
				<p class="color_fff mb20 f28 text-jus">1、12.31日前邀请好友预定-赛普高级私教课程，邀请人数最多的排名前十，可免费上价值25000元的高级私教课程。
					<br>
					<a href="javascript:void (0)" class="f30 color_orange">（预定金随时可退）</a>
				</p>

				<p class="color_fff mb30  f28 text-jus">2、现在预定赛普高级私教课程就可免费获得价值3000元线上【私教课堂】。
					<br>
					<a href="javascript:void (0)" class="f30 color_orange">（活动后恢复原价）</a>
				</p>
				<!--<p class="color_orange mb63 f28">有任何问题：添加客服老师微信saipujianshen,为您进行贴心解答。</p>-->
			<!-- </div>
		</div>  -->

		<div class="bg-tiyan text_center ">
			<a href="#1f" class="color_orange f30">体验一下线上【私教课堂】</a>
		</div>
		<!--活动规则 end-->
		<!--=========================本喵是分割线===============================================================-->


		<!--参与活动流程 start-->
		<div class=" bg-canjia">
			<h3 class="f40 color_orange text_center mb40"><i></i>参与活动流程<i></i></h3>

			<div class="plr30 mlr30">

				<div class="liucheng mt30">
					<p class="mb63 color_fff f28 clearfix">
						<i class="bgcolor_orange color_000 border-radius50 text_center">1</i>
						<span class="fr text-jus">点击左下方【预定】按钮进行预定。<br>
						（注：为了资金的安全、在您没有注册系统的情况下会自动弹出注册页面，完成【赛普健身社区】注册就可进行下一步）</span>
					</p>
					<p class="mb63 color_fff f28 clearfix">
						<i class="bgcolor_orange color_000 border-radius50 text_center">2</i>
						<span class="fr text-jus">根据操作提示在浏览器中打开缴费页面</span>
					</p>
					<p class="mb63 color_fff f28 clearfix">
						<i class="bgcolor_orange color_000 border-radius50 text_center">3</i>
						<span class="fr text-jus">进行缴费平台登录（注：手机号/注册账号为【赛普健身社区】注册手机号，密码为注册手机号后6位）</span>
					</p>
					<p class="mb63 color_fff f28 clearfix">
						<i class="bgcolor_orange color_000 border-radius50 text_center">4</i>
						<span class="fr text-jus">登录缴费平台后按照步骤完成缴费</span>
					</p>
					<p class="mb63 color_fff f28 clearfix">
						<i class="bgcolor_orange color_000 border-radius50 text_center">5</i>
						<span class="fr text-jus">完成缴费后请点击页面<a href="javascript:void(0)" class="color_orange">【我已预定】</a>（完成这一步才算哦！点击过后就可以在我的课表查看线上视频课程了）</span>
					</p>
					<p class="mb63 color_fff f28 clearfix">
						<i class="bgcolor_orange color_000 border-radius50 text_center">6</i>
						<span class="fr text-jus">点击【马上邀请】生成自己的邀请海报-长按分享到朋友圈，快去邀请你的小伙伴吧。你可以点击页面悬浮的【邀请明细】查看哪些小伙伴成功被邀请。</span>
					</p>
				</div>
			</div>
		</div>

		<!--btn start-->
		<div class="btn-bg2 text_center pt40">
			<!-- <a class="bgcolor_orange f32 color_000 border-radius-img mt32" href="/user/studying">我的课表</a> -->
			@if($mobile==0)
				<!-- <a class="bgcolor_orange f32 color_000 border-radius-img" onclick="userlogin()" href="javascript:void (0)"> -->
				<!-- 我已预定成功</a> -->
				<a class="bgcolor_orange f32 color_000 border-radius-img mt32" href="javascript:void (0)" onclick="userlogin()">查看预定邀请排行榜</a>
			@else
				<!-- <a class="bgcolor_orange f32 color_000 border-radius-img reserve" href="javascript:void (0)">我已预定成功</a> -->
				<a class="bgcolor_orange f32 color_000 border-radius-img mt32" href="/zt/rsort.html">查看预定邀请排行榜</a>
			@endif
			
			
		</div>
		<!--btn end-->
		<!--参与活动流程 end-->



		<!--=========================本喵是分割线===============================================================-->

		<!--参与活动须知 start-->
		<div class="bg-xuzhi2">
			<h3 class="f40 color_orange text_center"><i></i>参与活动须知<i></i></h3>

			<div class="plr30 mlr30 pt40 mt26">
				<p class="color_fff mb63 f28 text-jus">1、预定会有你的专属咨询师与你取得联系、有任何预定问题都可以咨询你的专属咨询师;</p>
				<p class="color_fff mb63 f28 text-jus">2、线上【私教课堂】为视频课程、供计9套课程，预定成功后，可以不限次数反复学习、永久有效该课程目前仅上线4套、我们会在2019年初陆续上线;</p>
				<p class="color_fff mb63 f28 text-jus">3、本活动所有解释权归赛普健身教练培训基地所有;</p>
				<!-- <p class="color_fff mb63 f28 text-jus">4、有任何问题：添加客服老师微saipujianshen,为您进行贴心解答;</p> -->
			</div>
		</div>
		<img src="../images/zt/xianshifuli/xuzhi-xian.jpg" alt="">
		<!--参与活动须知 end-->


		<!--=========================本喵是分割线===============================================================-->

		<!--课程 start-->
		<div>
			<a name="1f"></a>
			<h2 class="color_orange f44 ke-tit text_center">2019年赛普重磅<br>推出线上【私教视频课程】</h2>

			<div class="bg-ketit">
				<p class="f36 bgcolor_orange color_000">先试听一下课程<img src="../images/zt/xianshifuli/icon-houzi.jpg" alt=""></p>
			</div>



			<!--第一节-->

			<div class="color_fff text_center one-jie pb30 pt40">
				<p class="f32 mb40 pt40">第1节试听-学习解剖的意义</p>

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

			<div class="bg-tiyan bg-chakan text_center ">
				<a href="javascript:void (0)" class="color_orange f30">点击查看【私教视频课程】完整课表</a>
			</div>

		</div>

		<!--课程 end-->


		<!--=========================本喵是分割线===============================================================-->

		<!--课表 start-->
		<div class="kebiao">
			<h4 class="f44 color_orange text_center">2019【私教视频课程】完整课表</h4>

			<!--何翔宇-->
			<div class="bg-ter bg-list-ter color_fff relative">
				<span class="f24 color_000 bgcolor_orange">4节课</span>
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-he.jpg" alt="" class="border-radius-img"></dt>
					<dd class="fl">
						<h3 class="f32">运动训练基础解剖</h3>
						<p class="f26 op7">课程导师：何翔宇</p>
					</dd>
				</dl>
			</div>
			<img src="../images/zt/xianshifuli/bgtea-hexiangyu-b.jpg" alt="">

			<!--陶顺吉-->
			<div class="bg-ter bg-list-ter bg-list-ter-taoshunji color_fff relative">
				<span class="f24 color_000 bgcolor_orange">4节课</span>
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-taoshunji.jpg" alt="" class="border-radius-img"></dt>
					<dd class="fl nobo">
						<h3 class="f32">健身教练必备基础<br>知识入门</h3>
						<p class="f26 op7">课程导师：陶顺吉</p>
					</dd>
				</dl>
			</div>
			<img src="../images/zt/xianshifuli/bgtea-taoshunji-b.jpg" alt="">

			<!--徐乐-->
			<div class="bg-ter bg-list-ter bg-list-ter-xule color_fff relative">
				<span class="f24 color_000 bgcolor_orange">4节课</span>
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-xule.jpg" alt="" class="border-radius-img"></dt>
					<dd class="fl nobo">
						<h3 class="f32">【运动解剖】看这一<br>套就够了</h3>
						<p class="f26 op7">课程导师：徐乐</p>
					</dd>
				</dl>
			</div>
			<img src="../images/zt/xianshifuli/bgtea-xule-b.jpg" alt="">

			<!--解鹏-->
			<div class="bg-ter bg-list-ter bg-list-ter-xiepeng color_fff relative">
				<span class="f24 color_000 bgcolor_orange">4节课</span>
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-xiepeng.jpg" alt="" class="border-radius-img"></dt>
					<dd class="fl nobo">
						<h3 class="f32">【运动营养】减脂的<br>你吃对了吗？</h3>
						<p class="f26 op7">课程导师：解鹏</p>
					</dd>
				</dl>
			</div>
			<img src="../images/zt/xianshifuli/bgtea-xiepeng-b.jpg" alt="">

			<!--何翔宇-->
			<div class="bg-ter bg-list-ter bg-list-ter-he2 color_fff relative">
				<span class="f24 color_000 bgcolor_orange">4节课</span>
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-he.jpg" alt="" class="border-radius-img"></dt>
					<dd class="fl nobo">
						<h3 class="f32">如何进行抗阻力训练<br>的动作设计</h3>
						<p class="f26 op7">课程导师：何翔宇</p>
					</dd>
				</dl>
			</div>
			<img src="../images/zt/xianshifuli/bgtea-hexiangyu-b2.jpg" alt="">

			<!--何翔宇-->
			<div class="bg-ter bg-list-ter bg-list-ter-he3 color_fff relative">
				<span class="f24 color_000 bgcolor_orange">4节课</span>
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-he.jpg" alt="" class="border-radius-img"></dt>
					<dd class="fl">
						<h3 class="f32">胸部解剖与训练技术</h3>
						<p class="f26 op7">课程导师：何翔宇</p>
					</dd>
				</dl>
			</div>
			<img src="../images/zt/xianshifuli/bgtea-hexiangyu-b3.jpg" alt="">

			<!--何翔宇-->
			<div class="bg-ter bg-list-ter bg-list-ter-he4 color_fff relative">
				<span class="f24 color_000 bgcolor_orange">4节课</span>
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-he.jpg" alt="" class="border-radius-img"></dt>
					<dd class="fl">
						<h3 class="f32">肩部解剖与训练技术</h3>
						<p class="f26 op7">课程导师：何翔宇</p>
					</dd>
				</dl>
			</div>
			<img src="../images/zt/xianshifuli/bgtea-hexiangyu-b4.jpg" alt="">

			<!--何翔宇-->
			<div class="bg-ter bg-list-ter bg-list-ter-he5 color_fff relative">
				<span class="f24 color_000 bgcolor_orange">4节课</span>
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-he.jpg" alt="" class="border-radius-img"></dt>
					<dd class="fl">
						<h3 class="f32">背部解剖与训练技术</h3>
						<p class="f26 op7">课程导师：何翔宇</p>
					</dd>
				</dl>
			</div>
			<img src="../images/zt/xianshifuli/bgtea-hexiangyu-b5.jpg" alt="">

			<!--何翔宇-->
			<div class="bg-ter bg-list-ter bg-list-ter-he6 color_fff relative">
				<span class="f24 color_000 bgcolor_orange">4节课</span>
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-he.jpg" alt="" class="border-radius-img"></dt>
					<dd class="fl">
						<h3 class="f32">腿部解剖与训练技术</h3>
						<p class="f26 op7">课程导师：何翔宇</p>
					</dd>
				</dl>
			</div>
			<img src="../images/zt/xianshifuli/bgtea-hexiangyu-b6.jpg" alt="">

			<!--何翔宇-->
			<div class="bg-ter bg-list-ter bg-list-ter-he7 color_fff relative">
				<span class="f24 color_000 bgcolor_orange">4节课</span>
				<dl class="clearfix">
					<dt class="fl"><img src="../images/zt/xianshifuli/ter-he.jpg" alt="" class="border-radius-img"></dt>
					<dd class="fl">
						<h3 class="f32">腹部解剖与训练技术</h3>
						<p class="f26 op7">课程导师：何翔宇</p>
					</dd>
				</dl>
			</div>
			<img src="../images/zt/xianshifuli/bgtea-hexiangyu-b7.jpg" alt="">

		</div>
		<!--课表 end-->

		<!--=========================本喵是分割线===============================================================-->
	</div><!--边距30 结束-->
	
	<!-- <div class="footer_fuli text_center">
		<ul class="clearfix  f32">
			<li class="fl">
				@if($mobile==0)
					<a href="javascript:void (0)" onclick="userlogin()">预定￥500</a>
				@else
					<a href="http://jfpt.saipujiaoyu.com/MNetWorkUI/">预定￥500</a>
				@endif
			</li>
			<li class="fl">
				
				@if($mobile==0)
					<a href="javascript:void (0)" onclick="userlogin()">马上邀请</a>
				@else
					<a href="/wechat/share/37.html">马上邀请</a>
				@endif
			</li>
			<li class="fr wzixun"><a href="javascript:void (0)">微信咨询</a></li>
		</ul>
		
	</div> -->

	<div class="footer_fuli text_center">
		<ul class="clearfix bgcolor_orange f32">
			<li class="fl">
				@if($mobile==0)
					<a href="javascript:void (0)" onclick="userlogin()">预定￥500</a>
				@else
					<a href="http://jfpt.saipujiaoyu.com/MNetWorkUI/">预定￥500</a>
				@endif
			</li>
			<li class="fl">
				@if($mobile==0)
					<a href="javascript:void (0)" onclick="userlogin()">马上邀请</a>
				@else
					<a href="/wechat/share/37.html">马上邀请</a>
				@endif
			</li>
		</ul>
	</div>

	<!-- 右侧悬浮 start -->
	<div class="right_wrap">
		@if($mobile==0)
		<a class="bgcolor_orange f32 color_000 border-radius-img" onclick="userlogin()" href="javascript:void (0)">
			我已<br>预定
		</a>
		<a class="bgcolor_orange f32 color_000 border-radius-img mt32" href="/user/shareFriends">
			邀请<br>明细
		</a>
		@else
		<a class="bgcolor_orange f32 color_000 border-radius-img reserve" href="javascript:void (0)">
			我已<br>预定
		</a>
		<a class="bgcolor_orange f32 color_000 border-radius-img mt32" href="/user/shareFriends">
			邀请<br>明细
		</a>
		@endif
	</div>
	<!-- 右侧悬浮 end-->

</div><!--导航大盒子id=page 结束-->
<br><br>
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
            title: '邀你免费抢25000元高级私教课程', // 分享标题
            desc: '免费学高级私教课，赶快上车寻找2018赛普年终锦鲤，价值25000高级私教课程免费送......', // 分享描述
            link: "http://m.saipubbs.com/zt/yearinfo.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/tubiao/1.png", // 分享图标
        }, function(res) {
        //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '邀你免费抢25000元高级私教课程', // 分享标题
            link: "http://m.saipubbs.com/zt/yearinfo.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/tubiao/1.png", // 分享图标
        }, function(res) {
        //这里是回调函数
        });
    });
</script>
<script src="../lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="../lib/jqweui/js/fastclick.js"></script>
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
				content:'<div class="mykebiao_layer text-jus"><div class="container"><h3 class="pt40 mb40 f36 text_center">提示</h3><p class="pt30 f32">很遗憾！您还没有预定赛普私教课程，快去预定吧</p><div class="btnWrap pt30 pb30"><a href="#"class="btn f34">我的课表</a></div></div></div>',
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
							content:'<div class="mykebiao_layer text-jus"><div class="container"><h3 class="pt40 mb40 f36 text_center">提示</h3><p class="pt30 f32">你已成功预定-私教培训课程-快去我的课程查看赠送的【赛普线上视频课程】吧</p><div class="btnWrap pt30 pb30"><a href="/course/detail/37.html"class="btn f34">我的课表</a></div></div></div>',
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
<script src="../lib/jqweui/js/jquery-weui.min.js"></script>
<script src="../lib/layer/layer.js"></script>
<script>
	function countTime() {
		//获取当前时间
		var date = new Date();
		var now = date.getTime();
		//设置截止时间
		var endDate = new Date("2018/12/24");
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
		if(m<10 ){
			m="0"+m;
		}
		if(s<10){
			s="0"+s;
		}
		if(h<10){
			h="0"+h;
		}
		//将倒计时赋值到div中
		document.getElementById("_d").innerHTML = d+"";/*天*/
		document.getElementById("_h").innerHTML = h+"";/*时*/
		document.getElementById("_m").innerHTML = m+"";/*分*/
		document.getElementById("_s").innerHTML = s+"";/*秒*/
		//递归每秒调用countTime方法，显示动态时间效果
		setTimeout(countTime,1000);

	}
//	countTime();
</script>
<script language="javascript" src="http://shangwutong.saipujiaoyu.com/JS/LsJS.aspx?siteid=MRK72243147&lng=cn"></script>
<script>
    function ac(){
        openZoosUrl();
    }
</script>
<!--倒计时 end-->
@endsection