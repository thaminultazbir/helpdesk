<?php
  require 'db.php';
  require 'functions.php';
  check_auth();

  // Check if the user is an admin. If not, deny access.
  if ($_SESSION['user']['role'] !== 'admin') {
      echo "Access Denied.";
      exit; // Prevent further execution
  }

  // Handle form submission
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $name = $_POST['name'] ?? '';
      $phone = $_POST['phone'] ?? '';
      $employee_id = $_POST['employee_id'] ?? '';

      // Basic validation
      if (empty($name) || empty($phone) || empty($employee_id)) {
          $error = "All fields are required.";
      } else {
          // Insert into support_staff table
          $stmt = $pdo->prepare("INSERT INTO support_staff (name, phone, employee_id, created_at) VALUES (?, ?, ?, ?)");
          $stmt->execute([$name, $phone, $employee_id, date('Y-m-d H:i:s')]);

          $success = "Staff created successfully.";
          header("Location: admin_dashboard.php");
          exit();
      }
  }
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Create Support Staff</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="card">
      <div class="topbar">
        <h2>Create Support Staff</h2>
        <div>
          <a href="admin_dashboard.php">Back to Dashboard</a> | <a href="logout.php">Logout</a>
        </div>
      </div>

      <!-- Display errors or success messages -->
      <?php if (isset($error)): ?>
        <p style="color: red;"><?=h($error)?></p>
      <?php elseif (isset($success)): ?>
        <p style="color: green;"><?=h($success)?></p>
      <?php endif; ?>

      <!-- Form to create support staff -->
      <form action="create_support_staff.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br>

        <label for="phone">Phone Number:</label>
        <input type="text" name="phone" id="phone" required><br>

        <label for="employee_id">Employee ID:</label>
        <input type="text" name="employee_id" id="employee_id" required><br>

        <button type="submit">Create Staff</button>
      </form>
    </div>
  </body>
</html>
