<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>NASM-CPT认证私人教练课程-资格</title>
    <meta name="author" content="涵" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" >

    <!--本css-->
    <link rel="stylesheet" href="/css/zt/zt_nasm.css?t=1.0">

    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
</head>
<body>
<div>
    <!-- nav start-->
    <img src="/images/zt/nasmcpt/nav.jpg" alt="NASM-CPT认证私人教练课程">
    <!-- nav end-->
    <!-- banner start-->
    <div class="banner">
        <img src="/images/zt/nasmcpt/pub_tit.jpg" alt="">
    </div>
    <!-- banner end-->
    <!--不符合资格 start-->
    @if($satisfy == 0)
    <div class="fuhe">
        <div class="form bg_fuhe fz color_333 f24 text_center">
            <div class="">
                <p class="lt color_redff3000 f54 mb30">十分抱歉</p>
                <p class="fz color_gray666 f28">您不是赛普在校生</p>
                <p class="fz color_gray666 f28">需要获取赛普学籍后才能</p>
                <p class="fz color_gray666 f28">4700元学NASM</p>
            </div>
            <div class="mlr68">
                <button class="form_btn border-radius-img bgcolor_orange color_333 lt f30 mt44"><a href="/nasm/access.html">获取赛普学籍</a><img src="/images/zt/nasmcpt/zhua.png" alt=""></button>
            </div>
        </div>
    </div>
    @endif
    <!--不符合资格 end-->
    <!--符合资格 start-->
    @if($satisfy == 1)
    <div class="fuhe">
        <div class="form bg_fuhe fz color_333 f24 text_center">
            <div class="">
                <p class="lt color_redff3000 f54 mb40">恭喜恭喜</p>
                <p class="fz color_gray666 f32">您符合4700元学NASM资格</p>
            </div>
            <div class="mlr68 mt20">
                <button class="form_btn border-radius-img bgcolor_orange color_333 lt f30"><a href="/course/detail/58.html">前往报名</a><img src="/images/zt/nasmcpt/zhua.png" alt=""></button>
            </div>
        </div>
    </div>
    @endif
    <!--符合资格 end-->
    <!-- 底部 start-->
    <div class="foot foot_btn text_center">
        <ul>
            <li><a href="javascript:void (0)" class="block color_fff f26 fz">4700元学NASM活动截止时间：2019年12月5日</a></li>
        </ul>
    </div>
    <!-- 底部 end-->
</div>


<br><br><br>
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script>

</script>
</body>
</html>
