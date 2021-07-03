<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普&耐克超级健身盛典投票</title>
    <meta name="author" content="涵涵" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet"  href="/lib/jqweui/css/weui.min.css"/>
    <link rel="stylesheet"  href="/lib/jqweui/css/jquery-weui.min.css"/>

    <link rel="stylesheet" href="/css/reset.css?t=1.7"/>
    <link rel="stylesheet" href="/css/font-num40.css">
    <link rel="stylesheet" href="/css/zt/zt_just_do_it.css?t=1.8">
    <link rel="stylesheet" href="/css/zt/zt_just_do_it_public.css">
    <link rel="stylesheet" href="/css/zt/zt_RightFloat.css">
    <script src="/js/rem.js" type="text/javascript"></script>
    @include('layouts.baidutongji')
    <style>
        /* 搜索框 */
    .search_sp{position: relative;z-index: 9;}
    .search_sp .search_in{width: 100%;background:#fff;outline: none;border:1px solid #fdd000;padding:.5rem;height: 2rem;}
    .search_sp .btn_search{display: block;background: #fdd000;padding:.5rem 1rem;height: 2rem;position: absolute;top:0;right: 0;z-index: 99;}
    </style>
</head>
<body>
<div class="pubuliu_maxbox">
    <!-- 头部 start -->
    <div class="ad_code" style="display: none;">
        <img src="/images/zt/just_do_it/home/ad_sp.jpg" alt="" class="img100 ad_img_img">
        <div class="ad_close"><img src="/images/close2.png" class="img_close" alt=""></div>
    </div>
    <!-- 弹出 start -->
    <div class="bm_success_layer_wrap text_center hide">
        <p class="color_333 f20 pt40">扫描下面二维码报名<br>并获取报名结果</p>
        <img src="/images/zt/just_do_it/home/code.jpg" class="bm_success" alt="" />
    </div>
    <!-- 弹出 end -->
    <!-- 头部 end -->
    <!-- banner start -->
    <div class="pubu_ban">
        <img src="/images/zt/just_do_it/pububan_img1.jpg?t=1" alt="">
        <img src="/images/zt/just_do_it/pububan_img2.jpg" alt="">
    </div>
    <!-- banner end -->

    <!-- 时间倒计时 /票数/个人简介 start-->
    <div class="">
        <!-- 时间倒计时 start -->
        <div class="pu_time text_center bgcolor_o_ffb400">
            <h4 class="fz bold f30 color_333 pt40 pb35"><i></i>距离投票结束还有<i></i></h4>

            <div class="daojishi_box">
                <div class="ft_counter clearfix"></div>
            </div>
        </div>
        <!-- 时间倒计时 end -->

        <!-- 票数/个人简介 start-->
        <div class="plr35 mb40">
            <div class="pu_tick text_center border-radius-img bgcolor_fff">
                <ul class="clearfix">
                    <li>
                        <p class="fz bold f36">{{$bmTotal}}</p>
                        <span class="fz f26">报名人数</span>
                    </li>
                    <li>
                        <p class="fz bold f36">{{$totalVote}}</p>
                        <span class="fz f26">总票数</span>
                    </li>
                </ul>
                <!-- 个人 start-->
                @if($selfActive)
                    <?php
                    //                    $user = $selfActive->user;
                    //                    $name = $user->name?$user->name:$user->nickname;
                    $voteNum = $selfActive->invite_num;
                    //                    $isVote = App\Models\WechatActivityHand::where('sponsor_id',$user_id)->where('user_id',$selfActive->user_id)->select('id')->first();
                    $introActive = $selfActive->getActiveInfo($selfActive->user_id,'DOIT',$selfActive->stage);
                    $userInfo = json_decode($introActive->user_info);
                    $name = $userInfo->name;
                    ?>
                    <div class="pu_inr text_left plr40">
                        <dl class="clearfix">
                            <dt><img src="{{env('IMG_URL')}}{{$userInfo->cover_img}}" alt="" class="img100"></dt>
                            <dd>
                                <h3 class="fz bold f30 bold">{{$name}}</h3>
                                <div class="fz f26 color_gray666 inr_box1">
                                    <p class="text-overflow">{{$userInfo->company}}</p>
                                    <p class="text-overflow">{{$userInfo->positon}}</p>
                                </div>
                                <div class="fz f28 color_orange_fd7100 inr_box2">
                                    <span class="block bold"><b>{{$voteNum}}</b>票</span>
                                    <span class="block bold">第{{$selfRank+1}}名</span>
                                </div>
                                <div class="fz f28 min_btns">
                                    <button class="lapiao" data-id="{{$selfActive->user_id}}">拉票</button>
                                </div>
                            </dd>
                        </dl>
                    </div>
                    @endif
                            <!-- 个人 end -->
            </div>
        </div>
        <!-- 票数/个人简介 end-->
    </div>
    <!-- 时间倒计时 /票数/个人简介 end-->

    <!-- 瀑布流 start -->
    <!-- 热门选手 -->
    <div class="icon_tit_hot pb40 {{$selfActive?'':'mt-80'}}"><img src="/images/zt/just_do_it/icon_tit.png" class="img100" alt="热门选手"></div>
    <!-- 搜索框 start -->
    <div class="mlr30 mt30 mb30">
        <div class="search_sp">
            <form action="" method="get">
            <input type="text" name="key" placeholder="请输入选手参赛姓名" value="{{$key}}" class="search_in border-radius-img fz f20">
            <button class="btn_search border-radius-img fz f28 color_000 text_center" type="submit">
            搜&nbsp;&nbsp;索</button>
            </form>
        </div>
    </div>
    <!-- 搜索框 end -->
    <div class="">
        <div class="pbl_wrap">
            <div class="grid">

                @foreach($activeUsers as $activeUser)
                    <?php
                    //                        $user = $activeUser->user;
                    //                        $name = $user->name?$user->name:$user->nickname;
                    $voteNum = $activeUser->invite_num;
                    $day = date('Ymd');
                    $isVote = App\Models\WechatActivityHand::where('sponsor_id',$user_id)->where('user_id',$activeUser->user_id)->where('day',$day)->where('stage',$activeUser->stage)->select('id')->first();
                    $introActive = $activeUser->getActiveInfo($activeUser->user_id,'DOIT',$activeUser->stage);
                    $userInfo = json_decode($introActive->user_info);
                    $name = $userInfo->name;
                    ?>
                    <div class="grid-item">
                        <div class="info">
                            <div class="pic">
                                <a href="/jdt/active/center/{{$activeUser->user_id}}.html">
                                    <img src="{{env('IMG_URL')}}{{$userInfo->cover_img}}" alt="" class="img100">
                                    <p class="mask"></p>
                                    <p class="live"></p>
                                </a>
                            </div>
                            <div class="title fz bgcolor_fff">
                                <div class="clearfix t_name">
                                    <p class="fl f30 bold color_333">{{$name}}</p>
                                    <p class="fr f22 color_orange_ff6600 text_right"><span class="pu_num block">{{$voteNum}}</span>票</p>
                                </div>
                                <p class="f24 text-overflow2 color_333 text-jus js">{{$userInfo->company}}</p>
                                <div class="btns clearfix f28">
                                    @if($isVote)
                                        <button class="fl toupiao bgcolor_gray_ebebeb" onclick="num_jia(this);" disabled="disabled">已投</button>
                                    @else
                                        <button data-id="{{$activeUser->user_id}}" class="fl toupiao bgcolor_orange" onclick="num_jia(this);">投票</button>
                                    @endif
                                    <button data-id="{{$activeUser->user_id}}" class="fr lapiao">拉票</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- 瀑布流 end -->
</div>
<!-- 右侧悬浮 start-->
<div class="just_fixed_right text_center color_fff">
    <ul>
        <li><a href="/jdt/active/index" class="block lt f42 color_fff">首页</a></li>
        <li>
            <span class="block fz f26">还可投<strong class="f28 lt">{{$restNum}}</strong>票</span>
            <span class="block fz f24">每日有3票</span>
        </li>
    </ul>
</div>
<!-- 右侧悬浮 end-->
<!-- 底部固定导航 start -->
{{--<div class="fixed_bar_bottom">--}}
{{--<ul class="clearfix nav">--}}
{{--<li>--}}
{{--<a href="#">首页</a>--}}
{{--</li>--}}
{{--<li>--}}
{{--<a href="#">投票</a>--}}
{{--</li>--}}
{{--<li>--}}
{{--<a href="#">排行榜</a>--}}
{{--</li>--}}
{{--</ul>--}}
{{--</div>--}}
        <!-- 底部固定导航 end -->
<br><br><br>
<!--<script src="/js/jquery.js"></script>-->
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>

<!-- 倒计时 -->
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/djs/jquery.easing.js"></script>
<script src="/lib/djs/fliptimer.js"></script>
<script>

    //瀑布流去掉公共最大宽
    $("body").addClass("body_max-width_none");
    function userlogin(){

        var url = "/jdt/active/vote";
        localStorage.setItem("redirect", url);

        layer.msg('请先注册');
        setTimeout(function(){
            window.location.href = "/register";
        }, 300);
    }
    //拉票海报弹窗
    $('.shareRuleImg').click(function () {
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'canvassing_layer', //样式类名
            id: 'canvassing_layer', //设定一个id，防止重复弹出
            closeBtn: 1, //不显示关闭按钮
            anim: 2,
            shadeClose: true, //开启遮罩关闭
            area: ['90%', '80%'],
            content: '<div class="canvassing_layer text_center tan-font"><img src="/images/zt/just_do_it/lapiao_img.jpg" class="bm_success" alt="" /><p class="fz f26 ptb20">长按图片并将图片保存到相册</p></div>',
            btn: false
        });
    });

    //倒计时
    $(".ft_counter").EightycloudsFliptimer({
        enddate    : "3 January 2020 23:59:59",
        callback   : function(){
            alert("本活动已结束!");
        }
    });
    $(function (){
//        $(".ft_counter .EightycloudsFlipTimer .hours").after("<div class='clear'></div>");
        $('.ft_counter .EightycloudsFlipTimer .days .block_text').text('天');
        $('.ft_counter .EightycloudsFlipTimer .hours .block_text').text('时');
        $('.ft_counter .EightycloudsFlipTimer .minutes .block_text').text('分');
        $('.ft_counter .EightycloudsFlipTimer .seconds .block_text').text('秒');
    });


    var num = 0;
    function num_jia(e){
        var add_txt = $(e).parent().parent().find(".pu_num");
        var add_num = parseInt(add_txt.text());
        var id = $(e).attr('data-id');
        var token = '{{csrf_token()}}';

        var data = {id:id,_token:token};
        $(e).addClass('disabled');
        $.ajax({
            url:'/jdt/active/postVote',
            data:data,
            type:'POST',
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    $(e).removeClass('bgcolor_orange').addClass('bgcolor_gray_ebebeb').text("已投");
                    add_num +=1;
                    add_txt.text(add_num);
                    layer.msg("投票成功");
                }else if(res.code == 4){
                    $(e).removeClass('disabled');
                    userlogin();
                }else if(res.code == 5){
                    //引导关注公众号
                    $.ajax({
                        url:'/jdt/active/voteCode',
                        data:{id:id, _token:token},
                        type:'GET',
                        dataType:'json',
                        success:function(res){
                            if(res.code == 1){
                                var url = res.url;
                                layer.open({
                                    type: 1,
                                    title: false, //不显示标题栏
                                    skin: 'codeW_layer_wrap codeW_layer_success', //样式类名
                                    id: 'codeW_layer', //设定一个id，防止重复弹出
                                    closeBtn: 0, //不/显示关闭按钮
                                    anim: 2,
                                    shadeClose: 0, //开启/关闭遮罩
                                    shade: [1, '#333'],
                                    area: ['30%', '80%'],
                                    content:'<div class="hideWImg text_center mt16 relative">' +
                                    '<a class="Wjump no_Wjump d-in-black border-radius50 f26 fz color_fff" href="javascript:void(0)">关闭</a>' +
                                    '<p class="fz f44 mb40 bold mt50 color_FA6C11">你还不能投票</p>' +
                                    '<p class="plr30 fz f30 color_333 mt20 mb40">' +
                                    '<span class="block">关注公众号</span>' +
                                    '<span class="block">获得每日3次投票机会</span>' +
                                    '</p>' +
                                    '<img src="'+url+'" alt="赛普健身社区">' +
                                    '</div>',
                                    btn:false,
                                    success: function(layero,index){
                                        $(".codeW_layer_success .Wjump").click(function(){
                                            layer.closeAll();
                                        })
                                    }
                                });
                            }else{
                                layer.msg('网络错误');
                            }
                        }
                    })
                }else{
                    $(e).removeClass('disabled');
                    layer.msg(res.message);
                }
            }
        });
    }
    localStorage.removeItem('has_page');
    var page = 2;
    var flag = 1;
//    window.onload = function(){
//        //运行瀑布流主函数
//        PBL('pu_wrap','box');
//        //模拟数据
//        var data = [
//            /*	{'src':'1.jpg','title':'素素素素'},
//             {'src':'2.jpg','title':'素素素素'},
//             {'src':'3.jpg','title':'素素素素'},
//             {'src':'4.jpg','title':'素素素素'},
//             {'src':'5.jpg','title':'素素素素'},
//             {'src':'6.jpg','title':'素素素素'},
//             {'src':'7.jpg','title':'素素素素'},
//             {'src':'8.jpg','title':'素素素素'},
//             {'src':'9.jpg','title':'素素素'},
//             {'src':'10.jpg','title':'素素素'}*/
//        ];
//
//
//        //设置滚动加载
//
//        window.onscroll = function(){
//            //校验数据请求
//            if(getCheck()){
//                var data = {page:page,type:'page'};
//                page++;
//                if(flag == 1){
//                    $.ajax({
//                        url:'/jdt/active/vote1',
//                        data:data,
//                        type:'GET',
//                        dataType:'json',
//                        success:function(res){
//                            console.log(res);
//                            if(res.code == 0){
//                                if(res.data.body != ''){
//                                    $("#pu_wrap .am-gallery-overlay").append(res.data.body);
//                                }else{
//                                    flag = 0;
//                                }
//
//                                PBL('pu_wrap','box');
//                            }
//                        }
//                    });
//                }
//
//
//            }
//        }
//    }

//    function PBL(pu_wrap,box){
//        //	1.获得外层以及每一个box
//        var pu_wrap = document.getElementById(pu_wrap);
//        var boxs  = getClass(pu_wrap,box);
//        //	2.获得屏幕可显示的列数
//        var boxW = boxs[0].offsetWidth;
//        var colsNum = Math.floor(document.documentElement.clientWidth/boxW);
//        pu_wrap.style.width = boxW*colsNum+'px';//为外层赋值宽度
//        //	3.循环出所有的box并按照瀑布流排列
//        var everyH = [];//定义一个数组存储每一列的高度
//        for (var i = 0; i < boxs.length; i++) {
//            if(i<colsNum){
//                everyH[i] = boxs[i].offsetHeight;
//            }else{
//                var minH = Math.min.apply(null,everyH);//获得最小的列的高度
//                var minIndex = getIndex(minH,everyH); //获得最小列的索引
//                getStyle(boxs[i],minH,boxs[minIndex].offsetLeft,i);
//                everyH[minIndex] += boxs[i].offsetHeight;//更新最小列的高度
//            }
//        }
//    }
    /**
     * 获取类元素
     * @param  warp		[Obj] 外层
     * @param  className	[Str] 类名
     */
    function getClass(pu_wrap,className){
        var obj = pu_wrap.getElementsByTagName('*');
        var arr = [];
        for(var i=0;i<obj.length;i++){
            if(obj[i].className == className){
                arr.push(obj[i]);
            }
        }
        return arr;
    }
    /**
     * 获取最小列的索引
     * @param  minH	 [Num] 最小高度
     * @param  everyH [Arr] 所有列高度的数组
     */
    function getIndex(minH,everyH){
        for(index in everyH){
            if (everyH[index] == minH ) return index;
        }
    }
    /**
     * 数据请求检验
     */
    function getCheck(){
        var documentH = document.documentElement.clientHeight;
        var scrollH = document.documentElement.scrollTop || document.body.scrollTop;
        return documentH+scrollH>=getLastH() ?true:false;
    }
    /**
     * 获得最后一个box所在列的高度
     */
    function getLastH(){
        var pu_wrap = document.getElementById('pu_wrap');
        var boxs = getClass(pu_wrap,'box');
        return boxs[boxs.length-1].offsetTop+boxs[boxs.length-1].offsetHeight;
    }
    /**
     * 设置加载样式
     * @param  box 	[obj] 设置的Box
     * @param  top 	[Num] box的top值
     * @param  left 	[Num] box的left值
     * @param  index [Num] box的第几个
     */
    var getStartNum = 0;//设置请求加载的条数的位置
    function getStyle(box,top,left,index){
        if (getStartNum>=index) return;
        $(box).css({
            'position':'absolute',
            'top':top,
            "left":left,
            "opacity":"1"
        });
        $(box).stop().animate({
            "opacity":"1"
        },999);
//        getStartNum = index;//更新请求数据的条数位置
    }

    $(".lapiao").click(function(){
//        alert($(this).attr('data-id'));
        var id = $(this).attr('data-id');
        var _token = '{{csrf_token()}}';
        var data = {id:id,_token:_token};
        $.ajax({
            url:'/jdt/active/pullTicket',
            data:data,
            type:'POST',
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    var url = res.data.shareCode;
                    layer.open({
                        type: 1,
                        title: false, //不显示标题栏
                        skin: 'canvassing_layer', //样式类名
                        id: 'canvassing_layer', //设定一个id，防止重复弹出
                        closeBtn: 1, //不显示关闭按钮
                        anim: 2,
                        shadeClose: true, //开启遮罩关闭
                        area: ['90%', '80%'],
                        content: '<div class="canvassing_layer text_center tan-font"><img src="'+url+'" class="bm_success" alt="" /><p class="fz f26 ptb20">长按图片并将图片保存到相册</p></div>',
                        btn: false
                    });

                }
            }
        })
    });

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
    var title = '“TRAIN TO WIN”大奖在线投票';
    var desc = '我正在参加TRAIN TO WIN大赛，快来为我投票吧！';
    var share_img = "http://m.saipubbs.com/images/zt/just_do_it/share.png";
    var url = "http://m.saipubbs.com/jdt/active/vote";
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img // 分享图标

        }, function(res) {
            //这里是回调函数

        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: title, // 分享标题
            link: url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img // 分享图标

        }, function(res) {
            //这里是回调函数

        });
    });
    //弹窗
    $(function (){
        var date = new Date();
        Y = date.getFullYear();
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1);
        D = date.getDate() < 10? '0'+(date.getDate()): date.getDate();
        var dateTime = Y+''+M+''+D;
        //弹窗
        $('.ad_img_img').click(function(){
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'bm_success_layer_wrap homge_layer_toupiao', //样式类名
                id: 'bm_success_layer', //设定一个id，防止重复弹出
                closeBtn: 1, //不显示关闭按钮
                anim: 2,
                shadeClose: true, //开启遮罩关闭
                area: ['80%', '70%'],
                content:$('.bm_success_layer_wrap'),
                btn:false
            });
        })
        // 点击x关闭
        $('.img_close').click(function() {
            $(this).hide();
            $(".ad_img_img").hide();
            localStorage.setItem('subscribe_'+dateTime, 1);
        });
        var subscribe = localStorage.getItem('subscribe_'+dateTime);
        var isShow    = "{{$subscribe}}";
        if(isShow==0){
            $(".ad_code").show();
        }
        if(subscribe==1){
            $(".ad_code").hide();
        }
    })
</script>
<!-- 瀑布流 -->
<script src="/lib/pbl/minigrid.js"></script>
{{--<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>--}}
<script>
    var t_img; // 定时器
    var isLoad = true; // 控制变量
    (function () {
        //瀑布流图片代码

        var i = 0,
                sum;
        var page = 2;
        //瀑布流加载图片
        function load() {
            create();
        }

        //生成一张图片
        //判断图片加载完成后

        function create(oDiv) {
            //生成一个div盒子对象
//            var oDiv = document.createElement("div");
//            oDiv.className = "grid-item";
//            /*//生成一个图片对象
//             var oImg = new Image();
//             oImg.src = img_src[i%img_src.length].src;
//             //把图片放入div盒子
//             oDiv.appendChild(oImg);*/
//
//
//
//            //创建info
//            var info = document.createElement('div');
//            info.className = 'info';
//            oDiv.appendChild(info);
//            //创建pic
//            var pic = document.createElement('div');
//            pic.className = 'pic';
//            info.appendChild(pic);
//            //创建img
//            var oImg = document.createElement('img');
//            oImg.src = '../../images/zt/just_do_it/zipaijiantu/' + data[i % data.length].src;
//            oImg.style.height = 'auto';
//            pic.appendChild(oImg);
//            //创建title
//            var title = document.createElement('div');
//            title.className = 'title';
//            info.appendChild(title);
//            //创建a标记
//            var a = document.createElement('a');
//            a.innerHTML = data[i % data.length].title;
//            title.appendChild(a);
//
//
//            //把div放入大盒子
//            $(".grid").append(oDiv);
//            minigrid('.grid', '.grid-item');


//            if(getCheck()){
                var key  = "{{$key}}";
                var data = {page:page,type:'page', key:key};
//                page++;
                $.ajax({
                    url:'/jdt/active/vote',
                    data:data,
                    type:'GET',
                    async:false,
                    dataType:'json',
                    success:function(res){
                        console.log(res);
                        if(res.code == 0){
                            if(res.data.body != ''){
                                $(".pbl_wrap .grid").append(res.data.body);
                                minigrid('.grid', '.grid-item');
                                var oImg = $('.grid .grid-item .pic img');
                                (function (oImg) {
                                    setTimeout(function () {
                                        oImg.css({opacity:1,transform:"scale(1)"});
                                    }, 100);
                                })(oImg); //立马调用
                            }else{

                            }
                            page++;
                        }
                    }
                });
//            }
        }

        //滚动滚动条的时候调用的事件
        var scrollH = ''; //文档高度
        var scrollT = ''; //滚动条高度
        var _height = $(window).height();
        $(window).scroll(function () {
//            alert(3);
            scrollH = document.body.scrollHeight;
            scrollT = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;
            //console.log(_height + " a " + scrollT + " b " + 150 + "  " + scrollH)
//            if(getCheck()){
//
//            }
//            console.log(scrollH,scrollT);
            if (_height + scrollT +100 > scrollH) {
                load();
//                minigrid('.grid', '.grid-item');
            }
        });

//        load();
        setTimeout(function () {
            minigrid('.grid', '.grid-item', 0, null,
                    function () {
                        var d = document.querySelector('.pbl_wrap');
                        d.style.opacity = 1;
                    }
            );
        }, 100);

        window.addEventListener('resize', function () {
            minigrid('.grid', '.grid-item');
        });
//        var $grid = $('.grid');
//        $grid.masonry({
////            fitWidth: true,
////            initLayout: false,
//            itemSelector: '.grid-item',
//            columnWidth: '.grid-item'
////            percentPosition: true
//        });
//
//// 判断图片加载状况，加载完成后回调
//        isImgLoad(function () {
//            // 加载完成
//            $grid.masonry('layout');
//        });

// 判断图片加载的函数

    })();
    function isImgLoad(callback) {
//        alert(isLoad);
        // 注意我的图片类名都是cover，因为我只需要处理cover。其它图片可以不管。
        // 查找所有封面图，迭代处理
        $('.pbl_wrap img').each(function () {
            // 找到为0就将isLoad设为false，并退出each
            if (this.height === 0) {
                isLoad = false;
                return false;
            }
        });
        // 为true，没有发现为0的。加载完毕
        if (isLoad) {
            clearTimeout(t_img); // 清除定时器
            // 回调函数
            callback();
            // 为false，因为找到了没有加载完成的图，将调用定时器递归
        } else {
            isLoad = true;
            t_img = setTimeout(function () {
                isImgLoad(callback); // 递归扫描
            }, 500); // 我这里设置的是500毫秒就扫描一次，可以自己调整
        }
    }
</script>
</body>
</html>






