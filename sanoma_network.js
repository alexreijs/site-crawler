var page = require('webpage').create(),
    url = 'http://privacy.nu.nl';

	
	
page.onAlert = function(msg) {
  console.log('ALERT: ' + msg);
};
	
page.open(url, function (status) {
    if (status !== 'success') {
        console.log('Unable to access network');
    } else {
        
		var results = page.evaluate(function() {
		
			results = {"urls":[], "imgs":[]};
			list_of_pages = document.getElementsByClassName('settings-sidebar-sites')[0];
			list_elements = list_of_pages.getElementsByTagName("li");
		
            for (var i = 0; i < list_elements.length; i++){
	
				list_element = list_elements[i];
				list_element_image = list_element.getElementsByTagName("img")[0];
				list_element_anchor = list_element.getElementsByTagName("a")[0];
				
				site = list_element_anchor.innerHTML.toLowerCase();
				url = 'http://www.' + site;
				img = list_element_image.attributes[2].value;
					
				results['urls'].push(url);
				results['imgs'].push(img);
            }
			
			return results;
		
        });

		console.log(JSON.stringify(results));
		var fs = require('fs');
		fs.write('sanoma_network.txt', JSON.stringify(results), 'w');
    }
    phantom.exit();
});