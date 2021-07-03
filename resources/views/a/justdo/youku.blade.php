<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普之星百人健身直播申报</title>
    <!-- <title>赛普&耐克超级健身盛典报名</title> -->
    <meta name="author" content="络绎" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" href="/lib/jqweui/css/weui.min.css" />
    <link rel="stylesheet" href="/lib/jqweui/css/jquery-weui.css" />
    <link rel="stylesheet" href="/lib/mobileValidate/css/validate.css" />
    <link rel="stylesheet" href="/css/reset.css?t=1.6" />
    <link rel="stylesheet" href="/css/font-num40.css"/>
    <link rel="stylesheet" href="/css/zt/zt_just_do_it_form.css?t=16">
    <link rel="stylesheet" href="/css/zt/zt_RightFloat.css">
    <link rel="stylesheet" href="/css/zt/zt_just_do_it_public.css">
    <script src="/js/rem.js" type="text/javascript"></script>
    @include('layouts.baidutongji')
</head>
<body ontouchstart>
<!-- 头部 start -->
<div class="ad_code" style="display: none;">
     <img src="/images/zt/just_do_it/home/ad_sp.jpg" alt="" class="img100 ad_img_img">
    <div class="ad_close"><img src="/images/close2.png" class="img_close" alt=""></div>
</div>
<!-- 弹出 start -->
<div class="bm_success_layer_wrap text_center hide">
    <p class="color_333 f20 pt40">扫描下面二维码报名<br>并获取报名结果</p>
    <img src="/images/zt/just_do_it/home/code.jpg" class="bm_success" alt="" />
</div> 
<!-- 弹出 end -->
<!-- 头部 end -->

<!-- 表单 start-->
<h2 class="plr30 pt30 pb30 f32 bold">活动名称：赛普之星百人健身直播申报</h2>
<form method="post" action="" id="form1">
    <ul class="form_wrap">
        <li class="name_item clearfix">
            <div class="label_wrap fl">
                <label class="label">头像</label>
                @if($user->avatar)
                    @if(strpos($user->avatar,'http') !== false)
                        <img src="{{$user->avatar}}" class="avatar"/>
                    @else
                        <img src="{{env('IMG_URL')}}{{$user->avatar}}" alt="头像" class="avatar" />
                    @endif
                @else
                    <img class="avatar" src="/images/my/nophoto.jpg" alt="头像" />
                @endif
                {{--<img class="avatar" src="/images/zt/just_do_it/xy.png" alt="" />--}}
            </div>
            <div class="fr mr30"><a href="#" class="color_orange change_avatar">更换头像</a></div>
            <input type="file" class="color_orange upload_photo" name="image" style="display:none;" />
            <input type="hidden" class="photo" name="photo" value="{{$avatar}}" />
            {{csrf_field()}}
        </li>
        <li>
            <div class="label_wrap">
                <label for="name" class="label">姓名</label>
                <span class="star">*必填</span>
            </div>
            <div class="input_wrap">
                <input class="ipt" id="name" value="{{$name}}" type="text" placeholder="请输入您的姓名" data-required="false" data-descriptions="name" />
            </div>
        </li>
        
        <li>
            <div class="label_wrap">
                <label for="sex" class="label">性别</label>
                <span class="star">*必填</span>
            </div>
            <div class="input_wrap">
                <input class="ipt arrow_b weui-input" value="{{$sex}}" id="sex" type="text" placeholder="请选择" data-required="true" data-descriptions="sex">
            </div>
        </li>
        <li>
            <div class="label_wrap">
                <label for="number" class="label">大鱼号昵称</label>
                <span class="star">*必填</span>
            </div>
            <div class="input_wrap">
                <input class="ipt " id="number" value="{{isset($userInfo->number)?$userInfo->number:''}}" type="text" placeholder="请输入您的大鱼号昵称" data-required="true"
                       data-descriptions="number"/>
            </div>
        </li>
        <li>
            <div class="label_wrap">
                <label for="title" class="label">直播主题</label>
                <span class="star">*必填</span>
            </div>
            <div class="input_wrap">
                <input class="ipt " id="title" value="{{isset($userInfo->title)?$userInfo->title:''}}" type="text" placeholder="请输入您的直播主题" data-required="true"
                       data-descriptions="title"/>
            </div>
        </li>
        <li>
            <div class="label_wrap">
                <label for="content" class="label">直播内容</label>
                <span class="star">*必填</span>
            </div>
            <div class="input_wrap">
                <input class="ipt " id="content" value="{{isset($userInfo->content)?$userInfo->content:''}}" type="text" placeholder="请输入您的直播内容" data-required="true"
                       data-descriptions="content"/>
            </div>
        </li>
        <li>
            <div class="label_wrap">
                <label for="date" class="label">直播日期</label>
                <span class="star">*必填</span>
            </div>
            <div class="input_wrap">
                <input class="ipt arrow_b" id="date" type="text" placeholder="请选择您的直播日期"  data-required="true" value="{{isset($userInfo->date)?$userInfo->date:''}}"  data-descriptions="date">
            </div>
        </li>
        <li class="self_media_item">
            <div class="label_wrap">
                <label for="hours" class="label">直播时段</label>
                <span class="star">*必填</span>
            </div>
            <div class="input_wrap">
                <input class="ipt arrow_b" id="hours" type="text" value="{{isset($userInfo->hours)?$userInfo->hours:''}}"  placeholder="请选择您的直播时段" data-required="true" data-descriptions="hours" />
            </div>
        </li>
    </ul>
</form>

<!-- <div class="plr30 mt10 form_wrap2"> -->
    <!-- 上传封面图片 start -->
    <!-- <div class="upload_img pt30">
        <div class="label_wrap pb10">
            <label class="label f26 lt">上传个人白底照片（用于个人海报）</label>
        </div>
        <div class="show_cover_img">
            @if($cover_img)
                <div class="upload_fm relative">
                    <img src="{{env('IMG_URL')}}{{$cover_img}}" class="img100" alt="我是封面图">
                    <span class="up_close d-in-black" data-url="{{$cover_img}}" onclick="btn_delimg2(this);"><img src="/images/close.png" alt=""></span>
                </div>
            @endif
        </div>
        @if(!$cover_img)
            <div class="uplaod_img_btn ptb20" style="display:block;">
        @else
            <div class="uplaod_img_btn ptb20" style="display:none;">
        @endif
            <div class="weui-uploader__bd">
                <div class="weui-uploader__input-box">
                    <input class="weui-uploader__input upload_cover2" name="upload_cover" type="file" accept="image/*" multiple="">
                </div>
            </div>
        </div>
        <input type="hidden" id="cover_img" name="cover_img" value="{{$cover_img}}" data-required="true" data-descriptions="cover_img" />
    </div>
</div> -->


<div class="plr30 pt10 pb10">
    @if($userFlag)
        <span class="btn1 btn1_grey bmSubmit mt10">【报名成功-重新提交报名信息】</span>
    @else
        <input type="button" value="提交报名信息" class="bmSubmit btn1" />
    @endif

</div>

<!-- 表单 end-->
<br><br><br /><br />


<!-- loading start -->
<div class="loading hide">
    <div class="loading_img">
        <img src="/images/zt/just_do_it/loading.gif" alt="">
        <p>上传时间较长,请稍等...</p >
    </div>
</div>
<!-- loading end -->


<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/jqweui/js/city-picker.min.js"></script>
<script src="/lib/jqweui/js/datetimePicker.js"></script>
<script src="/lib/mobileValidate/js/jquery-mvalidate.js"></script>
<script src="/js/upload.js?4564654" type="text/javascript"></script>
<script src="/js/base64/mobileBUGFix.mini.js" type="text/javascript"></script>
{{--<script type='text/javascript' src='/js/jQuery.form.js'></script>--}}
<script type='text/javascript' src='https://www.17sucai.com/preview/227408/2019-05-22/1/js/jquery.form.js'></script>
<script type="text/javascript">
    var imgUrl ="{{env('IMG_URL')}}";
    $('.change_avatar').on('click', function () {
        $('input[name=image]').trigger('click');
    });

    $(".upload_photo").UploadImg({
        url : '/user/baseUpload',
        // width : '320',
        //height : '200',
        quality : '0.8', //压缩率，默认值为0.8
        // 如果quality是1 宽和高都未设定 则上传原图
        mixsize : '300000',
        //type : 'image/png,image/jpg,image/jpeg,image/pjpeg,image/gif,image/bmp,image/x-png',
        before : function(blob,className){
//                var className = '#'+className;
//                $(className).attr('src',blob);
        },
        error : function(res, obj){
            console.log(obj);
            $(obj).parent().next().attr('src', "");
            $(obj).parent().next().next().val("");
            $(obj).parent().next().next().next().html(res+"~亲~不能超过300kb");
        },
        success : function(url,className,obj){
//            console.log(className);
//            console.log(this);
            $('.avatar').attr('src',imgUrl+url);
            $('.photo').val(url);
//            $(obj).parent().next().next().next().html("上传成功");
        }
    });

    $(".upload_cover2").UploadImg({
        url : '/cover/upload',
        // width : '320',
        //height : '200',
        quality : '0.8', //压缩率，默认值为0.8
        // 如果quality是1 宽和高都未设定 则上传原图
        mixsize : '30000000',
        //type : 'image/png,image/jpg,image/jpeg,image/pjpeg,image/gif,image/bmp,image/x-png',
        before : function(blob,className){
            $(".loading").removeClass('hide');
        },
        error : function(res, obj){
            layer.msg(res);
        },
        success : function(url,className,obj){
            console.log(url);
            console.log(className);
            console.log(obj);
            $(".loading").addClass('hide');
            var content = '<div class="upload_fm relative"><img src="'+imgUrl+url+'" class="img100" alt="我是封面图"><span class="up_close d-in-black" data-url="'+url+'" onclick="btn_delimg2(this);"><img src="/images/close.png" alt=""></span></div>';
           $(obj).parent().parent().parent().prev().append(content);
           $(obj).parent().parent().parent().css('display','none');
           $(obj).parent().parent().parent().next().val(url);
        }
    });

    var btn_delimg2 = function(e){
        var imgurl = e.getAttribute("data-url");
        var _token = '{{csrf_token()}}';
        $.ajax({
            url: "/cover/delImg",
            type: "POST",
            data:  {imgurl:imgurl, _token:_token},
            dataType:'json',
            success: function (data) {
                if(data.code==0){
                    $(e).parent().parent().next().next().val("");
                    $(e).parent().parent().next().css('display','block');
                    $(e).parent().remove();
                }else if(res.code == 4){
                    userlogin();
                }else{
                    layer.msg(data.message);
                }
            }
        });
    }
    

     function delVideo(){
        var data = { _token:'{{csrf_token()}}'};
        $.ajax({
            url:'/jdt/active/delVideo',
            data:data,
            type:'POST',
            dataType:'json',
            success:function(res){

                if(res.code == 0){
                    $(".del_video div").remove();
                    $("#upload_video").val('');
                    var content = '<div class="weui-uploader__input-box"><input class="weui-uploader__input uploadfile" type="file" id="uploadfile" name="uploadfile" onchange="upladFile();" multiple="" accept="video/*"></div>';
                    $(".upload_btn").append(content);
                    layer.msg(res.message);
                }else if(res.code == 4){
                    userlogin();
                }else{

                    layer.msg(res.message);
                }
            }

        })
    }
    function upladFile(){
        $(".loading").removeClass('hide');
        var file = $('#uploadfile').val();
//        var exts = file.split('.').toLowerCase();

//        if(exts != 'avi' || exts != 'mov' || exts != 'rmvb' || exts != 'rm' || exts != 'flv' || exts != 'mp4' != exts != '3gp' || exts != 'mpeg' || exts != 'mpg' || exts != 'ogg' || exts != 'ogm'|| exts != 'mkv' || exts != 'wmv' || exts != 'asf'){
//            return layer.msg('视频格式有误');
//        }else{
//            alert(33);
//        }
        if(file!=""){
            $("#myupload").ajaxSubmit({
                dataType:  'json', //数据格式为json
                beforeSend: function() { //开始上传
                },
                uploadProgress: function(event, position, total, percentComplete) {
                },
                success: function(data) {
                    console.log(data);
                    if(data.code == 1){
                        $(".loading").addClass('hide');
                        layer.msg('上传成功');
                        var content = '<div class="video_box"><video class="upload_video" src="'+data.url+'" controls="" x5-playsinline="" playsinline="" webkit-playsinline="" poster="" preload="auto"></video></div><div class="pt10 pb10"><input type="button" value="删除视频" class="btn1 delete_video" onclick="delVideo();" />';
                        $(".del_video").append(content);
                        $(".upload_btn div").remove();
                       $("#upload_video").val(data.url);
                    }else{
                        $(".loading").addClass('hide');
                        layer.msg('上传失败');
                    }
                },
                error:function(xhr){ //上传失败
                    alert("上传失败");
                }
            });
        }
        else{
            alert("请选择视频文件");
        }

    }
    function userlogin(){

        var url = "/jdt/active/baoming";
        localStorage.setItem("redirect", url);

        layer.msg('请先注册');
        setTimeout(function(){
            window.location.href = "/register";
        }, 300);
    }
    function getDataInfo(identity,data){
        if(identity == '管理方向'){

            data.years_management = $("#years_management").val();
            data.year_wages = $("#year_wages").val();
            data.store_num = $("#store_num").val();
            data.staff_num = $("#staff_num").val();
            data.achievement_store = $("#achievement_store").val();
        }else if(identity == '已创业'){
            data.years_chuangye = $("#years_chuangye").val();
            data.cy_store_num = $("#cy_store_num").val();
            data.cy_store_type = $("#cy_store_type").val();
            data.cy_staff_num = $("#cy_staff_num").val();
            data.cy_position = $("#cy_position").val();
            data.cy_achievement = $("#cy_achievement").val();
        }else if(identity == '准备创业'){
            data.ready_store_type = $("#ready_store_type").val();
            data.ready_time = $("#ready_time").val();
            data.ready_occupation = $("#ready_occupation").val();
            if($("#ready_occupation").val() == '管理岗'){
                data.years_management = $("#years_management").val();
                data.year_wages = $("#year_wages").val();
                data.store_num = $("#store_num").val();
                data.staff_num = $("#staff_num").val();
                data.achievement_store = $("#achievement_store").val();
            }
        }else if(identity == '明星教练方向'){

            data.star_years = $("#star_years").val();
            data.star_reward_get = $("#star_reward_get").val();
            data.star_num_get = $("#star_num_get").val();
            data.star_honor_get = $("#star_honor_get").val();
        }
        return data;
    }

    var f_channel = localStorage.getItem("f_channel");
    console.log(f_channel);  //渠道信息
    var user_id = '{{$user_id}}';
    $(function () {
        $("#form1").mvalidate({
            type: 1,
            onKeyup: true,
            sendForm: true,
            firstInvalidFocus: false,
            valid: function (event, options) {
                //点击提交按钮时,表单通过验证触发函数
//                alert("验证通过！接下来可以做你想做的事情啦！");
                event.preventDefault();
                var avatar = $("input[name='photo']").val();
                var name   = $("#name").val();
                var sex    = $("#sex").val();
                var number   = $("#number").val();
                var content  = $("#content").val();
                var title    = $("#title").val();
                var date     = $("#date").val();
                var hours    = $("#hours").val();
                var cover_img    = $("#cover_img").val();
                var token    = '{{csrf_token()}}';
                //alert(cover_img);
                var data = {title:title, avatar:avatar,name:name,_token:token,sex:sex, number:number, content:content, date:date, hours:hours, cover_img:cover_img};

                //data = getDataInfo(identity,data);
//                console.log(data);return;
                $.ajax({
                    url:'/jdt/youku/postJoin',
                    data:data,
                    type:'POST',
                    dataType:'json',
                    success:function(res){
                        if(res.code == 0){
                            layer.msg('提交成功');
                            console.log(res.data.date);
                            return;
//                            $('.codeWBtn').click(function(){
//                            if(user_id == 93271){
                                $.ajax({
                                    url:"/jdt/active/poster",
                                    data:{_token:token},
                                    type:'POST',
                                    dataType:'json',
                                    success:function(res){
                                        if(res.code == 0){
                                            layer.open({
                                                type: 1,
                                                title: false, //不显示标题栏
                                                skin: 'codeW_layer_wrap codeW_layer_success', //样式类名
                                                id: 'codeW_layer', //设定一个id，防止重复弹出
                                                closeBtn: 0, //不/显示关闭按钮
                                                anim: 2,
                                                shadeClose: 0, //开启/关闭遮罩
                                                shade: [1, '#fdd000'],
                                                area: ['30%', '80%'],
                                                content:'<div class="hideWImg text_center mt16 relative">' +
                                                '<div class="stamp">'+
                                                '<a class="Wjump d-in-black border-radius50 f26 fz" href="/jdt/active/vote">跳过</a>' +
                                                '<p class="fz f44 mb40 bold mt50 color_FA6C11">海选报名成功</p>' +
                                                '<p class="plr30 fz f30 color_333 mt20 mb40">' +
                                                '<span class="block">关注公众号</span>' +
                                                '<span class="block">获取专属你的拉票海报</span>' +
                                                '<span class="block">分享好友拉票有机会直接进入初选</span>' +
                                                '</p>' +
                                                '<img src="'+res.data.img+'" alt="赛普健身社区">' +
                                                '</div>'+
                                                '</div>',
                                                btn:false,
                                                success: function(layero,index){
                                                    /*$(".codeW_layer_success .Wjump").click(function(){
                                                     layer.closeAll();
                                                     })*/
                                                    setTimeout(function() {
                                                        $('.codeW_layer_success').addClass('loaded')
                                                    }, 160)
                                                }
                                            });
                                        }

                                    }
                                });

//                            });
//
                        }else if(res.code == 4){

//                            userlogin();
                        }else{
                            layer.msg(res.message);
                        }
                    }
                })
            },
            invalid: function (event, status, options) {
                //点击提交按钮时,表单未通过验证触发函数
            },
            eachField: function (event, status, options) {
                //点击提交按钮时,表单每个输入域触发这个函数 this 执向当前表单输入域，是jquery对象
            },
            eachValidField: function (val) {},
            eachInvalidField: function (event, status, options) {},
            conditional: {
                /*confirmpwd: function () {
                 return $("#pwd").val() == $("#confirmpwd").val();
                 }*/
            },
            descriptions: {
                name: {
                    required: '请输入您的姓名'
                },
                // mobile: {
                //     required: '请输入您的手机号码',
                //     pattern: '你输入的手机号码不正确'
                // },
                // wechat: {
                //     required: '请输入您的微信号码'
                // },
                sex: {
                    required: '请选择性别'
                },
                number: {
                    required: '请输入您的大鱼号昵称',
                    pattern: '你输入的大鱼号昵称格式不正确'
                },
                content:{
                    required: '请输入您的直播内容',
                    pattern: '你输入的直播内容格式不正确'
                },
                date:{
                    required: '请选择直播日期'
                },
                hours: {
                    required: '请选择直播时段'
                },title:{
                    required: '请输入您的直播主题',
                    pattern: '你输入的直播主题格式不正确'
                }
            }
        });
        $(".bmSubmit").click(function(){

            $("#form1").submit();
        });

        //性别
        $("#sex").picker({
            title: "请选择您的性别",
            cols: [{
                textAlign: 'center',
                values: ['男', '女']
            }]
        });

        //学历
        $("#date").picker({
            title: "请选择您的直播日期",
            cols: [{
                textAlign: 'center',
                values: ['3月6日', '3月7日', '3月8日']
            }]
        });

        //是否体育专业
        $("#hours").picker({
            title: "请选择您的直播时段",
            cols: [{
                textAlign: 'center',
                values: ['16:00——17:00', '17:00——18:00', '18:00——19:00', '19:00——20:00']
            }],
            onChange: function (p, v, dv) {

            },
            onClose: function (p, v, dv) {

            }
        });

        //城市
        $("#city").cityPicker({
            title: "您所在的城市",
            showDistrict: false, //设置可以不显示地区（只选择省市
            onChange: function (picker, values, displayValues) {

            }
        });

        //职位
        $("#position").picker({
            title: "请选择您的职位",
            cols: [{
                textAlign: 'center',
                values: ['教练', '管理者', '创业', '其他']
            }]
        });

        //工作年限
        $("#working_life").picker({
            title: "请选择您的工作年限",
            cols: [{
                textAlign: 'center',
                values: ['一年以内', '1-2年', '2-3年', '3年以上']
            }]
        });

        //是否做自媒体创作
        $("#self_media").picker({
            title: "请选择您是否做自媒体创作",
            cols: [{
                textAlign: 'center',
                values: ['是', '否']
            }],
            onChange: function (p, v, dv) {
                console.log(p, v, dv);
            },
            onClose: function (p, v, dv) {

            }
        });

        /*-----------------------------------------------------------*/
        //身份信息
        $("#identity").picker({
            title: "请选择您的身份",
            cols: [{
                textAlign: 'center',
                values: ['管理方向', '已创业', '准备创业', '明星教练方向']
            }],
            onClose:function(){
                /*
                 * 管理方向 === admin_direction
                 * 是否已经在创业-已创业 === entrepreneurship
                 * 是否已经在创业-准备创业 === ready_entrepreneurship
                 * 明星教练方向 === start_coach
                 */
                var value = $("#identity").val();
                if(value == '管理方向'){
                    $(".admin_direction").slideDown().removeClass("none");

                    $(".entrepreneurship").slideUp().addClass("none");
                    $(".ready_entrepreneurship").slideUp().addClass("none");
                    $(".start_coach").slideUp().addClass("none");

                    $(".admin_direction input").attr("data-required",'true');
                    $(".entrepreneurship input").removeAttr("data-required");
                    $(".ready_entrepreneurship input").removeAttr("data-required");
                    $(".start_coach input").removeAttr("data-required");

                }else if(value == '已创业'){
                    $(".entrepreneurship").slideDown().removeClass("none");

                    $(".admin_direction").slideUp().addClass("none");
                    $(".ready_entrepreneurship").slideUp().addClass("none");
                    $(".start_coach").slideUp().addClass("none");

                    $(".entrepreneurship input").attr("data-required",'true');
                    $(".admin_direction input").removeAttr("data-required");
                    $(".ready_entrepreneurship input").removeAttr("data-required");
                    $(".start_coach input").removeAttr("data-required");

                }else if(value == '准备创业'){
                    $("#ready_occupation").val("");
                    $(".ready_entrepreneurship").slideDown().removeClass("none");

                    $(".admin_direction").slideUp().addClass("none");
                    $(".entrepreneurship").slideUp().addClass("none");
                    $(".start_coach").slideUp().addClass("none");

                    $(".ready_entrepreneurship input").attr("data-required",'true');
                    $(".admin_direction input").removeAttr("data-required");
                    $(".entrepreneurship input").removeAttr("data-required");
                    $(".start_coach input").removeAttr("data-required");

//                    getOccupation();

                }else if(value == '明星教练方向'){
                    $(".start_coach").slideDown().removeClass("none");

                    $(".admin_direction").slideUp().addClass("none");
                    $(".entrepreneurship").slideUp().addClass("none");
                    $(".ready_entrepreneurship").slideUp().addClass("none");

                    $(".start_coach input").attr("data-required",'true');
                    $(".admin_direction input").removeAttr("data-required");
                    $(".entrepreneurship input").removeAttr("data-required");
                    $(".ready_entrepreneurship input").removeAttr("data-required");
                }
            }
        });

        /*管理方向------------*/
        //管理年限
        $("#years_management").picker({
            title: "请选择您的管理年限",
            cols: [{
                textAlign: 'center',
                values: [ '1-2年', '3年', '4年','5年及以上']
            }]
        });

        //最近一年平均工资
        $("#year_wages").picker({
            title: "请选择您的一年平均工资",
            cols: [{
                textAlign: 'center',
                values: [ '4000及以下', '6000-8000', '8000-10000','10000-15000','15000-20000','20000-30000','30000以上']
            }]
        });

        /*已创业--------------*/
        //创业年限
        $("#years_chuangye").picker({
            title: "请选择您的创业年限",
            cols: [{
                textAlign: 'center',
                values: [ '1-2年', '3年', '4年','5年及以上']
            }]
        });
        //门店数量
        $("#cy_store_num").picker({
            title: "请选择您的门店数量",
            cols: [{
                textAlign: 'center',
                values: [ '1家', '2家','3家及以上']
            }]
        });
        //门店类型
        $("#cy_store_type").picker({
            title: "请选择您的门店类型",
            cols: [{
                textAlign: 'center',
                values: [ '俱乐部', '工作室']
            }]
        });
        //门店类型
        $("#cy_position").picker({
            title: "请选择您的定位",
            cols: [{
                textAlign: 'center',
                values: [ '高端', '中高端','中端']
            }]
        });

        /*准备创业--------------*/
        //准备开店类型
        $("#ready_store_type").picker({
            title: "请选择您准备开店的类型",
            cols: [{
                textAlign: 'center',
                values: [ '俱乐部', '工作室']
            }]
        });
        //准备什么时候创业
        $("#ready_time").picker({
            title: "请选择您准备创业时间",
            cols: [{
                textAlign: 'center',
                values: [ '1个月内', '3个月内','3个月-半年','半年以上','不确定']
            }]
        });

        //目前从事职位
        $("#ready_occupation").picker({
            title: "请选择您目前从事的职位",
            cols: [{
                textAlign: 'center',
                values: [ '管理岗', '不是管理岗']
            }],
            onClose:function() {
                /*
                 * 管理方向 === admin_direction
                 * 是否已经在创业-已创业 === entrepreneurship
                 * 是否已经在创业-准备创业 === ready_entrepreneurship
                 * 明星教练方向 === start_coach
                 */

                var value = $("#ready_occupation").val();
//                alert(value);
                if(value == '管理岗' || value ==''){
                    $("#ready_occupation").val("管理岗");
                    $(".admin_direction").slideDown().removeClass("none");
                    $(".admin_direction input").attr("data-required",'true');
                }else if(value == '不是管理岗'){
                    $(".admin_direction").slideUp().addClass("none");
                    $(".admin_direction input").removeAttr("data-required");
                }
            }

        });

        /*明星教练方向--------------*/
        //从教年限
        $("#star_years").picker({
            title: "请选择您从教年限",
            cols: [{
                textAlign: 'center',
                values: [ '1年以下', '1年-2年','2年-3年','3年以上']
            }]
        });


        //播放视频
        $('.video_box .mask_box').click(function () {
            $('.video_box .mask_box').show(); //点击别的视频会把视频背景图再次呼出
            $(this).hide();
            $(this).next().trigger('play');
        })
    });

</script>



<script type="text/javascript">
    //视频上传，不知道有用没有
    function filesize(ele) {
        var filesize = (ele.files[0].size / 1024 / 1024).toFixed(2);
        $('#big').html(filesize + "MB");
        $('#text').html(ele.files[0].name);
    }
    $(document).ready(function (e) {

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
    var title = '赛普之星百人健身直播申报';
    var desc = '提交直播信息，离明星更近一步';
    // var desc = '报名角逐 “TRAIN TO WIN”大奖，专享赛普&耐克超级健身盛典顶级资源';
    var share_img = "http://m.saipubbs.com/images/zt/just_do_it/youku.png";
    var url = "http://m.saipubbs.com/jdt/youku/baoming";
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img // 分享图标

        }, function(res) {
            //这里是回调函数

        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: title, // 分享标题
            link: url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img // 分享图标

        }, function(res) {
            //这里是回调函数

        });
    });
    //弹窗
    $(function (){
        var date = new Date();
        Y = date.getFullYear();
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1);
        D = date.getDate() < 10? '0'+(date.getDate()): date.getDate();
        var dateTime = Y+''+M+''+D;
        //弹窗
        $('.ad_img_img').click(function(){
           layer.open({
               type: 1,
               title: false, //不显示标题栏
               skin: 'bm_success_layer_wrap homge_layer_toupiao', //样式类名
               id: 'bm_success_layer', //设定一个id，防止重复弹出
               closeBtn: 1, //不显示关闭按钮
               anim: 2,
               shadeClose: true, //开启遮罩关闭
               area: ['80%', '70%'],
               content:$('.bm_success_layer_wrap'),
               btn:false
           });
        })
        //localStorage.setItem('subscribe_'+dateTime, null);
        // 点击x关闭
        $('.img_close').click(function() {
            $(this).hide();
            $(".ad_img_img").hide();
            localStorage.setItem('subscribe_'+dateTime, 1);
        });
        var subscribe = localStorage.getItem('subscribe_'+dateTime);
        var isShow    = "{{$subscribe}}";
        if(isShow==0){
            $(".ad_code").show();
        }
        if(subscribe==1){
            $(".ad_code").hide();
        }
    })
</script>

<script>
    //[ 报名成功 ]二维码弹窗

</script>
</body>
</html>