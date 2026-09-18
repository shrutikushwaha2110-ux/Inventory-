<?php
  require_once('includes/load.php');
  
  fn_a28(2);
?>
<?php
  $x69 = fn_a15('products',(int)$_GET['id']);
  if(!$x69){
    $x97->msg("d","Missing Product id.");
    fn_a34('product.php');
  }
?>
<?php
  $x21 = fn_a7('products',(int)$x69['id']);
  if($x21){
      $x97->msg("s","Products deleted.");
      fn_a34('product.php');
  } else {
      $x97->msg("d","Products deletion failed.");
      fn_a34('product.php');
  }
?>
