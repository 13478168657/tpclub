@foreach($activeUsers as $k => $activeUser)
    <?php
    $user = $activeUser->user;
    ?>
    <li class="fz clearfix bold">
        <p class="f28">{{$rank+$k+1}}.</p>
        <p class="">
            @if($user->avatar)
                @if(strpos($user->avatar,'http') !== false)
                    <img class="d-in-black border-radius50 radius-img-te" src="{{$user->avatar}}" alt="">
                @else
                    <img class="d-in-black border-radius50 radius-img-te" src="{{env('IMG_URL')}}{{$user->avatar}}">
                @endif
            @else
                <img class="d-in-black border-radius50 radius-img-te" src="/activity/award/images/zt/giftgive/fimg.jpg" alt="">
            @endif
        </p>
        <p class="f28 text-overflow">{{$user->name?$user->name:$user->nickname}}</p>
        <p class="f22 color_gray666">{{date('Y.m.d',strtotime($activeUser->updated_at))}}</p>
        <p class="f28 text_right">￥{{$activeUser->invite_num*100}}</p>
    </li>
@endforeach