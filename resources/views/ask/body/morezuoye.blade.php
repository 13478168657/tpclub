@foreach($comment as $v)
<li>
	<div class="pl_item">
		<div class="clearfix">
			<?php
				$all = get_teacher_name($v->user_id);
			?>
			<a href="#" class="user_photo">
				@if((strpos($all->avatar,'http') !== false))
					<img src="{{$all->avatar}}" alt="" class="img100">
				@else
					<img src="{{env('IMG_URL')}}{{$all->avatar}}" alt="" class="img100">
				@endif

			</a>
			<div class="info fl">
				<span class="f32 bold name">{{$all->name?$all->name:$all->nickname}}</span>
				<span class="f24 color_gray9b date">{{date("Y.m.d",strtotime($v->created_at))}}</span>
			</div>
			<div class="btn_reply fr open-popup" onclick="two_open(this);" first_key="{{$v->id}}" author_name = "{{$all->name?$all->name:$all->nickname}}" author_id = "{{$v->id}}" data-level="2"><span>回复</span></div>
		</div>
		<p class="cont">{{$v->content}}</p>
	</div>
	<!--二级回复-->
	<?php
		$two = DB::table("ask_comment")->where("aid",$v->aid)->where("level",2)->orderBy("created_at","desc")->where("cid",$v->id)->limit(3)->get();

	?>
	@if(count($two) > 0)
		@foreach($two as $a)
			<?php
				$all2 = get_teacher_name($a->user_id);
			?>

			<div class="hf_item bgcolor_f9f9f9">
				<div class="clearfix">
					<a href="#" class="user_photo">
						@if((strpos($all2->avatar,'http') !== false))
							<img src="{{$all2->avatar}}" alt="" class="img100">
						@else
							<img src="{{env('IMG_URL')}}{{$all2->avatar}}" alt="" class="img100">
						@endif

					</a>
					<div class="info fl">
						<span class="f32 bold name">{{$all2->name?$all2->name:$all2->nickname}}</span>
						<em class="f24 color_gray9b date">回复</em>
						<span class="f32 bold name ml20">{{$all->name?$all->name:$all->nickname}}</span>
					</div>
				</div>
				<p class="cont">{{$a->content}}</p>
				<div class="ptb30 clearfix">
					<span class="date_hf f24 color_gray9b fl">{{date("Y.m.d",strtotime($a->created_at))}}</span>
					{{--<span class="btn_reply2 fl open-popup" data-target="#full">回复</span>--}}
				</div>
			</div>
		@endforeach
	@endif
	<!--////////////////////////////--->
</li>
@endforeach