<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<link rel="stylesheet" type="text/css" href="/group/Data/bootstrap/css/bootstrap.css" />
    <script type="text/javascript" src='/group/Data/bootstrap/js/bootstrap.js'></script>

<title>商铺修改</title>
</head>
<body>
<form action="<?php echo U(MODULE_NAME.'/Shop/saveShop');?>" method="post" accept-charset="utf-8">

   <table class="table table-striped table-bordered table-hover"> 
     <tr>
      <th>商铺ID</th>
      <th>商铺名称</th>
      <th>商铺地址</th>
      <th>地铁地址</th>
      <th>商铺电话</th>
      <th>商铺坐标</th>
     </tr>
     <tr>
      <td><?php echo ($shop["shopid"]); ?>
        <input type="hidden" name="shopid" value="<?php echo ($shop["shopid"]); ?>">
      </td>
      <td>
         <input type="text" name="shopname" value="<?php echo ($shop["shopname"]); ?>">
      </td>
      <td>
         <input type="text" name="shopaddress" value="<?php echo ($shop["shopaddress"]); ?>">
      </td>
      <td>
         <input type="text" name="metroaddress" value="<?php echo ($shop["metroaddress"]); ?>">
      </td>
        <td>
           <input type="text" name="shoptel" value="<?php echo ($shop["shoptel"]); ?>">
        </td>
        <td>
           <input type="text" name="shopcoord" value="<?php echo ($shop["shopcoord"]); ?>">
        </td>
     </tr>
   </table>
     <div style="margin-top: 10px;" align="center"><input type="submit" value="保存修改" class="btn btn-primary"></div>
   </form>
</body>
</html>