@if($is_question == 1)
@foreach($question as $v)
<li>
	<a href="javascript:void (0)" class="fz ptb30">
		<h3 class="f32 color_333 bold text-jus">{{$v->title}}</h3>
		<p class="f28 color_gray666 text-jus mt10">{{$v->description}}</p>
		<div class="imgs hide ImgMax mt30">
			<?php
			$imgList = $v->imgurl_list;
			$imgArr = explode(",",$imgList);
			array_pop($imgArr);

			?>
			<ul class="clearfix post">
				@if(!is_null($imgList) && $imgList !== '')
					@foreach($imgArr as $a)
						<li><img src="{{env('IMG_URL')}}{{$a}}" class="img100" onclick="slidePhoto(this);" /></li>
					@endforeach
				@endif
			</ul>
		</div>
		<div class="weui-cell noafter nobefore padding0 f26 color_gray9b mt26"><div class="weui-cell__bd">
		<p>{{$v->view}}阅读· {{date("Y.m.d",strtotime($v->created_at))}}</p>
		</div>
		@if(!is_null($imgList) && $imgList !== '')
			<div class="weui-cell__ft " onclick="btn_open(this);">展开</div>
		@endif
		</div>
	</a>
</li>
@endforeach
	@else
	@foreach($question as $v)
	<li>
		<a href="/ask/zuoye/{{$v->id}}/1/{{$can}}.html" class="fz ptb30">
			<h3 class="f32 color_333 bold text-jus">{{$v->title}}</h3>
			<p class="f24 color_gray9b">{{$v->view}}阅读· {{$v->ans_num}}回答 &nbsp;&nbsp;{{$v->approve_num}}回答被导师认可
				<span class="text_right fr">{{date("Y.m.d",strtotime($v->created_at))}}</span>
			</p>
		</a>
	</li>
	@endforeach
@endif
<script>
	/*swiper弹出大图并轮播 start*/
	$(document).ready(function () {
		/*调起大图 S*/
		var mySwiper = new Swiper('.swiper-container2', {
			loop: false,
			pagination: '.swiper-pagination',
			paginationType: 'fraction'
		})
		$(".ImgMax").on("click", ".post img",
				function () {
					var imgBox = $(this).parents(".post").find("img");
					var i = $(imgBox).index(this);
					$(".big_img .swiper-wrapper").html("");

					for (var j = 0, c = imgBox.length; j < c; j++) {
						$(".big_img .swiper-wrapper").append('<div class="swiper-slide"><div class="cell"><img src="' + imgBox.eq(j).attr("src") + '" / ></div></div>');
					}
					mySwiper.updateSlidesSize();
					mySwiper.updatePagination();
					$(".big_img").css({
						"z-index": 1001,
						"opacity": "1"
					});
					mySwiper.slideTo(i, 0, false);
					return false;
				});

		$(".big_img").on("click",
				function () {
					$(this).css({
						"z-index": "-1",
						"opacity": "0"
					});
				});
	});
	/*调起大图 E*/
</script>