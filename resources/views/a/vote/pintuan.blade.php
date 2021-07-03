<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>我要开团</title>
    <meta name="author" content="" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <script src="/js/rem.js" type="text/javascript"></script>
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.css" rel="stylesheet" type="text/css" />
    <link href="/css/reset_phone.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" type="text/css" />
    <link href="/css/toufang.css?t=1.4" rel="stylesheet">
    <style>
        .buyBtn{
            height: 2.45rem;
            line-height: 2.45rem;
            border-radius: 4px;
            text-align: center;
        }
    </style>
</head>

<body ontouchstart>
<!-- 我要开团页 start -->
<div class="page_toufang_kaituan w750">
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
    <!-- 课程详情列表 start -->
    <div class="weui-cells course_details_list mt20 fs30 bold">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>课程内容</p>
            </div>
            <div class="weui-cell__ft">增肌+减脂</div>
            <!-- <div class="weui-cell__ft">{{$tfCourseClass->class_hour}}</div> -->
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>适合人群</p>
            </div>
            <div class="weui-cell__ft">
            健身爱好者<br/>健身行业求职者<br/>体校生和退伍军人
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>有效期</p>
            </div>
            <div class="weui-cell__ft">长期有效</div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>原价</p>
            </div>
            @if($tfCourseClass->price_info)
            <div class="weui-cell__ft">{{$tfCourseClass->price_info}}</div>
            @else
            <div class="weui-cell__ft">¥{{$tfCourseClass->price}}</div>
            @endif
        </div>
    </div>
    <div class="weui-cells course_details_list mt20 fs30 bold">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>优惠</p>
            </div>
            @if($tfCourseClass->discount_info)
            <div class="weui-cell__ft">{{$tfCourseClass->discount_info}}</div>
            @else
            <div class="weui-cell__ft">-¥{{$tfCourseClass->price-$tfCourseClass->team_price}}</div>
            @endif
        </div>
        <div class="weui-cell shijizhifu">
            <div class="weui-cell__bd">
                <p>实际支付</p>
            </div>
            <div class="weui-cell__ft">
                @if($tfCourseClass->id==1)
                <strong class="pintuanjiaBtn">拼团价</strong>
                @else
                <strong class="pintuanjiaBtn">预定金</strong>
                @endif
                ¥{{$tfCourseClass->team_price}}
            </div>
        </div>
    </div>
    <!-- 课程详情列表 end -->
</div>
<!-- 我要开团页 end -->

<!-- 底部固定条 start -->
<div class="fixed_bar_bot">
    <div class="w750 btns plr20 bold">
        @if($is_buy==1)
        <div class="buyBtn jianbian_button_yellow f36">您已支付</div>
        @else
        <div class="payBtn jianbian_button_yellow f36">我要支付</div>
        @endif
    </div>
</div>
<!-- 底部固定条 end -->


<!-- 支付表单弹窗 start -->
<div class="zhifu_form_layer hide">
    <div class="container bold">
        <h3 class="f30 text_center pt40 pb50">请输入您的收货信息</h3>
        <ul>
            <li class="mb30">
                <input type="text" class="ipt" placeholder="请输入您的姓名" id="username" />
            </li>
            <li class="mb30">
                <input type="text" class="ipt" placeholder="请输入手机号码" id="tel" />
            </li>
            <li class="mb30 clearfix">
                <div class="vcodeInputWrap fl_sp">
                    <input type="text" class="ipt vcodeInput" placeholder="请输入验证码" id="vcode" />
                </div>
                <div class="vcodeBtnWrap fr_sp">
                    <button class="vcodeBtn f30">获取验证码</button>
                </div>
            </li>
        </ul>
        <div class="btns clearfix">
            <a href="javascript:void(0)" class="payNowBtn jianbian_button_yellow f36">我要支付</a>
        </div>
        <p class="pt20">您的信息仅作为赛普活动通知使用，全程保密。<br />请确保信息准确，以便我们为您随时发放课程资料。</p>
    </div>
</div>
<!-- 支付表单弹窗 end -->

<!-- 二维码弹窗 start -->
<div class="qr_form_layer hide">
    <div class="container pt20 bold text_center">
        <h3 class="f30 pt50">扫描或识别下方二维码</h3>
        <dl class="mt20">
            <dt class="f40">添加辅导老师微信</dt>
            <dd class="mt40"><img class="add_img" src="{{env('IMG_URL')}}{{$tfCourseClass->wx_code}}" alt="二维码" /></dd>
        </dl>
    </div>
</div>
<!-- 二维码弹窗 end -->

<br><br><br /><br />

<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/js/js.js"></script>
<script type="text/javascript">

    $("input").blur(function () {
        setTimeout(function() {
            var scrollHeight = document.documentElement.scrollTop || document.body.scrollTop || 0;
            window.scrollTo(0, Math.max(scrollHeight - 1, 0));
        }, 100);
    });
    var is_weixin = "{{$is_weixin}}";  //是否为微信浏览器
    var user_id   = "{{$user_id}}";      //用户id
    var tf_course_class_id = "{{$tfCourseClass->id}}";  //购买投放课程id

    $(function () {


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

    });

    //跳转登陆函数
    var userlogin = function(){
        var url = "/dist/buy/pt"+tf_course_class_id+".html";
        localStorage.setItem("redirect", url);

        layer.msg('请先注册');
        window.location.href = "/register";
    };
    function href_go(){

        window.location.href='/tf/success/'+tf_course_class_id+'.html';
    }

    //已支付二维码弹窗
    $('.buyBtn').click(function(){
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'qr_form_layer_wrap', //样式类名
            id: 'qr_form_layer', //设定一个id，防止重复弹出
            closeBtn: 1, //不显示关闭按钮
            anim: 2,
            shadeClose: false, //开启遮罩关闭
            area: ['90%', '60%'],
            content:$('.qr_form_layer'),
            btn:false
        });
    });

    $(function (){

        //立即付款弹出框
        $('.payBtn').click(function (){
                layer.msg('正在支付');
                if(is_weixin==1){

                    jsApiCall();
                }else{
                    var token     = '{{csrf_token()}}';
//                    var username = $("#username").val();
//                    var phone = $("#tel").val();
//                    var code = $("#vcode").val();
//                    if(username == ''){
//                        layer.msg('请填写姓名');
//                        return false;
//                    }
//                    if(phone == ''){
//                        layer.msg('请填写手机号');
//                        return false;
//                    }
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
                        data:{_token:token,tf_class_id:tf_course_class_id},
                        dataType:"json",
                        success:function(result){
                            if(result.code==0){
                                console.log(result.objectxml.mweb_url);
                                //follow_us();
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
            var _token = '{{csrf_token()}}';
//            var username = $("#username").val();
//
//            var phone = $("#tel").val();
//            var code = $("#vcode").val();
//            if(username == ''){
//                layer.msg('请填写姓名');
//                return false;
//            }
//            if(phone == ''){
//                layer.msg('请填写手机号');
//                return false;
//            }
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
            var data = {_token:_token,tf_class_id:tf_course_class_id};
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