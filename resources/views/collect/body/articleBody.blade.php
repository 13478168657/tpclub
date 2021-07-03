@foreach($articleCollect as $article)
    <?php

    $art = $article->article;
    if(!$art){
        continue;
    }
    ?>
    <li class="pt30 pb30">
        <a href="/article/detail/{{$art->id}}.html">
            <dl class="clearfix relative">
                <dt class="border-radius-img"><img src="{{env('IMG_URL')}}{{$art->cover_url}}" alt="" /></dt>
                <dd>
                    <h3 class="lt f30 color_333 text-overflow2 text-overflow">{{$art->title}}</h3>
                    <div class="weui-cells nobefore noafter padding0 art-list-title mt0">
                        <div class="weui-cell nobefore noafter padding0 mt20">
                            <div class="weui-cell__hd border-radius50">
                                @if($art->author)
                                    @if(strpos($art->author->avatar,'http') !== false)
                                        <img src="{{$art->author->avatar}}">
                                    @else
                                        <img src="{{env('IMG_URL')}}{{$art->author->avatar}}">
                                    @endif
                                @else
                                    <img src=""/>
                                @endif
                            </div>
                            <div class="weui-cell__bd f28 fz color_gray666 ">
                                <p>{{$art->author?$art->author->name:''}}</p>
                            </div>
                        </div>
                        <div class="weui-cell nobefore noafter padding0 mt10">
                            <div class="weui-cell__bd">
                                <p class="color_gray9b f22 fz">{{date('Y.m.d',strtotime($article->created_at))}}</p>
                            </div>
                            <div class="weui-cell__ft fz f20 color_gray9b yudu-img">
                                <span class=""><img src="/images/icon-xiao-xihuan.png" alt="">{{$art->likes}}</span>
                                <span class="pl20"><img src="/images/icon-xiao-yuedu.png" alt="">{{$art->views}}</span>
                            </div>
                        </div>
                    </div>
                </dd>
            </dl>
        </a>
    </li>
@endforeach
