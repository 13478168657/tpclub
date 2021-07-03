@foreach($questions as $question)
    <li>
        <div class="weui-cell padding0 qaImg fz">
            <div class="weui-cell__hd">
                <?php
                $user = $question->user;
                ?>
                @if($user)
                    @if((strpos($user->avatar,'http') !== false))
                        <img src="{{$user->avatar}}" alt="" class="img100 border-radius50">
                    @else
                        @if(!empty($user->avatar))
                            <img src="{{env('IMG_URL')}}{{$user->avatar}}" alt="" class="img100 border-radius50">
                        @else
                            <img src="/images/my/nophoto.jpg" alt="" class="img100 border-radius50">
                        @endif
                    @endif
                @else
                    <img src="/images/my/nophoto.jpg" alt="" class="img100 border-radius50">
                @endif
            </div>
            <div class="weui-cell__bd f32">
                <?php
                $length = strlen($question->title);
                if($length >= 10){
                    $title = mb_substr($question->title,0,10).'...';
                }else{
                    $title = $question->title;
                }
                ?>
                <p class="d-in-black bold color_gray666"><a href="/cak/answer/{{$question->id}}/1.html">{{$title}}</a></p>
                {{--<p class="d-in-black ren"><img src="../images/ren.jpg" alt=""></p>--}}
                <p class="d-in-black color_gray666">提问</p>
            </div>
            <!--<div class="weui-cell__ft">5小时前</div>-->
        </div>
        <p class="qaText f34 bold fz color_333 mt20 text-jus"><a href="/cak/answer/{{$question->id}}/1.html"><?php echo htmlspecialchars_decode($question->desc);?></a></p>
    </li>
@endforeach