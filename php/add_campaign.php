
<?php
include 'connect.php';
$title = $_POST['title'];
$amount = $_POST['amount'];
$raised = $_POST['raised'];
$category = $_POST['category'];
$sql = "INSERT INTO campaigns (title, goal_amount, amount_raised, category) VALUES ('$title', '$amount', '$raised', '$category')";
if ($conn->query($sql) === TRUE) {
  echo "New campaign added.";
} else {
  echo "Error: " . $conn->error;
}
$conn->close();
?>
