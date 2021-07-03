@if(count($question)>0)
	@foreach($question as $v)
		<li>
			<!--提问-->
			<a href="javascript:void (0)" class="fz ptb30">
				<h3 class="f32 color_gray666 bold text-jus"><img src="/images/ask/wen.png" alt="">{{$v->title}}</h3>
				<p class="f28 color_gray999 text-jus mt10">{{$v->description}}</p>
				<div class="imgs hide ImgMax">
					<?php
					$imgList = $v->imgurl_list;
					$imgArr = explode(",",$imgList);
					array_pop($imgArr);
					$askUser = App\User::where('id',$v->user_id)->first();
					if($askUser){
						$askName = $askUser->name?$askUser->nickname:'';
					}else{
						$askName = '';
					}
					?>
					@if($imgList !== '' && !is_null($imgList))
							<ul class="clearfix post">
								@foreach($imgArr as $a)
									<li><img src="{{env('IMG_URL')}}{{$a}}" class="img100" onclick="slidePhoto(this);"/></li>
								@endforeach
							</ul>
					@endif
				</div>
				<div class="weui-cell noafter nobefore padding0 f26 color_gray9b mt26">
					<div class="weui-cell__bd">
						@if($askName)
							<p>{{$askName}}&nbsp;&nbsp;{{date("Y.m.d",strtotime($v->created_at))}}</p>
						@else
							<p>{{date("Y.m.d",strtotime($v->created_at))}}</p>
						@endif
					</div>
					@if($imgList !== '' && !is_null($imgList))
						<div class="weui-cell__ft btn_open">展开</div>
					@endif
				</div>
			</a>
			<?php
			$answer = DB::table("ask_answer")->where("qid",$v->id)->first();	//答案
			if(count($answer)>0){
				$users = DB::table("users")->where("id",$answer->author_id)->select("name","introduction","avatar","nickname")->first();
			}

			?>
			@if(count($answer) > 0 )
					<!--回答-->
			<div class="fiele_list_tea_da pt40">
				<a class="weui-cells  noafter nobefore padding0 mt0 no_b_border">
					<div class="weui-cell noafter nobefore padding0 ">
						<div class="weui-cell__hd">

							@if(count($users)>0)
								@if(strpos($users->avatar,'http') !== false)
									<img src="{{$users->avatar}}" class="border-radius50">
								@else
									<img src="{{env('IMG_URL')}}{{$users->avatar}}" class="border-radius50">

								@endif
							@else
								<img src="/images/ask/Group.png" class="border-radius50">
							@endif

						</div>
						<div class="weui-cell__bd fz">
							<p class="bold f28 color_333">@if(count($users)>0) {{$users->name == ''?$users->nickname:$users->name}} @endif<span class="f16 color_orange border-radius-img">导师</span></p>
							<p class="f26">{{$users?$users->introduction:''}}</p>
						</div>
					</div>
				</a>
				<div class="fz ptb30">
					<h3 class="f32 color_333 text-jus ConHref">
						<p class="HrefWrap" data-id="{{$v->id}}_{{$answer->id}}">
							<img src="/images/ask/da.png" alt="">{{$answer->content}}
						</p>
						<div class="read-more"></div>
					</h3>
					<p class="f24 color_gray9b mt26">{{date("Y.m.d",strtotime($answer->created_at))}}<span class="f24 color_gray9b fr"><!-- <img src="/images/ask/zan_h.png" alt="" class="fie_zan">赞同{{$answer->zan}}</span> --></p>
				</div>
			</div>
			@endif
		</li>
		<div class="bor20 mlrfu-30"></div>
	@endforeach
@endif
<script>
	$(function(){

		var slideHeight = 68; // px
		var defHeight = $('.HrefWrap').height();

		$('.HrefWrap').each(function(i){
			var defHeight = $(this).height();
//alert(defHeight);
			if(defHeight >= slideHeight){
				var askInfo = $('.HrefWrap').eq(i).attr('data-id');
				var askArr = askInfo.split('_');

				var url = '/ask/zyxiangqing/'+askArr[0]+'/'+askArr[1]+'/1.html';
				$('.ConHref').eq(i).bind('click',function(){
					window.location.href = url;
				});
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