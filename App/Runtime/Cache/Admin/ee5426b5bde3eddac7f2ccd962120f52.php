<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<link rel="stylesheet" type="text/css" href="/group/Data/bootstrap/css/bootstrap.css" />
    <script type="text/javascript" src='/group/Data/bootstrap/js/bootstrap.js'></script>

<title>分类列表</title>
</head>
<body>
<form action="<?php echo U(MODULE_NAME.'/Category/saveCate');?>" method="post" accept-charset="utf-8">

   <table class="table table-striped table-bordered table-hover"> 
     <tr>
      <th>分类ID</th>
      <th>分类名称</th>
      <th>分类关键字</th>
      <th>分类标题</th>
      <th>分类描述</th>
      <th>分类排序</th>
      <th>是否显示</th>
     </tr>
     <tr>
      <td><?php echo ($alterCate["cid"]); ?>
        <input type="hidden" name="cid" value="<?php echo ($alterCate["cid"]); ?>">
      </td>
      <td>
         <input type="text" name="cname" value="<?php echo ($alterCate["cname"]); ?>"></td>
      <td>
         <input type="text" name="keywords" value="<?php echo ($alterCate["keywords"]); ?>">
      </td>
      <td>
         <input type="text" name="title" value="<?php echo ($alterCate["title"]); ?>">
      </td>
      <td>
         <input type="text" name="description" value="<?php echo ($alterCate["description"]); ?>">
      </td>
      <td>
         <input type="text" name="sort" value="<?php echo ($alterCate["sort"]); ?>">
      </td>
      <td>
         显示 <input type="radio" name="display" value="1" placeholder="" checked="checked">&nbsp;&nbsp;
          不显示 <input type="radio" name="display" value="2" placeholder="">
      </td>
     </tr>
   </table>
     <div style="margin-top: 10px;" align="center"><input type="submit" value="保存修改" class="btn btn-primary"></div>
   </form>
</body>
</html>