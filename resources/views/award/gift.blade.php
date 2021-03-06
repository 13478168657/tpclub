<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-我获得的奖品</title>
    <meta name="author" content="啾啾" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/activity/award/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/activity/award/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <!--mmenu.css start-->
    <link href="/activity/award/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
    <link href="/activity/award/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
    <link href="/activity/award/css/nav-mmenu-public.css" rel="stylesheet" />
    <!--end-->
    <link href="/activity/award/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/activity/award/css/font-num40.css" rel="stylesheet" >

    <!--本css-->
    <link rel="stylesheet" href="/activity/award/css/zt/zt_giftgive.css">

    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
</head>
<body class="bg-eee">

<div>
    <!--==============================本喵是分割线 喵喵~==================================================-->
    <!--头部导航 start-->
    <div class="f-nav bg-eee">
        <ul class="clearfix text_center fz f26">
            <li><a href="/share/friend">领取奖学金的好友</a></li>
            <li><a href="/share/rank/list">送礼竞赛排行榜</a></li>
            <li><a href="/share/my/gift" class="active">我获得的奖品</a></li>
        </ul>
    </div>
    <!--头部导航 end-->
    <!--==============================本喵是分割线 喵喵~==================================================-->
    <div  class="plr30">
        <div class="Get-list">
            <ul>
                <li class="mb20 fuliyouxuan">
                    <img src="/activity/award/images/zt/giftgive/Gwyj.jpg" alt="">
                </li>
                <?php
                    if(time() > $awardTime){
                        $flag = 1;
                    }else{
                        $flag = 0;
                    }
                    $userRank = $total+1;
                ?>
                <li class="mb20 relative">

                    @if($flag)
                        <img src="/activity/award/images/zt/giftgive/G3800.jpg" alt="">
                        @if($userRank == 1)
                            <span class="d-in-black pspan text_center color_fff bg-ec313d f26 fz bold shequhuojiang">领取</span>
                        @else
                            <span class="d-in-black pspan text_center color_fff bg-bfbfbf f26 fz bold">未中奖</span>
                        @endif
                    @else
                        <img src="/activity/award/images/zt/giftgive/G3800.jpg" alt="">
                    @endif
                    {{--<span class="d-in-black pspan text_center color_fff bg-bfbfbf f26 fz bold">未中奖</span>--}}
                </li>

                <li class="mb20 relative">
                    @if($flag)
                        <img src="/activity/award/images/zt/giftgive/G489.jpg" alt="">
                        @if($userRank >= 2 && $userRank <= 6)
                            <span class="d-in-black pspan text_center color_fff bg-ec313d f26 fz bold shequhuojiang">领取</span>
                        @else
                            <span class="d-in-black pspan text_center color_fff bg-bfbfbf f26 fz bold">未中奖</span>
                        @endif
                    @else
                        <img src="/activity/award/images/zt/giftgive/G489.jpg" alt="">
                    @endif

                </li>
                <li class="mb20 relative">
                    @if($flag)
                        <img src="/activity/award/images/zt/giftgive/G239.jpg" alt="">
                        @if($userRank >= 7 && $userRank <= 16)
                            <span class="d-in-black pspan text_center color_fff bg-ec313d f26 fz bold shequhuojiang">领取</span>
                        @else
                            <span class="d-in-black pspan text_center color_fff bg-bfbfbf f26 fz bold">未中奖</span>
                        @endif
                    @else
                        <img src="/activity/award/images/zt/giftgive/G239.jpg" alt="">
                    @endif
                </li>
                <li class="mb20 relative">
                    @if($flag)
                        <img src="/activity/award/images/zt/giftgive/G119.jpg" alt="">
                        @if($userRank >= 17 && $userRank <= 36)
                            <span class="d-in-black pspan text_center color_fff bg-ec313d f26 fz bold shequhuojiang">领取</span>
                        @else
                            <span class="d-in-black pspan text_center color_fff bg-bfbfbf f26 fz bold">未中奖</span>
                        @endif
                    @else
                        <img src="/activity/award/images/zt/giftgive/G119.jpg" alt="">
                    @endif
                </li>
                <li class="mb20 relative">
                    @if($flag)
                        <img src="/activity/award/images/zt/giftgive/G49.jpg" alt="">
                        @if($userRank >= 37 && $userRank <= 100)
                            <span class="d-in-black pspan text_center color_fff bg-ec313d f26 fz bold shequhuojiang">领取</span>
                        @else
                            <span class="d-in-black pspan text_center color_fff bg-bfbfbf f26 fz bold">未中奖</span>
                        @endif
                    @else
                        <img src="/activity/award/images/zt/giftgive/G49.jpg" alt="">
                    @endif
                </li>
            </ul>
        </div>
    </div>
    <!--==============================本喵是分割线 喵喵~==================================================-->
    <!--免费送礼给好友 start-->
    <div class="relative">
        <div class="footer footer-dit">
            <ul class="text_center f28 fz bold">
                <li class="bg-ec313d"><a onclick="getAward();">免费送礼给好友</a></li>
            </ul>
        </div>
    </div>
    <!--免费送礼给好友 end-->
    <!--==============================本喵是分割线 喵喵~==================================================-->
    <!--==============================本喵是分割线 喵喵~==================================================-->
    <!--==============================本喵是分割线 喵喵~==================================================-->


</div>


<br><br>

<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/layer/layer.js"></script>

<script>
    $(function (){
        //弹窗[赋力优选]
        $('.fuliyouxuan').click(function(){
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'get_success_layer_wrap', //样式类名
                id: 'get_success_layer', //设定一个id，防止重复弹出
                closeBtn: 1, //不显示关闭按钮
                anim: 2,
                shadeClose: true, //开启遮罩关闭
                area: ['80%', '70%'],
                content:'<div class="get_success_layer text_center"><div class=" mt70 pt40"><img src="/activity/award/images/zt/giftgive/fuliyoupin.jpg" class="bm_success" alt="" /><div><p class="lt bold color_333 f32 mt26">扫描小程序二维码</p><p class="lt bold color_333 f32 mt10">进商城领取优惠券</p></div></div>',
                btn:false
            });
        });


        //弹窗[社区提问]
        $('.shequtiwen').click(function(){
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'get_success_layer_wrap', //样式类名
                id: 'get_success_layer', //设定一个id，防止重复弹出
                closeBtn: 1, //不显示关闭按钮
                anim: 2,
                shadeClose: true, //开启遮罩关闭
                area: ['80%', '70%'],
                content:'<div class="get_success_layer text_center"><div class=" mt70 pt40"><img src="/activity/award/images/zt/giftgive/shequtiwen.jpg" class="bm_success" alt="" /><div><p class="lt bold color_333 f32 mt26">对活动有疑问</p><p class="lt bold color_333 f32 mt10">可入群询问群管理员</p></div></div>',
                btn:false
            });
        });


        //弹窗[社区领奖]
        $('.shequhuojiang').click(function(){
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'get_success_layer_wrap', //样式类名
                id: 'get_success_layer', //设定一个id，防止重复弹出
                closeBtn: 1, //不显示关闭按钮
                anim: 2,
                shadeClose: true, //开启遮罩关闭
                area: ['80%', '70%'],
                content:'<div class="get_success_layer text_center"><div class=" mt70 pt40"><img src="/activity/award/images/zt/giftgive/shequhuojiang.jpg" class="bm_success" alt="" /><div><p class="lt bold color_333 f32 mt26">呀吼~恭喜获奖！</p><p class="lt bold color_333 f32 mt10">入群联系群管理员领奖</p></div></div>',
                btn:false
            });
        });


        //弹窗[社区海报]
        $('.shequhaibao').click(function(){
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'hb_success_layer_wrap', //样式类名
                id: 'hb_success_layer', //设定一个id，防止重复弹出
                closeBtn: 1, //不显示关闭按钮
                anim: 2,
                shadeClose: true, //开启遮罩关闭
                area: ['80%', '90%'],
                content:'<div class="bm_success_layer text_center tan-font color_fff fz f22"><img src="/activity/award/images/zt/giftgive/shequhaibao.jpg" class="bm_success" alt="" />─ 长按保存图片发送给好友 ─</div>',
                btn:false
            });
        });


        //弹窗[红包]
        $('.linghongbao').click(function(){
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'hongbao_success_layer_wrap', //样式类名
                id: 'hongbao_success_layer', //设定一个id，防止重复弹出
                closeBtn: 1, //不显示关闭按钮
                anim: 2,
                shadeClose: true, //开启遮罩关闭
                area: ['80%', '90%'],
                content:'<div class="bm_success_layer text_center tan-font color_fff fz f22 relative"><img src="/activity/award/images/zt/giftgive/bg-hongbao.png" class="bm_success " alt="" /><div class="hb-p"><p class="f32">白白汤圆</p><p class="f34 bold mt10">送你一个奖学金红包</p></div></div>',
                btn:false
            });
        });

    })

    localStorage.setItem('redirect','/share/my/gift');
    function getAward(){
        var data = {_token:'{{csrf_token()}}'};
        $.ajax({
            url:"/share/make/card",
            data:data,
            type:'POST',
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    layer.open({
                        type: 1,
                        title: false, //不显示标题栏
                        skin: 'hb_success_layer_wrap', //样式类名
                        id: 'hb_success_layer', //设定一个id，防止重复弹出
                        closeBtn: 1, //不显示关闭按钮
                        anim: 2,
                        shadeClose: true, //开启遮罩关闭
                        area: ['80%', '90%'],
                        content:res.data,
                        btn:false
                    });
                }else{
                    layer.msg(res.message);
                    window.location.href='/register';
                }
            }
        });
    }
</script>
<!-- GrowingIO Analytics code version 2.1 -->
<!-- Copyright 2015-2018 GrowingIO, Inc. More info available at at http://www.growingio.com -->

<script type='text/javascript'>
    !function(e,t,n,g,i){e[i]=e[i]||function(){(e[i].q=e[i].q||[]).push(arguments)},n=t.createElement("script"),tag=t.getElementsByTagName("script")[0],n.async=1,n.src=('https:'==document.location.protocol?'https://':'http://')+g,tag.parentNode.insertBefore(n,tag)}(window,document,"script","assets.growingio.com/2.1/gio.js","gio");
    gio('init','aef8110bebdb6dd5', {});
    //custom page code begin here
    //custom page code end here
    gio('send');
</script>

<!-- End GrowingIO Analytics code version: 2.1 -->
</body>
</html>
