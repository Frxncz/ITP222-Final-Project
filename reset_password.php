<?php
session_start();
include 'db.php';

// Check if token is valid
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    $stmt = $conn->prepare("SELECT id, token_expires FROM users WHERE reset_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Check if token is expired
        if (strtotime($user['token_expires']) < time()) {
            $_SESSION['error'] = "Reset link has expired. Please request a new one.";
            header("Location: forgot_password.php");
            exit();
        }
        
        // Token is valid - store user ID in session for password update
        $_SESSION['reset_user_id'] = $user['id'];
    } else {
        $_SESSION['error'] = "Invalid reset link.";
        header("Location: forgot_password.php");
        exit();
    }
}

// Handle password reset form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['reset_user_id'])) {
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    
    // Validate passwords match
    if ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: reset_password.php?token=" . $_GET['token']);
        exit();
    }
    
    // Password validation (same as signup)
    if (strlen($newPassword) < 8 || 
        !preg_match('/[A-Z]/', $newPassword) || 
        !preg_match('/[0-9]/', $newPassword) || 
        !preg_match('/[^a-zA-Z0-9]/', $newPassword)) {
        $_SESSION['error'] = "Password must be at least 8 characters and include at least one uppercase letter, one number, and one special character.";
        header("Location: reset_password.php?token=" . $_GET['token']);
        exit();
    }
    
    // Hash new password
    $hash = password_hash($newPassword, PASSWORD_BCRYPT);
    
    // Update password and clear reset token
    $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expires = NULL WHERE id = ?");
    $stmt->bind_param("si", $hash, $_SESSION['reset_user_id']);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Password updated successfully. You can now login.";
        unset($_SESSION['reset_user_id']);
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "Error updating password.";
        header("Location: reset_password.php?token=" . $_GET['token']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Reset Password</title>
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
      color: #ffcc66;
      text-decoration: none;
      transition: color 0.3s ease;
    }
    a:hover {
      color: #993300;
    }
    .login-container {
      background-color: #161b22;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);
      width: 100%;
      max-width: 420px;
    }
    form {
      display: flex;
      flex-direction: column;
    }
    h2 {
      color: #ffcc66;
      margin-bottom: 25px;
      text-align: center;
      letter-spacing: 1.5px;
    }
    label {
      margin-top: 15px;
      margin-bottom: 8px;
      font-weight: 600;
      color: #c9d1d9;
    }
    input[type="password"] {
      padding: 12px 15px;
      border-radius: 6px;
      border: 1.5px solid #30363d;
      background-color: #0d1117;
      color: #c9d1d9;
      font-size: 1rem;
      transition: border-color 0.3s ease;
    }
    input[type="password"]:focus {
      outline: none;
      border-color: #ffcc66;
      background-color: #161b22;
    }
    input[type="checkbox"] {
      cursor: pointer;
      accent-color: #ffcc66;
      margin-right: 8px;
      /* remove vertical margins to help align with label */
      vertical-align: middle;
    }
    .password-field {
      display: flex;
      align-items: center;
      margin-top: 10px;
      margin-bottom: 10px;
      user-select: none;
    }
    button {
      margin-top: 25px;
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
      margin-top: 20px;
      text-align: center;
      color: #c9d1d9;
    }
    p a {
      font-weight: 600;
    }
    /* Error message */
    p.error-message {
      color: #ff4d4d;
      background-color: #3b1a1a;
      padding: 10px 15px;
      border-radius: 8px;
      margin-bottom: 15px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <form action="reset_password.php?token=<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>" method="POST">
      <h2>Reset Your Password</h2>

      <?php if (isset($_SESSION['error'])): ?>
        <p class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
      <?php endif; ?>

      <label for="password">New Password</label>
      <input type="password" name="password" id="password" required placeholder="Min 8 chars, 1 uppercase, 1 number, 1 special">

      <div class="password-field">
        <input type="checkbox" id="show_password" onclick="togglePassword('password')">
        <label for="show_password">Show Password</label>
      </div>

      <label for="confirm_password">Confirm New Password</label>
      <input type="password" name="confirm_password" id="confirm_password" required>

      <div class="password-field">
        <input type="checkbox" id="show_confirm_password" onclick="togglePassword('confirm_password')">
        <label for="show_confirm_password">Show Password</label>
      </div>

      <button type="submit">Update Password</button>
      <p><a href="login.php">Back to Login</a></p>
    </form>
  </div>

  <script>
    function togglePassword(fieldId) {
      const field = document.getElementById(fieldId);
      field.type = field.type === 'password' ? 'text' : 'password';
    }
  </script>
</body>
</html>
