<?php


header("Content-Type: application/json");

include "../models/CompanyRepository.php";
$config = include("../db/config.php");



$db = new PDO($config["db"], $config["username"], $config["password"]);


$companies = new CompanyRepository($db);


switch($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        $result = $companies->getAll(array(
            "name" => $_GET["name"],
            "id" => intval($_GET["id"])
        ));
        break;
    case "POST":
        $result = $companies->insert(array(
            "name" => $_POST["name"]
        ));
        break;
    case "PUT":
        parse_str(file_get_contents("php://input"), $_PUT);
        $result = $companies->update(array(
            "id" => intval($_PUT["id"]),
            "name" => $_PUT["name"]
        ));
        break;
    case "DELETE":
        parse_str(file_get_contents("php://input"), $_DELETE);
        $result = $companies->remove(intval($_DELETE["id"]));
        break;
}
echo json_encode($result);


?>
