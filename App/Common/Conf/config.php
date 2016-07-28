<?php
return array(
	//'配置项'=>'配置值'

  	'DB_HOST'=>'127.0.0.1',
    'DB_USER'=>'root',
    'DB_PWD' =>'futa9',
    'DB_NAME'=>'group',
    'DB_PREFIX'=>'gr_',
    'DB_TYPE'=>'mysql',
    'DB_CHARSET' => 'utf8',
    'DB_PORT' => '3306',
    
     //点语法解析
     'TMPL_VAR_IDENTIFY'=>'array',

   //减少模板一个文件夹目录
   //'TMPL_FILE_DEPR'=>'_',

     'URL_MODEL'=>2,

   //第三方类库定义
     'AUTOLOAD_NAMESPACE' => array(
      'Classlib' => APP_PATH.'/Classlib',
    ),

/***********************url配置*****************************************/

    "HTTPS"                         => FALSE,       //基于https协议
    "URL_REWRITE"                   => 1,           //url重写模式
    "URL_TYPE"                      => 1,           //类型 1:PATHINFO模式 2:普通模式 3:兼容模式
    "PATHINFO_DLI"                  => "/",         //PATHINFO分隔符
    "PATHINFO_VAR"                  => "q",         //兼容模式get变量
    "PATHINFO_HTML"                 => ".html",     //伪静态扩展名
  /********************************url变量********************************/
    "VAR_APP"                       => "a",         //应用变量名，应用组模式有效
    "VAR_CONTROL"                   => "c",         //模块变量
    "VAR_METHOD"                    => "m",         //动作变量

);