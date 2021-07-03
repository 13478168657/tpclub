@extends('layouts.header')
@section('title')
    <title>正在学习{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/xueyuan.css">
    <link rel="stylesheet" href="/css/fenxiaoliucheng.css" >
@endsection
@section('content')
    <div class="">
        <div class="daka_kecheng text_center mb30 bgcolor_gray">
            <ul class="clearfix fz f28 color_gray999">
                <li class="fl"><a href="/user/studying">已报名课程</a></li>
                <li class="fl"><a href="/user/clock.html">参加的打卡课程</a></li>
                <li class="fl on"><a href="/underline/course.html">线下大课</a></li>
            </ul>
        </div>
        <!-- <div class="fixed_bar_top">
            <header class="header_bar bgc_grey relative">
                <a href="javascript:history.go(-1);" class="btn_back"><i></i></a>
                <h1 class="cat">正在学习</h1>
            </header>
        </div> -->
        <div class="mlr30">
            @if($total)
            <div class="">
                <ul>
                    @foreach($orders as $order)
                        <?php
                            $courseClass = App\Models\Courseclass::where('id',$order->course_class_id)->first();
                        ?>
                        <li class="mb30">
                            <a href="javascript:void(0)" class="block">
                                <img src="{{env('IMG_URL')}}{{$courseClass->cover_url}}" alt="">
                                <p class="f32 bold ptb13 fz text-overflow2 text-jus" style="max-height: 3rem;">{{$courseClass->title}}</p>
                            </a>
                        </li>
                    @endforeach
                    @if($hasNext)
                        <div class="weui-loadmore more text_center fz ptb30">
                            <!-- <i class="weui-loading"></i> -->
                            <span class="weui-loadmore__tips" id="study_more" data-is_ture='1'>加载更多</span>
                        </div>
                    @endif
                </ul>
            </div>
                <!--加载更多-->
            {{--@if($hasNext)--}}

            {{--@endif--}}
            @else
                <div class="con">
                    <div class="empty"><img src="/images/empty.png" alt=""></div>
                    <h2 class="fz color_gray666  text_center mt30 pt20">没有找到课程,快去学院看看吧!</h2>
                </div>
            @endif

        </div>

    </div>
    <!-- 底部固定导航条 start -->
    <div class="relative">
        <div class="fixed_bottom_4 clearfix">
            <a href="/"><span class="icon-home"></span></a>
            <a href="/article/0.html"><span class="icon-find"></span></a>
            <a href="/ask/specialdetail.html"><span class="icon-ask"></span></a>
            <a href="/user/studying" class="on"><span class="icon-study"></span></a>
            <a href="/user/index"><span class="icon-my"></span></a>
        </div>
    </div>
    <!-- 底部固定导航条 end -->

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
                var type   = 'study';
                var user_id= {{$userid}};
                //如果没有数据就不再请求数据库了
                var is_ture= $(this).attr('data-is_ture');
                if(is_ture<1){
                    layer.msg('没有更多课程了');
                    return;
                }
                $.ajax({
                    type:"GET",
                    url:"/underline/course.html",
                    data:{page:page},
                    dataType:"json",
                    success:function(result){

                        if(result.code==0){
                            var has_next = result.data.hasNext;
                            if(has_next == 0){
                                $('ul li.mb30').next(result.data.body);
                                $("#study_more").text('没有更多课程了');
                            }else{
                                $("#study_more").attr('data-is_ture', result.data.page);
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
