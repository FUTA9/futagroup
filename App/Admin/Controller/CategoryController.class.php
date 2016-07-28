<?php  

namespace Admin\Controller;

use Think\Controller;

use Classlib\Category;

Class CategoryController extends CommonController {
  
    Private $cid;

    /**
     * 执行方法前自动加载
     * [_auto description]
     * @return [type] [description]
     */
    Public function _auto() {
        $this->db = D('Category');
        $this->cid = I('cid','','intval');
    }

    /**
     * 分类显示方法
     * [index description]
     * @return [type] [description]
     */
    Public function index() {
        $categorys = M('category')->order('sort ASC')->select();
        $cate = new \Classlib\Category();
        $datas = $cate->unlimitForLevel($categorys,'--');
        $this->assign('cate',$datas)->display();
    }

    /**
     * 添加分类处理
     * [addCate description]
     */
    Public function addCate() {
      	if(IS_GET == true){
          $pid = I('pid', 0, 'intval');
          $this->assign('pid', $pid)->display();
        }else{
          $data = $this->getData();
          $result = $this->db->addCates($data);
          if($result){
            $this->success('添加成功',U(MODULE_NAME.'/Category/index'));
          }else{
            $this->error('添加失败');
          }
        }
    }

    /**
     * 删除分类处理
     * [deleteCate description]
     * @return [type] [description]
     */
    Public function deleteCate() {
        $result = $this->db->delCates($this->cid);
        if($result){
            $this->success('删除成功',U(MODULE_NAME.'/Category/index'));
        }else{
            $this->error('删除失败');
        }
    }

    /**
     * 修改分类处理
     * [saveCate description]
     * @return [type] [description]
     */
    Public function saveCate() {
        if(IS_GET == true){
           $cate = $this->db->getCates($this->cid);
           $this->assign('cate',$cate)->display();
        }else{
           $data = $this->getData();
           $result = $this->db->saveCates($data,$this->cid);
           if($result){
              $this->success('添加成功',U(MODULE_NAME.'/Category/index'));
           }else{
              $this->error('添加失败');
           }
        }
    }


    /**
     * 获取表单提交数据
     * [getData description]
     * @return [type] [description]
     */
     Private function getData() {
        $data = array();
        $data['cid'] = I('cid','','intval');
        $data['cname'] = I('cname');
        $data['keywords'] = I('keywords');
        $data['title'] = I('title');
        $data['description'] = I('description');
        $data['sort'] = I('sort','','intval');
        $data['display'] = I('display','','intval');
        $data['pid'] = I('pid','','intval');
        return $data;
     }

}