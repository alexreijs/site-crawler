module.exports = {
    detectBanners: detectBanners
};

function detectBanners(page) {

	return page.evaluate(function() {

		String.prototype.hashCode = function() {
			var hash = 0, i, chr, len;
			if (this.length == 0) return hash;
			for (i = 0, len = this.length; i < len; i++) {
				chr   = this.charCodeAt(i);
				hash  = ((hash << 5) - hash) + chr;
				hash |= 0; // Convert to 32bit integer
			}
			return hash;
		};
		
		// Define a function that will recursively loop through parent nodes looking for other ads (in order to deduplicate nested banners)
		function findParentAd(el, tag) {
			while (el.parentNode) {
				el = el.parentNode;
				if (/^(cts_|VMspot_|google_ads_iframe)/.test(el.id))
					return el.id;
			}
			return null;
		}

		results = [];
		
		bannerSearches = [
			{
				"tagName": "div",
				"patterns": [{
						"pattern": "^cts_",
						"attribute": "id",
						"description": "CTS"
					},
					{
						"pattern": "^VMspot_",
						"attribute": "id",
						"description": "Improve Digital"
					},
					{
						"pattern": "^plista_widget_",
						"attribute": "id",
						"description": "Plista"
					},
					{
						"pattern": "spklw-widget",
						"attribute": "className",
						"description": "Sprinkle"
					},
					{
						"pattern": "^widget-kalooga-wrapper",
						"attribute": "className",
						"description": "Kalooga"
					},
					{
						"pattern": "^OUTBRAIN$",
						"attribute": "className",
						"description": "Outbrain"
					}
				]
			},
			{
				"tagName": "iframe",
				"patterns": [
					{
						"pattern": "^google_ads_iframe",
						"attribute": "id",
						"description": "Google Adsense"
					}
				]
			}
		];
		
		for (x in bannerSearches) {
			bannerSearch = bannerSearches[x];
			elements = document.getElementsByTagName(bannerSearch.tagName);
							
			for (z in elements) {
				element = elements[z];
									
				for (i in bannerSearch.patterns) {
					pattern = bannerSearch.patterns[i];
					attributeValue = element[pattern.attribute];
					
					if (typeof attributeValue != 'undefined') {
						regexp = new RegExp(pattern.pattern);

						if (regexp.test(attributeValue)) {
							clipRect = element.getBoundingClientRect();						
							results.push({
								"parent": findParentAd(element),
								"description": pattern.description,
								"id": element.id || (pattern.description + '|' +  clipRect.top + '|' + clipRect.left).hashCode(),
								"clipRect": {
									"top": clipRect.top,
									"left": clipRect.left,
									"width": clipRect.width,
									"height": clipRect.height
								}
							});	
						}
					}
				}
			}
		}
		
		return results;
	});
}