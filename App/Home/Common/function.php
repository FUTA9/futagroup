<?php  

 function url_param_remove($var, $url = null){
//	import('Classlib.Route',APP_PATH);
 	$urls = new \Classlib\Route();
//    return Route::removeUrlParam($var,$url);
 	$result = $urls->removeUrlParam($var,$url);
 	return $result;


}



