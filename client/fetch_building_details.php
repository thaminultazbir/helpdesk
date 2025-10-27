<?php
// Assuming you are using PDO for database connection
include('../db.php');

// Check if 'building_id' is provided in the AJAX request
if(isset($_POST['building_id'])) {
    $building_id = $_POST['building_id']; // Get the building ID
    
    // Get the floor count and apartment names for the building
    $stmt = $pdo->prepare("SELECT number_of_floor, apartment_name FROM building_details WHERE id = :building_id");
    $stmt->bindParam(':building_id', $building_id, PDO::PARAM_INT);
    $stmt->execute();
    
    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($result) {
        $floor_count = $result['number_of_floor']; // Get number of floors
        $apartment_names = explode(",", $result['apartment_name']); // Split apartment names
        
        // Generate floor options dynamically based on floor_count
        $floor_options = [];
        for ($i = 1; $i <= $floor_count; $i++) {
            $floor_options[] = $i . (getOrdinalSuffix($i)); // Add ordinal suffix (1st, 2nd, 3rd, etc.)
        }
        
        // Return the floor options and apartment names as JSON
        echo json_encode([
            'floors' => $floor_options,
            'apartments' => $apartment_names
        ]);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}

// Helper function to get ordinal suffixes (st, nd, rd, th)
function getOrdinalSuffix($num) {
    if (in_array(($num % 100), [11,12,13])) {
        return 'th';
    }
    switch ($num % 10) {
        case 1:  return 'st';
        case 2:  return 'nd';
        case 3:  return 'rd';
        default: return 'th';
    }
}
?>
