<?php
 session_start();

class ClassB3 {

 public $x53;
 private $x117 = false;

 function __construct(){
   $this->flash_msg();
   $this->userLoginSetup();
 }

  public function isUserLoggedIn(){
    return $this->x117;
  }
  public function login($x116){
    $_SESSION['user_id'] = $x116;
  }
  private function userLoginSetup()
  {
    if(isset($_SESSION['user_id']))
    {
      $this->x117 = true;
    } else {
      $this->x117 = false;
    }

  }
  public function logout(){
    unset($_SESSION['user_id']);
  }

  public function msg($x110 ='', $x53 =''){
    if(!empty($x53)){
       if(strlen(trim($x110)) == 1){
         $x110 = str_replace( array('d', 'i', 'w','s'), array('danger', 'info', 'warning','success'), $x110 );
       }
       $_SESSION['msg'][$x110] = $x53;
    } else {
      return $this->x53;
    }
  }

  private function flash_msg(){

    if(isset($_SESSION['msg'])) {
      $this->x53 = $_SESSION['msg'];
      unset($_SESSION['msg']);
    } else {
      $this->x53;
    }
  }
}

$x97 = new ClassB3();
$x53 = $x97->msg();

?>
