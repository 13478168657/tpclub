<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-打卡分享海报</title>
    <meta name="author" content="啾啾" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />

    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" />
    <script src="/js/jquery-1.11.2.min.js"></script>
    <script src="/js/jquery.SuperSlide.2.1.1.js" type="text/javascript"></script>
    <!--本css-->
    <link rel="stylesheet" href="/css/fenxiaoliucheng_clock.css?t={{time()}}" >


    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
</head>
<body>

<!---导航右侧带导航弹出---->

<div><!--导航大盒子id=page 开始  【结束在最底部】-->

    <!--====================================本喵是分割线  喵喵~========================================================-->
    <div>
        <!--banner start-->
        <div>
            <img src="/images/clock/hb_new_ban.jpg" alt="">
        </div>
        <!--banner end-->
        <!--课程内容 start-->
        <div class="hb_content plr50">
            <div class="top-con bgcolor_fff border-radius-img relative overflow-none">

                {{--<img src="/images/clock/haibao-zhong.png" alt="" class="poimg">--}}
                <div class="user-img">
                    <img src="{{$avatar}}" alt="" class="block">
                </div>
                <div class="pt70 plr45 fz pb20 text_center">
                    <p class="f38 bold pb30">{{$name}}</p>
                    <p class="f28 ">在<span class="color_eb712f">#{{$disClass->title}}#</span>私教养成营</p>
                    <p class="pt40 f34 color_eb712f bold">《{{$disClass->title}}》</p>
                    <p class="f34 bold">已经学习了<span class="color_eb712f">{{$total}}节课</span></p>
                </div>
                <img src="/images/clock/haibao-line-h.jpg" alt="">
                <div class="pt40 pb60">
                    <img src="/images/clock/haibao-tit.png" alt="" class="titimg">
                    <div class="hb-list pt40 plr45 fz">
                        <ul>
                            @foreach($description as $desc)
                            <li class="mb30">
                                <dl class="clearfix">
                                    <dt class="fl"><img src="/images/clock/xue-h.png" alt=""></dt>
                                    <dd class="fr f26 color_333 bold">{{$desc}}</dd>
                                </dl>
                            </li>
                            @endforeach
                            {{--<li class="mb30">--}}
                                {{--<dl class="clearfix">--}}
                                    {{--<dt class="fl"><img src="/images/clock/xue-h.png" alt=""></dt>--}}
                                    {{--<dd class="fr f26 color_333 bold">《1个月减脂营》累计学习：6次</dd>--}}
                                {{--</dl>--}}
                            {{--</li>--}}
                            {{--<li class="mb30">--}}
                                {{--<dl class="clearfix">--}}
                                    {{--<dt class="fl"><img src="/images/clock/xue-h.png" alt=""></dt>--}}
                                    {{--<dd class="fr f26 color_333 bold">《1个月减脂营》累计学习：6次</dd>--}}
                                {{--</dl>--}}
                            {{--</li>--}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="bg-hb-bottom plr45 pb60">
                <ul class="clearfix color_fff plr20">
                    <li class="fl fz">
                        <p class="f30 pb30 pt10">加入<span  class="color_eb712f">《私教养成营》</span></p>
                        <p class="f24 color_gray999">12W人在赛普健身教练养成营</p>
                        <p class="f24 color_gray999">让健身更科学</p>
                    </li>
                    <li class="fr er">
                        <img src="http://qr.topscan.com/api.php?text=http://m.saipubbs.com/dist/buy/{{$disClass->id}}.html?dis={{$dist_id}}" alt="">
                        <p class="border-radius50 mt16 text_center">扫码体验</p>
                    </li>
                </ul>
            </div>
        </div>
        <!--课程内容 end-->
    </div>


    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--====================================本喵是分割线  喵喵~========================================================-->
</div><!--导航大盒子id=page 结束-->

<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script src="/lib/layer/layer.js"></script>


<script>
    $('body').addClass('bgcolor_000');
</script>
</body>
</html>
