@extends('layouts.header')
@section('title')
    <title>推荐文章{{env('WEB_TITLE')}}</title>
    <meta name="description" content="" />
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/article.css">
    <style>
    	#page {padding-bottom:3rem;}
    </style>
@endsection
@section('content')	
<div id="page">

	
	<nav id="menu"></nav>
	<!--头部导航 end-->


	<div class="page_tags">
		<div class="plr30 bgcolor_fff fz">
			<h3 class="clearfix ">
				<span class="fl">（分享你的见识，奖励赛普币）</span>
				<a href="/spb/rules" class="fr viewRule">查看赛普币规则</a>
			</h3>
			<div class="inputWrap urlWrap">
				<input type="text" class="input" name="article_url" placeholder="如粘贴一篇文章的链接到这里" />
			</div>
			<h3 class="clearfix">添加标签</h3>
			<div class="inputWrap tagsWrap fz">
				<div class="relative">
					<span class="ico_zoom"></span>
					<input type="text" class="input" placeholder="可添加3个标签如：有氧、减脂" />
					<span class="btn_addtags">添加</span>
				</div>
				<ul class="clearfix">
					<li><b class="text-overflow cur_tag"></b><span class="btn_close"></span></li>
					<li><b class="text-overflow cur_tag"></b><span class="btn_close"></span></li>
					<li><b class="text-overflow cur_tag"></b><span class="btn_close"></span></li>
				</ul>
			</div>
		</div>
		<!-- 标签列表 -->
		<div class="autocompleteWrap fz">
			<ul id="ui-id-1" tabindex="0" class="ui-menu ui-widget ui-widget-content ui-autocomplete ui-front" style="display: none;"></ul>
		</div>
		<!-- 底部按钮 -->
		<div class="fixed_bar_bottom ptb20 bgcolor_fff">
			<div class="plr30 bgcolor_fff">
				<span class="btn1 fz">立即分享</span>
			</div>
		</div>
	</div>
	<!--边距30 end-->
</div>
<!--导航大盒子id=page 结束-->


<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jquery-ui/jquery-ui.js" type="text/javascript"></script>
<link href="/lib/jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css" />
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
  $(function() {
    FastClick.attach(document.body);
  });
</script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>

<!--nav logo menu 导航条-->
<script src="/lib/mmenu/js/nav-mmenu-public.js"></script>
<script src="/lib/mmenu/js/jquery.mmenu.all.js"></script>
<script src="/lib/mmenu/js/jquery.mhead.js"></script>
<!--end-->

<script type="text/javascript">

	//去除底部按钮不能点击样式
	$('.urlWrap .input').on("input propertychange", function() {
		var val = $(this).val();
		console.log(val.length)
		if(val.length>0){
			$('.btn1').removeClass('disabled');
		}
	})

	$(document.body).delegate(".btn_addtags,.btn_add1", 'click', function () {
		var val=$('.tagsWrap .input').val();
		var len=$('.tagsWrap ul li.has').length;
		if(len>=3){
			layer.msg('最多添加3个标签');
			return false;
		}
		if(val==''){
			layer.msg('请输入标签');
		/*}else if(val.length>4){
			layer.msg('标签字符不能超过4个');*/
		}else{
			$('.tagsWrap ul li').each(function (){
				if($(this).hasClass('has')==false){
					$(this).addClass('has');
					$(this).find('b').text(val);
					$('.tagsWrap .input').val('');
					$('.autocompleteWrap #ui-id-1').html('');
					return false;
				}	
			})
		}
	})

	$(document.body).delegate(".btn_close", 'click', function () {
		$(this).parents('li').remove();
		$('.tagsWrap ul').append('<li><b></b><span class="btn_close"></span></li>')
	})

	//立即分享
	$('.btn1').click(function (){
		var article_url =  $("input[name='article_url']").val();
		var tags        = "";
		if(article_url==""){
			layer.msg("请输入地址");
			return;
		}
		var token       = '{{csrf_token()}}';
		$(".clearfix .cur_tag").each(function(){
			var text = $(this).text();
			if(text){
				tags+=text+",";
			}
		});

	   	var index = layer.load(1,{
			id:'my_loading',
			//time: 2*1000,
			content:'正在解析',
			shade: [.5,'#000'] //黑色背景
		});

	   	$.ajax({
			type:"POST",
			url:"/article/capture",
			data:{url:article_url,tags:tags, _token:token},
			dataType:"json",
			success:function(result){
				layer.closeAll('loading');
				if(result.code == 0){
					layer.msg(result.msg);
					setTimeout(function(){
						window.location="/recommend/success/"+result.id;
					}, 500);
				}else{
					layer.msg(result.msg);
				}
            }
		});
	   
	})

	//自动完成数据
	$(".tagsWrap .input").autocomplete({
	    source: [ 
	        "增肌",
	        "塑形",
	        "减脂","健身饮食","体脂率","卡路里","基础代谢","跑步减肥","慢跑","空腹跑步",
	        "弹力带","背阔肌","肱三头肌","三角肌","练肌肉","力量训练","练腹肌","锻炼身体","锻炼胸肌","健身饮食",
	        "壶铃", "斜方肌", "胸肌中缝", "斜方肌", "股四头肌", "腹外斜肌", "三角肌前束", "三角肌后束", "髂腰肌", "pc肌", "腿部肌肉",
	        "有氧运动","瑜伽","囚徒健身","无氧运动","室内健身","腹肌","骨骼肌","颈部肌肉","肱二头肌","胸肌",
	        "跑步","杠铃划船","人鱼线","拉伸运动","热身运动","健身教练","健身培训","私人教练","减肥运动","瘦肚子","瘦大腿","消耗脂肪","瘦腿","健身减肥",
	        "健身理论","腹部","胳膊","卧推","硬拉","深蹲","平板撑","波比运动","双杠臂屈伸",
			"大众健身","单杠","弹力绳","臀部","胸部","肩膀","腰部","上肢","下腹","膝关节","前臂","小腿","后背",
			"健美竞技","体能训练","拉力绳","杠铃","拉力器","登山机","划船器","哑铃健身","弹力带",
			"运动损伤","三角肌","泡沫轴","胸大肌","肌肉酸痛","拉伤","耐力","爆发力训练","臂力",
	        "体态"
	    ],
		appendTo: '.autocompleteWrap'
	}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li class='ui-menu-item fz'></li>" )
            .append( "<div class='ui-menu-item-wrapper ui-state-active fz'>"+item.value+"</div><span class='btn_add1'>添加</span>" )
            .appendTo( ul );
        }

	/*window.onload = function(){
		menuFixed('nav_keleyi_com');
	}*/
</script>
@endsection