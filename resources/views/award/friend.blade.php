<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-分享好友送大礼</title>
    <meta name="author" content="啾啾" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/activity/award/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/activity/award/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <!--mmenu.css start-->
    <link href="/activity/award/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
    <link href="/activity/award/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
    <link href="/activity/award/css/nav-mmenu-public.css" rel="stylesheet" />
    <!--end-->
    <link href="/activity/award/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/activity/award/css/font-num40.css" rel="stylesheet" >

    <!--本css-->
    <link rel="stylesheet" href="/activity/award/css/zt/zt_giftgive.css">

    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
</head>
<body>

<div>
    <!--==============================本喵是分割线 喵喵~==================================================-->
    <!--头部导航 start-->
    <div class="f-nav bg-eee">
        <ul class="clearfix text_center fz f26">
            <li><a href="/share/friend" class="active">领取奖学金的好友</a></li>
            <li><a href="/share/rank/list">送礼竞赛排行榜</a></li>
            <li><a href="/share/my/gift">我获得的奖品</a></li>
        </ul>
    </div>
    <!--头部导航 end-->
    <!--==============================本喵是分割线 喵喵~==================================================-->
    <div class="plr30">
        <div class="f-list">
            <ul id="moreFriend">
                @foreach($friends as $k => $friend)
                    <?php
                        $user = $friend->user;
                        if(!$user){
                            continue;
                        }
                    ?>
                <li class="fz clearfix bold">
                    <p class="f28">{{$k+1}}.</p>
                    <p class="">
                        @if($user->avatar)
                            @if(strpos($user->avatar,'http') !== false)
                                <img class="d-in-black border-radius50" src="{{$user->avatar}}" alt="">
                            @else
                                <img class="d-in-black border-radius50" src="{{env('IMG_URL')}}{{$user->avatar}}">
                            @endif
                        @else
                            <img class="d-in-black border-radius50" src="/activity/award/images/zt/giftgive/fimg.jpg" alt="">
                        @endif
                    </p>
                    <p class="f28 text-overflow">{{$user->name?$user->name:$user->nickname}}</p>
                    <p class="f22 text_right color_gray666">{{date('Y.m.d',strtotime($friend->created_at))}}</p>
                </li>
                @endforeach
                @if($friends->hasMorePages())
                <a onclick="moreFriend();" class="fz f24 color_gray999 loadMore text_center di-bolck">加载更多</a>
                @endif
            </ul>
        </div>
    </div>
    <!--==============================本喵是分割线 喵喵~==================================================-->
    <!--免费送礼给好友 start-->
    <div class="relative">
        <div class="footer footer-dit">
            <ul class="text_center f28 fz bold">
                <li class="bg-ec313d"><a onclick="getAward();">免费送礼给好友</a></li>
            </ul>
        </div>
    </div>
    <!--免费送礼给好友 end-->
    <!--==============================本喵是分割线 喵喵~==================================================-->
    <!--==============================本喵是分割线 喵喵~==================================================-->
    <!--==============================本喵是分割线 喵喵~==================================================-->


</div>


<br><br>

<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/layer/layer.js"></script>
<script type="text/javascript">
    localStorage.setItem('redirect','/share/friend');
    function getAward(){
        var data = {_token:'{{csrf_token()}}'};
        $.ajax({
            url:"/share/make/card",
            data:data,
            type:'POST',
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    layer.open({
                        type: 1,
                        title: false, //不显示标题栏
                        skin: 'hb_success_layer_wrap', //样式类名
                        id: 'hb_success_layer', //设定一个id，防止重复弹出
                        closeBtn: 1, //不显示关闭按钮
                        anim: 2,
                        shadeClose: true, //开启遮罩关闭
                        area: ['80%', '90%'],
                        content:res.data,
                        btn:false
                    });
                }else{
                    layer.msg(res.message);
                    window.location.href='/register';
                }
            }
        });
    }
    var page = 2;
    function moreFriend(){
        var data = {page:page};

        $.ajax({
            url:'/share/friend',
            data:data,
            type:'GET',
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    $("#moreFriend > li:last").after(res.body);
                    page = page+1;
                    if(res.body == ''){
                        $('.loadMore').text('无更多数据');
                    }
                }
            }
        });
    }
</script>
<!-- GrowingIO Analytics code version 2.1 -->
<!-- Copyright 2015-2018 GrowingIO, Inc. More info available at at http://www.growingio.com -->

<script type='text/javascript'>
    !function(e,t,n,g,i){e[i]=e[i]||function(){(e[i].q=e[i].q||[]).push(arguments)},n=t.createElement("script"),tag=t.getElementsByTagName("script")[0],n.async=1,n.src=('https:'==document.location.protocol?'https://':'http://')+g,tag.parentNode.insertBefore(n,tag)}(window,document,"script","assets.growingio.com/2.1/gio.js","gio");
    gio('init','aef8110bebdb6dd5', {});
    //custom page code begin here
    //custom page code end here
    gio('send');
</script>

<!-- End GrowingIO Analytics code version: 2.1 -->
</body>
</html>
