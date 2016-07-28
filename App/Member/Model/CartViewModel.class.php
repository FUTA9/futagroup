<?php  

namespace Member\Model;
use Think\Model\ViewModel; 

Class CartViewModel extends ViewModel {

	/**
	 * 添加购物车
	 * [addCart description]
	 * @param [type] $data [description]
	 */
	Public function addCart($data) {
		return $this->table('gr_cart')->add($data);
	}

	/**
	 * 购物车自增
	 * [incCart description]
	 * @param  [type] $id  [description]
	 * @param  [type] $num [description]
	 * @return [type]      [description]
	 */
	Public function incCart($id,$num) {
		return $this->table('gr_cart')->where(array('cart_id'=>$id))->setInc('goods_num',$num);
	}


	/**
	 * 验证购物车信息是否存在
	 * [checkCart description]
	 * @param  [type] $where [description]
	 * @return [type]        [description]
	 */
	Public function checkCart($where) {
		$result = $this->table('gr_cart')->field('cart_id')->where($where)->find();
		return isset($result['cart_id'])?$result['cart_id']:null;
	}

	/**
	 * 统计购物车总数
	 * [countCart description]
	 * @param  [type] $where [description]
	 * @return [type]        [description]
	 */
	Public function countCart($where) {
		return $this->table('gr_cart')->where($where)->count();
	}

	/**
	 * 获取商品数据
	 * [getGoods description]
	 * @param  [type] $gid [description]
	 * @return [type]      [description]
	 */
	Public function getGoods($gid) {
		$fields = array(
			'main_title',
			'gid',
			'goods_img',
			'price',
			'end_time'		
		);
		return $this->table('gr_goods')->field($fields)->where(array('gr_goods.gid'=>$gid))->find();
	}

	/**
	 * 获取购物车数据
	 * [getCartAll description]
	 * @param  [type] $uid [description]
	 * @return [type]      [description]
	 */
	Public function getCartAll($uid) {
		$this->viewFields = array(
			'goods'=>array(
				'main_title','gid','goods_img','price','end_time',
				'_type'=>'INNER'				
			),
			'cart'=>array(
				'cart_id','goods_num',
                '_type'=>'INNER',
                '_on'=>'goods.gid = cart.goods_id'
			)
		);
		$fields = array(
			'main_title',
			'gid',
			'goods_img',
			'price',
			'end_time',
			'cart_id',
			'goods_num'	
		);
		return $this->field($fields)->where(array('user_id'=>$uid))->select();
	}

	/**
	 * 购物车数量更新
	 * [updateCartNum description]
	 * @param  [type] $where [description]
	 * @param  [type] $num   [description]
	 * @return [type]        [description]
	 */
	Public function updateCartNum($where,$num){
		$result = $this->table('gr_cart')->where($where)->save(array('goods_num'=>$num));
		return $result;
	}
	
	/**
	 * 删除购物车数据
	 * [delCart description]
	 * @param  [type] $where [description]
	 * @return [type]        [description]
	 */
	Public function delCart($where){
		return $this->table('gr_cart')->where($where)->delete();
	}


}



