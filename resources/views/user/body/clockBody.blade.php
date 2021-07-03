@foreach($data as $v)
    <li>
        <a href="/dist/study/{{$v->id}}.html">
            <img src="{{env('IMG_URL')}}{{$v->cover_url}}" alt="" class="img100 border-radius-img">
            <h3 class="mt30 color_333 fz bold f30 text-overflow2">{{$v->title}}</h3>
            <div class="progressBox mt20">
                {{--<div class="words f24 color_gray666">共<span>22</span>个任务，已完成<span class="color_orange">11</span>个</div>--}}
                {{--<div class="progressBar clearfix">--}}
                {{--<div class="progress">--}}
                {{--<!-- 数据库获取到22和11，循环的时候11/22*100 -->--}}
                {{--<div class="bar" style="width:50%"></div>--}}
                {{--</div>--}}
                {{--</div>--}}
            </div>
        </a>
    </li>
@endforeach