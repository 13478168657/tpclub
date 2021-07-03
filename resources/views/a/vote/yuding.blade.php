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
    <link href="/css/toufang.css?t=1.5" rel="stylesheet">
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
						<input type="text" id="username" placeholder="请填写您的姓名" class="ipt" />
					</li>
					<li class="relative">
						<p>手 机 号<span>*</span></p>
						<input type="text" id="tel" placeholder="用于预定的电话" class="ipt" />
					</li>
					<li class="relative">
						<input type="text" id="vcode" placeholder="验证码" class="ipt" />
						<a href="javascript:void(0)" class="bg_fdd000 vcodeBtn f24 lt text_center">获取验证码</a>
					</li>
					<li class="relative">
						<p>身份证号<span>*</span></p>
						<input type="text" id="idcard" placeholder="请填写身份证号码" class="ipt" />
					</li>
				</ul>
				<div class="mt10 yuding_radio">
					<p class="f28 lt mb30">是否需要赠品<span>*</span></p>
					<label class="radio_wrap f24 color_4a clearfix mb20">
                        <input type="radio" checked="checked" name="remark" value="1" class="radio"><p>需要实物赠品（泡沫轴、弹力带）</p>
                    </label>
                    <label class="radio_wrap f24 color_4a clearfix mb20">
                        <input type="radio" name="remark" value="0" class="radio"><p>不需要实物赠品</p>
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
			<div class="payBtn jianbian_button_yellow f36">我要支付</div>
		</div>
	</div>
	<!-- 底部固定条 end -->


	<br><br><br /><br /><br /><br />

	<script src="/js/jquery-1.11.2.min.js"></script>
	<script src="/lib/layer/layer.js"></script>
	<script src="/lib/icheck/js/icheck.min.js"></script>
	<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
	<script src="/js/js.js"></script>
	<script type="text/javascript">
		var is_weixin = "{{$is_weixin}}";  //是否为微信浏览器
    	var user_id   = "{{$user_id}}";      //用户id
    	var tf_course_class_id = "{{$tfCourseClass->id}}";  //购买投放课程id

		//单选按钮
	    $('.radio').iCheck({
	        //checkboxClass: 'icheckbox_square-green',
	        radioClass: 'iradio',
	        increaseArea: '20%'
	    });

	    //跳转登陆函数
	    var userlogin = function(){
	        var url = "/dist/buy/yd"+tf_course_class_id+".html";
	        localStorage.setItem("redirect", url);

	        layer.msg('请先注册');
	        window.location.href = "/register";
	    };
	    function href_go(){
	        window.location.href='/tf/successyd/'+tf_course_class_id+'.html';
	    }

		$(function (){
			//针对苹果手机键盘的复位
			$("input").blur(function () { 
	 			setTimeout(function() { 
	 			var scrollHeight = document.documentElement.scrollTop || document.body.scrollTop || 0; 
	 			window.scrollTo(0, Math.max(scrollHeight - 1, 0)); 
	 			}, 100); 
	 		}); 

	 		//发送验证码
	        $(".vcodeBtn").click(function() {
	            var tel = $("#tel").val();
	            if(!tel || !/1[1-9]{1}[0-9]{9}/.test(tel)){
	                layer.msg('请输入有效的手机号码');
	            }else{
	                var token = '{{csrf_token()}}';
	                var mobile = $("#tel").val();
	                var data = {mobile:mobile,verify:1,_token:token};
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
	        });

        //立即付款弹出框
        $('.payBtn').click(function (){
                layer.msg('正在支付');
                if(is_weixin==1){
                    jsApiCall();
                }else{
                    var token     = '{{csrf_token()}}';
                   	var username = $("#username").val();
                   	var phone = $("#tel").val();
                   	var code  = $("#vcode").val();
                   	var idcard= $("#idcard").val();
                   	var is_give = $("input[name='remark']:checked").val();
                  	if(username == ''){
                       layer.msg('请填写姓名');
                       return false;
                  	}
                   	if(phone == ''){
                       layer.msg('请填写手机号');
                       return false;
                   	}
                   	if(code == ''){
                       layer.msg('请填写验证码');
                       return false;
                   	}

                   	//alert(111);
                   	//return false;
                    //20200210 记录真实支付点击次数
                    var data = {type:"pay_click_num",user_id:user_id, tf_course_class_id:tf_course_class_id};
                    $.ajax({
                        url:'/tf/click',
                        data:data,
                        type:'GET',
                        dataType:'json',
                        success:function(res){
                        }
                    });
                    $.ajax({
                        type:"POST",
                        url:"/tf/payh",
                        data:{_token:token,tf_class_id:tf_course_class_id, username:username, idcard:idcard, is_give:is_give, phone:phone},
                        dataType:"json",
                        success:function(result){
                        	//href_go();
                            if(result.code==0){
                                //console.log(result.objectxml.mweb_url);
                                //follow_us();
                                //href_go();
                                window.location.href=result.objectxml.mweb_url;   //h5呼叫微信支付
                            }else if(result.code == 3){
                                userlogin();
                            }else{
                                layer.msg(result.message);
                            }
                        }
                    });
                }

        });

        //调用微信JS api 支付
        function jsApiCall()
        {
            var token     = '{{csrf_token()}}';
           	var username = $("#username").val();
           	var phone = $("#tel").val();
           	var code  = $("#vcode").val();
           	var idcard= $("#idcard").val();
           	var is_give = $("input[name='remark']:checked").val();
          	if(username == ''){
               layer.msg('请填写姓名');
               return false;
          	}
           	if(phone == ''){
               layer.msg('请填写手机号');
               return false;
           	}
           	if(code == ''){
               layer.msg('请填写验证码');
               return false;
           	}
            //20200210 记录真实支付点击次数
            var info = {type:"pay_click_num",user_id:user_id, tf_course_class_id:tf_course_class_id};
            $.ajax({
                url:'/tf/click',
                data:info,
                type:'GET',
                dataType:'json',
                success:function(res){
                }
            });
            //alert(222);
            var data = {_token:token,tf_class_id:tf_course_class_id,username:username, idcard:idcard, is_give:is_give, phone:phone};
            //alert(111)
            $.ajax({
                url:'/tf/pay',
                data:data,
                type:'POST',
                dateType:"json",
                success:function(res){

                    if(res.code != 0){
                        if(res.code == 3){
                            userlogin();
                            return false;
                        }
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
    })
	</script>
</body>

</html>