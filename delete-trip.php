<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: index.html");
  exit();
}

$conn = new mysqli("localhost", "root", "", "auth_system");
if ($conn->connect_error) die("Connection failed");

if (isset($_POST['trip_id'])) {
  $stmt = $conn->prepare("DELETE FROM trip_plans WHERE id = ? AND username = ?");
  $stmt->bind_param("is", $_POST['trip_id'], $_SESSION['username']);
  $stmt->execute();
  $stmt->close();
}

$conn->close();
header("Location: trip-planner.php");
exit();
?>
