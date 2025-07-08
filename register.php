<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "ngo";

// Connect
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    die("❌ Database Connection Failed: " . $conn->connect_error);
}

// Get data
$name     = $_POST['name'] ?? '';
$email    = $_POST['email'] ?? '';
$dob      = $_POST['dob'] ?? '';
$father   = $_POST['father'] ?? '';
$contact  = $_POST['contact'] ?? '';
$address  = $_POST['address'] ?? '';
$motive   = $_POST['motive'] ?? '';
$password = $_POST['password'] ?? '';

// Validate
if (empty($name) || empty($email) || empty($dob) || empty($father) || empty($contact) || empty($address) || empty($motive) || empty($password)) {
    http_response_code(400);
    echo "❗ All fields are required.";
    exit();
}

// Hash password
$hash = password_hash($password, PASSWORD_DEFAULT);

// Generate enrollment
$result = $conn->query("SELECT enrollment FROM registrations ORDER BY id DESC LIMIT 1");
if ($result && $result->num_rows > 0) {
    $last = $result->fetch_assoc()['enrollment'];
    $num = (int)substr($last, 4) + 1;
    $enrollment = "GHCT" . str_pad($num, 4, '0', STR_PAD_LEFT);
} else {
    $enrollment = "GHCT0001";
}

// Insert
$stmt = $conn->prepare("INSERT INTO registrations (enrollment, name, email, dob, father, contact, address, motive, password)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", $enrollment, $name, $email, $dob, $father, $contact, $address, $motive, $hash);

if ($stmt->execute()) {
    echo "✅ Registered successfully! Enrollment No: $enrollment";
} else {
    http_response_code(500);
    echo "❌ Registration Failed: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
