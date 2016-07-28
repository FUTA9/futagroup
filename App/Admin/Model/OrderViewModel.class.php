<?php 

namespace Admin\Model;
use Think\Model\ViewModel; 

Class OrderViewModel extends ViewModel {

	/**
	 * 获取订单总数
	 * [getOrderTotal description]
	 * @param  [type] $where [description]
	 * @return [type]        [description]
	 */
	Public function getOrderTotal($where) {
		$string ='INNER JOIN gr_goods ON gr_goods.gid = gr_order.goods_id';	
		return $this->table('gr_order')->join($string)->where($where)->count();
	}

	/**
	 * 获取所有订单
	 * [getOrder description]
	 * @param  [type] $where [description]
	 * @return [type]        [description]
	 */
	Public function getOrder($where,$limit) {
		$fields = array(
			'main_title',
			'goods_num',
			'price',
			'orderid',
			'total_money',
			'status'		
		);
		$string ='INNER JOIN gr_goods ON gr_goods.gid = gr_order.goods_id';	
		return $this->table('gr_order')->join($string)->where($where)->limit($limit)->select();
	}

	/**
	 * 删除订单
	 * [delOrder description]
	 * @param  [type] $oid [description]
	 * @return [type]      [description]
	 */
	Public function delOrder($oid){
		return $this->table('gr_order')->where(array('orderid'=>$oid))->delete();
	}










}



