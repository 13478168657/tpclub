@extends('layouts.header')
@section('title')
    <title>创建的问答专区{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
   	<link rel="stylesheet" href="../css/ask.css">
	<link rel="stylesheet" href="../css/ask_popup.css">
    
@endsection
@section('content')
<!---导航右侧带导航弹出---->

<div id="page">
	<!--导航大盒子id=page 开始  【结束在最底部】-->
	<!--===========================================================================================-->
    <!--创建问答专区 start-->
    @if($list)
	<div class="chuangjian plr30" >
		<h4 class="fz bold f28 pt30">我创建的问答专区</h4>

		<div class="list_chuangjian">
			<ul id="scecial_list">

				@foreach($list as $k=>$item)
				<?php
					$k++;
					$y = $k%6;
				?>
				<li class="pt30">
					<a href="javascript:;">

						<div class="bg bg_color_lan_h_{{$y}} border-radius-img color_fff relative bg_height">
							<dl class="clearfix"  onclick="window.location.href='/ask/specialask/{{$item['id']}}.html';">
								<dt class="fl">
									@if(strpos($user->avatar,'http') !== false)
										<img src="{{$user->avatar}}" class="border-radius50 avatar" />
									@else
										<img src="{{env('IMG_URL')}}{{$user->avatar}}" class="border-radius50 avatar" />
									@endif
								</dt>
								<dd class="fl fz pt14">
									<h3 class="f28 bold mt10">{{$item['title']}}</h3>
									<p class="f28 bold">{{$item['author']}} <span class="f22">{{$item['description']}}</span></p >

								</dd>
							</dl>
							<div class="weui-cell nobefore padding0 foot f24 fr ">
								<div class="weui-cell__ft rev_del rev_del2 fz color_fff plr30">
									<?php
										$num = DB::table("ask_question")->where("special_id",$item['id'])->count();
									?>
									<span class="full1" data-attr = "{{$item['id']}}"><img src="/images/ico2_rev.png" alt="">修改</span>
									@if($num > 0)
										<span  onclick="layer.msg('已有作业和回复，不能删除哦');"><img src="/images/ico2_del.png" alt="">删除</span>
										@else
										<span  class="btn_del" data-attr ="{{$item['id']}}"><img src="/images/ico2_del.png" alt="">删除</span>
									@endif
								</div>
							</div>
							@if($item['is_open']==1)
								<strong class="open_open border-radius50 text_center f14">公开</strong>
							@endif
						</div>
					</a>

				</li>

				@endforeach
			</ul>
		</div>
	</div>
	@else
		<div class="ask_zc_con">
			<img src="/images/ask/icon_zc.png" alt="">
			<h2 class="fz color_gray666 text_center f28">你还没有创建专场</h2>
		</div>
	@endif
	<!--创建问答专区 end-->
	<!--===========================================================================================-->
	

	<!--底部悬浮【新建一个专题】按钮 start-->
	<div class="relative">
		<div class="fixed_zt_bottom text_center bgcolor_orange">
			<a href="javascript:void (0)" class="color_333 fz f34 open-popup" data-target="#full">新建一个专题</a>
		</div>
	</div>
	<!--底部悬浮【新建一个专题】按钮 end-->

</div>
<!--导航大盒子id=page 结束-->
<br><br><br>

<!-- popup -->
<div id="full" class='weui-popup__container bgcolor_fff ask_popup'>
	<div class="weui-popup__overlay"></div>
	<div class="weui-popup__modal bgcolor_fff">
		<!-- 头部条 start -->
		<header class="header_bar max750 relative">
			<a href="javascript:void(0);" class="btn_cancel btn_cancel1 color_gray999 f24">取消</a>
			<div class="cat1 f28">新建问答专区</div>
			<a href="javascript:void(0)" class="btn_link btn_submit color_gray999 f24">提交</a>
		</header>
		<!-- 头部条 end -->
		<!-- 表单区 start -->
		<div class="text_ask_chuangjian plr30 fz">
			<div class="zhuanti_name">
				<textarea class="text-jus f28" placeholder="专题命名（例如：孕产技能提升，建议10个字以内）" rows="1"  maxlength="10" id="cur_title" ></textarea>
			</div>
			<div class="zhuanti_name">
				<textarea class="text-jus f28" placeholder="输入您的姓名（让用户知道你是谁）" rows="1" id="cur_author"></textarea>
			</div>
			<textarea class="text-jus f28" placeholder="一句话描述您的职称或者荣誉（建议小于20字）" rows="2"  maxlength="20" id="cur_description"></textarea>

		</div>


		<!--开始/结束时间 start-->
		<div class="askStartTime mlr30 fz f28 ptb20">
			<div class="ptb20">
				<div class="weui-cell padding0">
					<div class="weui-cell__hd"><label for="date1" class="weui-label">开始时间</label></div>
					<div class="weui-cell__bd">
						<input class="weui-input date1" type="text" value="" placeholder="点击添加开始时间">
					</div>
				</div>
			</div>
			<div class="ptb20">
				<div class="weui-cell padding0">
					<div class="weui-cell__hd"><label for="date2" class="weui-label">结束时间</label></div>
					<div class="weui-cell__bd">
						<input class="weui-input date2" type="text" value="" placeholder="点击添加结束时间">
					</div>
				</div>
			</div>
		</div>
		<!--开始/结束时间 end-->
		<!-- 表单区 end -->

		<div class="choice plr30">
			<div class="choice_nav">
				<ul>
					<li class="clearfix fz f28 color_gray666">
						<h4 class="fl">是否公开</h4>
						<!--单选-->
						<div class="checkboxWrap fr">
							<label class=""><input type="radio" name="bbb" class="radiobox click-me" onclick = "cick_me(this);" value="1" checked />是</label>
							<label class=""><input type="radio" name="bbb" class="radiobox no-click-me" onclick = "no_click_me(this);" value="0" />否</label>
						</div>
					</li>
				</ul>
			</div>
			<div  class="choice_content none fz f28 color_gray666">
				<div class="choice_content_box">
					<p class="flip ptb40 relative">请选择关联该专区的组合课程<img src="../images/xiala_s.png" class="flip-arrow" alt=""/></p>
					<div class="panel plr36">
						<!--多选-->
						<div class="checkboxWrap pb40">
							@foreach($courseclassgroup as $group)
							<label class="mt20"><input type="checkbox" name="ccc" value="{{$group->id}}" class="checkbox group_c" />{{$group->title}}</label>
							@endforeach
						</div>
					</div>
				</div>
				<div class="choice_content_box">
					<p class="flip ptb40 relative">请选择关联该专区的单一课程<img src="../images/xiala_s.png" class="flip-arrow" alt=""/></p>
					<div class="panel plr36">
						<!--多选-->
						<div class="checkboxWrap pb40">
							@foreach($courseclass as $course)
							<label class="mt20"><input type="checkbox" name="aaa" value="{{$course->id}}" class="checkbox course_c" />{{$course->title}}</label>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


	<!-- popup 修改专题-->
	<div id="full1" class='weui-popup__container bgcolor_fff ask_popup'>
		<div class="weui-popup__overlay"></div>
		<div class="weui-popup__modal bgcolor_fff">
			<!-- 头部条 start -->
			<header class="header_bar max750 relative">
				<a href="javascript:void(0);" class="btn_cancel btn_cancel2 color_gray999 f24">取消</a>
				<div class="cat1 f28">新建问答专区</div>
				<a href="javascript:void(0)" class="btn_link btn_submit color_gray999 f24" data-attr="">提交</a>
			</header>
			<!-- 头部条 end -->
			<!-- 表单区 start -->
			<div class="text_ask_chuangjian plr30 fz">
				<div class="zhuanti_name">
					<textarea class="text-jus f28" placeholder="专题命名（例如：孕产技能提升，建议10个字以内）" rows="1"  maxlength="10" id="cur_title" ></textarea>
				</div>
				<div class="zhuanti_name">
					<textarea class="text-jus f28" placeholder="输入您的姓名（让用户知道你是谁）" rows="1" id="cur_author"></textarea>
				</div>
				<textarea class="text-jus f28" placeholder="一句话描述您的职称或者荣誉（建议小于20字）" rows="2"  maxlength="20" id="cur_description"></textarea>

			</div>

			<!--开始/结束时间 start-->
			<div class="askStartTime mlr30 fz f28 ptb20">
				<div class="ptb20">
					<div class="weui-cell padding0">
						<div class="weui-cell__hd"><label for="date1" class="weui-label">开始时间</label></div>
						<div class="weui-cell__bd">
							<input class="weui-input date1" type="text" value="" placeholder="点击添加开始时间">
						</div>
					</div>
				</div>
				<div class="ptb20">
					<div class="weui-cell padding0">
						<div class="weui-cell__hd"><label for="date2" class="weui-label">结束时间</label></div>
						<div class="weui-cell__bd">
							<input class="weui-input date2" type="text" value="" placeholder="点击添加结束时间">
						</div>
					</div>
				</div>
			</div>
			<!--开始/结束时间 end-->
			<!-- 表单区 end -->

			<div class="choice plr30">
				<div class="choice_nav">
					<ul>
						<li class="clearfix fz f28 color_gray666">
							<h4 class="fl">是否公开</h4>
							<!--单选-->
							<div class="checkboxWrap fr">
								<label class=""><input type="radio" name="bbb" class="radiobox click-me" onclick = "cick_me(this);" value="1" />是</label>
								<label class=""><input type="radio" name="bbb" class="radiobox no-click-me" onclick = "no_click_me(this);" value="0" />否</label>
							</div>
						</li>
					</ul>
				</div>
				<div  class="choice_content none fz f28 color_gray666">
					<div class="choice_content_box">
						<p class="flip ptb40 relative">请选择关联该专区的组合课程<img src="../images/xiala_s.png" class="flip-arrow" alt=""/></p>
						<div class="panel plr36">
							<!--多选-->
							<div class="checkboxWrap pb40">
								@foreach($courseclassgroup as $group)
									<label class="mt20"><input type="checkbox" name="ccc" value="{{$group->id}}" class="checkbox group_c" />{{$group->title}}</label>
								@endforeach
							</div>
						</div>
					</div>
					<div class="choice_content_box">
						<p class="flip ptb40 relative">请选择关联该专区的单一课程<img src="../images/xiala_s.png" class="flip-arrow" alt=""/></p>
						<div class="panel plr36">
							<!--多选-->
							<div class="checkboxWrap pb40">
								@foreach($courseclass as $course)
									<label class="mt20"><input type="checkbox" name="aaa" value="{{$course->id}}" class="checkbox course_c" />{{$course->title}}</label>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script src="/lib/icheck/js/icheck.min.js"></script>
<script>
	//给body加一个类
	$('body').addClass('page_dialog_wrap');

	//单选按钮
	$('.radiobox').iCheck({
		radioClass: 'iradio',
		increaseArea: '20%'
	});

	//多选按钮
	$('.checkbox').iCheck({
		radioClass: 'icheckbox',
		increaseArea: '20%'
	});

	var cick_me = function(e){
		$('.choice_content').hide();
	}

	var no_click_me = function(e){
		$('.choice_content').show();
	}
	$(function(){

		$('.flip').on('click',function(){
			$(this).next().slideToggle(500);
		});

		//下拉箭头样式
		var usercenter = {
			init:function(){
				this.modal();
			},
			modal: function() {
				$(".flip").click(function(){
					var arrow=$(this).children('.flip-arrow');
					if(arrow.hasClass("rotate")){ //点击箭头旋转180度
						arrow.removeClass("rotate");
						arrow.addClass("rotate1");
					}else{
						arrow.removeClass("rotate1"); //再次点击箭头回来
						arrow.addClass("rotate");
					}
				})
			}
		};
		usercenter.init();

	})


	var _token = '{{csrf_token()}}';
	//提交
	$('#full .btn_submit').click(function (){
		var des   = $('#full #cur_description').val();   //描述
		var title = $("#full #cur_title").val();         //专题标题
		var author= $("#full #cur_author").val();        //问答专题作者
		var avatar = $("#full .avatar").eq(0).attr("src");
		var is_open = $('#full input:radio[name="bbb"]:checked').val();
		var course  = "";
		var group   = "";
		var start = $('#full .date1').val();
		var end = $('#full .date2').val();
		$('#full .course_c').each(function(){
			if(this.checked){
				course+=$(this).val()+",";
			}
		});
		$('#full .group_c').each(function(){
			if(this.checked){
				group+=$(this).val()+",";
			}
		});

		if(!title || !des || !author || !start || !end){
			layer.msg('请完善内容');
			return;
		}else{
			$.ajax({
				url : '/ask/specialadd',
				type : 'post',
				dataType : 'json',
				data : {des : des, title:title, author:author, _token:_token, is_open:is_open, course: course, group:group,start:start,end:end},
				success:function(data){
					$.closePopup();
					if(data.code==1){
						//$("#scecial_list").prepend('');
						window.location.reload();
					}else{
						layer.msg(data.msg);
					}
					return;
					layer.msg(data.msg);
					setTimeout(function(){
						$.closePopup();//关闭弹出框
						window.location.reload();
					},1000)  //延迟1.5秒刷新页面
				}
			});
		}

	})
	//提交
	$('#full1 .btn_submit').click(function (){
		var des   = $('#full1 #cur_description').val();   //描述
		var title = $("#full1 #cur_title").val();         //专题标题
		var author= $("#full1 #cur_author").val();        //问答专题作者
		var avatar = $("#full1 .avatar").eq(0).attr("src");
		var is_open = $('#full1 input:radio[name="bbb"]:checked').val();
		var course  = "";
		var group   = "";
		var id = $("#full1 .btn_submit").attr("data-attr");
		var start = $('#full1 .date1').val();
		var end = $('#full1 .date2').val();

		$('#full1 .course_c').each(function(){
			if(this.checked){
				course+=$(this).val()+",";
			}
		});
		$('#full1 .group_c').each(function(){
			if(this.checked){
				group+=$(this).val()+",";
			}
		});

		if(!title || !des || !author || !start || !end){
			layer.msg('请完善内容');
			return;
		}else{
			$.ajax({
				url : '/ask/specialadd',
				type : 'post',
				dataType : 'json',
				data : {des : des, title:title, author:author, _token:_token, is_open:is_open, course: course, group:group,id:id,start:start,end:end},
				success:function(data){
					$.closePopup();
					layer.msg('修改成功');
					setTimeout(function(){
						$.closePopup();//关闭弹出框
						window.location.reload();
					},1000)  //延迟1.5秒刷新页面
				}
			});
		}

	})

	//取消
	$('.btn_cancel1').click(function (){
		layer.open({
			title: '',
			content: '是否放弃创建专题',
			id: 'mylayer',
			closeBtn: 0, //不显示关闭按钮
			btn: ['放弃', '继续'],
			yes: function(index, layero) {
				//【放弃按钮】的回调
				layer.closeAll();
				$.closePopup();//关闭弹出框
				$('#content').val('');

			},
			btn2: function(index, layero) {
				//【继续回答】的回调

			}
		});
	})
	//取消
	$('.btn_cancel2').click(function (){
		layer.open({
			title: '',
			content: '是否放弃修改专题',
			id: 'mylayer',
			closeBtn: 0, //不显示关闭按钮
			btn: ['放弃', '继续'],
			yes: function(index, layero) {
				//【放弃按钮】的回调
				layer.closeAll();
				$.closePopup();//关闭弹出框
				$('#content').val('');

			},
			btn2: function(index, layero) {
				//【继续回答】的回调

			}
		});
	})

</script>

<script>
	//取消
	$('.btn_del').click(function (){
		var id = $(this).attr("data-attr");
		//console.log(id);
		layer.open({
			title: '',
			content: '是否删除',
			id: 'mylayer',
			closeBtn: 0, //不显示关闭按钮
			btn: ['放弃', '删除'],
			yes: function(index, layero) {
				//【放弃按钮】的回调
				layer.closeAll();
				$.closePopup();//关闭弹出框
				//$('#tit').val('');
				$('#content').val('');

			},
			btn2: function(index, layero) {
				//删除
				$.ajax({
					url : '/ask/delspecial',
					type : 'post',
					dataType : 'json',
					data : {sid:id,_token:_token},
					success : function (data) {
						if(data.code == 1){
							layer.msg("删除成功");
							window.location.reload();
						}
					}
				});
			}
		});
	})

	$(".full1").click(function(){
		var id = $(this).attr("data-attr");
		$("#full1 .btn_submit").attr("data-attr",id);
		$.ajax({
			url : '/ask/getdetail',
			type : 'post',
			dataType : 'json',
			data : {sid:id,_token:_token},
			success : function (data) {
				$("#full1 #cur_title").val(data.title);
				$("#full1 #cur_author").val(data.author);
				$("#full1 #cur_description").val(data.description);
				$("#full1 .date1").val(data.start_time);
				$("#full1 .date2").val(data.end_time);
				if(data.is_open == 1){
					$("#full1 input:radio[name=bbb][value='1']").attr("checked",true);
				}else{
					$("#full1 input:radio[name=bbb][value='0']").attr("checked",true);
					$('#full1 .choice_content').show();
				}
				var arr = data.course_class_ids.split(',');
				var group_arr = data.course_class_group_ids.split(',');
				$.each(arr,function(index,value){
					$("#full1 input:checkbox[name=aaa][value='"+value+"']").attr("checked",true);
				});
				$.each(group_arr,function(index,value){
					$("#full1 input:checkbox[name=ccc][value='"+value+"']").attr("checked",true);
				})
				//单选按钮
				$('#full1 .radiobox').iCheck({
					radioClass: 'iradio',
					increaseArea: '20%'
				});
				//多选按钮
				$('#full1 .checkbox').iCheck({
					radioClass: 'icheckbox',
					increaseArea: '20%'
				});

			}
		});
		$("#full1").popup();
	})

	/*开始时间*/
	$(".date1").calendar({
		dateFormat: 'yyyy-mm-dd'
	});
	/*结束时间*/
	$(".date2").calendar({
		dateFormat: 'yyyy-mm-dd'
	});
</script>
@endsection