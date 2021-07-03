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
            titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
            mainCell:".bd ul",
            effect:"leftLoop",
            autoPage:true,//自动分页
            autoPlay:true //自动播放
        });
    </script>

    <!-- 选择适合自己的教练成长训练营 start -->
    <div class="home_xuanze_box bgcolor_fff">
        <div class="pt30 plr30 pb30">
            <!-- 按钮 start -->
            <a href="/train/list.html" class="block xz_a border-radius50 fz f26 text_center mb20">+ 选择适合自己的教练成长训练营</a>
            <!-- 按钮 end -->
            <!-- 正在参加---某某训练营 start-->
            @if($disCourseClass)
            <div class="home_now_canjia_box pt30">
                <a href="/dist/finish/{{$disCourseClass->id}}/{{$disPlayRecord->dis_course_id}}.html">
                <h3 class="fz f34 color_333 bold pb10">正在参加——{{$disCourseClass->title}}</h3>
                <p class="fz f28 color_gray999">第{{$nowTask}}天任务</p></a>
                <div class="h_page text_right mb26">
                    @if($prePlayRecord)
                    <a href="/dist/finish/{{$disCourseClass->id}}/{{$prePlayRecord->dis_course_id}}.html" class="d-in-black color_333 f28 text_center bgcolor_orange fz bold">前一天</a>
                    @endif
                    @if($nextPlayRecord)
                    <a href="/dist/finish/{{$disCourseClass->id}}/{{$nextPlayRecord->dis_course_id}}.html" class="d-in-black color_333 f28 text_center bgcolor_orange fz bold">后一天</a>
                    @endif
                </div>
            </div>
            @endif
            <!-- 正在参加---某某训练营 end-->
        </div>
        <!-- 列表 start -->
        {{--<div class="home_list_box bTop">--}}
            {{--<div class="list-art plr30">--}}
                {{--<ul>--}}
                    {{--<li class="pt30 pb30">--}}
                        {{--<a href="">--}}
                            {{--<dl class="clearfix relative">--}}
                                {{--<dt class="border-radius-img"><img src="../images/Active-page-img/mucong.png" alt="" /></dt>--}}
                                {{--<dd>--}}
                                    {{--<h3 class="fz bold f30 color_333 text-overflow2">世界形体小姐的极塑美臀课</h3>--}}
                                    {{--<div class="weui-cells nobefore noafter padding0 mt0">--}}
                                        {{--<div class="weui-cell nobefore noafter padding0 mt20">--}}
                                            {{--<div class="weui-cell__hd "><img src="../images/xy.png" class="width40 border-radius50"></div>--}}
                                            {{--<div class="weui-cell__bd f28 fz color_gray666">--}}
                                                {{--<p>浪客剑心</p>--}}
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
        <!-- 列表 end -->

    </div>
    <!-- 选择适合自己的教练成长训练营 end -->
    <!--模块栏 start-->
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
                        {{--<p class="">教练训练营</p>--}}
                    {{--</a>--}}
                {{--</div>--}}
                {{--<div class="swiper-slide">--}}
                    {{--<a href="javascript:void (0)" class="fz f22 block listHomeTag text_center">--}}
                        {{--<img src="/images/homeIcon/wenzhuanjia.png" alt="">--}}
                        {{--<p class="">问专家</p>--}}
                    {{--</a>--}}
                {{--</div>--}}
                {{--<div class="swiper-slide">--}}
                    {{--<a href="javascript:void (0)" class="fz f22 block listHomeTag text_center">--}}
                        {{--<img src="/images/homeIcon/huiyuanwuqu.png" alt="">--}}
                        {{--<p class="">会员误区</p>--}}
                    {{--</a>--}}
                {{--</div>--}}
                {{--<div class="swiper-slide">--}}
                    {{--<a href="javascript:void (0)" class="fz f22 block listHomeTag text_center">--}}
                        {{--<img src="/images/homeIcon/remenzhuanti.png" alt="">--}}
                        {{--<p class="">热门专题</p>--}}
                    {{--</a>--}}
                {{--</div>--}}
                {{--<div class="swiper-slide">--}}
                    {{--<a href="javascript:void (0)" class="fz f22 block listHomeTag text_center">--}}
                        {{--<img src="/images/homeIcon/jiaolianqingdan.png" alt="">--}}
                        {{--<p class="">教练清单</p>--}}
                    {{--</a>--}}
                {{--</div>--}}
                {{--<div class="swiper-slide">--}}
                    {{--<a href="javascript:void (0)" class="fz f22 block listHomeTag text_center">--}}
                        {{--<img src="/images/homeIcon/yingyangtupu.png" alt="">--}}
                        {{--<p class="">营养图谱</p>--}}
                    {{--</a>--}}
                {{--</div>--}}
            </div>
        </div>
        <!--Swiper end-->
    </div>
    <!--模块栏 end-->

    <!-- 今日知识 start -->
    @if($selected)
        <div class="bgcolor_fff">
        <!--公共标题1 start-->
        <div class="mt20 ptb40 plr30">
            <div class="weui-cells mt0 padding0 nobefore noafter">
                <div class="weui-cell nobefore noafter padding0">
                    <div class="weui-cell__bd text-overflow">
                        <h2 class="fz bold text-overflow f32 color_333"><b class="color_orange f40 mr10">•</b>今日知识</h2>
                    </div>
                    <?php
                        $week = [0=>'星期日',1=>'星期一',2=>'星期二',3=>'星期三',4=>'星期四',5=>'星期五',6=>'星期六'];
                        $time = $week[date('w')];
                    ?>
                    <div class="weui-cell__ft f36 color_333 bold font-Oswald-Medium"><a href="">{{str_replace('-', '.',$selected['today'])}} <span class="d-in-black f22">{{$time}}</span></a></div>
                </div>
            </div>
        </div>
        <!--公共标题1 end-->
        <!-- 视频 start-->
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

                                        <img src="{{$photo}}" alt="头像" class="border-radius50 width40" />
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
        <!-- 视频 end-->

        <!--查看过去精选 start-->
        <div class="text_center ptb40 chakanBtn bTop">
            <a href="/article/0.html" class="fz f30 color_333 d-in-black">查看过去精选<img src="../images/right-jian.png" class="d-in-black" alt=""></a>
        </div>
        <!--查看过去精选 end-->
    </div>
    @endif
    <!-- 今日知识 end -->
    <!-- 免费线上训练营 start -->
    @foreach($modelSettings as $setting)
        <?php
            $projects = $setting->projects($setting->id);
        ?>
    <div class="bgcolor_fff">
        <!-- 公共标题1 start-->
        <div class="mt20 ptb40 plr30">
            <div class="weui-cells mt0 padding0 nobefore noafter">
                <div class="weui-cell nobefore noafter padding0">
                    <div class="weui-cell__bd">
                        <h2 class="fz bold text-overflow f32 color_333"><b class="color_orange f40 mr10">•</b>{{$setting->name}}</h2>
                        <p class="color_gray666 fz f24 color_gray999 ml20">{{$setting->desc}}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- 公共标题1 end-->
        <!-- 列表 start -->
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
        <!-- 列表 end -->
    </div>
    <!-- 免费线上训练营 end -->
    @endforeach
    {{--<!-- 精英私教系列课 start -->--}}
    {{--<div class="bgcolor_fff">--}}
        {{--<!-- 公共标题1 start-->--}}
        {{--<div class="mt20 ptb40 plr30">--}}
            {{--<div class="weui-cells mt0 padding0 nobefore noafter">--}}
                {{--<div class="weui-cell nobefore noafter padding0">--}}
                    {{--<div class="weui-cell__bd">--}}
                        {{--<h2 class="fz bold text-overflow f32 color_333"><b class="color_orange f40 mr10">•</b>精英私教系列课</h2>--}}
                        {{--<p class="color_gray666 fz f24 color_gray999 ml20">系统提升教练专项能力、助力业绩提升</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<!-- 公共标题1 end-->--}}
        {{--<!-- 列表 start -->--}}
        {{--<div class="home_listMFXS_box bTop text_center pt30 pb30 plr30">--}}
            {{--<ul>--}}
                {{--<li>--}}
                    {{--<img src="../images/homeIcon/homeImg1.jpg" alt="" class="img100">--}}
                    {{--<p class="bgcolor_orange fz f26 color_333">低价拼团</p>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</div>--}}
        {{--<!-- 列表 end -->--}}
    {{--</div>--}}
    {{--<!-- 精英私教系列课 end -->--}}


    <!-- 免费单课 start -->
    <div class="bgcolor_fff">
        <!-- 公共标题1 start-->
        <div class="mt20 ptb40 plr30 fz">
            <div class="weui-cells mt0 padding0 nobefore noafter w-jian">
                <div class="weui-cell weui-cell_access nobefore noafter padding0 ">
                    <div class="weui-cell__bd">
                        <h2 class="fz bold text-overflow f32 color_333"><b class="color_orange f40 mr10">•</b>免费单课</h2>
                        <p class="color_gray666 fz f24 color_gray999 ml20">免费体验专项能力提升</p>
                    </div>
                    <div class="weui-cell__ft"><a href="/course/free" class="fz f26 color_gray999">更多免费</a></div>
                </div>
            </div>
        </div>
        <!-- 公共标题1 end-->
        <!-- 列表 start -->
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
        <!-- 列表 end -->
        <div class="foot mt15 text_center">
            <p class="t_b">
                赛普健身    saipubbs.com版权所有<br>
                北京赛普力量教育科技有限公司<br>
                <!-- 京ICP备16035765号-2<br> -->
                <a href="https://beian.miit.gov.cn">京ICP备16035765号-2</a><br>
            </p>
        </div>
    </div>
    <!-- 免费单课 end -->
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
