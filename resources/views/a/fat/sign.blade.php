<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>赛普千人减脂报名</title>
    <link href="lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="lib/jqweui/css/jquery-weui.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/mp.css">
    <link rel="stylesheet" href="css/font-num40.css">
    <link rel="stylesheet" href="css/animation-btn.css">
    <link rel="stylesheet" href="css/index.css?id={{rand(1,100)}}">
    <script src="js/rem.js"></script>
    <script src="js/TouchSlide.1.1.js"></script>
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


    <!-- 报名处 srtat-->
    <h3 class="text_center lt f48 pt70 pb35">报名处</h3>
    <div class="baomingchu plr30">
        <!-- 本例主要代码 Start ================================ -->
        <!-- Tab切换（高度自适应示范） -->
        <div id="tabBox1" class="tabBox">
            <div class="hd">
                <ul class="clearfix text_center f30 lt color_000" id="object">
                    <li data-index="1" data-object='student'><a href="javascript:void(0)">学员组</a></li>
                    <li data-index="2" data-object='staff'><a href="javascript:void(0)">员工组</a></li>
                    <li data-index="3" data-object='teacher'><a href="javascript:void(0)">教学组</a></li>
                </ul>
            </div>
            <div class="bd" id="tabBox1-bd"><!-- 添加id，js用到 -->
                <div class="con"><!-- 高度自适应需添加外层 -->
                    <div class="from fz f26">
                        <ul class="clearfix" id="form1">
                            <li>
                                <div class="wrap clearfix">
                                    <span>姓名</span>
                                    <input type="text" placeholder="请输入姓名" name="name">
                                </div>
                            </li>
                            <li>
                                <div class="wrap clearfix">
                                    <span>性别</span>
                                    <input type="text" placeholder="请选择性别" class="sex" name="sex">
                                    <b><img src="images/icon-j2.png" alt=""></b>
                                </div>
                            </li>
                            <li>
                                <div class="wrap clearfix">
                                    <span>学期</span>
                                    <input type="text" placeholder="请选择学期" class="xueqi" name="stage">
                                    <b><img src="images/icon-j2.png" alt=""></b>
                                </div>
                            </li>
                            <li>
                                <div class="wrap clearfix">
                                    <span>班级</span>
                                    <input type="text" placeholder="如：1班" name="class">
                                </div>
                            </li>
                            <li>
                                <div class="wrap clearfix">
                                    <span>手机号</span>
                                    <input type="text" placeholder="请输入手机号" name="mobile">
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="con"><!-- 高度自适应需添加外层 -->
                    <div class="from fz f26">
                        <ul class="clearfix" id="form2">
                            <li>
                                <div class="wrap clearfix">
                                    <span>姓名</span>
                                    <input type="text" placeholder="请输入姓名" name="name">
                                </div>
                            </li>
                            <li>
                                <div class="wrap clearfix">
                                    <span>性别</span>
                                    <input type="text" placeholder="请选择性别" class="sex" name="sex">
                                    <b><img src="images/icon-j2.png" alt=""></b>
                                </div>
                            </li>
                            <li>
                                <div class="wrap clearfix">
                                    <span>部门</span>
                                    <input type="text" placeholder="如:营销中心" name="stage">
                                </div>
                            </li>
                            <li>
                                <div class="wrap clearfix">
                                    <span>分支</span>
                                    <input type="text" placeholder="如:摄影部" name="class">
                                </div>
                            </li>
                            <li>
                                <div class="wrap clearfix">
                                    <span>手机号</span>
                                    <input type="text" placeholder="请输入手机号" name="mobile">
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="con"><!-- 高度自适应需添加外层 -->
                    <div class="from fz f26">
                        <ul class="clearfix" id="form3">
                            <li>
                                <div class="wrap clearfix">
                                    <span>姓名</span>
                                    <input type="text" placeholder="请输入姓名" name="name" />
                                </div>
                            </li>
                            <li>
                                <div class="wrap clearfix">
                                    <span>性别</span>
                                    <input type="text" placeholder="请选择性别" class="sex" name="sex" />
                                    <b><img src="images/icon-j2.png" alt=""></b>
                                </div>
                            </li>
                            <li>
                                <div class="wrap clearfix">
                                    <span>部门</span>
                                    <input type="text" placeholder="如:教学中心" name="stage" />
                                </div>
                            </li>
                            <li>
                                <div class="wrap clearfix">
                                    <span>分支</span>
                                    <input type="text" placeholder="如:教研部" name="class" />
                                </div>
                            </li>
                            <li>
                                <div class="wrap clearfix">
                                    <span>手机号</span>
                                    <input type="text" placeholder="请输入手机号" name="mobile" />
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            TouchSlide( { slideCell:"#tabBox1",

                endFun:function(i){ //高度自适应
                    var bd = document.getElementById("tabBox1-bd");
                    bd.parentNode.style.height = bd.children[i].children[0].offsetHeight+"px";
                    if(i>0)bd.parentNode.style.transition="200ms";//添加动画效果
                }

            } );</script>
        <!-- 本例主要代码 End ================================ -->
    </div>
    <!-- 报名处 end-->

    <!-- 分割线-->
    <div class="line-90"></div>

    <!-- 添加靓照 start -->
    <div class="mlr30 plr30 liangzhao-one">
        <h3 class="lt f48 pt60 pb35">添加靓照</h3>
        <ul class="imgUploadList clearfix mt30 mb30">
            <li class="imgUpload btnUploadWrap w100 gerenzhaopiao">
                <div class="weui-uploader__input-box">
                    <input id="" class="weui-uploader__input upload_img" type="file" accept="image/*" multiple="">
                    <input type="hidden" name="cover_img" />
                </div>
                <a href="javascript:void (0)" style="display: none">
                    <img src="" class="img" />
                    <div class="close-img f28"></div>
                </a>
            </li>
        </ul>
    </div>
    <!-- 添加靓照 end -->

    <!-- 按钮 -->
    <button class="btn lt f48 color_000 mt68 sign_btn">确认报名</button>

</div>

<br><br>
<br><br>
<!-- 公共脚部 start -->
    @include('a.fat.footer',['type'=>2])
    </div>
    <!-- 公共脚部 end -->
<script src="js/jquery-1.11.2.min.js"></script>
<script src="lib/icheck/js/icheck.min.js"></script>
<script src="lib/jqweui/js/jquery-weui.min.js"></script>
<script src="lib/jqweui/js/city-picker.min.js"></script>
<script src="lib/layer/layer.js"> </script>
<script>
    var imgUrl ="{{env('IMG_URL')}}";
    //上传图片
    function _compress(blob,file,url,o){
        layer.msg('正在上传,请稍等');
        layer.load(2, {shade: [0.5,'#000']});
        //alert(0);
        var img = new Image();
        img.src = blob;
        var quality =1;
        console.log("img");
        img.onload = function(){
            //alert(1);
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            var w = this.width;
            var h = w/this.width*this.height;
            $(canvas).attr({width : w, height : h});
            ctx.drawImage(this, 0, 0, w, h);
            var base64 = canvas.toDataURL(file.type, (quality || 0.8)*1 );
            $.post(url,{file:base64,type:file.type,_token:'{{csrf_token()}}'},function(res){
                //layer.msg('正在上传中');
                console.log(res);
                if(res.code == 0){
                    layer.msg('上传成功');
                    layer.closeAll('loading');
                    o.parent().next().show();
                    o.parent().next().find("img").attr("src", imgUrl + res.url);
                    o.next().val(res.url);
                }else{
                    alert('上传失败');
                    layer.closeAll('loading');
                }
            });
        };
    }

$(function (){
    $(".upload_img").change(function(){
        event.stopPropagation(); 
        console.log(111);
        var file = this.files['0'];
        var URL = window.URL || window.webkitURL;
        var blob = URL.createObjectURL(file);
         _compress(blob,file, "/fat/cover/upload",$(this));
         console.log($(this));
    });
    /*给弹出改变样式*/
    $("body").addClass("popup-body-class");
    //性别
    $(".sex").select({
        title: "性别",
        items: [
            {
                title: "男",
                value: 'male',
                description: "额外的数据1"
            },
            {
                title: "女",
                value: 'female',
                description: "额外的数据2"
            },
        ],
        onChange: function(d) {
            console.log(this, d);
            /*var index=this.data.values;
             $('.weui-picker-container:last .weui-picker-modal .weui-check_label').eq(index-1).addClass("cur")*/
            var items = this.config.items;
            var index=this.data.values;
            console.log(index)

            for (var i = 0; i < items.length; i++) {
                $('.weui-picker-container:last .weui-picker-modal .weui-check_label').eq(index-1).addClass('cur').siblings().removeClass('cur');
            }
            if($('.xueqi').data('values')!=undefined){
                //$('#inten').addClass('cur');
            }
        },

        onClose: function() {
            console.log("close");
            console.log("1111");
            //启用滚动条
            $(document.body).css({
                "overflow-x":"auto",
                "overflow-y":"auto"
            });
        },
        onOpen: function() {
            console.log("open");
            console.log("2222");
            //禁止滚动条
            $(document.body).css({
                "overflow-x":"hidden",
                "overflow-y":"hidden"
            });
        },
    });

    //学期
    $(".xueqi").select({
        title: "学期",
        items: [
            {
                title: "2020-09-25期",
                value: '2020-09-25期',
                description: "额外的数据1"
            },
            {
                title: "2020-10-10期",
                value: "2020-10-10期",
                description: "额外的数据2"
            },
            {
                title: "2020-10-25期",
                value: "2020-10-25期",
                description: "额外的数据2"
            },{
                title: "2020-11-10期",
                value: "2020-11-10期",
                description: "额外的数据2"
            },{
                title: "2020-11-25期",
                value: "2020-11-25期",
                description: "额外的数据2"
            },
        ],
        onChange: function(d) {
            console.log(this, d);
            /*var index=this.data.values;
             $('.weui-picker-container:last .weui-picker-modal .weui-check_label').eq(index-1).addClass("cur")*/
            var items = this.config.items;
            var index=this.data.values;
            console.log(index)

            for (var i = 0; i < items.length; i++) {
                $('.weui-picker-container:last .weui-picker-modal .weui-check_label').eq(index-1).addClass('cur').siblings().removeClass('cur');
            }
            if($('.xueqi').data('values')!=undefined){
                //$('#inten').addClass('cur');
            }
        },

        onClose: function() {
            console.log("close");
            console.log("1111");
            //启用滚动条
            $(document.body).css({
                "overflow-x":"auto",
                "overflow-y":"auto"
            });
        },
        onOpen: function() {
            console.log("open");
            console.log("2222");
            //禁止滚动条
            $(document.body).css({
                "overflow-x":"hidden",
                "overflow-y":"hidden"
            });
        },
    });


    /*点击遮罩关闭选择框*/
    /*$(document.body).delegate(".weui-picker-container", 'click', function () {
        console.log(1111);
        $(".select_ipt").select("close");
    });*/

    //删除上专照片关闭按钮
    $(".close-img").click(function(){
        $(this).parent().prev().find("input[type='hidden']").val("");
        $(this).parent("a").css("display","none");
    });


    $(".sign_btn").click(function(){
        layer.msg('正在提交');
        var index_value = $("#object").find("li[class='on']").attr("data-index");
        var name = $("#form"+index_value).find("input[name='name']").val();
        var mobile = $("#form"+index_value).find("input[name='mobile']").val();
        var sex = $("#form"+index_value).find("input[name='sex']").attr("data-values");
        if(index_value==1){
            var stage = $("#form"+index_value).find("input[name='stage']").attr("data-values");
        }else{
            var stage = $("#form"+index_value).find("input[name='stage']").val();
        }
        var classNumber = $("#form"+index_value).find("input[name='class']").val();
        var cover_img   = $("input[name='cover_img']").val();
        var object      = $("#object").find("li[class='on']").attr("data-object");
        if(!name || name==""){
            layer.msg('请填写您的姓名');
            return false;
        }
        if(!sex || sex==""){
            layer.msg('请选择性别');
            return false;
        }
        if(index_value==1){
            if(!stage || stage==""){
                layer.msg('请选择学期');
                return false;
            }
            if(!classNumber || classNumber==""){
                layer.msg('请填写班级号');
                return false;
            }
        }else{
            if(!stage || stage==""){
                layer.msg('请填写部门信息');
                return false;
            }
            if(!classNumber || classNumber==""){
                layer.msg('请填写部门分支');
                return false;
            }
        }

        if(!mobile || !/1[1-9]{1}[0-9]{9}$/.test(mobile)){
            layer.msg('请输入有效的手机号码');
            return false;
        }
        if(!cover_img || cover_img==""){
            layer.msg('请上传封面图');
            return false;
        }
        var token  = '{{csrf_token()}}';
        $.ajax({
            url:'/fat/signup/data',
            type:'post',
            data:{mobile:mobile, _token:token, name:name, classNumber:classNumber, sex:sex, stage:stage, cover_img:cover_img, object:object},
            dataType:'json',
            success:function(data){
                console.log(data);
                layer.msg(data.message);
                if(data.code == 0){
                    setTimeout( function (){window.location.href="/fat/index"; }, 3000);
                }
            }
        });
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