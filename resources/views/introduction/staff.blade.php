<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普百亿俱乐部</title>
    <!-- <title>赛普百亿（1%）共创未来计划</title> -->
    <meta name="author" content="" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />

    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" >

    <!--本css-->
    <link rel="stylesheet" href="/css/zt/zt_zhuanjieshao.css">

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
    <img src="/images/zt/zhuanjieshao/zmyg_img1.jpg" alt="">
    <!-- <img src="/images/zt/zhuanjieshao/zmyg_img2.jpg" alt="">
    <img src="/images/zt/zhuanjieshao/zmyg_img3.jpg" alt="">
    <img src="/images/zt/zhuanjieshao/zmyg_img4.jpg" alt="">
    <img src="/images/zt/zhuanjieshao/zmyg_img5.jpg" alt="">
    <img src="/images/zt/zhuanjieshao/zmyg_img6.jpg" alt="">
    <img src="/images/zt/zhuanjieshao/zmyg_img7.jpg" alt="">
    <img src="/images/zt/zhuanjieshao/zmyg_img8.jpg" alt="">
    <img src="/images/zt/zhuanjieshao/zmyg_img9.jpg" alt=""> -->

</div>

<!--弹出的内容 start-->
<div class="pop_form_success_layer text_center zhuan-img-pop  aa hide">
    <img src="/images/zt/zhuanjieshao/1.png" class="bm_success pt40" alt="" />
    <p class="fz color_ffd700 f36 ptb20">赛普共创未来计划</p>
    <div class="form fz">
        <div class="input mb40">
            <input type="text" name="mobile" value="" placeholder="请输入手机号" class="border-radius-img f30">
            <p class="color_fff f26 ptb13">请使用员工入职留电手机号</p>
        </div>
        <a href="javascript:;" class="pop-btn-a bg_ffd700 color_4a fz f26 plr45 border-radius-img joinPlan btn_jianrong">确认加入</a>
        <!-- <a onclick="joinPlan();" class="pop-btn-a bg_ffd700 color_4a fz f26 plr45 border-radius-img joinPlan">确认加入</a> -->
    </div>
</div>
<!--弹出的内容 end-->


<div>
    <!--悬浮btn start-->
    <div class="text_center relative">
        <a href="javascript:void (0)" class="btn-pos block bg_ffd700 color_222 f28 fz join">加入共创未来计划</a>
    </div>
    <!--悬浮btn end-->
</div>




<br><br>
<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script>
    //给本页面加背景颜色
    $('body').css('background-color','#cd701d');

    //弹出
    $(function (){
        //弹窗
        $('.join').click(function(){
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'pop_form_layer_wrap', //样式类名
                id: 'pop_form_success_layer', //设定一个id，防止重复弹出
                closeBtn: 0, //不显示关闭按钮
                anim: 2,
                shade: [.8,'#222222'],
                shadeClose: true, //开启遮罩关闭
                area: ['80%', '70%'],
                content:$('.aa'),
                btn:false
            });
        })
    })
    function joinPlan(){
        layer.msg("请稍等");
        var mobile = $("input[name='mobile']").val();
        if(mobile == ''){
            layer.msg('手机号不能为空');
            return false;
        }
        var data = {mobile:mobile,_token:'{{csrf_token()}}'};
        $.ajax({
            url:'/staff/join',
            data:data,
            type:'POST',
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    layer.msg(res.message);
                    window.location.href='/intro/staffList';
                }else{
                    layer.msg(res.message);
                }
            }
        });
    }

    

    $(document).on("click", ".joinPlan", function() {

        var mobile = $("input[name='mobile']").val();
            if(mobile == ''){
                layer.msg('手机号不能为空');
                return false;
            }
            var data = {mobile:mobile,_token:'{{csrf_token()}}'};
            $.ajax({
                url:'/staff/join',
                data:data,
                type:'POST',
                dataType:'json',
                success:function(res){

                    if(res.code == 0){
                        alert(res.message);
                        setTimeout(function(){
                            window.location.href = '/intro/staffList';
                        }, 0);
                        return false;
                    }else{
                        alert(res.message);
                    }
                }
            });
    });
</script>
</body>
</html>
