@extends('layouts.header')
@section('title')
    <title>标签分类-赛普健身社区</title>
 @endsection   

@section('cssjs')
    <link rel="stylesheet" href="/css/xueyuan.css">
    <!--jqweui css-->
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth/18.75 + "px";
        })()
    </script>
@endsection

@section("top")
<body class="bgcolor_fff">
<!-- 头部条 start -->
<!-- <div class="fixed_bar_top">
    <header class="header_bar bgc_grey relative">
        <a href="javascript:history.go(-1);" class="btn_back"><i></i></a>
        <h1 class="cat">标签分类</h1>
    </header>
</div> -->
<!-- 头部条 end -->
@endsection
@section('content')
<div class="plr30 tag_list text_center mt30 fz">
    <ul class="clearfix">
@if(isset($data[0]))
    @foreach($data as $v)
        <li class="bgcolor_gray border-radius-img ptb30 mb30 f28"><a href="/course/tagdetail/{{$v->id}}.html" class="color_gray666"><img class="mb20" src="{{env('IMG_URL')}}{{$v->cover_url}}" alt=""><p>{{$v->title}}</p></a></li>
     @endforeach  
  @else 
    <div class="con">
            <div class="empty"><img src="/images/empty.png" alt=""></div>
            <h2 class="fz color_gray666  text_center mt30 pt20">暂无标签</h2>
        </div>
   @endif
    </ul>
</div>
<br/><br/><br/><br/><br/><br/><br/>

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
            title: '标签分类-赛普健身社区', // 分享标题
            desc: '标签分类-赛普健身社区', // 分享描述
            link: "http://m.saipubbs.com/course/tag?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/tubiao/1.png", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '标签分类-赛普健身社区', // 分享标题
            link: "http://m.saipubbs.com/course/tag?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/tubiao/1.png", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
    //将裂变者id写入本地  用于存储上下级关系
    localStorage.setItem("fission_id", "{{$fission_id}}");
</script>
@endsection
