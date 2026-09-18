<?php
  require_once('includes/load.php');
  
  fn_a28(2);
?>
<?php
  $x35 = fn_a15('media',(int)$_GET['id']);
  $x68 = new ClassB1();
  if($x68->fn_a26($x35['id'],$x35['file_name'])){
      $x97->msg("s","Photo has been deleted.");
      fn_a34('media.php');
  } else {
      $x97->msg("d","Photo deletion failed Or Missing Prm.");
      fn_a34('media.php');
  }
?>
