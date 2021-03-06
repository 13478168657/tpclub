<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
	<title>产品体验官招募-填写</title>
	<meta name="author" content="涵涵" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link href="/css/reset.css" rel="stylesheet" type="text/css" />
	<link href="/css/font-num40.css" rel="stylesheet" >
	<!--本css-->
	<link rel="stylesheet" href="/css/zt/zt_recruit.css">
	<style type="text/css">
		#teamData label.error{color:red;font-size: 1.2em;width: 60%;text-align: left;font-family: 兰亭黑简;}
		#teamData label.checked{color:green;font-size: 1.2em;width: 60%;text-align: left;font-family: 兰亭黑简;}
	</style>
	<script>
		(function(){
			var html = document.documentElement;
			var hWidth = html.getBoundingClientRect().width;
			html.style.fontSize=hWidth/18.75+'px';
		})()
	</script>
</head>
<body>
	<div>

		<div>
			<div class="ban clearfix">
				<a href="javascript:void (0)" class="fr mr30 border-radius-img f28 lt bold d-in-black">CLOSE</a>
			</div>
			<!--=============================本喵是分割线 喵喵~===============================================-->

			<div class="plr35">
				<div class="comp-t text_center pt40">
					<h3 class="fz f42 bold mb30"><i></i>产品体验官竞选问卷<i></i></h3>
				</div>
			<!--=============================本喵是分割线 喵喵~===============================================-->
				<!--个人信息 start-->
				<div>
					<div class="mt70">
						<h3 class="bg-g d-in-black text_center f30 fz bold">个人信息</h3>
					</div>
					<!--单选 start-->
					<iframe name="teamPost" style="display:none;"></iframe>
					<form method="post" action="/zt/experinfo.html" id="teamData" target="teamPost">
						<!-- <form method="get" action="/zt/exper.html"> -->
					<div class="G-cont">
						<ul>
							<li>
								<div class="checkboxWrap mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">1、请问您的性别是？</h3>
									<div class="plr45">
										<label class="fz f28 mb10"><input type="radio" name="info1" value="男" class="radiobox" required />男</label>
										<label class="fz f28 mb10"><input type="radio" name="info1" value="女" class="radiobox" />女</label>
										<!--<p class="tip color_red f22 fz">嘤嘤嘤~</p>-->
									</div>
								</div>
							</li>
							<li>
								<div class="checkboxWrap mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">2、请问您的出生年份是？</h3>
									<div class="plr45">
										<label class="fz f28 mb10">
											<input type="radio" name="info2" class="radiobox" value="2000年后" required />2000年后
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info2" class="radiobox" value="1995年后-2000年前" />1995年后-2000年前
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info2" class="radiobox" value="1990年后-1995年前" />1990年后-1995年前
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info2" class="radiobox" value="1985年后-1990年前" />1985年后-1990年前
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info2" class="radiobox" value="1985年前" />1985年前
										</label>
										<!--<p class="tip color_red f22 fz">嘤嘤嘤~</p>-->
									</div>
								</div>
							</li>
							<li>
								<div class="textarea-a mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">3、请问是哪里人？</h3>
									<div class="plr45">
										<textarea class="bgcolor_fff border-radius-img ptb13 plr20 fz" placeholder="点击输入您的文字信息" rows="4" name="info3" required ></textarea>
										<!--<p class="tip color_red f22 fz">嘤嘤嘤~</p>-->
										<br/>
									</div>
								</div>
							</li>
							<li>
								<div class="textarea-a mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">4、请问您目前学习或工作的地方是在哪个城市？</h3>
									<div class="plr45">
										<textarea class="bgcolor_fff border-radius-img ptb13 plr20 fz" placeholder="点击输入您的文字信息" rows="4" name="info4" required></textarea>
										<!--<p class="tip color_red f22 fz">嘤嘤嘤~</p>-->
										<br/>
									</div>
								</div>
							</li>
							<li>
								<div class="checkboxWrap mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">5、请问您的身份是？</h3>
									<div class="plr45">
										<label class="fz f28 mb10">
											<input type="radio" name="info5" class="radiobox" value="健身爱好者" required />健身爱好者
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info5" class="radiobox" value="预定学员" />预定学员
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info5" class="radiobox" value="在校学员" />在校学员
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info5" class="radiobox" value="私人教练" />私人教练
										</label>
										<!--<p class="tip color_red f22 fz">嘤嘤嘤~</p>-->
									</div>
								</div>
							</li>
							<li>
								<div class="textarea-a mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">6、请问您平时健身使用_______器材？</h3>
									<div class="plr45">
										<textarea class="bgcolor_fff border-radius-img ptb13 plr20 fz" name="info6" placeholder="（比如：徒手，哑铃，杠铃等等）" rows="4" required></textarea>
										<!--<p class="tip color_red f22 fz">嘤嘤嘤~</p>-->
										<br/>
									</div>
								</div>
							</li>
							<li>
								<div class="checkboxWrap mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">7、请问您在赛普健身社区学习，是因为哪方面的需求偏多？</h3>
									<div class="plr45">
										<label class="fz f28 mb10">
											<input type="radio" name="info7" class="radiobox" value="增肌" required />增肌
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info7" class="radiobox" value="减脂" />减脂
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info7" class="radiobox" value="孕产专项教练技能" />孕产专项教练技能
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info7" class="radiobox" value="康复专项教练技能" />康复专项教练技能
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info7" class="radiobox" value="会员训练处理思路" />会员训练处理思路
										</label>
										<div class="textarea-a">
											<textarea class="bgcolor_fff border-radius-img ptb13 plr20 fz" name="info71"  placeholder="其他" rows="4"></textarea>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="textarea-a mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">8、请问您健身_____年了？</h3>
									<div class="plr45">
										<textarea class="bgcolor_fff border-radius-img ptb13 plr20 fz" placeholder="点击输入您的文字信息" name="info8" rows="4" required></textarea>
										<!--<p class="tip color_red f22 fz">嘤嘤嘤~</p>-->
										<br/>
									</div>
								</div>
							</li>
							<li>
								<div class="checkboxWrap mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">9、请问您微信有多少好友？</h3>
									<div class="plr45">
										<label class="fz f28 mb10">
											<input type="radio" name="info9" class="radiobox" value="100人以下" required />100人以下
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info9" class="radiobox" value="100—200人" />100—200人
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info9" class="radiobox" value="200—300人" />200—300人
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info9" class="radiobox" value="300—500人" />300—500人
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info9" class="radiobox" value="500人以上" />500人以上
										</label>
									</div>
								</div>
							</li>
							<li>
								<div class="checkboxWrap mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">10、以下课程，您的会员对哪一类课程更感兴趣？</h3>
									<div class="plr45">
										<label class="fz f28 mb10">
											<input type="radio" name="info10" class="radiobox" value="健美冠军都在学的强背计划" required />健美冠军都在学的强背计划
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info10" class="radiobox" value="只要7分钟，打造完美腹肌" />只要7分钟，打造完美腹肌
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info10" class="radiobox" value="减脂也容易，2周衣服回到S码" />减脂也容易，2周衣服回到S码
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info10" class="radiobox" value="产后妈妈如何恢复" />产后妈妈如何恢复
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info10" class="radiobox" value="美女老师带你全面掌握普拉提" />美女老师带你全面掌握普拉提
										</label>
										
									</div>
								</div>
							</li>
							<li>
								<div class="checkboxWrap mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">11、如果社区推出福利活动，您对以下哪种福利更感兴趣？</h3>
									<div class="plr45">
										<label class="fz f28 mb10">
											<input type="radio" name="info11" class="radiobox" value="家用引体向上器" required />家用引体向上器
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info11" class="radiobox" value="迷你踩踏登山机" />迷你踩踏登山机	
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info11" class="radiobox" value="家用动感单车" />家用动感单车
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info11" class="radiobox" value="多功能收腹器" />多功能收腹器
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info11" class="radiobox" value="瑜伽垫" />瑜伽垫
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info11" class="radiobox" value="隐形沙袋" />隐形沙袋
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="info11" class="radiobox" value="运动衣/运动背包" />运动衣/运动背包
										</label>
										<div class="textarea-a">
											<textarea class="bgcolor_fff border-radius-img ptb13 plr20 fz" name="info111"  placeholder="其他您想得到的福利_____" rows="4"></textarea>
											<!--<p class="tip color_red f22 fz">嘤嘤嘤~</p>-->
										</div>
									</div>
								</div>
							</li>
							<!--=== 第二大题 ======================================================================-->
							<div class="mt70">
								<h3 class="bg-g bg-g2 d-in-black text_center f30 fz bold">赛普健身社区产品体验</h3>
							</div>

							<li>
								<div class="mt32">
									<h3 class="fz f28 mb30 text-jus">1、如果让您给赛普健身社区为用户提供的几大学习形式打分，满分10分，您打几分？</h3>

									<div class="plr45">
										<div class="fz f28 mb10">系列课：
											<p class="xuan d-in-black">
												<select name="experience1_1">
													<option value="0">?</option>
													<option value="10">10</option>
													<option value="9">9</option>
													<option value="8">8</option>
													<option value="7">7</option>
													<option value="6">6</option>
													<option value="5">5</option>
													<option value="4">4</option>
													<option value="3">3</option>
													<option value="2">2</option>
													<option value="1">1</option>
												</select>
											</p>
										分</div>
										<p class="tip color_red cur_fz7 fz" style="display:none;">*请完善信息</p>
										<div class="fz f28 mb10">每日精选视频：
											<p class="xuan d-in-black">
												<select name="experience1_2">
													<option value="0">?</option>
													<option value="10">10</option>
													<option value="9">9</option>
													<option value="8">8</option>
													<option value="7">7</option>
													<option value="6">6</option>
													<option value="5">5</option>
													<option value="4">4</option>
													<option value="3">3</option>
													<option value="2">2</option>
													<option value="1">1</option>
												</select>
											</p>
											分</div>
										<p class="tip color_red cur_fz7 fz" style="display:none;">*请完善信息</p>
										<div class="fz f28 mb10">干货文章：
											<p class="xuan d-in-black">
												<select name="experience1_3">
													<option value="0">?</option>
													<option value="10">10</option>
													<option value="9">9</option>
													<option value="8">8</option>
													<option value="7">7</option>
													<option value="6">6</option>
													<option value="5">5</option>
													<option value="4">4</option>
													<option value="3">3</option>
													<option value="2">2</option>
													<option value="1">1</option>
												</select>
											</p>
											分</div>
										<p class="tip color_red cur_fz7 fz" style="display:none;">*请完善信息</p>
										<div class="fz f28 mb10">微信群：
											<p class="xuan d-in-black">
												<select name="experience1_4">
													<option value="0">?</option>
													<option value="10">10</option>
													<option value="9">9</option>
													<option value="8">8</option>
													<option value="7">7</option>
													<option value="6">6</option>
													<option value="5">5</option>
													<option value="4">4</option>
													<option value="3">3</option>
													<option value="2">2</option>
													<option value="1">1</option>
												</select>
											</p>
											分</div>
										<p class="tip color_red cur_fz7 fz" style="display:none;">*请完善信息</p>
									</div>

								</div>

							</li>

							<li>
								<div class="checkboxWrap mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">2、如果赛普健身社区只为您提供一种学习形式，你选择哪个？</h3>
									<div class="plr45">
										<label class="fz f28 mb10">
											<input type="radio" name="experience2" class="radiobox" value="系列课" required />系列课
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="experience2" class="radiobox" value="每日精选视频" />每日精选视频
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="experience2" class="radiobox" value="干货文章" />干货文章
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="experience2" class="radiobox" value="微信群" />微信群
										</label>
									</div>
								</div>
							</li>
							<li>
								<div class="checkboxWrap mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">3、如果让您去掉赛普健身社区的一种学习形式，您选择哪个？</h3>
									<div class="plr45">
										<label class="fz f28 mb10">
											<input type="radio" name="experience3" class="radiobox" value="系列课" required />系列课
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="experience3" class="radiobox" value="每日精选视频" />每日精选视频
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="experience3" class="radiobox" value="干货文章" />干货文章
										</label>
										<label class="fz f28 mb10">
											<input type="radio" name="experience3" class="radiobox" value="微信群" />微信群
										</label>
									</div>
								</div>
							</li>
							<li>
								<div class="textarea-a mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">4、系列课中您希望上线哪些课程？</h3>
									<div class="plr45">
										<textarea class="bgcolor_fff border-radius-img ptb13 plr20 fz" name="experience4" placeholder="点击输入您的文字信息" rows="4" required></textarea>
										<!--<p class="tip color_red f22 fz">嘤嘤嘤~</p>-->
										<br/>
									</div>
								</div>
							</li>
							<li>
								<div class="textarea-a mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">5、文章中您更希望看到哪些干货知识？</h3>
									<div class="plr45">
										<textarea class="bgcolor_fff border-radius-img ptb13 plr20 fz" placeholder="点击输入您的文字信息" name="experience5" rows="4" required></textarea>
										<!--<p class="tip color_red f22 fz">嘤嘤嘤~</p>-->
										<br/>
									</div>
								</div>
							</li>
							<li>
								<div class="textarea-a mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">6、每日精选视频中您希望导师拍摄些什么视频？</h3>
									<div class="plr45">
										<textarea class="bgcolor_fff border-radius-img ptb13 plr20 fz" placeholder="点击输入您的文字信息" name="experience6" rows="4" required></textarea>
										<!--<p class="tip color_red f22 fz">嘤嘤嘤~</p>-->
										<br/>
									</div>
								</div>
							</li>
							<li>
								<div class="textarea-a mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">7、在微信群中，您更想看到哪些内容？或者对于现在规则有何建议？</h3>
									<div class="plr45">
										<textarea class="bgcolor_fff border-radius-img ptb13 plr20 fz" placeholder="点击输入您的文字信息" name="experience7" rows="4" required></textarea>
										<!--<p class="tip color_red f22 fz">嘤嘤嘤~</p>-->
										<br/>
									</div>
								</div>
							</li>
							<!--=== 第三大题 ======================================================================-->
							<div class="mt70">
								<h3 class="bg-g bg-g2 bg-g3 d-in-black text_center f30 fz bold">产品优化建议：</h3>
							</div>

							<li>
								<div class="textarea-a mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">1、您在使用赛普健身社区产品中，有什么感觉到体验不好的地方？</h3>
									<div class="plr45">
										<textarea class="bgcolor_fff border-radius-img ptb13 plr20 fz" placeholder="点击输入您的文字信息" name="product1" rows="4" required></textarea>
										<!--<p class="tip color_red f22 fz">嘤嘤嘤~</p>-->
										<br/>
									</div>
								</div>
							</li>
							<li>
								<div class="textarea-a mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">2、您最看好社区哪项功能，但目前做的没有达到您的预期，您希望能如何改善？</h3>
									<div class="plr45">
										<textarea class="bgcolor_fff border-radius-img ptb13 plr20 fz" placeholder="点击输入您的文字信息" rows="4" name="product2" required></textarea>
										<!--<p class="tip color_red f22 fz">嘤嘤嘤~</p>-->
										<br/>
									</div>
								</div>
							</li>
							<li>
								<div class="textarea-a mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">3、您希望赛普健身社区产品加入什么新功能？</h3>
									<div class="plr45">
										<textarea class="bgcolor_fff border-radius-img ptb13 plr20 fz" placeholder="点击输入您的文字信息" rows="4" name="product3" required></textarea>
										<!--<p class="tip color_red f22 fz">嘤嘤嘤~</p>-->
										<br/>
									</div>
								</div>
							</li>
							<li>
								<div class="textarea-a mt32 mb50">
									<h3 class="fz f28 mb30 text-jus">4、其他建议</h3>
									<div class="plr45">
										<textarea class="bgcolor_fff border-radius-img ptb13 plr20 fz" placeholder="点击输入您的文字信息" rows="4" name="product4" required></textarea>
										<!--<p class="tip color_red f22 fz">嘤嘤嘤~</p>-->
										<br/>
									</div>
								</div>
							</li>

						</ul>
					</div>
					<!--单选 end-->
				</div>
				<!--个人信息 end-->


			</div>
			<!--=============================本喵是分割线 喵喵~===============================================-->
			<center><h3 class="fz f28">选拔时间：即日起至1月16日</h3></center>
			<center><h3 class="fz f28">若选拔通过，我们会在10个工作日内与您联系。</h3></center>
			<div class="bot-bg text_center">
				<div class="btn btn2 text_center  mt70 ">
					<a href="javascript:void (0)" class="text_center f30 fz bold d-in-black cur_submit">提交问卷</a>
				</div>
				<!-- <input type="button" value="提交" id="cur_button" /> -->
			</div>
			</form>
			<!--=============================本喵是分割线 喵喵~===============================================-->
			
			
		</div>
	</div>
	<script src="../../lib/jquery-2.1.4.js" type="text/javascript"></script>
	<script src="../../lib/icheck/js/icheck.min.js"></script>
	<script>
		//单选按钮
		$('.radiobox').iCheck({
			//checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio',
			increaseArea: '20%'
		});
	</script>
	<script src="../../js/jquery.validate.js"></script>
	<script src="../../js/jQuery.Form.js"></script>
	<script src="../../js/messages_zh.js"></script>
	<script src="../../lib/layer/layer.js"></script>
	<script>

	$("#teamData").validate({
		rules:{
			xingming:{
					required:true,
					maxlength: 20,
					
				},
			shouji:{
					required:true,
					tel:true,
				},
		},
		messages:{
				xingming:{
					required:"请输入用户名",
					maxlength:"用户名长度过长",
				},
				shouji:{
						required:"请输入手机号",
						tel:"手机号格式错误",
					},
				},
		/*success: function(label) {
					label.html("通过验证").addClass("checked");
			},*/
		success: 'valid',
		highlight:function(element,errorClass){
				$(element).parent().find("." +errorClass).removeClass("checked");
				//console.log($(element).parent());
			},
		submitHandler:function(form) {
				$(form).ajaxSubmit({
					type :"get",
					dataType:"json",
					url :"/zt/experinfo.html",
					success:function(data){
						if(data.code==1){
							$('#teamData')[0].reset();
							layer.msg(data.msg);
							setTimeout(function(){
								window.location.href="/user/studying";
							}, 2000)
						}else{
							layer.msg(data.msg);
						}
					},
				});
			},
		errorPlacement: function(error, element) {
				//console.log(element);
				if (element.is(":radio")){
					error.appendTo(element.parent().parent().parent());
				}else{
					error.appendTo(element.parent());
				}
				
			},

	});
	$('.cur_submit').click(function(){
		var experience1_4 = $("select[name='experience1_4']").val();
		if(experience1_4=="0"){
			$("select[name='experience1_4']").parent().parent().next().show();
		}
		var experience1_3 = $("select[name='experience1_3']").val();
		if(experience1_3=="0"){
			$("select[name='experience1_3']").parent().parent().next().show();
		}
		var experience1_2 = $("select[name='experience1_2']").val();
		if(experience1_2=="0"){
			$("select[name='experience1_2']").parent().parent().next().show();
		}
		var experience1_1 = $("select[name='experience1_1']").val();
		if(experience1_1=="0"){
			$("select[name='experience1_1']").parent().parent().next().show();
		}
		$("#teamData").submit();
	})
	</script>
</body>
</html>
