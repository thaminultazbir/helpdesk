<?php
  require '../db.php';
  require '../functions.php';
  check_auth();

$user = $_SESSION['user'];
$err = '';
?>
<?php  
include("./includes/header.php");
include("./includes/sidenav.php");
?>
<div class="main">
  <?php include("./includes/topbar.php");?>
  </div>
</div>
<?php include("./includes/footer.php"); ?>