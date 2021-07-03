@extends('layouts.header')
@section('title')
<title>赛普社区—分销中心主页</title>
<meta name="author" content="啾啾" />
<meta name="keywords" content="" />
<meta name="description" content="" />
@endsection

@section('cssjs')
	<!--本css-->
	<link rel="stylesheet" href="/css/fenxiaoliucheng.css" >
@endsection

@section('content')
	<!--选项卡 start-->
	<div>
		<!-- 本例主要代码 Start ================================ -->
		<div id="leftTabBox" class="tabBox">

			<div class="bd" id="tabBox1-bd">
				<div class="con clearfix">
					<!--第一页 start-->
					<div class="height_block">
						<!--====================================本喵是分割线  喵喵~========================================================-->
						<div class=" plr30">
							<h2 class="f34 color_333 lt ptb30 text_center">就业大课</h2>
							<div>
								<ul>
									@foreach($groupClass as $group)
									<li class="mb40">
										<a href="/train/study.html?id={{$group->id}}">
										<img src="{{env('IMG_URL')}}{{$group->cover_url}}" alt="" class="border-radius-img">
										<p class="f30 color_333 mt30">{{$group->title}}</p>
										<span class="block f24 color_gray666 fz">{{$group->courses}}套系列课&nbsp;&nbsp;{{$group->videos}}个视频课程&nbsp;&nbsp;{{$group->order}}人已报名</span>
										</a>
									</li>
									@endforeach
								</ul>
							</div>
						</div>
						<!--====================================本喵是分割线  喵喵~========================================================-->
						<br><br>
					</div>
					<!--第一页 end-->
				</div>
				<div class="con">
					<!--第二页 start-->
					<div class="height_block">
						<div class="mlr30">
							<div>
								<div class="ban_tit plr20 ptb30 bgcolor_orange">
									<dl class="clearfix plr20">
										<dt class="fl"><img src="/images/logo-s.png" alt=""></dt>
										<dd class="fl color_333 ml20">
											<p class="f40 lt pt10">赛普健身社区</p>
											<p class="f32 fz">课程佣金领取系统</p>
										</dd>
									</dl>
								</div>
								<p class="p-yj fz f22 text_center color_fff"><img src="/images/clock/xue.png" alt="" >申请提现后7个工作日内将收到佣金</p>
								<div class="plr20 con_1 ptb45">
									<dl class="clearfix plr20">
										<dt class="fl mr30">
											<!-- <img src="/images/clock/haibao-bg.jpg" alt=""> -->
											@if($user->avatar)
												@if(strpos($user->avatar,'http') !== false)
													<img src="{{$user->avatar}}" alt=""/>
												@else
													<img src="{{env('IMG_URL')}}{{$user->avatar}}" alt="头像" />
												@endif
											@else
											<img src="/images/my/nophoto.jpg" alt="头像" />
											@endif
										</dt>
										<dd class="fl">
											<p class="f32 lt color_333">{{$user->nickname}}</p>
											<!-- <p class="f22 fz color_gray666">招生老师</p> -->
										</dd>
									</dl>
								</div>
        					</div>
						</div>
						<hr class="hreiht20-bgf8">
						<!-- <div class="mlr30">
							<div class="yaoqing-yongjin">
								<h3 class="f30 fz color_333 ptb30">已经邀请付费的学员</h3>
								<div class="yaoqing-list">
									<ul>
										@if($formlist)
										@foreach($formlist as $form)
										<li class="ptb45">
											<div class="weui-cell padding0">
												<div class="weui-cell__bd">
													<p class="f30 fz color_333">{{$form->user_name}}{{$form->user_mobile}}</p>
													<p class="fz f22 color_gray999">录入时间：{{$form->created_at}}</p>
												</div>
												@if($form->is_receive==1)
												<div class="weui-cell__ft fz f26 color_gray999">已返佣金</div>
												@else
												<div class="weui-cell__ft fz f26 color_gray999">待返佣金</div>
												@endif
											</div>
										</li>
										@endforeach
										@else
										<li class="ptb45">
											<div class="weui-cell padding0">
												<div class="weui-cell__bd">
													<p class="f30 fz color_333">暂无信息</p>
												</div>
												<!-- <div class="weui-cell__ft fz f26 color_gray666">待返佣金</div> -->
											<!-- </div>
										</li>
										@endif
									</ul>
								</div>
							</div>
						</div>  -->
						<div class="mlr30">
							<div class="yaoqing-yongjin">
								<!--<h3 class="f30 fz color_333 ptb30">已经邀请付费的学员</h3>-->
								<div class="ptb30">
									<div class="weui-cell padding0 mt0 nobefore noafter f28 fz">
										<div class="weui-cell__bd">
											<p>已经邀请付费的学员</p>
										</div>
										<div class="weui-cell__ft color_333">共{{$orders->count()+$courseOrders->count()}}个用户</div>
									</div>
								</div>
								<?php
									$courseSum = $orders->count() + $courseOrders->count();
								?>
								<div class="yaoqing-list">
									<ul>
										@if($orders->count())
										@foreach($orders as $order)
										<li class="ptb30">
											<div class="weui-cell padding0 yq-img">
												<div class="weui-cell__hd">
													<!-- <img src="../images/xy.png" class="border-radius50"> -->
													@if(getUsers($order->user_id) && getUsers($order->user_id)->avatar)
														@if(strpos(getUsers($order->user_id)->avatar,'http') !== false)
															<img src="{{getUsers($order->user_id)->avatar}}" class="border-radius50"/>
														@else
															<img src="{{env('IMG_URL')}}{{getUsers($order->user_id)->avatar}}" class="border-radius50" />
														@endif
													@else
													<img src="/images/my/nophoto.jpg" alt="头像" class="border-radius50" />
													@endif
												</div>
												<div class="weui-cell__bd ml10">
													<p class="f30 fz color_333">
														@if(getUsers($order->user_id))
															{{getUsers($order->user_id)->nickname ? getUsers($order->user_id)->nickname : '暂无姓名'}}
															:{{getUsers($order->user_id)->mobile}}
														@else
															暂无信息
														@endif
													</p>
													<p class="fz f22 color_gray999">
													订单：{{$order->course_class_group_title}}
													</p>
												</div>
												<div class="weui-cell__ft fz f26 color_gray999">
													<p class="fz f26 color_gray999">佣金：{{$order->price*0.1}}元</p>
													@if($order->is_commission==1)
													<a href="javascript:void(0)" class="yj-btn text_center border-radius-img f28 fz bgcolor_e8 color_gray999">已提现</a>
													@elseif($order->is_commission==2)
													<a href="javascript:void(0)" class="yj-btn text_center border-radius-img f28 fz bgcolor_F5A623 color_fff">审核中</a>
													@elseif($order->is_commission==0)
													<a href="javascript:void(0)" class="yj-btn text_center border-radius-img f28 fz bgcolor_orange color_000 apply_btn" data-id="{{$order->id}}" id="btn_{{$order->id}}" data-true="1">提现</a>
													@endif
												</div>
											</div>
										</li>
										@endforeach
										@else
										@if(!$courseOrders)
											<li class="ptb45">
												<div class="weui-cell padding0">
													<div class="weui-cell__bd">
														<p class="f30 fz color_333">暂无信息</p>
													</div>
													<!-- <div class="weui-cell__ft fz f26 color_gray666">待返佣金</div> -->
												</div>
											</li>
										@endif
										@endif
                                        @if($courseOrders->count())
                                            @foreach($courseOrders as $courseOrder)
                                                <li class="ptb30">
                                                    <div class="weui-cell padding0 yq-img">
                                                        <div class="weui-cell__hd">
                                                            <!-- <img src="../images/xy.png" class="border-radius50"> -->
                                                            @if(getUsers($courseOrder->user_id) && getUsers($courseOrder->user_id)->avatar)
                                                                @if(strpos(getUsers($courseOrder->user_id)->avatar,'http') !== false)
                                                                    <img src="{{getUsers($courseOrder->user_id)->avatar}}" class="border-radius50"/>
                                                                @else
                                                                    <img src="{{env('IMG_URL')}}{{getUsers($courseOrder->user_id)->avatar}}" class="border-radius50" />
                                                                @endif
                                                            @else
                                                                <img src="/images/my/nophoto.jpg" alt="头像" class="border-radius50" />
                                                            @endif
                                                        </div>
                                                        <div class="weui-cell__bd ml10">
                                                            <p class="f30 fz color_333">
                                                                @if(getUsers($courseOrder->user_id))
                                                                    {{getUsers($courseOrder->user_id)->nickname ? getUsers($courseOrder->user_id)->nickname : '暂无姓名'}}
                                                                    :{{getUsers($courseOrder->user_id)->mobile}}
                                                                @else
                                                                    暂无信息
                                                                @endif
                                                            </p>
                                                            <p class="fz f22 color_gray999">
                                                                订单：{{$courseOrder->course_class_title}}
                                                            </p>
                                                        </div>
                                                        <div class="weui-cell__ft fz f26 color_gray999">
                                                            <p class="fz f26 color_gray999">佣金：{{$courseOrder->price*0.05}}元</p>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
									</ul>
								</div>
							</div>
						</div>
					
						<!-- <div class="btn_yongjin text_center">
							<a href="javascript:void (0)" class="bgcolor_orange border-radius-img fz f28 color_000 open-popup" data-target="#half" id="studyBtn">
								<img src="/images/clock/yang.png" alt="">申请佣金
							</a>
						</div> -->
						<br>
						<br>
					</div>
					<!--第二页 end-->
				</div>

			</div>
			<!-- <div class="hd zhu_btn">
				<ul class="clearfix text_center fz f34 color_333">
					<li><a href="javascript:void (0)">分销课程</a></li>
					<li class="on"><a href="javascript:void (0)">领取佣金</a></li>
				</ul>
			</div> -->
		</div>

		<script src="/js/TouchSlide.1.1.js"></script>
		<script type="text/javascript">TouchSlide({ slideCell:"#leftTabBox",defaultIndex:1,

			endFun:function(i){ //高度自适应
				var bd = document.getElementById("tabBox1-bd");
				bd.parentNode.style.height = bd.children[i].children[0].offsetHeight+"px";
				if(i>0)bd.parentNode.style.transition="200ms";//添加动画效果
			}
		}); </script>
		<!-- 本例主要代码 End ================================ -->

	</div>
	<!--选项卡 end-->
	
	

	<!--====================================本喵是分割线  喵喵~========================================================-->

	<!-- 底部弹出popup start -->
	<div id="half" class='weui-popup__container popup-bottom payType_popup'>
		<div class="weui-popup__overlay"></div>
		<div class="weui-popup__modal fz">
			<div class="toolbar">
				<div class="toolbar-inner ">
					<a href="javascript:void (0);" class="picker-button close-popup f28 color_333">关闭</a>
					<h1 class="title fz f30">佣金领取系统</h1>
				</div>
			</div>

			<div class="modal-content bgcolor_f8">
				<div class="biaodian_tj plr45 fz">
					<ul class="pt40">
						<li>
							<p class="f26 color_gray666 pb15">学员报名的课程</p>
							<div class="select-select fz f28">
								<select name="title">
									<option value="">-- 请选择学员报名的课程 --</option>
									@foreach($groupClass as $group)
									<option value="{{$group->title}}">{{$group->title}}</option>
									@endforeach
								</select>
							</div>
						</li>
						<li>
							<div class="wrap">
								<p class="f26 color_gray666 pb15 pt20">学员姓名</p>
								<input type="text" placeholder="请填写学员姓名" name="user_name" class="f28 border-radius-img">
							</div>
						</li>
						<li>
							<div class="wrap">
								<p class="f26 color_gray666 pb15 pt20">学员手机号</p>
								<input type="text" placeholder="请填写学员注册赛普健身社区的手机号" name="user_mobile" class="f28 border-radius-img">
							</div>
						</li>
					</ul>
				</div>
				<div class="tij-btn ptb30 text_center plr45 mt30">
					<a href="javascript:void(0);" class="btn bgcolor_orange border-radius-img payBtn f34 color_333">提交</a>
				</div>
			</div>
		</div>
	</div>
	<!-- 底部弹出popup end -->

	<!--====================================本喵是分割线  喵喵~========================================================-->
	<!--====================================本喵是分割线  喵喵~========================================================-->
</div><!--导航大盒子id=page 结束-->



<br><br>

<script>

	//设置select的默认选中项颜色
		var unSelected = "#d5d5d6";
		var selected = "#333";
		$(function () {
			$("select").css("color", unSelected);
			$("option").css("color", selected);
			$("select").change(function () {
				var selItem = $(this).val();
				if (selItem == $(this).find('option:first').val()) {
					$(this).css("color", unSelected);
				} else {
					$(this).css("color", selected);
				}
			});
		});

	//提交弹出框
	$('.payBtn').click(function (){
		//$.closePopup();
		// $.confirm({
		// 	title: '提示',
		// 	text: '确认提交吗？',
		// 	onOK: function () {
				//点击确认
				
			var user_mobile = $("input[name='user_mobile']").val();
			var user_name   = $("input[name='user_name']").val();
			var title       = $("select[name='title']").val();
			if(user_name.length = 0 ||user_name.length > 20||!user_name){
				layer.msg('请填写正确的姓名');
				return;
			}
			if(!title){
				layer.msg('请选择报名的课程');
				return;
			}
			if(!user_mobile || !/1[1-9]{1}[0-9]{9}$/.test(user_mobile)){
				layer.msg('请输入有效的手机号码');
			}else {
				$.ajax({
					url:'/dist/sale/form',
					type:'get',
					data:{user_mobile:user_mobile, user_name:user_name, title:title},
					dataType:'json',
					success:function(res){
						console.log(res);
						if(res.code == 1){
							layer.msg(res.msg);
						}else{
							layer.msg(res.msg);
						}
						//$.closePopup();
					}
				});
			}
			
			// },
			// onCancel: function () {

			// }
		// });
	})

	//提交提现申请
	$(".apply_btn").click(function(){
		var group_id = $(this).attr("data-id");
		var edit_id  = "btn_"+group_id;
		var data_true= $(this).attr("data-true");
		if(data_true==0){
			layer.msg("请勿重复操作");
		}else{
			$.ajax({
				url:'/dist/sale/form',
				type:'get',
				data:{group_id:group_id},
				dataType:'json',
				success:function(res){
					console.log(res);
					if(res.code == 1){
						$("#"+edit_id).text("审核中").removeClass("color_000").removeClass("bgcolor_orange").removeClass("apply_btn");
						$("#"+edit_id).text("审核中").addClass("bgcolor_F5A623").addClass("color_fff");
						$("#"+edit_id).attr("data-true", 0);
						layer.msg(res.msg);
					}else{
						layer.msg(res.msg);
					}
					//$.closePopup();
				}
			});
		}
		
	})
	//Tab切换模块展开解决bug
	var h2=$('.bd .height_block').eq(0).height();
	$('.tempWrap').height(h2)
</script>
@endsection
