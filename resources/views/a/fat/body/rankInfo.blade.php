<!-- 前三甲信息 start  -->
<div class="top_three">
    <ul class="clearfix">
        <?php
        $firstUser = isset($rankLists[0])?$rankLists[0]:'';
        $secondUser = isset($rankLists[1])?$rankLists[1]:'';
        $thirdUser = isset($rankLists[2])?$rankLists[2]:'';
        ?>
        @if($secondUser)
            <li>
                <a href="javascript:void (0)" class="block">
                    <div class="avatar_box">
                        <img src="images/top2.png" class="ico_hg" />
                        <img src="{{env('IMG_URL')}}{{$secondUser->cover_img}}" class="avatar border-radius2" alt="" />
                    </div>
                    <div class="name lt f24"><span>{{$secondUser->id}}号</span><span>{{$secondUser->name}}</span></div>
                    <div class="integral fz f24"><span>减脂差值{{$secondUser->fat_diff_value}}%</span></div>
                    <!-- <div class="integral fz f24"><span>体脂{{$secondUser->fat_rate}}%</span></div> -->
                </a>
            </li>
        @endif
        @if($firstUser)
            <li>
                <a href="javascript:void (0)" class="block">
                    <div class="avatar_box">
                        <img src="images/top1.png" class="ico_hg" />
                        <img src="{{env('IMG_URL')}}{{$firstUser->cover_img}}" class="avatar border-radius2" alt="" />
                    </div>
                    <div class="name lt f24"><span>{{$firstUser->id}}号</span><span>{{$firstUser->name}}</span></div>
                                        <div class="integral fz f24"><span>减脂差值{{$firstUser->fat_diff_value}}%</span></div>
                    <!-- <div class="integral fz f24"><span>体脂{{$firstUser->fat_rate}}%</span></div> -->
                </a>
            </li>
        @endif
        @if($thirdUser)
            <li>
                <a href="javascript:void (0)" class="block">
                    <div class="avatar_box">
                        <img src="images/top3.png" class="ico_hg" />
                        <img src="{{env('IMG_URL')}}{{$thirdUser->cover_img}}" class="avatar border-radius2" alt="" />
                    </div>
                    <div class="name lt f24"><span>{{$thirdUser->id}}号</span><span>{{$thirdUser->name}}</span></div>
                    <div class="integral fz f24"><span>减脂差值{{$thirdUser->fat_diff_value}}%</span></div>
                    <!-- <div class="integral fz f24"><span>体脂{{$thirdUser->fat_rate}}%</span></div> -->
                </a>
            </li>
        @endif
    </ul>
</div>
<!-- 前三甲信息 end -->

<!-- 列表 start -->
<div class="listBox mlr30 mt30">
    <ul>
        @foreach($rankLists as $k => $stu)
            <?php
            if($k <=2){
                continue;
            }
            ?>
            <li>
                <a href="javascript:void (0)" class="block">
                    <div class="wrap clearfix fz f30">
                        <p class="font-Impact">{{$k+1}}</p>
                        <p><img src="{{env('IMG_URL')}}{{$stu->cover_img}}" alt="" class="border-radius2"></p>
                        <p><span>{{$stu->id}}号</span><span>{{$stu->name}}</span></p>
                        <p class="f24">减脂差值{{$stu->fat_diff_value}}%</p>
                        <!-- <p class="f24">体脂{{$stu->fat_rate}}%</p> -->
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div>
<!-- 列表 end