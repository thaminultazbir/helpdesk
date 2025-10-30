<?php
require '../db.php';
require '../functions.php';
check_auth();

// Ensure the user is an admin
if ($_SESSION['user']['role'] !== 'admin') {
    echo "Access Denied.";
    exit;
}

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $building_id = $_GET['id'];

    // Prepare the DELETE query
    $query = "DELETE FROM building_details WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $building_id, PDO::PARAM_INT); // Bind the ID parameter to the query
    $stmt->execute();

    // Redirect to the building list page after deletion
    header("Location: building.php");
    exit;
} else {
    echo "Invalid ID.";
}
?>
