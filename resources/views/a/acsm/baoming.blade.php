<?php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-ACSM中文CPT认证课程考试报名通道</title>
    <meta name="author" content="涵涵" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <!--mmenu.css start-->
    <link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
    <link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
    <link href="/css/nav-mmenu-public.css" rel="stylesheet" />
    <!--end-->
    <link rel="stylesheet" href="/css/reset.css" type="text/css"/>
    <link rel="stylesheet" href="/css/font-num40.css" type="text/css"/>
    <link rel="stylesheet" href="/css/zt/zt_payment.css" type="text/css"/>
    <style>
        button{-webkit-appearance:none;border: none;}
        body.bgcolor_000{background-color: #000;}
        img{width: 100%;display: block;}
        .color_red_be3f00{color: #be3f00;}
        .plr40{padding-left: 1rem;padding-right: 1rem;}


        /*常见问题*/
        .common_box{}
        .common_box dl dt{float: left;width: 10%;background: url("/images/zt/acsm/K.png")no-repeat;background-size: 100% 100%;height: 1.6rem;line-height: 1.6rem;}
        .common_box dl dd{float: left;width: 90%;padding-left: .25rem;}
        .common_box dl dd h3{line-height: 1rem;padding-top: .3rem;padding-bottom: .5rem;}

        /*悬浮底部*/
        .footer{position: fixed;bottom: 0;left: 0;width: 100%;height: 2.5rem;line-height: 2.5rem/*100*/;z-index: 999;}
    </style>



    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
</head>
<body ontouchstart>

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
        <div class="text_center nav-a">
            <ul>
                <li><a href="/">首页</a></li>
                <li><a href="/user/studying">正在学习</a></li>
                <li><a href="/user/index">我的</a></li>
                <li><a href="javascript:history.go(-1);">返回</a></li>
                @if(!is_weixin())
                    @if($user)
                        <li><a href="/logout">退出</a></li>
                    @else
                        <li><a href="/register">注册/登录</a></li>
                    @endif
                    {{--<li><a href="/register">注册</a></li>--}}
                @endif
            </ul>
        </div>
    </nav>
    <!--头部导航 end-->

    <!--====================================本喵是分割线  喵喵~========================================================-->

    <div>
        <!-- banner start-->
        <div>
            <img src="/images/zt/acsm/ACSMkaoshi_banner.jpg" alt="ACSM中文CPT认证课程">
        </div>
        <!-- banner end-->
        <!-- 内容 start-->
        <div class="content">
            <!-- 报名考试常见问题 start -->
            <div class="plr40 common_box color_fff pt40">
                <dl class="clearfix mb40">
                    <dt class="text_center lt f37 color_orange">1</dt>
                    <dd>
                        <h3 class="fz bold f32 color_orange">怎么获取证书</h3>
                        <p class="fz f26 text-jus">课程学习结束后，会为您安排考试，通过考试即可获取证书。获取的证书需在3年内修够45个继续教育学分（不限于研讨会、工作坊进修学习）才可生效。</p>
                    </dd>
                </dl>
                <dl class="clearfix mb40">
                    <dt class="text_center lt f37 color_orange">2</dt>
                    <dd>
                        <h3 class="fz bold f32 color_orange">考试需要交费吗？</h3>
                        <p class="fz f26 text-jus">参与考试需另外缴纳考试费，考试费用为2800元/次，补考费用为1400元/次。</p>
                    </dd>
                </dl>
                <dl class="clearfix mb40">
                    <dt class="text_center lt f37 color_orange">3</dt>
                    <dd>
                        <h3 class="fz bold f32 color_orange">考试形式是什么？</h3>
                        <p class="fz f26 text-jus">考试前20天将为学生微信通知考试信息，参与考试的考生需到原学习地参加现场电脑在线考试，100道单选，答对70道以上即视为通过。</p>
                    </dd>
                </dl>
            </div>
            <!-- 报名考试常见问题 end-->
        </div>
        <!-- 内容 end-->


        <!-- 悬浮底部 start-->
        @if($mobile)
        @if(!$courseOrder)
        <button class="footer bgcolor_orange text_center open-popup" data-target="#half">
            <p class="fz bold f32 color_red_be3f00">￥2800元<span class="color_333 ml20">马上报名考试</span></p>
        </button>
        @else
            <div class="footer bgcolor_orange text_center open-popup">
                <p class="fz bold f32 color_red_be3f00"><span class="color_333 ml20">已报名</span></p>
            </div>
        @endif
        @else
            <div class="footer bgcolor_orange text_center open-popup" onclick="userlogin();">
                <p class="fz bold f32 color_red_be3f00">￥2800元<span class="color_333 ml20">马上报名考试</span></p>
            </div>
        @endif
        <!-- 悬浮底部 end-->
    </div>

    <!-- 底部弹出popup start -->
    <div id="half" class='weui-popup__container popup-bottom payType_popup'>
        <div class="weui-popup__overlay"></div>
        <div class="weui-popup__modal fz">
            <div class="toolbar bgcolor_fff">
                <div class="toolbar-inner ">
                    <a href="javascript:void (0);" class="picker-button close-popup">关闭</a>
                    <h1 class="title bold">确认付款</h1>
                </div>
            </div>

            <div class="modal-content bgc_white">
                <div class="mor_list fz color_333 plr30 ptb30">
                    <div class="weui-cell  mt0 padding0">
                        <div class="weui-cell__bd">
                            <p class="f32 color_333 bold">课程原价</p>
                        </div>
                        <div class="weui-cell__ft price color_333 bold f28 bold">2800元</div>
                    </div>
                    <!--<div class="mt30 mb40">
                        <a class="weui-cell weui-cell_access noafter nobefore mt0 padding0" href="javascript:void (0);">
                            <div class="weui-cell__bd">
                                <p class="f32 color_333 bold">优惠劵</p>
                            </div>
                            <div class="weui-cell__ft bold color_333 f28">-￥500元</div>
                        </a>
                        <p class="text_right f24 fz color_777">赛普学员抵扣劵</p>
                    </div>-->

                </div>
                <div class="weui-cell weui-cell borderBt borderAt">
                    <div class="weui-cell__bd">
                        <h2 class="f28 bold">最终合计</h2>
                    </div>
                    <div class="weui-cell__ft">
                        <span class="price bold">2800元</span>
                    </div>
                </div>
                <div class="weui-cells weui-cells_radio nobefore noafter  dd">
                    <label class="weui-cell weui-check__label" for="x11">
                        <div class="weui-cell__bd f28">
                            <p><i class="ico_wx"></i>微信支付</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" class="weui-check" name="radio1" id="x11" checked="checked" value="WXPAY">
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>
                    <label class="weui-cell weui-check__label nobefore disabled_xueyuan" for="x12">
                        <div class="weui-cell__bd f28">
                            <p><i class="ico_spb"></i>赛普币支付</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" name="radio1" class="weui-check" id="x12">
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>

                </div>
                <div class="container_btn ptb30 mt30">
                    <a href="javascript:void(0);" class="roy_btn bgcolor_orange payBtn">立即付款</a>
                </div>
            </div>
        </div>
    </div>
    <!-- 底部弹出popup end -->


</div><!--导航大盒子id=page 结束-->

<br><br>
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="/js/fonts.js?t={{time()}}"></script>
<script type="text/javascript">
    $("body").addClass("bgcolor_000");
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
    <?php
        $content = explode(PHP_EOL,$courseClass->seo_description);
        $art = '';
        foreach($content as $cont){
            $art .= trim($cont);
        }
    ?>
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: '{{$courseClass->title}}', // 分享标题
            desc: '{{$art}}', // 分享描述
            link: "http://m.saipubbs.com/dist/buy/bm60.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            {{--link: "http://m.saipubbs.com/nasm/active.html?fid={{$user_id}}",--}}
            imgUrl: "{{env('IMG_URL')}}{{$courseClass->cover_url}}", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: 'NASM认证——在线报名通道', // 分享标题
            link: "http://m.saipubbs.com/dist/buy/bm60.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            {{--link: "http://m.saipubbs.com/nasm/active.html?fid={{$user_id}}",--}}
            imgUrl: "{{env('IMG_URL')}}{{$courseClass->cover_url}}", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });

</script>


<script type="text/javascript">
    var is_weixin = "{{$is_weixin}}";  //是否为微信浏览器
    var token     = '{{csrf_token()}}';
    var c_c_id    = "{{$courseClass->id}}";     //课程id
    var mobile    = "{{$mobile}}";
    var fission_id = "{{$fission_id}}";
    var storage_fis_id = localStorage.getItem('acsm_fission_id');
    if(fission_id>0){
        localStorage.setItem("fission_id", fission_id);
        localStorage.setItem('acsm_fission_id',fission_id);
    }else{
        if(storage_fis_id == null || storage_fis_id == ''){
            fission_id = 0;
        }else{
            fission_id = storage_fis_id;
        }
    }

    //跳转登陆函数
    var userlogin = function(){
        var url = "/dist/buy/bm"+c_c_id+".html";
        localStorage.setItem("redirect", url);

        layer.msg('请先注册');
        setTimeout(function(){
            window.location.href = "/register";
        }, 500)
    };

    $(function (){

        //立即付款弹出框
        $('.payBtn').click(function (){
            var payfrom = $("input[name='radio1']:checked").val();
            if(payfrom=='BANLANCE'){
                $.closePopup();
                $.confirm({
                    title: '提示',
                    text: '立即购买学习该课程，确认购买吗？',
                    onOK: function () {
                        //点击确认
                        $.ajax({
                            type:"GET",
                            url:"/course/paybalance",
                            data:{c_c_id:c_c_id, user_id:user_id},
                            dataType:"json",
                            success:function(result){
                                if(result.code==1){
                                    layer.msg(result.msg);
                                    setTimeout(function(){
                                        href_go();     //支付成功跳转
                                    },1500)  //延迟1.5秒刷新页面
                                }else{
                                    layer.msg(result.msg);
                                }
                            }
                        });
                    },
                    onCancel: function (){
                    }
                });
            }else if(payfrom=="WXPAY"){

                if(is_weixin==1){
                    jsApiCall();
                }else{
                    $.ajax({
                        type:"POST",
                        url:"/unline/exam/payh",
                        data:{course_class_id:c_c_id,fission_id:fission_id,_token:token},
                        dataType:"json",
                        success:function(result){
                            if(result.code==0){
                                console.log(result.objectxml.mweb_url);
                                //follow_us();
                                window.location.href=result.objectxml.mweb_url;   //h5呼叫微信支付
                            }else{
                                layer.msg(result.msg);
                            }
                        }
                    });
                }
            }
        })

        //调用微信JS api 支付
        function jsApiCall()
        {
            var _token = '{{csrf_token()}}';
            var data = {class_id:c_c_id,fission_id:fission_id,_token:_token};

            $.ajax({
                url:'/unline/exam/pay',
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
    })

</script>
</body>
</html>