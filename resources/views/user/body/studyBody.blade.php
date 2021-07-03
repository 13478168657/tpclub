@foreach ($course_lists as $v)
    <?php
    $studyFinish = App\Models\CourseActivityView::where('course_class_id',$v->id)->where('user_id',$userid)->where('finished',1)->count();
    ?>
    <a href="/course/detail/{{$v->id}}.html">
        <li>
            <dl class="clearfix">
                <dt class="border-radius-img"><img src="{{env('IMG_URL')}}{{$v->cover_url}}" alt="" /><span class="text_center bgcolor_orange">{{$v->level}}</span></dt>
                <dd>
                    <h3 class="fz f30 bold text-overflow2">{{$v->title}}</h3>
                    <p class="fz f24 color_4a">{{$v->name}}导师</p>
                    <div class="pos_dd">
                        <div class="progressBox">
                            <div class="clearfix words_box">
                                <div class="words f24 color_gray666">共<span>{{$v->sum_course}} </span>个任务，已完成<span class="color_orange">{{$studyFinish}}</span>个
                                </div>
                            </div>
                            <?php
                            $percent = round($studyFinish/$v->sum_course,2)*100;
                            ?>
                            <div class="progressBar clearfix">
                                <div class="progress">
                                    <!-- 数据库获取到22和11，循环的时候11/22*100 -->
                                    <div class="bar" style="width:{{$percent}}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </dd>
            </dl>
        </li>
    </a>
@endforeach