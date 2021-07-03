<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普转介绍人发展计划</title>
    <meta name="author" content="" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />

    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" >

    <!--本css-->
    <link rel="stylesheet" href="/css/zt/zt_zhuanjieshao.css?t={{time()}}">

    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
    <style>
        .scroll-wrapper {
            -webkit-overflow-scrolling: touch;
            overflow-y: scroll;
        }
        .disabled1{
            background-color: #ccc !important;
            color: #fff !important;
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>
</head>
<body>

<div>
   <!--  <img src="/images/zt/zhuanjieshao/page3_banner1.jpg" alt="">
    <img src="/images/zt/zhuanjieshao/page3_banner2.jpg" alt=""> -->
   <!--  <img src="/images/zt/zhuanjieshao/page3_img1.jpg" alt="">
    <img src="/images/zt/zhuanjieshao/page3_img2.jpg" alt="">
    <img src="/images/zt/zhuanjieshao/page3_img3.jpg" alt="">
    <img src="/images/zt/zhuanjieshao/page3_img4.jpg" alt=""> -->
    <img src="/images/zt/zhuanjieshao/page3_img5.jpg" alt="">
</div>

<!--弹出的内容 start-->
<div class="pop_form_success_layer text_center zhuan-img-pop  aa hide">
    <p class="fz color_ffd700 f36 ptb30 mb30">加入申请</p>
    <div class="form form-page3 fz mlr30">
        <div class="input mb20">
            <input type="text" id="name" name="name" placeholder="请输入姓名或昵称" class="border-radius-img f30">
        </div>
        <div class="input mb20">
            <input type="text" id="tel" name="mobile" placeholder="请输入手机号" class="border-radius-img f30">
        </div>
        {{--<div class="input mb20">--}}
            {{--<input type="text" id="idcard" name="idcard" placeholder="请输入身份证号" class="border-radius-img f30">--}}
        {{--</div>--}}
        <div class="input clearfix">
            <input type="text" id="code" placeholder="请输验证码" class="border-top-left-bottom f30  fz bgcolor_fff mb20 yzm fl">
            <span class="vcodeBtn yzm-huoqu fr bgcolor_fff border-top-right-bottom f26">获取验证码</span>
        </div>
        <div class="wrap3 clearfix pt10 color_fff">
            <label class="radio_wrap fl">
                <input type="radio" name="sex" class="radio" checked>同意
            </label>
            <a href="javascript:void (0)" class="underline fl color_fff click-tiaoli2">赛普转介绍人保密条款</a>
        </div>
        <a href="javascript:void(0);" class="pop-btn-a pop-btn-a-page3 bg_ffd700 color_4a fz f26 border-radius-img cj joinPartner box-show-0004 mt30 btn_jianrong">加入赛普转介绍人</a>
        <a href="javascript:void (0)" class="color_fff text_right block underline pt10 join2">老学员已换号？</a>
    </div>
</div>
<!--弹出的内容 end-->

<!--弹出的内容2 1个btn start-->
<div class="pop_form_success_layer text_center zhuan-img-pop form2 hide">
    <!--<img src="../images/zt/zhuanjieshao/1.png" class="bm_success pt40" alt="" />-->
    <p class="fz color_ffd700 f36 pt105 pb30">入学时的手机号</p>
    <div class="form fz pt20">
        <div class="input mb40">
            <input type="text" name="originMobile" placeholder="请输入手机号" class="border-radius-img f30">
        </div>
        <a href="javascript:void (0)" class="pop-btn-a bg_ffd700 color_4a fz f26 plr45 border-radius-img join3 cj">确认</a>
    </div>
</div>
<!--弹出的内容2 1个btn end-->


<!--弹出的内容 start-->
<div class="pop_form_success_layer text_center zhuan-img-pop  form3 hide">
    <p class="fz color_ffd700 f36 ptb30 mb30">加入申请</p>
    <div class="form form-page3 fz mlr30">
        <div class="input mb20">
            <input type="text" name="userName" placeholder="请输入姓名" class="border-radius-img f30">
        </div>
        <div class="input mb20">
            <input type="text" name="newMobile" placeholder="请输入手机号" class="border-radius-img f30">
        </div>
        <div class="input clearfix">
            <input type="text" name="newCode" placeholder="请输验证码" class="border-top-left-bottom f30  fz bgcolor_fff mb20 yzm fl">
            <span class="vcodeBtn yzm-huoqu fr bgcolor_fff border-top-right-bottom f26">获取验证码</span>
        </div>
        <div class="wrap3 clearfix pt10 color_fff">
            <label class="radio_wrap fl">
                <input type="radio" name="sex" class="radio" checked>同意
            </label>
            <a href="javascript:void (0)" class="underline fl color_fff click-tiaoli2 ">网站服务条款</a>
        </div>
        <a href="javascript:void (0)" class="pop-btn-a pop-btn-a-page3 bg_ffd700 color_4a fz f26 border-radius-img box-show-0004 cj joinPartner">加入赛普转介绍人</a>

    </div>
</div>
<!--弹出的内容 end-->


@if(!$is_staff)
<div>
    <!--悬浮btn start-->
    <div class="text_center relative">
        <a href="javascript:void (0)" class="btn-pos block bg_ffd700 color_222 f28 fz join">现在加入</a>
    </div>
    <!--悬浮btn end-->
</div>
@endif
@if($is_staff)
<!--弹出分享 start-->
<div class="bb">
   <div class="bm_success_layer text_center tan-font color_fff f32 fz pt105 fx-img" >
      <img src="/images/fenxiang-j.png" class="bm_success down-arrow" id="dou" alt="" />
      <p class="pt105 color_fff f36 fz bold ">点击这里分享吧！</p >
      <p class="text_left pl135 pt70 pb30">1、点击“<img src="/images/more.png" alt="" class="d-in-black more-s">”</p>
      <p class="text_left pl135">2、点击“<img src="/images/pyq.png" alt="" class="d-in-black more-s">”分享到朋友圈</p >
      <!--<p class="pt70 mt16 f36 bold mb10">分享成功</p ><p class="f36 bold">即可记为打卡成功哦~</p >-->
   </div>
</div>
<!--弹出分享 end-->
@endif
<br><br>
<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/icheck/js/icheck.min.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/js/js.js"></script>
<script>
    //给本页面加背景颜色
    $('body').css('background-color','#db473a');
    var s_id = '{{$staff_id}}';
    var originMobile = '';
    var flag = 0;
    //弹出
    $(function (){
        //弹窗
        $('.join').click(function(){
            var token = '{{csrf_token()}}';
            var user_id = "{{$user_id}}";
            $.ajax({
                url:'/intro/staff/click',
                type:'POST',
                data:{user_id:user_id, _token:token},
                dataType:'json',
                success:function(res){
                    console.log(res);
                }
            });
            flag = 0;
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'pop_form_layer_wrap_page3', //样式类名
                id: 'pop_form_success_layer', //设定一个id，防止重复弹出
                closeBtn: 0, //不显示关闭按钮
                anim: 2,
                shade: [.5,'#222222'],
                shadeClose: true, //开启遮罩关闭
                area: ['100%', '80%'],
                content:$('.aa'),
                btn:false,
                success:function(res){
                    $('.cj').removeClass('disabled1');
                    $('.cj').text('加入赛普转介绍人');
                }
            });
        });

        $('.click-tiaoli2').click(function(){
            //弹出即全屏
            var index = layer.open({
                type: 2,
                title:['.','color:#fff'],
                content: '/intro/explain.html',
                area: ['100%', '100%'],
                maxmin: true,
                success: function(layero){
                    $(layero).addClass("scroll-wrapper");//苹果 iframe 滚动条失效解决方式
                }
            });
            layer.full(index);
        });


        //发送验证码
        $('.vcodeBtn').click(function (){
            if(flag == 1){
                var tel = $("input[name='newMobile']").val();
            }else{
                var tel = $('#tel').val();
            }

            if(!tel || !/1[1-9]{1}[0-9]{9}/.test(tel)){
                layer.msg('请输入有效的手机号码');
            }else{
                var token = '{{csrf_token()}}';
                var data = {mobile:tel,_token:token};
                $.ajax({
                    url:'/intro/code/send',
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
        //单选按钮
        $('.radio').iCheck({
            //checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio',
            increaseArea: '20%'
        });
    });

    $(document).on("click", ".joinPartner", function() {
        if(flag == 1){
            var name = $("input[name='userName']").val();
            var mobile = $("input[name='newMobile']").val();
            var code = $("input[name='newCode']").val();
        }else{
            var name = $("#name").val();
            var mobile = $("#tel").val();
            var code = $('#code').val();
        }

        var token = '{{csrf_token()}}';
        if(!name){
            layer.msg('请输入姓名');
            return false;
        }

        if(!mobile || !/1[1-9]{1}[0-9]{9}$/.test(mobile)){
           layer.msg('请输入有效的手机号码');
            return false;
        }else{
            $(".mobile_error").text('');
        }
        if(!code){
            layer.msg('请输入正确的验证码');
            return;
        }
        $('.cj').addClass('disabled1');
        $('.cj').text('请稍等...');
        if(flag == 1){
            var data = {originMobile:originMobile,name:name,mobile:mobile,code:code,s_id:s_id,_token:token};
        }else{
            var data = {name:name,mobile:mobile,code:code,s_id:s_id,_token:token};
        }

        $.ajax({
            url:'/partner/join',
            type:'POST',
            data:data,
            dataType:'json',
            success:function(data){
                if(data.code == 0){
                    layer.msg(data.message);
                    setTimeout(function(){
                        window.location.href = '/intro/partnerList';
                    }, 0);
                    return false;
                }else{
                    $('.cj').removeClass('disabled1');
                    $('.cj').text('加入赛普转介绍人');
                    layer.msg(data.message);
                }
            }
        });
    });
    $(document).on("click", ".join3", function() {
        originMobile = $("input[name='originMobile']").val();
        if(!originMobile || !/1[1-9]{1}[0-9]{9}$/.test(originMobile)){
            layer.msg('请输入有效的手机号码');
            return false;
        }
        var data = {mobile:originMobile,_token:'{{csrf_token()}}'};
        $('.cj').addClass('disabled1');
        $('.cj').text('请稍等...');
        $.ajax({
            url:'/intro/partner/judge',
            type:'POST',
            data:data,
            dataType:'json',
            success:function(data){
                $('.cj').removeClass('disabled1');
                $('.cj').text('确认');
                if(data.code == 0){
                    flag = 1;
                    layer.closeAll();
                    $('.cj').text('加入赛普合伙人');
                    layer.open({
                        type: 1,
                        title: false, //不显示标题栏
                        skin: 'pop_form_layer_wrap_page3', //样式类名
                        id: 'pop_form_success_layer3', //设定一个id，防止重复弹出
                        closeBtn: 0, //不显示关闭按钮
                        anim: 2,
                        shade: [.8,'#222222'],
                        shadeClose: true, //开启遮罩关闭
                        area: ['80%', '50%'],
                        content:$('.form3'),
                        btn:false
                    });
                }else{
                    layer.msg(data.message);
                }
            }
        });
    });
    //分享弹窗
    var is_staff = "{{$is_staff}}";
    if(is_staff==1){
        layer.open({
          type: 1,
          title: false, //不显示标题栏
          skin: 'fxpyq_success_layer_wrap', //样式类名
          id: 'fxpyq_success_layer', //设定一个id，防止重复弹出
          closeBtn: 0, //不显示关闭按钮
          anim: 2,
          shade:[0.7, '#000'],
          shadeClose: true, //开启遮罩关闭
          area: ['90%', '80%'],
          content: $('.bb'),
          btn: false
       });
    }
    /*点击文字也可以全部关闭*/
    $('.bm_success_layer').click(function(){
       parent.layer.closeAll()
    });


    //弹窗[1个btn的表单]
    $('.join2').click(function(){
        layer.closeAll();
        $('.cj').text('确认');
        flag = 1;
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'pop_form_layer_wrap2', //样式类名
            id: 'pop_form_success_layer2', //设定一个id，防止重复弹出
            closeBtn: 0, //不显示关闭按钮
            anim: 2,
            shade: [.8,'#222222'],
            shadeClose: true, //开启遮罩关闭
            area: ['80%', '50%'],
            content:$('.form2'),
            btn:false
        });
    });

</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: "{{$WechatShare['appId']}}", // 必填，公众号的唯一标识
        timestamp: "{{$WechatShare['timestamp']}}", // 必填，生成签名的时间戳
        nonceStr: "{{$WechatShare['noncestr']}}", // 必填，生成签名的随机串
        signature: "{{$WechatShare['signature']}}",// 必填，签名
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
        ] // 必填，需要使用的JS接口列表
    });
    var desc    = '赛普转介绍人招募计划正在进行中，更有升级奖励可拿，你懂得~';
    var title   = '赛普转介绍人进阶计划';
    var link = 'http://m.saipubbs.com/intro/partner/{{$staff_id}}.html';
    var imgUrl = 'http://m.saipubbs.com/images/zt/share.png';
    var content = '';
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: imgUrl, // 分享图标
            success: function(){
                /*----分享获得赛普币end----*/
            },
            cancel:function(){

            }
        }, function(res) {
            //这里是回调函数

        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: title, // 分享标题
            link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: imgUrl, // 分享图标
            success: function(){


            },
            cancel:function(){

            }
        }, function(res) {
            //这里是回调函数

        });
    });
</script>

</body>
</html>
