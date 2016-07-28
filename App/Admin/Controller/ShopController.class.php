<?php   

namespace Admin\Controller;

use Think\Controller;


Class ShopController extends CommonController {

   Private $shopid;

   Public function _auto () {
      
       
   }
    
    /**
     * 商铺首页视图
     */

    Public function index () {
        
       $this->shop = M('shop')->order('shopid DESC')->select();
 
       $this->display();

    }
   
    /**
     * 添加商铺视图
     */
   
    Public function addShop () {

          if(IS_GET == true){
            $this->display();
            exit;
          }
          
          $this->db = D('Shop');

          $data=$this->getData();
       
          if($this->db->addShops($data)){
             $this->success('添加成功',U(MODULE_NAME.'/Shop/index'));
          }else{
             $this->error('添加失败');
          }
      
     }


  /* public function getPoint(){
     $point = $_POST['point'];//获取表单提交的point
     $result = '福州市';//返回的值
     if ($result) {
        exit(json_encode(array('status'=>1,'point'=>$result)));//把返回值赋值给point(赋值给模板的data.point)
     } else {
        exit(json_encode(array('status'=>0)));
     }
    
   } */

  /* Public function runAddShop () {

     $shopname = trim(I('shopname'));

     if(empty($shopname)){
        $this->error('商铺名称不能为空');
     }
 
      $db = M('shop');
      if($db->create()){
        if($db->add()){
          $this->success('添加成功！', U(MODULE_NAME.'/Shop/index'));
        } else {
          $this->error('添加失败！');    
        }
     }

   } */

   /**
    * 修改商铺视图
    */
   
   Public function saveShop () {

      $this->db = D('Shop');

      if(IS_GET == true){
             
           $shopid = I('shopid','','intval');
         
           $shop = $this->db->getShops($shopid);

           $this->assign('shop',$shop)->display();   
      }else{
           $shopid = I('shopid','','intval');
           $data = $this->getData();
    
           $result = $this->db->saveShops($shopid,$data);

           if($result){
             $this->success('修改成功',U(MODULE_NAME.'/Shop/index'));
           }else{
             $this->error('修改失败'); 
           }
      }
   }
 
  /**
   * 获取表单提交数据
   */
 
  Public function getData () {

         $data = array(); 
         $data['shopid']= I('shopid');
         $data['shopname'] = I('shopname');
         $data['shopaddress'] = I('shopaddress');
         $data['metroaddress'] = I('metroaddress');
         $data['shoptel'] = I('shoptel','','intval'); 
         $data['shopcoord'] = I('shopcoord');

         return $data;

  }

  
  /**
   * 删除商铺
   * @return [type] [description]
   */
  Public function deleteShop () {

       $this->db = D('shop');

       $shopid = I('shopid','','intval');

       $delShop = $this->db->delShops($shopid);

       if($delShop){
          $this->success('删除成功',U(MODULE_NAME.'/Shop/index'));
       }else{
          $this->error('删除失败');
       }

  }

 

}








