<!-- <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>我的收藏-图文</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/xueyuan.css">
    <link rel="stylesheet" href="/css/font-num40.css">
    Link Swiper's CSS
    <link rel="stylesheet" href="/css/swiper.min.css">

    <!--jqweui css-->
    <!-- <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth/18.75 + "px";
        })()
    </script>
</head>
<body> -->
@extends('layouts.headercode')
@section('title')
    <title>{{$title}}{{env('WEB_TITLE')}}</title>
    <meta name="description" content="{{$description}}" />
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/article.css">
    <style>
        #page {padding-bottom:3rem;}
    </style>
    
@endsection
@section('content')    
<div class="bgcolor_fff plr30">
    <div class="page_dailySelection">
    <!--导航 start-->
            <div class="swiper-art-mar1 clearfix">
                <!-- Swiper -->
                <div class="swiper-container swiper-art-nav1 fz">
                    <div class="swiper-wrapper f28">
                        @if($typelist)
                            @foreach($typelist as $k=>$item)
                                <div class="swiper-slide index_{{$item->id}}" data-cid="{{$k}}">
                                    <a href="/article/question/{{$item->id}}.html">{{$item->title}}</a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <!--下箭头-->
                <div class="icon-xiala"></div>
            </div>

    <!--列表 start-->
    <div class="list-art" id="list">
        <ul id="index_article_list">
            @if($articlelist->count())
            @foreach($articlelist as $k=>$article)
            <li class="ptb40">
                <a href="/article/detail/{{$article->id}}.html">
                    <h3 class="lt f30 color_333 text-overflow2">{{$article->title}}</h3>
                    <div class="weui-cells nobefore noafter padding0 art-list-title mt0">
                        <div class="weui-cell nobefore noafter padding0 mt10">
                            <div class="weui-cell__bd">
                                <p class="color_gray9b f22 fz">
                                    @if($article->author && $article->author->avatar)
                                        @if(strpos($article->author->avatar,'http') !== false)
                                            <img src="{{$article->author->avatar}}" class="border-radius50" />
                                        @else
                                            <img src="{{env('IMG_URL')}}{{$article->author->avatar}}" alt="头像" class="border-radius50" />
                                        @endif
                                    @else
                                    <img src="/images/my/nophoto.jpg" alt="头像" class="border-radius50" />
                                    @endif
                                    <span class="color_gray666 mr30 f28">{{$article->author?$article->author->name:''}}</span>
                                    <span class="color_gray9b">{{substr($article->created_at,0, 10)}}</span>
                                </p>
                            </div>
                            <div class="weui-cell__ft fz f20 color_gray9b yudu-img">
                                <span class=""><img src="/images/icon-xiao-xihuan.png" alt="">{{$article->likes}}</span>
                                <span class="pl20"><img src="/images/icon-xiao-yuedu.png" alt="">{{$article->views}}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
            @endforeach
            @endif
        </ul>
   </div>

<!--列表 end-->

    <!--加载更多-->
    <div class="weui-loadmore more text_center fz ptb30">
        <!-- <i class="weui-loading"></i> -->
        <!-- <span class="weui-loadmore__tips">正在加载</span> -->
        <span class="weui-loadmore__tips" id="article_more" data-is_ture='1'>加载更多</span>
    </div>

    <!-- 半透明蒙版 start -->
            <div class="bg_mask">
                <div class=""></div>
                <ul class="nav-list1 f28 fz">
                    @foreach($typelist as $k=>$item)
                        <li><a href="/article/question/{{$item->id}}.html">{{$item->title}}</a></li>
                    @endforeach
                </ul>
            </div>
            <!-- 半透明蒙版 end -->

    <br><br>
    </div>
</div><!--白色背景层 end-->


<script src="/lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
                             
<script src="/lib/jqweui/js/jquery-weui.js"></script>
<!-- Swiper JS -->
<script src="/lib/swiper/swiper.min.js"></script>
<!-- Initialize Swiper -->

<script>
$(function (){

    $(function (){
        var events = navigator.userAgent;
        var mobile = 'phone';
        if(events.indexOf('Android')>-1 || events.indexOf('Linux')>-1 || events.indexOf('Adr')>-1){
            mobile = '';
        }else if(events.indexOf('iPhone')>-1){
            //根据尺寸进行判断 苹果的型号
            if(screen.height == 812 && screen.width == 375){// 进行操作，改变样式
                //console.log("苹果X");
            }else if(screen.height == 736 && screen.width == 414){
                mobile = 'phonePlus';
            }else if(screen.height == 667 && screen.width == 375){
                //console.log("iPhone7 - iPhone8 - iPhone6");
            }else if(screen.height == 568 && screen.width == 320){
                //console.log("iPhone5");
            }else if(events.indexOf('Windows Phone')>-1){
                //console.log("诺基亚手机");
            }else{
                //console.log("iPhone4");
            }

        }else if(events.indexOf("iPad")>-1){

        }
        //导航
        var cid="{{$cid}}";
        //var cid=4;
        var datacid=parseInt($('.index_'+cid).attr('data-cid'));
        var swiper = new Swiper('.swiper-art-nav1', {
            pagination: '.swiper-pagination',
            slidesPerView:'auto',////可见个数
            initialSlide :datacid,//默认第一个
            //centeredSlides: true,//居中
            paginationClickable: true,
            spaceBetween: 0
        });
        $('.swiper-art-nav1 .swiper-slide a').removeClass('font-active');
        $('.swiper-art-nav1 .swiper-slide').eq(datacid).find('a').addClass('font-active');
        
        var flag1=false;
        $('.icon-xiala').click(function (){
            if(!flag1){
                $(this).addClass('up');
                $('body').addClass('fixed100');//解决移动端滚动穿透
                $('.bg_mask').fadeIn(400).show();
                $('.nav-list1').slideDown(400);

            }else{
                $(this).removeClass('up');
                $('body').removeClass('fixed100');
                $('.bg_mask').hide();
                $('.nav-list1').slideUp();
            }
            flag1=!flag1;
        });
    });

})
</script>
<script>

    $(document).ready(function() {
        //加载更多
        var page = 1;
        var type_id = "{{$type_id}}";
        var type   = "type";
        var imgUrl = "{{env('IMG_URL')}}";  //图片公共地址
        $("#article_more").click(function(){
            page++;
            //如果没有数据就不再请求数据库了
            var is_ture= $(this).attr('data-is_ture');
            if(is_ture<1){
                layer.msg('抱歉没有更多的数据了');
                return;
            }
            $.ajax({
                type:"get",
                url:"/article/addmorei",
                data:{type_id:type_id, page:page, type:type},
                dataType:"json",
                success:function(result){
                    console.log(result);
                    if(result.code==1){
                        for (var item in result.list) {
                            var url = "/article/detail/"+ result.list[item].id+".html";
                            if((result.list[item].avatar).indexOf("http") > -1){
                                    var img = result.list[item].avatar;
                            }else{
                                var img = imgUrl+result.list[item].avatar;
                            }
                            if(result.list[item].user_name){
                                var name = result.list[item].user_name;
                            }else{
                                var name = "--";
                            }
                            if(result.list[item].is_selected){
                                
                                var tuiguang = "<img class='icon-new-hot' src='/images/icon-hot.png' alt=''>";
                            }else{
                                var tuiguang = "";
                            }
                                
                            $("#index_article_list").append("" +
                            "<li class='ptb40'>" +
                            "<a href='"+url+"'>"+
                            "<h3 class='lt f30 color_333 text-overflow2'>"+result.list[item].title+"</h3>" +
                            "<div class='weui-cells nobefore noafter padding0 art-list-title mt0'>" +
                            "<div class='weui-cell nobefore noafter padding0 mt10'>" +
                            "<div class='weui-cell__bd'>" +
                            "<p class='color_gray9b f22 fz'>" +
                            "<img class='border-radius50 d-in-black img-width44 img-middle mr20' src='"+img+"'>" +
                            "<span class='color_gray666 mr30 f28'>"+name+"</span>" +
                            "<span class='color_gray9b'>"+result.list[item].created+"</span>" +
                            " </p>" +
                            "</div>" +
                            " <div class='weui-cell__ft fz f20 color_gray9b yudu-img'>" +
                            "<span class=''><img src='/images/icon-xiao-xihuan.png' alt=''>"+result.list[item].likes+"</span>" +
                            "<span class='pl20'><img src='/images/icon-xiao-yuedu.png' alt=''>"+result.list[item].views+"</span>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</a>" +
                            "</li>");
                        }
                    }else{
                        $("#article_more").attr('data-is_ture', 0);
                        $("#article_more").text('抱歉没有更多的数据了');
                        layer.msg(result.msg);
                    }
                }
            });
        });
    });
</script>
<script>
    var loading = false;
    $(document.body).infinite().on("infinite", function() {
        if(loading) return;
        loading = true;
        setTimeout(function() {
            $("#list---").append("" +
                    "<li class='ptb40'>" +
                    "<a href=''>"+
                    "<h3 class='lt f30 color_333 text-overflow2'>世界形体小姐的极塑美臀课世界形体小姐世界形体小姐的极塑美臀课世界形体小姐</h3>" +
                    "<div class='weui-cells nobefore noafter padding0 art-list-title mt0'>" +
                    "<div class='weui-cell nobefore noafter padding0 mt10'>" +
                    "<div class='weui-cell__bd'>" +
                    "<p class='color_gray9b f22 fz'>" +
                    "<img class='border-radius50 d-in-black img-width44 img-middle mr20' src='../images/xy.png'>" +
                    "<span class='color_gray666 mr30 f28'>浪客剑心</span>" +
                    "<span class='color_gray9b'>2018.09.25</span>" +
                    " </p>" +
                    "</div>" +
                    " <div class='weui-cell__ft fz f20 color_gray9b yudu-img'>" +
                    "<span class=''><img src='../images/icon-xiao-xihuan.png' alt=''>300</span>" +
                    "<span class='pl20'><img src='../images/icon-xiao-yuedu.png' alt=''>300</span>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</a>" +
                    "</li>");


            loading = false;
        }, 2000);
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
    
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({ 
            title: '{{$title}}', // 分享标题
            desc: '{{$description}}', // 分享描述
            link: "http://m.saipubbs.com/article/question/{{$cid}}.html", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/q_share.png", // 分享图标
            
        }, function(res) { 
        //这里是回调函数 
            
        }); 
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({ 
            title: '{{$title}}', // 分享标题
            link: "http://m.saipubbs.com/article/question/{{$cid}}.html", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/q_share.png", // 分享图标
            
        }, function(res) { 
        //这里是回调函数
            
        }); 
    });
</script>
@endsection