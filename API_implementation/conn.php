<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; Charset=UTF-8");

  if ($_SERVER['REQUEST_METHOD'] !== "GET"){
    http_response_code(405);
    echo json_encode(array("error" => "Only GET request are allowed"));
    exit;
  }

  $host = "localhost";
  $username = "root";
  $password = "";
  $database = "students";

  $conn = new mysqli($host, $username, $password, $database);

  if ($conn -> connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

$query = "SELECT * FROM users";
$result = $conn->query($query);

if ($result->num_rows > 0) {
  $users = array();

  while ($row = $result->fetch_assoc()) {
    $users[] = $row;
  }

  http_response_code(200);
  echo json_encode($users);
} else {
  http_response_code(200);
  echo json_encode(array());
}

$conn->close()
?>