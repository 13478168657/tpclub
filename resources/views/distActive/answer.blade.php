<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-回答问题</title>
    <meta name="author" content="啾啾" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <!--mmenu.css start-->
    <link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
    <link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
    <link href="/css/nav-mmenu-public.css" rel="stylesheet" />
    <!--end-->
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" />
    <script src="/js/jquery-1.11.2.min.js"></script>
    <script src="/js/jquery.SuperSlide.2.1.1.js" type="text/javascript"></script>

    <!--本css-->
    <link rel="stylesheet" href="/css/fenxiaoliucheng_clock.css" />
    <link rel="stylesheet" href="/css/zt/zt_payment.css">

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
   <!--  <div class="mh-head Sticky">

        <div class=" menu-bg-logo">
			<span class="mh-btns-left">
				<a class="icon-menu icon-sousuo" href="javascript:;"></a>
			</span>
			<span class="mh-btns-right">
				<a class="icon-menu" href="#menu"></a>
				<a class="icon-menu" href="#page"></a>
			</span>
        </div>
    </div> -->

    <!--隐藏导航内容-->
    <!-- <nav id="menu">
        <div class="text_center  fz">
            <ul>
                <li><a href="/">首页</a></li>
                <li><a href="/user/studying">正在学习</a></li>
                <li><a href="/user/index">我的</a></li>
                <li><a href="javascript:history.go(-1);">返回</a></li>
            </ul>
        </div>
    </nav> -->
    <!--头部导航 end-->

    <!--====================================本喵是分割线  喵喵~========================================================-->
    <div>
        <div class="fz text_center Answer-tit pt105 mt30">
            <p class="color_ff7800 f66 bold mb22">恭喜你完成报名</p>
            <p class="color_333 f28 bold"><i></i>回答下面的问题后马上开始学习吧<i></i></p>
        </div>
        <div>
            <div class=" answer mt70 mlr70">

                <!-- Swiper start-->
                <div class="swiper-container bgcolor_fff border-radius-img pt105 pb100 swiper-no-swiping"><!--swiper-no-swiping //禁止滑动-->
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <!--单选 start-->
                            <div class="text_center plr80">
                                <h3 class="fz f32 bold mb50">你每周锻炼的时间</h3>
                                <div class="RadioStyle">
                                    <div class="fz f25 color_333">
                                        <ul>
                                            <li class="mb30">
                                                <input type="radio" name="time" value="1" id="1" />
                                                <label class="border-radius50 bgcolor_gray f28" for="1">一周3次以上</label>
                                            </li>
                                            <li class="mb30">
                                                <input type="radio" name="time" value="2" id="2" />
                                                <label class="border-radius50 bgcolor_gray f28" for="2">一周2次</label>
                                            </li>
                                            <li class="mb30">
                                                <input type="radio" name="time" value="3" id="3" />
                                                <label class="border-radius50 bgcolor_gray f28" for="3">一周1次</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--单选 end-->
                        </div>
                        <div class="swiper-slide">
                            <!--单选 start-->
                            <div class="text_center plr80">
                                <h3 class="fz f32 bold mb50">您通过什么渠道了解到我们课程的？</h3>
                                <div class="RadioStyle">
                                    <div class="fz f25 color_333">
                                        <ul>
                                            <li class="mb30">
                                                <input type="radio" name="know" value="1" id="11" />
                                                <label class="border-radius50 bgcolor_gray f28" for="11">微信公众号</label>
                                            </li>
                                            <li class="mb30">
                                                <input type="radio" name="know" value="2" id="12" />
                                                <label class="border-radius50 bgcolor_gray f28" for="12">微信群内</label>
                                            </li>
                                            <li class="mb30">
                                                <input type="radio" name="know" value="3" id="13" />
                                                <label class="border-radius50 bgcolor_gray f28" for="13">同学推荐</label>
                                            </li>
                                            <li class="mb30">
                                                <input type="radio" name="know" value="4" id="14" />
                                                <label class="border-radius50 bgcolor_gray f28" for="14">导师推荐</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--单选 end-->
                        </div>
                        <div class="swiper-slide">
                            <!--单选 start-->
                            <div class="text_center plr80">
                                <h3 class="fz f32 bold mb50">您目前的工作跟健身有关吗？</h3>
                                <div class="RadioStyle">
                                    <div class="fz f25 color_333">
                                        <ul>
                                            <li class="mb30">
                                                <input type="radio" name="about"  value="1" id="21" />
                                                <label class="border-radius50 bgcolor_gray f28" for="21">想了解健身教练</label>
                                            </li>
                                            <li class="mb30">
                                                <input type="radio" name="about" value="2" id="22" />
                                                <label class="border-radius50 bgcolor_gray f28" for="22" class="about" data-value="2">正在学习健身教练</label>
                                            </li>
                                            <li class="mb30">
                                                <input type="radio" name="about" value="3" id="23" />
                                                <label class="border-radius50 bgcolor_gray f28" class="about" data-value="3" for="23">已经是健身教练</label>
                                            </li>
                                            <li class="mb30">
                                                <input type="radio" name="about" value="4" id="24" />
                                                <label class="border-radius50 bgcolor_gray f28" class="about" data-value="4" for="24">对健身教练工作毫无兴趣</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--单选 end-->
                        </div>
                        <div class="swiper-slide">
                            <!--单选 start-->
                            <div class="text_center plr45"><!--plr80-->
                                <h3 class="fz f32 bold mb50">请问您执教几年了？</h3>
                                <div class="RadioStyle float_Radio">
                                    <div class="fz f25 color_333">
                                        <ul class="clearfix">
                                            <li class="mb30">
                                                <input type="radio" name="age" value="1" id="31" />
                                                <label class="border-radius50 bgcolor_gray f28" for="31">还不是私教</label>
                                            </li>
                                            <li class="mb30">
                                                <input type="radio" name="age" value="2" id="32" />
                                                <label class="border-radius50 bgcolor_gray f28" for="32">在校学员</label>
                                            </li>
                                            <li class="mb30">
                                                <input type="radio" name="age" value="3" id="33" />
                                                <label class="border-radius50 bgcolor_gray f28" for="33">毕业学员未执教</label>
                                            </li>
                                            <li class="mb30">
                                                <input type="radio" name="age" value="4" id="34" />
                                                <label class="border-radius50 bgcolor_gray f28" for="34">1年以内</label>
                                            </li>
                                            <li class="mb30">
                                                <input type="radio" name="age" value="5" id="35" />
                                                <label class="border-radius50 bgcolor_gray f28" for="35">1-2年</label>
                                            </li>
                                            <li class="mb30">
                                                <input type="radio" name="age" value="6" id="36" />
                                                <label class="border-radius50 bgcolor_gray f28" for="36">2-3年</label>
                                            </li>
                                            <li class="mb30">
                                                <input type="radio" name="age" value="7" id="37" />
                                                <label class="border-radius50 bgcolor_gray f28" for="37">3-4年</label>
                                            </li>
                                            <li class="mb30">
                                                <input type="radio" name="age" value="8" id="38" />
                                                <label class="border-radius50 bgcolor_gray f28" for="38">4-5年</label>
                                            </li>
                                            <li class="mb30">
                                                <input type="radio" name="age" value="9" id="39" />
                                                <label class="border-radius50 bgcolor_gray f29" for="39">5年以上</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--单选 end-->
                        </div>
                    </div>
                </div>
                <!-- Swiper end -->
                <!-- Add Arrows start-->
                <div class="a1">
                    <div class="aaa">
                        <div class="swiper-button-next border-radius50 bga text_center f29 fz nextProblem disabled" onclick="ac(this)">下一题</div>
                    </div>
                </div>
                <!-- Add Arrows end-->
            </div>
        </div>


    </div>

    <!--====================================本喵是分割线  喵喵~========================================================-->


</div><!--导航大盒子id=page 结束-->



<br><br><br><br><br><br>
<script src="/js/swiper.min.js"></script>

<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->

<script>
    $('body').addClass('bgcolor_fff3bd');

    <!-- Initialize Swiper -->
    var swiper = new Swiper('.swiper-container',{
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        autoHeight:true
    });
    var length = $('.swiper-wrapper').children().length;

    var i = 0;
    function ac(obj){

        i = i+1;
        if(i == length){
            $(obj).text('最后一题');
        }
        $(obj).addClass('disabled');
        var a = $(".swiper-wrapper").find(".swiper-slide-next").length;
    }
    var time = '';
    var about = '';
    var know = '';
    var age = '';
    var class_id = '{{$dis_course_id}}';
    $('input').click(function(){
        if(i == length-1){
            var html = '<div href="/" class="swiper-button-next border-radius50 bga text_center f29 fz nextProblem disabled" onclick="submitInfo();">完成-提交</div>';
            $('.aaa').append(html);
        }
        var name = $(this).attr('name');
        if(name == 'time'){
            time = $(this).val();
        }else if(name == 'age'){
            age = $(this).val();
        }else if(name == 'know'){
            know = $(this).val();
        }else if(name == 'about'){
            about = $(this).val();
        }
        $('.nextProblem').removeClass('disabled');
    });

    function submitInfo(){
        var token = '{{csrf_token()}}';
        var data = {time:time,know:know,about:about,age:age,_token:token};

        $.ajax({
            url:'/dist/postAnswer',
            data:data,
            type:'POST',
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    if(res.data.subscribe){
                        window.location.href="/dist/study/"+class_id+'.html';
                    }else{
                        window.location.href="/dist/code.html";
                    }

                }
            }
        })
    }
</script>
</body>
</html>
