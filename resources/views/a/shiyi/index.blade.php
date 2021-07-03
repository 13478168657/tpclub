<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>【双11立省299元】女会员业绩提升班</title>
    <meta name="author" content="" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <!--mmenu.css start-->
    <link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
    <link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
    <link href="/css/nav-mmenu-public.css" rel="stylesheet" />
    <!--end-->
    <link rel="stylesheet" href="/css/reset.css"/>
    <link rel="stylesheet" href="/css/font-num40.css" >
    <link rel="stylesheet" href="/css/zt/zt_payment.css">
    <link rel="stylesheet" href="/css/zt/zt_RightFloat.css">

    <link rel="stylesheet" href="/css/djs.css">
    <link rel="stylesheet" href="/css/shuang11.css?t=1">
    <!-- 20180918百度统计haiyang -->
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?88c4c1aabf71763aa97139b8279a3de6";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
    <!-- 20180918百度统计haiyang -->

    <!-- 20181029百度推送haiyang -->
    <script>
        (function(){
            var bp = document.createElement('script');
            var curProtocol = window.location.protocol.split(':')[0];
            if (curProtocol === 'https'){
                bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
            }
            else{
                bp.src = 'http://push.zhanzhang.baidu.com/push.js';
            }
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(bp, s);
        })();
    </script>
    <!-- 20181029百度推送haiyang -->
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
        </div>
    </nav>
    <!--头部导航 end-->

    <!--====================================本喵是分割线  喵喵~========================================================-->

    <div>
        <!-- banner start-->
        <div class="mb50">
            <img src="/images/shuang11/banner1.jpg" class="img100" alt="">
            <img src="/images/shuang11/banner2.jpg" class="img100" alt="">
        </div>
        <!-- banner end-->

        <!-- 内容 start-->
        <div class="shuang11 pl30 pr30">
            <!-- 购买此套餐立省299元 start -->
            <div class="wrapper wrapper1 bgcolor_fff">
                <div class="cat1">购买此套餐立省299元</div>
                <div class="text_center">
                    <h3 class="tit_line f28"><span>选择您要参加的班期</span></h3>
                </div>
                <ul class="banqi">
                    <?php
                        $orderStatistics = new App\Models\CourseClassGroupOrderStatistics();
                        $ordersFourNums = $orderStatistics->getOrderNumber(4,4);
                        $orderFiveNums = $orderStatistics->getOrderNumber(4,5);
                        $yunchanNums = $orderStatistics->getOrderNumber(1,12);
                    ?>
                    <li>
                        <h3 class="fz bold">减脂教练核心能力训练营</h3>
                        <ul class="clearfix">
                            <li class="item cur">
                                <div class="fl"><span class="btn2" data-stage="4">第4期 11月14日开班</span></div>
                                <div class="fr">名额仅剩：<em class="red1">{{($jianzhiCourse->people_set - $ordersFourNums['num'])>0?($jianzhiCourse->people_set - $ordersFourNums['num']):0}}</em>人</div>
                            </li>
                            <li class="item">
                                <div class="fl"><span class="btn2" data-stage="5">第5期 11月27日开班</span></div>
                                <div class="fr">名额仅剩：<em class="red1">{{($jianzhiCourse->people_set - $orderFiveNums['num'])>0?($jianzhiCourse->people_set - $orderFiveNums['num']):0}}</em>人</div>
                            </li>
                        </ul>
                        <div class="tag"><span class="f20">原价:199元</span></div>
                    </li>
                    <li>
                        <h3 class="fz bold">产后实战精英私教训练营</h3>
                        <ul class="clearfix">
                            <li class="item cur">
                                <div class="fl"><span class="btn2">第12期 11月21日开班</span></div>
                                <div class="fr">名额仅剩：<em class="red1">{{($yunchanCourse->people_set - $yunchanNums['num'])>0?($yunchanCourse->people_set - $yunchanNums['num']):0}}</em>人</div>
                            </li>
                        </ul>
                        <div class="tag"><span class="f20">原价:599元</span></div>
                    </li>
                </ul>
            </div>
            <!-- 购买此套餐立省299元 end -->
            <!-- 倒计时 start -->
            <div class="wrapper wrapper4 bgcolor_orange">
                <p class="mb20 pl20 ml10 fz f36 bold">活动时间仅剩:</p>
                <div class="ft_counter clearfix">
                </div>
            </div>
            <!-- 倒计时 end -->
            <!-- 都知道女性会员最好开单 start -->
            <div class="wrapper wrapper2 bgcolor_fff">
                <div class="text_center">
                    <div class="cat2_l">
                        <div class="cat2_r">
                            <h2 class="orange1 f36 lt">都知道女性会员最好开单</h2>
                        </div>
                    </div>
                    <h3 class="f26">但是很多健身教练正面临以下困境</h3>
                </div>
                <ul>
                    <li>
                        <dl class="f24">
                            <dt class="bold f28">职业规划不清晰</dt>
                            <dd>
                                <p class="fz">什么课都能带，什么课都带的不好，什么都学的不精，提高客单价难！难！难！</p>
                            </dd>
                        </dl>
                    </li>
                    <li>
                        <dl class="f24">
                            <dt class="bold f28">职业认知片面</dt>
                            <dd>
                                <p class="fz">不了解女性会员，为什么同样是女的，生没生孩子的减脂塑形完全是不一样的？</p>
                            </dd>
                        </dl>
                    </li>
                    <li>
                        <dl class="f24">
                            <dt class="bold f28">职业遇到瓶颈</dt>
                            <dd>
                                <p class="fz">亲手把会员从健身小白培养成健身大神，接下来该如何让会员持续优秀，不断复购？</p>
                            </dd>
                        </dl>
                    </li>
                </ul>
            </div>
            <!-- 都知道女性会员最好开单 end -->

            <div class="wrapper wrapper3 bgcolor_fff">
                <h2 class="cat3">《女会员业绩提升班》给你解决职业困惑，帮你脱颖而出</h2>
                <!-- 专为服务女性会员 start -->
                <div class="text_center">
                    <div class="cat2_l">
                        <div class="cat2_r">
                            <h2 class="orange1 f36 lt">专为服务女性会员<br />定制的教练进阶课程</h2>
                        </div>
                    </div>
                    <h3 class="f26">成为女性之友不在话下</h3>
                </div>
                <div class="box1 clearfix">
                    <div class="box_l">
                        <div class="wrap">
                            <img src="/images/shuang11/1.jpg" alt="" />
                            <h3>普通女会员</h3>
                            <h4>减脂、塑形</h4>
                        </div>
                        <div class="wrap">
                            <img src="/images/shuang11/2.jpg" alt="" />
                            <h3>产后女会员</h3>
                            <h4>产后恢复</h4>
                        </div>
                    </div>
                    <div class="box_r">
                        <img src="/images/shuang11/3.jpg" alt="" />
                        <h4>服务女性会员的<br />精英健身教练</h4>
                    </div>
                </div>
                <!-- 专为服务女性会员 end -->
                <!-- 一线大咖导师授课 start -->
                <div class="text_center">
                    <div class="cat2_l">
                        <div class="cat2_r">
                            <h2 class="orange1 f36 lt">一线大咖导师授课</h2>
                        </div>
                    </div>
                    <h3 class="f26">多年实战经验 倾囊相授</h3>
                </div>
                <ul class="teacher">
                    <li>
                        <h3 class="lt">减脂教练核心能力养成营</h3>
                        <dl>
                            <dt><img src="/images/shuang11/4.jpg" alt="" /></dt>
                            <dd>罗显婷</dd>
                        </dl>
                        <ul>
                            <li>赛普健身冠军导师</li>
                            <li>PTA-Global国际私教认证</li>
                        </ul>
                    </li>
                    <li>
                        <h3 class="lt">产后实战精英私教训练营</h3>
                        <dl>
                            <dt><img src="/images/shuang11/5.jpg" alt="" /></dt>
                            <dd>田坤</dd>
                        </dl>
                        <ul>
                            <li>赛普健身孕产导师</li>
                            <li>美国FORTANASCE国际孕产康复认证</li>
                            <li>Polestar北极星普拉提教练认证</li>
                        </ul>
                    </li>
                </ul>
                <!-- 一线大咖导师授课 end -->
                <!-- 线上学习时间更自由 start -->
                <div class="text_center">
                    <div class="cat2_l">
                        <div class="cat2_r">
                            <h2 class="orange1 f36 lt">线上学习时间更自由</h2>
                        </div>
                    </div>
                    <h3 class="f26">导师全程带班，不怕不会没人问</h3>
                </div>
                <ul class="xuexi">
                    <li>
                        <dl>
                            <dt class="f28 bold">在线学习</dt>
                            <dd>报名后即可在赛普健身社区【我的课表】中找到视频课进行学习，永久复听</dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt class="f28 bold">线上管理</dt>
                            <dd>开班后将成立线上班级群，导师全程辅导班主任全程跟踪</dd>
                        </dl>
                    </li>
                    <li>
                        <dl>
                            <dt class="f28 bold">导师点评</dt>
                            <dd>按时提交课后作业，都会得到授课导师的点评哪里没学好，点评全知道</dd>
                        </dl>
                    </li>
                </ul>
                <!-- 线上学习时间更自由 end -->
                <!-- 比单独购买更加优惠 start -->
                <div class="text_center">
                    <div class="cat2_l">
                        <div class="cat2_r">
                            <h2 class="orange1 f36 lt">比单独购买更加优惠</h2>
                        </div>
                    </div>
                </div>
                <ul class="priceList f24">
                    <li>
                        <a href="/train/study.html?id=4">
                            <div class="fl">减脂教练核心能力训练营</div>
                            <div class="fr bold">原价：￥199元</div>
                        </a>
                    </li>
                    <li>
                        <a href="/train/study.html">
                            <div class="fl">产后实战精英私教训练营</div>
                            <div class="fr bold">原价：￥599元</div>
                        </a>
                    </li>
                </ul>
                <div class="priceWrap">
                    <span class="bold f28">双11套餐特惠价：</span>
                    <span class="price">499</span>
                    <span class="btn1 f28">立省299元</span>
                </div>
                <!-- 比单独购买更加优惠 end -->
                <!-- 常见Q&A start -->
                <div class="text_center">
                    <h2 class="cat4">常见Q&A</h2>
                </div>
                <dl class="qa">
                    <dt class="lt f32">1、报名后就可以立即学习吗？</dt>
                    <dd> 报名后，关注【赛普健身社区】公众号进入【我的课表】即可在线学习视频课程。</dd>
                </dl>
                <dl class="qa">
                    <dt class="lt f32">2、开班后导师教学如何安排？</dt>
                    <dd>开班后，每周会在班级群内公布本周学习计划，学员自行学习线上录播视频课并完成作业后会得到导师的点评导师会根据学员的课程进度和作业情况每周在群内做一次作业讲解和特别分享。</dd>
                </dl>
                <dl class="qa">
                    <dt class="lt f32">3、学习中遇到问题怎么办？</dt>
                    <dd>所有报名学员享有导师答疑权限3个月，有问题可以在导师专区发起提问。</dd>
                </dl>
                <dl class="qa">
                    <dt class="lt f32">4、可以退费吗？</dt>
                    <dd>社区上的所有课程为虚拟产品，一旦购买成功，不接受退费。</dd>
                </dl>
                <!-- 常见Q&A end -->
            </div>
        </div>
        <!-- 内容 end-->


        <!-- 悬浮底部 start-->
        <div class="fixed_bot">
            <div class="footer clearfix">
                <div class="fl">
                    <div class="text_right">
                        <span class="btn1 f22">立省299元</span>
                    </div>
                    <div class="">
                        <span class="bold f28">双11套餐特惠价：</span>
                        <span class="price f50">499</span>
                    </div>
                </div>
                @if(!$is_buy)
                    @if($mobile)
                        <div class="fr">
                            {{--<span class="btn1 f36 open-popup" data-target="#half">立即报名</span>--}}
                            <a href="javascript:void(0);" class="btn1 f36 studyBtn open-popup" data-target="#half">立即报名</a>
                        </div>
                    @else
                        <div class="fr">
                            <span class="btn1 f36 open-popup" onclick="userlogin();">立即报名</span>
                        </div>

                    @endif
                @else
                    <div class="fr">
                        <span class="btn1 f36 open-popup">已报名</span>
                    </div>
                @endif
            </div>
        </div>
        <!-- 悬浮底部 end-->


        <!--右侧悬浮 【微信】 start-->
        <div class="relative codeWBtn">
            <div class="right-suspension_wx text_center pt10 right_Float_wx">
                <a href="javascript:void (0)">
                    <img src="/activity/award/images/zt/giftgive/weixin.png" alt="">
                    <p class="fz f20 bold">微信咨询</p>
                </a>
            </div>
        </div>
        <!--右侧悬浮 【微信】 end-->

        <!--右侧悬浮 【分销】start-->
        @if($is_staff)
        <div class="right-Invitation text_center open-popup" data-target="#Invitation">
            <a href="javascript:void(0)" class="color_fff fz f24 bold plr25">分销</a>
        </div>
        @endif
        <!--右侧悬浮 【邀请】end-->


        <!-- 底部弹出popup start -->
        <div id="half" class='weui-popup__container popup-bottom payType_popup'>
            <div class="weui-popup__overlay"></div>
            <div class="weui-popup__modal fz">
                <div class="toolbar bgcolor_fff">
                    <div class="toolbar-inner ">
                        <a href="javascript:;" class="picker-button close-popup">关闭</a>
                        <h1 class="title bold">确认付款</h1>
                    </div>
                </div>

                <div class="modal-content bgc_white">
                    <div class="mor_list fz color_333 plr30 ptb30">
                        <div class="weui-cell  mt0 padding0">
                            <div class="weui-cell__bd">
                                <p class="f32 color_333 bold">课程原价</p>
                            </div>
                            <div class="weui-cell__ft price color_333 bold f28 bold">798元</div>
                        </div>
                    </div>
                    <div class="weui-cell weui-cell borderBt borderAt">
                        <div class="weui-cell__bd">
                            <h2 class="f28 bold">最终合计</h2>
                        </div>
                        <div class="weui-cell__ft">
                            <span class="price bold">499元</span>
                        </div>
                    </div>
                    <div class="weui-cells weui-cells_radio nobefore noafter  dd">
                        <label class="weui-cell weui-check__label" for="x11">
                            <div class="weui-cell__bd f28">
                                <p><i class="ico_wx"></i>微信支付</p>
                            </div>
                            <div class="weui-cell__ft">
                                <input type="radio" class="weui-check" name="radio1" id="x11" checked="checked" value="WXPAY">
                                <span class="weui-icon-checked"></span>
                            </div>
                        </label>
                    </div>
                    <div class="container_btn ptb20">
                        <a href="javascript:void(0);" class="roy_btn bgcolor_orange payBtn">立即付款</a>
                    </div>
                    {{--<div class="container_btn ptb20 mt30">--}}
                        {{--<a href="javascript:void(0);" data-type="single" class="roy_btn bgcolor_orange payBtn">立即付款</a>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
        <!-- 底部弹出popup end -->


        <!--底部弹出popup 邀请内容 start-->
        <div>
            <div id="Invitation" class="weui-popup__container popup-bottom">
                <div class="weui-popup__overlay"></div>
                <div class="weui-popup__modal">
                    <div class="toolbar bgcolor_fff ">
                        <div class="tabbs">
                            <a href="javascript:;" class="picker-button close-popup">关闭</a>
                        </div>
                    </div>
                    <!--你的内容放在这里... start-->
                    <div class="text_center pt98 bgc_white fz">
                        <h3 class="mb40 color_ff6d1e f40 bold">分享赚取佣金</h3>
                        <p class="f26 color_gray666">分享下方链接/图片给好友，</p>
                        <p class="f26 color_gray666">好友报名后，你可获得好友实际支付金额的5%作为佣金~</p>
                        <p class="f26 color_gray666">在分销中心课看到你的分销记录哦~</p>

                        <div class="InvBtn plr30 clearfix fz pb30 pt40 mt30">
                            <a href="javascript:void (0)" class="fl bg_ff9a03 f24 border-radius-img shareRulelink"><img src="/images/zt/biglesson/icon-w.png" alt="">分享链接</a>
                            <a href="javascript:void (0)" class="fl bg_ff9a03 f24 border-radius-img shareRuleImg">分享图片</a>
                            <a href="/dist/sale/index.html" class="fl bg_ff9a03 f24 border-radius-img">分销中心</a>
                        </div>
                    </div>
                    <!--你的内容放在这里... end-->
                </div>
            </div>
        </div>
        <!--底部弹出popup 邀请内容 end-->
    </div><!--导航大盒子id=page 结束-->
</div>


<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>

<!-- 倒计时 -->
<script src="/lib/djs/jquery.easing.js"></script>
<script src="/lib/djs/fliptimer.js"></script>
<script type="text/javascript">
    $(".ft_counter").EightycloudsFliptimer({
        enddate    : "13 November 2019 12:00:00 GMT",
        callback   : function(){
            alert("本活动已结束!");
        }
    });
    $(function (){
        //$(".ft_counter .EightycloudsFlipTimer .hours").after("<div class='clear'></div>");
        $('.ft_counter .EightycloudsFlipTimer .days .block_text').text('天');
        $('.ft_counter .EightycloudsFlipTimer .hours .block_text').text('时');
        $('.ft_counter .EightycloudsFlipTimer .minutes .block_text').text('分');
        $('.ft_counter .EightycloudsFlipTimer .seconds .block_text').text('秒');
    })

</script>
<script>


    //将裂变者id写入本地  用于存储上下级关系
    var fission_id = "{{$fission_id}}";
    if(fission_id>0){
        localStorage.setItem("fission_id", fission_id);
    }

    //跳转登陆函数
    var href_url = "/dist/buy/sy.html?fission_id="+fission_id;
    var userlogin = function(){
        var url = href_url;
        localStorage.setItem("redirect", url);
        layer.msg('请先注册');
        setTimeout(function(){
            window.location.href = "/register";
        }, 500)
    }

    $("body").addClass("bgcolor_000");

    var stageJ = 4;
    var stageY = 12;
    var is_weixin = '{{$is_weixin}}';
    var token = '{{csrf_token()}}';
    $('.shuang11 .wrapper1 .banqi > li .item .btn2').click(function(){
        stageJ = $(this).attr('data-stage');
        $(this).parents('.item').addClass("cur").siblings().removeClass("cur");
    });

    //分享链接弹窗
    $('.shareRulelink').click(function(){
        $.closePopup();//关闭底部弹出【邀请】
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
            content: '<div class="text_center tan-font color_fff f32 fz ptb86 fx-img" >' +
            '<img src="/images/fenxiang-j.png" class="fx_success down-arrow d-in-black" id="dou" alt="" />' +
            '<p class="pt40 color_fff f36 fz bold ">点击这里分享吧！</p>' +
            '<p class="text_left pl135 pt40 pb30">1、点击“<img src="/images/more.png" alt="" class="d-in-black more-s">”</p>' +
            '<p class="text_left pl135">2、点击“<img src="/images/pyq.png" alt="" class="d-in-black more-s">”分享到朋友圈</p>' +
            '</div>',
            btn: false,
            success: function(v){
                /*点击文字也可以全部关闭*/
                $('.fxpyq_success_layer_wrap').click(function(){
                    parent.layer.closeAll()
                });
            }
        });
    });


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

    //免费报名成功或者购买成功后跳转
    function href_go(){
        location.href = "/train/success";
    }

    $(function () {
        $('.zaoniao_btn a').click(function () {
            $(this).addClass('bg_orange_active').siblings().removeClass('bg_orange_active');
            var index=$(this).index();
            $(".foot .foot_uu ul li.xiaoqu .h_box").eq(index).show().siblings().hide().removeClass("block");
        });

        //分享海报弹窗
        $('.shareRuleImg').click(function () {
            $.closePopup();//关闭底部弹出【分销】
            var type = 'shiyi';
            var data = {id:4,type:type,_token:'{{csrf_token()}}'};
            $.ajax({
                url:'/activeCourse/acsm/poster',
                data:data,
                type:'POST',
                dataType:'json',
                success:function(res){

                    if(res.code == 0){
                        var content = '<div class="friend_layer text_center tan-font"><img src="'+res.data.img+'" class="bm_success" alt="" /></div>';
                        layer.open({
                            type: 1,
                            title: false, //不显示标题栏
                            skin: 'friend_layer', //样式类名
                            id: 'friend_layer', //设定一个id，防止重复弹出
                            closeBtn: 1, //不显示关闭按钮
                            anim: 2,
                            shadeClose: true, //开启遮罩关闭
                            area: ['90%', '80%'],
                            content: content,
                            btn: false
                        });
                    }
                }
            });
        });

        //二维码弹窗
        $('.codeWBtn').click(function(){
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'codeW_layer_wrap', //样式类名
                id: 'codeW_layer', //设定一个id，防止重复弹出
                closeBtn: 1, //不/显示关闭按钮
                anim: 2,
                shadeClose: 1, //开启/关闭遮罩
                shade: [0.7, '#000'],
                area: ['30%', '60%'],
                content:'<div class="hideWImg text_center mt32">' +
                '<p class="fz f30 color_333 mb20 bold pt20">扫描二维码</p>' +
                '<img src="/images/jinqun.jpg" alt="赛普健身社区">' +
                '<p class="plr30 fz f30 color_333 mt20">' +
                '<span class="block bold">加课程顾问微信</span>' +
                '<span class="block bold">备注：活动咨询</span>' +
                '</p>' +
                '</div>',
                btn:false
            });
        });




        //立即付款弹出框
        $('.payBtn').click(function (){

            var payfrom = $("input[name='radio1']:checked").val();
            if(payfrom=='BANLANCE'){
                $.closePopup();
                $.confirm({
                    title: '提示',
                    text: '立即购买学习该课程，确认购买吗？',
                    onOK: function () {
                        //点击确认
                        $.ajax({
                            type:"GET",
                            url:"/course/paybalance",
                            data:{c_c_id:c_c_id, user_id:user_id},
                            dataType:"json",
                            success:function(result){
                                if(result.code==1){
                                    layer.msg(result.msg);
                                    setTimeout(function(){
                                        href_go();     //支付成功跳转
                                    },1500)  //延迟1.5秒刷新页面
                                }else{
                                    layer.msg(result.msg);
                                }
                            }
                        });
                    },
                    onCancel: function (){
                    }
                });
            }else if(payfrom=="WXPAY"){
                if(is_weixin==1){
                    jsApiCall();
                }else{
                    $.ajax({
                        type:"POST",
                        url:"/sy/active/payh",
                        data:{dis_id:fission_id,stagey:stageY,stagej:stageJ,_token:token},
                        dataType:"json",
                        success:function(res){
                            if(res.code==1){
                                console.log(res.objectxml.mweb_url);
                                //follow_us();
                                window.location.href=res.objectxml.mweb_url;   //h5呼叫微信支付
                            }else{
                                if(res.code == 2 || res.code == 3){

                                    layer.open({
                                        type: 1,
                                        title: false, //不显示标题栏
                                        skin: 'codeW_layer_wrap', //样式类名
                                        id: 'codeW_layer', //设定一个id，防止重复弹出
                                        closeBtn: 1, //不/显示关闭按钮
                                        anim: 2,
                                        shadeClose: 1, //开启/关闭遮罩
                                        shade: [0.7, '#000'],
                                        area: ['30%', '60%'],
                                        content:'<div class="hideWImg text_center mt32 fz">' +
                                        '<p class="fz f34 color_333 mb20 bold pt98">抱歉!</p >' +
                                        '<p class="plr30 fz f30 color_333 mt30 mb20">' +
                                        '<span class="block bold">你已经报名</span>' +
                                        '<span class="block bold">'+res.data.buyed+'</span>' +
                                        '<span class="block mt30 f28 lin40">若想报名'+res.data.noBuy+'直接购买更优惠哦~</span>' +
                                        '</p >' +
                                        '<a href="'+res.data.link+'" class="tiao d-in-black mt32 ptb20 bgcolor_orange border-radius-img">立即前往</a >'+
                                        '</div>',
                                        btn:false
                                    });

                                }else if(res.code == 4){
                                    layer.open({
                                        type: 1,
                                        title: false, //不显示标题栏
                                        skin: 'codeW_layer_wrap', //样式类名
                                        id: 'codeW_layer2', //设定一个id，防止重复弹出
                                        closeBtn: 1, //不/显示关闭按钮
                                        anim: 2,
                                        shadeClose: 1, //开启/关闭遮罩
                                        shade: [0.7, '#000'],
                                        area: ['30%', '50%'],
                                        content:'<div class="hideWImg text_center mt32 fz">' +
                                        '<p class="fz f34 color_333 mb40 bold pt98 mt32">抱歉!</p >' +
                                        '<p class="plr30 fz color_333 mt30 mb40">' +
                                        '<span class="block bold mb50 f36">您已经报名过这两套课程~</span>' +
                                        '</p >' +
                                        '<a href="/user/studying" class="tiao d-in-black mt32 ptb20 bgcolor_orange border-radius-img">立即学习</a >'+
                                        '</div>',
                                        btn:false
                                    });
                                }else{
                                    layer.msg(res.msg);
                                }

                            }
                        }
                    });
                }
            }
        })

        //调用微信JS api 支付
        function jsApiCall()
        {
            var _token = '{{csrf_token()}}';
            var data = {dis_id:fission_id,stagey:stageY,stagej:stageJ,_token:_token};
            $.ajax({
                url:'/sy/active/pay',
                data:data,
                type:'POST',
                dataType:'json',
                success:function(res){
                    if(res.code != 0){
                        if(res.code == 2 || res.code == 3){

                            layer.open({
                                type: 1,
                                title: false, //不显示标题栏
                                skin: 'codeW_layer_wrap', //样式类名
                                id: 'codeW_layer', //设定一个id，防止重复弹出
                                closeBtn: 1, //不/显示关闭按钮
                                anim: 2,
                                shadeClose: 1, //开启/关闭遮罩
                                shade: [0.7, '#000'],
                                area: ['30%', '60%'],
                                content:'<div class="hideWImg text_center mt32 fz">' +
                                '<p class="fz f34 color_333 mb20 bold pt98">抱歉!</p >' +
                                '<p class="plr30 fz f30 color_333 mt30 mb20">' +
                                '<span class="block bold">你已经报名</span>' +
                                '<span class="block bold">'+res.data.buyed+'</span>' +
                                '<span class="block mt30 f28 lin40">若想报名'+res.data.noBuy+'直接购买更优惠哦~</span>' +
                                '</p >' +
                                '<a href="'+res.data.link+'" class="tiao d-in-black mt32 ptb20 bgcolor_orange border-radius-img">立即前往</a >'+
                                '</div>',
                                btn:false
                            });

                        }else if(res.code == 4){
                            layer.open({
                                type: 1,
                                title: false, //不显示标题栏
                                skin: 'codeW_layer_wrap', //样式类名
                                id: 'codeW_layer2', //设定一个id，防止重复弹出
                                closeBtn: 1, //不/显示关闭按钮
                                anim: 2,
                                shadeClose: 1, //开启/关闭遮罩
                                shade: [0.7, '#000'],
                                area: ['30%', '50%'],
                                content:'<div class="hideWImg text_center mt32 fz">' +
                                '<p class="fz f34 color_333 mb40 bold pt98 mt32">抱歉!</p >' +
                                '<p class="plr30 fz color_333 mt30 mb40">' +
                                '<span class="block bold mb50 f36">您已经报名过这两套课程~</span>' +
                                '</p >' +
                                '<a href="/user/studying" class="tiao d-in-black mt32 ptb20 bgcolor_orange border-radius-img">立即学习</a >'+
                                '</div>',
                                btn:false
                            });
                        }else{
                            layer.msg(res.message);
                        }

                        return false;
                    }else{
                        var data = res.data;
                    }
                    WeixinJSBridge.invoke(
                            'getBrandWCPayRequest',
                            data,
                            function(res){
                                WeixinJSBridge.log(res.err_msg);
                                if(res.err_msg=='get_brand_wcpay_request:ok'){
                                    layer.msg('支付成功');
                                    href_go();     //支付成功跳转
                                }else{
                                    layer.msg('取消支付');
                                }
                            }
                    );
                }
            })

        }
    })

</script>
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
    <?php

    ?>
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: '【立省299元】健身教练进阶计划', // 分享标题
            desc: '双11狂欢特惠，针对女会员开单的业绩提升班火热招生中……', // 分享描述
            link: "http://m.saipubbs.com/dist/buy/sy.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            {{--link: "http://m.saipubbs.com/nasm/active.html?fid={{$user_id}}",--}}
            imgUrl: "http://m.saipubbs.com/activity/images/sheng.png", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '【立省299元】健身教练进阶计划', // 分享标题
            link: "http://m.saipubbs.com//dist/buy/sy.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            {{--link: "http://m.saipubbs.com/nasm/active.html?fid={{$user_id}}",--}}
            imgUrl: "http://m.saipubbs.com/activity/images/sheng.png", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });

</script>
</body>
</html>







