@extends('layouts.header_no_menu')
@section('title')
<title>{{$data->title}}{{env('WEB_TITLE')}}</title>
<meta name="author" content="啾啾" />
<meta name="keywords" content="{{$data->seo_title}}" />
<meta name="description" content="{{$data->seo_description}}" />
@endsection

@section('cssjs')

	<!--分享下css-->
	<link rel="stylesheet" href="/css/share.css?t={{time()}}">

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



	<div class="plr30"><!--边距30 开始-->

@if($data->is_video == 0)



		<img src="{{env('IMG_URL')}}{{$data->cover_url}}" alt="">


		<div class="pt40">
			<!--头部文章标题-->
			<h3 class="f36 lt mb20">{{$data->title}}</h3>
			<div class="weui-cells  nobefore mt0 share-title pb40">
				<div class="weui-cell padding0">
					<div class="weui-cell__bd fz f20 color_gray9b watch-img">
						<span class="f22 mr20">{{substr($data->created_at,0, 10)}}</span>
						<span class="pl20"><img src="/images/icon-xiao-xihuan.png" alt="">{{$data->likes}}</span>
						<span class="pl20"><img src="/images/icon-xiao-yuedu.png" alt="">{{$data->views}}</span>
					</div>
				</div>
			</div>
		</div>



		<!--文章本章没错了 start-->
		<div class="share-detail pt40 pb40">
			<div class="text-jus f30 color_333 fz"> <!-- text-indent1-6 -->
				<p>
					<?php
	                  echo  htmlspecialchars_decode($data->content)
	                ?>
				</p>
			</div>
		</div>
		<!--文章本章没错了 end-->


@elseif($data->is_video == 1)

	<!-- <video id="video" src="{{$data->video_url}}" onclick="" controls="controls" controlsList="nodownload"  style="width:100%;height:200px;" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto" x5-video-player-type="h5" x5-video-player-fullscreen="true" x5-playsinline="playsinline" playsinline="playsinline">
				您的浏览器不支持 video 标签。
		</video> -->
<div class="">
{{--@if(!isset($mobile->mobile))--}}
    {{--<div class="box2" id="nav">--}}
        {{--<div class="mask"></div>--}}
    {{--</div>--}}
{{--@endif--}}
    {{--<video id="video" src="{{$data->video_url}}" poster="{{env('IMG_URL')}}{{$data->cover_url}}" onclick="" controlsList="nodownload"  style="width:100%;height:200px;" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto" x5-video-player-type="h5" x5-video-player-fullscreen="true" x5-playsinline="playsinline" playsinline="playsinline">--}}
				{{--您的浏览器不支持 video 标签。--}}
	{{--</video>--}}
@if(!isset($mobile->mobile))
	<div class="video border-radius-img" id="nav">
		<div class="box2 ">
			<img src="{{env('IMG_URL')}}{{$data->cover_url}}" alt=""/>
			<div class="mask"></div>
			<span class="btn_play"></span>
		</div>

	</div>
	@else
		<div class="video border-radius-img">
			<div class="box2 ">
				<img src="{{env('IMG_URL')}}{{$data->cover_url}}" alt=""/>
				<div class="mask"></div>
				<span class="btn_play"></span>
			</div>
			<video id="video" src="{{$data->video_url}}" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto" ></video>
		</div>
		<script>
			//播放视频
			$(function (){
				//播放视频
				$('.video .box2').click(function(){
					$(this).hide();
					$(this).next().trigger('play');

				})
			})

		</script>
@endif

</div>

		<div class="pt40">
			<!--头部文章标题-->
			<h3 class="f36 lt mb20">{{$data->title}}</h3>
			<time datetime="{{$data->created_at}}" pubdate="pubdate"></time>
			<div class="weui-cells  nobefore mt0 share-title pb40">
				<div class="weui-cell padding0">
					<div class="weui-cell__bd fz f20 color_gray9b watch-img">
						<span class="f22 mr20">{{substr($data->created_at,0, 10)}}</span>
						<span class="pl20"><img src="/images/icon-xiao-xihuan.png" alt="">{{$data->likes}}</span>
						<span class="pl20"><img src="/images/icon-xiao-yuedu.png" alt="">{{$data->views}}</span>
					</div>
				</div>
			</div>
		</div>



		<!--文章本章没错了 start-->
		<div class="share-detail pt40 pb40">
			<div class="text-jus text-indent1-6 f30 color_333 fz">
				
					<?php
	                  echo  htmlspecialchars_decode($data->content)
	                ?>
                
			</div>
		</div>
		<!--文章本章没错了 end-->
@endif
	</div><!--边距30 结束-->
	<!--我是灰色的线-->
	<div class="solidtop20"></div>


	<div class="mlr30"  id="form"><!--边距30 开始-->
@if(empty($mobile->mobile))
		<div class="text_center pt80">
			<h2 class="f52 pb13">登录赛普健身社区</h2>
			<p class="f36 fz">即可观看视频</p>
		</div>


<form action="/auth/login" method="post">
		{{csrf_field()}}
		<!--表单 start-->
		<div class="bgcolor_f9f9f9 mt80 border-radius-img">

			<div class="pt60 plr45">
				<div class="weui-cells  noafter nobefore mt0 padding0 bgcolor_f9f9f9">
					<div class="weui-cell weui-cell_access padding0">
						<div class="weui-cell__bd f40 bold color_gray666">
							<p>登陆</p>
						</div>
						<div class="weui-cell__ft f26 color_gray666 fz">
							<a href="/special/indexRegister/{{$data->id}}/{{$sid}}.html#form">立即注册</a>

						</div>
					</div>
				</div>

				<div class="form fz f24 clearfix mb30 mtb45">
					<ul>
						<li>
							<div class="input">
								<input type="text" id="tel" placeholder="请输入您的手机号码" name="tel" class="input border-radius-img f30  fz bgcolor_fff mb30">
								<p class="text_left tip mobile_error"></p>
							</div>
						</li>
						<li>
							<div class="input">
								<input type="text" id="password" placeholder="请输入密码" name="password" class="input border-radius-img f30  fz bgcolor_fff mb30">
								<p class="text_left tip passwd_error"></p>
							</div>
						</li>
					</ul>

					<!--按钮-->

				{{--	<button type="button" onclick="userLogin();" >登陆观看视频</button>--}}

						<button  onclick="userLogin();" class="border-radius-img btn  color_333 f34 fz bgcolor_orange text_center  mt30" type="button">登陆观看视频
						</button>

				</div>
				<?php

					$data_arr = DB::table("special")->where("id",$sid)->select("result")->first();
					$str = explode("，",$data_arr->result);

				?>
				<!--气泡 start-->
				<div class="bg-qipao text_center mb80">
					<p class="color_333  bgcolor_orange f26 border-radius50 mb26">登录赛普健身社区还可获得：</p>
					@foreach($str as $v)
						<span class="text_left color_gray666 f30 fz bold"><i class="pr12 color_orange">•</i>{{$v}}</span>
					@endforeach
				</div>
				<!--气泡 end-->
			</div>

			<img src="/images/share/img-b.png" alt="">
		</div>
		<!--表单 end-->

</form>
@else

		<div class="huode mt30 border-radius">
			<img src="/images/mianfei.png" alt="">
			<h3 class="text_center f36 fz bold pt80 mt16">关注赛普健身社区还可以获得</h3>

			<ul class="text_left f32 fz mb80">
				<li class="pb40 mb10 mt80">器械动作训练22讲</li>
				<li class="pb40 mb10">趣味减脂训练12讲</li>
				<li class="pb40 mb10">孕产教练入门：产后恢复30讲</li>
				<li class="pb40 mb10">增肌/营养/解剖等免费内容</li>
			</ul>
		</div>
		<!--表单 start-->
		<div class="bgcolor_f9f9f9 mt30 border-radius-img"  id="form">

			<div class="pt20 plr45">

				<div class="text_center pt80">
					<p class="f36 fz bold">您已登陆成功</p>

					<img class="pt60 imgw pb40" src="/images/share/share-er.png" alt="">

					<p class="mb80 f28 color_333 fz">快来扫码关注公众号免费领取<br>
						更多健身相关学习资料</p>
				</div>

			</div>

		</div>
		<!--表单 end-->
@endif
	</div><!--边距30 结束-->










</div><!--导航大盒子id=page 结束-->
<script src="/js/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
    var redirect = '{{$redirect}}';
    var localUrl = localStorage.getItem('redirect');
    if(redirect != ''){
        localStorage.setItem('redirect',redirect);
    }else{
        localStorage.setItem('redirect','/');
    }
    if(localUrl != '' && localUrl != null){
        localStorage.setItem('redirect',localUrl);
    }
    $(function() {
        FastClick.attach(document.body);
    });

    function userLogin(){
        //gio('track', 'register');   //growing  统计代码
        var mobile = $("#tel").val();
        var token = '{{csrf_token()}}';
        var password = $('#password').val();

        if(!mobile || !/13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}$/.test(mobile)){
            $(".mobile_error").text('请输入有效的手机号码');
            return false;
        }else{
            $(".mobile_error").text('');
        }
        if(password.length < 6 || password.length > 20){
            $(".passwd_error").text('密码必须在6-20位字符之间');
            return;
        }else{
            $(".passwd_error").text('');
        }

        var data = {mobile:mobile,password:password};
////		alert("数据1"+data);
//        var data = {mobile:'13301372956',password:'123456',_token:token};

        $.ajax({
            url:'/api/ureserve',
            type:'get',
            data:data,
            dataType:'json',
			async: false, //加上之后不在跳转进error
            success:function(data){
            	//layer.msg(1111);
                if(data.code == 0){
					 layer.msg("登录成功");
					 window.location.reload();
//                    var url = localStorage.getItem('redirect');
//                    if(url !=''){
//                        localStorage.removeItem('redirect');
//                        window.location.href = url;
//
//                    }else{
//                        window.location.href = '/';
//                    }
                }else if(data.code == 1){
                    $(".mobile_error").text(data.message);
                }else if(data.code == 2){
                    $(".passwd_error").text(data.message);
                }else if(data.code == 3){
                    $(".passwd_error").text(data.message);
                }
            },error:function(XMLHttpRequest, textStatus, errorThrown){
				alert("错误代码："+XMLHttpRequest.status);
				alert("错误代码："+XMLHttpRequest.readyState);
				alert("错误代码："+textStatus);
			}
        });
    }


    //监听视频播放

 $('#nav').on('click',function(e){
     
     $('html,body').animate({scrollTop:$('#'+'form').offset().top}, 500);
 });

	//将裂变者id写入本地  用于存储上下级关系
	var fission_id = "{{$fission_id}}";
	if(fission_id>0){
		localStorage.setItem("fission_id", fission_id);
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

	wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
		wx.onMenuShareAppMessage({
			title: "{{$data->title}}", // 分享标题
			desc: "{{$data->seo_description}}", // 分享描述
			link: "http://m.saipubbs.com/special/indexRegister/{{$data->id}}/{{$sid}}.html?fission_id={{$userid}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
			imgUrl: "{{env('IMG_URL')}}{{$data->cover_url}}", // 分享图标
		}, function(res) {
			//这里是回调函数
			alert("分享好友成功");
		});
	});
	wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
		wx.onMenuShareTimeline({
			title: "{{$data->title}}", // 分享标题
			link: "http://m.saipubbs.com/special/indexRegister/{{$data->id}}/{{$sid}}.html?fission_id={{$userid}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
			imgUrl: "{{env('IMG_URL')}}{{$data->cover_url}}", // 分享图标
		}, function(res) {
			//这里是回调函数
		});
	});
</script>
<br><br><br>
@endsection
