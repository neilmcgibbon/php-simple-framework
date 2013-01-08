<?php

class View {
	
	private $view;
	private $data;
	
	function __construct($view, $data) {
		$this->view = $view;	
		$this->data = $data;
	}
	
	public function _get() {
		$data = $this->data;
		ob_start();
		require_once ( FW_VIEW . $this->view . '.tpl.php');
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
}
?>