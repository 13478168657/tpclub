<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-邀请好友助力</title>
    <meta name="author" content="啾啾" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />

    <!--mmenu.css start-->
    <link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
    <link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
    <link href="/css/nav-mmenu-public.css" rel="stylesheet" />
    <!--end-->
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" >

    <!--本css-->
    <link rel="stylesheet" href="/css/zt/zt_asszhuli.css" >

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
    {{--<div class="mh-head Sticky">--}}

        {{--<div class=" menu-bg-logo">--}}
			{{--<span class="mh-btns-left">--}}
				{{--<a class="icon-menu icon-sousuo" href="javascript:;"></a>--}}
			{{--</span>--}}
			{{--<span class="mh-btns-right">--}}
				{{--<a class="icon-menu" href="#menu"></a>--}}
				{{--<a class="icon-menu" href="#page"></a>--}}
			{{--</span>--}}
        {{--</div>--}}
    {{--</div>--}}

    <!--隐藏导航内容-->
    {{--<nav id="menu">--}}
        {{--<div class="text_center  fz">--}}
            {{--<ul>--}}
                {{--<li><a href="/">首页</a></li>--}}
                {{--<li><a href="/user/studying">正在学习</a></li>--}}
                {{--<li><a href="/user/index">我的</a></li>--}}
                {{--<li><a href="javascript:history.go(-1);">返回</a></li>--}}
            {{--</ul>--}}
        {{--</div>--}}
    {{--</nav>--}}
    <!--头部导航 end-->

    <!--====================================本喵是分割线  喵喵~========================================================-->

    <!--banner start-->
    <div>
        <img src="/images/zt/asszhuli/banner1.jpg" alt="">
    </div>
    <!--banner end-->


    <!--====================================本喵是分割线  喵喵~========================================================-->

    <!--距离活动结束还有 start-->
    <div class="daojishi bg353535 color_fff">

        <h3 class="f64 lt text_center pt105 mb50 titD">• <span class="f30 fz bgcolor_orange border-radius50 color_333">第{{$num}}期</span> 开营倒计时 •</h3>

        <div class="plr44">
            <!--倒计时 start-->
            <div class="fff-opt border-radius-img text_center color_fff conton">
                <p class="f28 fz"><span class="f64 lt" id="_d" >05</span>天</p>
                <p class="f28 fz"><span class="f64 lt" id="_h" >05</span>小时</p>
                <p class="f28 fz"><span class="f64 lt" id="_m" >05</span>分钟</p>
                <p class="f28 fz"><span class="f64 lt" id="_s" >05</span>秒</p>
            </div>
            <!--倒计时 end-->
            <!--助力 start-->
            <div class="bgcolor_fff border-radius-img text_center mt32 pt20 pb30">
                <p class="fz f28 color_gray666 pt40 mt10 mb50">还差{{(4-$invite_num)>0?4-$invite_num:0}}人助力、即可免费领取课程</p>

                <div class="plr56 portrait mb26 pb10">
                    <ul class="clearfix">
                        <?php
                        $rest = (4-$invite_num)>0?4-$invite_num:0;
                        ?>
                        @foreach($assignFriends as $friend)
                            <?php
                            $user = $friend->user;
                            if($user){
                                if(strpos($user->avatar,'http') !== false){
                                    $photo = $user->avatar;
                                }else{
                                    $photo = env('IMG_URL').$user->avatar;
                                }
                            }else{
                                $photo = '/images/my/nophoto.jpg';
                            }
                            ?>
                            <li class="fl">
                                <img src="{{$photo}}"/>
                            </li>
                        @endforeach
                        @for($i=0;$i<$rest;$i++)
                            <li class="fl"></li>
                        @endfor
                    </ul>
                </div>
            </div>
            <!--助力 end-->
            <!--活动步骤 start-->
            <div class="fff-opt1 plr44 mt32 border-radius-img pb30 ">
                <p class="lt f30 pt30 mb26">活动规则</p>
                <span class="d-in-black fz f26 text-jus mb50 LH1-2">01、点击页面底部【邀请好友助力】分享到朋友圈或者微信好友寻求好友助力。</span>
                <span class="d-in-black fz f26 text-jus LH1-2">02、当助力完成后进入【赛普健身社区】公众号——菜单栏【进入社区】——【我的课表】即可免费收看课程。</span>
            </div>
            <!--活动步骤 end-->

            <!--btn start-->
            {{--<div class="btn f32 bold fz text_center color_333 mt70 pb136">--}}
                {{--<a class="bgcolor_orange border-radius-img" href="javascript:void (0)">查看课程</a>--}}
            {{--</div>--}}
            <!--btn end-->
        </div>

    </div>
    <!--距离活动结束还有 end-->

    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--课程试看 视频 start-->
    <div class="plr30 ptb20 bg000">
        <div class="Modular-one pt70 border-radius-img">
            <p class="text_center one-qi f36 ptb13 mb50 color_fff"><i></i>课程试看<i></i></p>
            <!--sp start-->
            <div class="mb50">
                <div class="video border-radius-img">
                    <div class="box2 ">
                        <img src="/images/zt/asszhuli/bg-video.jpg" alt="" class="thumb"/>
                        <div class="mask"></div>
                        <span class="btn_play"></span>
                    </div>
                    <video id="video" src="http://v.saipubbs.com/%E7%A4%BE%E5%8C%BA%E6%89%93%E5%8D%A1/2%E8%83%B8%E9%83%A8%E8%AE%AD%E7%BB%83%E6%8A%80%E6%9C%AF%EF%BC%9A%E8%83%B8%E5%A4%A7%E8%82%8C%E7%9A%84%E5%8A%9F%E8%83%BD%E4%B8%8E%E8%A7%A3%E5%89%96-1.mp4" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto" ></video>
                </div>
                <h3 class="fz f30 color_fff text_center mt32 mb22">胸部原理与解剖（上）</h3>
            </div>
            <!--sp end-->

        </div>
    </div>
    <!--课程试看 视频 end-->
    <!--====================================本喵是分割线  喵喵~========================================================-->


    <!--点击查看全部课程内容 start-->
    <div class="bg000">
        <p class="text_center color_orange f26 fz mlr30 zhan-lie ptb65 btn_open">点击查看全部课程内容 <img src="/images/jiant.png" alt="" class="j-img"></p>
        <div class="imgs hide">
            <img src="/images/zt/asszhuli/ke.jpg" class="img100" />
        </div>
    </div>
    <!--点击查看全部课程内容 end-->

    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--此处为长图 start-->
    <img src="/images/zt/asszhuli/Cimg.jpg" alt="">
    <!--此处为长图 end-->

    <!--====================================本喵是分割线  喵喵~========================================================-->
    <div>


        <!--====================================本喵是分割线  喵喵~========================================================-->
        <!--悬浮按钮 start-->
        <div class="footer-x fz bold f32 text_center bgff7800">
            <ul class="clearfix">
                <li class="fl">
                    @if($hasMobile)
                    <a class="d-in-black color_fff zhuli" href="javascript:void (0)">为他助力</a>
                    @else
                    <a class="d-in-black color_fff zhuli" href="/login?redirect=/hand/index/{{$assign_id}}.html">为他助力</a>
                    @endif
                </li>
                <li class="fr">
                    @if($hasMobile)
                        <a class="d-in-black color_fff" href="/hand/index.html">我也要参加</a>
                    @else
                        <a class="d-in-black color_fff" href="/login?redirect=/hand/index.html">我也要参加</a>
                    @endif
                </li>
            </ul>
        </div>
        <!--悬浮按钮 end-->
        <!--====================================本喵是分割线  喵喵~========================================================-->

    </div><!--导航大盒子id=page 结束-->


</div>
<br><br>
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->
<script>
    //播放视频
    $(function (){
        //播放视频
        $('.video .box2').click(function(){
            $('.video .box2').show();
            $(this).hide();
            $(this).next().trigger('play');

        })


        //展开
        $('.btn_open').click(function (){
            $(this).hide();
            $(this).siblings().show();
        })
    })
    var u_id = '{{$user_id}}';
    var a_id = '{{$assign_id}}';
    $(document).on('click','.zhuli',function(){
       var data = {a_id:a_id,_token:'{{csrf_token()}}'};
        $.ajax({
            url:'/hand/zhuli',
            type:'POST',
            data:data,
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    layer.msg(res.message);
                }else if(res.code ==2){
                    layer.msg(res.message);
                    window.location.href='/login?redirect=/hand/friend/'+a_id+'.html';
                }else{
                    layer.msg(res.message);
                }
            }
        })
    });
</script>
<script type="text/javascript">
    function countTime() {
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var endDate = new Date("{{$beginTime}}");
        var end = endDate.getTime();
        //时间差
        var leftTime = end-now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        if (leftTime>=0) {
            d = Math.floor(leftTime/1000/60/60/24);
            h = Math.floor(leftTime/1000/60/60%24);
            m = Math.floor(leftTime/1000/60%60);
            s = Math.floor(leftTime/1000%60);
        }
        //将倒计时赋值到div中
        document.getElementById("_d").innerHTML = d;/*+"天"*/
        document.getElementById("_h").innerHTML = h;/*+"时"*/
        document.getElementById("_m").innerHTML = m;/*+"分"*/
        document.getElementById("_s").innerHTML = s;/*+"秒"*/
        //递归每秒调用countTime方法，显示动态时间效果
        setTimeout(countTime,1000);

    }
    onload(countTime())

</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
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
    var desc    = '来自健美冠军的虐胸挑战，一起来吧！';
    var title   = '我正在参加健身教练入门训练营-6天虐胸挑战，帮我助力，获取免费名额';
    var link = 'http://m.saipubbs.com/hand/friend/{{$user_id}}.html';
    var imgUrl = 'http://m.saipubbs.com/images/zt/share.png';
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
