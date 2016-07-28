<?php 

namespace Admin\Controller;
use Think\Controller;

Class CommonController extends Controller {

   Public function _initialize () {

   	  if(method_exists($this, '_auto')){
   	  	$this->_auto();
   	  }

      if(!isset($_SESSION['username'])){
      	$this->redirect(MODULE_NAME.'/Login/index');
      }

   }


}