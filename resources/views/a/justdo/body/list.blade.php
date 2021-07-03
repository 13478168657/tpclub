
@foreach($activeUsers as $activeUser)
    <?php

    $voteNum = $activeUser->invite_num;
    $day = date('Ymd');
    $isVote = App\Models\WechatActivityHand::where('sponsor_id',$user_id)->where('user_id',$activeUser->user_id)->where('day',$day)->select('id')->first();
    $introActive = $activeUser->getActiveInfo($activeUser->user_id,'DOIT');
    $userInfo = json_decode($introActive->user_info);
    $name = $userInfo->name;
//    $imgInfo = getimagesize(env('IMG_URL').$userInfo->cover_img);
//    list($width, $height, $type, $attr) = $imgInfo;
    $height = isset($userInfo->img_height)?$userInfo->img_height:150;
    $width = isset($userInfo->img_width)?$userInfo->img_width:150;
    $height1 = (177*$height)/$width;
    ?>
    <div class="grid-item">
        <div class="info">
            <div class="pic">
                <a href="/jdt/active/center/{{$activeUser->user_id}}.html">
                    <img style="height: {{$height1}}px;" src="{{env('IMG_URL')}}{{$userInfo->cover_img}}" alt="" class="img100">
                    <p class="mask"></p>
                    <p class="live"></p>
                </a>
            </div>
            <div class="title fz bgcolor_fff">
                <div class="clearfix t_name">
                    <p class="fl f30 bold color_333">{{$name}}</p>
                    <p class="fr f22 color_orange_ff6600 text_right"><span class="pu_num block">{{$voteNum}}</span>票</p>
                </div>
                <p class="f24 text-overflow2 color_333 text-jus js">{{$userInfo->company}}</p>
                <div class="btns clearfix f28">
                    @if($isVote)
                        <button class="fl toupiao bgcolor_gray_ebebeb" onclick="num_jia(this);" disabled="disabled">已投</button>
                    @else
                        <button data-id="{{$activeUser->user_id}}" class="fl toupiao bgcolor_orange" onclick="num_jia(this);">投票</button>
                    @endif
                    <button data-id="{{$activeUser->user_id}}" class="fr lapiao">拉票</button>
                </div>
            </div>
        </div>
    </div>
@endforeach