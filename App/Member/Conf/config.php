<?php   



return array( 

	'TMPL_PARSE_STRING' => array(
		'__PUBLICS__' => __ROOT__.'/'.APP_NAME.'/'.MODULE_NAME.'/View/Public'
	),
     //取消伪静态后缀名
    'URL_HTML_SUFFIX' =>'',
    //cookie缓存时间,设置为三天
    'COOKIE_EXPIRE' => '259200',
    'USER_AUTH_KEY'  =>'uid',       //用户认证识别号,用来写入session

    //session启动
    'SESSION_AUTO_START' =>true


);


