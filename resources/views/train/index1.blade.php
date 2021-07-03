<?php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-{{$courseClassGroup->title}}</title>
    <meta name="author" content="啾啾" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <!--mmenu.css start-->
    <link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
    <link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
    <link href="/css/nav-mmenu-public.css" rel="stylesheet" />
    <!--end-->
    <link href="/lib/swiper/swiper.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/reset.css?t=3" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" >

    <!--本css-->
    <link rel="stylesheet" href="/css/zt/zt_biglesson.css?t={{time()}}">
    <link rel="stylesheet" href="/css/zt/zt_payment.css">

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
                <li><a href="/article/0.html">文章</a></li>
                <li><a href="/cak/1.html">问答</a></li>
                <li><a href="/user/studying">我的课程</a></li>
                <li><a href="/user/index">我的</a></li>
                <li><a href="javascript:history.go(-1);">返回</a></li>
                @if(!is_weixin())
                    @if($user)
                        <li><a href="/logout">退出</a></li>
                    @else
                        <li><a href="/register">注册/登录</a></li>
                    @endif
                @endif
            </ul>
        </div>
    </nav>
    <!--头部导航 end-->

    <div>
        <!--banner start-->
        <div>
            <img src="{{env('IMG_URL')}}{{$courseClassGroup->cover_url}}" alt="">
        </div>
        <!--banner end-->
        <!-- ——————————————————————————————本喵是分割线————————————————————————————————-->
        <!--早鸟价 start-->
        <div class="mt45 mb80">

            <!--切换的内容 start-->
            <?php
                $i=0;
//                $teamPrice = $courseClassGroup->team_price;
            ?>
            @foreach($courseData['periods'] as $k => $period)
                <?php
                $i++;
                $orderStatistics = new App\Models\CourseClassGroupOrderStatistics();
                $ordersNums = $orderStatistics->getOrderNumber($period->course_class_group_id,$period->stage);
                if(isset($ordersNums['num']) || $ordersNums['num'] < $discount_num){
                    $flag = 1;
                }else{
                    $flag = 0;
                }
                if($i == 1){
                    $teamPrice = $period->birdPrice;
                    $currentPrice = $period->originPrice;
                    $stage = $period->stage;
//                    dd($teamPrice,$currentPrice,$stage);
                }

                $restTime = floor((strtotime($period['begin_time'])- time())/86400);
                if(date('Y-m-d',strtotime($period['begin_time'])) != date('Y-m-d') && $restTime == 0){
                    $restTime = 1;
                }else{
                    $restTime = 0;
                }
//                $disBeginTime =  date('Y-m-d',);
                ?>
                <div class="zaoniao zaoniaos plr30 {{$i==2?"none":''}}" id="{{$i==2?"zao2":'zao1'}}">
                    @if($flag)
                        <div class="clearfix pt20">
                            <p class="color_gray666 fl f20 fz text_left">拼团购买:<strong class="f38 bold color_ff7200">{{$period->birdPrice}}</strong><span class="color_ff7200">元</span></p>
                            <p class="color_gray666 fl f20 fz text_center">单独购买:{{$period->originPrice}}元</p>
                            <p class="color_gray666 fl f20 fz text_right">名额仅剩:<strong class="f38 bold color_ff7200">{{($courseClassGroup->people_set - $ordersNums['num'])>0?($courseClassGroup->people_set - $ordersNums['num']):0}}</strong><span class="color_ff7200"></span></p>
                        </div>
                    @else
                        <div class="clearfix pt20">
                            <p class="color_gray666 fl f20 fz text_left">拼团购买:<strong class="f38 bold color_ff7200">{{$period->birdPrice}}</strong><span class="color_ff7200">元</span></p>
                            <p class="color_gray666 fl f20 fz text_center">单独购买:{{$period->originPrice}}元</p>
                            <p class="color_gray666 fl f20 fz text_right">名额仅剩:<strong class="f38 bold color_ff7200">{{$courseClassGroup->people_set}}</strong><span class="color_ff7200"></span></p>
                        </div>
                    @endif
                </div>
            @endforeach

            <!--底部悬浮框 start-->
            <div class="relative">
                <div class="footers plr20 bg_fdf3cc footers_s">
                    <ul class="clearfix mt20">
                        <?php
                            $i=0;
                            $isShow = 0;
                        ?>
                        @foreach($courseData['periods'] as $k => $period)
                            <?php
                            $i++;
                            $orderStatistics = new App\Models\CourseClassGroupOrderStatistics();
                            $ordersNums = $orderStatistics->getOrderNumber($period->course_class_group_id,$period->stage);
                            if(!isset($ordersNums['num']) || $ordersNums['num'] < $discount_num){
                                $flag = 1;
                            }else{
                                $flag = 0;
                            }

//                            $restTime = floor((strtotime($period['begin_time'])- time())/86400);
//
//                            if(date('Y-m-d',strtotime($period['begin_time'])) != date('Y-m-d') && $restTime == 0){
//                                $restTime = 1;
//                            }else{
//                                $restTime = 0;
//                            }

                            ?>
                            @if($discount_num - $ordersNums['num'] <= 0)
                                @if($is_buy)
                                    @if($isTeam)
                                        @if($isTeamSuccess)
                                            <li data-id="{{$i}}" class="fr newclassbtn fz f30 text_center bgcolor_orange border-radius-img is_buy"><a href="/train/success?id={{$courseClassGroup->id}}" class="studyBtn">报名成功 完善报名信息</a></li>
                                        @else
                                            <li data-id="{{$i}}" class="fr newclassbtn fz f30 text_center bgcolor_orange border-radius-img is_buy"><a href="/train/success/{{$courseClassGroup->id}}.html" class="studyBtn">邀请好友 参加拼团</a></li>
                                        @endif
                                    @else
                                        <li data-id="{{$i}}" class="fr newclassbtn fz f30 text_center bgcolor_orange border-radius-img is_buy"><a href="/train/success?id={{$courseClassGroup->id}}" class="studyBtn">报名成功 完善报名信息</a></li>
                                    @endif
                                    <?php
                                        $isShow = 1;
                                    ?>
                                @else
                                    <li data-id="{{$i}}" class="fr newclassbtn fz f30 text_center bgcolor_orange border-radius-img extro_num extro_num {{$i==2?'none':''}}"><a href="javascript:void(0);" class="studyBtn">报名人数已满 请报名下一期</a></li>
                                @endif
                            @else
                                @if($is_buy && $isShow == 0)
                                        @if($isTeam)
                                            @if($isTeamSuccess)
                                                <li data-id="{{$i}}" class="fr newclassbtn fz f30 text_center bgcolor_orange border-radius-img is_buy"><a href="/train/success?id={{$courseClassGroup->id}}" class="studyBtn">报名成功 完善报名信息</a></li>
                                            @else
                                                <li data-id="{{$i}}" class="fr newclassbtn fz f30 text_center bgcolor_orange border-radius-img is_buy"><a href="/train/success/{{$courseClassGroup->id}}.html" class="studyBtn">邀请好友 参加拼团</a></li>
                                            @endif
                                        @else
                                            <li data-id="{{$i}}" class="fr newclassbtn fz f30 text_center bgcolor_orange border-radius-img is_buy"><a href="/train/success?id={{$courseClassGroup->id}}" class="studyBtn">报名成功 完善报名信息</a ></li>
                                        @endif
                                    <?php
                                        $isShow = 1;
                                    ?>
                                @else
                                    <li class="fl fz f30 text_center bgcolor_orange border-radius-img {{$i== 2? 'none':''}}" id="{{$i==2?"zao3":'zao5'}}">
                                        @if($mobile == 0)
                                            <a href="javascript:void (0)" class="studyBtn open-popup" onclick="userlogin()"><span class="f36">{{$period->originPrice}}元&nbsp;&nbsp;</span>单独购买</a>
                                        @else
                                            <a href="javascript:void (0)" class="studyBtn open-popup" data-target="#half"><span class="f36">{{$period->originPrice}}元&nbsp;&nbsp;</span>单独购买</a>
                                        @endif
                                    </li>
                                    <li class="fr fz f30 text_center bgcolor_orange border-radius-img {{$i== 2? 'none':''}}" id="{{$i==2?"zao4":'zao6'}}">
                                        @if($mobile == 0)
                                            <a href="javascript:void (0)" class="studyBtn open-popup"  onclick="userlogin();"><span class="color_red f36">{{$period->birdPrice}}元&nbsp;&nbsp;</span>{{$courseClassGroup->team_people}}人拼团</a>
                                        @else
                                            <a href="javascript:void (0)" class="studyBtn open-popup" data-target="#halfs"><span class="color_red f36">{{$period->birdPrice}}元&nbsp;&nbsp;</span>{{$courseClassGroup->team_people}}人拼团</a>
                                        @endif
                                    </li>
                                @endif
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <!--底部悬浮框 end-->
            <!--切换的内容 end-->

            <!--按钮切换 start-->
            <div class="zaoniao_btn2 mt60 plr25 clearfix text_center relative">
                <?php
                $i = 0;
                $total = count($courseData['periods']);
                ?>
                @foreach($courseData['periods'] as $k => $period)

                    <?php
                        $i++;
                        $restTime = 86400+1;
                        $playDate = date('m月d日',strtotime($period->begin_time));
                        $orderStatistics = new App\Models\CourseClassGroupOrderStatistics();
                        $ordersNums = $orderStatistics->getOrderNumber($period->course_class_group_id,$period->stage);

                        if(!isset($ordersNums['num']) || $ordersNums['num'] < $discount_num){
                            $flag = 1;
                        }else{
                            $flag = 0;
                        }

                    ?>

                    @if($total == 1)
                        <a href="javascript:void (0)" data-id="{{$period->stage}}" data-price="{{$period->originPrice}}" data-itemPrice="{{$period->birdPrice}}" style="width:100%" onclick="{{$i==1?'zao_show1':'zao_show2'}}(this);" class="button fl border-radius-img fz f24 bg_ff9a03 {{$i==1?'bg_ff9a03':''}}">{{$period['name']}}&nbsp;{{$playDate}}&nbsp;开班</a>
                        @if($flag)
                            {{--<img src="/images/zt/chanhoushijian/youhui.jpg" alt="" class="youhui"/>--}}
                        @endif
                    @else
                        <a href="javascript:void(0)" data-id="{{$period->stage}}" data-price="{{$period->originPrice}}" data-itemPrice="{{$period->birdPrice}}" onclick="{{$i==1?'zao_show1':'zao_show2'}}(this);" class="button {{$i==1?'fl':'fr'}} border-radius-img fz f24  {{$i==1?'bg_ff9a03':''}}">{{$period['name']}}&nbsp;{{$playDate}}&nbsp;开班</a>
                            @if($flag)
                                @if($k == 1)
                                {{--<img src="/images/zt/chanhoushijian/youhui.jpg" alt="" class="youhui"/>--}}
                                @else
                                {{--<img src="/images/zt/chanhoushijian/youhui.jpg" alt="" class="youhui2"/>--}}
                                @endif
                            @endif
                    @endif
                @endforeach

            </div>
            <!--按钮切换 end-->
        </div>
        <!--早鸟价 end-->

        <!--——————————————————————————————本喵是分割线————————————————————————————————-->
        <img src="{{env('IMG_URL')}}{{$courseClassGroup->activity_url}}" alt="">

    </div>

    <!--——————————————————————————————本喵是分割线————————————————————————————————-->
    <!--选项卡 start-->
    <div>
        <!-- 本例主要代码 Start ================================ -->
        <div id="leftTabBox" class="tabBox">
            <div class="hd biglesson-nav" id="nav_keleyi_com">
                <ul class="clearfix text_center fz f28 color_gray666">
                    <li class="on"><a href="javascript:void (0)">课程介绍</a></li>
                    <li><a href="javascript:void (0)">课程大纲</a></li>
                </ul>
            </div>
            <div class="bd" id="tabBox1-bd">
                <div class="con clearfix">
                    <!--第一页 start-->
                    <div class="height_block">
                        <!--====================================本喵是分割线  喵喵~========================================================-->
                        <div class="">
                            <img src="{{env('IMG_URL')}}{{$courseClassGroup->recommend_url}}" alt="">
                            <div class="">
                                <!--视频 start-->
                                <div class="text_center">
                                    <!--sp start-->
                                    <div class="relative">
                                        <img src="/images/zt/biglesson/mf.png" alt="" class="mf">
                                        <div class="con">
                                            <div class="video">
                                                <div class="box2">
                                                    <img src="{{env('IMG_URL')}}{{$courseClassGroup->video_img}}" alt=""/>
                                                    <div class="mask"></div>
                                                    <span class="btn_play"></span>
                                                </div>
                                                <video class="" src="{{$courseClassGroup->video_url}}" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto"></video>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--视频 end-->
                            </div>
                            <img src="{{env('IMG_URL')}}{{$courseClassGroup->explain_url}}" alt="">
                            <img src="/images/zt/biglesson/left2.png" alt="">
                        </div>
                        <!--====================================本喵是分割线  喵喵~========================================================-->
                        <br><br>
                    </div>
                    <!--第一页 end-->
                </div>
                <div class="con">
                    <!--第二页 start-->
                    <div class="height_block">
                        <div class="">
                            <img src="{{env('IMG_URL')}}{{$courseClassGroup->desc_url}}" alt="">
                        </div>
                        <br><br>
                    </div>
                    <!--第二页 end-->
                </div>
            </div>

        </div>

        <script src="/js/TouchSlide.1.1.js"></script>
        <script type="text/javascript">TouchSlide({ slideCell:"#leftTabBox",

                endFun:function(i){ //高度自适应
                    var bd = document.getElementById("tabBox1-bd");
                    bd.parentNode.style.height = bd.children[i].children[0].offsetHeight+"px";
                    if(i>0)bd.parentNode.style.transition="200ms";//添加动画效果
                }
            }); </script>
        <!-- 本例主要代码 End ================================ -->

    </div>
    <!--选项卡 end-->



    <!--——————————————————————————————本喵是分割线————————————————————————————————-->

    <!-- 底部弹出popup start -->
    <div id="half" class='weui-popup__container popup-bottom payType_popup'>
        <div class="weui-popup__overlay"></div>
        <div class="weui-popup__modal fz">
            <div class="toolbar">
                <div class="toolbar-inner">
                    <a href="javascript:;" class="picker-button close-popup">关闭</a>
                    <h1 class="title">确认付款</h1>
                </div>
            </div>

            <div class="modal-content bgc_white">
                <div class="plr40 mor_list fz color_333">
                    <h3 class="ptb20 f32 bold stage">{{$groupTitle}}（第{{$stage}}期）</h3>
                    <ul class="ptb30 f26">
                        <?php
                        echo htmlspecialchars_decode($groupDesc);
                        ?>
                    </ul>
                </div>
                <div class="weui-cell weui-cell">
                    <div class="weui-cell__bd">
                        <h2 class="f28">课程原价</h2>
                    </div>
                    <div class="weui-cell__ft">
                        <span class="price originPrice">{{$currentPrice}}元</span>
                    </div>
                </div>
                <div class="weui-cell weui-cell">
                    <div class="weui-cell__bd">
                        <h2 class="f28">已购课程抵扣</h2>
                    </div>
                    <div class="weui-cell__ft color_red">
                        -<span class="price">{{$youhui}}元</span>
                    </div>
                </div>
                @if($hasCoupon)
                <div class="weui-cell weui-cell">
                    <div class="weui-cell__bd">
                        <h2 class="f28">优惠劵</h2>
                    </div>
                    <div class="weui-cell__ft color_red">
                        -<span class="price">{{$couponPrice}}元</span>
                    </div>
                </div>
                @endif
                <div class="weui-cell weui-cell">
                    <div class="weui-cell__bd">
                        <h2 class="f28">最终合计</h2>
                    </div>
                    <div class="weui-cell__ft">
                        <span class="price buyPrice">{{$currentPrice-$youhui-$couponPrice}}元</span>
                    </div>
                </div>
                <div class="weui-cells weui-cells_radio noafter  dd">
                    <label class="weui-cell weui-check__label" for="x11">
                        <div class="weui-cell__bd f28">
                            <p><i class="ico_wx"></i>微信支付</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" value="WXPAY" class="weui-check" name="radio1" id="x11" checked="checked">
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>
                    <label class="weui-cell weui-check__label disabled_xueyuan" for="x12">
                        <div class="weui-cell__bd f28">
                            <p><i class="ico_balance"></i>余额支付</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" name="radio1" class="weui-check" id="x12">
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>
                </div>
                <div class="container_btn ptb20">
                    <a href="javascript:void(0);" data-type="single" class="roy_btn bgcolor_orange payBtn">立即付款</a>
                </div>
            </div>
        </div>
    </div>
    <!-- 底部弹出popup end -->
    <!-- 底部弹出popup start -->
    <div id="halfs" class='weui-popup__container payType_popup'>
        <div class="weui-popup__overlay"></div>
        <div class="weui-popup__modal fz"><!-- style="height: inherit;" //如果高度不能滑动加上前方这个style-->
            <div class="toolbar">
                <div class="toolbar-inner">
                    <a href="javascript:;" class="picker-button close-popup">关闭</a>
                    <h1 class="title">确认付款</h1>
                </div>
            </div>

            <div class="modal-content bgc_white">
                <div class="plr40 mor_list fz color_333">
                    <h3 class="ptb20 f32 bold stage">{{$groupTitle}}（第{{$stage}}期）</h3>
                    <ul class="ptb30 f26 text-jus">
                        <?php
                        echo htmlspecialchars_decode($teamDesc);
                        ?>
                    </ul>
                </div>
                <div class="weui-cell weui-cell">
                    <div class="weui-cell__bd">
                        <h2 class="f28 bold">{{$courseClassGroup->team_people}}人拼团价</h2>
                    </div>
                    <div class="weui-cell__ft">
                        <span class="price teamOriginPrice">{{$teamPrice}}元</span>
                    </div>
                </div>
                <div class="weui-cell weui-cell">
                    <div class="weui-cell__bd">
                        <h2 class="f28">已购课程抵扣</h2>
                    </div>
                    <div class="weui-cell__ft color_red">
                        -<span class="price">{{$youhui}}元</span>
                    </div>
                </div>
                @if($hasCoupon)
                    <div class="weui-cell weui-cell">
                        <div class="weui-cell__bd">
                            <h2 class="f28">优惠劵</h2>
                        </div>
                        <div class="weui-cell__ft color_red">
                            -<span class="price">{{$couponPrice}}元</span>
                        </div>
                    </div>
                @endif
                <div class="weui-cell weui-cell">
                    <div class="weui-cell__bd">
                        <h2 class="f28">最终合计</h2>
                    </div>
                    <div class="weui-cell__ft">
                        <span class="price teamBuyPrice">{{$teamPrice-$youhui-$couponPrice}}元</span>
                    </div>
                </div>
                <div class="weui-cells weui-cells_radio noafter  dd">
                    <label class="weui-cell weui-check__label" for="x14">
                        <div class="weui-cell__bd f28">
                            <p><i class="ico_wx"></i>微信支付</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" value="WXPAY" class="weui-check" name="radio2" id="x14" checked="checked">
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>
                    <label class="weui-cell weui-check__label disabled_xueyuan" for="x15">
                        <div class="weui-cell__bd f28">
                            <p><i class="ico_balance"></i>余额支付</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" name="radio1" class="weui-check" id="x15">
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>
                    {{--<label class="weui-cell weui-check__label" for="x16">--}}
                        {{--<div class="weui-cell__bd f28">--}}
                            {{--<p><i class="ico_spb"></i>赛普币支付</p>--}}
                        {{--</div>--}}
                        {{--<div class="weui-cell__ft">--}}
                            {{--<input type="radio" name="radio1" class="weui-check" id="x16">--}}
                            {{--<span class="weui-icon-checked"></span>--}}
                        {{--</div>--}}
                    {{--</label>--}}

                </div>

                <div class="container_btn ptb20">
                    <a href="javascript:void(0);" data-type="PT" class="roy_btn bgcolor_orange payBtn">立即付款</a>
                </div>
            </div>
        </div>
    </div>
    <!-- 底部弹出popup end -->
    <!--——————————————————————————————本喵是分割线————————————————————————————————-->
</div><!--导航大盒子id=page 结束-->

<!--右侧悬浮 【微信】 start-->

<div class="relative wx">
    <div class="right-suspension2 text_center pt10">
        <a href="javascript:void (0)">
            <img src="/images/zt/wexin.png" alt="">
            <p class="fz f20 bold">微信咨询</p>
        </a>
    </div>
</div>
<!--右侧悬浮 【微信】 end-->
<!--右侧悬浮 【邀请】start-->
@if($is_buy)
<div class="right-Invitation text_center open-popup" data-target="#Invitation">
    <a href="javascript:void(0)" class="color_fff fz f30 plr25"><img src="../../images/zt/biglesson/icon-m.png" alt="" class="">邀请</a>
</div>
@endif
<!--右侧悬浮 【邀请】end-->


<!--底部弹出popup 邀请内容 start-->
<div>
    <div id="Invitation" class="weui-popup__container popup-bottom">
        <div class="weui-popup__overlay"></div>
        <div class="weui-popup__modal">
            <!--你的内容放在这里... start-->
            <div class="text_center pt98 bgc_white ">
                <h3 class="mb40 color_ff6d1e f40 bold">分享后可赚取佣金¥50</h3>
                <p class="f26 color_gray666 fz">朋友通过你分享的页面成功购买后，</p>
                <p class="f26 color_gray666 fz">你可以获得相应的佣金。</p>
                <p class="f26 color_gray666 fz">佣金可在【我的分销员中心】查看</p>

                <div class="InvBtn plr30 clearfix fz pb30 pt40 mt30">
                    <a href="javascript:void (0)" class="fl bg_ff9a03 f24 border-radius-img wxfx"><img src="../../images/zt/biglesson/icon-w.png" alt="">微信分享</a>
                    <a href="/dist/sale/index.html" class="fr bg_ff9a03 f24 border-radius-img">我的分销中心</a>
                </div>
            </div>
            <!--你的内容放在这里... end-->
        </div>
    </div>
</div>
<!--底部弹出popup 邀请内容 end-->


<br><br><br>



<script src="/js/jquery-1.11.2.min.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->

<script src="/lib/swiper/swiper.min.js"></script>
<script type="text/javascript">
    //播放视频
    $(function (){
        $('.con .video .box2').click(function(){
            $(this).hide();
            $(this).next().trigger('play');
        })
    });
    function isBuyShow(id){
        var length = $('.is_buy').length;
        if(length == 2){
            $('.is_buy').each(function(){
                if($(this).attr('data-id') == id){
                    $(this).removeClass('none');
                }else{
                    $(this).addClass('none');
                }
            });
        }
    }
    isBuyShow(1);
</script>
<script>
    //切换抬
    function menuFixed(id){
        var obj = document.getElementById(id);
        var _getHeight = obj.offsetTop;

        window.onscroll = function(){
            changePos(id,_getHeight);
        }
    }
    function changePos(id,height){
        var obj = document.getElementById(id);
        var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        if(scrollTop < height){
            obj.style.position = 'relative';
        }else{
            obj.style.position = 'fixed';
        }
    }
</script>
<script type="text/javascript">
    window.onload = function(){
        menuFixed('nav_keleyi_com');
    }
</script>
<script type="text/javascript">
    //将裂变者id写入本地  用于存储上下级关系
    var fission_id = "{{$fission_id}}";
    if(fission_id>0){
        localStorage.setItem("fission_id", fission_id);
    }

    //跳转登陆函数
    var gp_id = '{{$courseClassGroup->id}}';
    var href_url = "/train/study.html?id="+gp_id;
    var userlogin = function(){
        var url = href_url;
        localStorage.setItem("redirect", url);
        layer.msg('请先注册');
        setTimeout(function(){
            window.location.href = "/register";
        }, 500)
    }

    var stage = '{{$stage}}';
    var groupTitle = '{{$groupTitle}}';
    //播放视频
    $(function (){
        $('.con .video .box2').click(function(){
            $(this).hide();
            $(this).next().trigger('play');
        })
    })

    //弹窗
    $('.con_list li dl').click(function(){
        n=$(this).parents('li').index();
        lesson(n)
    });
    function lesson(n){
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'bm_success_layer_wrap2', //样式类名
            id: 'bm_success_layer2', //设定一个id，防止重复弹出
            closeBtn: 1, //不显示关闭按钮
            anim: 2,
            shade:0,
            shadeClose: true, //开启遮罩关闭
            area: ['80%', '90%'],
            content:$('.aa'),
            btn:false,
            success: function(layero, index){
                $('#page').after('<div class="my-layui-layer-shade"></div>');
                var swiper = new Swiper('.swiper-container', {
                    pagination: '.swiper-pagination',
                    nextButton: '.swiper-button-next',
                    prevButton: '.swiper-button-prev',
                    initialSlide :n,//默认第二个
                    paginationClickable: true
                });
            },
            cancel: function(index, layero){
                $('.my-layui-layer-shade').remove()
                layer.close(index)
                return false;
            }
        });
    }

    var c_c_id    = '{{$courseClassGroup->id}}';   //课程组id
    var token     = '{{csrf_token()}}';
    var is_weixin = "{{$is_weixin}}";  //是否为微信浏览器
    var origin_price = '{{$currentPrice}}';
    var team_origin_price = '{{$teamPrice}}';
    var final_price = "{{$currentPrice-$youhui-$couponPrice}}";
    var final_team_price = "{{$teamPrice-$youhui-$couponPrice}}";
    var user_id     = "{{$user_id}}";      //用户id
    var yh = '{{$youhui==0?$youhui:0}}';
    var couponPrice = '{{$couponPrice}}';
    var spb = '{{$spb}}';
    var final_coin = 0;
    var buy_type = '';
    //免费报名成功或者购买成功后跳转
    function href_go(){
        if(buy_type == 'PT'){
            location.href = "/train/success/{{$courseClassGroup->id}}.html";
        }else{
            location.href = "/train/success?id={{$courseClassGroup->id}}";
        }

    }

    //调用微信JS api 支付
    function jsApiCall()
    {

        var _token = '{{csrf_token()}}';
        var buy_price = 0;
        if(buy_type == 'PT'){
            buy_price = final_team_price;
        }else{
            buy_price = final_price;
        }
        var data = {class_id:c_c_id,_token:_token, final_price:buy_price,stage:stage,dis_id:fission_id,type:buy_type};

        $.ajax({
            url:'/train/buy',
            data:data,
            type:'POST',
            dateType:'json',
            success:function(res){

                if(res.code != 0){
                    layer.msg(res.message);

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

    //立即付款弹出框
    $('.payBtn').click(function (){
        var type = $(this).attr('data-type');
        var payfrom = '';
        if(type == "PT"){
            payfrom = $("input[name='radio2']:checked").val();
        }else{
            payfrom = $("input[name='radio1']:checked").val();
        }
        buy_type = type;
        if(payfrom=="WXPAY"){
            if(is_weixin==1){

                jsApiCall();
            }else{
                var buy_price = 0;
                if(buy_type == 'PT'){
                    buy_price = final_team_price;
                }else{
                    buy_price = final_price;
                }
//                console.log({class_group_id:c_c_id,_token:token, final_price:buy_price,stage:stage,dis_id:fission_id,type:type});
//                return ;
                $.ajax({
                    type:"POST",
                    url:"/train/payh",
                    data:{class_group_id:c_c_id,_token:token, final_price:buy_price,stage:stage,dis_id:fission_id,type:type},
                    dataType:"json",
                    success:function(result){
                        if(result.code==1){
                            console.log(result.objectxml.mweb_url);
                            //follow_us();
                            window.location.href=result.objectxml.mweb_url;   //h5呼叫微信支付
                        }else{
                            layer.msg(result.msg);
                        }
                    }
                });
            }
        }else if(payfrom == "SPB"){

            $.closePopup()
            $.confirm({
                title: '提示',
                text: '立即购买学习该课程，确认购买吗？',
                onOK: function () {
                    $.ajax({
                        type:"get",
                        url:"/train/paySpb",
                        data:{class_group_id:c_c_id,user_id:user_id, final_price:final_price,stage:stage,dis_id:fission_id},
                        dataType:"json",
                        success:function(data){
                            console.log(data);
                            if(data.code == 1){
                                layer.msg(data.msg);
                                setTimeout(function(){
                                    href_go();     //支付成功跳转
                                },1500)  //延迟1.5秒刷新页面
                            }else{
                                layer.msg(data.msg);
                            }
                        }


                    })
                },
                onCancel: function (){
                }
            });
        }
    })

    /*早鸟价*/

    function zao_show1(obj){
        if($('.is_buy').attr('data-id') != undefined){
            isBuyShow(1);
            return;
        }
        if($('.extro_num').attr('data-id') != undefined){
            var length = $(".extro_num").length;
            console.log(length);
            if(length == 2){
                $('.extro_num').each(function(){
                    console.log($(this).attr('data-id'));
                    if($(this).attr('data-id') == 1){
                        $(this).removeClass('none');
                    }else{
                        $(this).addClass('none');
                    }
                });
            }else{
                if($('.extro_num').attr('data-id') == 2){
                    $('.extro_num').addClass('none');
                    document.getElementById("zao5").classList.remove("none");
                    document.getElementById("zao6").classList.remove("none");
                }else{
                    $('.extro_num').removeClass('none');
                    document.getElementById("zao3").classList.add("none");
                    document.getElementById("zao4").classList.add("none");
                }
            }

        }else{
            document.getElementById("zao3").classList.add("none");
            document.getElementById("zao4").classList.add("none");
            document.getElementById("zao5").classList.remove("none");
            document.getElementById("zao6").classList.remove("none");
        }

        document.querySelectorAll(".button")[0].classList.add("bg_ff9a03");
        document.querySelectorAll(".button")[1].classList.remove("bg_ff9a03");

        document.getElementById("zao1").classList.remove("none");
        document.getElementById("zao2").classList.add("none");




        var price = $(obj).attr('data-price');
        var team_price = $(obj).attr('data-itemprice');

        final_price = price - yh- couponPrice;
        final_team_price = team_price -yh - couponPrice;
        origin_price = price;
        team_origin_price = team_price;
        stage = $(obj).attr('data-id');
        final_coin = final_price * 100;
        var coin_text = final_coin+'赛普币(已有'+spb+'赛普币)';
        var groupName = groupTitle+'（第'+stage+'期）';
        $('.stage').text(groupName);
        $('.coin_price').text(coin_text);
        $('.buyPrice').text(final_price+'元');
        $('.originPrice').text(origin_price+'元');
        $('.teamOriginPrice').text(team_origin_price+'元');
        $('.teamBuyPrice').text(final_team_price+'元');
    }
    function zao_show2(obj){
        if($('.is_buy').attr('data-id') != undefined){
            isBuyShow(1);
            return;
        }
        if($('.extro_num').attr('data-id') != undefined){
            var length = $(".extro_num").length;
            if(length == 2){
                $('.extro_num').each(function(){
                    if($(this).attr('data-id') == 1){
                        $(this).removeClass('none');
                    }else{
                        $(this).addClass('none');
                    }
                });
            }else {
                if ($('.extro_num').attr('data-id') == 1) {
                    $('.extro_num').addClass('none');
                    document.getElementById("zao3").classList.remove("none");
                    document.getElementById("zao4").classList.remove("none");
                } else {
                    $('.extro_num').removeClass('none');
                    document.getElementById("zao5").classList.add("none");
                    document.getElementById("zao6").classList.add("none");
                }
            }
        }else{
            document.getElementById("zao3").classList.remove("none");
            document.getElementById("zao4").classList.remove("none");
            document.getElementById("zao5").classList.add("none");
            document.getElementById("zao6").classList.add("none");
        }
        document.querySelectorAll(".button")[1].classList.add("bg_ff9a03");
        document.querySelectorAll(".button")[0].classList.remove("bg_ff9a03");

        document.getElementById("zao1").classList.add("none");
        document.getElementById("zao2").classList.remove("none");


        var price = $(obj).attr('data-price');
        var team_price = $(obj).attr('data-itemprice');

        final_price = price - yh- couponPrice;
        final_team_price = team_price -yh - couponPrice;
        origin_price = price;
        team_origin_price = team_price;
        stage = $(obj).attr('data-id');
        final_coin = final_price * 100;
        var coin_text = final_coin+'赛普币(已有'+spb+'赛普币)';
        var groupName = groupTitle+'（第'+stage+'期）';
        $('.stage').text(groupName);
        $('.coin_price').text(coin_text);
        $('.buyPrice').text(final_price+'元');
        $('.originPrice').text(origin_price+'元');
        $('.teamOriginPrice').text(team_origin_price+'元');
        $('.teamBuyPrice').text(final_team_price+'元');
    }


    //右侧悬浮点击弹窗
    $('.wx').click(function(){
        var img = '';
        var notice = '';
        if(c_c_id == 5){
            img = '/images/zt/teenager/gaojie.png';
            notice = '青少儿';
        }else{

            img = '/images/zt/group-er1.png';
            notice = '产后咨询';
        }
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'bm_success_layer_wrap', //样式类名
            id: 'bm_success_layer', //设定一个id，防止重复弹出
            closeBtn: 0, //不显示关闭按钮
            anim: 2,
            shadeClose: true, //开启遮罩关闭
            area: ['80%', '60%'],
            content:'<div class="bm_success_layer"><img src="'+img+'" class="bm_success pt30" alt="" /><div class="text_center fz"><p class="f26 bold pt20">长按识别二维码</p><p class="f26 bold pb20"> 加课程顾问微信</p><p class="f26 bold">备注：'+notice+'</p></div></div>',
            btn:false
        });
    });
    //分享弹窗
    $('.wxfx').click(function(){
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
    var g_id = '{{$courseClassGroup->id}}';
    var desc = '';
    var share_img = '';
    if(g_id == 4){
        desc = '我已经报名减脂教练核心能力训练营，你也来学习吧~';
        share_img = "http://m.saipubbs.com/images/zt/xunlianying.jpeg";
    }else if(g_id == 5){
        desc = '我正在学习幼儿体侧师认证课程，你也来学习吧';
        share_img = "http://image.saipubbs.com/upload/image/20191213/1576204294.9201457246.png";
    }else{
        desc = '我正在学习产后实战课程，你也来学习吧~';
        share_img = "http://m.saipubbs.com/images/zt/yunchan01.jpg";
    }
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: '{{$courseClassGroup->title}}', // 分享标题
            desc: desc, // 分享描述
            link: "http://m.saipubbs.com/train/study.html?id={{$courseClassGroup->id}}&fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img, // 分享图标

        }, function(res) {
            //这里是回调函数

        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '{{$courseClassGroup->title}}', // 分享标题
            link: "http://m.saipubbs.com/train/study.html?id={{$courseClassGroup->id}}&fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img, // 分享图标

        }, function(res) {
            //这里是回调函数

        });
    });
</script>
</body>
</html>
