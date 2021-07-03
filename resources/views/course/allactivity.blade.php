@extends('layouts.header')
@section('title')
    <title>学院-全部活动{{env('WEB_TITLE')}}</title>
    <meta name="description" content="" />
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/xueyuan.css">
    <style>
        #page {padding-bottom:3rem;}
    </style>
@endsection
@section('content') 
<!--全部活动 start-->
<div>
  @if($activity)
    @foreach($activity as $item)
    <div class="plr30 pt30 bgcolor_fff">
       <div class="max-img border-radius-img mb20 mt10">
          <a href="{{$item->link}}">
           <img class="max-img-banner" src="{{env('IMG_URL')}}{{$item->cover_url}}" alt="{{$item->title}}">
          </a> 
       </div>
       <h3 class="f30 color_333 lt">线上免费课程 你想要减脂吗？线上免费课程 你想要减脂吗？</h3>
       <div class="weui-cells noafter nobefore mt0 pb30">
           <div class="weui-cell padding0 mt10">
               <div class="weui-cell__bd fz f20 color_gray666">
                   <span class="f24 d-in-black mr20">活动时间：{{substr($item->created_at,0, 10)}}</span>
               </div>
                  @if($item->state==1)
                  <div class="weui-cell__ft fz f24 border-radius-img all-hd-btn bgcolor_orange">
                   <p class="color_333">进行中</p>
                  </div>
                  @else
                  <div class="weui-cell__ft fz f24 border-radius-img all-hd-btn bgcolor-C9C7C7">
                    <p class="color_fff">已结束</p>
                  </div>
                  @endif 
           </div>
       </div>
   </div>
    <!--20px 的线-->
    <div class="solidtop20"></div>
    @endforeach
  @endif
</div>
<!-- 全部活动 end -->
@endsection