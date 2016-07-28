<?php   

namespace Admin\Model;
use Think\Model\ViewModel; 


Class UserViewModel extends ViewModel {

	Protected $viewFields = array(
		'user'=>array(
			'uid','uname','email','password',
			'_type'=>'INNER'
		),
		'userinfo'=>array(
            'user_id','balance',
            '_on'=>'user.uid = userinfo.user_id'
		)
	);



	/**
	 * 获取用户总数
	 * [getUserTotal description]
	 * @return [type] [description]
	 */
	Public function getUserTotal() {
		return $this->count();
	}

	/**
	 * 获取所有用户数据
	 * [getUser description]
	 * @return [type] [description]
	 */
	Public function getUser() {
		$fields = array(
			'uid',
			'email',
			'uname',
			'balance'				
		);
		return $this->field($fields)->select();
	}

	Public function deleteUser($uid) {
		$this->table('gr_collect')->where(array('gr_collect.user_id'=>$uid))->delete();
		$this->table('gr_cart')->where(array('gr_cart.user_id'=>$uid))->delete();
		$this->table('gr_order')->where(array('gr_order.user_id'=>$uid))->delete();
		$this->table('gr_userinfo')->where(array('gr_userinfo.user_id'=>$uid))->delete();
		$this->table('gr_user_address')->where(array('gr_user_address.user_id'=>$uid))->delete();
		return $this->table('gr_user')->where(array('gr_user.uid'=>$uid))->delete();
	}

}






