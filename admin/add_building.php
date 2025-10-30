<?php
require '../db.php';
require '../functions.php';
check_auth();

if ($_SESSION['user']['role'] !== 'admin') {
    echo "Access Denied.";
    exit; // Prevent further execution
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $building_name = $_POST['building_name'];
    $number_of_floor = $_POST['number_of_floor'];
    $number_of_unit = $_POST['number_of_unit'];
    $apartment_name = $_POST['apartment_name'];
    $apartment_name = preg_replace('/\s*,\s*/', ', ', $apartment_name);
    $apartment_name = trim($apartment_name);
    $apartment_name = implode(", ", array_filter(explode(",", $apartment_name), function($value) {
        return !empty(trim($value));  // filter out any empty values
    }));

    // Prepare the insert query
    $query = "INSERT INTO building_details (building_name, number_of_floor, number_of_unit, apartment_name) 
              VALUES (:building_name, :number_of_floor, :number_of_unit, :apartment_name)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':building_name', $building_name, PDO::PARAM_STR);
    $stmt->bindParam(':number_of_floor', $number_of_floor, PDO::PARAM_INT);
    $stmt->bindParam(':number_of_unit', $number_of_unit, PDO::PARAM_INT);
    $stmt->bindParam(':apartment_name', $apartment_name, PDO::PARAM_STR);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to the building list page after successful insertion
        header("Location: building.php");
        exit;
    } else {
        $error_message = "Error: Unable to add building. Please try again.";
    }
}
?>

<?php include("./includes/header.php"); ?>
<?php include("./includes/sidenav.php"); ?>

<!-- ========Main========== -->
<div class="main">
    <?php include("./includes/topbar.php"); ?>
    <div class="building_container">
        <div class="building_table_details">
            <h2>Add New Building</h2>
            <?php
            // Display error message if any
            if (isset($error_message)) {
                echo "<p style='color: red;'>$error_message</p>";
            }
            ?>
            <form action="add_building.php" method="POST">
                <div class="add_building_container">
                    <div class="input_field">
                        <label for="building_name">Building Name:</label>
                        <input type="text" name="building_name" id="building_name" required>
                    </div>

                    <div class="input_field">
                        <label for="number_of_floor">Number of Floors:</label>
                        <input type="number" name="number_of_floor" id="number_of_floor" required>
                    </div>

                    <div class="input_field">
                        <label for="number_of_Unit">Number of Unit:</label>
                        <input type="number" name="number_of_unit" id="number_of_unit">
                    </div>

                    <div class="input_field">
                        <label for="apartment_name">Apartment Names (comma separated):</label>
                        <textarea name="apartment_name" id="apartment_name" rows="5" required></textarea>
                    </div>
                </div>
                <button type="submit" class="add_build_sub">Add Building</button>
            </form>
        </div>
    </div>
</div>

<?php include("./includes/footer.php"); ?>

<script>
// JavaScript function to generate apartment names
document.getElementById('number_of_floor').addEventListener('input', generateApartments);
document.getElementById('number_of_unit').addEventListener('input', generateApartments);

function generateApartments() {
    var numberOfFloors = document.getElementById('number_of_floor').value;
    var numberOfUnits = document.getElementById('number_of_unit').value;
    
    var apartmentNames = [];
    
    // Only generate if both fields have values
    if (numberOfFloors && numberOfUnits) {
        for (var i = 1; i <= numberOfFloors; i++) {
            for (var j = 1; j <= numberOfUnits; j++) {
                // Generate apartment name in the format "A1, B1, C1, D1..."
                var apartmentName = String.fromCharCode(64 + j) + i; // Convert number to letter (A, B, C, etc.)
                apartmentNames.push(apartmentName);
            }
        }
        
        // Join the apartment names into a comma-separated string
        document.getElementById('apartment_name').value = apartmentNames.join(', ');
    }
}
</script>
