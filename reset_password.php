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
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="login-container">
    <form action="reset_password.php?token=<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>" method="POST">
      <h2>Reset Your Password</h2>
      
      <?php if (isset($_SESSION['error'])): ?>
        <p style="color:red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
      <?php endif; ?>
      
      <label for="password">New Password</label>
      <input type="password" name="password" id="password" required placeholder="Min 8 chars, 1 uppercase, 1 number, 1 special">
      <input type="checkbox" onclick="togglePassword('password')"> Show Password
      
      <label for="confirm_password">Confirm New Password</label>
      <input type="password" name="confirm_password" id="confirm_password" required>
      <input type="checkbox" onclick="togglePassword('confirm_password')"> Show Password
      
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