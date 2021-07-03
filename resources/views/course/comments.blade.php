@extends('layouts.header')
@section('title')
    <title>课程评价{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/xueyuan.css">
    <!--jqweui css-->
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth/18.75 + "px";
        })()
    </script>
@endsection
@section('content')
<!-- <header class="header_bar bgc_grey relative" style="background-color: #f2f2f2;">
    <a href="javascript:history.go(-1);" class="btn_back"><i class="icon iconfont icon-fenxiang2"></i></a>
    <h1 class="cat" style="margin:0">评价列表</h1>
</header> -->
    <ul class="mlr30 new_my" id="comment_list">
        <li>
            <div class="weui-cells nobefore noafter mt0 my_income">
            @if(!$is_true)
                @if(is_baoming($course_class_id,$userid) == 1 || expericence_card_isture($course_type_id,$userid) == 1)
                <a class="weui-cell weui-cell_access xueyuan_ping nobefore noafter" href="/course/commentadd/{{$course_class_id}}">
                @else
                <a class="weui-cell weui-cell_access xueyuan_ping nobefore noafter" href="javascript:;" onclick="layer.msg('报名后才能评价')">
                @endif    
            @else
            <!-- <a class="weui-cell weui-cell_access xueyuan_ping nobefore noafter" onclick="disadd()"> -->
            <a class="weui-cell weui-cell_access xueyuan_ping nobefore noafter" href="/course/commentadd/{{$course_class_id}}">    
            @endif 
                <div class="f30 color_333 weui-cell__bd lt">全部评价</div>
                <div class="weui-cell__ft f24 fz color_4a noafter padding0">我也要评价<div class="ping_icon"><img src="/images/icon_ping.png" alt=""></div></div>        
            </a>
        </div> 
        </li>
        <!--全部评价 start-->
        @foreach ($comments as $v)
            <li id="comment_item_{{$v->id}}">
                <div class="weui-cells nobefore noafter mt0 news-tit ptb30">
                    <a class="weui-cell weui-cell_access padding0" href="javascript:;">
                        <div class="weui-cell__hd ping_img">
                            @if($v->users && strpos($v->users->avatar,'http') !== false)
                            <img class="border-radius50" src="{{$v->users->avatar}}">
                            @elseif($v->users)
                            <img class="border-radius50" src="{{env('IMG_URL')}}{{$v->users->avatar}}">

                            @endif
                        </div>
                        <div class="weui-cell__bd text-overflow">
                            <h2 class="lt f26 color_000">{{$v->users?$v->users->name : ''}}</h2>
                            <div class="ping_start">
                                <?php
                                  echo  htmlspecialchars_decode(stars($v->score,'comments'))
                                ?>
                                <span class="fz color_4a f22">{{$v->score}}.0&nbsp;分</span>
                            </div> 
                        </div>
                        <div class="fz f22 color_c9c7c7 mb40">{{App\Constant\CommentDate::getDate($v->created_at)}}</div>
                    </a>
                    <p class="f24 color_gray666 new_ping ping_txt mt20 text-jus">{{$v->content}}</p>
                    @if($userid==$v->user_id)
                    <div class="weui-cell__ft news-r-img del_comment" data-id="{{$v->id}}">
                        <img src="/images/del.png" />
                    </div>
                    @endif
                </div>
            </li>
        @endforeach    
        <!--全部评价 end-->
    </ul>
    @if($comments->count())
    <div class="weui-loadmore more text_center fz ptb30">
        <!-- <i class="weui-loading"></i> -->
        <span class="weui-loadmore__tips" id="comment_more" data-is_ture='1'>加载更多</span>
    </div>
    @else
    <div class="weui-loadmore more text_center fz ptb30">
        <span class="weui-loadmore__tips">暂无评论</span>
    </div>
    @endif

<!--课程目录 end-->
<script>
    var imgUrl  = "{{env('IMG_URL')}}";  //图片公共地址
    var token   = '{{csrf_token()}}';   //验证token
    $(function() {
        FastClick.attach(document.body);
    });
    var disadd = function(){
        layer.msg('抱歉~不能重复评论哦');
    }
    $(document).ready(function() {
        //加载更多
        var page = 1;
        $("#comment_more").click(function(){
            page++;
            var type   = 'follow';
            var course_class_id = {{$course_class_id}};
            //如果没有数据就不再请求数据库了
            var is_ture= $(this).attr('data-is_ture');
            if(is_ture<1){
                layer.msg('抱歉没有更多的数据了');
                return;
            }
            $.ajax({
                type:"GET",
                url:"/course/commentmore",
                data:{course_class_id:course_class_id, page:page},
                dataType:"json",
                success:function(result){
                    //console.log(result);
                    if(result.code==1){
                        for (var item in result.list) {
                            if((result.list[item].user_avatar).indexOf("http") > -1){
                                var img = result.list[item].user_avatar;
                            }else{
                                var img = imgUrl+result.list[item].user_avatar;
                            }
                            if(result.list[item].user_name){
                                var name = result.list[item].user_name;
                            }else{
                                var name = "--";
                            }
                            $("#comment_list").append('<li>'+
                                    '<div class="weui-cells nobefore noafter mt0 news-tit ptb30">'+
                                    '<a class="weui-cell weui-cell_access padding0" href="javascript:;">'+
                                    '<div class="weui-cell__hd ping_img"><img class="border-radius50" src="'+img+'"></div>'+
                                    '<div class="weui-cell__bd text-overflow">'+
                                    '<h2 class="lt f26 color_000">'+name+'</h2>'+
                                    '<div class="ping_start">'+result.list[item].stars+
                                    '<span class="fz color_4a f22">'+result.list[item].score+'.0 分</span>'+
                                    '</div>'+
                                    '</div>'+
                                    '<div class="fz f22 color_c9c7c7 mb40">'+result.list[item].created_a+'</div>'+
                                    '</a>'+
                                    '<p class="f24 color_gray666 new_ping ping_txt mt20 text-jus">'+result.list[item].content+'</p>'+
                                    '</div>'+
                                    '</li>');
                        }
                    }else{
                        $("#comment_more").attr('data-is_ture', 0);
                        $("#comment_more").text('抱歉没有更多的数据了');
                        layer.msg(result.msg);
                    }
                }
            });
        });

        //删除评论
       
        $(".del_comment").click(function(){
            var comment_id = $(this).attr("data-id");
            var comment_item_id = "comment_item_"+comment_id;
            $.closePopup()
                $.confirm({
                    title: '提示',
                    text: '确认删除该评论吗？',
                    onOK: function () {
                        $.ajax({
                            type:"POST",
                            url:"/course/commentdel",
                            data:{comment_id:comment_id, _token:token},
                            dataType:"json",
                            success:function(result){
                                if(result.code==1){
                                    $("#"+comment_item_id).remove();
                                    layer.msg(result.msg);
                                }else{
                                    layer.msg(result.msg);
                                }
                            }
                        });
                    },
                    onCancel: function (){

                    }
                });

        });
        $(".del_comment-").click(function(){
            var comment_id = $(this).attr("data-id");
            var comment_item_id = "comment_item_"+comment_id;
            $.ajax({
                type:"POST",
                url:"/course/commentdel",
                data:{comment_id:comment_id, _token:token},
                dataType:"json",
                success:function(result){
                    if(result.code==1){
                        $("#"+comment_item_id).remove();
                        layer.msg(result.msg);
                    }else{
                        layer.msg(result.msg);
                    }
                }
            });
        });
    });
</script>
@endsection