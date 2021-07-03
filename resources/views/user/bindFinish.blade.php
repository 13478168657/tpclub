<!DOCTYPE html>
<html lang="zh-CN" class="htmlH100">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>绑定成功</title>
    <meta name="author" content="涵涵" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/my.css?t=1.1" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/css/font-num40.css">
</head>
<body class="page_reg pt0" ontouchstart>

<!-- 绑定手机号 start -->
<div class="form_container MyWrap pt40">
    <p class="text_right relative"><a onclick="href_go();" class="tiao border-radius50">跳过</a></p>
    <h4 class="f50 color_333 bold pt40 mt30">恭喜你录入成功</h4>
    <p class="f26 fz color_gray666 pb30 mb30">为了方便提供你想要的内容，请选择感兴趣的标签</p>
    <form method="post" action="" id="regForm">
        <ul>
            <li>
                <div class="selectSfList selectSfListB text_center">
                    <ul class="clearfix fz f28">
                        <li>
                            <input type="radio" name="interest" value="增肌健美" id="11" checked>
                            <label for="11">增肌健美</label>
                        </li>
                        <li>
                            <input type="radio" value="减脂塑形" name="interest" id="12">
                            <label for="12">减脂塑形</label>
                        </li>
                        <li>
                            <input type="radio" value="体态康复" name="interest" id="13">
                            <label for="13">体态康复</label>
                        </li>
                        <li>
                            <input type="radio" value="孕产" name="interest" id="14">
                            <label for="14">孕产</label>
                        </li>
                        <li>
                            <input type="radio" value="营养恢复" name="interest" id="15">
                            <label for="15">营养恢复</label>
                        </li>
                        <li>
                            <input type="radio" value="私教销售" name="interest" id="15">
                            <label for="15">私教销售</label>
                        </li>
                        <li>
                            <input type="radio" value="职业规划" name="interest" id="15">
                            <label for="15">职业规划</label>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="MysubmitBtn plr30 bgcolor_fff">
                <input type="button" value="完成并提交" class="submitBtn  bgcolor_orange border-radius-img f34 color_333" />
            </li>
        </ul>
    </form>
</div>
<!-- 绑定手机号 end -->


<br><br><br><br>
<script src="/lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/icheck/js/icheck.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/js/js.js"></script>
<script>
    $(function(){

        //单选按钮
        $('.radio').iCheck({
            //checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio',
            increaseArea: '20%'
        });

        $(".submitBtn").click(function(){
            var interest = $("input[name='interest']:checked").val();
            var token = '{{csrf_token()}}';
            var data = {interest:interest,_token: token};
            $.ajax({
                url:'/bind/interest',
                data:data,
                type:'POST',
                dataType:'json',
                success:function(res){
                    var url = localStorage.getItem('redirect');

                    if(res.code == 0){
                        layer.msg(res.message);
                        if(url !='' && url != null){
                            localStorage.removeItem('redirect');
                            window.location.href = url;
                        }else{
                            window.location.href="/user/edit";
                        }
                    }else{
                        layer.msg(res.message);
                    }
                }
            })
        })
    })

    function href_go(){
        var url = localStorage.getItem('redirect');
        if(url !='' && url != null){
            localStorage.removeItem('redirect');
            window.location.href = url;
        }else{
            window.location.href="/user/edit";
        }
    }
</script>
</body>
</html>
