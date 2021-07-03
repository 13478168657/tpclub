@extends('layouts.header')
@section('title')
    <title></title>
    <meta name="description" content="" />
@endsection
@section('cssjs')
    <style>
        /*免费线上训练营*/
        .home_listMFXS_box{}
        .home_listMFXS_box ul li{overflow: hidden;margin-bottom: .75rem;
            -webkit-border-radius: .35rem;
            -moz-border-radius: .35rem;
            border-radius: .35rem;}
        .home_listMFXS_box ul li img{}
        .home_listMFXS_box ul li p{height: 1.5rem;line-height: 1.5rem;/*60*/}
    </style>
@endsection

@section('content')

    <div>
        <!-- 列表 start -->
        <div class="home_listMFXS_box bTop text_center pt30 pb30 plr30">
            <ul>
                @foreach($disCourses as $course)
                <li>
                    <a href="/dist/buy/{{$course->id}}.html" class="block"><img src="{{env('IMG_URL')}}{{$course->cover_url}}" alt="" class="img100"></a>
                    <p class="bgcolor_orange fz f26 color_333">{{$course->sell_point}}</p>
                </li>
                @endforeach
            </ul>
        </div>
        <!-- 列表 start -->
    </div>
    <br><br>
@endsection
@include('layouts.footer')