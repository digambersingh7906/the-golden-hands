<?php
include 'connect.php';

$name = $_POST['name'];
$email = $_POST['email'];
$role = $_POST['role'];

$sql = "INSERT INTO members (name, email, role) VALUES ('$name', '$email', '$role')";

if ($conn->query($sql) === TRUE) {
  echo "New member added successfully. <a href='../dashboard.html'>Go to Dashboard</a>";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
