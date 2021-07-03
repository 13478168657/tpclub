<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no"/>
    <title>常规问答-分享海报页面</title>
    <meta name="author" content="涵涵"/>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <link href="/css/reset.css" rel="stylesheet" type="text/css"/>
    <link href="/css/font-num40.css" rel="stylesheet">
    <style>
        img{width: 100%;margin: 0 auto;display: block;}
        .plr73{padding-left: 1.825rem;padding-right: 1.825rem;}
        .askask{position: absolute;top: 20%;left: 0;width: 100%;}
        .askWen{top: 21.8%;}
        .askDa{top: 45%;}
        .askWen p,.askDa p{line-height: 1.3rem;}
        .askWen p{
            text-overflow: -o-ellipsis-lastline;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        .askDa p{
            text-overflow: -o-ellipsis-lastline;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 5;
            -webkit-box-orient: vertical;
        }
        .askImgMa{top: 78.6%;}
        .askImgMa ul li{float: left;}
        .askImgMa ul li:first-child{margin-right: 19%;/*52*/}
        .askImgMa ul li:first-child img{height: 3.125rem;width: 3.125rem;/*125*/}
        .askImgMa ul li:last-child p{line-height: 1.2rem;}
    </style>
    <script>
        (function () {
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth / 18.75 + 'px';
        })()
    </script>
</head>
<body ontouchstart>
<!--===========================================================================================-->
<div class="shareBImg relative f28 fz color_fff">
    <img src="{{$shareCode}}" alt="">
    {{--<div class="askask askWen plr73 bold">--}}
        {{--<p class="text-jus">我是问题我是问题我是问题我是问题我是问题我是问题我是问题我是问题我是问题我是问题我是问题</p>--}}
    {{--</div>--}}
    {{--<div class="askask askDa plr73">--}}
        {{--<p class="text-jus">我是回答内容我是回答内容我我是回答内容我是回答内容是回答内容我是回答内容我是回答内容我是回我是回答内容我是回答内容我是回答内容我是回答内容答内容我是回答内容我是回答内容我是回答内容我是回答内容我是回答内容我是回答内容</p>--}}
    {{--</div>--}}
    {{--<div class="askask askImgMa plr73 color_333 bold">--}}
        {{--<ul class="clearfix">--}}
            {{--<li><img src="/images/qr.png" alt="二维码"></li>--}}
            {{--<li><p>这里是名字</p></li>--}}
        {{--</ul>--}}
    {{--</div>--}}
</div>
<!--===========================================================================================-->
</body>
</html>