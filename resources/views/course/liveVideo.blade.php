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
    <title>赛普社区-视频详情页{{env('WEB_TITLE_COURSE')}}</title>
    <meta name="author" content="赛普课堂" />
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
    <link href="/css/font-num40.css" rel="stylesheet" >

    <!--文章下css-->
    <link rel="stylesheet" href="/css/video.css">


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
        <div class="text_center fz nav-a">
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



    <div class="plr30"><!--边距30 开始-->

        {{--<div id="live" style="width:100%;height:200px;"><img style="width:100%;height:200px;" src="{{env('IMG_URL')}}{{$data->explain_url}}"/></div>--}}
        @if($data->is_live)
            <div id="video" style="width:100%;height:200px;"><img style="width:100%;height:200px;" src="{{env('IMG_URL')}}{{$data->explain_url}}"/></div>
        @else
            <div id="video" style="width:100%;height:200px;"></div>
        @endif

        <!--课程视频列表 start-->
        <div class="pt40 pb15">
            <div class="weui-cell left0 padding0 ">
                <div class="weui-cell__bd">
                    <h2 class="f30 bold">课程目录</h2>
                </div>
            </div>
            <!-- Contenedor -->
            <ul id="accordion" class="accordion">
                @foreach($array as $k=>$v)
                    @if($data->is_free==0 || is_baoming($data->id,$userid) == 1 || expericence_card_isture($data->course_type_id,$userid) == 1)
                        <li  class="f28 {{$k==0?"default open":"fz"}}">
                            <div class="link"><span class="pr20 color_gray666">{{($k+1)<10?'0'.($k+1):$k+1}}</span>{{$v->title}}<i class="fa-chevron-down"></i></div>
                            <ul class="submenu">
                                @foreach($v->course as $course)
                                <?php
                                    $colorFlag = 0;
                                    if(time() > strtotime($course->live_end_time)){
                                        $colorFlag = 1;
                                    }
                                ?>
                                <li class="pt20" id="{{$course->id}}">
                                    @if($course->is_live && time() <= strtotime($course->live_end_time))
                                    <a href="{{env('POLY_LIVE_URL')}}{{$course->live_number}}">
                                    @elseif($course->is_live && time() > strtotime($course->live_end_time))
                                        @if(strpos($course->video_url,'video.saipubbs.com') === false)
                                            <a href="{{env('POLY_LIVE_URL')}}{{$course->live_number}}">
                                        @else
                                            <a onclick="aa('{{$course->video_url}}','{{$course->id}}');" id="player_{{$course->id}}">
                                        @endif
                                    @else
                                        <a onclick="aa('{{$course->video_url}}','{{$course->id}}');" id="player_{{$course->id}}">
                                    @endif
                                        <div style="background-color:rgba(222,222,222,0);" class="weui-cells nobefore noborder noafter padding0 mt0">
                                            <div class="weui-cell nobefore noborder noafter padding0 mt0">
                                                <div class="weui-cell__hd"><img src="/images/ico_video.png"></div>
                                                <div class="weui-cell__bd f28 {{$colorFlag?'color_c9c7c7':'color_333'}} fz">
                                                    <p class="text-overflow">{{$course->title}}</p>
                                                    <p class="fz color_gray9b f22">{{date('Y/m/d H:i',strtotime($course->live_start_time))}}~{{date('H:i',strtotime($course->live_end_time))}}<span class="pl20 ml20"></span></p>
                                                </div>
                                                @if(!$course->is_live && $course->preview)
                                                <div class="weui-cell__ft mr20 pt10 pb10 fz color_333 f20 text_center border-radius-img v-shiting">试听</div>
                                                @elseif($course->is_live && time()< strtotime($course->live_start_time))
                                                    <div class="weui-cell__ft mr20 pt10 pb10 fz color_333 f20 text_center border-radius-img v-shiting">待直播</div>
                                                @elseif($course->is_live && time() >= strtotime($course->live_start_time) && time() <= strtotime($course->live_end_time))
                                                    <div class="weui-cell__ft mr20 pt10 pb10 fz color_333 f20 text_center border-radius-img v-zhibozhong"><img src="/images/zhibozhong.gif" alt="">直播中</div>
                                                @elseif($course->is_live && time() > strtotime($course->live_end_time))
                                                    @if(strpos($course->video_url,'video.saipubbs.com') === false)
                                                    <div class="weui-cell__ft mr20 pt10 pb10 fz {{$colorFlag?'color_c9c7c7':'color_333'}} f20 text_center border-radius-img v-shiting">已结束</div>
                                                    @endif
                                                @elseif(!$course->is_live)

                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li  class="f28 {{$k==0?"default open":"fz"}}">
                            <div class="link"><span class="pr20 color_gray666">{{($k+1)<10?'0'.($k+1):$k+1}}</span>{{$v->title}}<i class="fa-chevron-down"></i></div>
                            <ul class="submenu">
                                @foreach($v->course as $course)
                                    <?php
                                        $colorFlag = 0;
                                        if(time() > strtotime($course->live_end_time)){
                                            $colorFlag = 1;
                                        }
                                    ?>
                                    <li class="pt20" id="{{$course->id}}">
                                        @if($course->is_live && time() >= strtotime($course->live_start_time) && time() <= strtotime($course->live_end_time))
                                            <a href="{{env('POLY_LIVE_URL')}}{{$course->live_number}}">
                                        @elseif($course->is_live && time()< strtotime($course->live_start_time))
                                             <a href="{{env('POLY_LIVE_URL')}}{{$course->live_number}}">
                                        @elseif($course->is_live && time() > strtotime($course->live_end_time))
                                             @if(strpos($course->video_url,'video.saipubbs.com') === false)
                                                  <a href="{{env('POLY_LIVE_URL')}}{{$course->live_number}}">
                                             @else
                                                  <a  onclick="aa('{{$course->video_url}}','{{$course->id}}');" id="player_{{$course->id}}">
                                             @endif
                                        @else
                                            @if($course->preview)
                                            <a  onclick="aa('{{$course->video_url}}','{{$course->id}}');" id="player_{{$course->id}}">
                                            @else
                                            <a class="no_preview" id="player_{{$course->id}}">
                                            @endif
                                        @endif
                                            <div style="background-color:rgba(222,222,222,0);" class="weui-cells nobefore noborder noafter padding0 mt0">
                                                <div class="weui-cell nobefore noborder noafter padding0 mt0">
                                                    <div class="weui-cell__hd"><img src="/images/ico_video.png"></div>
                                                    <div class="weui-cell__bd f28 {{$colorFlag?'color_c9c7c7':'color_333'}} fz">
                                                        <p class="text-overflow">{{$course->title}}</p>
                                                        <p class="fz color_gray9b f22">{{date('Y/m/d',strtotime($course->created_at))}}<span class="pl20 ml20">{{$course->live_long_time?$course->live_long_time.'min':''}}</span></p>
                                                    </div>
                                                    @if(!$course->is_live && $course->preview)
                                                        <div class="weui-cell__ft mr20 pt10 pb10 fz color_333 f20 text_center border-radius-img v-shiting">试听</div>
                                                    @elseif($course->is_live && time()< strtotime($course->live_start_time))
                                                        <div class="weui-cell__ft mr20 pt10 pb10 fz color_333 f20 text_center border-radius-img v-shiting">待直播</div>
                                                    @elseif($course->is_live && time() >= strtotime($course->live_start_time) && time() <= strtotime($course->live_end_time))

                                                        <div class="weui-cell__ft mr20 pt10 pb10 fz color_333 f20 text_center border-radius-img v-zhibozhong"><img src="/images/zhibozhong.gif" alt="">直播中</div>
                                                    @elseif($course->is_live && time() > strtotime($course->live_end_time))
                                                        <div class="weui-cell__ft mr20 pt10 pb10 fz {{$colorFlag?'color_c9c7c7':'color_333'}} f20 text_center border-radius-img v-shiting">已结束</div>
                                                    @elseif(!$course->is_live)

                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>




        </div>
        <!--课程视频列表 end-->


        @if($teacher->id!=$userid)
        <div class="weui-cells noafter nobefore mt0 art-det-con1 pb30">
            <div class="weui-cell weui-cell_access padding0 mtb15">
                <div class="weui-cell__hd border-radius50"><img src="{{env('IMG_URL')}}{{$teacher->avatar}}"></div>
                <div class="weui-cell__bd f26">
                    <p>{{$teacher->name}}</p>
                </div>
                @if($is_follow==1)
                    <div class="art-det-but bgcolor_orange f28 color_333 border-radius-img">已关注</div>
                @else
                    @if($mobile<1)
                        <div href="javascript:;" class="art-det-but bgcolor_orange f28 color_333 border-radius-img guanzhuBtn" data-user_id="{{$teacher->id}}" data-fans_id='{{$userid}}' onclick="userlogin()" data-is_follow='0' id="fans_id{{$userid}}">关注</div>
                    @else
                        <div href="javascript:;" class="art-det-but bgcolor_orange f28 color_333 border-radius-img guanzhuBtn" data-user_id="{{$teacher->id}}" data-fans_id='{{$userid}}' onclick="click_follow(this)" data-is_follow='0' id="fans_id{{$userid}}">关注</div>
                    @endif
                @endif

            </div>
        </div>
        @endif
    </div><!--边距30 结束-->

    <!--我是灰色的线-->
    <div class="solidtop20"></div>


    <!--小图list-->

    <!--小图 end-->

    <!--我是灰色的线-->
    <div class="solidtop20"></div>


    <div class="plr30"><!--边距30 开始-->


        <!-- 课程评价 start -->
        <!-- 文章评价列表 start -->
        @if($comment_one)
        <div class="page_evaluate bgc_white">
            <!-- 文章评价列表 start -->
            <div class="weui-cells nobefore  ">

                <div class="weui-cell left0 padding0 " id="head" >
                    <div class="weui-cell__bd">
                        <h2 class="f30 bold">评价</h2>
                    </div>
                </div>
                @foreach($comment_one as $comment)
                <div class="weui-cells pt30 pb30">
                    <div class="weui-cell evaluate padding0" data-id="1">
                        <div class="weui-cell__bd">
                            @if($comment && ($comment->users) && strpos($comment->users->avatar,'http') !== false)
                                <div class="user_photo"><img src="{{$comment->users->avatar}}" class="img100" /></div>
                            @elseif($comment && $comment->users)
                                <div class="user_photo"><img src="{{env('IMG_URL')}}{{$comment->users->avatar}}"  class="img100" /></div>
                            @else
                                {{--<img src="" alt="头像" class="img100"/>--}}
                            @endif
                            <dl>
                                @if($comment && $comment->users)
                                    <dt>{{$comment->users->name}} </dt>
                                @else
                                    <dt></dt>
                                @endif
                                <dd class="fz">{{App\Constant\CommentDate::getDate($comment->created_at)}}</dd>
                            </dl>
                            <p class="fz text-jus">{{$comment->content}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!-- 文章评价列表 end -->
        </div>


        <div class="text_center art-quanbu fz f26 color_gray666 mt30"><a href="/course/comments/{{$data->id}}.html">查看全部评价</a></div>


        @else
        <!--未评价=============================================================================-->
        <!--课程未评价 start-->
        <div class="start_weipingjia text_center">
            <div class="color_c9c7c7 fz f24 mt30 pt40">
                <img src="/images/shafa.png" alt="">
                <p class="mb40 pt10 pb30">沙发还没有人坐，请发言</p>
            </div>
        </div>
        @endif
        <!--课程未评价 end-->
    </div><!--边距30 结束-->




    <!--悬浮评价底部-->
    <div class="art-footer pj-ask-footer">
        <ul class="clearfix text_center">
            <li class="bgcolor_orange fz f34 color_333"><a href="javascript:;" class="open-popup" data-target="#full">评价</a></li>
            <li onclick="window.location.href='/course/comments/{{$data->id}}.html'" class="fz f20 check2"></li>
            <li onclick="window.location.href='/course/consultation/22.html'" class="fz f20 check"></li>
        </ul>
    </div>









</div><!--导航大盒子id=page 结束-->
<!-- 底部固定条 start -->
<div class="fixed_bar_bottom">
    <ul class="clearfix btnsWrap">
        @if(expericence_card_isture($data->course_type_id,$userid))
            <li class="studyBtn"><a href="javascript:;" id="cancel_studying">取消报名</a></li>
            <li class="consultBtn"><a href="/course/consultation/{{$data->id}}.html">立即咨询</a></li>
        @else

            @if($mobile == 0 && is_baoming($data->id,$userid)==0)
                @if($data->is_free==0)
                    <li class="studyBtn" onclick="userlogin()"><a href="javascript:;">免费报名</a></li>
                    <li class="consultBtn"><a href="/course/consultation/{{$data->id}}.html">立即咨询</a></li>
                @else
                    <li class="studyBtn open-popup" onclick="userlogin()">
                        <a href="javascript:;">立即学习¥{{$data->price}}</a>
                    </li>
                    <li class="consultBtn"><a href="/course/consultation/{{$data->id}}.html">立即咨询</a></li>
                @endif
            @else
                @if(is_baoming($data->id,$userid) == 1)
                    <li class="studyBtn"><a href="javascript:;" id="cancel_studying">取消报名</a></li>
                    <li class="consultBtn"><a href="/course/consultation/{{$data->id}}.html">立即咨询</a></li>
                @else
                    @if($data->is_free==0)
                        <li class="studyBtn"><a href="javascript:;" id="enroll">免费报名</a></li>
                        <li class="consultBtn"><a href="/course/consultation/{{$data->id}}.html">立即咨询</a></li>
                    @else
                        <li class="studyBtn open-popup" data-target="#half" id="studyBtn"><a>立即学习¥{{$data->price}}</a></li>
                        <li class="consultBtn"><a href="/course/consultation/{{$data->id}}.html">立即咨询</a></li>
                    @endif
                @endif
            @endif

        @endif
    </ul>
</div>
<!-- 底部固定条 end -->

<!-- 底部弹出popup start -->
<div id="half" class='weui-popup__container popup-bottom payType_popup'>
    <div class="weui-popup__overlay"></div>
    <div class="weui-popup__modal">
        <div class="toolbar">
            <div class="toolbar-inner">
                <a href="javascript:;" class="picker-button close-popup">关闭</a>
                <h1 class="title f28 fz">确认付款</h1>
            </div>
        </div>
        <div class="modal-content bgc_white">
            <div class="weui-cell  weui-cell">
                <div class="weui-cell__bd">
                    <h2 class="fs14 f28 fz">课程费用</h2>
                </div>
                <div class="weui-cell__ft">
                    <span class="price fz">{{$data->price}}元</span>
                </div>
            </div>
            <div class="weui-cells weui-cells_radio noafter fz f28">
                <label class="weui-cell weui-check__label" for="x11">
                    <div class="weui-cell__bd">
                        <p><i class="ico_wx "></i>微信支付</p>
                    </div>
                    <div class="weui-cell__ft">
                        <input type="radio" class="weui-check" name="radio1" id="x11" checked="checked">
                        <span class="weui-icon-checked"></span>
                    </div>
                </label>
                 @if($balance)
                    <label class="weui-cell weui-check__label" for="x12">
                @else
                    <label class="weui-cell weui-check__label disabled_article" for="x12">
                @endif
                
                    <div class="weui-cell__bd">
                        <p><i class="ico_balance"></i>余额支付</p>
                    </div>
                    <div class="weui-cell__ft">
                        <input type="radio" name="radio1" class="weui-check" id="x12">
                        <span class="weui-icon-checked"></span>
                    </div>
                </label>
                    @if($spb/100 > $data->price)
                    <label class="weui-cell weui-check__label" for="x13">
                @else
                    <label class="weui-cell weui-check__label disabled_article" for="x13">
                @endif
                    <div class="weui-cell__bd">
                        <p><i class="ico_spb"></i>{{$data->price * 100}}赛普币(已有{{$spb}}赛普币)</p>
                    </div>
                    <div class="weui-cell__ft">
                        <input type="radio" name="radio1" class="weui-check" id="x13" value="SPB">
                        <span class="weui-icon-checked"></span>
                    </div>
                </label>
            </div>
            <div class="container ptb20 fz f28 mlr30">
                <a href="javascript:void(0);" class="roy_btn bgcolor_orange payBtn">立即付款</a>
            </div>
        </div>
    </div>
</div>
<!-- 底部弹出popup end -->

<div id="full" class='weui-popup__container bgc_white page_evaluate_form'>
    <div class="weui-popup__overlay"></div>
    <div class="weui-popup__modal bgc_white">
        <!-- 头部条 start -->
        <header class="header_bar max640 bgc_white relative">
            {{--<a href="javascript:history.go(-1);" class="btn_back close-popup fz bold">取消</a>--}}
            <a class="btn_back close-popup fz bold">取消</a>
            <h2 class="cat1 lt">文章评论</h2>
            <a href="javascript:void(0)" onclick="commentSubmit();" class="btn_link btn_submit fz bold">提交</a>
        </header>
        <!-- 头部条 end -->
        <div class="textareaBox bgcolor_fff plr30">
           <div class="fz f26 text_center color_gray9b mt30 pt26 mb20" id="change_score">给老师的课程打个分~</div>
           <div id="star" class="text_center"></div>
           <textarea class="fz text-jus mt30" placeholder="请发表您的评论..." id="content"></textarea>
        </div>
    </div>
</div>
<br><br><br>
<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script src="/js/star_jquery.raty.min.js"></script>
<script>
    /*星星点亮*/
    var final_score = 0;
    var user_id     = '{{$userid}}';   //用户id
    var c_c_id      = '{{$data->id}}';    //课程id
    /*星星点亮*/
    $(function (){
            $.fn.raty.defaults.path = '/images/img/';
            $('#star').raty({
            click: function(score, evt) {
                final_score = score;
                $("#change_score").text(score+" 分");
            }
        });
    })
    //给body加一个类
    $('body').addClass('page_evaluate_wrap');

    //提交评论内容
    function commentSubmit(){

        var text = $("#content").val();
        if(text.length<10){
            layer.msg("请填写10字以上的评论");
            return;
        }
        if(final_score<1){
            layer.msg("请给课程评分");
            return;
        }
        var data = {user_id:user_id, _token:token, c_c_id:c_c_id, text:text, final_score:final_score};
        $.ajax({
            url:'/course/commentinsert',
            type:'POST',
            data:data,
            dataType:'json',
            success:function(res){
                layer.msg(res.msg);
                window.location.reload();
            }
        });
        return;

    }
    
</script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->
<script>
    $(function () {
        var Accordion = function (el, multiple) {
            this.el = el || {};
            this.multiple = multiple || false;
            var links = this.el.find('.link');
            links.on('click', {
                el: this.el,
                multiple: this.multiple
            }, this.dropdown);
        };
        Accordion.prototype.dropdown = function (e) {
            var $el = e.data.el;
            $this = $(this), $next = $this.next();
            $next.slideToggle();
            $this.parent().toggleClass('open');
            if (!e.data.multiple) {
                $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
            }
            ;
        };
        var accordion = new Accordion($('#accordion'), false);
    });
    //@ sourceURL=pen.js
</script>
{{--<script type="text/javascript">--}}
    {{--window.onload = function(){--}}
        {{--menuFixed('nav_keleyi_com');--}}
    {{--}--}}
{{--</script>--}}
<script src="/js/jweixin-1.4.0.js"></script>
<script type="text/javascript">
    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: "{{$WechatShare['appId']}}", // 必填，公众号的唯一标识
        timestamp: "{{$WechatShare['timestamp']}}", // 必填，生成签名的时间戳
        nonceStr: "{{$WechatShare['noncestr']}}", // 必填，生成签名的随机串
        signature: "{{$WechatShare['signature']}}",// 必填，签名
        jsApiList: [
            'updateAppMessageShareData',
            'updateTimelineShareData'
        ] // 必填，需要使用的JS接口列表
    });
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.updateAppMessageShareData({
            title: '{{$data->title}}', // 分享标题
            desc: '{{$data->seo_description}}', // 分享描述
            link: "http://m.saipubbs.com/course/detail/{{$data->id}}.html?fission_id={{$userid}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "{{env('IMG_URL')}}{{$data->cover_url}}", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.updateTimelineShareData({
            title: '{{$data->title}}', // 分享标题
            link: "http://m.saipubbs.com/course/detail/{{$data->id}}.html?fission_id={{$userid}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "{{env('IMG_URL')}}{{$data->cover_url}}", // 分享图标
        }, function(res) {
            //这里是回调函数
        });
    });
</script>
<script>

    var user_id = "{{$userid}}";      //用户id
    var c_c_id  = "{{$data->id}}";     //课程id
    var is_weixin = "{{$is_weixin}}";  //是否为微信浏览器
    var token     = '{{csrf_token()}}';
    var vid       = "player_"+{{$vid}};
    var video_id  = "{{$array[0]->course[0]->id}}";
    var subscribe = "{{$subscribe}}";

    //免费报名成功或者购买成功后跳转
    function href_go(){
        //判断是否关注公众号如果未关注跳转引导页
        if(subscribe){
            location.href="/course/video/"+c_c_id+"/"+video_id+".html";
        }else{
            location.href="/course/middle/"+c_c_id+"/"+video_id;
        }

    }

    //跳转登陆函数
    var userlogin = function(){
        var url = "/course/video/"+c_c_id+"/"+video_id+".html";
        layer.msg('请先登录');

        localStorage.setItem("redirect", url);
        setTimeout(function(){
            window.location.href = "/login";
        }, 500)
    }

    //调用微信JS api 支付
    function jsApiCall()
    {
        var _token = '{{csrf_token()}}';
        var data = {class_id:c_c_id,_token:_token};
        $.ajax({
            url:'/course/buy',
            data:data,
            type:'POST',
            dateType:'json',
            success:function(res){

                if(res.code != 0){
                    swal(res.message);
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
                                setTimeout(function(){
                                    href_go();     //支付成功跳转
                                },1500)  //延迟1.5秒刷新页面
                            }else{
                                layer.msg('取消支付');
                            }
                        }
                );
            }
        })

    }

    $(function (){
        //正在播放的视频高亮
        function video_bright(info){
            $("#"+info).parent().parent().siblings().children().eq(1).attr('class', ' ');
            $("#"+info).parent().attr("class", "block");
            $("#"+info).addClass("FDD000");
//            $("#"+info).find("img").attr("src", "/images/video_play.png");
        }
        //video_bright(vid);
        //查看视频滑倒顶部  并处理正在播放视频高亮
        $(".back-to-top").click(function() {
//            $(".back-to-top").each(function(){
//                $(this).removeClass("FDD000");
//                $(this).find("img").attr("src", "/images/ico_video.png");
//            })
//            $(this).addClass("FDD000");
//            $(this).find("img").attr("src", "/images/video_play.png");

            $('body,html').animate({
                        scrollTop: 0
                    },
                    500);
            return false;
        });

        //折叠面板
        $('.toggleBox .item h3').click(function (){
            if($(this).next().hasClass('block')){
                return false;
            }else{
                $(this).next().addClass('block').parents('.item').siblings().find('ul').removeClass('block');
                $(this).find('i').addClass('up').parents('.item').siblings().find('i').removeClass('up');
            }
        })

        //不支持试看视频
        $(".no_preview").click(function(){
            $.closePopup()
            $.confirm({
                title: '提示',
                text: '立即购买学习该课程，确认购买吗？',
                onOK: function () {
                    $('#studyBtn').trigger('click');
                },
                onCancel: function (){

                }
            });
        });

        //立即付款弹出框
        $('.payBtn').click(function (){
            var payfrom = $("input[name='radio1']:checked").val();
            //alert(payfrom);
            if(payfrom=='BANLANCE'){
                $.closePopup()
                $.confirm({
                    title: '提示',
                    text: '立即购买学习该课程，确认购买吗？',
                    onOK: function () {
                        //点击确认
                        $.ajax({
                            type:"GET",
                            url:"/course/paybalance",
                            data:{c_c_id:c_c_id, user_id:user_id},
                            dataType:"json",
                            success:function(result){
                                if(result.code==1){
                                    layer.msg(result.msg);
                                    setTimeout(function(){
                                        href_go();     //支付成功跳转
                                    },1500)  //延迟1.5秒刷新页面
                                }else{
                                    layer.msg(result.msg);
                                }
                            }
                        });
                    },
                    onCancel: function (){
                    }
                });
            }else if(payfrom=="WXPAY"){
                if(is_weixin==1){
                    jsApiCall();
                }else{
                    $.ajax({
                        type:"POST",
                        url:"/course/payh",
                        data:{course_class_id:c_c_id,_token:token},
                        dataType:"json",
                        success:function(result){
                            if(result.code==1){
                                console.log(result.objectxml.mweb_url);
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
                            url:"/course/paySpb",
                            data:{c_c_id:c_c_id,user_id:user_id},
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

        //免费报名课程
        $("#enroll").click(function(){
            var id = {{$data->id}};
            var user_id = {{$userid}};
            $.get("/course/enroll",{course_class_id:id,user_id:user_id},function(result){
                if(result == 0){
                    layer.msg('报名成功');
                    $(".enroll_bb").text("进入课程");
                    href_go();     //支付成功跳转
                    //window.location.href = "/course/video/"+id+"/"+video_id+".html";
                }
            })
        })

        //取消报名课程  20180827
        $("#cancel_studying").click(function(){
            layer.msg('取消报名成功');
            return;
            var id = {{$data->id}};
            var user_id = {{$userid}};
            $.ajax({
                type:"POST",
                url:"/course/no_entroll",
                data:{course_class_id:id, user_id:user_id, _token:token},
                dataType:"json",
                success:function(result){
                    if(result.code==1){
                        layer.msg(result.msg);
                        setTimeout(function(){
                            location.reload();
                        },1500)  //延迟1.5秒刷新页面
                    }else{
                        layer.msg(result.msg);
                    }
                }
            });
        })
    })
</script>
<script src="/js/ckplayer/ckplayer.js"></script>
<script>
    var cookie = {
        set: function(name, value) {
            var Days = 30;
            var exp = new Date();
            exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
            document.cookie = name + '=' + escape(value) + ';expires=' + exp.toGMTString();
        },
        get: function(name) {
            var arr, reg = new RegExp('(^| )' + name + '=([^;]*)(;|$)');
            if(arr = document.cookie.match(reg)) {
                return unescape(arr[2]);
            } else {
                return null;
            }
        },
        del: function(name) {
            var exp = new Date();
            exp.setTime(exp.getTime() - 1);
            var cval = getCookie(name);
            if(cval != null) {
                document.cookie = name + '=' + cval + ';expires=' + exp.toGMTString();
            }
        }
    };

    //记录最后一个播放视频
    function bb(){
        var cookieVid = cookie.get("cookievid");
        console.log("--"+cookieVid);
        if(cookieVid){
            $("#player_"+cookieVid).parent().parent().siblings().children().eq(1).attr('class', ' ');
            $("#player_"+cookieVid).parent().attr("class", "block");
            $("#player_"+cookieVid).addClass("FDD000");
//            $("#player_"+cookieVid).find("img").attr("src", "/images/video_play.png");
        }else{
            $("#"+vid).parent().parent().siblings().children().eq(1).attr('class', ' ');
            $("#"+vid).parent().attr("class", "block");
            $("#"+vid).addClass("FDD000");
//            $("#"+vid).find("img").attr("src", "/images/video_play.png");
        }
    }
    bb();

    //播放视频功能
    var player;
    var loadHandler;
    var timeHandler;
    function aa(video,id){

        if(typeof(video) == "undefined" && typeof(id) == "undefined"){
            @if($videoOne)
                var video_url_id = "{{$videoOne->video_url}}";
            @else
                var video_url_id = "{{$array[0]->course[0]->video_url}}";
            @endif
                var video_id = 	"{{$vid}}";
        }else{
            var video_url_id = video;
            var video_id = id;
        }
        var href_url = '/course/video/'+c_c_id+'/'+video_id+'.html';
        window.history.pushState({},0,href_url);
        var videoID = video_id;
        var cookieTime = cookie.get("time_" +videoID);
        var videoObject = {
            container: '#video',//“#”代表容器的ID，“.”或“”代表容器的class
            variable: 'player',//该属性必需设置，值等于下面的new chplayer()的对象
            flashplayer:false,//如果强制使用flashplayer则设置成true
            loaded:"loadHandler",
            autoplay:true,
            video:video_url_id//视频地址
        };

        if(!cookieTime || cookieTime == undefined){
            cookieTime = 0;
        }

        if(cookieTime > 0) {
//            layer.msg('上次观看时间为：' + cookieTime+' (秒)');
            videoObject['seek'] = cookieTime;   //设置最新时间
        }
        player = new ckplayer(videoObject);
        //监听播放时间
        loadHandler = function(){
            player.addListener('time', timeHandler);
        }
        //当前视频播放时间写入cookie
        timeHandler = function(t){
            t = Math.floor(t);
            cookie.set('time_' + video_id, t);
        }
        cookie.set('cookievid', video_id);
    }
//    aa();

    //执行关注操作
    function click_follow(e){
        var fans_id = e.getAttribute("data-fans_id");
        var user_id = e.getAttribute("data-user_id");
        var fansid  = e.getAttribute("id");
        var is_follow = e.getAttribute("data-is_follow");
        var token     = '{{csrf_token()}}';
        if(is_follow==1){
            layer.msg('您已关注,无需重复操作');
            return;
        }
        $.ajax({
            type:"POST",
            url:"/user/followadd",
            data:{fans_id:fans_id, user_id:user_id,_token:token},
            dataType:"json",
            success:function(result){
                if(result.code==1){
                    layer.msg('操作成功');
                    document.getElementById(fansid).setAttribute('data-is_follow', 1);
                    //document.getElementById(fansid).setAttribute('class', 'yihuguan border-radius');
                    document.getElementById(fansid).innerHTML='已关注';
                }else{
                    layer.msg(result.msg);
                }
            }
        });
    }
</script>

</body>
</html>
