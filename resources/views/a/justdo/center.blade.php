<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>参赛个人展示</title>
    <meta name="author" content="络绎" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" href="/lib/jqweui/css/weui.min.css" />
    <link rel="stylesheet" href="/lib/jqweui/css/jquery-weui.css" />
    <link rel="stylesheet" href="/css/reset.css" />
    <link rel="stylesheet" href="/css/font-num40.css"/>
    <link rel="stylesheet" href="/css/zt/zt_just_do_it_form.css?t=15">
    <link rel="stylesheet" href="/css/zt/zt_just_do_it.css">
    <link rel="stylesheet" href="/css/zt/zt_just_do_it_public.css">
    <link rel="stylesheet" href="/css/zt/zt_RightFloat.css">
    <script src="/js/rem.js" type="text/javascript"></script>
    @include('layouts.baidutongji')
</head>

<body ontouchstart>
<!-- 头部 start -->
    <div class="ad_code">
         <img src="/images/zt/just_do_it/home/ad_sp.jpg" alt="" class="img100 ad_img_img">
        <div class="ad_close"><img src="/images/close2.png" class="img_close" alt=""></div>
    </div>
    <!-- 弹出 start -->
    <div class="bm_success_layer_wrap text_center hide">
        <p class="color_333 f20 pt40">扫描下面二维码报名<br>并获取报名结果</p>
        <img src="/images/zt/just_do_it/home/code.jpg" class="bm_success" alt="" />
    </div> 
    <!-- 弹出 end -->
    <!-- 头部 end -->

<!-- 个人页 start -->
<div class="page_geren plr30 pt30">
    <div class="radius10 info">
        <div class="clearfix f32 bold">
            <div class="fl">{{$userInfo->name}}</div>
            <div class="fr c_orange totalVote">{{$total}}票</div>
        </div>
        <div class="color_gray666 f30 mt10">
            <span class="block">{{$userInfo->company}}</span>
            <span class="block">{{$user->position}}</span>
        </div>
    </div>
    <!-- 视频播放 start -->
    <div class="video_box mt30 radius10">
        <div class="mask_box">
            <p class="bgcolor_fff img_box" align="center"><img src="{{env("IMG_URL")}}{{$userInfo->cover_img}}" alt="" /></p>
            <div class="mask"></div>
            @if($userInfo->upload_video)

            <span class="btn_play"></span>
            @endif
        </div>
        @if($userInfo->upload_video)

        <video src="{{$userInfo->upload_video}}" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto"></video>
        @endif
    </div>
    <!-- 视频播放 end -->
</div>
<!-- 个人页 end -->


<br><br><br /><br />

<!-- 底部固定导航 start -->
<div class="fixed_bar_bottom">
    <ul class="clearfix nav2 max750">
        <li>
            <a href="/jdt/active/index">去首页</a>
        </li>
        <li>
            @if($isVote)
                <a href="javascript:void(0)" data-id="{{$user->id}}">已投</a>
            @else
                <a href="javascript:void(0)" onclick="num_jia(this);" data-id="{{$user->id}}">投票</a>
            @endif
        </li>
        <li>
            <a href="javascript:void(0)" class="lapiao" data-id="{{$user->id}}">拉票</a>
        </li>
    </ul>
</div>
<!-- 底部固定导航 end -->
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>

<script>
    var video = '{{$userInfo->upload_video}}';
    //播放视频
    $(function (){
        //播放视频
        $('.video_box .mask_box').click(function(){
            $('.video_box .mask_box').show();//点击别的视频会把视频背景图再次呼出
            if(video != ''){
                $(this).hide();
                $(this).next().trigger('play');
            }

        })
    })
    function userlogin(){

        var url = "/jdt/active/center"+'{{$user->id}}'+'.html';
        localStorage.setItem("redirect", url);

        layer.msg('请先注册');
        setTimeout(function(){
            window.location.href = "/register";
        }, 300);
    }

    function num_jia(e){
        
        var add_num = '{{$total}}';
        var id = $(e).attr('data-id');
        var token = '{{csrf_token()}}';
        $(e).addClass('disabled');
        var data = {id:id,_token:token};
        $.ajax({
            url:'/jdt/active/postVote',
            data:data,
            type:'POST',
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    $(e).text("已投");
                    var total = parseInt(add_num)+1;
                    $(".totalVote").text(total+'票');
                    layer.msg("投票成功");
                }else if(res.code == 4){
                    $(e).removeClass('disabled');
                    userlogin();
                }else if(res.code == 5){
                    //引导关注公众号
                    $.ajax({
                        url:'/jdt/active/voteCode',
                        data:{id:id, _token:token},
                        type:'GET',
                        dataType:'json',
                        success:function(res){
                            if(res.code == 1){
                                var url = res.url;
                                layer.open({
                                    type: 1,
                                    title: false, //不显示标题栏
                                    skin: 'codeW_layer_wrap codeW_layer_success', //样式类名
                                    id: 'codeW_layer', //设定一个id，防止重复弹出
                                    closeBtn: 0, //不/显示关闭按钮
                                    anim: 2,
                                    shadeClose: 0, //开启/关闭遮罩
                                    shade: [1, '#333'],
                                    area: ['30%', '80%'],
                                    content:'<div class="hideWImg text_center mt16 relative">' +
                                    '<a class="Wjump no_Wjump d-in-black border-radius50 f26 fz color_fff" href="javascript:void(0)">关闭</a>' +
                                    '<p class="fz f44 mb40 bold mt50 color_FA6C11">你还不能投票</p>' +
                                    '<p class="plr30 fz f30 color_333 mt20 mb40">' +
                                    '<span class="block">关注公众号</span>' +
                                    '<span class="block">获得每日3次投票机会</span>' +
                                    '</p>' +
                                    '<img src="'+url+'" alt="赛普健身社区">' +
                                    '</div>',
                                    btn:false,
                                    success: function(layero,index){
                                        $(".codeW_layer_success .Wjump").click(function(){
                                            layer.closeAll();
                                        })
                                    }
                                });
                            }else{
                                layer.msg('网络错误');
                            }
                        }
                    })
                }else{
                    $(e).removeClass('disabled');
                    layer.msg(res.message);
                }
            }
        });
    }
    $(".lapiao").click(function(){
        var id = $(this).attr('data-id');
        var _token = '{{csrf_token()}}';
        var data = {id:id,_token:_token};
        $.ajax({
            url:'/jdt/active/pullTicket',
            data:data,
            type:'POST',
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    var url = res.data.shareCode;
                    layer.open({
                        type: 1,
                        title: false, //不显示标题栏
                        skin: 'canvassing_layer', //样式类名
                        id: 'canvassing_layer', //设定一个id，防止重复弹出
                        closeBtn: 1, //不显示关闭按钮
                        anim: 2,
                        shadeClose: true, //开启遮罩关闭
                        area: ['90%', '80%'],
                        content: '<div class="canvassing_layer text_center tan-font"><img src="'+url+'" class="bm_success" alt="" /><p class="fz f26 ptb20">长按图片并将图片保存到相册</p></div>',
                        btn: false
                    });
                }
            }
        })
    });

    //[ 你还不能投票 ]二维码弹窗
    $('.codeWBtn').click(function(){
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'codeW_layer_wrap codeW_layer_success', //样式类名
            id: 'codeW_layer', //设定一个id，防止重复弹出
            closeBtn: 0, //不/显示关闭按钮
            anim: 2,
            shadeClose: 0, //开启/关闭遮罩
            shade: [1, '#333'],
            area: ['30%', '80%'],
            content:'<div class="hideWImg text_center mt16 relative">' +
            '<a class="Wjump no_Wjump d-in-black border-radius50 f26 fz color_fff" href="javascript:void(0)">关闭</a>' +
            '<p class="fz f44 mb40 bold mt50 color_FA6C11">你还不能投票</p>' +
            '<p class="plr30 fz f30 color_333 mt20 mb40">' +
            '<span class="block">关注公众号</span>' +
            '<span class="block">获得每日3次投票机会</span>' +
            '</p>' +
            '<img src="../../images/qr.png" alt="赛普健身社区">' +
            '</div>',
            btn:false,
            success: function(layero,index){
                $(".codeW_layer_success .Wjump").click(function(){
                    layer.closeAll();
                })

            }
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
    var user_id = '{{$user->id}}';
    var title = '“TRAIN TO WIN”大奖在线投票';
    var desc = '我正在参加TRAIN TO WIN大赛，快来为我投票吧！';
    var share_img = "http://m.saipubbs.com/images/zt/just_do_it/share.png";
    var url = "http://m.saipubbs.com/jdt/active/center/"+user_id+'.html';
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img // 分享图标

        }, function(res) {
            //这里是回调函数

        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: title, // 分享标题
            link: url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img // 分享图标

        }, function(res) {
            //这里是回调函数

        });
    });
    //弹窗
    $(function (){
        var date = new Date();
        Y = date.getFullYear();
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1);
        D = date.getDate() < 10? '0'+(date.getDate()): date.getDate();
        var dateTime = Y+''+M+''+D;
        //弹窗
        $('.ad_img_img').click(function(){
           layer.open({
               type: 1,
               title: false, //不显示标题栏
               skin: 'bm_success_layer_wrap homge_layer_toupiao', //样式类名
               id: 'bm_success_layer', //设定一个id，防止重复弹出
               closeBtn: 1, //不显示关闭按钮
               anim: 2,
               shadeClose: true, //开启遮罩关闭
               area: ['80%', '70%'],
               content:$('.bm_success_layer_wrap'),
               btn:false
           });
        })
        // 点击x关闭
        $('.img_close').click(function() {
            $(this).hide();
            $(".ad_img_img").hide();
            localStorage.setItem('subscribe_'+dateTime, 1);
        });
        var subscribe = localStorage.getItem('subscribe_'+dateTime);
        if(subscribe==1){
            $(".ad_code").hide();
        }
    })
</script>
</body>
</html>