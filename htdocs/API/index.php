<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

include "DbConnect.php";
$conn = new DbConnect();
$db = $conn->connect();

$allowedMethods = ["GET", "POST", "PUT", "DELETE"];
$method = $_SERVER["REQUEST_METHOD"];

if (!in_array($method, $allowedMethods)) {
    header("HTTP/1.1 405 Method Not Allowed");
    header("Allow: " . implode(", ", $allowedMethods));
    exit;
}

switch ($method) {
    case "GET":
        // Read operation
        $sql = "SELECT * FROM student";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($students);
        break;

    case "POST":
        // Create operation
        $student = json_decode(file_get_contents("php://input"));
        $sql = "INSERT INTO student(student_id, name, email, course_code) VALUES(:student_id, :name, :email, :course_code)";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(":student_id", $student->student_id);
        $stmt->bindParam(":name", $student->name);
        $stmt->bindParam(":email", $student->email);
        $stmt->bindParam(":course_code", $student->course_code);

        if ($stmt->execute()) {
            $response = ["status" => 1, "message" => "Record created successfully."];
        } else {
            $response = ["status" => 0, "message" => "Failed to create record."];
        }
        echo json_encode($response);
        break;

    case "PUT":
        // Update operation
        $student = json_decode(file_get_contents("php://input"));
        $sql = "UPDATE student SET name = :name, email = :email, course_code = :course_code WHERE id = :id";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(":id", $student->id);
        $stmt->bindParam(":name", $student->name);
        $stmt->bindParam(":email", $student->email);
        $stmt->bindParam(":course_code", $student->course_code);

        if ($stmt->execute()) {
            $response = ["status" => 1, "message" => "Record updated successfully."];
        } else {
            $response = ["status" => 0, "message" => "Failed to update record."];
        }
        echo json_encode($response);
        break;

    case "DELETE":
        // Delete operation
        $studentId = $_GET["id"] ?? null;
        if ($studentId !== null) {
            $sql = "DELETE FROM student WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":id", $studentId);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $response = ["status" => 1, "message" => "Record deleted successfully."];
            } else {
                $response = ["status" => 0, "message" => "No record found for deletion."];
            }
        } else {
            $response = ["status" => 0, "message" => "Invalid or missing 'id' parameter."];
        }
        echo json_encode($response);
        break;

    default:
        http_response_code(404);
        echo json_encode(["status" => 0, "message" => "Unsupported method"]);
        break;
}
?>
