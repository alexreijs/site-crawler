#!/usr/bin/php
<?php

require_once(dirname(__FILE__) . '/includes/config.php');


$jobs = $database->select('jobs', '*', ['status' => [0, 1]]);

foreach($jobs as $index => $job) {

	switch($job['status']) {

		case 0: // Create configuration file
			$config = " module.exports = {\n";
			$config .= "	sanomaConsentCategories: [" . ($job['cookie_consent'] ? "'atinternet', 'ads', 'stats', 'functional', 'interests', 'stir', 'social', 'videoplaza'" : "") . "],\n";
			$config .= "	getContentDeeplink: 0,\n";
			$config .= "	urls: ['" . $job['url'] . "'],\n";
			$config .= "	zoomFactor: 1,\n";
			$config .= "	userAgent: 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0',\n";
			$config .= "	viewportSize: {width: 1280, height: 800},\n";
			//$config .= "	clipRect: {top: 0, left: 0, width: 1280, height: 4000},\n";
			$config .= "	screenshotPage: " . $job['screenshots'] . ",\n";
			$config .= "	detectBanners: 0,\n";
			$config .= "	storeCookies: " . $job['cookies'] . ",\n"; 
			$config .= "	trackResources: " . $job['resources'] . ",\n"; 
			$config .= "	trackErrors: " . $job['errors'] . "\n";
			$config .= "};";

			// Save configuration file
			$configFile = '/var/tmp/site-crawler-job_' . $job['id'] . '.js';
			if (!file_exists($configFile)) {
				$fs = fopen($configFile, "w") or die("Unable to open file!");
				fwrite($fs, $config);
				fclose($fs);
			}

			// Create job command
			$command = '/usr/local/bin/phantomjs ' . $_SESSION['config']['siteCrawlerLocation'] . '/site_crawler.js config=' . $configFile . ' workingdir=' . $_SESSION['config']['siteCrawlerLocation'] . ' outputdir=/var/tmp/site-crawler/job_' . $job['id']. '/';

			// Make sure job starts in background
			$command = 'nohup ' . $command . ' > /dev/null 2>&1 &';

			// Start command
			exec($command);
			echo 'starting job: ' . $job['id'];

			// Set status to 1 in databse
			$database->update('jobs', ['status' => 1], ['id' => $job['id']]);

			// Remove configuration file
			//unlink($configFile);

			break;
		case 1:
			// Get all running site-crawler jobs
			$currentJobs = shell_exec("ps -ef | grep 'site_crawler.js config=/var/tmp/site-crawler-job_'" . $job['id']);

			// Check if current job is completed
			$jobRunning = false;
			foreach(preg_split("/((\r?\n)|(\r\n?))/", $currentJobs) as $line){
				if (preg_match('/phantomjs.*site_crawler.js config=.*site-crawler-job_' . $job['id'] . '.js/', $line))
					$jobRunning = true;
			}

			// Check if we've got output
			$outputFound = file_exists('/var/tmp/site-crawler/job_' . $job['id'] . '/');


			// When output is found and job is no longer running set status to 2
			if ($outputFound && !$jobRunning)
				$database->update('jobs', ['status' => 2], ['id' => $job['id']]);

			echo 'jobID: ' . $job['id'];
			echo "\n";
			echo 'outputFound: ' . $outputFound;
			echo "\n";
			echo 'jobRunning: ' . $jobRunning;

			break;

	}

}

?>
