<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-线下课程表单页</title>
    <meta name="author" content="涵涵" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="/lib/jqweui/css/weui.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/jqweui/css/jquery-weui.min.css" rel="stylesheet" type="text/css" />
    <!--mmenu.css start-->
    <link href="/lib/mmenu/css/jquery.mmenu.all.css"  rel="stylesheet" />
    <link href="/lib/mmenu/css/jquery.mhead.css"  rel="stylesheet" />
    <link href="/css/nav-mmenu-public.css" rel="stylesheet" />
    <!--end-->

    <link href="/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="/css/font-num40.css" rel="stylesheet" >
    <link rel="stylesheet" href="/css/zt/zt_payment.css">

    <link rel="stylesheet" href="/css/zt/zt_bigclass.css?t=1.22">
    <style>

    </style>



    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize=hWidth/18.75+'px';
        })()
    </script>
</head>
<body ontouchstart>

<!---导航右侧带导航弹出---->
<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->

    <!--头部导航 start-->
    <div class="mh-head Sticky">

        <div class=" menu-bg-logo">
			<span class="mh-btns-left">
				<a class="icon-menu icon-sousuo" href="javascript:;"></a>
			</span>
			<span class="mh-btns-right">
				<a class="icon-menu" href="#menu"></a>
				<a class="icon-menu" href="#page"></a>
			</span>
        </div>
    </div>

    <!--隐藏导航内容-->
    <nav id="menu">
        <div class="text_center  fz">
            <ul>
                <li><a href="/">首页</a></li>
                <li><a href="/user/studying">正在学习</a></li>
                <li><a href="/user/index">我的</a></li>
            </ul>
        </div>
    </nav>
    <!--头部导航 end-->

    <!--====================================本喵是分割线  喵喵~========================================================-->

    <div>
        <!-- banner start-->
        <div>
            <img src="/images/zt/biglesson/bmbanner1.jpeg" alt="">
        </div>
        <!-- banner end-->

        <!-- 内容 start-->
        <div class="content1">
            <div class="text_center mt32 mb30 fz">
                <h3 class="f30 bgh bold mb30">请填写以下信息，以便于确认您的学籍信息</h3>
                <p class="f25 color_333 "></p>
                {{--<p class="f25 color_333 ">教材、服装制作、班次安排以及证书邮寄。</p>--}}
            </div>

            <!-- 表单 start-->
            <div class="mlr25 bgcolor_fff border-radius-img plr48 ptb40 box-show2">
                <p class="chengnuo f22 fz text-jus">郑重承诺：以下报名信息将仅用于确认您的学籍信息，我们严格抵制任何将个人信息而用作商业用途的行为</p>
                @if($userInfo)
                <ul>
                    <li class="pt40">
                        <div class="BmList clearfix fz">
                            <h3 class="fl fz f30 bold">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</h3>
                            <div class="fr BmD-r">
                                <input type="text" value="{{$userInfo->name}}"  name="name" class="input f26" placeholder="请输入您的姓名">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz">
                            <h3 class="fl fz f30 bold">电&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;话</h3>
                            <div class="fr BmD-r">
                                <input type="text" value="{{$userInfo->mobile}}" name="mobile" class="input f26" placeholder="请输入您的电话">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz">
                            <h3 class="fl fz f30 bold">身份证号</h3>
                            <div class="fr BmD-r">
                                <input type="text" value="{{$userInfo->card}}" class="input f26" name="card" placeholder="请输入您的身份证号">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz">
                            <h3 class="fl fz f30 bold">微&nbsp;&nbsp;信&nbsp;&nbsp;号</h3>
                            <div class="fr BmD-r">
                                <input type="text" value="{{$userInfo->wxNumber}}" name="wxNumber" class="input f26" placeholder="请输入您的微信号">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz weui-cell padding0 mt0">
                            <h3 class="fl fz f30 bold"><label class="weui-label">服装尺码</label></h3>
                            <div class="fr BmD-r">
                                <input type="text" value="{{$userInfo->size}}" class="input f26 weui-input fuzhuang" placeholder="请选择您的服装尺码" name="size">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz weui-cell padding0 mt0">
                            <h3 class="fl fz f30 bold"><label class="weui-label">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别</label></h3>
                            <div class="fr BmD-r">
                                <input type="text" value="{{$userInfo->sex}}" class="input f26 weui-input sex" placeholder="请选择您的性别" name="sex">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz weui-cell padding0 mt0">
                            <h3 class="fl fz f30 bold"><label class="weui-label">年&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;龄</label></h3>
                            <div class="fr BmD-r">
                                <input type="text" value="{{$userInfo->age}}" class="input f26 weui-input age" placeholder="请选择您的年龄" name="age">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz weui-cell padding0 mt0">
                            <h3 class="fl fz f30 bold"><label class="weui-label">学&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;历</label></h3>
                            <div class="fr BmD-r">
                                <input type="text" value="{{$userInfo->education}}" class="input f26 weui-input education" placeholder="请选择您的学历" name="education">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz weui-cell padding0 mt0">
                            <h3 class="fl fz f30 bold"><label class="weui-label">在&nbsp;&nbsp;校&nbsp;&nbsp;生</label></h3>
                            <div class="fr BmD-r">
                                <input type="text" value="{{$userInfo->isStu}}" class="input f26 weui-input inschool" placeholder="请选择您是否为赛普在校生" name="isStu">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz">
                            <h3 class="fl fz f30 bold">学&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号</h3>
                            <div class="fr BmD-r">
                                <input type="text" value="{{$userInfo->stuNo}}" name="stuNo" class="input f26" placeholder="请输入您的学号">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz weui-cell padding0 mt0">
                            <h3 class="fl fz f30 bold"><label class="weui-label">上课地点</label></h3>
                            <div class="fr BmD-r">
                                <input type="text" value="{{$userInfo->place}}" name="place" class="input f26 weui-input place" placeholder="请选择您的上课地点">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz">
                            <h3 class="fl fz f30 bold">地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;址</h3>
                            <div class="fr BmD-r">
                                <input type="text" value="{{$userInfo->address}}" class="input f26" placeholder="请输入您的证书邮寄地址" name="address">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz">
                            <h3 class="fl fz f30 bold">邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱</h3>
                            <div class="fr BmD-r">
                                <input type="text" value="{{$userInfo->email}}" class="input f26" placeholder="请输入您的邮箱" name="email">
                            </div>
                        </div>
                    </li>
                </ul>
                @else
                <ul>
                    <li class="pt40">
                        <div class="BmList clearfix fz">
                            <h3 class="fl fz f30 bold">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</h3>
                            <div class="fr BmD-r">
                                <input type="text"  name="name" class="input f26" placeholder="请输入您的姓名">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz">
                            <h3 class="fl fz f30 bold">电&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;话</h3>
                            <div class="fr BmD-r">
                                <input type="text" name="mobile" class="input f26" placeholder="请输入您的电话">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz">
                            <h3 class="fl fz f30 bold">身份证号</h3>
                            <div class="fr BmD-r">
                                <input type="text" class="input f26" name="card" placeholder="请输入您的身份证号">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz">
                            <h3 class="fl fz f30 bold">微&nbsp;&nbsp;信&nbsp;&nbsp;号</h3>
                            <div class="fr BmD-r">
                                <input type="text" name="wxNumber" class="input f26" placeholder="请输入您的微信号">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz weui-cell padding0 mt0">
                            <h3 class="fl fz f30 bold"><label class="weui-label">服装尺码</label></h3>
                            <div class="fr BmD-r">
                                <input type="text" class="input f26 weui-input fuzhuang" placeholder="请选择您的服装尺码" name="size">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz weui-cell padding0 mt0">
                            <h3 class="fl fz f30 bold"><label class="weui-label">姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别</label></h3>
                            <div class="fr BmD-r">
                                <input type="text" class="input f26 weui-input sex" placeholder="请选择您的性别" name="sex">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz weui-cell padding0 mt0">
                            <h3 class="fl fz f30 bold"><label class="weui-label">年&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;龄</label></h3>
                            <div class="fr BmD-r">
                                <input type="text" class="input f26 weui-input age" placeholder="请选择您的年龄" name="age">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz weui-cell padding0 mt0">
                            <h3 class="fl fz f30 bold"><label class="weui-label">学&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;历</label></h3>
                            <div class="fr BmD-r">
                                <input type="text" class="input f26 weui-input education" placeholder="请选择您的学历" name="education">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz weui-cell padding0 mt0">
                            <h3 class="fl fz f30 bold"><label class="weui-label">在&nbsp;&nbsp;校&nbsp;&nbsp;生</label></h3>
                            <div class="fr BmD-r">
                                <input type="text" class="input f26 weui-input inschool" placeholder="请选择您是否为赛普在校生" name="isStu">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz">
                            <h3 class="fl fz f30 bold">学&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号</h3>
                            <div class="fr BmD-r">
                                <input type="text" name="stuNo" class="input f26" placeholder="请输入您的学号">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz weui-cell padding0 mt0">
                            <h3 class="fl fz f30 bold"><label class="weui-label">上课地点</label></h3>
                            <div class="fr BmD-r">
                                <input type="text" name="place" class="input f26 weui-input place" placeholder="请选择您的上课地点">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz">
                            <h3 class="fl fz f30 bold">地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;址</h3>
                            <div class="fr BmD-r">
                                <input type="text" class="input f26" placeholder="请输入您的证书邮寄地址" name="address">
                            </div>
                        </div>
                    </li>
                    <li class="pt40">
                        <div class="BmList clearfix fz">
                            <h3 class="fl fz f30 bold">邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱</h3>
                            <div class="fr BmD-r">
                                <input type="text" class="input f26" placeholder="请输入您的邮箱" name="email">
                            </div>
                        </div>
                    </li>
                </ul>
                @endif
                <div class="pt40">
                    <button class="BmTj color_333 f36 bgcolor_orange border-radius-img fz bold">提交</button>
                </div>
            </div>
            <!-- 表单 end-->

        </div>
        <!-- 内容 end-->

    </div>


</div><!--导航大盒子id=page 结束-->

<br><br>
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>


<script>
    $("body").addClass("Bm");
    var c_id = '{{$id}}';
    var f_id = '{{$fid}}';
    //服装
    $(".fuzhuang").picker({
        title: "请选择您的服装尺码",
        cols: [{
            textAlign: 'center',
            values: ['S', 'M', 'L', 'XL', 'XXL', 'XXXL']
        }]
    });

    //性别
    $(".sex").picker({
        title: "请选择您的性别",
        cols: [{
            textAlign: 'center',
            values: ['男', '女']
        }]
    });

    //年龄
    $(".age").picker({
        title: "请选择您的年龄",
        cols: [{
            textAlign: 'center',
            values: ['15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50']
        }]
    });

    //学历
    $(".education").picker({
        title: "请选择您的学历",
        cols: [{
            textAlign: 'center',
            values: ['小学', '初中', '高中', '专科', '本科', '本科以上']
        }]
    });

    //是否为在校生
    $(".inschool").picker({
        title: "请选择是否为赛普在校生",
        cols: [{
            textAlign: 'center',
            values: ['是', '否']
        }]
    });

    //上课地点
    $(".place").picker({
        title: "请选择上课地点",
        cols: [{
            textAlign: 'center',
            values: ['北京', '上海','深圳']
        }]
    });

    $('.BmTj').click(function(){
        var name = $("input[name='name']").val();
        var mobile = $("input[name='mobile']").val();
        var card = $("input[name='card']").val();
        var wxNumber = $("input[name='wxNumber']").val();
        var size = $("input[name='size']").val();
        var sex = $("input[name='sex']").val();
        var age = $("input[name='age']").val();
        var education = $("input[name='education']").val();
        var isStu = $("input[name='isStu']").val();
        var stuNo = $("input[name='stuNo']").val();
        var place = $("input[name='place']").val();
        var address = $("input[name='address']").val();
        var email = $("input[name='email']").val();
        var course_class_id = "{{$id}}";
        var _token = '{{csrf_token()}}';
        if(card == ''){
            layer.msg('请填写真实的身份证号');
            return
        }
        var data = {name:name,mobile:mobile,card:card,wxNumber:wxNumber,size:size,sex:sex,age:age,education:education,isStu:isStu,stuNo:stuNo,place:place,address:address,email:email,_token:_token, course_class_id:course_class_id};
        var hrefUrl = "/course/detail/"+c_id+".html?fission_id="+f_id;
        $.ajax({
            url:'/activeCourse/create',
            data:data,
            type:'POST',
            dataType:'json',
            success:function(res){
                if(res.code == 0){
                    layer.msg(res.message);
                    setInterval(function(){
                        window.location.href = hrefUrl;
                    },1500);
                }else{
                    layer.msg(res.message);
                    setInterval(function(){
                        window.location.href = hrefUrl;
                    },1500);
                }
            }
        })
    });

</script>


