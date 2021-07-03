@if($selected->count())
@foreach($selected as $item)
<div class="head-art clearfix fz">
	<dl class="fl">
		<dt class="f32 mb20 bold">每日精选</dt>
		<dd class="f20 color_gray666">每天早上10:00，与您分享</dd>
	</dl>
	<p class="fr bold"><b class="f36 mr5">{{str_replace('-', '.',$item->today)}}</b><span>期</span></p>
</div>
	<div class="art-list-content plr30 mt30" >
		<div>
			<div class="list-art">
				<ul>
					@foreach(get_articla_selected($item->article_ids) as $article)
					<li class="li-top-noborder">
						<a href="/article/detail/{{$article->id}}.html">
						<!--大图 start-->
						<div class="max-img border-radius-img mb20 relative">
							@if($article->is_video)
							<div class="new_mask"></div>
							@endif
							<img class="max-img-banner" src="{{env('IMG_URL')}}{{$article->cover_url}}" alt="{{$article->title}}" />
							@if($article->is_selected)
							<img class="icon-new-hot" src="/images/icon-hot.png" />
							@else
								@if(article_isnew($article->created_at))
								<img class="icon-new-hot" src="/images/icon-new.png" />
								@endif
							@endif
							@if($article->is_video)
							<img class="icon-bofang" src="/images/bofang.png" />
							@endif
						</div>
						<h3 class="f30 color_333 lt">{{$article->title}}</h3>
						<div class="weui-cells noafter nobefore mt0 art-list-title pb10">
							<a href="">
								<div class="weui-cell padding0">
									<div class="weui-cell__hd border-radius50">
										@if(getUsers($article->user_id))
											@if(strpos(getUsers($article->user_id)->avatar,'http') !== false)
												<img src="{{getUsers($article->user_id)->avatar}}" class="border-radius50" />
											@else
												<img src="{{env('IMG_URL')}}{{getUsers($article->user_id)->avatar}}" alt="头像" class="border-radius50" />
											@endif
										@else
										<img src="/images/my/nophoto.jpg" alt="头像" class="border-radius50" />
										@endif
									</div>
									<div class="weui-cell__bd fz f28 color_gray666 mtb20">
										<p>{{getUsers($article->user_id)->name}}
											<span class="color_gray9b f22 pl20">{{substr($article->created_at,0, 10)}}</span>
										</p>
									</div>
									<div class="weui-cell__ft fz f20 color_gray9b yudu-img">
										<span class="">
											<img src="/images/icon-xiao-xihuan.png" alt="">
											{{$article->likes}}
										</span>
										<span class="pl20">
											<img src="/images/icon-xiao-yuedu.png" alt="">
											{{$article->views}}
										</span>
									</div>
								</div>
							</a>
						</div>
						</a>
					</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
@endforeach
@endif