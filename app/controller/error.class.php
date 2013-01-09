<?php

class Controller_Error extends PHPSFW_Controller {

	public function __index() {
	
		$this->__pageNotFound();

	}
	
	public function __methodNotFound() {
		$this->_setView("error" . DIRECTORY_SEPARATOR . "method_not_found");
		$this->view();
		
	}
	
	public function __controllerNotFound() {
		$this->_setView("error" . DIRECTORY_SEPARATOR . "controller_not_found");
		
		$this->view();
		
	}
	
	public function __pageNotFound() {
		$this->_setView("error" . DIRECTORY_SEPARATOR . "page_not_found");
		
		$this->view();
		
	}
	
	
  
}

?>
