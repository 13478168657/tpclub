@extends('layouts.header')
@section('title')
    <title>全部免费课程{{env('WEB_TITLE')}}</title>
    <meta name="description" content="" />
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/xueyuan.css">
    <style>
        #page {padding-bottom:3rem;}
    </style>
@endsection
@section('content') 
<!-- 免费课程 start -->
<!--标题-->
<div class="">
    <div class="weui-cells nobefore noafter mt0 lt xuyuan-title">
       <!--  <div class="weui-cell">
            <div class="weui-cell__bd text_left color_333">
                <p>免费课程</p>
            </div>
        </div> -->
        <hr class="mlr20">
    </div>
</div>

<div class="list bgcolor_fff plr30">
    <ul id="course_free_list">
        @if($courselist)
        @foreach($courselist as $v)
        <a href="/course/detail/{{$v->id}}.html">
            <li class="ptb40">
                <dl class="clearfix">
                    <dt class="border-radius-img">
                        <img src="{{env('IMG_URL')}}{{$v->cover_url}}" alt="{{$v->title}}" />
                        <span class="bgcolor_orange text_center fz color_333 f22 padding0">{{$v->level}}</span>
                    </dt>
                    <dd>
                        <h3 class="lt f30 text-overflow">{{$v->title}}</h3>
                        <p class="fz color_gray666 f24">{{$v->sum_video}} 节课·{{$v->sum_people}}人正在提高中</p>
                        <div class="weui-cells fz color_gray666 noafter nobefore mt0 ">
                            <div class="weui-cell">
                                <div class="weui-cell__bd">
                                    <p class="color_4a f22">{{$v->teacher_name}}</p>
                                </div>
                                <div class="weui-cell__ft color_orange bold f28">免费</div>
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
    <!--加载更多-->
        <div class="weui-loadmore more text_center fz ptb30">
            <!-- <i class="weui-loading"></i> -->
            <!-- <span class="weui-loadmore__tips">正在加载</span> -->
            <span class="weui-loadmore__tips" id ="free_more"  data-is_ture='1'>加载更多</span>
        </div>
</div>
<!-- 免费课程 end -->
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
    var i = 2;
    $("#free_more").click(function(){
        var number = $("#free_more").attr("data-is_ture");
        if(number == 1){
            $.ajax({
                type:"get",
                url:"/course/free",
                data:{page:i},
                dataType:"json",
                success:function(data){
                    console.log(data);
                        if(!jQuery.isEmptyObject(data)){
                        $.each(data,function(index,json){
                            var str ="";
                            var str =str + "<a href='/course/detail/"+json['id']+".html'>";
                            var str =str + "<li class='ptb40'>" ;
                            var str =str + "<dl class='clearfix'>";
                            var str =str +"<dt class='border-radius-img'><img src='{{env('IMG_URL')}}"+json['cover_url']+"' alt=''/><span class='bgcolor_orange text_center fz color_333'>"+json['level']+"</span></dt>";
                            var str =str +"<dd>";
                            var str =str +"<h3 class='lt text-overflow'>"+json['title']+"</h3>";
                            var str =str +"<p class='fz color_gray666'>"+json['sum_video']+" 节课·"+json['sum_people']+" 人正在提高中</p>";
                           // var str =str +"<p class='fz color_gray999'>"+json['teacher_name']+"</p>";
                            var str =str +'<div class="weui-cells fz color_gray666 noafter nobefore mt0 ">';
                            var str =str +'<div class="weui-cell">';
                            var str =str +'<div class="weui-cell__bd f22">';
                            var str =str +'<p>'+json['teacher_name']+'</p>';
                            var str =str +'</div>';
                            // if(json['is_free']){
                            //     var str =str +'<div class="weui-cell__ft color_orange f28 color_red">可试看</div>';
                            // }else{
                                var str =str +'<div class="weui-cell__ft color_orange bold f28">免费</div>';
                            //}
                            var str =str +'</div>';
                            var str =str +'</div>';
                            var str =str +"<div class='text_center fz'>";
                            var str =str +"<div class='swiper-container'>";
                            var str =str +"<div class='swiper-wrapper'>";
                            for(var i=0;i<json['tagArr'].length;i++){
                                var str =str +"<div class='swiper-slide'><a class='color_gray666' href='/course/tagdetail/"+json['tagArr'][i][0]['id']+".html'>"+json['tagArr'][i][0]['title']+"</a></div>";
                             }
                            var str =str +"</div>";
                            var str =str +"</div>";
                            var str =str +"</div>";
                            var str =str +"</dd>";
                            var str =str +"</dl>";
                            var str =str +"</li>";
                            var str =str +"</a>";
                            $("#course_free_list").append(str);

                        })
                         i++;
                        var swiper = new Swiper('.swiper-container', {
                            slidesPerView: 'auto',
                            leftedSlides: true,
                            spaceBetween: 10,
                            grabCursor: true
                        });
                     }else{
                        $("#free_more").attr("data-is_ture",0);
                        $("#free_more").text("没有更多课程了");
                        layer.msg('没有更多课程啦');
                    }
                }
            });
        }else{
            layer.msg('没有更多课程啦');
        }
    })
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
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: '免费课程—赛普健身社区', // 分享标题
            desc: '冠军导师的系列课，限时免费学习', // 分享描述
            link: "http://m.saipubbs.com/course/free", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/free_course.png", // 分享图标
        }, function(res) {
        //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '免费课程—赛普健身社区', // 分享标题
            link: "http://m.saipubbs.com/course/free", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/free_course.png", // 分享图标
        }, function(res) {
        //这里是回调函数
        });
    });

</script>
@endsection