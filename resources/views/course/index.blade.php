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
    <link rel="stylesheet" href="/css/xueyuan.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="/css/swiper.min.css">
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth/18.75 + "px";
        })()
    </script>
@endsection

@section('content')
<div class="">
    <!--头部-->
    <!-- <header class="mt10 mb10">
        <h1><img src="/images/logo.png" alt=""></h1>
    </header> -->
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
    <script src="../js/TouchSlide.1.1.js"></script>
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

    <!--模块栏-->
    <div class="weui-flex icon_xueyuan_wrap text_center ptb30 fz bgcolor_fff">
        <div class="weui-flex__item"><a href="/course/tag"><div><img src="/images/icon-fenlei.png" alt=""></div><b>分类</b></a></div>
        <div class="weui-flex__item"><a href="/course/type/3.html"><div><img src="/images/icon-dongzuo.png" alt="动作训练"></div><b>动作训练</b></a></div>
        <div class="weui-flex__item"><a href="/course/type/4.html"><div><img src="/images/icon-sijiaoxueyuan.png" alt="私教学院"></div><b>私教学院</b></a></div>
        <!-- <div class="weui-flex__item"><a href="javascript:void (0)"><div><img src="../images/icon-qiandao.png" alt=""></div><b>签到</b></a></div> -->
    </div>
    <!-- 赛普文章头条 -->
    <!-- 灰色的边距 -->
    <div class="bgcolor_gray edge-top20" style=""></div>
    <!-- 赛普头条 -->
   <div class="plr30 bgcolor_fff home_headline" style="">
        <div class="weui-cells nobefore noafter mt0 fz">
            <div class="weui-cell weui-cell_access mtb23 nobefore noafter padding0">
                <div class="weui-cell__hd" onclick="window.location.href='/article/0.html'">
                    <img src="/images/headline.png" alt="" class="home_hl">
                </div>
                    <div class="notice">
                        <ul class=" ">
                            @if($newarticle)
                                @foreach($newarticle as $article)
                                <li>
                                    <a href="/article/detail/{{$article['id']}}.html">
                                        <div class="weui-cell padding0">
                                            <div class="weui-cell__hd">
                                                @if($article['is_selected'])
                                                <img src="/images/icon_hot.png" />
                                                @else
                                                 <img src="/images/icon_new.png" />
                                                @endif
                                            </div>
                                            <div class="weui-cell__bd">
                                              <p class="text-overflow f28 color_000 text-overflow">{{$article['title']}}</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                <div class="f24 color_gray666 spb_arrow weui-cell__ft" onclick="window.location.href='/article/0.html'"></div>
            </div>
        </div>
        <script>
        function noticeUp(obj,top,time) {
                $(obj).animate({
                        marginTop: top,

                }, time, function () {
                    $(this).css({marginTop:"0"}).find("li:first,li:eq(1)").remove().clone(true).appendTo(this);
                })
         }
        $(function () {
            // 调用函数
            setInterval("noticeUp('.notice ul','-56px',500)", 2000);
        });
        </script>
    </div>
    <!-- 赛普文章头条结束 -->
     <!-- 灰色的边距 -->
    @if($liveCourses->count())
    <div class="bgcolor_gray edge-top20"></div>
    <!--中标题-->
    <div class="">
        <div class="weui-cells nobefore noafter mt0 lt xuyuan-title">
            <div class="weui-cell">
                <div class="weui-cell__bd text_center">
                    <p>直播预告</p>
                </div>
            </div>
            <hr class="mlr20">
        </div>
    </div>
    @endif
    <!--直播 start-->
    <div class="list bgcolor_fff plr30" style="">
        <ul>
            @foreach($liveCourses as $live)
                <?php
                    $lvCourse = App\Models\Course::where('is_live',1)->where('state',1)->whereNull('deleted_at')->orderBy('live_start_time','asc')->first();
                ?>
            <a href="/course/detail/{{$live->id}}.html">
                <li class="ptb40">
                <dl class="clearfix">
                    <dt class="border-radius-img"><img src="{{env('IMG_URL')}}{{$live->cover_url}}" alt="" /><span class="bgcolor_orange text_center fz color_333">{{$live->courseType->title}}</span></dt>
                    <dd>
                        <h3 class="lt text-overflow">{{$live->title}}</h3>
                        <?php
//                            dd($live->course_class_id);
//                            dd(sum_course($live->id));

                        ?>
                        <p class="fz color_gray666">{{sum_course($live->id)->count}}节课·{{sum_study($live->id)->count}} 人正在提高中</p>
                         <div class="weui-cells fz color_gray666 noafter nobefore mt0 zhibo">
                             <div class="weui-cell">
                                <div class="weui-cell__hd"><img src="/images/icon_livelight.png"></div>
                                <div class="weui-cell__bd">
                                    @if($lvCourse && ((time() >= strtotime($lvCourse->live_start_time) && time() <= strtotime($lvCourse->live_end_time)) || time() > strtotime($lvCourse->live_end_time)))
                                    <p class="color_000 f20 lt">正在直播</p>
                                    @else
                                        <p class="color_000 f20 lt">待直播</p>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <div class="weui-cells fz color_gray666 noafter nobefore mt0 ">
                            <div class="weui-cell zhibo_dao">
                                <div class="weui-cell__bd">
                                    @if($live->user_id)
                                    <p>{{$live->author->name}}</p>
                                    @endif
                                </div>
                                <div class="weui-cell__ft color_orange bold">免费</div>
                            </div>
                        </div>
                        <!--<p class="fz color_gray999">Jane King 导师</p>-->
                        <div class="text_center fz">
                            <!-- Swiper -->
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    {{--{{dd($live->courseTag)}}--}}
                                    @foreach($live->courseTag as $ctag)
                                            <div class="swiper-slide"><a class="color_gray666" href="/course/tagdetail/{{$ctag->tag->id}}.html">{{$ctag->tag->title}}</a></div>
                                    @endforeach
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
    <!--直播 end-->
    <!-- 灰色的边距 -->
    <div class="bgcolor_gray edge-top20" style=""></div>

    <!--中标题-->
    <div>
        <div class="weui-cells nobefore noafter mt0 lt xuyuan-title">
            <div class="weui-cell">
                <div class="weui-cell__bd text_center">
                    <p>新课速递</p>
                </div>
            </div>
            <hr class="mlr20">
        </div>
    </div>

    <!--列表1 start-->
    <div class="list bgcolor_fff plr20">
        <ul>
             @if($one)
		<a href="/course/detail/{{$one->id}}.html">
            <li class="ptb40">
                <dl class="clearfix">
                    <dt class="border-radius-img"><img src="{{env('IMG_URL')}}{{$one->cover_url}}" alt="" /><span class="bgcolor_orange text_center fz color_333">{{$one->typeName}}</span></dt>
                    <dd>
                        <h3 class="lt text-overflow">{{$one->title}}</h3>
                        <p class="fz color_gray666"> {{$one->sum_video}}节课·{{$one->sum_people}} 人正在提高中</p>
                        <!-- <p class="fz color_gray999">{{$one->teacher_name}}导师</p> -->
                        <div class="weui-cells fz color_gray666 noafter nobefore mt0 ">
                            <div class="weui-cell">
                                <div class="weui-cell__bd f22">
                                    <p>{{$one->teacher_name}}</p>
                                </div>
                                @if($one->is_free)
                                    @if($one->sum_video == 1)
                                        <div class="weui-cell__ft color_orange f28 color_red">¥{{$one->price}}</div>
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
                                @if(isset($one['tagArr']))
									@foreach($one['tagArr'] as $v)
										<div class="swiper-slide"><a class="color_gray666" href="/course/tagdetail/{{$v[0]->id}}.html">{{$v[0]->title}}</a></div>
									@endforeach
                                @endif

                                </div>
                            </div>
                        </div>

                    </dd>
                </dl>
            </li>
		</a>
        @else
        <div class="weui-loadmore more text_center fz ptb30 remove_attr " id="study_more">
            <span class="weui-loadmore__tips" >暂无数据</span>
        </div>

        @endif
         </ul>
    </div>
    <!--列表1 end-->
    <!-- 灰色的边距 -->
    <div class="bgcolor_gray edge-top20" style="display: none;"></div>
    <!-- 活动 -->
     <div class="bgcolor_fff home_activity" style="display: none;">
        <div class="weui-cells nobefore noafter mt0 plr30">
            <a class="weui-cell weui-cell_access padding0 nobefore noafter fz" href="javascript:;">
                <div class="weui-cell__bd color_gray9b">
                    <p class="text_center f32 color_000 ptb30">活动</p>
                </div>
                <div class="right f24 color_gray666">
                    更多
                </div>
            </a>
        </div>
        <img src="../images/home_huo.jpg" alt="">
        <div class="weui-cells fz color_gray666 noafter nobefore mt0 plr30">
            <div class="weui-cell ptb30">
                <div class="weui-cell__bd">
                    <p class="f30 color_333 lt">10套精品课程&nbsp;&nbsp;&nbsp;&nbsp;让你爱上健身</p>
                    <p class="f24 color_gray666">活动时间：2018.10.07</p>
                </div>
                <a href="javascript:;" class="home_bao f24"><div class="weui-cell__ft color_000">报名中</div></a>
            </div>
        </div>
     </div>

    <!-- 灰色的边距 -->
    <div class="bgcolor_gray edge-top20"></div>
    <!--中标题-->
    <div class="">
        <div class="weui-cells nobefore noafter mt0 lt xuyuan-title">
            <div class="weui-cell">
                <div class="weui-cell__bd text_center">
                    <p>精选课程</p>
                </div>
            </div>
            <hr class="mlr20">
        </div>
    </div>

    <div class="bgcolor_fff plr20">
        @if($list)
        <!--列表2 start-->
        <div class="list">
            <ul  id="list">
            @foreach($list as $v)
                <a href="/course/detail/{{$v->id}}.html">
                <li class="ptb30">
                    <dl class="clearfix">
                        <dt class="border-radius-img"><img src="{{env('IMG_URL')}}{{$v->cover_url}}" alt="" /><span class="bgcolor_orange text_center fz color_333">{{$v->typeName}}</span></dt>
                        <dd>
                            <h3 class="lt text-overflow">{{$v->title}}</h3>
                            <p class="fz color_gray666">{{$v->sum_video}} 节课·{{$v->sum_people}}人正在提高中</p>
                            <!-- <p class="fz color_gray999">{{$v->teacher_name}}导师</p> -->
                            <div class="weui-cells fz color_gray666 noafter nobefore mt0 ">
                                <div class="weui-cell">
                                    <div class="weui-cell__bd f22">
                                        <p>{{$v->teacher_name}}</p>
                                    </div>
                                     @if($v->is_free)
                                         @if($v->sum_video == 1)
                                            <div class="weui-cell__ft color_orange f28 color_red">{{$v->price}}元</div>
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
                                    @if(isset($v->tagArr))
                                    @foreach($v->tagArr as $a)
                                        <div class="swiper-slide"><a class="color_gray666" href="/course/tagdetail/{{$a[0]->id}}.html">{{$a[0]->title}}</a></div>
                                    @endforeach
                                    @endif
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
        <!--列表2 end-->
       <!-- <div class="weui-loadmore more text_center fz ptb30">
            <i class="weui-loading"></i>
            <span class="weui-loadmore__tips">正在加载</span>
        </div>-->
        <!--加载更多-->
        <div class="weui-loadmore more text_center fz ptb30 remove_attr " id="study_more">
            <!-- <i class="weui-loading"></i> -->
            <span class="weui-loadmore__tips" id ="add_more"  data-is_ture='1'>加载更多</span>
        </div>
        @else
        <div class="weui-loadmore more text_center fz ptb30 remove_attr " id="study_more">
            <span class="weui-loadmore__tips" >暂无数据</span>
        </div>
        @endif
        <br><br>
    </div><!--白色背景层 end-->

</div>

<!-- 底部固定导航条 start -->
<!-- <div class="fixed_bar_bottom">
   <div class="weui-tabbar nav-tabbar">
      <a href="/" class="weui-tabbar__item weui-bar__item--on"><span class="ico_home"></span></a>
      <a href="/article/0.html" class="weui-tabbar__item"><span class="ico_find"></span></a>
      <a href="/user/studying" class="weui-tabbar__item"><span class="ico_study"></span></a>
      <a href="/user/index" class="weui-tabbar__item "><span class="ico_my"></span></a>
   </div>
</div> -->
<div class="relative">
    <div class="fixed_bottom_4 clearfix">
        <a href="/" class="on"><span class="icon-home"></span></a>
        <a href="/article/0.html"><span class="icon-find"></span></a>
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
</script>
<script src="/lib/jqweui/js/fastclick.js"></script>
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
        if(hasMobile == 0 && isShow !=1) {
//            setTimeout(function () {
//                $('html').addClass('htmlH100');
//
//                $.ajax({
//                    url: '/fee/course',
//                    type: 'GET',
//                    dataType: 'json',
//                    success:function(res){
//                        var result = res.data.freeCourse;
//                        layer.open({
//                            type: 1,
//                            title: false, //不显示标题栏
//                            skin: 'zhucelingqu_layer_wrap', //样式类名
//                            id: 'zhucelingqu_layer', //设定一个id，防止重复弹出
//                            closeBtn: 1, //不显示关闭按钮
//                            anim: 2,
//                            shadeClose: false, //开启遮罩关闭
//                            area: ['90%', '60%'],
//                            content: result,
//                            btn: false,
//                            cancel: function(){
//                                localStorage.setItem(isDiscard,1);
//                                $('html').removeClass('htmlH100');
//                            }
//                        });
//                        var swiper = new Swiper('.swiper-container', {
//                            slidesPerView: 'auto',
//                            spaceBetween: 10
//                        });
//                    }
//                });
//
//            }, 1000);
        }
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
<script src="/lib/jqweui/js/jquery-weui.js"></script>
<script>
    var i = 2;
$("#study_more").click(function(){
	var number = $("#add_more").attr("data-is_ture");
	if(number == 1){
            $.ajax({
                type:"get",
                url:"/course/getjson",
                data:{page:i},
                dataType:"json",
                success:function(data){
					console.log(data);
                        if(!jQuery.isEmptyObject(data)){
                        $.each(data,function(index,json){
							var str ="";
                            var str =str + "<a href='/course/detail/"+json['id']+".html'>";
                            var str =str + "<li class='ptb30'>" ;
                            var str =str + "<dl class='clearfix'>";
                            var str =str +"<dt class='border-radius-img'><img src='{{env('IMG_URL')}}"+json['cover_url']+"' alt=''/><span class='bgcolor_orange text_center fz color_333'>"+json['typeName']+"</span></dt>";
                            var str =str +"<dd>";
                            var str =str +"<h3 class='lt text-overflow'>"+json['title']+"</h3>";
                            var str =str +"<p class='fz color_gray666'>"+json['sum_video']+" 节课·"+json['sum_people']+" 人正在提高中</p>";
                           // var str =str +"<p class='fz color_gray999'>"+json['teacher_name']+"</p>";
                            var str =str +'<div class="weui-cells fz color_gray666 noafter nobefore mt0 ">';
                            var str =str +'<div class="weui-cell">';
                            var str =str +'<div class="weui-cell__bd f22">';
                            var str =str +'<p>'+json['teacher_name']+'</p>';
                            var str =str +'</div>';
                            if(json['is_free']){
                                if(json['sum_video'] == 1){
                                    var str =str +'<div class="weui-cell__ft color_orange f28 color_red">¥ '+json['price']+'</div>';
                                }else{
                                    var str =str +'<div class="weui-cell__ft color_orange f28 color_red">可试看</div>';
                                }

                            }else{
                                var str =str +'<div class="weui-cell__ft color_orange bold f28">免费</div>';
                            }
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
                            $("#list").append(str);

                        })
                         i++;
						var swiper = new Swiper('.swiper-container', {
							slidesPerView: 'auto',
							leftedSlides: true,
							spaceBetween: 10,
							grabCursor: true
						});
                     }else{
						 $("#add_more").attr("data-is_ture",0);
                        $("#add_more").text("没有更多课程了");
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
            title: '{{$website->title}}', // 分享标题
            desc: '{{$website->description}}', // 分享描述
            link: "http://m.saipubbs.com?fission_id={{$fission_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/tubiao/1.png", // 分享图标
        }, function(res) {
        //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '{{$website->title}}', // 分享标题
            link: "http://m.saipubbs.com?fission_id={{$fission_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/tubiao/1.png", // 分享图标
        }, function(res) {
        //这里是回调函数
        });
    });
    //将裂变者id写入本地  用于存储上下级关系
    localStorage.setItem("fission_id", "{{$fission_id}}");
    //将注册来源页面写入存储
    localStorage.setItem("channel", "index");
    console.log(localStorage.getItem('fission_id')+"是否是裂变者");
    console.log("index"+"channel");
    //统计代码设置用户id
    gio('setUserId', "{{$user_id}}");
</script>
@endsection
