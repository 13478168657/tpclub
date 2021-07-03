@extends('layouts.header')
@section('title')
    <title>个人收藏{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link href="/lib/swiper/swiper.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/my.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/swiper/swiper.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/my.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../css/font-num40.css">
@endsection
@section('content')

    <div class="bgcolor_fff plr20">
    <div class="tab_class pt40 pb30 mlr30 plr20">
        <a href="/user/collect/1.html" class="d-in-black color_333 f30 tab_class_ke fz bold">课程</a>
        <a href="/user/collect/2.html" class="d-in-black f28 color_gray999 fz">图文</a>
    </div>
    <!--列表 start-->
    @if(isset($list) && $list->count())
        <div class="list list_ke" id="list">
        <ul id="course_list_id">
            @foreach($list as $course)
            <li class="ptb30">
                <dl class="clearfix">
                    <dt class="border-radius-img"><img src="{{env('IMG_URL')}}{{$course->cover_url}}" alt="" /><span class="bgcolor_orange text_center fz color_333">{{$course->level}}</span></dt>
                    <dd>
                        <h3 class="lt f30 text-overflow">{{$course->title}}</h3>
                        <p class="fz color_gray666 f24">{{$course->sum_course}}  节课·{{$course->sum_study}} 人正在提高中</p>
                        <!--<p class="fz color_gray999">Jane King 导师</p>-->
                        <div class="weui-cells fz color_gray666 noafter mt0 nobefore">
                            <div class="weui-cell">
                                <div class="weui-cell__bd">
                                    <p class="f22">{{$course->name}} 导师</p>
                                </div>
                                @if($course->is_free)
                                    @if($course->sum_course == 1 || $course->preview == 0)
                                        <div class="weui-cell__ft color_orange f28 color_red">￥{{$course->price}}</div>
                                    @else
                                        <div class="weui-cell__ft color_orange f28 color_red">可试看</div>
                                    @endif
                                @else
                                    <div class="weui-cell__ft color_orange bold f28">免费</div>
                                @endif
                            </div>
                        </div>
                        <div class="text_center fz">
                            <!-- Swiper -->
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <?php
                                    echo  htmlspecialchars_decode($course->tags)
                                    ?>
                                </div>
                            </div>
                        </div>
                    </dd>
                </dl>
            </li>
            @endforeach
        </ul>
    </div>
    <!--列表 end-->
    <div class="weui-loadmore more text_center fz ptb30 remove_attr " id="study_more">
            <!-- <i class="weui-loading"></i> -->
            <span class="weui-loadmore__tips seach_more_class" id ="add_more"  data-is_ture='1'>加载更多</span>
    </div>
    @else
        <div class="con">

            <h2 class="fz color_gray666  text_center mt30 pt20">没有找到课程,快去学院看看吧!</h2>
        </div>
    @endif
    <!--加载更多-->

    {{--<div class="weui-loadmore more text_center fz ptb30">--}}
        {{--<i class="weui-loading"></i>--}}
        {{--<span class="weui-loadmore__tips">加载更多</span>--}}
    {{--</div>--}}


    <br><br>
</div><!--白色背景层 end-->



<!-- Swiper JS -->
<script src="/js/swiper.min.js"></script>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 'auto',
        leftedSlides: true,
        spaceBetween: 10,
        grabCursor: true
    });
</script>

<script src="/lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
    $(function() {
        FastClick.attach(document.body);
    });
</script>

<script src="/lib/jqweui/js/jquery-weui.js"></script>
<script>
    var page = 2;
    $('#add_more').click(function(){
        var data = {page:page,type:'collect'};
        $.ajax({
            url:'/collect/addmore/course',
            data:data,
            type:'GET',
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    page = page +1;
                    $("#course_list_id").append(res.body);
                }else{
                    $("#add_more").removeClass('seach_more_class');
                    $("#add_more").text(res.msg);
                }
            }
        });
    });

</script>
@endsection