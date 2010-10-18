<?php

error_reporting(E_ALL);
ini_set("display_errors", 1); 
 
defined('SITE_URL') ? null : define( 'SITE_URL', 'http://zentodoneapp' );
defined('DS') ? null : define('DS', '/'); 
defined('ABSPATH') ? null : define( 'ABSPATH', dirname(__FILE__) );
defined('INCLUDES') ? null : define( 'INCLUDES', dirname(__FILE__).DS.'resources'.DS.'includes' );
defined('APP_DIR') ? null : define( 'APP_DIR', dirname(__FILE__).DS.'resources'.DS.'application' );

defined('CLASSES') ? null : define ('CLASSES', APP_DIR.DS.'classes');
defined('DB_SERVER') ? null : define('DB_SERVER', 'localhost');
defined('DB_USER') ? null : define('DB_USER', 'ztdadev');
defined('DB_PASS') ? null : define('DB_PASS', 'c0l0r@d0');
defined('DB_NAME') ? null : define('DB_NAME', 'ztda');

require_once CLASSES.DS.'Database.php';
require_once CLASSES.DS.'DatabaseObject.php';
require_once CLASSES.DS.'Session.php';
require_once CLASSES.DS.'User.php';
require_once CLASSES.DS.'Password.php';
require_once CLASSES.DS.'Validation.php';
require_once CLASSES.DS.'Task.php';
require_once CLASSES.DS.'Context.php';

require_once APP_DIR.DS.'functions'.DS.'site-functions.php';

?>