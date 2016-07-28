<?php  

namespace Member\Model;
use Think\Model\ViewModel;

Class OrderViewModel extends ViewModel {

	/**
	 * 验证订单
	 * [checkOrder description]
	 * @param  [type] $where [description]
	 * @return [type]        [description]
	 */
	Public function checkOrder($where){
		return $this->table('gr_order')->where($where)->count();
	}	

	/**
	 * 添加订单
	 * [addOrder description]
	 * @param [type] $data [description]
	 */
	Public function addOrder($data){
		return $this->table('gr_order')->add($data);
	}

	/**
	 * 获取订单数据
	 * [getOrderData description]
	 * @param  [type] $where [description]
	 * @return [type]        [description]
	 */
	Public function getOrderData($where){
	    $string ='INNER JOIN gr_goods ON gr_goods.gid = gr_order.goods_id';	
		return $this->table('gr_order')->where($where)->join($string)->select();
	}

	/**
	 * 获取订单里的数据
	 * [getOrder description]
	 * @param  [type] $orderids [description]
	 * @return [type]           [description]
	 */
	Public function getOrder($orderids){
		$map['orderid'] = array('in',$orderids);
		$string ='INNER JOIN gr_goods ON gr_goods.gid = gr_order.goods_id';
		return $this->table('gr_order')->join($string)->where($map)->select();
	}

	/**
	 * 修改订单
	 * [updateStatus description]
	 * @param  [type] $orderids [description]
	 * @return [type]           [description]
	 */
	Public function updateStatus($orderids){
		$map['orderid'] = array('in',$orderids);
		$data['status'] = 2;
		return $this->table('gr_order')->where($map)->save($data);
	}

	/**
	 * 删除订单
	 * [delOrder description]
	 * @param  [type] $where [description]
	 * @return [type]        [description]
	 */
	Public function delOrder($where){
		return $this->table('gr_order')->where($where)->delete();
	}

}






