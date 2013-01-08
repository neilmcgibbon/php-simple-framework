<?php

class Model {
	
	static $mongo = NULL;
	protected $db;
	
	function __construct() {
		self::GetMongoConnection();
		$this->_setDB();
	}
	
	protected function _setDB() {
		$this->db = self::$mongo;
	}
	
	private static function GetMongoConnection() {
		
		if (self::$mongo === null) {
			$m = new Mongo();
			self::$mongo = $m->mine;
		}
		
	}
	
	protected function returnObject($status, $message, $object = false) {
		$ret = new stdClass;
		$ret->status = $status;
		$ret->message = $message;
		if ($object)
			$ret->data = $object;
		
		return $ret;
	}
	
}

?>