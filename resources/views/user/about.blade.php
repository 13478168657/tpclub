@extends('layouts.header')
@section('title')
    <title>关于我们{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/xueyuan.css">
    <style type="text/css">
        .weui-article {
            font-size: .6rem;
        }
    </style>>
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth/18.75 + "px";
        })()
    </script>
@endsection
@section('content')
<div class="about_con">
    <!--关于我们 start-->
    <article class="weui-article color_gray666 xy-about">
        <!-- logo -->
        <!-- <div class="about_logo"><img src="/images/logo.png" alt="赛普健身教练培训基地"></div> -->
        <section>
            <h2 class="title lt color_333">赛普健身社区是什么</h2>
            <section class="fz">
                <p>
                    赛普健身社区是一个专业的健身内容社区，我们致力于向所有爱健身、懂健身的人传递知识，并让愿意站出来传递知识的这些人实现个人增长。
                </p>
            </section>
            <h2 class="title lt color_333">赛普健身社区的研发初衷</h2>
            <section class="fz">
                <p>
                    随着移动互联的火爆，知识从线下转到了线上，甚至更多的人是从线上开始健身，了解健身。但其实健身易，科学有效健身难。而赛普的信仰是“健身改变人生”，是希望让每一个中国人得到科学的锻炼，从而改变生活。作为一家健身行业的培训公司，我们认为我们有能力、更有义务站出来，做出专业内容的产品，因此赛普健身社区应运而生。
                </p>
            </section>
            <h2 class="title lt color_333">专业团队生产专业知识</h2>
            <section class="fz">
                <p>
                    赛普健身社区所有的专业内容是集结了上百位健身领域专家的智慧结晶，不仅包罗万象，更科学有效。我们希望在赛普健身社区里，所有在健身领域有想法的专家都能成就自我，实现增长；更希望所有在健身中迷茫的训练者、职业人能通过消费我们的内容实现个人成长。
                </p>
            </section>
            <section class="fz">
                <p>
                    总之，赛普健身社区是一个开放的社区，所有人都可以在这里实现个人的成长。
                </p>
            </section>
        </section>
    </article>
<!--关于我们 end-->
</div>
<!--大按钮-->
<div class="mlr25 Btn pb30 nobefore noafter big_Btn1">
    <a href="/feedback" class="weui-btn nobefore noafter bgcolor_orange color_333">意见反馈</a>
</div>
<br/>
<br/>
<br/>
@endsection