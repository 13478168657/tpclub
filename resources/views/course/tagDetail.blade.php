@extends('layouts.header')
@section('title')
    <title>{{$name->seo_title}}{{env('WEB_TITLE')}}</title>
    <meta name="description" content="{{$name->seo_description}}" />
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
@section("top")
<!-- 头部条 start -->
<div class="fixed_bar_top">
    <header class="header_bar bgc_grey relative">
        <a href="javascript:history.go(-1);" class="btn_back"><i></i></a>
        <h1 class="cat">{{$name->title}}</h1>
    </header>
</div>
<!-- 头部条 end -->
@endsection
<div class="">
@if(isset($list[0]))
    <div class="bgcolor_fff plr20">

        <!--列表 start-->
        <div class="list" id="list">
            <ul>
            @foreach($list as $v)
                <a href="/course/detail/{{$v->id}}.html">
                <li class="ptb30">
                    <dl class="clearfix">
                        <dt class="border-radius-img"><img src="{{env('IMG_URL')}}{{$v['cover_url']}}" alt="" /><span class="bgcolor_orange text_center fz color_333">{{$v["typeName"]}}</span></dt>
                        <dd>
                            <h3 class="lt text-overflow">{{$v["title"]}}</h3>
                            <p class="fz color_gray666">{{$v['sum_video']}} 节课·{{$v->sum_people}} 人正在提高中</p>
                            <!-- <p class="fz color_gray999">{{$v->teacher_name}}导师</p> -->
                            <div class="weui-cells fz color_gray666 noafter nobefore mt0 ">
                                <div class="weui-cell">
                                    <div class="weui-cell__bd f22">
                                        <p>{{$v->teacher_name}}</p>
                                    </div>
                                    @if($v->is_free)
                                        @if($v['sum_video']== 1 || $v['preview'] ==0)
                                            <div class="weui-cell__ft color_orange f28 color_red">¥{{$v->price}}</div>
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
                                    @foreach($v["tagArr"] as $k)
                                       @if(isset($k[0]))
                                            <div class="swiper-slide"><a class="color_gray666" href="/course/tagdetail/{{$k[0]->id}}.html">{{$k[0]->title}}</a></div>
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        </dd>
                    </dl>
                </li>
                @endforeach
            </ul>
        </div>
        <!--列表 end-->

        <!--加载更多-->

        <div class="weui-loadmore more text_center fz ptb30 remove_attr" id="study_more">
            <!-- <i class="weui-loading"></i> -->
            <span class="weui-loadmore__tips" id ="add_more"  data-is_ture='1'>加载更多</span>
        </div>

        <br><br>
    </div><!--白色背景层 end-->
@else
		   <div class="con">
			<div class="empty"><img src="/images/empty.png" alt=""></div>
			<h2 class="fz color_gray666  text_center mt30 pt20">暂无更多课程</h2>
		</div>
   @endif
</div>

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
    var i=2;
	$("#study_more").click(function(){
		var number = $("#add_more").attr("data-is_ture");
		if(number == 1){
          $.ajax({
                type:"get",
                url:"/course/TagGetJson",
                data:{page:i,tagId:{{$tagId}}},
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
                            //var str =str +"<p class='fz color_gray999'>"+json['teacher_name']+"</p>";
                            var str =str +'<div class="weui-cells fz color_gray666 noafter nobefore mt0 ">';
                            var str =str +'<div class="weui-cell">';
                            var str =str +'<div class="weui-cell__bd f22">';
                            var str =str +'<p>'+json['teacher_name']+'</p>';
                            var str =str +'</div>';
                            if(json['is_free']){
                                if(json['sum_video'] == 1 || json['preview'] == 0){
                                    var str =str +'<div class="weui-cell__ft color_orange f28 color_red">¥'+json['price']+'</div>';
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
                                if(!json['tagArr']){
                                    var str =str +"<div class='swiper-slide'><a class='color_gray666' href='/course/type?id="+json['tagArr'][i][0]['id']+"'>"+json['tagArr'][i][0]['title']+"</a></div>";
                                }
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
            title: '{{$name->seo_title}}{{env('WEB_TITLE')}}', // 分享标题
            desc: '{{$name->seo_description}}', // 分享描述
            link: "http://m.saipubbs.com/course/tagdetail/{{$tagId}}.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/tubiao/1.png", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '{{$name->seo_title}}{{env('WEB_TITLE')}}', // 分享标题
            link: "http://m.saipubbs.com/course/tagdetail/{{$tagId}}.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/tubiao/1.png", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
    //将裂变者id写入本地  用于存储上下级关系
    localStorage.setItem("fission_id", "{{$fission_id}}");
</script>
@endsection
@include('layouts.footer')