module.exports = {
	onAlert: onAlert,
	onConsoleMessage: onConsoleMessage,
	onError: onError,
	onResourceRequested: onResourceRequested,
	onResourceReceived: onResourceReceived,
	onResourceTimeout: onResourceTimeout,
	onResourceError: onResourceError
};

// Hook page alert so that we can debug more easily
function onAlert(msg) {
  console.log('ALERT: ' + msg);
};

function onConsoleMessage(msg, lineNum, sourceId) {
  console.log('CONSOLE: ' + msg + ' (from line #' + lineNum + ' in "' + sourceId + '")');
};

// Hook page errors so that we can save them to a file
function onError(msg, trace) {
	if (configuration.trackErrors && typeof trace['function'] != 'undefined') {
		traceFunction = trace['function'].replace(/(\r\n|\n|\r)/gm, ' ');
		exportLists.errors.list.push([
			systemArguments.config,
			Date.now(),
			msg,
			trace['file'],
			trace['line'],
			traceFunction
		].join(delimiter));
		console.log('Javascript error occured, saving to file..')
	}
};

// Hook resourse triggers so that we can measure resource loading
function onResourceRequested(requestData, networkRequest) {
	if (!/^data:/.test(requestData.url))
		exportLists.resources.resources[requestData.id] = {"url": requestData.url, "requested": requestData.time.getTime() - timestamp, "completed": 0, "failed": 0};
};

// Hook resourse triggers so that we can measure resource loading
function onResourceReceived(response) {
	if (/3[0-9]{2}/.test(response.status))				// Redirect
		delete exportLists.resources.resources[response.id];
	else if (/2[0-9]{2}/.test(response.status))	{		// Successful response
		exportLists.resources.resources[response.id]['completed'] = response.time.getTime() - timestamp;
		exportLists.resources.resources[response.id]['content_type'] = response['contentType'].split(delimiter)[0];
		exportLists.resources.resources[response.id]['party'] = resourceParty.detectParty(response.url);
		//console.log(JSON.stringify(response, undefined, 4));
	}
};

// Hook resourse triggers so that we can measure resource loading
function onResourceTimeout(request) {
	exportLists.resources.resources[request.id]['failed'] = Date.now() - timestamp;
	console.log('    Encountered resource timeout..');
	//handleUrls.nextUrl();
};

// Hook resourse triggers so that we can measure resource loading
function onResourceError(request) {
	//console.log('\n' + JSON.stringify(request, undefined, 4) + '\n');
	exportLists.resources.resources[request.id]['failed'] = Date.now() - timestamp;
};