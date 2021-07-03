<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-长按识别二维码</title>
    <meta name="author" content="啾啾" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <!--mmenu.css start-->
    <link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
    <link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
    <link href="/css/nav-mmenu-public.css" rel="stylesheet" />
    <!--end-->
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" />
    <!--本css-->
    <link rel="stylesheet" href="/css/fenxiaoliucheng_clock.css" >


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
                <li><a href="javascript:history.go(-1);">返回</a></li>
            </ul>
        </div>
    </nav>
    <!--头部导航 end-->

    <!--====================================本喵是分割线  喵喵~========================================================-->
    <div>
        <div class="relative pt105">
            <div class="mlr70 border-radius-img text_center fz tou">
                <div class="sm-text f28 color_fff bold pt105 pb136">
                    <p>为了能够保证您每天的打卡成功</p>
                    <p>请您关注公众号</p>
                    <p>获得每日课程打卡提醒</p>
                </div>
                <img src="/images/clock/changan.jpg" alt="">
                <img src="/images/discode.png" alt="" class="qr-da-img">
                <div class="bgcolor_fff qr-da-btn pb136">
                    <p class="bold color_333 border-radius50 bgcolor_orange f29">长按识别二维码</p>
                </div>
            </div>
        </div>
    </div>

    <!--====================================本喵是分割线  喵喵~========================================================-->

</div><!--导航大盒子id=page 结束-->
<br><br>
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->

<script>
    //给body单独加背景颜色
    $('body').css('background','#fdf3cc');

</script>
</body>
</html>
