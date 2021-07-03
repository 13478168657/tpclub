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
		<a href="javascript:history.go(-1);" class="btn_back"><i class="icon iconfont icon-fenxiang2"></i></a>
		<h1 class="cat">我的信息</h1> -->
		<!-- <a href="javascript:void(0)" class="btn_link red" id="edit">编辑</a> -->
	<!-- </header>
</div> -->
<!-- 头部条 end -->

<!-- 用户登录头像信息 start -->
<div class="weui-cells photo_info bgc_white logged">
	<div class="weui-cell weui-cell_access">
		<div class="weui-cell__bd">
			<a href="/user/edit" class="user_photo">
				@if($user->avatar)
					@if(strpos($user->avatar,'http') !== false)
						<img src="{{$user->avatar}}" alt=""/>
					@else
						<img src="{{env('IMG_URL')}}{{$user->avatar}}" alt="头像" />
					@endif
				@else
				<img src="/images/my/nophoto.jpg" alt="头像" />
				@endif
			</a>
			
			<ul class="info info-saipubi">
				@if($user->nickname)
			   <li><a href="/user/edit">{{$user->nickname}}&nbsp;<img src="../images/my/ico_bianji.png" /></a></li>
			   @else
				<li><a href="/user/edit">ID：{{$user->id}}&nbsp;<img src="../images/my/ico_bianji.png" /></a></li>
			   @endif
			   <li class="pt10"><a href="/user/task"><img src="/images/my/ico_saipubi.png" alt="">赛普币{{$spb}}</a></li>
			</ul>
		</div>
		<div class="weui-cell__ft">
			<a href="/user/center/1.html" class="btn_info">个人主页</a>
		</div>
	</div>
</div>
<!-- 用户登录头像信息 end -->


<!-- 功能条 start -->
<div class="weui-flex grid_wrap bgc_white">
	<div class="weui-flex__item">
		<a href="/user/followlist">
			<p>
				<span class="text_center">{{$follows}}</span>
				<b>关注</b>
			</p>
		</a>
	</div>
	<div class="weui-flex__item">
		<a href="/user/fanslist">
			<p>
				<span class="text_center">{{$fans}}</span>
				<b>粉丝</b>
			</p>
		</a>
	</div>
	<div class="weui-flex__item">
		<a href="/user/powderlist">
			<p>
				<span class="text_center">{{$powders}}</span>
				<b>互粉</b>
			</p>
		</a>
	</div>
</div>
<!-- 功能条 end -->
<!--我的邀请 start-->
<div class="weui-cells mt10">
   <a href="/user/shareFriends" class="weui-cell weui-cell_access hide">
      <div class="weui-cell__bd ptb20">
         <div class="tit">
         	@if($is_fission==1)
			<img src="../images/my/ico_share.png" class="icoImg mr5" />我的邀请(咨询老师)
			@elseif($is_fission==2)
			<img src="../images/my/ico_share.png" class="icoImg mr5" />我的邀请(新媒体人)
			@else
			<img src="../images/my/ico_share.png" class="icoImg mr5" />我的邀请
			@endif
         </div>
         @if($is_fission==1 || $is_fission==2)
         <!-- <p class="f22 color_gray999 paleft13">二级代理人数：{{$childrens}}人</p > -->
         @endif
      </div>
      <div class="weui-cell__ft"></div>
   </a>
   <a href="/distribution/explain.html" class="weui-cell weui-cell_access hide">
		<div class="weui-cell__bd">
			<div class="tit"><img src="../images/my/ico_dis.png" class="icoImg mr5" />申请分销员赚奖金</div>
		</div>
		<div class="weui-cell__ft"></div>
	</a>
	<!-- <a href="/distribution/apply.html" class="weui-cell weui-cell_access">
		<div class="weui-cell__bd">
			<div class="tit"><img src="../images/my/ico_dis_list.png" class="icoImg mr5" />我的分销商</div>
		</div>
		<div class="weui-cell__ft"></div>
	</a> -->
</div>
<!--我的邀请 end-->

<!-- 功能列表 start -->
<div class="weui-cells mt10">
	<a href="/user/userstudy" class="weui-cell weui-cell_access">
		<div class="weui-cell__bd">
			<div class="tit"><img src="../images/my/ico_xuexi.png" class="icoImg mr5">我的教室</div>
		</div>
		<div class="weui-cell__ft"></div>
	</a>
	<a href="/user/edit" class="weui-cell weui-cell_access">
		<div class="weui-cell__bd">
			<div class="tit"><img src="/images/my/ico_dangan.png" class="icoImg mr5">我的档案</div>
		</div>
		<div class="weui-cell__ft"></div>
	</a>
	<!-- <a href="/user/usercourse" class="weui-cell weui-cell_access">
		<div class="weui-cell__bd">
			<div class="tit"><img src="../images/my/ico_fabu.png" class="icoImg mr5" />发布的课程</div>
		</div>
		<div class="weui-cell__ft"></div>
	</a> -->
	<a href="/user/collect/1.html" class="weui-cell weui-cell_access">
		<div class="weui-cell__bd">
			<div class="tit"><img src="../images/my/ico_shoucang.png" class="icoImg mr5" />我的收藏</div>
		</div>
		<div class="weui-cell__ft"></div>
	</a>
	@if(in_array($user->id,[102,93271,113244,1172]))
	<a href="/ask/special.html" class="weui-cell weui-cell_access">
		<div class="weui-cell__bd">
			<div class="tit"><img src="../images/my/ico_question.png" class="icoImg mr5" />问答专场</div>
		</div>
		<div class="weui-cell__ft"></div>
	</a>
	@endif
</div>
<div class="weui-cells mt10 lists">
   {{--<a href="/user/money" class="weui-cell weui-cell_access">--}}
      {{--<div class="weui-cell__hd"><img src="../images/my/ico_qianbao.png" class="icoImg mr10" /></div>--}}
      {{--<div class="weui-cell__bd">--}}
         {{--<div class="tit">我的钱包</div>--}}
      {{--</div>--}}
      {{--<div class="weui-cell__ft"></div>--}}
   {{--</a>--}}
   <a href="/user/news" class="weui-cell weui-cell_access">
      <div class="weui-cell__hd"><img src="../images/my/ico_xiaoxi.png" class="icoImg mr10" /></div>
      <div class="weui-cell__bd">
         <div class="tit">我的消息</div>
      </div>
      <div class="weui-cell__ft"></div>
   </a>
   <a href="/user/coupons" class="weui-cell weui-cell_access">
      <div class="weui-cell__hd"><img src="../images/my/icon-mycoupon.png" class="icoImg mr10" /></div>
      <div class="weui-cell__bd">
         <div class="tit">我的优惠券</div>
      </div>
      <div class="weui-cell__ft"></div>
   </a>
   <a href="/order/group" class="weui-cell weui-cell_access">
      <div class="weui-cell__hd"><img src="/images/my/icon-myorder.png" class="icoImg mr10" /></div>
      <div class="weui-cell__bd">
         <div class="tit">我的订单{{$user->id}}</div>
      </div>
      <div class="weui-cell__ft"></div>
   </a>
</div>
{{--<div class="weui-cells mt10">--}}
	{{--<a href="/user/newuser" class="weui-cell weui-cell_access">--}}
		{{--<div class="weui-cell__bd">--}}
			{{--<div class="tit"><img src="../images/my/ico_zhinan.png" class="icoImg mr5" />新手指南</div>--}}
		{{--</div>--}}
		{{--<div class="weui-cell__ft"></div>--}}
	{{--</a>--}}
	{{--<a href="/user/about" class="weui-cell weui-cell_access">--}}
		{{--<div class="weui-cell__bd">--}}
			{{--<div class="tit"><img src="../images/my/ico_guanyu.png" class="icoImg mr5" />关于我们</div>--}}
		{{--</div>--}}
		{{--<div class="weui-cell__ft"></div>--}}
	{{--</a>--}}
{{--</div>--}}
<!-- 功能列表 end -->
<!-- 底部固定导航条 start -->
<div class="relative">
    <div class="fixed_bottom_4 clearfix">
        <a href="/"><span class="icon-home"></span></a>
        <a href="/article/0.html"><span class="icon-find"></span></a>
        <a href="/cak/1.html"><span class="icon-ask"></span></a>
        <a href="/user/studying"><span class="icon-study"></span></a>
        <a href="/user/index" class="on"><span class="icon-my"></span></a>
    </div>
</div>
<script type="text/javascript">
	//localStorage.removeItem('fission_id');
</script>
<!-- 底部固定导航条 end -->
@endsection