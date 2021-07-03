<!---导航右侧带导航弹出---->  
@extends('layouts.header')
@section('title')
    <title>开始直播{{env('WEB_TITLE')}}</title>
@endsection

@section('cssjs')
    <link href="/css/live.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div id="page">
	<!--导航大盒子id=page 开始  【结束在最底部】-->
	<div class="page_tags page_article bgcolor_fff fz">
		<div class="plr30 bgcolor_fff fz mb40">
			<h3 class="color_333 f30">直播主题</h3>
			<div class="inputWrap">
				<input type="text" class="input kc_input" placeholder="运动健康的必要前提" name="live_title" />
			</div>
			<h3 class="color_333 f30">开始时间</h3>
			
			 <div class="weui-cells weui-cells_form nobefore noafter">
			 	<div class="weui-cell padding0 select">
    		    	<div class="weui-cell__hd"><label for="time-format" class="weui-label">开始时间</label></div>
    		    	<div class="weui-cell__bd relative">
    		    		<img src="/images/arrow_down.png" alt="">
    		      		<input class="weui-input" id="time-format" type="text" value="" name="live_stime" />
    		   	 	</div>
    			</div>
			 </div>

		</div>
		<div class="plr30 pt40">
			<span class="btn1 fz bgcolor_orange text_center f34 live_submit">确认</span>
		</div>
	</div>
	<!--边距30 end-->
</div>
<!--导航大盒子id=page 结束-->



<script src="/lib/jqweui/js/jquery-2.1.4.js" type="text/javascript"></script>
<script src="/lib/jqweui/js/fastclick.js"></script>
<script>
  $(function() {
    FastClick.attach(document.body);
  });
</script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<!--end-->

<script type="text/javascript">
	$('html,#page').css('background','#fff');
</script>
<script>
    $("#time-format").datetimePicker({
        title: '自定义格式',
        yearSplit: '年',
        monthSplit: '月',
        dateSplit: '日',
        times: function () {
          return [  // 自定义的时间
            {
              values: (function () {
                var hours = [];
                for (var i=0; i<24; i++) hours.push(i > 9 ? i : '0'+i);
                return hours;
              })()
            },
            {
              divider: true,  // 这是一个分隔符
              content: '时'
            },
            {
              values: (function () {
                var minutes = [];
                for (var i=0; i<59; i++) minutes.push(i > 9 ? i : '0'+i);
                return minutes;
              })()
            },
            {
              divider: true,  // 这是一个分隔符
              content: '分'
            }
          ];
        },
        onChange: function (picker, values, displayValues) {
          console.log(values);
        }
      });

    $(document).ready(function(){
       $(".live_submit").click(function(){
          var live_title = $("input[name='live_title']").val();
          var live_stime = $("input[name='live_stime']").val();
          if(live_title==""){
            layer.msg("请填写直播主题");
            return;
          }
          if(live_stime==""){
            layer.msg("请选择开始时间");
            return;
          }
       });
    });
</script>
@endsection