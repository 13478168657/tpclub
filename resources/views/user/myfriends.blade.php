@extends('layouts.header')
@section('title')
    <title>我的-好友列表{{env('WEB_TITLE')}}</title>
@endsection

@section('content')
	<link href="/css/my.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="/css/font-num40.css">
</head>
<body class="page_reg pt0" ontouchstart>
<div class="plr30" id="firend_list"><!--边距30 开始-->
	@if($list->count())
		@foreach($list as $a)
				<div class="weui-cells nobefore  mt0 myfriend-list">
					<a class="weui-cell weui-cell_access ptb44 nobefore noafter" href="javascript:;">
						<div class="weui-cell__hd">
							@if($a->avatar)
								@if(strpos($a->avatar,'http') !== false)
									<img class="border-radius50" src="{{$a->avatar}}" alt=""/>
								@else
									<img class="border-radius50" src="{{env('IMG_URL')}}{{$a->avatar}}" alt="头像" />
								@endif
							@else
							<img class="border-radius50" src="/images/my/nophoto.jpg" alt="头像" />
							@endif
						</div>
						<div class="weui-cell__bd fz">
						<p class="f32 bold color_333 pl20">{{$a->name?$a->name:"信息未完善"}}</p>
					</div>
					<div class="weui-cell__ft f24 color_333 noafter no-padding">
						<p class="fz bold">{{$a->is_reserve?'已预定':'未预定'}}</p>
						<span class="color_gray9b f20">{{$a->created_at}}</span>
					</div>
					</a>
				</div>
		@endforeach
		
	@else
		<div class="nofriend">
			<img src="/images/my/nofriend.png" alt="">
			 <p class="text_center f28 color_gray666 fz mtb45">
				 你还没有邀请好友<br>
				 快把你最喜欢的课程推荐给好友吧
			 </p>
		</div>
	@endif
</div><!--边距30 结束-->
		<!--加载更多-->
	    <div class="weui-loadmore more text_center fz ptb30">
	        <span class="weui-loadmore__tips" id="firend_more" data-is_ture='1'>加载更多</span>
	    </div>
<script src="/lib/jqweui/js/jquery-2.1.4.js"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
  $(function() {
    FastClick.attach(document.body);
  });
</script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/icheck/js/icheck.min.js"></script>
<script>
    $(document).ready(function() {
        //加载更多
        var page = 1;
        var imgUrl  = "{{env('IMG_URL')}}";
        $("#firend_more").click(function(){
            page++;
            var type   = 'courseclass';
            var user_id= {{$user_id}};
            //如果没有数据就不再请求数据库了
            var is_ture= $(this).attr('data-is_ture');
            if(is_ture<1){
                layer.msg('已经到底啦~');
                return;
            }
            $.ajax({
                type:"GET",
                url:"/user/friendsmore",
                data:{user_id:user_id, page:page},
                dataType:"json",
                success:function(result){
                    console.log(result.list);
                    if(result.code==1){
                        for (var item in result.list) {
                        	if((result.list[item].avatar).indexOf("http") > -1){
                                var img = result.list[item].avatar;
                            }else{
                                var img = imgUrl+result.list[item].avatar;
                            }
                            if(result.list[item].name){
                                var name = result.list[item].name;
                            }else{
                                var name = "--";
                            }
                            if(result.list[item].is_reserve==1){
                            	var is_reserve = "已预定";
                            }else{
                            	var is_reserve = "未预定";
                            }
                            $("#firend_list").append('<div class="weui-cells nobefore  mt0 myfriend-list">'+
								'<a class="weui-cell weui-cell_access ptb44 nobefore noafter" href="javascript:;">'+
								'<div class="weui-cell__hd">'+
								'<img class="border-radius50" src="'+img+'" alt="'+name+'"/>'+
								'</div>'+
								'<div class="weui-cell__bd fz">'+
								'<p class="f32 bold color_333 pl20">'+name+'</p>'+
								'</div>'+
								'<div class="weui-cell__ft f24 color_333 noafter no-padding">'+
								'<p class="fz bold">'+is_reserve+'</p>'+
								'<span class="color_gray9b f20">'+result.list[item].created_at+'</span>'+
								'</div>'+
								'</a>'+
								'</div>');
                        }    
                    }else{
                        $("#firend_more").attr('data-is_ture', 0);
                        $("#firend_more").text('已经到底啦~');
                        layer.msg(result.msg);
                    }
                }
            });
        });
    });
</script>
@endsection
