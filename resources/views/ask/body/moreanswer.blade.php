@foreach($answer as $v)
	<li>
		<?php
		$user = DB::table("users")->where("id",$v->user_id)->select("name","nickname","avatar","introduction")->first();
		?>
			<div class="weui-cell head noafter nobefore padding0 mt0 no_b_border">
				<div class="weui-cell__hd">
					@if(count($user) > 0)
						@if((strpos($user->avatar,'http') !== false))
							<img src="{{$user->avatar}}" class="border-radius50" style="width:2rem;margin-right:.5rem;">
						@else
							<img src="{{env('IMG_URL')}}{{$user->avatar}}" class="border-radius50" style="width:2rem;margin-right:.5rem;">
						@endif
					@endif
				</div>
				<div class="weui-cell__bd">
					<p class="fz f28 bold color_333 mt0 text-overflow" >{{$user?$user->nickname:''}}</p>
					<p class="fz f26 mt0">{{$user?$user->introduction:''}}</p>
				</div>
				<div class="weui-cell__ft color_gray9b">{{date("Y.m.d",strtotime($v->created_at))}}</div>
			</div>
			<div class="ConHref mt20">
				<h3 class="HrefWrap f28 text-jus fz line16" data-id="{{$v->qid}}_{{$v->id}}_{{$can}}">{{$v->content}}</h3>
				<div class="read-more"></div>
			</div>
		<div class="weui-flex pices  mt30">
			<?php
			$imgList = $v->imgurl_list;
			$imgArr = explode(",",$imgList);
			array_pop($imgArr);
			$comment_num = DB::table("ask_comment")->where("aid",$v->id)->count();
			?>
			@if($imgList !== '')
				@foreach($imgArr as $a)

					<div class="weui-flex__item"><img src="{{env('IMG_URL')}}{{$a}}" alt="" class="img100"></div>
				@endforeach
			@endif

		</div>
		<div class="weui-cell foot" onclick="window.location.href='/ask/zuoyedetail/{{$v->qid}}/{{$v->id}}/{{$can}}.html';">
			<div class="weui-cell__bd">
				<a href="javascript:;" class="color_gray666 f26">查看详情</a>
				@if($v->is_approve > 0) <img src="/images/tea_rk.png" class="biaoqian" alt=""> @endif
			</div>
			<div class="weui-cell__ft color_gray9b f24">
				<div class="pl">评论{{$comment_num}}</div>
				<div class="zt">赞同{{$v->zan}}</div>
			</div>
		</div>
	</li>
@endforeach
<script>
	/*超出出现【全文】*/
	$(function(){

		var slideHeight = 68; // px
		var defHeight = $('.HrefWrap').height();

		$('.HrefWrap').each(function(i){
			var defHeight = $(this).height();
//alert(defHeight);
			if(defHeight >= slideHeight){
				$('.ConHref').bind('click',function(){
//					window.location.href="http://www.baidu.com"
				});
				var askInfo = $('.HrefWrap').eq(i).attr('data-id');
				var askArr = askInfo.split('_');
				var url = '/ask/zuoyedetail/'+askArr[0]+'/'+askArr[1]+'/'+askArr[2]+'.html';
				$('.HrefWrap').eq(i).css('height' , slideHeight + 'px');
				$('.HrefWrap').eq(i).next('.read-more').html('<a href="'+url+'">...全文</a>');
				$('.HrefWrap').eq(i).next('.read-more a').click(function(){
					var curHeight = $('.HrefWrap').height();
					//console.log(333)
					if(curHeight == slideHeight){
						//					window.location.href="http://www.baidu.com"
					}else{

					}
					return false;
				});
			}else{

			}
		})

	});
</script>