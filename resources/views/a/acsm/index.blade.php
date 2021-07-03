<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-ACSM中文CPT认证课程活动</title>
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
    <link rel="stylesheet" href="/css/zt/zt_RightFloat.css">

    <link rel="stylesheet" href="/css/zt/zt_acsm.css?t=1.4">
    <style>

    </style>


    @include('layouts.baidutongji')
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
            {{--<img src="/images/zt/acsm/ban1.jpg" alt="ACSM中文CPT认证课程">--}}
            <img src="/images/zt/acsm/ban3.jpg" alt="ACSM中文CPT认证课程">
        </div>
        <!-- banner end-->

        <!-- 内容 start-->
        <div class="content">
            <!--按钮切换 start-->
            <div class="ptb50 bgcolor_fff bgcolor_f9f9f9">
                <div class="zaoniao_btn mt60 plr25 clearfix text_center relative">
                    <a href="javascript:void (0)" class="button border-radius-img fz f24 bg_orange_active" data-id="1" data-city="1">11月24号 北京校区</a>
                    <a href="javascript:void (0)" class="button border-radius-img fz f24" data-id="2" data-city="1">12月24号 北京校区</a>
                    {{--<a href="javascript:void (0)" class="button border-radius-img fz f24" data-id="1" data-city="2">11月9号 上海校区</a>--}}
                    <a href="javascript:void (0)" class="button border-radius-img fz f24" data-id="2" data-city="2">12月24号 上海校区</a>
                    {{--<a href="javascript:void (0)" class="button border-radius-img fz f24" data-id="1" data-city="3">11月9号 深圳校区</a>--}}
                    <a href="javascript:void (0)" class="button border-radius-img fz f24" data-id="2" data-city="3">12月24号 深圳校区</a>
                </div>
                <a href="/activeCourse/addUserInfo/60.html" class="BBut block text_center f28 fz bold border-radius50 mt26"><img src="/images/zt/acsm/zhua.png" alt="">报名前请——完善学员身份信息</a>
            </div>
            <!--按钮切换 end-->


            <!-- 在赛普健身社区报名 start -->
            <div>
                <img src="/images/zt/acsm/jgImg1.jpg" alt="">
                {{--<img src="/images/zt/acsm/jgImg2.jpg" alt="">--}}
                <div class="jgimg2Bg fz f28 color_333 line36 text-jus ">
                    <ul class="relative">
                        <li class="mb10">邀请5个好友助力，赛普补贴1000元</li>
                        <li class="mb10">邀请10个好友助力，赛普补贴2000元</li>
                        <li class="mb10">邀请15个好友助力，赛普补贴2500元</li>
                        <li class="">邀请20个好友助力，赛普补贴3000元</li>
                        <li class="posa text_center f24 bold">最低2800元,即可报名ACSM中文CPT认证课程</li>
                    </ul>
                </div>
                <img src="/images/zt/acsm/jgImg3.jpg" alt="">
            </div>
            <!-- 在赛普健身社区报名 end -->
            <!-- 课程大纲 start -->
            <div class="">
                <img src="/images/zt/acsm/dgtit.jpg" alt="">
                <img src="/images/zt/acsm/dgImg.jpg" alt="">
                <p class="fz f24 text_center color_fff plr40">5天，深度讲解解剖学、营养学等专业知识 基于会员伤病筛查，出具更科学符合会员的训练方案。</p>
            </div>
            <!-- 课程大纲 end -->
            <!-- 认证证书 start -->
            <div class="mb40">
                <img src="/images/zt/acsm/zsImg.jpg" alt="">
                <img src="/images/zt/acsm/zsImg2.jpg" alt="">
                <p class="fz f24 text_center color_fff plr40 pt40 mt30">完课并通过考核，即可获得ACSM中文CPT认证证书。</p>
            </div>
            <!-- 认证证书 end -->
            <!-- 考试条件 start -->
            {{--<div class="">--}}
                {{--<img src="/images/zt/acsm/kstjImgtit.jpg" alt="">--}}
                {{--<img src="/images/zt/acsm/kstjImg.jpg" alt="">--}}
            {{--</div>--}}
            <!-- 考试条件 end -->
            <!-- 常见问题 start-->
            <div class="changjianwentiTit text_center fz bold bgcolor_orange">
                <h4 class=" f36">常见问题</h4>
                <p class="f16 ">COMMON PROBLEMS</p>
            </div>
            <div class="plr35 common_box color_fff pt78">
                <dl class="clearfix mb40">
                    <dt class="text_center lt f37 color_orange">1</dt>
                    <dd>
                        <h3 class="lt f30 color_orange">什么时候开课？</h3>
                        <p class="fz f24 text-jus">本课程将于每月9号在赛普北京、深圳、上海校区同步开始，报名后会有老师与您联系。为您安排班级。</p>
                    </dd>
                </dl>
                <dl class="clearfix mb40">
                    <dt class="text_center lt f37 color_orange">2</dt>
                    <dd>
                        <h3 class="lt f30 color_orange">怎么获取证书</h3>
                        <p class="fz f24 text-jus">课程学习结束后，会为您安排考试，通过考试即可获取证书。获取的证书需在3年内修够45个继续教育学分（不限于研讨会、工作坊进修学习）才可生效。</p>
                    </dd>
                </dl>
                <dl class="clearfix mb40">
                    <dt class="text_center lt f37 color_orange">3</dt>
                    <dd>
                        <h3 class="lt f30 color_orange">考试需要交费吗？</h3>
                        <p class="fz f24 text-jus">参与考试需另外缴纳考试费，考试费用为2800元/次，补考费用为1400元/次。</p>
                    </dd>
                </dl>
                <dl class="clearfix mb40">
                    <dt class="text_center lt f37 color_orange">4</dt>
                    <dd>
                        <h3 class="lt f30 color_orange">ACSM中文CPT认证和ACSM认证一样吗？</h3>
                        <p class="fz f24 text-jus">ACSM中文CPT以ACSM-CPT体系为基础，将ACSM CPT课程体系中文化，同时结合国人体质及中国法律规定，对营养学及法律模块进行中国本土化优化，开发出更贴合中国市场的ACSM CPT培训课程。</p>
                    </dd>
                </dl>
                <dl class="clearfix mb40">
                    <dt class="text_center lt f37 color_orange">5</dt>
                    <dd>
                        <h3 class="lt f30 color_orange">考试形式是什么？</h3>
                        <p class="fz f24 text-jus">中文考试，2019 年实行纸质考核（试卷+答题卡），预计2020年上线计算机考核。</p>
                    </dd>
                </dl>
            </div>
            <!-- 常见问题 end-->
        </div>
        <!-- 内容 end-->


        <!-- 悬浮底部 start-->
        <div class="foot plr20 bgcolor_fff">
            <div class="foot_uu">
                <ul class="clearfix">
                    <li class="xiaoqu">
                        <div class="fz f26 bold h_box block">
                            <p>11月24号</p>
                            <p>北京校区</p>
                        </div>
                        <div class="fz f26 bold h_box">
                            <p>12月24号</p>
                            <p>北京校区</p>
                        </div>
                        {{--<div class="fz f26 bold h_box">--}}
                            {{--<p>11月9号</p>--}}
                            {{--<p>上海校区</p>--}}
                        {{--</div>--}}
                        <div class="fz f26 bold h_box">
                            <p>12月24号</p>
                            <p>上海校区</p>
                        </div>
                        {{--<div class="fz f26 bold h_box">--}}
                            {{--<p>11月9号</p>--}}
                            {{--<p>深圳校区</p>--}}
                        {{--</div>--}}
                        <div class="fz f26 bold h_box">
                            <p>12月24号</p>
                            <p>深圳校区</p>
                        </div>

                    </li>
                    @if($mobile)
                        @if($course_buyed)
                            <li class="mashang text_center bgcolor_orange border-radius-img open-popup">
                                <div>
                                    <p class="fz bold f30 color_red_be3f00"><span class="color_333">已报名</span></p>
                                </div>
                            </li>
                        @else
                            @if($add_info)
                            <li class="mashang text_center bgcolor_orange border-radius-img open-popup" data-target="#half">
                                <div>
                                    <p class="fz bold f30 color_red_be3f00">￥{{$price}}元<span class="color_333">马上报名</span></p>
                                </div>
                            </li>
                            @else
                                <li class="mashang text_center bgcolor_orange border-radius-img open-popup" onclick="javascript:window.location='/activeCourse/addUserInfo/{{$courseClass->id}}.html?fid={{$fission_id}}'">
                                    <div>
                                        <p class="fz bold f30 color_red_be3f00">￥{{$price}}元<span class="color_333">马上报名</span></p>
                                    </div>
                                </li>
                            @endif
                        @endif
                    @else
                        <li class="mashang text_center bgcolor_orange border-radius-img open-popup" onclick="userlogin();">
                            <div>
                                <p class="fz bold f30 color_red_be3f00">￥5800元<span class="color_333">马上报名</span></p>
                            </div>
                        </li>
                    @endif
                    @if($mobile)
                        <li class="zhuli text_center border-radius-img RuleCodeWBtn">
                            <a href="javascript:void (0)" class="block color_fff">
                                <p class="fz f22">好友助力报名</p>
                                <p class="fz f26 bold">补贴3000元</p>
                            </a>
                        </li>
                    @else
                        <li class="zhuli text_center border-radius-img" onclick="userlogin();">
                            <a href="javascript:void (0)" class="block color_fff">
                                <p class="fz f22">好友助力报名</p>
                                <p class="fz f26 bold">补贴3000元</p>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <!-- 悬浮底部 end-->
    </div>

    <!--右侧悬浮 【微信】 start-->
    <div class="relative codeWBtn">
        <div class="right-suspension_wx text_center pt10 right_Float_wx">
            <a href="javascript:void (0)">
                <img src="/activity/award/images/zt/giftgive/weixin.png" alt="">
                <p class="fz f20 bold">微信咨询</p>
            </a>
        </div>
    </div>
    <!--右侧悬浮 【微信】 end-->


    <!--右侧悬浮 【分销】start-->
    @if($is_staff)
    <div class="right-Invitation text_center open-popup" data-target="#Invitation">
        <a href="javascript:void(0)" class="color_fff fz f24 bold plr25">分销</a>
    </div>
    @endif
    <!--右侧悬浮 【邀请】end-->
    <!--右侧悬浮 【查看助力情况】start-->
    <div class="right-Invitation right-Zhuli text_center" >
        <a href="/dist/buy/a60.html" class="color_333 bgcolor_orange bold fz f26 plr25">查看助力情况</a>
    </div>
    <!--右侧悬浮 【查看助力情况】end-->


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
                        <button style="border: " class="roy_btn bgcolor_orange payBtn">立即付款</button>
                    @else
                        <a href="userlogin();" class="roy_btn bgcolor_orange payBtn">立即付款</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- 底部弹出popup end -->


    <!--底部弹出popup 邀请内容 start-->
    <div>
        <div id="Invitation" class="weui-popup__container popup-bottom">
            <div class="weui-popup__overlay"></div>
            <div class="weui-popup__modal">
                <div class="toolbar bgcolor_fff ">
                    <div class="tabbs">
                        <a href="javascript:;" class="picker-button close-popup">关闭</a>
                    </div>
                </div>
                <!--你的内容放在这里... start-->
                <div class="text_center pt98 bgc_white fz">
                    <h3 class="mb40 color_ff6d1e f40 bold">分享赚取佣金</h3>
                    <p class="f26 color_gray666">分享下方链接/图片给好友，</p>
                    <p class="f26 color_gray666">好友报名后，你可获得好友实际支付金额的5%作为佣金~</p>
                    <p class="f26 color_gray666">在分销中心课看到你的分销记录哦~</p>

                    <div class="InvBtn plr30 clearfix fz pb30 pt40 mt30">
                        <a href="javascript:void (0)" class="fl bg_ff9a03 f24 border-radius-img shareRulelink"><img src="/images/zt/biglesson/icon-w.png" alt="">分享链接</a>
                        <a href="javascript:void (0)" class="fl bg_ff9a03 f24 border-radius-img shareRuleImg">分享图片</a>
                        <a href="/dist/sale/index.html" class="fl bg_ff9a03 f24 border-radius-img">分销中心</a>
                    </div>
                </div>
                <!--你的内容放在这里... end-->
            </div>
        </div>
    </div>
    <!--底部弹出popup 邀请内容 end-->

</div><!--导航大盒子id=page 结束-->

<br><br><br><br><br>
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
            title: '{{$courseClass->title}}', // 分享标题
            desc: '{{$courseClass->seo_description}}', // 分享描述
            link: "http://m.saipubbs.com/course/detail/60.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            {{--link: "http://m.saipubbs.com/nasm/active.html?fid={{$user_id}}",--}}
            imgUrl: "{{env('IMG_URL')}}{{$courseClass->cover_url}}", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '{{$courseClass->title}}', // 分享标题
            link: "http://m.saipubbs.com/course/detail/60.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            {{--link: "http://m.saipubbs.com/nasm/active.html?fid={{$user_id}}",--}}
            imgUrl: "{{env('IMG_URL')}}{{$courseClass->cover_url}}", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });

</script>


<script>
    $("body").addClass("bgcolor_000");
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
    //分享链接弹窗
    $('.shareRulelink').click(function(){
        $.closePopup();//关闭底部弹出【邀请】
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
            content: '<div class="text_center tan-font color_fff f32 fz ptb86 fx-img" >' +
            '<img src="/images/fenxiang-j.png" class="fx_success down-arrow d-in-black" id="dou" alt="" />' +
            '<p class="pt40 color_fff f36 fz bold ">点击这里分享吧！</p>' +
            '<p class="text_left pl135 pt40 pb30">1、点击“<img src="/images/more.png" alt="" class="d-in-black more-s">”</p>' +
            '<p class="text_left pl135">2、点击“<img src="/images/pyq.png" alt="" class="d-in-black more-s">”分享到朋友圈</p>' +
            '</div>',
            btn: false,
            success: function(v){
                /*点击文字也可以全部关闭*/
                $('.fxpyq_success_layer_wrap').click(function(){
                    parent.layer.closeAll()
                });
            }
        });
    });


    //分享箭头样式
    var i=0;
    $(document).ready(function(){
        setInterval('gaibian()',1000);
    });
    function gaibian(){
        if(i==0){
            i=1;
            $("#dou").removeClass("zhuan_left");
            $("#dou").addClass("zhuan_right");
        }else{
            i=0;
            $("#dou").addClass("zhuan_left");
            $("#dou").removeClass("zhuan_right");
        }
    }

    //跳转登陆函数
    var userlogin = function(){
        var url = "/course/detail/"+c_c_id+".html?fission_id={{$fission_id}}";
        localStorage.setItem("redirect", url);

        layer.msg('请先注册');
        setTimeout(function(){
            window.location.href = "/register";
        }, 500)
    }
    var time = '1';
    var city = '1';
    $(function () {
        $('.zaoniao_btn a').click(function () {
            time = $(this).attr('data-id');
            city = $(this).attr('data-city');
            $(this).addClass('bg_orange_active').siblings().removeClass('bg_orange_active');
            var index=$(this).index();
            $(".foot .foot_uu ul li.xiaoqu .h_box").eq(index).show().siblings().hide().removeClass("block");
        });

        //分享海报弹窗
        $('.shareRuleImg').click(function () {
            $.closePopup();//关闭底部弹出【分销】

            var data = {id:c_c_id,_token:'{{csrf_token()}}'};
            $.ajax({
                url:'/activeCourse/acsm/poster',
                data:data,
                type:'POST',
                dataType:'json',
                success:function(res){

                    if(res.code == 0){
                        var content = '<div class="friend_layer text_center tan-font"><img src="'+res.data.img+'" class="bm_success" alt="" /></div>';
                        layer.open({
                            type: 1,
                            title: false, //不显示标题栏
                            skin: 'friend_layer', //样式类名
                            id: 'friend_layer', //设定一个id，防止重复弹出
                            closeBtn: 1, //不显示关闭按钮
                            anim: 2,
                            shadeClose: true, //开启遮罩关闭
                            area: ['90%', '80%'],
                            content: content,
                            btn: false
                        });
                    }
                }
            });

        });


        //二维码弹窗
        $('.codeWBtn').click(function(){
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'codeW_layer_wrap', //样式类名
                id: 'codeW_layer', //设定一个id，防止重复弹出
                closeBtn: 1, //不/显示关闭按钮
                anim: 2,
                shadeClose: 1, //开启/关闭遮罩
                shade: [0.7, '#000'],
                area: ['30%', '60%'],
                content:'<div class="hideWImg text_center mt32">' +
                '<p class="fz f30 color_333 mb20 bold pt20">微信二维码登陆</p>' +
                '<img src="/images/zt/acsm/wxconsult.jpeg" alt="赛普健身社区">' +
                '<p class="plr30 fz f30 color_333 mt20">' +
                '<span class="block bold">咨询课程问题 </span>' +
                '<span class="block bold">请扫码添加导师微信 </span>' +
                '<span class="block bold">“备注：ACSM”</span>' +
                '</p>' +
                '</div>',
                btn:false
            });
        });

        //二维码弹窗 [好友助力报名，最低2800元]
        $('.RuleCodeWBtn').click(function(){
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'codeW_layer_wrap', //样式类名
                id: 'codeW_layer2', //设定一个id，防止重复弹出
                closeBtn: 1, //不/显示关闭按钮
                anim: 2,
                shadeClose: 1, //开启/关闭遮罩
                shade: [0.7, '#000'],
                area: ['30%', '60%'],
                content:'<div class="hideWImg text_center mt32">' +
                '<p class="fz f30 color_333 bold mb20 pt20">扫描二维码</p>' +
                '<p class="fz f30 color_333 bold mb20">关注赛普健身社区公众号</p>' +
                '<img src="{{$code}}" alt="赛普健身社区">' +
                '<p class="plr30 fz f32 color_333 mt20">' +
                '<span class="block bold">获取活动通道</span>' +
                '</p>' +
                '</div>',
                btn:false
            });
        });

        //立即付款弹出框
        $('.payBtn').click(function (){
            var payfrom = $("input[name='radio1']:checked").val();
            if(payfrom=='BANLANCE'){
                $.closePopup()
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








