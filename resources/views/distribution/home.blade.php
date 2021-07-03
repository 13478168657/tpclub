@extends('layouts.header')
@section('title')
<title>赛普社区-分销主页</title>
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




	<!--选项卡 start-->
	<div>

		<!-- 本例主要代码 Start ================================ -->
		<div id="leftTabBox" class="tabBox">

			<div class="bd" id="tabBox1-bd">
				<div class="con clearfix">
					<!--第一页 start-->
					<div class="height_block">
						<!--====================================本喵是分割线  喵喵~========================================================-->
						<div class="ptb40 bbtom20 bgcolor_fff">
							<div class="weui-cell noafter nobefore padding0 fengxiao_tit mlr30">
								<div class="weui-cell__hd">
									@if(count($user)>0)
										@if(strpos($user->avatar,'http') !== false)
											<img src="{{$user->avatar}}" class="border-radius50">
										@else
											<img src="{{env('IMG_URL')}}{{$user->avatar}}" class="border-radius50">

										@endif
									@else
										<img src="/images/daoshi-t-img.jpg" class="border-radius50">
									@endif

								</div>
								<div class="weui-cell__bd fz">
									<p class="f32 color_333 bold">{{$user?$user->nickname:''}}</p>
									<span class="f22 color_gray666">分销员</span>
								</div>
								<div class="weui-cell__ft fz f22 color_000 fenxiao_saipubi border-radius-img"><img src="/images/ico_saipubi.png" alt=""> 赛普币{{$user?$user->spb:''}}</div>
							</div>
						</div>

						<!--====================================本喵是分割线  喵喵~========================================================-->

						<div class="bgcolor_fff">
							<div class="mlr30 ">
								<div class="zhuye_list ">
									<ul>
										<li class="ptb30">
											<a class="weui-cell weui-cell_access padding0 noafter nobefore mt0" href="javascript:;">
												<div class="weui-cell__bd">
													<p class="fz color_333 f30">我的招生老师</p>

													<span class="fz f22 color_gray999">{{getUsers($fission_id->fission_id)?getUsers($fission_id->fission_id)->nickname:''}}-{{getUsers($fission_id->fission_id)?getUsers($fission_id->fission_id)->mobile:''}}</span>
												</div>
												<div class="weui-cell__ft noafter">
												</div>
											</a>
										</li>
										<li class="ptb30">
											<a class="weui-cell weui-cell_access padding0 noafter nobefore mt0" href="/distribution/invite/0.html">
												<div class="weui-cell__bd">
													<p class="fz color_333 f30">累计客户</p>
													<span class="fz f22 color_gray999">（如果客户已经通过别的途径注册赛普产品则不做记录）</span>
												</div>
												<div class="weui-cell__ft noafter padding0 f28 fz">{{$all_num}}
												</div>
											</a>
										</li>
										<!-- <li class="ptb30">
											<a class="weui-cell weui-cell_access padding0 noafter nobefore mt0" href="/distribution/invite/0.html">
												<div class="weui-cell__bd">
													<p class="fz color_333 f30">累计客户</p>
													<span class="fz f22 color_gray999">（如果客户已经通过别的途径注册赛普产品则不做记录）</span>
												</div>
												<div class="weui-cell__ft padding0 f28 fz jiao_right">
												</div>
											</a>
										</li> -->

									</ul>

								</div>
							</div>
						</div>
						<!--====================================本喵是分割线  喵喵~========================================================-->

						<!--分享入口 start-->
						<div class="mlr30 mt286">
							<a href="javascript:void (0)"><img src="/images/fenxiaoliucheng/fenxiangtukou.png" alt=""></a>
						</div>
						<!--分享入口 end-->
						<!--====================================本喵是分割线  喵喵~========================================================-->
					</div>
					<!--第一页 end-->
				</div>
				<div class="con">
					<!--第二页 start-->
					<div class="height_block">
						<div class="mlr30">
							<ul class="ul_load_data">
								@if(count($class) > 0)
									@foreach($class as $v)
									<li class="mb30">
										<div class="fenxiaochanpin relative border-radius-img">
											<a href="/dist/buy/{{$v->id}}.html?dis={{$userid}}"><img src="{{env('IMG_URL')}}{{$v->cover_url}}" alt="" class="fenimg_img"></a>
											<div class="fen_img text_center fz color_fff">
												<h3 class="f32 bold" onclick = "window.location.href='/dist/buy/{{$v->id}}.html?dis={{$userid}}';">{{$v->title}}</h3>
												<p class="f26" onclick = "window.location.href='/dist/buy/{{$v->id}}.html?dis={{$userid}}';">{{$v->description}}</p>
												<div class="fen_btn_x">
													<ul class="clearfix"><!-- /distribution/shareCard/{{$userid}}.html -->
														<li class="fl bgcolor_orange"><a href="javascript:void (0)" onclick="getImgUrl('{{$userid}}','{{$v->id}}');" class="color_333 fz f26 ">打卡课程分享海报</a></li>
														<li class="fr bgcolor_orange"><a href="/dist/active/{{$userid}}/{{$v->id}}.html" class="color_333 fz f26 ">打卡课程分享链接</a></li>

													</ul>
												</div>
											</div>
										</div>
									</li>

									@endforeach

								@else
									<li class="on">暂无可分享课程哦~</li>
								@endif
							</ul>
							<div class="nomore f24 color_gray666 text_center ptb50 bgcolor_fff loadmore" onclick="loadmore(this);" data-load = 0>加载更多</div>

						</div>

					</div>
					<!--第二页 end-->
				</div>

			</div>
			<div class="hd zhu_btn">
				<ul class="clearfix text_center fz f34 color_333">
					<li class="on"><a href="javascript:void (0)">分销主页</a></li>
					<li><a href="javascript:void (0)">分销产品</a></li>
				</ul>
			</div>
		</div>

		<script src="../js/TouchSlide.1.1.js"></script>
		<script type="text/javascript">TouchSlide({ slideCell:"#leftTabBox",

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
	<!--====================================本喵是分割线  喵喵~========================================================-->
	<!--====================================本喵是分割线  喵喵~========================================================-->
</div><!--导航大盒子id=page 结束-->



<br><br><br><br>


<script>
$('body').addClass('bgcolor_f8');

//Tab切换模块展开解决bug
var h2=$('.bd .height_block').eq(0).height();
$('.tempWrap').height(h2);


var img_haibao = "";
var _token   = '{{csrf_token()}}';

var i = 2;
var loadmore = function(e){
	var loaddata = e.getAttribute("data-load");
	console.log(loaddata);
	if(loaddata == 0){

		$.ajax({
			url : '/distribution/loadmore',
			type : 'post',
			dataType : 'json',
			data : {page:i,_token:_token},
			success : function (data) {
				if(data.body == ''){
					layer.msg("加载完成哦~");
					$(".loadmore").text("加载完成");
					$(".loadmore").attr("data-load",1);
				}else{
					$(".height_block .ul_load_data").append(data.body);
					$('.tempWrap').css('height','auto');

				}
				i++;
			}
		});
	}else{
		layer.msg("加载已完成哦~");
	}

}
	function getImgUrl(id,cid){
		$.ajax({
			url:'/distribution/shareCard',
			type:'post',
			dataType:'json',
			data:{id:id,cid:cid,_token:_token},
			success:function(data){
				//console.log(data);
				img_haibao = data.img;
				layer.open({
					type: 1,
					title: false, //不显示标题栏
					skin: 'bm_success_layer_wrap200', //样式类名
					id: 'bm_success_layer200', //设定一个id，防止重复弹出
					closeBtn: 1, //不显示关闭按钮
					anim: 2,
					shadeClose: true, //开启遮罩关闭
					area: ['90%', '70%'],
					content: '<div class="bm_success_layer text_center tan-font"><img src="'+img_haibao+'" class="bm_success" alt="" /></div>',
					btn: false
				});
			}
		})
	}
</script>


@endsection
