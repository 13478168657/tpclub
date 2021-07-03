<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>课程未评价</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" href="/css/reset.css">
    <link href="/css/head.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/css/xueyuan.css">
    <link rel="stylesheet" href="/css/font-num40.css">
    <!--jqweui css-->
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth/18.75 + "px";
        })()
    </script>
     @include('layouts.baidutongji')
</head>
<body style="background: #fff;">
    <header class="header_bar bgc_grey relative" style="background-color: #f2f2f2;">
        <a href="javascript:history.go(-1);" class="btn_back"><i class="icon iconfont icon-fenxiang2"></i></a>
        <h1 class="cat" style="margin:0">评价列表</h1>
    </header>
    <div class="kc_evaluate mb26">
        <p class="f24 color_gray9b text_center mb30" id="change_score">给老师的课程打个分</p>
        <div id="star" class="text_center" data-score="0">
            
        </div>
    </div>

    <div class="yijianfankui mlr30 pt40">
       <div class="yjfk">
           <div class="weui-cell yijian nobefore">
               <div class="weui-cell__bd">
                   <textarea class="weui-textarea" placeholder="请填写10字以上评语……" rows="8" id="yijian"></textarea>
               </div>
           </div>
       </div>

        <!--大按钮-->
        <!-- <div class="Btn nobefore noafter fix_btn">
            <a href="javascript:;" class="weui-btn nobefore noafter bgcolor_dedede fz ">提交评价</a>
        </div> -->
        <div class="Btn nobefore noafter fix_btn">
            <a href="javascript:;" class="weui-btn nobefore noafter bgcolor_orange fz color_333" onclick="addcomment()">提交评价</a>
        </div>
    </div>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
$(function (){
    var jianjie=$("#yijian");
    wordLimit1(jianjie,$("#yijian_words"),150)
})
</script>
<script src="/js/jquery.min.js"></script>
<script src="/js/star_jquery.raty.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script>
    /*星星点亮*/
    var final_score = 0;
    var user_id     = {{$user_id}};   //用户id 
    var c_c_id      = {{$c_c_id}};    //课程id
    var token       = '{{csrf_token()}}';
    $(function (){
        $.fn.raty.defaults.path = '/images/img/';
        $('#star').raty({
            click: function(score, evt) {
                final_score = score;
                $("#change_score").text(score+" 分");
            }
        });
    })

    var addcomment = function(){
        var text = $("#yijian").val();
        if(text.length<10){
            layer.msg("请填写10字以上的评论");
            return;
        }
        if(final_score<1){
            layer.msg("请给课程评分");
            return;
        }
        var data = {user_id:user_id, _token:token, c_c_id:c_c_id, text:text, final_score:final_score};
        $.ajax({
            url:'/course/commentinsert',
            type:'POST',
            data:data,
            dataType:'json',
            success:function(res){
                layer.msg(res.msg);
                history.go(-1);
            }
        });

    }
</script>
</body>
</html>