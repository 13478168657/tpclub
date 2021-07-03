@extends('layouts.header')
@section('title')
    <title>赛普币规则-赛普健身社区</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
 @endsection

@section('cssjs')  
    <link rel="stylesheet" href="../css/xueyuan.css">
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth/18.75 + "px";
        })()
    </script>
@endsection

@section('content')
</head>
<body style="background: #fff;">


<!-- 头部条 start -->
<!-- <div class="fixed_bar_top">
    <header class="header_bar bgc_grey relative">
        <a href="javascript:history.go(-1);" class="btn_back"><i class="icon iconfont icon-fenxiang2"></i></a>
        <h1 class="cat">赛普币规则</h1> -->
        <!-- <a href="javascript:void(0)" class="btn_link red" id="edit">编辑</a> -->
   <!--  </header>
</div> -->
<!-- 头部条 end -->

<div class="about_con">
    <!--赛普币规则 start-->
    <article class="weui-article color_gray666 xy-about plr30">
        <section class="pt40">
            <h2 class="title lt color_333 f30">1.什么是余额？</h2>
            <section class="fz about_sai">
                <p class="f24 text-jus">
                    余额中的金额是您获得的课程收益。每笔课程收益会根据结算规则计入余额，主动提现即可到账。
                </p>
            </section>

            <h2 class="title lt color_333 f30">2.如何获取余额？</h2>
            <section class="fz about_sai">
                <p class="f24 text-jus">
                    开设课程。
                </p>
            </section>
            <h2 class="title lt color_333 f30">3.如何使用余额？</h2>
            <section class="fz about_sai">
                <p class="f24 text-jus">
                    购买课程或者提现。
                </p>
            </section>
            <h2 class="title lt color_333 f30">4.关于提现</h2>
            <section class="fz about_sai">
                <p class="f24 text-jus">
                    在您发起提现后，我们的客服人员会在7个工作日内与您联系，为您完成转账操作。每笔提现金额至少100元。
                </p>
            </section>
        </section>
    </article>
<!--赛普币规则 end-->
</div>


<script src="../lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="../lib/jqweui/js/fastclick.js"></script>
<script>
    $(function() {
        FastClick.attach(document.body);
    });
</script>

<script src="../lib/jqweui/js/jquery-weui.js"></script>
@endsection