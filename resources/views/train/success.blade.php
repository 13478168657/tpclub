<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
<title>赛普社区-产后实践-填写个人信息</title>
<meta name="author" content="啾啾" />
<meta name="keywords" content="" />
<meta name="description" content="" />
	<!--mmenu.css start-->
<link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
<link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
<link href="/css/nav-mmenu-public.css" rel="stylesheet" />
	<!--end-->
<link href="/css/reset.css" rel="stylesheet" type="text/css" />
<link href="/css/font-num40.css" rel="stylesheet" >

	<!--本css-->
	<link rel="stylesheet" href="/css/zt/zt_chanhoushijian.css">

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
				<li><a href="/article/0.html">文章</a></li>
				<li><a href="/cak/1.html">问答</a></li>
				<li><a href="/user/studying">我的课程</a></li>
				<li><a href="/user/index">我的</a></li>
			</ul>
		</div>
	</nav>
	<!--头部导航 end-->


	<div class="ban bg_fdf3cc pt98">
		<img src="/images/zt/chanhoushijian/last_tit.png" alt="">
		<p class="text_center fz color_333 border-radius50 f26 mt32">
			<span><img src="/images/zt/chanhoushijian/ico_xing.png" alt="">加微信：SPJSSQ</span>
			<span>备注报名期数投入班主任的怀抱吧！</span>
		</p>
		<img src="/images/zt/chanhoushijian/bian.jpg" class="pt40" alt="">
	</div>

	<!--以下填写个人信息，以便于我们更好的教学-->
	<div class="list_g fz pt40">
		<h2 class="text_center f29 bold"><i></i>以下填写个人信息，以便于我们更好的教学<i></i></h2>
		<ul class="f26 plr45 mt32">
			<li class="pb30">
				<div class="why">
					<h3 class="f28 bgcolor_gray">1、为了让班班找到你请填写你的有效微信号</h3>
					<input type="text" name="wx" placeholder="点击这里填写微信号..." class="input plr30 f26" >
				</div>
			</li>
			<li class="pb30">
				<div class="why checkboxWrap">
					<h3 class="f28 bgcolor_gray">2、请问您的执教___年了</h3>
					<div class="plr20  ptb30 clearfix">
						<label class="fz f28 mb10"><input type="radio" value="1" class="radiobox" name="time" />在校学员</label>
						<label class="fz f28 mb10"><input type="radio" value="2" class="radiobox" name="time" />毕业学员未执教</label>
						<label class="fz f28 mb10"><input type="radio" value="3" class="radiobox" name="time" />1年以内</label>
						<label class="fz f28 mb10"><input type="radio" value="4" class="radiobox" name="time" />1-2年</label>
						<label class="fz f28 mb10"><input type="radio" value="5" class="radiobox" name="time" />2-3年</label>
						<label class="fz f28 mb10"><input type="radio" value="6" class="radiobox" name="time" />3-4年</label>
						<label class="fz f28 mb10"><input type="radio" value="7" class="radiobox" name="time" />4-5年</label>
						<label class="fz f28 mb10"><input type="radio" value="8" class="radiobox" name="time" />5年以上</label>
					</div>
				</div>
			</li>
			<li class="pb30">
				<div class="why checkboxWrap">
					<h3 class="f28 bgcolor_gray">3、请问您如何了解到我们课程的？</h3>
					<div class="plr20  ptb30 clearfix">
						<label class="fz f28 mb10"><input type="radio" value="1" class="radiobox" name="know"/>微信公众号</label>
						<label class="fz f28 mb10"><input type="radio" value="2" class="radiobox" name="know"/>微信群内</label>
						<label class="fz f28 mb10"><input type="radio" value="3" class="radiobox" name="know"/>同学推荐</label>
						<label class="fz f28 mb10"><input type="radio" value="4" class="radiobox" name="know"/>导师推荐</label>
					</div>
					<input type="text" name="way" placeholder="如上述没有符合您的选项，点击这里添写其他渠道..." class="input plr30 f26" >
				</div>
			</li>
			<li class="pb30">
				<div class="why">
					<h3 class="f28 bgcolor_gray">4、其他建议</h3>
					<div class="textarea-c plr20">
						<textarea class="fz pt30 suggest"  placeholder="对我们可还有什么其他的建议，点这里添写..." name="suggest" rows="5"></textarea>
					</div>
				</div>
			</li>
		</ul>
		<div class="sub_btn text_center fz f29 plr64 mt45">
			<a onclick="infoSubmit()" class="border-radius50 bga ">提交</a>
		</div>
	</div>


</div><!--导航大盒子id=page 结束-->

<br><br>

<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>

<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->
<script src="/lib/icheck/js/icheck.min.js"></script>
<script>
	//单选按钮
	$('.radiobox').iCheck({
		//checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio',
		increaseArea: '20%'
	});
	var id = '{{$id}}';
	function infoSubmit(){

		var _token = '{{csrf_token()}}';
		var wx = $("input[name='wx']").val();
		var time = $("input[name='time']:checked").val();
		var know = $("input[name='know']:checked").val();
		var way = $("input[name='way']").val();
		var suggest = $(".suggest").val();
		var msg = '';
		if(wx == ''){
			msg = '请填写微信号';
			layer.msg(msg);
			return false;
		}
		if(time == '' || time == undefined){
			msg = '请选择执教年限';
			layer.msg(msg);
			return false;
		}
		if(know == '' || know == undefined){
			know  = '';
		}

		var data = {wx:wx,time:time,know:know,way:way,suggest:suggest,id:id,_token:_token};
		$.ajax({
			url:'/train/remark',
			data:data,
			type:'POST',
			dataType:'json',
			success:function(res){
//				if(res.code == 0){
					window.location.href='/train/notice?id='+id;
//				}else{
//					layer.msg(res.message);
//				}

			}
		})
	}


</script>


</body>
</html>
