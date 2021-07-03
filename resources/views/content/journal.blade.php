<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普期刊-活动</title>
    <meta name="author" content="涵" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" type="text/css" href="/lib/jqweui/css/weui.min.css" />
    <link rel="stylesheet" type="text/css" href="/lib/jqweui/css/jquery-weui.min.css"/>
    <link rel="stylesheet" type="text/css" href="/css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="/css/font-num40.css">
    <link rel="stylesheet" type="text/css" href="/css/zt/zt_RightFloat.css">
    <!--期刊css-->
    <link rel="stylesheet" type="text/css" href="/css/qikan.css?t=1.1">

    <script src="/js/rem.js"></script>
</head>
<body ontouchstart>


<div>
    <!--banner start-->
    <div>
        <img src="/images/zt/qikan/banner1.jpg" class="img100" alt="赛普期刊发行仪式">
        <img src="/images/zt/qikan/banner2.jpg" class="img100" alt="赛普期刊发行仪式">
    </div>
    <!--banner end-->

    <!--内容 start-->
    <div class="">
        <img src="/images/zt/qikan/boximg1.jpg" class="img100" alt="0基础到到赛普">
        <img src="/images/zt/qikan/boximg2.jpg" class="img100" alt="老师教的好，收入少不了">
        <img src="/images/zt/qikan/boximg3.jpg" class="img100" alt="2019重磅推出，赛普期刊">

        <!-- start-->
        <div class="qikan_zhongbang mlr45 color_fff text_center fz bgcolor_1a">
            <p class="pt30 pb30 bold f30">期刊的所有内容均由教学部老师产出<br>并且由部门经理审核后完成分发</p>
            <p class="bor-line text-jus mlr45 pt30 f26 opt60">销售部和就业部老师在指定的链接获取到该内容，完成朋友圈和社群的分发,并且分发的每一篇文章上方还会带有自己的电子名片，方便新老学员咨询。</p>
        </div>
        <!-- end -->

        <!--按钮 start-->
        <div class="qikan_btn plr45 mtb45">
            <a href="/content" class="block text_center color_000 bgcolor_orange border-radius-img">
                <p class="qikan_font-box">
                    <span class="bold f32">赛普期刊第一期</span>
                    <img class="d-in-black" src="/images/zt/qikan/icon_qikan.png" alt="">
                </p>
                <p class="fz f26">（点击我获取相关期刊内容）</p>
            </a>
        </div>
        <!--按钮 end-->

        <!-- 如何制作电子名片 start-->
        <div class="qikan_dianzi">
            <h3 class="color_fff fz f34 bold text_center mb40"><i></i>如何制作电子名片<i></i></h3>

            <div class="mlr45">
                <div class="bgcolor_1a qikan_bu border-radius-img">
                    <dl class="clearfix">
                        <dt class="color_fff f28"><span>第一步</span></dt>
                        <dd class="color_orange f30 lt">从微信下载自己的微信二维码</dd>
                    </dl>
                </div>
                <div class="bgcolor_1a qikan_bu border-radius-img mt20">
                    <dl class="clearfix">
                        <dt class="color_fff f28"><span>第二步</span></dt>
                        <dd class="color_orange f30 lt">上传自己的微信二维码</dd>
                    </dl>
                </div>
            </div>
        </div>
        <!-- 如何制作电子名片 end-->

        <input type="hidden" name="code_img" id="code_img" value="{{$code_img}}"/>
        <!--上传二维码 start-->
        <div class="color_fff mlr45 bgcolor_1a mt30 ptb45 qikan_upload">
            <h3 class="color_fff fz f34 bold text_center mb40"><i></i>上传二维码<i></i></h3>
            <div class="upload_img">
                <div class="show_cover_img">
                    @if($code_img)
                        <div class="upload_fm relative">
                            <img src="{{env('IMG_URL')}}{{$code_img}}" class="img100" alt="我是封面图">
                            <span class="up_close d-in-black" data-url="{{$code_img}}" onclick="btn_delimg(this);"><img src="/images/close2.png" alt=""></span>
                        </div>
                    @endif
                </div>
                {{--<div class="upload_fm relative"> --}}
                    {{--<img src="/images/qr.png" class="img100" alt="我是二维码">--}}
                    {{--<span class="up_close d-in-black"><img src="/images/close2.png" alt=""></span>--}}
                {{--</div>--}}
                @if(!$code_img)
                    <div class="uplaod_img_btn ptb20" style="display:block;">
                @else
                    <div class="uplaod_img_btn ptb20" style="display:none;">
                @endif
                    <div class="weui-uploader__bd">
                        <div class="weui-uploader__input-box">
                            <input class="weui-uploader__input upload_cover" name="upload_cover" type="file" accept="image/*" multiple="">
                        </div>
                    </div>
                </div>
                {{csrf_field()}}
            </div>
        </div>
        <!--上传二维码 end-->

        <!-- 完成提交 start -->
        <div class="mlr45 mtb45 border-radius-img qikan_btn2">
            <button  class="bgcolor_orange color_000 bold fz f34 code_submit">完成提交</button>
        </div>
        <!-- 完成提交 end -->

    </div>
    <!--内容 end-->

</div>
<br><br><br>
<script type="text/javascript" src="/lib/jqweui/js/jquery-2.1.4.js"></script>
<script type="text/javascript" src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script type="text/javascript" src="/lib/layer/layer.js"></script>
<script src="/js/upload.js" type="text/javascript"></script>
<script src="/js/base64/mobileBUGFix.mini.js" type="text/javascript"></script>
<script type="text/javascript">
    var imgUrl ="{{env('IMG_URL')}}";
    $("body").addClass("bgcolor_000");
    $(".upload_cover").UploadImg({
        url : '/journal/upload',
        // width : '320',
        //height : '200',
        quality : '0.8', //压缩率，默认值为0.8
        // 如果quality是1 宽和高都未设定 则上传原图
        mixsize : '30000000',
        //type : 'image/png,image/jpg,image/jpeg,image/pjpeg,image/gif,image/bmp,image/x-png',
        before : function(blob,className){
//            alert(3);
            $(".loading").removeClass('hide');
        },
        error : function(res, obj){
            layer.msg(res);
//            $(obj).parent().next().attr('src', "");
//            $(obj).parent().next().next().val("");
//            $(obj).parent().next().next().next().html(res+"~亲~不能超过300kb");
        },
        success : function(url,className,obj){
//            $(".loading").addClass('hide');
            var content = '<div class="upload_fm relative"><img src="'+imgUrl+url+'" class="img100" alt="我是封面图"><span class="up_close d-in-black" data-url="'+url+'" onclick="btn_delimg(this);"><img src="/images/close2.png" alt=""></span></div>';
            $('.show_cover_img').append(content);
            $(".uplaod_img_btn").css('display','none');
            $('#code_img').val(url);
//            $(obj).parent().next().next().next().html("上传成功");
        }
    });
    var btn_delimg = function(e){
        var imgurl = e.getAttribute("data-url");
        var _token = '{{csrf_token()}}';
        $.ajax({
            url: "/cover/delImg",
            type: "POST",
            data:  {imgurl:imgurl, _token:_token},
            dataType:'json',
            success: function (data) {
                if(data.code==0){
                    $('#code_img').val('');
                    $('.show_cover_img div').remove();
                    $(".uplaod_img_btn").css('display','block');
                }else if(res.code == 4){
                    userlogin();
                }else{
                    layer.msg(data.message);
                }
            }
        });
    }
    function userlogin(){

        var url = "/journal/active";
        localStorage.setItem("redirect", url);

        layer.msg('请先注册');
        setTimeout(function(){
            window.location.href = "/register";
        }, 300);
    }

    $('.code_submit').click(function () {
//        alert(33);
        var code_img = $("#code_img").val();
        var token = '{{csrf_token()}}';
        var data = {code_img:code_img,_token:token};

        $.ajax({
            url: "/journal/wx/code",
            type: "POST",
            data:  data,
            dataType:'json',
            success: function (data) {
                if(data.code==0){
                    layer.msg('上传成功');
                }else if(data.code == 4){
                    userlogin();
                }else{
                    layer.msg(data.message);
                }
            }
        });

    })
</script>
</body>
</html>
