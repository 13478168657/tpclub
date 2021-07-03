@extends('layouts.header')
@section('title')
    <title>赛普搜索-专业的健身行业资讯垂直搜索{{env('WEB_TITLE')}}</title>
    <meta name="description" content="普搜索致力于为健身教练提供健身图文、健身问答以及专业课程等信息，帮助健身教练更好解决工作、训练中遇到的问题。内容包括问答、视频、文章、训练动作等，涉及增肌、减脂、普拉提、孕产、康复等多个方向" />
    <meta name="keywords" content="健身,健身教练,康复,增肌,减脂" />
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/article.css">
    <style>
    	#page {padding-bottom:3rem;}
    </style>
@endsection
@section('content')	
<div id="page">

	<!--隐藏导航内容-->
	<nav id="menu"></nav>
	<!--头部导航 end-->

	<div class="page_search fz">
		<div class="plr30">
			<div class="searchWrap">
				<input type="text" class="input" placeholder="搜索问答、课程、文章" />
				<span class="btn_ss"></span>
			</div>
			<dl class="hot">
				<dt>热门搜索</dt>
				<dd>
					@foreach($keywords as $keyword)
					<a href="/searchr.html?k={{$keyword->keyword}}">{{$keyword->keyword}}</a>
					@endforeach
				</dd>
			</dl>
			<dl class="history">
				<dt class="clearfix">
					<span class="fl">历史搜索</span>
					<a href="javascript:void(0)" class="fr btn_del"></a>
				</dt>
				<dd id="old_keyword">
					
				</dd>
			</dl>
		</div>
	</div>
	<!--边距30 end-->
</div>
<!--导航大盒子id=page 结束-->

<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
  $(function() {
    FastClick.attach(document.body);
  });
</script>
<!-- <script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>
 -->
<!--nav logo menu 导航条-->
<!-- <script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script> -->
<!--end-->
<script>
	function getCookie(name) 
	{ 
	    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	 
	    if(arr=document.cookie.match(reg))
	 
	        return unescape(arr[2]); 
	    else 
	        return null; 
	} 
	var cookie = {
		set: function(name, value) {
			var Days = 30;
			var exp = new Date();
			exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
			document.cookie = name + '=' + escape(value) + ';expires=' + exp.toGMTString();
		},
		get: function(name) {
			var arr, reg = new RegExp('(^| )' + name + '=([^;]*)(;|$)');
			if(arr = document.cookie.match(reg)) {
				return unescape(arr[2]);
			} else {
				return null;
			}
		},
		del: function(name) {
			var exp = new Date();
			exp.setTime(exp.getTime() - 1);
			var cval = getCookie(name);
			if(cval != null) {
				document.cookie = name + '=' + cval + ';expires=' + exp.toGMTString();
			}
		}
	};
	
	var k  = cookie.get("k");
	console.log(k);
	if(k){
		var newk = JSON.parse(k);
		for(var i in newk){
			$("#old_keyword").append('<a href="/searchr.html?k='+newk[i]+'">'+newk[i]+'</a>');
		}
	}
</script>

<script type="text/javascript">
	//给body加一个类
	$('body').addClass('page_ss_wrap');
	//搜索点击按钮触发
	$('.btn_ss').click(function (){
		var val=$(this).prev().val();
		var karr = new Array();
		if(val==''){
			return false;
		}else{
			var oldk = cookie.get("k");
			if(oldk){
				oldk = JSON.parse(oldk);
				//筛选是否有重复值
				var is_insert = 1;
				for(var o in oldk){
					if(val == oldk[o]){
						is_insert = 0;
					}
				}
				console.log(val);
				if(is_insert==1){
					oldk.unshift(val);
					cookie.set('k', JSON.stringify(oldk));
				}
			}else{
				karr.unshift(val);
				cookie.set('k', JSON.stringify(karr));
			}
			window.location.href = "/searchr.html?k="+val;
		}
		
	})

	//搜索回车触发
	/*$('.searchWrap .input').keyup(function (event){
		var val=$(this).val();
		if(event.keyCode==13){
			if(val==''){
				return false;
			}else{
				alert(val);
			}                 
		}
	})*/

	//确认清空历史搜索
	$('.btn_del').click(function (){
		layer.open({
			title: '',
			content: '确认清空历史搜索？',
			id: 'mylayer',
			closeBtn: 0, //不显示关闭按钮
			btn: ['取消', '确定'],
			yes: function(index, layero) {
				//【取消按钮】的回调
				layer.closeAll();

			},
			btn2: function(index, layero) {
				//【确定按钮】的回调
				$("#old_keyword").empty();
				cookie.del("k");
			}
		});
	})

	/*window.onload = function(){
		menuFixed('nav_keleyi_com');
	}*/
</script>
@endsection