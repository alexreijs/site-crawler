<?php


header("Content-Type: application/json");

include "../models/RuleRepository.php";
$config = include("../db/config.php");



$db = new PDO($config["db"], $config["username"], $config["password"]);


$rules = new RuleRepository($db);


switch($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        $result = $rules->getAll(array(
            "type" => intval($_GET["type"]),
            "priority" => intval($_GET["priority"]),
            "location" => $_GET["location"],
            "value" => $_GET["value"],
            "company_id" => intval($_GET["company_id"]),
            "consent_type_id" => intval($_GET["consent_type_id"]),
            "operator" => intval($_GET["operator"]),
            "id" => intval($_GET["id"])
        ));
        break;
    case "POST":
        $result = $rules->insert(array(
            "type" => intval($_POST["type"]),
            "priority" => intval($_POST["priority"]),
            "location" => $_POST["location"],
            "value" => $_POST["value"],
            "company_id" => intval($_POST["company_id"]),
            "consent_type_id" => intval($_POST["consent_type_id"]),
            "operator" => $_POST["operator"],
            "id" => intval($_POST["id"])
        ));
        break;
    case "PUT":
        parse_str(file_get_contents("php://input"), $_PUT);
        $result = $rules->update(array(
            "type" => intval($_PUT["type"]),
            "priority" => intval($_PUT["priority"]),
            "location" => $_PUT["location"],
            "value" => $_PUT["value"],
            "company_id" => intval($_PUT["company_id"]),
            "consent_type_id" => intval($_PUT["consent_type_id"]),
            "operator" => intval($_PUT["operator"]),
            "id" => intval($_PUT["id"])
        ));
        break;
    case "DELETE":
        parse_str(file_get_contents("php://input"), $_DELETE);
        $result = $rules->remove(intval($_DELETE["id"]));
        break;
}
echo json_encode($result);


?>
