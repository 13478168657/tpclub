@foreach($friends as $k => $friend)
    <?php
    $user = $friend->user;
    ?>
    <li class="fz clearfix bold">
        <p class="f28">{{$k+1}}.</p>
        <p class="">
            @if($user->avatar)
                @if(strpos($user->avatar,'http') !== false)
                    <img class="d-in-black border-radius50" src="{{$user->avatar}}" alt="">
                @else
                    <img class="d-in-black border-radius50" src="{{env('IMG_URL')}}{{$user->avatar}}">
                @endif
            @else
                <img class="d-in-black border-radius50" src="/activity/award/images/zt/giftgive/fimg.jpg" alt="">
            @endif
        </p>
        <p class="f28 text-overflow">{{$user->name?$user->name:$user->nickname}}</p>
        <p class="f22 text_right color_gray666">{{date('Y.m.d',strtotime($friend->created_at))}}</p>
    </li>
@endforeach
