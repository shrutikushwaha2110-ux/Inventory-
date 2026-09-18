<?php include_once('includes/load.php'); ?>
<?php
$x86 = array('username','password' );
fn_a42($x86);
$x120 = fn_a35($_POST['username']);
$x65 = fn_a35($_POST['password']);

if(empty($x25)){
  $x116 = fn_a1($x120, $x65);
  if($x116){
    
     $x97->login($x116);
    
     fn_a38($x116);
     $x97->msg("s", "Welcome to OSWA-INV.");
     fn_a34('home.php',false);

  } else {
    $x97->msg("d", "Sorry Username/Password incorrect.");
    fn_a34('index.php',false);
  }

} else {
   $x97->msg("d", $x25);
   fn_a34('index.php',false);
}

?>
