@extends('layouts.header')
@section('title')
    <title>导师主页{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link href="/lib/swiper/swiper.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/my.css?t=1" rel="stylesheet" type="text/css" />
@endsection
@section('content')

<!-- 用户登录头像信息 start -->
<div class="weui-cells photo_info bgc_white logged">
    <div class="weui-cell">
        <div class="weui-cell__bd">
            <a href="javascript:;" class="user_photo">
                @if(strpos($user->avatar,'http') !== false)
                    <img src="{{$user->avatar}}">
                @else
                    <img src="{{env('IMG_URL')}}{{$user->avatar}}">
                @endif
            </a>
            <ul class="info">
                <li>{{$user->name}}
                    @if($user->sex=='male')
                        <img src="/images/my/ico_nan.png" alt="男" />
                    @elseif($user->sex=='female')
                        <img src="/images/my/ico_nv.png" alt="女" />
                    @endif
                </li>
                <li class="fans">
                    <p class="d-in-black"><b class="color_orange f36 mr5">{{$follows}}</b>关注</p>
                    <p class="d-in-black"><b class="color_orange f36 mr5">{{$fans}}</b>粉丝</p>
                    {{--<span>{{$powders}}互粉</span>--}}
                </li>
            </ul>
        </div>
        @if($userid!=$fansid)
            <div class="weui-cell__ft">
                @if($user->is_follow==1)
                    <a href="javascript:;" class="guanzhuBtn" data-user_id="{{$userid}}" data-fans_id='{{$fansid}}' onclick="click_follow(this)" data-is_follow='1' id="fans{{$user->id}}">已关注</a>
                @else
                    <a href="javascript:;" class="guanzhuBtn" data-user_id="{{$userid}}" data-fans_id='{{$fansid}}' onclick="click_follow(this)" data-is_follow='0' id="fans{{$user->id}}">关注</a>
                @endif
            </div>
        @endif
    </div>
</div>
<!-- 用户登录头像信息 end -->

<!-- 简介 start -->
<div class="bgc_white">
    <div class="clearfix myJjianJie">
        <p class="color_orange fl l">个人简介：</p>
        <div class="jianjieCon fl r">
            <p class="h40">{{$user->introduction ? $user->introduction : '暂无简介'}}</p>
            <!-- 没有简介就隐藏按钮 -->
            @if(mb_strlen($user->introduction,'UTF8')>50)
                <i class="arrowBtn"></i>
            @endif
        </div>
    </div>
    <div class="clearfix plr30 myrz">
        @if($userVerify)
        <p class="fl l color_orange">个人认证：</p>
        <p class="fl r">{{$userVerify->verify_info}}</p>
        @endif
    </div>
</div>
<!-- 简介 end -->

<!-- 编辑按钮 start -->
<!-- div class="weui-cells bgc_white nobefore noafter">
	<div class="weui-cell">
		<a href="/user/edit/" class="weui-btn bgc_yellow grey editBtn"><img src="/images/my/ico_bianji.png" />编辑个人资料</a>
	</div>
</div> -->
<!-- 编辑按钮 end -->
<div class="mt10">
    <div class="tab_class pt40 pb30 text_center mb10 bgcolor_fff plr20">
        <a href="/user/teacher/{{$user->id}}/2.html" class="d-in-black f26 color_gray999 fz">图文</a>
        <a href="/user/teacher/{{$user->id}}/1.html" class="d-in-black color_333 f30 fz bold">课程</a>

        {{--<a href="/user/teacher/{{$user->id}}/3.html" class="d-in-black f26 color_gray999 fz">直播</a>--}}
    </div>
    <!--列表 start-->
    @if($list)
        <div class="list plr30 bgcolor_fff" id="list">
            <ul>
                @foreach($list as $course)
                    <a href="/course/detail/{{$course->id}}.html">
                    <li class="ptb30">
                        <dl class="clearfix">
                            <dt class="border-radius-img"><img src="{{env('IMG_URL')}}{{$course->cover_url}}" alt="" /><span class="bgcolor_orange text_center fz color_333">{{$course->level}}</span></dt>
                            <dd>
                                <h3 class="lt f30 text-overflow">{{$course->title}}</h3>
                                <p class="fz color_gray666 f24">{{$course->sum_course}} 节课·{{$course->sum_study}} 人正在提高中</p>
                                <!--<p class="fz color_gray999">Jane King 导师</p>-->
                                <div class="weui-cells fz color_gray666 noafter mt0 nobefore">
                                    <div class="weui-cell">
                                        <div class="weui-cell__bd">
                                            <p class="f22">{{$course->name}} 导师</p>
                                        </div>
                                        @if($course->is_free)
                                            @if($course->sum_course == 1 || $course->preview == 0)
                                                <div class="weui-cell__ft color_orange bold f28 color_red">￥{{$course->price}}</div>
                                            @else
                                                <div class="weui-cell__ft color_orange bold f28 color_red">可试看</div>
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
                </a>
                @endforeach
            </ul>
        </div>
        <!--列表 end-->

        <!--加载更多-->
        <div class="weui-loadmore more text_center fz ptb30 remove_attr " id="study_more">
            <!-- <i class="weui-loading"></i> -->
            <span class="weui-loadmore__tips seach_more_class" id ="add_more"  data-is_ture='1'>加载更多</span>
        </div>
    @else
        <div class="weui-loadmore more text_center fz ptb30">
            <!-- <i class="weui-loading"></i> -->
            <span class="weui-loadmore__tips">暂无课程信息</span>
        </div>
    @endif
    {{--<div class="bgcolor_fff ptb30">--}}
    {{--<div class="weui-loadmore more text_center fz">--}}
    {{--<i class="weui-loading"></i>--}}
    {{--<span class="weui-loadmore__tips">正在加载</span>--}}
    {{--</div>--}}
    {{--</div>--}}
</div>

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
</script>
<script>
    //跳转登陆函数
    var userlogin = function(){
        var url = "user/teacher/"+{{$userid}};
        layer.msg('请先登录');
        localStorage.setItem("redirect", url);
        setTimeout(function(){
            window.location.href = "/login";
        }, 500)
    }

    $(document).ready(function() {
        //加载更多
        var page = 2;
        var www  = "{{env('IMG_URL')}}";
        var user_id = '{{$user->id}}';
        $('#add_more').click(function(){
            var data = {type:1,page:page,'userId':user_id};
            $.ajax({
                url:'/userCenter/addMore',
                data:data,
                type:'GET',
                dataType:'json',
                success:function(res){
                    if(res.code == 0){
                        page = page + 1;
                        $("#list ul").append(res.body);
                    }else{
                        $('.seach_more_class').text(res.msg);
                    }
                }
            });
        });
    });

    function click_follow(e){
        var fans_id = e.getAttribute("data-fans_id");
        var user_id = e.getAttribute("data-user_id");
        var fansid  = e.getAttribute("id");
        var is_follow = e.getAttribute("data-is_follow");
        var token   = '{{csrf_token()}}';
        // if(is_follow==1){
        // 	layer.msg('您已关注,无需重复操作');
        // 	return;
        // }
        var mobile = "{{$mobile}}";
        if(mobile<1){
            userlogin();  //跳转登陆
            return;
        }
        if(is_follow==0){
            $.ajax({
                type:"POST",
                url:"/user/followadd",
                data:{fans_id:fans_id, user_id:user_id, _token:token},
                dataType:"json",
                success:function(result){
                    if(result.code==1){
                        layer.msg('关注成功');
                        document.getElementById(fansid).setAttribute('data-is_follow', 1);
                        document.getElementById(fansid).innerHTML='已关注';
                    }else{
                        layer.msg(result.msg);
                    }
                }
            });
        }else{
            $.ajax({
                type:"POST",
                url:"/user/followcancel",
                data:{fans_id:fans_id, user_id:user_id, _token:token},
                dataType:"json",
                success:function(result){
                    if(result.code==1){
                        layer.msg('取消关注');
                        document.getElementById(fansid).setAttribute('data-is_follow', 0);
                        document.getElementById(fansid).innerHTML='关注';
                    }else{
                        layer.msg(result.msg);
                    }
                }
            });
        }

    }
</script>
@endsection