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
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="login-container">
    <form action="forgotpassword.php" method="POST">
      <h2>Reset Password</h2>
      
      <?php if (isset($_SESSION['error'])): ?>
        <p style="color:red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
      <?php endif; ?>
      
      <?php if (isset($_SESSION['message'])): ?>
        <p style="color:green;"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
      <?php endif; ?>
      
      <label for="resetEmail">Enter your email:</label>
      <input type="email" id="resetEmail" name="email" placeholder="you@example.com" required>
      <button type="submit">Send Reset Link</button>
      <p><a href="login.php">Back to Login</a></p>
    </form>
  </div>
</body>
</html>