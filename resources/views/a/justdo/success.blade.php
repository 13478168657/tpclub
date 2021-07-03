<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>报名成功</title>
    <meta name="author" content="络绎" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" href="/lib/jqweui/css/weui.min.css" />
    <link rel="stylesheet" href="/lib/jqweui/css/jquery-weui.css" />
    <link rel="stylesheet" href="/css/reset.css" />
    <link rel="stylesheet" href="/css/font-num40.css"/>
    <link rel="stylesheet" href="/css/zt/zt_just_do_it_form.css">
    <script src="/js/rem.js" type="text/javascript"></script>
</head>

<body ontouchstart>
<!-- 头部 start -->
<div class="fixed_bar_top">
    <header class="max750">
        <a href="javascript:history.go(-1);" class="btn_back"></a>
        <h1>报名成功</h1>
    </header>
</div>
<!-- 头部 end -->

<!-- 报名成功页 start -->
<div class="page_success_reg plr30 text_center">
    <h2 class=" bold">恭喜你报名成功</h2>
    <p class="mt30 f30">获得后续评选结果<br />需关注【赛普健身社区】</p>
    <!-- 关注 start -->
    <div class="follow">
        <dl>
            <dt><img src="/images/zt/just_do_it/logo.png" alt="赛普健身社区" class="logo" /></dt>
            <dd class="f34 bold">赛普健身社区</dd>
        </dl>
        <div class="plr30 pt10 pb10">
            <a href="#" class="btn1">查看</a>
            <span class="btn1 btn_follow">关注</span>
        </div>
        <div class="plr30 pt10 pb10">
            <span class="btn1 mt10 f28">为自己拉票跳过初选直接进入最终面试</span>
        </div>
    </div>
    <!-- 关注 end -->
</div>
<!-- 报名成功页 end -->


<br><br><br /><br />

<!-- 底部固定导航 start -->
<div class="fixed_bar_bottom">
    <ul class="clearfix nav max750">
        <li>
            <a href="#">首页</a>
        </li>
        <li>
            <a href="#">投票</a>
        </li>
        <li>
            <a href="#">排行榜</a>
        </li>
    </ul>
</div>
<!-- 底部固定导航 end -->

<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('.btn_follow').click(function () {
            layer.confirm(
                    '<div class="guanzhu"><p>是否关注该公众号</p><div class="logo"><img src="../images/logo.png" /><span>赛普健身社区</span></div></div>', {
                        title: false,
                        skin: 'layer_confirm_roy',
                        closeBtn: 0,
                        btn: ['取消', '关注'] //按钮
                    },
                    function () {
                        layer.closeAll()
                    },
                    function () {
                        layer.msg('关注了');
                    });
        })
    })
</script>



</body>
</html>