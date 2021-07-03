@extends('layouts.header')
@section('title')
    <title>新学期充电福利 助你钱途无量 助力成功</title>
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/newyear_reset.css">
    <link rel="stylesheet" href="/css/newyear_index.css">
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth/18.75 + "px";
        })()
    </script>
    <script>
        var ua = navigator.userAgent.toLowerCase();
        var isWeixin = ua.indexOf('micromessenger') != -1;
        if (!isWeixin) {
            window.location.href = "http://m.saipubbs.com/newyear/erweima.html"
        }
        @if($userid == 7149)
            alert("来晚啦 礼品已被领光");
            setTimeout("location.href='/'",0);
        @endif
    </script>
@endsection

@section('content')

<body class="bg_da463c">
<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->

@if($aid == 4)
    <div class="success mb100">
        <div class="success_top text_center">
            <h2 class="f44 sy_b color_fff mb26 pb30">恭喜您~</h2>
            <p class="f44 sy_b color_fff">{{$num}}位好友成功助力</p>
            <p class="f32 sy_m color_ffd5b4">免费领价值99元的多功能家用收腹机</p>
        </div>
        <div class="success_c pt20 mt30 mb30">
            <img src="/images/new_year/award_img2.jpg" alt="" class="border-radius-img">
        </div>
        <div class="plr45 success_b">
            <p class="bg_ffd5b4 border-radius60 color_da463c f26 pt10 pb10 sy_b text_center">价值99元的多功能家用收腹机</p>
        </div>   
    </div>
   @elseif($aid == 3)
        <div class="success mb100">
            <div class="success_top text_center">
                <h2 class="f44 sy_b color_fff mb26 pb30">恭喜您~</h2>
                <p class="f44 sy_b color_fff">{{$num}}位好友成功助力</p>
                <p class="f32 sy_m color_ffd5b4">免费领价值69元的瑜伽垫</p>
            </div>
            <div class="success_c pt20 mt30 mb30">
                <img src="/images/new_year/award_img1.jpg" alt="" class="border-radius-img">
            </div>
            <div class="plr45 success_b">
                <p class="bg_ffd5b4 border-radius60 color_da463c f26 pt10 pb10 sy_b text_center">价值69元的瑜伽垫</p>
            </div>
        </div>

    @endif
 @if($status->tel == "")
    <!-- 表单 start -->
    <div class="border-radius-img mlr30 bg_c93126 pt10">

        <form method="post" id="teamData" target="teamPost">
            <div class="success_form">
                <div class="succ">
                    <input type="text" id = "name" placeholder="姓名" class="ipt sy_n f32 border-radius-img bgcolor_fff mb30">
                    <p class="text_left tip name_error">请填写您的姓名</p>
                </div>
                <div class="succ">
                    <input type="text" id = "tel" placeholder="电话" class="ipt sy_n f32 border-radius-img bgcolor_fff  mb30">
                    <p class="text_left tip tel_error">请填写您的电话</p>
                </div>
                <div class="succ">
                    <input type="text" id = "wechat" placeholder="微信号" class="ipt sy_n f32 border-radius-img bgcolor_fff  mb30">
                    <p class="text_left tip wechat_error">请填写您的微信号</p>
                </div>
                <div class="succ">
                    <input type="text" id = "addr" placeholder="地址" class="ipt  f32 border-radius-img bgcolor_fff sy_n mb30">
                    <p class="text_left tip  addr_error">请填写您的地址</p>
                </div>

                <button id="tijiao" onclick = "userRegister();" class="border-radius-img btn color_333 f34 fz bgcolor_orange text_center  mt30" type="button">提交</button>
            </div>
        </form>
    </div>
    @else
        <div class="border-radius-img mlr30 bg_c93126 pt10">

            <div class="bm_success_layer text_center">
                <div class="mt40 pt40 plr20"><br /><br />
                    <p class="color_333 f32 sy_m bold">您的地址已经填写了哦 <br />请静待奖品到来哦~~</p>
                    <img src="/images/new_year/addr_wechat.png" class="bm_success" alt="" />
                    <p class="sy_m color_333 f26 mt40 sao">扫码领取更多福利,千万别惊讶,全部免费领</p>
                </div>
            </div>
            <br/>
        </div>

    @endif

    <!-- 活动规则 start -->
    <div class="activity mlr30 mt100 pt40">
        <h2 class="f38 sy_r bg_c93126 color_fff border-radius60 text_center pt10 pb10">•&nbsp;&nbsp;&nbsp;注意事项&nbsp;&nbsp;&nbsp;•</h2>
        <div class="bg_c93126 border-radius-img act_txt color_fff mt30">
            <p class="f28 sy_r mb70">
                活动时间：<br>活动时间为2019年1月23日-2019年2月19日
            </p>
            <p class="f28 sy_r mb70">
                领取福利须知：<br>奖品将在年后（2月13日后）3-5个工作日陆续寄出
            </p>
            <p class="f28 sy_r mb70">
                填写地址须知：<br>确保您所填写的联系方式能准确收到奖品；如有地址变更，请左侧添加微信群，呼唤客服小姐姐变更地址，如因个人填写问题没有收到奖品，【赛普健身社区】将不予以负责。
            </p>
            <p class="f28 sy_r">
                ◆本活动的最终解释权归【赛普健身社区】所有
            </p>
        </div>
    </div>
 <!-- 活动规则 end -->

<br><br><br><br><br><br>


    <!-- 微信 start -->
    <div class="code zixunBtn">
        <a href="javascript:void(0)" class="f20 color_000 sy_m bgcolor_fff">
            <img class="service-icon" src="/images/new_year/weixin.png" alt="">
            微信咨询
        </a>
    </div>
    <!-- 微信 end -->
</div>


<script src="/lib/jqweui/js/jquery-weui.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<script src="/js/jquery.validate.js"></script>

<!--end-->
<script type="text/javascript">
    window.onload = function(){
        menuFixed('nav_keleyi_com');
    }
</script> 

<script>
/*倒计时*/
function countTime() {
    //获取当前时间
    var date = new Date();
    var now = date.getTime();
    //设置截止时间
    var endDate = new Date("2019/1/30 23:23");
    var end = endDate.getTime();
    //时间差
    var leftTime = end-now;
    //定义变量 d,h,m,s保存倒计时的时间
    var d,h,m;
    if (leftTime>=0) {
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
    }
    //将倒计时赋值到div中
    document.getElementById("_d").innerHTML = d;/*+"天"*/
    document.getElementById("_h").innerHTML = h;/*+"时"*/
    document.getElementById("_m").innerHTML = m;/*+"分"*/
    //递归每秒调用countTime方法，显示动态时间效果
    setTimeout(countTime,1000);
}
onload(countTime())
</script>

<script>
//微信弹窗
$(function (){
    $('.zixunBtn').click(function(){
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'bm_success_layer_wrap', //样式类名
            id: 'bm_success_layer', //设定一个id，防止重复弹出
            closeBtn: 1, //不显示关闭按钮
            anim: 2,
            shadeClose: true, //开启遮罩关闭
            area: ['100%', '100%'],

           /* content:'<div class="bm_success_layer text_center tan-font"><div class="mt30 pt20"><p class="sy_r bold f32 color_333">扫码加入健身福利群<br />免费领更多福利</p><img src="images/code.jpg" class="bm_success" alt="" /><p class=" sy_r color_333 f26">扫码入群<br />活动问题都可在群内提出<br />美女小姐姐会为你耐心解答的~<br />更多健身干货，奖品福利<br />帅哥美女尽在这里，等你来撩~<br /></p></div>',*/

            content:'' +
            '<div class="bm_success_layer text_center">' +
            '<div class="mt40 pt40 plr20">' +
            '<p class="color_333 f32 sy_m bold">扫码加入健身福利群<br />免费领更多福利</p>' +
            '<img src="/images/new_year/code.jpg" class="bm_success" alt="" />' +
            '<p class="sy_m color_333 f26 mt40 sao">扫码入群<br />活动问题都可在群内提出<br />美女小姐姐会为你耐心解答的~<br />更多健身干货，奖品福利<br />帅哥美女尽在这里，等你来撩~</p>' +
            '</div>' +
            '</div>',
            btn:false
        });
    })
})


//提交地址
function userRegister(){

    var mobile = $("#tel").val();       //手机号码
    var name = $("#name").val();        //姓名
    var wechat = $("#wechat").val();    //微信名称
    var addr = $("#addr").val();        //地址
    var token = '{{csrf_token()}}';

    if(!mobile || !/13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|16[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}|19[0-9]{9}$/.test(mobile)){
        $(".tel_error").text('请输入有效的手机号码哦!');
        return false;
    }else{
        $(".tel_error").text('');
    }

    if(addr.length > 300 || addr.length <= 0){
        $(".addr_error").text('请填写正确的地址！');
        return;
    }else{
        $(".addr_error").text('');
    }
    if(name.length > 20 || name.length <= 0){
        $(".name_error").text('请填写正确的姓名！');
        return;
    }else{
        $(".name_error").text('');
    }
    if(wechat.length > 20|| wechat.length <= 0){
        $(".wechat_error").text('请填写正确的微信名称！');
        return;
    }else{
        $(".wechat_error").text('');
    }

    var data = {mobile:mobile,name:name,wechat:wechat,addr:addr,_token:token};
    console.log(data);
    $.ajax({
        url:'/newyear/addrsave/{{$aid}}',
        type:'POST',
        data:data,
        dataType:'json',
        success:function(data){
            if(data.code == 1){
                layer.msg("提交成功");
                setTimeout("location.href='/newyear/index.html'",1000);
            }else if(data.code == 0){
                layer.msg("您还没有完成任务哦，快去邀请好友吧！");
            }else if(data.code == 2){
                layer.msg("地址已填写成功哦~");
            }else{
                console.log(data);
            }


        }
    });
}

</script>



@endsection

