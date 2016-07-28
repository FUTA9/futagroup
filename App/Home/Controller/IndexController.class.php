<?php

namespace Home\Controller;
use Think\Controller;
use Classlib\Route;
use Classlib\Page;

/**
 * 前台首页
 */
Class IndexController extends CommonController {

	private $cid;	//分类主键
	private $lid;	//地区主键 
	private $url;
	private $price; //价格筛选
	private $order;   //排序规则
	/**
	 * 自动加载处理
	 * [_auto description]
	 * @return [type] [description]
	 */
	Public function _auto() {
		$this->cid = I('cid','','intval');
		$this->lid = I('lid','','intval');
		$this->price = I('price');
		$this->order = I('order','t-desc');
		$this->db = D('GoodsView'); 
		if(strlen(U('Home/Index/index'))>strlen(__SELF__)){
	 		$this->url = U('Home/Index/index');
		}else{
	 		$this->url = url_param_remove('keywords',__SELF__);
		}
	}

	/**
	 * 前台首页显示
	 * [Index description]
	 */
	Public function Index() {
		$this->setCategory();
		$this->setLocality();
		$this->setPrice();
		$this->setSearchWhere();
		$this->setOrder();
		$this->hostGoods = $this->getHostGoods(); //实现热卖商品
    	$this->setHostGroup();                    //实现热门分组
		$goods = $this->db->getGoods();
		$count = $this->db->getGoodsTotal();

		//引入分页类
	    //import('Classlib.Page',APP_PATH);
	    /*
	    $page = new \Classlib\Page($count,10);
	    $test = $page->limit();
	    $data = $this->db->setSearch($test['limit']);
	    foreach ($data as $k=>$v){
	     $data[$k]['goods_img'] = substr_replace($v['goods_img'],'_310x185',-4,0);
	      $data[$k]['sub_title'] = mb_substr($v['sub_title'],0,30,'utf8');
	      $data[$k]['main_title'] = mb_substr($v['main_title'],0,30,'utf8');
	    } 
	    $this->assign('goods',$data);
	    $this->assign('page',$page->show());
	    $this->assign('urls',$this->url);
		$this->display();
		*/
		
		$page = new \Think\Page($count,10);
	    $limit = $page->firstRow.','.$page->listRows;
	    $data = $this->db->setSearch($limit);
	    foreach ($data as $k=>$v){
	     $data[$k]['goods_img'] = substr_replace($v['goods_img'],'_310x185',-4,0);
	      $data[$k]['sub_title'] = mb_substr($v['sub_title'],0,30,'utf8');
	      $data[$k]['main_title'] = mb_substr($v['main_title'],0,15,'utf8');
	    } 
	    $this->assign('goods',$data);
	    $this->assign('page',$page->show());
	    $this->assign('urls',$this->url);
		$this->display();
	}

	/**
	 * 设置搜索条件
	 * [setSearchWhere description]
	 */
	Private function setSearchWhere() {
		if(isset($_GET['keywords'])){
			$this->db->keywords = $_GET['keywords'];
			return;
		}
		//组合分类条件
		if(!is_null($this->cid)){
			$db = D('Category');
			$sonCids = $db->getChildCate($this->cid);
			$cidss = $_GET['cid'];
			if($cidss){
				foreach ($sonCids as $v) {
					$this->db->cids['cid'][] = $v['cid'];
				}
				$this->db->cids['cid'][] = $this->cid;
			}
			 
		}

		//组合地区条件
		if(!is_null($this->lid)){
			$db = D('Locality');
			$sonLids = $db->getChildArea($this->lid);
			$lidss = $_GET['lid'];
			if($lidss){
				foreach ($sonLids as $v) {
					$this->db->lids['lid'][] = $v['lid'];
				}
				$this->db->lids['lid'][] = $this->lid;
			}
			
			
		}

		//组合价格条件
		if(!is_null($this->price)){
			$arr = explode('-',$this->price);
			if(isset($arr[1])){
				$this->db->pricefirst = intval($arr[0]);
				$this->db->priceend = intval($arr[1]);
			}else{
				$this->db->pricefirst = intval($arr[0]);
			}
		}
		$this->setOrderUrl();
	}

	/**
	 * 设置前台显示分类模板
	 * 1 没有cid 显示顶级分类
	 * 2 有cid 显示顶级分类与子类
	 * [setCategroy description]
	 */
	Private function setCategory() {
		$db = D('Category');
 		$url = url_param_remove('cid',$this->url);
		//当没有cid的时候
		if(is_null($this->cid)){
			$result = $db->getCateLevel(0);
			$tmpArr = array();
			$tmpArr[] = '<a href="'.$url.'">全部</a>';
			foreach ($result as $v) {
				$tmpArr[] = '<a href = "'. $url.'/cid/'.$v['cid'].'">'.$v['cname'].'</a>';
			}
			$this->assign('topCate',$tmpArr);
			return; 
		}

		/**
		 * 有cid的时候
		 * 1 cid是顶级分类ID
		 * 2 cid不是顶级分类的ID
		 */
		$pid = $db->getCatePid($this->cid);
		$result = $db->getCateLevel(0);
		$tmpArr = array();
		$tmpArr[] = '<a href="'.$url.'">全部</a>';
		foreach ($result as $v) {
				if($pid == $v['cid'] || $this->cid == $v['cid']){
					$tmpArr[] = '<a class="active" href = "'. $url.'/cid/'.$v['cid'].'">'.$v['cname'].'</a>';
				}else{
					$tmpArr[] = '<a href = "'. $url.'/cid/'.$v['cid'].'">'.$v['cname'].'</a>';
				}
			}
		
		$this->assign('topCate',$tmpArr);
		if($pid == 0){
			$sonCate = $db->getCateLevel($this->cid);
		}else{
			$sonCate = $db->getCateLevel($pid);
		}
		if(is_null($sonCate)) return;

		//组合子分类处理
		$tmpArr = array();
		if($pid == 0){
			$tmpArr[] = '<a class="active" href="'.$url.'/cid/'.$this->cid.'">全部</a>';
		}else{
			$tmpArr[] = '<a href="'.$url.'/cid/'.$pid.'">全部</a>';
		}
						
		foreach ($sonCate as $v) {
			if($v['cid'] == $this->cid){
				$tmpArr[] = '<a class="active" href = "'. $url.'/cid/'.$v['cid'].'">'.$v['cname'].'</a>';
			}else{
				$tmpArr[] = '<a href = "'. $url.'/cid/'.$v['cid'].'">'.$v['cname'].'</a>';
			}
		}
		$this->assign('sonCate',$tmpArr);
	}
	
	/**
	 * 设置前台地区模板
	 * [setLocality description]
	 */
	Private function setLocality() {
		$db = D('Locality');
		$url = url_param_remove('lid',$this->url);
		//当没有lid的时候
		if(is_null($this->lid)){
			$result = $db->getLocalityLevel(0);
			$tmpArr = array();
			$tmpArr[] = '<a href="'.$url.'">全部</a>';
			foreach($result as $v) {
				$tmpArr[] = '<a href = "'. $url.'/lid/'.$v['lid'].'">'.$v['lname'].'</a>';
			}
			$this->assign('toparea',$tmpArr);
			return;
		}
		/**
		 * 有lid的时候
		 * 1 lid是顶级分类ID
		 * 2 lid不是顶级分类的ID
		 */
		$pid = $db->getLocalityPid($this->lid);
		$result = $db->getLocalityLevel(0);
		$tmpArr = array();
		$tmpArr[] = '<a href="'.$url.'">全部</a>';
		foreach ($result as $v) {
				if($pid == $v['lid'] || $this->lid == $v['lid']){
					$tmpArr[] = '<a class="active" href = "'. $url.'/lid/'.$v['lid'].'">'.$v['lname'].'</a>';
				}else{
					$tmpArr[] = '<a href = "'. $url.'/lid/'.$v['lid'].'">'.$v['lname'].'</a>';
				}
			}
		
		$this->assign('toparea',$tmpArr);



		if($pid == 0){
			$sonIty = $db->getLocalityLevel($this->lid);
		}else{
			$sonIty = $db->getLocalityLevel($pid);
		}
		if(is_null($sonIty)) return;

		//组合子地区处理
		$tmpArr = array();
		if($pid == 0){
			$tmpArr[] = '<a class="active" href="'.$url.'/lid/'.$this->lid.'">全部</a>';
		}else{
			$tmpArr[] = '<a href="'.$url.'/lid/'.$pid.'">全部</a>';
		}
						
		foreach ($sonIty as $v) {
			if($v['lid'] == $this->lid){
				$tmpArr[] = '<a class="active" href = "'. $url.'/lid/'.$v['lid'].'">'.$v['lname'].'</a>';
			}else{
				$tmpArr[] = '<a href = "'. $url.'/lid/'.$v['lid'].'">'.$v['lname'].'</a>';
			}
		}
		$this->assign('sonIty',$tmpArr);


	}

	/**
	 * 设置价格筛选模板
	 * [setPrice description]
	 */
	Private function setPrice() {
		$db = D('Category');
		$url = url_param_remove('price',$this->url);
		$key = '';
		if(is_null($this->cid)){
			$key = 'all';
		}else{
			$pid = $db->getCatePid($this->cid);
			$key = $pid?$pid:$this->cid;
		}
		$prices = C('price');
		$price = $prices[$key];
		$tmpArr = array();
		if(is_null($this->price)){
			$tmpArr[] = "<a class='active' href='".$url."'>全部</a>";
		}else{
			$tmpArr[] = "<a href='".$url."'>全部</a>";
		}

		foreach ($price as $v) {
			if($this->price == $v[1]){
				$tmpArr[] = "<a class='active' href='".$url.'/price/'.$v[1]."'>".$v[0]."</a>";
			}else{
				$tmpArr[] = "<a href='".$url.'/price/'.$v[1]."'>".$v[0]."</a>";
			}
		}
		$this->assign('price',$tmpArr);
	}

	/**
	 * 设置排序模板
	 * [setOrderUrl description]
	 */
	Private function setOrderUrl(){
		$url = url_param_remove('order',$this->url);
		$orderUrl = array();
		//default 默认排序
		$orderUrl['d'] = $url.'/order/t-desc';  
		//buy 销量降序
		$orderUrl['b'] = $url.'/order/b-desc';
		//price 价格降序
		$orderUrl['p_d'] = $url.'/order/p-desc';
		//price 价格升序
		$orderUrl['p_a'] = $url.'/order/p-asc';
		//begin_time 发表时间，降序
		$orderUrl['t'] = $url.'/order/t2-desc';
		$this->assign('orderUrl', $orderUrl);
	}      

	/**
	 * 设置排序规则
	 * [setOrder description]
	 */
	Public function setOrder() {
		$order = '';
		$arr = explode('-',$this->order);
		switch ($arr[0]) {
			case 'd':
				$order = 'begin_time '.$arr[1];
			break;
			case 'b':
				$order = 'buy '.$arr[1];
			break;
			case 'p':
				$order = 'price '.$arr[1];
			break;
			case 't':
				$order = 'begin_time '.$arr[1];
			break;
		}
		$this->db->order = $order;
	}

	/**
	 * 热卖商品
	 * [getHostGoods description]
	 * @return [type] [description]
	 */
	Private function getHostGoods() {
      if(!$data = S('HostGoods')){
         $data = $this->db->getHostGoods();
         $data = $this->disHostGoods($data);
         S('HostGoods',$data,600);
      }
      return $data;
  	}

  	/**
  	 * 热卖商品数据处理
  	 * [disHostGoods description]
  	 * @param  [type] $goods [description]
  	 * @return [type]        [description]
  	 */
	Private function disHostGoods($goods){
	  if(empty($goods)) return false;
	    foreach ($goods as $k=>$v){
	      $goods[$k]['goods_img'] = substr_replace($v['goods_img'],'_90x55',-4,0);
	  }
	  return $goods;
  	}

  	/**
  	 * 热门团购
  	 * [setHostGroup description]
  	 */
  	Private function setHostGroup(){
    	$this->hostGroup = $this->db->getHostGroup();
	}



}








