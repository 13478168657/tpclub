<!DOCTYPE html>
<html lang="zh-CN">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
	<title>完善信息</title>
	<meta name="author" content="" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<script src="/js/rem.js" type="text/javascript"></script>
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.css" rel="stylesheet" type="text/css" />
    <link href="/css/reset_phone.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" type="text/css" />
    <link href="/css/toufang.css?t=1.7" rel="stylesheet">
</head>

<body ontouchstart>
	<!-- 我要开团页 start -->
	<div class="page_toufang_kaituan page_toufang_yuding w750">
		<!-- 课程详情 start -->
		<div class="weui-panel weui-panel_access course_details">
			<div class="weui-panel__bd">
				<a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
	                <div class="weui-media-box__hd">
	                    <img class="weui-media-box__thumb" src="{{env("IMG_URL")}}{{$tfCourseClass->cover_url}}" alt="">
	                </div>
	                <div class="weui-media-box__bd">
	                    <h4 class="weui-media-box__title f42">{{$tfCourseClass->title}}</h4>
	                    <p class="weui-media-box__desc f34 mt20">{{$tfCourseClass->description}}</p>
	                </div>
	            </a>
			</div>
		</div>
		<!-- 课程详情 end -->
		<!-- 表单 start -->
		<div class="weui-cells course_details_list yuding_form mt20 f30 bold">
			<div class="yuding_formWrap mlr30">
				<ul class="f28 lt">
					<li class="relative">
						<p>姓&nbsp;&nbsp;&nbsp;&nbsp;名<span>*</span></p>
						<input type="text" id="user" placeholder="请填写您的姓名" class="ipt" value="{{$tfOrder->username}}" />
					</li>
					<li class="relative">
						<p>手 机 号<span>*</span></p>
						<input type="text" id="tel" placeholder="用于预定的电话" class="ipt" value="{{$tfOrder->phone}}" />
					</li>
					<li class="relative">
						<!-- <input type="text" id="code" placeholder="用于预定的电话" class="ipt" /> -->
						<!-- <a href="javascript:void(0)" class="bgcolor_orange vcodeBtn f24 lt text_center">获取验证码</a> -->
					</li>
					<li class="relative">
						<p>身份证号<span>*</span></p>
						<input type="text" id="tel" placeholder="请填写身份证号码" class="ipt" value="{{$tfOrder->idcard}}" />
					</li>
				</ul>
				<div class="mt10 yuding_radio">
					<p class="f28 lt mb30">是否需要赠品<span>*</span></p>
					<label class="radio_wrap f24 color_4a clearfix mb20">
                        <input type="radio" checked="checked" name="remark" value="需要实物赠品（泡沫轴、弹力带）" class="radio"><p>需要实物赠品（泡沫轴、弹力带）</p>
                    </label>
                    <label class="radio_wrap f24 color_4a clearfix mb20">
                        <input type="radio" name="remark" value="不需要实物赠品" class="radio"><p>不需要实物赠品</p>
                    </label>
                    <p class="zhu f18 lt color_4a">注：不选择实物赠品预定后随时可退定；若选择实物赠品须到校办理。</p>
				</div>
			</div>
			<div class="weui-cell shijizhifu shijizhifu1 lt">
				<div class="weui-cell__bd">
					<p>实际支付</p>
				</div>
				<div class="weui-cell__ft"><strong class="pintuanjiaBtn">预定金</strong>500</div>
			</div>
		</div>
		<!-- 表单 end -->
	</div>
	<!-- 我要开团页 end -->

	<!-- 底部固定条 start -->
	<div class="fixed_bar_bot">
		<div class="w750 btns plr20 bold">
			<div class="payBtn jianbian_button_yellow f36">支付成功</div>
		</div>
	</div>
	<!-- 底部固定条 end -->

	
<!-- 选择弹窗 start -->
<div class="choose_layer hide">
	<div class="choose_con lt">
		<div class="selectSfList">
			<ul class="pb45 select_list clearfix">
				<p class="f28 color_000 mb30">预订入学时间</p>
				<li>
					<input type="radio" name="year" value="2020年" id="11" checked="checked">
                    <label for="11">2020年</label>	
				</li>
				<li>
					<input type="radio" name="year" value="2021年" id="12">
                    <label for="12">2021年</label>	
				</li>
				<li>
					<input type="radio" name="year" value="2022年及以后" id="13">
                    <label for="13">2022年及以后</label>	
				</li>
			</ul>
			<ul class="pb45 select_list1 clearfix">
				<p class="f28 color_000 mb30">预定分院校区</p>
				<li>
					<input type="radio" name="area" value="北京分院" id="21" checked="checked">
                    <label for="21">北京分院</label>	
				</li>
				<li>
					<input type="radio" name="area" value="上海分院" id="22">
                    <label for="22">上海分院</label>	
				</li>
				<li class="last-child">
					<input type="radio" name="area" value="深圳分院" id="23">
                    <label for="23">深圳分院</label>	
				</li>
				<li>
					<input type="radio" name="area" value="西安分院" id="24">
                    <label for="24">西安分院</label>	
				</li>
			</ul>
			<ul class="pb45 select_list2 clearfix">
				<p class="f28 color_000 mb30">预定课程</p>
				<li>
					<input type="radio" name="class" value="初级课程（1个月）" id="31" checked="checked">
                    <label for="31">初级课程（1个月）</label>	
				</li>
				<li class="last-child">
					<input type="radio" name="class" value="中级课程（2个月）" id="32">
                    <label for="32">中级课程（2个月）</label>	
				</li>
				<li>
					<input type="radio" name="class" value="高级课程（3个月）" id="33">
                    <label for="33">高级课程（3个月）</label>	
				</li>
				<li class="last-child">
					<input type="radio" name="class" value="国际高级课程（3个月）" id="34">
                    <label for="34">国际高级课程（3个月）</label>	
				</li>
			</ul>
		</div>
		<div class="btns mlr20">
			<a href="javascript:void(0)" class="submit f34 ltc radius5 text_center">提交信息</a>
		</div>
	</div>
</div>
<!-- 选择弹窗 end -->
<!-- 提交成功弹窗 start -->
<div class="tijiao_layer hide">
	<div class="tijiao_con lt">
		<img src="/images/vote/right.png" alt="">
		<p class="mt50 pt30 text_center f30">您已提交成功</p>
		<p class="text_center mt30 tijiao_txt">7个工作日内咨询老师会与您联系，<br>请保持电话通畅。</p>
	</div>
</div>
<!-- 提交成功弹窗 end -->


	<br><br><br /><br />

	<script src="/js/jquery-1.11.2.min.js"></script>
	<script src="/lib/layer/layer.js"></script>
	<script src="/lib/icheck/js/icheck.min.js"></script>
	<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
	<script src="/js/js.js"></script>
	<script type="text/javascript">
		$(function () {
			//二维码弹窗
			setTimeout(function(){ 
				layer.open({
					type: 1,
					title: false, //不显示标题栏
					skin: 'choose_layer_wrap', //样式类名
					id: 'choose_layer', //设定一个id，防止重复弹出
					closeBtn: 1, //不显示关闭按钮
					anim: 2,
					shadeClose: false, //开启遮罩关闭
					area: ['90%', '100%'],
					content:$('.choose_layer'),
					btn:false
				});
			}, 500);

			//发送验证码
			$(document.body).delegate(".vcodeBtn", 'click', function () {
				var tel=$('#tel').val();
				if(!tel || !/13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}$/.test(tel)){
					layer.msg('请输入正确的手机号');
				}else{
					settime($(this),60);
				}
			});
			
			$(".payBtn").click(function(){
				layer.open({
					type: 1,
					title: false, //不显示标题栏
					skin: 'choose_layer_wrap', //样式类名
					id: 'choose_layer', //设定一个id，防止重复弹出
					closeBtn: 1, //不显示关闭按钮
					anim: 2,
					shadeClose: false, //开启遮罩关闭
					area: ['90%', '100%'],
					content:$('.choose_layer'),
					btn:false
				});
			});

			var user_id   = "{{$user_id}}";      //用户id
        	var tf_course_class_id = "{{$tfCourseClass->id}}";  //购买投放课程id

			$('.submit').click(function (){
	                layer.msg('正在提交');
	                var token  = '{{csrf_token()}}';
	                var year   = $("input[name='year']:checked").val();
	                var school = $("input[name='area']:checked").val();
	                var course = $("input[name='class']:checked").val();
	                
	                $.ajax({
	                    type:"POST",
	                    url:"/tf/info/school",
	                    data:{_token:token,tf_class_id:tf_course_class_id,year:year, school:school, course:course},
	                    dataType:"json",
	                    success:function(result){
	                        if(result.code==0){
	                        	layer.msg("提交信息成功");
	                        	layer.closeAll(); //疯狂模式，关闭所有层
								//正如你看到的，每一种弹层调用方式，都会返回一个index
								//layer.close(layer.index); //此时你只需要把获得的index，轻轻地赋予layer.close即可
								layer.open({
									type: 1,
									title: false, //不显示标题栏
									skin: 'tijiao_layer_wrap', //样式类名
									id: 'tijiao_layer', //设定一个id，防止重复弹出
									closeBtn: 1, //不显示关闭按钮
									anim: 2,
									shadeClose: false, //开启遮罩关闭
									area: ['90%', '60%'],
									content:$('.tijiao_layer'),
									btn:false
								});
                            }else{
                                layer.msg(result.message);
                            }
	                    }
	                });

	        });
		})

		//单选按钮
	    $('.radio').iCheck({
	        //checkboxClass: 'icheckbox_square-green',
	        radioClass: 'iradio',
	        increaseArea: '20%'
	    });

		$(function () {	
			//针对苹果手机键盘的复位
			$("input").blur(function () { 
	 			setTimeout(function() { 
	 			var scrollHeight = document.documentElement.scrollTop || document.body.scrollTop || 0; 
	 			window.scrollTo(0, Math.max(scrollHeight - 1, 0)); 
	 			}, 100); 
	 		}); 
		})
	</script>
</body>

</html>