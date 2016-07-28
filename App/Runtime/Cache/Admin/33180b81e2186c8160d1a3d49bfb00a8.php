<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script type="text/javascript" src="/group/App/Admin/View/Public/Js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/group/App/Admin/View/Public/Js/index.js"></script>
<link rel="stylesheet" href="/group/App/Admin/View/Public/Css/public.css" />
<link rel="stylesheet" href="/group/App/Admin/View/Public/Css/index.css" />
<link rel="stylesheet" type="text/css" href="/group/Data/bootstrap/css/bootstrap.css" />
<script type="text/javascript" src='/group/Data/bootstrap/js/bootstrap.js'></script>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<title>网站后台</title>
<base target="iframe"/>
<head>
</head>
<body>
	<div id="top">
		<div class="menu">
			<a href="#">会员列表</a>
			<a href="<?php echo U(MODULE_NAME.'/Locality/index');?>">地区列表</a>
			<a href="<?php echo U(MODULE_NAME.'/Category/index');?>">分类列表</a>
			<a href="<?php echo U(MODULE_NAME.'/Shop/index');?>">商铺列表</a>
			<a href="<?php echo U(MODULE_NAME.'/Goods/index');?>">商品列表</a>
			<a href="#">订单列表</a>
		</div>
		<div class="exit">
			<a href="#" target="_self">退出</a>
			<a href="http://bbs.houdunwang.com" target="_blank">获得帮助</a>
			<a href="/group/index.php" target="_blank">站点主页</a>
		</div>
	</div>
	<div id="left">
		<dl>
			<dt>会员管理</dt>
			<dd><a href="#">功能标题</a></dd>
			<dd><a href="#">功能标题</a></dd>
			<dd><a href="#">功能标题</a></dd>
		
		</dl>
		<dl>
			<dt>地区管理</dt>
			<dd><a href="<?php echo U(MODULE_NAME.'/Locality/index');?>">地区列表与管理</a></dd>
			<dd><a href="<?php echo U(MODULE_NAME.'/Locality/addIty');?>">添加地区</a></dd>
		</dl>
		<dl>
			<dt>分类管理</dt>
			<dd><a href="<?php echo U(MODULE_NAME.'/Category/index');?>">分类列表与管理</a></dd>
			<dd><a href="<?php echo U(MODULE_NAME.'/Category/addCate');?>">添加分类</a></dd>
		</dl>
		<dl>
			<dt>商铺管理</dt>
			<dd><a href="<?php echo U(MODULE_NAME.'/Shop/index');?>">商铺列表与管理</a></dd>
			<dd><a href="<?php echo U(MODULE_NAME.'/Shop/addShop');?>">添加商铺</a></dd>	
		</dl>
		<dl>
			<dt>商品管理</dt>
			<dd><a href="<?php echo U(MODULE_NAME.'/Goods/index');?>">商品列表与管理</a></dd>
			<dd><a href="<?php echo U(MODULE_NAME.'/Goods/addGoods');?>">添加商品</a></dd>
		</dl>
		<dl>
			<dt>订单管理</dt>
			<dd><a href="#">功能标题</a></dd>
			<dd><a href="#">功能标题</a></dd>
			<dd><a href="#">功能标题</a></dd>
		</dl>
	</div>
	<div id="right">
		<iframe name="iframe" src="#"></iframe>
	</div>
</body>
</html>