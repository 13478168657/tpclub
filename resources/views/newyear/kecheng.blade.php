@extends('layouts.header')
@section('title')
    <title>新学期充电福利-助你钱途无量(好友助力课程)</title>
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
    </script>
    <script src="/js/jquery.SuperSlide.2.1.1.js"></script>
    <script>
        var ua = navigator.userAgent.toLowerCase();
        var isWeixin = ua.indexOf('micromessenger') != -1;
        if (!isWeixin) {
            window.location.href = "http://m.saipubbs.com/newyear/erweima.html"
        }
        @if($userid == 7149)
           alert("来晚啦 礼品已被领光");
           setTimeout("location.href='/'",0);
        @endif
    </script>
@endsection

@section('content')
</head>
<body class="bg_da463c">
<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->
    
    <div class="banner">
        <img src="/images/new_year/pocket_banner.jpg" alt="">
    </div>
    
    <!-- 福利课程：4节课 马上从健身菜鸟变为为健身达人  start -->
    <div class="mlr30 pt40 pocket_wrap">
        <div class="pocket text_center yoga border-radius-img">
            <p class="bg_ffd5b4 border-radius60 color_da463c f26 pt20 pb20 sy_b">福利课程：4节课 马上从健身菜鸟变为为健身达人</p>
            <div class="mt70 mb30">
                <div class="video-wrap mt26 mb40">
                    <div class="con">
                        <div class="video">
                            <div class="box2">
                                <img src="/images/new_year/fu_ke.jpg" alt="" class="thumb">
                            </div>
                            <video src="http://v.saipubbs.com/何翔宇/1-1基础解剖语言：学习解剖的意义.mp4" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto"></video>
                          </div>
                     </div>
                </div>
            </div>
            <p class="color_7a4300 f40 sy_b pb20">原价59元 限时0元免费领取</p>
        </div>
    </div>
    <!-- 福利课程：4节课 马上从健身菜鸟变为为健身达人  end -->

    <!-- 列表 start -->
    <div class="mt30 mlr30 list bg_e16354 border-radius-img">
        <div class="bd">
            <ul class="f24 sy_r">
                <li class="clearfix">
                    <p class="fl text-overflow"> ID 大爷爱美女... </p>
                    <span class="fr text_right">领取该课程</span>
                </li>
                <li class="clearfix">
                    <p class="fl text-overflow">ID POWER 大型健身房教研总监... </p>
                    <span class="fr text_right">领取该课程</span>
                </li>
                <li class="clearfix">
                    <p class="fl text-overflow">ID 一个抑郁的产后妈妈 ... </p>
                    <span class="fr text_right">领取该课程</span>
                </li>
                          
                <li class="clearfix">
                    <p class="fl text-overflow"> ID 卡澜普拉提会馆创始人  ... </p>
                    <span class="fr text_right">领取该课程</span>
                </li>
                <li class="clearfix">
                    <p class="fl text-overflow">ID被孩他爸嫌弃的胖女神  ... </p>
                    <span class="fr text_right">领取该课程</span>
                </li>
                <li class="clearfix">
                    <p class="fl text-overflow"> ID 我要翘臀我要翘腿... </p>
                    <span class="fr text_right">领取该课程</span>
                </li>
                <li class="clearfix">
                    <p class="fl text-overflow">ID 蓝速尔大型瑜伽会馆创始人... </p>
                    <span class="fr text_right">领取该课程</span>
                </li>
                <li class="clearfix">
                    <p class="fl text-overflow">ID 健身牛的不行私教教练 ... </p>
                    <span class="fr text_right">领取该课程</span>
                </li>

            </ul>
        </div>
        <script type="text/javascript">
            jQuery(".list").slide({mainCell:".bd ul",autoPage:true,effect:"topLoop",autoPlay:true,vis:3,mouseOverStop:false});
        </script>
    </div>
    <!-- 列表 end -->
    
    <!-- 距离活动结束还有 start -->
    <div class="distance plr30">
        <p class="color_fff f66 sy_m dis_title plr30 mb40">•&nbsp;距离活动结束还有&nbsp;•</p>
        <div class="color_fff bg_c93126 border-radius60 pt10 pb10 text_center conton">
            <p class="f32 sy_r">距离任务结束还有</p>
            <p class="f32 sy_r"><span class="f60" id="_d" >05</span>天</p >
            <p class="f32 sy_r"><span class="f60" id="_h" >05</span>小时</p >
            <p class="f32 sy_r"><span class="f60" id="_m" >05</span>分钟</p >
        </div>
        <div class="border-radius-img bg_ffd5b4 dis_wrap mt40">
            <div class="clearfix dis_con">
                @if(isset($sponsor->uid))
                    <?php
                        $name = DB::table("users")->where("id",$sponsor->uid)->select("nickname")->first();
                        $num = count($data);
                    ?>
                    <p class="fl f32 sy_b color_7a4300">{{$name->nickname?$name->nickname:'小伙伴们..'}}</p>
                    @else
                    <p class="fl f32 sy_b color_7a4300">小伙伴们..</p>
                @endif
                <span class="fr text_right text-overflow f28 sy_r color_c93126">正在校门口集结兄弟…</span>
            </div>
            <ul class="clearfix dis_head1 mt30 pt30">
                <?php
                    $moren = "/images/new_year/head_img2.png";
                    $studying = DB::table("studying")->where("user_id",$userid)->where("course_class_id",$class_id)->count();
                ?>
                @if(isset($sponsor->uid))
                    <?php
                        $avatar = DB::table("users")->where("id",$sponsor->uid)->select("avatar")->first();
                        $num = count($data);
                    ?>
                     <li class="fl"><img src="{{$avatar?$avatar->avatar:$moren}}" alt=""></li>
                     @foreach($data as $v)
                            <?php
                                $avatar = DB::table("users")->where("id",$v->friend)->select("avatar")->first();
                            ?>
                        <li class="fl"><img src="{{$avatar?$avatar->avatar:$moren}}" alt=""></li>
                     @endforeach
                     @for ($i = 0; $i < 3-$num; $i++)
                            <li class="fl"><img src="{{$moren}}" alt=""></li>
                     @endfor
                @else
                    <li class="fl"><img src="{{$moren}}" alt=""></li>
                    <li class="fl"><img src="{{$moren}}" alt=""></li>
                    <li class="fl"><img src="{{$moren}}" alt=""></li>
                    <li class="fl"><img src="{{$moren}}" alt=""></li>
                @endif
            </ul> 
        </div>
        <p class="f26 sy_r text_center mt40 dist_txt1 mb100"><i></i>还差{{3-count($data)}}位好友即可免费领取<i></i></p>
    </div>
    <!-- 距离活动结束还有 end -->

    <!-- 活动规则 start -->
    <div class="activity mlr30">
        <h2 class="f38 sy_r bg_c93126 color_fff border-radius60 text_center pt10 pb10">•&nbsp;&nbsp;&nbsp;活动规则&nbsp;&nbsp;&nbsp;•</h2>
        <div class="bg_c93126 border-radius-img act_txt color_fff mt30">
            <p class="f28 sy_r mb70">
                01、如何参与活动：<br>点击页面底部【邀请好友助力】分享到朋友圈或者微信好友寻求3名好友助力。
            </p>
            <p class="f28 sy_r mb70">
                02、如何领取课程：<br>当助力完成后到微信公众号【赛普健身社区】-【进入社区】-【我的课表】即可观看该课程。
            </p>
            <p class="f28 sy_r">
                03、如有其他问题：<br>欢迎您直接在【赛普健身社区】公众号留言，或者添加右侧微信入群咨询
            </p>  
        </div>
    </div>
    <!-- 活动规则 end -->

    <!-- 家用减脂瑜伽垫简介 start -->
    <div class="mlr30 bgcolor_fff border-radius-img mt50">
        <div class="yoga_txt color_7a4300">
            <h2 class="sy_b f40 mb40 text_center">课程简介</h2>
            <p class="sy_n f28">不管你是健身达人还是健身菜鸟，冠军导师带你了解运动中的术语和你的身体语言，更好的掌握动作发力模式，快速增肌瘦身~</p>
        </div>
    </div>
    <!-- 家用减脂瑜伽垫简介 end -->

<br><br><br>
    <!-- 固定底部 start-->
    <div class="fixed_wrap">
        <ul class="clearfix sy_m f28 text_center">

                @if($userid == 0)
                    <li class="color_333" onclick="userlogin()"><a href="javascript:;">邀请好友助力</a></li>
                    <li class="color_333" onclick="userlogin()"><a href="javascript:;">领取福利</a></li>
                @else
                    @if($num < 3)
                        <li class="color_333"><a href="/newyear/sharecard/{{$aid}}?cid={{$class_id}}&&userid={{$userid}}">邀请好友助力</a></li>
                        <li class="color_333" id="share_count" data-attr = "{{$num}}"><a href="javascript:;">领取福利</a></li>
                        @else
                        <li class="color_333"><a href="javascript:;" onclick = "layer.msg('助力成功 可点右侧【领取福利】');">邀请好友助力</a></li>
                        @if($studying == 1)			<!--是否领到课程---->
                            <li class="color_333 is_get" data-attr = "1"><a href="javascript:;">领取福利</a></li>
                        @else
                            <li class="color_333 is_get" data-attr = "0"><a href="javascript:;">领取福利</a></li>
                        @endif

                    @endif
                @endif

        </ul>
    </div>
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


<script src="lib/jqweui/js/jquery-weui.js"></script>
<script src="lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->
<script type="text/javascript">
    window.onload = function(){
        menuFixed('nav_keleyi_com');
    }
</script> 

<script>
/*倒计时*/
function countTime() {
    //获取当前时间
    var date = new Date();
    var now = date.getTime();
    //设置截止时间
    var endDate = new Date("2019/1/30 23:23");
    var end = endDate.getTime();
    //时间差
    var leftTime = end-now;
    //定义变量 d,h,m,s保存倒计时的时间
    var d,h,m;
    if (leftTime>=0) {
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
    }
    //将倒计时赋值到div中
    document.getElementById("_d").innerHTML = d;/*+"天"*/
    document.getElementById("_h").innerHTML = h;/*+"时"*/
    document.getElementById("_m").innerHTML = m;/*+"分"*/
    //递归每秒调用countTime方法，显示动态时间效果
    setTimeout(countTime,1000);
}
onload(countTime())
</script>

<script>


    $("#share_count").click(function(){
        var count = $(this).attr("data-attr");
        var left = 3 - count;
        layer.msg("亲，还差"+left+"人助力，快去邀请好友吧");
    })
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

//跳转登陆函数
var userlogin = function(){
    var userid = "{{$userid}}";
    var url = "{{$url}}";
    localStorage.setItem("redirect", url);

    layer.msg('请先注册');
    setTimeout(function(){
        window.location.href = "/register";
    }, 500)
}

//领取福利
$(".is_get").click(function() {
    var status = $(this).attr("data-attr");
    if (status == 0){
        var token = '{{csrf_token()}}';
        var userid = '{{$userid}}';
        var aid = '{{$aid}}';
        var cid = "{{$class_id}}";
        var data = {userid: userid,aid: aid,cid: cid, _token: token};
        $.ajax({
            url: '/newyear/is_zutuan',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function (data) {
                $(".is_get").attr("data-attr",1);
                layer.msg("恭喜您已领到课程。");
                window.location.href = "/course/detail/{{$class_id}}.html";

            }
        });
    }else{
        //layer.msg("您已领到课程，请在正在学习栏查看。");
        window.location.href = "/course/detail/{{$class_id}}.html";
    }
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
            title: '帮我助力获得孕产教练必备课程', // 分享标题
            desc: '孕产教练必备课程理论片解决了越来越多妈妈的孕前、孕后身体状态的问题，已经是每一个教练必备的技能', // 分享描述
            link: "http://m.saipubbs.com/newyear/classhelp/{{$userid}}/{{$class_id}}/{{$aid}}.html?fission_id={{$userid}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/zt/assistance/huodong2-banner.png", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '帮我助力获得孕产教练必备课程', // 分享标题
            link: "http://m.saipubbs.com/newyear/classhelp/{{$userid}}/{{$class_id}}/{{$aid}}.html?fission_id={{$userid}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/zt/assistance/huodong2-banner.png", // 分享图标
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

