@extends('layouts.header')
@section('title')
    <title>我的优惠券{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link href="/css/my.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
</head>
<body ontouchstart>
<div>
	<!-- 我的优惠券立即使用 -->

	@foreach($list as $k)
    @if($k->is_use==1)
      <div class="mycoupon plr30 mb20">
        <div class="weui-cells nobefore noafter mt0 padding0 bgcolor_gray">
            <a class="weui-cell weui-cell_access nobefore noafter mt0 padding0 coupon coupon1" href="javascript:;">
              <div class="weui-cell__bd text_center color_4a">
                <p class="lt f34">{{$k->title}}</p>
                <p class="fz f24">优惠券有效期{{$k->days}}天</p>
              </div>
              <div class="weui-cell__ft noafter text_center now_use now_ysy">
                <p class="lt f44 color_gray9b mb40 pb10">{{$k->days}}天</p>
                <span class="my_used"><img src="/images/my/icon-yishiyong.png" alt="体验卡" class="img100"></span>
              </div>
            </a>
        </div>
      </div>
	  @else
    	<!-- 我的优惠券已使用 -->
      <div class="mycoupon plr30 mb20">
        <div class="weui-cells nobefore noafter mt0 padding0 bgcolor_gray">
            <a class="weui-cell weui-cell_access nobefore noafter mt0 padding0 coupon" href="{{$k->url}}">
              <div class="weui-cell__bd text_center color_4a">
                <p class="lt f34">{{$k->title}}</p>
                <p class="fz f24">优惠券有效期{{$k->days}}天</p>
              </div>
              <div class="weui-cell__ft noafter text_center">
                <!-- <p class="lt f44 color_000">{{$k->days}}天</p> -->
                <span class="fz f24 color_4a span_btn">立即使用</span>
              </div>
            </a>
        </div>
      </div>
    @endif 
  @endforeach
</div>

<script src="/lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
  $(function() {
    FastClick.attach(document.body);
  });
</script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script>
    $(".span_btn_coupon").click(function(){
        var attr = $(this).attr("data-attr");
		var type = $(this).attr("type-attr");
		console.log(type);
        $.get("/user/record_coupon/",{id:attr},function(data){
              console.log(data);
              if(data == 1){
                  $(".coupon_y_"+attr).text("正在使用");
				  window.location.href = "/course/type/"+type+".html";
              }
          });
        
    })
</script>
@endsection