<?php
  require '../db.php';
  require '../functions.php';
  check_auth();
  $user = $_SESSION['user'];
  $id = $_GET['id'] ?? 0;

  // Fetch the ticket and the assigned staff (only one staff per ticket)
  $stmt = $pdo->prepare("SELECT t.*, u.name as user_name, s.name as assigned_name, s.id, s.employee_id as assigned_staff_id, cp.name as client_name, cp.phone as client_contact 
                       FROM tickets t
                       LEFT JOIN users u ON u.id=t.user_id 
                       LEFT JOIN ticket_assignments ta ON ta.ticket_id = t.id
                       LEFT JOIN support_staff s ON s.id = ta.staff_id
                       LEFT JOIN client_profile cp ON cp.id = t.client 
                       WHERE t.id = ? LIMIT 1");
  $stmt->execute([$id]);
  $t = $stmt->fetch();


  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['staff']) && !empty($_POST['staff'])) {
        $selectedStaffId = $_POST['staff'];
        $ticketId = $id;  // Assuming ticket ID is available

        // Update the assigned_to column in tickets table
        $updateQuery = $pdo->prepare("UPDATE tickets SET assigned_to = ? WHERE id = ?");
        $updateQuery->execute([$selectedStaffId, $ticketId]);

        // Optionally, show a success message or redirect
        echo "Assigned staff updated successfully!";
    } else {
        echo "Please select a staff member to assign.";
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
          <img src="./assets/imgs/customer2.jpg" class="image">
          <img src="./assets/imgs/customer2.jpg" class="image">
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
        <!-- <div class="project_details">
          <div><strong class="title">Change Staff: </strong><p>DropDown</p><button>Update</button></div>
        </div>
        <div>
          <h4>Change Ticket Status: </h4><p>Dropdown</p>
        </div> -->
        <div class="ticket_action">
          <form method="POST" action="view_ticket.php?id=<?= $t['id'] ?>">
            <div class="change_staff">
              <strong>Change Staff: </strong>
              <select name="staff" id="select_staff">
                <option value="" disabled selected>Update Staff</option>
                <!-- <option value="">Ahad</option>
                <option value="">Sazzad</option>
                <option value="">Asif kasdjklgklsd</option>
                <option value="">Tazbir</option> -->
                <?php
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
          <div class="ticket_status">
            <strong>Change Ticket Status:</strong>
            <select name="" id="status">
              <option value="" disabled selected>Update Status</option>
              <option value="">Pending</option>
              <option value="">On Process</option>
              <option value="">Solved</option>
            </select>
            <button class="btn">Update</button>
          </div>
        </div>
        <div class="comment_action">
          <a href="./comment.php">Write details about the ticket</a>
        </div>
  </div>
</div>
</div>
<?php include("./includes/footer.php"); ?>