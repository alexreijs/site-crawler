<?php

require_once(dirname(__FILE__) . '/includes/config.php');

$jobs = $database->select('jobs', '*', ['ORDER' => 'id DESC', 'LIMIT' => '50']);

if (count($jobs) > 0) {

?>
<table class="table">

	<tr>

		<th>ID</th>
		<th>Date</th>
		<th>Status</th>
		<th>URL</th>
		<th>Screenshots</th>
		<th>Cookies</th>
		<th>Resources</th>
		<th>Errors</th>

	</tr>

	<?php

	foreach ($jobs as $index => $job) {

		echo '<tr>';

			echo '<td>' . $job['id'] . '</td>';
			echo '<td>' . $job['date'] . '</td>';
			echo '<td>';
				switch ($job['status']) {
					case 0: echo '<img src="./images/loading.gif" border="0"/>';
						break;
					case 1: echo '<img src="./images/play.png" border="0"/>';
						break;
					case 2: echo '<img src="./images/checkmark.png" border="0"/>';
						break;
				}
			echo '</td>';

			echo '<td><a href="' . $job['url'] . '" target="_BLANK">' . $job['url'] . '</a></td>';

			echo '<td>';
				if ($job['screenshots']) {
					switch ($job['status']) {
						case 0: echo 'zip';
							break;
						case 1: echo 'zip';
							break;
						case 2: echo '<a href="#download.php?type=screenshots&id=' . $job['id']. '">zip</a>';
							break;
					}
				}
			echo '</td>';

			echo '<td>';
				if ($job['cookies']) {
					switch ($job['status']) {
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
				if ($job['errors']) {
					switch ($job['status']) {
						case 0: echo 'csv';
							break;
						case 1: echo 'csv';
							break;
						case 2: echo '<a href="download.php?type=errors&id=' . $job['id']. '">csv</a>';
							break;
					}
				}
			echo '</td>';

		echo '</tr>';

	}
	?>

</table>

<?php

}
else
	echo '<center><h4>No jobs found</h4></center>';

?>
