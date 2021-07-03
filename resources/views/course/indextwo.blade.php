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
        titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
        mainCell:".bd ul",
        effect:"leftLoop",
        autoPage:true,//自动分页
        autoPlay:true //自动播放
    });
</script>


    <!--模块栏重写 start-->
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
    <!--模块栏重写 end-->

{{--<div class="home_module_wrap text_center ptb30 fz bgcolor_fff">--}}
    {{--<div class="plr25 clearfix">--}}
        {{--@foreach($coursetypes as $type)--}}
        {{--<a href="/course/ctypeDetail/{{$type->id}}/0.html" class="color_fff f26 mb20">--}}
            {{--<div class="weui-flex__item">{{$type->title}}</div>--}}
        {{--</a>--}}
        {{--@endforeach--}}
    {{--</div>       --}}
{{--</div>--}}


<!--健身教练入门课程 start-->
    @if($initCourses->count())
    <div class="">
        <div class="plr30 bgcolor_fff mt32 pt40">
            <div class="weui-cells nobefore noafter mt0  w-jian">
                <a class="weui-cell weui-cell_access padding0" href="javascript:;">
                    <div class="weui-cell__bd color_333 f34 fz bold">
                        <p><span class="color_orange">▌</span>健身教练入门课程</p>
                    </div>
                    <!--<div class="weui-cell__ft color_gray999 f26">-->
                    <!--查看全部-->
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
                    <!--<span class="bgcolor_orange text_center fz color_333 f22 d-in-black">S1零基础</span>-->
                </div>
                <h3 class="f30 color_333 fz bold mt20">{{$initCourse->course_alias}}</h3>
                <div class="weui-cells fz color_gray666 noafter nobefore mt0 padding0">
                    <div class="weui-cell padding0 mb30">
                        <div class="weui-cell__bd">
                            <p class="f24 color_gray666">{{$sum_video}} 节课·{{$sum_people}} 人正在提高中</p>
                        </div>
                        <!--<div class="weui-cell__ft color_orange bold">免费</div>-->
                    </div>
                </div>
            </a>
        </div>

        <!-- 我是线线 start-->
        @if($init < $total-1)
        <div class="bgcolor_fff"><div class="bTop mlr30 "></div></div>
        @endif
        <!-- 我是线线 end-->
        @endforeach
        @if($disCourse)
            <?php
                $disCourseNum = count(explode(',',$disCourse->course_ids));
            ?>
            <div class="bgcolor_fff plr30 replace_wrap">
                <a href="/course/detail/{{$disCourse->id}}.html">
                    <div class="replace border-radius-img relative pt30">
                        <img class="max-img-banner" src="/images/fenxiaoliucheng/nx.jpg" alt="">
                        <!--<span class="bgcolor_orange text_center fz color_333 f22 d-in-black">S1零基础</span>-->
                    </div>
                    <h3 class="f30 color_333 fz bold mt20">{{$disCourse->title}}</h3>
                    <div class="weui-cells fz color_gray666 noafter nobefore mt0 padding0">
                        <div class="weui-cell padding0 mb30">
                            <div class="weui-cell__bd">
                                <p class="f24 color_gray666">{{$disCourseNum}} 节课·{{$disNum}} 人正在提高中</p>
                            </div>
                            <!--<div class="weui-cell__ft color_orange bold">免费</div>-->
                        </div>
                    </div>
                </a>
            </div>
        @endif
    </div>
    @endif
    <!--健身教练入门课程 end-->

    <!--健身教练进阶课程推荐 start-->
    <div class="">
        <div class="plr30 bgcolor_fff mt32 pt40">
            <div class="weui-cells nobefore noafter mt0  w-jian">
                <a class="weui-cell weui-cell_access padding0" href="javascript:;">
                    <div class="weui-cell__bd color_333 f34 fz bold">
                        <p><span class="color_orange">▌</span>健身教练进阶课程</p>
                    </div>
                    <!--<div class="weui-cell__ft color_gray999 f26">-->
                    <!--查看全部-->
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
                    <!--<span class="bgcolor_orange text_center fz color_333 f22 d-in-black">S1零基础</span>-->
                </div>
                <h3 class="f30 color_333 fz bold mt20">{{$stageCourse->course_alias}}</h3>
                <div class="weui-cells fz color_gray666 noafter nobefore mt0 padding0">
                    <div class="weui-cell padding0 mb30">
                        <div class="weui-cell__bd">
                            <p class="f24 color_gray666">{{$sum_video}} 节课·{{$sum_people}} 人正在提高中</p>
                        </div>
                        <!--<div class="weui-cell__ft color_orange bold">免费</div>-->
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
                    <!--<span class="bgcolor_orange text_center fz color_333 f22 d-in-black">S1零基础</span>-->
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
                            <p class="f24 color_gray666">{{$count_arr}} 节课·{{$num_data}} 人正在提高中</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <!--健身教练进阶课程推荐 end-->
    <!-- 每日精选 start -->
    @if($selected)
        <div class="mt20">
            <div class="weui-cells mt0 pt10 pb10 nobefore noafter everyday_wrap">
                <div class="weui-cell">
                    <div class="weui-cell__bd text-overflow">
                        <h2 class="lt text-overflow f32 color_333"><b class="bgcolor_orange everyday d-in-black border-radius50"></b>每日精选</h2>
                        <p class="color_gray666 fz f20 color_gray666" style="padding-left: .65rem">每天早上10:00，与您分享</p>
                    </div>
                    <div class="weui-cell__ft f36 color_333 bold">
                        <a href="javascript:;" class="font-Oswald-Medium">{{str_replace('-', '.',$selected['today'])}}
                            <span class="d-in-black f22">期</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="plr30 bgcolor_fff">
            <!-- 视频 -->
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
                                            <img src="{{env('IMG_URL')}}{{getUsers($article->user_id)->avatar}}" alt="头像" class="border-radius50" />
                                        @endif
                                    @else
                                        <img src="/images/my/nophoto.jpg" alt="头像" class="border-radius50" />
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
                                            <img src="{{env('IMG_URL')}}{{getUsers($article->user_id)->avatar}}" alt="头像" class="border-radius50" />
                                        @endif
                                    @else
                                        <img src="/images/my/nophoto.jpg" alt="头像" class="border-radius50" />
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
                <a href="/article/0.html" class="fz f26 color_gray9b d-in-black">查看过去精选</a>
            </div> -->
            <div class="text_center ptb40">
                <a href="/article/0.html" class="fz f30 color_333">查看过去精选<img src="/images/right-jian.png" class="d-in-black" style="width:.8rem;vertical-align: text-top;margin-left:.3rem;"  alt=""></ a>
            </div>
        </div>
    @endif
    <!-- 每日精选 end -->

<!-- 直播公开课 start-->
<div class="weui-cells nobefore noafter mt0 lt xuyuan-title color_#333 ptb30" style="display: none;">
    <div class="weui-cell padding0">
        <div class="weui-cell__bd text_center">
            <p class="f32">直播公开课</p>
        </div>
    </div>
</div>

<div class="mt20 mlr20 border-radius-img" style="display: none;">
    <div class="weui-cells xy-kecheng-zhi mt0 pt10 pb10 nobefore noafter xuyuan-title">
        <div class="weui-cell">
            <div class="weui-cell__bd text-overflow">
                <h2 class="text-overflow color_gray9b f26 fz">11月9日&nbsp;&nbsp;&nbsp;&nbsp;20:00直播</h2>
            </div>
           <div class="weui-cell__ft"><div class="f24 color_333 lt"><img src="/images/zhibozhong.gif" alt="">直播中</div></div>
        </div>
        <hr class="mlr20">
    </div>
    <div class="weui-cells nobefore mt0 daoshi-tit ds_tit pt10 pb10">
        <a class="weui-cell weui-cell_access" href="javascript:;">
            <div class="weui-cell__hd"><img class="border-radius50" src="/images/daoshi-t-img.jpg"></div>
            <div class="weui-cell__bd text-overflow">
                <h2 class="lt text-overflow mb10">田坤跟你谈孕产田坤跟你谈孕产田坤跟你谈孕产</h2>
                <p class="fz color_gray666">Jane King 导师</p>
            </div>
        </a>
    </div>
</div>

<!-- 待直播 -->
<div class="mt20 mlr20 border-radius-img" style="display: none;">
    <div class="weui-cells xy-kecheng-zhi mt0 pt10 pb10 nobefore noafter xuyuan-title">
        <div class="weui-cell">
            <div class="weui-cell__bd text-overflow">
                <h2 class="text-overflow color_gray9b f26 fz">11月9日&nbsp;&nbsp;&nbsp;&nbsp;20:00直播</h2>
            </div>
           <div class="weui-cell__ft"><div class="f24 color_gray999 lt"><img src="/images/daizhibo.png" alt="">待播中</div></div>
        </div>
        <hr class="mlr20">
    </div>
    <div class="weui-cells nobefore mt0 daoshi-tit ds_tit pt10 pb10">
        <a class="weui-cell weui-cell_access" href="javascript:;">
            <div class="weui-cell__hd"><img class="border-radius50" src="/images/daoshi-t-img.jpg"></div>
            <div class="weui-cell__bd text-overflow">
                <h2 class="lt text-overflow mb10">田坤跟你谈孕产田坤跟你谈孕产田坤跟你谈孕产</h2>
                <p class="fz color_gray666">Jane King 导师</p>
            </div>
        </a>
    </div>
</div>
<!-- 直播公开课 end-->


<!-- 专题推荐 start -->
@if($special)

        <div class="plr30 bgcolor_fff mt32 pt40">
            <div class="weui-cells nobefore noafter mt0 w-jian">
                <a class="weui-cell weui-cell_access padding0 nobefore" href="/special/list.html">
                    <div class="weui-cell__bd color_333 f34 fz bold">
                        <p><span class="color_orange">▌</span>专题推荐</p >
                    </div>
                    <div class="weui-cell__ft color_gray999 f26">
                        查看全部
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
                                        <p class="f26 fz "><span>共{{$article}} 讲</span><span>{{$people + $v->likes}}人已关注</span></p >
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


<!-- 免费课程 start -->
<!--标题-->

<div class="plr30 bgcolor_fff mt32 pt40">
    <div class="weui-cells nobefore noafter mt0 w-jian">
        <a class="weui-cell nobefore noafter weui-cell_access padding0" href="/course/free">
            <div class="weui-cell__bd color_333 f34 fz bold">
                <p><span class="color_orange">▌</span>免费课程</p >
            </div>
            <div class="weui-cell__ft color_gray999 f26">
                查看全部
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
                            <p class="fz color_gray666">{{$v->sum_video}} 节课·{{$v->sum_people}}人正在提高中</p>
                            <!-- <p class="fz color_gray999">{{$v->teacher_name}}导师</p> -->
                            <div class="weui-cells fz color_gray666 noafter nobefore mt0 ">
                                <div class="weui-cell">
                                    <div class="weui-cell__bd f22">
                                        <p>{{$v->teacher_name}}</p>
                                    </div>
                                     @if($v->is_free)
                                         @if($v->sum_video == 1 || $v->preview == 0)
                                            <div class="weui-cell__ft color_orange f28 color_red">¥ {{$v->price}}</div>
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
<!-- 免费课程 end -->
@if($activity->count())
<!-- 活动推荐 -->
<div class="">
    <div class="plr30 bgcolor_fff mt32 pt40">
        <div class="weui-cells nobefore noafter mt0 w-jian">
            <a class="weui-cell weui-cell_access padding0" href="/course/activity">
                <div class="weui-cell__bd color_333 f34 fz bold">
                    <p><span class="color_orange">▌</span>活动推荐</p >
                </div>
                <div class="weui-cell__ft color_gray999 f26">
                    查看全部
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
<!-- 最近更新的课程 start -->
<div class="">

   <div class="plr30 bgcolor_fff mt32 pt40">
        <div class="weui-cells nobefore noafter mt0 w-jian">
            <a class="weui-cell weui-cell_access padding0" href="javascript:;">
                <div class="weui-cell__bd color_333 f34 fz bold">
                    <p><span class="color_orange">▌</span>重磅推荐</p>
                    <!-- <p><span class="color_orange">▌</span>最近更新的课程</p > -->
                </div>
                <!-- <div class="weui-cell__ft color_gray999 f26">
                    查看全部
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
                        {{$count_arr}}节课· {{$num_data}}人正在提高中</p>
                </div>
                @if($v->price > 0)
                    {{--@if($v->sum_video == 1 || $v->preview == 0)--}}
                        <div class="weui-cell__ft color_orange f28 color_red">¥ {{$v->price}}</div>
                    {{--@else--}}
                        {{--<div class="weui-cell__ft color_orange f28 color_red">可试看</div>--}}
                    {{--@endif--}}
                @else
                <div class="weui-cell__ft color_orange bold f28">免费</div>
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
<!-- 最近更新的课程 end -->

@if($hots)
<!-- 为你推荐的课程 start -->
<div class="plr30 bgcolor_fff mt32 pt40">
    <div class="weui-cells nobefore noafter mt0 w-jian">
        <a class="weui-cell weui-cell_access padding0" href="/course/courseAll/0.html">
            <div class="weui-cell__bd color_333 f34 fz bold">
                <p><span class="color_orange">▌</span>为你推荐的课程</p >
            </div>
            <div class="weui-cell__ft color_gray999 f26">
                查看全部
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
                    <p class="f24 color_gray666">{{$v->sum_video}} 节课·{{$v->sum_people}}人正在提高中</p>
                </div>
                @if($v->is_free)
                     @if($v->sum_video == 1 || $v->preview == 0)
                        <div class="weui-cell__ft color_orange f28 color_red">¥ {{$v->price}}</div>
                     @else
                        <div class="weui-cell__ft color_orange f28 color_red">可试看</div>
                     @endif
                @else
                <div class="weui-cell__ft color_orange bold f28">免费</div>
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
<!-- 为你推荐的课程 end -->
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

    //每日问答
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
        //注册领取弹窗

        //狠心放弃
        $(document.body).delegate(".btn_fangqi", 'click', function () {
            localStorage.setItem(isDiscard,1);
            layer.closeAll(); //关闭弹出框
        })
        $(document.body).delegate(".layui-layer-close", 'click', function () {
            localStorage.setItem(isDiscard,1);
            layer.closeAll(); //关闭弹出框
        })
    });
</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">

    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: "{{$WechatShare['appId']}}", // 必填，公众号的唯一标识
        timestamp: "{{$WechatShare['timestamp']}}", // 必填，生成签名的时间戳
        nonceStr: "{{$WechatShare['noncestr']}}", // 必填，生成签名的随机串
        signature: "{{$WechatShare['signature']}}",// 必填，签名
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
        ] // 必填，需要使用的JS接口列表
    });


    var link = "http://m.saipubbs.com?fission_id={{$user_id}}";
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: '{{$website->title}}', // 分享标题
            desc: '{{$website->description}}', // 分享描述
            link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/tubiao/1.png", // 分享图标
        }, function(res) {
        //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '{{$website->title}}', // 分享标题
            link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/tubiao/1.png", // 分享图标
        }, function(res) {
        //这里是回调函数
        });
    });
    //将裂变者id写入本地  用于存储上下级关系
    var fission_id = "{{$fission_id}}";
    if(fission_id>0){
        localStorage.setItem("fission_id", fission_id);
    }

    //将注册来源页面写入存储
    localStorage.setItem("channel", "index");
    console.log(localStorage.getItem('fission_id')+"是否是裂变者");
    console.log("index"+"channel");
    //统计代码设置用户id
    gio('setUserId', "{{$user_id}}");
</script>

<script>
        /*滑动*/
    var swiper = new Swiper('.swiper-container-t', {
        slidesPerView: 'auto',
        spaceBetween: 10,
        slidesPerView:3,////可见个数
    });

    var loading = false;
    $(document.body).infinite().on("infinite", function() {
        if(loading) return;
        loading = true;
        setTimeout(function() {
            $("#list").append("" +
                    "<li class='ptb30'>" +
                    "<dl class='clearfix'>" +
                    "<dt class='border-radius-img'><img src='../images/listimg.jpg' alt=''/><span class='bgcolor_orange text_center fz color_333'>训练学院</span></dt>" +
                    "<dd>" +
                    "<h3 class='lt f30'>12天打造科学有效的跑步方案！</h3>" +
                    "<p class='fz color_gray666 f24'>12 节课·89 人正在提高中</p>" +
                    "<div class='weui-cells fz color_gray666 noafter nobefore mt0 '>" +
                    "<div class='weui-cell'>" +
                    "<div class='weui-cell__bd'>" +
                    "<p class='f22'>Jane King 导师</p>" +
                    "</div>" +
                    "<div class='weui-cell__ft color_red bold f28'>￥99</div>" +
                    "</div>" +
                    "</div>" +
                    "<div class='text_center fz'>" +
                    "<div class='swiper-container'>" +
                    "<div class='swiper-wrapper'>" +
                    "<div class='swiper-slide'><a class='color_gray666' href='javascript:void (0)'>体能体能</a></div>" +
                    "<div class='swiper-slide'><a class='color_gray666' href='javascript:void (0)'>体能体能</a></div>" +
                    "<div class='swiper-slide'><a class='color_gray666' href='javascript:void (0)'>体能体能</a></div>" +
                    "<div class='swiper-slide'><a class='color_gray666' href='javascript:void (0)'>体能体能</a></div>" +
                    "<div class='swiper-slide'><a class='color_gray666' href='javascript:void (0)'>体能</a></div>" +
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
