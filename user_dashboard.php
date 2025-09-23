<?php
    require 'db.php';
    require 'functions.php';
    check_auth();
    $user = $_SESSION['user'];
    // fetch user's tickets
    $stmt = $pdo->prepare("SELECT * FROM tickets WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user['id']]);
    $tickets = $stmt->fetchAll();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="./assets/images/logo.png" alt="logo" />
            <h2>RPL</h2>
        </div>
        <ul class="sidebar-links">
            <h4>
                <span>Main Menu</span>
                <div class="menu-separator"></div>
            </h4>
            <li>
                <a href="./user_dashboard.php">
                    <span class="material-symbols-outlined">
                        dashboard
                    </span>Home
                </a>
            </li>
            <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        overview
                    </span>Raise Ticket
                </a>
            </li>
            <!-- <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        monitoring
                    </span>Analytics
                </a>
            </li> -->
            <!-- <h4>
                <span>General</span>
                <div class="menu-separator"></div>
            </h4> -->
            <!-- <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        folder
                    </span>Projects
                </a>
            </li>
            <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        groups
                    </span>Groups
                </a>
            </li>
            <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        move_up
                    </span>Transfer
                </a>
            </li>
            <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        flag
                    </span>All Reports
                </a>
            </li>
            <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        notifications_active
                    </span>Notifications
                </a>
            </li> -->
            <h4>
                <span>Account</span>
                <div class="menu-separator"></div>

            </h4>
            <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        account_circle
                    </span>Profile
                </a>
            </li>
            <!-- <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        settings
                    </span>Settings
                </a>
            </li> -->
            <li>
                <a href="./logout.php">
                    <span class="material-symbols-outlined">
                        logout
                    </span>Logout
                </a>
            </li>
        </ul>
        <div class="user-account">
            <div class="user-profile">
                <img src="./assets/images/profile.png" alt="">
                <div class="user-details">
                    <h3 style="text-transform: capitalize;"><?=h($user['name'])?></h3>
                    <!-- <span>Web Developer</span> -->
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="wrapper">
            <?php if(!$tickets) echo '<p>No tickets yet.</p>'; ?>
            <table>
                <caption>
                    Your Tickets
                </caption>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Create At</th>
                </tr>
                <?php foreach($tickets as $t): ?>

                <tr>
                    <td data-cell="id"><?=h($t['id'])?></td>
                    <td data-cell="category"><?=h($t['category'])?></td>
                    <td data-cell="title"><?=h($t['title'])?></td>
                    <td data-cell="status"><?=h($t['status'])?></td>
                    <td data-cell="create at"><?=h($t['created_at'])?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>

</html>