<?php

include('../includes/config.php');

$jobs = $database->select('jobs');

print_r($jobs);


?>
