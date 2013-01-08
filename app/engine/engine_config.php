<?php

session_start();

/* Base definitions */
define ( 'PHPSFW_APP', PHPSFW_ROOT . 'app/' );
define ( 'PHPSFW_VIEW', PHPSFW_APP . 'view/' );
define ( 'PHPSFW_CONTROLLER', PHPSFW_APP . 'controller/' );
define ( 'PHPSFW_CACHE', PHPSFW_APP . 'view/_cache/' );
define ( 'PHPSFW_ENGINE', PHPSFW_APP . 'engine/' );

require_once( PHPSFW_ENGINE . 'classes/router.class.php');
require_once( PHPSFW_ENGINE . 'classes/exceptions.class.php');
require_once( PHPSFW_ENGINE . 'classes/session.class.php');
require_once( PHPSFW_ENGINE . 'classes/uploader.class.php');

require_once( PHPSFW_ENGINE . 'classes/model.class.php');
require_once( PHPSFW_ENGINE . 'classes/view.class.php');
require_once( PHPSFW_ENGINE . 'classes/controller.class.php');


/* autloader */

spl_autoload_register(function ($class) {
	$class_arr = explode('_', $class);
	$class_loc = '';
	for ($i = 0; $i < count($class_arr); $i++) 
		$class_loc .= ($i == count($class_arr) - 1) ? strtolower($class_arr[$i]) . '.class.php' : strtolower($class_arr[$i]) . DIRECTORY_SEPARATOR;
	
	/* Try regular controllers */
	if (file_exists ( PHPSFW_APP . $class_loc )) {
		require_once( PHPSFW_APP . $class_loc);
	} else {
		throw new Exception("Class '" . $class . "' does not exist. (Looked for " . PHPSFW_APP . $class_loc . ")");
		die();
	}
});	

/* Exception handler */

set_exception_handler("Exceptions::Handle");

?>
