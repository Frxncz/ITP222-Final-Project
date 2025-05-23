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
</head>

<style>
  /* Global Styles */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: Arial, sans-serif;
    background-color: #0d1117; /* GitHub dark bg */
    color: #c9d1d9; /* subtle light text */
    line-height: 1.6;
  }

  a {
    text-decoration: none;
    color: inherit;
  }

  /* Header Navigation */
  .site-header {
    width: 100%;
    background: #161b22;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
  }

  .container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    padding: 1rem 1rem;
  }

  .logo {
    font-size: 1.5rem;
    font-weight: bold;
    color: #ffcc66;
    margin-right: auto;
  }

  .nav-menu ul {
    list-style: none;
    display: flex;
  }

  .nav-menu ul li {
    margin-left: 1.5rem;
  }

  .nav-menu ul li a {
    font-size: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    transition: background-color 0.3s ease, color 0.3s ease;
    color: #c9d1d9;
  }

  .nav-menu ul li a:hover {
    background-color: #993300;
    color: #ffffff;
  }

  /* Landing Section */
  .landing-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
    text-align: center;
    padding: 20px;
    margin-top: 0px;
  }

  .landing-container h1 {
    font-size: 2.8em;
    margin-bottom: 0.5em;
    color: #58a6ff;
  }

  .landing-container p {
    margin-bottom: 2em;
    color: #8b949e;
    font-size: 1.2em;
  }

  .btn-group {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
  }

  .btn-group a {
    padding: 12px 24px;
    background: #238636;
    color: #fff;
    text-decoration: none;
    border-radius: 6px;
    font-weight: bold;
    transition: background 0.2s ease;
  }

  .btn-group a:hover {
    background: #2ea043;
  }

  /* Login Form Styles */
  .login-container {
    max-width: 500px;
    margin: 120px auto 40px;
    background-color: #161b22;
    padding: 2.5rem;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
  }

  #loginForm h2 {
    text-align: center;
    margin-bottom: 1.5rem;
    font-size: 1.75rem;
    color: #ffcc66;
  }

  #loginForm label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: bold;
    color: #c9d1d9;
  }

  #loginForm input[type="text"],
  #loginForm input[type="password"] {
    width: 100%;
    padding: 0.8rem;
    margin-bottom: 1rem;
    border: 1px solid #30363d;
    background-color: #0d1117;
    color: #f0f6fc;
    border-radius: 6px;
    font-size: 1rem;
  }

  #loginForm button {
    width: 100%;
    padding: 0.8rem;
    background-color: #993300;
    color: #f0f6fc;
    font-size: 1rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 1rem;
  }

  #loginForm button:hover {
    background-color: #30363d;
  }

  #loginForm a {
    display: block;
    text-align: center;
    margin-top: 1rem;
    color: #ffcc66;
    font-size: 0.95rem;
  }

  #loginForm input[type="checkbox"] {
    margin-right: 5px;
  }
</style>


<body>
  <!-- Header with Navigation -->
  <header class="site-header">
    <div class="container">
      <div class="logo">COMPASS</div>
      <nav class="nav-menu">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#service">Service</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>
  
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
