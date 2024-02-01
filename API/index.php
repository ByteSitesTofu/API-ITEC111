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
    header("405 Method Not Allowed");
    header("Allow: " . implode(", ", $allowedMethods));
    exit;
}

switch ($method) {
    case "GET":
        // Read operation
        $id = $_GET["id"] ?? null;
        $student_id = $_GET['student_id'] ?? null;
        $fname = $_GET["fname"] ?? null;
        $lname = $_GET["lname"] ?? null;
        $email = $_GET["email"] ?? null;
        $course_code = $_GET["course_code"] ?? null;
        $is_deleted = $_GET["is_deleted"] ?? null;

        $student = [];

        if($id !== null) {
            $sql = "SELECT * FROM student WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif ($student_id !== null) {
            $sql = "SELECT * FROM student WHERE student_id = :student_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":student_id", $student_id);
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }elseif ($fname !== null) {
            $sql = "SELECT * FROM student WHERE fname = :fname";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":fname", $fname);
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif ($lname !== null) {
            $sql = "SELECT * FROM student WHERE lname = :lname";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":lname", $lname);
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif ($email !== null) {
            $sql = "SELECT * FROM student WHERE email = :email";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif ($course_code !== null) {
            $sql = "SELECT * FROM student WHERE course_code = :course_code";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":course_code", $course_code);
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif ($is_deleted !== null) {
            $sql = "SELECT * FROM student WHERE is_deleted = :is_deleted";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":is_deleted", $is_deleted);
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else {
            $sql = "SELECT * FROM student";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode($students);
        break;

    case "POST":
        // Create operation
            $student = json_decode(file_get_contents("php://input"));

            if (empty($student->student_id) || empty($student->fname) || empty($student->lname) || empty($student->email) || empty($student->course_code)) {
                http_response_code(400);
                $response = ["message" => "Required fields cannot be null."];
                echo json_encode($response);
                break;
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
                $response = [ "message" => "Record created successfully."];
            } else {
                http_response_code(500);
                $response = [ "message" => "Failed to create record."];
            }
        echo json_encode($response);
        break;

    case "PUT":
        // Update operation
        $studentId= $_GET["id"] ?? null;
        if ($studentId !== null) {
            $student = json_decode(file_get_contents("php://input"));
            $sql = "UPDATE student SET student_id = :student_id, fname = :fname, lname = :lname, email = :email, course_code = :course_code WHERE id = :id";
            $stmt = $db->prepare($sql);
    
            $stmt->bindParam(":student_id", $student->student_id);
            $stmt->bindParam(":fname", $student->fname);
            $stmt->bindParam(":lname", $student->lname);
            $stmt->bindParam(":email", $student->email);
            $stmt->bindParam(":course_code", $student->course_code);
            $stmt->bindParam(":id", $studentId);
    
            if ($stmt->execute()) {
                $response = [ "message" => "Record updated successfully."];
            } else {
                $response = [ "message" => "Failed to update record."];
            }
        } else {
            $response = [ "message" => "Failed to update record."];
        }
        echo json_encode($response);
        break;

    case "DELETE":
        // Delete operation
        $studentId = $_GET["id"] ?? null;
        if ($studentId !== null) {
            $sql = "UPDATE student SET is_deleted = 1 WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":id", $studentId);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $response = [ "message" => "Record deleted successfully."];
            } else {
                $response = [ "message" => "No record found for deletion."];
            }
        } else {
            $response = ["message" => "Invalid or missing 'id' parameter."];
        }
        echo json_encode($response);
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Unsupported method"]);
        break;
}
?>
