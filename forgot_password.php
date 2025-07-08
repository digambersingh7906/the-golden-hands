<?php
session_start();
$host = "localhost";
$username = "root";
$password = "";
$dbname = "ngo";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $enroll = $_POST['enroll'] ?? '';
    $email = $_POST['email'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $new_password = $_POST['new_password'] ?? '';

    if (empty($enroll) || empty($email) || empty($contact) || empty($new_password)) {
        $error = "All fields are required.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM registrations WHERE enrollment = ? AND email = ? AND contact = ?");
        $stmt->bind_param("sss", $enroll, $email, $contact);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->close();
            $hash = password_hash($new_password, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE registrations SET password = ? WHERE enrollment = ?");
            $update->bind_param("ss", $hash, $enroll);
            if ($update->execute()) {
                $success = "✅ Password updated successfully!";
            } else {
                $error = "❌ Failed to update password.";
            }
            $update->close();
        } else {
            $error = "❌ No matching user found.";
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password - The Golden Hands</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to bottom, #1f1f1f, #121212);
      color: #fff;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 420px;
      margin: 80px auto;
      background: #1e1e1e;
      padding: 35px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.6);
    }

    h2 {
      text-align: center;
      color: #00d1b2;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: 600;
    }

    input {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 5px;
      background-color: #333;
      color: #fff;
      margin-top: 5px;
    }

    input:focus {
      outline: none;
      background-color: #444;
      border: 1px solid #1abc9c;
    }

    button {
      width: 100%;
      margin-top: 25px;
      padding: 12px;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      background-color: #00d1b2;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }

    button:hover {
      background-color: #16a085;
    }

    .success {
      color: #2ecc71;
      text-align: center;
      margin-top: 15px;
    }

    .error {
      color: #e74c3c;
      text-align: center;
      margin-top: 15px;
    }

    .back-link {
      display: block;
      text-align: center;
      margin-top: 20px;
      text-decoration: none;
      color: #00d1b2;
    }

    footer {
      text-align: center;
      padding: 15px;
      color: #ccc;
      font-size: 13px;
      background: #222;
      margin-top: 60px;
    }

    @media screen and (max-width: 480px) {
      .container {
        margin: 40px 15px;
        padding: 25px;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Reset Your Password</h2>
    <form method="POST">
      <label for="enroll">Enrollment No.</label>
      <input type="text" name="enroll" id="enroll" required>

      <label for="email">Email</label>
      <input type="email" name="email" id="email" required>

      <label for="contact">Contact Number</label>
      <input type="text" name="contact" id="contact" required>

      <label for="new_password">New Password</label>
      <input type="password" name="new_password" id="new_password" required>

      <button type="submit">Update Password</button>

      <?php if (!empty($success)): ?>
        <p class="success"><?= htmlspecialchars($success) ?></p>
      <?php endif; ?>

      <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>
    </form>

    <a class="back-link" href="login.html">🔙 Back to Login</a>
  </div>

  <footer>
    &copy; 2025 The Golden Hands Charitable Trust. All rights reserved.
  </footer>

</body>
</html>
