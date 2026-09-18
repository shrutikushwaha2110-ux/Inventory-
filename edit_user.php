<?php
  $x64 = 'Edit User';
  require_once('includes/load.php');
  
   fn_a28(1);
?>
<?php
  $x23 = fn_a15('users',(int)$_GET['id']);
  $x37  = fn_a9('user_groups');
  if(!$x23){
    $x97->msg("d","Missing user id.");
    fn_a34('users.php');
  }
?>

<?php

  if(isset($_POST['update'])) {
    $x86 = array('name','username','level');
    fn_a42($x86);
    if(empty($x25)){
             $x40 = (int)$x23['id'];
           $x54 = fn_a35($x20->escape($_POST['name']));
       $x120 = fn_a35($x20->escape($_POST['username']));
          $x45 = (int)$x20->escape($_POST['level']);
       $x101   = fn_a35($x20->escape($_POST['status']));
            $x98 = "UPDATE users SET name ='{$x54}', username ='{$x120}',user_level='{$x45}',status='{$x101}' WHERE id='{$x20->escape($x40)}'";
         $x88 = $x20->query($x98);
          if($x88 && $x20->affected_rows() === 1){
            $x97->msg('s',"Acount Updated ");
            fn_a34('edit_user.php?id='.(int)$x23['id'], false);
          } else {
            $x97->msg('d',' Sorry failed to updated!');
            fn_a34('edit_user.php?id='.(int)$x23['id'], false);
          }
    } else {
      $x97->msg("d", $x25);
      fn_a34('edit_user.php?id='.(int)$x23['id'],false);
    }
  }
?>
<?php

if(isset($_POST['update-pass'])) {
  $x86 = array('password');
  fn_a42($x86);
  if(empty($x25)){
           $x40 = (int)$x23['id'];
     $x65 = fn_a35($x20->escape($_POST['password']));
     $x38   = sha1($x65);
          $x98 = "UPDATE users SET password='{$x38}' WHERE id='{$x20->escape($x40)}'";
       $x88 = $x20->query($x98);
        if($x88 && $x20->affected_rows() === 1){
          $x97->msg('s',"User password has been updated ");
          fn_a34('edit_user.php?id='.(int)$x23['id'], false);
        } else {
          $x97->msg('d',' Sorry failed to updated user password!');
          fn_a34('edit_user.php?id='.(int)$x23['id'], false);
        }
  } else {
    $x97->msg("d", $x25);
    fn_a34('edit_user.php?id='.(int)$x23['id'],false);
  }
}

?>
<?php include_once('layouts/header.php'); ?>
 <div class="row">
   <div class="col-md-12"> <?php echo fn_a8($x53); ?> </div>
  <div class="col-md-6">
     <div class="panel panel-default">
       <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          Update <?php echo fn_a35(ucwords($x23['name'])); ?> Account
        </strong>
       </div>
       <div class="panel-body">
          <form method="post" action="edit_user.php?id=<?php echo (int)$x23['id'];?>" class="clearfix">
            <div class="form-group">
                  <label for="name" class="control-label">Name</label>
                  <input type="name" class="form-control" name="name" value="<?php echo fn_a35(ucwords($x23['name'])); ?>">
            </div>
            <div class="form-group">
                  <label for="username" class="control-label">Username</label>
                  <input type="text" class="form-control" name="username" value="<?php echo fn_a35(ucwords($x23['username'])); ?>">
            </div>
            <div class="form-group">
              <label for="level">User Role</label>
                <select class="form-control" name="level">
                  <?php foreach ($x37 as $x36 ):?>
                   <option <?php if($x36['group_level'] === $x23['user_level']) echo 'selected="selected"';?> value="<?php echo $x36['group_level'];?>"><?php echo ucwords($x36['group_name']);?></option>
                <?php endforeach;?>
                </select>
            </div>
            <div class="form-group">
              <label for="status">Status</label>
                <select class="form-control" name="status">
                  <option <?php if($x23['status'] === '1') echo 'selected="selected"';?>value="1">Active</option>
                  <option <?php if($x23['status'] === '0') echo 'selected="selected"';?> value="0">Deactive</option>
                </select>
            </div>
            <div class="form-group clearfix">
                    <button type="submit" name="update" class="btn btn-info">Update</button>
            </div>
        </form>
       </div>
     </div>
  </div>
  <!-- Change password form -->
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          Change <?php echo fn_a35(ucwords($x23['name'])); ?> password
        </strong>
      </div>
      <div class="panel-body">
        <form action="edit_user.php?id=<?php echo (int)$x23['id'];?>" method="post" class="clearfix">
          <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Type user new password">
          </div>
          <div class="form-group clearfix">
                  <button type="submit" name="update-pass" class="btn btn-danger pull-right">Change</button>
          </div>
        </form>
      </div>
    </div>
  </div>

 </div>
<?php include_once('layouts/footer.php'); ?>
