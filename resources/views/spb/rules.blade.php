@extends('layouts.header')
@section('title')
    <title>赛普币规则{{env('WEB_TITLE')}}</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
 @endsection

@section('cssjs')  
    <link rel="stylesheet" href="../css/xueyuan.css">
    <style>
        .about_sai table{text-align: center;}
         .about_sai table th{text-align: center;}
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

<div class="about_con">
    <!--赛普币规则 start-->
    <article class="weui-article color_gray666 xy-about plr30">
        <section class="pt40">
            <h2 class="title lt color_333 f30">1.什么是赛普币</h2>
            <section class="fz about_sai">
                <p class="f24 text-jus">
                    赛普币是针对用户在赛普健身社区购课、评价、分享等行为给予的奖励。这是赛普健身社区为所有用户推出的一项长期激励计划。
                </p>
            </section>

            <h2 class="title lt color_333 f30">2.赛普币可以用来做什么</h2>
            <section class="fz about_sai">
                <p class="f24 text-jus">
                    赛普币可直接用于支付课程，赛普币和现金抵扣的比例为100:1，即100赛普币=1元。
                </p>
            </section>
            <h2 class="title lt color_333 f30">3.赛普币的使用方法</h2>
            <section class="fz about_sai">
                <p class="f24 text-jus">
                    在结算页面选择使用赛普币支付，即可抵扣相应付款金额。
                </p>
            </section>
            <h2 class="title lt color_333 f30">4.如何获得赛普币</h2>
            <section class="fz about_sai">
                <p class="f24 text-jus">
                    <table border="1" cellpadding="10">
                        <tr>
                            <th colspan="2" width="35%">任务</th>
                            <th width="15%">赛普币</th>
                            <th width="50%">备注</th>
                        </tr>
                        <tr>
                            <td rowspan="2">新手任务</td>
                            <td>注册</td>
                            <td>3000</td>
                            <td>新用户注册即送3000币</td>
                        </tr>
                        <tr>
                            <td>完善个人信息</td>
                            <td>200</td>
                            <td>完善个人信息送200币</td>
                        </tr>
                        <tr>
                            <td>关注任务</td>
                            <td>关注导师</td>
                            <td>50</td>
                            <td>50币/人，每日只统计1次，取消不扣</td>
                        </tr>
                        

                        <tr>
                            <td rowspan="6">课程任务</td>
                            <td>购买课程</td>
                            <td>X*10</td>
                            <td>获得课程售价10%的等价值赛普币</td>
                        </tr>
                        <tr>
                            <td>评价课程</td>
                            <td>50</td>
                            <td>50币/课，每个课程仅统计1次</td>
                        </tr>
                        <tr>
                            <td>分享课程</td>
                            <td>50</td>
                            <td>50币/课，1个课程每日只统计1次，每日封顶150币</td>
                        </tr>
                        <tr>
                            <td>收藏课程</td>
                            <td>20</td>
                            <td>20币/课，每日封顶20币</td>
                        </tr>
                        <tr>
                            <td>报名课程</td>
                            <td>50</td>
                            <td>50币/课，每日封顶50币</td>
                        </tr>
                        <tr>
                            <td>学习课程</td>
                            <td>50</td>
                            <td>每日观看视频课程即送50个币</td>
                        </tr>
                        
                        <tr>
                            <td rowspan="5">文章任务</td>
                            <td>评论文章</td>
                            <td>50</td>
                            <td>50币/篇，每篇文章仅统计一次</td>
                        </tr>
                        <tr>
                            <td>分享文章</td>
                            <td>50</td>
                            <td>50币/篇，每篇文章每日只统计1次，每日统计上限3篇文章</td>
                        </tr>
                        <tr>
                            <td>收藏文章</td>
                            <td>20</td>
                            <td>20币/篇，每日只统计1次，取消不扣</td>
                        </tr>
                        <tr>
                            <td>喜欢文章</td>
                            <td>10</td>
                            <td>10币/篇，每日只统计1次，取消不扣</td>
                        </tr>
                        <tr>
                            <td>推荐文章</td>
                            <td>10</td>
                            <td>10币/篇，每日统计上限10篇文章，若文章被选入精选栏目，额外收获50币/篇</td>
                        </tr>
                        
                    </table>
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