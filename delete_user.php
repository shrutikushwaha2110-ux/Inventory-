<?php
  require_once('includes/load.php');
  
   fn_a28(1);
?>
<?php
  $x21 = fn_a7('users',(int)$_GET['id']);
  if($x21){
      $x97->msg("s","User deleted.");
      fn_a34('users.php');
  } else {
      $x97->msg("d","User deletion failed Or Missing Prm.");
      fn_a34('users.php');
  }
?>
