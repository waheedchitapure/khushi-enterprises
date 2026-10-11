<?php
/**
 * Khushi Enterprises - Admin Login Page
 */

session_start();
require_once __DIR__ . '/../config/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    // Default password is khushi2026
    if ($password === 'khushi2026') {
        $_SESSION['khushi_logged_in'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Galat Password! Kripya sahi admin password dalein.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Khushi Enterprises | Admin Login</title>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #071527; color: #fff; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; padding: 16px; }
    .login-box { background: #0a1d37; border: 1px solid #c69234; border-radius: 12px; padding: 32px; width: 100%; max-width: 380px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); text-align: center; }
    .logo { width: 70px; height: 70px; border-radius: 50%; margin-bottom: 14px; border: 2px solid #c69234; }
    h2 { font-size: 20px; color: #fff; margin-bottom: 6px; }
    p { font-size: 13px; color: #cbd5e1; margin-bottom: 20px; }
    .form-group { margin-bottom: 16px; text-align: left; }
    label { font-size: 13px; color: #dcb059; font-weight: bold; display: block; margin-bottom: 6px; }
    input[type="password"] { width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #1e457c; background: #0f274a; color: #fff; font-size: 15px; box-sizing: border-box; }
    input[type="password"]:focus { outline: none; border-color: #c69234; }
    button { width: 100%; background: #c69234; color: #fff; border: none; padding: 12px; font-size: 15px; font-weight: bold; border-radius: 6px; cursor: pointer; transition: background 0.2s; }
    button:hover { background: #b37e28; }
    .error { background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 6px; font-size: 13px; margin-bottom: 16px; }
  </style>
</head>
<body>

  <div class="login-box">
    <img src="../assets/images/brand/logo.png" alt="Khushi Enterprises" class="logo" onerror="this.style.display='none'">
    <h2>KHUSHI ENTERPRISES</h2>
    <p>Wholesale Enquiry Admin Portal</p>

    <?php if (!empty($error)): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label for="password">Enter Admin Password:</label>
        <input type="password" id="password" name="password" placeholder="Default: khushi2026" required autofocus>
      </div>
      <button type="submit">Login to Dashboard</button>
    </form>
  </div>

</body>
</html>
