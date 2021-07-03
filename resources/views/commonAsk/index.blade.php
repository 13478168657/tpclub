@extends('layouts.askheader')
@section('title')
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    @if($type == 1)
        <title>赛普知道-最热-健身教练专业问答平台-赛普健身社区</title>
    @else
        <title>赛普知道-待你来答-健身教练专业问答平台-赛普健身社区</title>
    @endif
    <meta name="author" content="啾啾" />
    <meta name="keywords" content="赛普知道作为健身教练的专业问答平台，致力于解决健身教练工作、职场、以及会员管理等方面的问题，帮助教练在专业知识以及技能方面获得提升。增肌减脂有问题，就来赛普知道，百名专业老师坐镇回答，问答涉及训练技术、减脂增肌、运动康复、运动营养、健身热门话题等多个方向，只有你没问到的健身问题，没有老师答不了的。" />
    <meta name="description" content="健身问题,增肌问题,减脂问题,产后问题,康复训练" />

    <!--问答下css-->
    <link rel="stylesheet" href="/css/ask.css?t=1.11">


    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
@endsection
<!---导航右侧带导航弹出---->
@section('content')
<div id="page">
    <!--导航大盒子id=page 开始  【结束在最底部】-->
    <!--头部导航 start-->

    <!--隐藏导航内容-->
    <nav id="menu"></nav>
    <!--头部导航 en-->
    <!--===========================================================================================-->
    <div class="qa_content">
        <!--导航 start-->
        {{--<div class="nav_bar_zt text_center">--}}
            {{--<ul class="clearfix fz f28 color_gray666">--}}
                {{--<li><a href="/cak/1.html" class="{{$type == 1?"cur":''}}">最热</a></li>--}}
                {{--<li><a href="/cak/2.html" class="{{$type == 2?"cur":''}}">待你来答({{sum_common_ask_questions(0)}})</a></li>--}}
                {{--<li><a href="/ask/specialdetail.html">回答专场</a></li>--}}
            {{--</ul>--}}
        {{--</div>--}}
        <!--导航 end-->
        <!-- 标签导航 start-->
        <div class="relative Nav">
            <div class="topNav-slide-left">
                <div id="topNav" class="swiper-container swiper-container-Abc fz f28 color_gray666">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide active" data-id="0"><span>全部</span></div>
                        @foreach($tagTypes as $tp)
                            <?php
                                if(empty($tp->title)){
                                    continue;
                                }
                            ?>
                        <div data-id="{{$tp->id}}" class="swiper-slide"><span>{{$tp->title}}</span></div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="topNav-slide-right text_center" onclick="xialas(this)"><img src="../images/xiala-shi.png" alt=""></div>
            <div class="topNav-slide hide bgcolor_fff text_center fz f28 color_gray666 ptb20">
                <ul class="clearfix">
                    <li data-id="0" onclick="searchTagInfo(this);" class="swiper-slide"><span>全部</span></li>
                    @foreach($tagTypes as $tp)
                        <?php
                        if(empty($tp->title)){
                            continue;
                        }
                        ?>
                        <li data-id="{{$tp->id}}" onclick="searchTagInfo(this);" class="swiper-slide"><span>{{$tp->title}}</span></li>
                    @endforeach
                    {{--<li class="active"><span>基础私教</span></li>--}}
                    {{--<li><span>瘦身燃脂</span></li>--}}
                    {{--<li><span>基础私教</span></li>--}}
                    {{--<li><span>瘦身燃脂</span></li>--}}
                    {{--<li><span>基础私教</span></li>--}}
                    {{--<li><span>瘦身燃脂</span></li>--}}
                    {{--<li><span>基础私教</span></li>--}}
                    {{--<li><span>瘦身燃脂</span></li>--}}
                    {{--<li><span>基础私教</span></li>--}}
                    {{--<li><span>瘦身燃脂</span></li>--}}
                </ul>
            </div>
            <div class="shadebg000 hide"></div>
        </div>
        <!-- 标签导航 end-->

        <!-- 新增模块[每周热议] start -->
        @if($hotQuestion)
            <?php
                $hotAnswerSum = App\Models\CommonAskAnswer::where('qid',$hotQuestion->id)->select('id')->count();
            ?>
        <a href="/cak/answer/{{$hotQuestion->id}}/1.html">
            <div class="ReYi mlr30 mt10 mb30">
                <div class="ptb20">
                    <span class="tagRy d-in-black color_fff f26 bold fz">每周热议</span>
                    <div class="plr30">
                        <p class="fz f34 fz bold text-jus">{{$hotQuestion->title}}</p>
                        <p class="f28 color_gray999"><span class="mr30">阅读：{{$hotQuestion->view}}</span><span class="ml20">讨论人数：{{$hotAnswerSum}}</span></p>

                    </div>
                </div>
            </div>
        </a>
        @endif
        <!-- 新增模块[每周热议] end -->



        <div class="qa_content_box plr30">
            <div>
                <ul>
                    @if($htQuestion)
                        <?php
                        $answers = App\Models\CommonAskAnswer::where('qid',$htQuestion->id)->orderBy('updated_at','desc')->take(2)->get();
                        $answerSum = App\Models\CommonAskAnswer::where('qid',$htQuestion->id)->select('id')->count();
                        ?>
                    <li class="ptb30">
                        <a href="/cak/answer/{{$htQuestion->id}}/1.html">
                            <dl class="clearfix">
                                <dt class="color_gray666 fz f24 fl">
                                    <span>{{$htQuestion->view}}</span>
                                    <span>阅读</span>
                                </dt>
                                <dd class="fr">
                                    <h3 class="f32 color_333 fz bold text-overflow2 relative pr90">{{$htQuestion->title}}<span class="HotSpan d-in-black f14 text_center color_fff fz">HOT</span></h3>
                                    <div class="weui-cell padding0 mt0 noafter nobefore">
                                        <div class="weui-cell__bd fz f24 color_gray9b text-overflow">
                                            <p>
                                                @foreach($answers as $answer)<span>{{$answer->user?$answer->user->nickname:''}}</span>
                                                @endforeach
                                                等{{$answerSum}}人参与讨论
                                            </p>
                                        </div>
                                        <div class="weui-cell__ft">{{App\Constant\CommentDate::getDate($htQuestion->updated_at)}}</div>
                                    </div>
                                </dd>
                            </dl>
                        </a>
                    </li>
                    @endif
                    @foreach($commonQuestions as $common)
                        <?php
                            $answers = App\Models\CommonAskAnswer::where('qid',$common->id)->orderBy('updated_at','desc')->take(2)->get();
                            $answerSum = App\Models\CommonAskAnswer::where('qid',$common->id)->select('id')->count();
                        ?>
                    <li class="ptb30">
                        <a href="/cak/answer/{{$common->id}}/1.html">
                            <dl class="clearfix">
                                <dt class="color_gray666 fz f24 fl">
                                    <span>{{$common->view}}</span>
                                    <span>阅读</span>
                                </dt>
                                <dd class="fr">
                                    <h3 class="f32 color_333 fz bold text-overflow2">{{$common->title}}</h3>
                                    <div class="weui-cell padding0 mt0 noafter nobefore">
                                        <div class="weui-cell__bd fz f24 color_gray9b text-overflow">
                                            <p>
                                                @foreach($answers as $answer)
                                                    <span>{{$answer->user?$answer->user->nickname:''}}</span>
                                                @endforeach
                                                等{{$answerSum}}人参与讨论
                                            </p>
                                        </div>
                                        <div class="weui-cell__ft">{{App\Constant\CommentDate::getDate($common->updated_at)}}</div>
                                    </div>
                                </dd>
                            </dl>
                        </a>
                    </li>
                    @endforeach

                </ul>
                @if($hasMore)
                    <a onclick="loadMore()" class="Load fz text_center pt40 mt20 color_gray666 f24">点击加载更多…</a>
                @endif
            </div>
        </div>
    </div>
    <!--===========================================================================================-->




    {{--悬浮 start--}}
    <div class="fixAsk">
        <a href="/cak/user/add.html" class="fix_box block"></a >
    </div>
    {{--悬浮 end--}}


</div>
<!--导航大盒子id=page 结束-->


<br><br><br>
<!-- 底部固定导航条 start -->
<div class="relative">
    <div class="fixed_bottom_4 clearfix">
        <a href="/"><span class="icon-home"></span></a>
        <a href="/article/0.html"><span class="icon-find"></span></a>
        <a href="/cak/1.html" class="on"><span class="icon-ask"></span></a>
        <a href="/user/studying"><span class="icon-study"></span></a>
        <a href="/user/index"><span class="icon-my"></span></a>
    </div>
</div>
<!-- 底部固定导航条 end -->

<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
    $(function() {
        FastClick.attach(document.body);
    });
    var tagid = 0;
    var type = '{{$type}}';
    var page = 2;
    function loadMore(){

        var data = {page:page,type:type,tagid:tagid};
        $.ajax({
            url:'/cak/loadMore',
            data:data,
            type:"GET",
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    $(".qa_content_box  ul").append(res.data.body);
                    page++;
                    if(res.data.hasMore == 0){
                        $('.Load').text('暂无更多');
                    }else{
                        $('.Load').text('点击加载更多…');
                    }
                }
            }
        });
    }

</script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>

<script src="/lib/swiper/swiper.min.js"></script>
<script type="text/javascript">
    var type = '{{$type}}'

    var mySwiper = new Swiper('#topNav', {
        freeMode: true,
        freeModeMomentumRatio: 0.5,
        slidesPerView: 'auto',

    });

    swiperWidth = mySwiper.container[0].clientWidth
    maxTranslate = mySwiper.maxTranslate();
    maxWidth = -maxTranslate + swiperWidth / 2

    $(".swiper-container-Abc").on('touchstart', function (e) {
//        alert(33333);
        e.preventDefault()
    });

    //一开始高亮的导航就定位到那里
    $("#topNav .swiper-slide").each(function (){
        var index = $(this).index();
        if($(this).hasClass('active')){
            var  curSwiperSlide= $(this);
            toSide(curSwiperSlide,index);
            $(".topNav-slide li").eq(index).addClass('active').siblings().removeClass('active');
        }
    })

//    $("#topNav .swiper-slide").each(function (){
//        if($(this).hasClass('active')){
//            let i = $(this).index();
//            let slideLeft = $(this).offset().left;
//            let slideWidth = $(this).outerWidth();
//            let slideCenter = slideLeft + slideWidth / 2
//            $("#topNav .swiper-slide").eq(i).addClass('active').siblings().removeClass('active');
//
//            // 被点击slide的中心点
//            mySwiper.setWrapperTransition(300)
//
//            if (slideCenter < swiperWidth / 2) {
//
//                mySwiper.setWrapperTranslate(0)
//
//            } else if (slideCenter > maxWidth) {
//
//                mySwiper.setWrapperTranslate(maxTranslate)
//
//            } else {
//
//                nowTlanslate = slideCenter - swiperWidth / 2
//                mySwiper.setWrapperTranslate(-nowTlanslate)
//
//            }
//        }
//    })

    mySwiper.on('tap', function (swiper, e) {
        tagid = $("#topNav .swiper-slide").eq(swiper.clickedIndex).attr('data-id');
        page = 1;
        var data = {tagid:tagid,type:type,page:page};
        $.ajax({
            url:'/cak/loadMore',
            data:data,
            type:'GET',
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    if(page == 1){
                        $(".qa_content_box  ul").html(res.data.body);
                    }else{
                        $(".qa_content_box  ul").append(res.data.body);
                    }

                    page++;
                    if(res.data.hasMore == 0){
                        $('.Load').text('暂无更多');
                    }else{
                        $('.Load').text('点击加载更多…');
                    }
                }
            }
        })
        e.preventDefault()
        console.log(e.currentTarget);
        slide = swiper.slides[swiper.clickedIndex]
        slideLeft = slide.offsetLeft
        slideWidth = slide.clientWidth
        slideCenter = slideLeft + slideWidth / 2
        // 被点击slide的中心点

        mySwiper.setWrapperTransition(300)

        if (slideCenter < swiperWidth / 2) {

            mySwiper.setWrapperTranslate(0)

        } else if (slideCenter > maxWidth) {

            mySwiper.setWrapperTranslate(maxTranslate)

        } else {

            nowTlanslate = slideCenter - swiperWidth / 2
            mySwiper.setWrapperTranslate(-nowTlanslate)

        }

        $("#topNav .active").removeClass('active');
        $("#topNav .swiper-slide").eq(swiper.clickedIndex).addClass('active');

        //收起下拉导航
        $(".topNav-slide").stop().slideUp("fast");
        $(".Nav .shadebg000").stop().fadeOut();
        $(".topNav-slide-right").find("img").stop().css("transform","rotate(0deg)");
        shadow =1;
        //下拉导航同步高亮
        $(".topNav-slide li").eq(swiper.clickedIndex).addClass('active').siblings().removeClass('active');
    });

    //标签下拉
    var shadow = 1;
    function xialas(){
        if(shadow == 1){
            $(".topNav-slide").stop().slideDown("fast");
            $(".Nav .shadebg000").stop().fadeIn();
            $(".topNav-slide-right").find("img").stop().css("transform","rotate(180deg)");
            shadow =0;
        }else{
            $(".topNav-slide").stop().slideUp("fast");
            $(".Nav .shadebg000").stop().fadeOut();
            $(".topNav-slide-right").find("img").stop().css("transform","rotate(0deg)");
            shadow =1;
        }
    }
    //遮罩
    $(".Nav .shadebg000").click(function(){

        console.log("333");
        xialas()
    })
    //点击下拉导航里的选项让水平导航定位
    $(".topNav-slide li").click(function(){
        var index = $(this).index();
        var curSwiperSlide = $("#topNav .swiper-slide").eq(index);
        toSide(curSwiperSlide,index);
//        xialas();
    });

    function toSide(curSwiperSlide,i){
        var slideLeft = curSwiperSlide.position().left;
        var slideWidth = curSwiperSlide.outerWidth();
        var slideCenter = slideLeft + slideWidth / 2
        $("#topNav .swiper-slide").eq(i).addClass('active').siblings().removeClass('active');

        // 被点击slide的中心点
        mySwiper.setWrapperTransition(300)

        if (slideCenter < swiperWidth / 2) {

            mySwiper.setWrapperTranslate(0)

        } else if (slideCenter > maxWidth) {

            mySwiper.setWrapperTranslate(maxTranslate)

        } else {

            nowTlanslate = slideCenter - swiperWidth / 2
            mySwiper.setWrapperTranslate(-nowTlanslate)

        }

    }
    function searchTagInfo(obj){
        tagid = $(obj).attr('data-id');
        var page = 1;
        var data = {tagid:tagid,type:type,page:page};
        $.ajax({
            url:'/cak/loadMore',
            data:data,
            type:'GET',
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    xialas()

//                    if(shadow == 1){
//                        $(".topNav-slide").stop().slideDown("fast");
//                        $(".Nav .shadebg000").stop().fadeIn();
//                        $(".topNav-slide-right").find("img").stop().css("transform","rotate(180deg)");
//                        shadow =0;
//                    }else{
//                        $(".topNav-slide").stop().slideUp("fast");
//                        $(".Nav .shadebg000").stop().fadeOut();
//                        $(".topNav-slide-right").find("img").stop().css("transform","rotate(0deg)");
//                        shadow =1;
//                    }
                    if(page == 1){
                        $(".qa_content_box  ul").html(res.data.body);
                    }else{
                        $(".qa_content_box  ul").append(res.data.body);
                    }

                    page++;
                    if(res.data.hasMore == 0){
                        $('.Load').text('暂无更多');
                    }
                }
            }
        })
    }

</script>
@endsection