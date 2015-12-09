<?php

$fieldsToCheck = array('url');

$fieldsPresent = true;

foreach($fieldsToCheck as $index => $field) {
	if (!isSet($_REQUEST[$field]))
		$fieldsPresent = false;
}

if ($fieldsPresent) {

	$dataArray = array(
		'url' => implode(';', explode("<br />", trim(preg_replace('/\s\s+/', '', nl2br($_REQUEST['url']))))),
		'cookie_consent' => (isSet($_REQUEST['cookie_consent']) && $_REQUEST['cookie_consent'] == 'on') ? 1 : 0,
		'deeplinks' => (isSet($_REQUEST['deeplinks']) && $_REQUEST['deeplinks'] == 'on') ? 1 : 0,
		'status' => 0,
		'screenshots' => (isSet($_REQUEST['screenshots']) && $_REQUEST['screenshots'] == 'on') ? 1 : 0,
		'cookies' => (isSet($_REQUEST['cookies']) && $_REQUEST['cookies'] == 'on') ? 1 : 0,
		'resources' => (isSet($_REQUEST['resources']) && $_REQUEST['resources'] == 'on') ? 1 : 0,
		'libraries' => (isSet($_REQUEST['libraries']) && $_REQUEST['libraries'] == 'on') ? 1 : 0,
		'errors' => (isSet($_REQUEST['errors']) && $_REQUEST['errors'] == 'on') ? 1 : 0
	);

	$job_id = $database->insert('jobs', $dataArray);

	//var_dump($database->error());

        echo '<div class="alert alert-info">'; 
        echo '        <strong>Job created!</strong> A new job with ID ' . $job_id .' has been started.';
        echo '</div>';

}

?>
