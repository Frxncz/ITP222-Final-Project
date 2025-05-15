<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    
    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        // Generate token and expiration (3 minutes)
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+3 minutes'));
        
        // Store token in database
        $update = $conn->prepare("UPDATE users SET reset_token = ?, token_expires = ? WHERE email = ?");
        $update->bind_param("sss", $token, $expires, $email);
        
        if ($update->execute()) {
           //generate a link
           $resetLink = "http://localhost/ITP222-FINAL-PROJ/reset_password.php?token=$token";
            $_SESSION['message'] = "Password reset link has been sent .<br> <a href='$resetLink'>$resetLink</a>";
        } else {
            $_SESSION['error'] = "Error generating reset token.";
        }
    } else {
        $_SESSION['error'] = "Email not found.";
    }
    
    header("Location: forgot-password.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Forgot Password</title>
  <style>
    /* Reset and global */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: Arial, sans-serif;
      background-color: #0d1117;
      color: #c9d1d9;
      line-height: 1.6;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      padding: 20px;
    }
    a {
      text-decoration: none;
      color: #ffcc66;
      transition: color 0.3s ease;
    }
    a:hover {
      color: #993300;
    }
    /* Container */
    .login-container {
      background-color: #161b22;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);
      width: 100%;
      max-width: 400px;
    }
    h2 {
      color: #ffcc66;
      margin-bottom: 25px;
      text-align: center;
      letter-spacing: 1.5px;
    }
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: #c9d1d9;
    }
    input[type="email"] {
      width: 100%;
      padding: 12px 15px;
      border-radius: 6px;
      border: 1.5px solid #30363d;
      background-color: #0d1117;
      color: #c9d1d9;
      font-size: 1rem;
      margin-bottom: 20px;
      transition: border-color 0.3s ease;
    }
    input[type="email"]:focus {
      outline: none;
      border-color: #ffcc66;
      background-color: #161b22;
    }
    button {
      width: 100%;
      padding: 12px 15px;
      background-color: #993300;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-weight: 700;
      font-size: 1.1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    button:hover {
      background-color: #ffcc66;
      color: #000;
    }
    p {
      margin-top: 15px;
      text-align: center;
      font-size: 0.9rem;
      color: #c9d1d9;
    }
    /* Error and success messages */
    .message {
      margin-bottom: 15px;
      padding: 10px 15px;
      border-radius: 6px;
      font-weight: 600;
      text-align: center;
    }
    .error {
      background-color: #8b0000;
      color: #fff;
      box-shadow: 0 0 6px #8b0000;
    }
    .success {
      background-color: #556b2f;
      color: #fff;
      box-shadow: 0 0 6px #ffcc66;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <form action="forgotpassword.php" method="POST">
      <h2>Reset Password</h2>
      
      <?php if (isset($_SESSION['error'])): ?>
        <div class="message error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
      <?php endif; ?>
      
      <?php if (isset($_SESSION['message'])): ?>
        <div class="message success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
      <?php endif; ?>
      
      <label for="resetEmail">Enter your email:</label>
      <input type="email" id="resetEmail" name="email" placeholder="you@example.com" required />
      <button type="submit">Send Reset Link</button>
      <p><a href="login.php">Back to Login</a></p>
    </form>
  </div>
</body>
</html>
