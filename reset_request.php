<?php
$enroll = $_POST['enroll'];
$email = $_POST['email'];
$contact = $_POST['contact'];

$conn = new mysqli("localhost", "root", "", "ngo");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM registrations WHERE enrollment=? AND email=? AND contact=?");
$stmt->bind_param("sss", $enroll, $email, $contact);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $token = bin2hex(random_bytes(16));  // 32-char token
    $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

    // Store token in a new table
    $conn->query("CREATE TABLE IF NOT EXISTS password_resets (
        id INT AUTO_INCREMENT PRIMARY KEY,
        enrollment VARCHAR(20),
        token VARCHAR(100),
        expires_at DATETIME
    )");

    $stmt = $conn->prepare("INSERT INTO password_resets (enrollment, token, expires_at) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $enroll, $token, $expiry);
    $stmt->execute();

    $link = "http://localhost/reset_password.php?token=$token";

    // Send email
    $subject = "Reset Your Password - The Golden Hands Trust";
    $message = "Hello,\n\nClick the link below to reset your password:\n$link\n\nThis link is valid for 1 hour.\n\n- The Golden Hands Team";
    $headers = "From: admin@goldenhands.org";

    mail($email, $subject, $message, $headers);

    header("Location: forgot_password.php?msg=Reset link sent to your email.");
} else {
    header("Location: forgot_password.php?msg=No matching record found.");
}
$conn->close();
?>
