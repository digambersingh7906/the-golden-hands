<?php
$conn = new mysqli("localhost", "root", "", "ngo");
if ($conn->connect_error) die("Connection failed.");

$token = $_GET['token'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT enrollment FROM password_resets WHERE token=? AND expires_at > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $enroll = $res->fetch_assoc()['enrollment'];
        $update = $conn->prepare("UPDATE registrations SET password=? WHERE enrollment=?");
        $update->bind_param("ss", $password, $enroll);
        $update->execute();

        // Delete the token
        $conn->query("DELETE FROM password_resets WHERE token='$token'");

        echo "<script>alert('Password updated successfully. Please login.'); window.location='login.html';</script>";
    } else {
        echo "<script>alert('Invalid or expired token.'); window.location='forgot_password.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Reset Password</title>
</head>
<body>
  <form method="POST">
    <h2>New Password</h2>
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
    <input type="password" name="password" placeholder="New Password" required>
    <button type="submit">Update Password</button>
  </form>
</body>
</html>
