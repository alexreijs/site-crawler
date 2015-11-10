<?php

$fieldsToCheck = array('urls');

$fieldsPresent = true;

foreach($fieldsToCheck as $index => $field) {
	if (!isSet($_REQUEST[$field]))
		$fieldsPresent = false;
}

if ($fieldsPresent) {

	$dataArray = array(
		'urls' => $_REQUEST['urls'],
		'status' => 0,
		'screenshots' => (isSet($_REQUEST['screenshots']) && $_REQUEST['screenshots'] == 'on') ? 1 : 0,
		'cookies' => (isSet($_REQUEST['cookies']) && $_REQUEST['cookies'] == 'on') ? 1 : 0
	);

	$job_id = $database->insert('jobs', $dataArray);

	echo $job_id;
}

?>
