<!DOCTYPE html>
<html lang="zh-CN" class="htmlH100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>登录-赛普健身教练基地</title>
    <meta name="author" content="络绎" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/my.css" rel="stylesheet" type="text/css" />
</head>
<body class="page_login pt0" ontouchstart>
<!-- 登录 start -->
<img src="/images/my/logoImg.png" class="logoImg" alt="" />
<div class="form_container">
    <h4 class="yellow fs15 mb10">登录赛普健身教练社区</h4>
    <form method="post" action="/user/login" onsubmit="" id="regForm">
        <ul>
            <li>
                <div class="wrap clearfix">
                    <input type="text" id="tel" placeholder="请输入您的手机号码" name="mobile" class="ipt tel" />
                </div>
                <div class="tip mobile_error">请输入有效的手机号码</div>
            </li>
            <li>
                <div class="wrap clearfix">
                    <input type="password" placeholder="请填写6-20位字符组成的密码" class="ipt password"  id="password">
                </div>
                <div class="tip passwd_error">用户名与密码不匹配</div>
            </li>
            <li>
                <input type="button" onclick="userLogin();" value="登录" class="weui-btn submitBtn bgc_yellow grey" />
                <div class="wrap2 clearfix">
                    <a href="/register" class="fl">还没有账号？去注册</a>
                    <a href="/forget/passwd" class="fr open-popup">忘记密码</a>
                </div>
            </li>
        </ul>
    </form>
    <a href="/" class="weui-btn bgc_grey1 grey">随便逛逛</a>
</div>
<!-- 登录 end -->
<script src="/lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
    $(function() {
        FastClick.attach(document.body);
    });
</script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/icheck/js/icheck.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/js/js.js"></script>
<script>

    function userLogin(){
        var mobile = $("#tel").val();
        var token = '{{csrf_token()}}';
        var password = $('#password').val();

        if(!mobile || !/13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}|19[0-9]{9}$/.test(mobile)){
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
                    window.location.href = '/';
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
</script>
</body>
</html>
