<?php
// Include database connection
include('../db.php');

// Fetch building names from the database
$sql = "SELECT * FROM building_details";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$buildings = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all building names

// Close the connection (optional with PDO)
$stmt->closeCursor();
?>







<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mobile UI</title>
  <link rel="stylesheet" href="./style.css">
  <style>
    #loader {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100px; /* You can adjust this */
            height: 100px; /* Adjust the height */
            background-image: url('./img/logo.png'); /* Your logo path */
            background-size: contain;
            background-repeat: no-repeat;
            animation: scaleUpDown 2s ease-in-out infinite;
            display: none; /* Initially hidden */
        }
  </style>
</head>
<body>
  <div class="container">
    <!-- Section 1: Messages -->
    <div class="messages">
      <p class="query">Welcome to <br> <span>Rancon Facility
 Support System</span></p>
      <img src="./img/logo.png" alt="">
    </div>

    <!-- Section 2: Personal Details -->
     <form method="POST" action="submit_ticket.php" enctype="multipart/form-data">
        <div class="personal-details">
        <div class="scroll-logo"><img src="./img/arrow.png" alt=""></div>
        <h4>Your Personal Details</h4>
        <div class="input-area">
            <label for="name">Name</label>
            <input type="text" name="name" required>
        </div>

        <div class="input-area">
            <label for="contact">Contact</label>
            <input type="number" name="contact" required>
        </div>
        

<div class="input-area dropdown">
    <img src="./img/dropdown.png" alt="arrow">
    <label for="buildingName">Building Name</label>
    <input type="text" name="buildingName" required id="buildingName" readonly placeholder="Select a Building">
    <div class="dropdown-content" data-name="building">
        <?php foreach($buildings as $building):?>
        <div class="dropdown-item" data-name="building" data-id="<?php echo htmlspecialchars($building['id']); ?>"><?php echo htmlspecialchars($building['building_name']); ?></div>
        <?php endforeach; ?>
    </div>
</div>

<div class="input-area dropdown">
    <img src="./img/dropdown.png" alt="arrow">
    <label for="floor">Floor</label>
    <input type="text" name="floor" required id="floor" readonly placeholder="Select a Floor">
    <div class="dropdown-content" data-name="floor">
    </div>
</div>

<div class="input-area dropdown">
    <img src="./img/dropdown.png" alt="arrow">
    <label for="apartment">Apartment</label>
    <input type="text" name="apartment" required id="apartment" readonly placeholder="Select an Apartment">
    <div class="dropdown-content" data-name="apartment">
    </div>
</div>
        </div>



        <div class="report-issue">
            <div class="heading">
                <h4>Report an Issue</h4>
                <img src="./img/error.png" alt="">
            </div>
            <div class="input-area dropdown">
                <img src="./img/dropdown.png" alt="arrow" class="registration">
                <label for="category">Category</label>
                <input type="text" name="Category" required id="category" readonly placeholder="Please Select">
                <div class="dropdown-content" data-name="category">
                    <div class="dropdown-item" data-name="category">Design issue</div>
                    <div class="dropdown-item" data-name="category">Design Seepage</div>
                    <div class="dropdown-item" data-name="category">Damp Issue</div>
                    <div class="dropdown-item" data-name="category">Parking Issue</div>
                    <div class="dropdown-item" data-name="category">Insaficient Ameneties</div>
                    <div class="dropdown-item" data-name="category">Registration Process</div>
                    <div class="dropdown-item" data-name="category">Lack of Maintenance</div>
                </div>
            </div>

            <div class="textarea">
                <label for="details">Details</label>
                <textarea name="details" id="" required></textarea>
            </div>



            <div class="file-input-container">
                <label for="file-upload" class="custom-file-upload">
                    Upload Images
                </label>
                <input type="file" id="fileInput" name="image[]" accept="image/*" multiple>
                <div class="image_file_name">
                    <span class="upload_button">+</span>
                    <div class="upload_box">
                        <p id="fileNames">No file selected</p>
                        <span class="delete_button">X</span>
                    </div>
                </div>
                <button class="btn" type="submit">Submit</button>
            </div>
        </div>
    </form>
    <div id="loader"></div>

  </div>

  <script src="./ajax.js"></script>
  <script src="./main.js"></script>
</body>
</html>
