<?php 

define('SITE_NAME', 'SHAPPY');
define('HOME_URL', '/shappy');

#development state
define('ENV', 'dev');

#database
define('DB_HOST', 'localhost');
define('DB_NAME', 'shappy');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

define('UTC_TIMEZONE', 'Asia/Manila');
date_default_timezone_set(UTC_TIMEZONE);

ini_set('display_errors', ENV == 'dev'? 1 : 0);
ini_set('display_startup_errors', ENV == 'dev'? 1 : 0);
error_reporting(ENV == 'dev'? E_ALL : -1);