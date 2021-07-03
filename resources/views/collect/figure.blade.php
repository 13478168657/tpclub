@extends('layouts.header')
@section('title')
    <title>个人收藏{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link href="/lib/swiper/swiper.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/my.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')

    <div class="bgcolor_fff plr20">
    <div class="tab_class pt40 pb30 mlr30 plr20">
        <a href="/user/collect/1.html" class="d-in-black f28 color_gray999 fz ">课程</a>
        <a href="/user/collect/2.html" class="d-in-black color_333 f30 fz bold tab_class_figure">图文</a>
    </div>
    <!--列表 start-->
    <div class="list-art" id="list">
        <ul id="article_list_id">
            @foreach($collectArticles as $article)
                <?php

                    $art = $article->article;
                    if(!$art){
                        continue;
                    }
                ?>
            <li class="pt30 pb30">
                <a href="/article/detail/{{$art->id}}.html">
                    <dl class="clearfix relative">
                        <dt class="border-radius-img"><img src="{{env('IMG_URL')}}{{$art->cover_url}}" alt="" /></dt>
                        <dd>
                            <h3 class="lt f30 color_333 text-overflow2 text-overflow">{{$art->title}}</h3>
                            <div class="weui-cells nobefore noafter padding0 art-list-title mt0">
                                <div class="weui-cell nobefore noafter padding0 mt20">
                                    <div class="weui-cell__hd border-radius50">
                                        @if($art->author)
                                            @if(strpos($art->author->avatar,'http') !== false)
                                                <img src="{{$art->author->avatar}}">
                                            @else
                                                <img src="{{env('IMG_URL')}}{{$art->author->avatar}}">
                                            @endif
                                        @else
                                            <img src=""/>
                                        @endif
                                    </div>
                                    <div class="weui-cell__bd f28 fz color_gray666 ">
                                        <p>{{$art->author?$art->author->name:''}}</p>
                                    </div>
                                </div>
                                <div class="weui-cell nobefore noafter padding0 mt10">
                                    <div class="weui-cell__bd">
                                        <p class="color_gray9b f22 fz">{{date('Y.m.d',strtotime($article->created_at))}}</p>
                                    </div>
                                    <div class="weui-cell__ft fz f20 color_gray9b yudu-img">
                                        <span class=""><img src="/images/icon-xiao-xihuan.png" alt="">{{$art->likes}}</span>
                                        <span class="pl20"><img src="/images/icon-xiao-yuedu.png" alt="">{{$art->views}}</span>
                                    </div>
                                </div>
                            </div>
                        </dd>
                    </dl>
                </a>
            </li>
            @endforeach


        </ul>
    </div>

    <!--列表 end-->

    <!--加载更多-->
    @if($collectArticles->count())
    <div class="weui-loadmore more text_center fz ptb30 remove_attr " id="study_more">
        <span class="weui-loadmore__tips" id ="add_more"  data-is_ture='1'>加载更多</span>
    </div>
    @else
        <div class="weui-loadmore more text_center fz ptb30 remove_attr " id="study_more">
            <span class="weui-loadmore__tips" id ="add_more"  data-is_ture='1'>暂无文章</span>
        </div>
    @endif
    {{--<div class="weui-loadmore more text_center fz ptb30">--}}
        {{--<i class="weui-loading"></i>--}}
        {{--<span class="weui-loadmore__tips">正在加载</span>--}}
    {{--</div>--}}


    <br><br>
</div><!--白色背景层 end-->



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

<script src="/lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
    $(function() {
        FastClick.attach(document.body);
    });
</script>


<script src="/lib/jqweui/js/jquery-weui.js"></script>
<script>
    var page = 2;
    $('#add_more').click(function(){
        var data = {page:page,type:'article'};
        $.ajax({
            url:'/collect/addmore/course',
            data:data,
            type:'GET',
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    page = page +1;
                    $("#article_list_id").append(res.body);
                }else{
                    $("#add_more").removeClass('seach_more_class');
                    $("#add_more").text(res.msg);
                }
            }
        });
    });

</script>
@endsection