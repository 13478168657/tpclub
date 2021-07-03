@extends('layouts.header')
@section('title')
    <title>意见反馈{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/xueyuan.css">
    <style type="text/css">
            label.error{color:red;font-size:10px;}
    </style>
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth/18.75 + "px";
        })()
    </script>
@endsection
@section('content')    
<form  id="signupForm"  method="post" action="/feedback/feedback_save">
 {{csrf_field()}}
<div  class="yijianfankui mlr30">
    <div class="yjfk">
        <div class="weui-cell__bd">
            <div class="tit pt30 pb20 color_333">内容主题</div>
        </div>
       <div class="theme">
            <input type="text" name="title" placeholder="内容" class="input" />
       </div>
    </div>

    <div class="yjfk">
        <div class="weui-cell__bd">
            <div class="tit pt30 pb20 color_333">反馈内容</div>
        </div>
        <div class="weui-cell yijian nobefore">
            <div class="weui-cell__bd">
                <textarea class="weui-textarea" maxlength="150"  name="content" placeholder="请详细描述您的问题或建议（建议150字以内）" rows="8" id="yijian"></textarea>
            </div>
        </div>
    </div>

    <div class="yjfk">
        <div class="weui-cell__bd">
            <div class="tit pt30 pb20 color_333">联系方式</div>
        </div>
       <div class="theme">
            <input type="text" placeholder="手机号" name="phone" class="input" />
       </div>
    </div>
<input type="hidden" name="user_id" value="{{$userid}}"/>
    <!--大按钮-->
    <div class="mlr25 Btn pb30 nobefore noafter big_Btn1">
        <button href="javascript:;" type="submit" class="weui-btn nobefore noafter bgcolor_orange color_333">提交</button>
    </div>
</div>
</form>
<script src="../lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="../lib/jqweui/js/fastclick.js"></script>
<script>
    $(function() {
        FastClick.attach(document.body);
    });
</script>
 <script src="/lib/jquery.validate.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/jquery-weui.js"></script>
<script>

 $("#signupForm").validate({
				rules:{
						title:{
								required:true,
						},
						content:{
								required:true,
						},
						phone:{
								required:true,		
								tel:true,
						}
				},
				messages:{
						title:{
								required:"请输入标题！",
						},
						content:{
								required:"请填写内容！",
						},
						phone:{
								required:"请填写手机号！",
								tel:"手机号格式错误",
						}
				},
                submitHandler:function(form){
						//swal("反馈提交成功!");
						form.submit();
					}  
            
        });

</script>
<script>
// $(function (){
//     var jianjie=$("#yijian");
//     wordLimit1(jianjie,$("#yijian_words"),150); 
// })
</script>
@endsection
