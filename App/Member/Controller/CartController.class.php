<?php  

namespace Member\Controller;
use Think\Controller;
use Classlib\Cart;

Class CartController extends Controller {

	private $uid = null;

	/**
	 * 初始自动加载模板
	 * [_initialize description]
	 * @return [type] [description]
	 */
	Public function _initialize() {
	   if(isset($_SESSION[C('USER_AUTH_KEY')])){
		  $this->uid = $_SESSION[C('USER_AUTH_KEY')];
		  //将session中的数据写入数据库
		  $this->writeCart();
       }
       $db = D('Category');
       $loginShow = $_SESSION[C('USER_AUTH_KEY')];
       $this->assign('loginShow',$loginShow);
       $this->nav = $db->getNavCategory(0);
       $this->assign('userIsLogin',isset($_SESSION[C('USER_AUTH_KEY')]));
	}


	/**
	 * 购物车显示模板
	 * [index description]
	 * @return [type] [description]
	 */
	Public function index() {
		$db = D('UserView');
		$address = $db->getAddress($this->uid);
		$this->assign('address',$address);
		$cart = $this->getCartData();
		if(!$cart){
			$this->error('购物车为空！',U('Home/Index/index'));
		} 
		$data = $this->disCart($cart);
		if(IS_AJAX === false){
			$this->count = count($cart);
			$this->assign('cart',$data[0]);
			$this->assign('total',$data[1]);
			$this->display();
		}else{
			if(isset($data[0])){
                exit(json_encode(array('status'=>true,'data'=>$data[0])));
			}else{
				$this->ajaxReturn(array('status'=>false),'JSON');	
			}
		}
	}


	/**
	 * 添加购物车AJAX处理
	 * [addCart description]
	 */
	Public function addCart() {
		if(IS_AJAX === false) $this->error('非法请求');
	    $result = array();
        if(is_null($this->uid)){
			$data = array(
               'id'=>I('gid','','intval'),
               'name'=>'',
               'num'=>1,
               'price'=>0
			);
			$cart = new \Classlib\Cart();
			$cart->add($data);
			$total = count($_SESSION['cart']['goods']);
            $result = array('status'=>true,'total'=>$total);
		}else{//用户已登录
			$data = array();
			$data['goods_id'] = I('gid','','intval');
			$data['user_id'] = $this->uid;
			$data['goods_num'] = 1;
			$result = $this->checkAdd($data);
			if($result){
				$db = D('CartView');
				$where = array('user_id'=>$data['user_id']);
				$total = $db->countCart($where);
				$result = array('status'=>true,'total'=>$total);
			}
		}
		exit(json_encode($result));


	}



	/**
	 * 验证添加，存在自增，不存在添加新数据
	 * [checkAdd description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	Private function checkAdd($data){
        $where = array('user_id'=>$data['user_id'],'goods_id'=>$data['goods_id']);
        $db = D('CartView');
        $cart_id = $db->checkCart($where);
        if(is_null($cart_id)){
           return $db->addCart($data); 
        }else{
           return $db->incCart($cart_id,$data['goods_num']); 
        }
	}

	/**
	 * 购物车在session的数据写入数据库
	 * [writeCart description]
	 * @return [type] [description]
	 */
	Private function writeCart(){
		if(!isset($_SESSION['cart']['goods'])) return;
		$goods = $_SESSION['cart']['goods'];
		foreach ($goods as $v) {
			$data = array();
            $data['user_id'] = $this->uid;
            $data['goods_id'] = $v['id'];
            $data['goods_num'] = $v['num'];
            $this->checkAdd($data);
		}
		unset($_SESSION['cart']);
	}

	/**
	 * 获取购物车数据
	 * [getCartData description]
	 * @return [type] [description]
	 */
	private function getCartData() {
		$db = D('CartView');
		$result = array();
		if(is_null($this->uid)){
			if(!isset($_SESSION['cart']['goods'])) return;
           	$carts = $_SESSION['cart']['goods'];
           	foreach ($carts as $v) {
           	   $data = $db->getGoods($v['id']);
			   $data['goods_num'] = $v['num'];
			   $result[] = $data;
		   	}
		}else{
			$result = $db->getCartAll($this->uid);
		}
		return $result;
	}

	/**
	 * 购物车数据处理
	 * [disCart description]
	 * @param  [type] $cart [description]
	 * @return [type]       [description]
	 */
	Public function disCart($cart){
		if(empty($cart)) return false;
		$total = 0;
		foreach ($cart as $k=>$v){
			$cart[$k]['xiaoji'] = $v['goods_num']*$v['price'];
			$cart[$k]['status'] = $v['end_time']<time()?'已下架':'可购买';
			$cart[$k]['goods_img'] = substr_replace($v['goods_img'],'_90x55',-4,0);
			$cart[$k]['sub_title'] = mb_substr($v['sub_title'],0,14,'utf8');
			$total += $cart[$k]['xiaoji'];
		}
		return array($cart,$total);
	}


	/**
	 * 购物车数量处理
	 * [updataGoodsNum description]
	 * @return [type] [description]
	 */
    Public function updataGoodsNum() {
    	if(IS_AJAX === false) return false;
    	$gid = I('gid','','intval');
        $num = I('num','','intval');
        $result = array();
        //用户没有登录
        if(is_null($this->uid)){
           $carts = $_SESSION['cart']['goods'];
           foreach ($carts as $k=>$v){
			  if($v['id'] == $gid){
					$carts[$k]['num'] = $num;
					$result = array(
						'status'=>true,
						'num'=>$num		
					);
			  }
		  	}
        }else{//用户登录
          $db = D('CartView');
		  $where = array(
			'goods_id'=>$gid,
			'user_id'=>$this->uid		
		  );
		  if($db->updateCartNum($where,$num)){
				$result = array(
					'status'=>true,
					'num'=>$num
				);
		  }
        }
        exit(json_encode($result));
    }


    /**
     * 删除购物车
     * [del description]
     * @return [type] [description]
     */
    Public function del() {
		if(IS_AJAX === false) {
			$gid = I('gid','','intval');
            $where = array('user_id'=>$this->uid,'goods_id'=>$gid);
			$db = D('CartView');
			if($db->delCart($where)){
				$this->success('删除成功',U(MODULE_NAME.'/Cart/index'));
			}else{
				$this->error('删除失败',U(MODULE_NAME.'/Cart/index'));
			}
			return;
		};
		$gid = I('gid','','intval');
		/**
		 * 用户没有登录
		 */
		$result = array();
		$result['status'] = false;
		if(is_null($this->uid)){
			foreach ($_SESSION['cart']['goods'] as $k=>$v){
				if($v['id'] == $gid){
					unset($_SESSION['cart']['goods'][$k]);
					$result['status'] = true;
				}
			} 
		}else{	//用户登录了
			$where = array('user_id'=>$this->uid,'goods_id'=>$gid);
			$db = D('CartView');
			if($db->delCart($where)){
				$result['status'] = true;
			}
		}
		
		exit(json_encode($result));
	}






}








