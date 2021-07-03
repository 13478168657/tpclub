<!DOCTYPE html>
<html lang="zh-CN">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
	<title>结业证书</title>
	<meta name="author" content="白白" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<!-- <script src="js/rem.js" type="text/javascript"></script>
	<link href="css/reset_phone.css" rel="stylesheet" type="text/css" />
	<link href="css/font-num40.css" rel="stylesheet" type="text/css" /> -->
	<link rel="stylesheet" href="/css/font-num40.css">
    <link rel="stylesheet" href="/css/reset.css">
	<style>
		.indent{text-indent: 2em;}
		/* banner */
		.graduate_wrap{background: url(/images/ttw/graduate.jpg)no-repeat center center;background-size: 100% 100%;padding:11.85rem 0 15.675rem 0;}
		.graduate_con{padding:0 1.8rem;}
		.graduate_con .ipt{background: none;color:#000;width:5rem;border: 0;border-bottom:1px solid #000;border-radius: 0;outline: none;}
		.graduate_con .graduate_txt{line-height: 1rem;}

		@media (max-width: 320px) {
			
		}
	</style>
	<script src="/js/rem.js" type="text/javascript"></script>
</head>

<body>
<div class="graduate_wrap">
	<div class="graduate_con f24 lt color_000">
		<p class="graduate_top mb40">亲爱的赛普学员<input type="text" class="ipt text_center" value="{{$name}}" id="name" />：</p>
		<p class="graduate_txt indent">恭喜您顺利完成为期三周的“TRAIN TO WIN”短视频达人培训，经考核成绩合格，准予结课。</p>
		<p class="indent mt10 mb50">特发此证，以资鼓励！</p>
		<p class="mt40 text_right f25 ltc">赛普健身教练培训基地</p>
		<p class="text_right f20 ltc mt20">2020年3月</p>
	</div>
</div>



<script src="/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
	$(function () {	
		//针对苹果手机键盘的复位
		$("input").blur(function () { 
 			setTimeout(function() { 
 			var scrollHeight = document.documentElement.scrollTop || document.body.scrollTop || 0; 
 			window.scrollTo(0, Math.max(scrollHeight - 1, 0)); 
 			}, 100); 
 		}); 
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
    var title = 'TRAIN TO WIN结课证书';
    var desc = '快来查收你的获奖通知函吧！';
    var share_img = "http://m.saipubbs.com/images/zt/just_do_it/share.png";
    var url = "http://m.saipubbs.com/jdt/active/notice";
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img, // 分享图标

        }, function(res) {
            //这里是回调函数

        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: title, // 分享标题
            link: url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img, // 分享图标

        }, function(res) {
            //这里是回调函数

        });
    });
    //弹窗
    
</script>	
</body>

</html>