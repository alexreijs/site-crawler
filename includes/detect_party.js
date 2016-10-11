//['atinternet', 'ads', 'stats', 'functional', 'interests', 'stir', 'social', 'videoplaza'];

module.exports = {
    detectParty: detectParty
};

var rulesJs = require(fs.workingDirectory + '/includes/rules.js');
rules = rulesJs.rules;


// Create function which tries to identify the party of a specific cookie
function detectParty(rule_type, location, site, name) {

	for (x in rules) {
		rule = rules[x];

		if (rule.rule_type == rule_type) {

			if (rule.location_regexp.length == 0) {
				if (rule.operator == 1)			
					location_regexp = true;
				else if (rule.operator == 2)
					location_regexp = false;
			}
			else
				location_regexp = new RegExp(rule.location_regexp.toLowerCase()).test(site.toLowerCase())

			if (rule.name_regexp.length == 0) {
				if (rule.operator == 1)			
					name_regexp = true;
				else if (rule.operator == 2)
					name_regexp = false;
			}
			else
				name_regexp = new RegExp(rule.name_regexp.toLowerCase()).test(name.toLowerCase())

			if ((rule.operator == 1 && location_regexp && name_regexp) || (rule.operator == 2 && (location_regexp || name_regexp)))
				return {"party": rule.company_name, "type": rule.consent_type};
		}

	}

	if (new RegExp(site.toLowerCase()).test(location.host.toLowerCase()) || new RegExp(location.host.toLowerCase()).test(site.toLowerCase()))
		return {"party": "Site-owned", "type": ""}

	return {"party": "", "type": ""};

}


