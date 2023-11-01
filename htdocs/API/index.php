<?php 
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
  header("Access-Control-Allow-Headers: *");

  include "DbConnect.php";
  $conn = new DbConnect();
  $db = $conn->connect(); 

  $method = $_SERVER["REQUEST_METHOD"];

  switch ($method) {
    case "GET":
      $sql = "SELECT * FROM `student`";
      $path = explode("/", $_SERVER["REQUEST_URI"]);
      if (isset($path[3]) && is_numeric($path[3])) {
        $sql .= "WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $path[3]);
        $stmt->execute();
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
      } else {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $student = $stmt->fetchAll(PDO::FETCH_ASSOC);
      }
      echo json_encode($student);
      break;

    case "POST":
      $student = json_decode(file_get_contents("php://input"));
      $sql = "INSERT INTO student(id, student_id, name, email, course_code, created_at) VALUES(null, :student_id, :name, :email, :course_code, :created_at)";
      $stmt = $db->prepare($sql);
      $created_at = date("Y-m-d"); 

      $stmt->bindParam(":student_id", $student->student_id);
      $stmt->bindParam(":name", $student->name);
      $stmt->bindParam(":email", $student->email);
      $stmt->bindParam(":course_code", $student->course_code);
      $stmt->bindParam(":created_at", $created_at); 

      if ($stmt->execute()) {
        $response = ["status" => 1, "message" => "Record created successfully."];
      } else {
        $response = ["status" => 0, "message" => "Failed to create record."];
      }
      echo json_encode($student);
      break;

      case "PUT":
        $student = json_decode(file_get_contents("php://input"));
        $sql = "UPDATE student SET student_id = :student_id, name = :name, email = :email, course_code = :course_code, updated_at = :updated_at WHERE id = :id";
        $stmt = $db->prepare($sql);
        $updated_at = date("Y-m-d");  
  
        $stmt->bindParam(":id", $student->id);
        $stmt->bindParam(":student_id", $student->student_id);
        $stmt->bindParam(":name", $student->name);
        $stmt->bindParam(":email", $student->email);
        $stmt->bindParam(":course_code", $student->course_code);
        $stmt->bindParam(":updated_at", $updated_at); 
  
        if ($stmt->execute()) {
          $response = ["status" => 1, "message" => "Record updated successfully."];
        } else {
          $response = ["status" => 0, "message" => "Failed to update record."];
        }
        echo json_encode($student);
        break;

      case "DELETE": 
        $sql = "DELETE FROM `student` WHERE id = :id";
        $path = explode("/", $_SERVER["REQUEST_URI"]);
        if (isset($path[3]) && is_numeric($path[3])) {
          $stmt = $db->prepare($sql);
          $stmt->bindParam(":id", $path[3]);
          $stmt->execute();
        };

        if ($stmt->execute()) {
          $response = ["status" => 1, "message" => "Record deleted successfully."];
        } else {
          $response = ["status" => 0, "message" => "Failed to delete record."];
        }
        echo json_encode($student);
        break;
  }
