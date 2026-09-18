<?php
  require_once('includes/load.php');
  
   fn_a28(1);
?>
<?php
  $x21 = fn_a7('user_groups',(int)$_GET['id']);
  if($x21){
      $x97->msg("s","Group has been deleted.");
      fn_a34('group.php');
  } else {
      $x97->msg("d","Group deletion failed Or Missing Prm.");
      fn_a34('group.php');
  }
?>
