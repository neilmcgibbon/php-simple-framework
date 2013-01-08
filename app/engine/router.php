<?php

ini_set("display_errors", "On");
error_reporting(E_ALL);

require_once ( $_SERVER['DOCUMENT_ROOT'] . '/config.php' );
require_once ( PHPSFW_ROOT . 'app/engine/engine_config.php' );

$router = new Router();

?>
