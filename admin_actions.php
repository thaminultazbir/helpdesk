<?php
    require 'db.php';
    require 'functions.php';
    check_auth();

    //Check if the user is an admin. If not, deny access
    if($_SESSION['user']['role']!=='admin'){ 
        echo 'Forbidden'; 
        exit; 
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $ticket = $_POST['ticket_id'] ?? 0;
        $assign_ids = $_POST['assign_id'] ?? [];
        $status = $_POST['status'] ?? 'Pending';
        $solved_at = null;

        if($status==='Solved'){
            $solved_at = date('Y-m-d H:i:s');
        } 
        // $pdo->prepare("UPDATE tickets SET assigned_to = ?, status = ?, solved_at = ? WHERE id = ?")
        //     ->execute([$assign_ids[0], $status, $solved_at, $ticket]);
        // header("Location: view_ticket.php?id=".$ticket);

        $pdo->prepare("UPDATE tickets SET status = ?, solved_at = ? WHERE id = ?")
            ->execute([$status, $solved_at, $ticket_id]);

        // Insert assignments for each selected staff
        foreach ($assign_ids as $staff_id) {
            $stmt = $pdo->prepare("INSERT INTO ticket_assignments (ticket_id, staff_id, assigned_at) VALUES(?, ?, ?)");
            $stmt->execute([$ticket_id, $staff_id, date('Y-m-d H:i:s')]);
        }
        header("Location: view_ticket.php?id=" . $ticket);
        exit();
    }
?>