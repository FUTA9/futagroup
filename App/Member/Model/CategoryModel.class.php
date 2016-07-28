<?php  

namespace Member\Model;
use Think\Model;

Class CategoryModel extends Model {

	Public function getNavCategory($pid){
     	return $this->field('cname,cid')->where(array('pid'=>$pid,'display'=>1))->order('sort asc')->limit(4)->select();
	}











	
}








