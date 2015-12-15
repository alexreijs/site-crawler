<pre>
<?php

if (isSet($_REQUEST['id'])) {

	$logContent = file_get_contents('/tmp/site-crawler/logs/job_' . $_REQUEST['id'] . '.log');

	echo str_replace('    ', "\t", nl2br($logContent));

}

?>
</pre>

<script>
window.scrollTo(0,document.body.scrollHeight);
window.setTimeout(function() {location.reload(true);}, 5000);
</script>
