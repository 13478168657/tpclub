@extends('layouts.header')
@section('title')
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>待你来答-赛普知道-健身教练专业问答平台</title>
    <meta name="author" content="啾啾" />
    <meta name="keywords" content="赛普知道作为健身教练的专业问答平台，致力于解决健身教练工作、职场、以及会员管理等方面的问题，帮助教练在专业知识以及技能方面获得提升。增肌减脂有问题，就来赛普知道，百名专业老师坐镇回答，问答涉及训练技术、减脂增肌、运动康复、运动营养、健身热门话题等多个方向，只有你没问到的健身问题，没有老师答不了的。" />
    <meta name="description" content="健身问题,增肌问题,减脂问题,产后问题,康复训练" />

    <!--问答下css-->
    <link rel="stylesheet" href="/css/ask.css?t=1.2">



    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
    @endsection
            <!---导航右侧带导航弹出---->
@section('content')
<div id="page">
    <!--导航大盒子id=page 开始  【结束在最底部】-->



    <!--===========================================================================================-->
    <div class="qa_content">
        <!--导航 start-->
        <div class="nav_bar_zt text_center">
            <ul class="clearfix fz f28 color_gray666">
                <li><a href="/cak/1.html" class="{{$type == 1?"cur":''}}">最热</a></li>
                <li><a href="/cak/2.html" class="{{$type == 2?"cur":''}}">待你来答({{sum_common_ask_questions(0)}})</a></li>
                <li><a href="/ask/specialdetail.html">回答专场</a></li>
            </ul>
        </div>
        <!--导航 end-->

        <div class="qa_content_box plr30">
            <div>
                <ul>
                    @foreach($commonQuestions as $common)
                        <?php
                            $answers = App\Models\CommonAskAnswer::where('qid',$common->id)->orderBy('updated_at','desc')->take(2)->get();
                            $answerSum = App\Models\CommonAskAnswer::where('qid',$common->id)->select('id')->count();
                        ?>
                        <li class="ptb30">
                            <a href="/cak/answer/{{$common->id}}/1.html">
                                <dl class="clearfix">
                                    <dt class="color_gray666 fz f24 fl">
                                        <span>{{$common->view}}</span>
                                        <span>阅读</span>
                                    </dt>
                                    <dd class="fr">
                                        <h3 class="f32 color_333 fz bold text-overflow2">{{$common->title}}</h3>
                                        <div class="weui-cell padding0 mt0 noafter nobefore">
                                            <div class="weui-cell__bd fz f24 color_gray9b text-overflow">
                                                <p>
                                                    @foreach($answers as $answer)
                                                        <span>{{$answer->user->nickname}}</span>
                                                    @endforeach
                                                    等{{$answerSum}}人参与讨论
                                                </p>
                                            </div>
                                            <div class="weui-cell__ft">{{App\Constant\CommentDate::getDate($common->updated_at)}}</div>
                                        </div>
                                    </dd>
                                </dl>
                            </a>
                        </li>
                    @endforeach
                </ul>
                @if($hasMore)
                <a onclick="loadMore()" class="Load fz text_center pt40 mt20 color_gray666 f24">点击加载更多…</a>
                @endif
            </div>
        </div>

    </div>
    <!--===========================================================================================-->

    {{--悬浮 start--}}
    <div class="fixAsk">
        <a href="/cak/user/add.html" class="fix_box block"></a >
    </div>
    {{--悬浮 end--}}


</div>
<!--导航大盒子id=page 结束-->


<br><br><br>
<!-- 底部固定导航条 start -->
<div class="relative">
    <div class="fixed_bottom_4 clearfix">
        <a href="/"><span class="icon-home"></span></a>
        <a href="/article/0.html"><span class="icon-find"></span></a>
        <a href="/cak/1.html" class="on"><span class="icon-ask"></span></a>
        <a href="/user/studying"><span class="icon-study"></span></a>
        <a href="/user/index"><span class="icon-my"></span></a>
    </div>
</div>
<!-- 底部固定导航条 end -->

<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
    $(function() {
        FastClick.attach(document.body);
    });
    var type = '{{$type}}';
    var page = 2;

    function loadMore(){
        var data = {page:page,type:type};
        $.ajax({
            url:'/cak/loadMore',
            data:data,
            type:"GET",
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    $(".qa_content_box  ul").append(res.data.body);
                    page++;
                    if(res.data.hasMore == 0){
                        $('.Load').text('暂无更多');
                    }
                }
            }
        });
    }
</script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>
@endsection