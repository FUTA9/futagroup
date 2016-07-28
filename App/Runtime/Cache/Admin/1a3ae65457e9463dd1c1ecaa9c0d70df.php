<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<link rel="stylesheet" type="text/css" href="/group/Data/bootstrap/css/bootstrap.css" />
    <script type="text/javascript" src='/group/Data/bootstrap/js/bootstrap.js'></script>

<title>添加商铺</title>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=AB6UhYmkURBaaKe1PaW2uGsa2GH4RwwR"></script>

<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>

</head>
<body>
<form action="<?php echo U(MODULE_NAME.'/Shop/addShop');?>" method="post" accept-charset="utf-8">
    <table class="table table-bordered table-hover ">
    	<tr>
    	   <th><b style="font-size: 20px;">添加商铺:</b></th>
    	</tr>
        <tr>
        	<td align="right">商铺名称:</td>
        	<td>
            <input type="text" name="shopname" value="" placeholder="在这里输入名称">
          </td>
        </tr>
        <tr>
        	<td align="right">商铺地址:</td>
        	<td>
              <input type="text" name="shopaddress" value="" placeholder="在这里输入地址">
        	</td>
        </tr>
        <tr>
          <td align="right">地铁地址</td>
          <td>
             <input type="text" name="metroaddress" value="" placeholder="在这里输入地址">
          </td>
        </tr>
        <tr>
          <td align="right">商铺电话</td>
          <td>
            <input type="text" name="shoptel" value="" placeholder="在这里输入电话">
          </td>
        </tr>
        <tr>
          <td align="right">商铺坐标</td>
          <td>
             <input type="text" id='shopcoord' name="shopcoord" value="" placeholder="">
             <input type="button" id='point' name="" class="btn btn-primary" value="获取坐标">
          </td>
        </tr>
    </table>
        <div>
   <!--        <script type="text/javascript">
              $(function(){
                $('#point').click(function(){
                  var point = $('#shopcoord').val();
                  if (point == "") {
                     return false;
                  } else {
                    $.ajax({
                       url:'http://localhost/group/index.php/Admin/Shop/getPoint',//请求地址
                       dataType:'json',//返回数据类型
                       data:'point='+point,//返回数据参数
                       type:'post',//请求数据类型
                       success:function(data){
                          if (data.status == 1) {
                            $('#shopcoord').val(data.point);
                          } 
                       }
                    })
                  }
                })
                 
              })
            </script> -->

             
    <!--     <script type="text/javascript">
               $(function(){    //页面全局请求完成后执行
                  $('#point').cilck(function(){ //点击id为point按钮后执行方法
                      var point = $('#shopcoord').val(); //变量(点击point按钮)point获取ID为shopcoord里的值
                         if(point == ""){
                          return false; //判断point为空,返回假(即返回不继续执行)
                         } else {
                            $.ajax({
                              url:'http://localhost/group/index.php/Admin/Shop/getPoint', //请求来源(getPoint为控制器里的方法)
                              dataType:'json', //返回(or请求的数据)数据类型为json
                              data:'point='+point, //返回数据参数(类似'id='.id)(+为连接符)
                              type:'post', //请求方式(post or get)
                              success:function(data){  //成功时把data获取到的内容传入方法
                               if (data.status == 1) {   //判断为真
                                 $('#shopcoord').val(data.point);  //把(方法里返回的point值)返回的数据赋值给ID为shopcoord
                                  } 
                              }


                            })


                         }


                  })

               })             
 
            </script> -->


       
           

       <script type="text/javascript">
                  $(function(){
                    /*
                       点击获取坐标
                      */
                      $('#point').click(function(){
                        if($('#shopcoord').val() == ''){
                           alert("请您输入一个地址")
                        }
                        var adds = $('#shopcoord').val();
                        getPoint(adds);
                      }) 
                  });
                  function getPoint(adds){
                      var myGeo = new BMap.Geocoder();
                  // 将地址解析结果显示在地图上,并调整地图视野
                  myGeo.getPoint(adds, function(point){
                    $('#shopcoord').val(JSON.stringify(point));
                  }, "福州市");
                  }

            </script>

            
       <script type="text/javascript">
          function getPoint (adds){   // 创建地址解析器实例
                var myGeo = new BMap.Geocoder();
                // 将地址解析结果显示在地图上,并调整地图视野
                 myGeo.getPoint(adds,function(point){ 
                    $("#shopcoord").val(JSON.stringify(point));
                 },"北京市");
               }


        </script>
       
        </div>
    <p align="center"><input type="submit" value="保存添加" class="btn btn-primary" style="margin:10px"></p>
</form>
</body>
</html>