<?php
  require '../db.php';
  require '../functions.php';
  check_auth();
  $user = $_SESSION['user'];
  $id = $_GET['id'] ?? 0;

  // session_start();

  // Fetch the ticket and the assigned staff (only one staff per ticket)
  $stmt = $pdo->prepare("SELECT t.*, u.name as user_name, s.name as assigned_name, s.employee_id as assigned_staff_employee_id, s.id as assigned_staff_id, cp.name as client_name, cp.phone as client_contact 
                       FROM tickets t
                       LEFT JOIN users u ON u.id=t.user_id 
                       LEFT JOIN ticket_assignments ta ON ta.ticket_id = t.id
                       LEFT JOIN support_staff s ON s.id = ta.staff_id
                       LEFT JOIN client_profile cp ON cp.id = t.client 
                       WHERE t.id = ? LIMIT 1");
  $stmt->execute([$id]);
  $t = $stmt->fetch();
  $successMessage = "";

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'update_staff') {
        $selectedStaffId = $_POST['staff'] ?? '';
        if ($selectedStaffId !== '') {
            $update = $pdo->prepare("UPDATE ticket_assignments SET staff_id = ? WHERE ticket_id = ?");
            $update->execute([$selectedStaffId, $id]);

            $_SESSION['success_message'] = $update->rowCount() > 0
              ? "Assigned staff updated successfully!"
              : "No change — same staff as before.";
        } else {
            $_SESSION['error_message'] = "Please select a staff member.";
        }
        header("Location: view_ticket.php?id=".$id);
        exit;
    }

    if ($action === 'update_status') {
        $newStatus = $_POST['status'] ?? '';
        if (in_array($newStatus, ['Pending','On Process','Solved'], true)) {
            $update = $pdo->prepare("UPDATE tickets SET status = ? WHERE id = ?");
            $update->execute([$newStatus, $id]);

            $_SESSION['success_message'] = $update->rowCount() > 0
              ? "Ticket status updated successfully!"
              : "No change — already $newStatus.";
        } else {
            $_SESSION['error_message'] = "Invalid status value.";
        }
        header("Location: view_ticket.php?id=".$id);
        exit;
    }
}
  


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


  <!-- Success Message Display -->
  <?php if (isset($_SESSION['success_message'])) { ?>
    <div id="successNotification"><?php echo $_SESSION['success_message']; ?></div>
    <?php unset($_SESSION['success_message']); // Clear the session message ?>
  <?php } ?>

  <!-- Error Message Display (if any) -->
  <?php if (isset($_SESSION['error_message'])) { ?>
    <div id="errorNotification"><?php echo $_SESSION['error_message']; ?></div>
    <?php unset($_SESSION['error_message']); // Clear the session error message ?>
  <?php } ?>
  


  <div class="ticket_details_container">
    <div class="ticket_details">
      <div class="ticket_heading">
        <h4>Ticket <span>#<?php echo $t['id']; ?> - </span><span><?php echo $t['category']; ?></span></h4>
        <div class="status <?php echo ($t['status'] == 'pending') ? 'pending' : (($t['status'] == 'On Process') ? 'ongoing' : 'solved'); ?>">
          <?php echo $t['status']; ?>
        </div>
      </div>
      <div class="horizontal_line"></div>

      <div class="ticket_body">
        <div class="project_details">
          <div><strong class="title">Project: </strong><p><?php echo $t['project']; ?></p></div>
          <?php if (!empty($t['floor'])): ?>
          <div>
              <strong class="title">Floor: </strong>
              <p><?php echo h($t['floor']); ?></p>
          </div>
          <?php endif; ?>

          <div><strong class="title">Appartment:</strong><p><?php echo $t['appartment']; ?></p></div>
        </div>
        <div class="issue_details"><strong>Issue Details: </strong><p><?php echo $t['description']; ?></p></div>
        
        <div class="issue_img">
          <!-- <img src="./assets/imgs/customer.jpg" class="image">
          <img src="./assets/imgs/customer2.jpg" class="image"> -->
          <?php
          if(!empty($t['image'])){
            $imagePaths = explode(',', $t['image']);
            // Loop through each image path and display the image
            foreach ($imagePaths as $imagePath) {
              // Trim any extra spaces from the image path
              $imagePath = trim($imagePath);
              echo "<img src='../client/$imagePath' class='image'>";
            }
          } else {
            echo "No images available.";
          }
          ?>
        </div>

        <div id="imageModal" class="modal">
          <span class="close">&times;</span>
          <img class="modal-content" id="modalImage">
        </div>
        
        <div class="project_details">
          <div>
            <strong class="title">Client Name: </strong><p><?php echo $t['client_name'] ?></p>
          </div>
          <div>
            <strong class="title">Client Contact: </strong><p>+<?php echo $t['client_contact'] ?></p>
          </div>
        </div>
        <div class="project_details">
          <div>
            <strong class="title">Assigned Staff: </strong><p class="name"><?php echo $t['assigned_name']; ?></p><strong class="title">ID: </strong><p><?php echo $t['assigned_staff_employee_id']; ?></p>
          </div>
        </div>
        <!-- <div class="project_details">
          <div><strong class="title">Change Staff: </strong><p>DropDown</p><button>Update</button></div>
        </div>
        <div>
          <h4>Change Ticket Status: </h4><p>Dropdown</p>
        </div> -->
        <div class="ticket_action">
          <!-- Update Staff -->
          <form method="POST" action="view_ticket.php?id=<?= (int)$t['id'] ?>">
            <input type="hidden" name="action" value="update_staff">
            <div class="change_staff">
              <strong>Change Staff: </strong>
              <select name="staff" id="select_staff" required>
                <option value="" disabled selected>Update Staff</option>
                <?php
                $staffQuery = $pdo->prepare("SELECT id, name FROM support_staff ORDER BY name");
                $staffQuery->execute();
                foreach ($staffQuery->fetchAll() as $staff) {
                  echo "<option value='{$staff['id']}'>{$staff['name']}</option>";
                }
                ?>
              </select>
              <button class="btn" type="submit">Update</button>
            </div>
          </form>  



          <!-- Update Status -->
          <form method="POST" action="view_ticket.php?id=<?= (int)$t['id'] ?>">
            <input type="hidden" name="action" value="update_status">
            <div class="ticket_status">
              <strong>Change Ticket Status:</strong>
              <select name="status" id="status" required>
                <option value="" disabled>Update Status</option>
                <option value="Pending"    <?= $t['status']==='Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="On Process" <?= $t['status']==='On Process' ? 'selected' : '' ?>>On Process</option>
                <option value="Solved"     <?= $t['status']==='Solved' ? 'selected' : '' ?>>Solved</option>
              </select>
              <button class="btn" type="submit">Update</button>
            </div>
          </form>
        </div>
        <div class="comment_action">
          <a href="./comment.php">Write details about the ticket</a>
        </div>
  </div>
</div>
</div>
<?php include("./includes/footer.php"); ?>


<script>
  // Show success notification and reload the page after a delay
  <?php if (isset($_SESSION['success_message'])) { ?>
    setTimeout(function() {
      location.reload(); // Reload the page after 1 second
    }, 1000);
  <?php } ?>
</script>