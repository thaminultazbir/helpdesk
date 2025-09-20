<?php
require 'db.php';
require 'functions.php';
check_auth();
if($_SESSION['user']['role']!=='admin'){ echo 'Forbidden'; exit; }
$user = $_SESSION['user'];
// fetch all tickets
$tickets = $pdo->query("SELECT t.*, u.name as user_name FROM tickets t JOIN users u ON u.id=t.user_id ORDER BY t.created_at DESC")->fetchAll();
$users = $pdo->query("SELECT id,name,email,role FROM users ORDER BY id DESC")->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Admin Dashboard</title><link rel="stylesheet" href="style.css"></head><body>
<div class="card">
  <div class="topbar">
    <h2>Admin Panel - <?=h($user['name'])?></h2>
    <div><a href="logout.php">Logout</a></div>
  </div>
  <div class="nav"><a href="admin_create_user.php">Create User/Admin</a></div>
  <h3>All Tickets</h3>
  <?php foreach($tickets as $t): ?>
    <div class="ticket">
      <strong><?=h($t['title'])?></strong> by <?=h($t['user_name'])?> — <?=h($t['category'])?><br>
      Status: <strong><?=h($t['status'])?></strong> | Created: <?=h($t['created_at'])?> 
      <a href="view_ticket.php?id=<?= $t['id'] ?>">View</a>
    </div>
  <?php endforeach; ?>
  <div>
    <a href="./create_support_staff.php">Creating A Support Staff</a>
  </div>
  
</div>
</body></html>