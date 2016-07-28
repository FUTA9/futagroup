<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<link rel="stylesheet" type="text/css" href="/group/Data/bootstrap/css/bootstrap.css" />
    <script type="text/javascript" src='/group/Data/bootstrap/js/bootstrap.js'></script>

<title>分类列表</title>
</head>
<body>

   <table class="table table-striped table-bordered table-hover"> 
   	 <tr>
      <th>分类ID</th>
   	 	<th>分类名称</th>
   	 	<th>分类关键字</th>
   	 	<th>分类标题</th>
   	 	<th>分类描述</th>
   	 	<th>分类排序</th>
   	 	<th>是否显示</th>
   	 	<th>操作</th>
   	 </tr>
   <?php if(is_array($cate)): foreach($cate as $key=>$v): ?><tr>
     	<td><?php echo ($v["cid"]); ?></td>
     	<td><?php echo ($v["html"]); echo ($v["cname"]); ?></td>
     	<td><?php echo ($v["keywords"]); ?></td>
     	<td><?php echo ($v["title"]); ?></td>
     	<td><?php echo ($v["description"]); ?></td>
     	<td><?php echo ($v["sort"]); ?></td>
     	<td><?php echo ($v["display"]); ?></td>
     	<td>
     		[<a href="<?php echo U(MODULE_NAME.'/Category/addCate',array('pid'=>$v['cid']));?>" style="color: blue;">添加子分类</a>]
            [<a href="<?php echo U(MODULE_NAME.'/Category/alterCate',array('id'=>$v['cid']));?>">修改</a>]
            [<a href="<?php echo U(MODULE_NAME.'/Category/deleteCate', array('id' => $v['cid']));?>" style="color: red;" onclick="return confirm('你确定要删除？')">删除</a>]
     	</td>
     </tr><?php endforeach; endif; ?>
   </table>
</body>
</html>