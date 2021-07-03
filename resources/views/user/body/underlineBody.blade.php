@foreach($orders as $order)
    <?php
        $courseClass = App\Models\Courseclass::where('id',$order->course_class_id)->first();
    ?>
    <li class="mb30">
        <a href="javascript:void(0)" class="block">
            <img src="{{env('IMG_URL')}}{{$courseClass->cover_url}}" alt="">
            <p class="f32 bold ptb13 fz text-overflow2 text-jus" style="max-height: 3rem;">{{$courseClass->title}}</p>
        </a>
    </li>
@endforeach