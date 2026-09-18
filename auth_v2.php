<?php include_once('includes/load.php'); ?>
<?php
$x86 = array('username','password' );
fn_a42($x86);
$x120 = fn_a35($_POST['username']);
$x65 = fn_a35($_POST['password']);

  if(empty($x25)){

    $x114 = fn_a2($x120, $x65);

        if($x114):
           
           $x97->login($x114['id']);
           
           fn_a38($x114['id']);
           
           if($x114['user_level'] === '1'):
             $x97->msg("s", "Hello ".$x114['username'].", Welcome to OSWA-INV.");
             fn_a34('admin.php',false);
           elseif ($x114['user_level'] === '2'):
              $x97->msg("s", "Hello ".$x114['username'].", Welcome to OSWA-INV.");
             fn_a34('special.php',false);
           else:
              $x97->msg("s", "Hello ".$x114['username'].", Welcome to OSWA-INV.");
             fn_a34('home.php',false);
           endif;

        else:
          $x97->msg("d", "Sorry Username/Password incorrect.");
          fn_a34('index.php',false);
        endif;

  } else {

     $x97->msg("d", $x25);
     fn_a34('login_v2.php',false);
  }

?>
