<link type="text/css" rel="stylesheet" href="./css/jsgrid.min.css" />
<link type="text/css" rel="stylesheet" href="./css/jsgrid-theme.min.css" />

<script type="text/javascript" src="./js/jsgrid.min.js"></script>





<div class="container">

	<div class="row">
		&nbsp;
	</div>

	<div class="row">


		<div class="col-md-6">
			<div id="companiesGrid" style="left:100px;"></div>
		</div>

		<div class="col-md-6">
			<div id="consentTypesGrid" style="float:right; right:100px;"></div>
		</div>

	</div>


	<div class="row">
		&nbsp;
	</div>

	<div class="row">


		<div class="col-md-12">

			<div id="rulesCookieGrid"></div>

		</div>

	</div>

</div>



<script>

	var priorities = [
	<?php

	for ($i = 0; $i <= 100; $i++) {
		echo '{ id : ' . $i . ', priority : ' . ($i == 0 ? '""' : $i) . '}';
		if ($i < 100)
			echo ",";
		echo "\n";
	}

	?>
	];

	var consentTypes = [
		{id : 0, type : ""},
	<?php

	$consentTypes = $database->select('consent_types', '*', ['ORDER' => 'type']);
	foreach ($consentTypes as $i => $consentType) {
		echo '{ id : ' . $consentType['id'] . ', type : "' . $consentType['type'] . '"}';
		if ($i < count($consentTypes) - 1)
			echo ",";
		echo "\n";
	}

	?>
	];



	var companies = [
		{id : 0, "name": ""},
	<?php

	$companies = $database->select('companies', '*', ['ORDER' => 'name']);
	foreach ($companies as $i => $company) {
		echo '{ id : ' . $company['id'] . ', name : "' . $company['name'] . '"}';
		if ($i < count($companies) - 1)
			echo ",";
		echo "\n";
	}

	?>
	];



	var database = {};
	database.companies = {
		loadData: function(filter) {
			return $.ajax({
				type: "GET",
				url: "./jsgrid-api/companies/",
				data: filter
			});
		},
		insertItem: function(item) {
			checkItem = $.ajax({
				type: "GET",
				url: "./jsgrid-api/companies/",
				data: {id : "", name : item.name, match_equal : true}
			}).done(function (obj) {
			        console.log(obj);
				if (obj.length > 0) {
					alert('Duplicate entry found');
					return false;
				}
				else {
					return $.ajax({
						type: "POST",
						url: "./jsgrid-api/companies/",
						data: item
					});
				}
			});
		},
		updateItem: function(item) {
			return $.ajax({
				type: "PUT",
				url: "./jsgrid-api/companies/",
				data: item
			});
		},
		deleteItem: function(item) {
			return $.ajax({
				type: "DELETE",
				url: "./jsgrid-api/companies/",
				data: item
			});
		}
	};

	database.consentTypes = {
		loadData: function(filter) {
			return $.ajax({
				type: "GET",
				url: "./jsgrid-api/consentTypes/",
				data: filter
			});
		},
		insertItem: function(item) {
			checkItem = $.ajax({
				type: "GET",
				url: "./jsgrid-api/consentTypes/",
				data: {id : "", type : item.type, match_equal : true}
			}).done(function (obj) {
			        console.log(obj);
				if (obj.length > 0) {
					alert('Duplicate entry found');
					return false;
				}
				else {
					return $.ajax({
						type: "POST",
						url: "./jsgrid-api/consentTypes/",
						data: item
					});
				}
			});
		},
		updateItem: function(item) {
			return $.ajax({
				type: "PUT",
				url: "./jsgrid-api/consentTypes/",
				data: item
			});
		},
		deleteItem: function(item) {
			return $.ajax({
				type: "DELETE",
				url: "./jsgrid-api/consentTypes/",
				data: item
			});
		}
	};

	database.rulesCookie = {
		loadData: function(filter) {
			getting = $.ajax({
				type: "GET",
				url: "./jsgrid-api/rules/",
				data: filter
			});
			console.log(filter);
			console.log(getting);
			return getting;
		},
		insertItem: function(item) {
			inserting = $.ajax({
				type: "POST",
				url: "./jsgrid-api/rules/",
				data: item
			});
			console.log(inserting);
			return inserting;
		},
		updateItem: function(item) {
			updating = $.ajax({
				type: "PUT",
				url: "./jsgrid-api/rules/",
				data: item
			});
			console.log(updating);
			return updating;
		},
		deleteItem: function(item) {
			return $.ajax({
				type: "DELETE",
				url: "./jsgrid-api/rules/",
				data: item
			});
		}
	};

    $("#companiesGrid").jsGrid({
        width: "400px",
        height: "300px",

        inserting: true,
        editing: true,
        sorting: true,
        paging: true,
	filtering: true,
	pageSize: 25,
	autoload: true,

	deleteConfirm: "Do you really want to delete company?",
	controller: database.companies,

        fields: [
		{ name: "name", title : "Company name", type: "text", width: 150, validate: "required" },
		{ type : "control"}
        ]
    });

    $("#consentTypesGrid").jsGrid({
        width: "400px",
        height: "300px",

        inserting: true,
        editing: true,
        sorting: true,
        paging: true,
	filtering: true,
	pageSize: 10,
	autoload: true,

	deleteConfirm: "Do you really want to delete consent type?",
	controller: database.consentTypes,

        fields: [
		{ name: "type", title : "Consent type", type: "text", width: 150, validate: "required" },
		{ type : "control"}
        ]
    });

    $("#rulesCookieGrid").jsGrid({
        width: "100%",
        height: "600px",

        inserting: true,
        editing: true,
        sorting: true,
        paging: true,
	filtering: true,
	pageSize: 25,
	autoload: true,

	deleteConfirm: "Do you really want to delete rule?",

	controller: database.rulesCookie,

        fields: [
		{ name: "type", title : "Rule type", type: "select", width: "75px", items: [{id : 0, operator : ""}, {id : 1, operator :"Cookie"}, {id : 2, operator : "Resource"}], valueField: "id", textField: "operator", validate: function(value, item) {return value != 0; }},
		{ name: "priority", title : "Priority", width: "50px", type: "select", items: priorities, valueField: "id", textField: "priority", validate: function(value, item) {return value != 0;}},
		{ name: "location", title : "Location RegExp", type: "text"},
		{ name: "name", title : "Name RegExp", type: "text"},
		{ name: "operator", title : "Operator", type: "select", width: "50px", items: [{id : 0, operator : ""}, {id : 1, operator :" AND"}, {id : 2, operator : "OR"}], valueField: "id", textField: "operator", validate: function(value, item) {return value != 0; }},
		{ name: "company_id", title : "Company", type: "select", items: companies, valueField: "id", textField: "name", validate: function(value, item) {return value != 0;}},
		{ name: "consent_type_id", title : "Consent type", width: "75px", type: "select", items: consentTypes, valueField: "id", textField: "type", validate: function(value, item) {return value != 0;}},
		{ type : "control"}
        ]
    });

</script>
