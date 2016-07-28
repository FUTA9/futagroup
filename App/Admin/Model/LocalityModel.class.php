<?php 

namespace Admin\Model;
use Think\Model;


Class LocalityModel extends Model {

    /**
     * 默认使用表名
     * [$tableName description]
     * @var string
     */
	Public $tableName = 'locality';

	/**
	 * 默认表前缀
	 * [$tablePrefix description]
	 * @var string
	 */
	Public $tablePrefix = 'gr_';


	/**
	 * 添加地区处理
	 * [addLocalIty description]
	 * @param [type] $data [description]
	 */
	Public function addLocalIty($data) {
		return $this->add($data);
	}


	/**
	 * 读取单条地区处理
	 * [getLocalIty description]
	 * @param  [type] $lid [description]
	 * @return [type]      [description]
	 */
	Public function getLocalIty($lid) {
		return $this->where(array('lid'=>$lid))->find();
	}

	/**
	 * 	更新地区处理
	 * [saveLocalIty description]
	 * @param  [type] $data [description]
	 * @param  [type] $lid  [description]
	 * @return [type]       [description]
	 */
	Public function saveLocalIty($data,$lid) {
		return $this->where(array('lid'=>$lid))->save($data);
	}

	/**
	 * 	删除地区处理
	 * [delLocalIty description]
	 * @param  [type] $lid [description]
	 * @return [type]      [description]
	 */
	Public function delLocalIty($lid) {
		return $this->where(array('lid'=>$lid))->delete();
	}

	/**
	 * 获取所有地区
	 * [getLocalItyAll description]
	 * @return [type] [description]
	 */
	Public function getLocalItyAll() {
		return $this->select();
	}


}