@extends('layouts.header')
@section('title')
    <title>新学期充电福利 助你钱途无量（好友人数）</title>
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/newyear_reset.css">
    <link rel="stylesheet" href="/css/newyear_index.css">


    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth/18.75 + "px";
        })()
        @if($userid == 7149)
           alert("来晚啦 礼品已被领光");
            setTimeout("location.href='/'",0);
        @endif
    </script>
    <script>
        var ua = navigator.userAgent.toLowerCase();
        var isWeixin = ua.indexOf('micromessenger') != -1;
        if (!isWeixin) {
           // window.location.href = "http://m.saipubbs.com/newyear/erweima.html"
        }
    </script>
    <script src="/js/jquery.SuperSlide.2.1.1.js"></script>
    <body class="bg_da463c">

@endsection

@section('content')

</head>

<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->


    <div class="banner">
        <div class="banner1 relative">
            <img src="/images/new_year/banner1.jpg" alt="">
            <a href="/newyear/rule.html" class="block color_7a4300 bg_e7a14c f28 text_center sy_m btn_com">奖励规则</a>
        </div>
        <div class="banner2 relative">
            <img src="/images/new_year/banner2.jpg" alt="">
            <a href="javascript:void();" target="_blank" class="block color_fff bg_c93126 text_center sy_r f34 border-radius60">邀请好友 / 马上领以下福利</a>
        </div>
        <img src="/images/new_year/banner3.jpg" alt="">
        <img src="/images/new_year/banner4.jpg" alt="">
    </div>
    
    <!-- 福利一 start -->
    <div class="welfare_wrap relative">
        <div class="welfare_top">
            <h2 class="f36 sy_m bg_e7a14c color_7a4300 border-radius60 text_center">•&nbsp;&nbsp;&nbsp;福利一&nbsp;&nbsp;&nbsp;•</h2>
        </div>
        <div class="border-radius-img bgcolor_fff mlr30">
            <div class="jiang"><img src="/images/new_year/praise.png" alt=""></div>
            <div class="welfare">
                @if($userid !== 0)
                    <?php
                        $c_num = DB::table("activity_team")->where("userid",$userid)->where("aid",1)->count();
                    ?>
                    <p class="color_cb7d1d f28 sy_r get text_right">还差&nbsp;<span class="f59">{{3-$c_num}}</span>&nbsp;位好友即可领取</p>
                @else

                    <p class="color_cb7d1d f28 sy_r get text_right">还差&nbsp;<span class="f59">3</span>&nbsp;位好友即可领取</p>
                @endif
                <div class="video-wrap mt26 mb40">
                    <div class="con">
                        <div class="video">
                             <div class="box2">
                                <div class="thumb color_fff box2_txt text_center">
                                    <p class="f36 sy_m">福利课程：运动训练基础课程</p>
                                    <p class="f28 sy_r">健身菜鸟的福音 教你最科学的健身方法</p>
                                </div>                                                       
                             </div>
                            <video src="http://v.saipubbs.com/何翔宇/1-1基础解剖语言：学习解剖的意义.mp4" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto"></video>
                          </div>
                     </div>
                </div>
                <a href="/newyear/class/24/1.html?fission_id={{$fission_id}}" class="block color_7a4300 bg_e7a14c f36 text_center sy_m border-radius60 mb30 pt20 pb20">邀请3位好友 免费领取</a>
                <p class="f24 color_cb7d1d text_center mb100">从此页面邀请，才可领取任务奖励哦~</p>
            </div>
        </div>
        <a href="" target="_blank" class="block color_7a4300 bg_e7a14c f20 text_center sy_r btn_com btn_b">向下拖更多福利</a>
    </div>
    <!-- 福利一 end -->
    
    <!-- 福利二 start -->
    <div class="welfare2_wrap plr30">
        <div class="clearfix title mb30">
            <p class="color_fff f32 sy_m fl">•&nbsp;&nbsp;&nbsp;福利二&nbsp;&nbsp;&nbsp;•</p>
            @if($userid !== 0)
                <?php
                $c_num = DB::table("activity_team")->where("userid",$userid)->where("aid",2)->count();
                ?>
                <a href="javascript:void();" target="_blank" class="block color_fff bg_c93126 text_center sy_r f24 border-radius60 fr">还差&nbsp;<span class="f50">{{5-$c_num}}</span>&nbsp;位好友即可领取</a>
            @else

                <a href="javascript:void();" target="_blank" class="block color_fff bg_c93126 text_center sy_r f24 border-radius60 fr">还差&nbsp;<span class="f50">5</span>&nbsp;位好友即可领取</a>
            @endif
        </div>
        <div class="border-radius-img bg_e15347 text_center welfare2">
            <div class="jiang"><img src="/images/new_year/praise.png" alt=""></div>
            <div class="welfare2_txt">
                <p class="color_fff f38 xy_r mb30">现金福利&nbsp;<span class="f66 xy_m">20元</span>&nbsp;红包</p>
                <p class="bg_ed9891 border-radius60 color_c93126 f28 pt10 pb10">赛普社区祝您猪年财源滚滚</p>
            </div>
        </div>
        <div class="mlr30">
            <a href="/newyear/gift/2.html?fission_id={{$fission_id}}"  class="yao block color_7a4300 bg_ffd5b4 f36 text_center sy_m border-radius60 mb30 pt20 pb20">邀请5位好友 免费领取</a>
            {{--<a href="javascript:;" onclick = "layer.msg('来晚啦 礼品已被领光!');"  class="yao block color_7a4300 bg_ffd5b4 f36 text_center sy_m border-radius60 mb30 pt20 pb20">邀请5位好友 免费领取</a>--}}

        </div>
        <p class="f24 text_center ling">从此页面邀请，才可领取任务奖励哦~</p>
    </div> 
    <!-- 福利二 end -->

    <!-- 福利三 start -->
    <div class="welfare2_wrap plr30">
        <div class="clearfix title mb30">
            <p class="color_fff f32 sy_m fl">•&nbsp;&nbsp;&nbsp;福利三&nbsp;&nbsp;&nbsp;•</p>
            @if($userid !== 0)
                <?php
                $c_num = DB::table("activity_team")->where("userid",$userid)->where("aid",3)->count();
                ?>
                <a href="javascript:void();" target="_blank" class="block color_fff bg_c93126 text_center sy_r f24 border-radius60 fr">还差&nbsp;<span class="f50">{{5-$c_num}}</span>&nbsp;位好友即可领取</a>
            @else

                <a href="javascript:void();" target="_blank" class="block color_fff bg_c93126 text_center sy_r f24 border-radius60 fr">还差&nbsp;<span class="f50">5</span>&nbsp;位好友即可领取</a>
            @endif
        </div>
        <div class="border-radius-img bgcolor_fff">
            <div class="jiang"><img src="/images/new_year/praise.png" alt=""></div>
            <div class="award_yujia text_center">                       
                <div class="award_img1 pb30"><img src="/images/new_year/award_img1.jpg" alt=""></div>
                <p class="f40 sy_b color_7a4300 mb30">奖品福利：价值69元的瑜伽垫</p>
                <?php
                $act3_num = DB::table("activity_sponsor")->where("aid",3)->where("is_get",1)->limit($act3)->count();
                ?>
                <p class="f28 sy_m color_7a4300 mb30 pb30">──&nbsp;&nbsp;奖品还剩{{$act3-$act3_num}}份，先到先得哦&nbsp;&nbsp;──</p>
                <a href="/newyear/gift/3.html?fission_id={{$fission_id}}" class="block color_7a4300 bg_e7a14c f36 text_center sy_m border-radius60 mb30 pt20 pb20">邀请5位好友 免费领取</a>
                <p class="f24 color_cb7d1d text_center mb80">从此页面邀请，才可领取任务奖励哦~</p>
            </div>
        </div>
    </div> 
    <!-- 福利三 end -->

    <!-- 福利四 start -->
    <div class="welfare2_wrap plr30">
        <div class="clearfix title mb30">
            <p class="color_fff f32 sy_m fl">•&nbsp;&nbsp;&nbsp;福利四&nbsp;&nbsp;&nbsp;•</p>
            @if($userid !== 0)
                <?php
                $c_num = DB::table("activity_team")->where("userid",$userid)->where("aid",4)->count();
                ?>
                <a href="javascript:void();" target="_blank" class="block color_fff bg_c93126 text_center sy_r f24 border-radius60 fr">还差&nbsp;<span class="f50">{{15-$c_num}}</span>&nbsp;位好友即可领取</a>
            @else

                <a href="javascript:void();" target="_blank" class="block color_fff bg_c93126 text_center sy_r f24 border-radius60 fr">还差&nbsp;<span class="f50">15</span>&nbsp;位好友即可领取</a>
            @endif
        </div>
        <div class="border-radius-img bgcolor_fff">
            <div class="jiang"><img src="/images/new_year/praise.png" alt=""></div>
            <div class="award_yujia text_center">                       
                <div class="award_img1 pb30"><img src="/images/new_year/award_img2.jpg" alt=""></div>
                <p class="f40 sy_b color_7a4300 mb30">奖品福利：价值99多功收腹机</p>
                <?php
                $act4_num = DB::table("activity_sponsor")->where("aid",4)->where("is_get",1)->limit($act4)->count();
                ?>
                <p class="f28 sy_m color_7a4300 mb30 pb30">──&nbsp;&nbsp;奖品还剩{{$act4-$act4_num}}份，先到先得哦&nbsp;&nbsp;──</p>


                <a href="/newyear/gift/4.html?fission_id={{$fission_id}}"  class="block color_7a4300 bg_e7a14c f36 text_center sy_m border-radius60 mb30 pt20 pb20">邀请15位好友 免费领取</a>
                <p class="f24 color_cb7d1d text_center mb80">从此页面邀请，才可领取任务奖励哦~</p>
            </div>
        </div>
    </div> 
    <!-- 福利四 end -->

    <!-- 福利五 start -->
    <div class="welfare2_wrap plr30">
        <div class="clearfix title mb30">
            <p class="color_fff f32 sy_m fl">•&nbsp;&nbsp;&nbsp;福利五&nbsp;&nbsp;&nbsp;•</p>
            @if($userid !== 0)
                <?php
                $c_num = DB::table("activity_team")->where("userid",$userid)->where("aid",5)->count();
                ?>
                <a href="javascript:void();" target="_blank" class="block color_fff bg_c93126 text_center sy_r f24 border-radius60 fr">还差&nbsp;<span class="f50">{{25-$c_num}}</span>&nbsp;位好友即可领取</a>
            @else

                <a href="javascript:void();" target="_blank" class="block color_fff bg_c93126 text_center sy_r f24 border-radius60 fr">还差&nbsp;<span class="f50">25</span>&nbsp;位好友即可领取</a>
            @endif
        </div>
       <div class="border-radius-img bgcolor_fff">
            <div class="jiang"><img src="/images/new_year/praise.png" alt=""></div>
            <div class="award_yujia text_center">
                <div class="award_img1 pb30"><a href="http://v.saipubbs.com/%E6%96%B0%E5%B9%B4%E6%B4%BB%E5%8A%A8/%E9%80%81%E5%A4%A7%E7%A4%BC/%E6%8B%9C%E5%B9%B4+%E6%BC%94%E7%A4%BA.mp4"><img src="/images/new_year/award_img3.jpg" alt=""></a></div>
                <p class="f40 sy_b color_7a4300 mb30">奖品福利：价值100元的京东卡</p>
                <p class="f28 sy_m color_7a4300 mb30 pb30">──&nbsp;&nbsp;活动领取详情 请点上方视频&nbsp;&nbsp;──</p>
                <?php

                ?>
                <!--<a href="javascript:;"  class="block color_7a4300 bg_e7a14c f36 text_center sy_m border-radius60 mb30 pt20 pb20 yao_last">邀请25位好友 免费领取</a>-->
                {{--<a href="/newyear/gift/5.html?fission_id={{$fission_id}}"  class="block color_7a4300 bg_e7a14c f36 text_center sy_m border-radius60 mb30 pt20 pb20">邀请25位好友 免费领取</a>--}}
                <a href="javascript:;" onclick = "layer.msg('来晚啦 礼品已被领光!');"   class="block color_7a4300 bg_e7a14c f36 text_center sy_m border-radius60 mb30 pt20 pb20">邀请25位好友 免费领取</a>

                <p class="f24 color_cb7d1d text_center mb80">从此页面邀请，才可领取任务奖励哦~</p>
            </div>
        </div>
    </div> 
    <!-- 福利五 end -->

    <!-- 固定底部 start-->
    {{--<div class="fixed_wrap">--}}
        {{--<ul class="clearfix sy_m f28 text_center">--}}
            {{--<li class="color_333"><a href="javascript:;">邀请好友助力</a></li>--}}
            {{--<li class="color_333"><a href="javascript:;">领取福利</a></li>--}}
        {{--</ul>--}}
    {{--</div>--}}
    <!-- 固定底部 end-->

    <!-- 微信 start -->
    <div class="code zixunBtn">
        <a href="javascript:void(0)" class="f20 color_000 sy_m bgcolor_fff">
            <img class="service-icon" src="/images/new_year/weixin.png" alt="">
            微信咨询
        </a>
    </div>
    <!-- 微信 end -->
</div>


<script src="/lib/jqweui/js/jquery-weui.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->
<script type="text/javascript">
    window.onload = function(){
        menuFixed('nav_keleyi_com');
    }
</script> 

<script>
//播放视频
$(function (){
    //播放视频
    $('.con .video .box2').click(function(){
        $(this).hide();
        /*//首页下点击图片播放的id  //教师下点击图片播放的id
        document.getElementById('video').play();*/
    })
})
$(document).ready(function(){
    $(".thumb").click(function(){
        $(this).parent().next().trigger('play');
    });
});
//点击其中一个播放时，其他的停止播放
// 获取所有video
var videoclose = document.getElementsByTagName("video");
// 暂停函数
function pauseAll() {
    var self = this;
    [].forEach.call(videoclose, function (i) {
        // 将video中其他的video全部暂停
        i !== self && i.pause();
    })
}
// 给play事件绑定暂停函数
[].forEach.call(videoclose, function (i) {
    i.addEventListener("play", pauseAll.bind(i));
})

/*最后一个福利*/
$('.yao_last').click(function(){
    layer.msg("兄弟别急，2月4日0:00点 来领红包哦~");
})
//微信弹窗
$(function (){
    $('.zixunBtn').click(function(){
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'bm_success_layer_wrap', //样式类名
            id: 'bm_success_layer', //设定一个id，防止重复弹出
            closeBtn: 1, //不显示关闭按钮
            anim: 2,
            shadeClose: true, //开启遮罩关闭
            area: ['100%', '100%'],

           /* content:'<div class="bm_success_layer text_center tan-font"><div class="mt30 pt20"><p class="sy_r bold f32 color_333">扫码加入健身福利群<br />免费领更多福利</p><img src="/images/new_year/code.jpg" class="bm_success" alt="" /><p class=" sy_r color_333 f26">扫码入群<br />活动问题都可在群内提出<br />美女小姐姐会为你耐心解答的~<br />更多健身干货，奖品福利<br />帅哥美女尽在这里，等你来撩~<br /></p></div>',*/

            content:'' +
            '<div class="bm_success_layer text_center">' +
            '<div class="mt40 pt40 plr20">' +
            '<p class="color_333 f32 sy_m bold">扫码加入健身福利群<br />免费领更多福利</p>' +
            '<img src="/images/new_year/code.jpg" class="bm_success" alt="" />' + 
            '<p class="sy_m color_333 f26 mt40 sao">扫码入群<br />活动问题都可在群内提出<br />美女小姐姐会为你耐心解答的~<br />更多健身干货，奖品福利<br />帅哥美女尽在这里，等你来撩~</p>' +
            '</div>' +
            '</div>',
            btn:false
        });
    })
})



</script>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>

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
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: '新学期充电福利 助你钱途无量', // 分享标题 newyear/gifthelp/{uid}/{aid}.html
            desc: '', // 分享描述
            link: "http://m.saipubbs.com/newyear/index.html?fission_id={{$userid}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/new_year/banner2.jpg", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '新学期充电福利 助你钱途无量', // 分享标题
            link: "http://m.saipubbs.com/newyear/index.html?fission_id={{$userid}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/new_year/banner2.jpg", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });

    var fission_id = "{{$fission_id}}";
    if(fission_id>0){
        localStorage.setItem("fission_id", fission_id);
    }
</script>
@endsection

