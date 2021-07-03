@extends('layouts.header')
@section('title')
    <title>正在学习{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/lib/jqweui/css/weui.min.css" />
    <link rel="stylesheet" href="/lib/jqweui/css/jquery-weui.min.css"/>
    <!--mmenu.css start-->
    <link rel="stylesheet" href="/lib/mmenu/css/jquery.mmenu.all.css" />
    <link rel="stylesheet" href="/lib/mmenu/css/jquery.mhead.css"/>
    <link rel="stylesheet" href="/css/nav-mmenu-public.css" />
    <!--end-->
    <link rel="stylesheet" href="/css/reset.css"/>
    <link rel="stylesheet" href="/css/font-num40.css"/>
    <link rel="stylesheet" href="/css/fenxiaoliucheng.css" >
    <link rel="stylesheet" href="/css/my_classroom.css">
@endsection
@section('content')
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
    <div class="">
        {{--<div class="daka_kecheng text_center mb30 bgcolor_gray">--}}
            {{--<ul class="clearfix fz f28 color_gray999">--}}
                {{--<li class="fl on"><a href="/user/studying">已报名课程</a></li>--}}
                {{--<li class="fl"><a href="/user/clock.html">参加的打卡课程</a></li>--}}
                {{--<li class="fl"><a href="/underline/course.html">线下大课</a></li>--}}
            {{--</ul>--}}
        {{--</div>--}}
        <!-- 列表小导航 start -->
        <div class="classroom_list_nav">
            <ul class="clearfix text_center">
                <li class="on"><a href="/user/studying" class="block fz f28 color_333"><span>单课</span></a></li>
                <li><a href="/user/train.html" class="block fz f28 color_333"><span>认证课</span></a></li>
                <li><a href="/user/clock.html" class="block fz f28 color_333"><span>训练营</span></a></li>
                {{--<li><a href="/underline/course.html" class="block fz f28 color_333"><span>线下课</span></a></li>--}}
            </ul>
        </div>
        <!-- 列表小导航 end -->
            <!--列表 start-->
            @if($list)
                <div class="classroom_single_courses mt30 mlr30 box_none block" id="list">
                    <ul>
                        @foreach ($list as $v)
                            <?php
                            $studyFinish = App\Models\CourseActivityView::where('course_class_id',$v->id)->where('user_id',$userid)->where('finished',1)->count();
                            ?>
                            <a href="/course/detail/{{$v->id}}.html">
                                <li>
                                    <dl class="clearfix">
                                        <dt class="border-radius-img"><img src="{{env('IMG_URL')}}{{$v->cover_url}}" alt="" /><span class="text_center bgcolor_orange">{{$v->level}}</span></dt>
                                        <dd>
                                            <h3 class="fz f30 bold text-overflow2">{{$v->title}}</h3>
                                            <p class="fz f24 color_4a">{{$v->name}}导师</p>
                                            <div class="pos_dd">
                                                <div class="progressBox">
                                                    <div class="clearfix words_box">
                                                        <div class="words f24 color_gray666">共<span>{{$v->sum_course}} </span>个任务，已完成<span class="color_orange">{{$studyFinish}}</span>个
                                                        </div>
                                                    </div>
                                                    <?php
                                                        $percent = round($studyFinish/$v->sum_course,2)*100;
                                                    ?>
                                                    <div class="progressBar clearfix">
                                                        <div class="progress">
                                                            <div class="bar" style="width:{{$percent}}%"></div>
                                                        </div>
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
                    @if($total >= 5)
                    <span class="weui-loadmore__tips" id="study_more" data-is_ture='1'>加载更多</span>
                    @else
                        <span class="weui-loadmore__tips" id="study_more" data-is_ture='1'>暂无课程</span>
                    @endif
                </div>
                <br><br>
            @else
                <div class="con">
                    <div class="empty"><img src="/images/empty.png" alt=""></div>
                    <h2 class="fz color_gray666  text_center mt30 pt20">没有找到课程,快去学院看看吧!</h2>
                </div>
            @endif

    </div>
    <!-- 底部固定导航条 start -->
    <div class="relative">
        <div class="fixed_bottom_4 clearfix">
            <a href="/"><span class="icon-home"></span></a>
            <a href="/article/0.html"><span class="icon-find"></span></a>
            <a href="/cak/1.html"><span class="icon-ask"></span></a>
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
                var user_id= '{{$userid}}';
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
                            if(result.data.body != ''){
                                $("#list ul").append(result.data.body);
                            }else{
                                $("#study_more").attr('data-is_ture', 0);
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
