<?php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
		<title>{{$data->seo_title}}{{env('WEB_TITLE_COURSE')}}</title>
		<meta name="author" content="赛普课堂" />
		<meta name="description" content="{{$data->seo_description}}" />
		<link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
		<link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
		<link href="/css/reset.css" rel="stylesheet" type="text/css" />
		{{--<link href="/css/detail-flow.css" rel="stylesheet" type="text/css" />--}}
		<link href="/css/xueyuan-detail2.css?t=1" rel="stylesheet" type="text/css" />
		<!--mmenu.css start-->
		<link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
		<link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
		<link href="/css/nav-mmenu-public.css" rel="stylesheet" />
		<!--end-->
		<script src="/js/TouchSlide.1.1.js"></script>
		<script>
			(function(){
				var html = document.documentElement;
				var hWidth = html.getBoundingClientRect().width;
				html.style.fontSize=hWidth/18.75+'px';
			})()
		</script>
		<style type="text/css">
			.icon-bofang {
			    width: 2.3rem!important;
			    position: absolute;
			    top: 50%;
			    left: 50%;
			    margin-top: -1.2rem;
			    margin-left: -1.2rem;
			}
		</style>
		 @include('layouts.baidutongji')
		 <!-- 熊掌号搜索出图20181114海洋 -->
	    <script type="application/ld+json">
	        // {
	        //     "@context": "https://ziyuan.baidu.com/contexts/cambrian.jsonld",
	        //     "@id": "http://m.saipubbs.com/course/detail/{{$data->id}}.html",
	        //     "appid": "1615100668980398",
	        //     "title": "{{$data->title}}",
	        //     "images": [
	        //         "{{env('IMG_URL')}}{{$data->explain_url}}"
	        //     ], //请在此处添加希望在搜索结果中展示图片的url，可以添加1个或3个url
	        //     "pubDate": "{{substr($data->created_at,0, 10)}}T{{substr($data->created_at,-8)}}" // 需按照yyyy-mm-ddThh:mm:ss格式编写时间，字母T不能省去
	        // }
	    </script>

	</head>
<body ontouchstart>

<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->
<!--头部导航 start-->
        <div class="mh-head Sticky">
            <div class=" menu-bg-logo">
                <span class="mh-btns-left">
                    <a class="icon-menu icon-sousuo" href="/search"></a>
                </span>
                @if(is_weixin())
                    @if(!$user->mobile)
                        <span class="mh-btns-right active-a">
                           <a href="/register">注册</a>
                        </span>
                     @else
                        <span class="mh-btns-right active-a">
                           <a href="/user/task">任务</a>
                        </span>  
                    @endif
                @endif
                <span class="mh-btns-right">
                    <a class="icon-menu" href="#menu"></a>
                    <a class="icon-menu" href="#page"></a>
                </span>
            </div>
        </div>

        <!--隐藏导航内容-->
        <nav id="menu">
            <div class="text_center nav-a">
                <ul>
					<li><a href="/">首页</a></li>
					<li><a href="/article/0.html">文章</a></li>
					<li><a href="/cak/1.html">问答</a></li>
					<li><a href="/user/studying">我的课程</a></li>
					<li><a href="/user/index">我的</a></li>
                    <li><a href="javascript:history.go(-1);">返回</a></li>
					@if(!is_weixin())
						@if($user)
							<li><a href="/logout">退出</a></li>
						@else
							<li><a href="/login">登录</a></li>
						@endif
					@endif
                </ul>
            </div>
        </nav>
        <!--头部导航 end-->

<div class="bgc_white mb40">
	<!-- banner start -->
	@if(expericence_card_isture($data->course_type_id,$user_id) || $data->id==4)
		<div class="banner relative" onclick="window.location.href='/course/video/{{$data->id}}/{{$array[0]->course[0]->id}}.html'">
			<img src="{{env('IMG_URL')}}{{$data->explain_url}}" class="img100" alt="{{$data->title}}" />
			<img class="icon-bofang" src="/images/bofang.png" alt="">
		</div>
	@else
		@if($mobile == 0 && is_baoming($data->id,$user_id)==0)
			@if($data->is_free==0)
				@if($mobile==0)
				<div class="banner relative" onclick="userlogin()">
				@else
				<div class="banner relative" onclick="window.location.href='/course/video/{{$data->id}}/{{$array[0]->course[0]->id}}.html'">
				@endif	
					<img src="{{env('IMG_URL')}}{{$data->explain_url}}" class="img100" alt="{{$data->title}}" />
					<img class="icon-bofang" src="/images/bofang.png" alt="">
				</div>
			@else
				<div class="banner relative" onclick="userlogin()">
					<img src="{{env('IMG_URL')}}{{$data->explain_url}}" class="img100" alt="{{$data->title}}" />
					<img class="icon-bofang" src="/images/bofang.png" alt="">
				</div>
			@endif
		@else
			@if(is_baoming($data->id,$user_id) == 1)
				<div class="banner relative" onclick="window.location.href='/course/video/{{$data->id}}/{{$array[0]->course[0]->id}}.html'">
					<img src="{{env('IMG_URL')}}{{$data->explain_url}}" class="img100" alt="{{$data->title}}" />
					<img class="icon-bofang" src="/images/bofang.png" alt="">
				</div>
			@else
				@if($data->is_free==0 || $data->sum_video>1)
					<div class="banner relative" onclick="window.location.href='/course/video/{{$data->id}}/{{$array[0]->course[0]->id}}.html'">
						<img src="{{env('IMG_URL')}}{{$data->explain_url}}" class="img100" alt="{{$data->title}}" />
						<img class="icon-bofang" src="/images/bofang.png" alt="">
					</div>
				@else
					<div class="banner relative no_preview">
						<img src="{{env('IMG_URL')}}{{$data->explain_url}}" class="img100" alt="{{$data->title}}" />
						<img class="icon-bofang" src="/images/bofang.png" alt="">
					</div>
				@endif
			@endif
		@endif
	@endif

	<!-- banner end -->

	<!--本篇标题 start-->
	<div class="weui-cells xy-kecheng-tit mt0 noafter nobefore ">
		<div class="weui-cell">
			<div class="weui-cell__bd text-overflow ">
				<h1 class="lt text-overflow">{{$data->title}}</h1>
				<p class="color_gray666 fz">{{$data->sum_video}} 节课·{{$data->sum_people}} 人正在提高中</p>
			</div>
			@if(is_collect($data->id,$user_id) == 1)
			<div class="weui-cell__ft text_center">
				<div id="button_shoucang">
					<img  id="wei_shoucang" data-collect="1" src="/images/yishoucang.png" alt="已收藏课程" data-attr="{{$data->id}}" />
				</div>
			</div>
			@else
			<div class="weui-cell__ft text_center">
				<div id="button_shoucang">
					<img  id="wei_shoucang" data-collect="0" src="/images/shoucang.png" alt="未收藏课程" data-attr="{{$data->id}}" />
				</div>
			</div>
			@endif
		</div>
	</div>
	<!--本篇标题 end-->
<!-- <span class="baomingBtn" onclick="follow_us()">报名成功</span> -->
	<!-- 选项卡 start ================================ -->
	<div id="leftTabBox" class="tabBox">
		<div class="hd" id="nav_keleyi_com">
			<ul>
				<li><a href="javascript:void(0)" ><span>课程简介</span></a></li>
				<li><a href="javascript:void(0)"><span>课程目录</span></a></li>
				
			</ul>
		</div>

		<div class="bd" id="tabBox1-bd">
			<div class="con">

				<div style="" class="jianjie">
					<!--简介 start-->
					
					<div class="fz" >
						<?php
				               echo $data->introduction;
						?>
					</div>								
		
					<!--简介 end-->
				</div>
			</div>
			<div class="con">
                    <!--课程目录 start-->
                <div class="plr30">

                    <!--课程目录 start-->
                    <!-- Contenedor -->
                    <ul id="accordion" class="accordion">
                        @foreach($array as $k=>$v)
                        <li  class="f28  {{$k==0?" open":""}}">
                        	<div class="link bold ">
                        		<span class="pr20 color_gray666">{{$k+1}}</span>
                        		{{$v->title}}
                        		<i class="fa-chevron-down"></i>
                        	</div>
                            <ul class="submenu">
                            	@if($data->is_free==0 || is_baoming($data->id,$user_id) == 1 || expericence_card_isture($data->course_type_id,$user_id) == 1)
                            		@foreach($v->course as $a)
	                                <li class="pt20">
	                                	@if($a->course_content_id>0)
	                                		<!-- 跳转到对应课程图文 -->
											<a onclick="go_content('{{$data->id}}','{{$a->course_content_id}}');">
	                                	@elseif($a->video_url=="")
	                                    	<a onclick="layer.msg('视频暂未上线');">
	                                    @else
	                                    	@if($mobile==0)
	                                    	<a onclick="userlogin()">
											@else
											<!-- 跳转课程对应视频 -->
											<a onclick="go_video('{{$data->id}}','{{$a->id}}');">
											@endif
	                                    @endif	
	                                        <div class="weui-cells nobefore noborder noafter padding0 mt0">
	                    						<div class="weui-cell nobefore noborder noafter padding0 mt0">
	                        						<div class="weui-cell__hd">
	                        							@if($a->course_content_id>0)
	                        							<img src="/images/wenzhang.png" style="margin-top: 0;">
	                        							@else
														<img src="/images/ico_video.png" style="margin-top: 0;">
	                        							@endif
	                        						</div>
						                            <div class="weui-cell__bd f28 color_333 fz">
						                                <p class="text-overflow">{{$a->title}}</p>
						                            </div>
						                            <!-- <div class="weui-cell__ft mr20 pt10 pb10 fz color_333 f20 text_center border-radius-img v-shiting">试听</div> -->
	                                       		</div>
	                                       	</div>	
	                                    </a> 
	                                </li>
                                	@endforeach
                                @else
									@foreach($v->course as $a)
	                                <li class="pt20">
	                                	@if($a->preview)
		                                   	@if($a->course_content_id>0)
		                                		<!-- 跳转到对应课程图文 -->
												<a onclick="go_content('{{$data->id}}','{{$a->course_content_id}}');">
		                                	@elseif($a->video_url=="")
		                                    	<a onclick="layer.msg('视频暂未上线');">
		                                    @else
		                                    <a onclick="go_video('{{$data->id}}','{{$a->id}}');">
		                                    @endif	
	                                    @else
	                                    <a class="no_preview">
	                                    @endif	
	                                        <div class="weui-cells nobefore noborder noafter padding0 mt0">
	                    						<div class="weui-cell nobefore noborder noafter padding0 mt0">
	                        						<div class="weui-cell__hd">
	                        							<img src="/images/ico_video.png" style="margin-top: 0;">
	                        						</div>
						                            <div class="weui-cell__bd f28 color_333 fz">
						                                <p class="text-overflow">{{$a->title}}</p>
						                            </div>
						                            @if($a->preview)
						                            <div class="weui-cell__ft mr20 pt10 pb10 fz color_333 f20 text_center border-radius-img v-shiting">试听</div>
						                            @endif
	                                       		</div>
	                                       	</div>	
	                                    </a> 
	                                </li>
                                	@endforeach
                                @endif
                     		</ul>
                        </li>
                        @endforeach                          
                    </ul>
                    <!--课程目录 end-->
                </div>
                    <!--课程目录 end-->
                </div>
            </div>
        </div>
			
		</div>
	</div>
	<!-- 选项卡 end ================================ -->

<div class="bottomheightgrey mtb23"></div>

	<!--作者名片 start-->
	<div class="afterleftright075">
		<div class="weui-cells mt0 daoshi-tit nobefore noafter clearfix">
			<a class="weui-cell weui-cell_access fl" href="/user/teacher/{{$data->user_id}}/1.html">
				<div class="weui-cell__hd">
					@if($data->avatar)
						@if(strpos($data->avatar,'http') !== false)
							<img class="border-radius50" src="{{$data->avatar}}">
						@else
							<img class="border-radius50" src="{{env('IMG_URL')}}{{$data->avatar}}">
						@endif
					@else
					<img class="border-radius50" src="/images/my/nophoto.jpg" alt="" />
					@endif
				</div>
				<div class="weui-cell__bd text-overflow">
					<h2 class="lt">{{$data->teacher_name}} 导师</h2>
					<p class="fz text-overflow color_gray666">{{$data->teacher_inc}}</p>
				</div>
				
				
			</a>

		</div>
	</div>
	<!--作者名片 end-->
	

</div>
</div>
<br/>
<br/>
<br/>
<!-- 底部固定条 start -->
<div class="fixed_bar_bottom">
	<ul class="clearfix btnsWrap">
		@if(expericence_card_isture($data->course_type_id,$user_id) || $data->id==4)
			<li class="studyBtn">
				<a href="/course/video/{{$data->id}}/{{$array[0]->course[0]->id}}.html">进入课程</a>
			</li>
		@else
			@if($mobile == 0 && is_baoming($data->id,$user_id)==0)
	        	@if($data->is_free==0)
	        		<li class="studyBtn" onclick="userlogin()">
	        			<a href="javascript:;">免费报名</a>
	        		</li>
				@else
					<li class="studyBtn open-popup" onclick="userlogin()">
						<a href="javascript:;" id="studyBtn" onclick="userlogin()">立即报名</a>
					</li>
				@endif
			@else
				@if(is_baoming($data->id,$user_id) == 1)
					@if($mobile==0)
					<li class="studyBtn">
						<a href="javascript:;" onclick="userlogin()">进入课程</a>
					</li>
					@else
					<li class="studyBtn">
						<a href="/course/video/{{$data->id}}/{{$array[0]->course[0]->id}}.html">进入课程</a>
					</li>
					@endif
				@else
					@if($data->is_free==0)
						<li class="studyBtn">
							<a href="javascript:;" id="enroll">免费报名</a>
						</li>
					@else
						<li class="studyBtn open-popup" data-target="#half" id="studyBtn">
							<a>立即报名</a>
						</li>
					@endif
				@endif
			@endif
		@endif
	</ul>
</div>
<!-- 底部固定条 end -->

<!-- 底部弹出popup start -->
<div id="half" class='weui-popup__container popup-bottom payType_popup'>
    <div class="weui-popup__overlay"></div>
    <div class="weui-popup__modal">
        <div class="toolbar">
            <div class="toolbar-inner">
                <a href="javascript:;" class="picker-button close-popup">关闭</a>
                <h1 class="title">确认付款</h1>
            </div>
        </div>
        <div class="modal-content bgc_white">
			<div class="weui-cell  weui-cell">
				<div class="weui-cell__bd">
					<h2 class="fs14">课程费用</h2>
				</div>
				<div class="weui-cell__ft">
					<span class="price">{{$data->price-$couponPrice}}元</span>
				</div>
			</div>
			@if($hasCoupon)
			<div class="weui-cell weui-cell">
				<div class="weui-cell__bd">
					<h2 class="f28">优惠劵</h2>
				</div>
				<div class="weui-cell__ft color_red">
					-<span class="price">{{$couponPrice}}元</span>
				</div>
			</div>
			@endif
			<div class="weui-cells weui-cells_radio noafter">
				<label class="weui-cell weui-check__label" for="x11">
					<div class="weui-cell__bd">
						<p><i class="ico_wx"></i>微信支付</p>
					</div>
					<div class="weui-cell__ft">
						<input type="radio" class="weui-check" name="radio1" id="x11" value="WXPAY" checked />
						<span class="weui-icon-checked"></span>
					</div>
				</label>
				@if($balance)
				<label class="weui-cell weui-check__label" for="x12">
				@else
				<label class="weui-cell weui-check__label disabled_xueyuan" for="x12">
				@endif
					<div class="weui-cell__bd">
						<p><i class="ico_balance"></i>余额支付</p>
					</div>
					<div class="weui-cell__ft">
						<input type="radio" name="radio1" class="weui-check" id="x12" value="BANLANCE">
						<span class="weui-icon-checked"></span>
					</div>
				</label>
				@if($spb/100 > $data->price)
				<label class="weui-cell weui-check__label" for="x13">
				@else
				<label class="weui-cell weui-check__label disabled_xueyuan" for="x13">
				@endif
					<div class="weui-cell__bd">
						<p><i class="ico_spb"></i>{{$data->price * 100}}赛普币(已有{{$spb}}赛普币)</p>
					</div>
					<div class="weui-cell__ft">
						<input type="radio" name="radio1" class="weui-check" id="x13" value="SPB">
						<span class="weui-icon-checked"></span>
					</div>
				</label>
			</div>
			<div class="container pt15 pb15">
				<a href="javascript:void(0);" class="roy_btn bgc_yellow payBtn" data-is_weixin="{{$is_weixin}}">立即付款</a>
			</div>
        </div>
    </div>
</div>
<!-- 底部弹出popup end -->

<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
  $(function() {
    FastClick.attach(document.body);
  });

</script>
<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<!--<script src="/js/jweixin-1.4.0.js"></script>-->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="/js/fonts.js?t={{time()}}"></script>
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
	<?php
		$content = explode(PHP_EOL,$data->seo_description);
		$art = '';
		foreach($content as $cont){
			$art .= trim($cont);
		}
	?>
	wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
		wx.onMenuShareAppMessage({
			title: '{{$data->title}}', // 分享标题
			desc: '{{$art}}', // 分享描述
			link: "http://m.saipubbs.com/course/detail/{{$data->id}}.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
			imgUrl: "{{env('IMG_URL')}}{{$data->cover_url}}", // 分享图标
		}, function(res) {
		//这里是回调函数
		});
	});
	wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
		wx.onMenuShareTimeline({
			title: '{{$data->title}}', // 分享标题
			link: "http://m.saipubbs.com/course/detail/{{$data->id}}.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
			imgUrl: "{{env('IMG_URL')}}{{$data->cover_url}}", // 分享图标
		}, function(res) {
		//这里是回调函数
		});
	});

	//温馨提示弹窗
	var date = new Date();
	Y = date.getFullYear();

	M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1);
	D = date.getDate() < 10? '0'+(date.getDate()): date.getDate();
	var dateTime = Y+''+M+''+D;
	var isDiscard = 'subscribeCode_'+dateTime;
	var isShow = localStorage.getItem('subscribeCode_'+dateTime);
	Day = date.getDate()-1 < 10? '0'+(date.getDate()-1): date.getDate()-1;
	removeTime = Y+''+M+''+Day;
	var removeSubscribe = 'subscribeCode_'+dateTime;
	function follow_code(){
		layer.open({
			type: 1,
			title: false, //不显示标题栏
			skin: 'wenxintishi_layer_wrap', //样式类名
			id: 'wenxintishi_layer', //设定一个id，防止重复弹出
			closeBtn: 1, //不显示关闭按钮
			shift: 2,
			shadeClose: false, //开启遮罩关闭
			area: ['90%', '60%'],
			content:'<div class="wenxintishi_layer"><div class="container clearfix"><img src="/images/qr.png" /><dl><dt><span class="btn_wxts">温馨提示</span></dt><dd>扫码关注</dd><dd>「赛普健身社区」</dd><dd>享受课程实时提醒</dd></dl></div></div>',
			btn:false,
			//给遮罩新加一个类以免样式重复
			success: function (layero,index) {
				console.log(layero);
				$("#layui-layer-shade1").addClass('myshade')
			},
			cancel:function(){
				localStorage.setItem(isDiscard,1);
//				$('html').removeClass('htmlH100');
			}
		});
	}
	var subscribe_cur = "{{$subscribe}}";
	if(isShow != 1 && subscribe_cur !=1){
		setTimeout(follow_code, 1000);
	}

</script>
<script>
	var user_id   = "{{$user_id}}";      //用户id
	var c_c_id    = "{{$data->id}}";     //课程id
	var is_weixin = "{{$is_weixin}}";  //是否为微信浏览器
	var token     = '{{csrf_token()}}';
	var video_id  = "{{$array[0]->course[0]->id}}";
	var mobile    = "{{$mobile}}";
	var subscribe = "{{$subscribe}}";
	console.log(subscribe+"是否关注");
	//将裂变者id写入本地  用于存储上下级关系
	var fission_id = "{{$fission_id}}";
    if(fission_id>0){
        localStorage.setItem("fission_id", fission_id);
    }
	console.log(localStorage.getItem('fission_id')+"裂变者id");
	console.log("course"+c_c_id+"channel");
	//将注册来源页面写入存储
    localStorage.setItem("channel", "course"+c_c_id);

	//免费报名成功或者购买成功后跳转
	function href_go(){
		//判断是否关注公众号如果未关注跳转引导页
		if(subscribe!=1) {
			layer.open({
				type: 1,
				title: false, //不显示标题栏
				skin: 'wenxintishi_layer_wrap', //样式类名
				id: 'wenxintishi_layer', //设定一个id，防止重复弹出
				closeBtn: 1, //不显示关闭按钮
				shift: 2,
				shadeClose: false, //开启遮罩关闭
				area: ['90%', '60%'],
				content: '<div class="wenxintishi_layer"><div class="container clearfix"><img src="/images/qr.png" /><dl><dt><span class="btn_wxts">温馨提示</span></dt><dd>扫码关注</dd><dd>「赛普健身社区」</dd><dd>享受课程实时提醒</dd></dl></div></div>',
				btn: false,
				//给遮罩新加一个类以免样式重复
				success: function (layero, index) {
					console.log(layero);
					$("#layui-layer-shade1").addClass('myshade')
				},
				cancel: function () {
					location.href = "/course/video/" + c_c_id + "/" + video_id + ".html";
				}
			});
		}else{
			location.href = "/course/video/" + c_c_id + "/" + video_id + ".html";
		}
//		if(subscribe==1){
//			location.href="/course/video/"+c_c_id+"/"+video_id+".html";
//		}else{
//			location.href="/course/middle/"+c_c_id+"/"+video_id;
//		}

	}

	//跳转登陆函数
	var userlogin = function(){
		var url = "/course/detail/"+c_c_id+".html";
		localStorage.setItem("redirect", url);

		layer.msg('请先注册');
		setTimeout(function(){
			window.location.href = "/register";
		}, 500)
	}



	//调用微信JS api 支付
	function jsApiCall()
	{
		var _token = '{{csrf_token()}}';
		var data = {class_id:c_c_id,_token:_token};
		$.ajax({
			url:'/course/buy',
			data:data,
			type:'POST',
			dateType:'json',
			success:function(res){

				if(res.code != 0){
					layer.msg(res.message);
					return false;
				}else{
					var data = res.data;
				}
				WeixinJSBridge.invoke(
						'getBrandWCPayRequest',
						data,
						function(res){
							WeixinJSBridge.log(res.err_msg);
							if(res.err_msg=='get_brand_wcpay_request:ok'){
								layer.msg('支付成功');
								href_go();     //支付成功跳转
							}else{
								layer.msg('取消支付');
							}
						}
				);
			}
		})

	}
	//关注公众号函数
	var follow_us = function(){
		layer.open({
			type: 1,
			title: false, //不显示标题栏
			skin: 'bm_success_layer_wrap', //样式类名
			id: 'bm_success_layer', //设定一个id，防止重复弹出
			closeBtn: 0, //不显示关闭按钮
			anim: 2,
			shadeClose: true, //开启遮罩关闭
			area: ['80%', '70%'],
			content:'<div class="bm_success_layer"><img src="/images/bm_success.png" class="bm_success" alt="" /><dl><dt><img src="/images/qr.png" alt="" /></dt><dd>扫描二维码获得课程提醒</dd></dl><a href="/course/video/'+c_c_id+'/'+video_id+'.html">关闭</a></div>',
			btn:false
		});
	}
$(function (){
	//折叠面板
	$('#accordion .link').click(function (){
        if($(this).parents('li').hasClass('open')){
            $('#accordion >li').removeClass('open')
            /*return false;*/
        }else{
            $(this).parents('li').addClass('open').siblings().removeClass('open');
            $(this).find('i').addClass('up').parents('.item').siblings().find('i').removeClass('up');
        }
        var h=$('#accordion').height()
        //console.log($('.open .submenu').height())
        $('.tempWrap').height(h)
     })
	//不支持试看视频
	$(".no_preview").click(function(){
		$.closePopup()
			$.confirm({
				title: '提示',
				text: '立即购买学习该课程，确认购买吗？',
				onOK: function () {

					$('#studyBtn').trigger('click');
				},
				onCancel: function (){

				}
			});

	});

	//立即付款弹出框
	$('.payBtn').click(function (){
		var payfrom = $("input[name='radio1']:checked").val();
		if(payfrom=='BANLANCE'){
			$.closePopup()
			$.confirm({
				title: '提示',
				text: '立即购买学习该课程，确认购买吗？',
				onOK: function () {
					//点击确认
					$.ajax({
						type:"GET",
						url:"/course/paybalance",
						data:{c_c_id:c_c_id, user_id:user_id},
						dataType:"json",
						success:function(result){
							if(result.code==1){
								layer.msg(result.msg);
								setTimeout(function(){
									href_go();     //支付成功跳转
								},1500)  //延迟1.5秒刷新页面
							}else{
								layer.msg(result.msg);
							}
			            }
					});
				},
				onCancel: function (){
				}
			});
		}else if(payfrom=="WXPAY"){
			//alert(is_weixin);
			if(is_weixin==1){
				jsApiCall();
//				layer.msg('微信浏览器');
			}else{
				$.ajax({
					type:"POST",
					url:"/course/payh",
					data:{course_class_id:c_c_id,_token:token},
					dataType:"json",
					success:function(result){
						if(result.code==1){
							console.log(result.objectxml.mweb_url);
							//follow_us();
							window.location.href=result.objectxml.mweb_url;   //h5呼叫微信支付
						}else{
							layer.msg(result.msg);
						}
		            }
				});
			}
		}else if(payfrom == "SPB"){
			$.closePopup()
			$.confirm({
				title: '提示',
				text: '立即购买学习该课程，确认购买吗？',
				onOK: function () {
					$.ajax({
						type:"get",
						url:"/course/paySpb",
						data:{c_c_id:c_c_id,user_id:user_id},
						dataType:"json",
						success:function(data){
								console.log(data);
								if(data.code == 1){
									layer.msg(data.msg);
									setTimeout(function(){
										href_go();     //支付成功跳转
									},1500)  //延迟1.5秒刷新页面
								}else{
									layer.msg(data.msg);
								}
						}


					})
				},
				onCancel: function (){
				}
			});
		}

	})

	//收藏课程或取消收藏  20180827
	$("#wei_shoucang").click(function(){
		var id = $("#wei_shoucang").attr("data-attr");
		//var user_id = '{{$user_id}}';
		if(mobile<1){
			userlogin();  //跳转登陆
			return;
		}
		var is_collect = $("#wei_shoucang").attr("data-collect");
		if(id){
			if(is_collect==1){
				$.get("/course/nocollect",{course_class_id:id,user_id:user_id},function(result){
					if(result){
						//$("#wei_shoucang").removeAttr("data-attr");
						$("#wei_shoucang").attr("src", "/images/shoucang.png");
						$("#wei_shoucang").attr("data-collect", "0");
						layer.msg('已取消');
					}
				})
			}else{
				$.get("/course/collect",{course_class_id:id,user_id:user_id},function(result){
					if(result){
						//$("#wei_shoucang").removeAttr("data-attr");
						$("#wei_shoucang").attr("src", "/images/yishoucang.png");
						$("#wei_shoucang").attr("data-collect", "1");
						layer.msg('已收藏');
					}
				})
			}
		}
	});

	//免费报名课程
	$("#enroll").click(function(){
		var id = '{{$data->id}}';
		var user_id = '{{$user_id}}';
		$.get("/course/enroll",{course_class_id:id,user_id:user_id},function(result){
			if(result == 0){
				layer.msg('报名成功');

				setTimeout(function(){
					href_go();     //支付成功跳转
				},1500)  //延迟1.5秒
			}else{
				layer.msg('网络错误，稍后请重试');
			}
		})
	})
})
</script>

<script>
	//跳转到课程播放页面
	var go_video  = function (c_c_id, video_id){
		window.location.href="/course/video/"+c_c_id+"/"+video_id+".html";
	}

	//跳转到课程图文页面
	var go_content  = function (c_c_id, content_id){
		window.location.href="/course/content/"+c_c_id+"/"+content_id+".html";
	}
</script>
<script type="text/javascript" >
	function menuFixed(id){
		var obj = document.getElementById(id);
		var _getHeight = obj.offsetTop;

		window.onscroll = function(){
			changePos(id,_getHeight);
		}
	}
	function changePos(id,height){
		var obj = document.getElementById(id);
		var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
		if(scrollTop < height){
			obj.style.position = 'relative';
		}else{
			obj.style.position = 'fixed';
		}
	}
</script>
<script type="text/javascript">
	window.onload = function(){
		menuFixed('nav_keleyi_com');
	}
</script>

<script type="text/javascript">

	TouchSlide({ slideCell:"#leftTabBox",
	        endFun:function(i){ //高度自适应
	            var bd = document.getElementById("tabBox1-bd");
	            bd.parentNode.style.height = bd.children[i].children[0].offsetHeight+"px";
	            if(i>0)bd.parentNode.style.transition="200ms";//添加动画效果

	        }
      	});
	// 图片地址 后面加时间戳是为了避免缓存
var html = document.documentElement;
var hWidth = html.getBoundingClientRect().width;
var img_url_define = $('.jianjie img').attr('src');
var img_url = $('.jianjie img').attr('src')+'?'+Date.parse(new Date());
if(img_url_define !== undefined){
	// 创建对象
	//var img = new Image();
	// 改变图片的src
	//img.src = img_url;
	// 加载完成执行
	//img.onload = function(){
		//var h1=Math.ceil(hWidth/(img.width/img.height));
		//$('.tempWrap').height(h1)
	//}
}


/*var h2=$('.jianjie img').eq(0).height();
 $('.tempWrap').height(h2)*/
  //  window.onload = function () {
  //  		var h=$('#leftTabBox .bd .con').eq(0).height();
		// $('.tempWrap').height(h);
      	
  //  }

	//执行关注操作
function click_follow(e){

		var fans_id = e.getAttribute("data-fans_id");
		var user_id = e.getAttribute("data-user_id");
		var fansid  = e.getAttribute("id");
		var is_follow = e.getAttribute("data-is_follow");
		
		var token     = '{{csrf_token()}}';
		// if(is_follow==1){
		// 	layer.msg('您已关注,无需重复操作');
		// 	return;
		// }
		$.ajax({
			type:"POST",
			url:"/user/followadd",
			data:{fans_id:fans_id, user_id:user_id,_token:token,is_follow:is_follow},
			dataType:"json",
			success:function(result){
				if(result.code==1){
					layer.msg('操作成功');
					document.getElementById(fansid).setAttribute('data-is_follow', 1);
					document.getElementById(fansid).innerHTML='已关注';
				}else{
					layer.msg(result.msg);
					document.getElementById(fansid).setAttribute('data-is_follow', 0);
					document.getElementById(fansid).innerHTML='关注';

				}
			}
		});
	}

</script>
</body>
</html>
