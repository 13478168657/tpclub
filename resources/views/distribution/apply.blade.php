@extends('layouts.header')
@section('title')
<title>赛普社区-分销申请流程</title>
<meta name="author" content="啾啾" />
<meta name="keywords" content="" />
<meta name="description" content="" />
@endsection

@section('cssjs')
	<!--本css-->
	<link rel="stylesheet" href="/css/fenxiaoliucheng.css" >

<script>
(function(){
	var html = document.documentElement;
	var hWidth = html.getBoundingClientRect().width;
	html.style.fontSize=hWidth/18.75+'px';
})()
</script>
@endsection

@section('content')

<!---导航右侧带导航弹出---->

<div id="page"><!--导航大盒子id=page 开始  【结束在最底部】-->



	<!--====================================本喵是分割线  喵喵~========================================================-->
	<div class="mlr30">

		<p class="box1 text_center fz f42 bold color_F59023 bor-rad100 mtb45">成为课程顾问 &nbsp;&nbsp;一键分享赚佣金</p>


		<div class="fz color_333 mt70 mb30">
			<p class="f32 mb20 bold">什么是课程顾问？</p>
			<span class="f26 text-jus">课程顾问是赛普课程的推广大使，所有的课程顾问都有一个共同的使命：将赛普课程推广给所有需要它的人。</span>

			<p class="f32 bold mb30 mt70">课程顾问的“钱”途</p>
			<img src="/images/fenxiaoliucheng/img1.png" alt="">

			<p class="f26 text-jus color_333 pt20 mb30">课程顾问通过分享分销中心的课程海报或链接带来新用户形成注册都会被记录在邀请列表中，用户成功入校，课程顾问就能获得600-1500元的佣金返现。  </p>
			<div class="txt-s fz f28 color_333 bold pl20 ptb40 mb40">
				<p>初级私教课程：介绍学员成功入校返现600元</p>
				<p>中级私教课程：介绍学员成功入校返现1000元</p>
				<p>高级私教课程：介绍学员成功入校返现1500元</p>
			</div>
		</div>

		<!--招生老师助你征服朋友圈 start-->
		<div class="pb92">
			<p class="fz f32 color_333 bold pb30">招生老师助你征服朋友圈</p>
			<img src="/images/fenxiaoliucheng/zhuanzhang.png" alt="">

			<p class="fz f26 color_333">你只需要分享分销中心的课程，跟单全部由招生老师替你完成，你带来的学员成功入校，招生老师将直接为你返现。</p>
		</div>
		<!--招生老师助你征服朋友圈 end-->

	</div>

	<!--====================================本喵是分割线  喵喵~========================================================-->


<form method="post"   id="submitFrame">
	<!--表单 start-->
	<div class="bgcolor_f9f9f9 mt30 border-radius-img mlr30 mb40">

		<div class="plr45 pb136">
			<h2 class="lt f40 color_333 text_center pt70">—填写申请信息—</h2>

			<div class="form fz f24 clearfix mb30 pt40">
				<ul>
					<li>
						<div class="input clearfix fz">
							<p class="fl bgcolor_fff f28 color_gray666">姓名</p>
							<input type="text" id="name" name="name" placeholder="请输入您的姓名" class="fr input f28  fz bgcolor_fff mb30" value="{{$data?$data->name:''}}">
							{{--<strong class="tip">哼！重输</strong>--}}
						</div>
					</li>
					<!-- <li>
						<div class="input clearfix fz">
							<p class="fl bgcolor_fff f28 color_gray666">手机号码</p>
							<input type="text" id="tel" name="tel" placeholder="请输入您的手机号码" class="fr input f28  fz bgcolor_fff mb30" value="{{$data?$data->mobile:''}}"> -->
							{{--<strong class="tip">哼！重输</strong>--}}
						<!-- </div>
					</li> -->
					<li>
						<div class="input clearfix fz">
							<p class="fl bgcolor_fff f28 color_gray666">微信号码</p>
							<input type="text" id="wechat" name="wechat" placeholder="请输入您的微信号码" class="fr input f28  fz bgcolor_fff mb30" value="{{$data?$data->wx_code:''}}">
							{{--<strong class="tip">哼！重输</strong>--}}
						</div>
					</li>
					<li>
						<div class="input clearfix fz">
							<p class="fl bgcolor_fff f28 color_gray666">身份证号码</p>
							<input type="text" id="idcard" name="idcard" placeholder="请输入您的身份证号码" class="fr input f28  fz bgcolor_fff mb30" value="{{$data?$data->id_card:''}}">
							{{--<strong class="tip">哼！重输</strong>--}}
						</div>
					</li>
				</ul>


			</div>

		</div>


	</div>
	<!--表单 end-->

	<!--====================================本喵是分割线  喵喵~========================================================-->
	<!-- start-->
	{{--<div class="bgcolor_f9f9f9 mt30 border-radius-img mlr30 text_center fz pb92">--}}
		{{--<h3 class="f40 mt70 pt40 bold mb50 pb30">上传您的微信二维码图片<br>（完善微信认证）</h3>--}}

		{{--<div class="jia_img mb30">--}}
			{{--<img id="img_input" img-attr="{{$data?$data->wx_img:''}}" class="img_input" src="{{$data?env('IMG_URL').$data->wx_img:'/images/fenxiaoliucheng/jia.png'}}" alt="" onclick="inputfile();">--}}

		{{--</div>--}}
		{{--<input type="file" id="wx_img" name="wx_img" multiple=""  style="display: none;"/>--}}
		{{--<p class="f28 color_333 mb10">点击上传您的个人微信二维码</p>--}}
		{{----}}
		{{--<div class="bg_kuang mt70 mb30">--}}
			{{--<img src="/images/zt/qr-yanjun.png" alt="">--}}
		{{--</div>--}}
		{{--<p class="f28 color_333 mb10 gou">四角完成  边框均匀 <img src="/images/fenxiaoliucheng/gou.png" alt=""></p>--}}

	{{--</div>--}}
	<!--end-->

	<!--====================================本喵是分割线  喵喵~========================================================-->
	<div class="bgcolor_f9f9f9 mt30 border-radius-img mlr30 fz">
		<p class="text_center f40 color_333 pt105 mb26 bold">—选择为您服务的招生老师—</p>


		<div class="plr45">
			<p class="xing text_left border-radius50 bgcolor_fff mb50 f26 color_FA6C11"><img src="/images/fenxiaoliucheng/xing.png" alt=""> 注意：请与招生老师确认后再填写</p>

			<p class="mt10 f32 color_gray666 text_left mb30">填写招生老师电话（选填）</p>
			<div class="input input1 pb30">
				<input type="text" id="teacher_tel" placeholder="手动添加招生老师" class="f28 fz bgcolor_fff text_center border-radius-img" value="{{$data?$data->teacher_mobile:''}}">
				{{--<p class="tip">哼!重输</p>--}}
			</div>

		</div>
		<p class="plr35 text_left text-jus f28 color_333 mb20">可选填你希望为你服务的招生老师的联系方式，然后点击【确认提交】即可。</p>
		<p class="plr35 text_left text-jus f28 color_333 mb20">如果没有填写视为接受随机分配招生老师，直接点击【确认提交】即可。
			注意：请与招生老师确认后再填写。</p>
		<input type="hidden" name="id" id="form_id" value="{{$data?$data->id:0}}"/>
	</div>
	<!--====================================本喵是分割线  喵喵~========================================================-->
	<div class="relative">
		@if(count($data) > 0)
			@if($data->code == 0)
				<a href="javascript:;" class="btn-f text_center bgcolor_orange fz f34 color_333 submit_btn" data-attr="1">审核中...</a>
			@elseif($data->code == 1)
				<a href="javascript:;" class="btn-f text_center bgcolor_orange fz f34 color_333 submit_btn">审核通过</a>
				<script>
					layer.msg("审核已通过");
					function jumpurl(){
						location='/distribution/home.html';
					}
					setTimeout('jumpurl()',1000);
				</script>
			@else
				{{--<a href="javascript:;" class="btn-f text_center bgcolor_orange fz f34 color_333" onclick="layer.msg('审核未通过');">审核未通过</a>--}}
				<a href="javascript:;" class="btn-f text_center bgcolor_orange fz f34 color_333 submit_btn" data-attr="0">再次提交</a>
			@endif
		@else
			<a href="javascript:;" class="btn-f text_center bgcolor_orange fz f34 color_333 submit_btn" data-attr="0">确认提交</a>
		@endif
	</div>
	<!--====================================本喵是分割线  喵喵~========================================================-->

<!--导航大盒子id=page 结束-->
</form>


<br><br><br><br>

<script type="text/javascript" src="/js/base64/localResizeIMG.js"></script>
<script type="text/javascript" src="/js/base64/mobileBUGFix.mini.js"></script>
<script>
  $(document).ready(function(){
    var m = "{{$mobile}}";
    if(m==0){
      var url = "/distribution/apply.html";
      layer.msg('请先注册');
      localStorage.setItem("redirect", url);
      setTimeout(function(){
        window.location.href = "/register";
      }, 1000)
    }
  });
</script>
<script>
	var delete_img = "";
	var token   = '{{csrf_token()}}';
	var img_data = "{{$data?$data->wx_img:''}}";
	function inputfile(){
		$("#wx_img").trigger('click');
	}

	$('#wx_img').localResizeIMG({
		width:800,// 宽度
		quality: 0.8, // 压缩参数 1 不压缩 越小清晰度越低
		success: function (result) {
			var img = new Image();
			img.src = result.base64;

			$.ajax({
				url: "{{url('ask/fileuploadbase')}}",
				type: "POST",
				data:  {file:img.src, _token:token},
				dataType:'json',
				success: function (data) {
					if(data.code==0){
						console.log(data);
						$('.img_input').attr("src",img.src);
						$("#img_input").attr("img-attr",data.url);
						//delete_img = data.url;
						img_data = data.url;
					}
				}
			});
//			if(delete_img !== ''){
//				$.ajax({
//					url: "/ask/deleteimg",
//					type: "POST",
//					data:  {imgurl:delete_img, _token:token},
//					dataType:'json',
//					success: function (data) {
//						if(data.code==1){
//							layer.msg("删除成功");
//						}
//					}
//				});
//			}


		}
	});


	$(".submit_btn").click(function(){

		var data_attr = $(this).attr("data-attr");
		if(data_attr == 0){
			var name = $("#name").val();
			//var tel = $("#tel").val();
			var tel ="{{$mobile}}";
			var wechat = $("#wechat").val();
			var idcard = $("#idcard").val();
			var teacher_tel = $("#teacher_tel").val();
			var form_id = $("#form_id").val();

			if(name == ''||name.length > 20 ||name.length ==0){
				$("html,body").animate({scrollTop: $("#name").offset().top-250}, 500);
				layer.msg("姓名格式不对哦~");
				return false;
			}

			// if(tel == ''|| !/13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}|19[0-9]{9}$/.test(tel)){

			// 	$("html,body").animate({scrollTop: $("#tel").offset().top-250}, 500);
			// 	layer.msg("手机号格式错误");
			// 	return false;
			// }


			if(wechat == '' || wechat.length >30){
				$("html,body").animate({scrollTop: $("#wechat").offset().top-250}, 500);
				layer.msg("微信号格式错误");
				return false;
			}

			if(idcard == '' || !/^[1-9]\d{5}(18|19|20|21|22)\d{2}((0[1-9])|10|11|12)(0[1-9]|[12]\d|3[01])\d{3}([0-9]|X)$|^[1-9]\d{5}\d{2}((0[1-9])|10|11|12)(0[1-9]|[12]\d|3[01])\d{3}$/.test(idcard)){
				$("html,body").animate({scrollTop: $("#idcard").offset().top-250}, 500);
				layer.msg("身份证格式错误");
				return false;
			}

//			if(teacher_tel==''||!/13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}|19[0-9]{9}$/.test(teacher_tel)){
//				layer.msg("老师手机号格式错误");
//				$("html,body").animate({scrollTop: $("#teacher_tel").offset().top-250}, 500);
//				return false;
//			}
//			if(img_data == ""){
//				layer.msg("请上传您的微信二维码~");
//				$("html,body").animate({scrollTop: $("#img_input").offset().top-250}, 500);
//				return false;
//			}

			var img_file = $("#img_input").attr("img-attr");

			$.ajax({
				url : '/distribution/form_data',
				type : 'post',
				dataType : 'json',
				data : {form_id:form_id,name:name,tel:tel,wechat:wechat,idcard:idcard,teacher_tel:teacher_tel,img_data:img_file,_token:token},
				success : function (data) {

					if(data.code == 1){
						layer.msg("提交成功");
						$("#submitFrame")[0].reset();
						$('.img_input').attr("src","/images/fenxiaoliucheng/jia.png");
						$(".submit_btn").text("审核中...");
						$(".submit_btn").attr("data-attr",1);
						if(form_id !== 0){
							window.location.reload();
						}

					}else if(data.code == 2){
						layer.msg("上传图片错误");
					}else{
						layer.msg("提交失败");
					}
				}
			});
		}else{
			layer.msg("您已提交成功，请等待审核哦·~");
		}

	})

</script>
@endsection
