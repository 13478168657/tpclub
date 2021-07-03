<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$member->fat_rate==0 ? "首次体测" : "训练第".($count+1)."周后"}}登记信息</title>
    <link href="/fat/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/fat/lib/jqweui/css/jquery-weui.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/fat/css/reset.css">
    <link rel="stylesheet" href="/fat/css/mp.css">
    <link rel="stylesheet" href="/fat/css/font-num40.css">
    <link rel="stylesheet" href="/fat/css/animation-btn.css">
    <link rel="stylesheet" href="/fat/css/index.css?id={{rand(1,100)}}">
    <script src="/fat/js/rem.js"></script>
    @include('layouts.baidutongji')
</head>
<body>
<div class="">

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


    <!-- 首次体测 srtat-->
    <h3 class="text_center lt f48 pt70 pb35">{{$member->fat_rate==0 ? "首次体测" : "第".($count+1)."周训练后身体数据"}}</h3>
    <div class="baomingchu mlr30 x-fdd000">
        <div class="from fz f26">
            <ul class="clearfix">
                <li>
                    <div class="wrap clearfix">
                        <span>姓名</span>
                        <input type="text" placeholder="请输入姓名" value="{{$member->name}}" readonly="">

                    </div>
                </li>
                <li>
                    <div class="wrap clearfix">
                        <span>性别</span>
                        <input type="text" placeholder="请选择性别" class="sex" value="{{$member->sex =='male' ? '男' : '女'}}" readonly="">
                        <!-- <b><img src="/fat/images/icon-j2.png" alt=""></b> -->
                    </div>
                </li>
                <li>
                    <div class="wrap clearfix">
                        <span>{{$member->object=='student' ? '学期' : '部门'}}</span>
                        <input type="text" placeholder="请选择学期" class="xueqi" value="{{$member->stage}}" readonly="">
                        <!-- <b><img src="/fat/images/icon-j2.png" alt=""></b> -->
                    </div>
                </li>
                <li>
                    <div class="wrap clearfix">
                        <span>{{$member->object=='student' ? '班级' : '分支'}}</span>
                        <input type="text" placeholder="请输入班级" value="{{$member->class}}" readonly="">
                    </div>
                </li>
                <li>
                    <div class="wrap clearfix">
                        <span>手机号</span>
                        <input type="text" placeholder="请输入手机号" value="{{$member->mobile}}" readonly="">
                    </div>
                </li>
                <li>
                    <div class="wrap clearfix">
                        <span>年龄</span>
                        <input type="number" placeholder="请输入年龄" name="age" value="{{$member->age}}" {{$member->age ? 'readonly' : ''}}>
                        <b>岁</b>
                    </div>
                </li>
                <li>
                    <div class="wrap clearfix">
                        <span>体重</span>
                        <input type="text" placeholder="请输入体重" name="weight">
                        <b>kg</b>
                    </div>
                </li>
                <li>
                    <div class="wrap clearfix">
                        <span>身高</span>
                        <input type="text" placeholder="请输入身高" name="height" value="{{$member->height}}" {{$member->height ? 'readonly' : ''}}>
                        <b>cm</b>
                    </div>
                </li>
                <li>
                    <div class="wrap clearfix">
                        <span>体脂</span>
                        <input type="text" placeholder="请输入体脂" name="fat_rate">
                        <b>%</b>
                    </div>
                </li>
                <li>
                    <div class="wrap clearfix">
                        <span>组别</span>
                        <input type="text" placeholder="请选择组别" class="zubie{{$member->group ? $member->group : ''}}" name="group" value='{{$member->group ? $member->group."组" : ''}}' data-values="{{$member->group ? $member->group : ''}}" {{$member->group ? 'readonly' : ''}} />
                    </div>
                </li>
                
            </ul>
        </div>
    </div>
    <!-- 首次体测 end-->

    <!-- 分割线-->
    <div class="line-90"></div>

    <!-- 添加靓照 start -->
    <div class="mlr30 plr30 liangzhao-one">
        <h3 class="lt f48 pt60 pb35">上传电子版数据</h3>
        <ul class="imgUploadList clearfix mt30 mb30">
            <li class="imgUpload btnUploadWrap w100 dianzibanshuju">
                <div class="weui-uploader__input-box">
                    <input id="" class="weui-uploader__input upload_img" type="file" accept="image/*" multiple="">
                    <input type="hidden" name="fat_img" />
                </div>
                <a href="javascript:void (0)" style="display: none">
                    <img src="" class="img" />
                    <div class="close-img f28"></div>
                </a>
            </li>
            <li class="imgUpload btnUploadWrap w50 zhengmian">
                <div class="weui-uploader__input-box">
                    <input id="" class="weui-uploader__input upload_img" type="file" accept="image/*" multiple="">
                    <input type="hidden" name="positive_img" />
                </div>
                <a href="javascript:void (0)" style="display: none">
                    <img src="" class="img" />
                    <div class="close-img f28"></div>
                </a>
            </li>
            <li class="imgUpload btnUploadWrap w50 cemian">
                <div class="weui-uploader__input-box">
                    <input id="" class="weui-uploader__input upload_img" type="file" accept="image/*" multiple="">
                    <input type="hidden" name="side_img" />
                </div>
                <a href="javascript:void (0)" style="display: none">
                    <img src="" class="img" />
                    <div class="close-img f28"></div>
                </a>
            </li>
        </ul>
        <div class="jp-list fz f24 mb30">
            <h5 class="color_000">温馨提示：</h5>
            <p>男子：请脱掉上衣，仅着黑色短裤拍照；</p>
            <p>女子：请身着运动bra、黑色紧身运动裤拍照；</p>
        </div>
    </div>
    <!-- 添加靓照 end -->

    <!-- 按钮 -->
    <button class="btn lt f48 color_000 mt68 body_btn">保存</button>



</div>

<br><br>
<br><br>
<!-- 公共脚部 start -->
    <!-- 公共脚部 end -->
<script src="/fat/js/jquery-1.11.2.min.js"></script>
<script src="/fat/lib/icheck/js/icheck.min.js"></script>
<script src="/fat/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/fat/lib/jqweui/js/city-picker.min.js"></script>
<script src="/fat/lib/layer/layer.js"> </script>
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
            var base64 = canvas.toDataURL(file.type, 0.8 );
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
    var sex = "{{$member->sex}}";
    if(sex=='male'){
        group = [{title:'男子A组(<13%)', value:'A'},{title:'男子B组(>=13%-<=18%)', value:'B'},{title:'男子C组(>18%)', value:'C'},{title:'专业组', value:'D'},];
    }else{
        group = [{title:'女子A组(<15%)', value:'A'},{title:'女子B组(>=15%-<=23%)', value:'B'},{title:'女子C组(>23%)', value:'C'},{title:'专业组', value:'D'},];
    }
    /*给弹出改变样式*/
    $("body").addClass("popup-body-class");
    //学期
    $(".zubie").select({
        title: "组别",
        items:group,
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
            if($('.zubie').data('values')!=undefined){
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

    $(".body_btn").click(function(){
        layer.msg('正在提交');
        var mid = "{{$member->id}}";
        var age   = $("input[name='age']").val();
        var weight= $("input[name='weight']").val();
        var height= $("input[name='height']").val();
        var group = $("input[name='group']").attr("data-values");
        var fat_rate = $("input[name='fat_rate']").val();
       
        var fat_img = $("input[name='fat_img']").val();
        var positive_img   = $("input[name='positive_img']").val();
        var side_img = $("input[name='side_img']").val();
        if(!age || age==""){
            layer.msg('请填写您的年龄');
            return false;
        }
        if(!weight || weight==""){
            layer.msg('请填写您的体重');
            return false;
        }
        if(!height || height==""){
            layer.msg('请填写您的身高');
            return false;
        }
        if(!group || group==""){
            layer.msg('请选择组别');
            return false;
        }
        if(!fat_rate || fat_rate==""){
            layer.msg('请填写体脂率');
            return false;
        }
        if(!fat_img || fat_img==""){
            layer.msg('请上传电子版数据');
            return false;
        }
        if(!positive_img || positive_img==""){
            layer.msg('请上传正面照');
            return false;
        }
        if(!side_img || side_img==""){
            layer.msg('请上传右侧面照');
            return false;
        }
        var token  = '{{csrf_token()}}';
        $.ajax({
            url:'/fat/body/data',
            type:'post',
            data:{mid:mid, _token:token, age:age, weight:weight, height:height, group:group, fat_rate:fat_rate, fat_img:fat_img, positive_img:positive_img, side_img:side_img},
            dataType:'json',
            success:function(data){
                console.log(data);
                layer.msg(data.message);
                if(data.code == 0){
                    setTimeout( function (){window.location.href="/fat/member/"+mid+".html"; }, 1500);
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