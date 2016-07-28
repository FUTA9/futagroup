<?php 

namespace Member\Controller;
use Think\Controller;
use Classlib\Encry;

Class IndexController extends Controller {

	/**
	 * 初始化
	 * [_initialize description]
	 * @return [type] [description]
	 */
	Public function _initialize() {
       $this->uid = (int)$_SESSION[C('USER_AUTH_KEY')];
       $db = D('Category');
       $loginShow = $_SESSION[C('USER_AUTH_KEY')];
       $this->assign('loginShow',$loginShow);
       $this->nav = $db->getNavCategory(0);
       $this->assign('userIsLogin',isset($_SESSION[C('USER_AUTH_KEY')]));
    }


	Public function collect() {
		$db = D('UserView');
    $status = I('status','','intval');
    $where = array('collect.user_id'=>$this->uid);
    if(!empty($status)){
      if($status == 1){
         $where = 'collect.user_id ='.$this->uid.' and end_time>='.time();
      }else{
         $where = 'collect.user_id ='.$this->uid.' and end_time<'.time();
      }
    }
    $data = $db->getCollect($where);
    $this->collect = $this->disCollectData($data);
    $this->assign('status',$status);
    $this->display();
	}
	

	/**
	 * 获取最近浏览商品
	 * [getRecentView description]
	 * @return [type] [description]
	 */
	Public function getRecentView() {
      if(IS_AJAX === false) return false;
      $key = Encry::encrypt('recent-view');     
      $result = array(); 
      if(!isset($_COOKIE[$key])){
        $result['status'] = false;
        $this->ajaxReturn($result,'JSON');
      }

      //取得cookie的值
      $value =unserialize(Encry::decrypt($_COOKIE[$key]));  
      $db = D('Goods');
      $data = $db->getGoods($value);
      if($data){
        $data = $this->disData($data);
        $result['status'] = true;
        $result['data'] = $data;
        $this->ajaxReturn($result,'JSON');
      }else{
        $result['status'] = false;
      }
      $this->ajaxReturn($result,'JSON');
  }

  /**
   * 最近浏览图片处理
   * [disData description]
   * @param  [type] $data [description]
   * @return [type]       [description]
   */
  private function disData($data){
    foreach ($data as $k=>$v){
      $data[$k]['goods_img'] = substr_replace($v['goods_img'],'_90x55',-4,0);
    }
    return $data;
  }

  /**
   * 清空最近浏览
   * [clearRecentView description]
   * @return [type] [description]
   */
  Public function clearRecentView(){
    if(IS_AJAX === false) exit();
    $key = Encry::encrypt('recent-view');
    if(isset($_COOKIE[$key])){
      unset($_COOKIE[$key]);
    }
    setcookie($key,'',1,'/');
  }

  /**
   * 添加收藏
   * [addCollect description]
   */
  Public function addCollect() {
    $gid = I('gid','','intval');
    $data = array(
        'user_id'=>$this->uid,
        'goods_id'=>$gid
    );
    $result = array();
    $db = D('UserView');
    if($db->checkCollect($data)){
       $result = array('status'=>true);
    }else{
       if($db->addCollect($data)){
         $result = array('status'=>true);
       }else{
         $result = array('status'=>false);
       }
    }
    $this->ajaxReturn($result,'JSON');
}

  /**
   * 处理收藏数据
   * [disCollectData description]
   * @param  [type] $data [description]
   * @return [type]       [description]
   */
  Public function disCollectData($data) {
    if(!$data) return false;
    foreach ($data as $k=>$v){
      $data[$k]['goods_img'] = substr_replace($v['goods_img'],'_90x55',-4,0);
      $data[$k]['end_time'] = $v['end_time']>time()?'进行中':'已结束';
    }   
    return $data;
  }

  /**
   * 删除收藏
   * [delCollect description]
   * @return [type] [description]
   */
  Public function delCollect() {
    $where = array(
      'user_id'=>$this->uid,
      'goods_id'=>I('gid','','intval')   
    );
    $db = D('UserView');
    if($db->delCollect($where)){
      $this->success('删除成功!',U('Member/Index/Collect'));
    }else{
      $this->error('删除失败!',U('Member/Index/Collect'));
    }
    
  }




}




