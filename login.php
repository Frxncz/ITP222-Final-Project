<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['email']);
    $password = $_POST['password'];

// Query user by email or username
$stmt = $conn->prepare("SELECT * FROM users WHERE email=? OR username=?");
$stmt->bind_param("ss", $user, $user);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Check if account is locked
    if (!empty($row['lock_until']) && strtotime($row['lock_until']) > time()) {
        $_SESSION['error'] = "Account is locked. Please try again later.";
        header("Location: login.php");
        exit();
    }

    // Verify password
    if (password_verify($password, $row['password'])) {
        // Reset failed attempts
        $conn->query("UPDATE users SET failed_attempts = 0, lock_until = NULL WHERE id = {$row['id']}");

        // Set session variables
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        // Increment failed attempts
        $conn->query("UPDATE users SET failed_attempts = failed_attempts + 1 WHERE id = {$row['id']}");

        // Lock account after 5 failed attempts
        if ($row['failed_attempts'] + 1 >= 5) {
            $lockUntil = date('Y-m-d H:i:s', strtotime('+5 minutes'));
            $conn->query("UPDATE users SET lock_until = '$lockUntil' WHERE id = {$row['id']}");
            $_SESSION['error'] = "Too many login attempts. Account locked for 5 minutes.";
        } else {
            $_SESSION['error'] = "Incorrect username/email or password.";
        }

        header("Location: login.php");
        exit();
    }
} else {
    $_SESSION['error'] = "User not found.";
    exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="login-container">
    <form action="login.php" method="POST" id="loginForm">
      <h2>Login</h2>

      <!-- Display Error Message if set in session -->
      <?php
      if (isset($_SESSION['error'])) {
          echo '<p style="color:red;">' . $_SESSION['error'] . '</p>';
          unset($_SESSION['error']);  // Unset the error message after displaying it
      }
      ?>
      

      <label for="email">Email or Username</label>
      <input type="text" name="email" id="email" placeholder="Enter your email or username" required>

      <label for="password">Password</label>
      <input type="password" name="password" id="password" placeholder="Enter your password" required>
      <input type="checkbox" onclick="togglePassword()"> Show Password

      <a href="forgot_password.html">Forgot Password?</a>

      <button type="submit">Login</button>
      <a href="signup.html">Don't have an account? Sign up here</a>
    </form>
  </div>


  <script>
    // Toggle password visibility
    function togglePassword() {
      var passwordField = document.getElementById('password');
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
      } else {
        passwordField.type = 'password';
      }
    }
  </script>

</body>
</html>
