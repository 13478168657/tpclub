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
			<div class="text-jus f30 color_333 fz"><!-- text-indent1-6 -->
				<p><?php
	                  echo  htmlspecialchars_decode($data->content)
	                ?></p>
			</div>
		</div>
		<!--文章本章没错了 end-->

@elseif($data->is_video == 1)

<div class="">
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


	<div class="mlr30"  id = "form"><!--边距30 开始-->

@if(empty($mobile->mobile))
		<div class="text_center pt80">
			<h2 class="f52 pb13 cur_ceshi">登录赛普健身社区</h2>
			<p class="f36 fz">即可观看视频</p>
		</div>


<form action = "" method="post" id ="regForm">
		<!--表单 start-->
		<div class="bgcolor_f9f9f9 mt80 border-radius-img">

			<div class="pt60 plr45">
				<div class="weui-cells  noafter nobefore mt0 padding0 bgcolor_f9f9f9">
					<div class="weui-cell weui-cell_access padding0">
						<div class="weui-cell__bd f40 bold color_gray666">
							<p>注册</p>
						</div>
						<div class="weui-cell__ft f26 color_gray666 fz">
							<a href="/special/indexLand/{{$data->id}}/{{$sid}}.html#form">已有账户登录</a>

						</div>
					</div>
				</div>

				<div class="form fz f24 clearfix mb30 mtb45">
					<ul>
						<li>
							<div class="input">
								<input type="text" id="tel" placeholder="请输入您的手机号码" class="input border-radius-img f30  fz bgcolor_fff mb30">
								<p class="text_left tip mobile_error"></p>
							</div>
						</li>
						{{--<li>
							<div class="input clearfix">
								<input type="text" name="imgCode" placeholder="请输入右侧图片上的文字" class="ipt vcode" />
								<span class="weui-btn icma" onclick="changeCode()"><img src='{{captcha_src()}}'/></span>
							</div>
							<div class="tip"></div>
						</li>--}}
						<!-- <li>
							<div class="input clearfix">
								<input type="text" id="code" name="imgCode" placeholder="请输入图文验证码" class="ipt vcode input border-radius-img f30  fz bgcolor_fff mb30 yzm fl">
								<span class="fr border-radius-img text_center f28 color_333 icma" onclick="changeCode()"><img src='{{captcha_src()}}'/></span>

							</div>

							<p class="text_left tip code_error"></p>
						</li> -->
						<li>
							<div class="input clearfix">
								<input type="text" id="code" placeholder="请输入您的验证码" class="ipt vcode input border-radius-img f30  fz bgcolor_fff mb30 yzm fl">
								<span class="vcodeBtn fr bgcolor_orange border-radius-img text_center f28 color_333 weui-btn">获取验证码</span>
							</div>
								
							<p class="text_left tip code_error"></p>
						</li>
						 <input type="hidden" name="openid" value="{{$openid}}" />
						<li>
							<div class="input">
								<input type="text" id="password" placeholder="设置新密码" class="input border-radius-img f30  fz bgcolor_fff mb30">
								<p class="text_left tip passwd_error"></p>
							</div>
						</li>
					</ul>

					<!--按钮-->
					<button  {{--onclick="userRegister();"--}} id="submit_yaya" type="button" class="border-radius-img btn  color_333 f34 fz bgcolor_orange text_center  mt30">立即注册观看视频<!-- class="border-radius-img btn  color_333 f34 fz bgcolor_orange text_center  mt30"-->
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
<br><br><br>
<!-- <script src="/lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/icheck/js/icheck.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/js/js.js"></script> -->
<!--end-->
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/js/js.js"></script>

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
<script>
    var redirect = '{{$redirect}}';
	localStorage.setItem('redirect',redirect);

    // $(function() {
    //     FastClick.attach(document.body);
    // });

    $(document).ready(function(){
    	$(".cur_ceshi").click(function(){
    		layer.msg(1111);
    		$.ajax({
                url:'/api/ureserve',
                type:'get',
                data:{aa:"111",bb:"22"},
                dataType:'json',
                success:function(res){
                        layer.msg(res);
                }
            });
    	});
    });


    $(function(){
        //发送验证码
        $('.vcodeBtn').click(function (){
			// var imgCode = $("input[name='imgCode']").val();
			// if(imgCode == ''){
			// 	layer.msg('请输入图文验证码');
			// 	return false;
			// }
            var tel = $('#tel').val();
            if(!tel || !/13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}|16[0-9]{9}$/.test(tel)){
                layer.msg('请输入有效的手机号码');
            }else{
                var token = '{{csrf_token()}}';
                var mobile = $("#tel").val();
                var data = {mobile:mobile ,_token:token};
                $.ajax({
                    url:'/send/acode',
                    type:'POST',
                    data:data,
                    dataType:'json',
                    success:function(res){
                        if(res.code == 1){
                            settime($('.vcodeBtn'),60);
                            layer.msg(res.message);
                        }else{
                            layer.msg(res.message);
                        }

                    }
                });
            }
        })
    });

	$("#submit_yaya").click(function(){

		var mobile = $("#tel").val();
		var token = '{{csrf_token()}}';
		var code = $('#code').val();
		var password = $('#password').val();

		if(!mobile || !/13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|16[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}$/.test(mobile)){
			$(".mobile_error").text('请输入有效的手机号码');
			return false;
		}else{
			$(".mobile_error").text('');
		}
		if(!code){
			$(".code_error").text('请输入正确的验证码');
			return;
		}else{
			$(".code_error").text('');
		}
		if(password.length < 6 || password.length > 20){
			$(".passwd_error").text('密码必须在6-20位字符之间');
			return;
		}else{
			$(".passwd_error").text('');
		}
		var fission_id = localStorage.getItem('fission_id');
		var share_id = '';
		if(fission_id != '' || fission_id != null){
			var share_id = fission_id;
		}
		var channel = localStorage.getItem('channel');
		if(channel == '' || channel == null){
			var channel = '';
		}

		var op = $("input[name='openid']").val();
		var data = {mobile:mobile,verifyCode:code,password:password,_token:token,op:op,share_id:share_id,channel:channel};
		$.ajax({
			url:'/user/register',
			type:'POST',
			data:data,
			dataType:'json',
			async: false, //加上之后不在跳转进error
			success:function(data){

				if(data.code == 0){
					layer.msg("登录成功");
					gio('track', 'register');   //growing  统计代码注册数加1
					window.location.href="{{$href}}";
				}else if(data.code == 1){
					$(".code_error").text(data.message);
				}else if(data.code == 2){
					$(".mobile_error").text(data.message);
				}else if(data.code == 3){
					$(".passwd_error").text(data.message);
				}else if(data.code == 4){
					$(".mobile_error").text(data.message);
				}else if(data.code == 5){
					$(".mobile_error").text(data.message);
				}
			},error:function(XMLHttpRequest, textStatus, errorThrown){
				alert("错误代码："+XMLHttpRequest.status);
				alert("错误代码："+XMLHttpRequest.readyState);
				alert("错误代码："+textStatus);
			}
		});

	})

//监听视频播放

 $('#nav').on('click',function(e){
     
     $('html,body').animate({scrollTop:$('#'+'form').offset().top}, 500);
 });

	//将裂变者id写入本地  用于存储上下级关系
	var fission_id = "{{$fission_id}}";
	if(fission_id>0){
		localStorage.setItem("fission_id", fission_id);
	}


	function changeCode(){
		$.ajax({
			url:'/captcha',
			type:'GET',
			dateType:'json',
			success:function(res){
				console.log(res);
				$('.icma').html(res.img);
			}
		})
	}
</script>


@endsection
