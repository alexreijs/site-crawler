module.exports = {
    pageOpenCallback: pageOpenCallback
};

// Define function that will be called when phantom page is done loading
function pageOpenCallback(status) {

	if (status !== 'success') {
		console.log('Request exitted with status: ' + status + '\n');
	} else {

		// Set a timeout on the code in order to give the page a little bit more time to render javascript
		window.setTimeout(function () {
	 
			// Get the location of the current page
			var location = genericFunctions.parseURL(page.evaluate(function() {
				return window.location.href;
			}));
						
			// Skip about:.... pages
			if (location.protocol != 'about') {
			

			
				// Get banners
				if (configuration.detectBanners) {
					var banners = detectBanners.detectBanners(page);
	
					// Loop through banners and let phantom take screenshots of them
					for (x in banners) {
						banner = banners[x];
						clipRect = banner.clipRect;
						page.clipRect = clipRect;
						if (Math.sqrt(clipRect.width * clipRect.height) < 750 && clipRect.width > 0 && clipRect.height > 0) {
							// Render banner to png
							if (banner.parent.length == 0 && systemArguments.norendering != 1)
								page.render(outputDir + '/banners/' + encodeURIComponent(banner.id) + '.png');
							
							// Add banner to list of banners
							exportLists.banners.list.push([
								systemArguments.config, timestamp, location.protocol, location.host, genericFunctions.encloseQuotes(location.path),
								genericFunctions.encloseQuotes(banner.id), genericFunctions.encloseQuotes(banner.parent), genericFunctions.encloseQuotes(encodeURIComponent(banner.id)), genericFunctions.encloseQuotes(banner.description),
								Math.round(clipRect.width), Math.round(clipRect.height), Math.round(clipRect.top), Math.round(clipRect.left)
							].join(delimiter));
						}
					}
				}
				
				// Add cookies to list of cookies
				if (configuration.storeCookies) {
					for (x in phantom.cookies) {
						cookie = phantom.cookies[x];
						cookiePartyInfo = cookieParty.detectParty(location, cookie.domain, cookie.name);
						exportLists.cookies.list.push([
							systemArguments.config, timestamp, location.protocol, location.host, genericFunctions.encloseQuotes(location.path),
							cookie.domain, genericFunctions.encloseQuotes(cookie.name), genericFunctions.encloseQuotes(cookie.value), cookiePartyInfo.party, cookiePartyInfo['type']
						].join(delimiter));					
					}
				}
				
				// Add resources to list of resources
				if (configuration.trackResources) {
					for (id in exportLists.resources.resources) {
						resource = exportLists.resources.resources[id];
						exportLists.resources.list.push([
							systemArguments.config, timestamp, location.protocol, location.host, genericFunctions.encloseQuotes(location.path),
							id, genericFunctions.encloseQuotes(resource.content_type), genericFunctions.encloseQuotes(resource.url), genericFunctions.parseURL(resource.url).host, genericFunctions.encloseQuotes(genericFunctions.parseURL(resource.url).path), resource.requested, resource.completed, resource.failed
						].join(delimiter));
					}
				}
				
				
				// Render screenshot as png
				if (configuration.screenshotPage && systemArguments.norendering != 1) {
					filename =  outputDir + '/screenshots/' + encodeURIComponent(location.host + location.path) + '.png';
					exportLists.screenshots.list.push([
						systemArguments.config, timestamp, location.protocol, location.host, genericFunctions.encloseQuotes(location.path), 
						configuration.clipRect.width, configuration.clipRect.height, genericFunctions.encloseQuotes(encodeURIComponent(location.host + location.path) + '.png')
					].join(delimiter));
					page.clipRect = configuration.clipRect;
					page.render(filename);
					console.log('    ' + 'Saved screenshot');
				}
				
				// Store cookies, banners, resources screenshots, and errors
				for (listName in exportLists) {
					list = exportLists[listName];
					
					fs.write(outputDir + '/' + listName + '.txt', list.list.join('\n') + '\n', 'a+');		
					
					if (typeof list.log != 'undefined' && list.list.length > 0)
						console.log('    ' + list.log.replace('[x]', list.list.length));
				}
			}
		}, onloadWait);
	}
	
	setTimeout(handleURLs.nextUrl, onloadWait);
};
