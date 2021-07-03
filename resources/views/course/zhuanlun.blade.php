<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-转盘抽奖</title>
    <meta name="author" content="涵涵" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" href="/lib/jqweui/css/weui.min.css" type="text/css" />
    <link rel="stylesheet" href="/lib/jqweui/css/jquery-weui.min.css" type="text/css" />
    <!--mmenu.css start-->
    <link rel="stylesheet" href="/lib/mmenu/css/jquery.mmenu.all.css"/>
    <link rel="stylesheet" href="/lib/mmenu/css/jquery.mhead.css"/>
    <link rel="stylesheet" href="/css/nav-mmenu-public.css"/>
    <!--end-->
    <link rel="stylesheet" href="/css/reset.css" />
    <link rel="stylesheet" href="/css/font-num40.css">

    <link rel="stylesheet" href="/css/zt/zt_zhuanpan.css">
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
</head>
<body >

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
        <div class="text_center fz">
            <ul>
                <li><a href="javascript:void (0)">首页</a></li>
                <li><a href="javascript:void (0)">正在学习</a></li>
                <li><a href="javascript:void (0)">我的</a></li>
            </ul>
        </div>
    </nav>
    <!--头部导航 end-->

    <!--====================================本喵是分割线  喵喵~========================================================-->

    <div>
        <!-- 右侧悬浮 start-->
        <div class="right_browse_bg plr10">
            <div class="browse_jindutiao clearfix mt20">
                <div class="progress fl">
                    <div id="bar"></div>
                </div>
                <p class="fr color_fff f16 fz browse_time text_right"><span class="Time">10</span>s</p>
            </div>

            <p class="browse_txt color_fff f16 fz text_center">滑动浏览得<br>1次抽奖机会</p>
        </div>
        <!-- 右侧悬浮 end-->
    </div>

    <div class="height" data-attr="1" style="height: 2000px;"></div>


</div><!--导航大盒子id=page 结束-->

<br><br>
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<script>

    $(".height").one("touchmove",function(){
        var iSpeed = 1;
        var dataid = $(".height").attr("data-attr");
        if(dataid > 0){
            obj=setInterval(function(){
                iSpeed+=1;
                if(iSpeed>=100){    // 设置达到多少进度后停止
                    clearInterval(obj);
                    $(".height").attr("data-attr","0");
                }
                bar.style.width=iSpeed+'%';

            },96);// s后函数执行一次

            countDown();
        }
    })

    //使用匿名函数方法
    function countDown(){
        var time = $(".Time");
        var out= setTimeout(function() {
            countDown()
        },1000);

        //获取到id为time标签中的内容，现进行判断
        if(time.text() == 0){
            //等于0时清除计时
            clearTimeout(out);
            $(".browse_txt").html('已浏览完毕').css({"line-height":"1.3rem"});
            //alert("到时间啦");
        }else{
            time.text(time.text()-1);
        }
    }
</script>







