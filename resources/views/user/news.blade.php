@extends('layouts.header')
@section('title')
    <title>消息{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/xueyuan.css">
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth/18.75 + "px";
        })()
    </script>
@endsection
@section('content')
<body ontouchstart style="background: #fff;">
<!-- 头部条 start -->
<!-- <div class="fixed_bar_top">
    <header class="header_bar bgc_grey relative">
        <a href="javascript:history.go(-1);" class="btn_back"><i class="icon iconfont icon-fenxiang2"></i></a>
        <h1 class="cat">消息列表</h1> -->
        <!-- <a href="javascript:void(0)" class="btn_link red" id="edit">编辑</a> -->
    <!-- </header>
</div> -->
<!-- 头部条 end -->
    <ul class="mlr30 new_my">
        <!--消息 start-->
        @if(isset($list[0]))
        @foreach($list as $v)
        <li>
            <div class="weui-cells nobefore noafter mt0 news-tit ptb30">
                <a class="weui-cell weui-cell_access padding0" href="javascript:;">
                    <div class="weui-cell__hd new_img"><img class="border-radius50" src="{{env('IMG_URL')}}{{$v->userAvatar}}"></div>
                    <div class="weui-cell__bd text-overflow">
                        <h2 class="lt f28">{{$v->usersName}}</h2>
                        <p class="fz text-overflow color_gray666 f26">@if($v->message_type == "BUY")购买@elseif($v->message_type == "like")喜欢@else评价@endif了你的课程:《{{$v->title}}》</p>
                    </div>
                    <div class="fz f20 color_gray999 mb40">{{$v->created_at}}</div>
                </a>
                @if($v->comment)
                    <p class="fz f24 color_gray666 new_ping mt20">{{$v->comment}}</p>
                @endif
            </div>
        </li>
        @endforeach
        <!--消息 end-->
    </ul>

      <!--  <div class="weui-loadmore more text_center fz ptb30 remove_attr " id="study_more">
            <span class="weui-loadmore__tips" id ="add_more"  data-is_ture='1'>加载更多</span>
        </div>-->


    @else
        <div class="con">
            <div class="empty"><img src="/images/empty.png" alt=""></div>
            <h2 class="fz color_gray666  text_center mt30 pt20">暂无消息</h2>
        </div>
    @endif

<!--课程目录 end-->

<script src="../lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="../lib/jqweui/js/fastclick.js"></script>
<script>
    $(function() {
        FastClick.attach(document.body);
    });
</script>

<script src="../lib/jqweui/js/jquery-weui.js"></script>
@endsection