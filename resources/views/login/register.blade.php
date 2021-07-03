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
    <title>注册-赛普健身社区</title>
    <meta name="author" content="络绎" />
    <meta name="keywords" content="健身,健身教练,赛普课堂,赛普知道" />
    <meta name="description" content="赛普健身社区作为健身教练从业者的终身学习平台，致力于为您提供精品学习资源和优质教学服务，助力您实现岗位和薪资的双重跃迁。课程覆盖基础私教健身、功能性、普拉提、孕产、康复、增肌、减脂、等多个前沿技术领域。" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/my.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/css/font-num40.css">
</head>
<body class="page_reg pt0" ontouchstart>

<!-- 绑定手机号 start -->
<div class="form_container MyWrap pt40">
    <h4 class="f50 color_333 bold pt40 mt30">填写手机号完成登录</h4>
    <p class="f26 fz color_gray666 pb30 mb30">登录后可以进行更深入的互动</p>
    <form method="post" action="" id="regForm">
        <ul>
            <li>
                <div class="wrap clearfix">
                    <input type="text" id="tel" placeholder="请输入您的手机号码" class="ipt tel" />
                </div>
            </li>
            <li>
                <div class="wrap clearfix">
                    <input type="text" id="code" placeholder="请输入您的验证码" class="ipt vcode" />
                    <span class="weui-btn vcodeBtn bgc_yellow grey">获取验证码</span>
                </div>
            </li>
            <li>
                <div class="selectSf text_center">
                    <h3 class="ptb30 mb30 color_gray666 f30"><i></i>请选择您的身份<i></i></h3>
                    <div class="selectSfList text_center">
                        <ul class="clearfix fz f28">
                            <li>
                                <input type="radio" name="job" value="健身教练" id="11">
                                <label for="11">健身教练</label>
                            </li>
                            <li>
                                <input type="radio" name="job" value="教练经理" id="12">
                                <label for="12">教练经理</label>
                            </li>
                            {{--<li>--}}
                                {{--<input type="radio" name="job" value="健身房店长 健身爱好者" id="13">--}}
                                {{--<label for="13">健身房店长</label>--}}
                            {{--</li>--}}
                            <li>
                                <input type="radio" name="job" value="想了解健身教练" id="15" checked>
                                <label for="15">想了解健身教练</label>
                            </li>
                            <li>
                                <input type="radio" name="job" value="想了解健身" id="14">
                                <label for="14">想了解健身</label>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>

            <li class="MysubmitBtn plr30 bgcolor_fff">
                <input type="button" value="完成登录" onclick="userRegister()" class="submitBtn  bgcolor_orange border-radius-img f34 color_333" />
                {{--<a href="/finish/bind"/>绑定成功</a>--}}
            </li>
        </ul>
    </form>
</div>
<!-- 绑定手机号 end -->


<br><br><br><br>
<script src="/lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/icheck/js/icheck.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/js/js.js"></script>
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
    $(function(){
        //发送验证码
        $('.vcodeBtn').click(function (){

            var tel = $('#tel').val();
            if(!tel || !/1[1-9]{1}[0-9]{9}/.test(tel)){
                layer.msg('请输入有效的手机号码');
            }else{
                var token = '{{csrf_token()}}';
                var mobile = $("#tel").val();
                var data = {mobile:mobile,_token:token};
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
    function userRegister(){

        var mobile = $("#tel").val();
        var token = '{{csrf_token()}}';
        var code = $('#code').val();
//            var password = $('#password').val();

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
        var job = $("input[name='job']:checked").val();
//            if(password.length < 6 || password.length > 20){
//                $(".passwd_error").text('密码必须在6-20位字符之间');
//                return;
//            }else{
//                $(".passwd_error").text('');
//            }

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
        var data = {mobile:mobile,verifyCode:code,_token:token,share_id:share_id,channel:channel,from:from,utm_source:utm_source,utm_medium:utm_medium,job:job};
        $.ajax({
            url:'/user/register',
            type:'POST',
            data:data,
            dataType:'json',
            success:function(data){
                layer.close(index);
                if(data.code == 0){
//                        var url = localStorage.getItem('redirect');
                    layer.msg(data.message);
//                        if(url !='' && url != null){
//                            localStorage.removeItem('redirect');
//                            window.location.href = url;
//                        }else{
//                            window.location.href = '/';
//                        }
                    window.location.href="/finish/bind";
//                        localStorage.removeItem('from');
//                        localStorage.removeItem('utm_source');
//                        localStorage.removeItem('utm_medium');
//                        gio('track', 'register');
                }else {
                    layer.msg(data.message);
//                        $(".code_error").text(data.message);
//                    }else if(data.code == 2){
//                        $(".mobile_error").text(data.message);
//                    }else if(data.code == 3){
//                        $(".passwd_error").text(data.message);
//                    }else if(data.code == 4){
//                        $(".mobile_error").text(data.message);
//                    }else if(data.code == 5){
//                        $(".mobile_error").text(data.message);
                }
            }
        });
    }
</script>
</body>
</html>