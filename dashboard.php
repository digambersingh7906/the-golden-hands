<?php
session_start();
if (!isset($_SESSION['enroll'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard - The Golden Hands</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    body {
      margin: 0;
      background: #121212;
      color: #f1f1f1;
      font-family: 'Segoe UI', sans-serif;
    }

    .top-bar {
      background: #1f1f1f;
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      box-shadow: 0 0 10px #000;
    }

    .top-bar h1 {
      font-size: 20px;
      color: #00d1b2;
      margin: 0;
    }

    .top-bar .logout-btn {
      background: #e74c3c;
      color: white;
      padding: 8px 14px;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
      cursor: pointer;
    }

    .container {
      max-width: 800px;
      margin: 40px auto;
      background: #1e1e1e;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.4);
    }

    h2 {
      color: #00d1b2;
      margin-bottom: 20px;
    }

    .info {
      font-size: 16px;
      margin-bottom: 20px;
      line-height: 1.6;
    }

    .footer {
      text-align: center;
      margin-top: 50px;
      color: #888;
      font-size: 13px;
    }
  </style>
</head>
<body>

  <header class="top-bar">
    <h1>The Golden Hands Charitable Trust</h1>
    <a href="logout.php" class="logout-btn">Logout</a>
  </header>

  <div class="container">
    <h2>Welcome to Your Dashboard</h2>

    <div class="info">
      <strong>Enrollment Number:</strong> <?= htmlspecialchars($_SESSION['enroll']) ?><br>
      <p>This is your personal dashboard. From here you can:</p>
      <ul>
        <li>📊 View your participation status</li>
        <li>🎯 Access NGO events and tasks</li>
        <li>✏️ Update your personal details (coming soon)</li>
        <li>🧾 Track your contributions (future release)</li>
      </ul>
    </div>

    <p>If you need any help, contact us at <a href="mailto:admin@goldenhands.org" style="color:#00d1b2;">admin@goldenhands.org</a></p>
  </div>

  <div class="footer">
    &copy; 2025 The Golden Hands Charitable Trust. All rights reserved.
  </div>

</body>
</html>
