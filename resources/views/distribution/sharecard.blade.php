<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
<title>邀请卡{{env('WEB_TITLE')}}</title>
<meta name="author" content="啾啾" />
<meta name="keywords" content="" />
<meta name="description" content="" />
	<style>
		html,body{ width:100%; height:100%; overflow:hidden;margin: 0;padding: 0}
		img{display: block;width: 100%;margin: 0 auto}
		.bg{background: url("/images/zt/fenxiang/bg-bgfenxiang.jpg")no-repeat top center;background-size:100% 100%;height:100%;position: relative}
		.bg img{width: 15rem;top: 50%;position: absolute;left:50%;/*margin-top: -7.5rem;margin-left:-7.5rem;*/
			-webkit-transform: translate(-50%,-50%);
			-moz-transform: translate(-50%,-50%);
			-ms-transform: translate(-50%,-50%);
			-o-transform: translate(-50%,-50%);
			transform: translate(-50%,-50%);
}

		.font-c{width: 100%;height: 2.2rem;line-height: 2.2rem;background-color: rgba(255,255,255,.6)/*#f2f2f2*/;text-align:
		center;font-size:.9rem;color: #000;font-weight: bold;}


		.bg p{position: absolute;bottom:0%;text-align: center;width: 100%;font-size: .75rem;color: #fff;}
		.bg p i{border-bottom:1px solid #fff;width: 8%;display: inline-block;vertical-align: middle;margin:0 .3rem; }

		/*html没有字号 ,写max-width:18.75不管用*/
		@media (min-width: 768px) {
			html{ font-size: 20px !important;}
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
<body>

	<div class="bg">
		<!-- <div class="font-c">
			邀请卡
		</div>
 -->
		<!-- <img src="/images/zt/fenxiang/fx-img.png" alt=""> -->
		<img src="{{$src}}" alt="">

		{{--<p><i></i>长按上图保存图片，或发送给朋友<i></i></p>--}}
	</div>
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">

</script>
</html>
