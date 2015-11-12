<?php

header('Content-type: text/csv');
header('Content-Disposition: attachment; filename="' . $_REQUEST['type'] . '_' . $_REQUEST['id'] . '.csv"');

$outputDirs = glob('/var/tmp/site-crawler/job_' . $_REQUEST['id']. '/*' , GLOB_ONLYDIR);
$outputDir = end($outputDirs);


switch($_REQUEST['type']) {
	case 'cookies':		echo file_get_contents($outputDir . '/cookies.txt');
				break;
	case 'resources':	echo file_get_contents($outputDir . '/resources.txt');
				break;
	case 'errors':		echo file_get_contents($outputDir . '/errors.txt');
				break;
}

?>
