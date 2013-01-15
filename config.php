<?php

/**
 * Configuration directives for PHP-Simple-Framework
 */
 
# Path to PHP-Simple-Framework root. 
define ( 'PHPSFW_APP_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/' );

# Debug mode, on (true) or off (false).  If true, more helpful error messages are displayed.
define ( 'PHPSFW_DEBUG_MODE', true);

# Database type. Can be none, mongodb or mysqli
define ( 'PHPSFW_DB_TYPE', 'none');

# If Database type is not 'none', then provide the following four definitions.
# ~ note that PHPSFW_DB_SCHEMA is the name of the database to use.
define ( 'PHPSFW_DB_HOST', '');
define ( 'PHPSFW_DB_USERNAME', '');
define ( 'PHPSFW_DB_PASSWORD', '');
define ( 'PHPSFW_DB_SCHEMA', '');

# If you wish to use different PHP session.save_path (for example if you have both nginx AND 
# apache installed and running, and permissions are givin you grief, set this constant to your
# new save path, and make sure your web server has got write permissions on it:
define( 'PHPSFW_PHP_SESSION_SAVE_PATH', false );


?>
