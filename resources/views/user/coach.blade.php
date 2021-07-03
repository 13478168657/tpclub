<!DOCTYPE html>
<html lang="zh-CN" class="htmlWhite">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>申请教练资格认证</title>
    <meta name="author" content="涵涵" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <script src="/js/jquery-1.11.2.min.js"></script>
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/my.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/css/font-num40.css">
</head>
<body class="bgc_white">

<div class="plr30 fz Zige">
    <ul>
        <li>
            <h3 class="pt40 f30 color_333 fz">公司或组织全称</h3>
            <input class="plr20" name="company" type="text" placeholder="请输入公司名称">
        </li>
        <li>
            <h3 class="pt40 f30 color_333 fz">认证信息</h3>
            <input class="plr20" name="info" type="text" placeholder="例如：教练/店长/教练经理/CEO">
        </li>
        <li>
            <div class="fileImg pt40 mt30">
                <div class="weui-cells weui-cells_form nobefore noafter">
                    <div class="weui-cell">
                        <div class="weui-cell__bd">
                            <div class="weui-uploader">
                                <div class="weui-uploader__bd">
                                    <ul class="weui-uploader__files img_list" id="uploaderFiles">

                                    </ul>
                                    <div class="weui-uploader__input-box">
                                        <input id="uploaderInput" class="weui-uploader__input" type="file" accept="image/*" multiple="">
                                    </div>
                                </div>
                                <p class="ptb30 fz f24 color_gray666">请上传教练资格证<br>或者工作证明</p>
                                <p class="ptb30 fz f22 color_red text-jus">提交后我们的工作人员将会在3个工作日内完成审核，请耐心等待。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>

<div class="Baocun plr30 bgcolor_fff">
    <input type="button" id="btnSubmit" value="完成提交" class="bgcolor_orange border-radius-img f34 color_333" />
</div>

<br><br><br><br><br>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script type="text/javascript" src="/js/base64/localResizeIMG.js"></script>
<script type="text/javascript" src="/js/base64/mobileBUGFix.mini.js"></script>
<script type="text/javascript">

    var imgurl_list = "";
    var _token      = '{{csrf_token()}}';
    var imgUrl      = "{{env('IMG_URL')}}";
    var img_number  = 0;
    var c_length    = 0;
    $('#uploaderInput').localResizeIMG({
        width:800,// 宽度
        quality: 0.8, // 压缩参数 1 不压缩 越小清晰度越低
        success: function (result) {
//            console.log(result);
            var img = new Image();
            img.src = result.base64;
            c_length = $(".img_url_list").length;
            c_length++;

            $(".img_list").append('<li><div class="operation"><span class="btn_del img_url_list" onclick="btn_delimg(this)" id="cur_span'+c_length+'" data-url=""></span></div><img src="'+img.src+'" alt="" class="img100" /></li>');
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

    $("#btnSubmit").click(function(){
        $(".img_url_list").each(function(){
            var cur = $(this).attr("data-url");
            imgurl_list+=cur+",";
        });
        var company = $("input[name='company']").val();
        var info = $("input[name='info']").val();
        if(company == '' || company == undefined){
            layer.msg('请填写公司或组织全称');
            return false;
        }
        if(info == '' || info == undefined){
            layer.msg('请填写认证信息');
            return false;
        }
        var token = '{{csrf_token()}}';
        var data = {company: company,info: info,imgUrl:imgurl_list,_token:token};
        $.ajax({
            url:'/apply/coach/verify',
            type:'POST',
            data:data,
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    layer.msg(res.message);
                    window.location.href="/user/edit";
                }else{
                    layer.msg(res.message);
                    return false;
                }
            }
        });
    });

</script>
</body>
</html>