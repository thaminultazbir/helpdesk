<?php
// Remove session_start() here, as it's already called in functions.php
require '../db.php';
require '../functions.php';
check_auth();
$user = $_SESSION['user'];
$id = $_GET['id'] ?? 0;

// Fetch the ticket and the assigned staff (only one staff per ticket)
$stmt = $pdo->prepare("SELECT t.*, u.name as user_name, s.name as assigned_name, s.id as assigned_staff_id, cp.name as client_name, cp.phone as client_contact
                       FROM tickets t
                       LEFT JOIN users u ON u.id=t.user_id 
                       LEFT JOIN ticket_assignments ta ON ta.ticket_id = t.id
                       LEFT JOIN support_staff s ON s.id = ta.staff_id
                       LEFT JOIN client_profile cp ON cp.id = t.client 
                       WHERE t.id = ? LIMIT 1");
$stmt->execute([$id]);
$t = $stmt->fetch();

// Handle form submission for updating assigned staff
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['staff']) && !empty($_POST['staff'])) {
        $selectedStaffId = $_POST['staff'];
        $ticketId = $id;  // Assuming ticket ID is available

        // Update the ticket_assignments table to change the assigned staff
        $updateQuery = $pdo->prepare("UPDATE ticket_assignments SET staff_id = ? WHERE ticket_id = ?");
        $updateQuery->execute([$selectedStaffId, $ticketId]);

        // Check if the update was successful
        if ($updateQuery->rowCount() > 0) {
            $_SESSION['success_message'] = "Assigned staff updated successfully!";
        } else {
            $_SESSION['success_message'] = "No changes were made.";
        }

        // Redirect after setting success message
        header("Location: view_ticket.php?id=" . $id);
        exit; // Stop further script execution
    } else {
        $_SESSION['error_message'] = "Please select a staff member to assign.";
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
        <h4>Ticket <span>#<?php echo $t['id']; ?> - </span><span><?php echo $t['title']; ?></span></h4>
        <div class="status <?php echo ($t['status'] == 'Pending') ? 'pending' : (($t['status'] == 'On Process') ? 'ongoing' : 'solved'); ?>">
          <?php echo $t['status']; ?>
        </div>
      </div>
      <div class="horizontal_line"></div>

      <div class="ticket_body">
        <div class="project_details">
          <div><strong class="title">Project: </strong><p><?php echo $t['project']; ?></p></div>
          <div><strong class="title">Floor: </strong><p><?php echo $t['floor']; ?></p></div>
          <div><strong class="title">Appartment:</strong><p><?php echo $t['appartment']; ?></p></div>
        </div>
        <div class="issue_details"><strong>Issue Details: </strong><p><?php echo $t['description']; ?></p></div>

        <div class="issue_img">
          <img src="./assets/imgs/customer.jpg" class="image">
          <img src="./assets/imgs/customer2.jpg" class="image">
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
            <strong class="title">Assigned Staff: </strong><p class="name"><?php echo $t['assigned_name']; ?></p><strong class="title">ID: </strong><p><?php echo $t['assigned_staff_id']; ?></p>
          </div>
        </div>

        <!-- Update Staff Form -->
        <div class="ticket_action">
          <form method="POST" action="view_ticket.php?id=<?= $t['id'] ?>">
            <div class="change_staff">
              <strong>Change Staff: </strong>
              <select name="staff" id="select_staff">
                <option value="" disabled selected>Update Staff</option>
                <?php
                // Fetch all staff from the support_staff table
                $staffQuery = $pdo->prepare("SELECT id, name FROM support_staff");
                $staffQuery->execute();
                $staffList = $staffQuery->fetchAll();
                foreach($staffList as $staff){
                  echo "<option value='{$staff['id']}'>{$staff['name']}</option>";
                }
                ?>
              </select>
              <button class="btn">Update</button>
            </div>
          </form>

          <form action="POST" action="view_ticket.php?id=<?= $t['id'] ?>">
            <div class="ticket_status">
              <strong>Change Ticket Status:</strong>
              <select name="status" id="status">
                <option value="" disabled selected>Update Status</option>
                <option value="Pending" <?php echo ($t['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="On Process" <?php echo ($t['status'] == 'On Process') ? 'selected' : ''; ?>>On Process</option>
                <option value="Solved" <?php echo ($t['status'] == 'Solved') ? 'selected' : ''; ?>>Solved</option>
              </select>
              <button class="btn">Update</button>
            </div>
          </form>
          
        </div>

        <div class="comment_action">
          <a href="./comment.php">Write details about the ticket</a>
        </div>
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
