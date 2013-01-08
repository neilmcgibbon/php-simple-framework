<?php

class Controller {
	
	protected $get;
	protected $post;
	
	protected $view;
	protected $view_data = array();
	
	protected $pre_views = array();
	protected $post_views = array();
	protected $javascripts = array();
	protected $stylesheets = array();
	
	protected $__method;
	
	protected $session;
	
	private $ajax = false;
	
	function __construct() {
		$this->__method = "__index";
		$this->get = $_GET;
		$this->post = $_POST;	
		
		$uri = explode('/', trim(trim($_SERVER['REDIRECT_URL'],'/')));
		
		if (count($uri) == 1 && $uri[0] == "")
			$this->view = '/home/index';
		elseif (count($uri) == 1)
			$this->view = $uri[0] . '/index';
		elseif (count($uri) > 1) {
			$this->view = $uri[0] . '/' . $uri[1];
		}
		
		if (count($uri) > 2) {
			for ($i = 2; $i < count($uri); $i++) 
				$this->{"_arg" . ($i-1)} = $uri[$i];
		}
		$this->session = new Session();
		$this->view_data['authorised'] = $this->session->_getLoggedIn();
		$this->view_data['flash'] = $this->session->_getFlash();
		
	
	}
	
	public function _setAjax($bool) {
		$this->ajax = $bool;
	}
	
	public function control() {
		$method = $this->_getMethod();
		if ($method && method_exists($this, $method))
			$this->{$method}();
		else
			$this->pageNotFound();
	}
	
	protected function pageNotFound() {
		$this->view = "error/page_not_found";
		$this->view();
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
		$method = "__" . lcfirst(
							str_replace(' ','',
							ucwords(
							str_replace('-', ' ', 
							trim($method)))));
		if ($method && method_exists($this, $method))
			$this->__method = $method;		
		else
			$this->pageNotFound();
	}
	
	public function _setJS($location) {
		if (preg_match('/^http/i', $location))
			$this->javascripts[] = $location;
		else
			$this->javascripts[] = '/lib/js/' . $location .'.js';
	}
	
	public function _setCSS($location) {
		if (preg_match('/^http/i', $location))
			$this->stylesheets[] = $location;
		else
			$this->stylesheets[] = '/lib/css/' . $location .'.css';
	}
	
	protected function view( $return = false ) {
		
		$this->view_data['javascripts'] = $this->javascripts;
		$this->view_data['stylesheets'] = $this->stylesheets;
		
		$html = '';
		
		if (!$this->ajax) 
			$html .= $this->_getView("mods/header");
			
		foreach ($this->pre_views as $view) 
			$html .= $this->_getView($view);

		$html .= $this->_getView( $this->view );
		
		foreach ($this->post_views as $view) 
			$html .= $this->_getView($view);

		if (!$this->ajax) 
			$html .= $this->_getView("mods/footer");
			
		if ($return)
			return $html;
			
		echo $html;
	}
	
	private function _getView($view) {
		$view = new View($view, $this->view_data);
		return $view->_get();
	}
	
	protected function _setFlash($flash) {
		$this->session->_setFlash($flash);
		$this->view_data['flash'] = $this->session->_getFlash();
	}
	
	protected function loadClass($class) {
		if (!file_exists(FW_APP . 'vendor/' . $class . '.php')) 
			throw new Exception("File " . FW_APP . 'vendor/' . $class . '.php does not exist');
		else 
			require_once( FW_APP . 'vendor/' . $class . '.php' );
	}
	
}

?>