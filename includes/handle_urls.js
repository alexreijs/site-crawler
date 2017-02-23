module.exports = {
	handleUrl: handleUrl,
	nextUrl: nextUrl,
	currentURL: currentURL,
	logTimeElapsed: logTimeElapsed
};

var url;
var urlTimeout;
var urlTimeoutRetryCount = {};

var urlStates = {};
var urlInterval = setInterval(function() {
	
	if(typeof url != 'undefined') {
		
		// New request
		if (typeof urlStates[url] == 'undefined') {
			
			// Check if we need to go to next URL after max retries
			if (urlTimeoutRetryCount[url] > urlTimeoutMaxRetries)
				nextUrl();
			
			urlStates[url] = {'started': Date.now()};
			handleUrl(url);
		}
	}

}, 10);


function currentURL() {
	return url;
}

// This function will be recursively called until all urls have been handled
function handleUrl(url){

	// Create timeout
	//clearTimeout(urlTimeout);
	//urlTimeout = setTimeout(function(){
	//	console.log('    Encountered timeout ..');
		//nextUrl();
	//}, timeoutMS);

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
		
	// Check if we need to set sanoma consent manager categories
	if (configuration.sanomaConsentCategories.length > 0) {
		phantom.addCookie({
			'name'     : 'site_consent',
			'value'    : 'sitecrawler|' + Math.floor((Math.random() * 8999) + 1000) + '%3' + timestamp + '%3Aall%3A' + configuration.sanomaConsentCategories.join('%2C'),
			'domain'   : '.' + genericFunctions.parseURL(url).host,
			'path'     : '/',
			'httponly' : false,
			'secure'   : false,
			'expires'  : (new Date()).getTime() + (1000 * 60 * 60)
		});
		phantom.addCookie({
			'name'     : 'consentBarViewCount',
			'value'    : '2',
			'domain'   : '.' + genericFunctions.parseURL(url).host,
			'path'     : '/',
			'httponly' : false,
			'secure'   : false,
			'expires'  : (new Date()).getTime() + (1000 * 60 * 60)
		});
	}

	console.log(Date());

	currentURL = genericFunctions.parseURL(page.url);
	nextURL = genericFunctions.parseURL(url);

	// Check to see if we are trying to open the same URL repeatedly, this will result in the browser not loading anything. We will go to next url in this case
	if (currentURL.protocol + '://' + currentURL.host + currentURL.path == nextURL.protocol + '://' + nextURL.host + nextURL.path) {
		console.log('Skipping address: ' + url + ' (already on same page)\n');	
		nextUrl();
	}
	else {
		// Open current url
		console.log('Openening address: ' + url + (urlTimeoutRetryCount[url] > 0 ? ' (retry count: ' + urlTimeoutRetryCount[url] + ')' : ''));	

		page.open(url, function (status) {
			// Lock page navigation during loading of page in order to avoid javascript and meta refresh
			page.navigationLocked = true;

			if (status !== 'success') { 
				page.navigationLocked = false;
				console.log('    Request exitted with status: ' + status);
				console.log('Retrying URL\n');
				urlTimeoutRetryCount[url] = (typeof urlTimeoutRetryCount[url] == 'undefined' ? 1 : urlTimeoutRetryCount[url] + 1);
				delete urlStates[url];
			}
			else {
				function checkReadyState() {
					setTimeout(function () {
						var readyState = page.evaluate(function () {
							return document.readyState;
						});
						
						if(typeof urlStates[url] == 'undefined')
							urlStates[url] = {};
						
						urlStates[url][readyState] = Date.now();
				
						if (readyState === 'complete') {
							console.log('    Page load completed - waiting for async (' + onloadWait / 1000 +' sec)');
							setTimeout(function() {
								pageOpenCallback.pageOpenCallback();
								logTimeElapsed();
								nextUrl();
							}, onloadWait);
						}
						else
							checkReadyState();
					});
				}
				checkReadyState();
			}

		});
	}
}

function nextUrl(){

	// Unlock page navigation
	page.navigationLocked = false;

	// Delete states data from previous URL
	delete urlStates[url];

	// Get current URL
	url = configuration.urls.shift();

	// If no more URLs found, exit phantom
	if(!url) {
		console.log('Done, exiting phantomJS..\n');		
		phantom.exit();
	}
}


function logTimeElapsed() {
	console.log('Elapsed: ' + (urlStates[url]['complete'] - urlStates[url]['started'] + onloadWait) / 1000 + ' seconds\n');
}
