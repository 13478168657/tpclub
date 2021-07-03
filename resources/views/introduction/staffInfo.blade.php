<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普员工中心</title>
    <meta name="author" content="啾啾" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />

    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" >

    <!--本css-->
    <link rel="stylesheet" href="/css/zt/zt_zhuanjieshao.css?t={{time()}}">

    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
</head>
<body>

<!--nav start-->
<div>
    <div class="nav-two-det clearfix plr30 box-show-000">
        <div class="fl nav-left">
            <img class="d-in-black mr30" src="/images/zt/zhuanjieshao/logo.png" alt="">
            <img class="d-in-black" src="/images/zt/zhuanjieshao/1.png" alt="" />
        </div>
        <p class="fr text_right color_ffd700 f42 fz">赛普共创未来计划</p>
    </div>
</div>
<!--nav end-->


<!--list start-->
<div class="page2-list-partner color_fff">
    <div class="mlr30">
        <div class="plr30 ptb30 bg_383838 f28 mt30 box-show-000 mb30">
            <div class="weui-cell padding0 noafter nobefore mt0 fz">
                <div class="weui-cell__bd"><p>转介绍人数量</p></div>
                <div class="weui-cell__ft color_fff">{{$partnerNum}}人</div>
            </div>
            <div class="weui-cell padding0 noafter nobefore mt0 fz">
                <div class="weui-cell__bd"><p>资源跟单数量</p></div>
                <div class="weui-cell__ft color_fff">{{$gendan}}人</div>
            </div>
            <div class="weui-cell padding0 noafter nobefore mt0 fz">
                <div class="weui-cell__bd"><p>资源预定数量</p></div>
                <div class="weui-cell__ft color_fff">{{$yuding}}人</div>
            </div>
            <div class="weui-cell padding0 noafter nobefore mt0 fz">
                <div class="weui-cell__bd"><p>资源入学数量</p></div>
                <div class="weui-cell__ft color_fff">{{$ruxue}}人</div>
            </div>
        </div>
        <div class="fz">
            <ul>
                <li>
                    @if(!empty($newSource))
                    <p class="ptb30 f30">新资源</p>
                    @endif
                    @foreach($newSource as $source)
                    <div class="plr30 ptb30 bg_383838 box-show-000 f30 mb30">
                        <div class="weui-cell padding0 noafter nobefore mt0 fz">
                            <div class="weui-cell__bd"><p>学员姓名</p>{{$source['name']}}</div>
                            <div class="weui-cell__ft color_F66558 f28">{{$source['status']}}</div>
                        </div>
                        <div class="weui-cell padding0 noafter nobefore mt0 fz">
                            <div class="weui-cell__bd"><p>{{$source['mobile']}}</p></div>
                            <!--<div class="weui-cell__ft color_fff f28">10人</div>-->
                        </div>
                        <div class="weui-cell padding0 noafter nobefore mt0 fz">
                            <div class="weui-cell__bd"><p>转介绍人：{{introduction_person($source['person'])}}</p></div>
                            <div class="weui-cell__ft color_fff f28 bold">{{$source['time']}}</div>
                        </div>
                    </div>
                    @endforeach
                </li>
                <li>
                    @if($sysSource)
                    <p class="ptb30 f30">系统已有资源</p>
                    @endif
                    @foreach($sysSource as $sys)
                    <div class="plr30 ptb30 bg_383838 box-show-000 f30 mb30">
                        <div class="weui-cell padding0 noafter nobefore mt0 fz">
                            <div class="weui-cell__bd"><p>学员姓名</p>{{$sys['name']}}</div>
                            <div class="weui-cell__ft f28 color_F66558">{{$sys['status']}}</div>
                        </div>
                        <div class="weui-cell padding0 noafter nobefore mt0 fz">
                            <div class="weui-cell__bd"><p>{{$sys['mobile']}}</p></div>
                            <!--<div class="weui-cell__ft color_fff f28">10人</div>-->
                        </div>
                        <div class="weui-cell padding0 noafter nobefore mt0 fz">
                            <div class="weui-cell__bd"><p></p></div>
                            <div class="weui-cell__ft color_fff f28 bold">{{$sys['time']}}</div>
                        </div>
                    </div>
                    @endforeach
                </li>
            </ul>
        </div>
        <img src="/images/zt/zhuanjieshao/11.png" alt="">
    </div>

</div>
<!--list end-->



<!--弹出的内容 start-->
<div class="pop_form_success_layer text_center zhuan-img-pop  aa hide">
    <img src="/images/zt/zhuanjieshao/1.png" class="bm_success mt26" alt="" />
    <p class="fz color_ffd700 f36 ptb20">赛普共创未来计划</p>
    <div class="form fz">
        <div class="input mb40">
            <input type="text" placeholder="请输入手机号" class="border-radius-img f30">
            <p class="color_fff f26 ptb13">请使用员工入职留电手机号</p>
        </div>
        <a href="javascript:void (0)" class="pop-btn-a bg_ffd700 color_4a fz f26 plr45 border-radius-img ">确认加入</a>
    </div>
</div>
<!--弹出的内容 end-->


<div>
    <!--悬浮btn start-->
    <!-- <div class="text_center relative">
        <a href="javascript:void (0)" class="btn-pos block bg_ffd700 color_222 f28 fz pop-recruit">点击招募合伙人</a>
    </div> -->
    <div class="w50btn clearfix bg_ffd700 text_center" >
        <a href="/intro/partner/{{$staff_id}}.html" class="color_222 f28 fz ">分享好友链接</a>
        <a href="javascript:void (0)" class="color_222 f28 fz pop-recruit">分享朋友圈海报</a>
    </div>
    <!--悬浮btn end-->
</div>

<!--弹出图片内容 start-->
<!--悬浮弹出内容 start-->
<div class="fix-pop-list jiugongge-con text_center bg_000 hide">
    <div class="">
        {{--<p class="bg_ffd700 f34 fz tit">推广用图</p>--}}
        <p class="text-jus text_left fz color_fff ptb30 plr30 f26">请使用该素材作为推广用素材，共24张。长按图片即可下载。</p>
    </div>

    <div class="jiugongge-list-img">
        <ul class="clearfix">
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/0.png" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/all-1.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/all-2.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/all-3.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/all-4.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/all-5.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/all-6.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/all-7.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/all-8.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/jun-1.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/jun-2.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/jun-3.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/jun-4.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/jun-5.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/jun-6.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/jun-7.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/jun-8.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/active-1.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/active-2.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/active-3.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/active-4.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/active-5.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/active-6.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/active-7.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/active-8.jpg" alt=""></a></li>
        </ul>
    </div>

</div>
<!--悬浮弹出内容 end-->

<!--悬浮弹出内容 start-->
<div class="fix-pop-list jiugongge-con2 text_center bg_000 hide">
    <div class="">
        <p class="bg_ffd700 f34 fz tit">推广用图</p>
        <p class="text-jus text_left fz color_fff ptb30 plr30 f26">请使用该素材作为推广用素材，共8张。长按图片即可下载。</p>
    </div>

    <div class="jiugongge-list-img">
        <ul class="clearfix">
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/0.png" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/jun-1.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/jun-2.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/jun-3.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/jun-4.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/jun-5.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/jun-6.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/jun-7.jpg" alt=""></a></li>
            <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/jun-8.jpg" alt=""></a></li>
        </ul>
    </div>

</div>
<!--悬浮弹出内容 end-->
<!--弹出图片内容 end-->



<br><br><br>
<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<!-- Swiper JS -->
<script src="/lib/swiper/swiper.min.js"></script>
<script>
    var src = '';
    //给本页面加背景颜色
    $('body').css('background-color','#222222');

    //弹出
    $(function (){

        //弹出图片
        $('.pop-recruit').click(function(){
            if(src != ''){
                layer.open({
                    type: 1,
                    title: false, //不显示标题栏
                    skin: 'pop_from_layer_wrap2', //样式类名
                    id: 'pop_from_layer2', //设定一个id，防止重复弹出
                    closeBtn: 1, //不显示关闭按钮
                    anim: 2,
                    shadeClose: true, //开启遮罩关闭
                    area: ['80%', '90%'],
                    content:src,
                    btn:false,
                    success: function(){
                        var swiper = new Swiper('.swiper-container', {
                            pagination: '.swiper-pagination',
                            nextButton: '.swiper-button-next',
                            prevButton: '.swiper-button-prev',
                            //initialSlide :2,//默认第二个
                            paginationClickable: true
                        });
                    }
                });
                return ;
            }
            var token = '{{csrf_token()}}';
            $.ajax({
                url:'/intro/poster',
                data:{_token:token},
                type:'POST',
                dataType:'json',
                success:function(res){
                    src = res.body;
                    layer.open({
                        type: 1,
                        title: false, //不显示标题栏
                        skin: 'pop_from_layer_wrap2', //样式类名
                        id: 'pop_from_layer2', //设定一个id，防止重复弹出
                        closeBtn: 1, //不显示关闭按钮
                        anim: 2,
                        shadeClose: true, //开启遮罩关闭
                        area: ['80%', '90%'],
                        content:res.body,
                        btn:false,
                        success: function(){
                            var swiper = new Swiper('.swiper-container', {
                                pagination: '.swiper-pagination',
                                nextButton: '.swiper-button-next',
                                prevButton: '.swiper-button-prev',
                                //initialSlide :2,//默认第二个
                                paginationClickable: true
                            });
                        }
                    });
                }
            });


        })
    })

    function loadPic(){
        window.location.href='/intro/load/pic';
    }

    function sucai(num){
        if(num == 1){
            layer.open({
                type: 1,
                title: '推广用图', //不显示标题栏
                skin: 'jiugongge_layer_wrap_9gg', //样式类名
                id: 'jiugongge_success_layer_9gg', //设定一个id，防止重复弹出
                closeBtn: 1, //不显示关闭按钮
                anim: 2,
                shade: [.8,'#222222'],
                shadeClose: true, //开启遮罩关闭
                area: ['80%', '70%'],
                content:$('.jiugongge-con'),
                btn:false
            });
        }
    }
</script>
<!--end-->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    var title = '';
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
    var desc    = '';
    var title   = '赛普转介绍人进阶计划';
    var link = 'http://m.saipubbs.com/intro/partner/{{$staff_id}}.html';
    var imgUrl = 'http://m.saipubbs.com/images/zt/share.png';
    var content = '';
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: imgUrl, // 分享图标
            success: function(){
                /*----分享获得赛普币end----*/
            },
            cancel:function(){

            }
        }, function(res) {
            //这里是回调函数

        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: title, // 分享标题
            link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: imgUrl, // 分享图标
            success: function(){


            },
            cancel:function(){

            }
        }, function(res) {
            //这里是回调函数

        });
    });
</script>
</body>
</html>