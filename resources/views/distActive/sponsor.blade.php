<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no"/>
    <title>赛普社区-拼团页面</title>
    <meta name="author" content="涵涵"/>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css"/>
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css"/>

    <link href="/css/reset.css" rel="stylesheet" type="text/css"/>
    <link href="/css/font-num40.css" rel="stylesheet">

    <!--本css-->
    <link rel="stylesheet" href="/css/zt/zt_payment.css">
    <link rel="stylesheet" href="/css/zt/zt_pintuan.css?t=1">

    <script>
        (function () {
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth / 18.75 + 'px';
        })()
    </script>
</head>
<body>

<div class="text_center fz">
    <div class="bgban1">

        @if($disCourse->team_people - count($classJoins) == 0)
            {{--<p class="color_ff6d1e f28 pb10">拼团完成</p>--}}
            <h3 class="bold f38 pb30">拼团成功，恭喜您获得该课程！</h3>
        @else
            @if(strtotime($orderCourse->uneffect_time)< time())
                <p class="color_ff6d1e f28 pb10">该团已过期</p>
            @else
                <h3 class="bold f38 pb30">还差{{$disCourse->team_people - count($classJoins)}}人，赶快邀请好友完成拼团</h3>
                <p class="color_ff6d1e f28 pb10">距离拼团结束时间还有</p>
                <p class="color_ff6d1e f28 settime" endTime="{{$orderCourse->uneffect_time}}"></p>
            @endif

        @endif
    </div>
    <div class="bgban2">
        <ul class="clearfix">
            @foreach($classJoins as $k => $join)
                <?php
                $majorUser = $join->user;
                if($majorUser){
                    if(strpos($majorUser->avatar,'http') !== false){
                        $majorPic = $majorUser->avatar;
                    }else{
                        if(!empty($majorUser->avatar)){
                            $majorPic = env('IMG_URL').$majorUser->avatar;
                        }else{
                            if($k == 0){
                                $majorPic = '/images/userImg.png';
                            }else{
                                $majorPic = '/images/userImgs.png';
                            }
                        }
                    }
                }else{
                    if($k == 0){
                        $majorPic = '/images/userImg.png';
                    }else{
                        $majorPic = '/images/userImgs.png';
                    }

                }
                ?>
                <li>
                    <div class="pImg">
                        <img class="borderRadius50" src="{{$majorPic}}" alt="">
                        <span class="color_fff bg_ff7200 f18 border-radius-img mt20">{{$k == 0?"团长":"拼团成功"}}</span>
                    </div>
                </li>
            @endforeach
            @if($k == 0)
                @if($disCourse->team_people - ($k+1) == 1)
                    <li>
                        <div class="pImg">
                            <img class="borderRadius50" src="/images/userImgs.png" alt="">
                            <span class="color_fff bg_ff7200 f18 border-radius-img mt20">待拼团<!--拼团成功--></span>
                        </div>
                    </li>
                @else
                    <li>
                        <div class="pImg">
                            <img class="borderRadius50" src="/images/userImgs.png" alt="">
                            <span class="color_fff bg_ff7200 f18 border-radius-img mt20">待拼团<!--拼团成功--></span>
                        </div>
                    </li>
                    <li>
                        <div class="pImg">
                            <img class="borderRadius50" src="/images/userImgs.png" alt="">
                            <span class="color_fff bg_ff7200 f18 border-radius-img mt20">待拼团<!--拼团成功--></span>
                        </div>
                    </li>
                @endif
            @endif
            @if($k==1)
                @if($disCourse->team_people - ($k+1) == 1)
                    <li>
                        <div class="pImg">
                            <img class="borderRadius50" src="/images/userImgs.png" alt="">
                            <span class="color_fff bg_ff7200 f18 border-radius-img mt20">待拼团<!--拼团成功--></span>
                        </div>
                    </li>
                @endif
            @endif
        </ul>
    </div>
    <!-- 正在拼团的课程 start -->
    <div class="nowPin">
        <div class="pinqilai fz">
            <a href="javascript:void (0)" class="color_fff block f32 color_ff6d1e bold"><i></i>正在拼团的课程<i></i></a>
        </div>
        <div class="mt70 text_left txt">
            <h3 class="bold f30 pb20 mb30">{{$disCourse->title}}（第{{$orderCourse->stage}}期）</h3>
            <?php
            $teamDesc = explode("\n",$disCourse->team_course_desc);
            ?>
            @foreach($teamDesc as $desc)
                <p class="f26"><span class="color_fedb00 mr15 f38">•</span>{{trim($desc)}}</p>
            @endforeach
            {{--<p class="f26"><span class="color_fedb00 mr15 f38">•</span>超过40+的训练动作&复位手法</p>--}}
            {{--<p class="f26"><span class="color_fedb00 mr15 f38">•</span>3个月导师答疑，7周导师群内教学</p>--}}
            {{--<p class="f26"><span class="color_fedb00 mr15 f38">•</span>课程完成后颁发结业证书</p>--}}
        </div>
        <p class="f26 pt70 mt20 text-jus zhu">（注：如果24小时内未完成拼团，或课程报名人数已满，系统会自动取消该订单，并且完成退款，团长可重新选择最新班期再次发起拼团）</p>

    </div>
    <!-- 正在拼团的课程 end -->

    <!-- 499元邀请好友拼团购买 start-->
    <div class="relative">
        @if($disCourse->team_people - count($classJoins) == 0)
            <a href="javascript:void(0);" class="pPosBtn f36">报名成功</a>
        @else
            @if(strtotime($orderCourse->uneffect_time)< time())
                <a href="javascript:void(0);" class="pPosBtn f36 disabled">该团已过期</a>
            @else
                <a href="javascript:void (0)" class="pPosBtn f36 clickFen">邀请好友一起拼团</a>
            @endif
        @endif
    </div>
    <!-- 499元邀请好友拼团购买 end-->

    <!--弹出分享 start-->
    <div class="bb hide">
        <div class="fxpyq_success_layer_wrap text_center tan-font color_fff f32 fz pt105 fx-img" >
            <p class="doimg clearfix">
                <img src="/images/fenxiang-j.png" class="down-arrow" id="dou" alt="" />
            </p>
            <p class="pt105 color_fff f36 fz bold ">分享一下，即可邀请好友一起拼团！</p>
            <p class="text_left pl135 pt70 pb30">1、点击“<img src="/images/more.png" alt="" class="d-in-black more-s">”</p>
            <p class="text_left pl135">2、分享到微信好友 / 群 / 朋友圈</p>

        </div>
    </div>
    <!--弹出分享 end-->

</div>

<br><br><br>
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script>
    $(document).ready(function () {
        var a = $(".bgban2").find("ul li").length;
        if (a == 2) {
            console.log('111');
            //$(".bgban2").find("ul li").css("width","50%");
            $(".bgban2").find("ul li").outerWidth("50%");
        } else {
            console.log('222')
        }
    });

    $(function(){
        updateEndTime();
    });
    function updateEndTime(){
        var NowTime = new Date();
        var time = NowTime.getTime();
        $(".settime").each(function(I){
            var endDate =this.getAttribute("endTime"); //结束时间字符串
            //转换为时间日期类型
            var endDate1 = eval('new Date(' + endDate.replace(/\d+(?=-[^-]+$)/, function (a) { return parseInt(a, 10) - 1; }).match(/\d+/g) + ')');
            var endTime = endDate1.getTime(); //结束时间毫秒数
            var lag = (endTime - time) / 1000; //当前时间和结束时间之间的秒数
            if(lag > 0){
                var second = Math.floor(lag % 60);
                var minite = Math.floor((lag / 60) % 60);
                var hour = Math.floor((lag / 3600) % 24);
                var day = Math.floor((lag / 3600) / 24);
                $(this).html(day+"天"+hour+"时"+minite+"分"+second+"秒");
            }else{
                $(this).html("时间到了！！");
            }
        });
        setTimeout("updateEndTime()",1000);
    }

    //分享弹窗
    $('.clickFen').click(function(){
        $('.video .box2').show();
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'fxpyq_success_layer_wrap', //样式类名
            id: 'fxpyq_success_layer', //设定一个id，防止重复弹出
            closeBtn: 0, //不显示关闭按钮
            anim: 2,
            shade:[0.7, '#000'],
            shadeClose: true, //开启遮罩关闭
            area: ['90%', '80%'],
            content: $('.bb'),
            btn: false
        });
    });
    /*点击文字也可以全部关闭*/
    $('.fxpyq_success_layer_wrap').click(function(){
        parent.layer.closeAll()
    })

</script>
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

    var fission_id = '{{$fission_id}}';
    var g_id = '{{$disCourse->id}}';

    var desc = '我正在学习{{$disCourse->title}}，你也来学习吧~';
    var share_img = '{{env('IMG_URL')}}{{$disCourse->cover_url}}';

    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: '{{$disCourse->title}}', // 分享标题
            desc: desc, // 分享描述
            link: "http://m.saipubbs.com/train/join/{{$fission_id}}t{{$disCourse->id}}.html", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img, // 分享图标

        }, function(res) {
            //这里是回调函数

        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '{{$disCourse->title}}', // 分享标题
            link: "http://m.saipubbs.com/train/join/{{$fission_id}}t{{$disCourse->id}}.html", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img, // 分享图标

        }, function(res) {
            //这里是回调函数
        });
    });
</script>

</body>
</html>