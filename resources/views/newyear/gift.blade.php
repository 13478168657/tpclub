@extends('layouts.header')
@section('title')
    <title>新学期充电福利-助你钱途无量(好友助力课程)</title>
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/newyear_reset.css">
    <link rel="stylesheet" href="/css/newyear_index.css">
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth/18.75 + "px";
        })()
    </script>
    <script src="/js/jquery.SuperSlide.2.1.1.js"></script>
    <script>
        var ua = navigator.userAgent.toLowerCase();
        var isWeixin = ua.indexOf('micromessenger') != -1;
        if (!isWeixin) {
            window.location.href = "http://m.saipubbs.com/newyear/erweima.html"
        }
        @if($userid == 7149)
           alert("来晚啦 礼品已被领光");
        setTimeout("location.href='/'",0);
        @endif
    </script>
@endsection

@section('content')
</head>
<body class="bg_da463c">
<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->
    
    <div class="banner">
        <img src="/images/new_year/pocket_banner.jpg" alt="">
    </div>
    
    <!-- 福利课程：4节课 马上从健身菜鸟变为为健身达人  start -->

            @if($aid == 2)
                <!-- 现金福利：20元现金红包 免费领啦  start -->
                <div class="mlr30 pt40 pocket_wrap">
                    <div class="pocket text_center border-radius-img">
                        <p class="bg_ffd5b4 border-radius60 color_da463c f32 pt20 pb20 sy_b">现金福利：20元现金红包 免费领啦</p>
                        <div class="mt70"><img src="/images/new_year/hongbao_img1.png" alt=""></div>
                        <p class="color_fff f28 sy_m">不知道您需要啥 直接送钱相信您最喜欢<br>活动保证真实有效  谁用谁知道</p>
                    </div>
                </div>
                <!-- 现金福利：20元现金红包 免费领啦  end -->
                @elseif($aid == 3)
                <!-- 奖品福利：家用减脂瑜伽垫  start -->
                <div class="mlr30 pt40 pocket_wrap">
                    <div class="pocket text_center yoga border-radius-img">
                        <p class="bg_ffd5b4 border-radius60 color_da463c f32 pt20 pb20 sy_b">奖品福利：家用减脂瑜伽垫</p>
                        <div class="mt70 pocket_hb mb30"><img src="/images/new_year/award_img1.jpg" alt=""></div>
                        <p class="color_7a4300 f40 sy_b pb20">原价69元 限时0元免费领</p>
                    </div>
                </div>
                <!-- 奖品福利：家用减脂瑜伽垫  end -->

                @elseif($aid == 4)
                    <!-- 奖品福利：免费领价值99元的多功能家用收腹机  start -->
                    <div class="mlr30 pt40 pocket_wrap">
                        <div class="pocket text_center yoga border-radius-img">
                            <p class="bg_ffd5b4 border-radius60 color_da463c f26 pt20 pb20 sy_b">奖品福利：免费领价值99元的多功能家用收腹机</p>
                            <div class="mt70 pocket_hb mb30"><img src="/images/new_year/award_img2.jpg" alt=""></div>
                            <p class="color_7a4300 f40 sy_b pb20">原价99元 限时免费领</p>
                        </div>
                    </div>
                    <!-- 奖品福利：免费领价值99元的多功能家用收腹机  end -->
                @elseif($aid == 5)
                    <!-- 现金福利：100元现金大红包  start -->
                    <div class="mlr30 pt40 pocket_wrap">
                        <div class="pocket text_center border-radius-img">
                            <p class="bg_ffd5b4 border-radius60 color_da463c f32 pt20 pb20 sy_b">现金福利：100元现金大红包</p>
                            <div class="mt70 mb30 pb20 pocket_hb"><img src="/images/new_year/hongbao_img2.png" alt=""></div>
                            <p class="color_fff f28 sy_m">赛普健身社区在新的一年里祝您财源滚滚</p>
                        </div>
                    </div>
                    <!-- 现金福利：100元现金大红包  end -->

                @endif

    <!-- 福利课程：4节课 马上从健身菜鸟变为为健身达人  end -->

    <!-- 列表 start -->
    <div class="mt30 mlr30 list bg_e16354 border-radius-img">
        <div class="bd">
            <ul class="f24 sy_r">
                  


                      
                   

                 
                <li class="clearfix">
                    <p class="fl text-overflow">ID 威尔士资深教练WINDAY ... </p>
                    <span class="fr text_right">领取该福利</span>
                </li>
                <li class="clearfix">
                    <p class="fl text-overflow">ID 疯狂的犀牛... </p>
                    <span class="fr text_right">领取该福利</span>
                </li>
                <li class="clearfix">
                    <p class="fl text-overflow">ID 迷人的大妈... </p>
                    <span class="fr text_right">领取该福利</span>
                </li>
                <li class="clearfix">
                    <p class="fl text-overflow">ID 健身爱好者葱葱921 ... </p>
                    <span class="fr text_right">领取该福利</span>
                </li>
                <li class="clearfix">
                    <p class="fl text-overflow">ID ENERGY健身工作室创始人... </p>
                    <span class="fr text_right">领取该福利</span>
                </li>
                <li class="clearfix">
                    <p class="fl text-overflow">ID 我要瘦下来61... </p>
                    <span class="fr text_right">领取该福利</span>
                </li>

            </ul>
        </div>
        <script type="text/javascript">
            jQuery(".list").slide({mainCell:".bd ul",autoPage:true,effect:"topLoop",autoPlay:true,vis:3,mouseOverStop:false});
        </script>
    </div>
    <!-- 列表 end -->




 @if($aid == 2||$aid == 3)
    <!-- 距离活动结束还有 start -->
    <div class="distance plr30">
        <p class="color_fff f66 sy_m dis_title plr30 mb40">•&nbsp;距离活动结束还有&nbsp;•</p>
        <div class="color_fff bg_c93126 border-radius60 pt10 pb10 text_center conton">
            <p class="f32 sy_r">距离任务结束还有</p>
            <p class="f32 sy_r"><span class="f60" id="_d" >05</span>天</p >
            <p class="f32 sy_r"><span class="f60" id="_h" >05</span>小时</p >
            <p class="f32 sy_r"><span class="f60" id="_m" >05</span>分钟</p >
        </div>
        <div class="border-radius-img bg_ffd5b4 dis_wrap mt40">
            <div class="clearfix dis_con">
                @if(isset($sponsor->uid))
                    <?php
                        $name = DB::table("users")->where("id",$sponsor->uid)->select("nickname")->first();
                        $num = count($data);
                    ?>
                    <p class="fl f32 sy_b color_7a4300">{{$name->nickname?$name->nickname:'小伙伴们..'}}</p>
                    @else
                    <p class="fl f32 sy_b color_7a4300">小伙伴们..</p>
                @endif
                <span class="fr text_right text-overflow f28 sy_r color_c93126">正在校门口集结兄弟…</span>
            </div>
            @if($aid == 2 || $aid == 3)
                <div class="dis_head relative">
                    <?php
                        $moren = "/images/new_year/head_img2.png";
                    ?>
                    @if(isset($sponsor->uid))
                        <?php
                            $avatar = DB::table("users")->where("id",$sponsor->uid)->select("avatar")->first();
                            $num = count($data);
                        ?>
                        <img src="{{$avatar?$avatar->avatar:$moren}}" alt="" class="head_img1">
                        @if($num !== 0)
                            @foreach($data as $k=>$v)
                                <?php
                                    $avatar = DB::table("users")->where("id",$v->friend)->select("avatar")->first();
                                ?>
                                <img src="{{$avatar?$avatar->avatar:$moren}}" alt="" class="head_img{{$k+2}}">
                            @endforeach
                        @endif
                        @for ($i = 0; $i < $anum-$num; $i++)
                            <img src="/images/new_year/head_img2.png" alt="" class="head_img{{$anum-$i+1}}">
                        @endfor
                    @else
                        <img src="/images/new_year/head_img2.png" alt="" class="head_img2">
                        <img src="/images/new_year/head_img2.png" alt="" class="head_img3">
                        <img src="/images/new_year/head_img2.png" alt="" class="head_img4">
                        <img src="/images/new_year/head_img2.png" alt="" class="head_img5">
                        <img src="/images/new_year/head_img2.png" alt="" class="head_img6">
                    @endif
                </div>
            @endif

        </div>
        <p class="f26 sy_r text_center mt40 dist_txt1 mb100"><i></i>还差{{$anum-count($data)}}位好友即可免费领取<i></i></p>
    </div>
    <!-- 距离活动结束还有 end -->
  @elseif($aid == 4||$aid == 5)
    <!-- 距离活动结束还有 start -->
    <div class="distance plr30">
        <p class="color_fff f66 sy_m dis_title plr30 mb40">•&nbsp;距离活动结束还有&nbsp;•</p>
        <div class="color_fff bg_c93126 border-radius60 pt10 pb10 text_center conton">
            <p class="f32 sy_r">距离任务结束还有</p>
            <p class="f32 sy_r"><span class="f60" id="_d" >05</span>天</p >
            <p class="f32 sy_r"><span class="f60" id="_h" >05</span>小时</p >
            <p class="f32 sy_r"><span class="f60" id="_m" >05</span>分钟</p >
        </div>
        <div class="clearfix dis_con mt40 distance_hb mb26">
            @if(isset($sponsor->uid))
                <?php
                $name = DB::table("users")->where("id",$sponsor->uid)->select("nickname","avatar")->first();
                $num = count($data);
                ?>
                <p class="fl f28  text-overflow sy_b color_7a4300"><img src="{{$name->avatar?$name->avatar:'/images/new_year/head_img1.png'}}" alt="">{{$name->nickname?$name->nickname:'小伙伴们..'}}</p>
            @else
                <p class="fl f32 sy_b color_7a4300">小伙伴们..</p>
            @endif
            <span class="fr text_right text-overflow f26 sy_r color_c93126">正在校门口集结兄弟…</span>
        </div>
        <div class="border-radius-img bg_ffd5b4 dis_wrap list1">
            <div class="bd">
                <ul class="">
                    <?php
                    $moren = "/images/new_year/head_img2.png";
                    ?>
                    @if(isset($sponsor->uid))
                        <?php
                        $avatar = DB::table("users")->where("id",$sponsor->uid)->select("avatar","nickname")->first();
                        $num = count($data);
                        ?>
                        <li class="clearfix distance_hb distance_hb1 mb26">
                            <p class="fl f28  text-overflow sy_b color_7a4300"><img src="{{$avatar?$avatar->avatar:$moren}}" alt="">{{$avatar?$avatar->nickname:'小伙伴们..'}}</p>
                            <span class="fr text_right text-overflow f26 sy_r">已经助力…</span>
                        </li>
                        @if($num !== 0)
                            @foreach($data as $k=>$v)
                                <?php
                                $avatar = DB::table("users")->where("id",$v->friend)->select("avatar","nickname")->first();
                                ?>
                                <li class="clearfix distance_hb distance_hb1 mb26">
                                    <p class="fl f28 sy_b  text-overflow color_7a4300"><img src="{{$avatar?$avatar->avatar:$moren}}" alt="">{{$avatar?$avatar->nickname:'小伙伴们..'}}</p>
                                    <span class="fr text_right text-overflow f26 sy_r">已经助力…</span>
                                </li>
                            @endforeach
                        @endif
                        @for ($i = 0; $i < $anum-$num; $i++)
                                <li class="clearfix distance_hb distance_hb1 mb26">
                                    <p class="fl f28 text-overflow sy_b color_7a4300"><img src="/images/new_year/head_img2.png" alt="">虚位以待</p>
                                    <span class="fr text_right text-overflow f26 sy_r">等待助力…</span>
                                </li>
                        @endfor
                    @else
                            <li class="clearfix distance_hb distance_hb1 mb26">
                                <p class="fl f28 sy_b color_7a4300"><img src="/images/new_year/head_img2.png" alt="">虚位以待</p>
                                <span class="fr text_right text-overflow f26 sy_r">等待助力…</span>
                            </li>
                            <li class="clearfix distance_hb distance_hb1 mb26">
                                <p class="fl f28 sy_b color_7a4300"><img src="/images/new_year/head_img2.png" alt="">虚位以待</p>
                                <span class="fr text_right text-overflow f26 sy_r">等待助力…</span>
                            </li>
                            <li class="clearfix distance_hb distance_hb1 mb26">
                                <p class="fl f28 sy_b color_7a4300"><img src="/images/new_year/head_img2.png" alt="">虚位以待</p>
                                <span class="fr text_right text-overflow f26 sy_r">等待助力…</span>
                            </li>
                            <li class="clearfix distance_hb distance_hb1 mb26">
                                <p class="fl f28 sy_b color_7a4300"><img src="/images/new_year/head_img2.png" alt="">虚位以待</p>
                                <span class="fr text_right text-overflow f26 sy_r">等待助力…</span>
                            </li>
                            <li class="clearfix distance_hb distance_hb1 mb26">
                                <p class="fl f28 sy_b color_7a4300"><img src="/images/new_year/head_img2.png" alt="">虚位以待</p>
                                <span class="fr text_right text-overflow f26 sy_r">等待助力…</span>
                            </li>
                    @endif

                </ul>
            </div>
            <script type="text/javascript">
                jQuery(".list1").slide({mainCell:".bd ul",autoPage:true,effect:"topLoop",autoPlay:true,vis:3,mouseOverStop:false});
            </script>
        </div>
        <p class="f26 sy_r text_center mt40 dist_txt1 mb100"><i></i>还差{{$anum-count($data)}}位好友即可免费领取<i></i></p>
    </div>
    <!-- 距离活动结束还有 end -->

 @endif

@if($aid == 2)
        <!-- 活动规则 start -->
        <div class="activity mlr30">
            <h2 class="f38 sy_r bg_c93126 color_fff border-radius60 text_center pt10 pb10">•&nbsp;&nbsp;&nbsp;活动规则&nbsp;&nbsp;&nbsp;•</h2>
            <div class="bg_c93126 border-radius-img act_txt color_fff mt30">
                <p class="f28 sy_r mb70">
                    01、如何参与活动：<br>点击页面底部【邀请好友助力】分享到朋友圈或者微信好友寻求5位好友助力。
                </p>
                <p class="f28 sy_r mb70">
                    02、如何领取20元红包：<br>邀请5名好友后在本页面点击【领取福利】，注意要在本页面点击哦~根据提示刮奖，然后注意查收微信【服务通知】-点击-【领取红包】。
                </p>
                <p class="f28 sy_r mb70">
                    03、如何查看好友助力情况：<br>找不到该页面的盆友，可以到公众号【赛普健身社区】-【免费福利】-【领取奖励】查看活动页面，同时可以查看好友助力情况。
                </p>
                <p class="f28 sy_r">
                    04、如有其他问题欢迎您直接在【赛普健身社区】公众号留言，或者添加右侧微信
                </p>
            </div>
        </div>
        <!-- 活动规则 end -->
    @elseif($aid == 3)

                <!-- 活动规则 start -->
        <div class="activity mlr30">
            <h2 class="f38 sy_r bg_c93126 color_fff border-radius60 text_center pt10 pb10">•&nbsp;&nbsp;&nbsp;活动规则&nbsp;&nbsp;&nbsp;•</h2>
            <div class="bg_c93126 border-radius-img act_txt color_fff mt30">
                <p class="f28 sy_r mb70">
                    01、如何参与活动：<br>点击页面底部【马上邀好友助力】分享到朋友圈或者微信好友寻求5位好友助力。
                </p>
                <p class="f28 sy_r mb70">
                    02、如何领取福利：<br>邀请5名好友后，在本页面点击【领取福利】，准确填写表单，以便顺利领取奖品哦~
                </p>
                <p class="f28 sy_r mb70">
                    03、如何查询好友助力：<br>在本页面点击【领取福利】查询好友助力情况，或到公众号【赛普健身社区】-【免费福利】-【领取奖励】-进入活动页面查询助力情况或领取福利。
                </p>
                <p class="f28 sy_r">
                    04、如有其他问题请直接在【赛普健身社区】公众号留言，或者添加右侧微信群咨询。
                </p>
            </div>
        </div>
        <!-- 活动规则 end -->

        <!-- 家用减脂瑜伽垫简介 start -->
        <div class="mlr30 bgcolor_fff border-radius-img mt50">
            <div class="yoga_txt color_7a4300">
                <h2 class="sy_b f40 mb40 text_center">家用减脂瑜伽垫简介</h2>
                <p class="sy_n f28">10mm加厚防滑瑜伽垫，环保多功能，男女皆可用，让健身变得安全舒适~</p>
            </div>
        </div>
        <!-- 家用减脂瑜伽垫简介 end -->

    @elseif($aid == 4)
         <!-- 活动规则 start -->
        <div class="activity mlr30">
            <h2 class="f38 sy_r bg_c93126 color_fff border-radius60 text_center pt10 pb10">•&nbsp;&nbsp;&nbsp;活动规则&nbsp;&nbsp;&nbsp;•</h2>
            <div class="bg_c93126 border-radius-img act_txt color_fff mt30">
                <p class="f28 sy_r mb70">
                    01、如何参与活动：<br>点击页面底部【马上邀好友助力】分享到朋友圈或者微信好友寻求15位好友助力。
                </p>
                <p class="f28 sy_r mb70">
                    02、如何领取福利：<br>邀请15名好友后，在本页面点击【领取福利】，准确填写表单，以便顺利领取奖品哦~
                </p>
                <p class="f28 sy_r mb70">
                    03、如何查询好友助力：<br>在本页面点击【领取福利】查询好友助力情况，或到公众号【赛普健身社区】-【免费福利】-【领取奖励】-进入活动页面查询助力情况或领取福利。
                </p>
                <p class="f28 sy_r">
                    04、如有其他问题请直接在【赛普健身社区】公众号留言，或者添加右侧微信群咨询。
                </p>
            </div>
        </div>
        <!-- 活动规则 end -->

        <!-- 家用减脂收腹机简介 start -->
        <div class="mlr30 bgcolor_fff border-radius-img mt50">
            <div class="yoga_txt color_7a4300">
                <h2 class="sy_b f40 mb40 text_center">多功能家用收腹机简介</h2>
                <p class="sy_n f28">加长加厚仰卧起坐美腰机收腹机器，随时随地都能健身，让健身变得随心所欲，让小肚子上赘肉一边呆着去吧~</p>
            </div>
        </div>
        <!-- 家用减脂收腹机简介 end -->
    @elseif($aid == 5)
            <!-- 活动规则 start -->
    <div class="activity mlr30">
        <h2 class="f38 sy_r bg_c93126 color_fff border-radius60 text_center pt10 pb10">•&nbsp;&nbsp;&nbsp;活动规则&nbsp;&nbsp;&nbsp;•</h2>
        <div class="bg_c93126 border-radius-img act_txt color_fff mt30">
            <p class="f28 sy_r mb70">
                01、如何参与活动：<br>点击页面底部【马上邀好友助力】分享到朋友圈或者微信好友寻求25位好友助力。
            </p>
            <p class="f28 sy_r mb70">
                02、如何领取福利：<br>邀请25名好友后，在本页面点击【领取福利】，准确填写表单，工作人员会联系您的微信/电话，请注意查看哦~
            </p>
            <p class="f28 sy_r mb70">
                03、如何查询好友助力：<br>在本页面点击【领取福利】查询好友助力情况，或到公众号【赛普健身社区】-【免费福利】-【领取奖励】-进入活动页面查询助力情况或领取福利。
            </p>
            <p class="f28 sy_r">
                04、如有其他问题请直接在【赛普健身社区】公众号留言，或者添加右侧微信群咨询。
            </p>
        </div>
    </div>
    <!-- 活动规则 end -->

@endif



<br><br><br>
    <!-- 固定底部 start-->
    <div class="fixed_wrap">
        <ul class="clearfix sy_m f28 text_center">

                @if($userid == 0)
                    <li class="color_333" onclick="userlogin()"><a href="javascript:;">邀请好友助力</a></li>
                    <li class="color_333" onclick="userlogin()"><a href="javascript:;">领取福利</a></li>
                @else
                    @if($sponsor_count < $maxnum)
                        @if($num < $anum)
                            <li class="color_333"><a href="/newyear/sharecard/{{$aid}}?userid={{$userid}}">邀请好友助力</a></li><!--10为此次活动暗号-->
                            <li class="color_333" id="share_count" data-attr = "{{$num}}"><a href="javascript:;">领取福利</a></li>
                            @else
                            <li class="color_333"><a href="javascript:;"  onclick = "layer.msg('助力成功 可点右侧【领取福利】');">邀请好友助力</a></li>
                            @if($sponsor->is_get == 1)			<!--是否领到礼物---->
                                @if($aid == 2)
                                        <li class="color_333" onclick = "layer.msg('您已经领过红包了哦！');"><a href="javascript:;">领取福利</a></li>
                                    @else
                                        <li class="color_333 is_get" data-attr = "1"><a href="javascript:;">领取福利</a></li>
                                 @endif
                            @else

                                <li class="color_333 is_get" data-attr = "0"><a href="javascript:;">领取福利</a></li>
                            @endif
                        @endif
                    @else
                        <li class="color_333"><a href="javascript:;"  onclick = "layer.msg('来晚啦 礼品已被领光!');">邀请好友助力</a></li>
                        <li class="color_333"><a href="javascript:;" onclick = "layer.msg('来晚啦 礼品已被领光!');">领取福利</a></li>
                    @endif
                @endif

        </ul>
    </div>
    <!-- 固定底部 end-->

    <!-- 微信 start -->
    <div class="code zixunBtn">
        <a href="javascript:void(0)" class="f20 color_000 sy_m bgcolor_fff">
            <img class="service-icon" src="/images/new_year/weixin.png" alt="">
            微信咨询
        </a>
    </div>
    <!-- 微信 end -->
</div>


<script src="lib/jqweui/js/jquery-weui.js"></script>
<script src="lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->
<script type="text/javascript">
    window.onload = function(){
        menuFixed('nav_keleyi_com');
    }
</script> 

<script>
/*倒计时*/
function countTime() {
    //获取当前时间
    var date = new Date();
    var now = date.getTime();
    //设置截止时间
    var endDate = new Date("2019/1/30 23:23");
    var end = endDate.getTime();
    //时间差
    var leftTime = end-now;
    //定义变量 d,h,m,s保存倒计时的时间
    var d,h,m;
    if (leftTime>=0) {
        d = Math.floor(leftTime/1000/60/60/24);
        h = Math.floor(leftTime/1000/60/60%24);
        m = Math.floor(leftTime/1000/60%60);
    }
    //将倒计时赋值到div中
    document.getElementById("_d").innerHTML = d;/*+"天"*/
    document.getElementById("_h").innerHTML = h;/*+"时"*/
    document.getElementById("_m").innerHTML = m;/*+"分"*/
    //递归每秒调用countTime方法，显示动态时间效果
    setTimeout(countTime,1000);
}
onload(countTime())
</script>

<script>


    $("#share_count").click(function(){
        var count = $(this).attr("data-attr");
        var left = {{$anum}} - count;
        layer.msg("亲，还差"+left+"人助力，快去邀请好友吧");
    })
//播放视频
$(function (){
    //播放视频
    $('.con .video .box2').click(function(){
        $(this).hide();
        /*//首页下点击图片播放的id  //教师下点击图片播放的id
        document.getElementById('video').play();*/
    })
})
$(document).ready(function(){
    $(".thumb").click(function(){
        $(this).parent().next().trigger('play');
    });
});
//点击其中一个播放时，其他的停止播放
// 获取所有video
var videoclose = document.getElementsByTagName("video");
// 暂停函数
function pauseAll() {
    var self = this;
    [].forEach.call(videoclose, function (i) {
        // 将video中其他的video全部暂停
        i !== self && i.pause();
    })
}
// 给play事件绑定暂停函数
[].forEach.call(videoclose, function (i) {
    i.addEventListener("play", pauseAll.bind(i));
})



//微信弹窗
$(function (){
    $('.zixunBtn').click(function(){
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'bm_success_layer_wrap', //样式类名
            id: 'bm_success_layer', //设定一个id，防止重复弹出
            closeBtn: 1, //不显示关闭按钮
            anim: 2,
            shadeClose: true, //开启遮罩关闭
            area: ['100%', '100%'],

           /* content:'<div class="bm_success_layer text_center tan-font"><div class="mt30 pt20"><p class="sy_r bold f32 color_333">扫码加入健身福利群<br />免费领更多福利</p><img src="/images/new_year/code.jpg" class="bm_success" alt="" /><p class=" sy_r color_333 f26">扫码入群<br />活动问题都可在群内提出<br />美女小姐姐会为你耐心解答的~<br />更多健身干货，奖品福利<br />帅哥美女尽在这里，等你来撩~<br /></p></div>',*/

            content:'' +
            '<div class="bm_success_layer text_center">' +
            '<div class="mt40 pt40 plr20">' +
            '<p class="color_333 f32 sy_m bold">扫码加入健身福利群<br />免费领更多福利</p>' +
            '<img src="/images/new_year/code.jpg" class="bm_success" alt="" />' + 
            '<p class="sy_m color_333 f26 mt40 sao">扫码入群<br />活动问题都可在群内提出<br />美女小姐姐会为你耐心解答的~<br />更多健身干货，奖品福利<br />帅哥美女尽在这里，等你来撩~</p>' +
            '</div>' +
            '</div>',
            btn:false
        });
    })
})

//跳转登陆函数
var userlogin = function(){
    var userid = "{{$userid}}";
    var url = "{{$url}}";
    localStorage.setItem("redirect", url);

    layer.msg('请先注册');
    setTimeout(function(){
        window.location.href = "/register";
    }, 500)
}

//领取福利
$(".is_get").click(function() {
    var status = $(this).attr("data-attr");
    if (status == 0){
        var token = '{{csrf_token()}}';
        var userid = '{{$userid}}';
        var aid = '{{$aid}}';

        var data = {userid: userid,aid: aid, _token: token};
        $.ajax({
            url: '/newyear/is_zutuan',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function (data) {
                $(".is_get").attr("data-attr",1);
                layer.msg("恭喜您获得大礼。");
                @if(isset($sponsor->uid))
                      @if($num >= $anum)
                         setTimeout("location.href='{{$gifturl}}'",1000);
                     @endif
                @endif

            }
        });
    }else{
        //layer.msg("您已领到课程，请在正在学习栏查看。");
        window.location.href = "{{$gifturl}}";
    }
})

</script>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>

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
            title: '新学期充电福利 助你钱途无量', // 分享标题 newyear/gifthelp/{uid}/{aid}.html
            desc: '', // 分享描述
            link: "http://m.saipubbs.com/newyear/gifthelp/{{$userid}}/{{$aid}}.html?fission_id={{$userid}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/new_year/banner2.jpg", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '新学期充电福利 助你钱途无量', // 分享标题
            link: "http://m.saipubbs.com/newyear/gifthelp/{{$userid}}/{{$aid}}.html?fission_id={{$userid}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "http://m.saipubbs.com/images/new_year/banner2.jpg", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });

    var fission_id = "{{$fission_id}}";
    if(fission_id>0){
        localStorage.setItem("fission_id", fission_id);
    }
</script>
@endsection

