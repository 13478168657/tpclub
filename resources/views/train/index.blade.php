<?php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-产后实践</title>
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
    <link href="/lib/swiper/swiper.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" >

    <!--本css-->
    <link rel="stylesheet" href="/css/zt/zt_chanhoushijian.css?t={{time()}}">
    <link rel="stylesheet" href="/css/zt/zt_payment.css">

    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
    <style type="text/css">
        .my-layui-layer-shade {
            position: fixed;
            _position: absolute;
            pointer-events: auto;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            _height: expression(document.body.offsetHeight+"px");
            z-index: 19891014;
            background-color: #000;
            opacity: 0.3;
            filter: alpha(opacity=30);
        }
    </style>
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
        <div class="text_center  fz">
            <ul>
                <li><a href="/">首页</a></li>
                <li><a href="/user/studying">正在学习</a></li>
                <li><a href="/user/index">我的</a></li>
                <li><a href="javascript:history.go(-1);">返回</a></li>
                @if(!is_weixin())
                    @if($user)
                        <li><a href="/logout">退出</a></li>
                    @else
                        <li><a href="/register">注册/登录</a></li>
                    @endif
                @endif
            </ul>
        </div>
    </nav>
    <!--头部导航 end-->



    <div>


        <!--banner start-->
        <div>
            <img src="/images/zt/chanhoushijian/banner1.jpg" alt="">
            <img src="/images/zt/chanhoushijian/banner2.jpg" alt="">
        </div>
        <!--banner end-->

        <!--——————————————————————————————本喵是分割线————————————————————————————————-->
        <div class="">
            <div class="plr97 bg_sp_tit text_center color_fff fz f32 bold">遇到产后会员不知道如何开单？</div>

            <!--视频 start-->
            <div class="plr97 bg_sp text_center pt20 pb50">

                <!--sp start-->
                <div class="pb30">
                    <div class="con">
                        <div class="video">
                            <div class="box2">
                                <img src="/images/zt/chanhoushijian/bg_video.jpg" alt=""/>
                            </div>
                            <video class="pt10" src="http://v.saipubbs.com/%E7%94%B0%E5%9D%A4/%E5%AD%95%E4%BA%A7%E9%A2%84%E5%91%8A%E6%88%90%E7%89%87-%E5%B0%8F.mp4" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto"></video>
                        </div>
                    </div>
                </div>
                <!--sp end-->
                <div class="sp_txt bg_eaeaea border-radius50 fz">
                    <span class="f15"><strong class="f35 bold">6</strong>周</span>│
                    <span class="f15"><strong class="f35 bold">12</strong>系列</span>
                </div>
            </div>
            <!--视频 end-->

            <!--带你解锁产后恢复全套技能 start-->
            <div class="bg_jiesuo text_center f48 bold font-italic">带你解锁产后恢复全套技能</div>
            <!--带你解锁产后恢复全套技能 end-->
        </div>
        <!--——————————————————————————————本喵是分割线————————————————————————————————-->
        <!--早鸟价 start-->
        <div class="mt45 mb205">

            <!--切换的内容 start-->
            <?php
                $i=0;
            ?>
            @foreach($courseData['periods'] as $k => $period)
                    <?php
                        $i++;
                        $orderStatistics = new App\Models\CourseClassGroupOrderStatistics();
                        $ordersNums = $orderStatistics->getOrderNumber($period->course_class_group_id,$period->stage);
                        if(!isset($ordersNums['num']) || $ordersNums['num'] < 50){
                            $flag = 1;
                        }else{
                            $flag = 0;
                        }
                        if($i == 1){
                            if($flag){
                                $currentPrice = $period['birdPrice'];
                            }else{
                                $currentPrice = $period['originPrice'];
                            }
                            $stage = $period['stage'];
                        }

                        $restTime = floor((strtotime($period['begin_time'])- time())/86400);
                    ?>
                    <div class="bg_fff5e5 zaoniao plr60 clearfix {{$i==2?"none":''}}" id="{{$i==2?"zao2":'zao1'}}">
                        @if($flag)
                        <p class="color_ff9a03 fl f20 fz">优惠价：<strong class="f42 bold">{{$period['birdPrice']}}</strong>元 <span class="color_gray666 shan f20 ml20">原价：{{$period['originPrice']}}元</span></p>
                        <p class="color_ff9a03 fr text_right f42 fz bold"><strong class="f20 settime" style="font-weight:100;">优惠名额仅剩：</strong>{{50-$ordersNums['num']}}</p>
                        @else
                            <p class="color_ff9a03 fl f20 fz">价格：<strong class="f42 bold">{{$period['originPrice']}}</strong>元</p>
                            <p class="color_ff9a03 fr text_right f42 fz"><strong class="f20 bold settime">距离开课：</strong>{{$restTime}}天</p>
                        @endif
                    </div>
            @endforeach


            <!--底部悬浮框 start-->
            <div class="relative">
                <div class="footers plr20 bg_fdf3cc">
                    <ul class="clearfix mt20">
                        <?php
                            $i=0;
                        ?>
                        @foreach($courseData['periods'] as $k => $period)
                            <?php
                                $i++;
                                $orderStatistics = new App\Models\CourseClassGroupOrderStatistics();
                                $ordersNums = $orderStatistics->getOrderNumber($period->course_class_group_id,$period->stage);
                                if(!isset($ordersNums['num']) || $ordersNums['num'] < 50){
                                    $flag = 1;
                                }else{
                                    $flag = 0;
                                }
                                $restTime = floor((strtotime($period['begin_time'])- time())/86400);
                            ?>
                            @if($flag)
                                <li class="fl fz color_be3f00 lineh11 {{$i==2?"none":""}}" id="{{$i==1?"zao3":"zao4"}}"><p><span class="f43">￥499</span>元 <strong class="f20 shan_be3f00 color_be3f00 ml10">￥599元</strong></p><p class=" fz color_333 bold">优惠名额仅剩：<span class="settime">{{50-$ordersNums['num']}}</span></p></li>
                            @else
                                <li class="fl fz color_be3f00 lineh11 {{$i==2?"none":""}}" id="{{$i==1?"zao3":"zao4"}}"><p><span class="f43">￥599</span>元 <strong class="f20 shan_be3f00 color_be3f00 ml10"></strong></p><p class=" fz color_333 bold">距离开课：<span class="settime">{{$restTime}}</span>天</p></li>
                            @endif
                        @endforeach

                        <li class="fr fz f30 text_center bgcolor_orange border-radius-img">
                            @if($mobile==0)
                             <a href="javascript:void (0)" class="studyBtn open-popup" onclick="userlogin()">马上报名</a>
                            @else
                                @if($is_buy)
                                <a href="/train/success" class="studyBtn open-popup">报名成功</a>
                                @else
                                <a href="javascript:void (0)" class="studyBtn open-popup" data-target="#half" id="studyBtn">马上报名</a>
                                @endif
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
            <!--底部悬浮框 end-->
            <!--切换的内容 end-->

            <!--按钮切换 start-->
            <div class="zaoniao_btn mt60 plr25 clearfix text_center relative">
                <?php
                    $i = 0;
                    $total = count($courseData['periods']);
                ?>
                @foreach($courseData['periods'] as $k => $period)

                    <?php
                        $i++;
                        $restTime = 86400+1;
                        $playDate = date('m月d日',strtotime($period->begin_time));

                        $orderStatistics = new App\Models\CourseClassGroupOrderStatistics();
                        $ordersNums = $orderStatistics->getOrderNumber($period->course_class_group_id,$period->stage);

                        if(!isset($ordersNums['num']) || $ordersNums['num'] < 50){
                            $flag = 1;
                        }else{
                            $flag = 0;
                        }
                    ?>

                    @if($total == 1)
                        <a href="javascript:void (0)" data-id="{{$period->stage}}" data-price="{{$flag?$period['birdPrice']:$period['originPrice']}}" style="width:100%" onclick="{{$i==1?'zao_show1':'zao_show2'}}(this);" class="button fl border-radius50 fz f24  {{$i==1?'bga':''}}">{{$period['name']}}&nbsp;{{$playDate}}&nbsp;开班</a>
                        @if($flag)
                            <img src="/images/zt/chanhoushijian/youhui.jpg" alt="" class="youhui"/>
                        @endif
                    @else
                       <a href="javascript:void(0)" data-id="{{$period->stage}}" data-price="{{$flag?$period['birdPrice']:$period['originPrice']}}" onclick="{{$i==1?'zao_show1':'zao_show2'}}(this);" class="button {{$i==1?'fl':'fr'}} fl border-radius50 fz f24  {{$i==1?'bga':''}}">{{$period['name']}}&nbsp;{{$playDate}}&nbsp;开班</a>
                    @endif
                @endforeach

            </div>
            <!--按钮切换 end-->
        </div>
        <!--早鸟价 end-->

        <!--——————————————————————————————本喵是分割线————————————————————————————————-->

        <img src="/images/zt/chanhoushijian/lin_bolang.jpg" alt="">
        <div class="bg_fdf3cc pt98 pb254">
            <!--线上课程买很多 学着学着就放弃了？ start-->
            <h2 class="bg_tit3 fz bold f32 color_fff">线上课程买很多，<p>学着学着就放弃了？</p></h2>
            <!--线上课程买很多 学着学着就放弃了？ end-->

            <!--给你四个选择我们的理由 start-->
            <div class="bg_tit_liyou mt32 text_center f48 bold font-italic">
                给你五个选择我们的理由
            </div>
            <!--给你四个选择我们的理由 end-->

            <!--第一模块 start-->
            <div class="pt98">
                <img src="/images/zt/chanhoushijian/bg_num1.jpg" alt="">
            </div>
            <div class="mlr48 bgcolor_fff libor">
                <div class="color_be3f00 text_center pt40 mb40">
                    <h2 class="f36 pt30">12系列录播课每周二课永久复听</h2>
                    <p class="fz f26">拒绝填鸭式教育，碎片化时间学习</p>
                </div>

                <div class="con_list">
                    <ul>
                        <li>
                            <dl class="clearfix plr20 class_img">
                                <dt class="fl bg_ff9a03 f20 fz color_fff text_center border-radius50 mt20">第一课</dt>
                                <dd class="fr f26 color_be3f00">
                                    <p class="">孕产教练理论－入门必备</p>
                                    <p class="fz">产后显微镜——看清妈妈身体变化</p>
                                </dd>
                            </dl>
                            <i class="mt30 pb40"></i>
                        </li>
                        <li>
                            <dl class="clearfix plr20">
                                <dt class="fl bg_ff9a03 f20 fz color_fff text_center border-radius50 mt20">第二课</dt>
                                <dd class="fr f26 color_be3f00">
                                    <p class="">产后腹直肌分离修复</p>
                                    <p class="fz">肚子不小不是胖 而是腹直肌分离</p>
                                </dd>
                            </dl>
                            <i class="mt30 pb40"></i>
                        </li>
                        <li>
                            <dl class="clearfix plr20">
                                <dt class="fl bg_ff9a03 f20 fz color_fff text_center border-radius50 mt20">第三课</dt>
                                <dd class="fr f26 color_be3f00">
                                    <p class="">产后骨盆宽大矫正</p>
                                    <p class="fz">产后屁股大 小心假胯宽</p>
                                </dd>
                            </dl>
                            <i class="mt30 pb40"></i>
                        </li>
                        <li>
                            <dl class="clearfix plr20">
                                <dt class="fl bg_ff9a03 f20 fz color_fff text_center border-radius50 mt20">第四课</dt>
                                <dd class="fr f26 color_be3f00">
                                    <p class="">骨盆带疼痛之骶髂关节紊乱</p>
                                    <p class="fz">产后单侧腰腿屁股痛  多半是骶髂关节紊乱</p>
                                </dd>
                            </dl>
                            <i class="mt30 pb40"></i>
                        </li>
                        <li>
                            <dl class="clearfix plr20">
                                <dt class="fl bg_ff9a03 f20 fz color_fff text_center border-radius50 mt20">第五课</dt>
                                <dd class="fr f26 color_be3f00">
                                    <p class="">骨盆带疼痛之耻骨联合分离</p>
                                    <p class="fz">下腹、会阴痛？耻骨联合分离才是元凶</p>
                                </dd>
                            </dl>
                            <i class="mt30 pb40"></i>
                        </li>
                        <li>
                            <dl class="clearfix plr20">
                                <dt class="fl bg_ff9a03 f20 fz color_fff text_center border-radius50 mt20">第六课</dt>
                                <dd class="fr f26 color_be3f00">
                                    <p class="">产后妈妈漏尿、尿失禁的分类及改善</p>
                                    <p class="fz">担心“笑尿了”  产后不能说的“社交 癌”</p>
                                </dd>
                            </dl>
                            <i class="mt30 pb40"></i>
                        </li>
                        <li>
                            <dl class="clearfix plr20">
                                <dt class="fl bg_ff9a03 f20 fz color_fff text_center border-radius50 mt20">第七课</dt>
                                <dd class="fr f26 color_be3f00">
                                    <p class="">盆腔脏器脱垂的解决技巧</p>
                                    <p class="fz">私密地带酸痛坠胀  小心产后脏器脱垂</p>
                                </dd>
                            </dl>
                            <i class="mt30 pb40"></i>
                        </li>
                        <li>
                            <dl class="clearfix plr20">
                                <dt class="fl bg_ff9a03 f20 fz color_fff text_center border-radius50 mt20">第八课</dt>
                                <dd class="fr f26 color_be3f00">
                                    <p class="">产后圆肩驼背的改善方法</p>
                                    <p class="fz">告别驼背，做妈妈更要姿态挺拔</p>
                                </dd>
                            </dl>
                            <i class="mt30 pb40"></i>
                        </li>
                        <li>
                            <dl class="clearfix plr20">
                                <dt class="fl bg_ff9a03 f20 fz color_fff text_center border-radius50 mt20">第九课</dt>
                                <dd class="fr f26 color_be3f00">
                                    <p class="">产后妈妈之脊柱养护</p>
                                    <p class="fz">脊柱养护好  酸痛压力少</p>
                                </dd>
                            </dl>
                            <i class="mt30 pb40"></i>
                        </li>
                        <li>
                            <dl class="clearfix plr20">
                                <dt class="fl bg_ff9a03 f20 fz color_fff text_center border-radius50 mt20">第十课</dt>
                                <dd class="fr f26 color_be3f00">
                                    <p class="">产后足弓塌陷、扁平足的评估与改善</p>
                                    <p class="fz">怀孕脚大了两码？小心你的足弓塌陷</p>
                                </dd>
                            </dl>
                            <i class="mt30 pb40"></i>
                        </li>
                        <li>
                            <dl class="clearfix plr20">
                                <dt class="fl bg_ff9a03 f20 fz color_fff text_center border-radius50 mt20">第十一课</dt>
                                <dd class="fr f26 color_be3f00">
                                    <p class="">剖腹产、侧切的疤痕恢复的处理技巧</p>
                                    <p class="fz">疤痕会变淡 母爱永不变淡</p>
                                </dd>
                            </dl>
                            <i class="mt30 pb40"></i>
                        </li>
                        <li>
                            <dl class="clearfix plr20">
                                <dt class="fl bg_ff9a03 f20 fz color_fff text_center border-radius50 mt20">第十二课</dt>
                                <dd class="fr f26 color_be3f00">
                                    <p class="">产后妈妈的胸部保养</p>
                                    <p class="fz">既给宝宝喂奶，也要胸部好看的保养良法</p>
                                </dd>
                            </dl>

                        </li>
                    </ul>

                </div>
            </div>
            <!--第一模块 end-->
            <!--——————————————————————————————本喵是分割线————————————————————————————————-->
        </div><!--fdf3cc颜色结束-->
        <!--——————————————————————————————本喵是分割线————————————————————————————————-->
        <!--第二模块 start-->
        <div class="pt140">
            <img src="/images/zt/chanhoushijian/bg_num2.jpg" alt="">
        </div>
        <div class="mlr48 bg_fdf3cc pb50 libor">
            <div class="color_be3f00 text_center">
                <h2 class="f36 pt30">2个月导师群内教学</h2>
                <p class="fz f26">拒绝纸上谈兵，让实战过的导师带你飞</p>
            </div>

            <div class="img_list plr45 mt60 pt20">
                <img src="/images/zt/chanhoushijian/kimg.jpg" alt="">
                <div class="k_list_txt mt60 pt20">
                    <h4 class="f48 font-italic mb40">田坤</h4>
                    <p class="fz f26 color_gray666">美国FORTANASCE 国际孕产康复认证</p>
                    <p class="fz f26 color_gray666">SPINECARE产后骨盆徒手矫正及产后康复认证</p>
                    <p class="fz f26 color_gray666 mb40">中国孕婴协会导师认证</p>
                    <span class="fz f22 color_gray999">Polestar北极星普拉提教练认证</span>
                    <span class="fz f22 color_gray999">AMCT脊柱护理认证教练</span>
                    <span class="fz f22 color_gray999">PTAG-CPT认证教练</span>
                    <span class="fz f22 color_gray999">国家职业资格中级私人教练</span>
                </div>
            </div>

        </div>
        <!--第二模块 end-->
        <!--——————————————————————————————本喵是分割线————————————————————————————————-->
        <!--第三模块 start-->
        <div class="pt140">
            <img src="/images/zt/chanhoushijian/bg_num3.jpg" alt="">
        </div>
        <div class="con3 bg_fdfbcf text_center color_be3f00">
            <p class="f36">实战作业训练+导师点评</p>
            <p class="fz f26">刻意训练，帮你彻底告别“学了不会用”</p>
        </div>

        <div class="plr40 mt60">
            <div class="con3_list con_bg1 f26 color_be3f00 mb26">
                <p>根据真实工作场景设计，</p>
                <p>高度贴合带产后会员会遇到的问题。</p>
            </div>

            <div class="con3_list con_bg2 f26 color_be3f00 mb26">
                <p>学员每一节课学完按时提交作业后，</p>
                <p> 都会得到授课导师点评。</p>
            </div>

            <div class="con3_list con_bg3 f26 color_be3f00 mb26">
                <p>导师每周会在班级群内为大家讲解作业。</p>
            </div>
        </div>
        <!--第三模块 end-->
        <!--——————————————————————————————本喵是分割线————————————————————————————————-->
        <!--第四模块 start-->
        <div class="pt140">
            <img src="/images/zt/chanhoushijian/bg_num4.jpg" alt="">
        </div>
        <div class="con3 bg_fdfbcf text_center color_be3f00">
            <p class="f36">线上班级制管理</p>
            <p class="fz f26">导师全程带班，保障学习效果</p>
        </div>

        <div class="plr40 mt60 pt10">
            <div class="con4 text_center color_be3f00 mb80">
                <img src="/images/zt/chanhoushijian/ico4img1.jpg" alt="">
                <h4 class="fz f36 bold mt26">导师带班</h4>
                <p class="fz f28">1v1解决你在学习中遇到的难题</p>
                <p class="fz f28">（课程结束后依然享有六个月导师答疑服务）</p>
            </div>
            <div class="con4 text_center color_be3f00 mb80">
                <img src="/images/zt/chanhoushijian/ico4img2.jpg" alt="">
                <h4 class="fz f36 bold mt26">班主任在线</h4>
                <p class="fz f28">班主任全程在线，定期跟进你的上课、作业情况，</p>
                <p class="fz f28"> 督促你学习，治疗你的拖延症。</p>
            </div>
            <div class="con4 text_center color_be3f00 mb80">
                <img src="/images/zt/chanhoushijian/ico4img3.jpg" alt="">
                <h4 class="fz f36 bold mt26">线上研讨</h4>
                <p class="fz f28">每周一次线上研讨会，</p>
                <p class="fz f28"> 导师会根据大家的学习进度和作业情况，</p>
                <p class="fz f28"> 针对性的带大家进行专业研讨。</p>
            </div>
        </div>
        <!--第四模块 end-->
        <!--——————————————————————————————本喵是分割线————————————————————————————————-->
        <!--第五模块 start-->
        <div class="ptb120 mb40">
            <div class="con5">
                <div class="con5_l text_center fz color_be3f00">
                    <p class="f36 bold">颁发结业证书</p >
                    <p class="f26">完课颁发</p >
                    <p class="f26">产后实战精英私教结业证书</p >
                </div>
            </div>
        </div>
        <!--第五模块 end-->
        <!--——————————————————————————————本喵是分割线————————————————————————————————-->
        <!--上课流程 start-->
        <img src="/images/zt/chanhoushijian/lin_bolang.jpg" alt="">
        <div class="bg_fdf3cc pt140 pb228">

            <div class="bg_tit_liyou text_center f48 bold font-italic mb80">
                <i></i>上课流程<i></i>
            </div>
            <div class="class_class text_center">
                <p class="f29 fz border-radius50 mb30 bor">报名成功（加入班级学习群）</p>
                <p class="f29 fz border-radius50 mb30 bor">开课仪式</p>
                <p class="f29 fz border-radius50 mb30 bga">每周学习1课完成实战作业</p>
                <p class="f29 fz border-radius50 mb30 bga">导师点评作业，答疑解惑</p>
                <p class="f29 fz border-radius50 mb30 bga">每周一次线上研讨会</p>
                <p class="f29 fz border-radius50 mb30 bor">结课仪式</p>
            </div>
        </div>
        <!--上课流程 end-->
        <!--——————————————————————————————本喵是分割线————————————————————————————————-->
        <!--常见 start-->
        <div class="changjian">
            <h4 class="text_center f62 bold pb50">常见Q&A</h4>

            <div class="mlr30 bg_fff5e5 plr30 ptb86 color_be3f00 text-jus">
                <h3 class="f32">1、可以购买单课吗？</h3>
                <p class="f26 fz mb80">原则上可以，但是我们相信只有体系化的学习、大量的实战练习和教学服务才能达到最大的效果。而单课是不享有这些服务的。</p>
                <h3 class="f32">2、为什么要开班，不可以马上就学习吗？</h3>
                <p class="f26 fz mb10">购买课程后就可以马上开始观看教学视频。但我们提供的教学服务是按照班级制提供的，我们会按照统一的学习计划，监督大家学习。</p>
            </div>
        </div>
        <!--常见 end-->
    </div>
    <!--——————————————————————————————本喵是分割线————————————————————————————————-->
    <!-- 底部弹出popup start -->
    <div id="half" class='weui-popup__container popup-bottom payType_popup'>
        <div class="weui-popup__overlay"></div>
        <div class="weui-popup__modal fz">
            <div class="toolbar">
                <div class="toolbar-inner">
                    <a href="javascript:;" class="picker-button close-popup">关闭</a>
                    <h1 class="title">确认付款</h1>
                </div>
            </div>
            <div class="modal-content bgc_white">
                <div class="plr40 mor_list fz color_333">
                    <h3 class="ptb20 f32 bold">{{$groupTitle}}</h3>
                    <ul class="ptb30 f26">
                        <?php
                            echo htmlspecialchars_decode($groupDesc);
                        ?>
                    </ul>
                </div>
                <div class="weui-cell  weui-cell">
                    <div class="weui-cell__bd">
                        <h2 class="f28">课程费用{{$youhuitext}}</h2>
                    </div>
                    <div class="weui-cell__ft">
                        <span class="price buyPrice">{{$currentPrice-$youhui}}元</span>
                    </div>
                </div>
                <div class="weui-cells weui-cells_radio noafter dd">
                    <label class="weui-cell weui-check__label" for="x11">
                        <div class="weui-cell__bd">
                            <p><i class="ico_wx"></i>微信支付</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" class="weui-check" name="radio1" id="x11" value="WXPAY" checked="checked">
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>
                    <!-- <label class="weui-cell weui-check__label disabled_xueyuan" for="x12" value="BANLANCE" >
                        <div class="weui-cell__bd">
                            <p><i class="ico_balance"></i>余额支付</p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" name="radio1" class="weui-check" id="x12">
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label> -->
                    @if($spb/100 > $currentPrice-$youhui)
                    <label class="weui-cell weui-check__label" for="x13">
                    @else
                    <label class="weui-cell weui-check__label disabled_xueyuan" for="x13">
                    @endif
                        <div class="weui-cell__bd">
                            <p><i class="ico_spb"></i><span class="coin_price">{{($currentPrice-$youhui) * 100}}赛普币(已有{{$spb}}赛普币)</span></p>
                        </div>
                        <div class="weui-cell__ft">
                            <input type="radio" name="radio1" class="weui-check" id="x13" value="SPB" >
                            <span class="weui-icon-checked"></span>
                        </div>
                    </label>

                </div>
                <div class="container_btn ptb20">
                    <a href="javascript:void(0);" class="roy_btn bgcolor_orange payBtn">立即付款</a>
                </div>
            </div>
        </div>
    </div>
    <!-- 底部弹出popup end -->
    <!--——————————————————————————————本喵是分割线————————————————————————————————-->
</div><!--导航大盒子id=page 结束-->

<div class="none aa bm_success_layer text_center tan-font">
    <!-- Swiper -->
    <div class="swiper-container swiper_con">
        <div class="swiper-wrapper ">
            <div class="swiper-slide"><img src="/images/zt/chanhoushijian/list_class/class_img1.png" class="bm_success" alt="" /></div>
            <div class="swiper-slide"><img src="/images/zt/chanhoushijian/list_class/class_img2.png" class="bm_success" alt="" /></div>
            <div class="swiper-slide"><img src="/images/zt/chanhoushijian/list_class/class_img3.png" class="bm_success" alt="" /></div>
            <div class="swiper-slide"><img src="/images/zt/chanhoushijian/list_class/class_img4.png" class="bm_success" alt="" /></div>
            <div class="swiper-slide"><img src="/images/zt/chanhoushijian/list_class/class_img5.png" class="bm_success" alt="" /></div>
            <div class="swiper-slide"><img src="/images/zt/chanhoushijian/list_class/class_img6.png" class="bm_success" alt="" /></div>
            <div class="swiper-slide"><img src="/images/zt/chanhoushijian/list_class/class_img7.png" class="bm_success" alt="" /></div>
            <div class="swiper-slide"><img src="/images/zt/chanhoushijian/list_class/class_img8.png" class="bm_success" alt="" /></div>
            <div class="swiper-slide"><img src="/images/zt/chanhoushijian/list_class/class_img9.png" class="bm_success" alt="" /></div>
            <div class="swiper-slide"><img src="/images/zt/chanhoushijian/list_class/class_img10.png" class="bm_success" alt="" /></div>
            <div class="swiper-slide"><img src="/images/zt/chanhoushijian/list_class/class_img11.png" class="bm_success" alt="" /></div>
            <div class="swiper-slide"><img src="/images/zt/chanhoushijian/list_class/class_img12.png" class="bm_success" alt="" /></div>
        </div>
        <!-- Add Pagination -->
        <!--<div class="swiper-pagination"></div>-->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</div>
<br><br><br>
<!--右侧悬浮 【微信】 start-->
<div class="relative wx">
    <div class="right-suspension1 text_center pt10">
        <a href="javascript:void(0)">
            <img src="/images/zt/wexin.png" alt="">
            <p class="fz f20 bold">微信咨询</p>
        </a>
    </div>
</div>
<!--右侧悬浮 【微信】 end-->

<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>

<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->

<script src="/lib/swiper/swiper.min.js"></script>
<script type="text/javascript">
    //将裂变者id写入本地  用于存储上下级关系
    var fission_id = "{{$fission_id}}";
    if(fission_id>0){
        localStorage.setItem("fission_id", fission_id);
    }
    
    console.log(localStorage.getItem('fission_id')+"是否是裂变者");
    
    //跳转登陆函数
    var userlogin = function(){
        var url = "/train/study.html";
        localStorage.setItem("redirect", url);
        layer.msg('请先注册');
        setTimeout(function(){
            window.location.href = "/register";
        }, 500)
    }

    var stage = '{{$stage}}';
    //播放视频
    $(function (){
        $('.con .video .box2').click(function(){
            $(this).hide();
            $(this).next().trigger('play');
        })
    })

    //弹窗
    $('.con_list li dl').click(function(){
        n=$(this).parents('li').index();
        lesson(n)
    });
    function lesson(n){
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'bm_success_layer_wrap2', //样式类名
            id: 'bm_success_layer2', //设定一个id，防止重复弹出
            closeBtn: 1, //不显示关闭按钮
            anim: 2,
            shade:0,
            shadeClose: true, //开启遮罩关闭
            area: ['80%', '90%'],
            content:$('.aa'),
            btn:false,
            success: function(layero, index){
                $('#page').after('<div class="my-layui-layer-shade"></div>');
                var swiper = new Swiper('.swiper-container', {
                    pagination: '.swiper-pagination',
                    nextButton: '.swiper-button-next',
                    prevButton: '.swiper-button-prev',
                    initialSlide :n,//默认第二个
                    paginationClickable: true
                });
            },
            cancel: function(index, layero){
                $('.my-layui-layer-shade').remove()
                layer.close(index)
                return false; 
            }    
        }); 
    }

    var c_c_id    = 1;   //课程组id
    var token     = '{{csrf_token()}}';
    var is_weixin = "{{$is_weixin}}";  //是否为微信浏览器
    var final_price = "{{$currentPrice-$youhui}}";
    var user_id     = "{{$user_id}}";      //用户id
    var yh = '{{$youhui==0?$youhui:0}}';
    var spb = '{{$spb}}';
    var final_coin = 0;
    //免费报名成功或者购买成功后跳转
    function href_go(){
        location.href = "/train/success";
    }

    //调用微信JS api 支付
    function jsApiCall()
    {

        var _token = '{{csrf_token()}}';
        var data = {class_id:c_c_id,_token:_token, final_price:final_price,stage:stage};
        $.ajax({
            url:'/train/buy',
            data:data,
            type:'POST',
            dateType:'json',
            success:function(res){

                if(res.code != 0){
                    layer.msg(res.message);
                    return false;
                }else{
                    var data = res.data;
                }
                WeixinJSBridge.invoke(
                        'getBrandWCPayRequest',
                        data,
                        function(res){
                            WeixinJSBridge.log(res.err_msg);
                            if(res.err_msg=='get_brand_wcpay_request:ok'){
                                layer.msg('支付成功');
                                href_go();     //支付成功跳转
                            }else{
                                layer.msg('取消支付');
                            }
                        }
                );
            }
        })

    }

    //立即付款弹出框
    $('.payBtn').click(function (){
        var payfrom = $("input[name='radio1']:checked").val();
        if(payfrom=="WXPAY"){
            if(is_weixin==1){

                jsApiCall();
            }else{
                $.ajax({
                    type:"POST",
                    url:"/train/payh",
                    data:{class_group_id:c_c_id,_token:token, final_price:final_price,stage:stage},
                    dataType:"json",
                    success:function(result){
                        if(result.code==1){
                            console.log(result.objectxml.mweb_url);
                            //follow_us();
                            window.location.href=result.objectxml.mweb_url;   //h5呼叫微信支付
                        }else{
                            layer.msg(result.msg);
                        }
                    }
                });
            }
        }else if(payfrom == "SPB"){
            
            $.closePopup()
            $.confirm({
                title: '提示',
                text: '立即购买学习该课程，确认购买吗？',
                onOK: function () {
                    $.ajax({
                        type:"get",
                        url:"/train/paySpb",
                        data:{class_group_id:c_c_id,user_id:user_id, final_price:final_price,stage:stage},
                        dataType:"json",
                        success:function(data){
                                console.log(data);
                                if(data.code == 1){
                                    layer.msg(data.msg);
                                    setTimeout(function(){
                                        href_go();     //支付成功跳转
                                    },1500)  //延迟1.5秒刷新页面
                                }else{
                                    layer.msg(data.msg);
                                }
                        }


                    })
                },
                onCancel: function (){
                }
            });
        }
    })

    /*早鸟价*/
    function zao_show1(obj){
        document.querySelectorAll(".button")[0].classList.add("bga");
        document.querySelectorAll(".button")[1].classList.remove("bga");

        document.getElementById("zao1").classList.remove("none");
        document.getElementById("zao2").classList.add("none");

        document.getElementById("zao3").classList.remove("none");
        document.getElementById("zao4").classList.add("none");
        var price = $(obj).attr('data-price');
        final_price = price - yh;
        stage = $(obj).attr('data-id');
        final_coin = final_price * 100;
        var coin_text = final_coin+'赛普币(已有'+spb+'赛普币)';
        $('.coin_price').text(coin_text);

        $('.buyPrice').text(final_price+'元');

    }
    function zao_show2(obj){
        document.querySelectorAll(".button")[1].classList.add("bga");
        document.querySelectorAll(".button")[0].classList.remove("bga");

        document.getElementById("zao1").classList.add("none");
        document.getElementById("zao2").classList.remove("none");

        document.getElementById("zao3").classList.add("none");
        document.getElementById("zao4").classList.remove("none");
        var price = $(obj).attr('data-price');
        final_price = price - yh;
        stage = $(obj).attr('data-id');
        final_coin = final_price * 100;
        var coin_text = final_coin+'赛普币(已有'+spb+'赛普币)';
        $('.coin_price').text(coin_text);
        $('.buyPrice').text(final_price+'元');
        
    }


    //右侧悬浮点击弹窗
    $('.wx').click(function(){
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'bm_success_layer_wrap', //样式类名
            id: 'bm_success_layer', //设定一个id，防止重复弹出
            closeBtn: 0, //不显示关闭按钮
            anim: 2,
            shadeClose: true, //开启遮罩关闭
            area: ['80%', '60%'],
            content:'<div class="bm_success_layer"><img src="/images/zt/group-er1.png" class="bm_success pt30" alt="" /><div class="text_center fz"><p class="f26 bold pt20">长按识别二维码</p><p class="f26 bold pb20"> 加课程顾问微信</p><p class="f26 bold">备注：产后咨询</p></div></div>',
            btn:false
        });
    })
</script>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: "{{$WechatShare['appId']}}", // 必填，公众号的唯一标识
        timestamp: "{{$WechatShare['timestamp']}}", // 必填，生成签名的时间戳
        nonceStr: "{{$WechatShare['noncestr']}}", // 必填，生成签名的随机串
        signature: "{{$WechatShare['signature']}}",// 必填，签名
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
        ] // 必填，需要使用的JS接口列表
    });
    
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({ 
            title: '产后实战精英私教训练营', // 分享标题
            desc: '我正在学习产后实战课程，你也来学习吧~', // 分享描述
            link: "http://m.saipubbs.com/train/study.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/zt/yunchan01.jpg", // 分享图标
            
        }, function(res) { 
        //这里是回调函数 
            
        }); 
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({ 
            title: '产后实战精英私教训练营', // 分享标题
            link: "http://m.saipubbs.com/train/study.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/zt/yunchan01.jpg", // 分享图标
            
        }, function(res) { 
        //这里是回调函数
            
        }); 
    });
</script>
</body>
</html>
