<?php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();
$flag = 0;
if($user && $user->mobile !=''){
    $flag = 1;
}
?>
@extends('layouts.headercode')
@section('title')
    <title>{{$website->title}}</title>
    <meta name="keywords" content="{{$website->keywords}}" />
    <meta name="description" content="{{$website->description}}" />
@endsection

@section('cssjs')
    {{--<link rel="stylesheet" href="/css/xueyuan.css?t=1">--}}
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="/css/swiper.min.css">
    <link rel="stylesheet" href="/css/home.css">
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth/18.75 + "px";
        })()
    </script>
    <style type="text/css">
        body{background: #f2f2f2 !important}
    </style>
    @endsection

    @section('content')
            <!--banner-->
    @if($banner[0])
        <div class="banner_wapper" style="right: 0px;">
            <div id="slideBox" class="slideBox lunhome">
                <div class="bd">
                    <div class="tempWrap">
                        <ul style="">
                            @foreach($banner as $v)
                                <li style="display: table-cell; vertical-align: top; max-width: 750px;">
                                    <a href="{{$v->link}}" target="_blank">
                                        <img src="{{env('IMG_URL')}}{{$v->banner_url}}" alt="{{$v->title}}">
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="hd">
                    <ul>
                        @foreach($banner as $k=>$v)
                            <li class="">{{$k}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
    <script src="/js/TouchSlide.1.1.js"></script>
    <script type="text/javascript">
        TouchSlide({
            slideCell:"#slideBox",
            titCell:".hd ul", //?????????????????? autoPage:true ??????????????? titCell ????????????????????????
            mainCell:".bd ul",
            effect:"leftLoop",
            autoPage:true,//????????????
            autoPlay:true //????????????
        });
    </script>

    <!-- ?????????????????????????????????????????? start -->
    <div class="home_xuanze_box bgcolor_fff">
        <div class="pt30 plr30 pb30">
            <!-- ?????? start -->
            <a href="/train/list.html" class="block xz_a border-radius50 fz f26 text_center mb20">+ ??????????????????????????????????????????</a>
            <!-- ?????? end -->
            <!-- ????????????---??????????????? start-->
            @if($disCourseClass)
            <div class="home_now_canjia_box pt30">
                <a href="/dist/finish/{{$disCourseClass->id}}/{{$disPlayRecord->dis_course_id}}.html">
                <h3 class="fz f34 color_333 bold pb10">??????????????????{{$disCourseClass->title}}</h3>
                <p class="fz f28 color_gray999">???{{$nowTask}}?????????</p></a>
                <div class="h_page text_right mb26">
                    @if($prePlayRecord)
                    <a href="/dist/finish/{{$disCourseClass->id}}/{{$prePlayRecord->dis_course_id}}.html" class="d-in-black color_333 f28 text_center bgcolor_orange fz bold">?????????</a>
                    @endif
                    @if($nextPlayRecord)
                    <a href="/dist/finish/{{$disCourseClass->id}}/{{$nextPlayRecord->dis_course_id}}.html" class="d-in-black color_333 f28 text_center bgcolor_orange fz bold">?????????</a>
                    @endif
                </div>
            </div>
            @endif
            <!-- ????????????---??????????????? end-->
        </div>
        <!-- ?????? start -->
        {{--<div class="home_list_box bTop">--}}
            {{--<div class="list-art plr30">--}}
                {{--<ul>--}}
                    {{--<li class="pt30 pb30">--}}
                        {{--<a href="">--}}
                            {{--<dl class="clearfix relative">--}}
                                {{--<dt class="border-radius-img"><img src="../images/Active-page-img/mucong.png" alt="" /></dt>--}}
                                {{--<dd>--}}
                                    {{--<h3 class="fz bold f30 color_333 text-overflow2">????????????????????????????????????</h3>--}}
                                    {{--<div class="weui-cells nobefore noafter padding0 mt0">--}}
                                        {{--<div class="weui-cell nobefore noafter padding0 mt20">--}}
                                            {{--<div class="weui-cell__hd "><img src="../images/xy.png" class="width40 border-radius50"></div>--}}
                                            {{--<div class="weui-cell__bd f28 fz color_gray666">--}}
                                                {{--<p>????????????</p>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="weui-cell nobefore noafter padding0">--}}
                                            {{--<div class="weui-cell__bd mt10">--}}
                                                {{--<p class="color_gray9b f22 fz">2018.09.25</p>--}}
                                            {{--</div>--}}
                                            {{--<div class="weui-cell__ft fz f20 color_gray9b yudu-img">--}}
                                                {{--<span class=""><img src="../images/icon-xiao-xihuan.png" alt="">300</span>--}}
                                                {{--<span class="pl20"><img src="../images/icon-xiao-yuedu.png" alt="">300</span>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</dd>--}}
                            {{--</dl>--}}
                        {{--</a>--}}
                    {{--</li>--}}

                {{--</ul>--}}
            {{--</div>--}}
        {{--</div>--}}
        <!-- ?????? end -->

    </div>
    <!-- ?????????????????????????????????????????? end -->
    <!--????????? start-->
    <div class="mt20 mb20 plr30 bgcolor_fff ptb30">
        <!--Swiper start-->
        <div class="swiper-container-why swiper-container-HomeTag">
            <div class="swiper-wrapper">
                @foreach($navigations as $navigate)
                <div class="swiper-slide">
                    <a href="{{$navigate->url}}" class="fz f22 block listHomeTag text_center">
                        <img src="{{env('IMG_URL')}}{{$navigate->cover_img}}" alt="">
                        <p class="">{{$navigate->name}}</p>
                    </a>
                </div>
                @endforeach
                {{--<div class="swiper-slide">--}}
                    {{--<a href="javascript:void (0)" class="fz f22 block listHomeTag text_center">--}}
                        {{--<img src="/images/homeIcon/jiaolianxunlianying.png" alt="">--}}
                        {{--<p class="">???????????????</p>--}}
                    {{--</a>--}}
                {{--</div>--}}
                {{--<div class="swiper-slide">--}}
                    {{--<a href="javascript:void (0)" class="fz f22 block listHomeTag text_center">--}}
                        {{--<img src="/images/homeIcon/wenzhuanjia.png" alt="">--}}
                        {{--<p class="">?????????</p>--}}
                    {{--</a>--}}
                {{--</div>--}}
                {{--<div class="swiper-slide">--}}
                    {{--<a href="javascript:void (0)" class="fz f22 block listHomeTag text_center">--}}
                        {{--<img src="/images/homeIcon/huiyuanwuqu.png" alt="">--}}
                        {{--<p class="">????????????</p>--}}
                    {{--</a>--}}
                {{--</div>--}}
                {{--<div class="swiper-slide">--}}
                    {{--<a href="javascript:void (0)" class="fz f22 block listHomeTag text_center">--}}
                        {{--<img src="/images/homeIcon/remenzhuanti.png" alt="">--}}
                        {{--<p class="">????????????</p>--}}
                    {{--</a>--}}
                {{--</div>--}}
                {{--<div class="swiper-slide">--}}
                    {{--<a href="javascript:void (0)" class="fz f22 block listHomeTag text_center">--}}
                        {{--<img src="/images/homeIcon/jiaolianqingdan.png" alt="">--}}
                        {{--<p class="">????????????</p>--}}
                    {{--</a>--}}
                {{--</div>--}}
                {{--<div class="swiper-slide">--}}
                    {{--<a href="javascript:void (0)" class="fz f22 block listHomeTag text_center">--}}
                        {{--<img src="/images/homeIcon/yingyangtupu.png" alt="">--}}
                        {{--<p class="">????????????</p>--}}
                    {{--</a>--}}
                {{--</div>--}}
            </div>
        </div>
        <!--Swiper end-->
    </div>
    <!--????????? end-->

    <!-- ???????????? start -->
    @if($selected)
        <div class="bgcolor_fff">
        <!--????????????1 start-->
        <div class="mt20 ptb40 plr30">
            <div class="weui-cells mt0 padding0 nobefore noafter">
                <div class="weui-cell nobefore noafter padding0">
                    <div class="weui-cell__bd text-overflow">
                        <h2 class="fz bold text-overflow f32 color_333"><b class="color_orange f40 mr10">???</b>????????????</h2>
                    </div>
                    <?php
                        $week = [0=>'?????????',1=>'?????????',2=>'?????????',3=>'?????????',4=>'?????????',5=>'?????????',6=>'?????????'];
                        $time = $week[date('w')];
                    ?>
                    <div class="weui-cell__ft f36 color_333 bold font-Oswald-Medium"><a href="">{{str_replace('-', '.',$selected['today'])}} <span class="d-in-black f22">{{$time}}</span></a></div>
                </div>
            </div>
        </div>
        <!--????????????1 end-->
        <!-- ?????? start-->
        <div class="home_listSP_box pt30 mb30 plr30 bTop">
            @foreach(get_articla_selected($selected['article_ids']) as $article)
                <a href="/article/detail/{{$article->id}}.html">
                    <div class="boxbox">
                        <div class="video border-radius-img">
                            <div class="box2 ">
                                <img src="{{env('IMG_URL')}}{{$article->cover_url}}" alt=""/>
                                <div class="mask"></div>
                                @if($article->is_video)
                                    <span class="btn_play"></span>
                                @endif
                            </div>
                            @if($article->is_video)
                                <video src="{{$article->video_url}}" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto" ></video>
                            @endif
                        </div>
                        <div class="pt30">
                            <h3 class="fz bold f34 color_333">{{$article->title}}</h3>
                            <div class="weui-cells noafter nobefore mt0 pb30">
                                <div class="weui-cell padding0 mt10">
                                    <div class="weui-cell__hd oline_free">
                                        <?php
                                            $authorUser = getUsers($article->user_id);
                                            $photo = '';
                                            if($authorUser){
                                                $name = $authorUser->name?$authorUser->name:$authorUser->nickname;
                                                if(strpos($authorUser->avatar,'http') !== false){
                                                    $photo = $authorUser->avatar;
                                                }elseif($authorUser->avatar != ''){
                                                    $photo = env('IMG_URL').$authorUser->avatar;
                                                }else{
                                                    $photo = '/images/my/nophoto.jpg';
                                                }
                                            }
                                            $showTime = date('Y.m.d',strtotime($article->created_at));
                                        ?>

                                        <img src="{{$photo}}" alt="??????" class="border-radius50 width40" />
                                    </div>
                                    <div class="weui-cell__bd fz f20 color_gray666">

                                        <span class="f28 d-in-black mr20">{{$name}}</span>
                                        <span class="f24 d-in-black mr20">{{$showTime}}</span>
                                    </div>
                                    <div class="weui-cell__ft yudu-img fz f20 color_gray9b">
                                        <span class="d-in-black pl20"><img src="/images/icon-xiao-xihuan.png" alt="">{{$article->likes}}</span>
                                        <span class="pl20"><img src="/images/icon-xiao-yuedu.png" alt="">{{$article->views}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <!-- ?????? end-->

        <!--?????????????????? start-->
        <div class="text_center ptb40 chakanBtn bTop">
            <a href="/article/0.html" class="fz f30 color_333 d-in-black">??????????????????<img src="../images/right-jian.png" class="d-in-black" alt=""></a>
        </div>
        <!--?????????????????? end-->
    </div>
    @endif
    <!-- ???????????? end -->
    <!-- ????????????????????? start -->
    @foreach($modelSettings as $setting)
        <?php
            $projects = $setting->projects($setting->id);
        ?>
    <div class="bgcolor_fff">
        <!-- ????????????1 start-->
        <div class="mt20 ptb40 plr30">
            <div class="weui-cells mt0 padding0 nobefore noafter">
                <div class="weui-cell nobefore noafter padding0">
                    <div class="weui-cell__bd">
                        <h2 class="fz bold text-overflow f32 color_333"><b class="color_orange f40 mr10">???</b>{{$setting->name}}</h2>
                        <p class="color_gray666 fz f24 color_gray999 ml20">{{$setting->desc}}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- ????????????1 end-->
        <!-- ?????? start -->
        @if(count($projects))
        <div class="home_listMFXS_box bTop text_center pt30 pb30 plr30">
            <ul>
                @foreach($projects as $project)
                    <?php
                        $course = $project->getCourse($project->type,$project->type_id);
                        if(!$course){
                            continue;
                        }
                        if($project->type == 'DIS'){

                            $url = '/coach/'.$course->id.'.html';
                            $img = $course->cover_url;
                        }elseif($project->type == 'GROUP'){
                            $url = '/train/study.html?id='.$course->id;
                            $img = $course->list_url;
                        }else{
                            $url = '/course/detail/'.$course->id.'.html';
                            $img = $course->explain_url;
                        }

                    ?>
                <a href="{{$url}}">
                    <li>
                        <img src="{{env('IMG_URL')}}{{$img}}" alt="" class="img100">
                        <p class="bgcolor_orange fz f26 color_333">{{$course->sell_point}}</p>
                    </li>
                </a>
                @endforeach

            </ul>
        </div>
        @endif
        <!-- ?????? end -->
    </div>
    <!-- ????????????????????? end -->
    @endforeach
    {{--<!-- ????????????????????? start -->--}}
    {{--<div class="bgcolor_fff">--}}
        {{--<!-- ????????????1 start-->--}}
        {{--<div class="mt20 ptb40 plr30">--}}
            {{--<div class="weui-cells mt0 padding0 nobefore noafter">--}}
                {{--<div class="weui-cell nobefore noafter padding0">--}}
                    {{--<div class="weui-cell__bd">--}}
                        {{--<h2 class="fz bold text-overflow f32 color_333"><b class="color_orange f40 mr10">???</b>?????????????????????</h2>--}}
                        {{--<p class="color_gray666 fz f24 color_gray999 ml20">???????????????????????????????????????????????????</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<!-- ????????????1 end-->--}}
        {{--<!-- ?????? start -->--}}
        {{--<div class="home_listMFXS_box bTop text_center pt30 pb30 plr30">--}}
            {{--<ul>--}}
                {{--<li>--}}
                    {{--<img src="../images/homeIcon/homeImg1.jpg" alt="" class="img100">--}}
                    {{--<p class="bgcolor_orange fz f26 color_333">????????????</p>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</div>--}}
        {{--<!-- ?????? end -->--}}
    {{--</div>--}}
    {{--<!-- ????????????????????? end -->--}}


    <!-- ???????????? start -->
    <div class="bgcolor_fff">
        <!-- ????????????1 start-->
        <div class="mt20 ptb40 plr30 fz">
            <div class="weui-cells mt0 padding0 nobefore noafter w-jian">
                <div class="weui-cell weui-cell_access nobefore noafter padding0 ">
                    <div class="weui-cell__bd">
                        <h2 class="fz bold text-overflow f32 color_333"><b class="color_orange f40 mr10">???</b>????????????</h2>
                        <p class="color_gray666 fz f24 color_gray999 ml20">??????????????????????????????</p>
                    </div>
                    <div class="weui-cell__ft"><a href="/course/free" class="fz f26 color_gray999">????????????</a></div>
                </div>
            </div>
        </div>
        <!-- ????????????1 end-->
        <!-- ?????? start -->
        <div class="list bgcolor_fff plr30 bTop">
            <ul>
                @if($frees)
                    @foreach($frees as $v)
                        <a href="/course/detail/{{$v->id}}.html">
                            <li class="ptb30">
                                <dl class="clearfix">
                                    <dt class="border-radius-img">
                                        <img src="{{env('IMG_URL')}}{{$v->cover_url}}" alt="{{$v->title}}" />
                                        <span class="bgcolor_orange text_center fz color_333">{{$v->level}}</span>
                                    </dt>
                                    <dd>
                                        <h3 class="lt text-overflow letter04">{{$v->title}}</h3>
                                        <p class="fz color_gray666">{{$v->sum_video}} ????????{{$v->sum_people}}??????????????????</p>
                                        <!-- <p class="fz color_gray999">{{$v->teacher_name}}??????</p> -->
                                        <div class="weui-cells fz color_gray666 noafter nobefore mt0 ">
                                            <div class="weui-cell">
                                                <div class="weui-cell__bd f22">
                                                    <p>{{$v->teacher_name}}</p>
                                                </div>
                                                @if($v->is_free)
                                                    @if($v->sum_video == 1 || $v->preview == 0)
                                                        <div class="weui-cell__ft color_orange f28 color_red">?? {{$v->price}}</div>
                                                    @else
                                                        <div class="weui-cell__ft color_orange f28 color_red">?????????</div>
                                                    @endif
                                                @else
                                                    <div class="weui-cell__ft color_orange bold f28">??????</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="text_center fz">
                                            <!-- Swiper -->
                                            <div class="swiper-container">
                                                <div class="swiper-wrapper">
                                                    <?php
                                                    echo  htmlspecialchars_decode(get_course_class_tag_two($v->id))
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                    </dd>
                                </dl>
                            </li>
                        </a>
                    @endforeach
                @endif
            </ul>
        </div>
        <!-- ?????? end -->
        <div class="foot mt15 text_center">
            <p class="t_b">
                ????????????    saipubbs.com????????????<br>
                ??????????????????????????????????????????<br>
                <!-- ???ICP???16035765???-2<br> -->
                <a href="https://beian.miit.gov.cn">???ICP???16035765???-2</a><br>
            </p>
        </div>
    </div>
    <!-- ???????????? end -->
    <br/><br/><br/>
    
    <div class="relative">
        <div class="fixed_bottom_4 clearfix">
            <a href="/" class="on"><span class="icon-home"></span></a>
            <a href="/article/0.html"><span class="icon-find"></span></a>
            <a href="/cak/1.html"><span class="icon-ask"></span></a>
            <a href="/user/studying"><span class="icon-study"></span></a>
            <a href="/user/index"><span class="icon-my"></span></a>
        </div>
    </div>
    <!-- ????????????????????? end -->

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

        //????????????
        var swiper = new Swiper('.swiper-container-why', {
            pagination: '.swiper-pagination',
            paginationType: 'progress',
            slidesPerView: 'auto',
            centeredSlides: false,
            paginationClickable: true,
            spaceBetween: 10,
            grabCursor: true
        });
    </script>

    <!-- <script src="/lib/jqweui/js/jquery-2.1.4.js"></script> -->
    <script src="/lib/jqweui/js/fastclick.js"></script>
    <script src="/lib/jqweui/js/jquery-weui.js"></script>
    <script>
        var date = new Date();
        Y = date.getFullYear();

        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1);
        D = date.getDate() < 10? '0'+(date.getDate()): date.getDate();
        var dateTime = Y+''+M+''+D;
        var isDiscard = 'isDiscard_'+dateTime;
        var isShow = localStorage.getItem('isDiscard_'+dateTime);
        var hasMobile = '{{$flag}}';
        $(function() {
            FastClick.attach(document.body);
            //??????????????????

            //????????????
            $(document.body).delegate(".btn_fangqi", 'click', function () {
                localStorage.setItem(isDiscard,1);
                layer.closeAll(); //???????????????
            })
            $(document.body).delegate(".layui-layer-close", 'click', function () {
                localStorage.setItem(isDiscard,1);
                layer.closeAll(); //???????????????
            })
        });
    </script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript">

        wx.config({
            debug: false, // ??????????????????,???????????????api???????????????????????????alert????????????????????????????????????????????????pc?????????????????????????????????log???????????????pc?????????????????????
            appId: "{{$WechatShare['appId']}}", // ?????????????????????????????????
            timestamp: "{{$WechatShare['timestamp']}}", // ?????????????????????????????????
            nonceStr: "{{$WechatShare['noncestr']}}", // ?????????????????????????????????
            signature: "{{$WechatShare['signature']}}",// ???????????????
            jsApiList: [
                'checkJsApi',
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
            ] // ????????????????????????JS????????????
        });


        var link = "http://m.saipubbs.com?fission_id={{$user_id}}";
        wx.ready(function () {   //???????????????????????????????????????????????????
            wx.onMenuShareAppMessage({
                title: '{{$website->title}}', // ????????????
                desc: '{{$website->description}}', // ????????????
                link: link, // ??????????????????????????????????????????????????????????????????????????????JS??????????????????
                imgUrl: "http://m.saipubbs.com/images/tubiao/1.png", // ????????????
            }, function(res) {
                //?????????????????????
            });
        });
        wx.ready(function () {      //???????????????????????????????????????????????????
            wx.onMenuShareTimeline({
                title: '{{$website->title}}', // ????????????
                link: link, // ??????????????????????????????????????????????????????????????????????????????JS??????????????????
                imgUrl: "http://m.saipubbs.com/images/tubiao/1.png", // ????????????
            }, function(res) {
                //?????????????????????
            });
        });
        //????????????id????????????  ???????????????????????????
        var fission_id = "{{$fission_id}}";
        if(fission_id>0){
            localStorage.setItem("fission_id", fission_id);
        }

        //?????????????????????????????????
        localStorage.setItem("channel", "index");
        console.log(localStorage.getItem('fission_id')+"??????????????????");
        console.log("index"+"channel");
        //????????????????????????id
        gio('setUserId', "{{$user_id}}");
    </script>

    <script>
                    /*??????*/
                    var swiper = new Swiper('.swiper-container-t', {
                        slidesPerView: 'auto',
                        spaceBetween: 10,
                        slidesPerView:3,////????????????
                    });

                    var loading = false;
                    $(document.body).infinite().on("infinite", function() {
                        if(loading) return;
                        loading = true;
                        setTimeout(function() {
                            $("#list").append("" +
                                    "<li class='ptb30'>" +
                                    "<dl class='clearfix'>" +
                                    "<dt class='border-radius-img'><img src='../images/listimg.jpg' alt=''/><span class='bgcolor_orange text_center fz color_333'>????????????</span></dt>" +
                                    "<dd>" +
                                    "<h3 class='lt f30'>12???????????????????????????????????????</h3>" +
                                    "<p class='fz color_gray666 f24'>12 ????????89 ??????????????????</p>" +
                                    "<div class='weui-cells fz color_gray666 noafter nobefore mt0 '>" +
                                    "<div class='weui-cell'>" +
                                    "<div class='weui-cell__bd'>" +
                                    "<p class='f22'>Jane King ??????</p>" +
                                    "</div>" +
                                    "<div class='weui-cell__ft color_red bold f28'>???99</div>" +
                                    "</div>" +
                                    "</div>" +
                                    "<div class='text_center fz'>" +
                                    "<div class='swiper-container'>" +
                                    "<div class='swiper-wrapper'>" +
                                    "<div class='swiper-slide'><a class='color_gray666' href='javascript:void (0)'>????????????</a></div>" +
                                    "<div class='swiper-slide'><a class='color_gray666' href='javascript:void (0)'>????????????</a></div>" +
                                    "<div class='swiper-slide'><a class='color_gray666' href='javascript:void (0)'>????????????</a></div>" +
                                    "<div class='swiper-slide'><a class='color_gray666' href='javascript:void (0)'>????????????</a></div>" +
                                    "<div class='swiper-slide'><a class='color_gray666' href='javascript:void (0)'>??????</a></div>" +
                                    "</div>" +
                                    "</div>" +
                                    "</div>" +
                                    "</dd>" +
                                    "</dl>" +
                                    "</li>");

                            var swiper = new Swiper('.swiper-container', {
                                slidesPerView: 'auto',
                                leftedSlides: true,
                                spaceBetween: 10,
                                grabCursor: true
                            });

                            loading = false;
                        }, 2000);
                    });
                </script>
@endsection
