<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<link rel="stylesheet" type="text/css" href="/group/Data/bootstrap/css/bootstrap.css" />
    <script type="text/javascript" src='/group/Data/bootstrap/js/bootstrap.js'></script>

<title>添加商品</title>
</head>
<body>
<form action="<?php echo U(MODULE_NAME.'/locality/runAddIty');?>" method="post" accept-charset="utf-8">
    <table class="table table-bordered table-hover ">
    	<tr>
    	   <th><b style="font-size: 20px;">添加商品:</b></th>
    	</tr>
        <tr>
        	<td align="right">商铺名称:</td>
        	<td>
            <input type="text" name="shopid" value="" >
         </td>
        </tr>
        <tr>
        	<td align="right">地区排序:</td>
        	<td><input type="text" name="sort" value="" placeholder="10">
        	<input type="hidden" name="pid" value="<?php echo ($pid); ?>">
        	</td>
        </tr>
        <tr>
          <td align="right">是否显示:</td>
          <td>显示
          <input type="radio" name="display" checked="checked" value="1">&nbsp;&nbsp;
          不显示
          <input type="radio" name="display" value="2">
          </td>
        </tr>
    </table>
    <p align="center"><input type="submit" value="保存添加" class="btn btn-primary" style="margin:10px"></p>
</form>
</body>
</html>