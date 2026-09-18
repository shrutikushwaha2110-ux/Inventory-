<?php
  $x64 = 'Add User';
  require_once('includes/load.php');
  
  fn_a28(1);
  $x37 = fn_a9('user_groups');
?>
<?php
  if(isset($_POST['add_user'])){

   $x86 = array('full-name','username','password','level' );
   fn_a42($x86);

   if(empty($x25)){
           $x54   = fn_a35($x20->escape($_POST['full-name']));
       $x120   = fn_a35($x20->escape($_POST['username']));
       $x65   = fn_a35($x20->escape($_POST['password']));
       $x118 = (int)$x20->escape($_POST['level']);
       $x65 = sha1($x65);
        $x78 = "INSERT INTO users (";
        $x78 .="name,username,password,user_level,status";
        $x78 .=") VALUES (";
        $x78 .=" '{$x54}', '{$x120}', '{$x65}', '{$x118}','1'";
        $x78 .=")";
        if($x20->query($x78)){
          
          $x97->msg('s',"User account has been creted! ");
          fn_a34('add_user.php', false);
        } else {
          
          $x97->msg('d',' Sorry failed to create account!');
          fn_a34('add_user.php', false);
        }
   } else {
     $x97->msg("d", $x25);
      fn_a34('add_user.php',false);
   }
 }
?>
<?php include_once('layouts/header.php'); ?>
  <?php echo fn_a8($x53); ?>
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Add New User</span>
       </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-6">
          <form method="post" action="add_user.php">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="full-name" placeholder="Full Name">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name ="password"  placeholder="Password">
            </div>
            <div class="form-group">
              <label for="level">User Role</label>
                <select class="form-control" name="level">
                  <?php foreach ($x37 as $x36 ):?>
                   <option value="<?php echo $x36['group_level'];?>"><?php echo ucwords($x36['group_name']);?></option>
                <?php endforeach;?>
                </select>
            </div>
            <div class="form-group clearfix">
              <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
            </div>
        </form>
        </div>

      </div>

    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
