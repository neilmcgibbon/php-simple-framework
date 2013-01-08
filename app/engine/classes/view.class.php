<?php

class View {
	
	private $view;
	private $data;
	private $is_valid = false;
	
	function __construct($view, $data) {
		$this->view = $view;	
		$this->data = $data;
		
		if (!file_exists( PHPSFW_VIEW . $this->view . '.tpl.php' ))
			return;
			
		$this->is_valid = true;
		return true;
	}
	
	public function _get() {
		$data = $this->data;
		ob_start();
		require_once ( PHPSFW_VIEW . $this->view . '.tpl.php');
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
	
	public static function GetVar($var, $override = false, $def = false) {
		if ($override && trim($override) != "")
			return trim($override);
		
		if (isset($_REQUEST[$var]) && trim($_REQUEST[$var]) != "")
			return trim($_REQUEST[$var]);
		
		return $def ? $def : '';
	}
	
	public function isValid() {
		return $this->is_valid;
	}
}
?>
