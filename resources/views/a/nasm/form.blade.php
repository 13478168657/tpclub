<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>NASM-CPT认证私人教练课程-表单页</title>
    <meta name="author" content="涵" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" >

    <!--本css-->
    <link rel="stylesheet" href="/css/zt/zt_nasm.css?t=1.0">

    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
</head>
<body>
<div>
    <!-- nav start-->
    <img src="/images/zt/nasmcpt/nav.jpg" alt="NASM-CPT认证私人教练课程">
    <!-- nav end-->
    <!-- banner start-->
    <div class="banner">
        <img src="/images/zt/nasmcpt/pub_tit.jpg" alt="">
    </div>
    <!-- banner end-->
    <!--表单start-->
    <div class="biaodan plr50">
        <div class="form plr40 fz color_333 f24 bgcolor_fff text_center border-radius-img">
            <p class="mb40 text_center fz f30 color_redff3000">剩余优惠名额:{{$restNum}}个</p>
            <ul>
                <li class="clearfix mb30">
                    <span class="block fl text_center">姓名</span>
                    <input class="fr" type="text" name="name" placeholder="请输入你的真实姓名">
                </li>
                <li class="clearfix">
                    <span class="block fl text_center">身份证号</span>
                    <input class="fr" name="idCard" type="text" placeholder="请输入你的身份证号码">
                </li>
            </ul>
            {{--@if($mobile)--}}
                <button class="form_btn border-radius-img bgcolor_orange color_333 lt f30">查询4700元学NASM资格<img src="/images/zt/nasmcpt/zhua.png" alt=""></button>
            {{--@else--}}
                {{--<button class="border-radius-img bgcolor_orange color_333 lt f30" onclick="userlogin();">查询4700元学NASM资格<img src="/images/zt/nasmcpt/zhua.png" alt=""></button>--}}
            {{--@endif--}}
        </div>
    </div>
    <!--表单end-->
    <!-- 底部 start-->
    <div class="foot foot_btn text_center">
        <ul>
            <li><a href="javascript:void (0)" class="block color_fff f26 fz">4700元学NASM活动截止时间：2019年12月5日</a></li>
        </ul>
    </div>
    <!-- 底部 end-->

</div>


<br><br><br>
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script>

    //跳转登陆函数
    var userlogin = function(){
        var url = "/nasm/form.html";
        localStorage.setItem("redirect", url);

        layer.msg('请先注册');
        setTimeout(function(){
            window.location.href = "/register";
        }, 500)
    }
    $(function(){
        $(".form_btn").click(function(){

            var mobile= '{{$mobile}}';
//            alert(3);
            if(mobile == ''){
                window.location.href="/login?redirect=/nasm/form.html";
                return false;
            }
            var name = $("input[name='name']").val();
            var card = $("input[name='idCard']").val();
            var token = '{{csrf_token()}}';
            var data = {name:name,card:card,_token:token};

            $.ajax({
                url:'/nasm/info/verify',
                data:data,
                type:'POST',
                dataType:'json',
                success:function(res){
                    if(res.code == 0){
                        window.location.href="/nasm/info/"+res.data.satisfy+".html";
                    }
                }
            });
        });
    })

</script>
</body>
</html>
