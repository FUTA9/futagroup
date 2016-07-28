<?php 

namespace Admin\Controller;
use Think\Controller;

class IndexController extends CommonController {


   Public function index () {
     $this->display();
 
   }

   Public function logout() {
        session_destroy();
		session_unset();
		$this->success('已退出!');
   }




}

