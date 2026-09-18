# Low-Stock Alert Feature — Diff & Test Report

Generated: 2026-09-17 05:11 UTC

Scope: this file covers only the low-stock alert feature. The full `git diff`
also shows ~56 unrelated files that already differed from HEAD before this
work started (an uncommitted obfuscation pass applied earlier to the whole
repo). Those are excluded below; only files touched for this feature are shown.

---

## 1. Git diff (files changed for this feature)

```diff
diff --git a/includes/config.php b/includes/config.php
index ad56918..2375cc6 100644
--- a/includes/config.php
+++ b/includes/config.php
@@ -1,20 +1,22 @@
 <?php
-/*
-|--------------------------------------------------------------------------
-| OWSA-INV V2
-|--------------------------------------------------------------------------
-| Author: Siamon Hasan
-| Project Name: OSWA-INV
-| Version: v2
-| Offcial page: http://oswapp.com/
-| facebook Page: https://www.facebook.com/oswapp
-|
-|
-|
-*/
-  define( 'DB_HOST', 'localhost' );          // Set database host
-  define( 'DB_USER', 'admin' );             // Set database user
-  define( 'DB_PASS', 'root' );             // Set database password
-  define( 'DB_NAME', 'oswa_inv' );        // Set database name
+
+
+
+
+
+
+
+
+
+
+
+
+
+  define( 'DB_HOST', 'localhost' );          
+  define( 'DB_USER', 'admin' );             
+  define( 'DB_PASS', 'root' );             
+  define( 'DB_NAME', 'oswa_inv' );        
+
+  define( 'LOW_STOCK_THRESHOLD', 10 );    
 
 ?>
diff --git a/includes/sql.php b/includes/sql.php
index 6b662ba..c10bb5f 100644
--- a/includes/sql.php
+++ b/includes/sql.php
@@ -1,354 +1,371 @@
 <?php
   require_once('includes/load.php');
 
-/*--------------------------------------------------------------*/
-/* Function for find all database table rows by table name
-/*--------------------------------------------------------------*/
-function find_all($table) {
-   global $db;
-   if(tableExists($table))
+
+
+
+function fn_a9($x105) {
+   global $x20;
+   if(fn_a36($x105))
    {
-     return find_by_sql("SELECT * FROM ".$db->escape($table));
+     return fn_a16("SELECT * FROM ".$x20->escape($x105));
    }
 }
-/*--------------------------------------------------------------*/
-/* Function for Perform queries
-/*--------------------------------------------------------------*/
-function find_by_sql($sql)
+
+
+
+function fn_a16($x98)
 {
-  global $db;
-  $result = $db->query($sql);
-  $result_set = $db->while_loop($result);
- return $result_set;
+  global $x20;
+  $x88 = $x20->query($x98);
+  $x89 = $x20->while_loop($x88);
+ return $x89;
 }
-/*--------------------------------------------------------------*/
-/*  Function for Find data from table by id
-/*--------------------------------------------------------------*/
-function find_by_id($table,$id)
+
+
+
+function fn_a15($x105,$x40)
 {
-  global $db;
-  $id = (int)$id;
-    if(tableExists($table)){
-          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
-          if($result = $db->fetch_assoc($sql))
-            return $result;
+  global $x20;
+  $x40 = (int)$x40;
+    if(fn_a36($x105)){
+          $x98 = $x20->query("SELECT * FROM {$x20->escape($x105)} WHERE id='{$x20->escape($x40)}' LIMIT 1");
+          if($x88 = $x20->fetch_assoc($x98))
+            return $x88;
           else
             return null;
      }
 }
-/*--------------------------------------------------------------*/
-/* Function for Delete data from table by id
-/*--------------------------------------------------------------*/
-function delete_by_id($table,$id)
+
+
+
+function fn_a7($x105,$x40)
 {
-  global $db;
-  if(tableExists($table))
+  global $x20;
+  if(fn_a36($x105))
    {
-    $sql = "DELETE FROM ".$db->escape($table);
-    $sql .= " WHERE id=". $db->escape($id);
-    $sql .= " LIMIT 1";
-    $db->query($sql);
-    return ($db->affected_rows() === 1) ? true : false;
+    $x98 = "DELETE FROM ".$x20->escape($x105);
+    $x98 .= " WHERE id=". $x20->escape($x40);
+    $x98 .= " LIMIT 1";
+    $x20->query($x98);
+    return ($x20->affected_rows() === 1) ? true : false;
    }
 }
-/*--------------------------------------------------------------*/
-/* Function for Count id  By table name
-/*--------------------------------------------------------------*/
 
-function count_by_id($table){
-  global $db;
-  if(tableExists($table))
+
+
+
+function fn_a3($x105){
+  global $x20;
+  if(fn_a36($x105))
   {
-    $sql    = "SELECT COUNT(id) AS total FROM ".$db->escape($table);
-    $result = $db->query($sql);
-     return($db->fetch_assoc($result));
+    $x98    = "SELECT COUNT(id) AS total FROM ".$x20->escape($x105);
+    $x88 = $x20->query($x98);
+     return($x20->fetch_assoc($x88));
   }
 }
-/*--------------------------------------------------------------*/
-/* Determine if database table exists
-/*--------------------------------------------------------------*/
-function tableExists($table){
-  global $db;
-  $table_exit = $db->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$db->escape($table).'"');
-      if($table_exit) {
-        if($db->num_rows($table_exit) > 0)
+
+
+
+function fn_a36($x105){
+  global $x20;
+  $x106 = $x20->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$x20->escape($x105).'"');
+      if($x106) {
+        if($x20->num_rows($x106) > 0)
               return true;
          else
               return false;
       }
   }
- /*--------------------------------------------------------------*/
- /* Login with the data provided in $_POST,
- /* coming from the login form.
-/*--------------------------------------------------------------*/
-  function authenticate($username='', $password='') {
-    global $db;
-    $username = $db->escape($username);
-    $password = $db->escape($password);
-    $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
-    $result = $db->query($sql);
-    if($db->num_rows($result)){
-      $user = $db->fetch_assoc($result);
-      $password_request = sha1($password);
-      if($password_request === $user['password'] ){
-        return $user['id'];
+ 
+ 
+
+
+  function fn_a1($x120='', $x65='') {
+    global $x20;
+    $x120 = $x20->escape($x120);
+    $x65 = $x20->escape($x65);
+    $x98  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $x120);
+    $x88 = $x20->query($x98);
+    if($x20->num_rows($x88)){
+      $x114 = $x20->fetch_assoc($x88);
+      $x66 = sha1($x65);
+      if($x66 === $x114['password'] ){
+        return $x114['id'];
       }
     }
    return false;
   }
-  /*--------------------------------------------------------------*/
-  /* Login with the data provided in $_POST,
-  /* coming from the login_v2.php form.
-  /* If you used this method then remove authenticate function.
- /*--------------------------------------------------------------*/
-   function authenticate_v2($username='', $password='') {
-     global $db;
-     $username = $db->escape($username);
-     $password = $db->escape($password);
-     $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
-     $result = $db->query($sql);
-     if($db->num_rows($result)){
-       $user = $db->fetch_assoc($result);
-       $password_request = sha1($password);
-       if($password_request === $user['password'] ){
-         return $user;
+  
+  
+
+
+
+   function fn_a2($x120='', $x65='') {
+     global $x20;
+     $x120 = $x20->escape($x120);
+     $x65 = $x20->escape($x65);
+     $x98  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $x120);
+     $x88 = $x20->query($x98);
+     if($x20->num_rows($x88)){
+       $x114 = $x20->fetch_assoc($x88);
+       $x66 = sha1($x65);
+       if($x66 === $x114['password'] ){
+         return $x114;
        }
      }
     return false;
    }
 
 
-  /*--------------------------------------------------------------*/
-  /* Find current log in user by session id
-  /*--------------------------------------------------------------*/
-  function current_user(){
-      static $current_user;
-      global $db;
-      if(!$current_user){
+  
+  
+
+  function fn_a5(){
+      static $x17;
+      global $x20;
+      if(!$x17){
          if(isset($_SESSION['user_id'])):
-             $user_id = intval($_SESSION['user_id']);
-             $current_user = find_by_id('users',$user_id);
+             $x116 = intval($_SESSION['user_id']);
+             $x17 = fn_a15('users',$x116);
         endif;
       }
-    return $current_user;
+    return $x17;
   }
-  /*--------------------------------------------------------------*/
-  /* Find all user by
-  /* Joining users table and user gropus table
-  /*--------------------------------------------------------------*/
-  function find_all_user(){
-      global $db;
-      $results = array();
-      $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,";
-      $sql .="g.group_name ";
-      $sql .="FROM users u ";
-      $sql .="LEFT JOIN user_groups g ";
-      $sql .="ON g.group_level=u.user_level ORDER BY u.name ASC";
-      $result = find_by_sql($sql);
-      return $result;
+  
+  
+
+
+  function fn_a12(){
+      global $x20;
+      $x90 = array();
+      $x98 = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login,";
+      $x98 .="g.group_name ";
+      $x98 .="FROM users u ";
+      $x98 .="LEFT JOIN user_groups g ";
+      $x98 .="ON g.group_level=u.user_level ORDER BY u.name ASC";
+      $x88 = fn_a16($x98);
+      return $x88;
   }
-  /*--------------------------------------------------------------*/
-  /* Function to update the last log in of a user
-  /*--------------------------------------------------------------*/
+  
+  
+
 
- function updateLastLogIn($user_id)
+ function fn_a38($x116)
 	{
-		global $db;
-    $date = make_date();
-    $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
-    $result = $db->query($sql);
-    return ($result && $db->affected_rows() === 1 ? true : false);
+		global $x20;
+    $x19 = fn_a25();
+    $x98 = "UPDATE users SET last_login='{$x19}' WHERE id ='{$x116}' LIMIT 1";
+    $x88 = $x20->query($x98);
+    return ($x88 && $x20->affected_rows() === 1 ? true : false);
 	}
 
-  /*--------------------------------------------------------------*/
-  /* Find all Group name
-  /*--------------------------------------------------------------*/
-  function find_by_groupName($val)
+  
+  
+
+  function fn_a14($x121)
   {
-    global $db;
-    $sql = "SELECT group_name FROM user_groups WHERE group_name = '{$db->escape($val)}' LIMIT 1 ";
-    $result = $db->query($sql);
-    return($db->num_rows($result) === 0 ? true : false);
+    global $x20;
+    $x98 = "SELECT group_name FROM user_groups WHERE group_name = '{$x20->escape($x121)}' LIMIT 1 ";
+    $x88 = $x20->query($x98);
+    return($x20->num_rows($x88) === 0 ? true : false);
   }
-  /*--------------------------------------------------------------*/
-  /* Find group level
-  /*--------------------------------------------------------------*/
-  function find_by_groupLevel($level)
+  
+  
+
+  function fn_a13($x45)
   {
-    global $db;
-    $sql = "SELECT group_level FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1 ";
-    $result = $db->query($sql);
-    return($db->num_rows($result) === 0 ? true : false);
+    global $x20;
+    $x98 = "SELECT group_level FROM user_groups WHERE group_level = '{$x20->escape($x45)}' LIMIT 1 ";
+    $x88 = $x20->query($x98);
+    return($x20->num_rows($x88) === 0 ? true : false);
   }
-  /*--------------------------------------------------------------*/
-  /* Function for cheaking which user level has access to page
-  /*--------------------------------------------------------------*/
-   function page_require_level($require_level){
-     global $session;
-     $current_user = current_user();
-     $login_level = find_by_groupLevel($current_user['user_level']);
-     //if user not login
-     if (!$session->isUserLoggedIn(true)):
-            $session->msg('d','Please login...');
-            redirect('index.php', false);
-      //if Group status Deactive
-     elseif($login_level['group_status'] === '0'):
-           $session->msg('d','This level user has been band!');
-           redirect('home.php',false);
-      //cheackin log in User level and Require level is Less than or equal to
-     elseif($current_user['user_level'] <= (int)$require_level):
+  
+  
+
+   function fn_a28($x87){
+     global $x97;
+     $x17 = fn_a5();
+     $x47 = fn_a13($x17['user_level']);
+     
+     if (!$x97->isUserLoggedIn(true)):
+            $x97->msg('d','Please login...');
+            fn_a34('index.php', false);
+      
+     elseif($x47['group_status'] === '0'):
+           $x97->msg('d','This level user has been band!');
+           fn_a34('home.php',false);
+      
+     elseif($x17['user_level'] <= (int)$x87):
               return true;
       else:
-            $session->msg("d", "Sorry! you dont have permission to view the page.");
-            redirect('home.php', false);
+            $x97->msg("d", "Sorry! you dont have permission to view the page.");
+            fn_a34('home.php', false);
         endif;
 
      }
-   /*--------------------------------------------------------------*/
-   /* Function for Finding all product name
-   /* JOIN with categorie  and media database table
-   /*--------------------------------------------------------------*/
-  function join_product_table(){
-     global $db;
-     $sql  =" SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.media_id,p.date,c.name";
-    $sql  .=" AS categorie,m.file_name AS image";
-    $sql  .=" FROM products p";
-    $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
-    $sql  .=" LEFT JOIN media m ON m.id = p.media_id";
-    $sql  .=" ORDER BY p.id ASC";
-    return find_by_sql($sql);
+   
+   
+
+
+  function fn_a24(){
+     global $x20;
+     $x98  =" SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.media_id,p.date,c.name";
+    $x98  .=" AS categorie,m.file_name AS image";
+    $x98  .=" FROM products p";
+    $x98  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
+    $x98  .=" LEFT JOIN media m ON m.id = p.media_id";
+    $x98  .=" ORDER BY p.id ASC";
+    return fn_a16($x98);
+
+   }
+  
+  
+
+
+
+  function fn_a43($x126){
+     global $x20;
+     $x126 = (int)$x126;
+     $x98  =" SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.media_id,p.date,c.name";
+    $x98  .=" AS categorie,m.file_name AS image";
+    $x98  .=" FROM products p";
+    $x98  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
+    $x98  .=" LEFT JOIN media m ON m.id = p.media_id";
+    $x98  .=" WHERE CAST(p.quantity AS SIGNED) <= '{$x126}'";
+    $x98  .=" ORDER BY CAST(p.quantity AS SIGNED) ASC, p.id ASC";
+    return fn_a16($x98);
 
    }
-  /*--------------------------------------------------------------*/
-  /* Function for Finding all product name
-  /* Request coming from ajax.php for auto suggest
-  /*--------------------------------------------------------------*/
-
-   function find_product_by_title($product_name){
-     global $db;
-     $p_name = remove_junk($db->escape($product_name));
-     $sql = "SELECT name FROM products WHERE name like '%$p_name%' LIMIT 5";
-     $result = find_by_sql($sql);
-     return $result;
+  
+  
+
+
+   function fn_a18($x71){
+     global $x20;
+     $x61 = fn_a35($x20->escape($x71));
+     $x98 = "SELECT name FROM products WHERE name like '%$x61%' LIMIT 5";
+     $x88 = fn_a16($x98);
+     return $x88;
    }
 
-  /*--------------------------------------------------------------*/
-  /* Function for Finding all product info by product title
-  /* Request coming from ajax.php
-  /*--------------------------------------------------------------*/
-  function find_all_product_info_by_title($title){
-    global $db;
-    $sql  = "SELECT * FROM products ";
-    $sql .= " WHERE name ='{$title}'";
-    $sql .=" LIMIT 1";
-    return find_by_sql($sql);
+  
+  
+
+
+  function fn_a10($x107){
+    global $x20;
+    $x98  = "SELECT * FROM products ";
+    $x98 .= " WHERE name ='{$x107}'";
+    $x98 .=" LIMIT 1";
+    return fn_a16($x98);
   }
 
-  /*--------------------------------------------------------------*/
-  /* Function for Update product quantity
-  /*--------------------------------------------------------------*/
-  function update_product_qty($qty,$p_id){
-    global $db;
-    $qty = (int) $qty;
-    $id  = (int)$p_id;
-    $sql = "UPDATE products SET quantity=quantity -'{$qty}' WHERE id = '{$id}'";
-    $result = $db->query($sql);
-    return($db->affected_rows() === 1 ? true : false);
+  
+  
+
+  function fn_a39($x77,$x60){
+    global $x20;
+    $x77 = (int) $x77;
+    $x40  = (int)$x60;
+    $x98 = "UPDATE products SET quantity=quantity -'{$x77}' WHERE id = '{$x40}'";
+    $x88 = $x20->query($x98);
+    return($x20->affected_rows() === 1 ? true : false);
 
   }
-  /*--------------------------------------------------------------*/
-  /* Function for Display Recent product Added
-  /*--------------------------------------------------------------*/
- function find_recent_product_added($limit){
-   global $db;
-   $sql   = " SELECT p.id,p.name,p.sale_price,p.media_id,c.name AS categorie,";
-   $sql  .= "m.file_name AS image FROM products p";
-   $sql  .= " LEFT JOIN categories c ON c.id = p.categorie_id";
-   $sql  .= " LEFT JOIN media m ON m.id = p.media_id";
-   $sql  .= " ORDER BY p.id DESC LIMIT ".$db->escape((int)$limit);
-   return find_by_sql($sql);
+  
+  
+
+ function fn_a19($x46){
+   global $x20;
+   $x98   = " SELECT p.id,p.name,p.sale_price,p.media_id,c.name AS categorie,";
+   $x98  .= "m.file_name AS image FROM products p";
+   $x98  .= " LEFT JOIN categories c ON c.id = p.categorie_id";
+   $x98  .= " LEFT JOIN media m ON m.id = p.media_id";
+   $x98  .= " ORDER BY p.id DESC LIMIT ".$x20->escape((int)$x46);
+   return fn_a16($x98);
  }
- /*--------------------------------------------------------------*/
- /* Function for Find Highest saleing Product
- /*--------------------------------------------------------------*/
- function find_higest_saleing_product($limit){
-   global $db;
-   $sql  = "SELECT p.name, COUNT(s.product_id) AS totalSold, SUM(s.qty) AS totalQty";
-   $sql .= " FROM sales s";
-   $sql .= " LEFT JOIN products p ON p.id = s.product_id ";
-   $sql .= " GROUP BY s.product_id";
-   $sql .= " ORDER BY SUM(s.qty) DESC LIMIT ".$db->escape((int)$limit);
-   return $db->query($sql);
+ 
+ 
+
+ function fn_a17($x46){
+   global $x20;
+   $x98  = "SELECT p.name, COUNT(s.product_id) AS totalSold, SUM(s.qty) AS totalQty";
+   $x98 .= " FROM sales s";
+   $x98 .= " LEFT JOIN products p ON p.id = s.product_id ";
+   $x98 .= " GROUP BY s.product_id";
+   $x98 .= " ORDER BY SUM(s.qty) DESC LIMIT ".$x20->escape((int)$x46);
+   return $x20->query($x98);
  }
- /*--------------------------------------------------------------*/
- /* Function for find all sales
- /*--------------------------------------------------------------*/
- function find_all_sale(){
-   global $db;
-   $sql  = "SELECT s.id,s.qty,s.price,s.date,p.name";
-   $sql .= " FROM sales s";
-   $sql .= " LEFT JOIN products p ON s.product_id = p.id";
-   $sql .= " ORDER BY s.date DESC";
-   return find_by_sql($sql);
+ 
+ 
+
+ function fn_a11(){
+   global $x20;
+   $x98  = "SELECT s.id,s.qty,s.price,s.date,p.name";
+   $x98 .= " FROM sales s";
+   $x98 .= " LEFT JOIN products p ON s.product_id = p.id";
+   $x98 .= " ORDER BY s.date DESC";
+   return fn_a16($x98);
  }
- /*--------------------------------------------------------------*/
- /* Function for Display Recent sale
- /*--------------------------------------------------------------*/
-function find_recent_sale_added($limit){
-  global $db;
-  $sql  = "SELECT s.id,s.qty,s.price,s.date,p.name";
-  $sql .= " FROM sales s";
-  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
-  $sql .= " ORDER BY s.date DESC LIMIT ".$db->escape((int)$limit);
-  return find_by_sql($sql);
+ 
+ 
+
+function fn_a20($x46){
+  global $x20;
+  $x98  = "SELECT s.id,s.qty,s.price,s.date,p.name";
+  $x98 .= " FROM sales s";
+  $x98 .= " LEFT JOIN products p ON s.product_id = p.id";
+  $x98 .= " ORDER BY s.date DESC LIMIT ".$x20->escape((int)$x46);
+  return fn_a16($x98);
 }
-/*--------------------------------------------------------------*/
-/* Function for Generate sales report by two dates
-/*--------------------------------------------------------------*/
-function find_sale_by_dates($start_date,$end_date){
-  global $db;
-  $start_date  = date("Y-m-d", strtotime($start_date));
-  $end_date    = date("Y-m-d", strtotime($end_date));
-  $sql  = "SELECT s.date, p.name,p.sale_price,p.buy_price,";
-  $sql .= "COUNT(s.product_id) AS total_records,";
-  $sql .= "SUM(s.qty) AS total_sales,";
-  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price,";
-  $sql .= "SUM(p.buy_price * s.qty) AS total_buying_price ";
-  $sql .= "FROM sales s ";
-  $sql .= "LEFT JOIN products p ON s.product_id = p.id";
-  $sql .= " WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}'";
-  $sql .= " GROUP BY DATE(s.date),p.name";
-  $sql .= " ORDER BY DATE(s.date) DESC";
-  return $db->query($sql);
+
+
+
+function fn_a21($x99,$x24){
+  global $x20;
+  $x99  = date("Y-m-d", strtotime($x99));
+  $x24    = date("Y-m-d", strtotime($x24));
+  $x98  = "SELECT s.date, p.name,p.sale_price,p.buy_price,";
+  $x98 .= "COUNT(s.product_id) AS total_records,";
+  $x98 .= "SUM(s.qty) AS total_sales,";
+  $x98 .= "SUM(p.sale_price * s.qty) AS total_saleing_price,";
+  $x98 .= "SUM(p.buy_price * s.qty) AS total_buying_price ";
+  $x98 .= "FROM sales s ";
+  $x98 .= "LEFT JOIN products p ON s.product_id = p.id";
+  $x98 .= " WHERE s.date BETWEEN '{$x99}' AND '{$x24}'";
+  $x98 .= " GROUP BY DATE(s.date),p.name";
+  $x98 .= " ORDER BY DATE(s.date) DESC";
+  return $x20->query($x98);
 }
-/*--------------------------------------------------------------*/
-/* Function for Generate Daily sales report
-/*--------------------------------------------------------------*/
-function  dailySales($year,$month){
-  global $db;
-  $sql  = "SELECT s.qty,";
-  $sql .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
-  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price";
-  $sql .= " FROM sales s";
-  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
-  $sql .= " WHERE DATE_FORMAT(s.date, '%Y-%m' ) = '{$year}-{$month}'";
-  $sql .= " GROUP BY DATE_FORMAT( s.date,  '%e' ),s.product_id";
-  return find_by_sql($sql);
+
+
+
+function  fn_a6($x125,$x52){
+  global $x20;
+  $x98  = "SELECT s.qty,";
+  $x98 .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
+  $x98 .= "SUM(p.sale_price * s.qty) AS total_saleing_price";
+  $x98 .= " FROM sales s";
+  $x98 .= " LEFT JOIN products p ON s.product_id = p.id";
+  $x98 .= " WHERE DATE_FORMAT(s.date, '%Y-%m' ) = '{$x125}-{$x52}'";
+  $x98 .= " GROUP BY DATE_FORMAT( s.date,  '%e' ),s.product_id";
+  return fn_a16($x98);
 }
-/*--------------------------------------------------------------*/
-/* Function for Generate Monthly sales report
-/*--------------------------------------------------------------*/
-function  monthlySales($year){
-  global $db;
-  $sql  = "SELECT s.qty,";
-  $sql .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
-  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price";
-  $sql .= " FROM sales s";
-  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
-  $sql .= " WHERE DATE_FORMAT(s.date, '%Y' ) = '{$year}'";
-  $sql .= " GROUP BY DATE_FORMAT( s.date,  '%c' ),s.product_id";
-  $sql .= " ORDER BY date_format(s.date, '%c' ) ASC";
-  return find_by_sql($sql);
+
+
+
+function  fn_a27($x125){
+  global $x20;
+  $x98  = "SELECT s.qty,";
+  $x98 .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
+  $x98 .= "SUM(p.sale_price * s.qty) AS total_saleing_price";
+  $x98 .= " FROM sales s";
+  $x98 .= " LEFT JOIN products p ON s.product_id = p.id";
+  $x98 .= " WHERE DATE_FORMAT(s.date, '%Y' ) = '{$x125}'";
+  $x98 .= " GROUP BY DATE_FORMAT( s.date,  '%c' ),s.product_id";
+  $x98 .= " ORDER BY date_format(s.date, '%c' ) ASC";
+  return fn_a16($x98);
 }
 
 ?>
diff --git a/layouts/admin_menu.php b/layouts/admin_menu.php
index c06c57e..271c92f 100644
--- a/layouts/admin_menu.php
+++ b/layouts/admin_menu.php
@@ -29,6 +29,7 @@
     <ul class="nav submenu">
        <li><a href="product.php">Manage products</a> </li>
        <li><a href="add_product.php">Add product</a> </li>
+       <li><a href="low_stock.php">Low stock alert</a> </li>
    </ul>
   </li>
   <li>
diff --git a/layouts/special_menu.php b/layouts/special_menu.php
index f5bdadf..d5ea1ca 100644
--- a/layouts/special_menu.php
+++ b/layouts/special_menu.php
@@ -19,6 +19,7 @@
     <ul class="nav submenu">
        <li><a href="product.php">Manage product</a> </li>
        <li><a href="add_product.php">Add product</a> </li>
+       <li><a href="low_stock.php">Low stock alert</a> </li>
    </ul>
   </li>
   <li>
```

### New files (untracked, not shown by `git diff`)

- `low_stock.php` — the low-stock alert page
- `claude.md` — updated project documentation (untracked because the committed
  `README.md` was already replaced by `claude.md` in the working tree before
  this feature was added)

---

## 2. Test results

Two independent suites were run against a real MariaDB database and a real
PHP dev server (not mocked): a function-level suite calling `fn_a43()` /
`fn_a39()` directly, and an HTTP-level suite driving the actual pages through
logged-in sessions.

**Result: 67/67 assertions passed, 0 failures.**

### 2a. Function-level suite (18 assertions)

```

PHP Warning:  session_start(): Session cannot be started after headers have already been sent (sent from C:\Users\ajitk\Downloads\ghost-repo-3-20260916T060818Z-1-001\ghost-repo-3\includes\load.php on line 1) in C:\Users\ajitk\Downloads\ghost-repo-3-20260916T060818Z-1-001\ghost-repo-3\includes\session.php on line 2

========================================================================
TEST 1 - Normal low stock (threshold 10, stock 5)
========================================================================
Test:     Product with stock 5 appears when threshold = 10
Expected: Widget A
Actual:   Widget A
Result:   PASS


========================================================================
TEST 2 - Above threshold (threshold 10, stock 15)
========================================================================
Test:     Product with stock 15 does NOT appear when threshold = 10
Expected: (none)
Actual:   (none)
Result:   PASS


========================================================================
TEST 3 - Exactly at threshold (threshold 10, stock 10) -> confirms <= not <
========================================================================
Test:     Product with stock 10 appears when threshold = 10
Expected: Widget A
Actual:   Widget A
Result:   PASS


========================================================================
TEST 4 - Multiple products (A=5, B=10, C=25, threshold 10)
========================================================================
Test:     Only A and B appear at threshold 10
Expected: Product A,Product B
Actual:   Product A,Product B
Result:   PASS

Test:     C alone is excluded (C not in result)
Expected: true
Actual:   true
Result:   PASS


========================================================================
TEST 5 - Changing threshold changes results, stock untouched
========================================================================
Test:     Stock 15, threshold 10 -> not low stock
Expected: (none)
Actual:   (none)
Result:   PASS

Test:     Same stock, threshold raised to 20 -> now low stock
Expected: Widget A
Actual:   Widget A
Result:   PASS

Test:     products.quantity unchanged by the threshold change
Expected: '15'
Actual:   '15'
Result:   PASS


========================================================================
TEST 6 - Zero stock (threshold 10, stock 0)
========================================================================
Test:     Product with stock 0 appears when threshold = 10
Expected: Widget A
Actual:   Widget A
Result:   PASS


========================================================================
TEST 7 - Negative stock
========================================================================
Test:     Product with stock -3 appears when threshold = 10
Expected: Widget A
Actual:   Widget A
Result:   PASS

Test:     Product with stock -3 appears even at threshold 0
Expected: Widget A
Actual:   Widget A
Result:   PASS


========================================================================
TEST 8 - No low-stock products
========================================================================
Test:     Threshold 4 -> no product qualifies
Expected: (none)
Actual:   (none)
Result:   PASS

Test:     Threshold 0 -> no product qualifies
Expected: (none)
Actual:   (none)
Result:   PASS


========================================================================
TEST 9 - Sale changes stock (stock 15, sell 6 -> 9, becomes low stock)
========================================================================
Test:     Before sale: threshold 10 -> not low stock
Expected: (none)
Actual:   (none)
Result:   PASS

Test:     After selling 6: products.quantity is 9
Expected: '9'
Actual:   '9'
Result:   PASS

Test:     After sale: threshold 10 -> now low stock
Expected: Widget A
Actual:   Widget A
Result:   PASS


========================================================================
TEST 13 - Read-only: querying low stock does not change quantity
========================================================================
Test:     Quantities identical after 15 low-stock queries
Expected: '5'|'25'
Actual:   '5'|'25'
Result:   PASS

Test:     Sales table still empty (no writes)
Expected: 0
Actual:   0
Result:   PASS


========================================================================
EDGE - non-numeric and NULL quantity (documenting actual behaviour)
========================================================================
Threshold 10 returns: Junk,Numeric
(documented below, not asserted as a requirement)


========================================================================
SUMMARY
========================================================================
PASS: 18
FAIL: 0
```

### 2b. HTTP-level suite (49 assertions)

```

========================================================================
TEST 4 (page) - Multiple products A=5 B=10 C=25, threshold 10
========================================================================
Test:     Page lists only A and B
Expected: Product A,Product B
Actual:   Product A,Product B
Result:   PASS

Test:     Match counter shows 2
Expected: 2
Actual:   2
Result:   PASS

Test:     Row for A shows qty and threshold
Expected: ('Product A', '5', '10', 'Low stock')
Actual:   ('Product A', '5', '10', 'Low stock')
Result:   PASS

Test:     Row for B is exactly at threshold and still listed
Expected: ('Product B', '10', '10', 'Low stock')
Actual:   ('Product B', '10', '10', 'Low stock')
Result:   PASS


========================================================================
TEST 5 (page) - Changing threshold changes results, stock untouched
========================================================================
Test:     Threshold 10 -> not low stock
Expected: (none)
Actual:   (none)
Result:   PASS

Test:     Threshold 10 -> empty message shown
Expected: No product is at or below the threshold.
Actual:   No product is at or below the threshold.
Result:   PASS

Test:     Threshold 20 -> now low stock
Expected: Widget A
Actual:   Widget A
Result:   PASS

Test:     Threshold column reflects new threshold
Expected: 20
Actual:   20
Result:   PASS

Test:     products.quantity unchanged by threshold change
Expected: 15
Actual:   15
Result:   PASS


========================================================================
TEST 6 (page) - Zero stock, and default threshold from config
========================================================================
Test:     Zero stock appears
Expected: Zero Stock
Actual:   Zero Stock
Result:   PASS

Test:     Zero stock is flagged "Out of stock"
Expected: Out of stock
Actual:   Out of stock
Result:   PASS

Test:     No threshold param -> falls back to LOW_STOCK_THRESHOLD (10)
Expected: 10
Actual:   10
Result:   PASS


========================================================================
TEST 8 (page) - No low-stock products
========================================================================
Test:     Threshold 4 -> no rows
Expected: (none)
Actual:   (none)
Result:   PASS

Test:     Threshold 4 -> match counter 0
Expected: 0
Actual:   0
Result:   PASS

Test:     Threshold 4 -> friendly empty message
Expected: No product is at or below the threshold.
Actual:   No product is at or below the threshold.
Result:   PASS

Test:     Page still renders fully (footer present)
Expected: True
Actual:   True
Result:   PASS


========================================================================
TEST 12 - Invalid threshold input
========================================================================
  [empty value] error banner: Threshold can&#039;t be blank. Showing the default threshold.
Test:     Invalid/valid input "empty value" -> falls back safely, page works
Expected: Product A,Product B
Actual:   Product A,Product B
Result:   PASS

  [non-numeric] error banner: Threshold must be a number. Showing the default threshold.
Test:     Invalid/valid input "non-numeric" -> falls back safely, page works
Expected: Product A,Product B
Actual:   Product A,Product B
Result:   PASS

  [negative] error banner: Threshold can&#039;t be negative. Showing the default threshold.
Test:     Invalid/valid input "negative" -> falls back safely, page works
Expected: Product A,Product B
Actual:   Product A,Product B
Result:   PASS

  [decimal 10.9] error banner: (no error shown)
Test:     Invalid/valid input "decimal 10.9" -> falls back safely, page works
Expected: Product A,Product B
Actual:   Product A,Product B
Result:   PASS

  [valid 25] error banner: (no error shown)
Test:     Invalid/valid input "valid 25" -> falls back safely, page works
Expected: Product A,Product B,Product C
Actual:   Product A,Product B,Product C
Result:   PASS

Test:     No SQL error leaked on non-numeric input
Expected: True
Actual:   True
Result:   PASS

Test:     SQL injection attempt is neutralised by (int) cast
Expected: True
Actual:   True
Result:   PASS


========================================================================
TEST 9 & 10 - Real sale flow through add_sale.php
========================================================================
Test:     Before sale: not low stock
Expected: (none)
Actual:   (none)
Result:   PASS

Test:     Sale row saved in sales table
Expected: 1
Actual:   1
Result:   PASS

Test:     sales row has correct product_id and qty
Expected: 1	6
Actual:   1	6
Result:   PASS

Test:     products.quantity decreased 15 -> 9
Expected: 9
Actual:   9
Result:   PASS

Test:     After sale: product now appears as low stock
Expected: Widget A
Actual:   Widget A
Result:   PASS

Test:     Status shows Low stock (not Out of stock)
Expected: Low stock
Actual:   Low stock
Result:   PASS


========================================================================
TEST 11 - Existing functionality still works
========================================================================
Test:     /product.php renders correctly
Expected: True
Actual:   True
Result:   PASS

Test:     /home.php renders correctly
Expected: True
Actual:   True
Result:   PASS

Test:     /admin.php renders correctly
Expected: True
Actual:   True
Result:   PASS

Test:     /sales.php renders correctly
Expected: True
Actual:   True
Result:   PASS

Test:     /add_sale.php renders correctly
Expected: True
Actual:   True
Result:   PASS

Test:     /add_product.php renders correctly
Expected: True
Actual:   True
Result:   PASS

Test:     /categorie.php renders correctly
Expected: True
Actual:   True
Result:   PASS

Test:     /users.php renders correctly
Expected: True
Actual:   True
Result:   PASS

Test:     /media.php renders correctly
Expected: True
Actual:   True
Result:   PASS

Test:     /daily_sales.php renders correctly
Expected: True
Actual:   True
Result:   PASS

Test:     /monthly_sales.php renders correctly
Expected: True
Actual:   True
Result:   PASS

Test:     /sales_report.php renders correctly
Expected: True
Actual:   True
Result:   PASS

Test:     product.php still lists ALL products, not just low stock
Expected: True
Actual:   True
Result:   PASS


========================================================================
TEST 13 (page) - Viewing low_stock.php does not change stock
========================================================================
Test:     Quantities unchanged after 6 page views
Expected: ('5', '25')
Actual:   ('5', '25')
Result:   PASS

Test:     No sales rows created by viewing
Expected: 0
Actual:   0
Result:   PASS


========================================================================
EXTRA - Role permissions and menu wiring
========================================================================
Test:     Admin menu contains the Low stock alert link
Expected: True
Actual:   True
Result:   PASS

Test:     Level 2 (special) can open low_stock.php
Expected: True
Actual:   True
Result:   PASS

Test:     Special menu contains the link
Expected: True
Actual:   True
Result:   PASS

Test:     Level 3 (user) is blocked, same as product.php
Expected: True
Actual:   True
Result:   PASS

Test:     Level 3 is blocked from product.php too (same rule)
Expected: True
Actual:   True
Result:   PASS


========================================================================
SUMMARY
========================================================================
PASS: 49
FAIL: 0
```
