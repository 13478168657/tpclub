<?php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();

?>

<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>教练清单详情页</title>
    <meta name="author" content="涵" />
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
    <!--教练清单css-->
    <link rel="stylesheet" href="/css/qingdan.css?t=3">
    <link rel="stylesheet" href="/css/ask_popup.css">
    @include('layouts.baidu')
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

<div id="page">
    <!--导航大盒子id=page 开始  【结束在最底部】-->

    <!--头部导航 start-->
    <div class="mh-head mm-sticky mh-sticky">
        <div class=" menu-bg-logo">
                <span class="mh-btns-left">
                    <a class="icon-menu icon-sousuo" href="/search"></a>
                </span>
                    <span class="mh-btns-right">
                    <a class="icon-menu" href="#menu"></a>
                    <a class="icon-menu" href="#page"></a>
                </span>
        </div>
    </div>
    <!--隐藏导航内容-->
        <nav id="menu">
            <div class="text_center nav-a">
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
                        {{--<li><a href="/register">注册</a></li>--}}
                    @endif
                </ul>
            </div>
        </nav>
    <!--头部导航 end-->

    <!--===================================================================================-->
    <!-- 标题 描述 start-->
    <div class="mlr30 fz border-b-dedede">
        <div class="pt40 pb40">
            <h3 class="color_333 f32 line40 bold">{{$coachList->name}}</h3>
            <p class="color_gray9b f24 mt10">{{$coachList->views}}阅读 · 获得的认可</p>
        </div>
        <p class="color_gray666 f28 line36 text-jus mb40">{{$coachList->deal_problem}}</p>
    </div>
    <!-- 标题 描述 end-->
    <!-- 使用工具 start-->
    <div class="mlr30 pt30 fz">
        <h4 class="bold f28 color_333">使用工具</h4>
        <p class="bold f28 color_gray666">{{$coachList->tools}}</p>

        <div class="step mt62">
            <!-- 步骤1 start-->

            @foreach($coachSteps as $k => $step)
                <?php
                $content = explode(PHP_EOL,$step->intro);
                    if($k == 0){

                        $art = '';
                        foreach($content as $cont){
                            $art .= trim($cont);
                        }
                    }
                    $showContent = '';
                    foreach($content as $show){

                        $showContent .= $show."<br/>";
                    }
                ?>
            <div class="bgcolor_f9f9f9">
                <div class="stepBox mlr20 pt40 pb40">
                    <h4 class="bold f28 color_333 pb20">步骤{{$k+1}}</h4>
                    <div class="bgcolor_fff mb20">
                        <!--这里是视频 start-->
                        @if($step->video_list)
                        <?php
                            $videoLists = explode(',',$step->video_list)
                        ?>
                        @foreach($videoLists as $video)
                        <div class="video">
                            @if($step->cover_img)
                            <div class="box">
                                <img src="{{env('IMG_URL')}}{{$step->cover_img}}" alt=""/>
                                <div class="mask"></div>
                                <span class="btn_play"></span>
                            </div>
                            @endif
                            <video id="video" src="{{$video}}" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto" ></video>
                        </div>
                        @endforeach
                        @endif
                        <!--这里是视频 end-->
                    </div>
                    @if($step->img_list)
                        <?php
                            $imgLists = explode(',',$step->img_list);
                        ?>
                        @foreach($imgLists as $img)
                        <div class="bgcolor_fff mb20">
                            <img src="{{env('IMG_URL')}}{{$img}}" class="img100" alt="这里是图片">
                        </div>
                        @endforeach
                    @endif
                    <p class="f28 color_gray666 text-jus line36 mt30">
                        <?php
                            echo htmlspecialchars_decode($showContent);
                        ?>
                    </p>
                    @if($step->url)
                    <div class="jump mlr20 text_center ptb40 f30 color_333">
                        <a href="{{$step->url}}" class="block">查看更多详情<img src="/images/right-jian.png" alt=""></a>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
            <!-- 步骤1 end-->
            <!-- 步骤2 start-->
            {{--<div class="bgcolor_f9f9f9 mt30">--}}
                {{--<div class="stepBox mlr20 pt40 pb40 border-b-dedede">--}}
                    {{--<h4 class="bold f28 color_333 pb20">步骤2</h4>--}}
                    {{--<p class="f28 color_gray666 text-jus line36 mt30">线上免费课程 你想要减脂吗？全部展现线上免费课程 你想要减脂吗？全部展现线上免费课程 你想要减脂吗？全部展现</p>--}}
                {{--</div>--}}
                {{--<div class="jump mlr20 text_center ptb40 f30 color_333">--}}
                    {{--<a href="" class="block">查看更多详情<img src="/images/right-jian.png" alt=""></a>--}}
                {{--</div>--}}
            {{--</div>--}}
            <!--步骤2 end-->
            <!-- 标签/关注 start -->
            <div class="pt40 pb40 border-b-dedede">
                <div class="Qtag">
                    <ul class="clearfix">
                        <?php
                            $tagids = explode(',',$coachList->list_tags);
                            $tagsArr = App\Models\CoachTag::whereIn('id',$tagids)->get();
                        ?>
                        @foreach($tagsArr as $tag)
                        <li><a  class="block bgcolor_gray border-rad2rem" onclick="javascrip:void(0);">{{$tag->name}}</a></li>
                        @endforeach

                    </ul>
                </div>
                <div class="Qfollow pt40">
                    <div class="weui-cell padding0 mt0 noafter nobefore">
                        <div class="weui-cell__hd">
                            @if($author)
                                @if(strpos($author->avatar,'http') !== false)
                                    <img src="{{$author->avatar}}" class="border-rad100" />
                                @else
                                    <img src="{{env('IMG_URL')}}{{$author->avatar}}" alt="头像" class="border-rad100" />
                                @endif
                            @else
                                <img class="border-radius50" src="/images/my/nophoto.jpg" alt="头像" class="border-rad100" />
                            @endif

                        </div>
                        <div class="weui-cell__bd">
                            <p class="f32 color_1515 bold ml10">{{$author->name?$author->name:$author->nickname}}</p>
                        </div>
                        <div class="weui-cell__ft follows">
                            @if(!$mobile)
                            <a onclick="userlogin(this)" class="d-in-black border-radius-img bgcolor_orange f28 bold">关注</a>
                            @else
                                @if($is_follow)
                                    <a onclick="click_follow(this)" class="d-in-black border-radius-img bgcolor_orange f28 bold">已关注</a>
                                @else
                                    <a onclick="click_follow(this)" class="d-in-black border-radius-img bgcolor_orange f28 bold"  data-user_id="{{$author->id}}" data-fans_id="{{$user?$user->id:0}}" data-is_follow="0" id="fans_id{{$user->id}}">关注</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            <!-- 标签/关注 end -->

            <!-- 更多清单 start-->
            <h4 class="bold f32 color_333 mt30 mb20">更多清单</h4>
            @foreach($moreCoachList as $k => $moreList)
            <div class="bgcolor_f9f9f9 {{$k == 0?"mb30":""}}">
                <a href="/coach/detail/{{$moreList->id}}.html">
                    <div class="stepBox mlr40 pt40 pb40">
                        <h4 class="bold f28 color_333 pb20 line36">{{$moreList->name}}</h4>
                        <p class="f24 color_gray999 text-jus line36">{{$moreList->deal_problem}}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>


    </div>
    <!-- 使用工具 end-->
    <div class="bgcolor_gray fz">
        <!-- 全部评论 start -->
        <h2 class="color_gray666 f30 text_center ptb40 bgcolor_fff cat_pl">全部评论</h2>
        <ul class="list_comment">
            @if(count($comments) > 0)
                @foreach($comments as $k=>$v)
                    <li>
                        <div class="pl_item noafter first_data{{$v->id}}">
                            <div class="clearfix">
                                <?php
                                $all = get_teacher_name($v->user_id);
                                ?>
                                <a href="#" class="user_photo">
                                    @if((strpos($all->avatar,'http') !== false))
                                        <img src="{{$all->avatar}}" alt="" class="img100">
                                    @else
                                        @if($all->avatar)
                                            <img src="{{env('IMG_URL')}}{{$all->avatar}}" alt="" class="img100">
                                        @else
                                            <img src="/images/my/nophoto.jpg" alt="" class="img100">
                                        @endif
                                    @endif
                                </a>
                                <div class="info fl">

                                    <span class="f32 bold name">{{$all->name?$all->name:$all->nickname}}</span>
                                    <span class="f24 color_gray9b date">{{App\Constant\CommentDate::getDate($v->created_at)}}</span>
                                </div>

                                <div class="btn_reply fr open-popup" onclick="two_open(this);" first_key="{{$v->id}}" author_name = "{{$all->name?$all->name:$all->nickname}}" data-content="{{$v->content}}" data-cid="{{$v->id}}" data-user="{{$v->user_id}}" author_id = "{{$v->id}}" data-level="2">
                                    <span>回复</span>
                                </div>
                            </div>
                            <p class="cont">{{$v->content}}</p>
                        </div>

                        <!--二级回复-->
                        <?php
                        $two = DB::table("coach_list_comments")->where("coach_list_id",$v->coach_list_id)->where("level",2)->orderBy("created_at","asc")->where("cid",$v->id)->whereNull('deleted_at')->get();


                        ?>
                        @if(count($two) > 0)
                            @foreach($two as $k => $a)
                                <?php
                                $all2 = get_teacher_name($a->user_id);
                                ?>
                                <div class="hf_item bgcolor_f9f9f9">
                                    <div class="clearfix">
                                        <a href="#" class="user_photo">
                                            @if((strpos($all2->avatar,'http') !== false))
                                                <img src="{{$all2->avatar}}" alt="" class="img100">
                                            @else
                                                @if($all2->avatar)
                                                    <img src="{{env('IMG_URL')}}{{$all2->avatar}}" alt="" class="img100">
                                                @else
                                                    <img src="/images/my/nophoto.jpg" alt="" class="img100">
                                                @endif
                                            @endif
                                        </a>
                                        <?php
                                        //                                            $allName = $all->name?$all->name:$all->nickname;
                                        $content_arr = explode(" ",$a->content);
                                        if(isset($content_arr[2])){
                                            $allName = trim($content_arr[0].$content_arr[1],'@');
                                        }else{
                                            $allName = trim($content_arr[0],'@');
                                        }
                                        $cont = str_replace("@".$allName.' ',"",$a->content);
                                        $replyName = $allName;
                                        ?>
                                        <div class="info fl">
                                            <span class="f32 bold name">{{$all2->name?$all2->name:$all2->nickname}}</span>
                                            {{--<em class="f24 color_gray9b date">回复</em>--}}
                                            {{--<span class="f32 bold name ml20">{{$replyName}}</span>--}}
                                        </div>
                                    </div>
                                    <?php
                                    $replyedComment = App\Models\CommonAskComment::where('id',$a->replyed_id)->first();
                                    ?>
                                    <p class="cont">{{$cont}}<span class="ml10">//<b class="bold mr10">@<?php echo $replyName;?></b>{{$replyedComment?$replyedComment->reply_content:''}}</span></p>

                                    <div class="ptb30 clearfix">
                                        <span class="date_hf f24 color_gray9b fl">{{date("Y.m.d",strtotime($a->created_at))}}</span>
                                        <span class="btn_reply2 fl open-popup" onclick="two_open(this);" first_key="{{$v->id}}" author_name = "{{$all2->name?$all2->name:$all2->nickname}}" data-content="{{$cont}}" data-cid="{{$a->id}}" data-user="{{$a->user_id}}" author_id = "{{$v->id}}" data-level="2">回复</span>
                                        @if($user_id == $a->user_id)
                                            <span data-id="{{$a->id}}" class="btn_reply2 fl ml20"  onclick="delComment(this);">删除</span>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                        <!---end-->

                    </li>
                @endforeach
            @endif

        </ul>
        @if(count($comments) > 0)
        <div class="nomore f24 color_gray666 text_center ptb50 bgcolor_fff loadmore" onclick="loadmore(this);" data-load = 0>加载更多</div>
        @else
            <div class="start_weipingjia text_center">
                <div class="color_c9c7c7 fz f24 mt30 pt40">
                    <img src="/images/shafa.png" alt="">
                    <p class="mb40 pt10 pb30">沙发还没有人坐，请发言</p><br/><br/><br/><br/><br/>
                </div>
            </div>
            @endif
        {{--<!-- 全部评论 end -->--}}
        {{--<div class="nomore f24 color_gray666 text_center ptb50 bgcolor_fff">已显示全部评论</div>--}}
    </div>
    <!--边距30 end-->
</div>
<!--导航大盒子id=page 结束-->

<!-- 底部固定按钮 start -->
<div class="fixed_bar_bottom bgcolor_fff">
    <div class="fixed_bar_ask text_center fz">
        <ul>
            <li>
                <div class="tianjia">
                    <a href="javascript:void (0)" class="block border-radius50 bgcolor_orange f32 open-popup" data-target="#full" ><img src="/images/ask/ico_pl_b.png" alt="">发起讨论</a>
                </div>
            </li>
            <li>
                <div class="tj-more">
                    <ol class="clearfix f26">
                        <li>
                            @if($zan)
                                <div class="relative clickZan" onclick="return layer.msg('喔吼？ 身为一个健身爱好者，请坚定立场');">
                                    <p class="praise"><img src="/images/icon-zantong-on.png" alt="" class="praise-img"></p>
                                    <p class="font-zan">已赞</p>
                                    <p class="pos-num color_red praise-txt f18">{{$sumZan}}</p>
                                    {{--<p class="add-num"><em>+1</em></p>--}}
                                </div>
                            @else
                                <div class="relative clickZan" onclick="zan(this)">
                                    <p class="praise"><img src="/images/icon-zantong.png" alt="" class="praise-img"></p>
                                    <p class="font-zan">赞同</p>
                                    <p class="pos-num color_red praise-txt f18">{{$sumZan}}</p>
                                    <p class="add-num"><em>+1</em></p>
                                </div>
                            @endif
                        </li>
                        <li>
                            <div onclick="meibangzhu(this)">
                                @if($isHelp)
                                    <p class="buzantong"><img src="/images/icon-buzantong.png" alt="" class="buzantong-img"></p>
                                    <p class="font-nobz">没帮助</p>
                                @else
                                    <p class="buzantong"><img src="/images/icon-buzantong-on.png" alt="" class="buzantong-img"></p>
                                    <p class="font-nobz color_orange">没帮助</p>
                                @endif
                            </div>
                        </li>
                        <li>
                            <div onclick="shoucang(this)">
                                @if($isCollect)
                                    <p class="sc"><img src="/images/icon-shoucangask-on.png" alt="" class="sc-img"></p>
                                    <p class="font-sc color_orange">已藏</p>
                                @else
                                    <p class="sc"><img src="/images/icon-shoucangask.png" alt="" class="sc-img"></p>
                                    <p class="font-sc">收藏</p>
                                @endif
                            </div>
                        </li>
                    </ol>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- 底部固定按钮 end -->


<!-- popup 评论-->
<div id="full" class='weui-popup__container bgcolor_fff ask_popup fz'>
    <div class="weui-popup__overlay"></div>
    <div class="weui-popup__modal bgcolor_fff">
        <!-- 头部条 start -->
        <header class="header_bar max750 relative">
            {{--<a href="javascript:history.go(-1);" class="btn_cancel color_gray999 f24">取消</a>--}}
            <a href="javascript:window.reload();" class="btn_cancel color_gray999 f24">取消</a>
            <div class="cat1 f28">回答评论</div>
            <a href="javascript:void(0)" class="btn_link btn_submit color_gray999 f24">提交</a>
        </header>
        <!-- 头部条 end -->
        <!-- 表单区 start -->
        <div class="ask_con">
            <div class="">
                <textarea name=""  class="text-adaption fz f28" placeholder="请发表您的评论…"  id="content" rows="10"></textarea>
            </div>
        </div>
        <!-- 表单区 end -->
    </div>
</div>


<br><br><br>
<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/js/ask.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->

<script type="text/javascript">
    //给body加一个类,弹出layer样式修改
    $('body').addClass('page_dialog_wrap');

    //跳转登陆函数
    var id = '{{$coachList->id}}';
    var author_id = 0;
    var key = '';
    var userlogin = function(){
        var url = "/coach/detail/"+id+".html";
        localStorage.setItem("redirect", url);

        layer.msg('请先注册');
        setTimeout(function(){
            window.location.href = "/register";
        }, 500)
    }
    //播放视频
    $(function (){
        //播放视频
        $('.video .box').click(function(){
            $('.video .box').show();//点击别的视频会把视频背景图再次呼出
            $(this).hide();
            $(this).next().trigger('play');
        })
    });
    var token = '{{csrf_token()}}';

    function zan(e){
        var praise_img = $(e).find(".praise-img");
        var text_box = $(e).find(".add-num");
        var praise_txt = $(e).find(".praise-txt");
        var num = parseInt(praise_txt.text());

        $.ajax({
            url : '/coach/list/agree',
            type : 'post',
            dataType : 'json',
            data : {cid : id,_token:token},
            success : function (data) {

                if(data.code == 0){
                    if(praise_img.attr("src") == ("/images/icon-zantong-on.png")){

                        layer.msg("喔吼？ 身为一个健身爱好者，请坚定立场");
                    }else{

                        $(e).find(".praise").html("<img src='/images/icon-zantong-on.png' class='praise-img animation'/>")
                        $(e).find(".font-zan").text("已赞").addClass("color_orange");
                        text_box.show().html("<em class='add-animation'>+1</em>");
                        $(".add-animation").addClass("hover_red");
                        num +=1;
                        praise_txt.text(num);
                    }
                }else{
                    layer.msg(data.message);
                }

            }
        });
    }
    function meibangzhu(o){
        var bz_img = $(o).find(".buzantong-img");
        var type = 1;
        $.ajax({
            url : '/coach/list/agree',
            type : 'post',
            dataType : 'json',
            data : {cid : id,type:type,_token:token},
            success : function (data) {

                if(data.code == 0){
                    if(bz_img.attr("src") == ("/images/icon-buzantong-on.png")){

                        $(o).find(".buzantong").html("<img src='/images/icon-buzantong.png' class='buzantong-img animation'/>");
                        $(o).find(".font-nobz").removeClass("color_orange")

                    }else{

                        $(o).find(".buzantong").html("<img src='/images/icon-buzantong-on.png' class='buzantong-img animation'/>");
                        $(o).find(".font-nobz").addClass("color_orange");
                    }
                }else{
                    layer.msg(data.message);
                }

            }
        });
    }
    function shoucang(i){
        var sc_img = $(i).find(".sc-img");
        var type = 2;
        $.ajax({
            url : '/coach/list/agree',
            type : 'post',
            dataType : 'json',
            data : {cid : id,type:type,_token:token},
            success : function (data) {

                if(data.code == 0){
                    if(sc_img.attr("src") == ("/images/icon-shoucangask-on.png")){

                        $(i).find(".sc").html("<img src='/images/icon-shoucangask.png' class='sc-img animation'/>");
                        $(i).find(".font-sc").text("收藏").removeClass("color_orange");
                    }else{

                        $(i).find(".sc").html("<img src='/images/icon-shoucangask-on.png' class='sc-img animation'/>");
                        $(i).find(".font-sc").text("已藏").addClass("color_orange");
                    }
                }else{
                    layer.msg(data.message);
                }

            }
        });

    }


    //提交
    var com_id = 0;
    $('.btn_submit').click(function (){

        var con = $('#content').val();

        if(!con){
            layer.msg('内容不能为空');
        }else{
            $.ajax({
                url : '/coach/list/addComment',
                type : 'post',
                dataType : 'json',
                data : {con : con,coachid:id,cid:author_id,comid:com_id,_token:token},
                success : function (data) {
                    if(data.code == 0){

                        $(".start_weipingjia").addClass("hide");
                        if(author_id == 0){

                            $(".list_comment").prepend(data.data.body);
                        }else{
                            alert(33);
                            $(".first_data"+key).append(data.data.body);
                        }

                        $("#content").val("");
                    }
                }
            });
            $.closePopup();//关闭弹出框
        }

    });

    function two_open(e){
        var author_id_two = e.getAttribute("author_id");//评论id
        author_name = e.getAttribute("author_name");
        author_id = author_id_two;
        key = e.getAttribute("first_key");
        alert(key);
        com_id = e.getAttribute('data-cid');
        var content = e.getAttribute('data-content');//获取评论内容
        $('.textareaBox').text(content);
        $("#content").val("@"+author_name+" ");
        $("#full").popup();
    }
    function delComment(obj){
        var cid = $(obj).attr('data-id');
        var token = '{{csrf_token()}}';
        var data = {cid:cid,_token:token};

        $.ajax({
            url:'/coach/list/delComment',
            data:data,
            type:'POST',
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    $(obj).parent().parent().remove();
                    layer.msg(res.message);
                }else{
                    layer.msg(res.message);
                }
            }
        });
    }
    //取消
    $('.btn_cancel').click(function (){
        layer.open({
            title: '',
            content: '是否放弃评论',
            id: 'mylayer',
            closeBtn: 0, //不显示关闭按钮
            btn: ['放弃', '继续评论'],
            yes: function(index, layero) {
                //【放弃按钮】的回调
                layer.closeAll();
                $.closePopup();//关闭弹出框
                $('#content').val('');

            },
            btn2: function(index, layero) {
                //【继续回答】的回调

            }
        });
    })

    //执行关注操作
    function click_follow(e){

        var fans_id = e.getAttribute("data-fans_id");
        var user_id = e.getAttribute("data-user_id");
        var fansid  = e.getAttribute("id");
        var is_follow = e.getAttribute("data-is_follow");

        var token     = '{{csrf_token()}}';
        // if(is_follow==1){
        // 	layer.msg('您已关注,无需重复操作');
        // 	return;
        // }
        $.ajax({
            type:"POST",
            url:"/user/followadd",
            data:{fans_id:fans_id, user_id:user_id,_token:token,is_follow:is_follow},
            dataType:"json",
            success:function(result){
                if(result.code==1){
                    layer.msg('操作成功');
                    document.getElementById(fansid).setAttribute('data-is_follow', 1);
                    document.getElementById(fansid).innerHTML='已关注';
                }else{
                    layer.msg(result.msg);
                    document.getElementById(fansid).setAttribute('data-is_follow', 0);
                    document.getElementById(fansid).innerHTML='关注';

                }
            }
        });
    }


    var i = 2;
    var loadmore = function(e){
        var loaddata = e.getAttribute("data-load");
        if(loaddata == 0){
            $.ajax({
                url : '/coach/list/moreComment',
                type : 'post',
                dataType : 'json',
                data : {cid : id,page:i,_token:token},
                success : function (data) {
                    if(data.code == 0){
                        $(".list_comment").append(data.body);
                        if(data.hasMore == 0){
                            layer.msg("加载完成哦~");
                            $(".loadmore").text("加载完成");
                            $(".loadmore").attr("data-load",1);
                        }
                    }
                    i++;
                }
            });
        }else{
            layer.msg("加载已完成哦~");
        }

    }

</script>

<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    var token1   = '{{csrf_token()}}';
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
    <?php

    ?>
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: '{{$coachList->name}}', // 分享标题
            desc: '{{$art}}', // 分享描述
            link: "http://m.saipubbs.com/coach/detail/{{$coachList->id}}.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "{{env('IMG_URL')}}{{$coachList->cover_img}}", // 分享图标
            success: function(){

            }
        }, function(res) {
            //这里是回调函数

        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: '{{$coachList->name}}', // 分享标题
            link: "http://m.saipubbs.com/coach/detail/{{$coachList->id}}.html?fission_id={{$user_id}}", // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: "{{env('IMG_URL')}}{{$coachList->cover_img}}", // 分享图标
            success: function(){

            }
        }, function(res) {
            //这里是回调函数

        });
    });
</script>

</body>
</html>
