@extends('layouts.header')
@section('title')
    <title>我的钱包-赛普健身社区</title>
 @endsection

@section('cssjs') 
    <link rel="stylesheet" href="/css/xueyuan.css">
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
<div class="fixed_bar_top">
    <!-- <header class="header_bar bgc_grey relative">
        <a href="javascript:history.go(-1);" class="btn_back"><i class="icon iconfont icon-fenxiang2"></i></a>
        <h1 class="cat">我的钱包</h1> -->
        <!-- <a href="javascript:void(0)" class="btn_link red" id="edit">编辑</a> -->
    <!-- </header> -->
</div>
<!-- 头部条 end -->
<!-- 现金金额 satrt -->
<div class="mlr30 pt30 xueyuan_spb">
    <div class="weui-cells  nobefore noafter mt0 pb30">
        <a class="weui-cell weui-cell_access xueyuan_cash nobefore noafter" @if(isset($spb[0]->total)) href="/user/tixian" @endif>
            <div class="weui-cell__bd f34 color_000 lt">
                <p>现金金额 @if(isset($spb[0]->total)) ¥{{$spb[0]->total}} @else ¥0 @endif</p>
            </div>
            @if(isset($spb[0]->total))
                <div class="f24 color_000 cash_btn fz">
                    提现
                </div>
            @endif
        </a>
     </div>
</div>
<!-- 现金金额 end -->

<!-- 赛普币明细 satrt -->
<ul class="spb_details mlr30 fz">
    <li class="color_gray9b f24 pb22">
        <div class="weui-cells nobefore noafter mt0">
            <a class="weui-cell weui-cell_access padding0 nobefore noafter fz" href="/user/help">
                <div class="weui-cell__bd f24 color_gray9b">
                    <p>（提现金额需满100元）</p>
                </div>
                <div class="right f24 color_gray666">
                    查看帮助
                </div>
            </a>
        </div>
    </li>
    <li>
        <div class="weui-cells nobefore noafter mt0 my_income">
            <a class="weui-cell weui-cell_access ptb44 xueyuan_install nobefore noafter" href="/user/myincome">
                <div class="weui-cell__hd f26"><img src="../images/icon_income.png" alt=""></div>
                <div class="weui-cell__bd fz">
                    <p class="f28 color_4a">我的收入</p>
                </div>
                <div class="f24 color_gray666 spb_arrow weui-cell__ft"></div>
            </a>
        </div> 
    </li>
    <li> 
        <div class="weui-cells nobefore noafter mt0 my_income">
            <a class="weui-cell weui-cell_access ptb44 xueyuan_install nobefore noafter" href="/user/myrecord">
                <div class="weui-cell__hd f26"><img src="../images/icon_zhifu.png" alt=""></div>
                <div class="weui-cell__bd fz">
                    <p class="f28 color_4a">支付记录</p>
                </div>
                <div class="f24 color_gray666 spb_arrow weui-cell__ft"></div>
            </a>
        </div> 
    </li>
</ul>
<!-- 赛普币明细 end -->


<script src="../lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="../lib/jqweui/js/fastclick.js"></script>
<script>
    $(function() {
        FastClick.attach(document.body);
    });
</script>

<script src="../lib/jqweui/js/jquery-weui.js"></script>

@endsection