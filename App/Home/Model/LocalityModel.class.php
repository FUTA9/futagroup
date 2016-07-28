<?php  

namespace Home\Model;
use Think\Model;

Class LocalityModel extends Model {

	/**
	 * 按等级读取分类
	 * [getLocalityLevel description]
	 * @param  [type] $pid [description]
	 * @return [type]      [description]
	 */
	Public function getLocalityLevel($pid) {	
		return $this->where(array('pid'=>$pid,'display'=>1))->field(array('lid','lname'))->order('sort ASC')->select();	

	}

	/**
	 * 获取子类的pid
	 * [getCatePid description]
	 * @param  [type] $cid [description]
	 * @return [type]      [description]
	 */
	Public function getLocalityPid($lid) {
		$result = $this->where(array('lid'=>$lid))->field('pid')->find();
		return $result['pid'];
	}

	/**
	 * 获取所有子地区
	 * [getChildArea description]
	 * @return [type] [description]
	 */
	Public function getChildArea($lid) {
		$result = $this->field('lid')->where(array('pid'=>$lid))->select();
		if(is_null($result)){
			$result = array('lid'=>$lid);
		}
		return $result;

	}





}






