<?php
require 'db.php';
require 'functions.php';
check_auth();
$user = $_SESSION['user'];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $ticket = $_POST['ticket_id'];
    $msg = $_POST['message'];
    $stmt = $pdo->prepare("INSERT INTO comments (ticket_id,user_id,message,created_at) VALUES (?,?,?,NOW())");
    $stmt->execute([$ticket,$user['id'],$msg]);
}
header("Location: view_ticket.php?id=".$ticket);
?>