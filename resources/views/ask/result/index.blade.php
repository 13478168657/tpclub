@extends('layouts.header')
@section('title')


<title>问答专场-已回答</title>
<meta name="author" content="啾啾" />
<meta name="keywords" content="" />
<meta name="description" content="" />
	@endsection

	@section('cssjs')

	<!--问答下css-->
<link rel="stylesheet" href="/lib/layui/css/layui.css">
<style>
	.img_list li{background-size: cover;
		background-position: center center;
		background-repeat: no-repeat;}
</style>
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

<div id="page">
	<!--导航大盒子id=page 开始  【结束在最底部】-->


	<form class="layui-form" action="/train/ask/selectzuoye">
		<div class="layui-form-item">
			<label class="layui-form-label"></label>
			<div class="" style="padding: 0px 20px;">
				<input type="text" name="mobile" required  lay-verify="required" placeholder="请输入手机号" autocomplete="off" class="layui-input">
			</div>
		</div>
		<div class="layui-form-item">
			<div class="" style="padding: 0px 20px;">
				<button type="submit" class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>

			</div>
		</div>
	</form>
	作业详情 -{{$mobile}}
	<table class="layui-table">
		<colgroup>
			<col>
			<col>
			<col>
		</colgroup>
		<thead>
		<tr>
			<th>编号</th>
			<th>作业标题</th>
			<th>是否提交</th>
			<th>是否认可</th>
			<th>提交时间</th>
			<th>更新时间</th>
		</tr>
		</thead>
		<tbody>
		@if(count($answer) > 0)
		@if($answer !== '')
			@foreach($answer as $v)
				<tr>
					<td>{{$v->id}}</td>
					<td>{{$v->title}}</td>
					<td>@if($v->content !== '' ||$v->imgurl_list !== '') 已提交 @else 未提交 @endif</td>
					<td>{{$v->is_approve}}</td>
					<td>{{$v->created_at}}</td>
					<td>{{$v->updated_at}}</td>
				</tr>
			@endforeach

		@else
			<tr>
				<td colspan="6">暂无作业详情</td>

			</tr>
		@endif
			@else
			<tr>
				<td colspan="6">暂无作业详情</td>

			</tr>
		@endif

		</tbody>
	</table>



</div>
<!--导航大盒子id=page 结束-->


<br><br><br>



@endsection
