<?php
    if(isset($_GET['redirect'])){
        $redirect = urldecode($_GET['redirect']);
    }else{
        $redirect = '';
    }

?>
<!DOCTYPE html>
<html lang="zh-CN" class="htmlH100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>登录-赛普健身社区</title>
    <meta name="author" content="络绎" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/my.css" rel="stylesheet" type="text/css" />
	@include('layouts.baidutongji')
</head>
<body class="page_login pt0" ontouchstart>
<!-- 登录 start -->
<img src="/images/my/logoImg.png" class="logoImg" alt="" />
<div class="form_container">
    <h4 class="yellow fs15 mb10">登录赛普健身社区</h4>
    <form method="post" action="/user/login" onsubmit="" id="regForm">
        <ul>
            <li>
                <div class="wrap clearfix">
                    <input type="text" id="tel" placeholder="请输入您的手机号码" name="mobile" class="ipt tel" />
                </div>
                <div class="tip mobile_error"></div>
            </li>
            <li>
                <div class="wrap clearfix">
                    <input type="password" placeholder="请填写6-20位字符组成的密码" class="ipt password"  id="password">
                </div>
                <div class="tip passwd_error"></div>
            </li>
            <li>
                <input type="button" onclick="userLogin();" value="登录" class="weui-btn submitBtn bgc_yellow grey" />
                <div class="wrap2 clearfix">
                    <a href="/register" class="fl"></a>
                    <a href="javascript:void(0)"  data-target="#full" class="fr open-popup">忘记密码</a>
                </div>
            </li>
        </ul>
    </form>
    <div class="clearfix fz around_circle">
        <a href="/" class="weui-btn mt0 nobefore noafter color_000">随便逛逛</a>
        <a href="/register"  class="weui-btn mt0 nobefore noafter color_000">注册</a>
    </div>
</div>
<!-- 登录 end -->

<!-- 注册登录弹出框 start -->
<div id="full" class='weui-popup__container page_login'>
    <div class="weui-popup__overlay"></div>
    <div class="weui-popup__modal bgc_white">
        <img src="../images/my/logoImg.png" class="logoImg" alt="" />
        <div class="form_container">
            <h4 class="yellow fs15 mb10">重置密码</h4>
            <form method="post" action="">
                <ul>
                    <li>
                        <div class="wrap clearfix">
                            <input type="text" placeholder="请输入您的手机号码" class="ipt tel" id="mobile" />
                        </div>
                        <div class="tip mobile_error"></div>
                    </li>
                    <li>
                        <div class="wrap clearfix">
                            <input type="text" placeholder="请输入您的验证码" class="ipt vcode" name="code" id="code"/>
                            <span class="weui-btn vcodeBtn bgc_yellow grey">获取验证码</span>
                        </div>
                        <div class="tip code_error"></div>
                    </li>
                    <li>
                        <div class="wrap clearfix">
                            <input type="password" placeholder="设置新密码" class="ipt password" id="newpass">
                        </div>
                        <div class="tip newpass_error"></div>
                    </li>
                    <li>
                        <div class="wrap clearfix">
                            <input type="password" placeholder="确认新密码" class="ipt password" id="renewpass">
                        </div>
                        <div class="tip renewpass_error"></div>
                    </li>
                    <li>
                        <input type="button" value="保存" class="weui-btn submitBtn bgc_yellow grey" onclick="passwordFind();" />
                    </li>
                </ul>
            </form>
        </div>
        <a href="javascript:;" class="colseBtn close-popup"></a>
    </div>
</div>
<!-- 注册登录弹出框 end -->
<script src="/lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
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
</script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/icheck/js/icheck.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/js/js.js"></script>
<script>
    $('.vcodeBtn').click(function (){
        var tel = $('#mobile').val();
        if(!tel || !/1[1-9]{1}[0-9]{9}/.test(tel)){
            layer.msg('请输入有效的手机号码');
        }else{

            var token = '{{csrf_token()}}';
            var mobile = tel;
            var flag=1;
            var data = {mobile:mobile,_token:token,flag:flag};
            $.ajax({
                url:'/send/code',
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

    function test(){
        //alert(111);
        gio('track', 'register');   //growing  统计代码
    }

    function userLogin(){
        //gio('track', 'register');   //growing  统计代码
        var mobile = $("#tel").val();
        var token = '{{csrf_token()}}';
        var password = $('#password').val();

        if(!mobile || !/1[1-9]{1}[0-9]{9}/.test(mobile)){
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
        var data = {mobile:mobile,password:password,_token:token};
        $.ajax({
            url:'/user/login',
            type:'POST',
            data:data,
            dataType:'json',
            success:function(data){
                if(data.code == 0){
                    var url = localStorage.getItem('redirect');
                    if(url !=''){
                        localStorage.removeItem('redirect');
                        window.location.href = url;
                    }else{
                        window.location.href = '/';
                    }
                }else if(data.code == 1){
                    $(".mobile_error").text(data.message);
                }else if(data.code == 2){
                    $(".passwd_error").text(data.message);
                }else if(data.code == 3){
                    $(".passwd_error").text(data.message);
                }
            }
        });
    }

    function passwordFind(){
        var mobile = $("#mobile").val();
        var token = '{{csrf_token()}}';
        var code = $('#code').val();
        var newPass = $.trim($('#newpass').val());
        var renewPass = $.trim($('#renewpass').val());

        if(!mobile || !/13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}$/.test(mobile)){
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
        if(newPass.length < 6 || newPass.length > 20){
            $(".newpass_error").text('密码必须在6-20位字符之间');
            return;
        }else{
            $(".newpass_error").text('');
        }
        if(renewPass.length < 6 || renewPass.length > 20){
            $(".renewpass_error").text('密码必须在6-20位字符之间');
            return;
        }else{
            $(".renewpass_error").text('');
        }
        if(newPass != renewPass){
            $(".renewpass_error").text('两次密码输入不一致');
            return;
        }else{
            $(".renewpass_error").text('');
        }
        var data = {mobile:mobile,'code':code,password:newPass,repassword:renewPass,_token:token};
        $.ajax({
            url:'/forget/password',
            type:'POST',
            data:data,
            dataType:'json',
            success:function(data){
                if(data.code == 0){
                    var url = localStorage.getItem('redirect');
                    if(url != ''){
                        localStorage.removeItem('redirect');
                        window.location.href = url;
                    }else{
                        window.location.href = '/';
                    }
                }else if(data.code == 1 || data.code == 2){
                    $(".mobile_error").text(data.message);
                }else if(data.code == 3){
                    $(".code_error").text(data.message);
                }else if(data.code == 4){
                    $(".renewpass_error").text(data.message);
                }else if(data.code == 5){
                    $(".renewpass_error").text(data.message);
                }
            }
        });
    }
</script>
</body>
</html>
