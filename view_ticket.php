<?php
  require 'db.php';
  require 'functions.php';
  check_auth();
  $user = $_SESSION['user'];
  $id = $_GET['id'] ?? 0;

  // Fetch the ticket and the assigned staff (only one staff per ticket)
  $stmt = $pdo->prepare("SELECT t.*, u.name as user_name, s.name as assigned_name 
                         FROM tickets t
                         LEFT JOIN users u ON u.id=t.user_id 
                         LEFT JOIN ticket_assignments ta ON ta.ticket_id = t.id
                         LEFT JOIN support_staff s ON s.id = ta.staff_id
                         WHERE t.id = ? LIMIT 1");  // Limit to only one staff assignment
  $stmt->execute([$id]);
  $t = $stmt->fetch();

  if (!$t) { 
    echo "Ticket not found"; 
    exit; 
  }

  // Fetch comments
  $comments = $pdo->prepare("SELECT c.*, u.name as author FROM comments c JOIN users u ON u.id=c.user_id WHERE c.ticket_id=? ORDER BY c.created_at ASC");
  $comments->execute([$id]);
  $coms = $comments->fetchAll();
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Ticket #<?=h($t['id'])?></title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="card">
      <div class="topbar">
        <h2><?=h($t['title'])?></h2>
        <div>
          <a href="<?= $user['role'] === 'admin' ? 'admin_dashboard.php' : 'user_dashboard.php' ?>">Back</a> | <a href="logout.php">Logout</a>
        </div>
      </div>
      <p>
        <strong>Category:</strong><?=h($t['category'])?>
      </p>
      <p><?=nl2br(h($t['description']))?></p>
      <?php if ($t['image']): ?>
      <p>
        <img src="<?=h($t['image'])?>" style="max-width:300px">
      </p>
      <?php endif; ?>
      <p>Status: <strong><?=h($t['status'])?></strong></p>
      <p>Created: <?=h($t['created_at'])?> <?= $t['solved_at'] ? "| Solved: ".h($t['solved_at']) : "" ?></p>
      <p>Assigned to: <?= h($t['assigned_name'] ?? '—') ?></p> <!-- Show the name of the assigned staff -->
      <hr>


      <h4>Comments</h4>
<?php foreach ($coms as $c): ?>
    <div class="ticket">
        <strong><?= h($c['author']) ?></strong>
        <small><?= h($c['created_at']) ?></small>
        <div><?= nl2br(h($c['message'])) ?></div>
        
        <?php if (!empty($c['files'])): ?>
            <div>
                <?php
                    $files = explode(',', $c['files']); // Split the file paths
                    foreach ($files as $file) {
                        $file = trim($file); // Remove any extra spaces
                        $fileExtension = pathinfo($file, PATHINFO_EXTENSION); // Get the file extension
                        
                        if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                            <img src="<?= h($file) ?>" alt="Uploaded Image" style="max-width: 200px; margin-top: 10px;">
                        <?php elseif ($fileExtension === 'pdf'): ?>
                            <a href="<?= h($file) ?>" target="_blank">Download PDF</a>
                        <?php else: ?>
                            <a href="<?= h($file) ?>" target="_blank">Download <?= h($file) ?></a>
                        <?php endif; ?>
                    <?php } ?>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

      <!-- <form method="post" action="comment.php">
        <input type="hidden" name="ticket_id" value="">
        <label>Your message</label><textarea name="message" required></textarea>
        <button>Send</button>
      </form> -->

      <form method="post" action="comment.php" enctype="multipart/form-data">
        <input type="hidden" name="ticket_id" value="<?=h($t['id'])?>">
        <label>Your message</label><textarea name="message" required></textarea>

        <label>Upload File (Image, PDF, etc.)</label>
        <input type="file" name="attachments[]" accept="image/*, .pdf" multiple> <!-- Multiple files -->

        <button>Send</button>
      </form>


      <?php if ($user['role'] === 'admin'): ?>
      <hr><h4>Admin actions</h4>
      <form method="post" action="admin_actions.php">
        <input type="hidden" name="ticket_id" value="<?=h($t['id'])?>">
        <select name="assign_id[]">
          <option>Select Staff</option>
          <?php
            // Fetching the list of staff members
            $stmt = $pdo->query("SELECT * FROM support_staff");
            while ($staff = $stmt->fetch()) {
                echo "<option value='" . $staff['id'] . "'>" . $staff['name'] . "</option>";
            }
          ?>
        </select>
        <label>Change status</label>
        <select name="status"><option>Pending</option><option>On Process</option><option>Solved</option></select>
        <button>Update</button>
      </form>
      <?php endif; ?>
    </div>
  </body>
</html>
