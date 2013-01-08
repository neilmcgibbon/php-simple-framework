<?php

class Model {
	
	static $connection = NULL;
	protected $db;
	
	function __construct() {
		self::GetConnection();
		$this->_setDB();
	}
	
	protected function _setDB() {
		$this->db = self::$connection;
	}
	
	private static function GetMongoConnection() {
		
		if (self::$connection === null) {
			
			switch (PHPSFW_DB_TYPE) {
				case "mongodb":
					$m = new Mongo();
			 		self::$connection = $m->{PHPSFW_DB_SCHEMA};
				break;
				case "mysqli":
					self::$connection = new MySQLi(PHPSFW_DB_HOST,PHPSFW_DB_USERNAME,PHPSFW_DB_PASSWORD,PHPSFW_DB_SCHEMA);
				break;
				default: break;
			}
		}
		
	}
	
	
}

?>
