<?php
require 'db.php';
session_start();
$err = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'] ?? '';
    $pass = $_POST['password'] ?? '';
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $u = $stmt->fetch();
    if($u && password_verify($pass, $u['password'])){
        $_SESSION['user'] = $u;
        if($u['role']==='admin') header('Location: ./admin/index.php');
        else header('Location: ./client/index.php');
        exit;
    } else $err = 'Invalid credentials';
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Login - Helpdesk</title>
<link rel="stylesheet" href="style.css"></head><body>
<div class="card">
  <h2>Login</h2>
  <?php if($err) echo '<p class="err">'.htmlspecialchars($err).'</p>'; ?>
  <form method="post">
    <label>Email</label><input name="email" required>
    <label>Password</label><input type="password" name="password" required>
    <button>Login</button>
  </form>
</div>
</body></html>