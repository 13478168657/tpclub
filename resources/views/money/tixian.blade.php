@extends('layouts.header')
@section('title')
    <title>申请提现-赛普健身社区</title>
 @endsection

@section('cssjs') 
    <link rel="stylesheet" href="/css/xueyuan.css">
    <style type="text/css">
        label.error{color:red;font-size:10px;}
    </style>
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
        <a href="/user/index" class="btn_back"><i class="icon iconfont icon-fenxiang2"></i></a>
        <h1 class="cat">申请提现</h1> -->
        <!-- <a href="javascript:void(0)" class="btn_link red" id="edit">编辑</a> -->
   <!--  </header>
</div> -->
<!-- 头部条 end -->
<form id ="formData" method="get" action=""> 
 {{csrf_field()}}
<div class="apply">
    <div class="apply_cash">
        <div class="weui-cell__bd mb30">
            <div class="f28 color_4a pb15">提现金额</div>
            <div class="f24 color_gray999">余额超过100元后才可以提现哦～</div>
        </div>
       <div class="the ptb34">
            <input type="text" name="money" placeholder="¥200.00" class="input lt color_000 f44" />
            <input type="hidden" name="user_id" value="{{$userid}}">
       </div>
       <div class="weui-cell__bd pt30 mb30 pb30">
            <div class="f24 color_gray999">当前可提现:{{$spb[0]->total}}元</div>
        </div>
    </div>


    <!--大按钮-->
    <div class="plr30 Btn nobefore noafter" >
        <button type="submit" class="weui-btn nobefore noafter bgcolor_orange color_333 f34 fz">立即申请提现</button>
    </div>

</div>
</form>

<script src="/lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>

<script>
    $(function() {
        FastClick.attach(document.body);
    });
</script>

<script src="/lib/jqweui/js/jquery-weui.js"></script>
<script src="/lib/jquery.validate.js" type="text/javascript"></script>
<script src="/lib/layer/layer.js" type="text/javascript"></script>
<script>
        $("#formData").validate({
           rules:{
                money:{
                    required:true,
                    min : 100,
                    max : {{$spb[0]->total}}
                }
           },
           messages:{
                money:{
                    required:"请填写提现金额",
                    min:"金额数字不能小于100",
                    max:"已超过可提现金额",
                }
           },
           errorPlacement:function(error,element) {
                error.appendTo(element.parent("div").next());

           },
           submitHandler: function(form){      
                $(form).ajaxSubmit();     
            }  
        });
        @if(!empty(session('tixian_success')))
             layer.msg("{{session('tixian_success')}}");
                setTimeout(function(){
                        window.location.href="/user/money";
                    },1500)  //延迟1.5秒刷新页面
        @endif 
        @if(!empty(session('tixian_error')))
           layer.msg("{{session('tixian_error')}}");
        @endif 

</script>
@endsection