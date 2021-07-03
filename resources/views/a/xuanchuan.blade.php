<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普健身社区</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="../../lib/swiper/swiper.min.css" rel="stylesheet" type="text/css" />
    <style>
        * {
            margin:0;
            padding:0;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        *:before,
        *:after {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        html,body{
            height:100%;
            background-color: #000;
        }
        img{
            display:block;
        }

        .swiper-container{ width:100%; max-width:750px; height:100%; margin:0 auto;}
        .swiper-container .swiper-wrapper{ }
        .swiper-container .swiper-wrapper .swiper-slide{ width:100%; height:100%; background:url(../../images/zt/sqH5/1.jpg) no-repeat center center; -webkit-background-size:100% auto; background-size:100% auto;/*-webkit-background-size:cover; background-size:cover;*/}
        .swiper-container .swiper-wrapper .swiper-slide:nth-child(2){ background-image:url(../../images/zt/sqH5/2.jpg);}
        .swiper-container .swiper-wrapper .swiper-slide:nth-child(3){ background-image:url(../../images/zt/sqH5/3.jpg);}
        .swiper-container .swiper-wrapper .swiper-slide:nth-child(4){ background-image:url(../../images/zt/sqH5/4.jpg);}
        .swiper-container .swiper-wrapper .swiper-slide:nth-child(5){ background-image:url(../../images/zt/sqH5/5.jpg);}
        .swiper-container .swiper-wrapper .swiper-slide:nth-child(6){ background-image:url(../../images/zt/sqH5/6.png);}
        .swiper-container .swiper-wrapper .swiper-slide:nth-child(7){ background-image:url(../../images/zt/sqH5/7.jpg);}


        @-webkit-keyframes tipmove{0%{bottom:10px;opacity:0}50%{bottom:15px;opacity:1}100%{bottom:20px;opacity:0}}
        .ani{
            position:absolute;
        }
        .txt{
            position:absolute;
        }
        .swiper-container .up{ position:absolute;width:20px;height:15px; bottom:40px; left:50%; margin-left:-10px;-webkit-animation: tipmove 1.5s infinite ease-in-out; z-index:999;}


        @media (min-width: 768px) {
            .swiper-container .swiper-wrapper .swiper-slide {
                -webkit-background-size:auto 100%; background-size:auto 100%;
            }
        }

        @media (min-width: 992px) {
        }

        @media (min-width: 1200px) {
        }

        @media (max-width: 321px) {
            .swiper-container .swiper-wrapper .swiper-slide {
                -webkit-background-size:auto 100%; background-size:auto 100%;
            }
        }
        @media (max-width: 768px) {
        }

        @media (min-width: 768px) and (max-width: 991px) {
        }

        @media (min-width: 992px) and (max-width: 1199px) {

        }
    </style>
</head>
<body>
<!-- 滚滚屏 start -->
<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide"></div>
        <div class="swiper-slide"></div>
        <div class="swiper-slide"></div>
        <div class="swiper-slide"></div>
        <div class="swiper-slide"></div>
        <div class="swiper-slide"></div>
        <div class="swiper-slide"></div>
    </div>
    <img src="../../images/zt/sqH5/web-swipe-tip.png" class="up">
    <!-- 指示点 -->
    <!-- <div class="swiper-pagination"></div> -->
</div>
<!-- 滚滚屏 end -->



<script src="../../js/jquery-1.11.2.min.js" type="text/javascript"></script>
<script src="../../lib/swiper/swiper.min.js" type="text/javascript"></script>
<script>
    var len=$('.swiper-container .swiper-slide').length;
    var swiper = new Swiper('.swiper-container', {
        //pagination: '.swiper-pagination',
        paginationClickable: true,
        direction: 'vertical',
        nextButton: '.up',
        grabCursor : true,
        //loop: true,
        onSlideChangeEnd: function(swiper){
            if(swiper.activeIndex >= len-1){
                $('.up').hide();
            }else{
                $('.up').show();
            }
        },
    });
</script>
</body>
</html>