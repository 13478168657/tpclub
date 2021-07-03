<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseType extends Model
{
    //
    protected $table = "course_type";
    public function getType(){
    	return $this->hasOne('App\Models\CourseClass','id','course_type_id');
	}

    public function gType(){
        $data = $this->get();

        return $data;
    }
    public function getTree($data,$pid){
        $tree = [];
        foreach($data as $k=>$v){
            if($v['pid'] == $pid){
                $v['child'] = self::getTree($data,$v['id']);
                $tree[] = $v;
            }

        }
        return $tree;
    }
    public function getTypes($pid){
        $types = $this->where('pid',$pid)->get();
        return $types;
    }
    public function getone($id){
        $data = $this->where("id",$id)->select("id","title")->get();
        return $data;
    }
}
