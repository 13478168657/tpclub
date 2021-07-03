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
    <title>赛普社区-新人礼包</title>
    <meta name="author" content="涵涵" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="/css/swiper.min.css">
    <!--mmenu.css start-->
    <link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
    <link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
    <link href="/css/nav-mmenu-public.css" rel="stylesheet" />
    <!--end-->

    <!--jqweui css-->
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <!--end -->

    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" >

    <!--本css-->
    <link rel="stylesheet" href="/css/zt/zt_yeargift.css" >


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
                        <li><a href="/login">登录</a></li>
                    @endif
                @endif
            </ul>
        </div>
    </nav>
    <!--头部导航 end-->

    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--banner start-->
    <img src="/images/gift-banner.png" alt="">
    <!--banner end-->
    <!--====================================本喵是分割线  喵喵~========================================================-->
    <!--我是灰色的线-->
    <div class="solidtop20"></div>

    <!--列表 start-->
    <div class="bgcolor_gray">
        <div class="mlr20 bgcolor_fff border-radius-img plr30 list">
            <div class="text_center mb20 mt70">
                <span class="f34 fz color_333 ptb13 d-in-black bgcolor_orange pl20 pr20 border-radius50">• 私教必备入门课程 •</span>
            </div>
            <ul>
                @foreach($courses as $class)
                <li class="ptb40">
                    <dl class="clearfix">
                        <dt class="border-radius-img"><a href="javasript:void(0)" class="d-in-black"><img src="{{env('IMG_URL')}}{{$class->cover_url}}" alt="" /></a></dt>
                        <dd>
                            <?php
//                                dd(mb_strlen($class->title,'utf-8')>15?mb_substr($class->title,0,15).'...':$class->title);
                            ?>
                            <a href="javascript:void (0)" class="d-in-black"><h3 class="lt text-overflow">{{mb_strlen($class->title,'utf-8')>15?mb_substr($class->title,0,13).'...':$class->title}}</h3></a>
                            <p class="fz color_gray666">{{sum_course($class->id)->count}} 节课·{{sum_study($class->id)->count}} 人正在提高中</p>
                            <div class="weui-cells fz color_gray666 noafter nobefore mt0 ">
                                <div class="weui-cell">
                                    <div class="weui-cell__bd">
                                        <p class="color_4a">{{$class->author->name}} 导师</p>
                                    </div>
                                    <?php
                                    if($class->is_free == 0){
                                        $priceSet = '免费';
                                    }else{
                                        $priceSet = $class->price.'元';
                                    }
                                    ?>
                                    <div class="weui-cell__ft color_orange bold">{{$priceSet}}</div>
                                </div>
                            </div>

                            <div class="text_center fz">
                                <!-- Swiper -->
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach($class->courseTag as $tags)
                                            <?php

                                                $tag =  $tag = App\Models\Tags::where('id',$tags->tag_id)->select('title')->first();
                                            ?>
                                        <div class="swiper-slide"><a class="color_gray666" href="javascript:void (0)">{{$tag->title}}</a></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </dd>
                    </dl>
                </li>
                @endforeach
            </ul>
        </div>

    </div>
    <!--列表 end-->

    <!--我是灰色的线-->
    <div class="solidtop20"></div>
    <!--====================================本喵是分割线  喵喵~========================================================-->


    <h2 class="lt f52 color_333 text_center pt105 mt32">注册赛普健身社区</h2>
    <p class="fz f36 color_333 mt16 text_center">免费学习价值168元课程</p>

    <!--表单 start-->
    <div class="bgcolor_f9f9f9 mt70 border-radius-img mlr30 mb40">
        <div class="plr45 pb136">
            <!------------------------------------------------------------------------------>
            <!--注册-->
            <div class="clearfix  pt70">
                <h2 class="fl lt f40 color_gray666 text_center ">注册</h2>
                <a href="/login" class="fr d-in-black  f26 color_gray666 fz ">已有账户登录></a>
            </div>
            <div class="form fz f24 clearfix mb30  pt40">
                <ul>
                    <li>
                        <div class="input">
                            <input type="text" id="tel" placeholder="请输入您的手机号码" class="input border-radius-img f30  fz bgcolor_fff mb30">
                            <p class="text_left mobile_error tip"></p>
                        </div>
                    </li>
                    <li>
                        <div class="input clearfix">
                            <input type="text" id="code" placeholder="请输入您的验证码" class="input border-radius-img f30  fz bgcolor_fff mb30 yzm fl">
                            <span class="vcodeBtn yzm-huoqu fr bgcolor_orange border-radius-img text_center f28 color_333">获取验证码</span>
                        </div>
                        <p class="text_left code_error tip"></p>
                    </li>
                    <li>
                        <div class="input">
                            <input type="password" id="password" placeholder="请输入6-20位密码" class="input border-radius-img f30  fz bgcolor_fff mb30">
                            <p class="text_left pass_error tip"></p>
                        </div>
                    </li>
                </ul>

                <!--按钮-->
                <button onclick="userRegister();"
                        class="border-radius-img btn  color_333 f34 fz bgcolor_orange text_center  mt30">注册领取课程
                </button>
            </div>
        </div>

    </div>
    <!--表单 end-->

    <!--====================================本喵是分割线  喵喵~========================================================-->



</div><!--导航大盒子id=page 结束-->



<br><br>
<script src="/lib/jquery-2.1.4.js"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script src="/js/js.js"></script>
<script>
    //播放视频
    $(function (){
        //播放视频
        $('.video .box2').click(function(){
            $(this).hide();
            $(this).next().trigger('play');

        })
    })

</script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->

<!-- Swiper JS -->
<script src="/js/swiper.min.js"></script>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 'auto',
        leftedSlides: true,
        spaceBetween: 10,
        grabCursor: true
    });


</script>
<script>
    $(function(){
        //发送验证码
        $('.vcodeBtn').click(function (){

            var tel = $('#tel').val();
            if(!tel || !/1[3-9]{1}[0-9]{9}$/.test(tel)){
                layer.msg('请输入有效的手机号码');
            }else{
                settime($('.vcodeBtn'),60);
                var token = '{{csrf_token()}}';
                var mobile = $("#tel").val();
                var data = {mobile:mobile,_token:token};
                $.ajax({
                    url:'/send/acode',
                    type:'POST',
                    data:data,
                    dataType:'json',
                    success:function(res){
                        if(res.code == 1){
                            settime($('.vcodeBtn'),60);
                            layer.msg(res.message);
                        }else{
                            layer.msg(res.message);
                        }
                    }
                });
            }
        })

    });
    function userRegister(){

        var mobile = $("#tel").val();
        var token = '{{csrf_token()}}';
        var code = $('#code').val();
        var password = $('#password').val();

        if(!mobile || !/1[3-9]{1}[0-9]{9}$/.test(mobile)){
            $(".mobile_error").text('请输入有效的手机号码');
            return false;
        }else{
            $(".mobile_error").text('');
        }
        if(!code){
            $(".code_error").text('请输入正确的验证码');
            return;
        }else{
            $(".code_error").text('');
        }
        if(password.length < 6 || password.length > 20){
            $(".passwd_error").text('密码必须在6-20位字符之间');
            return;
        }else{
            $(".passwd_error").text('');
        }
        var fission_id = localStorage.getItem('fission_id');
        var share_id = '';
        if(fission_id != '' || fission_id != null){
            var share_id = fission_id;
        }
        var channel = localStorage.getItem('channel');
        if(channel == '' || channel == null){
            var channel = '';
        }
        var op = $("input[name='openid']").val();
        var data = {mobile:mobile,verifyCode:code,password:password,_token:token,op:op,share_id:share_id,channel:channel};
        $.ajax({
            url:'/user/register',
            type:'POST',
            data:data,
            dataType:'json',
            success:function(data){
                if(data.code == 0){

                    var url = localStorage.getItem('redirect');
                    layer.msg('注册成功');
                    if(url !='' && url != null){
                        localStorage.removeItem('redirect');
                        window.location.href = url;
                    }else{
                        window.location.href = '/';
                    }

                    gio('track', 'register');   //growing  统计代码注册数加1
                }else if(data.code == 1){
                    $(".code_error").text(data.message);
                }else if(data.code == 2){
                    $(".mobile_error").text(data.message);
                }else if(data.code == 3){
                    $(".passwd_error").text(data.message);
                }else if(data.code == 4){
                    $(".mobile_error").text(data.message);
                }else if(data.code == 5){
                    $(".mobile_error").text(data.message);
                }
            }
        });
    }
</script>
</body>
</html>
