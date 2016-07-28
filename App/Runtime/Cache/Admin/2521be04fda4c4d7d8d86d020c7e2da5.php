<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<link rel="stylesheet" type="text/css" href="/group/Data/bootstrap/css/bootstrap.css" />
    <script type="text/javascript" src='/group/Data/bootstrap/js/bootstrap.js'></script>

<title>地区列表</title>
</head>
<body>

   <table class="table table-striped table-bordered table-hover"> 
   	 <tr>
      <th>地区ID</th>
   	 	<th>地区名称</th>
   	 	<th>地区排序</th>
   	 	<th>是否显示</th>
   	 	<th>操作</th>
   	 </tr>
   <?php if(is_array($ity)): foreach($ity as $key=>$v): ?><tr>
     	<td><?php echo ($v["lid"]); ?></td>
     	<td><?php echo ($v["html"]); echo ($v["lname"]); ?></td>
     	<td><?php echo ($v["sort"]); ?></td>
     	<td><?php echo ($v["display"]); ?></td>
     	<td>
     		[<a href="<?php echo U(MODULE_NAME.'/Locality/addIty',array('pid'=>$v['lid']));?>" style="color: blue;">添加子地区</a>]
            [<a href="<?php echo U(MODULE_NAME.'/Locality/alterIty',array('lid'=>$v['lid']));?>">修改</a>]
            [<a href="<?php echo U(MODULE_NAME.'/Locality/deleteIty',array('lid'=>$v['lid']));?>" style="color: red;" onclick="return confirm('你确定要删除？')">删除</a>]
     	</td>
     </tr><?php endforeach; endif; ?>
   </table>
</body>
</html>