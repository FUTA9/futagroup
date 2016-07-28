<?php

namespace Home\Controller;
use Think\Controller;

/**
 * 公共方法目录
 */
Class CommonController extends Controller {

	Public function _initialize() {
		if(method_exists($this,'_auto')){
			$this->_auto();
		}
		$this->setNav();
	}

	/**
	 * 导航分类
	 * [setNav description]
	 */
	Private function setNav() {
		$db = D('Category');
		$nav = $db->getCateLevel(0);
		$loginShow = $_SESSION[C('USER_AUTH_KEY')];
		$this->assign('loginShow',$loginShow);
		$this->assign('nav',$nav);
	}			








}