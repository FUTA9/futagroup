<?php 

namespace Member\Controller;
use Think\Controller;

Class RegController extends Controller {

	Public function _initialize() {
		$this->uid = $_SESSION[C('USER_AUTH_KEY')];
		$db = D('Category');
		$loginShow = $_SESSION[C('USER_AUTH_KEY')];
		$this->assign('loginShow',$loginShow);
		$this->nav = $db->getNavCategory(0);
		$this->assign('userIsLogin',isset($_SESSION[C('USER_AUTH_KEY')]));

	}



	/**
	 * 显示模板
	 * [index description]
	 * @return [type] [description]
	 */
	Public function index() {
		$this->display();

	}

	/**
	 * 设定验证码
	 * [showCode description]
	 * @return [type] [description]
	 */
	Public function showCode() {
		ob_clean();
		$config = array(
    		'fontSize'    =>    15,    // 验证码字体大小    
    		'length'      =>    4,     // 验证码位数
   		    'useNoise'    =>    false // 关闭验证码杂点   
    	);

        $verify = new \Think\Verify($config);
        $verify->entry();

	}

	/**
	 * 验证表单提交数据
	 * [check description]
	 * @return [type] [description]
	 */
	Public function check() {
		$this->db = D('UserView');
		if(IS_AJAX){
			$this->error('非法请求');
		}
		$key =  addslashes(key($_POST));
		$value = I($key);
		switch ($key) {
			case 'email':
				if($this->db->check('email',$value)){
					$result = array('status'=>false,'msg'=>'该邮箱已经存在');
				}else{
					$result = array('status'=>true);
				}
			break;
			case 'username':
			    if($this->db->check('uname',$value)){
			    	$result = array('status'=>false,'msg'=>'该用户名已经存在');
			    }else{
					$result = array('status'=>true);
				}
			break;
			case 'code':
			    if($_SESSION['verify'] != md5($value)){
                    $result = array('status'=>false,'msg'=>'验证码错误');
			    }else{
					$result = array('status'=>true);
				}
     		break;			
		}
        exit(json_encode($result));
	}

	/**
	 * 添加用户
	 * [addUser description]
	 */
	Public function addUser() {
		if(IS_POST === false) $this->error('非法请求');
		$this->db = D('UserView');
		$data = array();
		$data['email'] = I('email');
		$data['uname'] = I('username');
		$data['password'] = I('password','','md5');
		$data['logintime'] = time();

        $uid = $this->db->addUser($data);

        if($uid){
            session(C('USER_AUTH_KEY'),$uid);
            setcookie(session_name(),session_id(),time()+C('COOKIE_EXPIRE'),'/');
            $this->success('注册成功',U(Home.'/Index/index'));
        }else{
            $this->error('注册失败',U(Home.'/Index/index'));
        }
	}





}






