<?php 

namespace Home\Model;
use Think\Model\ViewModel; 

Class OrderViewModel extends ViewModel{

/**
   * 读取并判断订单数据
   * [getorder description]
   * @param  [type] $uid [description]
   * @param  [type] $gid [description]
   * @return [type]      [description]
   */
  Public function getorder($uid,$gid){
  	$string ='INNER JOIN gr_user ON gr_user.uid = gr_order.user_id';
     return $this->table('gr_order')->join($string)->where(array('user_id'=>$uid,'goods_id'=>$gid,'status'=>2))->select();
  }

  /**
   * 添加评论
   * [addComments description]
   * @param [type] $where [description]
   * @param [type] $data  [description]
   */
  Public function addComments($where,$data){
    return $this->table('gr_comment')->where($where)->add($data);
  }

  /**
   * 读取评论
   * [getComment description]
   * @return [type] [description]
   */
  Public function getComment($gid,$limit,$order){
    $string ='INNER JOIN gr_user ON gr_comment.user_id = gr_user.uid';
    return $this->table('gr_comment')->where(array('goods_id'=>$gid))->order($order)->limit($limit)->join($string)->select();
  }

  /**
   * 获取品论总数
   * [getCommentTotal description]
   * @return [type] [description]
   */
  Public function getCommentTotal($gid) {
    return $this->table('gr_comment')->where(array('goods_id'=>$gid))->count();
  }

  /**
   * 刪除评论
   * [delComments description]
   * @param  [type] $where [description]
   * @return [type]        [description]
   */
  Public function delComments($where){
    return $this->table('gr_comment')->where($where)->delete();
  }

}