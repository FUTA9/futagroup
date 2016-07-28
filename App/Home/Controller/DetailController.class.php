<?php 

namespace Home\Controller;
use Think\Controller;
use Classlib\Encry;
use Classlib\Page;

Class DetailController extends CommonController {

	private $gid;
	private $url;

	Public function _auto() {
		$this->gid = I('gid','','intval');
		$this->db = D('GoodsView');
		$this->setRecentView();
		if(strlen(U('Home/Index/index'))>strlen(__SELF__)){
	 		$this->url = U('Home/Index/index');
		}else{
	 		$this->url = url_param_remove('keywords',__SELF__);
		}

	}


	/**
	 * 显示模板方法
	 * [index description]
	 * @return [type] [description]
	 */
	Public function index() {
		$this->disComment();
		$this->orderUrl();
		$detail = $this->db->getGoodsDetail($this->gid);
		$detail = $this->disDetailData($detail);
		$this->getRelatedGoods();
		$serve = $detail['serve'];
		$this->assign('serve',$serve);
		$this->assign('detail',$detail);	
		$this->display();

	}

	/**
	 * 处理数据
	 * [disDetailData description]
	 * @param  [type] $detail [description]
	 * @return [type]         [description]
	 */
	Private function disDetailData($detail) {
		$detail['zhekou'] = round(($detail['price']/($detail['old_price']-1)*10),1);
		$detail['goods_img'] = substr_replace($detail['goods_img'],'_460x280',-4,0);
		if($detail['end_time']-time()>(pow(60,2)*24*3)){
			$detail['end_time'] = '剩余<span>3</span>天以上';
		}else{
			$detail['end_time'] = date('Y-m-d H:i:s').'下架';
		}
		$goodsServe = array_slice(unserialize($detail['goods_server']),0,2);
		$serve = C('goods_server');
		$detail['serve'] = array(
			$serve[$goodsServe[0]],
			$serve[$goodsServe[1]]
		);
		return $detail;
	}

	/**
	 * 最近浏览
	 * [setRecentView description]
	 */
	Private function setRecentView() {
 	    $key = Encry::encrypt('recent-view');
	    $value = isset($_COOKIE[$key])?unserialize(Encry::decrypt($_COOKIE[$key])):array();
	    if(!in_array($this->gid,$value)){
	        array_unshift($value, $this->gid);
	    }
	    setcookie($key,Encry::encrypt(serialize($value)),time()+3600,'/');
	}

	/**
	 * 查看团购处理
	 * [getRelatedGoods description]
	 * @return [type] [description]
	 */
	Private function getRelatedGoods(){
           $cid = $this->db->getGoodsCid($this->gid);
           $relateGoods = $this->db->getRelatedGoods($cid);
           foreach ($relateGoods as $k => $v) {
              $relateGoods[$k]['goods_img'] = substr_replace($v['goods_img'],'_200x100',-4,0);
           }
           $this->assign('relateGoods',$relateGoods);
        }



   	/**
   	 * 添加商品评论
   	 * [addComment description]
   	 */
	Public function addComment(){
		$db = D('OrderView');
		if(IS_GET == true){
			if(!isset($_SESSION[C('USER_AUTH_KEY')])){
				$this->error('您还未登录，请登录后操作！');
			}else{
				$this->uid = (int)$_SESSION['uid']; 
				$gid = I('gid','','intval');
				
				$result = $db->getorder($this->uid,$gid);
				if(!$result){
					$this->error('您还未购买该商品，无法评论！');
				}else{
					$data = array();
					$data = $result[0];
					$this->assign('user',$data);
					$this->display(); 
				}
			}

		}else{
			$where = array('user_id'=>$_POST['user_id'],'goods_id'=>$_POST['goods_id']);
			$data = array();
			$data['content'] = $_POST['content'];
			$data['user_id'] = $_POST['user_id'];
			$data['goods_id'] = $_POST['goods_id'];
			$data['time'] = time();
			$result = $db->addComments($where,$data);
			if($result){
				$this->success('添加评论成功！',U(MODULE_NAME.'/Detail/index/gid/'.$data['goods_id']));
			}else{
				$this->error('添加评论失败！');
			}

		}

	}

	/**
	 * 商品评论数据处理
	 * [disComment description]
	 * @return [type] [description]
	 */
	Public function disComment() {
		$db = D('OrderView');
		if(strpos($this->url,'/order/t-desc')){
			$order = 'time DESC';
		}else{
			$order = 'time ASC';
		}
		$count = $db->getCommentTotal($this->gid);
		$page = new \Classlib\Page($count,10);
		$text = $page->limit();
		$result = $db->getComment($this->gid,$text['limit'],$order);
		$delShow = $_SESSION[C('USER_AUTH_KEY')];
		$this->assign('userComment',$result);
		$this->assign('delShow',$delShow);
		$this->assign('page',$page->show());
	}

	/**
	 * 时间排序模板处理
	 * [orderUrl description]
	 * @return [type] [description]
	 */
	Public function orderUrl(){
		$url = url_param_remove('order',$this->url);
		if(strpos($this->url,'/order/t-desc')){
			$orderUrl = $url.'/order/t-asc';
		}else{
			$orderUrl = $url.'/order/t-desc';
		}
		$this->assign('orderUrl', $orderUrl);
	}

	/**
	 * 刪除評論
	 * [delComment description]
	 * @return [type] [description]
	 */
	Public function delComment(){
		if(!IS_AJAX == true) return;
		$comment_id = $_POST['comment'];
		$where = array('comment_id'=>$comment_id);
		$db = D('OrderView');
		if($db->delComments($where)){
			$result['status'] == true;
		}
		exit(json_encode($result));
	}


}




