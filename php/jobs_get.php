<?php

require_once(dirname(__FILE__) . '/includes/config.php');

$jobs = $database->select('jobs', '*', ['ORDER' => 'id DESC', 'LIMIT' => '50']);

if (count($jobs) > 0) {

?>
<table class="table">

	<tr>

		<th>Status</th>
		<th>ID</th>
		<th>Date</th>
		<th>URL</th>
		<th>Consent</th>
		<th>Deeplinks</th>
		<th>Screenshot</th>
		<th>Cookies</th>
		<th>Resources</th>
		<th>Banners</th>
		<th>Libraries</th>
		<th>Errors</th>
		<th>Log</th>

	</tr>

	<?php

	foreach ($jobs as $index => $job) {

		echo '<tr>';

			echo '<td>';
				switch ($job['status']) {
					case -1: echo '<img src="./images/error.gif" border="0"/>';
						break;
					case 0: echo '<img src="./images/loading.gif" border="0"/>';
						break;
					case 1: echo '<img src="./images/play.png" border="0"/>';
						break;
                                        case 2: echo '<img src="./images/checkmark.png" border="0"/><br/>';
                                                echo '<a href="index.php?action=jobs&redojob=' . $job['id'] . '" info="Do job again" alt="Do job again"><img src="./images/refresh.png" width="20" height="20" border="0"/></a>';
						break;
				}
			echo '</td>';

			echo '<td>' . $job['id'] . '</td>';
			echo '<td>' . $job['date'] . '</td>';

			echo '<td><div style="overflow:auto; width:275px; overflow-x:hidden; max-height:200px;">';

			$i = 1;
			foreach (explode(';', $job['url']) as $index => $url) {
				echo '<a href="' . $url . '" target="_BLANK">' . $url . '</a><br/>';
				$i++;
				if ($i > 11) {
				//	echo '...';
				//	break;
				}
			}

			echo '</div></td>';

			echo '<td>' . ($job['cookie_consent'] ? 'Yes' : 'No') . '</td>';

			echo '<td>' . ($job['deeplinks'] ? 'Yes' : 'No') . '</td>';

			echo '<td>';
				if ($job['screenshots']) {
					switch ($job['status']) {
						case -1: echo '<a style="color:orange" href="download.php?type=screenshots&id=' . $job['id']. '">png</a>';
							break;
						case 0: echo 'png';
							break;
						case 1: echo 'png';
							break;
						case 2: echo '<a href="download.php?type=screenshots&id=' . $job['id']. '">png</a>';
							break;
					}
				}
			echo '</td>';

			echo '<td>';
				if ($job['cookies']) {
					switch ($job['status']) {
						case -1: echo '<a style="color:orange" href="download.php?type=cookies&id=' . $job['id']. '">csv</a>';
							break;
						case 0: echo 'csv';
							break;
						case 1: echo 'csv';
							break;
						case 2: echo '<a href="download.php?type=cookies&id=' . $job['id']. '">csv</a>';
							break;
					}
				}
			echo '</td>';

			echo '<td>';
				if ($job['resources']) {
					switch ($job['status']) {
						case -1: echo '<a style="color:orange" href="download.php?type=resources&id=' . $job['id']. '">csv</a>';
							break;
						case 0: echo 'csv';
							break;
						case 1: echo 'csv';
							break;
						case 2: echo '<a href="download.php?type=resources&id=' . $job['id']. '">csv</a>';
							break;
					}
				}
			echo '</td>';

			echo '<td>';
				if ($job['banners']) {
					switch ($job['status']) {
						case -1: echo '<a style="color:orange" href="download.php?type=banners&id=' . $job['id']. '">csv</a>';
							break;
						case 0: echo 'csv';
							break;
						case 1: echo 'csv';
							break;
						case 2: echo '<a href="download.php?type=banners&id=' . $job['id']. '">csv</a>';
							break;
					}
				}
			echo '</td>';

			echo '<td>';
				if ($job['libraries']) {
					switch ($job['status']) {
						case -1: echo '<a style="color:orange" href="download.php?type=libraries&id=' . $job['id']. '">csv</a>';
							break;
						case 0: echo 'csv';
							break;
						case 1: echo 'csv';
							break;
						case 2: echo '<a href="download.php?type=libraries&id=' . $job['id']. '">csv</a>';
							break;
					}
				}
			echo '</td>';

			echo '<td>';
				if ($job['errors']) {
					switch ($job['status']) {
						case -1: echo '<a style="color:orange" href="download.php?type=errors&id=' . $job['id']. '">csv</a>';
							break;
						case 0: echo 'csv';
							break;
						case 1: echo 'csv';
							break;
						case 2: echo '<a href="download.php?type=errors&id=' . $job['id']. '">csv</a>';
							break;
					}
				}
			echo '</td>';

			echo '<td><a href="#" onclick="log_' . $job['id']. ' = window.open(\'./log.php?id=' . $job['id'] . '\', \'site-crawler-log\', \'status=0,scrollbars=1,toolbar=0,width=1280,height=1024\'); log_' . $job['id'] . '.focus();">log</a></td>';


		echo '</tr>';

	}
	?>

</table>

<div><center>This table refreshes automatically every 10 seconds<br/>&nbsp;</center></div>


<?php

}
else
	echo '<center><h4>No jobs found</h4></center>';

?>
