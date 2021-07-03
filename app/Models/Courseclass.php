<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Courseclass extends Model
{
    //
	protected $table = "course_class";
	public function getBanner(){
		$data = DB::table("banner")->where("state",1)->whereNull("deleted_at")->orderBy("order_by","desc")->get();
		return $data;
		
	}
	public function getone(){

		$data = $this->leftJoin("course_type","course_class.course_type_id","=","course_type.id")->where("course_class.is_new",1)->where("course_class.state",1)->where("course_class.is_hide",0)->whereNull("course_class.deleted_at")->select("course_class.*","course_type.title as typeName")->orderBy("course_class.orderby","desc")->take(1)->get();

		foreach($data as $k=>$v){
			$id = $v->id;
			$tag = DB::table("course_tag")->where("course_class_id",$id)->whereNull("deleted_at")->select("tag_id")->get()->toArray();
			//dd($tag);
			$sum_video = sum_course($id);
			$sum_people  = sum_study($id);
			$teacher_name = get_teacher_name($v['user_id']);
			$data[$k]['sum_people'] = $sum_people->count + $v['studying_num'];
			$data[$k]['sum_video'] = $sum_video->count;
			$data[$k]['teacher_name'] = $teacher_name->name;
			//dd($tag);
			if($tag){
				foreach($tag as $a=>$b){
					$tag_id = $b->tag_id;
					$arr[] = $this->getTag($tag_id);	
					
				}
				$data[$k]["tagArr"] = $arr;
				unset($arr);
			}
		}
    	return $data;
	}

	//2018-11-28  获取免费课程
	public function getFree(){

		$data = $this->leftJoin("course_type","course_class.course_type_id","=","course_type.id")->where("course_class.is_free",0)->where("course_class.state",1)->where("course_class.is_hide",0)->whereNull("course_class.deleted_at")->select("course_class.*","course_type.title as typeName")->orderBy("course_class.orderby","desc")->take(3)->get();

		foreach($data as $k=>$v){
			$id = $v->id;
			$tag = DB::table("course_tag")->where("course_class_id",$id)->whereNull("deleted_at")->select("tag_id")->get()->toArray();
			//dd($tag);
			$sum_video = sum_course($id);
			$sum_people  = sum_study($id);
			$teacher_name = get_teacher_name($v['user_id']);
			$data[$k]['sum_people'] = $sum_people->count + $v['studying_num'];
			$data[$k]['sum_video'] = $sum_video->count;
			$data[$k]['teacher_name'] = $teacher_name->name;
			//dd($tag);
			
		}
    	return $data;
	}

	//2018-11-28  获取推荐课程
	public function getHot(){

		$data = $this->leftJoin("course_type","course_class.course_type_id","=","course_type.id")->where("course_class.is_hot",1)->where("course_class.state",1)->where("course_class.is_hide",0)->whereNull("course_class.deleted_at")->select("course_class.*","course_type.title as typeName")->orderBy("course_class.orderby","desc")->get();

		foreach($data as $k=>$v){
			$id = $v->id;
			$tag = DB::table("course_tag")->where("course_class_id",$id)->whereNull("deleted_at")->select("tag_id")->get()->toArray();
			//dd($tag);
			$sum_video = sum_course($id);
			$sum_people  = sum_study($id);
			$teacher_name = get_teacher_name($v['user_id']);
			$data[$k]['sum_people'] = $sum_people->count + $v['studying_num'];
			$data[$k]['sum_video'] = $sum_video->count;
			$data[$k]['teacher_name'] = $teacher_name->name;
			
		}
    	return $data;
	}

	//2018-11-28  获取全部免费课程
	public function getFreeAll($p=1){
		$num  = 10;
		$skip = $num*($p-1);
		$data = $this->where("course_class.is_free",0)->where("course_class.state",1)->where("course_class.is_hide",0)->whereNull("course_class.deleted_at")->select("course_class.*")->orderBy("course_class.id","desc")->skip($skip)->take($num)->get();

		foreach($data as $k=>$v){
			$id = $v->id;
			$tag = DB::table("course_tag")->where("course_class_id",$id)->whereNull("deleted_at")->select("tag_id")->get()->toArray();
			//dd($tag);
			$sum_video = sum_course($id);
			$sum_people  = sum_study($id);
			$teacher_name = get_teacher_name($v['user_id']);
			$data[$k]['sum_people'] = $sum_people->count + $v['studying_num'];
			$data[$k]['sum_video'] = $sum_video->count;
			$data[$k]['teacher_name'] = $teacher_name->name;
			//dd($tag);
			if($tag){
				foreach($tag as $a=>$b){
					$tag_id = $b->tag_id;
					$arr[] = $this->getTag($tag_id);	
					
				}
				$data[$k]["tagArr"] = $arr;
				unset($arr);
			}
		}
    	return $data;
	}

	public function getMany($gets){
		$num = 10;
		if(isset($gets['course_type_id'])){
		$condition['course_type_id'] = $gets['course_type_id'];
		$data = $this
				->leftJoin("course_type","course_class.course_type_id","=","course_type.id")
				->select("course_class.*","course_type.title as typeName")
				->where("course_class.state",1)
				->where("course_class.is_hide",0)
				->where("course_class.is_live",0)
				->where($condition)
				->whereNull("course_class.deleted_at")
				->orderBy("course_class.orderby","desc")
				->orderBy("id","desc")
				->take($num)
				->get();
			}else{
			$data = $this
				->leftJoin("course_type","course_class.course_type_id","=","course_type.id")
				->whereNull("course_class.deleted_at")
				->where("course_class.state",1)
				->where("course_class.is_hide",0)
				->where("course_class.is_live",0)
				->select("course_class.*","course_type.title as typeName")
				->orderBy("course_class.orderby","desc")
				->orderBy("id","desc")
				->skip(0)
				->take($num)
				->get();

			}
		foreach($data as $k=>$v){
			$id = $v->id;
			$tag = DB::table("course_tag")->where("course_class_id",$id)->whereNull("deleted_at")->select("tag_id")->get()->toArray();
			
			$sum_video = sum_course($id);
			$sum_people  = sum_study($id);
			
			$teacher_name = get_teacher_name($v['user_id']);
			$data[$k]['sum_people'] = $sum_people->count + $v['studying_num'];
			$data[$k]['sum_video'] = $sum_video->count;
			$data[$k]['teacher_name'] = $teacher_name->name;
			if($tag){
				foreach($tag as $a=>$b){
					$tag_id = $b->tag_id;
					$arr[] = $this->getTag($tag_id);	
				}
				$data[$k]["tagArr"] = $arr;
				unset($arr);
			}
		}
		//dd($data);
		return $data;
	}
	public function getTagDetail($tag_id,$page){
		$num = 10;
		if(!empty($page)){
			$page = $page;
		}else{
			$page = 2;
			
		}
		$start = $num * ($page-1);
		$data = $this
				->leftJoin("course_type","course_class.course_type_id","=","course_type.id")
				->select("course_class.*","course_type.title as typeName")
				->where("course_class.state",1)
				->where("course_class.is_hide",0)
				->where("course_class.is_live",0)
				->whereIn('course_class.id',$tag_id)
				->whereNull("course_class.deleted_at")
				->orderBy("course_class.orderby","desc")
				->orderBy("id","desc")
				->skip($start)
				->take($num)
				->get();
		foreach($data as $k=>$v){
			$id = $v->id;
			$tag = DB::table("course_tag")->where("course_class_id",$id)->whereNull("deleted_at")->select("tag_id")->get()->toArray();
			$sum_video = sum_course($id);
			$sum_people  = sum_study($id);
			$teacher_name = get_teacher_name($v['user_id']);
			$data[$k]['sum_people'] = $sum_people->count + $v['studying_num'];
			$data[$k]['sum_video'] = $sum_video->count;
			$data[$k]['teacher_name'] = $teacher_name->name;
			if($tag){
				foreach($tag as $a=>$b){
					$tagId = $b->tag_id;
					$arr[] = $this->getTag($tagId);	
					
				}
				$data[$k]["tagArr"] = $arr;
				unset($arr);
			}
		}
		return $data;
	}
	public function pageJson($gets){
		//$gets = $request->input();

		$num = 10;
		if(isset($gets['page'])){
			$page = $gets['page'];
			$start = $num * ($page-1);
		}else{
			$page = 2;
			$start = $num * ($page-1);
		}
		if(isset($gets['course_type_id'])){
			$type_id = $gets['course_type_id'];
		$data = $this
				->leftJoin("course_type","course_class.course_type_id","=","course_type.id")
				->where("course_class.state",1)
				->where("course_class.is_hide",0)
				->where("course_class.is_live",0)
				->whereNull("course_class.deleted_at")
				->select("course_class.*","course_type.title as typeName")
				->orderBy("course_class.orderby","desc")
				->orderBy("id","desc")
				->where("course_type_id",$type_id)
				->skip($start)
				->take($num)
				->get();
			}else{
		$data = $this
				->leftJoin("course_type","course_class.course_type_id","=","course_type.id")
				->where("course_class.state",1)
				->where("course_class.is_hide",0)
				->where("course_class.is_live",0)
				->whereNull("course_class.deleted_at")
				->select("course_class.*","course_type.title as typeName")
				->orderBy("course_class.orderby","desc")
				->orderBy("id","desc")
				->skip($start)
				->take($num)
				->get();


			}

		foreach($data as $k=>$v){
			$id = $v->id;
			$tag = DB::table("course_tag")->where("course_class_id",$id)->whereNull("deleted_at")->select("tag_id")->get()->toArray();
			
			$sum_video = sum_course($id);
			$sum_people  = sum_study($id);
			$teacher_name = get_teacher_name($v['user_id']);
			$data[$k]['sum_people'] = $sum_people->count + $v['studying_num'];
			$data[$k]['sum_video'] = $sum_video->count;
			$data[$k]['teacher_name'] = $teacher_name->name;
			if($tag){
				foreach($tag as $a=>$b){
					$tag_id = $b->tag_id;
					$arr[] = $this->getTag($tag_id);	
					
				}
				$data[$k]["tagArr"] = $arr;
			}
			unset($arr);
		}
		return $data;
	}
	public function getTag($tag_id){

		$data = DB::table("tags")->where("id",$tag_id)->whereNull("deleted_at")->select("id","title")->get();
		return $data;

	}
	public function getTagNew($tag_id){

		$data = DB::table("tags")->where("id",$tag_id)->whereNull("deleted_at")->select("id","title")->first();
		return $data;

	}
	public function getTypeArr($id){
		return $data = $this->where("course_type_id",$id)->get();
	}
	public function detail($id){
		$data = $this->leftJoin("users","course_class.user_id","=","users.id")
					 ->where("course_class.id",$id)
					 ->where("course_class.state",1)
					 ->whereNull("course_class.deleted_at")
					 ->select("course_class.*","users.avatar")
					 ->get();
		return $data;

	}
	/*
	课程详细视频页
	 */
	public function video($id){
		 $data = DB::table("course_section")->where("course_class_id",$id)->where("state",1)->whereNull("deleted_at")->select("id","title")->get()->toArray();
		 
		 foreach($data as $k=>$v){
		 	$vid = $v->id;
		 	$v->course = DB::table("course")->where("course_class_section_id",$vid)->where("state",1)->whereNull("deleted_at")->select("id","title","video_url","preview",'is_live','live_long_time','live_start_time','live_end_time','live_number','created_at','course_content_id')->get();
		 }
		 //dd($data);
		 return $data;
	}
	public function videoDetail($id){
		$data = DB::table("course")->where("id",$id)->where("state",1)->whereNull("deleted_at")->select("video_url")->get();
		return $data[0];
	}

	public function author(){
		return $this->belongsTo('App\Models\Users','user_id','id');
	}

	public function courseType(){
		return $this->hasOne('App\Models\CourseType','id','course_type_id');
	}

	public function courseTag() {
		return $this->hasMany('App\Models\CourseTag','course_class_id','id');
	}

	public function getTypeData($id,$child = 0){

		$type = CourseType::where("pid",$id)->select("id","title","cover_url")->orderBy("id","desc")->get();

		if(isset($type[0])){
			if($child == 0){
				$tid = $type[0]->id;
			}else{
				$tid = $child;
			}
			$img = CourseType::where("id",$tid)->select("cover_url")->whereNull("deleted_at")->where("state",1)->first();
			$three = CourseType::where("pid",$tid)->select("id","title")->whereNull("deleted_at")->where("state",1)->get();
			$data = [];
			foreach($three as $v){
				$obj = Courseclass::where("course_type_id",$v->id)->whereNull("deleted_at")->where("state",1)->where("is_hide",0)->get();
				foreach($obj as $k=>$a){
					$a->typeName = $v->title;
					$tagId = $a->id;
					$tag = DB::table("course_tag")->where("course_class_id",$tagId)->whereNull("deleted_at")->select("tag_id")->get()->toArray();
					if($tag){
						foreach($tag as $a=>$b){
							$tag_id = $b->tag_id;
							$tagAll[] = $this->getTagNew($tag_id);
						}

						$obj[$k]["tagArr"] = $tagAll;
					}
					unset($tagAll);
				}
				$data[] = $obj;
			}
		}
		
		if(!isset($obj)){
			$obj = [];
			$data=[];
			$img="";
			$tid=[];
		}
		$arr['newData'] = end($obj);
		$arr['data'] = $data;
		$arr['type'] = $type;
		$arr['img'] = $img;
		if($child == 0){
			$arr['cid'] = $tid;
		}else{
			$arr['cid'] = $child;
		}
		return $arr;
	}
	public function getTagData($tagId,$offset){
		$limit = 2;
		$tag = DB::table("course_tag")->where("tag_id",$tagId)->offset($offset)->limit($limit)->select("course_class_id")->get();
		$list = [];
		foreach($tag as $v){
			$cid = $v->course_class_id;
			$list[] = Courseclass::where("id",$cid)->whereNull("deleted_at")->first();
		}
		$data = array_filter($list);
		foreach($data as $k=>$a){
			$id = $a->id;
			$tag = DB::table("course_tag")->where("course_class_id",$id)->whereNull("deleted_at")->select("tag_id")->get()->toArray();
			if($tag){
				foreach($tag as $a=>$b){
					$tag_id = $b->tag_id;
					$tagAll[] = $this->getTagNew($tag_id);
				}
				$data[$k]["tagArr"] = $tagAll;
			}
			unset($tagAll);
		}

		return $data;

	}
	public function getTagData1($id,$offset){
		$limit = 5;
		$type = $this->getTypeTree($id);
		foreach($type as $k=>$v){
			foreach($v as $key=>$val){
				$arr2[]=$val->id;
			}
		}
		$data = Courseclass::whereIn("course_type_id",$arr2)->whereNull("deleted_at")->where("state",1)->orderBy("orderby","desc")->offset($offset)->limit($limit)->get();
		foreach($data as $d => $a){	
					$tag = DB::table("course_tag")->where("course_class_id",$a->id)->whereNull("deleted_at")->select("tag_id")->get();
					if($tag){
						foreach($tag as $b){
							$tag_id = $b->tag_id;
							$tagAll[] = $this->getTagNew($tag_id);
						}
						$data[$d]['tagArr'] = $tagAll;
					}
					unset($tagAll);
		}
		
		
		return $data;
		
		

	}
	public function getTypeTree($id){

			$type = DB::table("course_type")->where("pid",$id)->select("id","title")->get();
			
			$tree = [];
			foreach($type as $v){
					$data = DB::table("course_type")->where("pid",$v->id)->whereNull("deleted_at")->where("state",1)->select("id","title")->get()->toArray();
					$tree[] = $data;
			}
			return array_filter($tree);

	}
	public function getRecommend($id){
		$type = $this->getTypeTree($id);
		foreach($type as $k=>$v){
			foreach($v as $key=>$val){
				$arr2[]=$val->id;
			}
		}
		$list = Courseclass::whereIn("course_type_id",$arr2)->whereNull("deleted_at")->where("state",1)->where("is_hide",0)->orderBy("id","desc")->limit(1)->first();
		$list->sum_course = sum_course($list->id)->count;
		$list->sum_study = sum_study($list->id)->count + $list->count;
		$list->teacher_name = get_teacher_name($list->user_id)->name;
		$tagData = DB::table("course_tag")->where("course_class_id",$list->id)->whereNull("deleted_at")->select("tag_id")->get()->toArray();
		if($tagData){
			foreach($tagData as $a=>$b){
				$tag_id = $b->tag_id;
				$tagAll[] = $this->getTagNew($tag_id);
			}
			$list["tagArr"] = $tagAll;
		}
		unset($tagAll);
		return $list;
		
	}
	public function getTwoRecommend($id,$cid){
		if($cid == 0){
			$type = DB::table("course_type")->where("pid",$id)->select("id","title")->orderBy("id","desc")->first();
			$last = DB::table("course_type")->where("pid",$type->id)->select("id","title")->orderBy("id","desc")->first();
		}else{
			$last = DB::table("course_type")->where("pid",$cid)->select("id","title")->orderBy("id","desc")->first();
			
		}
		
		$list = Courseclass::where("course_type_id",$last->id)->whereNull("deleted_at")->where("state",1)->orderBy("id","desc")->first();
		if($list){
				$list->sum_course = sum_course($list->id)->count;
				$list->sum_study = sum_study($list->id)->count + $list->count;
				$list->teacher_name = get_teacher_name($list->user_id)->name;
			
			$tagData = DB::table("course_tag")->where("course_class_id",$list->id)->whereNull("deleted_at")->select("tag_id")->get()->toArray();
			if($tagData){
				foreach($tagData as $a=>$b){
					$tag_id = $b->tag_id;
					$tagAll[] = $this->getTagNew($tag_id);
				}
				$list["tagArr"] = $tagAll;
			}
			unset($tagAll);
			return $list;
		}else{
			return [];
		}
		
	}
}
