<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>排行榜</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/mp.css">
    <link rel="stylesheet" href="css/font-num40.css">
    <link rel="stylesheet" href="css/animation-btn.css">
    <link rel="stylesheet" href="css/index.css?id={{rand(1,100)}}">
    <script src="js/rem.js"></script>
    @include('layouts.baidutongji')
</head>
<body>
<div class="">

    <!-- banner-->
    <img src="images/ban.jpg" alt="" class="img100">

    <!-- 公共列表 start -->
    <h3 class="text_center lt f48 pt120 pb15">“赛普千人减脂”大作战</h3>
    <div class="hear-box text_center">
        <ul class="clearfix">
            <li>
                <img src="images/icon-yibaoming.png" alt="" class="img100">
                <p class="lt f26">已报名</p>
                <p class="fz f24">{{$redisData['members']}}</p>
            </li>
            <li>
                <img src="images/icon-renci.png" alt="" class="img100">
                <p class="lt f26">投票总数</p>
                <p class="fz f24">{{$redisData['fat_activity_votes']}}</p>
            </li>
            <li>
                <img src="images/icon-fangwen.png" alt="" class="img100">
                <p class="lt f26">访问次数</p>
                <p class="fz f24">{{$redisData['fat_activity_views']}}</p>
            </li>
        </ul>
    </div>
    <!-- 公共列表 end -->


    <!-- 倒计时 srtat-->
    <div class="clearfix djsBox text_center mt30">
        <p class="text_right">活动结束倒计时</p>
        <div class="ft_counter clearfix"></div>
    </div>
    <!-- 倒计时 end-->


    <!-- 活动介绍 start -->
    <div class="action mlr30 mt60">
        <h2 class="f48 text_center lt pt30 pb30">活动介绍</h2>
        <p>为了普及健身理念、推广“健身改变人生”，12月1日至12月28日，赛普号召师生及员工以身作则、行为表率，以降脂为号，开展21天千人减脂大比拼活动，120000元现金等你瓜分!</p>
        <div class="con mt30">
            <ul>
                <li class="mb20"><label class="bold f26">投票开始：</label>2020-12-06&nbsp;&nbsp;00:00</li>
                <li class="mb20"><label class="bold f26">投票结束：</label>2020-12-27&nbsp;&nbsp;18:00</li>
                <li><label class="bold f26">投票规则：</label></li>
                <li class="f26" style="color:red;">1、每个微信ID每天可投5票，截止12月27日18：00每个参赛选手每天1000票封顶。</li>
                <li class="f26" style="color:red;">2、12月27日00:00-12月27日18:00将放开参赛选手每天1000票的限制。</li>
                <li class="f26" style="color:red;">3、最终投票排行出现相同票数并列第一者，平均瓜分人气大奖奖金；</li>
                <li class="f26" style="color:red;">4、此次活动严禁任何作弊行为，禁止网络刷票、水军群求助，一经发现，取消获奖资格；</li>
                <li class="f26" style="color:red;">5、凡参与本次活动者，请详细阅读活动规则及相关条款，报名则视为同意活动规则；</li>
                <li class="f26" style="color:red;">6、此次投票过程中，有任何疑问请联系活动负责人凌莉18610190214。</li>
            </ul>
        </div>
    </div>
    <!-- 活动介绍 end -->


    <!-- 排行榜 start -->
    <h3 class="text_center lt f48 pt120 pb55">排行榜</h3>

    <!-- 搜索框 start -->
    <div class="searchBox mlr30 fz f26">
        <input type="text" placeholder="请选择您要查看的组别" class="btn_open" readonly="">
        <b><img src="images/icon-j3.png" alt=""></b>
    </div>
    <!-- 搜索框 end -->

    <div class="paihangbang plr30 pt40">
        <!-- 前三甲信息 start -->
        <div class="top_three">
            <ul class="clearfix">
                <?php
                    $firstUser = isset($rankLists[0])?$rankLists[0]:'';
                    $secondUser = isset($rankLists[1])?$rankLists[1]:'';
                    $thirdUser = isset($rankLists[2])?$rankLists[2]:'';
                ?>
                @if($secondUser)
                <li>
                    <a href="javascript:void (0)" class="block">
                        <div class="avatar_box">
                            <img src="images/top2.png" class="ico_hg" />
                            <img src="{{env('IMG_URL')}}{{$secondUser->cover_img}}" class="avatar border-radius2" alt="" />
                        </div>
                        <div class="name lt f24"><span>{{$secondUser->id}}号</span><span>{{$secondUser->name}}</span></div>
                        <div class="integral fz f24"><span>{{$secondUser->votes}}票</span></div>
                    </a>
                </li>
                @endif
                @if($firstUser)
                <li>
                    <a href="javascript:void (0)" class="block">
                        <div class="avatar_box">
                            <img src="images/top1.png" class="ico_hg" />
                            <img src="{{env('IMG_URL')}}{{$firstUser->cover_img}}" class="avatar border-radius2" alt="" />
                        </div>
                        <div class="name lt f24"><span>{{$firstUser->id}}号</span><span>{{$firstUser->name}}</span></div>
                        <div class="integral fz f24"><span>{{$firstUser->votes}}票</span></div>
                    </a>
                </li>
                @endif
                @if($thirdUser)
                <li>
                    <a href="javascript:void (0)" class="block">
                        <div class="avatar_box">
                            <img src="images/top3.png" class="ico_hg" />
                            <img src="{{env('IMG_URL')}}{{$thirdUser->cover_img}}" class="avatar border-radius2" alt="" />
                        </div>
                        <div class="name lt f24"><span>{{$thirdUser->id}}号</span><span>{{$thirdUser->name}}</span></div>
                        <div class="integral fz f24"><span>{{$thirdUser->votes}}票</span></div>
                    </a>
                </li>
                @endif
            </ul>
        </div>
        <!-- 前三甲信息 end -->

        <!-- 列表 start -->
        <div class="listBox mlr30 mt30">
            <ul>
                @foreach($rankLists as $k => $stu)
                    <?php
                      if($k <=2){
                          continue;
                      }
                    ?>
                <li>
                    <a href="javascript:void (0)" class="block">
                        <div class="wrap clearfix fz f30">
                            <p class="font-Impact">{{$k+1}}</p>
                            <p><img src="{{env('IMG_URL')}}{{$stu->cover_img}}" alt="" class="border-radius2"></p>
                            <p><span>{{$stu->id}}号</span><span>{{$stu->name}}</span></p>
                            <p class="f24">{{$stu->votes}}票</p>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        <!-- 列表 end -->
    </div>

</div>


<!--弹出 start -->
<div id="half-box" class="hide half-box text_center">
    <ul class="list">
        <li class="cur" data-id="r_rq" data-msg="最佳人气排行">人气</li>
        <li data-id="m_a" data-msg="男子A组减脂排行">男子A组</li>
        <li data-id="m_b" data-msg="男子B组减脂排行">男子B组</li>
        <li data-id="m_c" data-msg="男子C组减脂排行">男子C组</li>
        <li data-id="f_a" data-msg="女子A组减脂排行">女子A组</li>
        <li data-id="f_b" data-msg="女子B组减脂排行">女子B组</li>
        <li data-id="f_c" data-msg="女子C组减脂排行">女子C组</li>
        <li data-id="p_d" data-msg="专业组排行">专业组</li>
    </ul>
</div>
<!--弹出 end -->

<br><br>

@include('a.fat.footer',['type'=>3])
<script src="js/jquery-1.11.2.min.js"></script>
<!-- 倒计时 -->
<script src="lib/djs/jquery.easing.js"></script>
<script src="lib/djs/fliptimer.js"></script>
<script src="lib/layer/layer.js"> </script>
<script>
$(function (){
    $(".ft_counter").EightycloudsFliptimer({
        enddate    : "2020/12/27 17:59:59",/*GMT*/
        callback   : function(){
            alert("本活动已结束!");
        }
    });
    $(function (){
        //$(".ft_counter .EightycloudsFlipTimer .hours").after("<div class='clear'></div>");
        $('.ft_counter .EightycloudsFlipTimer .days .block_text').text('天');
        $('.ft_counter .EightycloudsFlipTimer .hours .block_text').text('时');
        $('.ft_counter .EightycloudsFlipTimer .minutes .block_text').text('分');
        $('.ft_counter .EightycloudsFlipTimer .seconds .block_text').text('秒');
    })


    //弹窗
    $('.btn_open').click(function(){
        layer.open({
            type: 1,
            title: false, //不显示标题栏
            skin: 'level_layer_wrap', //样式类名
            id: 'level_layer', //设定一个id，防止重复弹出
            closeBtn: 0, //不显示关闭按钮
            anim: 2,
            shadeClose: true, //开启遮罩关闭
            area: ['80%', '70%'],
            content:$(".half-box"),
            btn:false,
            success: function(){
                console.log("1111");
                //禁止滚动条
                $(document.body).css({
                    "overflow-x":"hidden",
                    "overflow-y":"hidden"
                });
            },
            end:function(){
                console.log("2222");
                //启用滚动条
                $(document.body).css({
                    "overflow-x":"auto",
                    "overflow-y":"auto"
                });
            }
        });
    });

    //点击layer里的列表高亮和替换按钮文字
    $('#half-box .list li').click(function (){
        var text=$(this).text();
        var group = $(this).attr('data-id');
        if(group=='r_rq'){
            window.location.href = window.location.href+'?nnn=67468548';
        }
        $(this).addClass('cur').siblings().removeClass('cur');
        $('.searchBox .btn_open').val(text);
        //关闭layer
        document.title = $(this).attr('data-msg');
        layer.closeAll();
        var data = {group:group};
        $.ajax({
            url:'/fat/group/rank',
            type:'GET',
            data:data,
            dataType:'json',
            success:function(res){

                $('.paihangbang').html(res.data.body);
            }

        })
    });
})
</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    var url  = window.location.href;
    var title= document.title;
    var desc = '健身改变人生，千人减脂大比拼';
    var share_img = "{{env('APP_URL')}}/images/wx_share.jpg";
    console.log(url);
    console.log(title);
    console.log(desc);
    console.log(share_img);
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

    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img, // 分享图标
            success: function(){

            }
        }, function(res) {
        //这里是回调函数

        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: title, // 分享标题
            link: url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img, // 分享图标
            success: function(){

            }
        }, function(res) {
        //这里是回调函数

        });
    });
</script>    
</body>
</html>