<?php
 $x25 = array();

 
 


function fn_a33($x102){
  global $x15;
  $x26 = mysqli_real_escape_string($x15,$x102);
  return $x26;
}



function fn_a35($x102){
  $x102 = nl2br($x102);
  $x102 = htmlspecialchars(strip_tags($x102, ENT_QUOTES));
  return $x102;
}



function fn_a22($x102){
  $x121 = str_replace('-'," ",$x102);
  $x121 = ucfirst($x121);
  return $x121;
}



function fn_a42($x123){
  global $x25;
  foreach ($x123 as $x28) {
    $x121 = fn_a35($_POST[$x28]);
    if(isset($x121) && $x121==''){
      $x25 = $x28 ." can't be blank.";
      return $x25;
    }
  }
}




function fn_a8($x53 =''){
   $x57 = array();
   if(!empty($x53)) {
      foreach ($x53 as $x43 => $x122) {
         $x57  = "<div class=\"alert alert-{$x43}\">";
         $x57 .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
         $x57 .= fn_a35(fn_a22($x122));
         $x57 .= "</div>";
      }
      return $x57;
   } else {
     return "" ;
   }
}



function fn_a34($x113, $x67 = false)
{
    if (headers_sent() === false)
    {
      header('Location: ' . $x113, true, ($x67 === true) ? 301 : 302);
    }

    exit();
}



function fn_a37($x109){
   $x104 = 0;
   $x103 = 0;
   foreach($x109 as $x108 ){
     $x104 += $x108['total_saleing_price'];
     $x103 += $x108['total_buying_price'];
     $x76 = $x104 - $x103;
   }
   return array($x104,$x76);
}



function fn_a32($x102){
     if($x102)
      return date('F j, Y, g:i:s a', strtotime($x102));
     else
      return null;
  }



function fn_a25(){
  return strftime("%Y-%m-%d %H:%M:%S", time());
}



function fn_a4(){
  static $x16 = 1;
  return $x16++;
}



function fn_a31($x44 = 5)
{
  $x102='';
  $x14 = "0123456789abcdefghijklmnopqrstuvwxyz";

  for($x124=0; $x124<$x44; $x124++)
   $x102 .= $x14[mt_rand(0,strlen($x14))];
  return $x102;
}


?>
