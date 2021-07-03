@extends('layouts.header')
@section('title')
    <title>支付记录-赛普健身社区</title>
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
<!-- div class="fixed_bar_top">
    <header class="header_bar bgc_grey relative">
        <a href="javascript:history.go(-1);" class="btn_back"><i class="icon iconfont icon-fenxiang2"></i></a>
        <h1 class="cat">支付记录</h1> -->
        <!-- <a href="javascript:void(0)" class="btn_link red" id="edit">编辑</a> -->
    <!-- </header>
</div> -->
<!-- 头部条 end -->
<!-- 支付记录 satrt -->
<ul class="spb_details mlr30 fz">
    <div id="list">
     @if(isset($data[0]))
    @foreach($data as $v)
        <li>
            <div class="weui-cells nobefore noafter mt0">
                <a class="weui-cell weui-cell_access ptb30 xueyuan_install nobefore noafter" href="javascript:;">
                    <div class="weui-cell__bd f24 color_gray666">
                        <p class="color_4a f26 pb15">
                            @if($v->type == "BUY") 消费 @elseif($v->type == "APPLY")  提现 @else 被购买  @endif
                        </p>
                        <span class="color_gray999 f20">{{$v->created_at}}</span>
                    </div>
                    <div class="lt">
                        <p class="f26 color_red">
                              @if($v->type == "BUY") -{{$v->money}}元 @elseif($v->type == "APPLY") -{{$v->money}}元 @else +{{$v->money}}元 @endif
                        </p>
                    </div> 
                </a>
            </div> 
        </li>
    @endforeach
    </div>  
</ul>
<!-- 支付记录 end -->

<!--加载更多-->
<!--<div class="weui-loadmore more text_center fz ptb30">
    <i class="weui-loading"></i>
    <span class="weui-loadmore__tips">正在加载</span>
</div>-->
        <div class="weui-loadmore more text_center fz ptb30 remove_attr " id="study_more">
            <!-- <i class="weui-loading"></i> -->
            <span class="weui-loadmore__tips" id ="add_more"  data-is_ture='1'>加载更多</span>
        </div>


    @else
        <div class="con">
            <div class="empty"><img src="/images/empty.png" alt=""></div>
            <h2 class="fz color_gray666  text_center mt30 pt20">暂无记录</h2>
        </div>
    @endif
<script src="../lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="../lib/jqweui/js/fastclick.js"></script>
<script>
    $(function() {
        FastClick.attach(document.body);
    });
</script>

<script src="../lib/jqweui/js/jquery-weui.js"></script>
<script>
var i=2;
    $("#study_more").click(function(){
        var number = $("#add_more").attr("data-is_ture");
        if(number == 1){
            $.ajax({
                type:"get",
                url:"/money/record",
                data:{page:i},
                dataType:"json",
                success:function(data){
                    console.log(data);
                    if(!jQuery.isEmptyObject(data)){
                        $.each(data,function(index,json){
                            var str = "";
                            var str = str + '<li><div class="weui-cells nobefore noafter mt0"><a class="weui-cell weui-cell_access ptb30 xueyuan_install nobefore noafter" href="javascript:;"><div class="weui-cell__bd f24 color_gray666"><p class="color_4a f26 pb15">';
                            if(json['type'] == "BUY"){
                                var str = str + '购买';
                            }else if(json['type'] == "APPLY"){
                                var str = str + '提现';
                            }else{
                                var str = str + '被购买';
                            }
                            var str = str + '</p><span class="color_gray999 f20">' + json['created_at']+ '</span></div><div class="lt"><p class="f26 color_red">';
                            if(json['type'] == "BUY"){
                                var str = str + '-'+json['money'] + '元';
                            }else if(json['type'] == "APPLY"){
                                var str = str + '-'+json['money'] + '元';
                            }else{
                                var str = str + '+'+json['money'] + '元';
                            }
                            var str = str + '</p></div></a></div></li>';
                            $("#list").append(str);
                        })
                    }else{
                        $("#add_more").attr("data-is_ture",0);
                        $("#add_more").text("没有更多记录了"); 
                        layer.msg('没有更多记录啦');
                    }
                     i++;
                    }
                
            })

        }else{
            layer.msg('没有更多课程啦');
        }
    })
</script>
@endsection