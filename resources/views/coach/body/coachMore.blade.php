@foreach($coachList as $k => $coach)
    <a class="bgcolor_f9f9f9 {{$k==0?'mb30':''}}" href="/coach/detail/{{$coach->id}}.html">
        <div class="stepBox mlr40 pt40 pb40">
            <h4 class="bold f28 color_333 pb20 line36">{{$coach->name}}</h4>
            <p class="f24 color_gray999 text-jus line36">{{$coach->deal_problem}}</p>
        </div>
    </a>
@endforeach