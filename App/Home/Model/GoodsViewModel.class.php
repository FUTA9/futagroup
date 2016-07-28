<?php 

namespace Home\Model;
use Think\Model\ViewModel; 

Class GoodsViewModel extends ViewModel {

  Public $tablePrefix = 'gr_';
  Public $tableName = 'goods';

  public $cids = array();    //需要检索的cid
  public $lids = array();    //需要检索的lid
  public $pricefirst = '';   //需要检索的price
  public $priceend = '';     //需要检索的price
  public $order = '';        //排序规则
  public $keywords = null;     //搜索关键字
  Public $getCids = array();
  Public $getlids = array();

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
        )
  	);	

	/**
	 * 查询商品
	 * [getGoods description]
	 * @return [type] [description]
	 */
	Public function getGoods() {
    return $this->field(array('lid','cid','pid'))->select(); 
	}

  /**
   * 设置搜索条件
   * [setSearch description]
   * @param [type] $limit [description]
   */
  Public function setSearch($limit) {

    $result = null;


    if(!is_null($this->keywords)){
      $map['sub_title'] = array('like',"%$this->keywords%");
      $result = $this->field($field)->where($map)->order($this->order)->limit($limit)->select();
    }
    $field = array('gid','cid','shopid','lid','price','old_price','main_title','sub_title','buy','goods_img');

     //两个条件都存在
    if(!empty($this->cids['cid']) && !empty($this->lids['lid'])){
      $map['cid'] = array('in',$this->cids['cid']);
      $map['lid'] = array('in',$this->lids['lid']);
      $result = $this->field($field)->where($map)->order($this->order)->limit($limit)->select();
    }else{
      //存在分类筛选情况
      if(!empty($this->cids['cid'])){
        $map['cid'] = array('in',$this->cids['cid']);
        $result = $this->field($field)->where($map)->order($this->order)->limit($limit)->select();
      }

      //存在地区筛选情况
      if(!empty($this->lids['lid'])){
        $map['lid'] = array('in',$this->lids['lid']);
        $result = $this->field($field)->where($map)->order($this->order)->limit($limit)->select();
      }

    }
    if(!empty($this->priceend)){
      $map['price'] = array(array('gt',$this->pricefirst),array('lt',$this->priceend));
      $result = $this->field($field)->where($map)->order($this->order)->limit($limit)->select();
    }else{
      $map['price'] = array('gt',$this->pricefirst);
      $result = $this->field($field)->where($map)->order($this->order)->limit($limit)->select();
    }
    
    /*
    $getCid = M('category')->where(array('pid'=>0))->field('cid')->count();
    $getLid = M('locality')->where(array('pid'=>0))->field('lid')->count();
    $setCids = count($this->cids['cid']);
    $setLids = count($this->lids['lid']);
    if($getCid == $setCids && $getLid == $setLids){
      $result = $this->field($field)->order($this->order)->limit($limit)->select();
    }
    */
   
   if(empty($this->cids['cid']) && empty($this->lids['lid'])){
      $result = $this->field($field)->order($this->order)->limit($limit)->select();
   }

    return $result;
      

  }

  /**
   * 获得商品总数
   * [getGoodsTotal description]
   * @return [type] [description]
   */
  Public function getGoodsTotal() {
    //两个条件都存在
    if(!empty($this->cids['cid']) && !empty($this->lids['lid'])){
      $map['cid'] = array('in',$this->cids['cid']);
      $map['lid'] = array('in',$this->lids['lid']);
      $result = $this->where($map)->count();
    }else{
      //存在分类筛选情况
      if(!empty($this->cids['cid'])){
        $map['cid'] = array('in',$this->cids['cid']);
        $result = $this->where($map)->count();
      }

      //存在地区筛选情况
      if(!empty($this->lids['lid'])){
        $map['lid'] = array('in',$this->lids['lid']);
        $result = $this->where($map)->count();
      }
    
    }
    if(!empty($this->priceend)){
      $map['price'] = array(array('gt',$this->pricefirst),array('lt',$this->priceend));
      $result = $this->where($map)->count();
    }else{
      $map['price'] = array('gt',$this->pricefirst);
      $result = $this->where($map)->count();
    }
   
    $getCid = M('category')->where(array('pid'=>0))->field('cid')->count();
    
    $getLid = M('locality')->where(array('pid'=>0))->field('lid')->count();
    
    $setCids = count($this->cids['cid']);
    $setLids = count($this->lids['lid']);

    if($getCid == $setCids && $getLid == $setLids){
      $result = $this->count();
    }


    return $result;
  }

  /**
   * 查询商品细节数据
   * [getGoodsDetail description]
   * @param  [type] $gid [description]
   * @return [type]      [description]
   */
  Public function getGoodsDetail($gid){
    $this->viewFields['goods_detail'] = array(
           'goods_id','goods_server','detail',
           '_on'=>'goods.gid = goods_detail.goods_id',
           '_type'=>'INNER'
    );
    return $this->where(array('gid'=>$gid))->find();
  }

  /**
   * 获取商品分类
   * [getGoodsCid description]
   * @param  [type] $gid [description]
   * @return [type]      [description]
   */
  Public function getGoodsCid($gid){      
    $result = $this->field('cid')->where(array('gid'=>$gid))->find();
    return $result['cid'];
  }

  /**
   * 获得团购商品数
   * [getRelatedGoods description]
   * @param  [type] $cid [description]
   * @return [type]      [description]
   */
  Public function getRelatedGoods($cid){
      $fields = array(
        'main_title',
        'goods_img',
        'price',
        'buy',
        'gid'
      );
        return $this->where(array('cid'=>$cid))->order('buy desc')->limit(5)->select();
  }

  /**
   * 获取热卖商品
   * [getHostGoods description]
   * @return [type] [description]
   */
  Public function getHostGoods(){
        $fields = array(
          'main_title',
          'goods_img',
          'price',
          'old_price',
          'buy',
          'gid'
       );
        return $this->field($fields)->order('buy desc')->limit(5)->select();
  }

  /**
   * 获取热门团购
   * [getHostGroup description]
   * @return [type] [description]
   */
  Public function getHostGroup(){
    $fields = array('cid','cname');
    return $this->field($fields)->order('buy desc')->limit(7)->select();
  }

}