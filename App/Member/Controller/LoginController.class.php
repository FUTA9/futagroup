<?php  

namespace Member\Controller;
use Think\Controller;


Class LoginController extends Controller {

	Public function _initialize(){
       $this->uid = (int)$_SESSION[C('USER_AUTH_KEY')];
       $db = D('Category');
       $this->nav = $db->getNavCategory(0);
       $this->assign('userIsLogin',isset($_SESSION[C('USER_AUTH_KEY')]));
    }


    /**
     * 显示模板
     * [index description]
     * @return [type] [description]
     */
	Public function index() {
		if(isset($_SESSION[C('USER_AUTH_KEY')])){
			$this->error('已登录，请注销后再登录');
		}else{
			$this->display();
		}
	}

	/**
	 * 用户登录表单数据处理
	 * [login description]
	 * @return [type] [description]
	 */
	Public function login() {
		if(IS_POST === false) $this->error('非法请求');

		$uname = I('username');
		$password = I('password','','md5');
	//	$condition['email'] = $uname;
        $condition['uname'] = $uname;
		$this->db = D('UserView');
		$userinfo = $this->db->getUser($condition);
		$uid = $userinfo['uid'];
		if($userinfo['password'] == $password){
			session(C('USER_AUTH_KEY'),$uid);   
            if(isset($_POST['auto_login'])){
            	setcookie(session_name(),session_id(),time()+3600,'/');
            	//setcookie('user','test',time()+3600,'');
            }
            $this->success('登录成功',U('Home/Index/index'));
		}else{
			$this->error('账户或密码错误');
		}

	}

	Public function savePass(){
		if(IS_GET){
			$this->display(); 
		}else{
			$uname = $_POST['uname'];
			$email = $_POST['email'];
			$db = D('UserView');
			$where = array('uname'=>$_POST['uname']);
			$result = $db->getUser($where);
			$emails = $result['email'];
			$unames = $result['uname'];
			if($uname == $unames && $email == $emails){
				$password = $_POST['password'];
				$passwords = $_POST['password2'];
				if($password == $passwords){
					$where = array('uname'=>$result['uname']);
					$data = array();
					$data['password'] = I('password','','md5');
					$results = $db->savePass($where,$data);
					if($results){
						$this->success('修改密码成功',U(MODULE_NAME.'/Login/index'));
					}
				}else{
					$this->error('两次密码输入不一致！');
				}
			}else{
				$this->error('用户名或邮箱不正确');
			}


		}


	}

	/**
	 * 退出登录
	 * [logout description]
	 * @return [type] [description]
	 */
	Public function logout(){
		if(!isset($_SESSION[C('USER_AUTH_KEY')])){
			$this->error('未登录,请登录！');
		}else{
	    	setcookie(session_name(),session_id(),1,'/');
	    	session_unset();
	    	session_destroy();
	    	$this->success('退出成功',U('Home/Index/index'));	
    	}
    }




}






