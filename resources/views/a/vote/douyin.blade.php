<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$tfCourseClass->title}}</title>
    <link rel="stylesheet" href="/xinmeiti/douyin/css/reset.css?id=798789">
    <link rel="stylesheet" href="/xinmeiti/douyin/css/mp.css">
    <link rel="stylesheet" href="/xinmeiti/douyin/css/font-num40.css">
    <link rel="stylesheet" href="/xinmeiti/douyin/css/animation-btn.css">
    <link rel="stylesheet" href="/xinmeiti/douyin/css/shequn.css?id=798798">
    <script src="/xinmeiti/douyin/js/rem.js"></script>
    <script src="/xinmeiti/douyin/js/jquery-1.11.2.min.js"></script>
    <script src="/xinmeiti/douyin/js/jquery.SuperSlide.2.1.3.js"></script>
    @include('layouts.baidutongji')
    <script type="text/javascript">
        var phone = "{{$phone}}";
        if(phone==1){
            //localStorage.setItem("douyin_is_pay","{{$is_pay}}");
            //window.location.href="https://wx.vzan.com/live/AggSpread?id=369d8924-962f-406a-a7e6-a29ec6f987d7&shareuid=3642324";
        }
        var is_pay = "{{$is_pay}}";
        
        

    </script>
</head>
<body onload = "countTime2()">
<div class="fz">

    <!-- banner 倒计时 start -->
    <div class="banner">
        <img src="{{env("IMG_URL")}}{{$tfCourseClass->cover_url}}" alt="" class="img100">
        <div class="ban-time color_fff border-radius-img mlr25 mt10 mb15">
            <ul class="clearfix">
                <li>
                    <div class="wrap tj-box">
                        <p class="f40 plr30 lt">限时特价</p>
                        <p class="f21 plr30 c-fefcfc"><i class="money-icon"></i><span class="f42 mr10 ls6">{{$tfCourseClass->team_price}}</span>原价<i class="money-icon"></i><span class="shan_fff">{{$tfCourseClass->price }}.00</span></p>
                    </div>
                </li>
                <li>
                    <div class="wrap tj-box2">
                        <p class="fz f32 text_center c-fefcfc">距离结束还剩</p>
                        <div class="time text_center">
                            <div class="d"><span>2</span><em>天</em></div>
                            <div id="_h"><span>0</span><span>0</span><em>:</em></div>
                            <div id="_m"><span>0</span><span>0</span><em>:</em></div>
                            <div id="_s"><span>0</span><span>0</span><em></em></div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- banner 倒计时 end -->

    <!-- 标题 start -->
    <div class="tit mlr25 ptb24 plr30 border-radius-img">
        <h2 class="lt f32 text-jus">{{$tfCourseClass->title}}</h2>
        <h1 class="fz f25 mt8">{{$tfCourseClass->description}}</h1>
        <p class="fz f22 mt40"><img src="/xinmeiti/douyin/images/shequn/sd.png" alt="">12人在领取，可直接参与</p>
    </div>
    <!-- 标题 end -->
    <!-- 轮播 start -->
    <div class="wrap-bg text_center fz">
        <div class="txtScroll-top">
            <div class="bd">
                <ul>
                    <li><p class="wrap clearfix"><img src="/xinmeiti/douyin/images/shequn/user/1.png" alt="">我是healer-刚刚支付成功了</p></li>
                    <li><p class="wrap clearfix"><img src="/xinmeiti/douyin/images/shequn/user/2.png" alt="">我是橘子酱-刚刚支付成功了</p></li>
                    <li><p class="wrap clearfix"><img src="/xinmeiti/douyin/images/shequn/user/3.png" alt="">我是战战弟弟-刚刚支付成功了</p></li>
                    <li><p class="wrap clearfix"><img src="/xinmeiti/douyin/images/shequn/user/4.png" alt="">我是叫我欧巴-刚刚支付成功了</p></li>
                    <li><p class="wrap clearfix"><img src="/xinmeiti/douyin/images/shequn/user/5.png" alt="">我是q36858-刚刚支付成功了</p></li>
                    <li><p class="wrap clearfix"><img src="/xinmeiti/douyin/images/shequn/user/6.png" alt="">我是小龙虾-刚刚支付成功了</p></li>
                    <li><p class="wrap clearfix"><img src="/xinmeiti/douyin/images/shequn/user/7.png" alt="">我是时美美-刚刚支付成功了</p></li>
                    <li><p class="wrap clearfix"><img src="/xinmeiti/douyin/images/shequn/user/8.png" alt="">我是快乐生活-刚刚支付成功了</p></li>
                    <li><p class="wrap clearfix"><img src="/xinmeiti/douyin/images/shequn/user/9.png" alt="">我是退役熬夜选手-刚刚支付成功了</p></li>
                    <li><p class="wrap clearfix"><img src="/xinmeiti/douyin/images/shequn/user/10.png" alt="">我是迪士尼在逃公主-刚刚支付成功了</p></li>
                    <li><p class="wrap clearfix"><img src="/xinmeiti/douyin/images/shequn/user/11.png" alt="">我是幼儿园抢饭第一名-刚刚支付成功了</p></li>
                    <li><p class="wrap clearfix"><img src="/xinmeiti/douyin/images/shequn/user/12.png" alt="">我是马云背后的女人-刚刚支付成功了</p></li>
                </ul>
            </div>
        </div>
        <script type="text/javascript">
            jQuery(".txtScroll-top").slide({titCell:".hd ul",mainCell:".bd ul",autoPage:true,effect:"top",autoPlay:true,vis:1});
        </script>
    </div>
    <!-- 轮播 end -->

    <!-- 长图 start -->
    <img src="{{env('IMG_URL')}}{{$tfCourseClass->desc_url}}" alt="" class="img100">
    <!-- 长图 end -->

    <!-- 按钮 start -->
    <div class="btn">
        <ul class="clearfix @if($is_pay ==0) freeBtn @endif fz f28">
            <li>
                <div class="wrap clearfix text_center">
                    <p class="fz f25 shan_808080">原价{{$tfCourseClass->price}}元</p>
                    <p class="fz f47 color_orange">{{$tfCourseClass->team_price}}<span class="f20">元</span></p>
                </div>
            </li>
            @if($is_pay)
            <li>
                <button class="fz f45 dxx"><a href="javascript:;" class="pay_button dxx">查看课程</a></button>
            </li>
            @else
            <li>
                <button class="fz f45 animation_btn">立即支付</button>
            </li>
            @endif
        </ul>
    </div>
    <!-- 按钮 end -->


    <!-- 支付表单弹窗 start -->
    <div class="zhifu_form_layer fz hide">
        <div class="container">
            <h3 class="f36 text_center ptb50 color_333 bold">您希望收获什么？</h3>
            <div class="checkboxWrap">
                <ul>
                    <li>
                        <label class="clearfix">
                            <div class="fl fz f30">
                                <span>想考证将来考虑做教练</span>
                            </div>
                            <div class="fr">
                                <input type="checkbox" name="checkinfo" value="想考证将来考虑做教练" class="checkedbox"/>
                            </div>
                        </label>
                    </li>
                    <li>
                        <label class="clearfix">
                            <div class="fl fz f30">
                                <span>学习健身知识自己练身材</span>
                            </div>
                            <div class="fr">
                                <input type="checkbox" name="checkinfo" value="学习健身知识自己练身材" class="checkedbox"/>
                            </div>
                        </label>
                    </li>
                </ul>
            </div>
            <ul>
                <li class="relative">
                    <p class="f30 color_2e pos_a">昵称</p>
                    <input type="text" class="ipt f24" placeholder="请输入您的昵称" id="name" />
                </li>
                <li class="relative">
                    <p class="f30 color_2e pos_a">手机号</p>
                    <input type="text" class="ipt f24" placeholder="请输入手机号码" id="tel" />
                </li>
                <li class="relative">
                    <p class="f30 color_2e pos_a">验证码</p>
                    <input type="text" class="ipt f24 vcodeInput" placeholder="请填写验证码" id="vcode" />
                    <button class="vcodeBtn f24 text_center color_2e">获取验证码</button>
                </li>
            </ul>
            <div class="checkboxWrap f26 color_333 mt45">
                <!--<p class="f30 text_left mb20 color_000">支付方式</p>-->
                <ul>
                    <li>
                        <label class="clearfix">
                            <div class="fl">
                                <img src="/xinmeiti/douyin/images/mclass/icon_wx.png" alt="" class="img100">
                                <span>微信支付</span>
                            </div>
                            <div class="fr">
                                <input type="radio" name="bbb" class="radiobox" checked/>
                            </div>
                        </label>
                    </li>
                    <!-- <li>
                        <label class="clearfix disabled-new">
                            <div class="fl">
                                <img src="/xinmeiti/douyin/images/mclass/icon_zfb.png" alt="" class="img100">
                                <span>支付宝支付</span>
                            </div>
                            <div class="fr">
                                <input type="radio" name="bbb" class="radiobox" />
                            </div>
                        </label>
                    </li> -->
                </ul>
            </div>
            <div class="btns clearfix mt45">
                <a href="javascript:void(0)" class="payNowBtn text_center f32 bold border-radius-img">支付</a>
            </div>
        </div>
    </div>
    <!-- 支付表单弹窗 end -->
    <!-- 复制链接弹窗 start -->
    <div class="copylink hide">
        <div class="fz text_center pt70">
            <img src="/xinmeiti/douyin/images/shequn/gou.png" alt="">
            <h5 class="f42 pt24">恭喜您已获得体验课</h5>
            <div class="f30 pt90 pb90">
                <p>课程链接如下！</p>
                <p class="pb30 line36">记得复制收藏起来 方便反复观看哦！</p>
                <p class="link">http://suo.im/5Txhu7</p>
                <p class="f32 border-radius2 copyBtn" data-clipboard-text="http://suo.im/5Txhu7" onclick=""><img src="/xinmeiti/douyin/images/shequn/zhua.png" alt="">长按复制上方课程链接</p>
            </div>
            <a href="https://wx.vzan.com/live/AggSpread?id=369d8924-962f-406a-a7e6-a29ec6f987d7&shareuid=3642324" class="f32 bold">立即进入课程</a>
        </div>
    </div>
    <!-- 复制链接弹窗 end -->
</div>
<script src="/xinmeiti/douyin/lib/icheck/js/icheck.min.js"></script>
<script src="/xinmeiti/douyin/lib/layer/layer.js"></script>
<script src="/xinmeiti/douyin/lib/clipboard/clipboard.min.js"></script>
<script src="/xinmeiti/douyin/js/public_js.js"></script>
<script src="/xinmeiti/douyin/js/18hour-js.js"></script>
<script>
    var page_url = window.location.href;
    // var local_is_pay = localStorage.getItem("douyin_is_pay");
    //复制链接弹窗
    $('.dxx').click(function(){
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'copyB_layer_wrap', //样式类名
            id: 'copyB_layer_wrap', //设定一个id，防止重复弹出
            closeBtn: 1, //不显示关闭按钮
            anim: 2,
            shadeClose: false, //开启遮罩关闭
            shade: [0.7, '#000'],
            area: ['85%', 'auto'],
            content:$('.copylink'),
            //offset:'rb',
            btn:false
        });
    });

    if(is_pay==1){
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'copyB_layer_wrap', //样式类名
            id: 'copyB_layer_wrap', //设定一个id，防止重复弹出
            closeBtn: 1, //不显示关闭按钮
            anim: 2,
            shadeClose: false, //开启遮罩关闭
            shade: [0.7, '#000'],
            area: ['85%', 'auto'],
            content:$('.copylink'),
            //offset:'rb',
            btn:false
        });
        //window.location.href="https://wx.vzan.com/live/AggSpread?id=369d8924-962f-406a-a7e6-a29ec6f987d7&shareuid=3642324";
    }

    //复制
    var clipboard = new Clipboard('.copyBtnss');
    clipboard.on('success', function (e) {
        
        layer.msg('已复制');
        console.log(e);
    });
    clipboard.on('error', function (e) {
        layer.msg('您的浏览器可能不支持，请手动复制~');
    });
    //单选按钮
    $('.radiobox').iCheck({
        radioClass: 'iradio',
        increaseArea: '20%'
    });
    $('.checkedbox').iCheck({
        radioClass: 'iradio',
        increaseArea: '20%'
    });

    //底部免费报名
    $('.freeBtn').click(function(){
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'zhifu_form_layer_wrap', //样式类名
            id: 'zhifu_form_layer', //设定一个id，防止重复弹出
            closeBtn: 1, //不显示关闭按钮
            anim: 2,
            shadeClose: false, //开启遮罩关闭
            area: ['100%', '60%'],
            content:$('.zhifu_form_layer'),
            offset:'rb',
            btn:false
        });
    });
    //针对苹果手机键盘的复位
    $("input").blur(function () {
        setTimeout(function() {
            var scrollHeight = document.documentElement.scrollTop || document.body.scrollTop || 0;
            window.scrollTo(0, Math.max(scrollHeight - 1, 0));
        }, 100);
    });
    //发送验证码
    var user_id   = "";      //用户id
    $(document.body).delegate(".vcodeBtn", 'click', function () {
        var tel=$('#tel').val();
        if(!tel || !/13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}$/.test(tel)){
            layer.msg('请输入正确的手机号');
        }else{
            settime($(this),20);
            var token = '{{csrf_token()}}';
            var mobile = $("#tel").val();
            var data = {mobile:mobile,verify:1,_token:token};
            $.ajax({
                url:'/tf/send/code',
                type:'POST',
                data:data,
                dataType:'json',
                success:function(res){
                    if(res.code == 1){
                        
                        layer.msg(res.message);
                    }else{
                        layer.msg(res.message);
                    }
                }
            });
            //settime($(this),60);
        }
    });
    
    $(".payNowBtn").click(function(){
        var checkinfo="";
        $.each($('input:checkbox:checked'),function(){
            checkinfo +=$(this).val()+',';
        });
        if(checkinfo==""){
            layer.msg('请选择希望收获什么');
            return false;
        }
        
        var phone= $('#tel').val();
        var code = $("#vcode").val();
        var name = $("#name").val();
        var token= '{{csrf_token()}}';
        
        var tf_course_class_id = "{{$tfCourseClass->id}}";  //购买投放课程id
        if(!phone || phone==""){
            layer.msg('请输入手机号');
            return false;
        }
        if(!code || code==""){
            layer.msg('请输入验证码');
            return false;
        }

        //20200210 记录真实支付点击次数
        var info = {type:"pay_click_num",user_id:user_id, tf_course_class_id:tf_course_class_id};
        $.ajax({
            url:'/tf/click',
            data:info,
            type:'GET',
            dataType:'json',
            success:function(res){
            }
        });
        layer.msg('支付中...');
        $.ajax({
            type:"POST",
            url:"/tf/payh",
            data:{_token:token,tf_class_id:tf_course_class_id,phone:phone,user_id:user_id,username:name,code:code,remark:checkinfo,page_url:page_url},
            dataType:"json",
            success:function(result){
                if(result.code==0){
                    console.log(result.objectxml.mweb_url);
                    //follow_us();
                    window.location.href=result.objectxml.mweb_url;   //h5呼叫微信支付
                }else{
                    layer.msg(result.message);
                    layer.msg(result.code);
                    if(result.code==2){
                        localStorage.setItem("douyin_is_pay","1");
                        window.location.href="https://wx.vzan.com/live/AggSpread?id=369d8924-962f-406a-a7e6-a29ec6f987d7&shareuid=3642324";
                    }
                }
            }
        });
    });
</script>
</body>
</html>