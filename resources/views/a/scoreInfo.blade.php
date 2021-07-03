<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>最真实的自恋测试你敢测吗？</title>
    <meta name="keywords" content="白白" />
    <meta name="description" content="" />
    <link rel="stylesheet" href="/activity/css/reset.css">
    <link rel="stylesheet" href="/css/swiper.min.css">
    <link rel="stylesheet" href="/activity/css/index.css">
    <link rel="stylesheet" href="/css/font-num40.css">
    <script src="/js/jquery-1.11.2.min.js"></script>

    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth/18.75 + "px";
        })()
    </script>
    <script type='text/javascript'>
        !function(e,t,n,g,i){e[i]=e[i]||function(){(e[i].q=e[i].q||[]).push(arguments)},n=t.createElement("script"),tag=t.getElementsByTagName("script")[0],n.async=1,n.src=('https:'==document.location.protocol?'https://':'http://')+g,tag.parentNode.insertBefore(n,tag)}(window,document,"script","assets.growingio.com/2.1/gio.js","gio");
        gio('init','aef8110bebdb6dd5', {});
        gio('send');
    </script>
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?dfdc7fd30fc0493e9d74e7be9f7e6e7c";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
</head>
<body class="max750">

<!-- 右上角音乐按钮 satrt-->
<!-- <div class="music" id="musicControl">
   <a id="mc_play" class="on" onclick="play_music();">
       <audio id="musicfx" src="小跳蛙.mp3" loop="loop" autoplay="autoplay"></audio>
   </a>
</div> -->
<!-- 右上角音乐按钮 end-->
<div class="swiper-container">
    <div class="swiper-wrapper">
        <!-- 第一屏 start -->
        <div class="swiper-slide swiper-no-swiping page13" id="13f">
            <div class="page13_wrap text_left">
                @if($name)
                <h2 class="lt f50" style="margin-bottom:10px;">{{$name}}</h2>
                @endif
                <h2 class="lt f50">成绩：<span class="fz">{{$score}}分</span></h2>
                <div class="icon">

                    @if($score > 85)
                        <p class="f60 lt file_txt text-overflow2">你的健身才华配得上你的自恋！</p>
                        <img src="/activity/images/img5.png" alt="">
                    @elseif($score >= 50 && $score <= 85)
                        <p class="f60 lt file_txt text-overflow2">走自己的S型 让别人无路可走！</p>
                        @if($score == 50)
                            <img src="/activity/images/img4.png" alt="">
                        @elseif($score == 55 || $score == 60 || $score == 65 || $score == 70 || $score == 80)
                            <img src="/activity/images/img2.png" alt="">
                        @else
                            <img src="/activity/images/img5.png" alt="">
                        @endif
                    @elseif($score >= 15 && $score <= 45)
                        <p class="f60 lt file_txt">咳咳，麻烦收敛下胸肌，刺到别人就不好！</p>
                        @if($score == 15)
                            <img src="/activity/images/img6.png" alt="">
                        @elseif($score == 20 || $score == 30 || $score == 35)
                            <img src="/activity/images/img1.png" alt="">
                        @elseif($score == 40 || $score ==  45)
                            <img src="/activity/images/img4.png" alt="">
                        @endif
                    @elseif($score == 0)
                        <p class="f60 lt file_txt text-overflow2">你的自恋指数是别人开火箭也追不上的！</p>
                        <img src="/activity/images/img7.png" alt="">
                    @endif
                </div>
            </div>
            <div class="page13_bottom">
                <div class="file_text">
                    <img src="/activity/images/pingyu.png" alt="">
                    <p class="f26 fz text-overflow4 mt30 text_left">
                        @if($score == 100)
                            徒手器械随意玩转，厉害了<br>懂健身也懂保护自己的好宝宝<br>看家本领都难不住你，确认过眼神<br>你是能当王者的人
                        @elseif(in_array($score,[15,20,30,35,40,45]))
                            同学，是谁给你的自恋勇气？梁静茹吗？<br>2019年希望你做成为懂健身也能保护好自己的好宝宝哦
                        @elseif(in_array($score,[50,55,60,65,70,75,80,85]))
                            超级大肌霸必须是你，2018年你用生命健身，希望2019年你继续保持自己的曲线，让他们羡慕去吧~
                        @else
                            2019年啦，竟然还有你这种对健身一无所知的濒临物种~新的一年里不要再当孤独的文艺流啦，掌握新的撸铁技能势在必行哦~
                        @endif
                    </p>
                </div>
                <ul class="clearfix btn btn4 mt100">
                    <li class="fl">
                        @if($type == 0)
                        <a href="#15f" class="f30 color_333 lt bgcolor_orange border-radius">查看参考答案</a>
                        @else
                        <a href="#14f" class="f30 color_333 lt bgcolor_orange border-radius">查看参考答案</a>
                        @endif
                    </li>
                    <li class="fr baomingBtn">
                        <a href="#" class="f30 color_333 lt bgcolor_orange border-radius">邀好友测试</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- 第一屏 end -->

        <!-- 第二屏 start -->
        <!-- 摸底卷（赛普卷） -->
        <div class="swiper-slide swiper-no-swiping page4 page14" style="display:{{$type==1?'block':'none'}}"  id="14f">
            <div class="page4_top">
                <h2 class="lt f44 pb30 mb10">参考答案</h2>
                <table width="100%" cellpadding="0" cellspacing="0" border="2">
                    <thead>
                    <tr>
                        <td class="lt f30">1</td>
                        <td class="lt f30">2</td>
                        <td class="lt f30">3</td>
                        <td class="lt f30">4</td>
                        <td class="lt f30">5</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="fz f23">A</td>
                        <td class="fz f23">B</td>
                        <td class="fz f23">A</td>
                        <td class="fz f23">B</td>
                        <td class="fz f23">D&nbsp;E</td>
                    </tr>
                    </tbody>
                </table>
                <h3 class="lt f30 text_left">详解：略</h3>
                <p class="fz f24 p_theme text_left">经我观察，你骨骼惊奇，我看与你有缘，特送你训练秘籍，助你打通健身任督二脉！</p>
                <!--  视频 -->
                <div class="video-wrap video-wrap1">
                    <div class="con">
                        <div class="video">
                            <div class="box2">
                                <img src="http://image.saipubbs.com/upload/image/20180827/1535349571.18500099.png" alt="" class="thumb" />
                            </div>
                            <video src="http://v.saipubbs.com/dongzuo/kangfu/1.mp4" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto"></video>
                        </div>
                        <p class="f28 mt20">《训练关节疼痛康复全了解》</p>
                    </div>
                </div>
            </div>
            <div class="page14_bottom btn">
                <a onclick="accessCourse();" class="f30 color_000 lt bgcolor_orange border-radius">收入囊中</a>
            </div>
        </div>
        <!-- 第二屏 end -->

        <!-- 第三屏 start -->
        <!-- 小白卷（全国卷） -->
        <div class="swiper-slide swiper-no-swiping page4 page14" style="display:{{$type==1?'none':'block'}}" id="15f">
            <div class="page4_top">
                <h2 class="lt f44 pb30 mb10">参考答案</h2>
                <table width="100%" cellpadding="0" cellspacing="0" border="2">
                    <thead>
                    <tr>
                        <td class="lt f30">1</td>
                        <td class="lt f30">2</td>
                        <td class="lt f30">3</td>
                        <td class="lt f30">4</td>
                        <td class="lt f30">5</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="fz f23">A</td>
                        <td class="fz f23">C</td>
                        <td class="fz f23">C</td>
                        <td class="fz f23">B</td>
                        <td class="fz f23">A</td>
                    </tr>
                    </tbody>
                </table>
                <h3 class="lt f30 text_left">详解：略</h3>
                <p class="fz f24 p_theme text_left">经我观察，你骨骼惊奇，我看与你有缘，特送你训练秘籍，助你打通健身任督二脉！</p>
                <!--  视频 -->
                <div class="video-wrap video-wrap1">
                    <div class="con">
                        <div class="video">
                            <div class="box2">
                                <img src="http://image.saipubbs.com/upload/image/20180827/1535349571.18500099.png" alt="" class="thumb" />
                            </div>
                            <video src="http://v.saipubbs.com/dongzuo/kangfu/1.mp4" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto"></video>
                        </div>
                        <p class="f28 mt20">《训练关节疼痛康复全了解》</p>
                    </div>
                </div>
            </div>
            <div class="page14_bottom btn">
                <a onclick="accessCourse();" class="f30 color_000 lt bgcolor_orange border-radius">收入囊中</a>
            </div>
        </div>
        <!-- 第三屏 end -->
    </div>
</div>
</body>
</html>
<script src="/js/swiper.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        paginationClickable: true,
        noSwiping:true,
        noSwipingClass:'swiper-no-swiping',
        direction: 'vertical'
    });
</script>
<!-- 答案选项的选中状态 -->
<script src="/lib/layer/layer.js"></script>
<script type="text/javascript">
    var flag = '{{$flag}}';
    var type = '{{$type}}';
    var score = '{{$score}}';
    var name = '{{$name}}';
    //播放视频
    $(function (){
        //播放视频
        $('.con .video .box2').click(function(){
            $(this).hide();
            /*//首页下点击图片播放的id  //教师下点击图片播放的id
             document.getElementById('video').play();*/
        })
    })
    $(document).ready(function(){
        $(".thumb").click(function(){
            $(this).parent().next().trigger('play');
        });
    });


    //点击其中一个播放时，其他的停止播放
    // 获取所有video
    var videoclose = document.getElementsByTagName("video");
    // 暂停函数
    function pauseAll() {
        var self = this;
        [].forEach.call(videoclose, function (i) {
            // 将video中其他的video全部暂停
            i !== self && i.pause();
        })
    }
    // 给play事件绑定暂停函数
    [].forEach.call(videoclose, function (i) {
        i.addEventListener("play", pauseAll.bind(i));
    })

    function accessCourse(){

        if(flag ==0){
            if(type == 1){
                var url = '/get/answer?score='+score+'&type='+type+'&name='+name+'#14f';
            }else{
                var url = '/get/answer?score='+score+'&type='+type+'&name='+name+'#15f';
            }
            localStorage.setItem("redirect", url);
            layer.msg('请先登录');
            window.location.href='/register';

        }else{
            var data = {_token:'{{csrf_token()}}'};
            $.ajax({
                url:'/access/course',
                data:data,
                type:'POST',
                dataType:'json',
                success:function(res){
                    if(res.code == 0){
//                        layer.msg(res.message);
                        window.location.href='/course/detail/6.html';
                    }else{
                        layer.msg(res.message)
                    }
                }
            });
        }
    }
    //弹窗
    $(function (){
        $('.baomingBtn').click(function(){
            var data = {score:score,name:name,_token:'{{csrf_token()}}'};
            $.ajax({
                url:'/inviteUser',
                data:data,
                type:'POST',
                dataType:'json',
                success:function(res){
                    if(res.code == 0){
                        layer.open({
                            type: 1,
                            title: false, //不显示标题栏
                            skin: 'bm_success_layer_wrap', //样式类名
                            id: 'bm_success_layer', //设定一个id，防止重复弹出
                            closeBtn: 1, //不显示关闭按钮
                            anim: 2,
                            shadeClose: true, //开启遮罩关闭
                            area: ['96%', '96%'],
                            content:res.body,
                            btn:false
                        });
                    }
                }
            })
        })
    })
</script>