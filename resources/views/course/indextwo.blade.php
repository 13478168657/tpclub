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
    <link rel="stylesheet" href="/css/xueyuan.css?t=1">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="/css/swiper.min.css">
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


    <!--??????????????? start-->
    <div class="mt20 mb20 plr30 bgcolor_fff ptb30">
        <!--Swiper start-->
        <div class="swiper-container-why swiper-container-HomeTag">
            <div class="swiper-wrapper">
                @foreach($coursetypes as $k => $type)
                <div class="swiper-slide">
                    <a href="/course/ctypeDetail/{{$type->id}}/0.html" class="color_fff f26 relative block listHomeTag text_center">
                        <img src="/images/icon_img{{$k+1}}.png" alt="">
                        <p class="">{{$type->title}}</p>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <!--Swiper end-->
    </div>
    <!--??????????????? end-->

{{--<div class="home_module_wrap text_center ptb30 fz bgcolor_fff">--}}
    {{--<div class="plr25 clearfix">--}}
        {{--@foreach($coursetypes as $type)--}}
        {{--<a href="/course/ctypeDetail/{{$type->id}}/0.html" class="color_fff f26 mb20">--}}
            {{--<div class="weui-flex__item">{{$type->title}}</div>--}}
        {{--</a>--}}
        {{--@endforeach--}}
    {{--</div>       --}}
{{--</div>--}}


<!--???????????????????????? start-->
    @if($initCourses->count())
    <div class="">
        <div class="plr30 bgcolor_fff mt32 pt40">
            <div class="weui-cells nobefore noafter mt0  w-jian">
                <a class="weui-cell weui-cell_access padding0" href="javascript:;">
                    <div class="weui-cell__bd color_333 f34 fz bold">
                        <p><span class="color_orange">???</span>????????????????????????</p>
                    </div>
                    <!--<div class="weui-cell__ft color_gray999 f26">-->
                    <!--????????????-->
                    <!--</div>-->
                </a>
            </div>
        </div>
        @foreach($initCourses as $init => $initCourse)
            <?php

                $sum_video    = sum_course($initCourse->id)->count;
                $sum_people   = sum_study($initCourse->id)->count;
                $total = $initCourses->count();
            ?>
        <div class="bgcolor_fff plr30 replace_wrap">
            <a href="/course/detail/{{$initCourse->id}}.html">
                <div class="replace border-radius-img relative pt30">
                    <img class="max-img-banner" src="{{env('IMG_URL')}}{{$initCourse->explain_url}}" alt="">
                    <!--<span class="bgcolor_orange text_center fz color_333 f22 d-in-black">S1?????????</span>-->
                </div>
                <h3 class="f30 color_333 fz bold mt20">{{$initCourse->course_alias}}</h3>
                <div class="weui-cells fz color_gray666 noafter nobefore mt0 padding0">
                    <div class="weui-cell padding0 mb30">
                        <div class="weui-cell__bd">
                            <p class="f24 color_gray666">{{$sum_video}} ????????{{$sum_people}} ??????????????????</p>
                        </div>
                        <!--<div class="weui-cell__ft color_orange bold">??????</div>-->
                    </div>
                </div>
            </a>
        </div>

        <!-- ???????????? start-->
        @if($init < $total-1)
        <div class="bgcolor_fff"><div class="bTop mlr30 "></div></div>
        @endif
        <!-- ???????????? end-->
        @endforeach
        @if($disCourse)
            <?php
                $disCourseNum = count(explode(',',$disCourse->course_ids));
            ?>
            <div class="bgcolor_fff plr30 replace_wrap">
                <a href="/course/detail/{{$disCourse->id}}.html">
                    <div class="replace border-radius-img relative pt30">
                        <img class="max-img-banner" src="/images/fenxiaoliucheng/nx.jpg" alt="">
                        <!--<span class="bgcolor_orange text_center fz color_333 f22 d-in-black">S1?????????</span>-->
                    </div>
                    <h3 class="f30 color_333 fz bold mt20">{{$disCourse->title}}</h3>
                    <div class="weui-cells fz color_gray666 noafter nobefore mt0 padding0">
                        <div class="weui-cell padding0 mb30">
                            <div class="weui-cell__bd">
                                <p class="f24 color_gray666">{{$disCourseNum}} ????????{{$disNum}} ??????????????????</p>
                            </div>
                            <!--<div class="weui-cell__ft color_orange bold">??????</div>-->
                        </div>
                    </div>
                </a>
            </div>
        @endif
    </div>
    @endif
    <!--???????????????????????? end-->

    <!--?????????????????????????????? start-->
    <div class="">
        <div class="plr30 bgcolor_fff mt32 pt40">
            <div class="weui-cells nobefore noafter mt0  w-jian">
                <a class="weui-cell weui-cell_access padding0" href="javascript:;">
                    <div class="weui-cell__bd color_333 f34 fz bold">
                        <p><span class="color_orange">???</span>????????????????????????</p>
                    </div>
                    <!--<div class="weui-cell__ft color_gray999 f26">-->
                    <!--????????????-->
                    <!--</div>-->
                </a>
            </div>
        </div>
        @foreach($stageCourses as $stageCourse)
            <?php
                $sum_video    = sum_course($stageCourse->id)->count;
                $sum_people   = sum_study($stageCourse->id)->count;
            ?>
        <div class="bgcolor_fff plr30 replace_wrap">
            <a href="/course/detail/{{$stageCourse->id}}.html">
                <div class="replace border-radius-img relative pt30">
                    <img class="max-img-banner" src="{{env('IMG_URL')}}{{$stageCourse->explain_url}}" alt="">
                    <!--<span class="bgcolor_orange text_center fz color_333 f22 d-in-black">S1?????????</span>-->
                </div>
                <h3 class="f30 color_333 fz bold mt20">{{$stageCourse->course_alias}}</h3>
                <div class="weui-cells fz color_gray666 noafter nobefore mt0 padding0">
                    <div class="weui-cell padding0 mb30">
                        <div class="weui-cell__bd">
                            <p class="f24 color_gray666">{{$sum_video}} ????????{{$sum_people}} ??????????????????</p>
                        </div>
                        <!--<div class="weui-cell__ft color_orange bold">??????</div>-->
                    </div>
                </div>
            </a>
        </div>
        <div class="bgcolor_fff"><div class="bTop mlr30 "></div></div>
        @endforeach

        @foreach($one as $v)
        <div class="bgcolor_fff plr30 replace_wrap">
            <a href="/train/study.html?id={{$v->id}}">
                <div class="replace border-radius-img relative pt30">
                    <img class="max-img-banner" src="{{env('IMG_URL')}}{{$v->list_url}}" alt="">
                    <!--<span class="bgcolor_orange text_center fz color_333 f22 d-in-black">S1?????????</span>-->
                </div>
                <h3 class="f30 color_333 fz bold mt20">{{$v->title}}</h3>
                <div class="weui-cells fz color_gray666 noafter nobefore mt0 padding0">
                    <div class="weui-cell padding0 mb30">
                        <div class="weui-cell__bd">
                            <?php
                            if($v->course_class_ids){
                            $arr = explode(",",$v->course_class_ids);
                            $count_arr = count($arr);
                            }else{
                            $count_arr = 0;
                            }
                            $num_data = DB::table("order_course_class_group")->where("course_class_group_id",$v->id)->where("state",1)->count();
                            ?>
                            <p class="f24 color_gray666">{{$count_arr}} ????????{{$num_data}} ??????????????????</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <!--?????????????????????????????? end-->
    <!-- ???????????? start -->
    @if($selected)
        <div class="mt20">
            <div class="weui-cells mt0 pt10 pb10 nobefore noafter everyday_wrap">
                <div class="weui-cell">
                    <div class="weui-cell__bd text-overflow">
                        <h2 class="lt text-overflow f32 color_333"><b class="bgcolor_orange everyday d-in-black border-radius50"></b>????????????</h2>
                        <p class="color_gray666 fz f20 color_gray666" style="padding-left: .65rem">????????????10:00???????????????</p>
                    </div>
                    <div class="weui-cell__ft f36 color_333 bold">
                        <a href="javascript:;" class="font-Oswald-Medium">{{str_replace('-', '.',$selected['today'])}}
                            <span class="d-in-black f22">???</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="plr30 bgcolor_fff">
            <!-- ?????? -->
            @foreach(get_articla_selected($selected['article_ids']) as $article)
                @if($article->is_video)
                    <a href="/article/detail/{{$article->id}}.html">
                        <div class="max-img border-radius-img mb20 relative height9">
                            <div class="new_mask"></div>
                            <img class="max-img-banner" src="{{env('IMG_URL')}}{{$article->cover_url}}" alt="{{$article->title}}">
                            <img class="icon-bofang" src="/images/bofang.png" alt="">
                        </div>
                        <h3 class="f30 color_333 lt">{{$article->title}}</h3>
                        <div class="weui-cells noafter nobefore mt0 pb30">
                            <div class="weui-cell padding0 mt10">
                                <div class="weui-cell__hd oline_free">
                                    @if(getUsers($article->user_id))
                                        @if(strpos(getUsers($article->user_id)->avatar,'http') !== false)
                                            <img src="{{getUsers($article->user_id)->avatar}}" class="border-radius50" />
                                        @else
                                            <img src="{{env('IMG_URL')}}{{getUsers($article->user_id)->avatar}}" alt="??????" class="border-radius50" />
                                        @endif
                                    @else
                                        <img src="/images/my/nophoto.jpg" alt="??????" class="border-radius50" />
                                    @endif
                                </div>
                                <div class="weui-cell__bd fz f20 color_gray666">
                                    <span class="f26 d-in-black mr20">{{getUsers($article->user_id)?getUsers($article->user_id)->name:''}}</span>
                                    <span class="f22 d-in-black mr20">{{substr($article->created_at,0, 10)}}</span>
                                </div>
                                <div class="weui-cell__ft yudu-img fz f20 color_gray9b">
                                    <span class="d-in-black pl20"><img src="/images/icon-xiao-xihuan.png" alt="">{{$article->likes}}</span>
                                    <span class="pl20"><img src="/images/icon-xiao-yuedu.png" alt="">{{$article->views}}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @else
                    <a href="/article/detail/{{$article->id}}.html">
                        <div class="max-img border-radius-img mb20 relative height9">
                            <img class="max-img-banner" src="{{env('IMG_URL')}}{{$article->cover_url}}" alt="{{$article->title}}">
                            <!-- <img class="icon-bofang" src="/images/bofang.png" alt=""> -->
                        </div>
                        <h3 class="f30 color_333 lt">{{$article->title}}</h3>
                        <div class="weui-cells noafter nobefore mt0 pb30">
                            <div class="weui-cell padding0 mt10">
                                <div class="weui-cell__hd oline_free">
                                    @if(getUsers($article->user_id))
                                        @if(strpos(getUsers($article->user_id)->avatar,'http') !== false)
                                            <img src="{{getUsers($article->user_id)->avatar}}" class="border-radius50" />
                                        @else
                                            <img src="{{env('IMG_URL')}}{{getUsers($article->user_id)->avatar}}" alt="??????" class="border-radius50" />
                                        @endif
                                    @else
                                        <img src="/images/my/nophoto.jpg" alt="??????" class="border-radius50" />
                                    @endif
                                </div>
                                <div class="weui-cell__bd fz f20 color_gray666">
                                    <?php
                                    $name = getUsers($article->user_id);
                                    ?>
                                    <span class="f26 d-in-black mr20">@if($name){{getUsers($article->user_id)->name}}@else  @endif</span>
                                    <span class="f22 d-in-black mr20">{{substr($article->created_at,0, 10)}}</span>
                                </div>
                                <div class="weui-cell__ft yudu-img fz f20 color_gray9b">
                                    <span class="d-in-black pl20"><img src="/images/icon-xiao-xihuan.png" alt="">{{$article->likes}}</span>
                                    <span class="pl20"><img src="/images/icon-xiao-yuedu.png" alt="">{{$article->views}}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endif
            @endforeach

            <hr class="mlr20">
            <!-- <div class="text_center ptb40">
                <a href="/article/0.html" class="fz f26 color_gray9b d-in-black">??????????????????</a>
            </div> -->
            <div class="text_center ptb40">
                <a href="/article/0.html" class="fz f30 color_333">??????????????????<img src="/images/right-jian.png" class="d-in-black" style="width:.8rem;vertical-align: text-top;margin-left:.3rem;"  alt=""></ a>
            </div>
        </div>
    @endif
    <!-- ???????????? end -->

<!-- ??????????????? start-->
<div class="weui-cells nobefore noafter mt0 lt xuyuan-title color_#333 ptb30" style="display: none;">
    <div class="weui-cell padding0">
        <div class="weui-cell__bd text_center">
            <p class="f32">???????????????</p>
        </div>
    </div>
</div>

<div class="mt20 mlr20 border-radius-img" style="display: none;">
    <div class="weui-cells xy-kecheng-zhi mt0 pt10 pb10 nobefore noafter xuyuan-title">
        <div class="weui-cell">
            <div class="weui-cell__bd text-overflow">
                <h2 class="text-overflow color_gray9b f26 fz">11???9???&nbsp;&nbsp;&nbsp;&nbsp;20:00??????</h2>
            </div>
           <div class="weui-cell__ft"><div class="f24 color_333 lt"><img src="/images/zhibozhong.gif" alt="">?????????</div></div>
        </div>
        <hr class="mlr20">
    </div>
    <div class="weui-cells nobefore mt0 daoshi-tit ds_tit pt10 pb10">
        <a class="weui-cell weui-cell_access" href="javascript:;">
            <div class="weui-cell__hd"><img class="border-radius50" src="/images/daoshi-t-img.jpg"></div>
            <div class="weui-cell__bd text-overflow">
                <h2 class="lt text-overflow mb10">???????????????????????????????????????????????????????????????</h2>
                <p class="fz color_gray666">Jane King ??????</p>
            </div>
        </a>
    </div>
</div>

<!-- ????????? -->
<div class="mt20 mlr20 border-radius-img" style="display: none;">
    <div class="weui-cells xy-kecheng-zhi mt0 pt10 pb10 nobefore noafter xuyuan-title">
        <div class="weui-cell">
            <div class="weui-cell__bd text-overflow">
                <h2 class="text-overflow color_gray9b f26 fz">11???9???&nbsp;&nbsp;&nbsp;&nbsp;20:00??????</h2>
            </div>
           <div class="weui-cell__ft"><div class="f24 color_gray999 lt"><img src="/images/daizhibo.png" alt="">?????????</div></div>
        </div>
        <hr class="mlr20">
    </div>
    <div class="weui-cells nobefore mt0 daoshi-tit ds_tit pt10 pb10">
        <a class="weui-cell weui-cell_access" href="javascript:;">
            <div class="weui-cell__hd"><img class="border-radius50" src="/images/daoshi-t-img.jpg"></div>
            <div class="weui-cell__bd text-overflow">
                <h2 class="lt text-overflow mb10">???????????????????????????????????????????????????????????????</h2>
                <p class="fz color_gray666">Jane King ??????</p>
            </div>
        </a>
    </div>
</div>
<!-- ??????????????? end-->


<!-- ???????????? start -->
@if($special)

        <div class="plr30 bgcolor_fff mt32 pt40">
            <div class="weui-cells nobefore noafter mt0 w-jian">
                <a class="weui-cell weui-cell_access padding0 nobefore" href="/special/list.html">
                    <div class="weui-cell__bd color_333 f34 fz bold">
                        <p><span class="color_orange">???</span>????????????</p >
                    </div>
                    <div class="weui-cell__ft color_gray999 f26">
                        ????????????
                    </div>
                </a>
            </div>
        </div>
        <!---///////////////////////////////////////////////////--->
        <div class="plr30 pt30 pb10 bgcolor_fff">
            <!--banner start-->
            <!--Swiper start-->
            <div class=" swiper-container-zhuan swiper-container-why">
                <div class="swiper-wrapper">
                 @foreach($special as $v)
                    <div class="swiper-slide">

                        <?php
                        $article = DB::table('article')->where("special_id","like",'%'.$v->id."%")->count();
                        $people = DB::table('special_follow')->where("special_id","like",'%'.$v->id."%")->count();
                        ?>
                        <a href="/special/index/{{$v->id}}.html">

                            <div class="relative pb22">
                                <img class="pos-img-img border-radius-img" src="{{env('IMG_URL')}}{{$v->img_url}}" alt="">
                                <div class="bg-000 border-radius-img">
                                    <div class="text_center pos-img color_fff">
                                        <p class="f34 pb13"><i class="color_orange">#</i>{{$v->title}}<i class="color_orange">#</i></p >
                                        <p class="f26 fz "><span>???{{$article}} ???</span><span>{{$people + $v->likes}}????????????</span></p >
                                        <p>{{$v->special_tag}}</p>
                                    </div>
                                </div>
                                <div class="bor-radius-top hei-bottom bgcolor_fff"></div>
                            </div>

                        </a>
                    </div>
                 @endforeach
                </div>
            </div>
            <!--Swiper end-->
            <!--banner end-->
        </div>
        <!---///////////////////////////////////////////////////--->


@endif


<!-- ???????????? start -->
<!--??????-->

<div class="plr30 bgcolor_fff mt32 pt40">
    <div class="weui-cells nobefore noafter mt0 w-jian">
        <a class="weui-cell nobefore noafter weui-cell_access padding0" href="/course/free">
            <div class="weui-cell__bd color_333 f34 fz bold">
                <p><span class="color_orange">???</span>????????????</p >
            </div>
            <div class="weui-cell__ft color_gray999 f26">
                ????????????
            </div>
        </a>
    </div>
</div>

<div class="list bgcolor_fff plr30">
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
<!-- ???????????? end -->
@if($activity->count())
<!-- ???????????? -->
<div class="">
    <div class="plr30 bgcolor_fff mt32 pt40">
        <div class="weui-cells nobefore noafter mt0 w-jian">
            <a class="weui-cell weui-cell_access padding0" href="/course/activity">
                <div class="weui-cell__bd color_333 f34 fz bold">
                    <p><span class="color_orange">???</span>????????????</p >
                </div>
                <div class="weui-cell__ft color_gray999 f26">
                    ????????????
                </div>
            </a>
        </div>
    </div>

    <div class="bgcolor_fff plr30 replace_wrap">
        <a href="{{$activity[0]->link}}">
            <div class="replace border-radius-img relative pt30">
                <img class="max-img-banner border-radius-img" src="{{env('IMG_URL')}}{{$activity[0]->cover_url}}" alt="{{$activity[0]->title}}">
            </div>
        </a>
        <h3 class="f30 color_333 fz bold mt20 letter04 pb30">{{$activity[0]->title}}</h3>
    </div>
</div>
@endif


@if(count($one)>0)
<!-- ????????????????????? start -->
<div class="">

   <div class="plr30 bgcolor_fff mt32 pt40">
        <div class="weui-cells nobefore noafter mt0 w-jian">
            <a class="weui-cell weui-cell_access padding0" href="javascript:;">
                <div class="weui-cell__bd color_333 f34 fz bold">
                    <p><span class="color_orange">???</span>????????????</p>
                    <!-- <p><span class="color_orange">???</span>?????????????????????</p > -->
                </div>
                <!-- <div class="weui-cell__ft color_gray999 f26">
                    ????????????
                </div> -->
            </a>
        </div>
    </div>
   @foreach($one as $v)
    <div class="bgcolor_fff plr30 replace_wrap">
        <a href="/train/study.html?id={{$v->id}}">
            <div class="replace border-radius-img relative pt30">
                <img class="max-img-banner border-radius-img" src="{{env('IMG_URL')}}{{$v->list_url}}" alt="{{$v->title}}">
                {{--<span class="bgcolor_orange text_center fz color_333 f22 d-in-black">{{$v->level}}</span>--}}
            </div>
        </a>
        <h3 class="f30 color_333 lt mt20 letter04">{{$v->title}}</h3>
        <div class="weui-cells fz color_gray666 noafter nobefore mt0 padding0">
            <div class="weui-cell padding0 mb30">
                <div class="weui-cell__bd">
                    <p class="f24 color_gray666">
                        <?php
                            if($v->course_class_ids){
                                $arr = explode(",",$v->course_class_ids);
                                $count_arr = count($arr);
                            }else{
                                $count_arr = 0;
                            }
                            $num_data = DB::table("order_course_class_group")->where("course_class_group_id",$v->id)->where("state",1)->count();
                        ?>
                        {{$count_arr}}???????? {{$num_data}}??????????????????</p>
                </div>
                @if($v->price > 0)
                    {{--@if($v->sum_video == 1 || $v->preview == 0)--}}
                        <div class="weui-cell__ft color_orange f28 color_red">?? {{$v->price}}</div>
                    {{--@else--}}
                        {{--<div class="weui-cell__ft color_orange f28 color_red">?????????</div>--}}
                    {{--@endif--}}
                @else
                <div class="weui-cell__ft color_orange bold f28">??????</div>
                @endif
            </div>
        </div>

        <div class="wrap1 fz pb30 clearfix">
            <span class="fl f22 color_4a"><span>{{getUsers($v->user_id)?getUsers($v->user_id)->name:''}}</span></span>
            <div class="swiper-container swiper-container-t tags fr f24 color_gray666">
                <div class="swiper-wrapper">
                    <?php
                    //echo  htmlspecialchars_decode(get_course_class_tag($v->id))
                    ?>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
<!-- ????????????????????? end -->

@if($hots)
<!-- ????????????????????? start -->
<div class="plr30 bgcolor_fff mt32 pt40">
    <div class="weui-cells nobefore noafter mt0 w-jian">
        <a class="weui-cell weui-cell_access padding0" href="/course/courseAll/0.html">
            <div class="weui-cell__bd color_333 f34 fz bold">
                <p><span class="color_orange">???</span>?????????????????????</p >
            </div>
            <div class="weui-cell__ft color_gray999 f26">
                ????????????
            </div>
        </a>
    </div>
</div>
<div class="bgcolor_fff">

    @foreach($hots as $v)

    <div class="plr30 replace_wrap">
        <a href="/course/detail/{{$v->id}}.html">
        <div class="replace border-radius-img relative pt30">
            <img class="max-img-banner border-radius-img" src="{{env('IMG_URL')}}{{$v->explain_url}}" alt="{{$v->title}}">
            <span class="bgcolor_orange text_center fz color_333 f22 d-in-black">{{$v->level}}</span>
        </div>
        </a>
        <h3 class="f30 color_333 lt mt20 letter04">{{$v->title}}</h3>
        <div class="weui-cells fz color_gray666 noafter nobefore mt0 padding0">
            <div class="weui-cell padding0 mb30">
                <div class="weui-cell__bd">
                    <p class="f24 color_gray666">{{$v->sum_video}} ????????{{$v->sum_people}}??????????????????</p>
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

        <div class="wrap1 fz pb30 clearfix">
            <span class="fl f22 color_4a"><span>{{$v->teacher_name}}</span></span>
            <div class="swiper-container swiper-container-t tags fr f24 color_gray666">
                <div class="swiper-wrapper">
                    <?php
                    echo  htmlspecialchars_decode(get_course_class_tag($v->id))
                    ?>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
<!-- ????????????????????? end -->
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
