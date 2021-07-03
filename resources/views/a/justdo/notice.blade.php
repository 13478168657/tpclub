<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>获奖函</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    
    <link rel="stylesheet" href="/css/font-num40.css">
    <link rel="stylesheet" href="/css/reset.css">
    <style>
        /* 获奖通知函 */
        .notify_wrap{background: url('/images/zt/just_do_it/bg_img1.jpg')no-repeat center center;background-size: 100% 100%;padding:0 1.9rem 3.9rem 1.9rem;}
        .notify_wrap p{line-height: 1.15rem;}
        .notify_wrap p .name{padding:.1rem 0;background: none;width: 3.6rem;outline: none;border-bottom: 1px solid #000;border-top:none;border-right: none;border-left: none;-webkit-appearance:none;/*清除ios默认圆角*/border-radius:0;}
        .notify_wrap p input::-webkit-input-placeholder {/*Chrome/Opera/Safari*/color: #000;}
        .notify_wrap p input:-ms-input-placeholder{/*IE*/color:#000;}
        .notify_wrap p input::-moz-placeholder{/*Firfox*/color: #000;}
        .notify_wrap p:nth-child(2){text-indent: 2em;}

    </style>
     @include('layouts.baidutongji')
    <!-- <script src="js/jquery-1.11.2.min.js" type="text/javascript"></script> -->
	<script src="/js/rem.js" type="text/javascript"></script>
</head>
<body> 
<!-- banner start -->
<div class="banner">
    <img src="/images/zt/just_do_it/banner1.jpg" alt="" class="img100">
    <img src="/images/zt/just_do_it/banner2.jpg" alt="" class="img100">
    @if($is_have==1)
    <img src="/images/zt/just_do_it/banner3.jpg" alt="" class="img100">
    @else
    <img src="/images/zt/just_do_it/banner4.jpg" alt="" class="img100">
    @endif
</div>
<!-- banner end -->

<!-- 获奖通知函 start -->
<div class="notify_wrap fz">
    @if($is_have==1)
    <p class="f24 color_000">亲爱的赛普学员<input type="text" class="name text_center" value="{{$name}}" readonly="" />：</p>
    <p class="f24 color_000">
        恭喜您通过由赛普&耐克盛典携手打造的TRAIN TO WIN大奖选拔，获得<input type="text" class="name text_center" value="{{$identity}}" readonly="" />，您将免费获得耐克盛典门票、耐克大礼包，赛普也将持续为您提供课程、资金等各项赋能。领取方式、赋能方案将会与您进一步沟通，敬请期待。
    </p>
    @else
    <p class="f24 color_000">亲爱的赛普学员：</p>
    <p class="f24 color_000">
        请持续关注TRAIN TO WIN大奖，欢迎报名下一批TRAIN TO WIN，角逐管理精英奖、创业精英奖、明星教练奖。
    </p>
    @endif
    <div class="mt20 clearfix notify">
        <p class="text_right bold f25">赛普健身教练培训基地</p>
        <p class="text_right bold f20">2020年<?=date("m")?>月<?=date("d")?>日</p>
    </div>
</div>
<!-- 获奖通知函 end -->



</body>
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
    var title = 'TRAIN TO WIN获奖通知函';
    var desc = '2020年度TRAIN TO WIN大奖第一批选拔落下帷幕，快来查收你的获奖通知函吧！';
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
</html>