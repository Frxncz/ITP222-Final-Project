<?php
session_start();
include 'db.php';

// Get and sanitize input
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];

// Password validation
if (strlen($password) < 8 || 
    !preg_match('/[A-Z]/', $password) || 
    !preg_match('/[0-9]/', $password) || 
    !preg_match('/[^a-zA-Z0-9]/', $password)) {
    echo "Password must be at least 8 characters and include at least one uppercase letter, one number, and one special character.";
    exit;
}

// ✅ Check if username already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo "Username already taken.";
    exit;
}
$stmt->close();

// ✅ Check if email already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo "Email already registered.";
    exit;
}
$stmt->close();

// Hash password
$hash = password_hash($password, PASSWORD_BCRYPT);

// Insert user
$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $hash);

if ($stmt->execute()) {
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;

    header("Location: dashboard.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>
