<?php
include "DbConnect.php";

$conn = new DbConnect();
$db = $conn->connect();

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "POST") {
  $requestUri = $_SERVER['REQUEST_URI'];

  if (strpos($requestUri, '/post.php') !== false) {
    $student = json_decode(file_get_contents("php://input"));

    if (empty($student->student_id) || empty($student->fname) || empty($student->lname) || empty($student->email) || empty($student->course_code)) {
      http_response_code(400);
      $response = ["status" => 400, "message" => "Required fields cannot be null."];
      echo json_encode($response);
      exit;
    }

    $sql = "INSERT INTO student(student_id, fname, lname, email, course_code) VALUES(:student_id, :fname, :lname, :email, :course_code)";
    $stmt = $db->prepare($sql);

    $stmt->bindParam(":student_id", $student->student_id);
    $stmt->bindParam(":fname", $student->fname);
    $stmt->bindParam(":lname", $student->lname);
    $stmt->bindParam(":email", $student->email);
    $stmt->bindParam(":course_code", $student->course_code);

    if ($stmt->execute()) {
      http_response_code(201);
      $response = ["status" => 201, "message" => "Record created successfully."];
    } else {
      http_response_code(406);
      $response = ["message" => "Failed to create record."];
    }

    echo json_encode($response);
  } else {
    http_response_code(400);
    echo json_encode(["status" => 400, "message" => "Invalid endpoint for POST request"]);
  }
} else {
    http_response_code(405);
    echo json_encode(["status" => 405, "message" => "Unsupported method"]);
}
?>
