<?php

class PHPSFW_Exceptions {
	
	static function Handle($e) {
		
		echo 'ERROR: "' . $e->getMessage();
		
	}
}

?>