<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no"/>
    <title>赛普社区-提问送课</title>
    <meta name="author" content="涵涵"/>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css"/>
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" type="text/css" href="/css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="/css/font-num40.css">
    <!-- 本css -->
    <link rel="stylesheet" type="text/css" href="/css/zt/zt_tiwensongke.css" >
    <script>
        (function () {
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth / 18.75 + 'px';
        })()
    </script>
</head>
<body>

<div>
    <div>
        <!-- banner start-->
        <div>
            <img src="/images/zt/tiwensongke/ban1.jpg" alt="" class="img100">
            <img src="/images/zt/tiwensongke/ban2.jpg" alt="" class="img100">
        </div>
        <!-- banner end-->
        <!-- 活动规则 start -->
        <div class="guizeBg">
            <h3 class="text_center lt f40 pb30"><i></i>活动规则<i></i></h3>
            <ul>
                <li>
                    <div class="wrap relative">
                        <span class="lt f31">1.</span>
                        <p class="text-jus fz f26 color_gray666">在问答版块，添加特定标签提问，即可免费 获得该领域课程一套</p>
                    </div>
                </li>
                <li>
                    <div class="wrap relative">
                        <span class="lt f31">2.</span>
                        <p class="text-jus fz f26 color_gray666">免费领取课程后需完成学习（完成标准：学习进度为100%）才能继续领取下一套课程</p>
                    </div>
                </li>
                <li>
                    <div class="wrap relative">
                        <span class="lt f31">3.</span>
                        <p class="text-jus fz f26 color_gray666">在活动开始前已经拥有本次赠送课程的用户会收到1000赛普币补贴</p>
                    </div>
                </li>
            </ul>
        </div>
        <!-- 活动规则 end -->

        <!-- 领取列表 start -->
        <div class="lingqu">
            <div class="titBg text_center">
                <h3 class="lt f40 color_000"><i></i>领取列表<i></i></h3>
                <p class="fz f24">总价值￥584元课程<span class="bold">免费送</span></p>
            </div>
            <?php
            $jianzhi = App\Models\CourseActivityUser::where('course_class_id',8)->where('user_id',$user_id)->select('id')->first();
            $zengji = App\Models\CourseActivityUser::where('course_class_id',4)->where('user_id',$user_id)->select('id')->first();
            $jiepou = App\Models\CourseActivityUser::where('course_class_id',24)->where('user_id',$user_id)->select('id')->first();
            $pulati = App\Models\CourseActivityUser::where('course_class_id',12)->where('user_id',$user_id)->select('id')->first();
            $yunchan = App\Models\CourseActivityUser::where('course_class_id',39)->where('user_id',$user_id)->select('id')->first();
            $kangfu = App\Models\CourseActivityUser::where('course_class_id',68)->where('user_id',$user_id)->select('id')->first();
            ?>
                    <!-- 列表 start -->
            <div class="list">
                <div class="listBg">
                    <div class="listBox clearfix">
                        <div class="listLeft relative">
                            <img src="/images/zt/tiwensongke/img.jpg" alt="" class="img100">
                            <div class="posHfont text_center">
                                <p class="lt f36 color_000">减脂教练</p>
                                <span class="lt f24 block">核心必备技能</span>
                            </div>
                        </div>
                        <div class="listRight">
                            <h2 class="lt f34 color_000 pb20">14天减脂训练计划</h2>
                            <p class="fz f22 color_gray666 p">提问时添加<span class="color_red_dd1f36 bold">「减脂」</span>标签,提问成功后可免费获得该课程</p>
                            <div class="btnLing clearfix">
                                <p class="fl f32 color_red_dd1f36 fz bold">199<strong class="f22">元</strong></p>
                                @if($jianzhi)
                                    <p class="fl fz border-radius50 color_fff f28 BG_gray_999 lingBtn" data-id="8">已领取</p>
                                @else
                                    <?php
                                    $jzSpb = App\Models\CourseActivitySpbRecord::where('course_class_id',8)->where('user_id',$user_id)->select('id')->first();
                                    ?>
                                    @if($jzSpb)
                                        <p class="fl fz border-radius50 color_fff f28 BG_gray_999 lingBtn" data-id="8">已领取</p>
                                    @else
                                        <p class="fl fz border-radius50 color_fff f28 lingBtn BG_red_dd1f36 clickGet" data-id="8">免费领</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="listBg">
                    <div class="listBox clearfix">
                        <div class="listLeft relative">
                            <img src="/images/zt/tiwensongke/img2.jpg" alt="" class="img100">
                            <div class="posHfont text_center">
                                <p class="lt f36 color_000">增肌教练</p>
                                <span class="lt f24 block">核心必备技能</span>
                            </div>
                        </div>
                        <div class="listRight">
                            <h2 class="lt f34 color_000 pb20">胸肩背腹专项训练</h2>
                            <p class="fz f22 color_gray666 p">提问时添加<span class="color_red_dd1f36 bold">「增肌」</span>标签,提问成功后可免费获得该课程</p>
                            <div class="btnLing clearfix">
                                <p class="fl f32 color_red_dd1f36 fz bold">69<strong class="f22">元</strong></p>
                                @if($zengji)
                                    <p class="fl fz border-radius50 color_fff f28 lingBtn BG_gray_999" data-id="4">已领取</p>
                                @else
                                    <?php
                                    $zjSpb = App\Models\CourseActivitySpbRecord::where('course_class_id',4)->where('user_id',$user_id)->select('id')->first();
                                    ?>
                                    @if($zjSpb)
                                        <p class="fl fz border-radius50 color_fff f28 BG_gray_999 lingBtn" data-id="4">已领取</p>
                                    @else
                                        <p class="fl fz border-radius50 color_fff f28 lingBtn BG_red_dd1f36 clickGet" data-id="4">免费领</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="listBg">
                    <div class="listBox clearfix">
                        <div class="listLeft relative">
                            <img src="/images/zt/tiwensongke/img3.jpg" alt="" class="img100">
                            <div class="posHfont text_center">
                                <p class="lt f36 color_000">健身教练</p>
                                <span class="lt f24 block">核心必备技能</span>
                            </div>
                        </div>
                        <div class="listRight">
                            <h2 class="lt f34 color_000 pb20">运动训练基础解剖</h2>
                            <p class="fz f22 color_gray666 p">提问时添加<span class="color_red_dd1f36 bold">「肌肉解剖」</span>标签,提问成功后可免费获得该课程</p>
                            <div class="btnLing clearfix">
                                <p class="fl f32 color_red_dd1f36 fz bold">59<strong class="f22">元</strong></p>
                                @if($jiepou)
                                    <p class="fl fz border-radius50 color_fff f28 lingBtn BG_gray_999"  data-id="24">已领取</p>
                                @else
                                    <?php
                                    $jpSpb = App\Models\CourseActivitySpbRecord::where('course_class_id',24)->where('user_id',$user_id)->select('id')->first();
                                    ?>
                                    @if($jpSpb)
                                        <p class="fl fz border-radius50 color_fff f28 BG_gray_999 lingBtn" data-id="24">已领取</p>
                                    @else
                                        <p class="fl fz border-radius50 color_fff f28 lingBtn BG_red_dd1f36 clickGet" data-id="24">免费领</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="listBg">
                    <div class="listBox clearfix">
                        <div class="listLeft relative">
                            <img src="/images/zt/tiwensongke/img4.jpg" alt="" class="img100">
                            <div class="posHfont text_center">
                                <p class="lt f36 color_000">普拉提教练</p>
                                <span class="lt f24 block">核心必备技能</span>
                            </div>
                        </div>
                        <div class="listRight">
                            <h2 class="lt f34 color_000 pb20">普拉提基础入门</h2>
                            <p class="fz f22 color_gray666 p">提问时添加<span class="color_red_dd1f36 bold">「普拉提」</span>标签,提问成功后可免费获得该课程</p>
                            <div class="btnLing clearfix">
                                <p class="fl f32 color_red_dd1f36 fz bold">99<strong class="f22">元</strong></p>
                                @if($pulati)
                                    <p class="fl fz border-radius50 color_fff f28 lingBtn BG_gray_999"  data-id="12">已领取</p>
                                @else
                                    <?php
                                    $pltSpb = App\Models\CourseActivitySpbRecord::where('course_class_id',12)->where('user_id',$user_id)->select('id')->first();
                                    ?>
                                    @if($pltSpb)
                                        <p class="fl fz border-radius50 color_fff f28 BG_gray_999 lingBtn" data-id="12">已领取</p>
                                    @else
                                        <p class="fl fz border-radius50 color_fff f28 lingBtn BG_red_dd1f36 clickGet" data-id="12">免费领</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="listBg">
                    <div class="listBox clearfix">
                        <div class="listLeft relative">
                            <img src="/images/zt/tiwensongke/img5.jpg" alt="" class="img100">
                            <div class="posHfont text_center">
                                <p class="lt f36 color_000">孕产教练</p>
                                <span class="lt f24 block">核心必备技能</span>
                            </div>
                        </div>
                        <div class="listRight">
                            <h2 class="lt f34 color_000 pb20">腹直肌分离评估与改善</h2>
                            <p class="fz f22 color_gray666 p">提问时添加<span class="color_red_dd1f36 bold">「孕产」</span>标签,提问成功后可免费获得该课程</p>
                            <div class="btnLing clearfix">
                                <p class="fl f32 color_red_dd1f36 fz bold">89<strong class="f22">元</strong></p>
                                @if($yunchan)
                                    <p class="fl fz border-radius50 color_fff f28 lingBtn BG_gray_999"  data-id="39">已领取</p>
                                @else
                                    <?php
                                    $ycSpb = App\Models\CourseActivitySpbRecord::where('course_class_id',39)->where('user_id',$user_id)->select('id')->first();
                                    ?>
                                    @if($ycSpb)
                                        <p class="fl fz border-radius50 color_fff f28 BG_gray_999 lingBtn" data-id="39">已领取</p>
                                    @else
                                        <p class="fl fz border-radius50 color_fff f28 lingBtn BG_red_dd1f36 clickGet" data-id="39">免费领</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="listBg">
                    <div class="listBox clearfix">
                        <div class="listLeft relative">
                            <img src="/images/zt/tiwensongke/img6.jpg" alt="" class="img100">
                            <div class="posHfont text_center">
                                <p class="lt f36 color_000">康复教练</p>
                                <span class="lt f24 block">核心必备技能</span>
                            </div>
                        </div>
                        <div class="listRight">
                            <h2 class="lt f34 color_000 pb20">肩关节复合体弹响及处理思路</h2>
                            <p class="fz f22 color_gray666 p">提问时添加<span class="color_red_dd1f36 bold">「康复」</span>标签,提问成功后可免费获得该课程</p>
                            <div class="btnLing clearfix">
                                <p class="fl f32 color_red_dd1f36 fz bold">79<strong class="f22">元</strong></p>
                                @if($kangfu)
                                    <p class="fl fz border-radius50 color_fff f28 lingBtn BG_gray_999" data-id="68">已领</p>
                                @else
                                    <?php
                                    $kfSpb = App\Models\CourseActivitySpbRecord::where('course_class_id',68)->where('user_id',$user_id)->select('id')->first();
                                    ?>
                                    @if($kfSpb)
                                        <p class="fl fz border-radius50 color_fff f28 BG_gray_999 lingBtn" data-id="68">已领取</p>
                                    @else
                                        <p class="fl fz border-radius50 color_fff f28 lingBtn BG_red_dd1f36 clickGet" data-id="68">免费领</p>
                                    @endif

                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- 列表 end -->
        </div>
        <!-- 领取列表 end -->
        <p class="fz f26 color_000 suo text_center mt30"><i></i>活动最终解释权归赛普健身社区所有<i></i></p>
    </div>


</div>

<!--弹出框 1000赛普币已到账-->
<div class="jump jump1 hide">
    <div class="text_center pt190">
        <p class="pb70 f40 color_333 lt">1000赛普币已到账</p>
        <button class="bgcolor_orange fz f28 color_000 border-radius-img">领取其他课程</button>
    </div>
</div>

<!--弹出框 课程领取成功-->
<div class="jump jump2 hide">
    <div class="text_center pt115">
        <p class="fz f28 color_gray666 mb30">《肩关节复合体弹响及处理思路》</p>
        <p class="f40 color_333 lt pb70">课程领取成功</p>
        <button class="bgcolor_orange fz f28 color_000 border-radius-img">前往看课</button>
        <p class="fz f20 color_gray999 plr65 pt40 text_left line1">提示：该课程学习进度为100%时，方可领取下一个课程</p>
    </div>
</div>

<!--弹出框 您已经拥有该课程 奉上1000赛普币-->
<div class="jump jump3 hide">
    <div class="text_center pt115">
        <p class="fz f28 color_gray666 mb30">您已经拥有该课程</p>
        <p class="f40 color_333 lt pb70">奉上1000赛普币<br>请您笑纳</p>
        <button class="bgcolor_orange fz f28 color_000 border-radius-img">领取赛普币</button>
        <p class="fz f20 color_gray999 plr65 pt40 text_left line1">提示：您可以继续领取其他课程</p>
    </div>
</div>

<!--弹出框 不要贪心哟 没有完成不能领取下一个课程-->
<div class="jump jump4 hide">
    <div class="text_center pt115">
        <p class="f40 color_333 lt mb30">不要贪心哟</p>
        <p class="fz f28 color_gray666 pb70 plr30 line1 text_left">《腹直肌分离评估与改善》学习  没有完成不能领取下一个课程</p>
        <button class="bgcolor_orange fz f28 color_000 border-radius-img">前往学习</button>
        <p class="fz f20 color_gray999 plr65 pt40 text_left line1">提示：该课程学习进度为100%时，方可 领取下一个课程</p>
    </div>
</div>

<br><br>
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="/js/fonts.js?t={{time()}}"></script>
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

    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: '教练必修课免费领取', // 分享标题
            desc: '总价值￥584元课程，限时0元领~', // 分享描述
            link: "http://m.saipubbs.com/course/access.html", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '教练必修课免费领取', // 分享标题
            link: "http://m.saipubbs.com/course/access.html", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });


</script>
<script>
    $("body").addClass("BgColorPink");

    //弹窗 1000赛普币已到账
    var id = 0;
    $('.clickGet').click(function(){
        id = $(this).attr('data-id');
        var token = '{{csrf_token()}}';
        var data = {id:id,_token:token};
        $.ajax({
            url:'/course/free/judge',
            data:data,
            type:"POST",
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    makeAsk();
                }else if(res.code == 1){
                    layer.open({
                        type: 1,
                        title: false, //不显示标题栏
                        skin: 'songke_layer_wrap', //样式类名
                        id: 'songke_layer', //设定一个id，防止重复弹出
                        closeBtn: 0, //不/显示关闭按钮
                        anim: 2,
                        shadeClose: 1, //开启/关闭遮罩
                        shade: [0.7, '#000'],
                        area: ['30%', '60%'],
                        content:res.data.content,
                        btn:false
                    });
                }else if(res.code == 2){
                    layer.open({
                        type: 1,
                        title: false, //不显示标题栏
                        skin: 'songke_layer_wrap', //样式类名
                        id: 'songke_layer2', //设定一个id，防止重复弹出
                        closeBtn: 0, //不/显示关闭按钮
                        anim: 2,
                        shadeClose: 1, //开启/关闭遮罩
                        shade: [0.7, '#000'],
                        area: ['30%', '60%'],
                        content:res.data.content,
                        btn:false
                    });
                }else if(res.code == 3){
                    layer.open({
                        type: 1,
                        title: false, //不显示标题栏
                        skin: 'songke_layer_wrap', //样式类名
                        id: 'songke_layer3', //设定一个id，防止重复弹出
                        closeBtn: 0, //不/显示关闭按钮
                        anim: 2,
                        shadeClose: 1, //开启/关闭遮罩
                        shade: [0.7, '#000'],
                        area: ['30%', '60%'],
                        content:res.data.content,
                        btn:false
                    });
                }else if(res.code == 4){
                    layer.open({
                        type: 1,
                        title: false, //不显示标题栏
                        skin: 'songke_layer_wrap', //样式类名
                        id: 'songke_layer4', //设定一个id，防止重复弹出
                        closeBtn: 0, //不/显示关闭按钮
                        anim: 2,
                        shadeClose: 1, //开启/关闭遮罩
                        shade: [0.7, '#000'],
                        area: ['30%', '60%'],
                        content:res.data.content,
                        btn:false
                    });
                }else if(res.code == 5){

                    layer.msg(res.message);
                    var url = "/course/access.html";
                    localStorage.setItem("redirect", url);

                    setTimeout(function(){
                        window.location.href = "/register";
                    }, 500);

                }
            }
        });

    });
    function makeAsk(){
        window.location.href="/cak/user/add.html?id="+id;
    }

    function getSpbCoin(obj){
        var cid = $(obj).attr('data-id');
        var token = '{{csrf_token()}}';
        var data = {cid:cid,_token:token};
        $.ajax({
            url:'/course/send/spb',
            type:'POST',
            data:data,
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    layer.msg(res.message);
                }
            }
        });
    }

    function courseStudy(obj){
        var cid = $(obj).attr('data-id');
        var vid = $(obj).attr('data-vid');

        window.location.href='/course/video/'+cid+'/'+vid+'.html';
    }

    //弹窗 课程领取成功
    $('.clickB2').click(function(){
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'songke_layer_wrap', //样式类名
            id: 'songke_layer2', //设定一个id，防止重复弹出
            closeBtn: 0, //不/显示关闭按钮
            anim: 2,
            shadeClose: 1, //开启/关闭遮罩
            shade: [0.7, '#000'],
            area: ['30%', '60%'],
            content:$('.jump2'),
            btn:false
        });
    });

    //弹窗 您已经拥有该课程 奉上1000赛普币
    $('.clickB3').click(function(){
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'songke_layer_wrap', //样式类名
            id: 'songke_layer3', //设定一个id，防止重复弹出
            closeBtn: 0, //不/显示关闭按钮
            anim: 2,
            shadeClose: 1, //开启/关闭遮罩
            shade: [0.7, '#000'],
            area: ['30%', '60%'],
            content:$('.jump3'),
            btn:false
        });
    });

    //弹窗 不要贪心哟 没有完成不能领取下一个课程
    $('.clickB4').click(function(){
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'songke_layer_wrap', //样式类名
            id: 'songke_layer4', //设定一个id，防止重复弹出
            closeBtn: 0, //不/显示关闭按钮
            anim: 2,
            shadeClose: 1, //开启/关闭遮罩
            shade: [0.7, '#000'],
            area: ['30%', '60%'],
            content:$('.jump4'),
            btn:false
        });
    });
</script>