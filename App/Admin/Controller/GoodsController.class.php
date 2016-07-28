<?php   

namespace Admin\Controller;

use Think\Controller;
use Think\Model\ViewModel; 
use Classlib\UploadFile;

Class GoodsController extends CommonController {

	Private $gid;

	Public function _auto() {
		$this->gid = I('gid','','intval');
		$this->db = D('GoodsView');
	}



	/**
	 * 商品表单列表
	 * [index description]
	 * @return [type] [description]
	 */
	Public function index() {
		$count = M('goods')->count();
		$page = new \Think\Page($count, 20);
		$limit = $page->firstRow.','.$page->listRows;
		$this->page = $page->show();
		$goods = $this->db->getGoodsAll($limit);
		$this->assign('goods',$goods)->display();
	}


	/**
	 * 添加商品
	 * [addGoods description]
	 */
	Public function addGoods() {
		if(IS_GET == true){
			$this->setShop();//调用当前商品对应商铺信息
			$this->setCategory();//调用当前商品对应商铺信息
			$this->setLocality();//调用当前商品对应地区信息 
			$this->assign('goods_server',C('goods_server'));
			$this->display();
		}else{
			//$this->upload();//调用当前商品的图片上传 
			$data = $this->getData();
			$result = $this->db->addGoods($data);
			if($result){
				$this->success('添加成功',U(MODULE_NAME.'/Goods/index'));
			}else{
				$this->error('添加失败');
			}
		}

	}

	/**
	 * 修改商品
	 * [saveGoods description]
	 * @return [type] [description]
	 */
	Public function saveGoods() {
		if(IS_GET == true){
			$goods = $this->db->getGoodsFind($this->gid);
			$this->setCategory();
			$this->setLocality();
			$this->setShop();
			$this->cid = D('Category')->getCates($goods['cid']); 
   		    $this->aid = D('Locality')->getLocalIty($goods['lid']);
			$this->assign('server',C('goods_server'));
			$goods['goods_server'] = unserialize($goods['goods_server']);//提交时序列化了，使用需要反序列化
			$this->assign('goods',$goods);
			$this->display();
		}else{
			$data = $this->getData();
			$this->delOldFile(I('old_img'));
			$result = $this->db->editGoods($data,$this->gid);
			if($result) {
				$this->success('修改成功',U(MODULE_NAME.'/Goods/index'));
			}else{
				$this->error('修改失败');
			}  
		} 
	}

	/**
	 * 分配当前商品对应商铺的信息
	 * [setShop description]
	 */
	private function setShop() {
		$shopid = I('shopid','','intval');
		$db = D('Shop');
		$shop = $db->getShops($shopid);
		$this->assign('shop',$shop);
	}

	/**
	 * 分配当前商品对应商铺信息
	 * [setCategory description]
	 */
	Private function setCategory() {
		$db = D('Category');
		$categorys = $db->getCategoryAll();
		$cate = new \Classlib\Category();
		$data = $cate->unlimitForLevel($categorys,'--');
		$this->assign('cate',$data);
	}

	/**
	 * 分配当前商品对应地区信息
	 * [setLocality description]
	 */
	Private function setLocality() {
		$db = D('Locality');
		$localitys = $db->getLocalItyAll();
		$ity = new \Classlib\Locality();
        $data = $ity->unlimitForLevel($localitys,'--');
        $this->assign('ity',$data);
	}

	/**
	 * 表单数据获取
	 * [getData description]
	 * @return [type] [description]
	 */
	Private function getData() {

		$upload = new \Classlib\UploadFile();
		$upload ->autoSub = 'true'; //开启子目录上传
        $upload ->subType = 'date'; //子目录创建方式
        $upload ->dateFormat ='Ymd'; //按照时间的年月
		$upload->maxSize  = 3145728 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png');// 设置附件上传类型
		$upload->savePath =  './Public/Uploads/';// 设置附件上传目录
		$upload->thumb = true; //设置开启生成缩略图
		$upload->thumbPrefix =  '';// 缩略图前缀
		$upload->thumbSuffix = '_460x280,_200x100,_310x185,_90x55';  //缩略图后缀
		$upload->thumbMaxWidth = '460,200,310,90';// 缩略图最大宽度
        $upload->thumbMaxHeight =  '280,100,185,55';// 缩略图最大高度
        $upload->thumbType = 1;// 缩略图生成方式 1 按设置大小截取 0 按原图等比例缩略
  	    if(!$upload->upload()) {// 上传错误提示错误信息
		    $this->error($upload->getErrorMsg());
	  	}else{// 上传成功 获取上传文件信息
			$image =  $upload->getUploadFileInfo();
		}
		$url = substr($image[0]['savepath'],1).$image[0]['savename'];






	/*	$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   = 3145728 ;// 设置附件上传大小
		$upload->exts      = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  = './Public/Uploads/'; // 设置附件上传根目录
		$upload->savePath  = ''; // 设置附件上传（子）目录
		$upload->autoSub  = true;
		$upload->subName  = array('date','Y-m-d');
		$info   =   $upload->upload(I('goods_img'));
		if(!$info) {// 上传错误提示错误信息
		    $this->error($upload->getError());
		}else{// 上传成功
	   		$image = $info['goods_img']['savepath'].$info['goods_img']['savename'];

   		*/

	   	/*
	   		$newimage = new \Think\Image();
	   		$newimage->open($upload->upload(I('goods_img')));
	   		$newimage->thumb(460, 280)->save(__ROOT__.'/Publiic/Uploads'.$image.'_460x280.jpg');
	   		$newimage->thumb(200, 100)->save(__ROOT__.'/Publiic/Uploads/'.$image.'_200x100.jpg');
	   		$newimage->thumb(310, 180)->save(__ROOT__.'/Publiic/Uploads/'.$image.'_310x180.jpg');
	   		$newimage->thumb(99, 55)->save(__ROOT__.'/Publiic/Uploads/'.$image.'_99x55.jpg'); 
		} */

		//表单提交数据
		$data = array();
		$data['goods']['gid'] = I('gid','','intval');
		$data['goods']['cid'] = I('cid','','intval');
		$data['goods']['lid'] = I('lid','','intval');
		$data['goods']['shopid'] = I('shopid','','intval');
		$data['goods']['price'] = I('price','','intval');
		$data['goods']['old_price'] = I('old_price','','intval');
		$data['goods']['main_title'] = I('main_title');
		$data['goods']['sub_title'] = I('sub_title');     
        $data['goods']['begin_time'] = I('begin_time','','strtotime');
		$data['goods']['end_time'] = I('end_time','','strtotime'); 
	    $data['goods_detail']['detail'] = I('detail');
	    $data['goods_detail']['goods_server'] = serialize(I('goods_server'));

	    //删除旧图处理
	    if(isset($image)){
          	if(isset($_POST['old_img'])){
				$this->delOldFile(I('old_img'));
			}
      		$data['goods']['goods_img'] = $url;  
      	}
	    return $data;
	}

	/**
	 * 删除旧图片处理
	 * [delOldFile description]
	 * @param  [type] $img [description]
	 * @return [type]      [description]
	 */
	private function delOldFile($img){
		$pathInfo = pathinfo($img);
		$oldFiles = array(
			__ROOT__.'/Public/Uploads/'.$img,
			__ROOT__.'/Public/Uploads/'.$pathInfo['dirname'].'/'.$pathInfo['filename'].'_460x280.'.$pathInfo['extension'],
			__ROOT__.'/Public/Uploads/'.$pathInfo['dirname'].'/'.$pathInfo['filename'].'_200x100.'.$pathInfo['extension'],
			__ROOT__.'/Public/Uploads/'.$pathInfo['dirname'].'/'.$pathInfo['filename'].'_310x185.'.$pathInfo['extension'],
			__ROOT__.'/Public/Uploads/'.$pathInfo['dirname'].'/'.$pathInfo['filename'].'_90x55.'.$pathInfo['extension'],
		);
		foreach ($oldFiles as $v){
			if(file_exists($v)) unlink($v);
		}
	}

	/**
	 * 删除商品处理
	 * [deleteGoods description]
	 * @return [type] [description]
	 */
	Public function deleteGoods() {
		$result = $this->db->delGoods($this->gid);
		if($result){
			$this->success('删除成功',U(MODULE_NAME.'/Goods/index'));
		}else{
			$this->error('删除失败');
		}
	}





}