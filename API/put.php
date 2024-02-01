<?php
include "DbConnect.php";

$conn = new DbConnect();
$db = $conn->connect();

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "PUT") {
  $requestUri = $_SERVER['REQUEST_URI'];

  if (strpos($requestUri, '/put.php') != false) {
    $studentId = $_GET["id"] ?? null;
    $student = json_decode(file_get_contents("php://input"));

    if (empty($student->student_id) || empty($student->fname) || empty($student->lname) || empty($student->email) || empty($student->course_code)) {
      http_response_code(400);
      $response = ["status" => 400, "message" => "Required fields cannot be null."];
      echo json_encode($response);
      exit;
    } else if ($studentId === null) {
      http_response_code(400);
      $response = ["status" => 400, "message" => "ID parameter is missing or empty."];
      echo json_encode($response);
      exit;
    }

    $sql = "UPDATE student SET student_id = :student_id, fname = :fname, lname = :lname, email = :email, course_code = :course_code WHERE id = :id";
    $stmt = $db->prepare($sql);

    $stmt->bindParam(":student_id", $student->student_id);
    $stmt->bindParam(":fname", $student->fname);
    $stmt->bindParam(":lname", $student->lname);
    $stmt->bindParam(":email", $student->email);
    $stmt->bindParam(":course_code", $student->course_code);
    $stmt->bindParam(":id", $studentId);

    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
          http_response_code(200);
          $response = ["status" => 200, "message" => "Record updated successfully."];
        } else {
          http_response_code(404);
          $response = ["status" => 404, "message" => "Record with the provided ID not found."];
        }
    } else {
      http_response_code(500);
      $response = ["status" => 500, "message" => "Failed to update record."];
    }

    echo json_encode($response);
  } else {
      http_response_code(400);
      echo json_encode(["status" => 400, "message" => "Invalid endpoint for PUT request"]);
  }
} else {
    http_response_code(405);
    echo json_encode(["status" => 405, "message" => "Unsupported method"]);
}
?>
