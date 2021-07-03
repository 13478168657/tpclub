@foreach($data as $v)
	<li class="ptb30">
		<div class="weui-cell noafter nobefore padding0">
			<div class="weui-cell__hd">
				<?php
				$user = getUsers($v->user_id);
				?>
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
			<div class="weui-cell__bd fz f32 color_333 bold">
				{{--<p>{{$v->name?$v->name:'匿名'}}</p>--}}
				@if(count($user))
					@if($user->nickname == '')
						{{$user->name}}
					@else
						{{$user->nickname}}
					@endif
				@endif
			</div>
			<div class="weui-cell__ft fz f26 color_333 time">{{$v->is_reserve == 0?'未预定':'已预定'}}<span class="color_gray9b f20">{{date("Y/m/d",strtotime($v->created_at))}}</span></div>
		</div>
	</li>
@endforeach