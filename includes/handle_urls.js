module.exports = {
	handleUrl: handleUrl,
	nextUrl: nextUrl,
	start: start,
	currentURL: currentURL,
	logTimeElapsed: logTimeElapsed
};

var url;
var urlTimeout;
var urlTimeoutRetryCount = 0;

function currentURL() {
	return url;
}

// This function will be recursively called until all urls have been handled
function handleUrl(url){

	// Create export header lines
	for (listName in exportLists) {
		exportLists[listName].list = [];
		fileName = outputDir + '/' + listName + '.txt';
		
		if (!fs.exists(fileName))
			fs.write(fileName, exportLists[listName].headers.join(delimiter) + '\n', 'a+');					
	}

	// Reset scope variables
	phantom.clearCookies();
	timestamp = Date.now();
	exportLists.resources.resources = {};
	
	// Open current url
	console.log(Date());
	console.log('Openening address: ' + url + (urlTimeoutRetryCount > 0 ? ' (retry count: ' + urlTimeoutRetryCount + ')' : ''));
	page.open(url, pageOpenCallback.pageOpenCallback);
	
}

function nextUrl(wasSuccess){
	
	// Set a timeout
	window.clearTimeout(urlTimeout);
	urlTimeout = window.setTimeout(timeout, timeoutMS);
	
	// Check if we need to to a retry
	if (!wasSuccess && urlTimeoutRetryCount < urlTimeoutMaxRetries) {
		configuration.urls.unshift(url);
		urlTimeoutRetryCount++;
	}
	
	// Reset retries
	if (wasSuccess)
		urlTimeoutRetryCount = 0;
	else if (urlTimeoutRetryCount > urlTimeoutMaxRetries) {
		configuration.urls.shift();
		urlTimeoutRetryCount = 0;
	}


	// Get next URL
	url = configuration.urls.shift();
    
	// If no more URLs found, exit phantom
	if(!url) {
		console.log('Done, exiting phantomJS..\n');
		phantom.exit();
	}
	
	// Process URL
	handleUrl(url);
}

function start() {
	console.log('\nStarting phantomJS, using configuration: ' + systemArguments.config + '\n');
	nextUrl(true);
}

function timeout() {
	console.log('    Encountered timeout, ' + (urlTimeoutRetryCount + 1 > urlTimeoutMaxRetries ? 'reached max number of retries' : 'retrying'));
	logTimeElapsed(0);
	nextUrl(false);
}

function logTimeElapsed(timestampDelta) {
	console.log('Elapsed: ' + Math.round((Date.now() - timestamp - timestampDelta) * 1000) / 1000000 + ' seconds\n');
}