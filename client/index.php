




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
      <!-- <p class="msg"> Lorem ipsum dolor sit amet, consectetur adipiscing 
elit, sed do eiusmod tempor incididunt ut labore et 
dolore magna aliqua.</p> -->
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
            <label for="name">Contact</label>
            <input type="number" name="contact" required>
        </div>
        <div class="input-area">
            <label for="name">Building Name</label>
            <input type="text" name="buildingName" required>
        </div>
        <div class="input-area">
            <label for="name">Floor</label>
            <input type="text" name="floor">
        </div>

        <div class="input-area">
            <label for="name">Appartment</label>
            <input type="text" name="appartment" required>
        </div>
        </div>



        <div class="report-issue">
            <div class="heading">
                <h4>Report an Issue</h4>
                <img src="./img/error.png" alt="">
            </div>
            <div class="input-area">
                <label for="Category">Category</label>
                <input type="text" name="category" required>
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

  <script src="./main.js"></script>
</body>
</html>
