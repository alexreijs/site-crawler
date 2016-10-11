<?php


header("Content-Type: application/json");


include "../models/ConsentTypeRepository.php";


$config = include("../db/config.php");



$db = new PDO($config["db"], $config["username"], $config["password"]);


$consentTypes = new ConsentTypeRepository($db);


switch($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        $result = $consentTypes->getAll(array(
            "type" => $_GET["type"],
            "id" => intval($_GET["id"])
        ));
        break;
    case "POST":
        $result = $consentTypes->insert(array(
            "type" => $_POST["type"]
        ));
        break;
    case "PUT":
        parse_str(file_get_contents("php://input"), $_PUT);
        $result = $consentTypes->update(array(
            "id" => intval($_PUT["id"]),
            "type" => $_PUT["type"]
        ));
        break;
    case "DELETE":
        parse_str(file_get_contents("php://input"), $_DELETE);
        $result = $consentTypes->remove(intval($_DELETE["id"]));
        break;
}
echo json_encode($result);


?>
