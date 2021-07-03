@foreach($data as $v)
	<li class="mb30">
		<div class="fenxiaochanpin relative border-radius-img">
			<img onclick = "window.location.href='/dist/buy/{{$v->id}}/{{$userid}}.html';" src="{{env('IMG_URL')}}{{$v->cover_url}}" alt="" class="fenimg_img">
			<div class="fen_img text_center fz color_fff">
				<h3 class="f32 bold" onclick = "window.location.href='/dist/buy/{{$v->id}}/{{$userid}}.html';">{{$v->title}}</h3>
				<p class="f26" onclick = "window.location.href='/dist/buy/{{$v->id}}/{{$userid}}.html';">{{$v->description}}</p>
				<div class="fen_btn_x">
					<ul class="clearfix">
						<li class="fl bgcolor_orange"><a href="javascript:void (0)" onclick="getImgUrl({{$userid}});" class="color_333 fz f26 ">打卡课程分享海报</a></li>
						<li class="fr bgcolor_orange"><a href="/dist/active/{{$userid}}.html" class="color_333 fz f26 ">打卡课程分享链接</a></li>
					</ul>
				</div>
			</div>
		</div>
	</li>

@endforeach