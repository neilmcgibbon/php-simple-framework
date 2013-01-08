<?php

class Session {
	
	
	private $authorised = false;
	private $uid = false;
	private $redirect_after_login = false;
	private $privileges = array();
	private $flash = false;
	
	function __construct() {
		if (isset($_SESSION['FW_SESSION']) && $_SESSION['FW_SESSION']) {
			$this->_setLoggedIn($_SESSION['FW_SESSION']);
		}
		if (isset($_SESSION['flash'])) {
			$this->flash = $_SESSION['flash'];
			unset($_SESSION['flash']);
		}
	}
	
	public function requiresAuth() {
		
		if ($this->authorised)
			return true;
		
		$_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
		
		header("Location: /account/login");
		die();
		
	}
	
	/** Acceor for the current user ID
	 *  @returns int Returns the current logged in User ID
	 */
	public function _getID() {
		return $this->uid;
	}
	
	public function _setPrivilege($priv) {
		if (is_array($priv))
			$this->privileges = $priv;
		else
			$this->privileges[] = $priv;
	}
	
	public function requriesPrivilege($priv) {
		if ($this->authorised && in_array($priv, $this->privileges)) {
			return true;
		} elseif ($this->authorised) {
			header("Location: /error/not-allowed");
			die();
		} 
		
		$_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
		
		header("Location: /account/login");
		die();
		
	}
	
	public function _setLoggedIn($uid) {
		$_SESSION['partnership_uid'] = $uid;
		$this->authorised = true;
		$this->uid = $uid;
		
		$model = new Model_Users();
		$this->privileges = $model->_getPrivileges($uid);
	}
	
	public function logout() {
		$_SESSION['FW_SESSION'] = false;
		unset($_SESSION['FW_SESSION']);
		session_destroy();
		session_start();
		session_regenerate_id(true);
		
		$this->authorised = false;
		$this->uid = false;
		$this->privileges = array();
	}
	
	public function _getLoggedIn() {
		return $this->authorised;
	}
	
	public function redirectAfterLogin() {
		
		if (isset($_SESSION['redirect_after_login']) && $_SESSION['redirect_after_login']) {
			$redirect = $_SESSION['redirect_after_login'];
			$_SESSION['redirect_after_login'] = false;
			unset($_SESSION['redirect_after_login']);
			header("Location: " . $redirect);
		}	else {
			header("Location: /account/");
		}
		
		die();
		
	}
	
	public function _setFlash($flash) {
		$_SESSION['flash'] = $flash;
		$this->flash = $flash;
	}
	
	public function _getFlash() {
		$flash = $this->flash;
		$this->flash = false;
		return $flash;
	}
	
	
}

?>