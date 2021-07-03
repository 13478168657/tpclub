<!doctype html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>赛普千人减脂大比拼之人气投票选手详情</title>
	<link rel="stylesheet" href="/fat/lib/swiper/swiper.min.css">
	<link rel="stylesheet" href="/fat/css/font-num40.css">
    <link rel="stylesheet" href="/fat/css/mp.css">
	<link rel="stylesheet" href="/fat/css/reset.css">
	<link rel="stylesheet" href="/fat/css/index.css?id={{rand(1,100)}}">
	<script src="/fat/js/rem.js"></script>
    @include('layouts.baidutongji')
</head>

<body>
<!-- banner-->
<img src="/fat/images/ban.jpg" alt="" class="img100">

<!-- 公共列表 start -->
<h3 class="text_center lt f48 pt120 pb15">“赛普千人减脂”大作战</h3>
<div class="hear-box text_center">
    <ul class="clearfix">
        <li>
            <img src="/fat/images/icon-yibaoming.png" alt="" class="img100">
            <p class="lt f26">已报名</p>
            <p class="fz f24">{{$redisData['members']}}</p>
        </li>
        <li>
            <img src="/fat/images/icon-renci.png" alt="" class="img100">
            <p class="lt f26">投票总数</p>
            <p class="fz f24">{{$redisData['fat_activity_votes']}}</p>
        </li>
        <li>
            <img src="/fat/images/icon-fangwen.png" alt="" class="img100">
            <p class="lt f26">访问次数</p>
            <p class="fz f24">{{$redisData['fat_activity_views']}}</p>
        </li>
    </ul>
</div>
<!-- 公共列表 end -->


<!-- 倒计时 srtat-->
<div class="clearfix djsBox text_center mt30">
    <p class="text_right">投票结束倒计时</p>
    <div class="ft_counter clearfix"></div>
</div>
<!-- 倒计时 end-->

<div class="page_index">
	<!-- 活动介绍 start -->
	<div class="action mlr30 mt50">
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

	<!-- 搜索表单 start -->
	<div class="form_search mlr30 mt50">
		<input type="text" value="{{$name}}" id="uname" placeholder="按照学员姓名/编号" />
		<button class="search_btn" type="button">搜索</button>
	</div>
	<!-- 搜索表单 end -->

	<!-- 投票列表 start -->
	<div class="vote_list mlr30 mt50">
		<ul class="rankList clearfix">
            @foreach($rankLists as $k => $stu)
			<li>
				<div class="inner">
                    <a href="/fat/member/{{$stu->id}}.html" class="block">
                        <span class="number font-Impact"><b>{{$stu->id}}</b></span>
                        <div class="thumb">
                            <img src="{{env('IMG_URL')}}{{$stu->cover_img}}" class="img100" alt="" />
                        </div>
                        <div class="clearfix info mt20">
                            <div class="fl">
                                <span class="name lt">{{$stu->name}}</span>
                                <?php
                                    if($stu->object == 'staff'){
                                        $identify = '员工';
                                        $tag_color = 'tag_orange';
                                    }elseif($stu->object == 'teacher'){
                                        $identify = '教师';
                                        $tag_color = 'tag_purple';
                                    }else{
                                        $identify = '学员';
                                        $tag_color = 'tag_green';
                                    }
                                ?>
                                <label class="tag {{$tag_color}}">{{$identify}}</label>
                            </div>
                            <div class="fr lt"><span class="votesinfo">{{$stu->votes}}</span>票</div>
                        </div>
                    </a>
					<div class="btn mt20">
						<button class="user_vote" onclick="voteFunc(this)" data-id="{{$stu->id}}">投票</button>
					</div>
				</div>
			</li>
            @endforeach

		</ul>
        <!-- 加载更多-->
        @if($hasPage)
        <div class="weui-loadmore">
            <i class="weui-loading"></i>
            <span class="weui-loadmore__tips">正在加载</span>
        </div>
        @endif

        <!-- <div class="mlr30 plr60 pt20 pb60">
            <button class="btn_confirm f48 lt">确认报名</button>
        </div> -->
	</div>
	<!-- 投票列表 end -->
</div>

<br/>
<br/>
<br/>
<!-- 弹出的验证码 start -->
<div class="layer_code_con text_center hide">
    <div class="head f36 bold">
        <p>验证码</p>
    </div>
    <div class="content fz">
        <div class="box clearfix">
            <input type="button" id="code" class="f36 fz text_center">
            <p class="f24 refresh">换一张<img src="/fat/images/f5.png" alt=""></p>
        </div>
        <input type="text" id="input" placeholder="请输入验证码" class="fz f28">
    </div>
    <div class="foot lt f36">
        <button id="check">提交</button>
    </div>
</div>
<!-- 弹出的验证码 end -->


@include('a.fat.footer',['type'=>1])

<script src="/fat/js/jquery-1.11.2.min.js"></script>
<!-- 倒计时 -->
<script src="/fat/lib/djs/jquery.easing.js"></script>
<script src="/fat/lib/djs/fliptimer.js"></script>
<script src="/fat/lib/jqweui/js/fastclick.js"></script>
<script src="/fat/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/fat/lib/layer/layer.js"></script>
<script src="/fat/lib/swiper/swiper.js"></script>
<link href="/fat/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
<link href="/fat/lib/jqweui/css/jquery-weui.css" rel="stylesheet" type="text/css" />
<script src="/fat/lib/jqweui/js/jquery-weui.min.js"></script>
<script type="text/javascript">
    //弹出验证码
    $(".btn_confirm").click(function(){

    });
    var voteNum = 0;
    var token = '';
    var mid = 0;
    var obj   = '';
    //验证码
    function change(){
        code=$("#code");
        // 验证码组成库
        var arrays=new Array('1','2','3','4','5','6','7','8','9','0',
                'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
                'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        codes='';// 重新初始化验证码
        for(var i = 0; i<5; i++){
            // 随机获取一个数组的下标
            var r = parseInt(Math.random()*arrays.length);
            codes += arrays[r];
        }
        // 验证码添加到input里
        code.val(codes);
    }
    change();
    code.click(change);
    $(".refresh").click(change);
    //单击验证
    $("#check").click(function(){
        var inputCode = $("#input").val().toUpperCase(); //取得输入的验证码并转化为大写
        console.log(inputCode);
        if(inputCode.length == 0) { //若输入的验证码长度为0
            layer.msg("请输入验证码！"); //则弹出请输入验证码
        }
        else if(inputCode!=codes.toUpperCase()) { //若输入的验证码与产生的验证码不一致时
            layer.msg("请输入正确的验证码！"); //则弹出验证码输入错误
            change();//刷新验证码
            $("#input").val("");//清空文本框
        }else { //输入正确时
//            layer.msg("正确"); //弹出^-^
            layer.closeAll();
            voteNum += 1;
            var data = {mid:mid,_token:token};
            layer.load(2, {shade: [0.5,'#000']});
            $.ajax({
                data:data,
                type:'POST',
                url:'/fat/user/vote',
                dataType:'json',
                success:function(res){
                    layer.closeAll('loading');
                    if(res.code == 1){
                        layer.msg(res.message);
                        window.location.href = '/login?redirect=/fat/index';
                    }
                    layer.msg(res.message);
                    if(res.code==0){

                        console.log(hasPage);
                        var voteinfo = obj.parent().prev().find("span[class='votesinfo']").text();
                        obj.parent().prev().find("span[class='votesinfo']").text(voteinfo-0+1);
                    }
                }
            })
        }
    });

    $(function (){
//		$('.btn').click(function(){
//			alert('点我干嘛');
//		});

        var hasPage = '{{$hasPage}}';
//        voteFunc(object);

        $(".search_btn").click(function(){
            var name = $('#uname').val();
            var data = {name:name};
            hasPage = 0;
            $.ajax({
                url:'/fat/user/search',
                data:data,
                Type:'GET',
                dataType:'json',
                success:function(res){

                    if(res.code == 0){
                        $('.rankList').html(res.data.body);
//                        voteFunc();
                    }
                }
            });
        });
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
        });

        //加载更多...
        var page = 2;
        var loading = false;  //状态标记

        $(document.body).infinite().on("infinite", function() {
            if(hasPage){
                $(".weui-loadmore").show();
            }else{
                $(".weui-loadmore").hide();
                return;
            }

            if(loading) return;
            loading = true;
            if(hasPage){
                setTimeout(function() {
                    var data = {page:page};
                    $.ajax({
                        url:'/fat/index/load/more',
                        data:data,
                        type:'GET',
                        dataType:'json',
                        success:function(res){
                            console.log(res);
                            page++;
                            $(".rankList").append(res.data.body);

                            $(".weui-loadmore").hide();
                            loading = false;
                            hasPage = res.data.hasPage;
                        }
                    });
//                $(".vote_list ul").append("<p> 我是新加载的内容 </p >");

                }, 1000);   //模拟延迟
            }

        });
	});

    function voteFunc(object){

        token = '{{csrf_token()}}';
        mid = $(object).attr('data-id');
        obj   = $(object);
        if(voteNum == 0){
            layer.open({
                type: 1,
                title: false, //不显示标题栏
                skin: 'layer_code_box', //样式类名
                id: 'layer_code_box', //设定一个id，防止重复弹出
                closeBtn: 1, //不显示关闭按钮
                anim: 2,
                shadeClose: false, //开启遮罩关闭
                area: ['99%', 'auto'],
                content:$('.layer_code_con'),
                btn: false
            });
            return;
        }

        voteNum += 1;
        var data = {mid:mid,_token:token};
        layer.load(2, {shade: [0.5,'#000']});
        $.ajax({
                data:data,
                type:'POST',
                url:'/fat/user/vote',
                dataType:'json',
                success:function(res){
                    layer.closeAll('loading');
                    if(res.code == 1){
                        layer.msg(res.message);
                        window.location.href = '/login?redirect=/fat/index';
                    }
                    layer.msg(res.message);
                    if(res.code==0){

                        console.log(hasPage);
                        var voteinfo = obj.parent().prev().find("span[class='votesinfo']").text();
                        obj.parent().prev().find("span[class='votesinfo']").text(voteinfo-0+1);
                    }
                }
            })

    }

</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<script type="text/javascript">
    //针对苹果手机键盘的复位
    $("input").blur(function () {
        setTimeout(function() {
            var scrollHeight = document.documentElement.scrollTop || document.body.scrollTop || 0;
            window.scrollTo(0, Math.max(scrollHeight - 1, 0));
        }, 100);
    });
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