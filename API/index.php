<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

$method = $_SERVER["REQUEST_METHOD"];

switch ($method) {
    case "GET":
        include "search.php";
        break;

    case "POST":
        include "post.php";
        break;

    case "PUT":
        include "put.php";
        break;

    case "DELETE":
        include "delete.php";
        break;

    default:
        http_response_code(200);
        $response = ["status" => 200, "message" => "Welcome to your API. Please specify a valid endpoint."];
        echo json_encode($response);
        exit;
}
?>
