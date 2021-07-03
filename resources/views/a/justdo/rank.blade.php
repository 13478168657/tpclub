<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no" />
    <title>排行榜</title>
    <meta name="author" content="络绎" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" href="/lib/jqweui/css/weui.min.css" />
    <link rel="stylesheet" href="/lib/jqweui/css/jquery-weui.css" />
    <link rel="stylesheet" href="/css/reset.css" />
    <link rel="stylesheet" href="/css/font-num40.css"/>
    <link rel="stylesheet" href="/css/zt/zt_just_do_it_form.css">
    <script src="/js/rem.js" type="text/javascript"></script>
    @include('layouts.baidutongji')
</head>
<body ontouchstart>
<!-- 头部 start -->
<div class="fixed_bar_top">
    <header class="max750">
        <a href="javascript:history.go(-1);" class="btn_back"></a>
        <h1 class="text_center">排行榜</h1>
    </header>
</div>
<!-- 头部 end -->
<br/>
<br/>
<!-- 排行榜页 start -->
<div class="page_rank plr30 pt30">
    <!-- 前三甲信息 start -->
    <div class="top_three">
        <ul class="clearfix">
            @if($secondRank)
                <?php

                    $userInfo = $secondRank->getActiveInfo($secondRank->user_id,'DOIT',$secondRank->stage);
                    $user = json_decode($userInfo->user_info);
                    $name = $user->name;
                    if($user->avatar){
                       if(strpos($user->avatar,'http') !== false){
                            $avatar = $user->avatar;
                       }else{
                           $avatar = env('IMG_URL').$user->avatar;
                        }
                    }else{
                        $user = $secondRank->user;
                        if($user->avatar){
                            if(strpos($user->avatar,'http') !== false){
                                $avatar = $user->avatar;
                            }else{
                                $avatar = env('IMG_URL').$user->avatar;
                            }
                        }else{
                            $avatar = "/images/my/nophoto.jpg";
                        }

                    }
                    if($user->cover_img){
                        $avatar = env('IMG_URL').$user->cover_img;
                    }
                ?>
            <li>
                <div class="avatar_box">
                    <img src="/images/zt/just_do_it/huangguan2.png" class="ico_hg" />
                    <img src="{{$avatar}}" class="avatar radius50p" alt="" />
                </div>
                <div class="name">{{$name}}</div>
                <div class="integral">{{$secondRank->invite_num}}</div>
            </li>
            @endif
            @if($firstRank)
                <?php
//                    $user = $firstRank->user;
//                    $name = $user->name?$user->name:$user->nickname;
                    $userInfo = $firstRank->getActiveInfo($firstRank->user_id,'DOIT',$firstRank->stage);
                    $user = json_decode($userInfo->user_info);
                    $name = $user->name;
                    if($user->avatar){
                        if(strpos($user->avatar,'http') !== false){
                            $avatar = $user->avatar;
                        }else{
                            $avatar = env('IMG_URL').$user->avatar;
                        }
                    }else{
                        $user = $firstRank->user;
                        if($user->avatar){
                            if(strpos($user->avatar,'http') !== false){
                                $avatar = $user->avatar;
                            }else{
                                $avatar = env('IMG_URL').$user->avatar;
                            }
                        }else{
                            $avatar = "/images/my/nophoto.jpg";
                        }
                    }
                    if($user->cover_img){
                        $avatar = env('IMG_URL').$user->cover_img;
                    }
                ?>
            <li>
                <div class="avatar_box">
                    <img src="/images/zt/just_do_it/huangguan1.png" class="ico_hg" />
                    <img src="{{$avatar}}" class="avatar radius50p" alt="" />
                </div>

                <div class="name">{{$name}}</div>
                <div class="integral">{{$firstRank->invite_num}}</div>
            </li>
            @endif
            @if($thirdRank)
                <?php
//                    $user = $thirdRank->user;
//                    $name = $user->name?$user->name:$user->nickname;
                    $userInfo = $thirdRank->getActiveInfo($thirdRank->user_id,'DOIT',$thirdRank->stage);
                    $user = json_decode($userInfo->user_info);
                    $name = $user->name;
                    if($user->avatar){
                        if(strpos($user->avatar,'http') !== false){
                            $avatar = $user->avatar;
                        }else{
                            $avatar = env('IMG_URL').$user->avatar;
                        }
                    }else{
                        $user = $thirdRank->user;
                        if($user->avatar){
                            if(strpos($user->avatar,'http') !== false){
                                $avatar = $user->avatar;
                            }else{
                                $avatar = env('IMG_URL').$user->avatar;
                            }
                        }else{
                            $avatar = "/images/my/nophoto.jpg";
                        }
                    }
                    if($user->cover_img){
                        $avatar = env('IMG_URL').$user->cover_img;
                    }
                ?>
            <li>
                <div class="avatar_box">
                    <img src="/images/zt/just_do_it/huangguan3.png" class="ico_hg" />
                    <img src="{{$avatar}}" class="avatar radius50p" alt="" />
                </div>
                <div class="name">{{$name}}</div>
                <div class="integral">{{$thirdRank->invite_num}}</div>
            </li>
            @endif
        </ul>
    </div>
    <!-- 前三甲信息 end -->
    <!-- 列表 start -->
    @if(count($rankInfo))
    <div class="list">
        <ol>
            @foreach($rankInfo as  $k => $info)
                <?php
                    $rankNum  = $k + $num+1;
//                    $user = $info->user;
//                    $name = $user->name?$user->name:$user->nickname;
                    $userInfo = $info->getActiveInfo($info->user_id,'DOIT',$info->stage);
                    $user = json_decode($userInfo->user_info);
                    $name = $user->name;
                    if($user->avatar){
                        if(strpos($user->avatar,'http') !== false){
                            $avatar = $user->avatar;
                        }else{
                            $avatar = env('IMG_URL').$user->avatar;
                        }
                    }else{
                        $user = $info->user;
                        if($user->avatar){
                            if(strpos($user->avatar,'http') !== false){
                                $avatar = $user->avatar;
                            }else{
                                $avatar = env('IMG_URL').$user->avatar;
                            }
                        }else{
                            $avatar = "/images/my/nophoto.jpg";
                        }

                    }
                    if($user->cover_img){
                        $avatar = env('IMG_URL').$user->cover_img;
                    }
                ?>
            <li>
                <div class="fl">
                    <span class="no">{{$rankNum}}</span>
                    <img src="{{$avatar}}" class="avatar radius50p" alt="" />
                    <span class="name">{{$name}}</span>
                </div>
                <div class="fr integral">{{$info->invite_num}}</div>
            </li>
            @endforeach
        </ol>
    </div>
    @endif
    <!-- 列表 end -->
</div>
<!-- 排行榜页 end -->


<br><br><br /><br />

<!-- 底部固定导航 start -->
<div class="fixed_bar_bottom">
    <ul class="clearfix nav max750">
        <li>
            <a href="/jdt/active/index">首页</a>
        </li>
        <li>
            <a href="/jdt/active/vote">投票</a>
        </li>
        <li>
            <a href="/jdt/active/rank">排行榜</a>
        </li>
    </ul>
</div>
<!-- 底部固定导航 end -->
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/lib/layer/layer.js"></script>
<script src="/lib/jqweui/js/jquery-weui.min.js"></script>

<script>
    $('body').addClass('bgc_yellow1')
</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: "{{$WechatShare['appId']}}", // 必填，公众号的唯一标识
        timestamp: "{{$WechatShare['timestamp']}}", // 必填，生成签名的时间戳
        nonceStr: "{{$WechatShare['noncestr']}}", // 必填，生成签名的随机串
        signature: "{{$WechatShare['signature']}}",// 必填，签名
        jsApiList: [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
        ] // 必填，需要使用的JS接口列表
    });
    var title = '“TRAIN TO WIN”大奖排行榜';
    var desc = '聚焦精英擂台，见证健身王者';
    var share_img = "http://m.saipubbs.com/images/zt/just_do_it/share.png";
    var url = "http://m.saipubbs.com/jdt/active/rank";
    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareAppMessage({
            title: title, // 分享标题
            desc: desc, // 分享描述
            link: url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img, // 分享图标

        }, function(res) {
            //这里是回调函数

        });
    });
    wx.ready(function () {      //需在用户可能点击分享按钮前就先调用
        wx.onMenuShareTimeline({
            title: title, // 分享标题
            link: url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: share_img, // 分享图标

        }, function(res) {
            //这里是回调函数

        });
    });
</script>
</body>
</html>