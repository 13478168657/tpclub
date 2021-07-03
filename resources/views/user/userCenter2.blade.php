@extends('layouts.header')
@section('title')
    <title>个人主页{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link href="/lib/swiper/swiper.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/my.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<!-- 用户登录头像信息 start -->
<div class="weui-cells photo_info bgc_white logged">
    <div class="weui-cell">
        <div class="weui-cell__bd">
            <a href="baseinfo.html" class="user_photo">
                @if($user->avatar)
                    @if(strpos($user->avatar,'http') !== false)
                        <img src="{{$user->avatar}}" alt="" />
                    @else
                        <img src="{{env('IMG_URL')}}{{$user->avatar}}" alt="" />
                    @endif
                @else
                    <img src="/images/my/nophoto.jpg" alt="" />
                @endif
            </a>
            <ul class="info">
                <li>{{$user->nickname ? $user->nickname : $user->name}} <img src="/images/my/ico_nan.png" alt="" /></li>
                <li class="fans">
                    <span>{{$follows}}关注</span>
                    <span>{{$fans}}粉丝</span>
                    <span>{{$powders}}互粉</span>
                </li>
            </ul>
        </div>

    </div>
</div>
<!-- 用户登录头像信息 end -->

<!-- 简介 start -->
<div class="bgc_white jianjieCon">
    <p class="h40">{{$user->introduction ? $user->introduction : '暂无简介'}}</p>
    <!-- 没有简介就隐藏按钮 -->
    @if(mb_strlen($user->introduction,'UTF8')>50)
        <i class="arrowBtn"></i>
    @endif
</div>
<!-- 简介 end -->

<!-- 编辑按钮 start -->
<div class="weui-cells bgc_white nobefore noafter">
    <div class="weui-cell">
        <a href="/user/edit" class="weui-btn bgc_yellow grey editBtn"><img src="/images/my/ico_bianji.png" />编辑个人资料</a>
    </div>
</div>
<!-- 编辑按钮 end -->

<!-- 课程 start -->
<div class="mt10">
    <div class="tab_class pt40 pb30 text_center mb10 bgcolor_fff plr20">
        <a href="/user/center/1.html" class="d-in-black f26 color_gray999 fz">课程</a>
        <a href="/user/center/2.html" class="d-in-black f26 color_gray999 fz">图文</a>
        <a href="/user/center/3.html" class="d-in-black f30 color_333 fz bold">直播</a>
    </div>
    <!--列表 start-->
    {{--<div class="list-live mlr20" id="list">--}}
        {{--<!-- 直播 -->--}}
        {{--<div class="mt10 border-radius-img bgcolor_fff">--}}
            {{--<div class="weui-cells xy-kecheng-zhi mt0 pt10 pb10 nobefore noafter xuyuan-title">--}}
                {{--<div class="weui-cell">--}}
                    {{--<div class="weui-cell__bd text-overflow">--}}
                        {{--<h2 class="text-overflow color_gray9b f26 fz">11月9日&nbsp;&nbsp;&nbsp;&nbsp;20:00直播</h2>--}}
                    {{--</div>--}}
                    {{--<div class="weui-cell__ft"><div class="f24 color_333 lt"><img src="/images/zhibozhong.gif" alt="">直播中</div></div>--}}
                {{--</div>--}}

                {{--<div class="plr30 my-hr">--}}
                    {{--<i></i>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="weui-cells nobefore noafter mt0 daoshi-tit ds_tit pt10 mb10">--}}
                {{--<a class="weui-cell weui-cell_access" href="javascript:;">--}}
                    {{--<div class="weui-cell__hd"><img class="border-radius50" src="/images/daoshi-t-img.jpg"></div>--}}
                    {{--<div class="weui-cell__bd text-overflow">--}}
                        {{--<h2 class="lt text-overflow mb10">田坤跟你谈孕产田坤跟你谈孕产田坤跟你谈孕产1/h2>--}}
                            {{--<p class="fz color_gray666">Jane King 导师</p>--}}
                    {{--</div>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<!-- 待直播 -->--}}
        {{--<div class="mt10 border-radius-img mb10">--}}
            {{--<div class="weui-cells xy-kecheng-zhi mt0 pt10 pb10 nobefore noafter xuyuan-title">--}}
                {{--<div class="weui-cell">--}}
                    {{--<div class="weui-cell__bd text-overflow">--}}
                        {{--<h2 class="text-overflow color_gray9b f26 fz">11月9日&nbsp;&nbsp;&nbsp;&nbsp;20:00直播</h2>--}}
                    {{--</div>--}}
                    {{--<div class="weui-cell__ft">--}}
                        {{--<div class="f24 color_gray999 lt"><img src="/images/daizhibo.png" alt="">待播中</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="plr30 my-hr">--}}
                    {{--<i></i>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="weui-cells nobefore mt0 daoshi-tit ds_tit pt10 pb10">--}}
                {{--<a class="weui-cell weui-cell_access" href="javascript:;">--}}
                    {{--<div class="weui-cell__hd"><img class="border-radius50" src="/images/daoshi-t-img.jpg"></div>--}}
                    {{--<div class="weui-cell__bd text-overflow">--}}
                        {{--<h2 class="lt text-overflow mb10">田坤跟你谈孕产田坤跟你谈孕产田坤跟你谈孕产</h2>--}}
                        {{--<p class="fz color_gray666">Jane King 导师</p>--}}
                    {{--</div>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    <!--列表 end-->

    <!--加载更多-->
    <div class="weui-loadmore more text_center fz ptb30 remove_attr " id="study_more">
        <!-- <i class="weui-loading"></i> -->
        <span class="weui-loadmore__tips seach_more_class" id ="add_more"  data-is_ture='1'>暂无直播</span>
    </div>
</div>
<!-- 课程 end -->


<script src="/lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
    $(function() {
        FastClick.attach(document.body);
    });
</script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/swiper/swiper.min.js"></script>
<script src="/js/js.js"></script>
<script>
    $('.jianjieCon').click(function (){
        $(this).find('p').toggleClass("h40");
        $(this).find('.arrowBtn').toggleClass("up");
    })
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 'auto',
        leftedSlides: true,
        spaceBetween: 10,
        grabCursor: true
        // freeMode: true
    });
    var page = 2;
    $('#add_more').click(function(){
        var data = {type:3,page:page};
        $.ajax({
            url:'/userCenter/addMore',
            data:data,
            type:'GET',
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    page = page+1;
                    $("#list ul").append(res.body);
                }else{
                    $('.seach_more_class').text(res.msg);
                }
            }
        });
    });
</script>
@endsection
