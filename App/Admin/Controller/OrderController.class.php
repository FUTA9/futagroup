<?php 

namespace Admin\Controller;
use Think\Controller;

Class OrderController extends CommonController {

	Public function _auto() {
		$this->db = D('OrderView');
	}
	
	/**
	 * 订单显示模板
	 * [index description]
	 * @return [type] [description]
	 */
	Public function index() {
		$where = $this->getWhere();
        $count = $this->db->getOrderTotal($where);
        $page = new \Think\Page($count,10);
        $show = $page->show();
        $order = $this->db->getOrder($where,10);
        $this->assign('order',$order);
        $this->assign('page',$show);
        $this->order = $this->db->getOrder($where);
		$this->display();
	}

	/**
	 * 获取读取订单条件
	 * [getWhere description]
	 * @return [type] [description]
	 */
	Private function getWhere() {
		$where = array();
		$status =  I('status','','intval');
		if(!empty($status)){
			$where['status'] = $status;
		}
		return $where;
	}

	/**
	 * 删除订单
	 * [del description]
	 * @return [type] [description]
	 */
	Public function del() {
		$oid=  I('orderid','','intval');
		if($this->db->delOrder($oid)){
			$this->success('删除成功!',U(MODULE_NAME.'/Order/index'));
		}else{
			$this->success('删除失败!',U(MODULE_NAME.'/Order/index'));
		}
	}










}



