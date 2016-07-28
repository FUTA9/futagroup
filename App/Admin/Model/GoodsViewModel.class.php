<?php 

namespace Admin\Model;
use Think\Model\ViewModel; 

Class GoodsViewModel extends ViewModel {

    Public $tablePrefix = 'gr_';
	Public $tableName = 'goods';

	/**
	 * 设定关联表
	 * [$viewFields description]
	 * @var array
	 */
	Public $viewFields = array(
       'goods'=>array(
          'gid','cid','lid','main_title','sub_title','price','old_price','buy','goods_img',
          '_type'=>'INNER'
        ),
       'category'=>array(
          'cid','cname','keywords','title','description','sort','display','pid',
          '_on'=>'goods.cid = category.cid',
          '_type'=>'INNER'       
        ),
       'shop'=>array(
          'shopid','shopname','shopaddress','metroaddress','shoptel','shopcoord',
          '_on'=>'goods.shopid = shop.shopid',
          '_type'=>'INNER'
        ),
       'locality'=>array(
           'lid','lname',
           '_on'=>'goods.lid = locality.lid'
        ),
       'goods_detail'=>array(
           'goods_id','goods_server','detail',
           '_on'=>'goods.gid = goods_detail.goods_id'
        ) 
  	);	

	/**
	 * 添加数据
	 * [addGoods description]
	 * @param [type] $data [description]
	 */
	Public function addGoods($data) {
		$gid = $this->table('gr_goods')->add($data['goods']);
		$data['goods_detail']['goods_id'] = $gid;
		return $this->table('gr_goods_detail')->add($data['goods_detail']);
	}

	/**
	 * 获取所有商品
	 * [getGoodsAll description]
	 * @return [type] [description]
	 */
	Public function getGoodsAll($limit) {
		return $this->limit($limit)->order('gid DESC')->select();
	}

	/**
	 * 获取商品单条数据
	 * [getGoodsFind description]
	 * @param  [type] $gid [description]
	 * @return [type]      [description]
	 */
	Public function getGoodsFind($gid) {
		return $this->where(array('gid'=>$gid))->find();
	}

	/**
	 * 修改商品处理
	 * [editGoods description]
	 * @param  [type] $data [description]
	 * @param  [type] $gid  [description]
	 * @return [type]       [description]
	 */
	Public function editGoods($data,$gid) {	
		$count = 0;
		$count += $this->table('gr_goods')->where(array('gr_goods.gid'=>$gid))->save($data['goods']);	
	 	$count += $this->table('gr_goods_detail')->where(array('gr_goods_detail.goods_id'=>$gid))->save($data['goods_detail']);
	 	if($count = 2){
			return ($count = 2);
		}
	}

	/**
	 * 删除商品
	 * [delGoods description]
	 * @param  [type] $gid [description]
	 * @return [type]      [description]
	 */
	public function delGoods($gid){
	   $count = 0;
	   $count += $this->table('gr_goods_detail')->where(array('gr_goods_detail.goods_id'=>$gid))->delete();
	   $count += $this->table('gr_goods')->where(array('gr_goods.gid'=>$gid))->delete();
	   return ($count == 2);
	}

}

