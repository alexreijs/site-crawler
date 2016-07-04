<?php

require_once(dirname(__FILE__) . '/../../includes/config.php');

$rules = $database->query("

	select

	r.name as name_regexp,
	r.location as location_regexp,
	r.operator,
	r.type as rule_type,
	c.name as company_name,
	ct.type as consent_type

	from rules r

	left outer join consent_types ct on ct.id = r.consent_type_id
	left outer join companies c on c.id = r.company_id

	order by r.priority

")->fetchAll(PDO::FETCH_ASSOC);


$rulesString = "
module.exports = {
        rules: [";


foreach ($rules as $rId => $rule) {
	$rulesString .= "		" . json_encode($rule);

	if ($rId < count($rules) - 1)
		$rulesString .= ",";

	$rulesString .= "\n";

}

$rulesString .= "
        ]
};
";


$rulesFile = dirname(__FILE__) . '/../../../includes/rules.js';

$myfile = fopen($rulesFile, "w") or die("Unable to open file!");
fwrite($myfile, $rulesString);
fclose($myfile);


?>
