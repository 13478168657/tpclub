@extends('layouts.header')
@section('title')
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>教练清单</title>
    <meta name="author" content="涵" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <!--mmenu.css start-->
    <link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
    <link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
    <link href="/css/nav-mmenu-public.css" rel="stylesheet" />
    <!--end-->
    <link href="/css/reset.css?t=1.21" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" >
    <!--教练清单css-->
    <link rel="stylesheet" href="/css/qingdan.css">
    <link rel="stylesheet" href="/css/ask_popup.css">


    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
@endsection
@section('content')

<!---导航右侧带导航弹出---->

<div id="page">
    <!--导航大盒子id=page 开始  【结束在最底部】-->

    <!--头部导航 start-->
    {{--<div class="mh-head Sticky">--}}
        {{--<div class=" menu-bg-logo">--}}
			{{--<span class="mh-btns-left">--}}
				{{--<a class="icon-menu icon-sousuo" href="javascript:;"></a>--}}
			{{--</span>--}}
			{{--<span class="mh-btns-right">--}}
				{{--<a class="icon-menu erweima icon-erweima" href="javascript:;"></a>--}}
			{{--</span>--}}
        {{--</div>--}}
    {{--</div>--}}
    <!--隐藏导航内容-->
    <nav id="menu"></nav>
    <!--头部导航 end-->

    <!--===================================================================================-->
    <!-- 导航 start -->
    <div class="Qnav fz plr30 relative">
        <ul class="clearfix tab1_tit">
            <li><a href="javascript:void (0)" class="f28 color_gray666 ding">全部方向 <img src="/images/xiala-shi.png" alt=""></a></li>
            <li><a href="javascript:void (0)" class="f28 color_gray666 Unlimited">不限部位 <img src="/images/xiala-shi.png" alt=""></a></li>
        </ul>
        <p onclick="loadMore(this);" data-id="z" data-type="zan" class="dianzanMore bgcolor_orange color_333 f24 text_center">点赞更多</p>
    </div>

    <div class="tab1_box">
        <div class="text_center fz Dbox2 Dshow hide">
            <ul class="clearfix">
                @foreach($coachClassify as $k => $classify)
                <li class="{{$k==0?"on":""}}" onclick="loadMore(this);" data-id="{{$classify->id}}" data-type="pos">
                    <a href="javascript:void (0)" class="block border-radius50 f26">{{$classify->name}}</a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="text_center fz Dbox2 Dshow2 hide">
            <ul class="clearfix">
                @foreach($coachTags as $k => $tag)
                <li onclick="loadMore(this);" class="{{$k==0?"on":""}}" data-id="{{$tag->id}}" data-type="tag">
                    <a href="javascript:void (0)" class="block border-radius50 f26">{{$tag->name}}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- 导航 end -->


    <!-- 列表 start-->
    <div class="mlr30 pt30 fz append">
        <!--  start-->
        @foreach($coachList as $k => $coach)
        <a class="bgcolor_f9f9f9 {{$k==0?'mb30':''}}" href="/coach/detail/{{$coach->id}}.html">
            <div class="stepBox mlr40 pt40 pb40">
                <h4 class="bold f28 color_333 pb20 line36">{{$coach->name}}</h4>
                <p class="f24 color_gray999 text-jus line36">{{$coach->deal_problem}}</p>
            </div>
        </a>
        @endforeach
        <!--  end-->
    </div>
    <!-- 列表 end-->


</div>
<!--导航大盒子id=page 结束-->


<br><br><br>
<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->
<script type="text/javascript">

    $(".tab1_tit li").click(function(){
        var index=$(this).index();

        if($(this).hasClass('is_show')){
            console.log("333");
            $(this).removeClass('is_show bold color_333');
            $('.tab1_box').children('div').eq(index).stop().slideUp("fast");
            $(this).find("img").stop().css({"transform":"rotate(0deg)","opacity":".5"});

        }else{
            console.log("222");
            $(this).addClass('is_show bold color_333').siblings().removeClass('is_show bold color_333');
            $('.tab1_box').children('div').eq(index).stop().slideDown("fast").siblings().stop().slideUp("fast");
            $(this).find("img").stop().css({"transform":"rotate(180deg)","opacity":"1"}).parents().siblings().find("img").stop().css({"transform":"rotate(0deg)","opacity":".5"})
        }
    });

    function loadMore(obj){
        alert($(obj).attr('data-id'));
        var id = $(obj).attr('data-id');
        var type = $(obj).attr('data-type');
        var data = {id:id,type:type};
        $.ajax({
            url:'/user/coach/list.html',
            data:data,
            type:'GET',
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    alert(res.message);
                    $('.append').html(res.data.body);
                }
            }
        });
    }
</script>
@endsection