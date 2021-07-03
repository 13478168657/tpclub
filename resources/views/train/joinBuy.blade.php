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
        <h3 class="bold f38 pb30">团长邀请你拼团购买课程</h3>
        @if($courseClassGroup->team_people - count($classJoins) <= 0)
        <p class="color_ff6d1e f28 pb10">拼团完成</p>
        @else

            @if(strtotime($orderCourse->uneffect_time)< time())
                <p class="color_ff6d1e f28 pb10">该团已过期</p>
            @else
                <p class="color_ff6d1e f28 pb10">距离拼团结束时间还有</p>
                <p class="color_ff6d1e f28 settime" endTime="{{$orderCourse->uneffect_time}}">
            @endif
        </p>
        @endif
    </div>
    <div class="bgban2">
        <ul class="clearfix">
            <?php

                if(isset($classJoins[0])){
                    $majorUser = $classJoins[0]->user;
                    if($majorUser){
                        if(strpos($majorUser->avatar,'http') !== false){
                            $majorPic = $majorUser->avatar;
                        }else{
                            if(!empty($majorUser->avatar)){
                                $majorPic = env('IMG_URL').$majorUser->avatar;
                            }else{
                                $majorPic = '/images/userImg.png';
                            }
                        }
                    }else{
                        $majorPic = '/images/userImg.png';
                    }
                }else{
                    $majorPic = '/images/userImg.png';
                }

            ?>
            <li>
                <div class="pImg">
                    <img class="borderRadius50" src="{{$majorPic}}" alt="">
                    <span class="color_fff bg_ff7200 f18 border-radius-img mt20">团长</span>
                </div>
            </li>
            <?php
                if(isset($classJoins[1])){
                    $slaveUser = $classJoins[1]->user;
                    $descInfo = '拼团成功';
                    if($slaveUser){
                        if(strpos($slaveUser->avatar,'http') !== false){
                            $slavePic = $slaveUser->avatar;
                        }else{
                            if(!empty($slaveUser->avatar)){
                                $slavePic = env('IMG_URL').$slaveUser->avatar;
                            }else{
                                $slavePic = '/images/userImg.png';
                            }
                        }
                    }else{
                        $slavePic = '/images/userImg.png';
                    }
                }else{
                    $slavePic = '/images/userImgs.png';
                    $descInfo = '待拼团';
                }
            ?>
            @if($courseClassGroup->team_people == 3 || $courseClassGroup->team_people == 2)
            <li>
                <div class="pImg">
                    <img class="borderRadius50" src="{{$slavePic}}" alt="">
                    <span class="color_fff bg_ff7200 f18 border-radius-img mt20">{{$descInfo}}<!--拼团成功--></span>
                </div>
            </li>
            @endif
            <?php
                if(isset($classJoins[2])){
                    $descInfo = '拼团成功';
                    $slaveUser = $classJoins[2]->user;
                    if($slaveUser){
                        if(strpos($slaveUser->avatar,'http') !== false){
                            $slavePic = $slaveUser->avatar;
                        }else{
                            if(!empty($slaveUser->avatar)){
                                $slavePic = env('IMG_URL').$slaveUser->avatar;
                            }else{
                                $slavePic = '/images/userImg.png';
                            }
                        }
                    }else{
                        $slavePic = '/images/userImg.png';
                    }
                }else{
                    $slavePic = '/images/userImgs.png';
                    $descInfo = '待拼团';
                }
            ?>
            @if($courseClassGroup->team_people == 3)
            <li>
                <div class="pImg">
                    <img class="borderRadius50" src="{{$slavePic}}" alt="">
                    <span class="color_fff bg_ff7200 f18 border-radius-img mt20">{{$descInfo}}<!--拼团成功--></span>
                </div>
            </li>
            @endif
        </ul>
    </div>
    <!-- 正在拼团的课程 start -->
    <div class="nowPin">
        <div class="pinqilai fz">
            <a href="javascript:void (0)" class="color_fff block f32 color_ff6d1e bold"><i></i>正在拼团的课程<i></i></a>
        </div>
        <a href="/train/studying.html?id={{$courseClassGroup->id}}">
        <img class="pinqiImg" src="{{env("IMG_URL")}}{{$courseClassGroup->list_url}}" alt=""></a>
    </div>
    <!-- 正在拼团的课程 end -->

    <!-- 499元邀请好友拼团购买 start-->
    <div class="relative">
        @if($mobile == 0)
            <a href="javascript:void (0)" class="pPosBtn f36 open-popup" onclick="userlogin();">立即拼团购买</a>
        @else
            @if($courseClassGroup->team_people - count($classJoins) <= 0)
            <a href="javascript:void (0)" class="pPosBtn f36 open-popup disabled">拼团结束</a>
            @else
                @if(strtotime($orderCourse->uneffect_time)< time())
                    <a href="javascript:void (0)" class="pPosBtn f36 open-popup disabled">该团已过期</a>
                @else
                    <a href="javascript:void (0)" class="pPosBtn f36 open-popup" data-target="#half">立即拼团购买</a>
                @endif
            @endif
        @endif
    </div>
    <!-- 499元邀请好友拼团购买 end-->


    <!-- 底部弹出popup start -->
    <div id="half" class='weui-popup__container popup-bottom payType_popup'>
        <div class="weui-popup__overlay"></div>
        <div class="weui-popup__modal fz"><!-- style="height: inherit;" //如果高度不能滑动加上前方这个style-->
            <div class="toolbar">
                <div class="toolbar-inner">
                    <a href="javascript:;" class="picker-button close-popup">关闭</a>
                    <h1 class="title">确认付款</h1>
                </div>
            </div>

            <div class="modal-content bgc_white text_left">
                <div class="plr40 mor_list fz color_333">
                    <h3 class="ptb20 f32 bold">{{$groupTitle}}（第{{$orderCourse->stage}}期）</h3>
                    <ul class="ptb30 f26 text-jus">
                        <?php
                            echo htmlspecialchars_decode($teamDesc);
                        ?>
                    </ul>
                </div>
                <div class="weui-cell weui-cell">
                    <div class="weui-cell__bd">
                        <h2 class="f28 bold">{{$courseClassGroup->team_people}}人拼团价</h2>
                    </div>
                    <div class="weui-cell__ft">
                        <span class="price">{{$coursePeriod->birdPrice}}元</span>
                    </div>
                </div>
                <div class="weui-cell weui-cell">
                    <div class="weui-cell__bd">
                        <h2 class="f28">已购课程抵扣</h2>
                    </div>
                    <div class="weui-cell__ft color_red">
                        -<span class="price">{{$youhui}}元</span>
                    </div>
                </div>
                @if($hasCoupon)
                    <div class="weui-cell weui-cell">
                        <div class="weui-cell__bd">
                            <h2 class="f28">优惠劵</h2>
                        </div>
                        <div class="weui-cell__ft color_red">
                            -<span class="price">{{$couponPrice}}元</span>
                        </div>
                    </div>
                @endif
                <div class="weui-cell weui-cell">
                    <div class="weui-cell__bd">
                        <h2 class="f28">最终合计</h2>
                    </div>
                    <div class="weui-cell__ft">
                        <span class="price">{{$coursePeriod->birdPrice-$youhui-$couponPrice}}元</span>
                    </div>
                </div>
                <div class="weui-cells weui-cells_radio noafter  dd">
                    <label class="weui-cell weui-check__label" for="x14">
                        <div class="weui-cell__bd f28">
                            <p><i class="ico_wx"></i>微信支付</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" class="weui-check" value="WXPAY" name="radio1" id="x14" checked="checked">
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>
                    <label class="weui-cell weui-check__label disabled_xueyuan" for="x15">
                        <div class="weui-cell__bd f28">
                            <p><i class="ico_balance"></i>余额支付</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" value="WXPAY" name="radio1" class="weui-check" id="x15">
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>
                </div>

                <div class="container_btn ptb20">
                    <a href="javascript:void(0);" class="roy_btn bgcolor_orange payBtn">立即付款</a>
                </div>
            </div>
        </div>
    </div>
    <!-- 底部弹出popup end -->

</div>

<br><br><br>
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script>

    $(document).ready(function () {
        var a = $(".bgban2").find("ul li").length;

        if (a == 2) {

            //$(".bgban2").find("ul li").css("width","50%");
            $(".bgban2").find("ul li").outerWidth("50%");
        } else {

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
    //将裂变者id写入本地  用于存储上下级关系
    var fission_id = "{{$sponsor_id}}";
    if(fission_id>0){
        localStorage.setItem("fission_id", fission_id);
    }

    //跳转登陆函数
    var gp_id = '{{$courseClassGroup->id}}';
    var href_url = "/train/join/"+fission_id+"s"+gp_id+".html";
    var userlogin = function(){

        localStorage.setItem("redirect", href_url);
        layer.msg('请先注册');
        setTimeout(function(){
            window.location.href = "/register";
        }, 500)
    };
    var is_weixin = "{{$is_weixin}}";  //是否为微信浏览器
    var c_c_id    = '{{$courseClassGroup->id}}';   //课程组id
    var token     = '{{csrf_token()}}';
    var final_price = "{{$coursePeriod->birdPrice-$youhui-$couponPrice}}";
    var user_id     = "{{$user_id}}";
    var yh = '{{$youhui==0?$youhui:0}}';
    var couponPrice = '{{$couponPrice}}';
    var stage = '{{$orderCourse->stage}}';
    //调用微信JS api 支付
    function jsApiCall()
    {

        var _token = '{{csrf_token()}}';
        var buy_price = final_price;

        var data = {class_id:c_c_id,_token:_token, final_price:buy_price,stage:stage,dis_id:fission_id,sponsor_id:fission_id};

        $.ajax({
            url:'/team/train/buy',
            data:data,
            type:'POST',
            dateType:'json',
            success:function(res){

                if(res.code != 0){
                    layer.msg(res.message);

                    return false;
                }else{
                    var data = res.data;
                }
                WeixinJSBridge.invoke(
                        'getBrandWCPayRequest',
                        data,
                        function(res){
                            WeixinJSBridge.log(res.err_msg);
                            if(res.err_msg=='get_brand_wcpay_request:ok'){
                                layer.msg('支付成功');
                                href_go();     //支付成功跳转
                            }else{
                                layer.msg('取消支付');
                            }
                        }
                );
            }
        })
    }
    //免费报名成功或者购买成功后跳转
    function href_go(){
        location.href = "/train/success/{{$courseClassGroup->id}}.html";
    }
    //立即付款弹出框
    $('.payBtn').click(function (){

        var payfrom = $("input[name='radio1']:checked").val();

        if(payfrom=="WXPAY"){
            if(is_weixin==1){

                jsApiCall();
            }else{
                var buy_price = final_price;
                var data = {class_group_id:c_c_id,_token:token, final_price:buy_price,stage:stage,dis_id:fission_id,sponsor_id:fission_id};

                $.ajax({
                    type:"POST",
                    url:"/team/train/payh",
                    data:{class_group_id:c_c_id,_token:token, final_price:buy_price,stage:stage,dis_id:fission_id,sponsor_id:fission_id},
                    dataType:"json",
                    success:function(result){
                        if(result.code==1){
                            console.log(result.objectxml.mweb_url);
                            //follow_us();
                            window.location.href=result.objectxml.mweb_url;   //h5呼叫微信支付
                        }else{
                            layer.msg(result.msg);
                        }
                    }
                });
            }
        }else{
            layer.msg('请选择支付方式');
        }
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
    var g_id = '{{$courseClassGroup->id}}';
    var desc = '';
    var share_img = '';
    if(g_id == 4){
        desc = '我已经报名减脂教练核心能力训练营，你也来学习吧~';
        share_img = "http://m.saipubbs.com/images/zt/xunlianying.jpeg";
    }else if(g_id == 5){
        desc = '我正在学习幼儿体侧师认证课程，你也来学习吧';
        share_img = "http://image.saipubbs.com/upload/image/20191213/1576204294.9201457246.png";
    }else{
        desc = '我正在学习产后实战课程，你也来学习吧~';
        share_img = "http://m.saipubbs.com/images/zt/yunchan01.jpg";
    }
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: '{{$courseClassGroup->title}}', // 分享标题
            desc: desc, // 分享描述
            link: "http://m.saipubbs.com"+href_url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img, // 分享图标

        }, function(res) {
            //这里是回调函数

        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '{{$courseClassGroup->title}}', // 分享标题
            link: "http://m.saipubbs.com"+href_url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img, // 分享图标

        }, function(res) {
            //这里是回调函数

        });
    });
</script>
</body>
</html>