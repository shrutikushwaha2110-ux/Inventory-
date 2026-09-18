<?php
require_once(LIB_PATH_INC.DS."config.php");

class ClassB2 {

    private $x15;
    public $x79;

    function __construct() {
      $this->db_connect();
    }




public function db_connect()
{
  $this->x15 = mysqli_connect(DB_HOST,DB_USER,DB_PASS);
  if(!$this->x15)
         {
           die(" Database connection failed:". mysqli_connect_error());
         } else {
           $x96 = $this->x15->select_db(DB_NAME);
             if(!$x96)
             {
               die("Failed to Select Database". mysqli_connect_error());
             }
         }
}




public function db_disconnect()
{
  if(isset($this->x15))
  {
    mysqli_close($this->x15);
    unset($this->x15);
  }
}



public function query($x98)
   {

      if (trim($x98 != "")) {
          $this->x79 = $this->x15->query($x98);
      }
      if (!$this->x79)
        
              die("Error on this Query :<pre> " . $x98 ."</pre>");
       
        

       return $this->x79;

   }




public function fetch_array($x100)
{
  return mysqli_fetch_array($x100);
}
public function fetch_object($x100)
{
  return mysqli_fetch_object($x100);
}
public function fetch_assoc($x100)
{
  return mysqli_fetch_assoc($x100);
}
public function num_rows($x100)
{
  return mysqli_num_rows($x100);
}
public function insert_id()
{
  return mysqli_insert_id($this->x15);
}
public function affected_rows()
{
  return mysqli_affected_rows($this->x15);
}

 


 public function escape($x102){
   return $this->x15->real_escape_string($x102);
 }



public function while_loop($x48){
 global $x20;
   $x90 = array();
   while ($x88 = $this->fetch_array($x48)) {
      $x90[] = $x88;
   }
 return $x90;
}

}

$x20 = new ClassB2();

?>
