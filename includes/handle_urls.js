module.exports = {
	handleUrl: handleUrl,
	nextUrl: nextUrl,
	start: start,
	currentURL: currentURL
};

var url;
var urlTimeout;

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
	console.log('Openening address: ' + url);
	page.open(url, pageOpenCallback.pageOpenCallback);
	
}

function nextUrl(){
	
	// Set a timeout
	window.clearTimeout(urlTimeout);
	urlTimeout = window.setTimeout(timeout, timeoutMS);

	// If we were already getting an URL, show elapsed time
	if (typeof url != 'undefined')
		console.log('Elapsed: ' + Math.round((Date.now() - onloadWait - timestamp) * 1000) / 1000000 + ' seconds\n');

	// Get next URL
	url = configuration.urls.shift();
    
	// If no more URLs found, exit phantom
	if(!url) {
		console.log('Done, exiting phantomJS..\n');
		phantom.exit(0);
	}
	
	// Process URL
	handleUrl(url);
}

function start() {
	console.log('\nStarting phantomJS, using configuration: ' + systemArguments.config + '\n');
	nextUrl();
}

function timeout() {
	console.log('    Encountered timeout while trying to connect..');
	nextUrl();
}