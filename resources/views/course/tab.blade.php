<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-课程分类</title>
    <meta name="author" content="虾虾" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <!--mmenu.css start-->
    <link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
    <link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
    <link href="/css/nav-mmenu-public.css" rel="stylesheet" />
    <!--end-->
    <link rel="stylesheet" href="../lib/swiper/swiper.min.css">
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" >

    <!--课程分类 css-->
    <link rel="stylesheet" href="/css/xueyuan-kechengfenlei.css">

    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
</head>
<body ontouchstart>

<!---导航右侧带导航弹出---->

<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->

    <!--头部导航 start-->
    <div class="mh-head Sticky">

        <div class=" menu-bg-logo">
			<span class="mh-btns-left">
				<a class="icon-menu icon-sousuo" href="javascript:;"></a>
			</span>
			<span class="mh-btns-right">
				<a class="icon-menu" href="#menu"></a>
				<a class="icon-menu" href="#page"></a>
			</span>
        </div>
    </div>

    <!--隐藏导航内容-->
    <nav id="menu">
        <div class="text_center fz">
            <ul>
                <li><a href="javascript:void (0)">首页</a></li>
                <li><a href="javascript:void (0)">正在学习</a></li>
                <li><a href="javascript:void (0)">我的</a></li>
            </ul>
        </div>
    </nav>
    <!--头部导航 end-->

    {{--<div class="act_top_fixed">我是空白</div>--}}
    <!--===课程选项卡 start ======================================================-->
    <div class="act_con_wrap">
        <div class="clearfix act_fenlei">
            <div class="maple-tab fl text_center fz f28 gundongtiao">
                <ul>
                    @foreach($courseTypes as $k => $type)
                        @if($k == 0)
                            <li class="active"><p>{{$type->title}}</p></li>
                        @else
                            <li><p>{{$type->title}}</p></li>
                        @endif
                    @endforeach
                    {{--<li><p>减脂专项教练</p></li>--}}
                    {{--<li><p>运动康复教练</p></li>--}}
                    {{--<li><p>孕产教练</p></li>--}}
                    {{--<li><p>格斗教练</p></li>--}}
                    {{--<li><p>普拉提教练</p></li>--}}
                    {{--<li><p>青少儿教练</p></li>--}}
                </ul>
            </div>
            <!--列表内容-->
            <div class="fr list_weo gundongtiao">
                <div class="swiper-container swiper-no-swiping">
                    <div class="swiper-wrapper">
                        @foreach($courseTypes as $k => $type)
                        <?php
                            $childs = $type->getTypes($type->id);
                        ?>
                        <div class="swiper-slide">
                            <div class="content_div">
                                <!--内容 start-->
                                <div class="box_li text_center">
                                    <ul>
                                        @foreach($childs as $child)
                                            <li data-url="/course/ctypeDetail/{{$type->id}}/{{$child->id}}.html"><a class="block f30 fz color_333" href="/course/ctypeDetail/{{$type->id}}/{{$child->id}}.html">{{$child->title}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!--内容 end-->
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>

    </div>
    <!--===课程选项卡 end ======================================================-->





</div><!--导航大盒子id=page 结束-->

<br><br><br>
<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/swiper/swiper.min.js"></script>

<!--nav logo menu 导航条-->
<script src="／lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->
<script>
    //给此页面body加一个类
    $("html,body").addClass("kechengfenlei bgcolor_fff");

    $(function () {
        var mySwiper = new Swiper('.swiper-container', {
            effect : 'fade',

            onSlideChangeEnd: function (swiper) {
                var j = mySwiper.activeIndex;
                $('.maple-tab li').removeClass('active').eq(j).addClass('active');
                /*var content_height = $(".content_div").eq(j).height();
                 var slide_height = $(".swiper-slide").eq(j).height(content_height);
                 $(".swiper-wrapper").css("height", content_height);
                 $(".swiper-container").css("height", content_height);
                 $(".swiper-slide").css("height",slide_height);*/

                $(".swiper-container .swiper-slide").eq(i).show().siblings().hide();
            }
        })
        /*列表切换*/
        $('.maple-tab li').on('click', function (e) {
            e.preventDefault();
            //得到当前索引
            var i = $(this).index();
            $('.maple-tab li').removeClass('active').eq(i).addClass('active');


            $(".swiper-container .swiper-slide").eq(i).fadeIn().siblings().fadeOut();

            mySwiper.slideTo(i, 1000, false);
            $(".swiper-container .swiper-slide").eq(i).addClass('swiper-slide-active');
        });

        $(".swiper-slide .content_div ul li").click(function(){
           var href= $(this).attr('data-url');
        });
    });


    /*$(document).ready(function(){
     /!*var height = $(".swiper-slide").height();
     console.log(height);*!/
     /!*$(".swiper-wrapper").click(function(){*!/
     $(".swiper-slide .content_div").each(function(){
     /!*alert($(this).height());*!/
     var s=$(this).outerHeight();
     var w=$(window).height();
     //alert(w)
     if(s>=w){
     console.log(111);
     $(this).parents(".swiper-slide").addClass("gundongtiao");
     }else{
     console.log(222)
     }
     });
     /!*});*!/
     })*/
</script>

</body>
</html>
