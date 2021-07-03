<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="han"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no"/>
    <title>回答-添加标签-健身教练专业问答平台</title>
   <meta name="keywords" content="赛普知道作为健身教练的专业问答平台，致力于解决健身教练工作、职场、以及会员管理等方面的问题，帮助教练在专业知识以及技能方面获得提升。增肌减脂有问题，就来赛普知道，百名专业老师坐镇回答，问答涉及训练技术、减脂增肌、运动康复、运动营养、健身热门话题等多个方向，只有你没问到的健身问题，没有老师答不了的。" />
    <meta name="description" content="健身问题,增肌问题,减脂问题,产后问题,康复训练" />
    <!-- jqweui -->
    <link rel="stylesheet" href="/lib/jqweui/css/jquery-weui.css">
    <link rel="stylesheet" href="/lib/jqweui/css/weui.min.css">

    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/font-num40.css">
    <link rel="stylesheet" href="/css/ask-addtag.css">
    <link rel="stylesheet" type="text/css" href="/css/zt/zt_tiwensongke.css" >
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()

    </script>

</head>
<body>
<div class='bgcolor_fff'>
    <div class="page_ask_addtag bgc_white">
        <!-- 头部条 start -->
        <header class="header_bar max750 relative fz">
            <a href="javascript:history.go(-1);" class="btn_cancel color_gray999 f24">取消</a>
            <a href="javascript:void(0)" class="btn_link btn_submit btn_submit_task color_gray999 f24">提交</a>
        </header>
        <!-- 头部条 end -->
        <!-- 表单区 start -->
        <div class="ask_con fz">
            <div class="iptBox">
                <input type="text" id="tit" placeholder="请用一句话描述问题并以问号结尾（最多35字）" maxlength="50" class="f28" />
            </div>
            <div class="textareaBox">
                <textarea placeholder="请详细描述问题，认真的提问才能带来优质的回答哦～" id="content"></textarea>
            </div>


            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <div class="weui-uploader">
                            <div class="weui-uploader__bd">
                                <ul class="weui-uploader__files img_list" id="uploaderFiles">

                                </ul>
                                <div class="weui-uploader__input-box" id="upload_button">
                                    <input id="uploaderInput" class="weui-uploader__input" type="file" accept="image/*" multiple="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- 表单区 end -->
    </div>

    <div class="pt40 pb30 mb30">
        <p class="f34 plr30 fz mt32 pt40 color_orange">+添加问题标签（至少添加一个标签）</p >
        <div class=" bgc_white fz ask_addtag_popup plr30">
            <!-- 添加标签 start -->
            <div class="add_tags mt32">
                <div class="inputWrap tagsWrap">
                    <div class="relative">
                        <span class="ico_zoom"></span>
                        <input type="text" class="input f26 selectTag" placeholder="每个标签不超过6个字|例：增肌" />
                        <span class="btn_addtags f28" style="curser:pointer;">添加</span>
                    </div>
                    <p class="tip f28 pt10 pb10 mt10 color_c9c7c7"></p >
                    <ul class="clearfix">
                    </ul>
                </div>
                <!-- 标签列表 -->
                <div class="autocompleteWrap pb20">
                    <ul id="ui-id-1" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front" style="display: none;"></ul>
                </div>
            </div>
            <!-- 添加标签 end -->
        </div>
    </div>
    <br><br>
    </div>

<script src="/js/jquery-1.11.2.min.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<!-- <script src="/js/ask.js"></script> -->
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/jquery-ui/jquery-ui.js" type="text/javascript"></script>
<link href="/lib/jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/base64/localResizeIMG.js"></script>
<script type="text/javascript" src="/js/base64/mobileBUGFix.mini.js"></script>
<script>

    var tags = [];//标签数组
    var maxTagNum = 3;//最大标签数
    var tagsNum = 0;
    var cid = '{{$cid}}';
    //打开popup
    $('.open-popup').click(function () {
        tagsNum = tags.length;

        if (tagsNum == 0) {
            $('.tagsWrap .tip').text('至少添加一个标签');
        } else {
            $('.tagsWrap .tip').text('您还可添加' + (maxTagNum - tagsNum) + '个标签');
        }
    })

    //添加标签项
    $(document).on('touchstart',".btn_addtags", function () {
        var val = $('.tagsWrap .input').val();
        var len = tags.length;
        console.log(len, 'len')
        if (len >= 3) {
            layer.msg('最多添加3个标签');
            return false;
        }
        if (val == '') {
            layer.msg('请输入标签');

        } else {
            tags.push(val);//往数组里插入新值并返回新数组长度
            console.log(tagsNum);
            tagsNum = tags.length;
            $('.tagsWrap .input').val('');//清空输入框
            $('.autocompleteWrap ul').empty();//清空联动列表
            $('<li><b>' + val + '</b><span class="btn_close" style="curser:pointer;"></span></li>').appendTo(".tagsWrap ul");//添加标签列表项
            $('.tagsWrap .tip').text('您还可添加' + (maxTagNum - tagsNum) + '个标签');//改变剩余提示
        }
    });

    //删除标签项（popup里）
    $(document).on('touchstart',".tagsWrap ul li .btn_close", function () {
        var val = $(this).prev().text();
        console.log(val)
        $(this).parents('li').remove();
//        tags.removeByValue(val);//删除数组元素
        tags.forEach(function(item, index, arr) {
            if(item == val) {
                arr.splice(index, 1);
            }
        });

        tagsNum = tags.length;
        $('.tagsWrap .tip').text('您还可添加' + (maxTagNum - tagsNum) + '个标签');
    })

    //自动完成数据
    var bind_name = 'input';
    if (navigator.userAgent.indexOf("MSIE") != -1){
        bind_name = 'propertychange';
    }
    $('.selectTag').on('input propertychange', function(){
        var key = $(this).val();
        var data = {keyword:key};
        $.ajax({
            url:'/get/tags',
            data:data,
            type:'GET',
            dataType:'json',
            success:function(res){
                var source = res.data.tags;
                var str = '';
                for(var i in source) {
                    console.log(i,":",source[i].name);
                    str += "<li class='ui-menu-item'><div class='ui-menu-item-wrapper ui-state-active'>" + source[i].name + "</div><span onclick='chooseTag(this);' class='btn_add1'>添加</span></li>";
                }
                $(".autocompleteWrap #ui-id-1").html(str);

            }

        })
    })

    function getTags(obj){

    }

    function chooseTag(obj){
        var val = $(obj).prev().text();
        var len = tags.length;
        console.log(len, 'len')
        if (len >= 3) {
            layer.msg('最多添加3个标签');
            return false;
        }
        if (val == '') {
            layer.msg('请输入标签');

        } else {
            tags.push(val);//往数组里插入新值并返回新数组长度
            tagsNum = tags.length;
            $('.tagsWrap .input').val('');//清空输入框
            $('.autocompleteWrap ul').empty();//清空联动列表
            $('<li><b>' + val + '</b><span class="btn_close" style="curser:pointer;"></span></li>').appendTo(".tagsWrap ul");//添加标签列表项
            $('.tagsWrap .tip').text('您还可添加' + (maxTagNum - tagsNum) + '个标签');//改变剩余提示
        }
    }



    //完成
    $(document).on('touchstart',".btn_complete",  function () {
        $('.tagsWrap ul li').clone().appendTo(".page_ask_addtag .tags");
        $('.tagsWrap ul').empty();
        $('.tagsWrap .tip').text('您还可添加3个标签');
        //$('<li><b></b><span class="btn_close"></span></li>').replaceAll($(this));

    });

    //删除标签项
    $(document).on( 'touchstart',".page_ask_addtag .tags .btn_close", function () {
        var val = $(this).prev().text();
//        tags.removeByValue(val);//删除数组元素
        tags.forEach(function(item, index, arr) {
            if(item == val) {
                arr.splice(index, 1);
            }
        });
        $(this).parents('li').remove();//移除标签项
    });


    var imgurl_list = "";
    var _token      = '{{csrf_token()}}';
    var imgUrl      = "{{env('IMG_URL')}}";
    var img_number  = 0;
    var c_length    = 0;
    $('input:file').localResizeIMG({
        width:800,// 宽度
        quality: 0.8, // 压缩参数 1 不压缩 越小清晰度越低
        success: function (result) {
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
    $('.btn_submit_task').click(function (){
        imgurl_list = "";
        $(".img_url_list").each(function(){
            var cur = $(this).attr("data-url");
            imgurl_list+=cur+",";
        });

        var tit = $('#tit').val();
        if(tit.length > 35){
            layer.msg('问题不能超过35字');
            return false;
        }
        var con = $('#content').val();
        var tag = tags.join(',');

        if(!tit){
            layer.msg('标题不能为空');
        }else if(!con){
            layer.msg('内容不能为空');
        }else if(tag == ''){
            layer.msg('标签不能为空');
        }else{
            $(this).addClass('disabled-ask');
            $.ajax({
                url : '/cak/addQuestion',
                type : 'post',
                dataType : 'json',
                data : {title:tit, desc:con,tag:tag, img_url:imgurl_list,cid:cid, _token:_token},
                success : function (data) {
                    if(data.code==0){
                        window.location.href='/cak/1.html';
                    }else{
                        $(this).removeClass('disabled-ask');
                        if(data.code == 2){
                            layer.msg(data.message);
                            $.closePopup();//关闭弹出框
                            window.location.href='/login?redirect=/cak/user/add.html';
                            return false;
                        }else if(data.code == 3){
                            layer.open({
                                type: 1,
                                title: false, //不显示标题栏
                                skin: 'songke_layer_wrap', //样式类名
                                id: 'songke_layer4', //设定一个id，防止重复弹出
                                closeBtn: 0, //不/显示关闭按钮
                                anim: 2,
                                shadeClose: 1, //开启/关闭遮罩
                                shade: [0.7, '#000'],
                                area: ['30%', '60%'],
                                content:data.data.content,
                                btn:false
                            });
                        }
                        layer.msg(data.message);
                        $.closePopup();//关闭弹出框
                    }
                }
            });
            $.closePopup();//关闭弹出框
        }

    })

    function courseWatch(obj){
        var cid = $(obj).attr('data-id');
        window.location.href = '/course/detail/'+cid+'.html';
    }

</script>
</body>
</html>