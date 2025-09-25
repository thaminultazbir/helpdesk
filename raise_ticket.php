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

<?php 
include './includes/header.php';
include './includes/sidenav.php';
?>

    <div class="container">
        <div class="formWrapper">
            <div class="form">
      <!-- <div class="title">Welcome</div> -->
      <div class="subtitle">Let's create your Issue</div>
      <div class="input-container ic1">
        <input id="i_category" class="input" type="text" placeholder=" " />
        <div class="cut"></div>
        <label for="i_category" class="placeholder">Category</label>
      </div>
      <div class="input-container ic2">
        <input id="i_title" class="input" type="text" placeholder=" " />
        <div class="cut"></div>
        <label for="i_title" class="placeholder">Issue Title</label>
      </div>
      <div class="input-container ic2">
        <input id="i_description" class="input" type="text" placeholder=" " />
        <div class="cut cut-short"></div>
        <label for="description" class="placeholder">Description</>
      </div>
      <button type="text" class="submit">submit</button>
    </div>
    </div>
    </div>
</body>

</html>