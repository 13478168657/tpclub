
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



//单行省略
var ellipsis1 = document.querySelectorAll(".ellipsis1");
//循环使用
for (var i = 0; i < ellipsis1.length; i++){
	$clamp(ellipsis1[i], {clamp: 1});
};

//两行省略
var ellipsis2 = document.querySelectorAll(".ellipsis2");
//循环使用
for (var j = 0; j < ellipsis2.length; j++){
	$clamp(ellipsis2[j], {clamp: 2});
};

//三行省略
var ellipsis3 = document.querySelectorAll(".ellipsis3");
//循环使用
for (var j = 0; j < ellipsis3.length; j++){
	$clamp(ellipsis3[j], {clamp: 3});
};

//四行省略
var ellipsis4 = document.querySelectorAll(".ellipsis4");
//循环使用
for (var j = 0; j < ellipsis4.length; j++){
	$clamp(ellipsis4[j], {clamp: 4});
};

//五行省略
var ellipsis5 = document.querySelectorAll(".ellipsis5");
//循环使用
for (var j = 0; j < ellipsis5.length; j++){
	$clamp(ellipsis5[j], {clamp: 5});
};

//五行省略加全文
var ellipsis5_more = document.querySelectorAll(".ellipsis5_more");
//循环使用
for (var j = 0; j < ellipsis5_more.length; j++){
	$clamp(ellipsis5_more[j], {clamp: 5,useNativeClamp:false,truncationChar:'<a href="javascript:void (0)" class="mores fz">全文</a>',truncationHTML: '...'});
};