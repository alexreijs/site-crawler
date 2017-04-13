<?php

$fieldsToCheck = array('url');

$fieldsPresent = true;

foreach($fieldsToCheck as $index => $field) {
	if (!isSet($_REQUEST[$field]))
		$fieldsPresent = false;
}

function cleanurls($url) {
    $urls = explode(PHP_EOL, trim($url));
    foreach ($urls as $key => $val) {
        if(substr($val,0,4) != 'http') {
            $urls[$key] = "http://".trim($val);
        } else {
            $urls[$key] = trim($val);
        }
    }

    return implode(';',$urls);
}

if ($fieldsPresent) {

	$dataArray = array(
		'url' => cleanurls($_REQUEST['url']),
		'cookie_consent' => (isSet($_REQUEST['cookie_consent']) && $_REQUEST['cookie_consent'] == 'on') ? 1 : 0,
		'deeplinks' => (isSet($_REQUEST['deeplinks']) && $_REQUEST['deeplinks'] == 'on') ? 1 : 0,
		'status' => 0,
		'screenshots' => (isSet($_REQUEST['screenshots']) && $_REQUEST['screenshots'] == 'on') ? 1 : 0,
		'cookies' => (isSet($_REQUEST['cookies']) && $_REQUEST['cookies'] == 'on') ? 1 : 0,
		'resources' => (isSet($_REQUEST['resources']) && $_REQUEST['resources'] == 'on') ? 1 : 0,
		'banners' => (isSet($_REQUEST['banners']) && $_REQUEST['banners'] == 'on') ? 1 : 0,
		'libraries' => (isSet($_REQUEST['libraries']) && $_REQUEST['libraries'] == 'on') ? 1 : 0,
		'errors' => (isSet($_REQUEST['errors']) && $_REQUEST['errors'] == 'on') ? 1 : 0
	);

	$job_id = $database->insert('jobs', $dataArray);

	//var_dump($database->error());

        echo '<div class="alert alert-info">'; 
        echo '        <strong>Job created!</strong> A new job with ID ' . $job_id .' has been started.';
        echo '</div>';

}

if (isSet($_REQUEST['redojob'])) {
	$dataArray = $database->select('jobs', ['url', 'cookie_consent', 'deeplinks', 'screenshots', 'cookies', 'resources', 'banners', 'libraries', 'errors'], ['id' => $_REQUEST['redojob']]);
	$dataArray[0]['status'] = 0;

	$job_id = $database->insert('jobs', $dataArray[0]);

	//var_dump($database->error());

        echo '<div class="alert alert-info">'; 
        echo '        <strong>Job created!</strong> A new job with ID ' . $job_id .' has been started.';
        echo '</div>';
}

?>
