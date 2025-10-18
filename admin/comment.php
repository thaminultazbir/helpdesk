<?php
require 'db.php';
require 'functions.php';
check_auth();

$user = $_SESSION['user'];
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ticket_id = $_POST['ticket_id'] ?? 0;
    $message = $_POST['message'] ?? '';
    $filePaths = []; // Store paths of uploaded files

    // Process uploaded files
    if (!empty($_FILES['attachments']['name'][0])) {
        $targetDir = 'uploads/';  // Directory to store files
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];

        // Loop through each uploaded file
        foreach ($_FILES['attachments']['name'] as $index => $fileName) {
            $fileTmpName = $_FILES['attachments']['tmp_name'][$index];
            $fileType = $_FILES['attachments']['type'][$index];

            // Check if file type is allowed
            if (in_array($fileType, $allowedTypes)) {
                $targetFile = $targetDir . time() . '_' . basename($fileName);
                
                // Move the file to the uploads directory
                if (move_uploaded_file($fileTmpName, $targetFile)) {
                    $filePaths[] = $targetFile; // Store the path of the uploaded file
                } else {
                    $err = "Failed to upload one or more files.";
                }
            } else {
                $err = "File type not allowed.";
            }
        }
    }

    // Insert comment into the database
    if (empty($err)) {
        $filePaths = implode(',', $filePaths); // Store file paths as comma-separated values in the database
        $stmt = $pdo->prepare("INSERT INTO comments (ticket_id, user_id, message, files, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$ticket_id, $user['id'], $message, $filePaths]);

        // Redirect back to the ticket view page
        header('Location: view_ticket.php?id=' . $ticket_id);
        exit;
    }
}
?>

