<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$userMember->name}}详情</title>
    <!-- jqweui -->
    <link rel="stylesheet" href="/fat/lib/jqweui/css/weui.min.css">
    <link rel="stylesheet" href="/fat/lib/jqweui/css/jquery-weui.css">
    <link rel="stylesheet" href="/fat/css/reset.css">
	<link rel="stylesheet" href="/fat/css/mp.css">
    <link rel="stylesheet" href="/fat/css/font-num40.css">
    <link rel="stylesheet" href="/fat/css/index.css?t=1.1">
    <script src="/fat/js/rem.js"></script>

 	<script src="/fat/js/jquery-1.11.2.min.js"></script>
	<script src="/lib/echarts/echarts.min.js"></script>
    @include('layouts.baidutongji')
</head>

<body ontouchstart>

<!-- banner-->
<img src="/fat/images/ban.jpg" alt="" class="img100">

 <div class="page_xuanshouxiangqing mlr30 mt50 mb50">
	<!-- 内容 start -->
	<div class="content pb60">
		<div class="thumb relative">
			<img src="{{env('IMG_URL')}}{{$userMember->cover_img}}" class="img100" alt="" />
			<span class="number font-Impact">{{$userMember->id}}</span>
		</div>
		<div class="info pt20 pb20">
			<span class="name lt f48">{{$userMember->name}}</span>
			<?php
				if($userMember->object == 'staff'){
					$identify = '员工';
					$tag_color = 'tag_orange';
				}

				if($userMember->object == 'teacher'){
					$identify = '教师';
					$tag_color = 'tag_purple';
				}

				if($userMember->object == 'student'){
					$identify = '学员';
					$tag_color = 'tag_green';
				}
			?>
			<label class="tag {{$tag_color}}">{{$identify}}</label>
		</div>
		<ul class="clearfix votes mt30">
			<li>
				<div class="im f38 num">{{$rank}}</div>
				<div class="f26">排名</div>
			</li>
			<li>
				<div class="im f38 num"><span class="votesinfo">{{$userMember->votes}}</span></div>
				<div class="f26">票数</div>
			</li>
			<li>
				@if($preUser)
				<div class="im f38 num">{{$preUser->votes-$userMember->votes}}<span class="f32 lt">票</span></div>
				@else
					<div class="im f38 num">0<span class="f32 lt">票</span></div>
				@endif
				<div class="f26">距上一名</div>
			</li>
		</ul>
		<div class="clearfix btns mt60">
			<button data-id="{{$userMember->id}}" class="btn_vote f44 lt fl">投票</button>
			<button class="btn_canvass f44 lt fr part-btn">为我拉票</button>
		</div>
	</div>
	<!-- 内容 end -->
	<!-- 二维码 start -->
<div class="codeImg text_center pt20">
   <h4 class="lt f48">关注二维码</h4>
   <p class="fz f30 pt30">获取比赛最新动态，学习健身行业知识</p >
   <img src="/fat/images/code.jpg" alt="" class="img100">
</div>
<!-- 二维码 end -->
	<!-- 秀出你的身材 start -->
	<div class="showFigure pt60">
		<h2 class="lt f48">秀出你的身材</h2>
		<ul class="pt20">
			<li>
				<dl class="clearfix">
					<dt>报名初期</dt>
					<dd>
						<span>身高:{{$userMember->height}}CM</span>
						<span>体重:{{$userMember->weight}}KG</span>
						<span>体脂率:{{$userMember->fat_rate}}%</span>
					</dd>
				</dl>
				<ul class="clearfix figure">
					<li>
						<div class="thumb">
							<img src="{{env('IMG_URL')}}{{$userMember->fat_img}}" class="img100" alt="" />
						</div>
						<h4>电子凭证图</h4>
					</li>
					<li>
						<div class="thumb">
							<!-- <img src="{{env('IMG_URL')}}{{$userMember->positive_img}}" class="img100" alt="" /> -->
							@if($user && $user->id==$userMember->user_id)
							<img src="{{env('IMG_URL')}}{{$userMember->positive_img}}" class="img100" alt="" />
							@else
							<img src="/fat/images/baomi.png" class="img100" alt="" />
							@endif
						</div>
						<h4>正面图</h4>
					</li>
					<li>
						<div class="thumb">
							<!-- <img src="{{env('IMG_URL')}}{{$userMember->side_img}}" class="img100" alt="" /> -->
							@if($user && $user->id==$userMember->user_id)
							<img src="{{env('IMG_URL')}}{{$userMember->side_img}}" class="img100" alt="" />
							@else
							<img src="/fat/images/baomi.png" class="img100" alt="" />
							@endif
						</div>
						<h4>右侧面图</h4>
					</li>
				</ul>
			</li>
			@if(isset($fatBodyData[0]))
				<li>
					<dl class="clearfix">
						<dt>训练结束</dt>
						<dd>
							<span>身高:{{$userMember->height}}CM</span>
							<span>体重:{{$fatBodyData[0]->weight}}KG</span>
							<span>体脂率:{{$fatBodyData[0]->fat_rate}}%</span>
						</dd>
					</dl>
					<ul class="clearfix figure">
						<li>
							<div class="thumb">
								<img src="{{env('IMG_URL')}}{{$fatBodyData[0]->fat_img}}" class="img100" alt="" />
							</div>
							<h4>电子凭证图</h4>
						</li>
						<li>
							<div class="thumb">
								<!-- <img src="{{env('IMG_URL')}}{{$fatBodyData[0]->positive_img}}" class="img100" alt="" /> -->
								@if($user && $user->id==$userMember->user_id)
								<img src="{{env('IMG_URL')}}{{$fatBodyData[0]->positive_img}}" class="img100" alt="" />
								@else
								<img src="/fat/images/baomi.png" class="img100" alt="" />
								@endif
							</div>
							<h4>正面图</h4>
						</li>
						<li>
							<div class="thumb">
								<!-- <img src="{{env('IMG_URL')}}{{$fatBodyData[0]->side_img}}" class="img100" alt="" /> -->
								@if($user && $user->id==$userMember->user_id)
								<img src="{{env('IMG_URL')}}{{$fatBodyData[0]->side_img}}" class="img100" alt="" />
								@else
								<img src="/fat/images/baomi.png" class="img100" alt="" />
								@endif
							</div>
							<h4>右侧面图</h4>
						</li>
					</ul>
				</li>
			@else
				<li>
					<dl class="clearfix">
						<dt>训练结束</dt>
						<dd>
							<span>身高:CM</span>
							<span>体重:KG</span>
							<span>体脂率:%</span>
						</dd>
					</dl>
					<ul class="clearfix figure">
						<li>
							<div class="thumb">
								<img src="" class="img100" alt="" />
							</div>
							<h4>电子凭证图</h4>
						</li>
						<li>
							<div class="thumb">
								<img src="" class="img100" alt="" />
							</div>
							<h4>正面图</h4>
						</li>
						<li>
							<div class="thumb">
								<img src="" class="img100" alt="" />
							</div>
							<h4>右侧面图</h4>
						</li>
					</ul>
				</li>
			@endif
			<!-- @if(isset($fatBodyData[1]))
				<li>
					<dl class="clearfix">
						<dt>第二周</dt>
						<dd>
							<span>身高:{{$userMember->height}}CM</span>
							<span>体重:{{$fatBodyData[1]->weight}}KG</span>
							<span>体脂率:{{$fatBodyData[1]->fat_rate}}%</span>
						</dd>
					</dl>
					<ul class="clearfix figure">
						<li>
							<div class="thumb">
								<img src="{{env('IMG_URL')}}{{$fatBodyData[1]->fat_img}}" class="img100" alt="" />
							</div>
							<h4>电子凭证图</h4>
						</li>
						<li>
							<div class="thumb">
								<img src="{{env('IMG_URL')}}{{$fatBodyData[1]->positive_img}}" class="img100" alt="" />
							</div>
							<h4>正面图</h4>
						</li>
						<li>
							<div class="thumb">
								<img src="{{env('IMG_URL')}}{{$fatBodyData[1]->side_img}}" class="img100" alt="" />
							</div>
							<h4>右侧面图</h4>
						</li>
					</ul>
				</li>
			@else
				<li>
					<dl class="clearfix">
						<dt>第二周</dt>
						<dd>
							<span>身高:</span>
							<span>体重:</span>
							<span>体脂率:</span>
						</dd>
					</dl>
					<ul class="clearfix figure">
						<li>
							<div class="thumb">
								<img src="" class="img100" alt="" />
							</div>
							<h4>电子凭证图</h4>
						</li>
						<li>
							<div class="thumb">
								<img src="" class="img100" alt="" />
							</div>
							<h4>正面图</h4>
						</li>
						<li>
							<div class="thumb">
								<img src="" class="img100" alt="" />
							</div>
							<h4>右侧面图</h4>
						</li>
					</ul>
				</li>
			@endif -->
			<!-- @if(isset($fatBodyData[2]))
				<li>
					<dl class="clearfix">
						<dt>第三周</dt>
						<dd>
							<span>身高:{{$userMember->height}}CM</span>
							<span>体重:{{$fatBodyData[2]->weight}}KG</span>
							<span>体脂率:{{$fatBodyData[2]->fat_rate}}%</span>
						</dd>
					</dl>
					<ul class="clearfix figure">
						<li>
							<div class="thumb">
								<img src="{{env('IMG_URL')}}{{$fatBodyData[2]->fat_img}}" class="img100" alt="" />
							</div>
							<h4>电子凭证图</h4>
						</li>
						<li>
							<div class="thumb">
								<img src="{{env('IMG_URL')}}{{$fatBodyData[2]->positive_img}}" class="img100" alt="" />
							</div>
							<h4>正面图</h4>
						</li>
						<li>
							<div class="thumb">
								<img src="{{env('IMG_URL')}}{{$fatBodyData[2]->side_img}}" class="img100" alt="" />
							</div>
							<h4>右侧面图</h4>
						</li>
					</ul>
				</li>
			@else
				<li>
					<dl class="clearfix">
						<dt>第三周</dt>
						<dd>
							<span>身高:</span>
							<span>体重:</span>
							<span>体脂率:</span>
						</dd>
					</dl>
					<ul class="clearfix figure">
						<li>
							<div class="thumb">
								<img src="" class="img100" alt="" />
							</div>
							<h4>电子凭证图</h4>
						</li>
						<li>
							<div class="thumb">
								<img src="" class="img100" alt="" />
							</div>
							<h4>正面图</h4>
						</li>
						<li>
							<div class="thumb">
								<img src="" class="img100" alt="" />
							</div>
							<h4>右侧面图</h4>
						</li>
					</ul>
				</li>
			@endif -->
		</ul>
	</div>
	<!-- 秀出你的身材 end -->
 </div>
<!-- 弹出的验证码 start -->
<div class="layer_code_con text_center hide">
	<div class="head f36 bold">
		<p>验证码</p>
	</div>
	<div class="content fz">
		<div class="box clearfix">
			<input type="button" id="code" class="f36 fz text_center">
			<p class="f24 refresh">换一张<img src="/images/fat/images/f5.png" alt=""></p>
		</div>
		<input type="text" id="input" placeholder="请输入验证码" class="fz f28">
	</div>
	<div class="foot lt f36">
		<button id="check">提交</button>
	</div>
</div>
<!-- 弹出的验证码 end -->

<!-- 减脂体测数据变化条形图 start -->
<div class="box x-box bgc_white plr30 mlr30">
	<div class="tit">
		<p class="lt f38 color_333">减脂体测数据变化条形图</p>
	</div>
	<div>
		<div class="mimd" id="min3"></div>
	</div>
</div>
<!-- 减脂体测数据变化条形图 end -->


<!--弹出分享 start-->
<div class="part-content">
	<div class="fxpyq_success_layer_wrap text_center mt105 fx-img">
		<p><img src="/fat/images/partimg.png" class="fx_success down-arrow" id="dou" alt="" /></p>
		<p class="pt95 color_fff f36 fz">请点击右上角<br>将它发送给指定朋友<br>或分享到朋友圈</p>
	</div>
</div>
<!--弹出分享 end-->
@include('a.fat.footer',['type'=>0])
 <script src="/fat/lib/jqweui/js/fastclick.js"></script>
 <script src="/fat/lib/jqweui/js/jquery-weui.min.js"></script>
 <script src="/fat/lib/layer/layer.js"></script>
<script src="/fat/lib/swiper/swiper.js"></script>
 <script>
	 //弹出验证码
	 $(".btn_confirm").click(function(){

	 });
	 var voteNum = 0;
	 var token = '';
	 var mid = 0;
	 var obj   = '';
	 //验证码
	 function change(){
		 code=$("#code");
		 // 验证码组成库
		 var arrays=new Array('1','2','3','4','5','6','7','8','9','0',
				 'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
				 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		 codes='';// 重新初始化验证码
		 for(var i = 0; i<5; i++){
			 // 随机获取一个数组的下标
			 var r = parseInt(Math.random()*arrays.length);
			 codes += arrays[r];
		 }
		 // 验证码添加到input里
		 code.val(codes);
	 }
	 change();
	 code.click(change);
	 $(".refresh").click(change);
	 //单击验证
	 $("#check").click(function(){
		 var inputCode = $("#input").val().toUpperCase(); //取得输入的验证码并转化为大写
		 console.log(inputCode);
		 if(inputCode.length == 0) { //若输入的验证码长度为0
			 layer.msg("请输入验证码！"); //则弹出请输入验证码
		 }
		 else if(inputCode!=codes.toUpperCase()) { //若输入的验证码与产生的验证码不一致时
			 layer.msg("请输入正确的验证码！"); //则弹出验证码输入错误
			 change();//刷新验证码
			 $("#input").val("");//清空文本框
		 }else { //输入正确时
//            layer.msg("正确"); //弹出^-^
			 layer.closeAll();
			 voteNum += 1;
			 var data = {mid:mid,_token:token};
			 layer.load(2, {shade: [0.5,'#000']});
			 $.ajax({
				 data:data,
				 type:'POST',
				 url:'/fat/user/vote',
				 dataType:'json',
				 success:function(res){
					 layer.closeAll('loading');
					 if(res.code == 1){
						 layer.msg(res.message);
						 window.location.href = '/login?redirect=/fat/index';
					 }
					 layer.msg(res.message);
					 if(res.code==0){

						 console.log(hasPage);
						 var voteinfo = obj.parent().prev().find("span[class='votesinfo']").text();
						 obj.parent().prev().find("span[class='votesinfo']").text(voteinfo-0+1);
					 }
				 }
			 })
		 }
	 });

	 $(function () {
			FastClick.attach(document.body);
		});

		$(".btn_vote").click(function(){

			token= '{{csrf_token()}}';
			mid  = $(this).attr('data-id');
			obj  = $(this);
			if(voteNum == 0){
				layer.open({
					type: 1,
					title: false, //不显示标题栏
					skin: 'layer_code_box', //样式类名
					id: 'layer_code_box', //设定一个id，防止重复弹出
					closeBtn: 1, //不显示关闭按钮
					anim: 2,
					shadeClose: false, //开启遮罩关闭
					area: ['99%', 'auto'],
					content:$('.layer_code_con'),
					btn: false
				});
				return;
			}
			voteNum += 1;
			var data = {mid:mid,_token:token};
			layer.load(2, {shade: [0.5,'#000']});
			$.ajax({
				data:data,
				type:'POST',
				url:'/fat/user/vote',
				dataType:'json',
				success:function(res){
					layer.closeAll('loading');
					if(res.code == 1){
						layer.msg(res.message);
						window.location.href = '/login?redirect=/fat/member/'+'{{$userMember->id}}'+'.html';
					}
					layer.msg(res.message);
					if(res.code==0){

                        var voteinfo = obj.parent().prev().find("span[class='votesinfo']").text();
                        obj.parent().prev().find("span[class='votesinfo']").text(voteinfo-0+1);
                    }
				}
			})

		});

		//图片浏览器
		$(".showFigure .figure li").click(function () {
			var urls = [];
			var len = $(this).parents('.figure').find('ul li').size();
			var index=$(this).index();
			console.log(len)
			$(this).parents('.figure').find('li').each(function () {
				var src = $(this).find('img').attr('src');
				urls.push(src)
			});
			var pb3 = $.photoBrowser({
				items: urls,
				
			initIndex: index
			});
			console.log(urls)
			pb3.open();
		});




		$(".part-btn").click(function(){
			layer.open({
				type: 1,
				title: false,
				skin: 'fxpyq_success_layer_wrap',
				id: 'fxpyq_success_layer',
				closeBtn: 0,
				anim: 2,
				shade:[0.7, '#000'],
				shadeClose: true,
				area: ['90%', '80%'],
				content: $('.part-content'),
				btn: false
			});
		});
		$('.part-content').click(function(){
			layer.closeAll()
		});

		//分享箭头样式
		var i=0;
		$(document).ready(function(){
			setInterval('gaibian()',1000);
		});
		function gaibian(){
			if(i==0){
				i=1;
				$("#dou").removeClass("zhuan_left");
				$("#dou").addClass("zhuan_right");
			}else{
				i=0;
				$("#dou").addClass("zhuan_left");
				$("#dou").removeClass("zhuan_right");
			}
		}

		$(function () {
			function Column3() {
				var myChart = echarts.init(document.getElementById('min3'));
				// 指定图表的配置项和数据
				var option = {
					tooltip: {
						trigger: 'axis'
					},
					grid: {
						x: 40,
						y: 30,
						x2: 0,
						y2: 50,
						//containLabel: true//grid 区域是否包含坐标轴的刻度标签。
					},
					xAxis: {
						type: 'category',
						axisLabel: {
							color: '#828282',
							fontSize: 13,
							lineHeight:18,
							interval: 0,
							//rotate:-30,
						},
						data: ["报名初期{{$userMember->fat_rate}}%\n{{$userMember->fat_first_time}}", "训练结束{{isset($fatBodyData[0])  ? $fatBodyData[0]['fat_rate'] : ''}}\n{{date('Y-m-d',strtotime($userMember->fat_first_time)+3600*24*20)}}"],
						axisLine: {
							lineStyle: {
								color: '#9D9D9D'//最底下一条横线
							}
						},
					},
					yAxis: {
						type: 'value',
						axisLine: {
							show: false,//最左边竖着的线不显示
							lineStyle: {
								color: '#e1e1e1'
							}
						},
						axisLabel: {
							color: '#828282',
							fontSize: 13,
							//设置y轴数值为kal
							//formatter: '{value} kal'
							// 控制网格线是否显示
							splitLine: {
								show: true,
								lineStyle: {
									//type: 'dashed',
									color: ['#000fff']
								}
							},
						},
						"min": 0,
						"max": 50
					},
					series: [
						{
							name: '',
							type: 'bar',
							barWidth: 20,
							itemStyle: {
								normal: {
									color: function (params) {
										var colorList = ['#FCD000','#F36F20'];
										return colorList[params.dataIndex];
									}
								},
							},
							data: ["{{$userMember->fat_rate}}", "{{isset($fatBodyData[0])  ? $fatBodyData[0]['fat_rate'] : 0}}"]
						}
					]
				};
				// 使用刚指定的配置项和数据显示图表。
				myChart.setOption(option);
			}


			Column3();
		});
    </script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
	//针对苹果手机键盘的复位
	$("input").blur(function () {
		setTimeout(function() {
			var scrollHeight = document.documentElement.scrollTop || document.body.scrollTop || 0;
			window.scrollTo(0, Math.max(scrollHeight - 1, 0));
		}, 100);
	});
    var url  = window.location.href;
    var title= '我正在参与赛普千人减脂大比拼';
    var desc = '健身改变人生，千人减脂大比拼,快来为我投票吧！';
    var share_img = "{{env('APP_URL')}}/images/wx_share.jpg";
    console.log(url);
    console.log(title);
    console.log(desc);
    console.log(share_img);
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
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img, // 分享图标
            success: function(){
            	layer.closeAll();
            }
        }, function(res) {
        //这里是回调函数

        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: title, // 分享标题
            link: url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img, // 分享图标
            success: function(){
            	layer.closeAll();
            }
        }, function(res) {
        //这里是回调函数

        });
    });
</script>    
</body>

</html>