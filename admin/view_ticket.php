<?php
  require '../db.php';
  require '../functions.php';
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

<?php  
include("./includes/header.php");
include("./includes/sidenav.php");
?>
<div class="main">
  <?php include("./includes/topbar.php");?>
  <div class="ticket_details_container">
    <div class="ticket_details">
      <div class="ticket_heading">
        <h4>Ticket <span>#1 - </span><span>Water Leakage</span></h5>
        <div class="status pending">Pending</div>
      </div>
      <div class="horizontal_line"></div>

      <div class="ticket_body">
        <div class="project_details">
          <div><strong class="title">Project: </strong><p>Toruneer</p></div>
          <div><strong class="title">Floor: </strong><p>4th</p></div>
          <div><strong class="title">Appartment:</strong><p>B4</p></div>
        </div>
        <div><strong>Issue Details: </strong><p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem, accusantium. Voluptate saepe exercitationem, vitae unde illum modi voluptatum reiciendis impedit commodi. In mollitia alias qui non voluptas quibusdam veritatis illum.</p></div>
        <div class="project_details">
          <div><strong class="title">Contact Client: </strong><p>+880123456789</p></div>
        </div>
        <div class="project_details"><strong>Assigned Staff: </strong><p>Sazzad</p> <strong>ID: </strong><p>12345</p></div>
        <div class="project_details"><strong>Change Staff: </strong><p>DropDown</p><button>Update</button></div>
      </div>
    </div>
  </div>
</div>
</div>
<?php include("./includes/footer.php"); ?>