<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class CoursePlayRecordCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'course:record_count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $date = date("Ymd");

        logger()->info('ceshi2');
        if(Redis::keys("course_*") && Redis::keys("course_*") != ''){
            $json    = Redis::keys("course_*");
            foreach($json as $v){
               // echo $v."=>".Redis::get($v)."<br/>";
                logger()->info('ceshi2');
                logger()->info($v."=>".Redis::get($v));
                logger()->info('ceshi1');
                $arr = explode("_", $v);
                $data = array();
                if($arr[1]=='visit'){
                    continue;
                }else{
                    $data['course_id'] = $arr[2];         //单独视频id
                    $data['course_class_id'] = $arr[1];   //课程id
                    $data['date'] = $date;
                    $data['number'] = Redis::get($v);
                    $data['created_at'] = date("Y-m-d H:i:s");
                    DB::table("course_play_number")->insert($data);
                    empty($arr);
                    empty($data);
                    Redis::del($v);
                }
            }
        }
        
    }
}
