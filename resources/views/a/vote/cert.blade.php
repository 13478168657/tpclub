<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>我的证书</title>
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/font-num40.css">
    <link rel="stylesheet" href="/css/credit_hour.css">
    <script src="/js/rem.js"></script>
</head>
<body>
<div class="credit_hour_box">
    @if($img_src==0)
    <!-- 为空 start -->
    <div class="max_none hide">
    @else
    <div class="max_none">
    @endif    
        <!-- 标题 -->
        <h2 class="lt f55 color_000 opt9 plr65 mt56">我的证书</h2>
        <div class="credit_none text_center">
            <img src="/images/vote/credit_none.png" alt="我是空白图" class="img100">
            <span class="block fz f26 mt50">抱歉！</span>
            <span class="block fz f26 mb66 mt20">您还没有证书</span>
            <a href="javascript:void (0)" class="block fz f30 color_fff border-radius2">返回</a>
        </div>
    </div>
    <!-- 为空 end -->
    
    <!-- 我的证书 start 【为空时暂时隐藏我的证书】-->
    <div class="credit_cert">
        <img src="/{{$img_src}}" alt="精英健身教练训练营结业证书" class="img100">
        <p class="fz f24 text_center pt30">长按图片保存到相册</p>
    </div>
    <!-- 我的证书 end -->
    
</div>

<br><br><br>
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script>


</script>
</body>
</html>