@foreach($answers as $answer)

    <li>
        <div class="weui-cell head">
            <div class="weui-cell__bd">
                <a href="#" class="user_photo">
                    <?php
                    $user = $answer->user;
                    ?>
                    @if($user)
                        @if((strpos($user->avatar,'http') !== false))
                            <img src="{{$user->avatar}}" alt="" class="img100 border-radius50">
                        @else
                            <img src="{{env('IMG_URL')}}{{$user->avatar}}" alt="" class="img100 border-radius50">
                        @endif
                    @else
                        <img src="/images/my/nophoto.jpg" alt="" class="img100 border-radius50">
                    @endif
                </a>
                <dl>
                    <dt>{{$answer->user->nickname}}</dt>
                    <dd>{{$answer->user->introduction?$answer->user->introduction:'还没完成自我介绍'}}</dd>
                </dl>
                <a href="/cak/comment/{{$answer->id}}.html">
                    <div class="ConHref mt20">
                        <h3 class="HrefWrap f28 text-jus fz" data-id="{{$answer->id}}_1">{{$answer->content}}</h3>
                        <div class="read-more"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="weui-flex pices">
            <?php
            $imgArr = [];
            if($answer->imgurl_list != null && $answer->imgurl_list != ''){
                $img_url = explode(',',$answer->imgurl_list);
            }
            ?>
            <a href="/cak/comment/{{$answer->id}}.html">
                @foreach($imgArr as $img)
                    <div class="weui-flex__item"><img src="{{env("IMG_URL")}}{{$img}}" alt="" class="img100"></div>
                @endforeach
            </a>
        </div>
        <div class="weui-cell foot">
            <div class="weui-cell__bd">
                <span class="date color_gray9b">{{date('Y.m.d',strtotime($answer->updated_at))}}</span>
            </div>
            <div class="weui-cell__ft color_gray9b f24">
                <a href="/cak/comment/{{$answer->id}}.html">
                    <div class="pl">{{$answer->getTotalComment()}}评论</div>
                    <div class="zt">赞同{{$answer->getTotalZan()}}</div>
                </a>
            </div>
        </div>
    </li>
@endforeach