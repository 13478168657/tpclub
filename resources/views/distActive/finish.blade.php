<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-打卡</title>
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
    <link rel="stylesheet" href="/css/fenxiaoliucheng.css?t={{time()}}" >


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
                <li><a href="javascript:history.go(-1);">返回</a></li>
            </ul>
        </div>
    </nav>
    <!--头部导航 end-->

    <!--====================================本喵是分割线  喵喵~========================================================-->
    <div>
        <!--banner start-->
        <div>
            <div class="video">
                <div class="box2">
                    <img src="{{env('IMG_URL')}}/{{$disCourse->cover_url}}" alt=""/>
                    <div class="mask"></div>
                    <span class="btn_play"></span>
                </div>
                <video id="video" src="{{$disCourse->video_url}}" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto" ></video>
                {{--<div id="video" style="width:100%;height:200px;"></div>--}}
            </div>
        </div>
        <!--banner end-->

        <div class="fenxiao_detail plr30">
            <h3 class="ptb40 color_000 f30 bold fz border-bottom-dedede">{{$disCourse->title}}</h3>
            <?php
                $description = explode("\n",$disCourse->description);
                $isLive = 0;
                $liveUrl = '';
                foreach($description as $dec){
                    if(strpos($dec,'http') !== false){
                        $liveUrl = $dec;
                    }
                }
            ?>
            <p class="fz f26 color_gray666 pt30"><a href="{{$liveUrl}}">{{$description[0]}}</a></p>
        </div>


        <!--悬浮底 start-->
        {{--<div class="btn_fenxiao_fix text_center relative daka_judge">--}}
            {{--@if($flag == 1)--}}
            {{--<a href="/dist/share/{{$cid}}/{{$disCourse->id}}.html" class="fz f34 color_333 block bgcolor_orange btn_daka">已完成课程打卡</a>--}}
            {{--@elseif($flag == 2)--}}
            {{--<a href="javascript:void(0);" class="fz f34 color_333 block bgcolor_orange">错过打卡日期不能补打卡</a>--}}
            {{--@else--}}
            {{--<a href="/dist/share/{{$cid}}/{{$disCourse->id}}.html" class="fz f34 color_333 block bgcolor_orange btn_daka">完成课程打卡</a>--}}
            {{--@endif--}}
        {{--</div>--}}
        <!--悬浮底  end-->
    </div>


    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--====================================本喵是分割线  喵喵~========================================================-->
</div><!--导航大盒子id=page 结束-->



<br><br>

<br><br>
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->
<script src="/js/ckplayer/ckplayer.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    var course_id = '{{$disCourse->id}}';
    var c_id = '{{$cid}}';

    $(function() {
        $('.btn_daka').click(function () {

        })

        $('.video .box2').click(function(){
            $(this).hide();
            $(this).next().trigger('play');

        })
    })

    $(document.body).delegate(".btn_daka2", 'click', function () {
        //do sonething
//        layer.closeAll();
//        layer.open({
//            type: 1,
//            title: false, //不显示标题栏
//            skin: 'daka_layer_wrap', //样式类名
//            id: 'daka_layer2', //设定一个id，防止重复弹出
//            closeBtn: 1, //显示关闭按钮
//            anim: 2,
//            shade: false,
//            shadeClose: false, //开启遮罩关闭
//            area: ['80%', '60%'],
//            content: '<div class="daka_layer"><div class="container text_center pt20"><h3 class="pt40 f26 text_center fz color_333">恭喜你完成今日课程的挑战！</h3><p class="f26 fz color_333">但是你已经错过打卡日期，只能学习该课程</p><div class="btnWrap pt30 pb30"><a onclick="closeAll();" class="btn f34 block fz">知道了</a></div></div></div>',
//            btn: false
//        });
    });

    var img_url = '{{env('IMG_URL')}}/{{$disCourse->cover_url}}';
    var video_url = '{{$disCourse->video_url}}';

    function closeAll(){
        $('#video').css('display',"block");
        $('.video .box2').show();
        layer.closeAll();
    }
    var flag = '{{$flag}}';

    var md=document.getElementsByTagName("video")[0];
    md.addEventListener("ended",function(){

            if(flag == 0){
//                var url = '/dist/share/'+c_id+'/'+course_id+'.html';
//                var content = '<div class="daka_layer"><div class="container text_center pt20"><h3 class="pt40 f26 text_center fz color_333">恭喜你完成今日课程的挑战！</h3><p class="f26 fz color_333">你可以打卡后去完成导师建议的训练</p><div class="btnWrap pt30 pb30 "><a href="'+url+'"class="btn f34 block fz ">去打卡</a></div></div></div>';
//                $('#video').css('display',"none");
//                top.layer.open({
//                    type: 1,
//                    title: false, //不显示标题栏
//                    skin: 'daka_layer_wrap', //样式类名
//                    id: 'daka_layer', //设定一个id，防止重复弹出
//                    closeBtn: 1, //显示关闭按钮
//                    anim: 2,
//                    shade: false,
//                    shadeClose: false, //开启遮罩关闭
//                    area: ['80%', '60%'],
//                    content: content,
//                    btn: false,
//                    zIndex: layer.zIndex, //重点1
//                    success: function(layero){
//                        layer.setTop(layero); //重点2
//                    },
//                    cancel:function(){
//                        $('.video .box2').show();
//                        $('#video').css("display","block");
//                    }
//                });
//                localStorage.setItem('distCardCourse_'+course_id,1);
//                var info = '<a href="/dist/share/'+c_id+'/'+course_id+'.html"'+' class="fz f34 color_333 block bgcolor_orange ">去完成课程打卡</a>';
//                $('.daka_judge').html(info);

            }else if(flag == 2) {
//                $('#video').css('display',"none");
//                top.layer.open({
//                    type: 1,
//                    title: false, //不显示标题栏
//                    skin: 'daka_layer_wrap', //样式类名
//                    id: 'daka_layer2', //设定一个id，防止重复弹出
//                    closeBtn: 1, //显示关闭按钮
//                    anim: 2,
//                    shade: false,
//                    shadeClose: false, //开启遮罩关闭
//                    area: ['80%', '60%'],
//                    content: '<div class="daka_layer"><div class="container text_center pt20"><h3 class="pt40 f26 text_center fz color_333">恭喜你完成今日课程的挑战！</h3><p class="f26 fz color_333">但是你已经错过打卡日期，只能学习该课程</p><div class="btnWrap pt30 pb30"><a onclick="closeAll();" class="btn f34 block fz">知道了</a></div></div></div>',
//                    btn: false,
//                    zIndex: layer.zIndex, //重点1
//                    success: function(layero){
//                        layer.setTop(layero); //重点2
//                    },
//                    cancel:function(){
//                        $('.video .box2').show();
//                        $('#video').css("display","block");
//                    }
//                });
            }
    });
    var title = '';
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
    var desc = '{{$disCourse->description}}';
    var title = '{{$disCourse->title}}';
    var user_id = '{{$user_id}}';
    var dis_id = '{{$dis_id}}';
//    var link = 'http://m.saipubbs.com/dist/finish/'+c_id+'/'+course_id+'.html?id='+user_id;
    var link = 'http://m.saipubbs.com/dist/buy/'+c_id+'.html?dis='+dis_id;
    var imgUrl = '{{env('IMG_URL')}}/{{$disCourse->cover_url}}';
    var content = '';
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: imgUrl, // 分享图标
            success: function(){
                /*----分享获得赛普币end----*/
            },
            cancel:function(){

            }
        }, function(res) {
            //这里是回调函数

        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: title, // 分享标题
            link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: imgUrl, // 分享图标
            success: function(){


            },
            cancel:function(){

            }
        }, function(res) {
            //这里是回调函数

        });
    });
</script>
</body>
</html>
