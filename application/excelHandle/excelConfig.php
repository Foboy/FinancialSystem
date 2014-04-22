<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
// Load application config (error reporting, database credentials etc.)
// require '../config/urlconfig.php';
// require '../config/config.php';
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'gogotowncrm');
define('DB_USER', 'crm');
define('DB_PASS', 'crm123');

// define('DB_TYPE', 'mysql');
// define('DB_HOST', '192.168.0.62;port=3366');
// define('DB_NAME', 'gogotowncrm');
// define('DB_USER', 'crm');
// define('DB_PASS', 'crm123');

// The auto-loader to load the php-login related internal stuff automatically
// require '../config/autoload.php';
//require_once  '../../vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
// The Composer auto-loader (official way to load Composer contents) to load external stuff automatically
if (file_exists('../../vendor/autoload.php')) {
	require '../../vendor/autoload.php';
}



require_once '../libs/PHP2EXCEL.php';
require_once '../libs/Database.php';
require_once '../libs/Session.php';
require_once '../models/bills_model.php';
// require_once '../LIBS/PHPExcel/Reader/Excel2007.php';
// require_once '../LIBS/PHPExcel/Reader/Excel5.php';
// include_once '../LIBS/PHPExcel/IOFactory.php';
//$toExcel=new PHP2EXCEL();
Session::init();
