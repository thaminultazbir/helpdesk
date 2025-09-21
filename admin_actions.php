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
      $ticket = $_POST['ticket_id'] ?? 0;
      $assign_ids = $_POST['assign_id'] ?? [];
      $status = $_POST['status'] ?? 'Pending';
      $solved_at = null;

      if ($status === 'Solved') {
          $solved_at = date('Y-m-d H:i:s');
      }

      // Update the ticket's status
      $pdo->prepare("UPDATE tickets SET status = ?, solved_at = ? WHERE id = ?")
          ->execute([$status, $solved_at, $ticket]);

      // Remove any existing staff assignment and assign the new staff member
      $pdo->prepare("DELETE FROM ticket_assignments WHERE ticket_id = ?")
           ->execute([$ticket]);  // Remove previous staff assignments

      // Insert the new staff assignment (only one staff)
      foreach ($assign_ids as $staff_id) {
          $stmt = $pdo->prepare("INSERT INTO ticket_assignments (ticket_id, staff_id, assigned_at) VALUES(?, ?, ?)");
          $stmt->execute([$ticket, $staff_id, date('Y-m-d H:i:s')]);
      }

      // Redirect back to the view ticket page
      header("Location: view_ticket.php?id=" . $ticket);
      exit();
  }
?>
