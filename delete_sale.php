<?php
  require_once('includes/load.php');
  
  fn_a28(3);
?>
<?php
  $x18 = fn_a15('sales',(int)$_GET['id']);
  if(!$x18){
    $x97->msg("d","Missing sale id.");
    fn_a34('sales.php');
  }
?>
<?php
  $x21 = fn_a7('sales',(int)$x18['id']);
  if($x21){
      $x97->msg("s","sale deleted.");
      fn_a34('sales.php');
  } else {
      $x97->msg("d","sale deletion failed.");
      fn_a34('sales.php');
  }
?>
