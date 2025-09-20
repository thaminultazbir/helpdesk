<?php
require 'db.php';
require 'functions.php';
check_auth();
$user = $_SESSION['user'];
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $title = $_POST['title'] ?? '';
    $category = $_POST['category'] ?? '';
    $description = $_POST['description'] ?? '';
    $status = 'Pending';
    $imgpath = null;
    if(!empty($_FILES['image']['name'])){
        $tgt = 'uploads/'.time().'_'.basename($_FILES['image']['name']);
        if(move_uploaded_file($_FILES['image']['tmp_name'], $tgt)) $imgpath = $tgt;
    }
    $stmt = $pdo->prepare("INSERT INTO tickets (user_id,title,category,description,image,status,created_at) VALUES (?,?,?,?,?,?,NOW())");
    $stmt->execute([$user['id'],$title,$category,$description,$imgpath,$status]);
    header('Location: user_dashboard.php');
    exit;
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Create Ticket</title><link rel="stylesheet" href="style.css"></head><body>
<div class="card"><h2>Create Ticket</h2>
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
</div></body></html>