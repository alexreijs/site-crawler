<?php

require_once(dirname(__FILE__) . '/includes/config.php');

if (!isSet($_REQUEST['job_id'])) {
	echo "Job ID required";
	exit;
}

$jobs = $database->select('jobs', '*', ["id" => $_REQUEST['job_id']]);

if (count($jobs) == 0) {
	echo "Job not found";
	exit;
}


$id = $jobs[0]['id'];

$jobFolder =  '/tmp/site-crawler/job_' . $id;

$outputDirs = glob($jobFolder . "/*" , GLOB_ONLYDIR);
$outputDir = end($outputDirs);




function getDataFromCSV($data, $folder, $file) {

	$stringCSV = file_get_contents($folder . '/' . $file . '.txt');
	$dataCSV = str_getcsv($stringCSV, "\n"); //parse the rows

	foreach($dataCSV as $rowId => $row) {
		// Get header
		if ($rowId == 0) {

			$header = array();

			foreach (str_getcsv($row, ";") as $item) {
				$item =  preg_replace(array('/CookieDomain/', '/ResourceHost/'), array('Host', 'Host'), $item);
				$item =  preg_replace(array('/CookieParty/', '/ResourceParty/'), array('Party', 'Party'), $item);
				$item =  preg_replace(array('/CookiePartyCategory/', '/ResourcePartyCategory/'), array('PartyCategory', 'PartyCategory'), $item);
				array_push($header, $item);
			}

		}
		else {
			$rowData = array_combine($header, str_getcsv($row, ";"));
			$hostName = $rowData['LocationHostname'];
			$pathName = $rowData['LocationPathname'];

			if (!isSet($data[$hostName][$pathName]))
				$data[$hostName][$pathName] = array();

			if (!isSet($data[$hostName][$pathName][$file]))
				$data[$hostName][$pathName][$file] = array();

			array_push($data[$hostName][$pathName][$file], $rowData);
		}
	}

	return $data;
}

$allData = getDataFromCSV(array(), $outputDir, 'cookies');
$allData = getDataFromCSV($allData, $outputDir, 'resources');

?>


<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Sanoma - Site-Crawler</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="./css/jumbotron-narrow.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

<body>



<?php

//print_r($allData);

foreach ($allData as $hostName => $hostData) {

	echo '<div class="collapsible" id="' . $hostName . '">' . $hostName .'<span></span></div>';

	echo '<div>';

	foreach ($hostData as $pathName => $fileData) {


		echo '<div class="collapsible" id="' . $hostName . $pathName . '" style="margin-left:20px;">' . $hostName . ' ' . $pathName . '<span></span></div>';

		echo '<div>';

		foreach ($fileData as $fileType => $data) {

			echo '<div class="collapsible" id="' . $hostName . $pathName . '_' . $fileType . '" style="margin-left:40px;">' . $fileType . '<span></span></div>';

			echo '<div>';

			foreach ($data as $rowId => $row) {

				echo '
				<div class="container-fluid" style="margin-left:20px;">
			 		<div class="col-md-4">
			 			' . $row['Host'] . '
	        			</div>
	 				<div class="col-md-4">
	 					' . $row['Party'] . '
					</div>
	 				<div class="col-md-4">
						' . $row['PartyCategory']. '
					</div>
				</div>';

			}

			echo '</div>';

		}

		echo '</div>';

		break;
	}

	echo '</div>';

}

?>








<script type="text/javascript" src="js/jquery.collapsible.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
    //collapsible management
        $('.collapsible').collapsible({
		speed : 200,
		//bind : 'mouseenter'
        });
    });
</script>


<style>

.collapse-open {
    background:#000;
    color: #fff;
}

.collapse-open span {
    display:block;
    float:right;
    padding:10px;
}

.collapse-open span {
    background:url(images/minus.png) center center no-repeat;
}

.collapse-close span {
    display:block;
    float:right;
    background:url(images/plus.png) center center no-repeat;
    padding:10px;
}
</style>

</body>

</html>
