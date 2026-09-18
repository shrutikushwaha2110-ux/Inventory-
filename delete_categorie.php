<?php
  require_once('includes/load.php');
  
  fn_a28(1);
?>
<?php
  $x13 = fn_a15('categories',(int)$_GET['id']);
  if(!$x13){
    $x97->msg("d","Missing Categorie id.");
    fn_a34('categorie.php');
  }
?>
<?php
  $x21 = fn_a7('categories',(int)$x13['id']);
  if($x21){
      $x97->msg("s","Categorie deleted.");
      fn_a34('categorie.php');
  } else {
      $x97->msg("d","Categorie deletion failed.");
      fn_a34('categorie.php');
  }
?>
