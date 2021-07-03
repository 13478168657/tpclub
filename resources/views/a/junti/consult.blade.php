<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no"/>
    <title>赛普社区-人工客服-电话回访</title>
    <meta name="author" content="涵涵"/>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css"/>
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" type="text/css" href="/css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="/css/font-num40.css">
    <!-- 本css -->
    <style>
        .cus_tel_box{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .cus_tel_box .Customer_Tel{margin-bottom: 2rem;}
        .cus_tel_box .Customer_Tel img{width: 4.5rem;/*180px;*/margin: 0 auto}

        /*去掉左侧悬浮商务通*/
        #LR_YaoDiv{display:none!important;}

    </style>



    <script>
        (function () {
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth / 18.75 + 'px';
        })()
    </script>
</head>
<body>

<div class="cus_tel_box text_center">
    <div class="Customer_Tel" onclick="ac()">
        <img src="/images/ico_cus.png" alt="" class="img100 block">
        <p class="fz f32 color_333 pt40">点我接通</p>
        <p class="fz bold f32">人工客服</p>
    </div>
    <div class="Customer_Tel clockBtn_point">
        @if($mobile)
            <img src="/images/ico_tel.png" onclick="applyInvite();" alt="" class="img100 block">
        @else
            <img src="/images/ico_tel.png" onclick="userlogin();" alt="" class="img100 block">
        @endif
        <p class="fz f32 color_333 pt40">点我申请</p>
        <p class="fz bold f32 ">课程顾问电话回访</p>
    </div>
    <!--【点我申请】点击判断，未注册到注册-->
    <!--已经注册提示【收到申请，稍后给您致电，如果您着急请点击上面的人工客服】-->
</div>

<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script>
//    $(".clockBtn_point").click(function() {
//
//    })
    function ac(){
        openZoosUrl();
    }

    function applyInvite(){
        var _token = '{{csrf_token()}}';
        $.ajax({
            url:'/jt/user/sync',
            type:'POST',
            data:{_token:_token},
            dataType:'json',
            success:function(res){
                layer.open({
                    title:false,
                    type: 1,
                    skin: 'layui-layer-Customer', //样式类名
                    id: 'layui-layer-Customer',
                    closeBtn: 0, //不显示关闭按钮
                    anim: 2,
                    shadeClose: true, //开启遮罩关闭
                    area: ['80%', 'auto'],
                    content: '<div class="plr30 ptb40 fz f28">收到申请，稍后给您致电，如果您着急请点击上面的<strong class="bold ml10">「 人工客服 」</strong></div>'
                })
            }
        })
    }

    var userlogin = function(){
        var url = "/jt/consult.html?utm_source=saipubbs&utm_medium=military";
        localStorage.setItem("redirect", url);

        layer.msg('请先注册');
        setTimeout(function(){
            window.location.href = "/register";
        }, 500)
    }
</script>

</body>
</html>
<script language="javascript" src="http://shangwutong.saipujiaoyu.com/JS/LsJS.aspx?siteid=MRK72243147&lng=cn"></script>