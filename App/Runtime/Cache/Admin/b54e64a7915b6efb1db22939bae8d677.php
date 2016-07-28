<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<link rel="stylesheet" type="text/css" href="/group/Data/bootstrap/css/bootstrap.css" />
    <script type="text/javascript" src='/group/Data/bootstrap/js/bootstrap.js'></script>

<title>商铺列表</title>
</head>
<body>

   <table class="table table-striped table-bordered table-hover"> 
   	 <tr>
      <th>商铺ID</th>
   	 	<th>商铺名称</th>
   	 	<th>商铺地址</th>
   	 	<th>地铁地址</th>
      <th>商铺电话</th>
      <th>商铺坐标</th>
   	 	<th>操作</th>
   	 </tr>
   <?php if(is_array($shop)): foreach($shop as $key=>$v): ?><tr>
     	<td><?php echo ($v["shopid"]); ?></td>
     	<td><?php echo ($v["shopname"]); ?></td>
     	<td><?php echo ($v["shopaddress"]); ?></td>
     	<td><?php echo ($v["metroaddress"]); ?></td>
      <td><?php echo ($v["shoptel"]); ?></td>
      <td><?php echo ($v["shopcoord"]); ?></td>
     	<td>
            [<a href="<?php echo U(MODULE_NAME.'/Shop/saveShop',array('shopid'=>$v['shopid']));?>">修改</a>]
            [<a href="<?php echo U(MODULE_NAME.'/Shop/deleteShop',array('shopid'=>$v['shopid']));?>" style="color: red;" onclick="return confirm('你确定要删除？')">删除</a>]
     	</td>
     </tr><?php endforeach; endif; ?>
   </table>
</body>
</html>