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
    <title>{{$groupClass->title}}{{env('WEB_TITLE_COURSE')}}</title>
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
                <a href="/user/train.html" class="block color_333 fz bold f28 border-radius-img bgcolor_orange">我的教室</a>
            </div>
            <div class="fr my_progress">
                <div class="progressBox clearfix">
                    <div class="words f24 color_gray666 fl">共<span>{{$totalCourse}}</span>个任务,已完成<span class="color_orange">{{$viewTotal}}</span>个</div>
                    <div class="progressBar clearfix fl">
                        <div class="progress">
                            <?php
                              $percent = round($viewTotal/$totalCourse,2)*100;
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
    <!-- banner start -->
    <div>
        <div id="video" style="width:100%;height:200px;"></div>
    </div>
    <!-- banner end -->
    <!-- 课程目录 start -->
    <div class="classroom_list_detailed mt40">
        <h2 class="plr30 fz bold f32 color_333">课程目录</h2>
        <!-- 目录 start -->
        <?php
            $class_ids = explode(',',$groupClass->course_class_ids);

        ?>
        @foreach($class_ids as $k=>$class_id)
            <?php
                $courseClass = App\Models\CourseClass::where('id',$class_id)->first();
                $classSections = $courseClass->video($courseClass->id);
            ?>
            <div class="">
            <div class="class_list_det_tit">
                <p class="fz bold color_orange f30 text-overflow">阶段{{$k+1}} {{$courseClass->title}}</p>
            </div>
            <div class="">
                <ul class="nav">
                    @foreach($classSections as $skey => $section)
                    <li>
                        <a href="javascript:void (0)">{{$section->title}}</a>
                        <ul>
                            @foreach($section->course as $ckey => $course)
                                @if($course->course_content_id >0)
                                    <li onclick="go_content('{{$class_id}}','{{$a->course_content_id}}');">
                                @else
                                    <li onclick="aa('{{$course->video_url}}','{{$course->id}}','{{$class_id}}');" id="player_{{$course->id}}">
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
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endforeach
        <!-- 目录 end -->
    </div>
    <!-- 课程目录 end -->
</div>

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

    var title = '{{$groupClass->title}}';
    var desc = '{{$groupClass->description}}';
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: "http://m.saipubbs.com/course/detail/{{$groupClass->id}}.html?fission_id={{$userid}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "{{env('IMG_URL')}}{{$groupClass->cover_url}}", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: title, // 分享标题
            link: "http://m.saipubbs.com/course/detail/{{$groupClass->id}}.html?fission_id={{$userid}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "{{env('IMG_URL')}}{{$groupClass->cover_url}}", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
</script>
<script>

    var user_id = "{{$userid}}";      //用户id
    var c_c_id  = "{{$courseClass->id}}";     //课程id
    var is_weixin = "{{$is_weixin}}";  //是否为微信浏览器
    var token     = '{{csrf_token()}}';
    var vid       = "player_"+{{$vid}};
    var video_id  = "{{$video_id}}";
    var subscribe = "{{$subscribe}}";

    //跳转到课程图文页面
    var go_content  = function (c_id,content_id){
        window.location.href="/course/content/"+c_id+"/"+content_id+".html";
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
            $("#player_"+cookieVid).addClass("FDD000");
            $(".nav li").removeClass('active');
            $("#player_"+cookieVid).addClass("active");
            $("#player_"+cookieVid).find("img").attr("src", "/images/video_play.png");
        }else{
            $("#"+vid).parent().parent().siblings().children().eq(1).attr('class', ' ');
//            $("#"+vid).parent().attr("class", "block");
            $("#"+vid).addClass("FDD000");
            $(".nav li").removeClass("active");
            $("#"+vid).addClass("active");
            $("#"+vid).find("img").attr("src", "/images/video_play.png");
        }
    }
    bb();


    //播放视频功能
    var player;
    var loadHandler;
    var timeHandler;
    var videoTotalTime = 0;
    function aa(video,id,c_id){

        if(typeof(video) == "undefined" && typeof(id) == "undefined" && typeof(c_id) == "undefined"){
            var cookieVid = cookie.get("cookievid");
            if(cookieVid){
                var video_id = cookieVid;
                var video_url_id = cookie.get("cookievideoUrl");
            }else{
                var video_url_id = "{{$videoOne->video_url}}";
                var video_id = 	"{{$vid}}";
            }
        }else{
            var video_url_id = video;
            var video_id = id;
            c_c_id = c_id;
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
            cookie.set("time_" +videoID,0);
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
        console.log('总时长：'+videoTotalTime);
        //当前视频播放时间写入cookie
        var is_send = 0;
        var is_finished = 0;
        timeHandler = function(t){
            t = Math.floor(t);
            if(t>120){
                if(is_send==0){
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
</script>
</body>
</html>
