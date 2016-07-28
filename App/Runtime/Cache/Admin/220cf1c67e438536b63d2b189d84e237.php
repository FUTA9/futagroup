<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<link rel="stylesheet" type="text/css" href="/group/Data/bootstrap/css/bootstrap.css" />
    <script type="text/javascript" src='/group/Data/bootstrap/js/bootstrap.js'></script>

<title>地区修改</title>
</head>
<body>
<form action="<?php echo U(MODULE_NAME.'/Locality/saveIty');?>" method="post" accept-charset="utf-8">

   <table class="table table-striped table-bordered table-hover"> 
     <tr>
      <th>地区ID</th>
      <th>地区名称</th>
      <th>地区排序</th>
      <th>是否显示</th>
     </tr>
     <tr>
      <td><?php echo ($alterIty["lid"]); ?>
        <input type="hidden" name="lid" value="<?php echo ($alterIty["lid"]); ?>">
      </td>
      <td>
         <input type="text" name="lname" value="<?php echo ($alterIty["lname"]); ?>" ></td>
      <td>
         <input type="text" name="sort" value="<?php echo ($alterIty["sort"]); ?>" >
      </td>
      <td>
        <!-- <input type="text" name="display" value="" placeholder="<?php echo ($alterIty["display"]); ?>"> -->
          显示 <input type="radio" name="display" value="1" placeholder="" checked="checked">&nbsp;&nbsp;
          不显示 <input type="radio" name="display" value="2" placeholder="">
      </td>
     </tr>
   </table>
     <div style="margin-top: 10px;" align="center"><input type="submit" value="保存修改" class="btn btn-primary"></div>
   </form>
</body>
</html>