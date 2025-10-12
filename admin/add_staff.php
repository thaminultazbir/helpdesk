<?php
  require '../db.php';
  require '../functions.php';
  check_auth();
  if ($_SESSION['user']['role'] !== 'admin') {
      echo "Access Denied.";
      exit; // Prevent further execution
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $staff_id = $_POST['staff_id'] ?? '';
    // $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if (empty($name) || empty($staff_id) || empty($phone)) {
        $error = "All fields are required.";
    }else{
        $stmt = $pdo->prepare("INSERT INTO support_staff (name, phone, employee_id, created_at) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $phone, $staff_id, date('Y-m-d H:i:s')]);

        $success = "Staff created successfully.";
        header("Location: index.php");
        exit();
    }
  }
?>





<?php
include("./includes/header.php");
include("./includes/sidenav.php"); 
?>
        


<!-- ========Main========== -->
    <div class="main">
        <?php 
        include("./includes/topbar.php");
        ?>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?=h($error)?></p>
        <?php elseif (isset($success)): ?>
            <p style="color: green;"><?=h($success)?></p>
        <?php endif; ?>
        <form action="add_staff.php" method="POST">
            <div class="staff-form">
                <div class="nice-form-group">
                    <label>Staff Name</label>
                    <input type="text" placeholder="Entre name" name="name"/>
                </div>

                <div class="nice-form-group">
                    <label>Staff ID</label>
                    <input type="text" placeholder="ID" name="staff_id"/>
                </div>

                <div class="nice-form-group">
                    <label>Email</label>
                    <input type="email" placeholder="Optional" name="email/>
                </div>

                <div class="nice-form-group">
                    <label>Phonenumber</label>
                    <input type="number" placeholder="Entre Phone Number" name="phone"/>
                </div>
                <button type="submit">Create Staff</button>
            </div>
        </form>
    </div>
    <?php include("./includes/footer.php") ?>