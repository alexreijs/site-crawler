<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(dirname(__FILE__) . '/medoo/medoo.php');

$database = new medoo([
        'database_type' => 'mysql',
        'database_name' => 'site-crawler',
        'server' => 'localhost',
        'username' => 'root',
        'password' => '1234',
        'charset' => 'utf8',
]);

$_SESSION['config'] = [
	'siteCrawlerLocation' => '/usr/local/repos/site-crawler'
];


$sysVars = array('action' => 'home');

foreach($sysVars as $variable => $default) {
	if (isSet($_REQUEST[$variable]))
		$_SESSION[$variable] = $_REQUEST[$variable];
	else if (!isSet($_SESSION[$variable])) {
		$_SESSION[$variable] = $default;
	}

}


?>
