<?php    

namespace Member\Controller;
use Think\Controller;

Class AccountController extends CommonController {

	Public function _auto() {
		$this->db = D('UserView');
	}

	/**
	 * 用户余额显示
	 * [index description]
	 * @return [type] [description]
	 */
	Public function index() {
		$balance = $this->db->getUserBalance($this->uid);
		$this->assign('balance', $balance);
		$this->display();
	}

	/**
	 * 用户帐户设置
	 * [setting description]
	 * @return [type] [description]
	 */
	Public function setting() {
		$where = array('uid'=>$this->uid);
		$this->user = $this->db->getUser($where);
		$this->display();
	}

	/**
	 * 设置收货地址
	 * [setAddress description]
	 */
	Public function setAddress() {
		$address = $this->db->getAddress($this->uid);
		$this->assign('address', $address);
		$this->display();

	}

	/**
	 * 删除收货地址
	 * [delAddress description]
	 * @return [type] [description]
	 */
	Public function delAddress() {
		$id = I('addressid','','intval');
		if($this->db->delAddress($id)){
			$this->success('删除成功!',U(MODULE_NAME.'/Account/setAddress'));
		}else{
			$this->error('删除失败!',U(MODULE_NAME.'/Account/setAddress'));
		}
	}

	/**
	 * 添加收货地址
	 * [addAddress description]
	 */
	Public function addAddress() {
		$data = array();
		foreach ($_POST as $D=>$v){
			$data[$D] = strip_tags($v);
		}
		$data['user_id'] = $this->uid;
		if(M('user_address')->add($data)){
			$this->success('添加成功',U('Member/Order/index'));
		}else{
			$this->error('添加失败',U('Member/Order/index'));
		}
	}

	/**
	 * 账户充值
	 * [addBalance description]
	 */
	Public function addBalance() {
		$data = array();
		if(M('userinfo')->where(array('user_id'=>$this->uid))->setInc('balance',10000)){
			$this->success('充值成功',U('index'));
		}else{
			$this->error('充值失败',U('index'));
		}
	}

	/**
	 * 修改用户密码
	 * [savePass description]
	 * @return [type] [description]
	 */
	Public function savePass() {
		if(IS_GET){
			$this->display(); 
		}else{
			$where = array('uid'=>$this->uid);
			$result = $this->db->getUser($where);
			$getEmail = $_POST['email'];
			$email = strtolower($getEmail);
			$emails = $result['email'];
			if($emails == $email){
				$password = $_POST['password'];
				$passwords = $_POST['password2'];
				if($password == $passwords){
					$where = array('uid'=>$result['uid']);
					$data = array();
					$data['password'] = I('password','','md5');
					$results = $this->db->savePass($where,$data);
					if($results){
						$this->success('修改密码成功',U(MODULE_NAME.'/Account/setting'));
					}
				}else{
					$this->error('两次密码输入不一致！');
				}
			}else{
				$this->error('邮箱输入错误！');
			}



		}





	}


}





