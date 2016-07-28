<?php   

namespace Member\Model;
use Think\Model;

Class GoodsModel extends Model {

	/**
	 * 获取所有商品数据
	 * [getGoods description]
	 * @param  [type] $in [description]
	 * @return [type]     [description]
	 */
	Public function getGoods($in){
		$fields = array(
           'main_title',
           'price',
           'gid',
           'old_price',
           'goods_img',
           'end_time'
		);
		$map['gid'] = array('in',$in);
		return $this->field($fields)->where($map)->select();
	}

	/**
	 * 获取单条商品数据
	 * [getGoodsFind description]
	 * @param  [type] $gid [description]
	 * @return [type]      [description]
	 */
	Public function getGoodsFind($gid){
		return $this->where(array('gid'=>$gid))->find();
	}



	
}




