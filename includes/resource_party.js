module.exports = {
    detectParty: detectParty
};

// Create function which tries to identify the party of a specific script
function detectParty(location) {
	checks = [
		{"value": location,		"regexp": "cts\.snmmd\.nl\/lib\/js\/advertising\.js", 					"party": "Adblock checker"},			//"type": "ads"},
		{"value": location, 	"regexp": "googleadservices.com/pagead/conversion.js",					"party": "Google Adwords"}, 			//"type": "ads"},
		{"value": location, 	"regexp": "hotjar.com",													"party": "Hotjar"}, 					//"type": "stats"},
		{"value": location, 	"regexp": "adform.net",													"party": "Adform"}, 					//"type": "ads"},
		{"value": location, 	"regexp": "ytimg.com",													"party": "Youtube"}, 					//"type": "social"},
		{"value": location, 	"regexp": "youtube.com",												"party": "Youtube"}, 					//"type": "social"},
		{"value": location, 	"regexp": "visualwebsiteoptimizer.com",									"party": "Visual Website Optimizer"}, 	//"type": "stats"},
		{"value": location, 	"regexp": "connect.facebook.net",										"party": "Facebook Connect"}, 			//"type": "interests"},
		{"value": location, 	"regexp": "sprinkle",													"party": "Sprinkle"}, 					//"type": "ads"},
		{"value": location, 	"regexp": "twitter.com",												"party": "Twitter"}, 					//"type": "social"},
		{"value": location, 	"regexp": "blendle.com",												"party": "Blendle"}, 					//"type": "interests"},
		{"value": location, 	"regexp": "instagram.com",												"party": "Instragram"}, 				//"type": "social"},
		{"value": location,		"regexp": ".*" + window.location.hostname + ".*\/consent\.js", 			"party": "Consent manager"}				//"type": "functional"}
	];
	
	for (x in checks) {
		regexp = new RegExp(checks[x].regexp.toLowerCase());
		if (regexp.test(checks[x].value.toLowerCase()))
			return checks[x].party;
	}
	
	return "";
}
