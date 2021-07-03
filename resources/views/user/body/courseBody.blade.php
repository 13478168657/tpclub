@foreach($articleCollect as $course)
<a href="/course/detail/{{$course->id}}.html">
    <li class="ptb30">
        <dl class="clearfix">
            <dt class="border-radius-img"><img src="{{env('IMG_URL')}}{{$course->cover_url}}" alt="" /><span class="bgcolor_orange text_center fz color_333">{{$course->level}}</span></dt>
            <dd>
                <h3 class="lt f30 text-overflow">{{$course->title}}</h3>
                <p class="fz color_gray666 f24">{{$course->sum_course}} 节课·{{$course->sum_study}} 人正在提高中</p>
                <!--<p class="fz color_gray999">Jane King 导师</p>-->
                <div class="weui-cells fz color_gray666 noafter mt0 nobefore">
                    <div class="weui-cell">
                        <div class="weui-cell__bd">
                            <p class="f22">{{$course->name}} 导师</p>
                        </div>
                        @if($course->is_free)
                            @if($course->sum_course == 1 || $course->preview ==0)
                                <div class="weui-cell__ft color_orange bold f28 color_red">￥{{$course->price}}</div>
                            @else
                                <div class="weui-cell__ft color_orange bold f28 color_red">可试看</div>
                            @endif
                        @else
                            <div class="weui-cell__ft color_orange bold f28">免费</div>
                        @endif
                    </div>
                </div>

                <div class="text_center fz">
                    <!-- Swiper -->
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <?php
                            echo  htmlspecialchars_decode($course->tags)
                            ?>
                        </div>
                    </div>
                </div>
            </dd>
        </dl>
    </li>
</a>    
@endforeach