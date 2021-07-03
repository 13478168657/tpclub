<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-{{$distClass->title}}</title>
    <meta name="author" content="啾啾" />
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
    <link href="/css/font-num40.css" rel="stylesheet" />
    <script src="/js/jquery-1.11.2.min.js"></script>
    <script src="/js/jquery.SuperSlide.2.1.1.js" type="text/javascript"></script>

    <!--本css-->
    <link rel="stylesheet" href="/css/fenxiaoliucheng_clock.css?t=1.2" />
    <link rel="stylesheet" href="/css/zt/zt_payment.css?t=1">
    <link rel="stylesheet" type="text/css" href="/css/zt/zt_RightFloat.css">

    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
</head>
<body>

<!---导航右侧带导航弹出---->

<div><!--导航大盒子id=page 开始  【结束在最底部】-->



    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--banner start-->
    <div>
        {{--<img src="/images/clock/img/banner.png" alt="">--}}
        <img src="{{env('IMG_URL')}}/{{$distClass->head_url}}" alt="">
    </div>
    <!--banner end-->


    <div class="bgcolor_fff pb15">
        <div class="time_class_box ptb45 plr30">
            <ul class="clearfix">
                <li>
                    <p class="color_gray666 f20 fz text_left">单独购买:<strong class="f38 bold color_ff7200">{{$distClass->price}}</strong><span class="color_ff7200">元</span></p>
                </li>
                <li>
                    <p class="color_gray666 f20 fz text_center">单独购买:{{$distClass->price}}元</p>
                </li>
                <li>
                    <p class="color_gray666 f20 fz text_right">拼团购买:<strong class="f38 bold color_ff7200">{{$distClass->team_price}}</strong><span class="color_ff7200">元</span></p>
                </li>
            </ul>
        </div>
        @if($period)
            <div class="time_day_box plr30 pb30">
                <p class="text_center border-radius-img bg_ff9a03 f28">{{$period->name}} {{date('Y年m月d日',strtotime($period->begin_time))}} 开课</p>
            </div>
        @endif
    </div>
    <!-- 时间 end -->
    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--====================================本喵是分割线  喵喵~========================================================-->
    <div class="bgcolor_000 sp pb60 pt70">
        <p class="fz color_fff bold text_center f34 border-radius50 line-x"><i></i> 课程试看 <i></i></p>
        <!--视频 start-->
        <div class="plr30 pt40">
            <div class="video">
                <div class="box2">
                    <img src="{{env('IMG_URL')}}/{{$distClass->video_img_url}}" alt=""/>
                    <div class="mask"></div>
                    <span class="btn_play"></span>
                </div>
                <video id="video" src="{{$distClass->video_url}}" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto" ></video>
            </div>
        </div>
        <!--视频 end-->
        <span class="block fz f30 pt40 color_fff text_center">{{$distClass->video_title}}</span>
    </div>
    <div class="bgcolor_000">
        <p class="text_center color_orange f26 fz mlr30 zhan-lie ptb65 btn_open">点击查看全部课程内容 <img src="/images/clock/jiant.png" alt="" class="j-img"></p>
        <div class="imgs hide">
            <img src="{{env('IMG_URL')}}/{{$distClass->course_desc}}" class="img100" />
        </div>
    </div>
    <!--====================================本喵是分割线  喵喵~========================================================-->
    <div>
        <img src="{{env('IMG_URL')}}/{{$distClass->inc_url}}" alt="">
    </div>

    <div class="relative">
        <div class="footers plr20 bg_fdf3cc">
            <ul class="clearfix mt20">
                @if(!$is_buy)
                    <li class="fl fz f30 text_center border-radius-img"><button class="studyBtn open-popup" data-target="#half"><span class="f36">{{$distClass->price}}元&nbsp;&nbsp;</span>单独购买</button></li>
                    <li class="fr fz f30 text_center border-radius-img"><button class="studyBtn open-popup" data-target="#halfs"><span class="color_red f36">{{$distClass->team_price}}元&nbsp;&nbsp;</span>{{$distClass->team_people}}人拼团</button></li>
                @else
                    @if($disOrder && $disOrder->buy_way == 'TEAM')
                        <li data-id="" class="fr newclassbtn fz f30 text_center border-radius-img is_buy" style="width:100%;"><a href="/train/success/t{{$distClass->id}}.html" class="studyBtn">邀请好友</a></li>
                    @else
                        <li data-id="" class="fr newclassbtn fz f30 text_center bgcolor_dedede border-radius-img is_buy" style="width:100%;"><a href="javascript:void(0);" class="studyBtn">已购买</a></li>
                    @endif
                @endif
            </ul>
        </div>
    </div>
    <!--悬浮btn end-->
    <!--右侧悬浮 【分销】start-->
    @if($is_dis)
    <div class="right-Invitation text_center open-popup" data-target="#Invitation">
        <a href="javascript:void(0)" class="color_fff fz f24 bold plr25">分销</a>
    </div>
    @endif
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
    <!--====================================本喵是分割线  喵喵~========================================================-->

    <!-- 底部弹出popup start -->
    <div id="half" class='weui-popup__container popup-bottom payType_popup'>
        <div class="weui-popup__overlay"></div>
        <div class="weui-popup__modal fz">
            <div class="toolbar">
                <div class="toolbar-inner">
                    <a href="javascript:;" class="picker-button close-popup">关闭</a>
                    <h1 class="title">确认付款</h1>
                </div>
            </div>

            <div class="modal-content bgc_white">
                <div class="weui-cell weui-cell">
                    <div class="weui-cell__bd">
                        <h2 class="f28">课程费用</h2>
                    </div>
                    <div class="weui-cell__ft">
                        @if($is_dis)
                            <span class="price">0元</span>
                        @else
                            <span class="price">{{$distClass->price}}元</span>
                        @endif
                    </div>
                </div>
                <div class="weui-cells weui-cells_radio noafter  dd">
                    <label class="weui-cell weui-check__label" for="x11">
                        <div class="weui-cell__bd f28">
                            <p><i class="ico_wx"></i>微信支付</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" class="weui-check" name="radio1" id="x11" checked="checked" value="WXPAY">
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>
                    <label class="weui-cell weui-check__label disabled_xueyuan" for="x12">
                        <div class="weui-cell__bd f28">
                            <p><i class="ico_balance"></i>余额支付</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" name="radio1" class="weui-check" id="x12" value="WXPAY">
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>

                </div>
                <div class="container_btn ptb20">
                    <a href="javascript:void(0);" data-type="single" class="roy_btn bgcolor_orange payBtn">立即付款</a>
                </div>
            </div>
        </div>
    </div>
    <!-- 底部弹出popup end -->
    <!-- 底部弹出popup start -->
    <div id="halfs" class='weui-popup__container payType_popup popup-bottom'>
        <div class="weui-popup__overlay"></div>
        <div class="weui-popup__modal fz">
            <div class="toolbar">
                <div class="toolbar-inner">
                    <a href="javascript:;" class="picker-button close-popup">关闭</a>
                    <h1 class="title">确认付款</h1>
                </div>
            </div>

            <div class="modal-content bgcolor_fff">
                {{--<div class="plr40 mor_list fz color_333">--}}
                    {{--<h3 class="ptb20 f32 bold">产后实战精英私教训练营（第2期）</h3>--}}
                    {{--<ul class="ptb30 f26 text-jus">--}}
                        {{--<li>2人拼团购买，每人仅需459元</li>--}}
                        {{--<li>付款后才能成功发起拼团，成为团长</li>--}}
                        {{--<li>成为团长后按照提示分享给好友，好友付款后视为拼团成功</li>--}}
                        {{--<li>注：如果24小时内未完成拼团，或课程报名人数已满，系统会自动取消该订单，并完成退款，团长可重新选择最新班期再次发起拼团</li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
                <div class="weui-cell weui-cell">
                    <div class="weui-cell__bd">
                        <h2 class="f28 bold">{{$distClass->team_people}}人拼团价</h2>
                    </div>
                    <div class="weui-cell__ft">
                        <span class="price">{{$distClass->team_price}}元</span>
                    </div>
                </div>
                <div class="weui-cell weui-cell">
                    <div class="weui-cell__bd">
                        <h2 class="f28">最终合计</h2>
                    </div>
                    <div class="weui-cell__ft">
                        <span class="price">{{$distClass->team_price}}元</span>
                    </div>
                </div>
                <div class="weui-cells weui-cells_radio noafter  dd">
                    <label class="weui-cell weui-check__label" for="x14">
                        <div class="weui-cell__bd f28">
                            <p><i class="ico_wx"></i>微信支付</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" class="weui-check" name="radio2" id="x14" checked="checked" value="WXPAY">
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>

                </div>

                <div class="container_btn ptb20">
                    <a href="javascript:void(0);" data-type="PT" class="roy_btn bgcolor_orange payBtn">立即付款</a>
                </div>
            </div>
        </div>
    </div>
    <!-- 底部弹出popup end -->
    <!--====================================本喵是分割线  喵喵~========================================================-->

    <!--右侧悬浮 【微信】 start-->
    <div class="relative codeWBtn">
        <div class="right-suspension_wx text_center pt10 right_Float_wx">
            <a href="javascript:void (0)">
                <img src="/images/zt/wexin.png" alt="">
                <p class="fz f20 bold">微信咨询</p>
            </a>
        </div>
    </div>
    <!--右侧悬浮 【微信】 end-->

</div><!--导航大盒子id=page 结束-->



<br><br><br><br><br><br>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script src="/lib/layer/layer.js"></script>

<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->

<script>
    $('body').addClass('bgcolor_fff3bd');

    $(function() {
        //视频
        $('.video .box2').click(function(){
            $(this).hide();
            $(this).next().trigger('play');

        });

        //展开
        $('.btn_open').click(function (){
            $(this).hide();
            $(this).siblings().show();
        })
    });

</script>
<script type="text/javascript">

    //跳转登陆函数
    var dist_id = '{{$dist_id}}';
    var fission_id = "{{$dist_id}}";
    if(fission_id>0){
        localStorage.setItem("fission_id", fission_id);
    }
    var class_id = '{{$dis_course_id}}';
    var url = 'http://m.saipubbs.com/dist/buy/'+class_id+'.html?dis='+dist_id;
    var userlogin = function(){

        localStorage.setItem("redirect", url);
        layer.msg('请先注册');
        setTimeout(function(){
            window.location.href = "/register";
        }, 500)
    }

    var token     = '{{csrf_token()}}';
    var is_weixin = '{{$is_weixin}}';  //是否为微信浏览器
    var spb = '{{$spb}}';
    var final_coin = 0;
    var is_dist = '{{$is_dis}}';

    var buy_type = '';
    //免费报名成功或者购买成功后跳转
//    function href_go(){
//        location.href = "/dist/answer/"+class_id+'.html';
//    }

    function href_go(){
        if(buy_type == 'PT'){

            location.href = "/train/success/t"+class_id+".html";
        }else{

            location.href = "/dist/study/"+class_id+'.html';
        }
    }
    //调用微信JS api 支付
    function jsApiCall()
    {

        var _token = '{{csrf_token()}}';
        var data = {_token:_token,class_id:class_id,dist_id:dist_id,type:buy_type};
        $.ajax({
            url:'/dist/payW',
            data:data,
            type:'POST',
            dateType:'json',
            success:function(res){

                if(res.code == 2){
                    userlogin();
                    return false;
                }else if(res.code == 0){
                    if(is_dist==1){
                        layer.msg('购买成功');
//                        alert(333);
                        location.href = "/dist/answer/"+class_id+'.html';
                        return;
                    }
                    var data = res.data;
                }else{
                    layer.msg(res.message);
                    return false;
                }
                WeixinJSBridge.invoke(
                        'getBrandWCPayRequest',
                        data,
                        function(res){
//                            WeixinJSBridge.log(res.err_msg);

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

    //立即付款弹出框
    $('.payBtn').click(function (){
//        var payfrom = $("input[name='radio1']:checked").val();
//        alert(222);
        var type = $(this).attr('data-type');

//        var payfrom = '';
        if(type == "PT"){
            payfrom = $("input[name='radio2']:checked").val();
        }else{
            payfrom = $("input[name='radio1']:checked").val();
        }
        buy_type = type;
        if(payfrom=="WXPAY"){
            if(is_weixin==1){
//                window.location.href="/dist/answer/"+class_id+'.html';
                jsApiCall();
            }else{

//                window.location.href="/dist/answer/"+class_id+'.html';
                $.ajax({
                    type:"POST",
                    url:"/dist/payH",
                    data:{_token:token,class_id:class_id,dist_id:dist_id,type:buy_type},
                    dataType:"json",
                    success:function(result){
                        if(result.code==1){
//                            console.log(result.objectxml.mweb_url);
                            //follow_us();
//                            alert(is_dist);
                            if(is_dist==1){
                                layer.msg('购买成功');
                                location.href = "/dist/answer/"+class_id+'.html';
                                return;
                            }else{
                                window.location.href=result.objectxml.mweb_url;   //h5呼叫微信支付
                            }

                        }else if(res.code == 2){
                            userlogin();
                            return false;
                        }else{
                            layer.msg(result.message);
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
                        url:"/train/paySpb",
                        data:{},
                        dataType:"json",
                        success:function(data){
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

    //右侧悬浮点击弹窗
    $('.wx').click(function(){
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'bm_success_layer_wrap', //样式类名
            id: 'bm_success_layer', //设定一个id，防止重复弹出
            closeBtn: 0, //不显示关闭按钮
            anim: 2,
            shadeClose: true, //开启遮罩关闭
            area: ['80%', '60%'],
            content:'<div class="bm_success_layer"><img src="/images/zt/group-er1.png" class="bm_success pt30" alt="" /><div class="text_center fz"><p class="f26 bold pt20">长按识别二维码</p><p class="f26 bold pb20"> 加课程顾问微信</p><p class="f26 bold">备注：</p></div></div>',
            btn:false
        });
    })

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
    //分享海报弹窗
    $('.shareRuleImg').click(function () {
        $.closePopup();//关闭底部弹出【分销】
        var type = 'train';
        var data = {id:class_id,type:type,_token:'{{csrf_token()}}'};
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
            '<img src="/images/qr.png" alt="赛普健身社区">' +
            '<p class="plr30 fz f30 color_333 mt20">' +
            '<span class="block bold">请使用微信扫描二维码登录</span>' +
            '<span class="block bold">“赛普健身社区”</span>' +
            '</p>' +
            '</div>',
            btn:false
        });
    });
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
    var link = 'http://m.saipubbs.com/dist/buy/'+class_id+'.html?dis='+dist_id;
    var title = '{{$distClass->title}}';
    var desc = '{{$distClass->seo_desc}}';
    var img = '{{env('IMG_URL')}}/{{$distClass->cover_url}}';
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: img, // 分享图标

        }, function(res) {
            //这里是回调函数

        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: title, // 分享标题
            link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: img, // 分享图标

        }, function(res) {
            //这里是回调函数

        });
    });
</script>
</body>
</html>
