<?php
require 'db.php';
require 'functions.php';
check_auth();
$user = $_SESSION['user'];
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $category = $_POST['category'] ?? '';
    $description = $_POST['description'] ?? '';
    $status = 'Pending';
    $imgpath = null;

    // Handle image upload with compression
    if (!empty($_FILES['image']['name'])) {
        $targetDir = 'uploads/';
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $fileName;

        // Get image properties
        $imageType = $_FILES['image']['type'];
        $imageTmpName = $_FILES['image']['tmp_name'];

        // Check if the uploaded file is an image
        if (in_array($imageType, ['image/jpeg', 'image/png', 'image/gif'])) {
            // Create image resource based on type
            if ($imageType == 'image/jpeg') {
                $image = imagecreatefromjpeg($imageTmpName);  // JPEG image
            } elseif ($imageType == 'image/png') {
                $image = imagecreatefrompng($imageTmpName);  // PNG image
            } elseif ($imageType == 'image/gif') {
                $image = imagecreatefromgif($imageTmpName);  // GIF image
            }

            // Compress the image
            if ($image) {
                // Resize if necessary (optional: based on max width/height)
                $maxWidth = 800; // Max width for image resizing
                $maxHeight = 600; // Max height for image resizing
                list($width, $height) = getimagesize($imageTmpName);
                $aspectRatio = $width / $height;
                
                if ($width > $maxWidth || $height > $maxHeight) {
                    if ($aspectRatio > 1) {
                        $newWidth = $maxWidth;
                        $newHeight = $maxWidth / $aspectRatio;
                    } else {
                        $newHeight = $maxHeight;
                        $newWidth = $maxHeight * $aspectRatio;
                    }

                    // Create a new image with the resized dimensions
                    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
                    imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                    $image = $resizedImage;
                }

                // Save the compressed image (JPEG with 75% quality for good compression)
                if ($imageType == 'image/jpeg') {
                    imagejpeg($image, $targetFile, 75);  // Save JPEG image with compression
                } elseif ($imageType == 'image/png') {
                    imagepng($image, $targetFile, 6);  // Save PNG image with compression
                } elseif ($imageType == 'image/gif') {
                    imagegif($image, $targetFile);  // Save GIF image
                }

                // Free memory
                imagedestroy($image);

                // Set image path
                $imgpath = $targetFile;
            } else {
                $err = "Failed to process image.";
            }
        } else {
            $err = "Only image files are allowed.";
        }
    }

    // Insert into the database
    if (empty($err)) {
        $stmt = $pdo->prepare("INSERT INTO tickets (user_id, title, category, description, image, status, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$user['id'], $title, $category, $description, $imgpath, $status]);
        header('Location: user_dashboard.php');
        exit;
    }
}
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Create Ticket</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="card">
      <h2>Create Ticket</h2>
      <?php if ($err): ?>
        <p style="color: red;"><?= h($err) ?></p>
      <?php endif; ?>
      <form method="post" enctype="multipart/form-data">
        <label>Title</label><input name="title" required>
        <label>Category</label>
        <select name="category" required>
          <option>Lift Problem</option>
          <option>Water Leakage</option>
          <option>Parking Problem</option>
          <option>Other</option>
        </select>
        <label>Description</label><textarea name="description" rows="5"></textarea>
        <label>Reference Image (optional)</label><input type="file" name="image" accept="image/*">
        <button>Create Ticket</button>
      </form>
      <div><a href="user_dashboard.php">Back</a></div>
    </div>
  </body>
</html>
