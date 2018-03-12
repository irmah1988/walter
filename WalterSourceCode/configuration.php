<?php

// DB settings
$database = array(
  'host'    => 'mysql.wecast.services',
  'user'    => 'wecast-user',
  'password'=> 'NecesNikadPogodit2017!',
  'database'=> 'walter'
);

 //$conn = new mysqli('localhost','root', '', 'c0_intranet') or die ("Unable to connect");
  //echo "Great work!!!";



// SMTP settings
$site_doamin  = "walter.wecast.ws";

// Paths...
//$path_pref      = '/app';
//$root           = dirname(__FILE__);
//$protocol       = "http".((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "s" : "") . "://";
//$host 		      = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
//$url 		        = $protocol.$host.$path_pref;

// Paths...
$path_pref          = '';
$root               = "/var/Wecast/vhosts/walter";
$host               = 'http://walter.wecast.ws';
$url                = $host.$path_pref;

$_themeRoot  = $root.'/theme';
$_themeUrl   = $url.'/theme';
$_uploadRoot = $root.'/uploads';
$_uploadUrl  = $url.'/uploads';
$_pluginUrl  = $url.'/plugins';
$_cssUrl     = $url.'/theme/css';
$_jsUrl      = $url.'/theme/js';
$_timthumb   = $url.'/CORE/timthumb.php?src=';


// Variables
$_mod     = @$_GET['m'];
$_page    = @$_GET['p'];
$_search  = @$_GET['q'];
$_edit    = @$_GET['e'];
$action   = @$_GET['action'];
$_num = @$_GET['pg'];

$_defaultMod    = 'stats';
$_defaultPage   = 'dashboard';
$_defaultLocale = 'en_US';

define('ENC_KEY', 'sEFa?.a#asdakns58saWDa');
define('DEBUG', true);

// Start user session
session_start();

// Connect to database
$dsn = 'mysql:host='.$database['host'].';dbname='.$database['database'];

$db_error = '';

try {
	//$pdo = new PDO('pgsql:host=localhost;port=81/app;dbname=c0_intranet', 'root', '');
    $db = new PDO($dsn, $database['user'], $database['password']);
    $db -> exec('SET CHARACTER SET UTF-8');
    $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $db_error .= '<div class="error-db">';
    $db_error .= 'Connection failed:<br/>';
    if(DEBUG){ $db_error .= $e->getMessage(); }
    $db_error .= '</div>';
}

global $db;

// Include main functions
include_once $root.'/CORE/functions.main.php';
// Include language functions
include_once $root.'/CORE/functions.lang.php';

 ?>
