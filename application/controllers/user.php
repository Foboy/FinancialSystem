<?php

class user extends Controller
{
	/**
	 * 用户信息查询，登陆注册转移到这个文件
	 */
	public function __construct()
	{
		parent::__construct();
	
		//Auth::handleLogin();
	}
	/*
	 * crm客户端登陆
	 * parms user_name user_password user_type=1/3
	 */
    public  function  finacillogin()
    {
    	$result = new DataResult ();
    	
    	$login_model = $this->loadModel('Users');
    	$login_successful = $login_model->login();
    	
    	$result->Data=$login_successful;
    	if ($login_successful) {
    		
    		if($_SESSION ['user_type']!=4 and $_SESSION ['user_type']!=5)
    		{
    			$result->ErrorMessage=FEEDBACK_USER_ACCESSDENIED;
    			$result->Error = ErrorType::Accessdenied;
    			print json_encode ( $result ) ;
    			return ;
    		}else 
    		{
    		$result->Data=$_SESSION ['user_type'];
    		
    		$result->Error = ErrorType::Success;
    		}
    	} else {
    		$result->ErrorMessage=FEEDBACK_LOGIN_FAILED;
    		$result->Error = ErrorType::LoginFailed;
    		$result->ExMessage=$_SESSION;
    	}
    	
    	print json_encode ( $result ) ;
    }
  

    function logout()
    {
    	$result = new DataResult ();
    	$login_model = $this->loadModel('Users');
    	$result->Data = $login_model->logout();
    	print  json_encode ( $result ) ;
    }
    /**
     * Login with cookie
     */
    function loginWithCookie()
    {
    	$result = new DataResult ();
    	// run the loginWithCookie() method in the login-model, put the result in $login_successful (true or false)
    	$login_model = $this->loadModel('Users');
    	$result->Data =$login_successful = $login_model->loginWithCookie();
    
    	if ($login_successful) {
    			$result->Error = ErrorType::Success;
    	} else {
    		// delete the invalid cookie to prevent infinite login loops
    		$login_model->deleteCookie();
    		// if NO, then move user to login/index (login form) (this is a browser-redirection, not a rendered view)
    		$result->Error = ErrorType::LoginFailed;
    	}
    	print  json_encode ( $result ) ;
    }
    /**
     * 注册新用户
     * parms acount user_type user_name user_password_new user_password_repeat
     */
    public  function  register()
    {
    	$result = new DataResult ();
    	$login_model = $this->loadModel('Users');
    	$result->Data = $registration_successful = $login_model->registerNewUser();
    	
    	if ($registration_successful == true) {
 $result->Error = ErrorType::Success;
    		//  header('location: ' . URL . 'login/index');
    	} else {
    		$result->Error = ErrorType::Failed;
    		//  header('location: ' . URL . 'login/register');
    	}
    	print  json_encode ( $result ) ;
    }
    /*
     * 获取当前登陆用户信息
     */
    public  function  getCurrentUser()
    {
    	$result = new DataResult ();
    	if (! isset ( $_SESSION["user_id"] ) or empty ( $_SESSION["user_id"] )) {
    		$result->Error = ErrorType::Unlogin;
    		print json_encode ( $result );
    		return ;
    	}
    	$user_model = $this->loadModel('Users');
    	$result = $user_model->get($_SESSION["user_id"]);
        $result->Error = ErrorType::Success;
    	print  json_encode ( $result ) ;
    }
    /*
     * 启用禁用用户
     * parms user_id state 1 启用 0禁用
    */
    public  function  updateUserState()
    {
    	$result = new DataResult ();
    	if (! isset ( $_POST["user_id"] ) or empty ( $_POST["user_id"] )) {
    		$result->Error = ErrorType::RequestParamsFailed;
    		print json_encode ( $result );
    		return ;
    	}
    	if (! isset ( $_POST["state"] ) or empty ( $_POST["state"] )) {
    		$result->Error = ErrorType::RequestParamsFailed;
    		print json_encode ( $result );
    		return ;
    	}
    	
    	$user_model = $this->loadModel('Users');
    	$result->Data = $user_model->updateUserState($_POST["state"],$_POST["user_id"]);
    	if( $_POST["state"] == UserState::Active)
    	{
    	$result->ErrorMessage=FEEDBACK_ACCOUNT_ACTIVATION_SUCCESSFUL;
    	}else 
    	{
    		$result->ErrorMessage=FEEDBACK_ACCOUNT_UNACTIVATION_SUCCESSFUL;
    	}
    	$result->Error = ErrorType::Success;
    	print  json_encode ( $result ) ;
    }
    /*
     * 获取财务APP账号列表
    * parms: name user_type 1 ADMIN 2 APP 3 STAFF 4 financialadmin 5 financialstaff
    */
    public function searchFinancialsAcount() {
    	$result = new DataResult ();
    
    	if (! isset ( $_POST ['name'] )) {
    		$result->Error = ErrorType::RequestParamsFailed;
    		print json_encode ( $result );
    		return ;
    	}
    	
    	$user_model = $this->loadModel('Users');
    
    	$result = $user_model->search ($_POST ['name'],0,5);
    	$result->Error = ErrorType::Success;
    
    	print  json_encode ( $result );
    }
    /*
     * 修改操作员密码
    * parms: user_id user_password_new  user_password_repeat
    */
    public function updatePass() {
    	$result = new DataResult ();
    	if (! isset ( $_POST["user_id"] ) or empty ( $_POST["user_id"] )) {
    		$result->Error = ErrorType::RequestParamsFailed;
    		print json_encode ( $result );
    		return ;
    	}
    
    	if (!isset($_POST['user_password_new']) OR empty($_POST['user_password_new'])) {
    		$result->Error = ErrorType::RequestParamsFailed;;
    		print json_encode ( $result );
    		return ;
    	}
    	if (!isset($_POST['user_password_repeat']) OR empty($_POST['user_password_repeat'])) {
    		$result->Error = ErrorType::RequestParamsFailed;;
    		print json_encode ( $result );
    		return ;
    	}
    	// password does not match password repeat
    	if ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
    		$result->Error  = FEEDBACK_PASSWORD_REPEAT_WRONG;
    		print json_encode ( $result );
    		return ;
    	}
    	// password too short
    	if (strlen($_POST['user_password_new']) < 6) {
    		$result->Error = FEEDBACK_PASSWORD_TOO_SHORT;
    		print json_encode ( $result );
    		return ;
    	}
    	// check if we have a constant HASH_COST_FACTOR defined
    	// if so: put the value into $hash_cost_factor, if not, make $hash_cost_factor = null
    	$hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);
    
    	// crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
    	// the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
    	// compatibility library. the third parameter looks a little bit shitty, but that's how those PHP 5.5 functions
    	// want the parameter: as an array with, currently only used with 'cost' => XX.
    	$user_password_hash = password_hash($_POST['user_password_new'], PASSWORD_DEFAULT, array('cost' => $hash_cost_factor));
    
    	$user_model = $this->loadModel('Users');
    
    	$result->Data = $user_model->setNewPassword ($_POST["user_id"] ,$user_password_hash);
    	$result->Error = ErrorType::Success;
    
    	print  json_encode ( $result );
    }
}