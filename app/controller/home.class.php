<?php

class Controller_Home extends Controller {

	public function __index() {
	
		$this->view();

	}
	
	public function __methodNotFound() {
		$this->_setView("error" . DIRECTORY_SEPARATOR . "method_not_found");
		$this->view();
		
	}
	
	public function __controllerNotFound() {
		$this->_setView("error" . DIRECTORY_SEPARATOR . "controller_not_found");
		
		$this->view();
		
	}
	
	
  
}

?>
