<?php

session_start();

/* Base definitions */

define ( 'FW_APP', FW_ROOT . 'app/' );
define ( 'FW_VIEW', FW_APP . 'view/' );
define ( 'FW_CONTROLLER', FW_APP . 'controller/' );
define ( 'FW_CACHE', FW_APP . 'view/_cache/' );
define ( 'FW_ENGINE', FW_APP . 'engine/' );

require_once( FW_ENGINE . 'classes/router.class.php');
require_once( FW_ENGINE . 'classes/exceptions.class.php');
require_once( FW_ENGINE . 'classes/session.class.php');
require_once( FW_ENGINE . 'classes/uploader.class.php');

require_once( FW_ENGINE . 'classes/model.class.php');
require_once( FW_ENGINE . 'classes/view.class.php');
require_once( FW_ENGINE . 'classes/controller.class.php');

/* User definitions */

/* autloader */

spl_autoload_register(function ($class) {
	$class_arr = explode('_', $class);
	$class_loc = '';
	for ($i = 0; $i < count($class_arr); $i++) 
		$class_loc .= ($i == count($class_arr) - 1) ? strtolower($class_arr[$i]) . '.class.php' : strtolower($class_arr[$i]) . DIRECTORY_SEPARATOR;
	
	/* Try regular controllers */
	if (file_exists ( FW_APP . $class_loc )) {
		require_once( FW_APP . $class_loc);
	} else {
		throw new Exception("Class '" . $class . "' does not exist. (Looked for " . FW_APP . $class_loc . ")");
		die();
	}
});	

/* Exception handler */

set_exception_handler("Exceptions::Handle");

?>