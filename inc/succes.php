<?php
// session_start();
if(isset($_SESSION['success'])){
    foreach($_SESSION['success'] as $succ){?>

      <div class="alert alert-success"><?php echo $succ ?></div>
    <?php }
    unset($_SESSION['success']);
  }
?>