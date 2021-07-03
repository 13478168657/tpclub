<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普内部优惠报名通道</title>
    <meta name="author" content="" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" />
    <!--本css-->
    <link rel="stylesheet" href="/css/zt/zt_zhuanjieshao.css"/>

    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
    <style>
        .disabled1{
            background-color: #ccc !important;
            color: #fff !important;
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>
</head>

<body>
  
@if($style==0)
<div class="page5-logo">
    <img src="/images/zt/zhuanjieshao/quanmin_img.jpg"/>
</div>
@else
<div class="page5-logo">
    <img class="" src="/images/zt/zhuanjieshao/junren_img.jpg" alt="">

</div>
@endif


<!--文字 start-->
<!-- <div class="page5-txt color_fff mlr30 plr45 fz f28 pt70 text-jus">
    <p>在这里，</p>
    <p>有的不仅仅是一群高颜值的年轻人，他们不仅仅是别人眼中的翘臀女王，也不仅仅是行走的荷尔蒙。他们是性感、是嘻哈、是Snaker、是兵哥哥、是学霸、是雷鬼……，他们是强者！他们都有同样的信仰，他们相信无坚持，不回报！他们坚持要让强健的体魄布满在华夏土地。在赛普没有弱者！</p>
    <p class="pt70">成为强健的布道者，成为赛普人！</p>
</div> -->
<!--文字 end-->

<!-- <div class="text_center mt70 mb50 pb30">
    <a href="javascript:void (0)" class="page-btn-more text_center border-radius50 color_orange f26 fz">了解更多</a>
</div>
 -->

<!--emmm-->
<!-- <div class="bg_121212 mlr45 border-radius-img text_center page5-jump f34 fz mb60">
    <a class="block color_orange" href="http://m.saipujianshen.com">赛普官网</a>
    {{--<a class="block color_orange ptb45" href="javascript:void (0)">赛普公众号</a>--}}
    <a class="block color_orange" href="http://m.saipubbs.com">赛普健身社区</a>
</div> -->



<div class="page5-pos-con plr88 mb50 pb136 mlr45 border-radius-img">
    <!--弹出的内容 start-->
    <div class="pop_form_success_layer text_center zhuan-img-pop mt60">
        <!-- <p class="fz color_ffd700 f46 bold fz ptb30 mb30">赛普内部优惠报名通道</p> -->
        <!-- <p class="page5-hr plr30 mlr30"></p> -->
        <div class="form form-page3 fz mlr30 mt70">
            <div class="input mb40">
                <input type="text" id="name" placeholder="请输入姓名" class="border-radius-img f30">
            </div>
            <div class="input mb40">
                <input type="text" id="tel" placeholder="请输入手机号" class="border-radius-img f30">
            </div>
            <div class="input clearfix">
                <input type="text" id="code" placeholder="请输验证码" class="border-top-left-bottom f30  fz bgcolor_fff mb40 yzm fl">
                <span class="vcodeBtn yzm-huoqu fr bgcolor_fff border-top-right-bottom f26">获取验证码</span>
            </div>
            <a href="javascript:void(0);" class="pop-btn-a pop-btn-a-page3 bg_ffd700 color_4a fz f26 border-radius-img box-show-0004 btn_jianrong cj userEnroll">点击领取</a>
        </div>
    </div>
    <!--弹出的内容 end-->
</div>

<!-- <div class="text_center color_fff fz f30 page5-pos-f">
    <p class="mb10">当前政策：优惠后再减<strong class="bold">500</strong></p>
    <p>内部工具·请勿对外</p>
</div> -->

@if($is_partner)
<!--弹出分享 start-->
<div class="bb">
    <div class="bm_success_layer text_center tan-font color_fff f32 fz pt105 fx-img" >
        <img src="/images/fenxiang-j.png" class="bm_success down-arrow" id="dou" alt="" />
        <p class="pt105 color_fff f36 fz bold ">点击这里分享吧！</p>
        <p class="text_left pl135 pt70 pb30">1、点击“<img src="/images/more.png" alt="" class="d-in-black more-s">”</p>
        <p class="text_left pl135">2、点击“<img src="/images/pyq.png" alt="" class="d-in-black more-s">”分享到朋友圈</p>
        <!--<p class="pt70 mt16 f36 bold mb10">分享成功</p><p class="f36 bold">即可记为打卡成功哦~</p>-->
    </div>
</div>
<!--弹出分享 end-->
@endif

<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>

<script src="/js/js.js"></script>
<script>
    var p_id = '{{$partner_id}}';
    var path = window.location.href;
    //弹出
    $(function (){
        //发送验证码
        $('.vcodeBtn').click(function (){
            var tel = $('#tel').val();
            if(!tel || !/1[1-9]{1}[0-9]{9}/.test(tel)){
                layer.msg('请输入有效的手机号码');
            }else{
                var token = '{{csrf_token()}}';
                var mobile = $("#tel").val();
                var data = {mobile:mobile,_token:token,flag:1};
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
        })
    })

    $(document).on("click", ".userEnroll", function() {
        var data1 = {p_id:p_id,_token:'{{csrf_token()}}'};
        $.ajax({
            url:'/intro/partner/set',
            type:'POST',
            data:data1,
            dataType:'json',
            success:function(data){

            }
        });
        var name = $("#name").val();
        var mobile = $("#tel").val();
        var token = '{{csrf_token()}}';
        var code = $('#code').val();
        if(!name){
            layer.msg('请输入姓名');
            return false;
        }

        if(!mobile || !/1[1-9]{1}[0-9]{9}$/.test(mobile)){
            layer.msg('请输入有效的手机号码');
            return false;
        }
        if(!code){
            layer.msg('请输入正确的验证码');
            return;
        }
        $('.cj').addClass('disabled1');
        $('.cj').text('请稍等...');
        var data = {name:name,mobile:mobile,code:code,p_id:p_id,path:path,_token:token};
        $.ajax({
            url:'/intro/addReserve',
            type:'POST',
            data:data,
            dataType:'json',
            success:function(data){
                if(data.code == 0){
                    $('.cj').removeClass('disabled1');
                    $('.cj').text('报名');
                    // layer.msg(data.message);
                    alert(data.message);
                }else{
                    $('.cj').removeClass('disabled1');
                    $('.cj').text('报名');
                    // layer.msg(data.message);
                    alert(data.message);
                }
                setTimeout(function(){
                    window.location.href='/intro/share/page?mobile='+mobile;
                }, 500)
                
            }
        });
    });
    //分享弹窗
    var is_partner = "{{$is_partner}}";
    console.log(is_partner);
    if(is_partner==1){
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
    })
    //分享箭头样式
    var i=0;
    $(document).ready(function(){
        setInterval('gaibian()',1000);
    });
    function gaibian(){
        if(i==0){
            i=1;
            $("#dou").removeClass("zhuan_left");
            $("#dou").addClass("zhuan_right");
        }else{
            i=0;
            $("#dou").addClass("zhuan_left");
            $("#dou").removeClass("zhuan_right");
        }
    }
</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    var style = '{{$style}}';
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
    var desc    = '2019赛普健身最低优惠限额开放中，错过再等一年~';
    var title   = '赛普内部优惠报名通道';
    var link = '';
    if(style == 0){
        link = 'http://m.saipubbs.com/intro/reserve/{{$partner_id}}.html';
    }else{
        link = 'http://m.saipubbs.com/intro/reserve/{{$partner_id}}.html?style=1';
    }
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
<script>
    
    //根据风格不同改版颜色
    var bg_class = "{{$style}}";
    if(bg_class==0){
        $('body').addClass('bg_6e7d06');
    }else{
        $('body').addClass('bg_0a1737');
    }
</script>
</body>
</html>