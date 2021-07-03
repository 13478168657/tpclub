@foreach($commonQuestions as $common)
    <li class="ptb30">
        <a href="/cak/answer/{{$common->id}}/2.html">
            <?php
            $answers = App\Models\CommonAskAnswer::where('qid',$common->id)->orderBy('updated_at','desc')->take(2)->get();
            $answerSum = App\Models\CommonAskAnswer::where('qid',$common->id)->select('id')->count();
            ?>
            <dl class="clearfix">
                <dt class="color_gray666 fz f24 fl">
                    <span>{{$common->view}}</span>
                    <span>阅读</span>
                </dt>
                <dd class="fr">
                    <h3 class="f32 color_333 fz bold text-overflow2">{{$common->title}}</h3>
                    <div class="weui-cell padding0 mt0 noafter nobefore">
                        <div class="weui-cell__bd fz f24 color_gray9b text-overflow">
                            <p>
                                @foreach($answers as $answer)
                                    <span>{{$answer->user?$answer->user->nickname:''}}</span>
                                @endforeach
                                等{{$answerSum}}人参与讨论
                            </p>
                        </div>
                        <div class="weui-cell__ft">{{App\Constant\CommentDate::getDate($common->updated_at)}}</div>
                    </div>
                </dd>
            </dl>
        </a>
    </li>
@endforeach