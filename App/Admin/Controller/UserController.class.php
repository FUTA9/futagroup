<?php   

namespace Admin\Controller;
use Think\Controller;

Class UserController extends CommonController {

	Public function _auto() {
		$this->db = D('UserView');
	}

	/**
	 * 用户显示模板
	 * [index description]
	 * @return [type] [description]
	 */
	Public function index(){
        $count = $this->db->getUserTotal();
        $page = new \Think\Page($count,10);
        $user = $this->db->getUser();
        $this->assign('user',$user);
        $this->assign('page',$page->show());
        $this->user = $this->db->getUser();
		$this->display();
	}

	/**
	 * 删除用户
	 * [del description]
	 * @return [type] [description]
	 */
	Public function del() {
		$uid = I('uid','','intval');
		if($this->db->deleteUser($uid)){
			$this->success('删除成功!',U(MODULE_NAME.'/User/index'));
		}else{
			$this->error('删除失败!',U(MODULE_NAME.'/User/index'));
		}
	}





}




