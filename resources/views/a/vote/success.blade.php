<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>支付成功</title>
    <meta name="author" content="" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <script src="/js/rem.js" type="text/javascript"></script>
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.css" rel="stylesheet" type="text/css" />
    <link href="/css/reset_phone.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" type="text/css" />
    <link href="/css/toufang.css?t=1.12" rel="stylesheet">
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
                    <p class="weui-media-box__desc f34 mt20">12小时精品职业课+7天国 家教练讲堂。</p>
                </div>
            </a>
        </div>
    </div>
    <!-- 课程详情 end -->
    <!-- 课程详情列表 start -->
    <div class="weui-cells course_details_list mt20 fs30 bold">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>普通课时</p>
            </div>
            <div class="weui-cell__ft">12课时</div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>套餐类型</p>
            </div>
            <div class="weui-cell__ft">不限</div>
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
            <div class="weui-cell__ft">¥{{$tfCourseClass->price}}</div>
        </div>
    </div>
    <div class="weui-cells course_details_list mt20 fs30 bold">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>优惠</p>
            </div>
            <div class="weui-cell__ft">-¥{{$tfCourseClass->price-$tfCourseClass->team_price}}</div>
        </div>
        <div class="weui-cell shijizhifu">
            <div class="weui-cell__bd">
                <p>实际支付</p>
            </div>
            <div class="weui-cell__ft"><strong class="pintuanjiaBtn">拼团价</strong>¥{{$tfCourseClass->team_price}}</div>
        </div>
    </div>
    <!-- 课程详情列表 end -->
</div>
<!-- 我要开团页 end -->

<!-- 底部固定条 start -->
<div class="fixed_bar_bot">
    <div class="w750 btns plr20 bold">
        <div class="payBtn jianbian_button_yellow f36">支付成功</div>
    </div>
</div>
<!-- 底部固定条 end -->
<!-- 支付表单弹窗 start -->
<div class="zhifu_form_layer hide">
    <div class="container bold">
        <h3 class="f30 text_center pt40 pb50">请您注册登录</h3>
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
            <a href="javascript:void(0)" class="payNowBtn jianbian_button_yellow f36">立即注册</a>
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
    var is_submit = 0;  //是否提交信息默认否
    $(function () {
        //底部立即支付
        var index={};

        layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'zhifu_form_layer_wrap', //样式类名
                id: 'zhifu_form_layer', //设定一个id，防止重复弹出
                closeBtn: 1, //不显示关闭按钮
                anim: 2,
                shadeClose: false, //开启遮罩关闭
                area: ['90%', '60%'],
                content:$('.zhifu_form_layer'),
                btn:false,
                // cancel: function(){
                //     layer.open({
                //         type: 1,
                //         title: false, //不显示标题栏
                //         skin: 'qr_form_layer_wrap', //样式类名
                //         id: 'qr_form_layer', //设定一个id，防止重复弹出
                //         closeBtn: 1, //不显示关闭按钮
                //         anim: 2,
                //         shadeClose: false, //开启遮罩关闭
                //         area: ['90%', '60%'],
                //         content:$('.qr_form_layer'),
                //         btn:false
                //     });
                // }
            });


        var user_id   = "{{$user_id}}";      //用户id
        var tf_course_class_id = "{{$tfCourseClass->id}}";  //购买投放课程id
        //20200210 记录记录微信页面点击册数
        var data = {type:"wx_click_num",user_id:user_id, tf_course_class_id:tf_course_class_id};
        $.ajax({
            url:'/tf/click',
            data:data,
            type:'GET',
            dataType:'json',
            success:function(res){
            }
        });
        $('.payNowBtn').click(function (){
                layer.msg('正在提交');
                var token     = '{{csrf_token()}}';
                var username = $("#username").val();
                var phone = $("#tel").val();
                var code = $("#vcode").val();
                if(username == ''){
                    layer.msg('请填写姓名');
                    return false;
                }
                if(phone == '') {
                    layer.msg('请填写手机号');
                    return false;
                }

                //20200211 记录记录确认订单信息点击次数
                $.ajax({
                    url:'/tf/click',
                    data:{type:"order_click_num",user_id:user_id, tf_course_class_id:tf_course_class_id},
                    type:'GET',
                    dataType:'json',
                    success:function(res){
                    }
                });

                $.ajax({
                    type:"POST",
                    url:"/tf/info/add",
                    data:{_token:token,tf_class_id:tf_course_class_id,username:username,phone:phone,code:code},
                    dataType:"json",
                    success:function(result){

                        if(result.code==0){
                            is_submit = 1;    //表明已提交信息
                            layer.closeAll(); //疯狂模式，关闭所有层
                            //正如你看到的，每一种弹层调用方式，都会返回一个index
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
                        }else if(result.code==2){
                            window.location.href='/tf/result/'+tf_course_class_id+'.html';
                        }else{
                            layer.msg(result.message);
                        }
                    }
                });

        });


        //二维码弹窗
        $('.payBtn').click(function(){
//            clearTimeout(timer);
            //如果已提交信息  弹出二维码
            if(is_submit==1){
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
            }else{
                //如果没有提交弹出  注册信息弹框
                layer.open({
                    type: 1,
                    title: false, //不显示标题栏
                    skin: 'zhifu_form_layer_wrap', //样式类名
                    id: 'zhifu_form_layer', //设定一个id，防止重复弹出
                    closeBtn: 1, //不显示关闭按钮
                    anim: 2,
                    shadeClose: false, //开启遮罩关闭
                    area: ['90%', '60%'],
                    content:$('.zhifu_form_layer'),
                    btn:false
                });
            }
            
        });

        //弹窗里的立即支付

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

    })
    //针对苹果手机键盘的复位
    $("input").blur(function () {
        setTimeout(function() {
            var scrollHeight = document.documentElement.scrollTop || document.body.scrollTop || 0;
            window.scrollTo(0, Math.max(scrollHeight - 1, 0));
        }, 100);
    });

</script>
</body>

</html>