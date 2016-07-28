<?php  

namespace Admin\Model;
use Think\Model;

Class CategoryModel extends Model {

	/**
	 * 设定默认使用表名
	 * [$tableName description]
	 * @var string
	 */
	Public $tableName = 'category';

	/**
	 * 设定使用表前缀
	 * [$tablePrefix description]
	 * @var string
	 */
	Public $tablePrefix = 'gr_';

	/**
	 * 获取单条分类数据
	 * [getCate description]
	 * @return [type] [description]
	 */
	Public function getCates($cid) {
		return $this->where(array('cid'=>$cid))->find();
	}

	/**
	 * 添加分类处理
	 * [addCates description]
	 * @param [type] $data [description]
	 */
	Public function	addCates($data)	{
		return $this->add($data);
	}

	/**
	 * 更新分类处理						
	 * [saveCates description]
	 * @param  [type] $data [description]
	 * @param  [type] $cid  [description]
	 * @return [type]       [description]
	 */
	Public function saveCates($data,$cid) {
		return $this->where(array('cid'=>$cid))->save($data);
	}

	/**
	 * 删除分类处理
	 * [delCates description]
	 * @param  [type] $cid [description]
	 * @return [type]      [description]
	 */
	Public function delCates($cid) {
		return $this->where(array('cid'=>$cid))->delete();
	}

	/**
	 * 获取所有分类
	 * [getCategoryAll description]
	 * @return [type] [description]
	 */
	Public function getCategoryAll() {
		return $this->select();

	}


}