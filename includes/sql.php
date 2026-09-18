<?php
  require_once('includes/load.php');




function fn_a9($x105) {
   global $x20;
   if(fn_a36($x105))
   {
     return fn_a16("SELECT * FROM ".$x20->escape($x105));
   }
}



function fn_a16($x98)
{
  global $x20;
  $x88 = $x20->query($x98);
  $x89 = $x20->while_loop($x88);
 return $x89;
}



function fn_a15($x105,$x40)
{
  global $x20;
  $x40 = (int)$x40;
    if(fn_a36($x105)){
          $x98 = $x20->query("SELECT * FROM {$x20->escape($x105)} WHERE id='{$x20->escape($x40)}' LIMIT 1");
          if($x88 = $x20->fetch_assoc($x98))
            return $x88;
          else
            return null;
     }
}



function fn_a7($x105,$x40)
{
  global $x20;
  if(fn_a36($x105))
   {
    $x98 = "DELETE FROM ".$x20->escape($x105);
    $x98 .= " WHERE id=". $x20->escape($x40);
    $x98 .= " LIMIT 1";
    $x20->query($x98);
    return ($x20->affected_rows() === 1) ? true : false;
   }
}




function fn_a3($x105){
  global $x20;
  if(fn_a36($x105))
  {
    $x98    = "SELECT COUNT(id) AS total FROM ".$x20->escape($x105);
    $x88 = $x20->query($x98);
     return($x20->fetch_assoc($x88));
  }
}



function fn_a36($x105){
  global $x20;
  $x106 = $x20->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$x20->escape($x105).'"');
      if($x106) {
        if($x20->num_rows($x106) > 0)
              return true;
         else
              return false;
      }
  }
 
 


  function fn_a1($x120='', $x65='') {
    global $x20;
    $x120 = $x20->escape($x120);
    $x65 = $x20->escape($x65);
    $x98  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $x120);
    $x88 = $x20->query($x98);
    if($x20->num_rows($x88)){
      $x114 = $x20->fetch_assoc($x88);
      $x66 = sha1($x65);
      if($x66 === $x114['password'] ){
        return $x114['id'];
      }
    }
   return false;
  }
  
  



   function fn_a2($x120='', $x65='') {
     global $x20;
     $x120 = $x20->escape($x120);
     $x65 = $x20->escape($x65);
     $x98  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $x120);
     $x88 = $x20->query($x98);
     if($x20->num_rows($x88)){
       $x114 = $x20->fetch_assoc($x88);
       $x66 = sha1($x65);
       if($x66 === $x114['password'] ){
         return $x114;
       }
     }
    return false;
   }


  
  

  function fn_a5(){
      static $x17;
      global $x20;
      if(!$x17){
         if(isset($_SESSION['user_id'])):
             $x116 = intval($_SESSION['user_id']);
             $x17 = fn_a15('users',$x116);
        endif;
      }
    return $x17;
  }
  
  


  function fn_a12(){
      global $x20;
      $x90 = array();
      $x98 = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,";
      $x98 .="g.group_name ";
      $x98 .="FROM users u ";
      $x98 .="LEFT JOIN user_groups g ";
      $x98 .="ON g.group_level=u.user_level ORDER BY u.name ASC";
      $x88 = fn_a16($x98);
      return $x88;
  }
  
  


 function fn_a38($x116)
	{
		global $x20;
    $x19 = fn_a25();
    $x98 = "UPDATE users SET last_login='{$x19}' WHERE id ='{$x116}' LIMIT 1";
    $x88 = $x20->query($x98);
    return ($x88 && $x20->affected_rows() === 1 ? true : false);
	}

  
  

  function fn_a14($x121)
  {
    global $x20;
    $x98 = "SELECT group_name FROM user_groups WHERE group_name = '{$x20->escape($x121)}' LIMIT 1 ";
    $x88 = $x20->query($x98);
    return($x20->num_rows($x88) === 0 ? true : false);
  }
  
  

  function fn_a13($x45)
  {
    global $x20;
    $x98 = "SELECT group_level FROM user_groups WHERE group_level = '{$x20->escape($x45)}' LIMIT 1 ";
    $x88 = $x20->query($x98);
    return($x20->num_rows($x88) === 0 ? true : false);
  }
  
  

   function fn_a28($x87){
     global $x97;
     $x17 = fn_a5();
     $x47 = fn_a13($x17['user_level']);
     
     if (!$x97->isUserLoggedIn(true)):
            $x97->msg('d','Please login...');
            fn_a34('index.php', false);
      
     elseif($x47['group_status'] === '0'):
           $x97->msg('d','This level user has been band!');
           fn_a34('home.php',false);
      
     elseif($x17['user_level'] <= (int)$x87):
              return true;
      else:
            $x97->msg("d", "Sorry! you dont have permission to view the page.");
            fn_a34('home.php', false);
        endif;

     }
   
   


  function fn_a24(){
     global $x20;
     $x98  =" SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.media_id,p.date,c.name";
    $x98  .=" AS categorie,m.file_name AS image";
    $x98  .=" FROM products p";
    $x98  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
    $x98  .=" LEFT JOIN media m ON m.id = p.media_id";
    $x98  .=" ORDER BY p.id ASC";
    return fn_a16($x98);

   }
  
  



  function fn_a43($x126){
     global $x20;
     $x126 = (int)$x126;
     $x98  =" SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.media_id,p.date,c.name";
    $x98  .=" AS categorie,m.file_name AS image";
    $x98  .=" FROM products p";
    $x98  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
    $x98  .=" LEFT JOIN media m ON m.id = p.media_id";
    $x98  .=" WHERE CAST(p.quantity AS SIGNED) <= '{$x126}'";
    $x98  .=" ORDER BY CAST(p.quantity AS SIGNED) ASC, p.id ASC";
    return fn_a16($x98);

   }
  
  


   function fn_a18($x71){
     global $x20;
     $x61 = fn_a35($x20->escape($x71));
     $x98 = "SELECT name FROM products WHERE name like '%$x61%' LIMIT 5";
     $x88 = fn_a16($x98);
     return $x88;
   }

  
  


  function fn_a10($x107){
    global $x20;
    $x98  = "SELECT * FROM products ";
    $x98 .= " WHERE name ='{$x107}'";
    $x98 .=" LIMIT 1";
    return fn_a16($x98);
  }

  
  

  function fn_a39($x77,$x60){
    global $x20;
    $x77 = (int) $x77;
    $x40  = (int)$x60;
    $x98 = "UPDATE products SET quantity=quantity -'{$x77}' WHERE id = '{$x40}'";
    $x88 = $x20->query($x98);
    return($x20->affected_rows() === 1 ? true : false);

  }
  
  

 function fn_a19($x46){
   global $x20;
   $x98   = " SELECT p.id,p.name,p.sale_price,p.media_id,c.name AS categorie,";
   $x98  .= "m.file_name AS image FROM products p";
   $x98  .= " LEFT JOIN categories c ON c.id = p.categorie_id";
   $x98  .= " LEFT JOIN media m ON m.id = p.media_id";
   $x98  .= " ORDER BY p.id DESC LIMIT ".$x20->escape((int)$x46);
   return fn_a16($x98);
 }
 
 

 function fn_a17($x46){
   global $x20;
   $x98  = "SELECT p.name, COUNT(s.product_id) AS totalSold, SUM(s.qty) AS totalQty";
   $x98 .= " FROM sales s";
   $x98 .= " LEFT JOIN products p ON p.id = s.product_id ";
   $x98 .= " GROUP BY s.product_id";
   $x98 .= " ORDER BY SUM(s.qty) DESC LIMIT ".$x20->escape((int)$x46);
   return $x20->query($x98);
 }
 
 

 function fn_a11(){
   global $x20;
   $x98  = "SELECT s.id,s.qty,s.price,s.date,p.name";
   $x98 .= " FROM sales s";
   $x98 .= " LEFT JOIN products p ON s.product_id = p.id";
   $x98 .= " ORDER BY s.date DESC";
   return fn_a16($x98);
 }
 
 

function fn_a20($x46){
  global $x20;
  $x98  = "SELECT s.id,s.qty,s.price,s.date,p.name";
  $x98 .= " FROM sales s";
  $x98 .= " LEFT JOIN products p ON s.product_id = p.id";
  $x98 .= " ORDER BY s.date DESC LIMIT ".$x20->escape((int)$x46);
  return fn_a16($x98);
}



function fn_a21($x99,$x24){
  global $x20;
  $x99  = date("Y-m-d", strtotime($x99));
  $x24    = date("Y-m-d", strtotime($x24));
  $x98  = "SELECT s.date, p.name,p.sale_price,p.buy_price,";
  $x98 .= "COUNT(s.product_id) AS total_records,";
  $x98 .= "SUM(s.qty) AS total_sales,";
  $x98 .= "SUM(p.sale_price * s.qty) AS total_saleing_price,";
  $x98 .= "SUM(p.buy_price * s.qty) AS total_buying_price ";
  $x98 .= "FROM sales s ";
  $x98 .= "LEFT JOIN products p ON s.product_id = p.id";
  $x98 .= " WHERE s.date BETWEEN '{$x99}' AND '{$x24}'";
  $x98 .= " GROUP BY DATE(s.date),p.name";
  $x98 .= " ORDER BY DATE(s.date) DESC";
  return $x20->query($x98);
}



function  fn_a6($x125,$x52){
  global $x20;
  $x98  = "SELECT s.qty,";
  $x98 .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
  $x98 .= "SUM(p.sale_price * s.qty) AS total_saleing_price";
  $x98 .= " FROM sales s";
  $x98 .= " LEFT JOIN products p ON s.product_id = p.id";
  $x98 .= " WHERE DATE_FORMAT(s.date, '%Y-%m' ) = '{$x125}-{$x52}'";
  $x98 .= " GROUP BY DATE_FORMAT( s.date,  '%e' ),s.product_id";
  return fn_a16($x98);
}



function  fn_a27($x125){
  global $x20;
  $x98  = "SELECT s.qty,";
  $x98 .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
  $x98 .= "SUM(p.sale_price * s.qty) AS total_saleing_price";
  $x98 .= " FROM sales s";
  $x98 .= " LEFT JOIN products p ON s.product_id = p.id";
  $x98 .= " WHERE DATE_FORMAT(s.date, '%Y' ) = '{$x125}'";
  $x98 .= " GROUP BY DATE_FORMAT( s.date,  '%c' ),s.product_id";
  $x98 .= " ORDER BY date_format(s.date, '%c' ) ASC";
  return fn_a16($x98);
}



function fn_a44($x128){
  global $x20;
  $x128 = (int)$x128;
  $x98  = " SELECT ps.id,ps.product_id,ps.location_id,ps.quantity,";
  $x98 .= "l.name AS location_name";
  $x98 .= " FROM product_stock ps";
  $x98 .= " LEFT JOIN locations l ON l.id = ps.location_id";
  $x98 .= " WHERE ps.product_id = '{$x128}'";
  $x98 .= " ORDER BY l.name ASC";
  return fn_a16($x98);
}



function fn_a45($x126){
  global $x20;
  $x126 = (int)$x126;
  $x98  = " SELECT ps.id,ps.quantity,p.id AS product_id,p.name AS product_name,";
  $x98 .= "l.id AS location_id,l.name AS location_name";
  $x98 .= " FROM product_stock ps";
  $x98 .= " LEFT JOIN products p ON p.id = ps.product_id";
  $x98 .= " LEFT JOIN locations l ON l.id = ps.location_id";
  $x98 .= " WHERE CAST(ps.quantity AS SIGNED) <= '{$x126}'";
  $x98 .= " ORDER BY CAST(ps.quantity AS SIGNED) ASC, p.id ASC";
  return fn_a16($x98);
}



function fn_a46($x129,$x130,$x131,$x132){
  global $x20;
  $x129 = (int)$x129;
  $x130 = (int)$x130;
  $x131 = (int)$x131;
  $x132 = (int)$x132;
  $x19  = fn_a25();

  $x98  = "INSERT INTO product_stock (product_id,location_id,quantity) VALUES";
  $x98 .= " ('{$x129}','{$x130}','-{$x132}')";
  $x98 .= " ON DUPLICATE KEY UPDATE quantity = quantity - '{$x132}'";
  $x88 = $x20->query($x98);

  $x98  = "INSERT INTO product_stock (product_id,location_id,quantity) VALUES";
  $x98 .= " ('{$x129}','{$x131}','{$x132}')";
  $x98 .= " ON DUPLICATE KEY UPDATE quantity = quantity + '{$x132}'";
  $x89 = $x20->query($x98);

  $x98  = "INSERT INTO transfers (";
  $x98 .= " product_id,source_location_id,destination_location_id,qty,date";
  $x98 .= ") VALUES (";
  $x98 .= "'{$x129}','{$x130}','{$x131}','{$x132}','{$x19}'";
  $x98 .= ")";
  $x90 = $x20->query($x98);

  return ($x88 && $x89 && $x90) ? true : false;
}



function fn_a47(){
  global $x20;
  $x98  = "SELECT t.id,t.qty,t.date,p.name AS product_name,";
  $x98 .= "ls.name AS source_name,ld.name AS destination_name";
  $x98 .= " FROM transfers t";
  $x98 .= " LEFT JOIN products p ON p.id = t.product_id";
  $x98 .= " LEFT JOIN locations ls ON ls.id = t.source_location_id";
  $x98 .= " LEFT JOIN locations ld ON ld.id = t.destination_location_id";
  $x98 .= " ORDER BY t.date DESC";
  return fn_a16($x98);
}



function fn_a48(){
  global $x20;
  $x98  = " SELECT ps.id,ps.quantity,p.name AS product_name,l.name AS location_name";
  $x98 .= " FROM product_stock ps";
  $x98 .= " LEFT JOIN products p ON p.id = ps.product_id";
  $x98 .= " LEFT JOIN locations l ON l.id = ps.location_id";
  $x98 .= " ORDER BY p.name ASC, l.name ASC";
  return fn_a16($x98);
}



function fn_a49($x128,$x130){
  global $x20;
  $x128 = (int)$x128;
  $x130 = (int)$x130;
  $x98  = "SELECT quantity FROM product_stock";
  $x98 .= " WHERE product_id = '{$x128}' AND location_id = '{$x130}' LIMIT 1";
  $x88 = $x20->query($x98);
  $x89 = $x20->fetch_assoc($x88);
  return $x89 ? (int)$x89['quantity'] : 0;
}

?>
