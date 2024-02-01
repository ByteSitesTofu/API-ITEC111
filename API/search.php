<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");
include "DbConnect.php";
$conn = new DbConnect();
$db = $conn->connect();

$method = $_SERVER['REQUEST_METHOD'];

if ($method === "GET") {
    $requestUri = $_SERVER['REQUEST_URI'];

    if (strpos($requestUri, '/search.php') !== false) {
        $param = $_GET["search"] ?? null;

        $param = "%$param%";
        $sql = "SELECT * FROM student WHERE fname LIKE :param OR lname LIKE :param OR course_code LIKE :param";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":param", $param);
        $stmt->execute();
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($students)) {
            http_response_code(404);
            echo json_encode(["status" => 404, "message" => "Not found"]);
        } else {
            echo json_encode($students);
        }
    } else {
        http_response_code(400);
        echo json_encode(["status" => 400, "message" => "Invalid GET endpoint"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["status" => 405, "message" => "Unsupported method"]);
}
?>
