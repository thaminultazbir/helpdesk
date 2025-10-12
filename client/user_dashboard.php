<?php
    require '../db.php';
    require '../functions.php';
    check_auth();
    $user = $_SESSION['user'];
    // fetch user's tickets
    $stmt = $pdo->prepare("SELECT * FROM tickets WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user['id']]);
    $tickets = $stmt->fetchAll();
?>

<?php 
include './includes/header.php';
include './includes/sidenav.php';
?>

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