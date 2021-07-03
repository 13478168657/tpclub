<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-参加的打卡课程</title>
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
    <script src="/js/jquery-1.11.2.min.js"></script>
    <script src="/js/jquery.SuperSlide.2.1.1.js" type="text/javascript"></script>
    <!--本css-->
    <link rel="stylesheet" href="/css/fenxiaoliucheng.css" >


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
    <div class="daka_kecheng text_center mb30 bgcolor_gray">
        <ul class="clearfix fz f28 color_gray999">
            <li class="fl"><a href="javascript:void (0)">已报名课程</a></li>
            <li class="fr on"><a href="javascript:void (0)">参加的打卡课程</a></li>
        </ul>
    </div>
    <!--====================================本喵是分割线  喵喵~========================================================-->
    <div class="mlr30">
        <div class="">
            <ul>
                <li class="mb30">
                    <div class="fenxiaochanpin fenxiaochanpin_no_btn relative border-radius-img">
                       <img src="/images/fenxiaoliucheng/fimg1.png" alt="" class="fenimg_img">
                        <div class="fen_img text_center fz color_fff">
                            <h3 class="f32 bold">14天训练让你回归S码</h3>
                            <p class="f26">减脂  打卡  有氧  可坚持</p>
                        </div>
                    </div>
                </li>
                @foreach($disStudy as $dis)
                <li class="mb30">
                    <div class="fenxiaochanpin fenxiaochanpin_no_btn relative border-radius-img">
                        <a href="">
                            <img src="{{env('IMG_URL')}}{{$dis->cover_url}}" alt="" class="fenimg_img">
                            <div class="fen_img text_center fz color_fff">
                                <h3 class="f32 bold">{{$dis->title}}</h3>
                            </div>
                        </a>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

    </div>

    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--====================================本喵是分割线  喵喵~========================================================-->
</div><!--导航大盒子id=page 结束-->



<br><br>
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->

<script>

</script>
</body>
</html>
