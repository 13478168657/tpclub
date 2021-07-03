@if($cid == 0)
    <li class="first_data{{$comment->id}}">
        <div class="pl_item ">
            <div class="clearfix">
                <a href="#" class="user_photo">
                    <?php
                    $user = $comment->user;
                    ?>
                    @if($user)
                        @if((strpos($user->avatar,'http') !== false))
                            <img src="{{$user->avatar}}" alt="" class="img100 border-radius50">
                        @else
                            @if($user->avatar)
                                <img src="{{env('IMG_URL')}}{{$user->avatar}}" alt="" class="img100 border-radius50">
                            @else
                                <img src="/images/my/nophoto.jpg" alt="" class="img100">
                            @endif
                        @endif
                    @else
                        <img src="/images/my/nophoto.jpg" alt="" class="img100 border-radius50">
                    @endif
                </a>
                <div class="info fl">
                    <span class="f32 bold name">{{$comment->user->name?$comment->user->name:$comment->user->nickname}}</span>
                    <span class="f24 color_gray9b date">{{date('Y-m-d H:i:s',strtotime($comment->updated_at))}}</span>
                </div>
                <div class="btn_reply fr open-popup" onclick="two_open(this);" first_key="{{$comment->id}}" author_name="{{$comment->user->name?$comment->user->name:$comment->user->nickname}}" data-content="{{$comment->content}}" data-cid="{{$comment->id}}" data-user="{{$user->id}}" author_id ="{{$comment->id}}" data-level="2"><span>回复</span>
                </div>
            </div>
            <p class="cont">{{$comment->content}}</p>
        </div>
    </li>
@else
    <div class="hf_item bgcolor_f9f9f9">
        <div class="clearfix">
            <a href="#" class="user_photo">
                <?php
                $user = $comment->user;
                ?>
                @if($user)
                    @if((strpos($user->avatar,'http') !== false))
                        <img src="{{$user->avatar}}" alt="" class="img100 border-radius50">
                    @else
                        @if($user->avatar)
                            <img src="{{env('IMG_URL')}}{{$user->avatar}}" alt="" class="img100 border-radius50">
                        @else
                            <img src="/images/my/nophoto.jpg" alt="" class="img100">
                        @endif
                    @endif
                @else
                    <img src="/images/my/nophoto.jpg" alt="" class="img100 border-radius50">
                @endif
            </a>
            <?php
            $content_arr = explode(" ",$comment->content);
            if(isset($content_arr[2])){
                $allName = trim($content_arr[0].$content_arr[1],'@');
            }else{
                $allName = trim($content_arr[0],'@');
            }
            $cont = str_replace("@".$allName.' ',"",$comment->content);
            $replyName = $allName;
            ?>
            <div class="info fl">
                <span class="f32 bold name">{{$user->name?$user->name:$user->nickname}}</span>
                {{--<em class="f24 color_gray9b date">回复</em>--}}
                {{--<span class="f32 bold name ml20">{{$replyName}}</span>--}}
            </div>
        </div>
        {{--<p class="cont">{{$cont}}</p>--}}
        <?php
        $replyedComment = App\Models\CommonAskComment::where('id',$comment->replyed_id)->first();
        ?>
        <p class="cont">{{$cont}}<span class="ml10">//<b class="bold mr10">@<?php echo $replyName;?></b>{{$replyedComment?$replyedComment->reply_content:''}}</span></p>
        <div class="ptb30 clearfix">
            <span class="date_hf f24 color_gray9b fl">{{date("Y.m.d",strtotime($comment->created_at))}}</span>
            <span class="btn_reply2 fl open-popup" onclick="two_open(this);" first_key="{{$cid}}" author_name="{{$user->name?$user->name:$user->nickname}}" data-content="{{$cont}}" author_id="{{$cid}}" data-user="{{$user->id}}" data-cid="{{$comment->id}}" data-level="2">回复</span>
            @if($user_id == $comment->user_id)
                <span data-id="{{$comment->id}}" class="btn_reply2 fl ml20" onclick="delComment(this);">删除</span>
            @endif
        </div>
    </div>
@endif