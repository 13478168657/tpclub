@foreach($userSorts as $sort)
    <li class="clearfix pt20 pb20">
        <div class="yq_phb_user fl lt f28 color_333">
            @if($sort->user)
                @if(strpos($sort->user->avatar,'http') !== false)
                    <img src="{{$sort->user->avatar}}">
                @else
                    <img src="{{env('IMG_URL')}}{{$sort->user->avatar}}">
                @endif
            @else
                <img src="/images/my/nophoto.jpg" class="border-radius50"/>
            @endif
            {{$sort->user?$sort->user->nickname:'暂无昵称'}}
        </div>
        <p class="fr fz color_gray666 f26">已邀请{{$sort->reserve_num}}人</p>
    </li>
@endforeach