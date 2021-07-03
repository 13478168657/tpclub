@foreach($rankLists as $k => $stu)
    <li>
        <div class="inner">
            <a href="/fat/member/{{$stu->id}}.html" class="block">
                <span class="number font-Impact"><b>{{$stu->id}}</b></span>
                <div class="thumb">
                    <img src="{{env('IMG_URL')}}{{$stu->cover_img}}" class="img100" alt="" />
                </div>
                <div class="clearfix info mt20">
                    <div class="fl">
                        <span class="name lt">{{$stu->name}}</span>
                        <?php

                        if($stu->object == 'student'){
                            $identify = '学员';
                            $tag_color = 'tag_green';
                        }elseif($stu->object == 'teacher'){
                            $identify = '教师';
                            $tag_color = 'tag_purple';
                        }elseif($stu->object == 'staff'){
                            $identify = '员工';
                            $tag_color = 'tag_orange';
                        }else{
                            $identify = '未知';
                            $tag_color = 'tag_purple';
                        }
                        ?>
                        <label class="tag {{$tag_color}}">{{$identify}}</label>
                    </div>
                    <div class="fr lt"><span class="votesinfo">{{$stu->votes}}</span>票</div>
                </div>
            </a>
            <div class="btn mt20">
                <button class="user_vote" onclick="voteFunc(this)" data-id="{{$stu->id}}">投票</button>
            </div>
        </div>
    </li>
@endforeach