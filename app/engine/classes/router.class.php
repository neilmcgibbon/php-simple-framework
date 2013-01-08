<?php

class Router {
	
	private $path;
	private $controller;
	
	function __construct() {
		$this->path = trim(trim($_SERVER['REDIRECT_URL']), '/');

		$this->processPath();
		
		$this->controller->control();
		
	}
	
	private function processPath() {
		
		$path = explode('/', $this->path);
		
		$controller = trim($path[0]);
		if ($controller == "")
			$controller = "Home";
		
		$controller = strtolower($controller);
		if ( !file_exists ( PHPSFW_CONTROLLER . $controller . '.class.php')) {
			throw new Exception("Error");
		} else {
			$class = "Controller_" . $controller;
			$this->controller = new $class();
		}

		if (isset($path[1]) && trim($path[1]) != "")
			$this->controller->_setMethod(trim($path[1]));
			
		
	}
	
} 

?>
