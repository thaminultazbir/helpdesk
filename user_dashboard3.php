<?php
  require 'db.php';
  require 'functions.php';
  check_auth();
  $user = $_SESSION['user'];
  // fetch user's tickets
  $stmt = $pdo->prepare("SELECT * FROM tickets WHERE user_id = ? ORDER BY created_at DESC");
  $stmt->execute([$user['id']]);
  $tickets = $stmt->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><title>User Dashboard</title><link rel="stylesheet" href="style.css"></head><body>
<div class="card">
  <div class="topbar">
    <h2>Welcome, <?=h($user['name'])?></h2>
    <div><a href="logout.php">Logout</a></div>
  </div>
  <div class="nav"><a href="create_ticket.php">Create Ticket</a></div>
  <h3>Your Tickets</h3>
  <?php if(!$tickets) echo '<p>No tickets yet.</p>'; ?>
  <?php foreach($tickets as $t): ?>
    <div class="ticket">
      <strong><?=h($t['title'])?></strong> — <small><?=h($t['category'])?></small><br>
      Status: <strong><?=h($t['status'])?></strong><br>
      Created: <?=h($t['created_at'])?> <?php if($t['solved_at']) echo " | Solved: ".h($t['solved_at']); ?><br>
      <a href="view_ticket.php?id=<?= $t['id'] ?>">View</a>
    </div>
  <?php endforeach; ?>
</div>
</body></html>