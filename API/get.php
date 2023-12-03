<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

class DbConnect {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "lms";

    public function connect() {
        try {
            $conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}

$conn = (new DbConnect())->connect();

$method = $_SERVER["REQUEST_METHOD"];
$path = explode("/", $_SERVER["REQUEST_URI"]);

switch ($method) {
    case "GET":
        if (isset($path[3]) && is_numeric($path[3])) {
            // Retrieve a specific record
            $stmt = $conn->prepare("SELECT * FROM `student` WHERE id = :id");
            $stmt->bindParam(":id", $path[3]);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            // Retrieve all records
            $stmt = $conn->query("SELECT * FROM `student`");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode($data);
        break;

    case "POST":
        // Create a new record
        $input = json_decode(file_get_contents("php://input"), true);
        $stmt = $conn->prepare("INSERT INTO student(id, student_id, name, email, course_code, is_deleted, created_at) VALUES(null, :student_id, :name, :email, :course_code, :is_deleted, :created_at)");
        $created_at = date("Y-m-d");

        $stmt->bindParam(":student_id", $input['student_id']);
        $stmt->bindParam(":name", $input['name']);
        $stmt->bindParam(":email", $input['email']);
        $stmt->bindParam(":course_code", $input['course_code']);
        $stmt->bindParam(":created_at", $input[$created_at]);
        if ($stmt->execute()) {
            echo json_encode(["status" => 1, "message" => "Record created successfully."]);
        } else {
            echo json_encode(["status" => 0, "message" => "Failed to create record."]);
        }
        break;

    case "PUT":
        // Update an existing record
        $input = json_decode(file_get_contents("php://input"), true);
        $stmt = $conn->prepare("UPDATE `student` SET column1 = :value1, column2 = :value2, column3 = :value3 WHERE id = :id");
        $stmt->bindParam(":id", $input['id']);
        $stmt->bindParam(":value1", $input['value1']);
        $stmt->bindParam(":value2", $input['value2']);
        $stmt->bindParam(":value3", $input['value3']);
        if ($stmt->execute()) {
            echo json_encode(["status" => 1, "message" => "Record updated successfully."]);
        } else {
            echo json_encode(["status" => 0, "message" => "Failed to update record."]);
        }
        break;

    case "DELETE":
        // Delete a record
        if (isset($path[3]) && is_numeric($path[3])) {
            $stmt = $conn->prepare("DELETE FROM `student` WHERE id = :id");
            $stmt->bindParam(":id", $path[3]);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                echo json_encode(["status" => 1, "message" => "Record deleted successfully."]);
            } else {
                echo json_encode(["status" => 0, "message" => "Record not found."]);
            }
        } else {
            echo json_encode(["status" => 0, "message" => "Invalid request."]);
        }
        break;

    default:
        echo json_encode(["status" => 0, "message" => "Invalid request method."]);
        break;
}
?>
