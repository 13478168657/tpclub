@extends('layouts.header')
@section('title')
    <title>我的赛普币{{env('WEB_TITLE')}}</title>
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
<body style="background: #fff;">
<!-- 头部条 start -->
<div class="fixed_bar_top">
   <!--  <header class="header_bar bgc_grey relative">
        <a href="javascript:history.go(-1);" class="btn_back"><i class="icon iconfont icon-fenxiang2"></i></a>
        <h1 class="cat">我的赛普币</h1> -->
        <!-- <a href="javascript:void(0)" class="btn_link red" id="edit">编辑</a> -->
    <!-- </header> -->
</div>
<!-- 头部条 end -->
<!-- 赛普币 satrt -->
<div class="mlr30 pt30 xueyuan_spb">
    <div class="weui-cells  nobefore noafter mt0 pb30">
        <a class="weui-cell weui-cell_access xueyuan_money nobefore noafter" href="/spb/rules">
            <div class="weui-cell__hd f26"><img src="../images/my/ico_saipubi.png" alt=""></div>
            <div class="weui-cell__bd f34 color_000 lt">
                <p>赛普币{{$spb[0]->spb}}</p>
            </div>
            <div class="right f24 color_gray666">
                赛普币规则
            </div>
        </a>
     </div>
</div>
<!-- 赛普币 end -->

<!-- 赛普币明细 satrt -->
<ul class="spb_details mlr30 fz">
    <li class="color_gray9b f24 pb22">赛普币明细</li>
    <div id="list">
@if(isset($list[0]))
    @foreach($list as $v)
        <li>
            <div class="weui-cells nobefore noafter mt0">
                <a class="weui-cell weui-cell_access ptb44 xueyuan_install nobefore noafter" href="javascript:;">
                    <div class="weui-cell__hd f26"><img src="../images/icon_install.png" alt=""></div>
                    <div class="weui-cell__bd fz">
                        <p class="f28 color_4a">{{$v->title}}</p>
                    </div>
                    <div class="f24 color_gray666">
                        <p class="color_4a f26 pb15 fz bold text_right">@if($v->value > 0) +{{$v->value}} @else {{$v->value}}  @endif</p>
                        <span class="color_gray999 f20">{{$v->created_at}}</span>
                    </div>
                </a>
            </div> 
        </li>
    @endforeach

    </div>  
</ul>
<!-- 赛普币明细 end -->

<!--加载更多-->
<div class="weui-loadmore more text_center fz ptb30 remove_attr " id="study_more">
    <span class="weui-loadmore__tips" id ="add_more"  data-is_ture='1'>加载更多</span>
</div>
@else
        <h2 class="fz color_gray666  text_center mt30 pt20">暂无明细</h2>
@endif


<script src="/lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
    $(function() {
        FastClick.attach(document.body);
    });
</script>

<script src="/lib/jqweui/js/jquery-weui.js"></script>
<script>
var i=2;
$("#study_more").click(function(){
        var number = $("#add_more").attr("data-is_ture");
        if(number == 1){
            $.ajax({
                type:"get",
                url:"/spb/spbJson",
                data:{page:i},
                dataType:"json",
                success:function(data){
                    console.log(data);
                    if(!jQuery.isEmptyObject(data)){
                        $.each(data,function(index,json){
                            if(json['value'] > 0){
                                var add = "+";
                            }else{
                                var add = "";
                            }
                            var str = "";
                            var str = str + '<li><div class="weui-cells nobefore noafter mt0"><a class="weui-cell weui-cell_access ptb44 xueyuan_install nobefore noafter" href="javascript:;"><div class="weui-cell__hd f26"><img src="../images/icon_install.png" alt=""></div><div class="weui-cell__bd fz"><p class="f28 color_4a">'+json['title'];
                            var str = str + '</p></div><div class="f24 color_gray666"><p class="color_4a f26 pb15 fz bold text_right">'+ add +json['value'];
                            var str = str + '</p><span class="color_gray999 f20">'+json['created_at'];
                            var str = str + '</span></div></a></div></li>';
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