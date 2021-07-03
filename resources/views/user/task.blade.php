<!-- <!DOCTYPE html>
<html lang="zh-CN" class="htmlWhite">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
<title>个人任务</title>
<meta name="author" content="涵涵" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
<link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
<link href="/css/reset.css" rel="stylesheet" type="text/css" />
	<link href="/css/font-num40.css" rel="stylesheet" type="text/css" />
<link href="/css/my.css" rel="stylesheet" type="text/css" />
</head> -->
@extends('layouts.header')
@section('title')
    <title>个人任务{{env('WEB_TITLE')}}</title>
    <meta name="description" content="" />
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/my.css">
    <style>
        #page {padding-bottom:3rem;}
    </style>
@endsection
@section('content') 
<body class="bgc_white" ontouchstart>

<!--===================本喵是分割线 喵喵~======================================================-->
<div class="bg-task-top">
	<div class="weui-cells noafter nobefore padding0 mt0 background0">
		<a class="weui-cell noafter nobefore padding0 mt0 weui-cell_access" href="/spb/index">
			<div class="weui-cell__bd">
				<p class="fz bold f36 color_333">赛普币{{$spb}}</p>
				<p class="fz f24 color_333">赛普币可直接用于购买课程</p>
			</div>
			<div class="fz f26 color_gray666 rightj">
				查看明细
			</div>
		</a>
	</div>
</div>
<!--===================本喵是分割线 喵喵~======================================================-->
<!--邀请好友得1300元现金红包 start-->
<!-- <div class="bgcolor_f9f9f9 ptb20">
	<div class="bg-go text_center">
		<a href="javascript:void (0)" class="d-in-black fz f28 color_fff">邀请好友&nbsp;&nbsp;得<span class="fz f32 bold">1300元</span>现金红包</a>
	</div>
</div> -->
<!--邀请好友得1300元现金红包 end-->
<!--===================本喵是分割线 喵喵~======================================================-->
<!--日常任务 start-->
<div class="rctask plr30">
	<h3 class="mb30 mt30 color_gray9b fz f24">日常任务</h3>
	<ul>
		<li>
			<div class="weui-cells noafter   mt0 background0">
				<div class="weui-cell noafter nobefore  mt0">
					<div class="weui-cell__bd">
						<p class="fz f28 color_4a mb02">分享一个课程</p>
						<p class="fz f20 color_gray999">每次奖励50<img class="img30" src="/images/my/ico_saipubi.png" alt=""> ，每天3次</p>
					</div>
					<div class="fz f28 color_gray666">
						<a href="/course/courseAll/0.html" class="border-radius-img">去完成</a>
					</div>
				</div>
			</div>
		</li>
		<li>
			<div class="weui-cells noafter   mt0 background0">
				<div class="weui-cell noafter nobefore  mt0">
					<div class="weui-cell__bd">
						<p class="fz f28 color_4a mb02">分享一个专题</p>
						<p class="fz f20 color_gray999">每次奖励50<img class="img30" src="/images/my/ico_saipubi.png" alt=""> ，每天3次</p>
					</div>
					<div class="fz f28 color_gray666">
						<a href="/special/list.html" class="border-radius-img">去完成</a>
					</div>
				</div>
			</div>
		</li>
		<li>
			<div class="weui-cells noafter   mt0 background0">
				<div class="weui-cell noafter nobefore  mt0">
					<div class="weui-cell__bd">
						<p class="fz f28 color_4a mb02">分享一篇文章</p>
						<p class="fz f20 color_gray999">每次奖励50<img class="img30" src="/images/my/ico_saipubi.png" alt=""> ，每天3次</p>
					</div>
					<div class="fz f28 color_gray666">
						<a href="/article/0.html" class="border-radius-img">去完成</a>
					</div>
				</div>
			</div>
		</li>
		<!-- <li>
			<div class="weui-cells noafter   mt0 background0">
				<div class="weui-cell noafter nobefore  mt0">
					<div class="weui-cell__bd">
						<p class="fz f28 color_4a mb02">邀请一个朋友</p>
						<p class="fz f20 color_gray999">每次奖励100<img class="img30" src="/images/my/ico_saipubi.png" alt=""> ，不限次数</p>
					</div>
					<div class="fz f28 color_gray666">
						<a href="javascript:void (0)" class="border-radius-img">去完成</a>
					</div>
				</div>
			</div>
		</li> -->
	</ul>
</div>
<!--日常任务 end-->
<!--===================本喵是分割线 喵喵~======================================================-->
<!--20px 的线-->
<div class="solidtop20"></div>
<!--===================本喵是分割线 喵喵~======================================================-->
<!--日常任务 start-->
<div class="rctask plr30">
	<h3 class="mb30 mt30 color_gray9b fz f24">日常任务</h3>
	<ul>
		<li>
			<div class="weui-cells noafter   mt0 background0">
				<div class="weui-cell noafter nobefore  mt0">
					<div class="weui-cell__bd">
						<p class="fz f28 color_4a mb02">关注微信公众号</p>
						<p class="fz f20 color_gray999">关注“赛普健身社区公众号”奖励</p>
						<p class="fz f20 color_gray999">500赛普币不定期还有独家福利</p>
					</div>
					<div class="fz f28 color_gray666">
						<a href="javascript:void (0)" class="border-radius-img foucswe">去完成</a>
					</div>
				</div>
			</div>
		</li>

	</ul>
</div>
<!--日常任务 end-->
<!--===================本喵是分割线 喵喵~======================================================-->
<!--查看赛普币更多规则 start-->
<div class="text_center  bgcolor_f9f9f9 pt40 pb100">
	<a href="/spb/rules" class="mt30 d-in-black fz f24 color_gray666">查看赛普币更多规则 >></a>
</div>
<!--查看赛普币更多规则 end-->
<!--===================本喵是分割线 喵喵~======================================================-->
<script type="text/javascript">
	$(function (){
    //弹窗
        $('.foucswe').click(function(){
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'bm_success_layer_wrap', //样式类名
                id: 'bm_success_layer', //设定一个id，防止重复弹出
                closeBtn: 0, //不显示关闭按钮
                anim: 2,
                shadeClose: true, //开启遮罩关闭
                area: ['80%', '70%'],
                content:'<div class="bm_success_layer text_center"><div class="mt30 pt30"><p class="lt bold color_333 f30">识别二维码</p><p class="fz color_gray666 f24 mt10">关注赛普健身社区公众号</p></div><img src="/images/qr.png" class="bm_success" alt="" /><div><p class="lt bold color_333 f30 mt10">更新实时提醒</p><p class="fz color_gray666 f24 mt20">不错过每一次的精彩</p></div></div>',
                btn:false
            });
        });
    })
</script>
@endsection