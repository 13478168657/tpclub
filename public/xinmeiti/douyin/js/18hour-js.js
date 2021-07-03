/**
*络绎改编简单倒计时2===============永远18小时倒计时
*使用方法1，在js里调用
	window.onload=function(){
		countTime2()
	}

*使用方法1，在body上调用
	<body onload="countTime2()">
*html：
	<div class="countTime">
        <div id="_d"><span>0</span><span>0</span><em>天</em></div>
        <div id="_h"><span>0</span><span>0</span><em>时</em></div>
        <div id="_m"><span>0</span><span>0</span><em>分</em></div>
        <div id="_s"><span>0</span><span>0</span><em>秒</em></div>
    </div>
**/
//18小时的毫秒数
var leftTime = 64800000;
function countTime2() {
	/*//获取当前时间  
	var date = new Date();
	var now = date.getTime();
	//设置截止时间 
	var datestr = "2020/6/10 00:00:00";
	var endDate = new Date(datestr);
	var end = endDate.getTime();*/

	//时间差  
	//var leftTime = end - now;
	leftTime=leftTime-1000;
	//定义变量 d,h,m,s保存倒计时的时间  
	var d, h, m, s;
	if (leftTime >= 0) {
		d = Math.floor(leftTime / 1000 / 60 / 60 / 24);
		//h = Math.floor(leftTime / 1000 / 60 / 60 % 24);
		h = Math.floor(leftTime / 1000 / 60 / 60);
		m = Math.floor(leftTime / 1000 / 60 % 60);
		console.log(leftTime)
		s = Math.floor(leftTime / 1000 % 60);

		//将0-9的数字前面加上0，例1变为01
		d = checkTime(d);
		h = checkTime(h);
		m = checkTime(m);
		s = checkTime(s);
		function checkTime(i) {
			if (i < 10) {
				i = "0" + i;
			}
			return i;
		}
		//将倒计时赋值到div中  
		//console.log(d)
		//console.log(d.toString().length)
		var html="";
		for( var j = 0; j < d.toString().length; j++){
			html +="<span>" + d.toString()[j] + "</span>"
		}
		//console.log(html)
		//document.getElementById("_d").innerHTML = html + "<em></em>";
		document.getElementById("_h").innerHTML ="<div><span>" + h.toString()[0] + "</span><span>" + h.toString()[1] + "</span></div><em>" +  ":" + "</em>";
		document.getElementById("_m").innerHTML ="<div><span>" + m.toString()[0] + "</span><span>" + m.toString()[1] + "</span></div><em>" +  ":" + "</em>";
		document.getElementById("_s").innerHTML ="<div><span>" + s.toString()[0] + "</span><span>" + s.toString()[1] + "</span></div>";
		//递归每秒调用countTime方法，显示动态时间效果  
		setTimeout(countTime2, 1000);
	}else{
		alert('时间到');
		//return false;
	}
}
/*window.onload=function(){
	countTime2()
}*/