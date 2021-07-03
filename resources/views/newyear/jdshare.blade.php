@extends('layouts.header')
@section('title')
    <title>弹窗</title>
@endsection

@section('cssjs')
    <link rel="stylesheet" href="/css/newyear_reset.css">
    <link rel="stylesheet" href="/css/newyear_index.css">
    <script>
        (function(){
            var html = document.documentElement;
            var hWidth = html.getBoundingClientRect().width;
            html.style.fontSize = hWidth/18.75 + "px";
        })()
    </script>
    <script>
        var ua = navigator.userAgent.toLowerCase();
        var isWeixin = ua.indexOf('micromessenger') != -1;
        if (!isWeixin) {
            window.location.href = "http://m.saipubbs.com/newyear/erweima.html"
        }
        @if($userid == 7149)
           alert("来晚啦 礼品已被领光");
        setTimeout("location.href='/'",0);
        @endif
    </script>
@endsection

@section('content')
    @if($userid == 0)

    @else
        @if($status->is_get == 1)
            <div class="bm_success_layer text_center">
                <div class="mt40 pt40 plr20"><br /><br />
                    @if($data)
                    <p class="color_333 f32 sy_m bold">卡号:{{$data->card_code}}</p>
                    <p class="color_333 f32 sy_m bold">卡密:{{$data->card_pass}}</p>

                    <img src="/images/new_year/code.jpg" class="bm_success" alt="" />
                    <p class="sy_m color_333 f26 mt40 sao"><b class="color_red"> 如何使用京东E卡：</b><br/>
                        记得用电脑先登录京东商城~<br/>
                        页面导航栏【我的京东】-【礼品卡】<br/>
                        绑定京东E卡，填写卡号和卡密即可<br/>
                        如有其它疑问请扫码，进群咨询~</p>
                    @else
                        <p class="color_333 f32 sy_m bold">来晚啦 礼品已被领光   </p>
                    @endif
                </div>
            </div>
        @else
            <div class="bm_success_layer text_center">
                <div class="mt40 pt40 plr20"><br /><br />
                    <p class="color_red f32 sy_m bold">您还没有完成任务哦！不能获得礼品呢</p>
                    <p class="color_333 f32 sy_m bold">新年福利送现金<br />祝您猪年钱途无量</p>
                    <img src="/images/new_year/code.jpg" class="bm_success" alt="" />
                    <p class="sy_m color_333 f26 mt40 sao">扫码立即参与活动<br />千万别惊讶 全部免费送</p>

                </div>

            </div>

        @endif
    @endif

@endsection

