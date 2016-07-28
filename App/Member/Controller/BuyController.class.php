<?php  

namespace Member\Controller;
use Think\Controller;


Class BuyController extends CommonController {

	Public function _auto(){
      	$this->gid = I('gid','','intval');
    }

    /**
     * 提单提交首页处理
     * [index description]
     * @return [type] [description]
     */
    Public function index() {
    	//分配收获地址
		$db = D('UserView');
		$address = $db->getAddress($this->uid);
		$this->assign('address',$address); 
		//订单处理
		$db = D('Goods');
		$goods = $db->getGoodsFind($this->gid);
		$this->assign('goods',$goods);
		$this->display();
    }

    /**
     * 付款页面
     * [payMent description]
     * @return [type] [description]
     */
    Public function payMent() {
    	if(IS_POST === true){
			if(!isset($_POST['addressid'])) {
				$this->error('请选择一个收货地址!',U('Member/Account/setAddress'));
			}
			if(is_array($_POST['gid'])){
				$data = $_POST;
				foreach ($data['gid'] as $k=>$v){
					$_POST['gid'] = $v;
					$_POST['price'] = $data['price'][$k];
					$_POST['goods_num'] = $data['goods_num'][$k];
					$_POST['addressid'] = $data['addressid'];
					if(!$this->addOrder()) $this->error('订单提交失败!');
				}
			}else{
				if(!$this->addOrder()) $this->error('订单提交失败!');
			}
		}
		$order = $this->getOrderData();
		$sumArr = array();
		foreach ($order as $v){
			$sumArr[] = $v['price']*$v['goods_num'];
		}
		$this->assign('sumPrice', array_sum($sumArr));
		$this->assign('order',$order);
		$db = D('UserView');
		$balance = $db->getUserBalance($this->uid);
		$this->assign('balance',$balance);
		$this->display();
    }

    /**
     * 获取订单数据
     * [getOrderData description]
     * @return [type] [description]
     */
    Public function getOrderData() {
    	$db = D('OrderView');
		$orderid = I('oid','','intval');
		if(isset($orderid)){
			$where = array('user_id'=>$this->uid,'status'=>1);
		}else{
			$where = array('orderid'=>$orderid);
		}
		return  $db->getOrderData($where);
    }


    /**
     * 添加订单
     * [addOrder description]
     */
    Private function addOrder() {
		$data =  array();
		$data['user_id'] = $this->uid;
		$data['goods_id'] = I('gid','','intval');
		$data['goods_num'] = I('goods_num','','intval');
		$data['addressid'] = I('addressid','','intval');
		$data['total_money'] = $data['goods_num']*I('price','','intval');
		$db = D('OrderView');
		$where = array('user_id'=>$this->uid,'goods_id'=>$data['goods_id'],'status'=>1);
		if(!$db->checkOrder($where)){
			return $db->addOrder($data);
		}
		return true;		
	}

	/**
	 * 验证购物信息
	 * [checkBuy description]
	 * @return [type] [description]
	 */
	Public function checkBuy() {
		if(IS_POST === false){
			exit;
		}
		$gid = $this->gid;
		$orderids = $_POST['orderid'];
		$db = D('OrderView');
		$data = $db->getOrder($orderids);
		$sumArr = array();
		foreach ($data as $v){
			$sumArr[] = $v['price']*$v['goods_num'];
		}
		$totalPrice = array_sum($sumArr);
		$db = D('UserView');
		$balance = $db->getUserBalance($this->uid);
		if($balance<$totalPrice){
			$this->error('余额不足失败，请先充值!',U(MODULE_NAME.'/Account/index'));
		}else{
			$this->buysuccess($orderids,$totalPrice,$gid);
		}
	}

	/**
	 * 购买商品成功
	 * [buysuccess description]
	 * @param  [type] $orderids   [description]
	 * @param  [type] $totalPrice [description]
	 * @param  [type] $gid        [description]
	 * @return [type]             [description]
	 */
	Public function buysuccess($orderids,$totalPrice,$gid) {
		$db = D('OrderView');
		$map['orderid'] = array('in',$orderids);
		$data['status'] = 2;
		$order = M('order')->where($map)->save($data);
		if(!$order){
			$this->error('付款失败!',U('Home/Index/index'));
		}else{
			$balance = M('userinfo')->where(array('user_id'=>$this->uid))->setDec('balance',$totalPrice);
			$buy = M('goods')->where(array('gid'=>$gid))->setInc('buy',1);
			$db = D('CartView');
			$db->delCart(array('user_id'=>$this->uid));
			$this->display('buysuccess');
		}
	}

}


