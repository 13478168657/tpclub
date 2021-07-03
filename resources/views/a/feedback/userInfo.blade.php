<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>赛普社区-就业反馈</title>
    <meta name="author" content="啾啾" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" type="text/css" href="/lib/jqweui/css/weui.min.css" />
    <link rel="stylesheet" type="text/css" href="/lib/jqweui/css/jquery-weui.min.css"/>
    <link rel="stylesheet" type="text/css" href="/css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="/css/font-num40.css" >
    <!--本css-->

    <script src="/js/jquery-1.11.2.min.js"></script>
    <script src="/lib/layer/layer.js"></script>
    <script src="/lib/jqweui/js/jquery-weui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/zt/zt_JobFeedback2.css?t=1">
    <script src="/lib/mobileValidate/js/jquery-mvalidate.js"></script>
    <script type='text/javascript' src='https://www.17sucai.com/preview/227408/2019-05-22/1/js/jquery.form.js'></script>

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
                <h3 class="f30 bold ptb30 text_center">赛普学员就业需求收集：</h3>
                <p class="text-jus f26">紧张的学习生活匆匆而过，转眼即将面临就业选择，在接下来的一段时间班主任将开始为各位学员进行工作推荐和匹配，赶快说出你的就业需求吧！</p>
            </div>
            <div>
                <form  method="post" action="" id="form1">
                    <div class="JobAsk">
                    <ul>
                        <li>
                            <div class="checkboxWrap mt32 mb50 pt20 fz">
                                <h3 class="fz f30 mb30 text-jus">1、身份证号<span>*</span></h3>
                                <div class="plr45">
                                    <input type="text" id="idcard" name="idcard" value="{{$userInfo?$userInfo->idcard:''}}" autocomplete="off" class="input f26" placeholder="请添写身份证号">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="checkboxWrap mt32 mb50 pt20 fz">
                                <h3 class="fz f30 mb30 text-jus">2、毕业后是否找工作<span>*</span></h3>
                                <div class="plr45">
                                    <ul>
                                        <?php
                                            $is_biye = '';
                                            if($userInfo){
                                                $is_biye = $userInfo->is_biye;
                                            }
                                        ?>
                                        <li><label onclick="block_box2_yes()" class="fz f28 mb10"><input type="radio" name="is_biye" autocomplete="off" value="是" {{$is_biye==='是'?'checked':''}} class="radiobox" />是</label></li>
                                        <li><label onclick="block_box2_no()" class="fz f28 mb10"><input type="radio"  name="is_biye" autocomplete="off" {{$is_biye==='否'?'checked':''}} value="否" class="radiobox" />否</label></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <?php
                            $is_recom = '';
                            if($userInfo){
                                $is_recom = $userInfo->is_recommend;
                            }
                        ?>
                        @if($is_recom)
                            <li class="" id="d3">
                        @else
                            <li class="none" id="d3">
                        @endif
                            <div class="checkboxWrap mt32 mb50 pt20 fz">
                                <h3 class="fz f30 mb30 text-jus">3、是否需要职业规划班主任推荐工作<span>*</span></h3>
                                <div class="plr45">
                                    <ul>
                                        <li><label onclick="block_box3_xuyao()" class="fz f28 mb10"><input type="radio" name="is_recommend"  autocomplete="off" {{$is_recom=="需要"?"checked":""}} value="需要" class="radiobox" />需要</label></li>
                                        <li><label onclick="block_box3_buxuyao()" class="fz f28 mb10"><input type="radio" name="is_recommend"  autocomplete="off" {{$is_recom=="不需要"?"checked":""}}  value="不需要" class="radiobox" />不需要</label></li>
                                        <li><label onclick="block_box3_zanshibuxuyao()" class="fz f28 mb10"><input type="radio" name="is_recommend"  autocomplete="off" {{$is_recom=="暂时不需要"?"checked":""}}  value="暂时不需要" class="radiobox" />暂时不需要</label></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <?php
                            if($userInfo){
                                $city = $userInfo->city;
                                $position1 = $userInfo->position1;
                                $position2 = $userInfo->position2;
                                $position3 = $userInfo->position3;
                                $position4 = $userInfo->position4;
                                $position5 = $userInfo->position5;
                                $good_at1 = $userInfo->good_at1;
                                $good_at2 = $userInfo->good_at2;
                                $good_at3 = $userInfo->good_at3;
                                $good_at4 = $userInfo->good_at4;
                                $good_at5 = $userInfo->good_at5;
                                $care1 = $userInfo->care1;
                                $care2 = $userInfo->care2;
                                $care3 = $userInfo->care3;
                                $care4 = $userInfo->care4;
                                $work_time = $userInfo->work_time;
                                $prepare = $userInfo->prepare;
                                $company = $userInfo->company;
                            }else{
                                $city = '';
                                $position1 = '';
                                $position2 = '';
                                $position3 = '';
                                $position4 = '';
                                $position5 = '';
                                $good_at1 = '';
                                $good_at2 = '';
                                $good_at3 = '';
                                $good_at4 = '';
                                $good_at5 = '';
                                $care1 = '';
                                $care2 = '';
                                $care3 = '';
                                $care4 = '';
                                $work_time = '';
                                $prepare = '';
                                $company = '';
                            }
                        ?>
                        @if($city)
                        <li class="" id="d4">
                        @else
                        <li class="none" id="d4">
                        @endif
                            <div class="JobDay mt32 mb50 pt20 fz">
                                <h3 class="fz f30 mb30 text-jus">4、意向城市<span>*</span></h3>
                                <p class="txk mb10 color_gray999 f26">CN 中国</p>
                                <div class="JobDayIn fz">
                                    <div class="weui-cells_form padding0 mt0 noafter nobefore">
                                        <div class="weui-cell padding0 mt0">
                                            <div class="weui-cell__hd"><label for="home-city" class="weui-label"><img src="/images/db2.png" alt=""></label></div>
                                            <div class="weui-cell__bd plr30">
                                                <input class="weui-input f26" id="home-city" type="text" value="{{$userInfo?$userInfo->city:''}}" name="city" placeholder="点击添加城市">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @if($position1 || $position2 || $position3 || $position4 || $position5)
                        <li class="" id="d5">
                        @else
                        <li class="none" id="d5">
                        @endif
                            <div class="checkboxWrap mt32 mb50 pt20 fz">
                                <h3 class="fz f30 mb30 text-jus">5、就业意向方向（多选）<span>*</span></h3>
                                <div class="plr45">
                                    <ul>
                                        <li><label class="fz f28 mb10"><input type="checkbox" name="position1" class="checkbox" autocomplete="off" {{(isset($userInfo->position1) && !empty($userInfo->position1))?'checked':''}} value="连锁俱乐部" />连锁俱乐部</label></li>
                                        <li><label class="fz f28 mb10"><input type="checkbox" name="position2" class="checkbox" autocomplete="off" {{(isset($userInfo->position2) && !empty($userInfo->position2))?'checked':''}} value="综合训练馆" />综合训练馆</label></li>
                                        <li><label class="fz f28 mb10"><input type="checkbox" name="position3" class="checkbox" autocomplete="off" {{(isset($userInfo->position3) && !empty($userInfo->position3))?'checked':''}} value="单店" />单店</label></li>
                                        <li><label class="fz f28 mb10"><input type="checkbox" name="position4" class="checkbox" autocomplete="off" {{(isset($userInfo->position4) && !empty($userInfo->position4))?'checked':''}} value="工作室" />工作室</label></li>
                                        <li><label class="fz f28 mb10"><input type="checkbox" name="position5" class="checkbox" autocomplete="off" {{(isset($userInfo->position5) && !empty($userInfo->position5))?'checked':''}} value="其他" />其他</label></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        @if($good_at1 || $good_at2 || $good_at3 || $good_at3 || $good_at4)
                        <li class="" id="d6">
                        @else
                        <li class="none" id="d6">
                        @endif
                            <div class="checkboxWrap mt32 mb50 pt20 fz">
                                <h3 class="fz f30 mb30 text-jus">6、自身擅长方向（多选）<span>*</span></h3>
                                <div class="plr45">
                                    <ul>
                                        <li><label class="fz f28 mb10"><input type="checkbox" name="good_at1" class="checkbox" autocomplete="off" value="增肌减脂" {{(isset($userInfo->good_at1) && !empty($userInfo->good_at1))?'checked':''}} />增肌减脂</label></li>
                                        <li><label class="fz f28 mb10"><input type="checkbox" name="good_at2" class="checkbox" autocomplete="off" value="运动康复" {{(isset($userInfo->good_at2) && !empty($userInfo->good_at2))?'checked':''}}/>运动康复</label></li>
                                        <li><label class="fz f28 mb10"><input type="checkbox" name="good_at3" class="checkbox" autocomplete="off" value="功能性" {{(isset($userInfo->good_at3) && !empty($userInfo->good_at3))?'checked':''}}/>功能性</label></li>
                                        <li><label class="fz f28 mb10"><input type="checkbox" name="good_at4" class="checkbox" autocomplete="off" value="普拉提" {{(isset($userInfo->good_at4) && !empty($userInfo->good_at4))?'checked':''}}/>普拉提</label></li>
                                        <li><label class="fz f28 mb10"><input type="checkbox" name="good_at5" class="checkbox" autocomplete="off" value="销售" {{(isset($userInfo->good_at5) && !empty($userInfo->good_at5))?'checked':''}}/>销售</label></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        @if($care1 || $care2 || $care3 || $care4)
                        <li class="" id="d7">
                        @else
                        <li class="none" id="d7">
                        @endif
                            <div class="checkboxWrap mt32 mb50 pt20 fz">
                                <h3 class="fz f30 mb30 text-jus">7、求职过程你最关心哪些（多选）<span>*</span></h3>
                                <div class="plr45">
                                    <ul>
                                        <li><label class="fz f28 mb10"><input type="checkbox" name="care1" class="checkbox" autocomplete="off" value="经营项目是否与自身擅长内容一致" {{(isset($userInfo->care1) && !empty($userInfo->care1))?'checked':''}}/>经营项目是否与自身擅长内容一致</label></li>
                                        <li><label class="fz f28 mb10"><input type="checkbox" name="care2" class="checkbox" autocomplete="off" value="薪资福利" {{(isset($userInfo->care2) && !empty($userInfo->care2))?'checked':''}}/>薪资福利</label></li>
                                        <li><label class="fz f28 mb10"><input type="checkbox" name="care3" class="checkbox" autocomplete="off" value="工作地点" {{(isset($userInfo->care3) && !empty($userInfo->care3))?'checked':''}}/>工作地点</label></li>
                                        <li><label class="fz f28 mb10"><input type="checkbox" name="care4" class="checkbox" autocomplete="off" value="是否提供培训" {{(isset($userInfo->care4) && !empty($userInfo->care4))?'checked':''}}/>是否提供培训</label></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <?php
                            $join = '';
                            if($userInfo){
                                $join = $userInfo->join;
                            }
                        ?>
                        @if($join)
                        <li class="" id="d8">
                        @else
                        <li class="none" id="d8">
                        @endif
                            <div class="checkboxWrap mt32 mb50 pt20 fz">
                                <h3 class="fz f30 mb30 text-jus">8、是否参加9月18日的招聘会<span>*</span></h3>
                                <div class="plr45">
                                    <ul>
                                        <li><label class="fz f28 mb10"><input type="radio" name="join" class="radiobox" autocomplete="off" value="参加"  {{$join=='参加'?'checked':''}}/>参加</label></li>
                                        <li><label class="fz f28 mb10"><input type="radio" name="join" class="radiobox" autocomplete="off" value="不确定" {{$join=='不确定'?'checked':''}}/>不确定</label></li>
                                        <li><label class="fz f28 mb10"><input type="radio" name="join" class="radiobox" autocomplete="off" value="不参加" {{$join=='不参加'?'checked':''}}/>不参加</label></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        @if($work_time)
                        <li class="" id="d9">
                        @else
                        <li class="none" id="d9">
                        @endif
                            <div class="checkboxWrap mt32 mb50 pt20 fz">
                                <h3 class="fz f30 mb30 text-jus">9、计划工作的时间<span>*</span></h3>
                                <div class="plr45">
                                    <input type="text" class="input f26" id="job-day" placeholder="请选择计划工作的时间" name="work_time" autocomplete="off" value="{{$work_time}}">
                                </div>
                            </div>
                        </li>
                        @if($prepare)
                        <li class="" id="d10">
                        @else
                        <li class="none" id="d10">
                        @endif
                            <div class="checkboxWrap mt32 mb50 pt20 fz">
                                <h3 class="fz f30 mb30 text-jus">10、 找工作前的这段时间准备做什么？<span>*</span></h3>
                                <div class="plr45">
                                    <input type="text" class="input f26" value="{{$prepare}}" autocomplete="off" name="prepare" placeholder="工作准备">
                                </div>
                            </div>
                        </li>
                        <?php
                            $reason = '';
                            if($userInfo){
                                $reason = $userInfo->reason;
                            }
                        ?>
                        @if($reason)
                        <li class="" id="d11">
                        @else
                        <li class="none" id="d11">
                        @endif
                            <div class="checkboxWrap mt32 mb50 pt20 fz">
                                <h3 class="fz f30 mb30 text-jus">11、不需要推荐工作的原因<span>*</span></h3>
                                <div class="plr45">
                                    <ul>
                                        <li><label onclick="block_box11_yizhaodaogongzuo_no()" class="fz f28 mb10"><input type="radio" autocomplete="off" value="自主创业" {{$reason=='自主创业'?'checked':''}} name="reason" class="radiobox" />自主创业</label></li>
                                        <li><label onclick="block_box11_yizhaodaogongzuo()" class="fz f28 mb10"><input type="radio" autocomplete="off" value="已找到工作" {{$reason=='已找到工作'?'checked':''}}  name="reason" class="radiobox" />已找到工作</label></li>
                                        <li><label  onclick="block_box11_yizhaodaogongzuo_no()" class="fz f28 mb10"><input type="radio" autocomplete="off" value="从事其他行业"  {{$reason=='从事其他行业'?'checked':''}} name="reason" class="radiobox" />从事其他行业</label></li>
                                        <li><label  onclick="block_box11_yizhaodaogongzuo_no()" class="fz f28 mb10"><input type="radio" value="其他" name="reason" {{$reason=='其他'?'checked':''}} class="radiobox" />其他</label></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        @if($company)
                            <li class="" id="d12">
                        @else
                            <li class="none" id="d12">
                        @endif
                            <div class="checkboxWrap mt32 mb50 pt20 fz">
                                <h3 class="fz f30 mb30 text-jus">12、 工作单位<span>*</span></h3>
                                <div class="plr45">
                                    <input type="text" class="input f26" value="{{$company}}" name="company" placeholder="请添写工作单位">
                                </div>
                            </div>
                        </li>
                    </ul>
                    <a href="javascript:void(0)" class="JobBtn text_center f30 bgcolor_orange mt100 fz">提交</a>
                </div>
                </form>
            </div>
        </div>

        <!--====================================本喵是分割线 喵喵！==================================================-->

    </div>





    <!--====================================本喵是有底线哒 喵喵！==================================================-->
</div>


<br><br><br>
<script src="/lib/city-picker.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/icheck/js/icheck.min.js"></script>
<script>
    $('body').addClass('bb');

    /*第2个问题*/
    function block_box2_yes(){
        $("#d3").slideDown().removeClass("none");
        $("#d4").slideUp().addClass("none");
        $("#d5").slideUp().addClass("none");
        $("#d6").slideUp().addClass("none");
        $("#d7").slideUp().addClass("none");
        $("#d8").slideUp().addClass("none");
        $("#d9").slideUp().addClass("none");
        $("#d10").slideUp().addClass("none");
        $("#d11").slideUp().addClass("none");
        $("#d12").slideUp().addClass("none");
    }
    function block_box2_no(){
        $("#d3").slideUp().addClass("none");
        $("#d4").slideUp().addClass("none");
        $("#d5").slideUp().addClass("none");
        $("#d6").slideUp().addClass("none");
        $("#d7").slideUp().addClass("none");
        $("#d8").slideUp().addClass("none");
        $("#d9").slideUp().addClass("none");
        $("#d10").slideUp().addClass("none");
        $("#d11").slideDown().removeClass("none");
        $("#d12").slideUp().addClass("none");
    }

    /*第3个问题*/
    /*需要*/
    function block_box3_xuyao(){
        $("#d4").slideDown().removeClass("none");
        $("#d5").slideDown().removeClass("none");
        $("#d6").slideDown().removeClass("none");
        $("#d7").slideDown().removeClass("none");
        $("#d8").slideDown().removeClass("none");
        $("#d9").slideDown().removeClass("none");
        $("#d10").slideDown().removeClass("none");

        $("#d11").slideUp().addClass("none");
        $("#d12").slideUp().addClass("none");
    }
    /*不需要*/
    function block_box3_buxuyao(){
        $("#d4").slideUp().addClass("none");
        $("#d5").slideUp().addClass("none");
        $("#d6").slideUp().addClass("none");
        $("#d7").slideUp().addClass("none");
        $("#d8").slideUp().addClass("none");
        $("#d9").slideUp().addClass("none");
        $("#d10").slideUp().addClass("none");
        $("#d11").slideDown().removeClass("none");
        $("#d12").slideUp().addClass("none");
    }
    /*暂时不需要*/
    function block_box3_zanshibuxuyao(){
        $("#d4").slideUp().addClass("none");
        $("#d5").slideUp().addClass("none");
        $("#d6").slideUp().addClass("none");
        $("#d7").slideUp().addClass("none");
        $("#d8").slideUp().addClass("none");
        $("#d9").slideDown().removeClass("none");
        $("#d10").slideDown().removeClass("none");
        $("#d11").slideUp().addClass("none");
        $("#d12").slideUp().addClass("none");
    }

    /*第11个问题*/
    /*已找到工作*/
    function block_box11_yizhaodaogongzuo(){
        $("#d12").slideDown().removeClass("none");
    }
    /*自主创业，从事其他行业，其他*/
    function block_box11_yizhaodaogongzuo_no(){
        $("#d12").slideUp().addClass("none");
    }




    $(function(){

        //单选按钮
        $('.radiobox').iCheck({
            //checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio',
            increaseArea: '20%'
        });
        $('.checkbox').iCheck({
            //checkboxClass: 'icheckbox_square-green',
            radioClass: 'icheckbox',
            increaseArea: '20%'
        });

        //地址
        $("#home-city").cityPicker({
            title: "选择地址",
            shade:true,
            showDistrict: true,//如果到区请写true
            onChange: function (picker, values, displayValues) {
                console.log(values, displayValues);
            }
        });

        $("#job-day").picker({
            title: "请选择计划工作时间",
            cols: [
                {
                    textAlign: 'center',
                    values: ['1个月内', '1个月-3个月', '3个月以上', '不确定']
                }
            ]
        });

        /*$("#job-day").change(function(){
         if($(this).val() == '1个月内'){
         alert(3);
         }
         })*/

    })
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
//                alert(3222);
                var idcard = $("input[name='idcard']").val();
                var is_biye = $("input[name='is_biye']:checked").val();

                var data = {
                    idcard:idcard,
                    is_biye:is_biye
                };
                data = getDataInfo(is_biye, data);
                console.log(data);
                if(data['code'] != 0){

                    return ;
                }
                var info = data.info;
                info._token = '{{csrf_token()}}';
//                console.log(data);return;
                $.ajax({
                    url: '/stu/info/create',
                    data: info,
                    type: 'POST',
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 0) {
                            layer.msg(res.message);
                        } else {
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
            eachValidField: function (val) {
            },
            eachInvalidField: function (event, status, options) {
            },
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
                    required: '请输入您的微信号码'
                },
                sex: {
                    required: '请选择性别'
                },
                age: {
                    required: '请输入您的年龄',
                    pattern: '你输入的年龄格式不正确'
                }

            }
        });
    });
    $(".JobBtn").click(function(){
//        alert(3);
        $("#form1").submit();
    });

    function getDataInfo(biye,data){
        data.city = '';
        data.is_recommend = '';
        data.position1 = '';
        data.position2 = '';
        data.position3 = '';
        data.position4 = '';
        data.position5 = '';
        data.good_at1 = '';
        data.good_at2 = '';
        data.good_at3 = '';
        data.good_at4 = '';
        data.good_at5 = '';
        data.care1 = '';
        data.care2 = '';
        data.care3 = '';
        data.care4 = '';
        data.join = '';
        data.work_time = '';
        data.prepare = '';
        data.reason = '';
        data.company = '';
        var info = [];
        info['code'] = 0;
        var msg = '';
        if(data.idcard == ''){
            msg = '请输入身份证号';
            info['code'] = 1;
            layer.msg(msg);
            return info;
        }
        if(data.idcard == ''){
            msg = '请选择毕业是否找工作';
            info['code'] = 1;
            layer.msg(msg);
            return info;
        }
        if(biye == '' || biye == undefined){
            msg = '请选择毕业是否找工作';
            info['code'] = 1;
            layer.msg(msg);
            return info;
        }
        if(biye == '是'){
            var is_recommend = $("input[name='is_recommend']:checked").val();
            data.is_recommend = is_recommend;
            if(is_recommend == '需要'){
                data.city = $("input[name='city']").val();
                if(data.city == ''){
                    msg = '请选择意向城市';
                    layer.msg(msg);
                    info['code'] = 1;
                    return info;
                }
                if ($("input[name='position1']:checked").val() != undefined) {
                    data.position1 = $("input[name='position1']:checked").val();
                }
                if ($("input[name='position2']:checked").val() != undefined) {
                    data.position2 = $("input[name='position2']:checked").val();
                }
//                alert(data.position1);
                if ($("input[name='position3']:checked").val() != undefined) {
                    data.position3 = $("input[name='position3']:checked").val();
                }
                if ($("input[name='position4']:checked").val() != undefined) {
                    data.position4 = $("input[name='position4']:checked").val();
                }
                if ($("input[name='position5']:checked").val() != undefined) {
                    data.position5 = $("input[name='position5']:checked").val();
                }

                if(data.position1 == '' && data.position2== '' && data.position3 == '' && data.position4 == '' && data.position5 == ''){
                    msg = '请选择就业意向方向';
                    layer.msg(msg);
                    info['code'] = 1;
                    return info;
                }
                if ($("input[name='good_at1']:checked").val() != undefined) {
                    data.good_at1 = $("input[name='good_at1']:checked").val();
                }
                if ($("input[name='good_at2']:checked").val() != undefined) {
                    data.good_at2 = $("input[name='good_at2']:checked").val();
                }
                if ($("input[name='good_at3']:checked").val() != undefined) {
                    data.good_at3 = $("input[name='good_at3']:checked").val();
                }
                if ($("input[name='good_at4']:checked").val() != undefined) {
                    data.good_at4 = $("input[name='good_at4']:checked").val();
                }
                if ($("input[name='good_at5']:checked").val() != undefined) {
                    data.good_at5 = $("input[name='good_at5']:checked").val();
                }
                if(data.good_at1 == '' && data.good_at2 == '' && data.good_at3 == '' && data.good_at4 == '' && data.good_at5 == ''){
                    msg = '请选择自身擅长方向';
                    layer.msg(msg);
                    info['code'] = 1;
                    return info;
                }
                if ($("input[name='care1']:checked").val() != undefined) {
                    data.care1 = $("input[name='care1']").val();
                }
                if ($("input[name='care2']:checked").val() != undefined) {
                    data.care2 = $("input[name='care2']").val();
                }
                if ($("input[name='care3']:checked").val() != undefined) {
                    data.care3 = $("input[name='care3']").val();
                }
                if ($("input[name='care4']:checked").val() != undefined) {
                    data.care4 = $("input[name='care4']").val();
                }
                if(data.care1 == '' && data.care2 == '' && data.care3 == '' && data.care4 == ''){
                    msg = '请选择求职过程你最关心哪些';
                    layer.msg(msg);
                    info['code'] = 1;
                    return info;
                }
                if($("input[name='join']:checked").val() != undefined){
                    data.join = $("input[name='join']:checked").val();
                }
                if(data.join == ''){
                    msg = '请选择是否参加9月18日的招聘会';
                    layer.msg(msg);
                    info['code'] = 1;
                    return info;
                }
                data.work_time = $("input[name='work_time']").val();

                if(data.work_time == ''){
                    msg = '请选择计划工作的时间';
                    layer.msg(msg);
                    info['code'] = 1;
                    return info;
                }

                data.prepare = $("input[name='prepare']").val();
                if(data.prepare == ''){
                    msg = '请输入找工作前的这段时间准备做什么';
                    layer.msg(msg);
                    info['code'] = 1;
                    return info;
                }
            }else if(is_recommend == '不需要'){
                if($("input[name='reason']:checked").val() != undefined){
                    data.reason = $("input[name='reason']:checked").val();
                }
                if(data.reason == ''){
                    msg = '请选择不需要推荐工作的原因';
                    layer.msg(msg);
                    info['code'] = 1;
                    return info;
                }
                if(data.reason == '已找到工作'){
                    data.company = $("input[name='company']").val();
                    if(data.company == ''){
                        msg = '请选择工作单位';
                        layer.msg(msg);
                        info['code'] = 1;
                        return info;
                    }
                }
            }else if(is_recommend == '暂时不需要'){

                data.work_time = $("input[name='work_time']").val();

                data.prepare = $("input[name='prepare']").val();
                if(data.work_time == ''){
                    msg = '请选择计划工作的时间';
                    layer.msg(msg);
                    info['code'] = 1;
                    return info;
                }
                if(data.prepare == ''){
                    msg = '请输入找工作前的这段时间准备做什么';
                    layer.msg(msg);
                    info['code'] = 1;
                    return info;
                }
            }else{
                msg = '请选择是否需要职业规划班主任推荐工作';
                layer.msg(msg);
                info['code'] = 1;
                return info;
            }
        }else{
            data.reason = $("input[name='reason']:checked").val();

            if(data.reason == '' || data.reason == undefined){
                msg = '请选择不需要推荐工作的原因';
                layer.msg(msg);
                info['code'] = 1;
                return info;
            }
            if(data.reason == '已找到工作'){
                data.company = $("input[name='company']").val();
                if(data.company == ''){
                    msg = '请选择工作单位';
                    layer.msg(msg);
                    info['code'] = 1;
                    return info;
                }
            }
        }
        info['info'] = data;
        return info;
    }
</script>
</body>
</html>