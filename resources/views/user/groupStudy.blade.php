@extends('layouts.header')
@section('title')
    <title>赛普社区-打卡</title>
    <meta name="author" content="啾啾" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    @endsection

    @section('cssjs')
            <!--本css-->
    {{--<link rel="stylesheet" href="/css/fenxiaoliucheng.css" >--}}
    <link rel="stylesheet" href="/css/my_classroom.css">
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>

    @endsection
    @section('content')

            <!---导航右侧带导航弹出---->

    <div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->


        <!--====================================本喵是分割线  喵喵~========================================================-->
        <div class="classroom_list_nav">
            <ul class="clearfix text_center">
                <li><a href="/user/studying" class="block fz f28 color_333"><span>单课</span></a></li>
                <li class="on"><a href="/user/train.html" class="block fz f28 color_333"><span>认证课</span></a></li>
                <li><a href="/user/clock.html" class="block fz f28 color_333"><span>训练营</span></a></li>
                {{--<li><a href="/underline/course.html" class="block fz f28 color_333"><span>线下课</span></a></li>--}}
            </ul>
        </div>
        <!--====================================本喵是分割线  喵喵~========================================================-->

        <div class="classroom_line_courses classroom_training_camp mt30 mlr30">
            <ul>
                @if(count($groupList) > 0)
                    @foreach($groupList as $v)
                        <?php
                            $class_id = explode(',',$v->course_class_ids)[0];
                        ?>
                        <li>
                            <a href="/group/video/{{$v->id}}/{{$class_id}}.html">
                                <img src="{{env('IMG_URL')}}{{$v->list_url}}" alt="" class="img100 border-radius-img">
                                <h3 class="mt30 color_333 fz bold f30 text-overflow2">{{$v->title}}</h3>
                                {{--<div class="progressBox mt20">--}}
                                    {{--<div class="words f24 color_gray666">共<span>22</span>个任务，已完成<span class="color_orange">11</span>个</div>--}}
                                    {{--<div class="progressBar clearfix">--}}
                                    {{--<div class="progress">--}}
                                    {{--<!-- 数据库获取到22和11，循环的时候11/22*100 -->--}}
                                    {{--<div class="bar" style="width:50%"></div>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            </a>
                        </li>
                    @endforeach
                @else
                    <div class="con">

                        <h2 class="fz color_gray666  text_center mt30 pt20">没有找到课程,快去学院看看吧!</h2>
                    </div>
                @endif
            </ul>
        </div>
        @if(count($groupList) > 0)
            <div class="con">
                <h2 class="fz color_gray666  text_center mt30 pt20 loadmore" onclick="loadmore(this);" data-load = 0>加载更多</h2>
            </div>
        @endif


                    <!--====================================本喵是分割线  喵喵~========================================================-->
            <!--====================================本喵是分割线  喵喵~========================================================-->
            <!--====================================本喵是分割线  喵喵~========================================================-->
            <!--====================================本喵是分割线  喵喵~========================================================-->
    </div><!--导航大盒子id=page 结束-->



    <br><br>
    <br><br>

    <!-- 底部固定导航条 start -->
    <div class="relative">
        <div class="fixed_bottom_4 clearfix">
            <a href="/"><span class="icon-home"></span></a>
            <a href="/article/0.html"><span class="icon-find"></span></a>
            <a href="/ask/specialdetail.html"><span class="icon-ask"></span></a>
            <a href="/user/studying" class="on"><span class="icon-study"></span></a>
            <a href="/user/index"><span class="icon-my"></span></a>
        </div>
    </div>
    <!-- 底部固定导航条 end -->
    <script>
        var _token   = '{{csrf_token()}}';
        var i = 2;
        var loadmore = function(e){
            var loaddata = e.getAttribute("data-load");
            console.log(loaddata);
            if(loaddata == 0){
                $.ajax({
                    url : '/user/train.html',
                    type : 'GET',
                    dataType : 'json',
                    data : {page:i,type:'pg'},
                    success : function (data) {
                        if(data.data.body == ''){
                            layer.msg("加载完成哦~");
                            $(".loadmore").text("加载完成");
                            $(".loadmore").attr("data-load",1);
                        }else{
                            $(".classroom_line_courses ul").append(data.body);
                        }
                        i++;
                    }
                });
            }else{
                layer.msg("加载已完成哦~");
            }

        }
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

        var link = 'http://m.saipubbs.com/user/train.html';
        var title = '组合课程';
        var desc = '组合课程详情';
        var img = 'http://m.saipubbs.com/images/clock/daka.jpg';
        wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
            wx.onMenuShareAppMessage({
                title: title, // 分享标题
                desc: desc, // 分享描述
                link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: img, // 分享图标

            }, function(res) {
                //这里是回调函数

            });
        });
        wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
            wx.onMenuShareTimeline({
                title: title, // 分享标题
                link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: img, // 分享图标

            }, function(res) {
                //这里是回调函数

            });
        });
    </script>
@endsection
