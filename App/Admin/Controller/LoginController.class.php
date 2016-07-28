<?php  

namespace Admin\Controller;
use Think\Controller;

Class LoginController extends Controller {

    Public function index () {
         $this->display();
    }


    Public function verify () {
       
       $config = array(
    		'fontSize'    =>    15,    // 验证码字体大小    
    		'length'      =>    4,     // 验证码位数
        'useNoise'    =>    false // 关闭验证码杂点   
    	);

       $verify = new \Think\Verify($config);
       $verify->entry();

  }


    Public function login () {
      if(!IS_POST) E('页面不存在');


       $Verify = new \Think\Verify();
    	if(!$Verify->check(I('code'))){
    		$this->error('验证码错误！');
    	}

/*
      $code= I('code');                //这是提取页面上打字输入的code即验证码
        if(check_code($code) === false){       //给function.php中定义的函数check_code，然后它返回真假
        $this->error('验证码错误');
        }
*/
       $db = M('admin');

       $user = $db->where(array('uname'=>I('username')))->find();  
       
       
       if(!$user || $user['password'] != I('password','','md5')){
           $this->error('账号或密码错误');
       }
      
       //更新最后登录时间
       $data = array(
       'id' =>$user['uid'],
       'logintime' => time(),
     	 );



      $db->save($data);



      session('uid',$user['uid']);
      session('username',$user['uname']);
      session('logintime',date('Y-m-d H:i:s',$user['logintime']));

      redirect(__MODULE__);



    }



}