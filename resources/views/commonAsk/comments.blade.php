@extends('layouts.header')
@section('title')
    <title>问题答案-赛普知道</title>
    <meta name="author" content="" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    @endsection

    @section('cssjs')
            <!--文章下css-->
    <link rel="stylesheet" href="/css/ask.css?t=1.8">
    <link rel="stylesheet" href="/css/ask_popup.css">
    <link rel="stylesheet" href="/css/swiper.min.css">
    <script src="/js/swiper.min.js"></script>
    <script type="text/javascript" src="/js/base64/localResizeIMG.js"></script>
    <script type="text/javascript" src="/js/base64/mobileBUGFix.mini.js"></script>
    <style>
        .img_list li{background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;}
    </style>

    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
    @endsection
    @section('content')


            <!---导航右侧带导航弹出---->

    <div id="page">
        <!--导航大盒子id=page 开始  【结束在最底部】-->



        <div class="page_ask bgcolor_gray">
            <!-- 文章评价列表 start -->
            <div class="daoshizuoye_box bgcolor_fff HuidaImgMax pb30">
                <h2 class="tit f32 bold">{{$question->title}}</h2>
                <p class="desc f28 color_gray666">{{$question->desc}}</p>
                <div class="weui-cell nobefore foot f24 pt0">
                    {{--<div class="weui-cell__bd color_gray9b">{{$question->view}}阅读· {{App\Constant\CommentDate::getDate($question->created_at)}}</div>--}}
                    <div class="weui-cell__bd color_orange askJask f26"><span class="open-popup cursor" data-target="#full_huida"><img src="/images/ask/btn_ask_H.png" alt="" class="d-in-black img100 mr10">我来答</span></div>
                    <div class="">
                        <a href="/cak/answer/{{$question->id}}/1.html" class="f24 color_orange">查看全部回答</a >
                    </div>
                    <?php
                    $imgList = $question->img_url;
                    $imgArr = explode(",",$imgList);
                    array_pop($imgArr);
                    $askUser = App\User::where('id',$question->user_id)->first();
                    if($askUser){
                        $askName = $askUser->name?$askUser->nickname:'';
                    }else{
                        $askName = '';
                    }
//                        dd($imgList);
                    ?>
                    @if($imgList !== '' && !is_null($imgList))
                        <div class="weui-cell__ft btn_open1">展开</div>
                    @endif

                </div>
                <div class="imgs hide ImgMax">

                    <ul class="clearfix post">
                        @if(!is_null($imgList) && $imgList !== '')
                            @foreach($imgArr as $a)
                                @if(!empty($a))
                                    <li><img src="{{env('IMG_URL')}}{{$a}}" class="img100" onclick="slidePhoto(this);" /></li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <ul class="list_daoshizuoye mt20">
                <?php
                 $user = '';
                ?>
                @if($answer)
                    <li>
                        <?php
                        $user = DB::table("users")->where("id",$answer->user_id)->select("name","nickname","avatar","introduction")->first();
                        $userAttr = DB::table("users_attribute")->where("user_id",$answer->user_id)->select("is_verify")->first();
                        ?>
                        <div class="wdui-cell head">
                            <div class="weui-cell__bd">

                                <a href="#" class="user_photo">
                                    @if($user)
                                        @if((strpos($user->avatar,'http') !== false))
                                            <img src="{{$user->avatar}}" alt="" class="img100">
                                        @else
                                            @if($user->avatar)
                                                <img src="{{env('IMG_URL')}}{{$user->avatar}}" alt="" class="img100">
                                            @else
                                                <img src="/images/my/nophoto.jpg" alt="" class="img100">
                                            @endif
                                        @endif
                                    @else
                                        <img src="/images/my/nophoto.jpg" alt="" class="img100">
                                    @endif
                                </a>
                                <dl class="relative" style="overflow: hidden;">
                                    @if($user)
                                        <dt class="ren">{{$user->name?$user->name:$user->nickname}}
                                        @if($userAttr)
                                            @if($userAttr->is_verify==1)
                                                <img src="/images/ren.jpg" alt="">
                                            @endif
                                        @endif
                                        </dt>
                                        <dd style="width: 88%;overflow: hidden;height: 1rem;">{{$user->introduction?$user->introduction:'还没完还没完成自我介绍还没完成自我介绍还没完成自我介绍还没完成自我介绍成自我介绍'}}</dd>
                                        <?php
                                        $follow = DB::table("follow")->where("user_id",$answer->user_id)->where("fans_id",$user_id)->count();
                                        ?>
                                        @if($follow > 0)
                                            <dd class=""><p class="date color_gray9b" data-user_id="{{$answer->user_id}}" data-fans_id='{{$user_id}}' onclick="article_follow(this)" data-is_follow='1' id="teacher{{$answer->user_id}}">已关注</p></dd>
                                        @else
                                    <dd class=""><p class="date color_gray9b" data-user_id="{{$answer->user_id}}" data-fans_id='{{$user_id}}' onclick="article_follow(this)" data-is_follow='0' id="teacher{{$answer->user_id}}">关注</p></dd>
                                        @endif
                                        {{--<dd class=""><p class="date color_gray9b">关注</p></dd>--}}
                                    @else
                                        <dt></dt>
                                        <dd></dd>
                                    @endif

                                </dl>

                            </div>


                        </div>

                            {{--<p>{{$answer->content}}</p>--}}
                            <div class="Detail-huida  f28 mt20 text-jus" style="word-wrap: break-word;">
                                <pre><?php echo htmlspecialchars_decode($answer->content);?></pre>
                            </div>
                            <span class="date color_gray9b">{{date("Y.m.d",strtotime($answer->created_at))}}</span>
                        <div class="imgs pb20">
                            <?php
                            $imgList = $answer->imgurl_list;
                            $imgArr = explode(",",$imgList);
                            array_pop($imgArr);


                            ?>
                            @if($imgList !== '')
                                @foreach($imgArr as $a)
                                    @if($a != '')
                                    <img src="{{env('IMG_URL')}}{{$a}}" class="img100 mb20" />
                                    @endif
                                @endforeach
                            @endif

                        </div>
                        <div class="weui-cell nobefore foot">
                            <div class="weui-cell__bd fz f26 color_gray9b">
                                阅读量{{$answer->view}}
                            </div>
                            @if($user_id == $answer->user_id)
                                <div class="weui-cell__ft">
                                    <a href="javascript:;" class="f24 color_gray9b rev_del fz color_333">
                                        <span  class="open-popup" data-target="#full1" ><img src="/images/ico_rev.png"alt="" onclick="aa(this);">修改</span>
                                        @if(count($comments)>0)
                                            <span class="btn_del btn_del_comment" data-attr = 1><img src="/images/ico_del.png" alt="">删除</span>
                                        @else
                                            <span class="btn_del btn_del_comment" data-attr = 0><img src="/images/ico_del.png" alt="">删除</span>
                                        @endif
                                    </a>
                                </div>
                            @endif

                        </div>
                            <!-- 增加举报功能 start -->
                            <div class="text_right pb30">
                                <p class="color_gray999 d-in-black dianDian">• • •</p>
                                <div class="relative JuBao hide">
                                    <p class="color_gray999 d-in-black juBao f24 open-popup" data-target="#jubao">举报</p>
                                </div>
                            </div>
                            <!-- 增加举报功能 end -->
                            <!-- 增加查看更多好问题 start -->
                            <div class="text_center moreHao pb30">
                                <a href="/cak/1.html" class="block bgcolor_orange fz f28 bold border-radius50">查看更多好问题</a>
                            </div>
                            <!-- 增加查看更多好问题 end -->
                    </li>
                @else
                    <li>答案已删除~</li>
                @endif
            </ul>
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
                            $two = DB::table("common_ask_comments")->where("aid",$answer->id)->where("level",2)->orderBy("created_at","asc")->where("cid",$v->id)->whereNull('deleted_at')->get();


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
                                        {{--<p class="cont">--}}

                                            {{--{{$cont}}</p>--}}
                                        <div class="ptb30 clearfix">
                                            <span class="date_hf f24 color_gray9b fl">{{date("Y.m.d",strtotime($a->created_at))}}</span>
                                            {{--<span class="btn_reply fr open-popup" onclick="two_open(this);" first_key="{{$v->id}}" author_name = "{{$all2->name?$all2->name:$all2->nickname}}" data-content="{{$cont}}" data-user="{{$a->user_id}}" author_id = "{{$v->id}}" data-level="2">回复</span>--}}
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
                    <!-- 全部评论 end -->
            <div class="nomore f24 color_gray666 text_center ptb50 bgcolor_fff loadmore" onclick="loadmore(this);" data-load = 0>加载更多</div>
            @else
                <div class="start_weipingjia text_center">
                    <div class="color_c9c7c7 fz f24 mt30 pt40">
                        <img src="/images/shafa.png" alt="">
                        <p class="mb40 pt10 pb30">沙发还没有人坐，请发言</p><br/><br/><br/><br/><br/>
                    </div>
                </div>
            @endif

        </div>
        <!--边距30 end-->
    </div>
    <!--导航大盒子id=page 结束-->

    <div class="fixed_bar_bottom bgcolor_fff">
        <div class="fixed_bar_ask text_center fz">
            <ul>
                <li>
                    <div class="tianjia">
                        <a href="javascript:void (0)" class="block border-radius50 bgcolor_orange f32 open-popup" data-target="#full" ><img src="/images/ask/ico_pl_b.png" alt="">添加评论</a>
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
                                <div>
                                    <a href="/comment/share/{{$answer->id}}.html">
                                        <p class="fx"><img src="/images/icon-fenxiang.png" alt=""></p>
                                        <p>分享</p>
                                    </a>
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
    <!-- popup -->
    <div id="full" class='weui-popup__container bgcolor_fff ask_popup'>
        <div class="weui-popup__overlay"></div>
        <div class="weui-popup__modal bgcolor_fff">
            <!-- 头部条 start -->
            <header class="header_bar max750 relative">
                <a href="javascript:void(0)" class="btn_cancel btn_cancel_comment color_gray999 f24">取消</a>
                <div class="cat1 f28">回答评论</div>
                <a href="javascript:void(0)" class="btn_link btn_submit color_gray999 f24">提交</a>
            </header>
            <!-- 头部条 end -->
            <!-- 表单区 start -->
            <div class="ask_con">
                <div class="textareaBox mt20 mb20 pb20 pt20 plr20" style="border:1px solid rgba(204,204,204,.4);">
                    <?php
                    echo htmlspecialchars_decode($answer->content);
                    ?>
                </div>
                <div class="">
                    <textarea name=""  class="text-adaption fz f28" placeholder="请发表您的评论…"  id="content" rows="10"></textarea>
                </div>
            </div>
            <!-- 表单区 end -->
        </div>
    </div>

    <!-- 底部固定按钮 end -->

    <!--/////////////////////////////////////////////////////////////////////////////////-->
    <div id="full1" class='weui-popup__container bgcolor_fff ask_popup'>
        <div class="weui-popup__overlay"></div>
        <div class="weui-popup__modal bgcolor_fff">
            <!-- 头部条 start -->
            <header class="header_bar max750 relative">
                <a href="javascript:void(0)" class="btn_cancel btn_cancel_update color_gray999 f24 ">取消</a>
                <a href="javascript:void(0)" class="btn_link btn_submit1 color_gray999 f24">提交</a>
            </header>
            <!-- 头部条 end -->
            <!-- 表单区 start -->
            <div class="ask_con">
                <div class="iptBox">
                    <input type="text" id="tit" maxlength="50" onfocus="this.blur();" value="{{$answer->title}}" />
                </div>
                <div class="">
                    <p name=""  class="text-adaption fz f28" placeholder="请您填写答案"  id="content_ans" style="height: auto!important;min-height: 5rem!important;" contenteditable="true" >
                        <?php
                        echo htmlspecialchars_decode($answer->content);
                        ?>
                    </p>
                </div>
                <div class="weui-cells weui-cells_form">
                    <div class="weui-cell">
                        <div class="weui-cell__bd">
                            <div class="weui-uploader">
                                <div class="weui-uploader__bd">
                                    <ul class="weui-uploader__files img_list" id="uploaderFiles">
                                        @if($imgList !== '')
                                            @foreach($imgArr as $a)
                                                <li>
                                                    <img src="{{env('IMG_URL')}}{{$a}}" alt="" class="img100" />
                                                    <div class="operation">
                                                        <span class="btn_del img_url_list" onclick="btn_delimg(this)" data-url="{{$a}}"></span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif

                                    </ul>
                                    <form id="uploadForm" action="{{url('user/fileupload')}}" method="post" enctype="multipart/form-data">
                                        <div class="weui-uploader__input-box" id="upload_button">
                                            <input id="uploaderInput" class="weui-uploader__input" name="image" type="file" accept="image/*" multiple="">
                                        </div>
                                        {{csrf_field()}}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 表单区 end -->
        </div>
    </div>



    <!-- popup 回答-->
    <div id="full_huida" class='weui-popup__container bgcolor_fff ask_popup'>
        <div class="weui-popup__overlay"></div>
        <div class="weui-popup__modal bgcolor_fff">
            <!-- 头部条 start -->
            <header class="header_bar max750 relative">
                {{--javascript:history.go(-1);--}}
                <a href="javascript:void(0);" class="btn_cancel color_gray666 f32 btn_cancel_answer">取消</a>
                <span class="color_333 bold f34 fz">回答</span>
                <a href="javascript:void(0)" class="btn_link btn_submit_ans color_orange f32 bold">提交</a>
            </header>
            <!-- 头部条 end -->
            <!-- 表单区 start -->
            <div class="ask_con ask_con2">
                <div class="inputBb plr30 ptb30 bg_colorf5">
                    <div class="askTiDet">
                        <h3 class="bold fz f32 pb20 text-jus">{{$question->title}}</h3>
                        <div class="askDetail hide">
                            <p class="text-jus f30 fz color_gray666"><?php echo htmlspecialchars_decode($question->desc); ?></p>
                        </div>
                        <div class="btnAskShow text_center pt10">
                            <img src="/images/icon-art.png" alt="" class="d-in-black transition3">
                            <span class="color_gray999 f30 d-in-black">展开问题详情</span>
                        </div>
                    </div>
                </div>

                <div class="text-jus pt30">
                    <textarea name=""  class="text-adaption fz f28" placeholder="请您添加问题（5字以上）"  id="answer_content" rows="3"></textarea>
                </div>

                <div class="weui-cells weui-cells_form noafter plr30">
                    <div class="weui-cell">
                        <div class="weui-cell__bd">
                            <div class="weui-uploader">
                                <div class="weui-uploader__bd">
                                    <ul class="weui-uploader__files img_ans_list" id="uploaderFiles">

                                    </ul>
                                    <div class="weui-uploader__input-box">
                                        <input id="uploaderAnswer" class="weui-uploader__input" type="file" accept="image/*" multiple="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 表单区 end -->
        </div>
    </div>

    <!--////////////////////////////////////////////////////////////////////////////---->
    <!--放大-->
    <div class="big_img">
        <div class="swiper-container2">
            <div class="swiper-wrapper"></div>
        </div>
        <div class="swiper-pagination"></div>
    </div>




    <!-- 举报 start-->
    <div id="jubao" class="weui-popup__container popup-bottom jubao_popup">
        <div class="weui-popup__overlay"></div>
        <div class="weui-popup__modal">
            <!-- 头部条 start -->
            <header class="jubao_header relative fz">
                <p class="text_center f32">选择举报类型</p>
                <p class="jubao-close close-popup f30">关闭</p>
            </header>
            <!-- 头部条 end -->
            <div class="radioList text_center fz f28">
                <ul>
                    <li>
                        <input type="radio" name="h" value="1" checked>
                        <label for="1">垃圾广告</label>
                    </li>
                    <li>
                        <input type="radio" name="h" value="2" >
                        <label for="2">色情低俗</label>
                    </li>
                    <li>
                        <input type="radio" name="h" value="3" >
                        <label for="3">问题表达不清晰---无法回答</label>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- 举报 end-->


<br/>
<br/>
<br/>

    <script type="text/javascript">
        var question_id = '{{$question->id}}';
        var answer_id = '{{$answer->id}}';
        var orderDesc = 1;
        var imgurl_ans_list = "";
        var _token      = '{{csrf_token()}}';
        var imgUrl      = "{{env('IMG_URL')}}";
        var img_ans_number  = 0;
        var c_ans_length    = 0;
        $('#uploaderAnswer').localResizeIMG({
            width:800,// 宽度
            quality: 0.8, // 压缩参数 1 不压缩 越小清晰度越低
            success: function (result) {
//            console.log(result);
                var img = new Image();
                img.src = result.base64;
                c_ans_length = $(".img_url_list").length;
                c_ans_length++;
                $(".img_ans_list").append('<li style="background-image: url('+img.src+')"><div class="operation"><span class="btn_del imgurl_ans_list" onclick="btn_delimg_ans(this)" id="ans_span'+c_ans_length+'" data-url=""></span></div></li>');
                $.ajax({
                    url: "{{url('ask/fileuploadbase')}}",
                    type: "POST",
                    data:  {file:img.src, _token:_token},
                    dataType:'json',
                    success: function (data) {
                        if(data.code==0){
                            if(img_ans_number>=2){
                                $("#upload_button").hide();
                            }else{
                                img_ans_number++;
                            }
                            $("#ans_span"+c_ans_length).attr("data-url", data.url);
                        }
                    }
                });
            }
        });
        //删除图片
        var btn_delimg_ans = function(e){
            var imgurl = e.getAttribute("data-url");
            var li     = e.parentNode.parentNode;
            var parent = li.parentNode;
            $.ajax({
                url: "/ask/deleteimg",
                type: "POST",
                data:  {imgurl:imgurl, _token:_token},
                dataType:'json',
                success: function (data) {
                    if(data.code==1){
                        parent.removeChild(li);    //删除图片元素
                        imgurl_ans_list = "";
                        //删除图片重新计算图片地址
                        $(".imgurl_ans_list").each(function(){
                            var cur = $(this).attr("data-url");
                            imgurl_ans_list+=cur+",";
                        });

                        //判断上传按钮是否显示
                        if(img_ans_number<3){
                            $("#upload_button").show();
                        }else{
                            img_ans_number--;
                        }
                    }
                }
            });
        }


        //创建作业提交按钮
        $('.btn_submit_ans').click(function (){
            imgurl_ans_list = "";
            $(".imgurl_ans_list").each(function(){
                var cur = $(this).attr("data-url");
                imgurl_ans_list+=cur+",";
            });

//        var tit = $('#tit').val();
            var con = $('#answer_content').val();
            if(!con){
                layer.msg('内容不能为空');
            }else{
                $.ajax({
                    url : '/cak/addanswer',
                    type : 'post',
                    dataType : 'json',
                    data : {content:con, qid:question_id,img_url:imgurl_ans_list, _token:_token},
                    success : function (data) {
                        if(data.code==0){
                            window.location.href='/cak/answer/'+question_id+'/'+orderDesc+'.html';
                        }else{
                            layer.msg(data.msg);
                            $.closePopup();//关闭弹出框
                        }
                    }
                });
                $.closePopup();//关闭弹出框
            }
        })

        function zan(e){
            var praise_img = $(e).find(".praise-img");
            var text_box = $(e).find(".add-num");
            var praise_txt = $(e).find(".praise-txt");
            var num = parseInt(praise_txt.text());

            var aid = "{{$answer->id}}";
            $.ajax({
                url : '/cak/askagree',
                type : 'post',
                dataType : 'json',
                data : {aid : aid,_token:token},
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
            var aid = "{{$answer->id}}";
            var type = 1;
            $.ajax({
                url : '/cak/askagree',
                type : 'post',
                dataType : 'json',
                data : {aid : aid,type:type,_token:token},
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
            var aid = "{{$answer->id}}";
            var type = 2;
            $.ajax({
                url : '/cak/askagree',
                type : 'post',
                dataType : 'json',
                data : {aid : aid,type:type,_token:token},
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

        var dianBlock = 1;
        $(".dianDian").click(function(){
            if(dianBlock == 1){
                console.log("222");
                $(".JuBao").stop().fadeIn("fast");
                dianBlock = 0;
            }else{
                console.log("333");
                $(".JuBao").stop().fadeOut("fast");
                dianBlock = 1;
            }
        });

        $(document).ready(function() {
            $(".radioList ul li").click(function(){
                var type = $(this).find('input').val();

                var data = {type:type,aid:answer_id,_token:'{{csrf_token()}}'};
                $.ajax({
                    url:'/cak/complain',
                    data:data,
                    type:'POST',
                    dataType:'json',
                    success:function(res){
                        if(res.code == 0){
                            $.closePopup();
                            layer.msg(res.message,{
                                icon:1,
                                skin:'layerJumpIcon',
                                time:2000 //2s后自动关闭
                            })
                        }else{
                            $.closePopup();
                            layer.msg(res.message,{
                                icon:1,
                                skin:'layerJumpIcon',
                                time:2000 //2s后自动关闭
                            })
                        }
                    }
                });

            });

            $(".Detail-huida").find("br").remove();
            $(".Detail-huida p").each(function () {
                var p = $(this).text();
                //alert(p);
                if (p == '') {
                    console.log(111);
                    $(this).remove();

                } else {
                    console.log(222);

                }
            })
        });

        var imgI = 1;
        $(".btnAskShow").click(function(){
            $(".askDetail").slideToggle("fast");
            if(imgI == 1){
                $(".btnAskShow").find("span").html("收起问题详情");
                $(".btnAskShow").find("img").stop().css("transform","rotate(180deg)");
                imgI = 0;

            }else{
                $(".btnAskShow").find("span").html("展开问题详情");
                $(".btnAskShow").find("img").stop().css("transform","rotate(0deg)");
                imgI = 1;

            }
        });

        function aa(obj){

            $("#content_ans").focus()
        }

        //展开
        $(function(){
            $('.btn_open1').click(function (){
                $(this).hide();
                $(this).parents('.daoshizuoye_box').find('.imgs').show();
            })
        });


        var token   = '{{csrf_token()}}';

        /*--------------------------------------------------*/
        var imgUrl      = "{{env('IMG_URL')}}";
        //给body加一个类
        $('body').addClass('page_dialog_wrap');

        $('.btn_agree').click(function (){
            var aid = "{{$answer->id}}";
            var agree = $(this).attr("data-agree");
            if(agree == 0){
                $.ajax({
                    url : '/cak/askagree',
                    type : 'post',
                    dataType : 'json',
                    data : {aid : aid,_token:token},
                    success : function (data) {

                        if(data.code == 0){
                            $(".btn_agree").text('已赞');
                            $(".btn_agree").attr("data-agree",1);
                        }

                    }
                });
            }
        })
        var author_id = 0;

        {{--var user_avatar = '{{$users?$users->avatar:""}}';--}}
        var user_avatar = '';
        {{--var user_name = '{{$users?$users->nickname:""}}';--}}
        var user_name = '';
        var author_name = '';
        var key = '';
        var com_id = 0;
        push_user_id = 0;

        function two_open(e){
            var author_id_two = e.getAttribute("author_id");//评论id
            author_name = e.getAttribute("author_name");
            push_user_id = e.getAttribute("data-user");
            author_id = author_id_two;
            key = e.getAttribute("first_key");
            com_id = e.getAttribute('data-cid');
            var content = e.getAttribute('data-content');//获取评论内容
            $('.textareaBox').text(content);
            $("#content").val("@"+author_name+" ");
            $("#full").popup();
        }



        $(".one_open").click(function(){
            author_id = 0;
            $("#full").popup();
        })

        //提交
        $('.btn_submit').click(function (){
            var replyContent = $(".textareaBox").text();
//            alert(replyContent);
//            console.log(reply)
//            var con = $('#content').val()+"//"+replyContent;
            var con = $('#content').val();
            var aid = "{{$answer->id}}";

            if(!con){
                layer.msg('内容不能为空');
            }else{
                $.ajax({
                    url : '/cak/addComment',
                    type : 'post',
                    dataType : 'json',
                    data : {con : con,aid:aid,cid:author_id,comid:com_id,push_user:push_user_id,_token:token},
                    success : function (data) {
                        if(data.code == 0){

                            $(".start_weipingjia").addClass("hide");
                            if(author_id == 0){

                                $(".list_comment").prepend(data.data.body);
                            }else{

                                $(".first_data"+key).append(data.data.body);
                            }

                            $("#content").val("");
                        }
                    }
                });
                $.closePopup();//关闭弹出框
            }

        })


        //取消
        $('.btn_cancel_comment').click(function (){
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
        });
        //取消
        $('.btn_cancel_answer').click(function (){
            layer.open({
                title: '',
                content: '是否放弃回答',
                id: 'mylayer',
                closeBtn: 0, //不显示关闭按钮
                btn: ['放弃', '继续回答'],
                yes: function(index, layero) {
                    //【放弃按钮】的回调
                    layer.closeAll();
                    $.closePopup();//关闭弹出框
                    $('#answer_content').val('');

                },
                btn2: function(index, layero) {
                    //【继续回答】的回调

                }
            });
        });
        //取消
        $('.btn_cancel_update').click(function (){
            layer.open({
                title: '',
                content: '是否放弃修改',
                id: 'mylayer',
                closeBtn: 0, //不显示关闭按钮
                btn: ['放弃', '继续修改'],
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

        //删除作业
        $('.btn_del_comment').click(function (){
            var status = $(this).attr("data-attr");
            var answer_id = "{{$answer->id}}";
            if(status == 1){
                layer.msg("已有评论不能删除哦~");
            }else{
                layer.open({
                    title: '',
                    content: '确定要删除么',
                    id: 'mylayer',
                    closeBtn: 0, //不显示关闭按钮
                    btn: ['取消', '确定'],
                    yes: function(index, layero) {
                        layer.closeAll();
                        $.closePopup();//关闭弹出框

                    },
                    btn2: function(index, layero) {
                        console.log(111);
                        $.ajax({
                            url : '/cak/delanswer',
                            type : 'post',
                            dataType : 'json',
                            data : {answer_id : answer_id,_token:token},
                            success : function (data) {
                                console.log(answer_id);
                                if(data.code == 0){
                                    layer.msg("删除成功");
                                    window.location.href = "/cak/answer/{{$question->id}}/1.html";
                                }
                            }
                        });
                    }
                });
            }
        });



        //跳转登陆函数
        var userlogin = function(){
            var url = "/cak/comment/{{$answer->id}}.html";
            layer.msg('请先注册');
            localStorage.setItem("redirect", url);
            setTimeout(function(){
                window.location.href = "/register";
            }, 500)
        }

    </script>

    <script>
        var i = 2;
        var can = "";
        var loadmore = function(e){
            var loaddata = e.getAttribute("data-load");
            console.log(loaddata);
            if(loaddata == 0){
                var answer_id = "{{$answer->id}}";
                $.ajax({
                    url : '/cak/loadMoreComment',
                    type : 'post',
                    dataType : 'json',
                    data : {aid : answer_id,page:i,_token:token},
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
        <script>

        $('.btn_submit1').click(function (){

            imgurl_list = "";
            $(".img_url_list").each(function(){
                var cur = $(this).attr("data-url");
                imgurl_list+=cur+",";
            });

//            var tit=$('#tit').val();
            var con=$('#content_ans').text();
            var qid = "{{$question->id}}";
            var author = "{{$question->user_id}}";
            var aid = "{{$answer->id}}";
            var token   = '{{csrf_token()}}';
            if(!con){
                layer.msg('内容不能为空');
            }else{
                $.ajax({
                    url : '/cak/addanswer',
                    type : 'post',
                    dataType : 'json',
                    data : {
                        content : con,
                        qid : qid,
                        author:author,
                        _token:token,
                        imgurl_list:imgurl_list,
                        update:1,
                        aid:aid,
                    },
                    success : function (data) {
                        if(data.code == 0){
                            layer.msg("修改成功");
                            window.location.reload();
                        }
                    }
                });
                $.closePopup();//关闭弹出框
            }

        })
        /*--------------------------------------*/
        var imgUrl      = "{{env('IMG_URL')}}";
        var _token   = '{{csrf_token()}}';
        var c_length    = 0;
        $('input:file').localResizeIMG({
            width:800,// 宽度
            quality: 0.8, // 压缩参数 1 不压缩 越小清晰度越低
            success: function (result) {
                var img = new Image();
                img.src = result.base64;
                c_length = $(".img_url_list").length;
                c_length++;

                $(".img_list").append('<li style="background-image: url('+img.src+')"><div class="operation"><span class="btn_del img_url_list" onclick="btn_delimg(this)" id="cur_span'+c_length+'" data-url=""></span></div></li>');
                $.ajax({
                    url: "{{url('ask/fileuploadbase')}}",
                    type: "POST",
                    data:  {file:img.src, _token:_token},
                    dataType:'json',
                    success: function (data) {
                        if(data.code==0){
                            var length = $(".img_list li").length;
                            console.log(length);
                            console.log(data);
                            if(length>=3){
                                $("#upload_button").hide();
                            }
                            $("#cur_span"+c_length).attr("data-url", data.url);
                            console.log("图片地址是"+data.url);
                        }
                    }
                });
            }
        });

        //删除图片
        var btn_delimg = function(e){
            var imgurl = e.getAttribute("data-url");
            var li     = e.parentNode.parentNode;
            var parent = li.parentNode;
            $.ajax({
                url: "/ask/deleteimg",
                type: "POST",
                data:  {imgurl:imgurl, _token:token},
                dataType:'json',
                success: function (data) {
                    if(data.code==1){
                        parent.removeChild(li);    //删除图片元素
                        imgurl_list = "";
                        //删除图片重新计算图片地址
                        $(".img_url_list").each(function(){
                            var cur = $(this).attr("data-url");
                            imgurl_list+=cur+",";
                        });
                        var length = $(".img_list li").length;
                        //判断上传按钮是否显示
                        if(length<3){
                            $("#upload_button").show();
                        }
                    }
                }
            });
        }



        /*swiper弹出大图并轮播 start*/
        $(document).ready(function () {
            /*调起大图 S*/
            var mySwiper = new Swiper('.swiper-container2', {
                loop: false,
                pagination: '.swiper-pagination',
                paginationType: 'fraction'
            })
            $(".ImgMax").on("click", ".post img",function () {
                var imgBox = $(this).parents(".post").find("img");
                var i = $(imgBox).index(this);
                $(".big_img .swiper-wrapper").html("");

                for (var j = 0, c = imgBox.length; j < c; j++) {
                    $(".big_img .swiper-wrapper").append('<div class="swiper-slide"><div class="cell"><img src="' + imgBox.eq(j).attr("src") + '" / ></div></div>');
                }
                mySwiper.updateSlidesSize();
                mySwiper.updatePagination();
                $(".big_img").css({
                    "z-index": 1001,
                    "opacity": "1"
                });
                mySwiper.slideTo(i, 0, false);
                return false;
            });

            $(".big_img").on("click",
                    function () {
                        $(this).css({
                            "z-index": "-1",
                            "opacity": "0"
                        });
                    });
        });
        /*调起大图 E*/
        /*swiper弹出大图并轮播 end*/
        function delComment(obj){
            var cid = $(obj).attr('data-id');
            var token = '{{csrf_token()}}';
            var data = {cid:cid,_token:token};

            $.ajax({
                url:'/cak/delComment',
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


        //关注取消关注
        function article_follow(e){
            var fans_id = e.getAttribute("data-fans_id");
            var user_id = e.getAttribute("data-user_id");
            var articleid  = e.getAttribute("id");
            var is_follow = e.getAttribute("data-is_follow");
            var token   = '{{csrf_token()}}';
            var mobile = "{{$mobile}}";
            if(mobile == 0){
                userlogin();  //跳转登陆
                return;
            }
            if(is_follow==0){
                $.ajax({
                    type:"POST",
                    url:"/user/followadd",
                    data:{fans_id:fans_id, user_id:user_id, _token:token},
                    dataType:"json",
                    success:function(result){
                        if(result.code==1){
                            layer.msg('关注成功');
                            document.getElementById(articleid).setAttribute('data-is_follow', 1);
                            document.getElementById(articleid).innerHTML='已关注';
                        }else{
                            layer.msg(result.msg);
                        }
                    }
                });
            }else{
                $.ajax({
                    type:"POST",
                    url:"/user/followcancel",
                    data:{fans_id:fans_id, user_id:user_id, _token:token},
                    dataType:"json",
                    success:function(result){
                        if(result.code==1){
                            layer.msg('取消关注');
                            document.getElementById(articleid).setAttribute('data-is_follow', 0);
                            document.getElementById(articleid).innerHTML='关注';
                        }else{
                            layer.msg(result.msg);
                        }
                    }
                });
            }
        }

        </script>
@endsection
