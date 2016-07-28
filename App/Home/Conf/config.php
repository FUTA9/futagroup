<?php
return array(
	//'配置项'=>'配置值' 
 	'URL_HTML_SUFFIX'=>'',

 	'USER_AUTH_KEY'  =>'uid',       //用户认证识别号,用来写入session

	'TMPL_PARSE_STRING' => array(
		'__PUBLICS__' => __ROOT__.'/'.APP_NAME.'/'.MODULE_NAME.'/View/Public'
	),

	// 开启静态缓存
   // 'HTML_CACHE_ON'=>true,

	//商品服务
	'goods_server'=>array(
	  1=>array(
	     'name'=>'假一赔十',
	     'img' =>'<span class="ico" style="background-position:0px -92px;"></span>'
	  ),
	  2=>array(
	     'name'=>'支持随时退款',
	     'img' =>'<span class="ico" style="background-position:0px 0px;"></span>'
	  ),
	  3=>array(
	     'name'=>'不支持随时退款',
	     'img' =>'<span class="ico" style="background-position:0px -121px;"></span>'
	  )
	),

/***************************价格配置*********************************/
	
	'price' => array(
			'all'=>array(
		      array('100元以下','0-100'),
		      array('100元到200元','100-200'),
		      array('200元到500元','200-500'),
		      array('500元以上','500')
		  	 ),
		   '1'=>array(
		      array('50元以下','0-50'),
		      array('50元到100元','50-100'),
		      array('100元到200元','100-200'),
		      array('200元以上','200')
		   ),
		   '2'=>array(
		      array('50元以下','0-50'),
		      array('50元到100元','50-100'),
		      array('100元到200元','100-200'),
		      array('200元以上','200')
		   ),
		   '3'=>array(
		      array('50元以下','0-50'),
		      array('50元到100元','50-100'),
		      array('100元到200元','100-200'),
		      array('200元以上','200')
		   ),
		   '4'=>array(
		      array('50元以下','0-50'),
		      array('50元到100元','50-100'),
		      array('100元到200元','100-200'),
		      array('200元以上','200')
		   ),
		   '5'=>array(
		      array('50元以下','0-50'),
		      array('50元到100元','50-100'),
		      array('100元到200元','100-200'),
		      array('200元以上','200')
		   ),
		   '6'=>array(
		      array('100元以下','0-100'),
		      array('100元到200元','100-200'),
		      array('200元到500元','200-500'),
		      array('500元以上','500')
		   ),
		   '7'=>array(
		      array('50元以下','0-50'),
		      array('50元到100元','50-100'),
		      array('100元到200元','100-200'),
		      array('200元以上','200')
		   ),
		   '12'=>array(
		      array('50元以下','0-50'),
		      array('50元到100元','50-100'),
		      array('100元到200元','100-200'),
		      array('200元以上','200')
		   )     
	),

	 /********************************分页处理********************************/
    "PAGE_VAR"                      => "page",      //分页GET变量
    "PAGE_ROW"                      => 10,          //页码数量
    "PAGE_SHOW_ROW"                 => 10,          //每页显示条数
    "PAGE_STYLE"                    => 2,           //页码风格
    "PAGE_DESC"                     => array("pre" => "上一页", "next" => "下一页",//分页文字设置
                                           "first" => "首页", "end" => "尾页", "unit" => "条"), 


);