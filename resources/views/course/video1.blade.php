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
    <title>{{$data->title}}{{env('WEB_TITLE_COURSE')}}</title>
    <meta name="author" content="赛普课堂" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/xueyuan-detail2.css" rel="stylesheet" type="text/css" />
    <!--mmenu.css start-->
    <link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
    <link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
    <link href="/css/nav-mmenu-public.css" rel="stylesheet" />
    <link href="/css/font-num40.css" rel="stylesheet" >
    <link href="/css/article.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/my_classroom.css">
    <!--end-->
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
    @include('layouts.baidutongji')
    <style>
        .FDD000 {color:#FDD000;}
    </style>
</head>
<body ontouchstart>

<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->
    <!--头部导航 start-->
    <div class="mh-head Sticky">
        <div class=" menu-bg-logo">
                <span class="mh-btns-left">
                    <a class="icon-menu icon-sousuo" href="/search"></a>
                </span>
            @if(is_weixin())
                @if(!$user->mobile)
                    <span class="mh-btns-right active-a">
                           <a href="/register">注册</a>
                        </span>
                @else
                    <span class="mh-btns-right active-a">
                           <a href="/user/task">任务</a>
                        </span>
                @endif
            @endif
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
                <li><a href="/article/0.html">文章</a></li>
                <li><a href="/cak/1.html">问答</a></li>
                <li><a href="/user/studying">我的课程</a></li>
                <li><a href="/user/index">我的</a></li>
                <li><a href="javascript:history.go(-1);">返回</a></li>
                @if(!is_weixin())
                    @if($user)
                        <li><a href="/logout">退出</a></li>
                    @else
                        <li><a href="/login">登录</a></li>
                    @endif
                @endif
            </ul>
        </div>
    </nav>
    <!--头部导航 end-->
    <!-- 我的教室 start -->
    <div class="plr30">
        <div class="classroom_nav bgcolor_fff clearfix">
            <div class="fl my_room text_center">
                <a href="/user/studying" class="block color_333 fz bold f28 border-radius-img bgcolor_orange">我的教室</a>
            </div>
            <div class="fr my_progress">
                <div class="progressBox clearfix">
                    <div class="words f24 color_gray666 fl">共<span>{{$sumTotal}}</span>个任务,已完成<span class="color_orange">{{$viewTotal}}</span>个</div>
                    <div class="progressBar clearfix fl">
                        <div class="progress">
                            <?php
                            $percent = round($viewTotal/$sumTotal,2)*100;
                            ?>
                                    <!-- 数据库获取到22和11，循环的时候11/22*100 -->
                            <div class="bar" style="width:{{$percent}}%"></div>
                        </div>
                        <div class="percentage"><span class="num">{{$percent}}</span>%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 我的教室 end -->
    <div>
        <div id="video" style="width:100%;height:200px;"></div>
    </div>
    <!-- 课程目录 start -->
    <div class="classroom_list_detailed mt40">
        <h2 class="plr30 fz bold f32 color_333">课程目录</h2>
        <!-- 目录 start -->
            <?php
                $classSections = $array;
            ?>
            <div class="">
                <div class="class_list_det_tit">
                    <p class="fz bold color_orange f30 text-overflow">阶段1 {{$data->title}}</p>
                </div>
                <div class="">
                    <ul class="nav">
                        @foreach($classSections as $skey => $section)
                            <li>
                                <a href="javascript:void(0)">{{$section->title}}</a>
                                @if($data->is_free==0 || is_baoming($data->id,$userid) == 1 || expericence_card_isture($data->course_type_id,$userid) == 1 || $data->id==4)
                                    <ul>
                                        @foreach($section->course as $ckey => $course)

                                            @if($course->course_content_id>0)
                                                <li onclick="go_content('{{$course->course_content_id}}');">
                                            @elseif($course->video_url=="")
                                                <li onclick="layer.msg('视频暂未上线');" class="back-to-top">
                                            @else
                                                <li onclick="aa('{{$course->video_url}}','{{$course->id}}');" id="player_{{$course->id}}">
                                            @endif

                                            <a>
                                                <div class="weui-cell padding0 mt0">
                                                    <div class="weui-cell__bd">
                                                        <p>{{$ckey+1}}.{{$course->title}}</p>
                                                    </div>
                                                    <div class="weui-cell__ft">
                                                        @if($course->course_content_id >0)
                                                            <p class="clearfix icon_article_on">
                                                                <span class="fz f22">文章</span>
                                                            </p>
                                                        @else
                                                            <p class="clearfix icon_video_on">
                                                                <span class="fz f22">视频</span>
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <ul>
                                        @foreach($section->course as $ckey => $course)
                                            @if($course->preview)
                                                @if($course->course_content_id>0)
                                                    <li onclick="go_content('{{$course->course_content_id}}');" class="back-to-top">
                                                @elseif($course->video_url=="")
                                                    <li onclick="layer.msg('视频暂未上线');" class="back-to-top">
                                                @else
                                                    <li onclick="aa('{{$course->video_url}}','{{$course->id}}');" id="player_{{$course->id}}" class="back-to-top">
                                                @endif
                                            @else
                                                <li class="no_preview" id="player_{{$course->id}}" class="back-to-top">
                                            @endif

                                                @if($course->course_content_id >0)
                                                    <a>
                                                @else
                                                    <a>
                                                @endif
                                                    <div class="weui-cell padding0 mt0">
                                                        <div class="weui-cell__bd">
                                                            <p>{{$ckey+1}}.{{$course->title}}</p>
                                                        </div>
                                                        <div class="weui-cell__ft">
                                                            @if($course->course_content_id >0)
                                                                <p class="clearfix icon_article_on">
                                                                    <span class="fz f22">文章</span>
                                                                </p>
                                                            @else
                                                                <p class="clearfix icon_video_on">
                                                                    <span class="fz f22">视频</span>
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        <!-- 目录 end -->
    </div>
    <!-- 课程目录 end -->

</div>

<!-- 底部弹出popup start -->
<div id="half" class='weui-popup__container popup-bottom payType_popup zindex6ge9'>
    <div class="weui-popup__overlay"></div>
    <div class="weui-popup__modal">
        <div class="toolbar">
            <div class="toolbar-inner">
                <a href="javascript:;" class="picker-button close-popup">关闭</a>
                <h1 class="title">确认付款</h1>
            </div>
        </div>
        <div class="modal-content bgc_white">
            <div class="weui-cell  weui-cell">
                <div class="weui-cell__bd">
                    <h2 class="fs14">课程费用</h2>
                </div>
                <div class="weui-cell__ft">
                    <span class="price">{{$data->price}}元</span>
                </div>
            </div>
            <div class="weui-cells weui-cells_radio noafter">
                <label class="weui-cell weui-check__label" for="x11">
                    <div class="weui-cell__bd">
                        <p><i class="ico_wx"></i>微信支付</p>
                    </div>
                    <div class="weui-cell__ft">
                        <input type="radio" class="weui-check" name="radio1" id="x11" value="WXPAY" checked />
                        <span class="weui-icon-checked"></span>
                    </div>
                </label>
                @if($balance)
                    <label class="weui-cell weui-check__label" for="x12">
                        @else
                            <label class="weui-cell weui-check__label disabled_xueyuan" for="x12">
                                @endif
                                <div class="weui-cell__bd">
                                    <p><i class="ico_balance"></i>余额支付</p>
                                </div>
                                <div class="weui-cell__ft">
                                    <input type="radio" name="radio1" class="weui-check" id="x12" value="BANLANCE">
                                    <span class="weui-icon-checked"></span>
                                </div>
                            </label>
                            @if($spb/100 > $data->price)
                                <label class="weui-cell weui-check__label" for="x13">
                                    @else
                                        <label class="weui-cell weui-check__label disabled_xueyuan" for="x13">
                                            @endif
                                            <div class="weui-cell__bd">
                                                <p><i class="ico_spb"></i>{{$data->price * 100}}赛普币(已有{{$spb}}赛普币)</p>
                                            </div>
                                            <div class="weui-cell__ft">
                                                <input type="radio" name="radio1" class="weui-check" id="x13" value="SPB">
                                                <span class="weui-icon-checked"></span>
                                            </div>
                                        </label>
            </div>
            <div class="container pt15 pb15">
                <a href="javascript:void(0);" class="roy_btn bgc_yellow payBtn">立即付款</a>
            </div>
        </div>
    </div>
</div>
<!-- 底部弹出popup end -->



<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<!-- <script>
  $(function() {
    FastClick.attach(document.body);
  });
</script> -->
<!--nav logo menu 导航条-->
<script src="/js/accordion.js" type="text/javascript"></script>
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<!-- <script src="/js/jweixin-1.4.0.js"></script> -->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="/js/star_jquery.raty.min.js"></script>
<script>

    //给body加一个类
    $('body').addClass('page_evaluate_wrap');

    $(function(){
        $(".nav").accordion({
            //accordion: true,
            speed: 500,
            closedSign: 'down',
            openedSign: 'up'
        });

    });
    //提交评论内容
    $('.btn_submit').click(function (){
        var con=$('#content').val();
        console.log(con);

        var html='<div class="weui-cells pt30  noafter " data-id="1">' +
                '<div class="weui-cell evaluate padding0">'+
                '<div class="weui-cell__bd">'+
                '	<a href="#" class="user_photo"><img src="/images/xy.png" alt="" class="img100"></a>'+
                '	<dl>'+
                '		<dt>Jane King </dt>'+
                '		<dd class="fz">6分钟前</dd>'+
                '	</dl>'+
                '	<p  class="fz text-jus">'+con+'</p>'+
                '</div>'+
                '</div>'+
                '</div>	';
        $('#head').after(html);

        $.ajax({
            url : '',
            type : 'post',
            dataType : 'json',
            data : {
                con : con
            },
            beforeSend : function(){

            },
            success : function (data) {

            }
        });
        $.closePopup();//关闭弹出框
        //location.reload()

    })


    /**/
    /*$(function() {
     FastClick.attach(document.body);
     });*/
</script>
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
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: '{{$data->title}}', // 分享标题
            desc: '{{$data->seo_description}}', // 分享描述
            link: "http://m.saipubbs.com/course/detail/{{$data->id}}.html?fission_id={{$userid}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "{{env('IMG_URL')}}{{$data->cover_url}}", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '{{$data->title}}', // 分享标题
            link: "http://m.saipubbs.com/course/detail/{{$data->id}}.html?fission_id={{$userid}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "{{env('IMG_URL')}}{{$data->cover_url}}", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
</script>
<script>

    var user_id = "{{$userid}}";      //用户id
    var c_c_id  = "{{$data->id}}";     //课程id
    var is_weixin = "{{$is_weixin}}";  //是否为微信浏览器
    var token     = '{{csrf_token()}}';
    var vid       = "player_"+{{$vid}};
    var video_id  = "{{$array[0]->course[0]->id}}";
    var subscribe = "{{$subscribe}}";

    //跳转到课程图文页面
    var go_content  = function (content_id){
        window.location.href="/course/content/"+c_c_id+"/"+content_id+".html";
    }

    //免费报名成功或者购买成功后跳转
    function href_go(){
        //判断是否关注公众号如果未关注跳转引导页
        if(subscribe==1){
            location.href="/course/video/"+c_c_id+"/"+video_id+".html";
        }else{
            location.href="/course/middle/"+c_c_id+"/"+video_id;
        }

    }

    //跳转登陆函数
    var userlogin = function(){
        var url = "/course/video/"+c_c_id+"/"+video_id+".html";
        layer.msg('请先登录');

        localStorage.setItem("redirect", url);
        setTimeout(function(){
            window.location.href = "/login";
        }, 500)
    }

    //调用微信JS api 支付
    function jsApiCall()
    {
        var _token = '{{csrf_token()}}';
        var data = {class_id:c_c_id,_token:_token};
        $.ajax({
            url:'/course/buy',
            data:data,
            type:'POST',
            dateType:'json',
            success:function(res){

                if(res.code != 0){
                    swal(res.message);
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
                                setTimeout(function(){
                                    href_go();     //支付成功跳转
                                },1500)  //延迟1.5秒刷新页面
                            }else{
                                layer.msg('取消支付');
                            }
                        }
                );
            }
        })

    }

    $(function (){
        //正在播放的视频高亮
        function video_bright(info){
            $("#"+info).parent().parent().siblings().children().eq(1).attr('class', ' ');
            $("#"+info).parent().attr("class", "block");
            $("#"+info).addClass("FDD000");
            $("#"+info).find("img").attr("src", "/images/video_play.png");
        }
        //video_bright(vid);
        //查看视频滑倒顶部  并处理正在播放视频高亮
        $(".back-to-top").click(function() {
            $(".back-to-top").each(function(){
                $(this).removeClass("FDD000");
                $(this).find("img").attr("src", "/images/ico_video.png");
            })
            $(this).addClass("FDD000");
            $(this).find("img").attr("src", "/images/video_play.png");

            $('body,html').animate({
                        scrollTop: 0
                    },
                    500);
            return false;
        });

        //折叠面板
        $('.toggleBox .item h3').click(function (){
            if($(this).next().hasClass('block')){
                return false;
            }else{
                $(this).next().addClass('block').parents('.item').siblings().find('ul').removeClass('block');
                $(this).find('i').addClass('up').parents('.item').siblings().find('i').removeClass('up');
            }
        })

        //不支持试看视频
        $(".no_preview").click(function(){
            var mobile = "{{$mobile}}";
            if(mobile==0){
                userlogin();
                return;
            }
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
            //alert(payfrom);
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
                        data:{course_class_id:c_c_id,_token:token},
                        dataType:"json",
                        success:function(result){
                            if(result.code==1){
                                console.log(result.objectxml.mweb_url);
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
            var id = {{$data->id}};
            var user_id = {{$userid}};
            $.get("/course/enroll",{course_class_id:id,user_id:user_id},function(result){
                if(result == 0){
                    layer.msg('报名成功');
                    $(".enroll_bb").text("进入课程");
                    href_go();     //支付成功跳转
                    //window.location.href = "/course/video/"+id+"/"+video_id+".html";
                }
            })
        })

        //取消报名课程  20180827
        $("#cancel_studying").click(function(){
            layer.msg('取消报名成功');
            return;
            var id = {{$data->id}};
            var user_id = {{$userid}};
            $.ajax({
                type:"POST",
                url:"/course/no_entroll",
                data:{course_class_id:id, user_id:user_id, _token:token},
                dataType:"json",
                success:function(result){
                    if(result.code==1){
                        layer.msg(result.msg);
                        setTimeout(function(){
                            location.reload();
                        },1500)  //延迟1.5秒刷新页面
                    }else{
                        layer.msg(result.msg);
                    }
                }
            });
        })
    })
</script>
<script src="/js/ckplayer/ckplayer.js"></script>
<script>
    var cookie = {
        set: function(name, value) {
            var Days = 30;
            var exp = new Date();
            exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
            document.cookie = name + '=' + escape(value) + ';expires=' + exp.toGMTString();
        },
        get: function(name) {
            var arr, reg = new RegExp('(^| )' + name + '=([^;]*)(;|$)');
            if(arr = document.cookie.match(reg)) {
                return unescape(arr[2]);
            } else {
                return null;
            }
        },
        del: function(name) {
            var exp = new Date();
            exp.setTime(exp.getTime() - 1);
            var cval = getCookie(name);
            if(cval != null) {
                document.cookie = name + '=' + cval + ';expires=' + exp.toGMTString();
            }
        }
    };

    //记录最后一个播放视频
    function bb(){
        var cookieVid = cookie.get("cookievid");
        console.log("--"+cookieVid);
        if(cookieVid){
            $("#player_"+cookieVid).parent().parent().siblings().children().eq(1).attr('class', ' ');
//            $("#player_"+cookieVid).parent().attr("class", "block");
            $(".nav li").removeClass('active');
            $("#player_"+cookieVid).addClass("active");
            $("#player_"+cookieVid).addClass("FDD000");
            $("#player_"+cookieVid).find("img").attr("src", "/images/video_play.png");

        }else{
            $("#"+vid).parent().parent().siblings().children().eq(1).attr('class', ' ');
//            $("#"+vid).parent().attr("class", "block");
            $("#"+vid).addClass("FDD000");
            $("#"+vid).addClas("active");
            $("#"+vid).find("img").attr("src", "/images/video_play.png");
        }
    }
    bb();


    //播放视频功能
    var player;
    var loadHandler;
    var timeHandler;
    var videoTotalTime = 0;
    function aa(video,id){

        if(typeof(video) == "undefined" && typeof(id) == "undefined"){
            var cookieVid = cookie.get("cookievid");
            if(cookieVid){
                var video_id = cookieVid;
                var video_url_id = cookie.get("cookievideoUrl");
            }else{
                @if($videoOne)
                var video_url_id = "{{$videoOne->video_url}}";
                @else
                var video_url_id = "{{$array[0]->course[0]->video_url}}";
                @endif
                var video_id = 	"{{$vid}}";
            }

        }else{
            var video_url_id = video;
            var video_id = id;
        }
        var videoID = video_id;
        var cookieTime = cookie.get("time_" +videoID);
        var videoObject = {
            container: '#video',//“#”代表容器的ID，“.”或“”代表容器的class
            variable: 'player',//该属性必需设置，值等于下面的new chplayer()的对象
            flashplayer:false,//如果强制使用flashplayer则设置成true
            loaded:"loadHandler",
            autoplay:true,
            loop:true,
            video:video_url_id//视频地址
        };

        if(!cookieTime || cookieTime == undefined){
            cookieTime = 0;
        }

        if(cookieTime > 0) {
            layer.msg('上次观看时间为：' + cookieTime+' (秒)');
            videoObject['seek'] = cookieTime;   //设置最新时间
        }
        player = new ckplayer(videoObject);

        //监听播放时间
        loadHandler = function(){
            player.addListener('time', timeHandler);
        }
        player.addListener('duration', durationHandler); //监听播放时间
        function durationHandler(duration) {

            videoTotalTime = duration;
        }
//		alert(videoTotalTime);
        console.log('总时长：'+videoTotalTime);
        //当前视频播放时间写入cookie
        var is_send = 0;
        var is_finished = 0;
        timeHandler = function(t){
            t = Math.floor(t);
            if(t>120){
                if(is_send==0){
                    console.log(t);
                    console.log(c_c_id);
                    console.log(video_id);
                    console.log('总时长：'+videoTotalTime);
                    $.ajax({
                        type:"POST",
                        url:"/course/playrecord",
                        data:{c_c_id:c_c_id, video_id:video_id, _token:token},
                        dataType:"json",
                        success:function(result){
                            console.log(result);
                        }
                    });
                    is_send = 1;
                }
            }
            if(t > videoTotalTime - 120){
                if(is_finished ==0){
                    $.ajax({
                        type:"POST",
                        url:"/course/video/finish",
                        data:{c_c_id:c_c_id, video_id:video_id, _token:token},
                        dataType:"json",
                        success:function(result){
                            console.log(result);
                        }
                    });
                    is_finished = 1;
                }
            }
            cookie.set('time_' + video_id, t);
        }
        cookie.set('cookievid', video_id);
        cookie.set('cookievideoUrl',video_url_id);
    }
    aa();

    //执行关注操作
    function click_follow(e){
        var fans_id = e.getAttribute("data-fans_id");
        var user_id = e.getAttribute("data-user_id");
        var fansid  = e.getAttribute("id");
        var is_follow = e.getAttribute("data-is_follow");
        var token     = '{{csrf_token()}}';
        // if(is_follow==1){
        // 	layer.msg('您已关注,无需重复操作');
        // 	return;
        // }
        $.ajax({
            type:"POST",
            url:"/user/followadd",
            data:{fans_id:fans_id, user_id:user_id,_token:token,is_follow:is_follow},
            dataType:"json",
            success:function(result){
                if(result.code==1){
                    layer.msg('操作成功');
                    document.getElementById(fansid).setAttribute('data-is_follow', 1);
                    //document.getElementById(fansid).setAttribute('class', 'yihuguan border-radius');
                    document.getElementById(fansid).innerHTML='已关注';
                }else{
                    layer.msg(result.msg);
                    document.getElementById(fansid).setAttribute('data-is_follow', 0);
                    document.getElementById(fansid).innerHTML='关注';
                }
            }
        });
    }


    /*星星点亮*/
    $(function (){
        $.fn.raty.defaults.path = '/images/img/';
        $('#star').raty({});
    })
    /*星星点亮*/
    var final_score = 0;
    var user_id     = {{$userid}};   //用户id
    var c_c_id      = {{$data->id}};    //课程id
    var token       = '{{csrf_token()}}';

    $(function (){
        $.fn.raty.defaults.path = '/images/img/';
        $('#star').raty({
            click: function(score, evt) {
                final_score = score;
                $("#change_score").text(score+" 分");
            }
        });
    })
    var addcomment = function(){
        var text = $("#yijian").val();
        var avatar     = "{{$avatar}}";
        var user_name  = "{{$user_name}}";

        var html='<div class="weui-cells pt30  noafter " data-id="1">' +
                '<div class="weui-cell evaluate padding0">'+
                '<div class="weui-cell__bd">'+
                '	<a href="#" class="user_photo"><img src="'+avatar+'" alt="" class="img100"></a>'+
                '	<dl>'+
                '		<dt>'+user_name+'</dt>'+
                '		<dd class="fz">刚刚</dd>'+
                '	</dl>'+
                '	<p  class="fz text-jus">'+text+'</p>'+
                '</div>'+
                '</div>'+
                '</div>	';
        $('#head').after(html);
        $(".start_weipingjia").hide();

        if(text.length<10){
            layer.msg("请填写10字以上的评论");
            return;
        }
        if(final_score<1){
            layer.msg("请给课程评分");
            return;
        }
        var data = {user_id:user_id, _token:token, c_c_id:c_c_id, text:text, final_score:final_score};
        //console.log(data);
        $.ajax({
            url:'/course/commentinsert',
            type:'POST',
            data:data,
            dataType:'json',
            success:function(res){
                layer.msg(res.msg);
                //history.go(-1);
                location.reload();
            }
        });

    }
</script>
</body>
</html>
