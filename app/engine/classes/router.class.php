<?php

class PHPSFW_Router {
	
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
		$class = "Controller_" . $controller;

		try {
			$this->controller = new $class();
			if (isset($path[1]) && trim($path[1]) != "") {
				$set_method = $this->controller->_setMethod(trim($path[1]));
				if (!$set_method)
					throw new Exception("Method not found");
			}
		} catch (Exception $e) {
			$class = "Controller_Error";
			$this->controller = new $class();	
			
			if (PHPSFW_DEBUG_MODE) {
				if ($e->getMessage() == "Method not found")
					$this->controller->_setMethod("method-not-found");
				else
					$this->controller->_setMethod("controller-not-found");
			} else {
				$this->controller->_setMethod("page-not-found");
			}
				
		}
			
		
	}
	
} 

?>
