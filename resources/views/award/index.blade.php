<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-分享好友送大礼</title>
    <meta name="author" content="啾啾" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/activity/award/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/activity/award/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <!--mmenu.css start-->
    <link href="/activity/award/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
    <link href="/activity/award/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
    <link href="/activity/award/css/nav-mmenu-public.css" rel="stylesheet" />
    <!--end-->
    <link href="/activity/award/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/activity/award/css/font-num40.css" rel="stylesheet" >

    <!--本css-->
    <link rel="stylesheet" href="/activity/award/css/zt/zt_giftgive.css">

    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
</head>
<body ontouchstart>

<!---导航右侧带导航弹出---->

<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->

    <!--头部导航 start-->
    <div class="mh-head Sticky">

        <div class=" menu-bg-logo">
			<span class="mh-btns-left">
				<a class="icon-menu icon-sousuo" href="javascript:;"></a>
			</span>
			<span class="mh-btns-right">
				<a class="icon-menu" href="#menu"></a>
				<a class="icon-menu" href="#page"></a>
			</span>
        </div>
    </div>

    <!--隐藏导航内容-->
    <nav id="menu">
        <div class="text_center  fz">
            <ul>
                <li><a href="/">首页</a></li>
                <li><a href="/user/studying">正在学习</a></li>
                <li><a href="/user/index">我的</a></li>
            </ul>
            </ul>
        </div>
    </nav>
    <!--头部导航 end-->





    <div>

        <!--==============================本喵是分割线 喵喵~==================================================-->
        <!--banner start-->
        <div class="">
            <img src="/activity/award/images/zt/giftgive/new-ban1.jpg" alt="">
            <img src="/activity/award/images/zt/giftgive/new-ban2.jpg" alt="">
            <div class="new-bgban text_center">
                <p class="f24 d-in-black text_center bold"><span class="d-in-black color_fff border-radius50">• 邀请的好友越多 获得的奖品越大哦！•</span></p>
                <p class="f22 text-jus plr140 pt30">送好友价值¥100元赛普健身社区奖学金，你可获得价值¥316元线上私教课程，还有价值¥3800元筋膜枪等豪礼等你来抢。</p>
            </div>
        </div>
        <!--banner end-->
        <!--==============================本喵是分割线 喵喵~==================================================-->
        <!--视频 start-->
        <div class="new-bg-sp pb20">
            <div class="plr94 pb30">
                <div class="video border-radius-img">
                    <div class="box2">
                        <img src="/activity/award/images/hehe.jpeg" alt=""/>
                        <div class="mask"></div>
                        <span class="btn_play"></span>
                    </div>
                    <video src="http://v.saipubbs.com/%E6%88%90%E7%89%87%E6%89%8B%E6%9C%BA%E7%89%88.mp4" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto" ></video>
                </div>
            </div>
        </div>
        <!--视频 end-->
        <!--倒计时 start-->
        <div class="new-bg-djs pt26 text_right bold color_ec313d">
            <span id="_d">7</span>
        </div>
        <!--倒计时 end-->
        <!--活动时间 btn start-->
        <div class="new-huodong-btn plr94 pt20 text_center">
            <p class="class fz color_fff border-radius50 f22 bold mb10">活动时间：1月15日至1月22日</p>
            @if($flag)
                <a href="javascript:void (0)" class="btn btn2 fz f32 d-in-black border-radius-img bg-ec313d color_fff bold mt90 shequhaibao">免费送奖学金给好友</a>
            @else
                <a onclick="userLogin();" class="btn btn2 fz f32 d-in-black border-radius-img bg-ec313d color_fff bold mt90 ">免费送奖学金给好友</a>
            @endif
        </div>
        <!--活动时间 btn end-->
        <!--==============================本喵是分割线 喵喵~==================================================-->

        <!--分享好友赢大礼第二弹 start-->
        <div class="new-bg-con2 plr68">
            <div class="">
                <img class="mb30" src="/activity/award/images/zt/giftgive/img-te.jpg" alt="">
                <img class="mb30" src="/activity/award/images/zt/giftgive/img-1.jpg" alt="">
                <img class="mb30" src="/activity/award/images/zt/giftgive/img-2.jpg" alt="">
                <img class="mb30" src="/activity/award/images/zt/giftgive/img-3.jpg" alt="">
                <img class="mb30" src="/activity/award/images/zt/giftgive/img-4.jpg" alt="">
            </div>
        </div>
        <!--分享好友赢大礼第二弹 end-->
        <!--领取豪礼流程 start-->
        <div class="new-bg-liucheng new-bg-haoli-liucheng plr80 text_center f28 fz bold">
            <p class="color_fff border-radius50 fz f32 bold ptb13 d-in-black mt70 mb40">领取豪礼流程</p>
            <p class="fz text_left text-jus mb50">好友会通过你分享的海报<span class="color_ec313d">领取奖学金</span>，我们会依据参与活动的成员发送奖学金被领取成功的金额，从多到少排列为<span class="color_ec313d">【送礼竞赛排行榜】</span>(奖学金金额一样的，按时间排序)</p>
            <p class="fz text_left text-jus mt32">奖品分为特等奖（筋膜枪）、一等奖（蛋白粉）、二等奖（左旋肉碱）、三等奖（支链氨基酸肽）、四等奖（双肩背包）五个奖品梯次。</p>
            @if($flag)
                <a href="/share/rank/list" class="btn btn2 fz f32 d-in-black border-radius-img bg-ec313d color_fff bold mt90">查看送礼竞赛排行榜</a>
            @else
                <a href="#registerUser" class="btn btn2 fz f32 d-in-black border-radius-img bg-ec313d color_fff bold mt90">查看送礼竞赛排行榜</a>
            @endif
        </div>
        <!--领取豪礼流程 end-->
        <!--分享好友赢大礼第一弹 start-->
        <div class="new-bg-con3 plr68">
            <!---->
            <div class="bgcolor_fff plr25 pt26 pb30 relative over-h">
                <div class="po">
                    <img src="/activity/award/images/zt/giftgive/199.png" alt="">
                </div>
                <!--视频 start-->
                <div class="video border-radius-img">
                    <div class="box2">
                        <img src="/activity/award/images/zt/giftgive/spimg2.jpg" alt=""/>
                        <div class="mask"></div>
                        <span class="btn_play"></span>
                    </div>
                    <video src="http://v.saipubbs.com/杨亚东2周疯狂减脂1/第1集-运动前的肌肉激活.mov" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto" ></video>
                </div>
                <!--视频 end-->
                <p class="fz f32 bold text_center mt32">两周疯狂减脂，衣服重回S码</p>
            </div>
            <!---->

            <!---->
            <div class="bgcolor_fff plr25 pt26 pb30 relative over-h mt70">
                <div class="po">
                    <img src="/activity/award/images/zt/giftgive/99.png" alt="">
                </div>
                <!--图片 start-->
                <img src="/activity/award/images/zt/giftgive/img2.jpg" alt=""/>
                <!--图片 end-->
                <p class="fz f32 bold text_center mt32">每天7分钟，全面打造完美腹肌</p>
            </div>
            <!---->

            <!---->
            <div class="bgcolor_fff plr25 pt26 pb30 relative over-h mt70">
                <div class="po">
                    <img src="/activity/award/images/zt/giftgive/19.png" alt="">
                </div>
                <!--图片 start-->
                <img src="/activity/award/images/zt/giftgive/img3.jpg" alt=""/>
                <!--图片 end-->
                <p class="fz f32 bold text_center mt32">究竟是什么限制了你的肌肉生长</p>
            </div>
            <!---->
        </div>
        <!--分享好友赢大礼第一弹 end-->
        <!--==============================本喵是分割线 喵喵~==================================================-->
        <!--领取课程流程 start-->
        <div class="new-bg-liucheng plr80 text_center f28 fz bold">
            <p class="color_fff border-radius50 fz f32 bold ptb13 d-in-black mt70 mb40">领取课程流程</p>
            <p class="fz text_left text-jus">点击<span class="color_ec313d">“免费送奖学金给好友”</span>分享海报给你的好友，有3位好友通过你分享的海报成功<span class="color_ec313d">领取奖学金</span>，后你即能获得价值316元线上私教课程。</p>
            <p class="fz text_left text-jus mt10">（*赛普健身社区发放的奖学金为赛普币，100元奖学金即10000赛普币，赛普币可用来购买线上课程）</p>
            <p class="fz text_left text-jus mt32">通过【赛普健身社区】公众号菜单栏，在【我的课表】即可找到该课程，课程永久免费在线学习。</p>
        </div>
        <!--领取课程流程 end-->
        <!--已经有xxx位好友领取了你送出的奖学金 btn start-->
        <div class="new-bg-linqu text_center bold">
            <p class="fz f33 color_fff mlr50">已经有<span class="f44">{{$total}}</span>位好友领取了你送出的奖学金</p>
            @if($flag)
            <a href="/share/friend" class="btn btn2 fz f32 d-in-black border-radius-img bg-ec313d color_fff bold mt90">查看免费领取奖学金的好友</a>
            @else
                <a onclick="userlogin();" class="btn btn2 fz f32 d-in-black border-radius-img bg-ec313d color_fff bold mt90">查看免费领取奖学金的好友</a>
            @endif
        </div>
        <!--已经有xxx位好友领取了你送出的奖学金 btn end-->
        <!--==============================本喵是分割线 喵喵~==================================================-->

        <!--==============================本喵是分割线 喵喵~==================================================-->

        <!--==============================本喵是分割线 喵喵~==================================================-->
        <!--分享好友赢大礼第三弹 start-->
        <div class="new-bg-con4 plr68">
            <div class="fuliyouxuan">
                <img class="mb30" src="/activity/award/images/zt/giftgive/youhuijuan1.png" alt="">
            </div>
        </div>
        <!--分享好友赢大礼第三弹 end-->
        <!--==============================本喵是分割线 喵喵~==================================================-->
        <!--怎样领取奖品 start-->
        <div class="new-bg-liucheng new-bg-haoli-liucheng plr80 text_center f28 fz bold">
            <p class="color_fff border-radius50 fz f32 bold ptb13 d-in-black mt70 mb40">怎样领取奖品</p>
            <p class="fz text_left text-jus mb50">2019年1月22日中午16:00活动截止，到时您可在<span class="color_ec313d">【我获得的奖品】</span>，页面点击<span class="color_ec313d">【领取奖品】</span>，进入微信群，届时我们的工作人员将和您确认获奖信息，并为您配送奖品。</p>
            @if($flag)
                <a href="/share/my/gift" class="btn btn2 fz f32 d-in-black border-radius-img bg-ec313d color_fff bold mt90">查看我获得的奖品</a>
            @else
                <a href="#registerUser" class="btn btn2 fz f32 d-in-black border-radius-img bg-ec313d color_fff bold mt90">查看我获得的奖品</a>
            @endif
        </div>
        <!--怎样领取奖品 end-->
        <!--==============================本喵是分割线 喵喵~==================================================-->
        <!--微信二维码 start-->
        <div class="new-bg-weixin fz bold f36 text_center">
            <img src="/activity/award/images/zt/giftgive/weixin.jpg" alt="">
            <p class="pt40">关注赛普健身社区公众号</p>
            <p class="mt26">第一时间知晓获奖信息</p>
        </div>
        <!--微信二维码 end-->
        <!--注册 start-->
        <!--表单 start-->
        @if(!$flag)
        <h2 class="lt f44 color_333 text_center mt70 pt26">要先注册才能领取奖学金哦~</h2>
        <div id="registerUser" class="bgcolor_f9f9f9 mt70 border-radius-img mlr30 mb40">
            <div class="plr45 pb136">

                <!--注册-->
                <div class="clearfix  pt70">
                    <h2 class="fl lt f40 color_gray666 text_center ">注册</h2>
                    <a href="/login" class="fr d-in-black  f26 color_gray666 fz ">已有账户登录></a>
                </div>
                <div class="form fz f24 clearfix mb30  pt40">
                    <ul>
                        <li>
                            <div class="input">
                                <input type="text" id="tel" placeholder="请输入您的手机号码" class="input border-radius-img f30  fz bgcolor_fff mb30">
                                <p class="text_left tip mobile_error"></p>
                            </div>
                        </li>
                        <li>
                            <div class="input clearfix">
                                <input type="text" id="code" placeholder="请输入您的验证码" class="input border-radius-img f30  fz bgcolor_fff mb30 yzm fl">
                                <span class="vcodeBtn yzm-huoqu fr bgcolor_orange border-radius-img text_center f28 color_333">获取验证码</span>
                            </div>
                            <p class="text_left tip code_error"></p>
                        </li>
                        <li>
                            <div class="input">
                                <input type="text" id="password" placeholder="请输入6-12位密码" class="input border-radius-img f30  fz bgcolor_fff mb30">
                                <p class="text_left tip passwd_error"></p>
                            </div>
                        </li>
                    </ul>

                    <!--按钮-->
                    <button onclick="userRegister();" class="border-radius-img btn  color_333 f34 fz bgcolor_orange text_center bold mt30">注册</button>
                </div>

            </div>
        </div>
        @endif
        <!--表单 end-->

        <!--注册 end-->
        <!--==============================本喵是分割线 喵喵~==================================================-->
        <!--底部 start-->
        <div class="relative">
            <div class="footer new-footer">
                <ul class="clearfix text_center f26 fz bold">
                    @if($flag)
                        <li class="bg-ec313d shequhaibao">
                            <a href="javascript:void (0)">免费送礼给好友</a>
                        </li>
                        <li class="bg-ec313d"><a href="/share/friend">领取奖学金的好友</a></li>
                        <li class="bg-ec313d"><a href="/share/my/gift">我获得的奖品</a></li>
                    @else
                        <li class="bg-ec313d">
                            <a onclick="userLogin();">免费送礼给好友</a>
                        </li>
                        <li class="bg-ec313d"><a onclick="userLogin();">领取奖学金的好友</a></li>
                        <li class="bg-ec313d"><a onclick="userLogin();">我获得的奖品</a></li>
                    @endif
                </ul>
            </div>
        </div>
        <!--底部 end-->
        <!--==============================本喵是分割线 喵喵~==================================================-->
        <!--右侧悬浮 【微信】 start-->
        <div class="relative">
            <div class="right-suspension text_center pt10 shequtiwen">
                <a href="javascript:void (0)">
                    <img src="/activity/award/images/zt/giftgive/weixin.png" alt="">
                    <p class="fz f20 bold">微信咨询</p>
                </a>
            </div>
        </div>
        <!--右侧悬浮 【微信】 end-->
    </div>


</div><!--导航大盒子id=page 结束-->


<br><br>

<script src="/activity/award/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/activity/award/lib/jqweui/js/fastclick.js"></script>
<script src="/js/js.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
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
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: '{{$name}}送你100元奖学金，快去领取吧~', // 分享标题
            desc: '参加活动还有可能获得筋膜枪、蛋白粉、左旋、支链、运动背包', // 分享描述
            @if($fission_id == 0)
                link: "http://m.saipubbs.com/share/award", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            @else
                link: "http://m.saipubbs.com/share/receive?fission_id={{$fission_id}}",
            @endif
            imgUrl: "http://m.saipubbs.com/activity/award/images/activity.jpeg", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '{{$name}}送你100元奖学金，快去领取吧~', // 分享标题
            @if($fission_id == 0)
                link: "http://m.saipubbs.com/share/award", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            @else
                link: "http://m.saipubbs.com/share/receive?fission_id={{$fission_id}}",
            @endif
            imgUrl: "http://m.saipubbs.com/activity/award/images/activity.jpeg", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
    /**/
    $(function() {
        FastClick.attach(document.body);
    });
</script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->

<script type="text/javascript">
    //播放视频
    $(function (){
        //播放视频
        $('.video .box2').click(function(){
            $(this).hide();
            $(this)/*.parent()*/.next().trigger('play');
        })
    })


</script>
<script type="text/javascript">
    localStorage.setItem('redirect','/share/award');
    var flag = '{{$flag}}';
    countTime();
    function countTime() {
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
        var endDate = new Date("2019/1/22 16:00");
        var end = endDate.getTime();
        //时间差
        var leftTime = end-now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d,h,m,s;
        if (leftTime>=0) {
            d = Math.floor(leftTime/1000/60/60/24);
//            h = Math.floor(leftTime/1000/60/60%24);
//            m = Math.floor(leftTime/1000/60%60);
//            s = Math.floor(leftTime/1000%60);
        }
        //将倒计时赋值到div中
        document.getElementById("_d").innerHTML = d+"";/*天*/
//        /document.getElementById("_h").innerHTML = h+"";/*时*/
//        document.getElementById("_m").innerHTML = m+"";/*分*/
//        document.getElementById("_s").innerHTML = s+"";/*秒*/
        //递归每秒调用countTime方法，显示动态时间效果
        setTimeout(countTime,1000);

    }

    //弹窗[社区提问]
    $('.shequtiwen').click(function(){
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'get_success_layer_wrap', //样式类名
            id: 'get_success_layer', //设定一个id，防止重复弹出
            closeBtn: 1, //不显示关闭按钮
            anim: 2,
            shadeClose: true, //开启遮罩关闭
            area: ['80%', '70%'],
            content:'<div class="get_success_layer text_center"><div class=" mt70 pt40"><img src="/activity/award/images/zt/giftgive/shequtiwen.jpg" class="bm_success" alt="" /><div><p class="lt bold color_333 f32 mt26">对活动有疑问</p><p class="lt bold color_333 f32 mt10">可入群询问群管理员</p></div></div>',
            btn:false
        });
    });
    //弹窗[赋力优选]
    $('.fuliyouxuan').click(function(){
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'get_success_layer_wrap', //样式类名
            id: 'get_success_layer', //设定一个id，防止重复弹出
            closeBtn: 1, //不显示关闭按钮
            anim: 2,
            shadeClose: true, //开启遮罩关闭
            area: ['80%', '70%'],
            content:'<div class="get_success_layer text_center"><div class=" mt70 pt40"><img src="/activity/award/images/zt/giftgive/fuliyoupin.jpg" class="bm_success" alt="" /><div><p class="lt bold color_333 f32 mt26">扫描小程序二维码</p><p class="lt bold color_333 f32 mt10">进商城领取优惠券</p></div></div>',
            btn:false
        });
    });
    //弹窗[社区海报]
    $('.shequhaibao').click(function(){
        var data = {_token:'{{csrf_token()}}'};
        $.ajax({
            url:"/share/make/card",
            data:data,
            type:'POST',
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    layer.open({
                        type: 1,
                        title: false, //不显示标题栏
                        skin: 'hb_success_layer_wrap', //样式类名
                        id: 'hb_success_layer', //设定一个id，防止重复弹出
                        closeBtn: 1, //不显示关闭按钮
                        anim: 2,
                        shadeClose: true, //开启遮罩关闭
                        area: ['80%', '90%'],
                        content:res.data,
                        btn:false
                    });
                }else{
                    layer.msg(res.message);
                    window.location.href='/register';
                }
            }
        });

    });

//    onload(countTime())

    $(function(){
        //发送验证码
        $('.vcodeBtn').click(function (){
            var tel = $('#tel').val();
            if(!tel || !/13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}$/.test(tel)){
                layer.msg('请输入有效的手机号码');
            }else{
                var token = '{{csrf_token()}}';
                var mobile = $("#tel").val();
                var data = {mobile:mobile,_token:token};
                $.ajax({
                    url:'/send/code',
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
    function userRegister(){
        var mobile = $("#tel").val();
        var token = '{{csrf_token()}}';
        var code = $('#code').val();
        var password = $('#password').val();

        if(!mobile || !/13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|16[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}$/.test(mobile)){
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
        var fission_id = localStorage.getItem('fission_id');
        var share_id = '';
        if(fission_id != '' || fission_id != null){
            var share_id = fission_id;
        }
        var channel = localStorage.getItem('channel');
        if(channel == '' || channel == null){
            var channel = '';
        }
        var op = $("input[name='openid']").val();
        var data = {mobile:mobile,verifyCode:code,password:password,_token:token,op:op,share_id:share_id,channel:channel};
        $.ajax({
            url:'/user/register',
            type:'POST',
            data:data,
            dataType:'json',
            success:function(data){
                if(data.code == 0){

                    var url = localStorage.getItem('redirect');
                    layer.msg('注册成功');
                    if(url !='' && url != null){
                        localStorage.removeItem('redirect');
                        window.location.href = url;
                    }else{
                        window.location.href = '/';
                    }

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
    function userLogin(){
        if(flag == 0){
            layer.msg('请登录');
            window.location.href="#registerUser";
        }
    }
</script>
<!-- GrowingIO Analytics code version 2.1 -->
<!-- Copyright 2015-2018 GrowingIO, Inc. More info available at at http://www.growingio.com -->

<script type='text/javascript'>
    !function(e,t,n,g,i){e[i]=e[i]||function(){(e[i].q=e[i].q||[]).push(arguments)},n=t.createElement("script"),tag=t.getElementsByTagName("script")[0],n.async=1,n.src=('https:'==document.location.protocol?'https://':'http://')+g,tag.parentNode.insertBefore(n,tag)}(window,document,"script","assets.growingio.com/2.1/gio.js","gio");
    gio('init','aef8110bebdb6dd5', {});
    //custom page code begin here
    //custom page code end here
    gio('send');
</script>

<!-- End GrowingIO Analytics code version: 2.1 -->
</body>
</html>
