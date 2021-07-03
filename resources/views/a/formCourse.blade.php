<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普健身私教课免费领取</title>
    <meta name="author" content="啾啾" />
    <meta name="keywords" content="" />
    <meta name="description" content="健身教练入门免费体验！2020抓住健康风口，给你前途未来" />
    <link rel="stylesheet" type="text/css" href="/lib/jqweui/css/weui.min.css" />
    <link rel="stylesheet" type="text/css" href="/lib/jqweui/css/jquery-weui.min.css"/>
    <link rel="stylesheet" type="text/css" href="/css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="/css/font-num40.css" >
    <!--本css-->
    <link rel="stylesheet" type="text/css" href="/css/zt/zt_JobFeedback2.css?t=1">

    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
</head>
<body ontouchstart>
<div>
    <div >
        <div class="plr30">
            <div class="fz color_333">
                <h3 class="f30 bold ptb30 text_center">恭喜您，获得免费体验赛普健身教练课程的机会。
请您如实填写以下信息，我们会为您开通听课权限。</h3>
            </div>
            <div>
                <div class="JobAsk">
                    <form method="post" action="" id="form1">
                    <ul>
                        <li>
                            <div class="checkboxWrap mt32 mb50 pt20 fz">
                                <h3 class="fz f30 mb30 text-jus">1、您是健身爱好者吗？</h3>
                                <div class="plr45">
                                    <ul>
                                        <li><label class="fz f28 mb10"><input type="radio" name="identify" autocomplete="off" {{$identify == '对健身不感兴趣'?'checked':''}} class="radiobox" value="对健身不感兴趣" />对健身不感兴趣</label></li>
                                        <li><label class="fz f28 mb10"><input type="radio" name="identify" autocomplete="off" {{$identify == '健身小白'?'checked':''}} class="radiobox" value="健身小白" />健身小白</label></li>
                                        <li><label class="fz f28 mb10"><input type="radio" name="identify" autocomplete="off" {{$identify == '健身1-3年'?'checked':''}} class="radiobox" value="健身1-3年" />健身1-3年</label></li>
                                        <li><label class="fz f28 mb10"><input type="radio" name="identify" autocomplete="off" {{$identify == '想成为健身教练'?'checked':''}} class="radiobox" value="想成为健身教练" />想成为健身教练</label></li>
                                        <li><label class="fz f28 mb10"><input type="radio" name="identify" autocomplete="off" {{$identify == '健身教练'?'checked':''}} class="radiobox" value="已经是健身教练" />已经是健身教练</label></li>
                                    </ul>
                                    <input type="hidden" name="cid" value="{{$cid}}" />
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="checkboxWrap mt32 mb50 pt20 fz">
                                <h3 class="fz f30 mb30 text-jus">2、您是否希望获得更多健身教练的专业和职业信息？<span>*</span></h3>
                                <div class="plr45">
                                    <ul>
                                        <li><label onclick="block_box2_yes()" class="fz f28 mb10"><input type="radio" name="is_know" autocomplete="off" {{$is_know=='是'?'checked':''}} value="想了解" class="radiobox" />想了解</label></li>
                                        <li><label onclick="block_box2_no()" class="fz f28 mb10"><input type="radio" name="is_know" autocomplete="off" {{$is_know=='否'?'checked':''}} value="不想了解" class="radiobox" />不想了解</label></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                          <li class="" >
                            <div class="checkboxWrap mt32 mb50 pt20 fz">
                                <h3 class="fz f30 mb30 text-jus">3、您的手机号是?<span>*</span></h3>
                                <div class="plr45">
                                    <ul>
                                        <li>
                                            <input name="mobile" value="" placeholder="请输入您的手机号" />
                                            <!-- <textarea name="other_profit" placeholder="">{{$other_profit}}</textarea> -->
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                          <li class="" >
                            <div class="checkboxWrap mt32 mb50 pt20 fz">
                                <h3 class="fz f30 mb30 text-jus">4、您的姓名是？（为您发送听课信息用）<span>*</span></h3>
                                <div class="plr45">
                                    <ul>
                                        <li>
                                        <input name="wechat" value="" placeholder="请输入您的姓名" />
                                            <!-- <textarea name="other_profit" placeholder="">{{$other_profit}}</textarea> -->
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>



                    </ul>
                    </form>
                    @if(!$flag)
                        {{--<a href="javascript:void (0)" class="JobBtn text_center f30 bgcolor_orange mt100 fz">提交</a>--}}
                        <input type="button" value="提交报名信息" class="JobBtn bmSubmit btn1 text_center f30 bgcolor_orange mt100 fz" />
                    @else
                        {{--<a href="javascript:void (0)" class="JobBtn text_center f30 bgcolor_orange mt100 fz">已提交</a>--}}
                        <input type="button" value="已提交报名信息" class="JobBtn btn1 text_center f30 bgcolor_orange mt100 fz" onclick="javascript:layer.msg('课程已经领取 请在赛普健身社区【我的课表】中查看');" />
                    @endif
                </div>
            </div>
        </div>
        <!--====================================本喵是分割线 喵喵！==================================================-->

    </div>



    <!--====================================本喵是有底线哒 喵喵！==================================================-->
</div>


<br><br><br>
<script src="/js/jquery-1.11.2.min.js" type="text/javascript"></script>
<script src="/lib/icheck/js/icheck.min.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/city-picker.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/js/upload.js" type="text/javascript"></script>
<script src="/lib/mobileValidate/js/jquery-mvalidate.js"></script>
<script src="/js/base64/mobileBUGFix.mini.js" type="text/javascript"></script>
{{--<script type='text/javascript' src='/js/jQuery.form.js'></script>--}}
<script type='text/javascript' src='https://www.17sucai.com/preview/227408/2019-05-22/1/js/jquery.form.js'></script>
<script>
    $('body').addClass('bb bgcolor_fff');

    /*第2个问题*/
    function block_box2_yes(){
        $("#d3").slideDown().removeClass("none");
        $("#d4").slideDown().removeClass("none");
        $("#d5").slideDown().removeClass("none");
        $("#d6").slideDown().removeClass("none");

    }
    function block_box2_no(){
        $("#d3").slideUp().addClass("none");
        $("#d4").slideUp().addClass("none");
        $("#d5").slideUp().addClass("none");
        $("#d6").slideUp().addClass("none");
    }



    $(function(){
        //多选按钮
        $('.checkbox').iCheck({
            //checkboxClass: 'icheckbox_square-green',
            radioClass: 'icheckbox',
            increaseArea: '20%'
        });

        //单选按钮
        $('.radiobox').iCheck({
            //checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio',
            increaseArea: '20%'
        });

    });
    var cid = '{{$cid}}';
    function userlogin(){

        var url = "/active/form/"+cid+".html";
        localStorage.setItem("redirect", url);
        layer.msg('请先注册');
        setTimeout(function(){
            window.location.href = "/register";
        }, 300);
    }
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
                var identify = $("input[name='identify']:checked").val();
                var is_know = $("input[name='is_know']:checked").val();
                var mobile = $("input[name='mobile']").val();
                var wechat = $("input[name='wechat']").val();
                if(identify == undefined){
                    layer.msg('请选择您是健身爱好者吗');
                    return false;
                }
                if(is_know == undefined){
                    layer.msg('您是否希望获得更多健身教练的专业和职业信息');
                    return;
                }
                if(!mobile || !/1[1-9]{1}[0-9]{9}/.test(mobile)){
                    layer.msg('请填写正确的手机号');
                    return;
                }
                if(!wechat){
                     layer.msg('请填写您的姓名');
                     return;
                }
                if(is_know == '是'){
                    var know_way = $("input[name='know_way']:checked").val();
                    var other_way = $("textarea[name='other_way']").val();
                    var join_way = $("input[name='join_way']:checked").val();
                    var destination = $("input[name='destination']:checked").val();
                    var other_dest = $("textarea[name='other_dest']").val();
                    var other_profit = $("textarea[name='other_profit']").val();
                    if(know_way == undefined){
                        layer.msg('请选择了解渠道');
                        return ;
                    }
                    if(join_way == undefined){
                        layer.msg('请选择参与活动身份');
                        return ;
                    }
                    if(destination == undefined){
                        layer.msg('请选择参加活动目的');
                        return false;
                    }
                    if(other_profit == ''){
                        layer.msg('请添加其他想得到福利');
                        return ;
                    }
                }else{
                    var know_way = '';
                    var other_way = '';
                    var join_way = '';
                    var destination = '';
                    var other_dest = '';
                    var other_profit = '';
                }

                var token = '{{csrf_token()}}';
                var cid = $("input[name='cid']").val();
                var data = {identify:identify,is_know:is_know,know_way:know_way,other_way:other_way,join_way:join_way,destination:destination,other_dest:other_dest,other_profit:other_profit,cid:cid,mobile:mobile,wechat:wechat,_token:token};

//                console.log(data);return;
                $.ajax({
                    url:'/active/doit/feedback',
                    data:data,
                    type:'POST',
                    dataType:'json',
                    success:function(res){
                        if(res.code == 0){
                            layer.msg(res.message);
                            window.location.href='/user/studying';

                        }else if(res.code == 2){
                            userlogin();
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
                mobile: {
                    required: '请输入您的手机号码',
                    pattern: '你输入的手机号码不正确'
                },
                wechat: {
                    required: '请输入您的姓名'
                },
                sex: {
                    required: '请选择性别'
                },
                age: {
                    required: '请输入您的年龄',
                    pattern: '你输入的年龄格式不正确'
                },
                education:{
                    required: '请选择您的学历'
                }
            }
        });
        $(".bmSubmit").click(function(){

            $("#form1").submit();
        });




    });

</script>
</body>
</html>