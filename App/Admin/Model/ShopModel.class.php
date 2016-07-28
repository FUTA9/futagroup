<?php  

namespace Admin\Model;
use Think\Model;

Class ShopModel extends Model {

    Public $tableName = 'shop';
    Public $tablePrefix = 'gr_'; 


    Public function addShops ($data) {
       return $this->add($data);
    }

    Public function getShops ($shopid) {
		return $this->where(array('shopid'=>$shopid))->find(); 
	}


    Public function delShops($shopid) {
        return $this->where(array('shopid'=>$shopid))->delete();
    }

    /**
     * @param  [type] $shopid [description]
     * @param  [type] $data   [description]
     * @return [type]         [description]
     */
    Public function saveShops($shopid,$data) {
        return $this->where(array('shopid'=>$shopid))->save($data);
    } 
	

}





