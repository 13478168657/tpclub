<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普健身教练培训基地</title>
    <meta name="author" content="" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <script src="/js/rem.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/lib/swiper/swiper.min.css">
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.css" rel="stylesheet" type="text/css" />
    <link href="/css/reset_phone.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" type="text/css" />
    <link href="/css/toufang.css?t=1.5464654" rel="stylesheet">
    @include('layouts.baidutongji')
</head>

<body ontouchstart onload = "countTime()">
<!-- 社区拼团主页 start -->
<div class="page_toufang_index w750">
    <!-- banner start -->
    <div class="banner">
        <img src="{{env("IMG_URL")}}{{$tfCourseClass->cover_url}}" class="img100" alt="" />
    </div>
    <!-- banner end -->
    <!-- 倒计时 start -->
    <div class="plr30 djs_wrap clearfix bold">
        <h3 class="f36  text-overflow">{{$tfCourseClass->title}}</h3>
        <div class="djs">
            <h4 class="f20">活动剩余时间</h4>
            <div class="countTime">
                <div id="_d"><span>0</span><span>0</span><em>天</em></div>
                <div id="_h"><span>0</span><span>0</span><em>:</em></div>
                <div id="_m"><span>0</span><span>0</span><em>:</em></div>
                <div id="_s"><span>0</span><span>0</span><em></em></div>
            </div>
        </div>
    </div>
    <!-- 倒计时 end -->
    <!-- 信息 start -->
    <div class="plr30 bg_fff info_wrap pt30 pb20 bold">
        <div class="clearfix">
            <div class="fl_sp">
                @if($tfCourseClass->id==2)
                <label class="fl_sp">预定金</label>
                @else
                <label class="fl_sp">{{$tfCourseClass->team_people}}人拼团价</label>
                @endif
                <span class="price fl_sp f54">¥{{$tfCourseClass->team_price}}</span>
                @if($tfCourseClass->price_info)
                <span class="oldPrice fl_sp f36"></span>
                @else
                <span class="oldPrice fl_sp f36">¥{{$tfCourseClass->price }}</span>
                @endif
            </div>
            <div class="fr_sp f36">剩余{{$limitNum-$buyNum}}名额</div>
        </div>
        <h2 class="mt30 f36">{{$tfCourseClass->description}}</h2>
    </div>
    <!-- 信息 end -->
    <!-- 提示 start -->
    <div class="plr30 bg_fff tip_wrap mt20">
        <p class="pt20 pb20 bold">12人在拼团，可直接参与。</p>
    </div>
    <!-- 提示 end -->
    <!-- 拼团滚动信息 start -->
    <div class="pintuanScroll">
        <!-- Swiper -->
        <div class="swiper-container swiper-container-pintuan">
            <div class="swiper-wrapper">
                @foreach($tfOrders as $tfOrder)
                <div class="swiper-slide">
                    <div class="my-flex-center">
                        <?php
                            $user = $tfOrder->user;
                            if($user){
                                $name = $user->name?$user->name:$user->nickname;
                                if($user->avatar){
                                    if(strpos($user->avatar,'http') !== false){
                                      $img = $user->avatar;
                                    }else{
                                        $img = env('IMG_URL').$user->avatar;
                                    }
                                }else{
                                    $img = '/images/my/nophoto.jpg';
                                }
                            }else{
                                $name = "小伙伴";
                            }
                        ?>
                        <img src="{{isset($img) ? $img : ''}}" class="radius50p" alt="" />
                        <span class="">
                            <em>{{$name}}</em>刚刚拼团成功了
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- 拼团滚动信息 end -->
</div>
<!-- 社区拼团主页 end -->

<!-- 插入长图 start -->
<div class="longPage">
    <img src='{{env("IMG_URL")}}{{$tfCourseClass->desc_url}}' class="img100" />
</div>
<!-- 插入长图 end -->

<!-- 底部固定条 start -->
<div class="fixed_bar_bot">
    <div class="w750 btns plr20 my-flex jc-between bold">
        <!-- <div class="zixunBtn whiteBtn ">
            <a href="#">咨询</a>
        </div> -->
        <div class="danduPrice whiteBtn ">
            <strong class="f44">¥{{$tfCourseClass->price}}</strong>
            <span class="">单独购买</span>
        </div>
        <div class="pintuanPrice jianbian_button_yellow">
            @if($tfCourseClass->id==2)
            <!-- 500元预定金 -->
            <a href="/dist/buy/yd{{$tfCourseClass->id}}.html">  
            @else
            <a href="/dist/buy/pt{{$tfCourseClass->id}}.html">
            @endif  
                <strong class="f44">¥{{$tfCourseClass->team_price}}</strong>
                <span class="">我要开团</span>
            </a>
        </div>
    </div>
</div>
<!-- 底部固定条 end -->
<br><br><br /><br />

<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/swiper/swiper.min.js"> </script>
<script src="/js/js.js"></script>
<script type="text/javascript">
    $(function () {
        //拼团滚动信息
        var swiper = new Swiper('.swiper-container-pintuan', {
            //pagination: '.swiper-pagination',
            paginationClickable: true,
            direction: 'vertical',
            //spaceBetween: 30,
            centeredSlides: true,
            autoplay: 2500,
            autoplayDisableOnInteraction: false
        });
    })
    function countTime() {
        //获取当前时间
        var date = new Date();
        var now = date.getTime();
        //设置截止时间
//        var datestr = "2020/3/6 00:00:00";
        var datestr = "{{$tfCourseClass->end_time}}";
//        alert(datestr);
        var endDate = new Date(datestr);
        var end = endDate.getTime();

        //时间差
        var leftTime = end - now;
        //定义变量 d,h,m,s保存倒计时的时间
        var d, h, m, s;
        if (leftTime >= 0) {
            d = Math.floor(leftTime / 1000 / 60 / 60 / 24);
            h = Math.floor(leftTime / 1000 / 60 / 60 % 24);
            m = Math.floor(leftTime / 1000 / 60 % 60);
            s = Math.floor(leftTime / 1000 % 60);

            //将0-9的数字前面加上0，例1变为01
            d = checkTime(d);
            h = checkTime(h);
            m = checkTime(m);
            s = checkTime(s);

            function checkTime(i) {
                if (i < 10) {
                    i = "0" + i;
                }
                return i;
            }
            //将倒计时赋值到div中
            console.log(d)
            console.log(d.toString().length)
            var html="";
            for( var j = 0; j < d.toString().length; j++){
                html +="<span>" + d.toString()[j] + "</span>"
            }
            console.log(html)
            document.getElementById("_d").innerHTML = html + "<em>天</em>";
            document.getElementById("_h").innerHTML ="<span>" + h.toString()[0] + "</span><span>" + h.toString()[1] + "</span><em>" +  ":" + "</em>";
            document.getElementById("_m").innerHTML ="<span>" + m.toString()[0] + "</span><span>" + m.toString()[1] + "</span><em>" +  ":" + "</em>";;
            document.getElementById("_s").innerHTML ="<span>" + s.toString()[0] + "</span><span>" + s.toString()[1] + "</span><em>" +  "" + "</em>";;
            //递归每秒调用countTime方法，显示动态时间效果
            setTimeout(countTime, 1000);
        }else{
            alert('时间到');
            //return false;
        }
    }
</script>

</body>

</html>