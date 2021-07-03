@extends('layouts.headercode')
@section('title')
    <title>赛普社区-标签相关列表</title>
    <meta name="description" content="" />
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/article.css?t=1">
@endsection

{{--<!DOCTYPE html>--}}
{{--<html lang="zh-CN">--}}
{{--<head>--}}
    {{--<meta charset="utf-8" />--}}
    {{--<meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
    {{--<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />--}}
    {{--<title>赛普社区-标签相关列表</title>--}}
    {{--<meta name="author" content="啾啾" />--}}
    {{--<meta name="keywords" content="" />--}}
    {{--<meta name="description" content="" />--}}
    {{--<link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />--}}
    {{--<link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />--}}
    {{--<!--mmenu.css start-->--}}
    {{--<link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />--}}
    {{--<link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />--}}
    {{--<link href="/css/nav-mmenu-public.css" rel="stylesheet" />--}}
    {{--<!--end-->--}}

    {{--<link rel="stylesheet" href="/lib/swiper/swiper.min.css">--}}

    {{--<link href="/css/reset.css" rel="stylesheet" type="text/css" />--}}
    {{--<link href="/css/font-num40.css" rel="stylesheet" >--}}

    {{--<!--文章下css-->--}}
    {{--<link rel="stylesheet" href="/css/article.css">--}}



    {{--<script>--}}
        {{--(function(){--}}
            {{--var html = document.documentElement;--}}
            {{--var hWidth = html.getBoundingClientRect().width;--}}
            {{--html.style.fontSize=hWidth/18.75+'px';--}}
        {{--})()--}}
    {{--</script>--}}
{{--</head>--}}
{{--<body ontouchstart>--}}
@section('content')
        <!---导航右侧带导航弹出---->

<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->

    {{--<!--头部导航 start-->--}}
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
    {{--<!--隐藏导航内容-->--}}
    {{--<nav id="menu"></nav>--}}
    {{--<!--头部导航 end-->--}}


    <div class="plr30">
        <!--小图list-->
        <div>
            <div class="weui-cells nobefore noafter">
                <div class="weui-cell left0 padding0" id="head" >
                    <div class="weui-cell__bd">
                        <h2 class="f30 bold">“{{$title}}”相关问答</h2>
                    </div>
                </div>
            </div>

            <div class="page_search_result mt20">
                <div class="list_wenda">
                    <ul>
                        @foreach($questions as $question)
                            <li>
                                <div class="weui-cell padding0 qaImg fz">
                                    <div class="weui-cell__hd">
                                        <?php
                                        $user = $question->user;
                                        ?>
                                        @if($user)
                                            @if((strpos($user->avatar,'http') !== false))
                                                <img src="{{$user->avatar}}" alt="" class="img100 border-radius50">
                                            @else
                                                @if(!empty($user->avatar))
                                                    <img src="{{env('IMG_URL')}}{{$user->avatar}}" alt="" class="img100 border-radius50">
                                                @else
                                                    <img src="/images/my/nophoto.jpg" alt="" class="img100 border-radius50">
                                                @endif
                                            @endif
                                        @else
                                            <img src="/images/my/nophoto.jpg" alt="" class="img100 border-radius50">
                                        @endif
                                    </div>
                                    <div class="weui-cell__bd f32">
                                        <?php
                                        $length = strlen($question->title);
                                        if($length >= 10){
                                            $title = mb_substr($question->title,0,10).'...';
                                        }else{
                                            $title = $question->title;
                                        }
                                        ?>
                                        <p class="d-in-black bold color_gray666">
                                            <a href="/cak/answer/{{$question->id}}/1.html">
                                                @if($user)
                                                    @if($user->name)
                                                        {{$user->name}}
                                                    @elseif($user->nickname)
                                                        {{$user->nickname}}
                                                    @else
                                                        {{'暂无昵称'}}
                                                    @endif
                                                @else
                                                    {{'暂无姓名'}}
                                                @endif
                                            </a>
                                        </p>
                                        {{--<p class="d-in-black ren"><img src="../images/ren.jpg" alt=""></p>--}}
                                        <p class="d-in-black color_gray666">提问</p>
                                    </div>
                                    <!--<div class="weui-cell__ft">5小时前</div>-->
                                </div>
                                <p class="qaText f34 bold fz color_333 mt20 text-jus"><a href="/cak/answer/{{$question->id}}/1.html"><?php echo $question->title;?></a></p>
                            </li>
                        @endforeach
                        {{--<li>--}}
                            {{--<div class="weui-cell padding0 qaImg fz">--}}
                                {{--<div class="weui-cell__hd"><img src="/images/xy.png" class="border-radius50 img100"></div>--}}
                                {{--<div class="weui-cell__bd f32">--}}
                                    {{--<p class="d-in-black bold color_gray666">标题文字</p>--}}
                                    {{--<p class="d-in-black ren"><img src="/images/ren.jpg" alt=""></p>--}}
                                    {{--<p class="d-in-black color_gray666">提问</p>--}}
                                {{--</div>--}}
                                {{--<!--<div class="weui-cell__ft">5小时前</div>-->--}}
                            {{--</div>--}}
                            {{--<p class="qaText f34 bold fz color_333 mt20 text-jus">我想问一下，地一一一地厅地要夺夺夺厅载地珠一夺夺在革地在城城在震夺夺在地地地地地</p>--}}
                        {{--</li>--}}
                    </ul>
                    @if($hasMore)
                        <a onclick="loadMore()" class="block text_center fz f26 color_333 Load" style="margin-top: 1rem;">点击加载更多…</a>
                    @endif
                </div>
            </div>
        </div>
        <!--小图 end-->
    </div><!--边距30 end-->
</div><!--导航大盒子id=page 结束-->

<br><br><br>
<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
    $(function() {
        FastClick.attach(document.body);
    });
</script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->


<script>
    $(function (){
        //弹窗
        $('.erweima').click(function(){
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'bm_success_layer_wrap', //样式类名
                id: 'bm_success_layer', //设定一个id，防止重复弹出
                closeBtn: 0, //不显示关闭按钮
                anim: 2,
                shadeClose: true, //开启遮罩关闭
                area: ['80%', '70%'],
                content:'<div class="bm_success_layer text_center"><div class="mt30 pt30"><p class="lt bold color_333 f30">识别二维码</p><p class="fz color_gray666 f24 mt10">关注赛普健身社区公众号</p></div><img src="/images/qr.png" class="bm_success" alt="" /><div><p class="lt bold color_333 f30 mt10">更新实时提醒</p><p class="fz color_gray666 f24 mt20">不错过每一次的精彩</p></div></div>',
                btn:false
            });
        });
    })

    var tagId = '{{$tagId}}';
    var page = 2;
    function loadMore(){
        var data = {page:page,tagId:tagId};
        $.ajax({
            url:'/cak/search/more',
            data:data,
            type:"GET",
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    $(".page_search_result  ul").append(res.data.body);
                    page++;
                    if(res.data.hasMore == 0){
                        $('.Load').text('暂无更多');
                    }
                }
            }
        });
    }
</script>
@endsection