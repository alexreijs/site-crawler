#!/usr/bin/php
<?php

require_once(dirname(__FILE__) . '/includes/config.php');

// Create directory structure
$mainDir = '/tmp/site-crawler/';
if (!is_dir($mainDir))
	mkdir($mainDir);

$logDir = $mainDir . 'logs/';
if (!is_dir($logDir))
	mkdir($logDir);

$confDir = $mainDir . 'configurations/';
if (!is_dir($confDir))
	mkdir($confDir);

$jobs = $database->select('jobs', '*', ['status' => [0, 1]]);

foreach($jobs as $index => $job) {

	$logFile = '/tmp/site-crawler/logs/job_' . $job['id'] . '.log';
	$configFile = '/tmp/site-crawler/configurations/site-crawler-job_' . $job['id'] . '.js';

	switch($job['status']) {

		case 0: // Create configuration file
			$config = " module.exports = {\n";
			$config .= "	sanomaConsentCategories: [" . ($job['cookie_consent'] ? "'atinternet', 'ads', 'stats', 'functional', 'interests', 'stir', 'social', 'videoplaza'" : "") . "],\n";
			$config .= "	getAllDeeplinks: " . $job['deeplinks'] . ",\n";
			$config .= "	getContentDeeplink: 0,\n";
			$config .= "	urls: ['" . implode("', '", explode(";", $job['url'])) . "'],\n";
			$config .= "	zoomFactor: 1,\n";
			$config .= "	userAgent: 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0',\n";
			$config .= "	viewportSize: {width: 1280, height: 800},\n";
			$config .= "	scanLibraries: " . $job['libraries'] . ",\n";
			$config .= "	screenshotPage: " . $job['screenshots'] . ",\n";
			$config .= "	detectBanners: " . $job['banners'] . ",\n";
			$config .= "	storeCookies: " . $job['cookies'] . ",\n"; 
			$config .= "	trackResources: " . $job['resources'] . ",\n"; 
			$config .= "	trackErrors: " . $job['errors'] . "\n";
			$config .= "};";

			// Save configuration file
			if (!file_exists($configFile)) {
				$fs = fopen($configFile, "w") or die("Unable to open file!");
				fwrite($fs, $config);
				fclose($fs);
			}

			// Create job command
			$command = 'sh ' . $_SESSION['config']['siteCrawlerLocation'] . '/sh/run-job.sh ' . $configFile . ' /tmp/site-crawler/job_' . $job['id'] . '/ ' . $logFile;

			// Make sure job starts in background
			$command = 'nohup ' . $command . ' > /dev/null 2>&1 &';

			// Start command
			//echo $command;
			exec($command);
			echo "\n";
			echo 'starting job: ' . $job['id'];



			// Set status to 1 in databse
			$database->update('jobs', ['status' => 1], ['id' => $job['id']]);

			break;
		case 1:
			echo 'jobID: ' . $job['id'];
			echo "\n";

			// Get all running site-crawler jobs
			$currentJobs = shell_exec("ps -ef | grep 'site_crawler.js config=". $configFile . "'");

			// Check if current job is completed
			$jobRunning = false;
			foreach(preg_split("/((\r?\n)|(\r\n?))/", $currentJobs) as $line){
				if (preg_match('/phantomjs.*site_crawler.js config=.*site-crawler-job_' . $job['id'] . '.js/', $line))
					$jobRunning = true;
			}

			// Check if we've got output
			$outputFound = file_exists('/tmp/site-crawler/job_' . $job['id'] . '/');

			// When output is found and job is no longer running set status to 2
			if (!$jobRunning)
				$database->update('jobs', ['status' => $outputFound ? 2 : -1], ['id' => $job['id']]);
			// When job is running but log file hasnt changed in 10 minutes, cancel job
			else {
				if (time() - filemtime($logFile) >= 10 * 60) {
					exec("ps axf | grep site-crawler-job_" . $job['id'] . ".js | grep -v grep | awk '{print \"kill -9 \" $1}' | sh", $output);
					$database->update('jobs', ['status' => -1], ['id' => $job['id']]);
					echo 'killedJob';
					echo "\n";
				}
			}

			echo 'outputFound: ' . $outputFound;
			echo "\n";
			echo 'jobRunning: ' . $jobRunning;

			break;

	}

}

?>
