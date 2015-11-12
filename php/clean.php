<?php

$link = mysql_connect('localhost', 'root', '1234') or die('Could not connect: ' . mysql_error());
mysql_select_db('site-crawler') or die('Could not select database');

$query = 'TRUNCATE jobs';
$result = mysql_query($query) or die('Query failed: ' . mysql_error());


exec('rm /var/tmp/site-crawler-job*.js');
exec('rm -r /var/tmp/site-crawler')

?>
