@extends('layouts.header')
@section('title')
    <title>赛普社区-投放页面</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
@endsection

@section('cssjs')
	<!--本css-->
	<link rel="stylesheet" href="../css/zt/zt_tuibian.css">

<script>
(function(){
	var html = document.documentElement;
	var hWidth = html.getBoundingClientRect().width;
	html.style.fontSize=hWidth/18.75+'px';
})()
</script>
@endsection

@section('content')

<body ontouchstart>

<!---导航右侧带导航弹出---->

<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->



	<!--头部导航 end-->

		<!--------------------------------------本喵是模块分割线--------------------------------------------->


	<div class="plr30"><!--边距30 开始-->
		
		<!--banner start-->
			<div class="mb40 pb10">
				<img src="../images/zt/tuibian/banner1.jpg" alt="">
				<img src="../images/zt/tuibian/banner2.jpg" alt="">
			</div>
		<!--banner end -->		
		<!--------------------------------------本喵是模块分割线--------------------------------------------->


		<!--你是否有以下困惑？ start -->
			<div class="T-content1 pb30">
				<div class="bg f35 fz bold">
					<ul>
						<li class="pt10 pb10"><span class="border-radius50 bgcolor_orange text_center mr20">1</span>想系统健身不知从何入手?</li>
						<li class="pt10 pb10"><span class="border-radius50 bgcolor_orange text_center mr20">2</span>为找不到高效的训练方法而苦恼</li>
						<li class="pt10 pb10"><span class="border-radius50 bgcolor_orange text_center mr20">3</span>有经验的训练者难以突破平台期</li>
						<li class="mt10 mb40 pb30"><span class="border-radius50 bgcolor_orange text_center mr20">4</span>想追随名师却投师无门</li>
						<li class="f36 padding0 text_center mt30 mb40">如果恰好有一个机会你能把握住吗？</li>
					</ul>
				</div>

			</div>
		<!--你是否有以下困惑？ end -->
		<!--------------------------------------本喵是模块分割线--------------------------------------------->



		<!--2018年10月 start -->
		<div class="T-content2 ptb45 mt30 bgcolor_gray border-radius-img fz">
			<div class="text_center pb30">
				<p class="f70 bold">2018年10月</p>
				<h2 class="fz f39 pt10 bold">赛普斥资<span class="color_orange">40万</span>推出<span class="color_orange">“蜕变”21天</span></h2>
			</div>

			<div class="bg mt30">
				<ul class="clearfix text_center f30 fz">
					<li class="fl">三次长达<span class="bold">80</span>分钟<br>的冠军直播课程</li>
					<li class="fr">为期<span class="bold">21</span>天的冠军<br>每日训练计划<br>实时更新</li>
				</ul>
			</div>
			<p class="fz f24 mt30 plr20">与健身大咖朝夕相处,了解更多健身干货,零距离的互动与交流</p>
		</div>
		<!--2018年10月 end -->
		<!--------------------------------------本喵是模块分割线--------------------------------------------->




		<!--3个课程  start-->
		<div class="T-content3 ">
			<ul>
				<li class="pt40 mt30">
					<img class="pt40 pl400" src="../images/zt/tuibian/T3-text1.png" alt="">
					<p class="fz f28 mt26 pl400">了解健身中必备的基础知识<br>能够依据训练目标科学定制适合自己的健身计划</p>
					<p class="fz text_right pr20 mr20 pt40 pb20 color_orange">62 min <img class="ml20" src="../images/zt/tuibian/ren.png" alt="">7854</p>
				</li>
				<li class="pt40 mt30">
					<img class="pt40 pl400" src="../images/zt/tuibian/T3-text2.png" alt="">
					<p class="fz f28 mt26 pl400">掌握增肌、减脂、塑形的饮食结构制定<br>个性化饮食食谱</p>
					<p class="fz text_right pr20 mr20 pt40 pb20 color_orange">61 min <img class="ml20" src="../images/zt/tuibian/ren.png" alt="">6984</p>
				</li>

				<li class="pt40 mt30">
					<img class="pt40 pl400" src="../images/zt/tuibian/T3-text3.png" alt="">
					<p class="fz f28 mt26 pl400">主人公是如何从小白成为冠军的<br>了解冠军的蜕变成长之路</p>
					<p class="fz text_right pr20 mr20 pt40 pb20 color_orange">57 min <img class="ml20" src="../images/zt/tuibian/ren.png" alt="">9585</p>
				</li>
			</ul>
		</div>
		<!--3个课程  end-->
		<!--------------------------------------本喵是模块分割线--------------------------------------------->


		<!--本喵是一条2px的虚线-->
		<div class="lin-x mtb45"></div>


		<!--本计划适合谁？解决什么问题？ start -->
		<div class="T-content4 ptb45 bgcolor_gray border-radius-img text_center">
			<h2 class="title fz bold f40">本计划适合谁？解决什么问题</h2>

			<div class="mt30 pt30">
				<ul class="clearfix">
					<li class="fz fl">
						<img src="../images/zt/tuibian/T4img1.png" alt="">
						<p class="f30 bold mt10 mb10">健身小白</p>
						<span class="f26">盲目健身效果差<br>学习健身无从下手</span>
					</li>
					<li class="fz fl">
						<img src="../images/zt/tuibian/T4img2.png" alt="">
						<p class="f30 bold mt10 mb10">资深训练者</p>
						<span class="f26">平台期难以突破<br>进步停滞</span>
					</li>
					<li class="fz fl">
						<img src="../images/zt/tuibian/T4img3.png" alt="">
						<p class="f30 bold mt10 mb10">健身教练</p>
						<span class="f26">会员粘滞性差<br>工作中棘手问题不知所措</span>
					</li>
				</ul>
			</div>
		</div>
		<!--本计划适合谁？解决什么问题？ end -->
		<!--------------------------------------本喵是模块分割线--------------------------------------------->


		<!--课程导师 start-->
		<div class="T-content5 ptb45 mt30 bgcolor_gray border-radius-img text_center">
			<h2 class="title fz bold f40 title-D"><img src="../images/zt/tuibian/tea.png" alt="">课程导师</h2>

			<div class="tea plr20 mt30 text_left fz">
				<ul class="clearfix">
					<li class="fl"><img src="../images/zt/tuibian/hxy.png" alt=""></li>
					<li class="fr">
						<h3 class="f30 bold"><img src="../images/zt/tuibian/ren2.png" alt="">何翔宇</h3>
						<div class="small-unit">
							<label class="label color_orange">●</label>
							<div class="msg f22">Saipu赛普健身学院 培训师／导师</div>
						</div>
						<div class="small-unit">
							<label class="label color_orange">●</label>
							<div class="msg f22">2018京津冀健美公开赛 75KG 冠军等多届健美赛事冠军</div>
						</div>
						<div class="small-unit">
							<label class="label color_orange">●</label>
							<div class="msg f22">Resistance Training<br>Specialist抗阻力训练专家 认证</div>
						</div>
						<div class="small-unit">
							<label class="label color_orange">●</label>
							<div class="msg f22">CFSC Strength &<br>Conditioning国际体能教练认证</div>
						</div>
					</li>
				</ul>
				<p class="f24 bold mt30 pt20 mb20">何老师自己的蜕变历程—瘦鸡华丽变身型男</p>
				<img src="../images/zt/tuibian/teaimg1.jpg" alt="">
				<img src="../images/zt/tuibian/teaimg2.jpg" alt="">
			</div>
		</div>
		<!--课程导师 end-->
		<!--------------------------------------本喵是模块分割线--------------------------------------------->



		<!--型男靓女的蜕变之路邀请你共同见证 start-->
		<div class="T-content6 ptb45 mt30 bgcolor_gray border-radius-img text_center fz">
			<h2 class="title fz bold f38 title-E">型男靓女的蜕变之路邀请你共同见证</h2>

			<img class="mt30 pt20 " src="../images/zt/tuibian/tui1.jpg" alt="">
			<p class=" f24 mt30 mb30">第1期参训者 张丹 参加训练营6期 蜕变纪录</p>
			<div class="plr20 text_left">
				<p class="f30 bold">训练者说：</p>
				<p class="f28 text-jus">抱着试试的心态参加线上训练营，本想减肥，结果被健身深深吸引。慢慢对健身感兴趣，于是毫不犹豫地来到了赛普健身教练培训基地，系统学习了专业健身知识。同时在导师的带领下荣获健身比基尼小姐冠军。从来不敢想象我竟然从一个油腻的胖子，变成比基尼小姐冠军。健身给我带来的不仅是完美的身材，更是新的生活方式。我为我自己代言。</p>
				<!--本喵是一条2px的虚线-->
				<div class="lin-x mtb45"></div>
			</div>

			<img class="mt30 pt20 " src="../images/zt/tuibian/tui2.jpg" alt="">
			<p class=" f24 mt30 mb30">第3期参训者 赵迪 参加训练营4期 蜕变纪录</p>
			<div class="plr20 text_left">
				<p class="f30 bold">训练者说：</p>
				<p class="f28 text-jus">我是一名健身爱好者，有一定的训练经验，偶然在网上看到线上冠军训练营。听了直播课对我的健身之路帮助很大。用了冠军的训练计划和方法。进步突飞猛进。我已经参加 4期了。还有个事我不好意思说，起初我觉得21天冠军训练计划和三节直播课仅需一个汉堡的价格，抱着试试的心态，参加后结果很令我吃惊。很感谢赛普，我已预订了年底的高级私教培训课程。希望能有新的突破。</p>
			</div>

		</div>
		<!--型男靓女的蜕变之路邀请你共同见证 end -->

		<!--------------------------------------本喵是模块分割线--------------------------------------------->




		<!--资源有限-马上抢占 start-->
		<div class="T-content7 ptb45 mt30 bgfcc800 border-radius-img text_center fz">
			<span class="f30">• 资源有限-马上抢占 •</span>
			<p class="f56 bold mt20 mb30 pb20">仅提供100名额</p>

		<iframe name="teamPost" style="display:none;"></iframe>

		<form method="post" action="/zt/store" id="formData"  target="teamPost">
		{{csrf_field()}}
			<div class="form fz f24 clearfix mb30 pt10">
				<div class="input">
					<input type="text" id="tel" name="name" placeholder="请输入您的微信号码" class="input border-radius50 f24 text_center name_attr" required>
					<input type="hidden" name="url" value=""/>
					<p class="text_left tip">请输入您的微信号码</p>
				</div>
				<a href="javascript:void (0)" class="border-radius50 btn btn-submit">马上申请</a>
			</div>
		</form>

			<img src="../images/zt/tuibian/botimg.jpg" alt="">


			<!--恩~ -->
			<div class="text_left fz f27 bold plr30">
				<div class="small-unit small-unit-D">
					<label class="label label-D label-D-1">本期开营时间：</label>
					<div class="msg msg-D msg-D-1 text-jus">2018年10月22日（人数限制100人）</div>
				</div>
				<div class="small-unit small-unit-D">
					<label class="label label-D">报名方式：</label>
					<div class="msg msg-D text-jus">1.微信扫描二维码添加联系人,付款29元。</div><br>
					<div class="msg msg-D">2、管理员邀请入群。</div>
				</div>
				<div class="small-unit small-unit-D">
					<label class="label label-D">最终收获：</label>
					<div class="msg msg-D text-jus">1.为期21天的每日冠军训练计划同步更新</div><br>
					<div class="msg msg-D text-jus">2.每天健身干货早晚报</div><br>
					<div class="msg msg-D text-jus">3.三次冠军导师健身干货直播课程</div><br>
					<div class="msg msg-D text-jus">4.结识更多志同道合的伙伴</div><br>
					<div class="msg msg-D text-jus">5.优秀学员有机会获得免费线下体验课程</div>
				</div>
			</div>
		</div>
		<!--资源有限-马上抢占 end-->





	</div><!--边距30 结束-->










</div><!--导航大盒子id=page 结束-->



<br><br><br>



<script src="../lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="../lib/jqweui/js/fastclick.js"></script>
<script>


	/**/
  $(function() {
    FastClick.attach(document.body);
  });
</script>
<script src="../lib/jqweui/js/jquery-weui.min.js"></script>
<script src="../lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="../lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="../lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="../lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->

<script type="text/javascript">

var strUrl = window.location.href;
$('input[name="url"]').attr('value',strUrl);

console.log(strUrl);
	window.onload = function(){
		menuFixed('nav_keleyi_com');
	}
	$(".btn-submit").click(function(){
		var name = $(".name_attr").val();
		if(name == ""){
		 	layer.msg("请输入您的微信号");
		}else{
			$("#formData").submit();
			layer.msg("申请已提交");
			$('#formData')[0].reset();
		}
		 

	})
		
</script>
@endsection
