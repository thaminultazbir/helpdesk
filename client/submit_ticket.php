<?php
// Include the database connection
include('../db.php');

// Get client data from cookies or form
$client_name = $_COOKIE['client_name']; // Or get from form if needed
$client_contact = $_COOKIE['client_contact']; // Or get from form if needed

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = $_POST['category'];
    $details = $_POST['details'];

    // Get the additional form data for project, appartment, and floor
    $project = $_POST['buildingName'];  // Get project
    $appartment = $_POST['appartment'];  // Get appartment
    $floor = $_POST['floor'];  // Get floor

    // Step 1: Insert client details into client_profile table
    $sql_client = "INSERT INTO client_profile (name, phone) VALUES (:client_name, :client_contact)";
    $stmt_client = $pdo->prepare($sql_client);
    $stmt_client->bindParam(':client_name', $client_name);
    $stmt_client->bindParam(':client_contact', $client_contact);
    $stmt_client->execute();

    // Get the last inserted client_profile ID
    $client_profile_id = $pdo->lastInsertId();

    // Step 2: Handle image upload
    $imagePaths = [];
    $uploadDirectory = "issue_images/";

    // Check if files are uploaded and if it's an array
    if (isset($_FILES['image']) && is_array($_FILES['image']['name'])) {
        // Loop through uploaded files and move them to the upload folder
        foreach ($_FILES['image']['name'] as $key => $imageName) {
            $targetFile = $uploadDirectory . basename($imageName);
            // Ensure the file is uploaded properly
            if (move_uploaded_file($_FILES['image']['tmp_name'][$key], $targetFile)) {
                $imagePaths[] = $targetFile;  // Store the image path in the array
            }
        }
    } else {
        // Handle the case where only one image is uploaded
        $imageName = $_FILES['image']['name'];
        $targetFile = $uploadDirectory . basename($imageName);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePaths[] = $targetFile;
        }
    }
    

    // Step 3: Insert ticket data into tickets table
    $sql_ticket = "INSERT INTO tickets (client, category, description, image, status, created_at, project, appartment, floor) 
                   VALUES (:client, :category, :description, :image, :status, :created_at, :project, :appartment, :floor)";

    $stmt_ticket = $pdo->prepare($sql_ticket);

    $imagePathsStr = implode(",", $imagePaths);
    $status = 'pending';
    $created_at = date("Y-m-d H:i:s");

    // Bind values to the prepared statement
    $stmt_ticket->bindParam(':client', $client_profile_id);  // Insert client_profile ID as foreign key
    $stmt_ticket->bindParam(':category', $category);
    $stmt_ticket->bindParam(':description', $details);
    $stmt_ticket->bindParam(':image', $imagePathsStr);  // Bind image paths as comma-separated string
    $stmt_ticket->bindParam(':status', $status);
    $stmt_ticket->bindParam(':created_at', $created_at);
    $stmt_ticket->bindParam(':project', $project);  // Bind project
    $stmt_ticket->bindParam(':appartment', $appartment);  // Bind appartment
    $stmt_ticket->bindParam(':floor', $floor);  // Bind floor

    // Execute the ticket insertion
    $stmt_ticket->execute();

    // Close the connection (optional with PDO)
    $stmt_ticket->closeCursor();

    echo "Ticket submitted successfully!";
}
?>
