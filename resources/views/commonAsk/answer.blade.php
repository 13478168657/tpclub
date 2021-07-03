@extends('layouts.header')
@section('title')
    <title>问题-赛普知道-健身教练专业问答平台</title>
    <meta name="keywords" content="赛普知道作为健身教练的专业问答平台，致力于解决健身教练工作、职场、以及会员管理等方面的问题，帮助教练在专业知识以及技能方面获得提升。增肌减脂有问题，就来赛普知道，百名专业老师坐镇回答，问答涉及训练技术、减脂增肌、运动康复、运动营养、健身热门话题等多个方向，只有你没问到的健身问题，没有老师答不了的。" />
    <meta name="description" content="健身问题,增肌问题,减脂问题,产后问题,康复训练" />
    <link rel="stylesheet" href="/css/swiper.min.css">
    <script src="/js/swiper.min.js"></script>


    <link rel="stylesheet" href="/css/ask.css?t=3">
    <link rel="stylesheet" href="/css/ask_popup.css">



    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
    <style type="text/css">
        pre{
            white-space: pre-wrap;
            white-space: -moz-pre-wrap;
            white-space: -webkit-pre-wrap;
            white-space: -o-pre-wrap;
            word-wrap: break-word;
        }
    </style>
    @endsection
            <!---导航右侧带导航弹出---->
    @section('content')

<!---导航右侧带导航弹出---->
<?php
  $user = Auth::user();
?>
<div id="page">
    <!--导航大盒子id=page 开始  【结束在最底部】-->




    <!--隐藏导航内容-->
    {{--<nav id="menu"></nav>--}}
    <!--头部导航 end-->


    <div class="page_ask bgcolor_gray">
        <!-- 文章评价列表 start -->
        <div class="daoshizuoye_box bgcolor_fff HuidaImgMax">
            <div class="cgSkTag">
                <?php
                    $tags = $question->tag_ids;
//                    dd($tags);
                    $tagsArr = explode(',',$tags);
                ?>
                @foreach($tagsArr as $tagId)
                    <?php
                        $nowTag = App\Models\Tags::where('id',$tagId)->where('state',1)->first();
//                            dd($nowTag);
                        if(!$nowTag){
                            continue;
                        }
                    ?>
                    @if(!empty($nowTag))
                        <a href="/cak/search/{{$nowTag->id}}.html" class="border-radius50 color_333 bgcolor_orange f24 fz">{{$nowTag->title}}</a>
                    @endif
                @endforeach
            </div>
            <h2 class="tit f32 bold">{{$question->title}}</h2>
            <p class="desc f28 color_gray666">{{$question->desc}}</p>
            <div class="imgs hide ImgMax mt30">
                <ul class="clearfix post">
                    <?php
                        $img_url = $question->img_url;
                        $imgArr = explode(",",$question->img_url);
//                        dd($imgArr);
                        $flag = 0;
                        if(!is_null($img_url) && $img_url !== ''){
                            $flag = 1;
                        }
                    ?>
                    @foreach($imgArr as $img)
                        @if($img != '')
                        <li><img src="{{env('IMG_URL')}}{{$img}}" class="img100" /></li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="weui-cell nobefore foot f24">
                <div class="weui-cell__bd color_gray9b">
                    <span>{{$question->view}}阅读&nbsp;&nbsp;·&nbsp;&nbsp;{{$question->getAnswerTotal()}}回答</span>
                    <span>{{App\Constant\CommentDate::getDate($question->updated_at)}}</span>
                </div>
                <div class="">
                    @if($flag && $userid != $question->user_id)
                        <a href="javascript:;" class="f24 btn_open open-popup">展开</a>
                    @endif
                </div>
            </div>
            @if($userid == $question->user_id)
            <div class="weui-cell nobefore foot f24">
                <div class="weui-cell__bd color_gray9b rev_del fz color_333">
                    <span data-target="#full1" class="open-popup">
                        <img src="/images/ico_rev.png" alt="">修改
                    </span>
                    <span class="clickDel">
                        <img src="/images/ico_del.png" alt="">删除
                    </span>
                </div>
                <div class="">
                    <div class="btn_open f24 open-popup">展开</div>
                </div>
            </div>
            @endif
        </div>



        <!-- 排序 start -->
        <div class="weui-flex sort f28 text_center mt20">
            <div class="weui-flex__item"><a href="/cak/answer/{{$question->id}}/1.html" class="{{$order==1?'':'color_gray666'}}">按时间排序</a></div>
            <div class="weui-flex__item"><a href="/cak/answer/{{$question->id}}/2.html" class="{{$order==2?'':'color_gray666'}}">按赞同数排序</a></div>
        </div>

        @if(count($answers))
        <ul class="list_daoshizuoye">
            @foreach($answers as $answer)
                <?php
//                    dd($answer);
                ?>
            <li>
                <div class="weui-cell head">
                    <div class="weui-cell__bd">
                        <a href="#" class="user_photo">
                            <?php
                                $user = $answer->user;
                            ?>
                            @if($user)
                                @if((strpos($user->avatar,'http') !== false))
                                    <img src="{{$user->avatar}}" alt="" class="img100 border-radius50">
                                @else
                                    <img src="{{env('IMG_URL')}}{{$user->avatar}}" alt="" class="img100 border-radius50">
                                @endif
                            @else
                                <img src="/images/my/nophoto.jpg" alt="" class="img100 border-radius50">
                            @endif
                        </a>
                        <dl>
                            <dt>{{$answer->user?$answer->user->nickname:''}}</dt>
                            @if($answer->user)
                                <dd>{{$answer->user->introduction?$answer->user->introduction:'还没完成自我介绍'}}</dd>
                            @else
                                <dd>还没完成自我介绍</dd>
                            @endif
                        </dl>
                        <div class="ConHref mt20">
                            <a href="/cak/comment/{{$answer->id}}.html">
                                {{--<h3 class="HrefWrap f28 text-jus fz" data-id="{{$answer->id}}_1">{{$answer->content}}</h3>--}}
                                <h3 class="HrefWrap f28 text-jus fz herfP">
                                    <pre><?php echo htmlspecialchars_decode($answer->content);?></pre>
                                </h3>
                                <div class="read-more"></div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="weui-flex pices pices_new">
                    <?php
                        $imgArr = [];
                        if($answer->imgurl_list != null && $answer->imgurl_list != ''){
                            $imgArr = explode(',',$answer->imgurl_list);
                        }
                    ?>
                    @foreach($imgArr as $img)
                    @if(!empty($img))
                        <div class="picimgs"><img src="{{env("IMG_URL")}}{{$img}}" alt="" class="img100"></div>
                    @endif
                    @endforeach
                </div>
                <div class="weui-cell foot">
                    <div class="weui-cell__bd">
                        <span class="date color_gray9b">{{date('Y.m.d',strtotime($answer->updated_at))}}</span>
                    </div>
                    <a href="/cak/comment/{{$answer->id}}.html">
                        <div class="weui-cell__ft color_gray9b f24">
                            <div class="pl">{{$answer->getTotalComment()}}评论</div>
                            <div class="zt">赞同{{$answer->getTotalZan()}}</div>
                        </div>
                    </a>
                </div>
            </li>
            @endforeach
        </ul>
        @if($hasMore)
        <a href="javascript:void (0)" class="Load fz text_center pt40 pb40 mt20 color_gray666 f24 loadmore" onclick="loadMore(this);" data-is_ture="0">加载更多</a>
        @endif
        <!-- 排序 end -->
        @else
            <!--没有内容 start-->
            <div class="no_paixu bgcolor_fff text_center">
                <img src="/images/no-paixu.png" alt="">
                <p class="fz f28 color_gray666 text_center pt40">暂时还没有回答，快来写第一个回答</p>
            </div>
            <!--没有内容 end-->
        @endif
    </div>
    <!--边距30 end-->
</div>
<!--导航大盒子id=page 结束-->

<!-- 底部固定按钮 start -->
<div class="fixed_bar_bottom" style="bottom: 7%;">
    <div class="btn_wrap bgcolor_fff">
        <a href="javascript:void(0)" class="f28 text_center bgcolor_gray open-popup" data-target="#full">添加回答</a>
    </div>
</div>
<!-- 底部固定按钮 end -->

<div id="full" class='weui-popup__container bgcolor_fff ask_popup' style="z-index: 99999999;">
    <div class="weui-popup__overlay"></div>
    <div class="weui-popup__modal bgcolor_fff" style="z-index: 99999999;">
        <!-- 头部条 start -->
        <header class="header_bar max750 relative">
            <a href="javascript:void(0);" class="btn_cancel color_gray999 f24">取消</a>
            <a href="javascript:void(0);" class="btn_link btn_submit color_gray999 f24">提交</a>
        </header>
        <!-- 头部条 end -->
        <!-- 表单区 start -->
        <div class="ask_con">
            {{--<div class="iptBox">--}}
                {{--<p> {{$question->title}}</p>--}}
            {{--</div>--}}
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
            <!--<div class="textareaBox">
                <textarea placeholder="请您添加问题描述" id="content"></textarea>
            </div>-->
            <div class="">
                <textarea name=""  class="text-adaption fz f28" placeholder="请您添加答案"  id="content" rows="3"></textarea>
            </div>
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <div class="weui-uploader">
                            <div class="weui-uploader__bd">
                                <ul class="weui-uploader__files img_list" id="uploaderFiles">
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

<div id="full1" class='weui-popup__container bgcolor_fff ask_popup'>
    <div class="weui-popup__overlay"></div>
    <div class="weui-popup__modal bgcolor_fff">
        <!-- 头部条 start -->
        <header class="header_bar max750 relative">
            <a href="javascript:void(0);" class="btn_cancel1 color_gray999 f24 text_left block  pl20 ml10">取消</a>
            <a href="javascript:void(0);" class="btn_link btn_submit1 color_gray999 f24">提交</a>
        </header>
        <!-- 头部条 end -->
        <!-- 表单区 start -->
        <div class="ask_con">
            <div class="iptBox">
                <input type="text" id="tit1" placeholder="请用一句话描述问题并以问号结尾（最多50字）" value="{{$question->title}}" maxlength="50" />
            </div>
            <!--<div class="textareaBox">
                <textarea placeholder="请您添加问题描述" id="content"></textarea>
            </div>-->
            <div class="">
                <textarea name=""  class="text-adaption fz f28" placeholder="请您添加问题描述"  id="content1" rows="3">{{$question->desc}}</textarea>
            </div>
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <div class="weui-uploader">
                            <div class="weui-uploader__bd">
                                <ul class="weui-uploader__files img_list1" id="uploaderFiles">
                                    <?php
                                        $img_url = $question->img_url;
                                        $imgArr = explode(',',$img_url);

                                    ?>
                                    @if($img_url)
                                    @foreach($imgArr as $arr)
                                    @if(!empty($arr))
                                    <li>
                                        <img src="{{env("IMG_URL")}}{{$arr}}" alt="" class="img100" />
                                        <div class="operation">
                                            <span class="btn_del" onclick="btn_delimg1(this)" data-url="{{$arr}}"></span>
                                        </div>
                                    </li>
                                    @endif
                                    @endforeach
                                    @endif
                                </ul>
                                <div class="weui-uploader__input-box">
                                    <input id="uploaderAsk" class="weui-uploader__input" type="file" accept="image/*" multiple="">
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
<!--放大-->
<div class="big_img">
    <div class="swiper-container2">
        <div class="swiper-wrapper"></div>
    </div>
    <div class="swiper-pagination"></div>
</div>

<br><br><br><br/><br/><br/>
<!-- 底部固定导航条 start -->
<div class="relative">
    <div class="fixed_bottom_4 clearfix">
        <a href="/"><span class="icon-home"></span></a>
        <a href="/article/0.html"><span class="icon-find"></span></a>
        <a href="/cak/1.html" class="on"><span class="icon-ask"></span></a>
        <a href="/user/studying"><span class="icon-study"></span></a>
        <a href="/user/index"><span class="icon-my"></span></a>
    </div>
</div>
<!-- 底部固定导航条 end -->


<script src="/js/ask.js"></script>


<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->
<script type="text/javascript" src="/js/base64/localResizeIMG.js"></script>
<script type="text/javascript" src="/js/base64/mobileBUGFix.mini.js"></script>
<script type="text/javascript">
    var question_id = '{{$question->id}}'
    var orderDesc = '{{$order}}'
    //给body加一个类（为了弹窗有个父类）
    $('body').addClass('page_dialog_wrap');

    //展开
    $('.btn_open').click(function (){
        $(this).hide();
        $(this).parents('.daoshizuoye_box').find('.imgs').show();
    });


    //取消
    $('.btn_cancel').click(function (){
        layer.open({
            title: '',
            content: '是否放弃提问',
            id: 'mylayer',
            closeBtn: 0, //不显示关闭按钮
            btn: ['放弃', '继续回答'],
            yes: function(index, layero) {
                //【放弃按钮】的回调
                layer.closeAll();
                $.closePopup();//关闭弹出框
                $('#tit').val('');
                $('#content').val('');

            },
            btn2: function(index, layero) {
                //【继续回答】的回调

            }
        });
    })
    $('.btn_cancel1').click(function (){
        layer.open({
            title: '',
            content: '是否放弃修改',
            id: 'mylayer',
            closeBtn: 0, //不显示关闭按钮
            btn: ['放弃', '继续回答'],
            yes: function(index, layero) {
                //【放弃按钮】的回调
                layer.closeAll();
                $.closePopup();//关闭弹出框
                var data = {qid:question_id ,_token:'{{csrf_token()}}'};
                $.ajax({
                    url:'/cak/modquest',
                    data:data,
                    type:'POST',
                    dataType:'json',
                    success:function(res){
                        if(res.code == 0){
                            layer.msg('修改成功');
                            layer.closeAll();
                            $.closePopup();//关闭弹出框
                        }
                    }
                });
            },
            btn2: function(index, layero) {
                //【继续回答】的回调

            }
        });
    })


    // clickDel 删除
    $('.clickDel').click(function (){
        layer.open({
            title: '',
            content: '你确定要删除此问题吗？',
            id: 'mylayer2',
            closeBtn: 0, //不显示关闭按钮
            btn: ['取消','确定'],
            yes: function(index, layero) {
                //【放弃按钮】的回调
                layer.closeAll();
            },
            btn2: function(index, layero) {
                //【确定】的回调

                var data = {qid:question_id,_token:'{{csrf_token()}}'}
                $.ajax({
                    url:'/cak/delquest',
                    data:data,
                    type:'POST',
                    dataType:'json',
                    success:function(res){
                        if(res.code == 0){
                            layer.closeAll();
                            window.location.href="/cak/1.html";
                        }
                    }

                })

            }
        });
    })

    /*超出出现【全文】*/
//    $(function(){
//
//        var slideHeight = 68; // px
//        var defHeight = $('.HrefWrap').height();
//
//        $('.HrefWrap').each(function(i){
//            var defHeight = $(this).height();
////alert(defHeight);
//            if(defHeight >= slideHeight){
//                var askInfo = $('.HrefWrap').eq(i).attr('data-id');
//                var askArr = askInfo.split('_');
//
//                var url = '/cak/comment/'+askArr[0]+'.html';
//                $('.ConHref').eq(i).bind('click',function(){
//                    window.location.href = url;
//                });
//                $('.HrefWrap').eq(i).css('height' , slideHeight + 'px');
//                $('.HrefWrap').eq(i).next('.read-more').html('<a href="'+url+'">...全文</a>');
//                $('.HrefWrap').eq(i).next('.read-more a').click(function(){
//                    var curHeight = $('.HrefWrap').height();
//                    //console.log(333)
//                    if(curHeight == slideHeight){
//                        //					window.location.href="http://www.baidu.com"
//                    }else{
//
//                    }
//                    return false;
//                });
//            }else{
//
//            }
//        })
//
//    });


    /*swiper弹出大图并轮播 start*/
    $(document).ready(function () {
        /*调起大图 S*/
        var mySwiper = new Swiper('.swiper-container2', {
            loop: false,
            pagination: '.swiper-pagination',
            paginationType: 'fraction'
        })
        $(".ImgMax").on("click", ".post img",
                function () {
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
    var page = 2;
    function loadMore(obj){
        var load = $(obj).val();
        var data = {page:page,qid:question_id};
        $.ajax({
            url:'/cak/loadAnswer',
            data:data,
            type:'GET',
            dataType:'json',
            success:function(res){

                if(res.code == 0){
                    if(res.hasMore == 0){
                        $('.Load').text('暂无更多');
                    }
                    $(".list_daoshizuoye").append(res.data.body);
                    page++;
                }
            }
        });
    }




    var imgurl_list = "";
    var _token      = '{{csrf_token()}}';
    var imgUrl      = "{{env('IMG_URL')}}";
    var img_number  = 0;
    var c_length    = 0;
    $('#uploaderAnswer').localResizeIMG({
        width:800,// 宽度
        quality: 0.8, // 压缩参数 1 不压缩 越小清晰度越低
        success: function (result) {
//            console.log(result);
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
                        if(img_number>=2){
                            $("#upload_button").hide();
                        }else{
                            img_number++;
                        }
                        $("#cur_span"+c_length).attr("data-url", data.url);
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
            data:  {imgurl:imgurl, _token:_token},
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

                    //判断上传按钮是否显示
                    if(img_number<3){
                        $("#upload_button").show();
                    }else{
                        img_number--;
                    }
                }
            }
        });
    }


    //创建作业提交按钮
    $('.btn_submit').click(function (){
        imgurl_list = "";
        $(".img_url_list").each(function(){
            var cur = $(this).attr("data-url");
            imgurl_list+=cur+",";
        });

//        var tit = $('#tit').val();
        var con = $('#content').val();
        if(!con){
            layer.msg('内容不能为空');
        }else{
            var that = this;
            $(this).addClass('disabled-ask');

            $.ajax({
                url : '/cak/addanswer',
                type : 'post',
                dataType : 'json',
                data : {content:con, qid:question_id,img_url:imgurl_list, _token:_token},
                success : function (data) {
                    if(data.code==0){
                        window.location.href='/cak/answer/'+question_id+'/'+orderDesc+'.html';
                    }else{
                        if(data.code == 2){
                            $(that).removeClass('disabled-ask');
                            layer.msg(data.message);
                            $.closePopup();//关闭弹出框
                            window.location.href='/login?redirect=/cak/answer/'+question_id+'/'+orderDesc+'.html';
                        }else{
                            $(that).removeClass('disabled-ask');
                            layer.msg(data.message);
                            $.closePopup();//关闭弹出框
                        }


                    }
                }
            });
            $.closePopup();//关闭弹出框
        }
    })


    var imgurl_list1 = "";
    var img_number1  = 0;
    var c_length1    = 0;
    $('#uploaderAsk').localResizeIMG({
        width:800,// 宽度
        quality: 0.8, // 压缩参数 1 不压缩 越小清晰度越低
        success: function (result) {
//            console.log(result);
            var img = new Image();
            img.src = result.base64;
            c_length1 = $(".img_url_list1").length;
            c_length1++;
            $(".img_list1").append('<li style="background-image: url('+img.src+')"><div class="operation"><span class="btn_del img_url_list1" onclick="btn_delimg1(this)" id="cur1_span'+c_length1+'" data-url=""></span></div></li>');
            $.ajax({
                url: "{{url('ask/fileuploadbase')}}",
                type: "POST",
                data:  {file:img.src, _token:_token},
                dataType:'json',
                success: function (data) {
                    if(data.code==0){
                        if(img_number1>=2){
                            $("#upload_button").hide();
                        }else{
                            img_number1++;
                        }
                        $("#cur1_span"+c_length1).attr("data-url", data.url);
                    }
                }
            });
        }
    });
    //删除图片
    var btn_delimg1 = function(e){
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
                    imgurl_list1 = "";
                    //删除图片重新计算图片地址
                    $(".img_url_list1").each(function(){
                        var cur = $(this).attr("data-url");
                        imgurl_list1+=cur+",";
                    });

                    //判断上传按钮是否显示
                    if(img_number1<3){
                        $("#upload_button").show();
                    }else{
                        img_number1--;
                    }
                }
            }
        });
    }


    //创建作业提交按钮
    $('.btn_submit1').click(function (){
        imgurl_list1 = "";
        $(".img_url_list1").each(function(){
            var cur = $(this).attr("data-url");
            imgurl_list1+=cur+",";
        });

        var tit = $('#tit1').val();
        var con = $('#content1').val();
        if(!tit){
            layer.msg('标题不能为空');
        }else if(!con){
            layer.msg('内容不能为空');
        }else{
            var that = this;
            $(this).addClass('disabled-ask');

            $.ajax({
                url : '/cak/addQuestion',
                type : 'post',
                dataType : 'json',
                data : {title:tit, desc:con, qid:question_id,img_url:imgurl_list1, _token:_token},
                success : function (data) {
                    if(data.code==0){
//                        window.location.href='';
                        $(".tit").text(tit);
                        $(".desc").text(con);
                    }else{
                        $(that).removeClass('disabled-ask');
                        if(data.code == 2){
                            layer.msg(data.message);
                            $.closePopup();//关闭弹出框
                            window.location.href='/login?redirect=/cak/user/add.html';
                            return false;
                        }
                        layer.msg(data.message);
                        $.closePopup();//关闭弹出框
                    }
                }
            });
            $.closePopup();//关闭弹出框
        }
    })
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

    var link = window.location.href;
    var title = '{{$question->title}}';
    var desc = '赛普知道——健身教练的问答平台';
    var img = 'http://m.saipubbs.com/zt/know.jpg';
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: img, // 分享图标

        }, function(res) {
            //这里是回调函数

        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: title, // 分享标题
            link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: img, // 分享图标

        }, function(res) {
            //这里是回调函数

        });
    });

</script>
@endsection