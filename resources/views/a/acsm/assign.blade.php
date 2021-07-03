<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-ACSM中文CPT认证课程活动-好友助力榜</title>
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

    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" >
    <link rel="stylesheet" href="/css/zt/zt_payment.css">

    <link rel="stylesheet" href="/css/zt/zt_acsm.css?t=1.4">
    <style>

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
        <div class="text_center  fz">
            <ul>
                <li><a href="/">首页</a></li>
                <li><a href="/user/studying">正在学习</a></li>
                <li><a href="/user/index">我的</a></li>
            </ul>
        </div>
    </nav>
    <!--头部导航 end-->

    <!--====================================本喵是分割线  喵喵~========================================================-->

    <div>
        <!-- banner start-->
        <div>
            <img src="/images/zt/acsm/ban3.jpg" alt="ACSM中文CPT认证课程">
            {{--<img src="/images/zt/acsm/ban2.jpg" alt="ACSM中文CPT认证课程">--}}
            <img src="/images/zt/acsm/ban3zl.jpg" alt="ACSM中文CPT认证课程">
        </div>
        <!-- banner end-->

        <!-- 内容 start-->
        <div class="content">
            <!-- 再邀请N个好友助力至N档价格 start -->
            <div class="help_list pt30">
                <div class="roy-progress fz plr35">
                    <ul>
                        <li><span>5800<em>元</em></span></li>
                        <li><span>4800<em>元</em></span></li>
                        <li><span>3800<em>元</em></span></li>
                        <li><span>3300<em>元</em></span></li>
                        <li><span>2800<em>元</em></span></li>
                    </ul>
                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
                </div>
                <p class="text_left fz f26 plr35 color_gray666 pt30 pb30 mb40">
                    @if($price == 2800)
                        恭喜您，您已获得2800元报名ACSM资格~
                    @else
                        还差<span class="color_red_fe4839">{{$invite}}</span>个好友助力,可获得<span class="color_red_fe4839">{{$grade}}</span>元报名ACSM资格</p>
                    @endif
            </div>
            <!-- 再邀请N个好友助力至N档价格 end -->

            <!-- 好友助力榜 start-->
            <img src="/images/zt/acsm/friendImgTit.jpg" alt="赛普健身社区好友助力榜">
            <div class="friend_help_list">
                <p class="text_center fz f26 color_gray666 mb40">共有{{count($assignHands)}}位朋友为你助力</p>
                <ul class="fz color_333 f26">
                    @foreach($assignHands as $k => $hand)
                        <?php
                          if(!$hand->user){
                              continue;
                          }
                        ?>
                    <li>
                        <div class="weui-cell noafter nobefore mt0 padding0">

                            <div class="weui-cell__hd">{{$k+1}}
                                @if($hand->user->avatar)
                                    @if(strpos($hand->user->avatar,'http') !== false)
                                        <img class="h_img border-radius50 img100" src="{{$hand->user->avatar}}">
                                    @else
                                        <img class="h_img border-radius50 img100" src="{{env('IMG_URL')}}{{$hand->user->avatar}}">
                                    @endif
                                @else
                                    <img class="h_img border-radius50 img100" src="/images/userImg.png" alt="" />
                                @endif
                            </div>
                            <div class="weui-cell__bd">
                                <p class="text-overflow color_gray666">{{$hand->user->name?$hand->user->name:$hand->user->nickname}}</p>
                            </div>
                            <div class="weui-cell__ft color_333">{{date('m-d',strtotime($hand->created_at))}}</div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <img src="/images/zt/acsm/friendImgConButa.jpg" alt="">
            <!-- 好友助力榜 end-->
            <!-- 活动规则 start -->
            <div class="help_rule plr35">
                <h4 class="help_rule_Tit text_center lt f34 color_333"><img src="/images/zt/acsm/rule_left.png" alt="">活动规则<img src="/images/zt/acsm/rule_right.png" alt=""></h4>
                <ul class="pt40 fz f26 color_gray666">
                    <li class="clearfix pb20"><span class="color_orange">●</span><p>每位被邀请的用户只能完成一次助力。</p></li>
                    <li class="clearfix pb20"><span class="color_orange">●</span><p>每位用户可以为多位好友完成助力。</p></li>
                    <li class="clearfix pb20"><span class="color_orange">●</span><p>没有关注公众号的用户选先关注公众号后才能助力。</p></li>
                </ul>
            </div>
            <!-- 活动规则 end -->
        </div>
        <!-- 内容 end-->

        <!--按钮切换 start-->
        <div class="ptb50 bgcolor_fff bgcolor_f9f9f9">
            <div class="zaoniao_btn mt60 plr25 clearfix text_center relative">
                <a href="javascript:void (0)" class="button border-radius-img fz f24 bg_orange_active" data-id="1" data-city="1">11月9号 北京校区</a>
                <a href="javascript:void (0)" class="button border-radius-img fz f24" data-id="2" data-city="1">12月9号 北京校区</a>
                <a href="javascript:void (0)" class="button border-radius-img fz f24 " data-id="1" data-city="2">11月9号 上海校区</a>
                <a href="javascript:void (0)" class="button border-radius-img fz f24 " data-id="2" data-city="2">12月9号 上海校区</a>
                <a href="javascript:void (0)" class="button border-radius-img fz f24 " data-id="1" data-city="3">11月9号 深圳校区</a>
                <a href="javascript:void (0)" class="button border-radius-img fz f24 "data-id="2" data-city="3">12月9号 深圳校区</a>
            </div>
            <a href="/activeCourse/addUserInfo/60.html" class="BBut block text_center f28 fz bold border-radius50 mt26"><img src="/images/zt/acsm/zhua.png" alt="">报名前请——完善学员身份信息</a>
        </div>
        <!--按钮切换 end-->
        <!-- 悬浮底部 start-->
        @if($course_buyed)
            <div class="foot foot_help text_center open-popup bgcolor_orange">
        @else
            <div class="foot foot_help text_center open-popup bgcolor_orange" data-target="#half">
        @endif
            @if($mobile)
                @if($course_buyed)
                    <a class="fz bold f30 color_red_be3f00 block" href="javascript:void (0)"><span class="color_333">已报名</span></a>
                @else
                    @if($add_info)
                    <a class="fz bold f30 color_red_be3f00 block" href="javascript:void (0)">￥{{$price}}元 <span class="color_333">立即报名</span></a>
                    @else
                        <a class="fz bold f30 color_red_be3f00 block" onclick="javascript:window.location='/activeCourse/addUserInfo/{{$courseClass->id}}.html?fid={{$fission_id}}'">￥{{$price}}元 <span class="color_333">立即报名</span></a>
                    @endif
                @endif
            @else
                <a class="fz bold f30 color_red_be3f00" onclick="userlogin();">￥{{$price}}元 <span class="color_333">立即报名</span></a>
            @endif
        </div>
        <!-- 悬浮底部 end-->
    </div>


    <!-- 底部弹出popup start -->
    <div id="half" class='weui-popup__container popup-bottom payType_popup'>
        <div class="weui-popup__overlay"></div>
        <div class="weui-popup__modal fz">
            <div class="toolbar bgcolor_fff">
                <div class="toolbar-inner ">
                    <a href="javascript:;" class="picker-button close-popup">关闭</a>
                    <h1 class="title bold">确认付款</h1>
                </div>
            </div>

            <div class="modal-content bgc_white">
                <div class="mor_list fz color_333 plr30 ptb30">
                    <div class="weui-cell  mt0 padding0">
                        <div class="weui-cell__bd">
                            <p class="f32 color_333 bold">课程原价</p>
                        </div>
                        <div class="weui-cell__ft price color_333 bold f28 bold">5800元</div>
                    </div>
                </div>
                <div class="weui-cell weui-cell borderBt borderAt">
                    <div class="weui-cell__bd">
                        <h2 class="f28 bold">最终合计</h2>
                    </div>
                    <div class="weui-cell__ft">
                        <span class="price bold">{{$price}}元</span>
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
                    @if($mobile)
                        <a href="javascript:void(0);" class="roy_btn bgcolor_orange payBtn">立即付款</a>
                    @else
                        <a onclick="userlogin();" class="roy_btn bgcolor_orange">立即付款</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- 底部弹出popup end -->


</div><!--导航大盒子id=page 结束-->

<br><br><br>
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
            title: 'NASM认证——在线报名通道', // 分享标题
            desc: '美国国家运动医学院（NASM）是美国四大认证之一，4天28课时，国际权威教练认证也能拿！', // 分享描述
            link: "http://m.saipubbs.com/course/detail/60.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            {{--link: "http://m.saipubbs.com/nasm/active.html?fid={{$user_id}}",--}}
            imgUrl: "{{env('IMG_URL')}}{{$courseClass->cover_url}}", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: 'NASM认证——在线报名通道', // 分享标题
            link: "http://m.saipubbs.com/course/detail/60.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
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
        var url = "/dist/buy/a"+c_c_id+".html";
        localStorage.setItem("redirect", url);

        layer.msg('请先注册');
        setTimeout(function(){
            window.location.href = "/register";
        }, 500)
    };

    var time = '1';
    var city = '1';
    $(function (){

        var step='{{$currentGrade}}';//步数
        var lis=$('.roy-progress ul li');//li元素
        var bar=$('.progress-bar');//进度条对象
        var li_len=lis.length;
        var li_w=lis.width();
        if(step>=li_len){
            bar.width(li_w*step);
        }else{
            bar.width(li_w*step-li_w/2);
        }
        lis.eq(step-1).addClass('active');
        for( var i = 0; i < step-1; i++){
            lis.eq(i).addClass('pass');
        }

        $('.zaoniao_btn a').click(function () {
            time = $(this).attr('data-id');
            city = $(this).attr('data-city');

            $(this).addClass('bg_orange_active').siblings().removeClass('bg_orange_active');
            var index=$(this).index();
            $(".foot .foot_uu ul li.xiaoqu .h_box").eq(index).show().siblings().hide().removeClass("block");
        });

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
                        url:"/activeCourse/acsm/payh",
                        data:{course_class_id:c_c_id,fission_id:fission_id,time:time,city:city,_token:token},
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
            }
        })

        //调用微信JS api 支付
        function jsApiCall()
        {
            var _token = '{{csrf_token()}}';
            var data = {class_id:c_c_id,fission_id:fission_id,time:time,city:city,_token:_token};
            $.ajax({
                url:'/activeCourse/acsm/buy',
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