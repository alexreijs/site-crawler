// Initilize file system object
var fs = require('fs');

// Initiliaze timestamp
var timestamp = Date.now();

// Get system arguments
var system = require('system');
systemArguments = {};
for (x in system.args) {
	argument = system.args[x];
	if (/[a-z_/]*=[a-z_/]*/.test(argument))
		systemArguments[argument.split('=')[0]] = argument.split('=')[1];
}

// Check for mandatory arguments
if (typeof systemArguments.config == 'undefined') {
	console.log('Please specify a configuration by using "config=xxx" as parameter');
	phantom.exit();
}
else if (!fs.exists(systemArguments.config)) {
	console.log('The configuration file you specified could not be found');
	phantom.exit();
}
else if (typeof systemArguments.outputdir == 'undefined') {
	console.log('Please specify a direcoty to be used to storing the output using "outputdir=xxx" as parameter');
	phantom.exit();
}
else if (typeof systemArguments.norendering == 'undefined')
	systemArguments.norendering = 0;

// Set settings
var onloadWait = 3500;
var delimiter = ';';
var timeoutMS = 5000;
var urlTimeoutMaxRetries = 3;
var outputDir = systemArguments.outputdir + '/' + Date.now();

// Get includes
var configuration = require(systemArguments.config);
var genericFunctions = require('./includes/generic_functions.js');
var cookieParty = require('./includes/cookie_party.js');
var resourceParty = require('./includes/resource_party.js');
var handleURLs = require('./includes/handle_urls.js');
var triggerFunctions = require('./includes/trigger_functions.js');
var pageOpenCallback = require('./includes/page_open_callback.js');
var detectBanners = require('./includes/detect_banners.js');


// Check if URLs were found
if (typeof configuration.urls == 'undefined' || configuration.urls.length == 0) {
	console.log('No URLs were specified, aborting');
	phantom.exit();
}


// Create outputDir structure
if (!fs.isDirectory(outputDir)) {
	fs.makeTree(outputDir);
	fs.makeDirectory(outputDir + '/screenshots');
	fs.makeDirectory(outputDir + '/banners');
}

// Create new phantom page object and set initial settings
var page = require('webpage').create();
page.settings.resourceTimeout = timeoutMS;
page.viewportSize = configuration.viewportSize;
page.zoomFactor = configuration.zoomFactor;
page.settings.userAgent = configuration.userAgent;

// Hook callback triggers to page 
for (trigger in triggerFunctions) {
	if ((/Resource/.test(trigger) && configuration.trackResources) || !/Resource/.test(trigger))
		page[trigger] = triggerFunctions[trigger];
}

// Make an object containing every list we are exporting
var exportLists = {
	"cookies": {
		"list": [],
		"log": "Stored [x] cookies",
		"headers": ['Configuration', 'Timestamp', 'LocationProtocol', 'LocationHostname', 'LocationPathname', 'CookieDomain', 'CookieName', 'CookieValue', 'CookieParty', 'CookiePartyCategory']
	},
	"banners": {
		"list": [],
		"log": "Found and saved [x] banners",
		"headers": ['Configuration', 'Timestamp', 'LocationProtocol', 'LocationHostname', 'LocationPathname', 'BannerID', 'BannerParentID', 'BannerFilename', 'BannerDescription', 'BannerWidth', 'BannerHeight', 'BannerTop', 'BannerLeft']
	},
	"resources": {
		"resources": {},
		"list": [],
		"log": "Tracked [x] resources",
		"headers": ['Configuration', 'Timestamp', 'LocationProtocol', 'LocationHostname', 'LocationPathname', 'ResourceID', 'ResourceContentType', 'ResourceURL', 'ResourceHost', 'ResourcePath', 'ResourceParty', 'ResourceRequested', 'ResourceCompleted', 'ResourceFailed']
	},
	"screenshots": {
	 	"list": [],
		"headers": ['Configuration', 'Timestamp', 'LocationProtocol', 'LocationHostname', 'LocationPathname', 'ScreenshotWidth', 'ScreenshotHeight', 'Filename']
	},
	"errors": {
		"list": [],
		"log": "Tracked [x] errors",
		"headers": ['Configuration', 'Timestamp', 'Message', 'File', 'Line', 'Function']
	}
};

// Start with first URL
handleURLs.start();

// cd C:\Users\A.Reijs\Repos\site-crawler\
// phantomjs --ssl-protocol=any --ignore-ssl-errors=true .\site_crawler.js config=desktop outputdir=.\output