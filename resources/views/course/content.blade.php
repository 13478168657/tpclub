<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>{{$content->title}}{{env('WEB_TITLE_COURSE')}}</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" href="/css/reset.css">
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
    <style>
        .wzList .fz a{color:blue;}
    </style>
</head>
<body ontouchstart>

<div class="bgcolor_fff">

    <div class="mb20">
        <!--本篇标题 start-->
        <div class="plr30 pt30">
            <h3 class="f40 color_333 bold fz line1">{{$content->title}}</h3>
            <div class="weui-cells nobefore noafter padding0 art-list-title mt0">
                <div class="weui-cell nobefore noafter padding0 mt20">
                    <div class="weui-cell__bd">
                        <p class="color_gray9b f24 fz">
                            {{substr($content->created_at,0, 10)}}
                        </p>
                    </div>
                    <div class="weui-cell__ft fz f24 color_gray9b yudu-img">
                        <!-- <span class=""><img src="/images/icon-xiao-xihuan.png" alt="">300</span> -->
                        <span class="pl20"><img src="/images/icon-xiao-yuedu.png" alt="">{{$content->views}}</span>
                    </div>
                </div>
            </div>
        </div>
        <!--本篇标题 end-->

        <!--作者名片 start-->
        <div class="daoshi-tit pt10 pb10">
            <a class="weui-cell weui-cell_access" href="javascript:;">
                <div class="weui-cell__hd">

                    @if($data->avatar)
                        @if(strpos($data->avatar,'http') !== false)
                            <img class="border-radius50" src="{{$data->avatar}}">
                        @else
                            <img class="border-radius50" src="{{env('IMG_URL')}}{{$data->avatar}}">
                        @endif
                    @else
                    <img class="border-radius50" src="/images/my/nophoto.jpg" alt="" />
                    @endif

                    <!-- <img class="border-radius50" src="/images/daoshi-t-img.jpg"> -->
                </div>
                <div class="weui-cell__bd text-overflow">
                    <h2 class="fz f26 color_333 bold">{{$data->teacher_name}}</h2>
                </div>
                <!-- <div class="weui-cell__ft fz border-radius-img color_333 noafter bgcolor_orange plr30 pt10 pb10 f28 bold">关注</div>
 -->
                @if($is_follow==1)
                    <div href="javascript:;" class="fr fz bgcolor_orange border-radius-img pt10 pb10 pl20 pr20 mr30 mt32" data-user_id="{{$data->user_id}}" data-fans_id='{{$user_id}}' onclick="click_follow(this)" data-is_follow='1' id="fans_id{{$user_id}}">已关注</div>
                @else
                    @if($mobile < 1)
                        <div class="fr fz bgcolor_orange border-radius-img pt10 pb10 pl20 pr20 mr30 mt32" onclick="userlogin()" data-user_id="{{$data->user_id}}" data-fans_id='{{$user_id}}' onclick="click_follow(this)" data-is_follow='0' id="fans_id{{$user_id}}">关注</div>
                    @else
                        <div class="fr fz bgcolor_orange border-radius-img pt10 pb10 pl20 pr20 mr30 mt32" data-user_id="{{$data->user_id}}" data-fans_id='{{$user_id}}' onclick="click_follow(this)" data-is_follow='0' id="fans_id{{$user_id}}">关注</div>
                    @endif
                @endif
            </a>
        </div>
        <!--作者名片 end-->

        <!--文章内容 start-->
        <div class="plr30 text-jus pt10 pb30 color_gray666 wzList">
            <div  class="fz">
                <?php
                  echo  htmlspecialchars_decode($content->content)
                ?>
            </div>
        </div>
        <!--文章内容 end-->

        <!-- 标签 start-->
        <div class="wzTag mlr30 pt40 pb30">
            <!-- <ul class="clearfix">
                <li class=" border-radius-img"><a href="javascript:void(0)" class="f24 color_gray666 block plr20 ptb8 bgcolor_gray">我是标签</a></li>
                <li class=" border-radius-img"><a href="javascript:void(0)" class="f24 color_gray666 block plr20 ptb8 bgcolor_gray">标签</a></li>
                <li class=" border-radius-img"><a href="javascript:void(0)" class="f24 color_gray666 block plr20 ptb8 bgcolor_gray">小标签</a>

            </ul> -->
        </div>
        <!-- 标签 end-->
        
        <!--按钮 start-->
        <div class="wxBtn text_center mt10 pb15">
            <a href="javascript:history.back()" class="d-in-black plr40 border-radius-img pt10 pb15 bgcolor_orange"><img src="/images/icoFanhui.png" alt="">返回课程目录</a>
        </div>
        <!--按钮 end-->
    </div>

</div><!--白色背景 end-->


<script src="/lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/jqweui/js/jquery-weui.js"></script>
<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script>
    $('body').addClass('bgcolor_fff')
    var c_c_id      = "{{$data->id}}";     //课程id
    var content_id  = "{{$content->id}}";
    //跳转登陆函数
    var userlogin = function(){
        var url = "/course/content/"+c_c_id+"/"+content_id+".html";
        layer.msg('请先登录');
        
        localStorage.setItem("redirect", url);
        setTimeout(function(){
            window.location.href = "/login";
        }, 500)
    }

    function click_follow(e){

        var fans_id = e.getAttribute("data-fans_id");
        var user_id = e.getAttribute("data-user_id");
        var fansid  = e.getAttribute("id");
        var is_follow = e.getAttribute("data-is_follow");
        
        var token     = '{{csrf_token()}}';
        if(is_follow==1){
         layer.msg('您已关注,无需重复操作');
         return;
        }
        $.ajax({
            type:"POST",
            url:"/user/followadd",
            data:{fans_id:fans_id, user_id:user_id,_token:token,is_follow:is_follow},
            dataType:"json",
            success:function(result){
                if(result.code==1){
                    layer.msg('操作成功');
                    document.getElementById(fansid).setAttribute('data-is_follow', 1);
                    document.getElementById(fansid).innerHTML='已关注';
                }else{
                    layer.msg(result.msg);
                    document.getElementById(fansid).setAttribute('data-is_follow', 0);
                    document.getElementById(fansid).innerHTML='关注';

                }
            }
        });
    }
</script>
</body>
</html>