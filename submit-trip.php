<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: index.html");
  exit();
}

$username = $_SESSION['username'];
$city = $_POST['city'] ?? '';
$region = $_POST['region'] ?? '';
$activities = isset($_POST['activities']) ? implode(", ", $_POST['activities']) : '';
$info = isset($_POST['info']) ? implode(", ", $_POST['info']) : '';

// DB connection
$conn = new mysqli("localhost", "root", "", "auth_system");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Insert or update
$sql = "REPLACE INTO trip_plans (username, city, region, activities, info)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $username, $city, $region, $activities, $info);

if ($stmt->execute()) {
  echo "<script>alert('Trip saved successfully!'); window.location.href='trip-planner.php';</script>";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
