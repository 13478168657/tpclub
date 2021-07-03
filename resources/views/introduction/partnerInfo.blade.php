<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普转介绍人中心</title>
    <meta name="author" content="" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />

    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" >

    <!--本css-->
    <link rel="stylesheet" href="/css/zt/zt_zhuanjieshao.css">

    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
    <style>
        body{
            background: #000;
        }
    </style>
</head>
<body>


<div>
    <div class="box-show-000">
        <img src="/images/zt/zhuanjieshao/partner_img1.jpg" alt="">
    </div>
</div>
<!--list start-->
<div class="page2-list-partner color_fff">
    <div class="mlr30">
        <div class="plr30 ptb30 bg_383838 f28 mt30 box-show-000">
            <div class="weui-cell padding0 noafter nobefore mt0 fz">
                <div class="weui-cell__bd"><p>资源信息</p></div>
                <!-- <div class="weui-cell__bd"><p>推广收益</p></div> -->
                <div class="weui-cell__ft"><img src="/images/icon_install2.png" alt="" class="iconInsShezhi sub"></div>
            </div>
            <!-- <p class="text_center ptb30 color_ffd700 f50 fz mb10">1200<span>元</span></p> -->
            <div class="page4-list-top-num clearfix fz text_center f30">
                <span>跟单中{{$gendan}}人</span>
                <span>已预定{{$yuding}}人</span>
                <span>已入学{{$ruxue}}人</span>
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
                            <div class="weui-cell__bd"><p>转介绍人：{{$partnerName}}</p></div>
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
                            <div class="weui-cell__bd"><p>学员姓名</p>{{isset($sys['name'])?$sys['name']:''}}</div>
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
    </div>

</div>
<!--list end-->

<!--nav start-->
<div>
    <div class="box-show-000">
        <img src="/images/zt/zhuanjieshao/partner_img2.jpg" alt="">
    </div>
    <!-- <p class="fz color_fff plr30 ptb13 mb30 f24">当前转介绍政策：初级800 中级1200 高级2000 学员返500</p> -->
    <!-- <img class="plr30" src="/images/zt/zhuanjieshao/12.png" alt=""> -->
</div>
<!--nav end-->



<!--弹出的表单 身份证 银行卡 开户行 start-->
<div class="text_center zhuan-img-pop  yhk hide">
    <p class="fz color_ffd700 f36 mb30 pt70">账户信息</p>
    <div class="form form-page3 fz mlr30">
        <div class="input mb30">
            <input type="text" name="cardName" placeholder="请输入银行卡姓名" value="{{$introPerson->bank_username}}" class="border-radius-img f30">
        </div>
        <div class="input mb30">
            <input type="text" name="card" placeholder="请输入银行卡" class="border-radius-img f30" value="{{$introPerson->bank_card_number}}" />
        </div>
        <div class="input mb30">
            <input type="text" name="cardBank" placeholder="请输入开户行信息" class="border-radius-img f30" value="{{$introPerson->bank_info}}"  />
        </div>
        <a href="javascript:void (0)" class="pop-btn-a pop-btn-a-page3 bg_ffd700 color_4a fz f26 border-radius-img box-show-0004 cardInfo">提交</a>
    </div>
</div>
<!--弹出的表单 身份证 银行卡 开户行 end-->

<div>
    <div class="w50btn clearfix bg_ffd700 text_center">
        <a href="/intro/reserve/{{$partner_id}}.html" class="color_222 f28 fz ">分享好友链接</a>
        <a href="javascript:void (0)" class="color_222 f28 fz pop-recruit">分享朋友圈海报</a>
    </div>
</div>

<!--弹出图片内容 start-->
<!--悬浮弹出内容 start-->
<div class="fix-pop-list jiugongge-con text_center bg_000 hide">
    <div class="">
        <p class="bg_ffd700 f34 fz tit">推广用图</p>
        <p class="text-jus text_left fz color_fff ptb30 plr30 f26">请使用该素材作为推广用素材，共八张。长按图片即可下载。</p>
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
        </ul>
    </div>

</div>
<!--悬浮弹出内容 end-->

<!--悬浮弹出内容 start-->
<div class="fix-pop-list jiugongge-con2 text_center bg_000 hide">
    <div class="">
        <p class="bg_ffd700 f34 fz tit">推广用图</p>
        <p class="text-jus text_left fz color_fff ptb30 plr30 f26">请使用该素材作为推广用素材,共八张，长按图片即可下载。</p>
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

<div class="fix-pop-list jiugongge-con3 text_center bg_000 hide">
    <div class="">
        <p class="bg_ffd700 f34 fz tit">推广用图</p>
        <p class="text-jus text_left fz color_fff ptb30 plr30 f26">请使用该素材作为推广用素材,共八张，长按图片即可下载。</p>
    </div>

    <div class="jiugongge-list-img">
        <ul class="clearfix">
             <li><a href="javascript:void (0)"><img src="/images/zt/zhuanjieshao/list-img/0.png" alt=""></a></li>
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
<!--弹出图片内容 end-->
<!--右侧悬浮 【再次进入】start-->
<div class="right-Invitation text_center">
    <a href="javascript:void(0);" class="color_fff fz f30 plr25 bg_000 pop-zaiCiBtn">再次进入</a >
</div>
<!--右侧悬浮 【再次进入】end-->
<!--再次弹出  start-->
<div class="pop-zaiCiTc pb136 hide">
    <p class="plr45 pt105 fz f26 text-jus">为了方便以后查看邀请信息，申请成功后，关注微信公众号<span class="Color_770739 bold">【赛普健身社区】</span>，从菜单栏 <span class="Color_770739 bold">[了解赛普] -[转介绍人中心]</span> 通道查看自己的权益信息。</p >
    <img src="/images/qr.png" alt="" class="mt70">
</div>
<!--再次弹出  end-->
<br><br>
<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<!-- Swiper JS -->
<script src="/lib/swiper/swiper.min.js"></script>
<script>
    var src = '';
    //给本页面加背景颜色
    //$('body').css('background-color','#222222');

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
                    area: ['70%', '90%'],
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
            var flag = 1;
            $.ajax({
                url:'/intro/poster',
                data:{_token:token,flag:flag},
                type:'POST',
                dataType:'json',
                success:function(res) {
                    src = res.body;
                    layer.open({
                        type: 1,
                        title: false, //不显示标题栏
                        skin: 'pop_from_layer_wrap2', //样式类名
                        id: 'pop_from_layer2', //设定一个id，防止重复弹出
                        closeBtn: 1, //不显示关闭按钮
                        anim: 2,
                        shadeClose: true, //开启遮罩关闭
                        area: ['70%', '90%'],
                        content: res.body,
                        btn: false,
                        success: function () {
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
        });


        //弹窗
        $('.sub').click(function(){
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'pop_form_layer_sub_page3', //样式类名
                id: 'pop_form_success_layer_sub', //设定一个id，防止重复弹出
                closeBtn: 0, //不显示关闭按钮
                anim: 2,
                shade: [.5,'#222222'],
                shadeClose: true, //开启遮罩关闭
                area: ['80%', '60%'],
                content:$('.yhk'),
                btn:false
            });
        })
    });
    function loadPic(){
        window.location.href='/intro/load/pic';
    }
    function sucai(num){
        if(num == 1){
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'jiugongge_layer_wrap', //样式类名
                id: 'jiugongge_success_layer', //设定一个id，防止重复弹出
                closeBtn: 1, //不显示关闭按钮
                anim: 2,
                shade: [.8,'#222222'],
                shadeClose: true, //开启遮罩关闭
                area: ['80%', '70%'],
                content:$('.jiugongge-con'),
                btn:false
            });
        }else if(num==2){
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'jiugongge_layer_wrap', //样式类名
                id: 'jiugongge_success_layer', //设定一个id，防止重复弹出
                closeBtn: 1, //不显示关闭按钮
                anim: 2,
                shade: [.8,'#222222'],
                shadeClose: true, //开启遮罩关闭
                area: ['80%', '70%'],
                content:$('.jiugongge-con2'),
                btn:false
            });
        }else{
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'jiugongge_layer_wrap', //样式类名
                id: 'jiugongge_success_layer', //设定一个id，防止重复弹出
                closeBtn: 1, //不显示关闭按钮
                anim: 2,
                shade: [.8,'#222222'],
                shadeClose: true, //开启遮罩关闭
                area: ['80%', '70%'],
                content:$('.jiugongge-con3'),
                btn:false
            });
        }
    }

    $(document).on("click", ".cardInfo", function() {
        var cardName = $("input[name='cardName']").val();
        var card = $("input[name='card']").val();
        var cardBank = $("input[name='cardBank']").val();
        if(cardName == ''){
            layer.msg('请输入开户行姓名');
            return false;
        }
        if(!/^([1-9]{1})\d{12,20}$/.test(card)){
            layer.msg('请输入有效的银行卡号');
            return false;
        }
        if(cardBank == ''){
            layer.msg('请输入开户行地址');
            return false;
        }
        var data = {cardName:cardName,card:card,cardBank:cardBank,_token:'{{csrf_token()}}'};
        $.ajax({
            url:'/intro/partner/card',
            type:'POST',
            data:data,
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    layer.msg(res.message);
                }else{
                    layer.msg(res.message);
                }
            }
        });
    });
    //再次进入的弹出
    $('.pop-zaiCiBtn').click(function(){

        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'pop_zaiCi_layer_wrap2', //样式类名
            id: 'pop_zaiCi_layer2', //设定一个id，防止重复弹出
            closeBtn: 1, //不显示关闭按钮
            anim: 2,
            shadeClose: true, //开启遮罩关闭
            area: ['80%', '60%'],
            content:$('.pop-zaiCiTc'),
            btn:false
        });
    })
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
    var desc    = '';
    var title   = '赛普内部优惠报名通道';
    var link = 'http://m.saipubbs.com/intro/reserve/{{$partner_id}}.html';
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