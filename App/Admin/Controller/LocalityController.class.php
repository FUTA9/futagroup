<?php   

namespace Admin\Controller;

use Think\Controller;

Class LocalityController extends CommonController {
    
    Private $lid;
    /**
     * 加载模型和获取ID
     * [_auto description]
     * @return [type] [description]
     */
    Public function _auto() {
       $this->db = D('Locality');
       $this->lid = I('lid','','intval');
    }



    /**
     * 地区显示处理方法
     * [index description]
     * @return [type] [description]
     */
    Public function index() {
       $localIty = M('locality')->order('sort ASC')->select();
       $ity = new \Classlib\Locality();
       $data = $ity->unlimitForLevel($localIty,'--');
       $this->assign('ity',$data)->display();
    }
   
    /**
     * 增加地区处理
     * [addIty description]
     */
    Public function addIty() {
       if(IS_GET == true){
         $pid = I('pid', 0, 'intval');
         $this->assign('pid', $pid)->display();
         exit;
       }

       $data = $this->getData();
       if($this->db->addLocalIty($data)){
          $this->success('添加成功',U(MODULE_NAME.'/Locality/index'));
       }else{
          $this->error('添加失败');
       }

    }

    /**
     * 删除地区处理
     * [deleteIty description]
     * @return [type] [description]
     */
    Public function deleteIty() {
       if($this->db->delLocalIty($this->lid)){
          $this->success('删除成功',U(MODULE_NAME.'/Locality/index'));
       }else{
          $this->error('删除失败');
       }
    }

    /**
     * 修改地区处理
     * [saveIty description]
     * @return [type] [description]
     */
    Public function saveIty() {
       if(IS_GET == true){
          $ity = $this->db->getLocalIty($this->lid);
          $this->assign('itys',$ity)->display();
       }else{
          $data = $this->getData();
          $result = $this->db->saveLocalIty($data,$this->lid);
         if($result){
            $this->success('修改成功',U(MODULE_NAME.'/Locality/index'));
          }else{
            $this->error('修改失败');
          }
       }
    }

    /**
     * 获取表单提交的值
     * [getData description]
     * @return [type] [description]
     */
    Private function getData() {
       $data = array();
       $data['lid'] = I('lid','','intval');
       $data['lname'] = I('lname');
       $data['sort'] = I('sort','','intval');
       $data['display'] = I('display','','intval');
       $data['pid'] = I('pid','','intval');
       return $data;
    }


}




