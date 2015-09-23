module.exports = {
    detectParty: detectParty
};

// Create function which tries to identify the party of a specific script
function detectParty(location) {
	checks = [
		{"value": location,		"regexp": "cts\.snmmd\.nl\/lib\/js\/advertising\.js", 					"party": "Adblock checker"},
		{"value": location,		"regexp": ".*" + window.location.hostname + ".*\/consent\.js", 			"party": "Consent manager"}
	];
	
	for (x in checks) {
		regexp = new RegExp(checks[x].regexp.toLowerCase());
		if (regexp.test(checks[x].value.toLowerCase()))
			return checks[x].party;
	}
	
	return "";
}