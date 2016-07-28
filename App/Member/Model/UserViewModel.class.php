<?php   

namespace Member\Model;
use Think\Model\ViewModel; 

Class UserViewModel extends ViewModel{

	Public $tableName='user';

	/**
	 * 验证字段是否存在
	 * [check description]
	 * @param  [type] $field [description]
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	Public function check($field,$value){
         return $this->where(array($field=>$value))->count();
	}

    /**
     * 添加用户
     * [addUser description]
     * @param [type] $data [description]
     */
    Public function addUser($data){
        $uid =  $this->table('gr_user')->add($data);
        $data = array('user_id'=>$uid);
        $this->table('gr_userinfo')->add($data);
        return $uid;
    }

    /**
     * 获取用户
     * [getUser description]
     * @param  [type] $where [description]
     * @return [type]        [description]
     */
    Public function getUser($where){
        return $this->table('gr_user')->where($where)->find();
    }

    /**
     * 更新用户密码
     * [savePass description]
     * @param  [type] $where [description]
     * @param  [type] $data  [description]
     * @return [type]        [description]
     */
    Public function savePass($where,$data){
        return $this->table('gr_user')->where($where)->save($data);
    }
    
    /**
     * 添加账户余额
     * [addBalance description]
     * @param [type] $uid [description]
     */
    Public function addBalance($uid){
         return $this->table('gr_userinfo')->where(array('user_id'=>$this->uid))->setInc('balance',10000);
    }

    /**
     * 获取账户余额
     * [getUserBalance description]
     * @param  [type] $uid [description]
     * @return [type]      [description]
     */
    Public function getUserBalance($uid){
        $result = $this->field('balance')->table('gr_userinfo')->where(array('user_id'=>$uid))->find();
        return $result['balance'];
    }
    
    /**
     * 更新账户余额
     * [updateBalance description]
     * @param  [type] $uid [description]
     * @param  [type] $num [description]
     * @return [type]      [description]
     */
    Public function updateBalance($uid,$num){
        $this->table('gr_userinfo')->where(array('user_id'=>$uid))->setDec('balance',$num);
    }
    
    /**
     * 添加收货地址
     * [addAddress description]
     * @param [type] $data [description]
     */
    Public function addAddress($data){
        return $this->table('gr_user_address')->add($data);
    }

    /**
     * 读取收货地址
     * [getAddress description]
     * @param  [type] $uid [description]
     * @return [type]      [description]
     */
    Public function getAddress($uid){
        return $this->table('gr_user_address')->where(array('user_id'=>$uid))->select();
    }
    
    /**
     * 删除收货地址
     * [delAddress description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    Public function delAddress($id){
        return $this->table('gr_user_address')->where(array('addressid'=>$id))->delete();
    }

    /**
     * 验证是否已收藏过订单
     * [checkCollect description]
     * @param  [type] $where [description]
     * @return [type]        [description]
     */
    Public function checkCollect($where){
        return $this->table('gr_collect')->where($where)->count();
    }
    
    /**
     * 添加收藏
     * [addCollect description]
     * @param [type] $data [description]
     */
    Public function addCollect($data){
        return $this->table('gr_collect')->add($data);
    }

    /**
     * 获取所有收藏
     * [getCollect description]
     * @param  [type] $where [description]
     * @return [type]        [description]
     */
    Public function getCollect($where){
        $this->viewFields = array(
          'goods'=>array(
            'main_title','gid','goods_img','price','end_time',
            '_type'=>'INNER'        
          ),
          'collect' => array(
              'collectid','user_id','goods_id',
              '_on'=>'goods.gid = collect.goods_id'
          )
        ); 
        $fields = array(
            'main_title',
                'goods_img',
                'price',
                'end_time',
                'gid');

        return $this->field($fields)->where($where)->select();
    }

    /**
     * 删除收藏
     * [delCollect description]
     * @param  [type] $where [description]
     * @return [type]        [description]
     */
    Public function delCollect($where){
        return $this->table('gr_collect')->where($where)->delete();
    }


}








