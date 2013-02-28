<?php

class PHPSFW_Controller {
	
	protected $get;
	protected $post;
	protected $path;
	
	protected $view;
	protected $view_data = array();
	
	protected $pre_views = array();
	protected $post_views = array();
	protected $javascripts = array();
	protected $stylesheets = array();
	protected $hard_headers = array();
	
	protected $__method;
	protected $redirect_to_index = false;
	
	protected $session;
	
	private $use_full_template = true;
	
	function __construct() {
		$this->__method = "__index";
		$this->get = $_GET;
		$this->post = $_POST;	
		
		$uri = explode('/', trim(preg_replace('/^(.*)\?.*$/', '$1', trim($_SERVER['REQUEST_URI'],'/')),'/'));
		
		if (count($uri) == 1 && $uri[0] == "")
			$this->view = 'home' . DIRECTORY_SEPARATOR . 'index';
		elseif (count($uri) == 1)
			$this->view = $uri[0] . DIRECTORY_SEPARATOR . 'index';
		elseif (count($uri) > 1) {
			$this->view = $uri[0] . DIRECTORY_SEPARATOR . $uri[1];
		}
		
		if (count($uri) > 2) {
			for ($i = 2; $i < count($uri); $i++) 
				$this->{"_arg" . ($i-1)} = $uri[$i];
		}
		$this->session = new PHPSFW_Session();
		$this->view_data['authorised'] = $this->session->_getLoggedIn();
		$this->view_data['flash'] = $this->session->_getFlash();
		
	
	}
	
	public function _setRedirectToIndex($bool) {
		$this->redirect_to_index = $bool;
	}
	
	public function _setFullTemplate($bool) {
		$this->use_full_template = $bool;
	}
	
	public function control($path) {
		$this->path = $path;
		$method = $this->_getMethod();
		$this->{$method}();
	}
	
	public function _getMethod() {
		return $this->__method;
	}
	
	public function _setPostView($view) {
		$this->post_views[] = $view;
	}
	
	public function _setPreView($view) {
		$this->pre_views[] = $view;
	}
	
	public function _setMethod($method) {
		if ($this->redirect_to_index == true)
			return $this->__method = "__index";		

		$method = "__" . lcfirst(
							str_replace(' ','',
							ucwords(
							str_replace('-', ' ', 
							trim($method)))));
		if ($method && method_exists($this, $method))
			return $this->__method = $method;		
		else
			return false;
	}
	
	public function _setJS($location) {
		if (preg_match('/^http/i', $location))
			$this->javascripts[] = $location;
		else
			$this->javascripts[] = '/web/js/' . $location .'.js';
	}
	
	public function _setCSS($location) {
		if (preg_match('/^http/i', $location))
			$this->stylesheets[] = $location;
		else
			$this->stylesheets[] = '/web/css/' . $location .'.css';
	}
	
	public function _setHardHeader($string) {
		$this->hard_headers[] = $string;
	}
	
	protected function view( $return = false ) {
		
		$this->view_data['javascripts'] = $this->javascripts;
		$this->view_data['stylesheets'] = $this->stylesheets;
		$this->view_data['hard_headers'] = $this->hard_headers;
		
		$html = '';
		
		if ($this->use_full_template) 
			$html .= $this->_getView("modules" . DIRECTORY_SEPARATOR . "header");
			
		foreach ($this->pre_views as $view) 
			$html .= $this->_getView($view);

		$html .= $this->_getView( $this->view );
		
		foreach ($this->post_views as $view) 
			$html .= $this->_getView($view);

		if ($this->use_full_template) 
			$html .= $this->_getView("modules" . DIRECTORY_SEPARATOR . "footer");
			
		if ($return)
			return $html;
			
		echo $html;
	}
	
	private function _getView($view) {
		$view_object = new PHPSFW_View($view, $this->view_data);
		if (!$view_object->isValid()) {
			$class = "Controller_Error";
			$controller = new $class();	
			if (PHPSFW_DEBUG_MODE)
				$controller->_setMethod("view-not-found");
			else
				$controller->_setMethod("page-not-found");
			return $controller->control($this->path);
		} else {
			return $view_object->_get($this->path);
		}
	}
	
	protected function _setView($view) {
		$this->view = $view;
	}
	
	protected function viewJSON($mixed) {
		echo json_encode($mixed);
		die();
	}
	
	protected function _setFlash($flash) {
		$this->session->_setFlash($flash);
		$this->view_data['flash'] = $this->session->_getFlash();
	}
	
	protected function loadClass($class) {
		if (!file_exists(PHPSFW_APP . 'vendor/' . $class . '.php')) 
			throw new Exception("File " . PHPSFW_APP . 'vendor/' . $class . '.php does not exist');
		else 
			require_once( PHPSFW_APP . 'vendor/' . $class . '.php' );
	}
	
}

?>
