@extends('layouts.header')
@section('title')
    <title>我的信息{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link href="/css/my.css" rel="stylesheet" type="text/css" />
    <style>
        #page {padding-bottom:3rem;}
    </style>
@endsection
@section('content')
<!-- 头部条 start -->
<!-- <div class="fixed_bar_top">
    <header class="header_bar bgc_grey relative">
        <h1 class="cat">我的</h1>
    </header>
</div> -->
<!-- 头部条 end -->

<!-- 用户未登录状态 start -->
<div class="weui-cells photo_info bgc_white">
    <div class="weui-cell weui-cell_access">
        <div class="weui-cell__bd">
            <a href="/user/info" class="user_photo"><img src="/images/my/nophoto.jpg" alt="" /></a>
        </div>
        <div class="weui-cell__ft">
            <a href="/user/info">登录赛普健身社区<br />立即提升健身实力</a>
        </div>
    </div>
</div>
<!-- 用户未登录状态 end -->

<!-- 功能列表 start -->
<div class="weui-cells mt10 lists">
    <a href="/user/userstudy" class="weui-cell weui-cell_access">
        <div class="weui-cell__hd"><img src="../images/my/ico_xuexi.png" class="icoImg mr10" /></div>
        <div class="weui-cell__bd">
            <div class="tit">正在学习</div>
        </div>
        <div class="weui-cell__ft"></div>
    </a>
    <a href="/user/usercourse" class="weui-cell weui-cell_access">
        <div class="weui-cell__hd"><img src="../images/my/ico_fabu.png" class="icoImg mr10" /></div>
        <div class="weui-cell__bd">
            <div class="tit">发布的课程</div>
        </div>
        <div class="weui-cell__ft"></div>
    </a>
    <a href="/user/usercollect" class="weui-cell weui-cell_access">
        <div class="weui-cell__hd"><img src="../images/my/ico_shoucang.png" class="icoImg mr10" /></div>
        <div class="weui-cell__bd">
            <div class="tit">收藏的课程</div>
        </div>
        <div class="weui-cell__ft"></div>
    </a>
</div>
<div class="weui-cells mt10 lists">
   <a href="/user/money" class="weui-cell weui-cell_access">
      <div class="weui-cell__hd"><img src="../images/my/ico_qianbao.png" class="icoImg mr10" /></div>
      <div class="weui-cell__bd">
         <div class="tit">我的钱包</div>
      </div>
      <div class="weui-cell__ft"></div>
   </a>
   <a href="/user/news" class="weui-cell weui-cell_access">
      <div class="weui-cell__hd"><img src="../images/my/ico_xiaoxi.png" class="icoImg mr10" /></div>
      <div class="weui-cell__bd">
         <div class="tit">我的消息</div>
      </div>
      <div class="weui-cell__ft"></div>
   </a>
</div>
<div class="weui-cells mt10 lists">
   <!-- <a href="/user/shareFriends" class="weui-cell weui-cell_access">
        <div class="weui-cell__hd"><img src="../images/my/ico_zhinan.png" class="icoImg mr10" /></div>
        <div class="weui-cell__bd">
            <div class="tit">邀请好友</div>
        </div>
        <div class="weui-cell__ft"></div>
    </a>-->
    <a href="/user/newuser" class="weui-cell weui-cell_access">
        <div class="weui-cell__hd"><img src="../images/my/ico_zhinan.png" class="icoImg mr10" /></div>
        <div class="weui-cell__bd">
            <div class="tit">新手指南</div>
        </div>
        <div class="weui-cell__ft"></div>
    </a>
    <a href="/user/about" class="weui-cell weui-cell_access">
        <div class="weui-cell__hd"><img src="../images/my/ico_guanyu.png" class="icoImg mr10" /></div>
        <div class="weui-cell__bd">
            <div class="tit">关于我们</div>
        </div>
        <div class="weui-cell__ft"></div>
    </a>
</div>
<!-- 功能列表 end -->
<!-- 底部固定导航条 start -->
<div class="fixed_bar_bottom">
   <div class="weui-tabbar nav-tabbar">
      <a href="/" class="weui-tabbar__item"><span class="ico_home"></span></a>
      <a href="/article/0.html" class="weui-tabbar__item"><span class="ico_find"></span></a>
      <a href="/user/studying" class="weui-tabbar__item"><span class="ico_study"></span></a>
      <a href="javascript:;" class="weui-tabbar__item weui-bar__item--on"><span class="ico_my"></span></a>
   </div>
</div>
<!-- 底部固定导航条 end -->
<script src="/lib/layer/layer.js"></script>
<script>
  $(document).ready(function(){
    var m = "{{$mobile}}";
    if(m==0){
      var url = "/user/index";
      layer.msg('请先注册');
      localStorage.setItem("redirect", url);
      setTimeout(function(){
        window.location.href = "/register";
      }, 1000)
    }
  });
</script>
@endsection