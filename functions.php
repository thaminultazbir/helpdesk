<?php
function check_auth() {
    session_start();
    if(!isset($_SESSION['user'])) {
        header('Location: /helpdesk/login.php');
        exit;
    }
}
function is_admin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}
function h($s){ return htmlspecialchars($s, ENT_QUOTES); }
?>