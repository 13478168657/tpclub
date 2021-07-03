<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>报名结果登记信息</title>
    <!-- jqweui -->
    <link rel="stylesheet" href="lib/jqweui/css/weui.min.css">
    <link rel="stylesheet" href="lib/jqweui/css/jquery-weui.css">
    <link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/mp.css">
    <link rel="stylesheet" href="css/font-num40.css">
    <link rel="stylesheet" href="css/index.css?id={{rand(1,100)}}">
    <script src="js/rem.js"></script>
    @include('layouts.baidutongji')
</head>

<body ontouchstart>


<!-- banner-->
<img src="images/ban.jpg" alt="" class="img100">

<!-- 公共列表 start -->
<h3 class="text_center lt f48 pt120 pb15">“赛普千人减脂”大作战</h3>
<div class="hear-box text_center">
	<ul class="clearfix">
		<li>
			<img src="images/icon-yibaoming.png" alt="" class="img100">
			<p class="lt f26">已报名</p>
			<p class="fz f24">{{$redisData['members']}}</p>
		</li>
		<li>
			<img src="images/icon-renci.png" alt="" class="img100">
			<p class="lt f26">投票总数</p>
			<p class="fz f24">{{$redisData['fat_activity_votes']}}</p>
		</li>
		<li>
			<img src="images/icon-fangwen.png" alt="" class="img100">
			<p class="lt f26">访问次数</p>
			<p class="fz f24">{{$redisData['fat_activity_views']}}</p>
		</li>
	</ul>
</div>
<!-- 公共列表 end -->

<div class="page_xuanshouxiangqing mlr30 mt50 mb50 bgf2 bor2">
	<!-- 内容 start -->
	<div class="content pb50 ">
		<div class="thumbList pb40">
			<ul>
				<li>
					<div class="clearfix wrap k2">
						<p><span>姓名：</span><span>{{$member->name}}</span></p>
						<p><span>性别：</span><span>{{$member->sex=='male' ? '男' : '女'}}</span></p>
						
					</div>
				</li>
				<li>
					<div class="clearfix wrap k2">
						<p><span>{{$member->object=='student' ? '班级' : '分支'}}：</span><span>{{$member->class}}</span></p>
						<p><span>{{$member->object=='student' ? '学期' : '部门'}}：</span><span>{{$member->stage}}</span></p>
					</div>
				</li>
				<li>
					<div class="clearfix wrap k2">
						<p><span>手机号：</span><span>{{$member->mobile}}</span></p>
						<p></p>
					</div>
				</li>			
				@if($member->height)
				<li>
					<div class="clearfix wrap">
						<p><span>首次登记信息：</span><span>{{$member->fat_first_time}}</span></p>
					</div>
				</li>
				<li>
					<div class="clearfix wrap">
						<p>三周后登记信息：{{date('Y-m-d',strtotime($member->fat_first_time)+3600*24*20)}} (全天都可以)</p>
					</div>
				</li>
				@endif
			</ul>
		</div>
		<div class="thumb relative">
			<img src="{{env('IMG_URL')}}{{$member->cover_img}}" class="img100" alt="{{$member->name}}" />
			<span class="number font-Impact" onclick="window.location.href='/fat/member/{{$member->id}}.html'">{{$member->id}}</span>
		</div>

	</div>
	<!-- 内容 end -->
</div>

<!-- 按钮 -->
	


	@if(!$member->fat_rate)
		<button class="btn lt f48 color_000 mt68"><a href='/fat/body/data'>登记信息</a></button>
	@else
		@if($count<1)
			@if(time()>(strtotime($member->fat_first_time)+3600*24*20) && time()<(strtotime($member->fat_first_time)+3600*24*21))
			<button class="btn lt f48 color_000 mt68"><a href='/fat/body/data'>登记信息</a></button>
			@else
			<button class="btn lt f48 color_000 mt68"><a href='javascript:;'>未到达登记时间</a></button>
			@endif
		@else
			<button class="btn lt f48 color_000 mt68"><a href='/fat/member/{{$member->id}}.html'>查看全部体测</a></button>
		@endif
	@endif
<br><br>
<br><br>
<!-- 公共脚部 start -->
    @include('a.fat.footer',['type'=>2])
    <!-- 公共脚部 end -->
<script src="js/jquery-1.11.2.min.js"></script>
<script src="lib/jqweui/js/fastclick.js"></script>
<script src="lib/jqweui/js/jquery-weui.min.js"></script>
<script src="lib/layer/layer.js"></script>
<script src="lib/swiper/swiper.js"></script>
<script>
	$(function () {
		FastClick.attach(document.body);
	});
	//图片浏览器
	$(".showFigure .figure li").click(function () {
		var urls = [];
		var len = $(this).parents('.figure').find('ul li').size();
		var index=$(this).index();
		console.log(len)
		$(this).parents('.figure').find('li').each(function () {
			var src = $(this).find('img').attr('src');
			urls.push(src)
		});
		var pb3 = $.photoBrowser({
			items: urls,

		initIndex: index
		});
		console.log(urls)
		pb3.open();
	});

</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    var url  = window.location.href;
    var title= document.title;
    var desc = '健身改变人生，千人减脂大比拼';
    var share_img = "{{env('APP_URL')}}/images/wx_share.jpg";
    console.log(url);
    console.log(title);
    console.log(desc);
    console.log(share_img);
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
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img, // 分享图标
            success: function(){

            }
        }, function(res) {
        //这里是回调函数

        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: title, // 分享标题
            link: url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img, // 分享图标
            success: function(){

            }
        }, function(res) {
        //这里是回调函数

        });
    });
</script>    
</body>

</html>