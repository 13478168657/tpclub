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
    <title>绑定手机号</title>
    <meta name="author" content="涵涵" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/my.css?t=1.1" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/css/font-num40.css">
</head>
<body class="page_reg pt0" ontouchstart>

<!-- 绑定手机号 start -->
<div class="form_container MyWrap pt40">
    @if($flag)
    <h4 class="f50 color_333 bold pt40 mt30">重新绑定手机号</h4>
    @else
    <h4 class="f50 color_333 bold pt40 mt30">绑定手机号</h4>
    @endif
    <p class="f26 fz color_gray666 pb30 mb30">绑定手机号后你就可以进行更深入的互动了</p>
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
            @if(!$flag)
            <li>
                <div class="selectSf text_center">
                    <h3 class="ptb30 mb30 color_gray666 f30"><i></i>请选择您的身份<i></i></h3>
                    <div class="selectSfList text_center">
                        <ul class="clearfix fz f28">
                            <li>
                                <input type="radio" name="job" value="健身教练" id="11" checked>
                                <label for="11">健身教练</label>
                            </li>
                            <li>
                                <input type="radio" name="job" value="健身经理" id="12">
                                <label for="12">健身经理</label>
                            </li>
                            <li>
                                <input type="radio" name="job" value="健身房店长" id="13">
                                <label for="13">健身房店长</label>
                            </li>
                            <li>
                                <input type="radio" name="job" value="健身创业者" id="14">
                                <label for="14">健身创业者</label>
                            </li>
                            <li>
                                <input type="radio" name="job" value="健身爱好者" id="15">
                                <label for="15">健身爱好者</label>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            @endif

            <li class="MysubmitBtn plr30 bgcolor_fff">
                <input type="button" value="完成绑定" class="submitBtn  bgcolor_orange border-radius-img f34 color_333" />
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
    $(function(){
        //发送验证码
        $('.vcodeBtn').click(function (){
            var tel = $('#tel').val();
            var flag = 3;
            if(!tel || !/1[3-9]{1}[0-9]{9}/.test(tel)){
                layer.msg('请输入有效的手机号码');
            }else{
                var token = '{{csrf_token()}}';
                var mobile = tel;
                var data = {mobile:mobile,_token:token,flag:flag};
                $.ajax({
                    url:'/send/acode',
                    type:'POST',
                    data:data,
                    dataType:'json',
                    success:function(res){
                        if(res.code == 1){
                            layer.msg(res.message);
                        }else{
                            settime($('.vcodeBtn'),60);
                            layer.msg(res.message);
                        }
                    }
                });
            }
        })
        $(".submitBtn").click(function(){

            var mobile = $("#tel").val();
            var job = $("input[name='job']:checked").val();
            var code = $("#code").val();
            alert(job);
            var _token = '{{csrf_token()}}';

            var data = {mobile:mobile,job:job,code:code,_token:_token};
            $.ajax({
                url:'/bind/mobile',
                data:data,
                type:'POST',
                dataType:'json',
                success:function(res){
                    if(res.code == 0){
                        layer.msg(res.message);
                        window.location.href="/finish/bind";
                    }else{

                        layer.msg(res.message);
                    }
                }
            })

        });
        //单选按钮
        $('.radio').iCheck({
            //checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio',
            increaseArea: '20%'
        });
    })
</script>
</body>
</html>