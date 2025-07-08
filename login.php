<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "ngo");
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "DB Connection Failed"]);
    exit;
}

// Generate CAPTCHA if requested
if (isset($_GET['getCaptcha'])) {
    $chars = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
    $_SESSION['captcha'] = substr(str_shuffle($chars), 0, 6);
    echo $_SESSION['captcha'];
    exit;
}

// Handle form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $enroll = $_POST['enroll'] ?? '';
    $password = $_POST['password'] ?? '';
    $userCaptcha = strtoupper(trim($_POST['user_captcha'] ?? ''));
    $storedCaptcha = $_SESSION['captcha'] ?? '';

    if ($userCaptcha !== $storedCaptcha) {
        echo json_encode(["success" => false, "error" => "Invalid CAPTCHA"]);
        exit;
    }

    $stmt = $conn->prepare("SELECT password FROM registrations WHERE enrollment = ?");
    $stmt->bind_param("s", $enroll);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($hash);
        $stmt->fetch();
        if (password_verify($password, $hash)) {
            $_SESSION['enroll'] = $enroll;
            echo json_encode(["success" => true]);
            exit;
        } else {
            echo json_encode(["success" => false, "error" => "Incorrect password"]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "Enrollment not found"]);
    }

    $stmt->close();
}
$conn->close();
