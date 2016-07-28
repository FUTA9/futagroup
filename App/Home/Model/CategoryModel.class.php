<?php 

namespace Home\Model;
use Think\Model;

Class CategoryModel extends Model {

	/**
	 * 按等级读取分类
	 * [getCateLevel description]
	 * @param  [type] $pid [description]
	 * @return [type]      [description]
	 */
	Public function getCateLevel($pid) {	
		return $this->where(array('pid'=>$pid,'display'=>1))->field(array('cid','cname'))->order('sort ASC')->select();	

	}

	/**
	 * 获取子类
	 * [getCatePid description]
	 * @param  [type] $cid [description]
	 * @return [type]      [description]
	 */
	Public function getCatePid($cid) {
		$result = $this->where(array('cid'=>$cid))->field('pid')->find();
		return $result['pid'];
	}

	/**
	 * 获取所有的子分类
	 * [getChildCate description]
	 * @return [type] [description]
	 */
	Public function getChildCate($cid) {
		$result = $this->field('cid')->where(array('pid'=>$cid))->select();
		if(is_null($result)){
			$result = array('cid'=>$cid);
		}
		return $result;
	}



}