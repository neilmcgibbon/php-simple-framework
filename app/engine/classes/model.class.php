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
			/* Create database connection
			 * e.g. for a Mongo connection : 
                         *   $m = new Mongo();
			 *   self::$connection = $m->collection;
                         * or a mysqli connection:
                         *   $m = new MySQLi('host','user','password','schema');
			 *   self:$connection = $m;
 			 */
		}
		
	}
	
	
}

?>
