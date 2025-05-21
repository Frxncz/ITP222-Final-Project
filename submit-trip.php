<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: index.html");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_SESSION['username'];
  $city = $_POST['city'] ?? '';
  $region = $_POST['region'] ?? '';
  $activities = isset($_POST['activities']) ? implode(', ', $_POST['activities']) : '';
  $info = isset($_POST['info']) ? implode(', ', $_POST['info']) : '';

  // DB connection
  $conn = new mysqli("localhost", "root", "", "auth_system");
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("INSERT INTO trip_plans (username, city, region, activities, info) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $username, $city, $region, $activities, $info);

  if ($stmt->execute()) {
    header("Location: trip-planner.php"); // redirect to see new plan
    exit();
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
}
?>
