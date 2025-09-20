<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $employee_id = $_POST['employee_id'];

    $stmt = $pdo->prepare("INSERT INTO support_staff (name, phone, employee_id) VALUES (?, ?, ?)");
    $stmt->execute([$name, $phone, $employee_id]);

    $success = "Support staff created successfully!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Support Staff</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Create Support Staff</h2>
        <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>
        <form method="POST">
            <label>Name:</label><br>
            <input type="text" name="name" required><br>
            <label>Phone:</label><br>
            <input type="text" name="phone" required><br>
            <label>Employee ID:</label><br>
            <input type="text" name="employee_id" required><br><br>
            <button type="submit">Create Staff</button>
        </form>
        <br>
        <a href="admin_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
