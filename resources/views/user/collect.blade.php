@extends('layouts.header')
@section('title')
    <title>收藏列表{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/xueyuan.css">
@endsection
@section('content')    
<div class="">
    <!-- <div class="fixed_bar_top">
        <header class="header_bar bgc_grey relative">
            <a href="javascript:history.go(-1);" class="btn_back"><i></i></a>
            <h1 class="cat">收藏的课程</h1>
        </header>
    </div> -->
     @if($list)
    <div class="bgcolor_fff plr20">
        <!--列表 start-->
        <div class="list" id="list">
            <ul>
                @foreach ($list as $v)
                <a href="/course/detail/{{$v->id}}.html">
                <li class="ptb30">
                    <dl class="clearfix">
                        <dt class="border-radius-img"><img src="{{env('IMG_URL')}}{{$v->cover_url}}" alt="" /><span class="bgcolor_orange text_center fz color_333">{{$v->cytitle}}</span></dt>
                        <dd>
                            <h3 class="lt text-overflow">{{$v->title}}</h3>
                            <p class="fz color_gray666">{{$v->sum_course}} 节课·{{$v->sum_study}} 人正在提高中</p>
                            <!-- <p class="fz color_gray999">{{$v->name}}老师</p> -->
                            <div class="weui-cells fz color_gray666 noafter nobefore mt0 ">
                                <div class="weui-cell">
                                    <div class="weui-cell__bd f22">
                                        <p>{{$v->name}}</p>
                                    </div>
                                    @if($v->is_free)
                                    <div class="weui-cell__ft color_orange f28 color_red">可试看</div>
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
                                          echo  htmlspecialchars_decode($v->tags)
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </dd>
                    </dl>
                </li>
                </a>
                @endforeach
               
            </ul>
        </div>
        <!--列表 end-->

        <!--加载更多-->
        <div class="weui-loadmore more text_center fz ptb30">
            <!-- <i class="weui-loading"></i> -->
            <span class="weui-loadmore__tips" id="study_more" data-is_ture='1'>加载更多</span>
        </div>
        <br><br>
    </div><!--白色背景层 end-->
     @else
    <div class="con">
        <div class="empty"><img src="/images/empty.png" alt=""></div>
        <h2 class="fz color_gray666  text_center mt30 pt20">没有找到课程,快去学院看看吧!</h2>
    </div>
    @endif
</div>
<!-- 功能列表 end -->
<!-- 粉丝 end -->
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
    $(document).ready(function() {
        //加载更多
        var page = 1;
        var www  = "{{env('IMG_URL')}}";
        $("#study_more").click(function(){
            page++;
            var type   = 'collect';
            var user_id= {{$userid}};
            //如果没有数据就不再请求数据库了
            var is_ture= $(this).attr('data-is_ture');
            if(is_ture<1){
                layer.msg('没有更多课程了');
                return;
            }
            $.ajax({
                type:"GET",
                url:"/user/addmorecourse",
                data:{type:type, user_id:user_id, page:page},
                dataType:"json",
                success:function(result){
                    console.log(result.list);
                    if(result.code==1){
                        for (var i in result.list) {
                            if(result.list[i].is_free){
                                var text ='<div class="weui-cell__ft color_orange f28 color_red">可试看</div>';
                            }else{
                                var text ='<div class="weui-cell__ft color_orange bold f28">免费</div>';
                            }
                            $("#list").append("" +
                            "<a href='/course/detail/"+result.list[i].id+".html'><li class='ptb30'><li class='ptb30'>" +
                            "<dl class='clearfix'>" +
                            "<dt class='border-radius-img'><img src='"+www+result.list[i].cover_url+"' alt=''/><span class='bgcolor_orange text_center fz color_333'>训练学院</span></dt>" +
                            "<dd>" +
                            "<h3 class='lt text-overflow'>"+result.list[i].title+"</h3>" +
                            "<p class='fz color_gray666'>"+result.list[i].sum_course+" 节课·"+result.list[i].sum_study+" 人正在提高中</p>" +
                            '<div class="weui-cells fz color_gray666 noafter nobefore mt0 ">'+
                                '<div class="weui-cell">'+
                                    '<div class="weui-cell__bd f22">'+
                                        '<p>'+result.list[i].name+'</p>'+
                                    '</div>'+text+
                                '</div>'+
                            '</div>'+
                            "<div class='text_center fz'>" +
                            "<div class='swiper-container'>" +
                            "<div class='swiper-wrapper'>" +
                            result.list[i].tags+
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</dd>" +
                            "</dl>" +
                            "</li></a>");
                            var swiper = new Swiper('.swiper-container', {
                                slidesPerView: 'auto',
                                leftedSlides: true,
                                spaceBetween: 10,
                                grabCursor: true
                            });
                        }    
                    }else{
                        $("#study_more").attr('data-is_ture', 0);
                        $("#study_more").text('没有更多课程了');
                        layer.msg(result.msg);
                    }
                }
            });
        });
    });
</script>
@endsection