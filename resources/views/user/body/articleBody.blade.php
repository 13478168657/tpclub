@foreach($articleCollect as $article)
@if(is_question($article->type_ids)==0)
    <li class="pt30 pb30">
        <a href="/article/detail/{{$article->id}}.html">
            <dl class="clearfix relative">
                <dt class="border-radius-img"><img src="{{env('IMG_URL')}}{{$article->cover_url}}" alt="" />
                    @if($article->state == 2)
                    <span class="color_fff">待审核</span>
                    @endif
                </dt>
                <dd>
                    <h3 class="lt f30 color_333 text-overflow2 text-overflow">{{$article->title}}</h3>
                    <div class="weui-cells nobefore noafter padd$articleing0 art-list-title mt0">
                        <div class="weui-cell nobefore noafter padding0 mt10">
                            <div class="weui-cell__hd">
                                @if($article->author)
                                    @if(strpos($article->author->avatar,'http') !== false)
                                        <img src="{{$article->author->avatar}}" class="border-radius50">
                                    @else
                                        <img src="{{env('IMG_URL')}}{{$article->author->avatar}}" class="border-radius50">
                                    @endif
                                @else
                                    <img src="" class="border-radius50"/>
                                @endif
                            </div>
                            <div class="weui-cell__bd f28 fz color_gray666 ">
                                <p>{{$article->author?$article->author->name:''}}</p>
                            </div>
                        </div>
                        <div class="weui-cell nobefore noafter padding0">
                            <div class="weui-cell__bd">
                                <p class="color_gray9b f22 fz">{{date('Y.m.d',strtotime($article->created_at))}}</p>
                            </div>
                            <div class="weui-cell__ft fz f20 color_gray9b yudu-img">
                                <span class=""><img src="/images/icon-xiao-xihuan.png" alt="">{{$article->likes}}</span>
                                <span class="pl20"><img src="/images/icon-xiao-yuedu.png" alt="">{{$article->views}}</span>
                            </div>
                        </div>
                    </div>
                </dd>
            </dl>
        </a>
    </li>
@endif    
@endforeach