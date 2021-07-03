<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-线下课程报名</title>
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

    {{--本页面css--}}
    <link rel="stylesheet" href="/css/zt/zt_bigclass.css">

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
            <img src="{{env('IMG_URL')}}{{$data->explain_url}}" alt="">
        </div>
        <!-- banner end-->

        <!-- 内容 start-->
        <div class="content">
            <h2 class="f30 bold color_000 fz plr30 ptb30">{{$data->title}}</h2>

            <!--按钮切换 start-->
            <div class="ptb20">
                <div class="zaoniao_btn mt60 plr25 clearfix text_center relative">
                    <a href="javascript:void (0)" onclick="zao_show1();" class="button border-radius50 fz f24 bga">10月9号开班</a >
                    <a href="javascript:void (0)" onclick="zao_show2();" class="button border-radius50 fz f24 ">11月9号开班</a >
                    <a href="javascript:void (0)" onclick="zao_show3();" class="button border-radius50 fz f24 ">11月9号开班</a >
                </div>
            </div>
            <!--按钮切换 end-->

            <h3 class="text_center fz bold color_orange f30 ptb30 borderTB">课程简介</h3>

            <!-- 课程先导 start-->
            <div class="plr30">
                <h3 class="f28 color_333 bold fz ptb30">课程先导</h3>

                <!-- 视频 start -->
                <div class="video">
                    <div class="box2 ">
                        @if($data->id ==60)
                        <img src="/images/coursev60.jpg" alt=""/>
                        @else
                        <img src="/images/coursev1.jpg" alt=""/>
                        @endif
                        <div class="mask"></div>
                        <span class="btn_play"></span>
                    </div>
                    <video src="{{$data->preview_video}}" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto" ></video>
                </div>
                <!-- 视频 end -->

                <!-- 这里有课程介绍长图 start-->
                <div class="mt30">
                    <?php
                    echo $data->introduction;
                    ?>

                </div>
                <!-- 这里有课程介绍长图 end-->

            </div>
            <!-- 课程先导 end-->
        </div>
        <!-- 内容 end-->


        <!-- 悬浮按钮 start-->
        <div class="foot plr20 bgcolor_fff">
            <div class="foot_u">
                <ul class="clearfix">
                    <li class="leftW clearfix plr20" id="zao1">
                        <div class="fl nth1">
                            <span class="block fz f22 bold">10月9日开班</span>
                            <span class="block fz f22 bold">还剩<span class="color_be3f00">50</span>个名额</span>
                        </div>
                        <div class="fr nth2">
                            <img src="/images/wanshan.png" alt="">
                            <span class="fz f22 block text_center">已完善<!--请完善--></span>
                        </div>
                    </li>
                    <li class="leftW clearfix plr20 none" id="zao2">
                        <div class="fl nth1">
                            <span class="block fz f22 bold">10月9日开班</span>
                            <span class="block fz f22 bold">还剩<span class="color_be3f00">51</span>个名额</span>
                        </div>
                        <div class="fr nth2">
                            <img src="/images/wanshan.png" alt="">
                            <span class="fz f22 block text_center">已完善<!--请完善--></span>
                        </div>
                    </li>
                    <li class="leftW clearfix plr20 none" id="zao3">
                        <div class="fl nth1">
                            <span class="block fz f22 bold">10月9日开班</span>
                            <span class="block fz f22 bold">还剩<span class="color_be3f00">52</span>个名额</span>
                        </div>
                        <div class="fr nth2">
                            <img src="/images/wanshan.png" alt="">
                            <span class="fz f22 block text_center">已完善<!--请完善--></span>
                        </div>
                    </li>


                    <li class="rightW bgcolor_orange border-radius-img plr20">
                        <div class="clearfix text_center">
                            <p class="fz color_5c2a0c open-popup" data-target="#half">
                                <span class="f43 mr20 color_be3f00">￥500<b class="f19">元</b></span>
                                <span class="f30 f30">马上报名</span>
                            </p >
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- 悬浮按钮 end-->


        <!-- 悬浮按钮 start-->
        {{--<div class="Baoming fz">--}}
            {{--@if($mobile==0)--}}
            {{--<button class="fl bold f34 color_333 bgcolor_orange open-popup" onclick="userlogin()">￥{{$price}} 马上报名</button>--}}
            {{--<button class="fr bold f34 color_333 bgcolor_orange" onclick="userlogin()">报名必填信息</button>--}}
            {{--@else--}}
                {{--@if($is_buy)--}}
                    {{--<button class="bold f34 color_333 Baoming bgcolor_orange open-popup">已报名</button>--}}
                {{--@else--}}
                    {{--@if($add_info)--}}
                    {{--<button class="bold f34 color_333 Baoming bgcolor_orange open-popup" data-target="#half">￥{{$price}} 马上报名</button>--}}
                    {{--@else--}}
                        {{--<button class="bold f34 color_333 Baoming bgcolor_orange open-popup" onclick="javascript:window.location='/activeCourse/addUserInfo/{{$data->id}}.html?fid={{$fission_id}}'">￥{{$price}} 马上报名</button>--}}
                    {{--@endif--}}
                {{--@endif--}}
                {{--@if($add_info)--}}
                    {{--<button class="fr bold f34 color_333 bgcolor_orange" onclick="javascript:window.location='/activeCourse/addUserInfo/{{$data->id}}.html?fid={{$fission_id}}'">报名信息已填</button>--}}
                {{--@else--}}
                    {{--<button class="fr bold f34 color_333 bgcolor_orange" onclick="javascript:window.location='/activeCourse/addUserInfo/{{$data->id}}.html?fid={{$fission_id}}'">报名必填信息</button>--}}
                {{--@endif--}}
            {{--@endif--}}


        {{--</div>--}}
        <!-- 悬浮按钮 end-->
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
                            {{--<p class="f32 color_333 bold">课程原价</p>--}}
                            <p class="f32 color_333 bold">价格</p>
                        </div>
                        <div class="weui-cell__ft price color_333 bold f28 bold">{{$price}}元</div>
                    </div>

                </div>

                <div class="weui-cells weui-cells_radio nobefore noafter  dd">
                    <label class="weui-cell weui-check__label" for="x11">
                        <div class="weui-cell__bd f28">
                            <p><i class="ico_wx"></i>微信支付</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" class="weui-check" name="radio1" id="x11" value="WXPAY" checked />
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

    <!--右侧悬浮 【邀请】start-->
    {{--@if($is_staff)--}}
    <div class="right-Invitation text_center open-popup" data-target="#Invitation">
        <a href="javascript:void(0)" class="color_fff fz f30 plr25"><img src="/images/zt/biglesson/icon-m.png" alt="" class="">邀请</a>
    </div>
    {{--@endif--}}
    <!--右侧悬浮 【邀请】end-->

    <!--底部弹出popup 邀请内容 start-->
    <div>
        <div id="Invitation" class="weui-popup__container popup-bottom">
            <div class="weui-popup__overlay"></div>
            <div class="weui-popup__modal">
                <div class="toolbar bgcolor_fff ">
                    <div class="tabbs">
                        <a href="javascript:void(0);" class="picker-button close-popup">关闭</a >
                    </div>
                </div>
                <!--你的内容放在这里... start-->
                <div class="text_center pt98 bgc_white fz">
                    <h3 class="mb40 color_ff6d1e f40 bold">分享赚佣金（销售额的5%）</h3>
                    <p class="f26 color_gray666">朋友通过你分享的页面成功购买后，</p>
                    <p class="f26 color_gray666">你可以获得相应的佣金。</p>
                    <p class="f26 color_gray666">佣金可在【我的分销员中心】查看</p>

                    <div class="InvBtn plr30 clearfix fz pb30 pt40 mt30">
                        <a href="javascript:void (0)" class="fl bg_ff9a03 f24 border-radius-img wxfx"><img src="/images/zt/biglesson/icon-w.png" alt="">分享链接</a>
                        <a href="/wechat/share/{{$data->id}}.html" class="fl bg_ff9a03 f24 border-radius-img">分享图片</a>
                        <a href="/dist/sale/index.html" class="fl bg_ff9a03 f24 border-radius-img">分销中心</a>
                    </div>
                </div>
                <!--你的内容放在这里... end-->
            </div>
        </div>
    </div>
    <!--底部弹出popup 邀请内容 end-->

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
        $content = explode(PHP_EOL,$data->seo_description);
        $art = '';
        foreach($content as $cont){
            $art .= trim($cont);
        }
    ?>
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: '{{$data->title}}', // 分享标题
            desc: '{{$art}}', // 分享描述
            link: "http://m.saipubbs.com/course/detail/{{$data->id}}.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "{{env('IMG_URL')}}{{$data->cover_url}}", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '{{$data->title}}', // 分享标题
            link: "http://m.saipubbs.com/course/detail/{{$data->id}}.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "{{env('IMG_URL')}}{{$data->cover_url}}", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });

</script>

<script>
    //播放视频
    $(function (){
        $('.video .box2').click(function(){
            $(this).hide();
            $(this).next().trigger('play');
        })
    })

    //分享弹窗
    $('.wxfx').click(function(){
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
</script>
<script>
    var user_id   = "{{$user_id}}";      //用户id
    var c_c_id    = "{{$data->id}}";     //课程id
    var is_weixin = "{{$is_weixin}}";  //是否为微信浏览器
    var token     = '{{csrf_token()}}';
    var mobile    = "{{$mobile}}";
    var subscribe = "{{$subscribe}}";
    //将裂变者id写入本地  用于存储上下级关系
    var fission_id = "{{$fission_id}}";
    var storage_fis_id = localStorage.getItem('intro_fission_id');

    if(fission_id>0){
        localStorage.setItem("fission_id", fission_id);
        localStorage.setItem('intro_fission_id',fission_id);

    }else{
        if(storage_fis_id == null || storage_fis_id == ''){
            fission_id = 0;
        }else{
            fission_id = storage_fis_id;
        }
    }
    //将注册来源页面写入存储
    localStorage.setItem("channel", "course"+c_c_id);

    //免费报名成功或者购买成功后跳转
    function href_go(){

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



    //调用微信JS api 支付
    function jsApiCall()
    {
        var _token = '{{csrf_token()}}';
        var data = {class_id:c_c_id,fission_id:fission_id,_token:_token};
        $.ajax({
            url:'/activeCourse/buy',
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

    $(function (){
        //折叠面板
        $('#accordion .link').click(function (){
            if($(this).parents('li').hasClass('open')){
                $('#accordion >li').removeClass('open')
                /*return false;*/
            }else{
                $(this).parents('li').addClass('open').siblings().removeClass('open');
                $(this).find('i').addClass('up').parents('.item').siblings().find('i').removeClass('up');
            }
            var h=$('#accordion').height()
            //console.log($('.open .submenu').height())
            $('.tempWrap').height(h)
        })
        //不支持试看视频
        $(".no_preview").click(function(){
            $.closePopup()
            $.confirm({
                title: '提示',
                text: '立即购买学习该课程，确认购买吗？',
                onOK: function () {

                    $('#studyBtn').trigger('click');
                },
                onCancel: function (){

                }
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
                        url:"/course/payh",
                        data:{course_class_id:c_c_id,fission_id:fission_id,_token:token},
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
            }else if(payfrom == "SPB"){
                $.closePopup()
                $.confirm({
                    title: '提示',
                    text: '立即购买学习该课程，确认购买吗？',
                    onOK: function () {
                        $.ajax({
                            type:"get",
                            url:"/course/paySpb",
                            data:{c_c_id:c_c_id,user_id:user_id},
                            dataType:"json",
                            success:function(data){
                                console.log(data);
                                if(data.code == 1){
                                    layer.msg(data.msg);
                                    setTimeout(function(){
                                        href_go();     //支付成功跳转
                                    },1500)  //延迟1.5秒刷新页面
                                }else{
                                    layer.msg(data.msg);
                                }
                            }


                        })
                    },
                    onCancel: function (){
                    }
                });
            }

        })

        //免费报名课程
        $("#enroll").click(function(){
            var id = '{{$data->id}}';
            var user_id = '{{$user_id}}';
            $.get("/course/enroll",{course_class_id:id,user_id:user_id},function(result){
                if(result == 0){
                    layer.msg('报名成功');
                    setTimeout(function(){
                        href_go();     //支付成功跳转
                    },1500)  //延迟1.5秒
                }else{
                    layer.msg('网络错误，稍后请重试');
                }
            })
        })
    })


    /*早鸟价*/
    function zao_show1(){
        document.querySelectorAll(".button")[0].classList.add("bga");
        document.querySelectorAll(".button")[1].classList.remove("bga");
        document.querySelectorAll(".button")[2].classList.remove("bga");

        document.getElementById("zao1").classList.remove("none");
        document.getElementById("zao2").classList.add("none");
        document.getElementById("zao3").classList.add("none");
    }

    function zao_show2(){
        document.querySelectorAll(".button")[1].classList.add("bga");
        document.querySelectorAll(".button")[0].classList.remove("bga");
        document.querySelectorAll(".button")[2].classList.remove("bga");

        document.getElementById("zao1").classList.add("none");
        document.getElementById("zao2").classList.remove("none");
        document.getElementById("zao3").classList.add("none");

    }
    function zao_show3(){
        document.querySelectorAll(".button")[2].classList.add("bga");
        document.querySelectorAll(".button")[1].classList.remove("bga");
        document.querySelectorAll(".button")[0].classList.remove("bga");

        document.getElementById("zao1").classList.add("none");
        document.getElementById("zao2").classList.add("none");
        document.getElementById("zao3").classList.remove("none");

    }
</script>









