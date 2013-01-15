<?php

/* Before we start the session, let's check if we are using an alternate session.save_path *.
if ( defined ('PHPSFW_PHP_SESSION_SAVE_PATH' ) && false != PHPSFW_PHP_SESSION_SAVE_PATH)
	ini_set('session.save_path', PHPSFW_PHP_SESSION_SAVE_PATH);

session_start();

/* Base definitions */
define ( 'PHPSFW_ROOT', PHPSFW_APP_ROOT . (substr(PHPSFW_APP_ROOT, strlen(PHPSFW_APP_ROOT)-1) == DIRECTORY_SEPARATOR ? '' : DIRECTORY_SEPARATOR) );
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

set_exception_handler("PHPSFW_Exceptions::Handle");

?>
