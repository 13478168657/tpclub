$(function (){
	//搜索
	var cha=$('.search .s_box2 .s_wrap .icon-chahao');//重置叉
	var keywords=$('.search .s_box2 .s_wrap .keywords');//关键字输入框
	$('.search .s_box1 .s_wrap .s_tip').click(function(){
		$('.search .s_box1').hide();
		$('.search .s_box2').show();
		keywords.focus();
		$('.search_mask').show();
		$('.search_mask').show();
		$('.search_mask .container').slideDown();
		$('.search2_mask').toggleClass('block')
		$('.search2 .s_box1 .wrap_r .nav_menu').toggleClass('block');
	})
	//取消和点击蒙版
	$('.search .s_box2 .btn_cannel,.search_mask .mask').click(function(){
		$('.search .s_box2').hide();
		$('.search .s_box1').show();
		$('.search_mask').hide();
		$('.search_mask').hide();
		$('.search_mask .container').hide();
	})
	//重置输入框
	cha.click(function(){
		$(this).prev('.keywords').val('').focus();
	})
	//回车
	keywords.keyup(function(){
		if($(this).val().length>0){
			cha.show();
		}else{
			cha.hide();
		}
		if(event.keyCode ==13){
			//$("#submit").trigger("click");
			alert(123);
		}
	});

	/*搜索2菜单按钮*/
	$('.search2 .s_box1 .wrap_r .btn_wrap,.search2_mask .mask').click(function(){
		$('.search2_mask').toggleClass('block')
		$('.search2 .s_box1 .wrap_r .nav_menu').toggleClass('block');
	})

	
})

//选项卡
function tab1(tabTitle,tabBox){
	$(tabTitle).click(function(){
		$(this).addClass("cur").siblings().removeClass("cur"); 
		var index=$(this).index(); 
		//alert(index);
		$(tabBox).children('div').eq(index).show().siblings().hide();
	})
}


//发送验证码
function settime(btnSend,countdown){
	if (countdown == 0) { 
	   btnSend.removeClass('disabled');
	   btnSend.text('重新发送');
	   countdown = 60; 
	} else {
		btnSend.addClass('disabled');
		btnSend.text("重新发送(" + countdown + ")");
		countdown--; 
		setTimeout(function() { 
			settime(btnSend,countdown) 
		},1000)  
	} 
}
/**
*字数限制（倒数）
*@inputObj 输入框对象，如文本框或文本域
*@numObj 显示数字的对象，如exp_content_words，<div>还可以输入<strong id="exp_content_words">50</strong>个字</div>
*@maxNum 最大字数
**/  
function wordLimit(inputObj,numObj,maxNum){
	var val=inputObj.val();
	numObj.text(maxNum - val.length);
	inputObj.on("input propertychange", function() {  
		var $this = $(this),  
			_val = $this.val(),  
			count = "";  
		if (_val.length > maxNum) {  
			$this.val(_val.substring(0, maxNum));  
		}  
		count = maxNum - $this.val().length;  
		numObj.text(count);  
	});  
}
/*正数*/
function wordLimit1(inputObj,numObj,maxNum){
	var val=inputObj.val();
	numObj.text(val.length);
	inputObj.on("input propertychange", function() {  
		var $this = $(this),  
			_val = $this.val(),  
			count = "";  
		if (_val.length > maxNum) {  
			$this.val(_val.substring(0, maxNum));  
		}  
		count = $this.val().length;  
		numObj.text(count);  
	});  
}

/**
*限制字符于多少到多少之间
*@inputObj 输入框对象，如文本框或文本域
*@numObj 显示数字盒子的外层对象，如exp_content_words，<div id="exp_content_words">还需要输入<strong>50</strong>个字</div>
*@minNum 最小字数
*@maxNum 最大字数
**/
function minWordLimit(inputObj,numObj,minNum,maxNum){
	/*var val=inputObj.val();
	numObj.find('strong').text(maxNum - val.length);*/
	inputObj.on("input propertychange", function() {  
		var $this = $(this),  
			_val = $this.val(),  
			count = "";  
		if (_val.length < minNum) {
			count = minNum - $this.val().length;  
			//numObj.find('strong').text(count);  
			numObj.html("你还需要输入<strong>"+count+"</strong>个字");  
		} else{
			if (_val.length > maxNum) {  
				$this.val(_val.substring(0, maxNum));  
			}  
			count = maxNum - $this.val().length;  
			numObj.html("你还可以输入<strong>"+count+"</strong>个字");  
			//numObj.find('strong').text(count);  
		}
		
	});  
}
