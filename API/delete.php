<?php
include "DbConnect.php";

$conn = new DbConnect();
$db = $conn->connect();

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "DELETE") {
  $requestUri = $_SERVER['REQUEST_URI'];

  if (strpos($requestUri, '/delete.php') !== false) {
    $studentId = $_GET["id"] ?? null;

    if ($studentId !== null) {
        $sql = "UPDATE student SET is_deleted = 1 WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $studentId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
          http_response_code(200);
          $response = ["status" => 200, "message" => "Record deleted successfully."];
        } else {
          http_response_code(404);
          $response = ["status" => 404, "message" => "No record found for deletion."];
        }
    } else {
      http_response_code(400);
      $response = ["status" => 400, "message" => "Invalid or missing 'id' parameter."];
    }

    echo json_encode($response);
  } else {
    http_response_code(400);
    echo json_encode(["status" => 400, "message" => "Invalid endpoint for DELETE request"]);
  }
} else {
  http_response_code(405);
  echo json_encode(["status" => 405, "message" => "Unsupported method"]);
}
?>
