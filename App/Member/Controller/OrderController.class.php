<?php  

namespace Member\Controller;
use Think\Controller;

Class OrderController extends CommonController {

	/**
	 * 订单显示页面
	 * [index description]
	 * @return [type] [description]
	 */
	Public function index() {
		 $db = D('OrderView');
		 $status = I('status','','intval');
		 if(empty($status)){
		 	$where = array('user_id'=>$this->uid);
		 }else{
		 	$where = array('user_id'=>$this->uid,'status'=>$status);
		 }
		 $data =  $db->getOrderData($where);//获取订单的数据       	
		 $order = $this->disData($data);
		 $this->assign('order', $order);
		 $this->assign('status',$status);
		 $this->display();            
    }

    /**
     * 订单数据处理
     * [disData description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    Private function disData($data) {
    	if(!$data) return false;
    	foreach ($data as $k=> $v){
    		$data[$k]['goods_img'] = substr_replace($v['goods_img'],'_90x55',-4,0);
    		$data[$k]['zongji'] = $v['goods_num']*$v['price'];
    	}
    	return $data;
    }

    /**
     * 删除订单处理
     * [del description]
     * @return [type] [description]
     */
	Public function del() {
		$oid = I('oid','','intval');
		if(is_null($oid)){
			$this->error('404错误');
		}
		$where = array('user_id'=>$this->uid,'orderid'=>$oid);
		$db = D('OrderView');
		if($db->delOrder($where)){
			$this->success('删除成功!',U('Member/Order/index'));
		}else{
			$this->error('删除失败！',U('Member/Order/index'));
		}
	}  	


}






