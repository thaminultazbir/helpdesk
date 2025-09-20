<?php
require 'db.php';
require 'functions.php';
check_auth();
if($_SESSION['user']['role']!=='admin'){ echo 'Forbidden'; exit; }
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name = $_POST['name']; $email = $_POST['email']; $role = $_POST['role']; $pass = $_POST['password'];
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name,email,password,role,created_at) VALUES (?,?,?,?,NOW())");
    $stmt->execute([$name,$email,$hash,$role]);
    header('Location: admin_dashboard.php');
    exit;
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Create User</title><link rel="stylesheet" href="style.css"></head><body>
<div class="card">
  <h2>Create User / Admin</h2>
  <form method="post">
    <label>Name</label><input name="name" required>
    <label>Email</label><input name="email" type="email" required>
    <label>Role</label><select name="role"><option value="user">User</option><option value="admin">Admin</option></select>
    <label>Password</label><input name="password" required>
    <button>Create</button>
  </form>
  <div><a href="admin_dashboard.php">Back</a></div>
</div>
</body></html>