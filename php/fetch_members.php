<?php
include 'connect.php';

$sql = "SELECT * FROM members";
$result = $conn->query($sql);
$data = [];

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
}
echo json_encode($data);
$conn->close();
?>
