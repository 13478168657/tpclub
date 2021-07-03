<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-打卡分享海报</title>
    <meta name="author" content="啾啾" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <!--mmenu.css start-->
    <!--end-->
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" />
    <!--本css-->
    <link rel="stylesheet" href="/css/fenxiaoliucheng_clock.css?t={{time()}}" >


    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
</head>
<body>

<!---导航右侧带导航弹出---->

<div><!--导航大盒子id=page 开始  【结束在最底部】-->




    <!--====================================本喵是分割线  喵喵~========================================================-->
    <div>
        <!--banner start-->
        <div class="dakabanner_bg color_fff fz">
            <p class="pb30 f26">点击“复制”带推荐语分享，完成打卡！</p>

            <!--推荐语 start-->
            <div class="tuijian_daka fz">
                <ul class="clearfix">
                    <li class="f26">
                        <textarea readonly class="color_fff copytxtcontent" >{{$disCourse->hotwords}}</textarea>

                        {{--<textarea readonly class="color_fff copytxtcontent hide" >你已经完成了今天的学习挑战快去打卡吧</textarea>--}}
                        {{--<textarea readonly class="color_fff copytxtcontent hide" >牙牙是猪猪</textarea>--}}
                    </li>
                    <li class="text_center bgcolor_fff color_333 f22">推荐语</li>
                </ul>
                <p class="f24 color_orange text_right mt20">
                    <span class="mr30 copy" onclick="">复制</span>
                    {{--<span class="change">换一条</span>--}}
                </p>
            </div>
            <!--推荐语 end-->
        </div>
        <!--banner end-->
        <!--====================================本喵是分割线  喵喵~========================================================-->
        <!--内容 start-->
        <div class="box2">
            <div class="box-con top-con">
                <div class=" mlr40 text_center border-radius-img  fz  bg_box-show">
                    <div class="bgcolor_fff relative pt105">
                        <img src="/images/clock/haibao-zhong.png" alt="" class="poimg">
                        <p class="f66 color_e8712e bold"><img src="/images/clock/t.jpg" alt="" class="t">恭喜你<img src="/images/clock/yuan.jpg" alt="" class="yuan"></p>
                        <p class="f28 color_333 ptb40">你已经完成了今天的学习挑战！<br>快去打卡吧～</p>
                    </div>
                    <img src="/images/clock/da-line.png" alt="">
                    <div  class="bgcolor_fff pb70">
                        <p class="pt40 f32">《{{$disClass->title}}》</p>
                        <p class="f32 ptb13">累计学习：<strong class="color_F59023 bold">{{$total}}次</strong></p>
                    </div>
                </div>

                <!--btn start-->

                <div class="btnda fz f34 text_center pb70 relative">
                    <a href="javascript:void (0)" class="bgcolor_orange border-radius-img kwg">分享</a >
                </div>

                <!--btn end-->
            </div>
            <br/>
        </div>
        <!--内容 end-->

    </div>

    <!--====================================本喵是分割线  喵喵~========================================================-->

</div><!--导航大盒子id=page 结束-->

<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/js/clipboard.min.js"></script>
<script>
    //复制
    var clipboard = new ClipboardJS('.copy', {
        target: function() {
            return document.querySelector('textarea');//class也可以{.copytxtcontent}
        }
    });
    clipboard.on('success', function(e) {

        layer.msg('已复制好，可粘贴');
    });
    clipboard.on('error', function(e) {

        layer.msg('您当前版本复制不了哦')
    });

    /*换一换*/
    var length = $('.tuijian_daka ul li').find('textarea').length;
    var index = 0;

//    alert(title);
//    $('.change').click(function(){
//        index = index + 1;
//        $('.tuijian_daka ul li').find('textarea').addClass('hide');
//        if(index == length){
//            index = 0;
//        }
//
//        $('.tuijian_daka ul li').find('textarea').eq(index).removeClass('hide');
//    });

    function closeAll(){

        layer.closeAll();
    }

    $(function () {
        //分享弹窗
        $('.kwg').click(function () {
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'bm_success_layer_wrap22', //样式类名
                id: 'bm_success_layer22', //设定一个id，防止重复弹出
                closeBtn: 0, //不显示关闭按钮
                anim: 2,
                shade:[0.7, '#000'],
                shadeClose: true, //开启遮罩关闭
                area: ['90%', '80%'],
                content:'<div class="bm_success_layer text_center tan-font color_fff f32 fz pt105 fx-img" ><img src="/images/fenxiang-j.png" class="bm_success down-arrow" id="dou" alt="" /><p class="pt105 color_fff f36 fz bold ">点击这里快去分享打卡吧！</p><p class="text_left pl135 pt70 pb30">1、点击“<img src="/images/more.png" alt="" class="d-in-black more-s">”</p><p class="text_left pl135">2、点击“<img src="/images/pyq.png" alt="" class="d-in-black more-s">”分享到朋友圈</p><p class="pt70 mt16 f36 bold mb10">分享成功</p><p class="f36 bold">即可记为打卡成功哦~</p></div>',
                btn: false

            });

        });
    })

    //分享箭头样式
    var i=0;
    $(document).ready(function(){
        setInterval('gaibian()',1000);
    });
    function gaibian(){
        if(i==0){
            i=1;
            $("#dou").removeClass("zhuan_left");
            $("#dou").addClass("zhuan_right");
        }else{
            i=0;
            $("#dou").addClass("zhuan_left");
            $("#dou").removeClass("zhuan_right");
        }
    }
</script>
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
    var class_id = '{{$class_id}}';
    var course_id = '{{$course_id}}';
    var dis_id = '{{$dis_id}}';
    var desc = '{{$disCourse->description}}';
    var title = '{{$disCourse->title}}';
    var user_id = '{{$user_id}}';
    var link = 'http://m.saipubbs.com/dist/poster/'+user_id+'/'+class_id+'/'+course_id+'.html';
    var imgUrl = '{{env('IMG_URL')}}/{{$disCourse->cover_url}}';
    var content = '';
    var data = {course_id:course_id,c_id:class_id,_token:'{{csrf_token()}}'};

    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: imgUrl, // 分享图标
            success: function(){
                layer.open({
                    type: 1,
                    title: false, //不显示标题栏
                    skin: 'daka_layer_wrap_s', //样式类名
                    id: 'daka_layer_s', //设定一个id，防止重复弹出
                    closeBtn: 0, //不显示关闭按钮
                    anim: 2,
                    shade:  [0.6, '#000'],
                    shadeClose: true, //开启遮罩关闭
                    area: ['80%', 'auto'],/*55%*/
                    content: '<div class="daka_layer_s pb30"><div class="container text_center pt40 mt20"><img src="/images/logo-s.png" alt=""><h3 class="f32 text_center fz color_333 bold mt10 mb30">打卡状态以朋友圈为准</h3><p class="f24 fz color_gray666">挑战结束后，</p ><p class="f24 fz color_gray666">老师会检查你的朋友圈记录</p ><div onclick="closeAll();" class="btnWrap  pb30"><a href="javascript:void(0);" class="btnnew f34 block fz mt32 bga border-radius50">好的，我已知</a ></div></div></div>',
                    btn: false
                });
                /*----分享获得赛普币start----*/
                $.ajax({
                    url:'/dist/postFinish',
                    data:data,
                    type:'POST',
                    dataType:'json',
                    success:function(res){
                        if(res.code == 0){

                        }else{

                        }
                    }
                });
                /*----分享获得赛普币end----*/
            },
            cancel:function(){
                layer.open({
                    type: 1,
                    title: false, //不显示标题栏
                    skin: 'daka_layer_wrap_s', //样式类名
                    id: 'daka_layer_s', //设定一个id，防止重复弹出
                    closeBtn: 0, //不显示关闭按钮
                    anim: 2,
                    shade:  [0.6, '#000'],
                    shadeClose: true, //开启遮罩关闭
                    area: ['80%', 'auto'],/*55%*/
                    content: '<div class="daka_layer_s pb30"><div class="container text_center pt40 mt20"><img src="/images/logo-s.png" alt=""><h3 class="f32 text_center fz color_333 bold mt10 mb30">打卡状态以朋友圈为准</h3><p class="f24 fz color_gray666">挑战结束后，</p ><p class="f24 fz color_gray666">老师会检查你的朋友圈记录</p ><div onclick="closeAll();" class="btnWrap  pb30"><a href="javascript:void(0);" class="btnnew f34 block fz mt32 bga border-radius50">好的，我已知</a ></div></div></div>',
                    btn: false
                });
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
                layer.open({
                    type: 1,
                    title: false, //不显示标题栏
                    skin: 'daka_layer_wrap_s', //样式类名
                    id: 'daka_layer_s', //设定一个id，防止重复弹出
                    closeBtn: 0, //不显示关闭按钮
                    anim: 2,
                    shade:  [0.6, '#000'],
                    shadeClose: true, //开启遮罩关闭
                    area: ['80%', 'auto'],/*55%*/
                    content: '<div class="daka_layer_s pb30"><div class="container text_center pt40 mt20"><img src="/images/logo-s.png" alt=""><h3 class="f32 text_center fz color_333 bold mt10 mb30">打卡状态以朋友圈为准</h3><p class="f24 fz color_gray666">挑战结束后，</p ><p class="f24 fz color_gray666">老师会检查你的朋友圈记录</p ><div onclick="closeAll();" class="btnWrap  pb30"><a href="javascript:void(0);" class="btnnew f34 block fz mt32 bga border-radius50">好的，我已知</a ></div></div></div>',
                    btn: false
                });
                /*----分享获得赛普币start----*/
                $.ajax({
                    url:'/dist/postFinish',
                    data:data,
                    type:'POST',
                    dataType:'json',
                    success:function(res){
                        if(res.code == 0){

                        }else{

                        }
                    }
                });
                /*----分享获得赛普币end----*/
            },
            cancel:function(){
                layer.open({
                    type: 1,
                    title: false, //不显示标题栏
                    skin: 'daka_layer_wrap_s', //样式类名
                    id: 'daka_layer_s', //设定一个id，防止重复弹出
                    closeBtn: 0, //不显示关闭按钮
                    anim: 2,
                    shade:  [0.6, '#000'],
                    shadeClose: true, //开启遮罩关闭
                    area: ['80%', 'auto'],/*55%*/
                    content: '<div class="daka_layer_s pb30"><div class="container text_center pt40 mt20"><img src="/images/logo-s.png" alt=""><h3 class="f32 text_center fz color_333 bold mt10 mb30">打卡状态以朋友圈为准</h3><p class="f24 fz color_gray666">挑战结束后，</p ><p class="f24 fz color_gray666">老师会检查你的朋友圈记录</p ><div onclick="closeAll();" class="btnWrap  pb30"><a href="javascript:void(0);" class="btnnew f34 block fz mt32 bga border-radius50">好的，我已知</a ></div></div></div>',
                    btn: false
                });
            }
        }, function(res) {
            //这里是回调函数

        });
    });
</script>
</body>
</html>
