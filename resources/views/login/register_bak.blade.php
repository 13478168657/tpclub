<!DOCTYPE html>
<html lang="zh-CN" class="htmlH100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>注册-赛普健身教练基地</title>
    <meta name="author" content="络绎" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/my.css?t=1" rel="stylesheet" type="text/css" />
	@include('layouts.baidutongji')
</head>
<body class="page_reg pt0" ontouchstart>
<!-- 注册 start -->
<img src="/images/my/logoImg.png" class="logoImg" alt="" />
<div class="form_container">
    <h4 class="yellow fs15 mb10">注册赛普健身社区</h4>
    <form method="post" action="" id="regForm">
        <ul>
            <li>
                <div class="wrap clearfix">
                    <input type="text" id="tel" placeholder="请输入您的手机号码" class="ipt tel" />
                </div>
                <div class="tip mobile_error"></div>
            </li>
            <!-- <li>
                <div class="wrap clearfix">
                    <input type="text" name="imgCode" placeholder="请输入图文验证码" class="ipt vcode" />
                    <span class="weui-btn icma" onclick="changeCode()"><img src='{{captcha_src()}}'/></span>
                </div>
                <div class="tip"></div>
            </li> -->
            <li>
                <div class="wrap clearfix">
                    <input type="text" id="code" placeholder="请输入您的验证码" class="ipt vcode" />
                    <span class="weui-btn vcodeBtn bgc_yellow grey">获取验证码</span>
                </div>
                <div class="tip code_error"></div>
            </li>
            <li>
                <div class="wrap clearfix">
                    <input type="password" placeholder="请填写6-20位字符组成的密码" class="ipt password"  id="password">
                </div>
                <div class="tip passwd_error"></div>
            </li>
            <li>
                <h4 class="fz bold color_333 pt10 pb10 f22">请选择您的职业标签:</h4>
                <div class="select-select fz">
                    <select id="workstatus" name="workstatus" id="">
                        <option value="0">-- 请选择 --</option>
                        <option value="想了解健身教练">想了解健身教练</option>
                        <option value="正在学习健身教练">正在学习健身教练</option>
                        <option value="已经是健身教练">已经是健身教练</option>
                        <option value="毫无兴趣">毫无兴趣</option>
                    </select>
                </div>
                <div class="tip">请选择目前的工作状态</div>
            </li>
            <input type="hidden" name="openid" value="{{$openid}}" />
            <li>
                <div class="wrap3 clearfix pt10">
                    <label class="radio_wrap fl">
                        <input type="radio" name="sex" class="radio" checked>同意<a href="#" class="underline yellow">网站服务条款</a>
                    </label>
                </div>
            </li>
            <li>
                <input type="button" onclick="userRegister();" value="注册" class="weui-btn submitBtn bgc_yellow grey" />
                <div class="wrap2 clearfix">
                    <a href="/login" class="fr"></a>
                </div>
            </li>
        </ul>
    </form>
    <div class="clearfix fz around_circle">
        <a href="/" class="weui-btn mt0 nobefore noafter color_000">随便逛逛</a>
        <a href="/login"  class="weui-btn mt0 nobefore noafter color_000">登录</a>
    </div>
</div>
<!-- 注册 end -->



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


    $(function(){
        //发送验证码
        $('.vcodeBtn').click(function (){
            var imgCode = $("input[name='imgCode']").val();
            if(imgCode == ''){
                layer.msg('请输入图文验证码');
                return false;
            }
            var tel = $('#tel').val();
            if(!tel || !/1[1-9]{1}[0-9]{9}/.test(tel)){
                layer.msg('请输入有效的手机号码');
            }else{
                var token = '{{csrf_token()}}';
                var mobile = $("#tel").val();
                var data = {mobile:mobile,_token:token,imgCode:imgCode};
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

        //单选按钮
        $('.radio').iCheck({
            //checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio',
            increaseArea: '20%'
        });

    })
    function userRegister(){

        var mobile = $("#tel").val();
        var token = '{{csrf_token()}}';
        var code = $('#code').val();
        var password = $('#password').val();
        var workstatus = $("#workstatus").val();


        if(!mobile || !/1[1-9]{1}[0-9]{9}$/.test(mobile)){
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
        if(workstatus==0){
            layer.msg("请选择您的职业标签");
            return;
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
        var from = localStorage.getItem('from');
        if(from == '' || from == null){
            var from  = '';
        }
        var utm_source = localStorage.getItem('utm_source');
        if(utm_source == '' || utm_source == null){
            utm_source = '';
        }

        var utm_medium = localStorage.getItem('utm_medium');
        if(utm_medium == '' || utm_medium == null){
            utm_medium = '';
        }


        var index = layer.load(1, {
          shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
//        var op = $("input[name='openid']").val();
        var data = {mobile:mobile,verifyCode:code,password:password,_token:token,share_id:share_id,channel:channel,from:from,utm_source:utm_source,utm_medium:utm_medium,workstatus:workstatus};
        $.ajax({
            url:'/user/register',
            type:'POST',
            data:data,
            dataType:'json',
            success:function(data){
                layer.close(index);
                if(data.code == 0){
                    var url = localStorage.getItem('redirect');
                    layer.msg('注册成功');
                    if(url !='' && url != null){
                        localStorage.removeItem('redirect');
                        window.location.href = url;
                    }else{
                        window.location.href = '/';
                    }
                    localStorage.removeItem('from');
                    localStorage.removeItem('utm_source');
                    localStorage.removeItem('utm_medium');
                    gio('track', 'register');   //growing  统计代码注册数加1
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
            }
        });
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
</body>
</html>
