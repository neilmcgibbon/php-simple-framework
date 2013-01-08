<?php

class Exceptions {
	
	static function Handle($e) {
		
		echo 'ERROR: "' . $e->getMessage();
		
	}
}

?>