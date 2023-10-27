<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data</title>

  <link rel="stylesheet" href="style.css">
</head>

<body>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>NAME</th>
        <th>EMAIL</th>
      </tr>
    </thead>
    <tbody>

      <?php

      $host = "localhost";
      $username = "root";
      $password = "";
      $database = "students";

      $conn = new mysqli($host, $username, $password, $database);


      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $query = "SELECT * FROM users";
      $result = $conn->query($query);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

          echo "<tr>";
          echo "<td>" . $row["id"] . "</td>";
          echo "<td>" . $row["name"] . "</td>";
          echo "<td>" . $row["email"] . "</td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='3'>0 results</td></tr>";
      }

      $conn->close();
      ?>
        </tbody>
  </table>

</body>

</html>
