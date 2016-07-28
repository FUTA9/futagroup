<?php   
namespace Classlib;

/**
 * 无限分级类
 * @author Administrator
 *
 */
Class Category {

	//组合一维数组
	static function unlimitForLevel($cate, $html = '--', $pid = 0, $level = 0){
		$arr = array();
		foreach ($cate as $v){
			if($v['pid'] == $pid){
				$v['level'] = $level + 1;
				$v['html'] = str_repeat($html, $level);
				$arr[] = $v;
				$arr = array_merge($arr, self::unlimitForLevel($cate, $html, $v['cid'], $level + 1));
			}
		}
		
		return $arr;
	}
	
	//组合多维数组
	static function unlimitForLayer($cate, $pid = 0, $cname= 'child'){
		$arr = array();
		foreach ($cate as $v){
			if($v['pid'] == $pid){
				$v[$cname] = self::unlimitForLayer($cate, $v['cid'], $cname);
				$arr[] = $v;
			}
		}
	
		return $arr;
	}
	
	//传递子分类的id返回所有的父级分类
	static function getParents($cate, $id){
		$arr = array();
		foreach($cate as $v){
			if($v['cid'] == $cid){
				$arr[] = $v;
				$arr = array_merge(self::getParents($cate, $v['pid']), $arr);
			}
		}
		
		return $arr;
	}
	
	//传递父级id返回所有子级id
	static function getChildsId($cate, $pid){
		$arr = array();
		foreach($cate as $v){
			if($v['pid'] == $pid){
				$arr[] = $v['cid'];
				$arr = array_merge($arr, self::getChildsId($cate, $v['cid']));
			}
		}
		
		return $arr;
	}
	
	//传递父级id返回所有子级分类
	static function getChilds($cate, $pid){
		$arr = array();
		foreach($cate as $v){
			if($v['pid'] == $pid){
				$arr[] = $v;
				$arr = array_merge($arr, self::getChilds($cate, $v['cid']));
			}
		}
		
		return $arr;
	}
	
}
